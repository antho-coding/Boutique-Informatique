<?php

class Home
{

    private $db;
    private $connect;


    public function __construct()
    {
        $this->db = new DataBase();
        $this->connect = $this->db->getConnect();
    }

    public function getPictureSlider()
    {

        $query = $this->connect->prepare("
        
        SELECT
            ID,
            Image
        FROM
            Picture_slider_home");

        $query->execute();
        $pictureSlider = $query->fetchAll();

        return $pictureSlider;
    }

    public function addSlide($slide)
    {
        $insert = "INSERT INTO Picture_slider_home(Image)
                   VALUES(?)";

        $query = $this->connect->prepare($insert);
        $ctrl = $query->execute([$slide]);

        return $ctrl;
    }

    public function deleteSlide($id)
    {
        $query = $this->connect->prepare(" 
        
        DELETE FROM Picture_slider_home
        WHERE ID= ? ");

        $delete = $query->execute([$id]);

        return $delete;
    }
}
