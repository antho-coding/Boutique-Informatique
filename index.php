<?php
session_start();

require "config/database.php";
require "controllers/HomeControllers.php";
require "controllers/UserController.php";
require "controllers/PrestationController.php";
require "controllers/AdminControllers.php";
require "controllers/ContactControllers.php";
require "controllers/ShopControllers.php";
require "controllers/OrderControllers.php";

$homeControllers = new HomeControllers;
$userController = new UserController;
$prestationController = new PrestationController;
$adminController = new AdminController;
$contactController = new ContactControllers;
$shopController = new ShopControllers;
$orderController = new OrderController;

// var_dump($_SESSION);
// var_dump($_GET);

if (array_key_exists("action", $_GET)) {

    switch ($_GET["action"]) {

        case "home":
            $homeControllers->staticPage();
            break;

            //manage account User
        case "createAccount":
            $userController->createAccount();
            break;

        case "deconnectAccount":
            $userController->deconnectSession();
            break;

        case "connectAccount":
            $userController->connectUser();
            break;

        case "forgotPassword":
            $userController->forgotPasswordUser();
            break;

            //User area
        case "userArea":
            $orderController->displayLastOrder();
            break;

        case "detailslastOrder":
            $orderController->displayDetailLastOrder();
            break;

        case "choiceOrderUser":
            $orderController->displayDetailLastOrder();
            break;

        case "displayInformationUser":
            $userController->displayInformationUser();
            break;

        case "updateDataUser":
            $userController->updateDataUser();
            break;

        case "generateInvoice":
            $userController->generateInvoiceUser();
            break;

            //Display prestation for user
        case "displayPrestation":
            $prestationController->displayPrestation();
            break;

            //Submit form in BDD
        case "contact":
            $contactController->submitContactForm();
            break;

            // Display product shop for user
        case "shop":
            $shopController->displayAllProductShop();
            break;

        case "showCaddie":
            $shopController->displayProductBasket();
            break;

            //Display Prestation for admin
        case "manageRepair":
            $prestationController->allManagmentRepair();
            break;

            //Display shop for admin
        case "manageShop":
            $shopController->allManagmentShop();
            break;

        case "searchShopAdmin":
            $shopController->allManagmentShop();
            break;

            //Display slide for admin
        case "manageSlider":
            $homeControllers->displaySlide();
            break;

            //Display contact form for admin
        case "manageForm":
            $contactController->allManagementContactForm();
            break;

            //Manage prestation for admin
        case "insertPrestaComputer":
            $prestationController->insertPrestaComputerAdmin();
            break;

        case "updatePrestaComputer":
            $prestationController->updatePrestaComputerAdmin();
            break;

        case "insertPrestaPeripheral":
            $prestationController->insertPrestaPeripheralAdmin();
            break;

        case "updatePrestaPeripheral":
            $prestationController->updatePrestaPeripheralAdmin();
            break;

        case "insertPrestaInternet":
            $prestationController->insertPrestaInternetAdmin();
            break;

        case "updatePrestaInternet":
            $prestationController->updatePrestaInternetAdmin();
            break;

        case "insertPrestaRemote":
            $prestationController->insertPrestaRemoteAdmin();
            break;

        case "updatePrestaRemote":
            $prestationController->updatePrestaRemoteAdmin();
            break;

            // Delete Prestation for admin
        case "deleteRepair":
            $prestationController->updatePrestaComputerAdmin();
            break;

        case "deletePeripheral":
            $prestationController->updatePrestaPeripheralAdmin();
            break;

        case "deleteInternet":
            $prestationController->updatePrestaInternetAdmin();
            break;

        case "deleteRemote":
            $prestationController->updatePrestaRemoteAdmin();
            break;

            //Manage shop for admin
        case "insertProductShop":
            $shopController->insertProductShop();
            break;

        case "updateProductShop":
            $shopController->updateProductShop();
            break;

        case "deleteProductShop":
            $shopController->updateProductShop();
            break;

            //Manage contact form for admin
        case "deleteForm":
            $contactController->deleteForm();
            break;

        case "seeForm":
            $contactController->seeDetailsForm();
            break;

        case "createPdf":
            $contactController->generatePdfDetailsForm();
            break;

            //login and deconnect Admin
        case "loginAdmin":
            $adminController->Admin();
            break;

        case "deconnectAccountAdmin":
            $adminController->deconnectSessionAdmin();
            break;
    }
} else {
    $homeControllers->staticPage();
}
