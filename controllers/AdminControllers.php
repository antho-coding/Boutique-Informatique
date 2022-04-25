<?php
require "models/Admin.php";

class AdminController
{

    private $db;
    private $connect;
    private $admin;

    public function __construct()
    {
        $this->db = new DataBase;
        $this->connect = $this->db->getConnect();
        $this->admin = new Admin;
    }

    public function verifySessionAdmin()
    {
        if (isset($_SESSION["Admin"])) {
            return true;
        } else {
            return false;
        }
    }

    public function deconnectSessionAdmin()
    {

        if (isset($_SESSION["Admin"])) {

            $_SESSION["Admin"] = [];
            session_unset();
            session_destroy();
            header("location:index.php");
        }
    }

    public function Admin()
    {
        if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"])) {

            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);

            $adminVerify = $this->admin->getAdmin($email);

            if ($adminVerify) {

                if (password_verify($password, $adminVerify["Password"])) {
                    $_SESSION['Admin']["Prenom"] = $adminVerify["Prenom"];
                    $_SESSION['Admin']['Id'] = $adminVerify["ID"];

                    $title = "Panneau administrateur";
                    require "www/admin/layaoutAdmin.phtml";
                } else {

                    $error = "Votre mot de passe est incorrect";
                }
            } else {

                $error = "Votre email est incorrect";
            }
        } else {

            $title = "Connection admin";
            $template = "www/admin/loginAdmin";
            require "www/layaoutConnectUser.phtml";
        }
    }
}
