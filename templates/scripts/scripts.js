/**
 * Created by awt on 08/11/2016.
 */

//$("#logTicket").click(function () {
//    loadPage("view.php?view=logTicket");
//});
$(document).ready(function() {

/*$(document).on('click',function (event) {*/

    var $logDisp = $(".logDisplay");



    $(".menuItems").on("click",function (event) {
        //if(event.target.id != 'logTicket') event.stopPropagation();

        $(".menuItems").removeClass("active");
        $(event.target.parentElement).addClass("active");

        switch (event.target.id) {
            case "myCalls":
                link = {url: "view.php?view=my&desk=" + $_GET("desk")};
                break;
            case "openCalls":
                link = {url: "view.php?view=open&desk=" + $_GET("desk")};
                break;
            case "closedCalls":
                link = {url: "view.php?view=closed&desk=" + $_GET("desk")};
                break;
            case "administerCalls":
                link = {url: "view.php?view=adminHome&desk=" + $_GET("desk")};
                break;
            default:
                link = "";
        }
        if (link != "") { loadPage(link, ".logDisplay"); }

    });

    $("#checkAll").change(function () {
        $("input:checkbox").prop("checked", $(this).prop("checked"));
    });

    $logDisp.on("click", ".adminClicks", function (event) {
        //event.stopPropagation();
        $(".linkDisplay").removeClass("active");
        $(event.target.parentElement).addClass("active");
        switch (event.target.id) {
            case "adminDashboard":
                link = {url: "view.php?adminPage=dashboard&desk=" + $_GET("desk")};
                break;
            case "adminPrinters":
                link = {url: "view.php?adminPage=printers&desk=" + $_GET("desk")};
                break;
            case "adminSituatedPrinters":
                link = {url: "view.php?adminPage=situatedprinter&desk=" + $_GET("desk")};
                break; //change from dashboard
            case "adminServiceStatus":
                link = {url: "view.php?adminPage=servicestatus&desk=" + $_GET("desk")};
                break;
            case "adminReports":
                link = {url: "view.php?adminPage=reports&desk=" + $_GET("desk")};
                break;
            case "adminCartridges":
                link = {url: "view.php?adminPage=cartridges&desk=" + $_GET("desk")};
                break;
            case "adminCategories":
                link = {url: "view.php?adminPage=categories&desk=" + $_GET("desk")};
                break;
            case "adminDepartments":
                link = {url: "view.php?adminPage=departments&desk=" + $_GET("desk")};
                break;
            default:
                link = "url: view.php?adminPage=dashboard&desk=" + $_GET("desk");
        }

        loadPage(link, "#admin_page");


    });
/*
    $logDisp.on("click", "#refreshUsers",       function (event) { loadPage({url: "view.php?adminPage=dashboard&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshCategories",  function (event) { loadPage({url: "view.php?adminPage=categories&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshCartridges",  function (event) { loadPage({url: "view.php?adminPage=cartridges&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshDepartments", function (event) { loadPage({url: "view.php?adminPage=departments&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshPrinter",     function (event) { loadPage({url: "view.php?adminPage=printers&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshSituatedPrinter", function (event) { loadPage({url: "view.php?adminPage=situatedprinter&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshStatus",      function (event) { loadPage({url: "view.php?adminPage=servicestatus&desk=" + $_GET("desk")}, "#admin_page"); });
*/


    $logDisp.on("click", "#refreshUsers",       function() { refreshAdmin("dashboard", $_GET("desk"))});
    $logDisp.on("click", "#refreshCategories",  function() { refreshAdmin("categories", $_GET("desk"))});
    $logDisp.on("click", "#refreshCartridges",  function() { refreshAdmin("cartridges", $_GET("desk"))});
    $logDisp.on("click", "#refreshDepartments", function() { refreshAdmin("departments", $_GET("desk"))});
    $logDisp.on("click", "#refreshPrinter",     function() { refreshAdmin("printers", $_GET("desk"))});
    $logDisp.on("click", "#refreshSituatedPrinter", function() { refreshAdmin("situatedprinter", $_GET("desk"))});
    $logDisp.on("click", "#refreshStatus",      function() { refreshAdmin("servicestatus", $_GET("desk"))});


    $logDisp.on("click", ".removeCategory", function () {

        //event.stopPropagation();
        /*
        loadPage(
            {
             type: "POST",
             url: "view.php?adminPage=categories&desk="+$_GET('desk'),
             data:
             {
                 method: "DELETE",
                 id: $(this)[0].parentNode.parentNode.id
             }
            }, "#admin_page");*/

        console.log($(this)[0].parentNode.parentNode.id);

    });

       var keeper;

    $logDisp.on("focus", ".catName, .openState", function () {
        keeper = $(this)[0].innerHTML;
        if(keeper.length == 0)
        {
            //check to see if its a radio box
            if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio")
                keeper = $(this)[0].value;
        }
    })
        .on("blur", ".catName, .openState", function () {

        var newData;

        if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio") newData = $(this)[0].value;
        else newData = $(this)[0].innerHTML;

        //This is the data field
        var d = buildData($(this)[0], newData, "UPDATE");

        loadPage(
         {
             type: "POST",
             url: "view.php?adminPage=categories&desk="+$_GET('desk'),
             data: d
         }, "#admin_page");
    });

    $logDisp.on("focus", ".cartridgeName, .cartridgeColor, .cartridgeStock, cartridgePrinterName, .cartridgeCost", function (event) {
        keeper = $(this)[0].innerHTML;
        if(keeper.length == 0)
        {
            //check to see if its a radio box
            if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio")
                keeper = $(this)[0].value;
        }
    })
        .on("blur", ".cartridgeName, .cartridgeColor, .cartridgeStock, cartridgePrinterName, .cartridgeCost", function (event) {

        var newData;

        if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio") newData = $(this)[0].value;
        //else if($(this)[0].tagName == "OPTION")console.log($(this)[0].value)
        else newData = $(this)[0].innerHTML;

        //This is the data field
        var d = buildData($(this)[0], newData, "UPDATE");
        console.log(d);
        loadPage(
            {
                type: "POST",
                url: "view.php?adminPage=cartridges&desk="+$_GET('desk'),
                data: d
            }, "#admin_page");
    });

    $logDisp.on("focus", ".assignedTo", function () {
        keeper = $(this)[0].innerHTML;
        if(keeper.length == 0)
        {
            //check to see if its a radio box
            if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio" || $(this)[0].tagName == "OPTION")
                keeper = $(this)[0].value;
        }
    })
        .on("change", ".assignedTo", function () {

        var newData;
        var sender;

        sender = $(this)[0];

        if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio"  || $(this)[0].tagName == "SELECT")
            newData = $(this)[0].value;
        else newData = $(this)[0].innerHTML;

        if($(this)[0].tagName == "OPTION")
            sender = $(this)[0].parentNode;


        //This is the data field
        var d = buildData(sender, newData, "UPDATE");
        console.log(d);

        loadPage(
            {
                type: "POST",
                url: "view.php?view=open&desk="+$_GET('desk'),
                data: d
            }, "#admin_page");
    });

    /**
     * Creates an associative array to be sent for
     * processing by the database
     *
     * @param item The DOM object being manipulated
     * @param newData The data to be updated in the database
     * @param method The type of submission, UPDATE, DELETE etc.
     * @returns {{}} The associative array to be processed
     */
    function buildData(item, newData, method) {

        var d = {};
        var field = item.className;
        d[field] = newData;
        d.method = method;
        d.id = item.parentNode.parentNode.id;
        return d;
    }

    /**
     * Closing a ticket with reason
     */
    $logDisp.on("change", "#reason, #reasonMy", function ()
    {
        var why = prompt("Brief explanation why ticket is being closed", "");

        if(why == "" || why == null)
            return; //returns if cancel is pressed. Prevents reload etc.

        var url;
        url = ($(this)[0].id == "reason" ? "view.php?view=open&desk="+$_GET("desk") : "view.php?view=my&desk="+$_GET("desk"));

        loadPage({
            type: "POST",
            url:  url,
            data:
                {
                    method: "UPDATE",
                    closedWhy: why,
                    closedReason: $(this)[0].value,
                    id: $(this)[0].parentNode.parentNode.id
                }

        }, "#admin_page");

        console.log(why);

        refresh(($(this)[0].id == "reason" ? "open":"my"), $_GET("desk")); //complete process
    });

    $logDisp.on("change", ".priority", function (event) {
        var newData;
        var sender;

        sender = $(this)[0];

        if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio"  || $(this)[0].tagName == "SELECT")
            newData = $(this)[0].value;

        var d = buildData(sender, newData, "UPDATE");

        loadPage({
            type: "POST",
            url:  "view.php?view=open&desk="+$_GET("desk"),
            data: d

        }, "#admin_page");

        refresh("open", $_GET("desk"));
    });

    $logDisp.on("focus", ".btn-reopen", function (event) {
        console.log($(this)[0].parentNode.parentNode.id);

        loadPage({
            type: "POST",
            url:  "view.php?view=closed&desk="+$_GET("desk"),
            data:
                {
                    method: "UPDATE",
                    status: 0,
                    id: $(this)[0].parentNode.parentNode.id
                }

        }, "#admin_page");



        refresh(($(this)[0].id == "closeMy" ? "my":"closed"), $_GET("desk"));
    });

    $logDisp.on("click", ".removeUser", function () {

        //event.stopPropagation();
        /*
        loadPage(
            {
                type: "POST",
                url: "view.php?adminPage=dashboard&desk="+$_GET('desk'),
                data:
                    {
                        method: "DELETE",
                        id: $(this)[0].parentNode.parentNode.id
                    }
            }, "#admin_page");*/

        console.log($(this)[0].parentNode.parentNode.id);

    });

});