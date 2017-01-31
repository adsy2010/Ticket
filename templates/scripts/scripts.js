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

function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}

/**
 * Function loads the specified page at a specified location using
 * an AJAX call
 * @param data
 * @param location
 */
function loadPage(data, display){
    $.ajax(data)/*
        {
            url: uri,
        }*/
        .done(function(html) {
            $(display).html(html);
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
        case 'adminDashboard':      link = {url: "view.php?adminPage=dashboard&desk="+$_GET('desk')}; break;
        case 'adminPrinters':       link = {url: "view.php?adminPage=printers&desk="+$_GET('desk')}; break;
        case 'adminPrinterCosts':   link = {url: "view.php?adminPage=printercosts&desk="+$_GET('desk')}; break;
        case 'adminServiceStatus':  link = {url: "view.php?adminPage=servicestatus&desk="+$_GET('desk')}; break;
        case 'adminReports':        link = {url: "view.php?adminPage=reports&desk="+$_GET('desk')}; break;
        case 'adminCartridges':     link = {url: "view.php?adminPage=cartridges&desk="+$_GET('desk')}; break;
        case 'adminCategories':     link = {url: "view.php?adminPage=categories&desk="+$_GET('desk')}; break;
        default: link = "url: view.php?adminPage=dashboard&desk="+$_GET('desk');
    }

    loadPage(link, "#admin_page");
});

$(".menuItems").click(function(event) {
    $(".menuItems").removeClass("active");
    $(event.target.parentElement).addClass("active");
    switch (event.target.id)
    {
        case 'myCalls':         link = {url: "view.php?view=my&desk="+$_GET('desk')}; break;
        case 'openCalls':       link = {url: "view.php?view=open&desk="+$_GET('desk')}; break;
        case 'closedCalls':     link = {url: "view.php?view=closed&desk="+$_GET('desk')}; break;
        case 'administerCalls': link = {url: "view.php?view=adminHome&desk="+$_GET('desk')}; break;
        default: link = ""; break;
    }
    if(link != "") loadPage(link, ".logDisplay");
});

$("#addCategoryBtn").fancybox({
    afterClose: function () {
        loadPage({url: "view.php?adminPage=categories&desk="+$_GET('desk')}, "#admin_page");
    }
});

$("#addUserBtn").fancybox({
    afterClose: function () {
        loadPage({url: "view.php?adminPage=dashboard&desk="+$_GET('desk')}, "#admin_page");
    }
});

$(".removeCategory").click(function (event) {
    loadPage({
        type: "POST",
        url: "view.php?adminPage=adminCategories&desk="+$_GET('desk'),
        data:
            {
                method: "DELETE",
                id: event.target.id
            }

    }, "#admin_page");
});
