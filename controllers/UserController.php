<?php

require "models/User.php";

//Pour le plugin de telechargement
require "vendor/autoload.php";

use Spipu\Html2Pdf\Html2Pdf;

class UserController
{

    private $user;
    private $orderController;
    private $order;



    public function __construct()
    {
        $this->user = new User;
        $this->orderController = new OrderController;
        $this->order = new Order;
    }


    public function deconnectSession()
    {

        if (isset($_SESSION["User"])) {
            $_SESSION["User"] = [];
            session_unset();
            session_destroy();
            header("location:index.php");
        } else {
            header("location:index.php");
        }
    }

    public function verifySessionUser()
    {
        if (isset($_SESSION["User"])) {
            return true;
        } else {
            return false;
        }
    }

    public function createAccount()
    {

        if (isset($_POST["email"]) && !empty($_POST["email"])) {

            $userExist = $this->user->getUserByMail($_POST["email"]);

            if (!$userExist) {

                if (
                    isset($_POST["name"]) && !empty($_POST["name"])
                    && isset($_POST["prenom"]) && !empty($_POST["prenom"])
                    && isset($_POST["password"]) && !empty($_POST["password"])
                    && isset($_POST["email"]) && !empty($_POST["email"])
                    && isset($_POST["adress"]) && !empty($_POST["adress"])
                    && isset($_POST["code_postal"]) && !empty($_POST["code_postal"])
                    && isset($_POST["city"]) && !empty($_POST["city"])
                    && isset($_POST["phone"]) && !empty($_POST["phone"])
                ) {

                    $name = htmlspecialchars($_POST["name"]);
                    $lastName = htmlspecialchars($_POST["prenom"]);
                    $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
                    $email = htmlspecialchars($_POST["email"]);
                    $adress = htmlspecialchars($_POST["adress"]);
                    $codePostal = htmlspecialchars($_POST["code_postal"]);
                    $city = htmlspecialchars($_POST["city"]);
                    $phone = htmlspecialchars($_POST["phone"]);

                    $insertUser = $this->user->addUser($name, $lastName, $email, $password, $phone, $adress, $codePostal, $city);

                    if ($insertUser == true) {

                        $error = "Le compte à bien été créer";
                        header("location:index.php?action=connectAccount&error=" . $error);
                    } else {
                        $error = "Une erreur serveur est survenue";
                    }
                } else {
                    $error = "Merci de completer correctement les champs du formulaire";
                }
            } else {
                $error = "Impossible de crée le compte, l'email existe deja";
            }
        }

        $title = "Creation de compte";
        $template = "www/user/createAccount";
        require "www/layaoutConnectUser.phtml";
    }

    public function connectUser()
    {
        if (
            isset($_POST["email"]) && !empty($_POST["email"])
            && isset($_POST["password"]) && !empty($_POST["password"])
        ) {
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);

            $userVerify = $this->user->getUserByMail($email);

            if ($userVerify) {

                if (password_verify($password, $userVerify["Password"])) {

                    $_SESSION['User']['Prenom'] = $userVerify["Prenom"];
                    $_SESSION['User']['Id'] = $userVerify["ID"];

                    header("location:index.php?action=userArea");
                } else {

                    $error = "Votre mot de passe est incorrect";
                }
            } else {

                $error = "Votre Email est incorrect";
            }
        }

