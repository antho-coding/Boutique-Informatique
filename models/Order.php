<?php

class Order
{

    private $db;
    private $connect;


    public function __construct()
    {
        $this->db = new DataBase();
        $this->connect = $this->db->getConnect();
    }

    public function getLastOrder($idUser)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID_commande,
            ID_user,
            Produit,
            Quantite,
            Prix_unitaire,
            Prix_total,
            DATE_FORMAT(Date,'%d/%m/%Y') AS Date,
            Photo
        FROM
            Detail_order
        INNER JOIN `Order`
        ON `Order`.ID = Detail_order.ID_commande
        INNER JOIN Shop ON Shop.ID = Detail_order.ID_produit
        WHERE ID_user = ?
        ORDER BY `Order`.ID DESC
        LIMIT 1 ");

        $query->execute([$idUser]);

        $lastOrder = $query->fetch();

        return $lastOrder;
    }


    public function getAllOrder($idUser)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            ID_user,
            Prix_total,
            DATE_FORMAT(Date,'%d/%m/%Y') AS Date
        FROM
            `Order`     
        WHERE ID_user = ?
        ORDER BY ID DESC");

        $query->execute([$idUser]);

        $lastOrder = $query->fetchAll();

        return $lastOrder;
    }

    public function getOrderById($idOrder)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Prix_total,
            DATE_FORMAT(Date,'%d/%m/%Y') AS Date
        FROM
            `Order`     
        WHERE ID = ?
        ORDER BY Date DESC ");

        $query->execute([$idOrder]);

        $lastOrder = $query->fetch();

        return $lastOrder;
    }

    public function getLastDetailOrder($idOrder)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID_commande,
            ID_user,
            Produit,
            Quantite,
            Prix_unitaire,
            Prix_total,
            DATE_FORMAT(Date,'%d/%m/%Y') AS Date,
            Photo
        FROM
            Detail_order
        INNER JOIN `Order`
        ON `Order`.ID = Detail_order.ID_commande
        INNER JOIN Shop ON Shop.ID = Detail_order.ID_produit
        WHERE ID_commande = ?
        ORDER BY `Order`.ID DESC ");

        $query->execute([$idOrder]);

        $lastOrder = $query->fetchAll();

        return $lastOrder;
    }
}
