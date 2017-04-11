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
    $.ajax(data)
        .done(function (html)
        {
            $(display).html(html);

        });
}

function expandticket(logID, $elem) {
    isVisible = $('#td' + logID).is(":visible");

    contracttickets(logID);

    if (!isVisible) {

        $('#'+logID).css("backgroundColor", "#0a2751").css("color", "white");
        $('select').css("color", "black");

        $('#td' + logID).toggle(true);
        startMCE();

    }
    else {
        $('#'+logID).css("backgroundColor", "transparent").css("color", "black");
        $('#td' + logID).toggle(false);
    }
}

function refreshAdmin(page, desk)
{
    loadPage({url: "view.php?adminPage="+page+"&desk="+desk}, "#admin_page");
}

function refresh(page,desk)
{
    loadPage({url: "view.php?view="+page+"&desk="+desk}, ".logDisplay");
}

function contracttickets(logID) {
    $('tr').css("backgroundColor", "transparent").css("color", "black");
    $("tr.contentRow").toggle(false);
}