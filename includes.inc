<?php

//database files
require_once "models/database.php";

//templates and definitions
require_once "models/Templates.php";
require_once "models/Definitions.php";

//models
require_once "models/iModels.php";
require_once "models/model.Cartridge.php";
require_once "models/model.Printer.php";
require_once "models/model.CartridgeLog.php";
require_once "models/model.Comment.php";
require_once "models/model.Ticket.php";
require_once "models/model.User.php";

//controllers
require_once "controllers/controller.UserHandler.php";
require_once "controllers/controller.TicketHandler.php";
require_once "controllers/controller.PrinterHandler.php";

//views
require_once "views/viewTypes.php";
require_once "views/view.logCall.php";
require_once "views/view.myLogs.php";
require_once "views/view.allLogs.php";
require_once "views/view.closedLogs.php";
require_once "views/admin/view.adminAddUser.php";
require_once "views/admin/view.adminCategories.php";
require_once "views/admin/view.adminDashboard.php";
require_once "views/admin/view.adminCartridges.php";
require_once "views/admin/view.adminPrinters.php";
require_once "views/admin/view.adminReports.php";
require_once "views/admin/view.adminServiceStatus.php";
require_once "views/admin/view.administerHome.php";

