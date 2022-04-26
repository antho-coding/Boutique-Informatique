<?php

require "models/Shop.php";

class ShopControllers
{
    private $shop;
    private $admin;

    public function __construct()
    {
        $this->shop = new Shop;
        $this->admin = new AdminController;
    }

    //Display product shop for user
    public function displayAllProductShop()
    {
        if (array_key_exists("search", $_GET)) {

            $search = htmlspecialchars($_GET["search"]);

            $searchProducts = $this->shop->getBySearchBar($search);

            if (!empty($searchProducts)) {

                require "www/shop/searchBar.phtml";
            } else {

                echo "<p>Aucun produit trouvé</p>";
            }
        } else {

            $allProducts = $this->shop->getAllProduct();

            $title = "Boutique";
            $template = "www/shop/shop";
            require "www/layaout.phtml";
        }
    }

    //Display product shop for admin
    public function allManagmentShop()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("search", $_GET)) {

                $search = htmlspecialchars($_GET["search"]);

                $displayProductsShop = $this->shop->getBySearchBar($search);

                if (!empty($displayProductsShop)) {

                    require "www/admin/manageShop/searchShop.phtml";
                } else {

                    echo "<p>Aucun produit trouvé</p>";
                }
            } else {

                $displayProductsShop = $this->shop->getAllProduct();

                $title = "Gestion de la boutique";
                $template = "www/admin/manageShop/managmentShop";
                require "www/admin/layaoutAdmin.phtml";
            }
        } else {

            header("location:index.php");
        }
    }

    //Display basket Ajax/localStorage end push in table order
    public function displayProductBasket()
    {
        if (array_key_exists("productBasket", $_GET) && array_key_exists("amount", $_GET)) {

            $amount = $_GET["amount"];

            $orderUser = $this->shop->pushInOrder($_SESSION['User']['Id'], $amount);

            $productsBasket = json_decode($_GET["productBasket"]);

            // parcourir product Basket avec un foreach pour insert dans la bdd

            foreach ($productsBasket as $productBasket) {

                $pushDetail = $this->shop->pushDetailOrder($orderUser, $productBasket[3], $productBasket[4], $productBasket[2]);
            }
        } else {
            $title = "Panier";
            $template = "www/shop/showBasket";
            require "www/layaout.phtml";
        }
    }

    //**************************************** Method for manage Shop ***************************************//

    public function insertProductShop()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["description"]) && !empty($_POST["description"]) && isset($_POST["price"]) && !empty($_POST["price"]) && isset($_FILES["picture"]) && !empty($_FILES["picture"])) {

                $nameProduct = htmlspecialchars($_POST["name"]);
                $description = htmlspecialchars($_POST["description"]);
                $price = htmlspecialchars($_POST["price"]);

                //Gestion du fichier image
                $name = htmlspecialchars($_FILES['picture']['name']);
                $tmpName = $_FILES['picture']['tmp_name'];
                $size = $_FILES['picture']['size'];

                $tabExtension = explode('.', $name);
                $extension = strtolower(end($tabExtension));
                $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                $maxSize = 2000000;

                if (in_array($extension, $extensions) && ($size <= $maxSize) && ($size != 0)) {
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName . "." . $extension;

                    move_uploaded_file($tmpName, 'www/img/images-shop/' . $file);

                    $newProduct = $this->shop->addProductShop($nameProduct, $description, $price, $file);

                    if ($newProduct) {

                        $error = " Le produit a bien été crée";
                    } else {

                        $error = "Une erreur est survenue";
                    }
                } else {

                    $error = "Mauvaise extension ou taille trop grande";
                }
            }

            $title = "Ajout d'un produit";
            $template = "www/admin/manageShop/addProductShop";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }

    public function updateProductShop()
    {
        if ($this->admin->verifySessionAdmin()) {

            if (array_key_exists("delId", $_GET) && array_key_exists("picture", $_GET)) {

                $deleteProduct = $this->shop->deleteProductShop($_GET["delId"]);

                //delete picture
                $recoveryPict = $_GET["picture"];
                $routePict = "www/img/images-shop/" . $recoveryPict;
                $delPicture = unlink($routePict);

                if ($deleteProduct) {
                    header("location:index.php?action=manageShop");
                }
            }

            if (array_key_exists("idProduct", $_GET)) {

                $id = $_GET["idProduct"];

                $recoveryProduct = $this->shop->getProductById($id);
            }

            //leave the choice to the user to modify the image or not
            if (isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["description"]) && !empty($_POST["description"]) && isset($_POST["price"]) && !empty($_POST["price"])) {

                $nameProduct = htmlspecialchars($_POST["name"]);
                $description = htmlspecialchars($_POST["description"]);
                $price = htmlspecialchars($_POST["price"]);
                $oldPicture = htmlspecialchars($_POST["recoveryPict"]); //recovery old picture for delete for update
                $idProduct = htmlspecialchars($_POST["id"]);

                //leave the choice to the user to modify the image or not
                if (isset($_FILES["picture"]["name"]) && !empty($_FILES["picture"]["name"])) {

                    $name = htmlspecialchars($_FILES['picture']['name']);
                    $tmpName = $_FILES['picture']['tmp_name'];
                    $size = $_FILES['picture']['size'];

                    $tabExtension = explode('.', $name);
                    $extension = strtolower(end($tabExtension));
                    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                    $maxSize = 2000000;

                    if (in_array($extension, $extensions) && ($size <= $maxSize) && ($size != 0)) {
                        $uniqueName = uniqid('', true);
                        $file = $uniqueName . "." . $extension;
                        move_uploaded_file($tmpName, 'www/img/images-shop/' . $file);

                        // Update if picture
                        $updateProduct = $this->shop->updateProductShop($nameProduct, $description, $price, $file, $idProduct);

                        if ($updateProduct) {

                            //Delete Old picture
                            $routeOldPict = "www/img/images-shop/" . $oldPicture;
                            $delOldPicture = unlink($routeOldPict);

                            header("location:index.php?action=manageShop");
                        } else {

                            $error = "Une erreur est survenue.";
                        }
                    } else {

                        $error = "Mauvaise extension ou taille trop grande";
                    }
                } else {
                    //update else picture
                    $updateProduct = $this->shop->updateProductwithoutPicture($nameProduct, $description, $price, $idProduct);

                    if ($updateProduct) {

                        header("location:index.php?action=manageShop");
                    } else {

                        $error = "Une erreur est survenue.";
                    }
                }
            }

            $title = "Modification d'un produit";
            $template = "www/admin/manageShop/updateProductShop";
            require "www/admin/layaoutAdmin.phtml";
        } else {

            header("location:index.php");
        }
    }
}
