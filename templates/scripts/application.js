/**
 * Created by awt on 11/04/2017.
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

function contracttickets(logID) {
    $('tr').css("backgroundColor", "transparent").css("color", "black");
    $("tr.contentRow").toggle(false);
}



var app = {

    initialize: function () {
        $(".fancybox").fancybox();
        var url = "view.php?view=my&desk=" + $_GET("desk"); // initial page


        this.startApp();
        this.startEventListeners();
    },

    // Update DOM on a Received Event
    startApp: function () {

        function TicketHandler() {

            this.expandTicket = function () {

            };

            this.contractTicket = function () {

            };

            this.deleteData = function (data) {

            };

            this.updateData = function(data) {

            };

            this.addData = function (data) {

            };

            this.refresh = function (page, area) {
                $.ajax({
                    url: page,
                    statusCode: {
                        404: function () {
                            alert('page not found');
                        },
                        500: function () {
                            alert('server error');
                        }
                    }
                }).done(function (html) {
                    $(area).html(html)
                });
            }
        }

        function PrinterHandler() {

            this.deleteData = function (data) {

            };

            this.updateData = function(data) {

            };

            this.addData = function (data) {

            };

            this.refresh = function (data) {
                alert(data);
            }
        }

        function UserHandler() {

            this.deleteData = function (data) {

            };

            this.updateData = function(data) {

            };

            this.addData = function (data) {

            };

            this.refresh = function () {
                alert('test');
            }
        }

        this.ticketHandler = new TicketHandler();
        this.printerHandler = new PrinterHandler();
        this.userHandler = new UserHandler();

        /**
         * Setup initial page
         * @type {string}
         */
        var url = "view.php?view=my&desk=" + $_GET("desk"),area="#logDisplay";
        this.ticketHandler.refresh(url, area);

    },

    startEventListeners: function () {
        /**
         * Setup event listeners
         */
        addEventListener("click", function (event) {
            var url,area;
            if (typeof event.target.parentNode.classList !== 'undefined') {

                if (event.target.parentNode.classList.contains('menuItems')) {
                    //check id

                    $(".menuItems").removeClass("active");
                    $(event.target.parentElement).addClass("active");

                    area = "#logDisplay";

                    switch (event.target.id) {
                        case "openCalls": url = "view.php?view=open&desk=" + $_GET("desk"); break;
                        case "closedCalls": url = "view.php?view=closed&desk=" + $_GET("desk"); break;
                        case "administerCalls": url = "view.php?view=adminHome&desk=" + $_GET("desk"); break;
                        case "myCalls":
                        default: url = "view.php?view=my&desk=" + $_GET("desk");

                    }

                }

                if (event.target.classList.contains('adminClicks')) {
                    //check id

                    $(".linkDisplay").removeClass("active");
                    $(event.target.parentElement).addClass("active");

                    area = '#admin_page';

                    switch (event.target.id)
                    {
                        case "adminPrinters": url = "view.php?adminPage=printers&desk=" + $_GET("desk"); break;
                        case "adminSituatedPrinters": url = "view.php?adminPage=situatedprinter&desk=" + $_GET("desk"); break;
                        case "adminServiceStatus": url = "view.php?adminPage=servicestatus&desk=" + $_GET("desk"); break;
                        case "adminReports": url = "view.php?adminPage=reports&desk=" + $_GET("desk"); break;
                        case "adminCartridges": url = "view.php?adminPage=cartridges&desk=" + $_GET("desk"); break;
                        case "adminCategories": url = "view.php?adminPage=categories&desk=" + $_GET("desk"); break;
                        case "adminDepartments": url = "view.php?adminPage=departments&desk=" + $_GET("desk"); break;
                        case "adminDashboard":
                        default: url = "view.php?adminPage=dashboard&desk=" + $_GET("desk"); break;

                    }

                }

                app.ticketHandler.refresh(url, area);
            }
            console.log(event.target.classList.contains('adminClicks'));

        }, false);

        addEventListener("change", function (event) {

        }, false);

        addEventListener("focus", function (event) {

        }, false);
    }

};

app.initialize();
