<?php

class Shop
{

    public $db;
    public $connect;

    public function __construct()
    {
        $this->db = new DataBase();
        $this->connect = $this->db->getConnect();
    }

    public function getAllProduct()
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Produit,
            Description,
            Prix,
            Photo
        FROM
            Shop");

        $query->execute();
        $shop = $query->fetchAll();

        return $shop;
    }

    public function getProductById($id)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Produit,
            Description,
            Prix,
            Photo
        FROM
            Shop
        WHERE ID=? ");

        $query->execute([$id]);
        $shop = $query->fetch();

        return $shop;
    }

    public function getBySearchBar($search)
    {
        $query = $this->connect->prepare("

        SELECT
           ID,
           Produit,
           Description,
           Prix,
           Photo
        FROM
           Shop
        WHERE 
           Produit
        LIKE 
           ? ");

        $query->execute(["%" . $search . "%"]);
        $shop = $query->fetchAll();

        return $shop;
    }

    public function pushInOrder($idUser, $lastAmount)
    {

        $insert = 'INSERT INTO `Order`(ID_user,Prix_total,Date)
                  VALUES(?,?,NOW())';

        $query = $this->connect->prepare($insert);
        $query->execute([$idUser, $lastAmount]);

        $orderUser = $this->connect->lastInsertId();

        return $orderUser;
    }

    public function pushDetailOrder($idOrder, $idProduct, $quantity, $price)
    {

        $insert = "INSERT INTO Detail_order(ID_commande,ID_produit,Quantite,Prix_unitaire)
                  VALUES(?,?,?,?)";

        $query = $this->connect->prepare($insert);
        $ctrl = $query->execute([$idOrder, $idProduct, $quantity, $price]);

        return $ctrl;
    }

    public function addProductShop($product, $description, $price, $picture)
    {
        $insert = "INSERT INTO Shop(Produit,Description,Prix,Photo)
                   VALUES(?,?,?,?)";

        $query = $this->connect->prepare($insert);
        $ctrl = $query->execute([$product, $description, $price, $picture]);

        return $ctrl;
    }

    public function updateProductShop($product, $description, $price, $picture, $id)
    {
        $updateProduct = "UPDATE Shop
                             SET Produit=?,
                                 Description=?,
                                 Prix=?,
                                 Photo=?
                             WHERE ID=? ";

        $query = $this->connect->prepare($updateProduct);

        $ctrl = $query->execute([$product, $description, $price, $picture, $id]);

        return $ctrl;
    }

    public function updateProductwithoutPicture($product, $description, $price, $id)
    {
        $updateProduct = "UPDATE Shop
                             SET Produit=?,
                                 Description=?,
                                 Prix=?
                             WHERE ID=? ";

        $query = $this->connect->prepare($updateProduct);

        $ctrl = $query->execute([$product, $description, $price, $id]);

        return $ctrl;
    }

    public function deleteProductShop($id)
    {
        $query = $this->connect->prepare(" 
        
                       DELETE FROM Shop
                       WHERE ID= ? ");

        $delete = $query->execute([$id]);

        return $delete;
    }
}
