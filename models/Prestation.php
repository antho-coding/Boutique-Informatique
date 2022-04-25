<?php

class Prestation
{

    private $db;
    private $connect;


    public function __construct()
    {
        $this->db = new DataBase();
        $this->connect = $this->db->getConnect();
    }


    //**************************************** Request for Prestation computer ***************************************//
    public function getPrestationRepairComputer()
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_computer");

        $query->execute();
        $prestationComputer = $query->fetchAll();

        return $prestationComputer;
    }

    public function getPrestationComputerById($id)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_computer
        WHERE ID=? ");

        $query->execute([$id]);

        $prestationComputer = $query->fetch();

        return $prestationComputer;
    }

    public function addPrestationComputer($category, $description, $price)
    {

        $insert = "INSERT INTO Repair_computer(Categorie,Tache,Prix)
                   VALUES(?,?,?)";

        $query = $this->connect->prepare($insert);
        $ctrl = $query->execute([$category, $description, $price]);

        return $ctrl;
    }

    public function updatePrestationComputer($category, $description, $price, $idPresta)
    {
        $updatePrestation = "UPDATE Repair_computer
                             SET Categorie=?,
                                 Tache= ?,
                                 Prix=?
                             WHERE ID=? ";

        $query = $this->connect->prepare($updatePrestation);

        $ctrl = $query->execute([$category, $description, $price, $idPresta]);

        return $ctrl;
    }

    public function deletePrestationRepairComputer($id)
    {

        $query = $this->connect->prepare(" 
        
                       DELETE FROM Repair_computer
                       WHERE ID= ? ");

        $delete = $query->execute([$id]);

        return $delete;
    }

    //**************************************** Request for Prestation Peripheral ***************************************/
    public function getPrestationRepairPeripheral()
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_computer_peripheral");

        $query->execute();
        $prestationPeripheral = $query->fetchAll();

        return $prestationPeripheral;
    }

    public function getPrestationPeripheralById($id)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_computer_peripheral
        WHERE ID=? ");

        $query->execute([$id]);

        $prestationPeripheral = $query->fetch();

        return $prestationPeripheral;
    }

    public function addPrestationPeripheral($category, $description, $price)
    {
        $insert = "INSERT INTO Repair_computer_peripheral(Categorie,Tache,Prix)
                   VALUES(?,?,?)";

        $query = $this->connect->prepare($insert);
        $ctrl = $query->execute([$category, $description, $price]);

        return $ctrl;
    }

    public function updatePrestationPeripheral($category, $description, $price, $idPresta)
    {
        $updatePrestation = "UPDATE Repair_computer_peripheral
                             SET Categorie=?,
                                 Tache= ?,
                                 Prix=?
                             WHERE ID=? ";

        $query = $this->connect->prepare($updatePrestation);

        $ctrl = $query->execute([$category, $description, $price, $idPresta]);

        return $ctrl;
    }

    public function deletePrestationRepairPeripheral($id)
    {
        $query = $this->connect->prepare(" 
        
                       DELETE FROM Repair_computer_peripheral
                       WHERE ID= ? ");

        $delete = $query->execute([$id]);

        return $delete;
    }

    //**************************************** Request for Prestation Internet ***************************************/
    public function getPrestationRepairInternet()
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_internet_box");

        $query->execute();
        $prestationInternet = $query->fetchAll();

        return $prestationInternet;
    }

    public function getPrestationInternetById($id)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_internet_box
        WHERE ID=? ");

        $query->execute([$id]);

        $prestationInternet = $query->fetch();

        return $prestationInternet;
    }

    public function addPrestationBox($category, $description, $price)
    {
        $insert = "INSERT INTO Repair_internet_box(Categorie,Tache,Prix)
                   VALUES(?,?,?)";

        $query = $this->connect->prepare($insert);
        $ctrl = $query->execute([$category, $description, $price]);

        return $ctrl;
    }

    public function updatePrestationInternet($category, $description, $price, $idPresta)
    {
        $updatePrestation = "UPDATE Repair_internet_box
                             SET Categorie=?,
                                 Tache= ?,
                                 Prix=?
                             WHERE ID=? ";

        $query = $this->connect->prepare($updatePrestation);

        $ctrl = $query->execute([$category, $description, $price, $idPresta]);

        return $ctrl;
    }

    public function deletePrestationRepairInternet($id)
    {
        $query = $this->connect->prepare(" 
        
                       DELETE FROM Repair_internet_box
                       WHERE ID= ? ");

        $delete = $query->execute([$id]);

        return $delete;
    }

    //**************************************** Request for Prestation remote ***************************************/
    public function getPrestationRepairRemote()
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_remote");

        $query->execute();
        $prestationRemove = $query->fetchAll();

        return $prestationRemove;
    }

    public function getPrestationRemoteById($id)
    {
        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Categorie,
            Tache,
            Prix
        FROM
            Repair_remote
        WHERE ID=? ");

        $query->execute([$id]);

        $prestationRemote = $query->fetch();

        return $prestationRemote;
    }

    public function addPrestationRemote($category, $description, $price)
    {
        $insert = "INSERT INTO Repair_remote(Categorie,Tache,Prix)
                   VALUES(?,?,?)";

        $query = $this->connect->prepare($insert);
        $ctrl = $query->execute([$category, $description, $price]);

        return $ctrl;
    }

    public function updatePrestationRemote($category, $description, $price, $idPresta)
    {
        $updatePrestation = "UPDATE Repair_remote
                             SET Categorie=?,
                                 Tache= ?,
                                 Prix=?
                             WHERE ID=? ";

        $query = $this->connect->prepare($updatePrestation);

        $ctrl = $query->execute([$category, $description, $price, $idPresta]);

        return $ctrl;
    }

    public function deletePrestationRemote($id)
    {
        $query = $this->connect->prepare(" 
        
                       DELETE FROM Repair_remote
                       WHERE ID= ? ");

        $delete = $query->execute([$id]);

        return $delete;
    }
}
