<?php

class Contact
{

    private $db;
    private $connect;


    public function __construct()
    {
        $this->db = new DataBase();
        $this->connect = $this->db->getConnect();
    }

    public function insertDataForm($nom, $prenom, $email, $telephone, $sujet, $message)
    {
        $insertData = "INSERT INTO Contact_form(Nom,Prenom,Email,Telephone,Sujet,Message,Date)
                      VALUES(?,?,?,?,?,?,NOW())";

        $query = $this->connect->prepare($insertData);

        $controle = $query->execute([$nom, $prenom, $email, $telephone, $sujet, $message]);

        return $controle; //return true or false for manage error
    }

    public function getContactForm()
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Nom,
            Prenom,
            Email,
            Telephone,
            Sujet,
            Message,
            DATE_FORMAT(Date,'%d/%m/%Y') AS Date
        FROM
            Contact_form
        ORDER BY 
            DATE_FORMAT(Date,'%d/%m/%Y')
        LIMIT 
            5 ");

        $query->execute();
        $contactForm = $query->fetchAll();

        return $contactForm;
    }

    public function getContactFormById($id)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Nom,
            Prenom,
            Email,
            Telephone,
            Sujet,
            Message,
            DATE_FORMAT(Date,'%d/%m/%Y') AS Date
        FROM
            Contact_form
        WHERE 
            ID=? ");

        $query->execute([$id]);
        $detailForm = $query->fetch();

        return $detailForm;
    }

    public function deleteContactForm($id)
    {

        $query = $this->connect->prepare(" 
        
                       DELETE FROM Contact_form
                       WHERE ID= ? ");

        $delete = $query->execute([$id]);

        return $delete;
    }
}
