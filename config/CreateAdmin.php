<?php
require "database.php";

class CreateAdmin
{

    private $db;
    private $connect;

    public function __construct()
    {
        $this->db = new DataBase();
        $this->connect = $this->db->getConnect();
    }

    public function insertAdmin($prenom, $email, $password)
    {

        $insert = "INSERT INTO Admin(Prenom,Email,Password)
                    VALUES(?,?,?)";

        $query = $this->connect->prepare($insert);

        $test = $query->execute([$prenom, $email, $password]);

        return $test;
    }
}

$addAdmin = new CreateAdmin();

// Les champs sont a modifié avec des mdp securisé pour crée des admin a vider une fois l'insertion fini
$prenom = "";
$email = "";
$pass = password_hash("", PASSWORD_DEFAULT);

$addAdmin->insertAdmin($prenom, $email, $pass);

if ($addAdmin) {
    header("location:../index.php");
} else {
    echo "une erreur est survenu lors de la création de l'administateur";
}
