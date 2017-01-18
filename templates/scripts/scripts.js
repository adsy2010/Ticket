/**
 * Created by awt on 08/11/2016.
 */

//$("#logTicket").click(function () {
//    loadPage("view.php?view=logTicket");
//});

$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

$("#myCalls").click(function(){
    loadPage("view.php?view=my");
});

$("#openCalls").click(function(){
    loadPage("view.php?view=open");
});

$("#closedCalls").click(function(){
    loadPage("view.php?view=closed");
});


$("#administerCalls").click(function(){
    loadPage("view.php?view=adminHome");
});

function loadPage(data){
    $.ajax(
        {
            url: data
        })
        .done(function(html) {
            $(".logDisplay").html(html);
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