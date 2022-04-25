<?php

require "models/Contact.php";

//Pour le plugin de telechargement
require "vendor/autoload.php";

use Spipu\Html2Pdf\Html2Pdf;

class ContactControllers
{
    private $contact;
    private $admin;

    public function __construct()
    {
        $this->contact = new Contact;
        $this->admin = new AdminController;
    }

    public function submitContactForm()
    {
        if (
            isset($_POST["nom"]) && !empty($_POST["nom"])
            && isset($_POST["prenom"]) && !empty($_POST["prenom"])
            && isset($_POST["email"]) && !empty($_POST["email"])
            && isset($_POST["telephone"]) && !empty($_POST["telephone"])
            && isset($_POST["sujet"]) && !empty($_POST["sujet"])
            && isset($_POST["message"]) && !empty($_POST["message"])
        ) {
            $name = htmlspecialchars($_POST["nom"]);
            $lastname = htmlspecialchars($_POST["prenom"]);
            $mail = htmlspecialchars($_POST["email"]);
            $phone = htmlspecialchars($_POST["telephone"]);
            $object = htmlspecialchars($_POST["sujet"]);
            $message = htmlspecialchars($_POST["message"]);

            $submitForm = $this->contact->insertDataForm($name, $lastname, $mail, $phone, $object, $message);

            if ($submitForm) {

                $error = "Votre message a bien été envoyé, nous vous repondrons sous 48h ouvrés";
            } else {

                $error = "Nous avons recontré un probléme technique, votre message n'a pas pu être envoyé";
            }
        } elseif (isset($_POST["nom"]) && empty($_POST["nom"])) {

            $error = "Merci de remplir correctement les champs du formulaire";
        }

        $title = "Prestations";
        $template = "www/contact/contact";
        require "www/layaout.phtml";
    }

    public function allManagementContactForm()
    {
        if ($this->admin->verifySessionAdmin()) {

            $contactForms = $this->contact->getContactForm();

            $title = "Gestion des formulaires";
            $template = "www/admin/manageForm/manageContactForm";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    public function deleteForm()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("delId", $_GET)) {

                $deleteForm = $this->contact->deleteContactForm($_GET["delId"]);

                if ($deleteForm) {
                    header("location:index.php?action=manageForm");
                }
            }
        } else {

            header("location:index.php");
        }
    }

    public function seeDetailsForm()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("idForm", $_GET)) {

                $detailForm = $this->contact->getContactFormById($_GET["idForm"]);

                $title = "Detail du formulaire";
                $template = "www/admin/manageForm/displayDetailForm";
                require "www/admin/layaoutAdmin.phtml";
            }
        } else {

            header("location:index.php");
        }
    }

    public function generatePdfDetailsForm()
    {
        if (array_key_exists("idForm", $_GET)) {

            $detailForm = $this->contact->getContactFormById($_GET["idForm"]);

            //instanciation du plugin
            $html2pdf = new Html2Pdf('P', 'A4', 'fr');

            //template et style pour le plugin, selon la doc
            $html = "
            
            <page>

              <style>

                h3 {
                  text-align: center;
                   }

                img {
                  width: 150px;
                   }

                p,a {
                    margin: 10px 0;
                    font-size: 18px;
                  }

                .date {
                    text-align: right;
                  }

                .text-underline {
                    text-decoration: underline;
                }

              </style>

              <page_header>

                <img class=logo src='www/img/LBPI-1.png' alt=logo />
                <h3>Formulaire de contact n° $detailForm[ID] </h3> 

                <div>
                  <p>$detailForm[Nom] $detailForm[Prenom]</p>
                  <a class='mail-contact-form' href='mailto:$detailForm[Email]>$detailForm[Email]</a>
                  <p>$detailForm[Telephone]</p>
                </div>
                
                <p class='date'>$detailForm[Date]</p>
                <div class='object-form'>                
                  <p class='text-underline'>$detailForm[Sujet]</p>
                  <p>$detailForm[Message]</p>
                </div>

              </page_header>

            </page> ";

            $html2pdf->writeHTML($html);
            $html2pdf->Output("detail-form.pdf");
        }
    }
}
