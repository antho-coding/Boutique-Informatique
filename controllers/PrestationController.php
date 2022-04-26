<?php

require "models/Prestation.php";

class PrestationController
{

    private $prestation;
    private $admin;

    public function __construct()
    {
        $this->prestation = new Prestation;
        $this->admin = new AdminController;
    }

    //Display all prestation for user
    public function displayPrestation()
    {
        $prestationsComputer = $this->prestation->getPrestationRepairComputer();
        $prestationsPeripheral = $this->prestation->getPrestationRepairPeripheral();
        $prestationsInternet = $this->prestation->getPrestationRepairInternet();
        $prestationsRemote = $this->prestation->getPrestationRepairRemote();

        $title = "Prestations";
        $template = "www/prestation/prestation";
        require "www/layaout.phtml";
    }

    //Display all prestation for admin
    public function allManagmentRepair()
    {
        if ($this->admin->verifySessionAdmin()) {

            $prestationsComputer = $this->prestation->getPrestationRepairComputer();
            $prestationsPeripheral = $this->prestation->getPrestationRepairPeripheral();
            $prestationsInternet = $this->prestation->getPrestationRepairInternet();
            $prestationsRemote = $this->prestation->getPrestationRepairRemote();

            $title = "Gestion des prestations";
            $template = "www/admin/manageRepair/managmentRepair";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    public function updatePrestaComputerAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("idPresta", $_GET)) {

                $id = $_GET["idPresta"];

                $recoveryPresta = $this->prestation->getPrestationComputerById($id);
            }

            if (array_key_exists("delId", $_GET)) {

                $deleteComputerPresta = $this->prestation->deletePrestationRepairComputer($_GET["delId"]);

                if ($deleteComputerPresta) {

                    header("location:index.php?action=manageRepair");
                }
            }

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"]) &&
                isset($_POST["id"]) && !empty($_POST["id"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);
                $id = htmlspecialchars($_POST["id"]);

                $updatePresta = $this->prestation->updatePrestationComputer($category, $description, $price, $id);

                if ($updatePresta) {
                    header("location:index.php?action=manageRepair");
                } else {

                    $error = "Une erreur est survenu";
                }
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/updatePrestation";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    public function insertPrestaComputerAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);

                $addPresta = $this->prestation->addPrestationComputer($category, $description, $price);

                if ($addPresta) {

                    $error = "Votre préstation a bien été crée";
                } else {

                    $error = "Une erreur est survenu, merci de reassayer dans quelques instants";
                }
            } elseif (
                isset($_POST["categorie"]) && empty($_POST["categorie"]) ||
                isset($_POST["prix"]) && empty($_POST["prix"]) ||
                isset($_POST["description"]) && empty($_POST["description"])
            ) {

                $error = "Merci de completer tous les champs du formulaire";
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/addPrestation";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    //**************************************** Method for Prestation Peripheral ***************************************//

    public function insertPrestaPeripheralAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);

                $addPresta = $this->prestation->addPrestationPeripheral($category, $description, $price);

                if ($addPresta) {

                    $error = "Votre préstation a bien été crée";
                } else {

                    $error = "Une erreur est survenu, merci de reassayer dans quelques instants";
                }
            } elseif (
                isset($_POST["categorie"]) && empty($_POST["categorie"]) ||
                isset($_POST["prix"]) && empty($_POST["prix"]) ||
                isset($_POST["description"]) && empty($_POST["description"])
            ) {

                $error = "Merci de completer tous les champs du formulaire";
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/addPrestaPerip";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    public function updatePrestaPeripheralAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("idPresta", $_GET)) {

                $id = $_GET["idPresta"];

                $recoveryPresta = $this->prestation->getPrestationPeripheralById($id);
            }

