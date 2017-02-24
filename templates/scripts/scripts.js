/**
 * Created by awt on 08/11/2016.
 */

//$("#logTicket").click(function () {
//    loadPage("view.php?view=logTicket");
//});
$(document).ready(function() {
    console.log("ready");

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
    $logDisp.getElementById("#addCategoryBtn").fancybox({
        afterClose: function () {
            loadPage({url: "view.php?adminPage=categories&desk=" + $_GET('desk')}, "#admin_page");

        }
    });

    $("#addUserBtn").fancybox({

        onCancel: function () {
            loadPage({url: "view.php?adminPage=dashboard&desk=" + $_GET('desk')}, "#admin_page");
        }
    });*/
/*
    $logDisp.on('click', "#addUserBtn", function (event) {
        $('.fancybox').fancybox();
        $('.fancybox').open([{
                'href': 'view.php?adminPage=addUser&desk=1',
                'type': 'iframe'
            }],
            {
                afterClose: function () {
                    loadPage({url: "view.php?adminPage=dashboard&desk=" + $_GET('desk')}, "#admin_page");
                }
            }
        );

    });*/

    /*
    switch(cat)
    {
        case "#refreshUsers": url= "dashboard"; break;
    }
    */
    $logDisp.on("click", "#refreshUsers",       function (event) { loadPage({url: "view.php?adminPage=dashboard&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshCategories",  function (event) { loadPage({url: "view.php?adminPage=categories&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshCartridges",  function (event) { loadPage({url: "view.php?adminPage=cartridges&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshDepartments", function (event) { loadPage({url: "view.php?adminPage=departments&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshPrinter",     function (event) { loadPage({url: "view.php?adminPage=printers&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshSituatedPrinter", function (event) { loadPage({url: "view.php?adminPage=situatedprinter&desk=" + $_GET("desk")}, "#admin_page"); });
    $logDisp.on("click", "#refreshStatus",      function (event) { loadPage({url: "view.php?adminPage=servicestatus&desk=" + $_GET("desk")}, "#admin_page"); });


    $logDisp.on("click", ".removeCategory", function (event) {

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

    $logDisp.on("focus", ".catName, .openState", function (event) {
        keeper = $(this)[0].innerHTML;
        if(keeper.length == 0)
        {
            //check to see if its a radio box
            if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio")
                keeper = $(this)[0].value;
        }
    }).on("blur", ".catName, .openState", function (event) {

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
    }).on("blur", ".cartridgeName, .cartridgeColor, .cartridgeStock, cartridgePrinterName, .cartridgeCost", function (event) {

        var newData;

        if($(this)[0].tagName == "INPUT" && $(this)[0].type == "radio") newData = $(this)[0].value;
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

    function buildData(item, newData, method) {

        var d = {};
        var field = item.className;
        d[field] = newData;
        d.method = method;
        d.id = item.parentNode.parentNode.id;
        return d;
    }


    $logDisp.on("click", ".removeUser", function (event) {

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