        $title = "login page";
        $template = "www/user/loginUser";
        require "www/layaoutConnectUser.phtml";
    }

    public function forgotPasswordUser()
    {
        $title = "mot de passe oublié";
        $template = "www/user/forgotPassword";
        require "www/layaoutConnectUser.phtml";
    }

    public function displayInformationUser()
    {
        if ($this->verifySessionUser()) {

            $lastOrder = $this->order->getLastOrder($_SESSION['User']['Id']);
            $infoUser = $this->user->getUserById($_SESSION['User']['Id']);

            $title = "Espace utilisateur";
            $template = "www/user/displayInformationUser";
            require "www/layaout.phtml";
        } else {

            header("location:index.php?action=connectAccount");
        }
    }

    public function updateDataUser()
    {
        // Controle de securité d'url sinon redirection vers la page de connection
        if ($this->verifySessionUser()) {

            // 8 caractére min, 1maj, 1caractére special, 1chiffre a controler avec if(preg_match($regexPassword, $name du mot de passe à controler))
            $regexPassword = "/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/";
            // 1er chiffre 0 puis de 1 a 9 en 2éme chiffre ensuite on separe ou non puis on defini un couple de 0 a 9 et on repete 4 fois
            $regexPhone = "#^0[1-9]([-. ]?[0-9]{2}){4}$#";

            //Requete pour la nav
            $lastOrder = $this->order->getLastOrder($_SESSION['User']['Id']);
            $infoUser = $this->user->getUserById($_SESSION['User']['Id']);

            // *****************************SI MODIFICATION MAIL******************************************//
            if (array_key_exists("mail", $_GET)) {

                // si l'utilisateur à bien remplit le champs "mot de passe actuel"
                if (isset($_POST["password"]) && !empty($_POST["password"])) {

                    // Controle de la saisi pour faille de sécurité
                    $password = htmlspecialchars($_POST["password"]);

                    // On appel la requete pour recuperer le mot de passe actuelle
                    $verifyPassword = $this->user->getUserById($_SESSION['User']['Id']);

                    // Si la requete est ok
                    if ($verifyPassword) {

                        // on compare, on control la securité des autres champs et on update le mail
                        if (password_verify($password, $verifyPassword["Pass"])) {

                            if (isset($_POST["mail"]) && !empty($_POST["mail"]) && isset($_POST["mail-confirm"]) && !empty($_POST["mail-confirm"])) {

                                $mail = htmlspecialchars($_POST["mail"]);
                                $mailconfirm = htmlspecialchars($_POST["mail-confirm"]);

                                // On controle le format de l'email avec la methode native php
                                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                                    //comparaison si les 2 mail sont identique
                                    if ($mail == $mailconfirm) {

                                        $updateMail = $this->user->updateMailUser($mail, $_SESSION['User']['Id']);

                                        if ($updateMail) {

                                            header("location:index.php?action=displayInformationUser");
                                        } else {

                                            $error = "Une erreur est survenu, l'email n'a pas pu être modifier";
                                        }

                                        //sinon mail non identique
                                    } else {

                                        $error = "Les 2 mails doivent être identique";
                                    }

                                    //sinon format de l'email non pris en charhe
                                } else {
                                    $error = "Le format de l'email est invalide";
                                }

                                //sinon champs non remplit
                            } else {

                                $error = "Merci de remplir correctement les champs email";
                            }
                            //sinon mauvais mot de passe
                        } else {

                            $error = "Votre mot de passe actuel ne correspond pas";
                        }

                        //Sinon une erreur technique est survenu
                    } else {
                        $error = "une erreur est survenue";
                    }

                    //sinon mot de passe actuel non saisi
                } elseif (isset($_POST["password"]) && empty($_POST["password"])) {

                    $error = "Merci de saisir votre mot de passe actuel";
                }

                $title = "Espace utilisateur";
                $template =  "www/user/updateMailUser";
                require "www/layaout.phtml";
            }

            // *****************************SI MODIFICATION PASSWORD******************************************//
            if (array_key_exists("password", $_GET)) {

                // si l'utilisateur à bien remplit le champs "mot de passe actuel"
                if (isset($_POST["check-password"]) && !empty($_POST["check-password"])) {

                    // Controle de la saisi pour faille de sécurité
                    $checkPassword = htmlspecialchars($_POST["check-password"]);

                    // On appel la requete pour recuperer le mot de passe actuelle
                    $verifyPassword = $this->user->getUserById($_SESSION['User']['Id']);

                    // Si la requete est ok
                    if ($verifyPassword) {

                        // on compare, on control la securité des autres champs et on update le password
                        if (password_verify($checkPassword, $verifyPassword["Pass"])) {

                            if (isset($_POST["password"]) && !empty($_POST["password"]) && isset($_POST["password-confirm"]) && !empty($_POST["password-confirm"])) {

                                $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
                                $passwordConfirm = htmlspecialchars($_POST["password-confirm"]);

                                // prevoir ici une regex pour controller le format

                                if (preg_match($regexPassword, $passwordConfirm)) {

                                    //comparaison si les 2 password sont identique
                                    if (password_verify($passwordConfirm, $password)) {

                                        $updatePass = $this->user->updatePasswordUser($password, $_SESSION['User']['Id']);

                                        if ($updatePass) {

                                            header("location:index.php?action=displayInformationUser");
                                        } else {

                                            $error = "Une erreur est survenu, le mot de passe n'a pas pu être modifié";
                                        }

                                        //sinon mot de passe non identique
                                    } else {

                                        $error = "Les 2 mot de passe doivent être identique";
                                    }

                                    //sinon mot de passe n'est pas securisé
                                } else {

                                    $error = "Le mot de passe doit contenir au moins 8 caractères dont un chiffre, un caractère spécial, une majuscule";
                                }

                                //sinon champs non remplit
                            } else {

                                $error = "Merci de remplir correctement les champs téléphone";
                            }
                            //sinon mauvais mot de passe actuel
                        } else {

                            $error = "Votre mot de passe actuel ne correspond pas";
                        }

                        //Sinon une erreur technique est survenu
                    } else {
                        $error = "une erreur est survenue";
                    }

                    //sinon mot de passe actuel non saisi
                } elseif (isset($_POST["check-password"]) && empty($_POST["check-password"])) {

                    $error = "Merci de saisir votre mot de passe actuel";
                }

                $title = "Espace utilisateur";
                $template =  "www/user/updatePasswordUser";
                require "www/layaout.phtml";
            }

            // *****************************SI MODIFICATION TELEPHONE******************************************//
            if (array_key_exists("phone", $_GET)) {

                // si l'utilisateur à bien remplit le champs "mot de passe actuel"
                if (isset($_POST["password"]) && !empty($_POST["password"])) {

                    // Controle de la saisi pour faille de sécurité
                    $password = htmlspecialchars($_POST["password"]);

                    // On appel la requete pour recuperer le mot de passe actuelle
                    $verifyPassword = $this->user->getUserById($_SESSION['User']['Id']);

                    // Si la requete est ok
                    if ($verifyPassword) {

                        // on compare, on control la securité des autres champs et on update le téléphone
                        if (password_verify($password, $verifyPassword["Pass"])) {

                            if (isset($_POST["phone"]) && !empty($_POST["phone"]) && isset($_POST["phone-confirm"]) && !empty($_POST["phone-confirm"])) {

                                $phone = htmlspecialchars($_POST["phone"]);
                                $phoneConfirm = htmlspecialchars($_POST["phone-confirm"]);

                                // Controle du format du numero

                                if (preg_match($regexPhone, $phone)) {

                                    //comparaison si les 2 téléphones sont identique
                                    if ($phone == $phoneConfirm) {

                                        $updatePhone = $this->user->updatePhoneUser($phone, $_SESSION['User']['Id']);

                                        if ($updatePhone) {

                                            header("location:index.php?action=displayInformationUser");
                                        } else {

                                            $error = "Une erreur est survenu, le téléphone n'a pas pu être modifier";
                                        }

                                        //sinon téléphone non identique
                                    } else {

                                        $error = "Les 2 numéros de téléphone doivent être identique";
                                    }

                                    //sinon mauvais format
                                } else {

                                    $error = "Le format du numero doit commencer par 0 et être à un format correct";
                                }

                                //sinon champs non remplit
                            } else {

                                $error = "Merci de remplir correctement les champs téléphone";
                            }
                            //sinon mauvais mot de passe
                        } else {

                            $error = "Votre mot de passe actuel ne correspond pas";
                        }

                        //Sinon une erreur technique est survenu
                    } else {
                        $error = "une erreur est survenue";
                    }

                    //sinon mot de passe actuel non saisi
                } elseif (isset($_POST["password"]) && empty($_POST["password"])) {

                    $error = "Merci de saisir votre mot de passe actuel";
                }

                $title = "Espace utilisateur";
                $template =  "www/user/updatePhoneUser";
                require "www/layaout.phtml";
            }
        } else {

            header("location:index.php?action=connectAccount");
        }
    }

    public function generateInvoiceUser()
    {
        if (array_key_exists("idInvoice", $_GET)) {

            $invoiceId = $_GET["idInvoice"];

            $invoice = $this->order->getOrderById($invoiceId);
            $products = $this->order->getLastDetailOrder($invoiceId);
            $dataUser = $this->user->getUserById($_SESSION['User']['Id']);

            //2eme méthode avec le plugin html2pdf , on utilise ob_start et ob_get_clean(natif php) avec un template et un style pour les factures.

            ob_start();

            require "www/user/invoice.phtml";

            $html = ob_get_clean();

            //instanciation du plugin
            $html2pdf = new Html2Pdf('P', 'A4', 'fr');

            $html2pdf->writeHTML($html);
            $html2pdf->Output("MaFacture.pdf");
        }
    }
}
