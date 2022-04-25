<?php

class User
{
    private $db;
    private $connect;

    public function __construct()
    {
        $this->db = new DataBase;
        $this->connect = $this->db->getConnect();
    }

    public function getUserByMail($mail)
    {

        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Mail,
            Password,
            Prenom
        FROM
            User
        WHERE Mail = ? ");

        $query->execute([$mail]);
        $recoveryUser = $query->fetch();

        return $recoveryUser;
    }

    public function getUserById($id)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Nom,
            Prenom,
            Adresse,
            Code_postal,
            Ville,
            Mail,
            Password AS Pass,
            Telephone,
            REPLACE('Password', 'Password', '********') AS Password
        FROM
            User
        WHERE ID = ? ");

        $query->execute([$id]);
        $recoveryUser = $query->fetch();

        return $recoveryUser;
    }

    public function addUser($name, $lastName, $mail, $password, $phone, $adress, $cp, $city)
    {

        $insert = "INSERT INTO User(Nom,Prenom,Mail,Password,Telephone,Adresse,Code_postal,Ville)
                   VALUES(?,?,?,?,?,?,?,?)";

        $query = $this->connect->prepare($insert);
        $test = $query->execute([$name, $lastName, $mail, $password, $phone, $adress, $cp, $city]);

        return $test;
    }

    public function updateMailUser($mail, $idUser)
    {
        $updateMail = "UPDATE User
                          SET Mail=?
                          WHERE ID=? ";

        $query = $this->connect->prepare($updateMail);

        $ctrl = $query->execute([$mail, $idUser]);

        return $ctrl;
    }

    public function updatePasswordUser($password, $idUser)
    {
        $updateMail = "UPDATE User
                          SET Password=?
                          WHERE ID=? ";

        $query = $this->connect->prepare($updateMail);

        $ctrl = $query->execute([$password, $idUser]);

        return $ctrl;
    }

    public function updatePhoneUser($phone, $idUser)
    {
        $updateMail = "UPDATE User
                          SET Telephone=?
                          WHERE ID=? ";

        $query = $this->connect->prepare($updateMail);

        $ctrl = $query->execute([$phone, $idUser]);

        return $ctrl;
    }
}
