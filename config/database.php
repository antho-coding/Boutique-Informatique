<?php

class DataBase
{
    const SERVEUR = "db.3wa.io";
    const DBNAME = "anthonyleloup_ProjetFinal";
    const USER = "anthonyleloup";
    const PASSWORD = "8c5cd1b5695100a2929d5ae4e4ba3b9b";

    private $connect;

    public function __construct()
    {
        try {
            $this->connect = new PDO("mysql:host=" . self::SERVEUR . ";dbname=" . self::DBNAME, self::USER, self::PASSWORD);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->exec("SET CHARACTER SET utf8");
        } catch (PDOException $error) {
            echo "Erreur : " . $error->getMessage();
        }
    }

    public function getConnect()
    {
        return $this->connect;
    }
}
