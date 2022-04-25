<?php

class Admin
{

    private $db;
    private $connect;


    public function __construct()
    {
        $this->db = new DataBase();
        $this->connect = $this->db->getConnect();
    }

    public function getAdmin($email)
    {

        $query = $this->connect->prepare("
        
                                SELECT
                                    ID,
                                    Email,
                                    Password,
                                    Prenom
                                FROM
                                    Admin
                                WHERE Email = ? ");

        $query->execute([$email]);
        $recupAdmin = $query->fetch();

        return $recupAdmin;
    }
}
