/**
 * Created by awt on 13/01/2017.
 */

function startMCE() {
    tinyMCE.init({
        mode: "textareas",
        plugins: "spellchecker,insertdatetime,preview",

        menubar: false,
        statusbar: false,
        theme_advanced_toolbar_align: "left"
    });
}

function $_GET(param) {
    var vars = {};
    window.location.href.replace(location.hash, '').replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function (m, key, value) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if (param) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}

/**
 * Function loads the specified page at a specified location using
 * an AJAX call
 * @param data
 * @param display
 */
function loadPage(data, display) {
    $.ajax(data)/*
     {
     url: uri,
     }*/
        .done(function (html) {
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