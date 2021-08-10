<?php

require_once "../db/DBController.php";

class PrezentareAdmin extends DBController
{
    function getAllVideoCategories()
    {
        $query = "SELECT DISTINCT categorie FROM date_video";

        $categoriesResult=$this->getDBResult($query);
		return $categoriesResult;
    }

    function getAllVideos()
    {
        $query = "SELECT * FROM date_video ORDER BY id_video DESC";
		
		$videoResult=$this->getDBResult($query);
		return $videoResult;
    }

    function addNewVideo($titlu, $data, $link, $categorie)
    {
        $data = date('Y-m-d', strtotime ($data));

        $query = "INSERT INTO date_video (titlu, data, link, categorie) 
                VALUES ('".$titlu."','".$data."','".$link."','".$categorie."') ";
        
        $this -> updateDB($query);
    }

    function deleteVideo($id_video)
    {
        $query = "DELETE FROM date_video WHERE id_video=?";

        $params = array(
			array("param_type" => "i", "param_value" => $id_video)
        );
        $this -> updateDB($query, $params);
    }

    function getVideoById($id_video)
    {
        $query = "SELECT * FROM date_video WHERE id_video = ?";
		
        $params = array(
			array("param_type" => "i", "param_value" => $id_video)
        );

		$videoResult=$this->getDBSingleResult($query,$params);
		return $videoResult;
    }

    function updateVideo($id_video, $titlu, $data, $link, $categorie)
    {
        $data = date('Y-m-d', strtotime ($data));

        $query = "UPDATE date_video SET titlu=?, data=?, link=?, categorie=? WHERE id_video=?";
		
        $params = array(
			array("param_type" => "s", "param_value" => $titlu),
			array("param_type" => "s", "param_value" => $data),
			array("param_type" => "s", "param_value" => $link),
			array("param_type" => "s", "param_value" => $categorie),
            array("param_type" => "i", "param_value" => $id_video)
				);
		
		$this -> updateDB($query, $params);
    }

    function getAllBiographyEntries()
    {
        $query = "SELECT * FROM date_biografice ORDER BY id DESC";
		
		$result=$this->getDBResult($query);
		return $result;
    }

    function addNewSubchapter($subtitlu, $imagine, $informatii)
    {
        $query = "INSERT INTO date_biografice (subtitlu, imagine, informatii) VALUES (?,?,?)";

        $params = array(
            array("param_type" => "s", "param_value" => $subtitlu),
            array("param_type" => "s", "param_value" => $imagine),
			array("param_type" => "s", "param_value" => $informatii)
        );
        $this -> updateDB($query, $params);
    }

    function getSubChapterById($id_subcapitol)
    {
        $query = "SELECT * FROM date_biografice WHERE id=?";
		
        $params = array(
            array("param_type" => "i", "param_value" => $id_subcapitol)
        );

		$result=$this->getDBSingleResult($query, $params);
		return $result;
    }

    function deleteSubChapter($id_subcapitol)
    {
        $query = "DELETE FROM date_biografice WHERE id=?";

        $params = array(
			array("param_type" => "i", "param_value" => $id_subcapitol)
        );
        $this -> updateDB($query, $params);
    }
    function updateSubchapter($id_subcapitol, $subtitlu, $imagine, $informatii)
    {
        $query = "UPDATE date_biografice SET subtitlu=?, imagine=?, informatii=? WHERE id=?";
		
        $params = array(
			array("param_type" => "s", "param_value" => $subtitlu),
			array("param_type" => "s", "param_value" => $imagine),
			array("param_type" => "s", "param_value" => $informatii),
            array("param_type" => "i", "param_value" => $id_subcapitol)
				);
		
		$this -> updateDB($query, $params);
    }
}
?>