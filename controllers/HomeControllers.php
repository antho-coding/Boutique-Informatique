<?php

require "models/home.php";

class HomeControllers
{
    private $home;
    private $admin;

    public function __construct()
    {
        $this->home = new Home;
        $this->admin = new AdminController;
    }

    //Display pictures for the slider
    public function staticPage()
    {
        $displaySlides = $this->home->getPictureSlider();

        $title = "Page d'accueil";
        $template = "www/home";
        require "www/layaout.phtml";
    }

    //**************************************** Method for manage Slider ***************************************//

    public function displaySlide()
    {
        if ($this->admin->verifySessionAdmin()) {

            //Display all slides
            $displaySlides = $this->home->getPictureSlider();

            //Delete slide in delete picture in the dossier
            if (array_key_exists("delId", $_GET) && array_key_exists("picture", $_GET)) {

                $deleteProduct = $this->home->deleteSlide($_GET["delId"]);

                //delete picture
                $recoveryPict = $_GET["picture"];
                $routePict = "www/img/images-sliders/" . $recoveryPict;
                $delPicture = unlink($routePict);

                if ($deleteProduct) {
                    header("location:index.php?action=manageSlider");
                }
            }

            //Insert new slide
            if (isset($_FILES["picture"]) && !empty($_FILES["picture"])) {

                //verify the picture for securiy probleme
                $name = htmlspecialchars($_FILES['picture']['name']);
                $tmpName = $_FILES['picture']['tmp_name'];
                $size = $_FILES['picture']['size'];
                // var_dump($size);
                $tabExtension = explode('.', $name);
                $extension = strtolower(end($tabExtension));
                $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                $maxSize = 2000000; //2Mo

                if (in_array($extension, $extensions) && ($size <= $maxSize) && ($size != 0)) {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName . "." . $extension;

                    //download
                    move_uploaded_file($tmpName, 'www/img/images-sliders/' . $file);

                    // Update picture
                    $insertSlide = $this->home->addSlide($file);

                    if ($insertSlide) {

                        $error = "La slide a bien été rajoutée.";
                    } else {

                        $error = "Une erreur est survenue.";
                    }
                } else {

                    $error = "Mauvaise extension ou taille trop grande";
                }
            }

            $title = "Ajout d'une Slide";
            $template = "www/admin/manageSlider/manageSlider";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }
}
