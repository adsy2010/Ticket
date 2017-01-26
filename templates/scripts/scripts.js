/**
 * Created by awt on 08/11/2016.
 */

//$("#logTicket").click(function () {
//    loadPage("view.php?view=logTicket");
//});

$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
/*
$("#myCalls").click(function(){
    loadPage("view.php?view=my", ".logDisplay");
});

$("#openCalls").click(function(){
    loadPage("view.php?view=open", ".logDisplay");
});

$("#closedCalls").click(function(){
    loadPage("view.php?view=closed", ".logDisplay");
});


$("#administerCalls").click(function(){
    loadPage("view.php?view=adminHome", ".logDisplay");
});*/


/**
 * Function loads the specified page at a specified location using
 * an AJAX call
 * @param data
 * @param location
 */
function loadPage(data, location){
    $.ajax(
        {
            url: data
        })
        .done(function(html) {
            $(location).html(html);
            //$.getScript( "templates/scripts/scripts.js" );
        });
}

function expandticket(logID, $elem) {
    isVisible = $('#td' + logID).is(":visible");

    contracttickets(logID);
    
    if (!isVisible) {

        $('#td' + logID).toggle(true);
        startMCE();

    }
    else {
            $('#td' + logID).toggle(false);
    }
}

function contracttickets(logID) {
    $("tr.contentRow").toggle(false);
}

$(".adminClicks").click(function(event) {

    $(".linkDisplay").removeClass("active");
    $(event.target.parentElement).addClass("active");
    switch (event.target.id)
    {
        case 'adminDashboard':      link = "view.php?adminPage=dashboard"; break;
        case 'adminPrinters':       link = "view.php?adminPage=printers"; break;
        case 'adminPrinterCosts':   link = "view.php?adminPage=printercosts"; break;
        case 'adminServiceStatus':  link = "view.php?adminPage=servicestatus"; break;
        case 'adminReports':        link = "view.php?adminPage=reports"; break;
        case 'adminCartridges':     link = "view.php?adminPage=cartridges"; break;
        default: link = "view.php?adminPage=dashboard";
    }

    loadPage(link, "#admin_page");
});

$(".menuItems").click(function(event) {
    $(".menuItems").removeClass("active");
    $(event.target.parentElement).addClass("active");
    switch (event.target.id)
    {
        case 'myCalls':         link = "view.php?view=my"; break;
        case 'openCalls':       link = "view.php?view=open"; break;
        case 'closedCalls':     link= "view.php?view=closed"; break;
        case 'administerCalls': link = "view.php?view=adminHome"; break;
        default: link = ""; break;
    }
    if(link != "") loadPage(link, ".logDisplay");
});
