/**
 * Created by awt on 08/11/2016.
 */

//$("#logTicket").click(function () {
//    loadPage("view.php?view=logTicket");
//});
$(document).ready(function() {
    console.log("ready");

/*$(document).on('click',function (event) {*/

    var logDisp = $('.logdisplay');

    $(".menuItems").on('click',function (event) {
        if(event.target.id != 'logTicket') event.stopPropagation();

        $(".menuItems").removeClass("active");
        $(event.target.parentElement).addClass("active");

        switch (event.target.id) {
            case 'myCalls':
                link = {url: "view.php?view=my&desk=" + $_GET('desk')};
                break;
            case 'openCalls':
                link = {url: "view.php?view=open&desk=" + $_GET('desk')};
                break;
            case 'closedCalls':
                link = {url: "view.php?view=closed&desk=" + $_GET('desk')};
                break;
            case 'administerCalls':
                link = {url: "view.php?view=adminHome&desk=" + $_GET('desk')};
                break;
            default:
                link = "";
                break;
        }
        if (link != "") loadPage(link, ".logDisplay");

    });

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $(".logDisplay").on('click', ".adminClicks", function (event) {
        event.stopPropagation();
        $(".linkDisplay").removeClass("active");
        $(event.target.parentElement).addClass("active");
        switch (event.target.id) {
            case 'adminDashboard':
                link = {url: "view.php?adminPage=dashboard&desk=" + $_GET('desk')};
                break;
            case 'adminPrinters':
                link = {url: "view.php?adminPage=printers&desk=" + $_GET('desk')};
                break;
            case 'adminPrinterCosts':
                link = {url: "view.php?adminPage=printercosts&desk=" + $_GET('desk')};
                break;
            case 'adminServiceStatus':
                link = {url: "view.php?adminPage=servicestatus&desk=" + $_GET('desk')};
                break;
            case 'adminReports':
                link = {url: "view.php?adminPage=reports&desk=" + $_GET('desk')};
                break;
            case 'adminCartridges':
                link = {url: "view.php?adminPage=cartridges&desk=" + $_GET('desk')};
                break;
            case 'adminCategories':
                link = {url: "view.php?adminPage=categories&desk=" + $_GET('desk')};
                break;
            default:
                link = "url: view.php?adminPage=dashboard&desk=" + $_GET('desk');
        }

        loadPage(link, "#admin_page");


    });





    $("#addCategoryBtn").fancybox({
        afterClose: function () {
            loadPage({url: "view.php?adminPage=categories&desk=" + $_GET('desk')}, "#admin_page");
        }
    });

    $("#addUserBtn").fancybox({
        afterClose: function () {
            loadPage({url: "view.php?adminPage=dashboard&desk=" + $_GET('desk')}, "#admin_page");
        }
    });

    $('.logDisplay').on('click', ".removeCategory", function (event) {

        /*loadPage({
         type: "POST",
         url: "view.php?adminPage=adminCategories&desk="+$_GET('desk'),
         data:
         {
         method: "DELETE",
         id: $(this)[0].id
         }

         }, "#admin_page");*/
        event.stopPropagation();
        console.log($(this)[0].id)

    });

});

//});

