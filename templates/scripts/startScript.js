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