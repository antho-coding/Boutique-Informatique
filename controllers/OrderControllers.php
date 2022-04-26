<?php

require "models/Order.php";

class OrderController
{
    private $order;
    private $user;

    public function __construct()
    {
        $this->order = new Order;
        $this->user = new UserController;
    }

    public function displayLastOrder()
    {
        if ($this->user->verifySessionUser()) {

            $lastOrder = $this->order->getLastOrder($_SESSION['User']['Id']);

            $title = "Espace utilisateur";
            $template = "www/user/clientArea";
            require "www/layaout.phtml";
        } else {

            header("location:index.php?action=connectAccount");
        }
    }

    public function displayDetailLastOrder()
    {
        if ($this->user->verifySessionUser()) {

            if (array_key_exists("idLastOrder", $_GET)) {

                //for select
                $allOrders = $this->order->getAllOrder($_SESSION['User']['Id']);

                //for date price last order
                $lastOrder = $this->order->getLastOrder($_SESSION['User']['Id']);

                //for detail display detail order
                $idLastOrder = $_GET["idLastOrder"];

                $lastDetailsOrder = $this->order->getLastDetailOrder($idLastOrder);

                $title = "Espace utilisateur";
                $template = "www/user/detailsOrderUser";
                require "www/layaout.phtml";
            } elseif (array_key_exists("idOrder", $_GET)) {

                //for select
                $allOrders = $this->order->getAllOrder($_SESSION['User']['Id']);

                $idOrder = $_GET["idOrder"];

                //for date et price global
                $uniqOrder = $this->order->getOrderById($idOrder);

                //for choice order
                $choiceOrder = $this->order->getLastDetailOrder($idOrder);

                require "www/user/choiceOrder.phtml";
            }
        } else {

            header("location:index.php?action=connectAccount");
        }
    }
}
