/**
 * Created by awt on 11/04/2017.
 */

function startMCE() {
    tinyMCE.editors = [];
    $("div.mce-panel").remove();
    $("textarea").attr('style', "");
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

function expandticket(logID) {
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

            this.expandTicket = function (logID) {
                isVisible = $('#td' + logID).is(":visible");
                this.contractTicket(logID);

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
            };

            this.contractTicket = function () {
                $('tr').css("backgroundColor", "transparent").css("color", "black");
                $("tr.contentRow").toggle(false);
            };

            this.deleteData = function (data) {

            };

            this.updateData = function(page, data) {
                /*var urlFormat = "view.php?view="+page+"&desk="+$_GET("desk");
                $.ajax({
                    type: "POST",
                    url: urlFormat,
                    data: {
                        method: "UPDATE",
                        id: data.parentNode.parentNode.id,
                        status: 0
                    }

                }).done(function (html) {
                    $('#logDisplay').html(html);
                });*/
            };

            this.addTicket = function (data) {

            };

            this.addComment = function (sender) {
                var urlFormat = "view.php?view=comments&desk="+$_GET("desk");
                var buildId = "#comments"+sender.parentNode.className;
                var commentBox = "commentBox" + sender.parentNode.className;

                tinyMCE.triggerSave();
                var id = sender.parentNode.className;
                var data = document.getElementById(commentBox).value;

                if(data == "") return alert("Please enter a comment before submitting.");
                $.ajax({
                    type: "POST",
                    url: urlFormat,
                    data:
                    {
                        method: "ADD",
                        id: id,
                        info: data
                    }
                }).done(function (html) {
                    $(buildId).html(html);
                });
            };

            this.reopen = function (sender) {
                var id = sender.parentNode.parentNode.id;
                var urlFormat = "view.php?view=closed&desk="+$_GET("desk");

                $.ajax({
                    type: "POST",
                    url: urlFormat,
                    data:
                    {
                        method: "UPDATE",
                        id: id,
                        status: 0
                    }
                }).done(function (html) {
                    var page = (sender.id == "closeMy" ? "my" : "closed");
                    var newUrl = "view.php?view="+page+"&desk="+$_GET("desk");
                    app.ticketHandler.refresh(newUrl, "#logDisplay");
                });
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
                    $(area).html(html);

                });
            }
        }

        function PrinterHandler() {

            this.deleteData = function (data) {

            };

            this.updateData = function(page, data) {

            };

            this.addData = function (data) {

            };

            this.refresh = function (data) {
                alert(data);
            }
        }

        function SystemHandler() {
            this.updateData = function(page,data)
            {
                $.ajax({
                    type: "POST",
                    url: page,
                    data: data
                }).done(function(response){
                    //response
                });
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
        this.systemHandler = new SystemHandler();

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

                //console.log(event.target.tagName);

                /**
                 * Check to see if item clicked allows row expansion
                 */
                if(event.target.tagName != "INPUT"
                    && event.target.tagName != "SELECT"
                    && event.target.tagName != "OPTION"
                    && event.target.parentNode.tagName == "TR"
                    && event.target.parentNode.classList.contains("expandable"))
                {
                    app.ticketHandler.expandTicket(event.target.parentNode.id);
                }



                if (event.target.classList.contains('btn-reopen'))
                {
                    //alert("test");
                    //area = "#logDisplay";
                    //url = "view.php?view=closed&desk=" + $_GET("desk");
                }

                app.ticketHandler.refresh(url, area);
                app.special($("#logDisplay")); //update dom
            }
            //console.log(event.target.classList.contains('adminClicks'));

        }, false);

        addEventListener("change", function (event) {
            if (typeof event.target.classList !== 'undefined') {
                var classCheck = [
                    "closedReason",
                    "priority",
                    "assignedTo",
                    "catName",
                    "openState",
                ];

                $.each(classCheck, function (index, value) {
                    if(event.target.classList.contains(value))
                    {
                        app.special($("#logDisplay"));
                        event.target.blur();
                    }
                });
                //console.log(event.target.classList);

            }
        }, false);

        //console.log($(".logDisplay"));



        addEventListener("keypress", function (event) {
            var check = [
                "cartridgeName",
                "cartridgeColor",
                "cartridgeStock",
                "cartridgePrinterName",
                "cartridgeCost",
                "printerMake",
                "printerModel"
            ];

            $.each(check, function (index, value) {
                if(event.keyCode == 13) {
                    event.preventDefault();
                    event.target.blur();
                    app.special($("#logDisplay"));
                }
            });

        }, false);
    },

    special: function (logDisplay) {
        logDisplay.off(); //detach all events
        logDisplay.on('focusout', this.focusCall);

        //handles updating data
        this.focusCall = function (event) {
            var url;
            var data = {};

            var idCheck = [
                "reason",
                "reasonMy"
            ];

            //auth user fields
            var authUserCheck = [
                "authUsername",
                "authUserEmail",
                "authUserColor"
            ];

            //category fields
            var categoryCheck = [
                "catName",
                "openState"
            ];

            //department fields
            var departmentCheck = [
                "department"
            ];

            //cartridge fields
            var cartridgeCheck = [
                "cartridgeName",
                "cartridgeColor",
                "cartridgeStock",
                "cartridgePrinterName",
                "cartridgeCost"
            ];

            //printer fields
            var printerCheck = [
                "printerMake",
                "printerModel"
            ];

            //status Fields
            var statusCheck = [
                "statusName",
                "statusStatus"
            ];

            //situated printer fields
            var situatedPrinterCheck = [
                "situatedLocation",
                "situatedCostDept",
                "situatedExemption"
            ];

            var openLogsCheck = [
                "assignedTo",
                "priority"
            ];

            $.each(openLogsCheck, function (index, value) {
                if(event.target.classList.contains(value)) {
                    url = "view.php?view=open&desk=" + $_GET("desk");
                    updateData(value);
                    app.ticketHandler.refresh(url, "#logDisplay");
                }
            });

            $.each(idCheck, function (index, value) {
                if(event.target.id == value)
                {
                    url = (event.target.id == "reason" ? "view.php?view=open&desk="+$_GET("desk") : "view.php?view=my&desk="+$_GET("desk"));
                    var why = prompt("Brief explanation why ticket is being closed", "");
                    if(why == "" || why == null)
                        return;
                    updateData(why, "closedWhy");
                    updateData("closedReason");
                    app.ticketHandler.refresh(url, "#logDisplay");
                }
            });

            //check cartridge fields
            $.each(cartridgeCheck, function (index, value) {
                if (event.target.classList.contains(value)) {
                    url = "view.php?adminPage=cartridges&desk=" + $_GET('desk');
                    updateData(value);
                }

            });

            //check category fields
            $.each(categoryCheck, function (index, value) {
                if (event.target.classList.contains(value)) {
                    url = "view.php?adminPage=categories&desk=" + $_GET('desk');
                    updateData(value);
                }

            });

            //check printer fields
            $.each(printerCheck, function (index, value) {
                if (event.target.classList.contains(value)) {
                    url = "view.php?adminPage=printers&desk=" + $_GET('desk');
                    updateData(value);
                }
            });

            //check situated printer fields
            $.each(authUserCheck, function (index, value) {
                if (event.target.classList.contains(value)) {
                    url = "view.php?adminPage=dashboard&desk=" + $_GET('desk');
                    updateData(value);
                }
            });

            //check auth user fields
            $.each(situatedPrinterCheck, function (index, value) {
                if (event.target.classList.contains(value)) {
                    url = "view.php?adminPage=situatedprinter&desk=" + $_GET('desk');
                    updateData(value);
                }
            });

            //check status fields
            $.each(statusCheck, function (index, value) {
                if (event.target.classList.contains(value)) {
                    url = "view.php?adminPage=servicestatus&desk=" + $_GET('desk');
                    updateData(value);
                }
            });

            //check department fields
            $.each(departmentCheck, function (index, value) {
                if (event.target.classList.contains(value)) {
                    url = "view.php?adminPage=departments&desk=" + $_GET('desk');
                    updateData(value);
                }
            });

            function updateData (value, cname) {

                data.method = "UPDATE";

                //Extra
                if(typeof cname !== 'undefined')
                {
                    data[cname] = value;
                    data.id = event.target.parentNode.parentNode.id;
                }
                else{

                    if (event.target.classList.contains(value)) {

                        data.id = event.target.parentNode.parentNode.id;

                        if ($(event.target).is(":checkbox")) data[event.target.className] = event.target.checked;
                        else if (typeof event.target.value !== 'undefined') data[event.target.className] = event.target.value;
                        else data[event.target.className] = event.target.innerHTML;
                    }

                    console.log(data);
                }

                //update data
                if (typeof url !== 'undefined') {
                    app.systemHandler.updateData(url, data);
                }
            }
            event.stopPropagation();

        }
    }

};

app.initialize();