            if (array_key_exists("delId", $_GET)) {
                $deleteComputerPresta = $this->prestation->deletePrestationRepairPeripheral($_GET["delId"]);

                if ($deleteComputerPresta) {
                    header("location:index.php?action=manageRepair");
                }
            }

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"]) &&
                isset($_POST["id"]) && !empty($_POST["id"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);
                $id = htmlspecialchars($_POST["id"]);

                $updatePresta = $this->prestation->updatePrestationPeripheral($category, $description, $price, $id);

                if ($updatePresta) {

                    header("location:index.php?action=manageRepair");
                } else {

                    $error = "Une erreur est survenu";
                }
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/updatePrestaPerip";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    //**************************************** Method for Prestation Internet ***************************************//

    public function insertPrestaInternetAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);

                $addPresta = $this->prestation->addPrestationBox($category, $description, $price);

                if ($addPresta) {

                    $error = "Votre préstation a bien été crée";
                } else {

                    $error = "Une erreur est survenu, merci de reassayer dans quelques instants";
                }
            } elseif (isset($_POST["categorie"]) && empty($_POST["categorie"]) || isset($_POST["prix"]) && empty($_POST["prix"]) || isset($_POST["description"]) && empty($_POST["description"])) {

                $error = "Merci de completer tous les champs du formulaire";
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/addPrestaInternet";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    public function updatePrestaInternetAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("idPresta", $_GET)) {

                $id = $_GET["idPresta"];

                $recoveryPresta = $this->prestation->getPrestationInternetById($id);
            }

            if (array_key_exists("delId", $_GET)) {
                $deleteComputerPresta = $this->prestation->deletePrestationRepairInternet($_GET["delId"]);

                if ($deleteComputerPresta) {
                    header("location:index.php?action=manageRepair");
                }
            }

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"]) &&
                isset($_POST["id"]) && !empty($_POST["id"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);
                $id = htmlspecialchars($_POST["id"]);

                $updatePresta = $this->prestation->updatePrestationInternet($category, $description, $price, $id);

                if ($updatePresta) {

                    header("location:index.php?action=manageRepair");
                } else {

                    $error = "Une erreur est survenu";
                }
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/updatePrestaInternet";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    //**************************************** Method for Prestation remote ***************************************//

    public function insertPrestaRemoteAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);

                $addPresta = $this->prestation->addPrestationRemote($category, $description, $price);

                if ($addPresta) {

                    $error = "Votre préstation a bien été crée";
                } else {

                    $error = "Une erreur est survenu, merci de reassayer dans quelques instants";
                }
            } elseif (isset($_POST["categorie"]) && empty($_POST["categorie"]) || isset($_POST["prix"]) && empty($_POST["prix"]) || isset($_POST["description"]) && empty($_POST["description"])) {

                $error = "Merci de completer tous les champs du formulaire";
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/addPrestaRemote";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    public function updatePrestaRemoteAdmin()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("idPresta", $_GET)) {

                $id = $_GET["idPresta"];

                $recoveryPresta = $this->prestation->getPrestationRemoteById($id);
            }

            if (array_key_exists("delId", $_GET)) {
                $deleteComputerPresta = $this->prestation->deletePrestationRemote($_GET["delId"]);

                if ($deleteComputerPresta) {
                    header("location:index.php?action=manageRepair");
                }
            }

            if (
                isset($_POST["categorie"]) && !empty($_POST["categorie"]) &&
                isset($_POST["prix"]) && !empty($_POST["prix"]) &&
                isset($_POST["description"]) && !empty($_POST["description"]) &&
                isset($_POST["id"]) && !empty($_POST["id"])
            ) {
                $category = htmlspecialchars($_POST["categorie"]);
                $price = htmlspecialchars($_POST["prix"]);
                $description = htmlspecialchars($_POST["description"]);
                $id = htmlspecialchars($_POST["id"]);

                $updatePresta = $this->prestation->updatePrestationRemote($category, $description, $price, $id);

                if ($updatePresta) {

                    header("location:index.php?action=manageRepair");
                } else {

                    $error = "Une erreur est survenu";
                }
            }

            $title = "Ajout d'une prestation";
            $template = "www/admin/manageRepair/updatePrestaRemote";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }
}
