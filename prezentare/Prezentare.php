<?php

require_once "../db/DBController.php";

class Prezentare extends DBController{
    
    function getAllVideoCategories()
    {
        $query = "SELECT DISTINCT categorie FROM date_video WHERE categorie != 'index'";

        $categoriesResult=$this->getDBResult($query);
		return $categoriesResult;
    }

    function getVideosByCategory($categorie)
    {
        $query = "SELECT * FROM date_video  WHERE categorie=? ORDER BY data DESC";
		$params = array(
			array("param_type" => "s", "param_value" => $categorie)
				);
		
		$videoResult=$this->getDBResult($query, $params);
		return $videoResult;
    }


    function getKoreanAlbums()
    {
        $query = "SELECT produse.poza AS coperta, produse.denumire AS titlu,
                            prod_albume.an_aparitie, prod_albume.tip_album, prod_albume.id_alb AS id_album
                 FROM prod_albume INNER JOIN produse ON prod_albume.id_prod = produse.id 
                 WHERE prod_albume.limba= 'coreean'
                 ORDER BY prod_albume.an_aparitie DESC, produse.id DESC";

        $albumResult=$this->getDBResult($query);
        return $albumResult;
    }

    function getKoreanYears()
    {
        $query = "SELECT DISTINCT an_aparitie FROM prod_albume WHERE prod_albume.limba= 'coreean'";

        $albumResult=$this->getDBResult($query);
        return $albumResult;
    }

    function getAlbumYears()
    {
        $query = "SELECT DISTINCT an_aparitie FROM prod_albume";

        $albumResult=$this->getDBResult($query);
        return $albumResult;
    }

    function getAlbumsByYear($an)
	{
		$query = "SELECT produse.poza AS coperta, produse.denumire AS titlu,
                    prod_albume.an_aparitie, prod_albume.tip_album, prod_albume.id_alb AS id_album
                    FROM prod_albume INNER JOIN produse ON prod_albume.id_prod = produse.id  
                    WHERE produse.id=prod_albume.id_prod AND prod_albume.limba= 'coreean' AND prod_albume.an_aparitie=?
					ORDER BY produse.id DESC";
		$params = array(
					array("param_type" => "i", "param_value" => $an)
						);
		$subcategoryResult=$this->getDBResult($query, $params);
        return $subcategoryResult;
	}

    function getAlbumMainInformation($id_album)
    {
        $query = "SELECT produse.denumire, produse.poza AS coperta, produse.descriere, produse.id AS id_prod,
                    prod_albume.an_aparitie, prod_albume.tip_album, 
                    prod_albume.link_spotify AS spotify, prod_albume.link_itunes AS itunes
                    FROM produse JOIN prod_albume ON produse.id = prod_albume.id_prod
                    WHERE prod_albume.id_alb = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_album)
                );
        $albumInfo=$this->getDBSingleResult($query, $params);
        return $albumInfo;
    }

    function getAlbumVersions($id_album)
    {
        $query = "SELECT versiune, poza_ver
                    FROM ver_albume
                    WHERE ver_albume.id_album = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_album)
                );
        $albumVersions=$this->getDBResult($query, $params);
        return $albumVersions;
    }

    function getAlbumSingleVersion($id_album)
    {
        $query = "SELECT poza_grup
                    FROM prod_albume
                    WHERE id_alb = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_album)
                );
        $albumVersions=$this->getDBSingleResult($query, $params);
        return $albumVersions;
    }

    function getAlbumMusic($id_album)
    {
        $query = "SELECT prod_albume.durata, prod_albume.nr_cantece, prod_albume.poza_tracklist AS tracklist, prod_albume.link_youtube AS youtube
                    FROM prod_albume WHERE id_alb=?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_album)
                );
        $albumVersions=$this->getDBSingleResult($query, $params);
        return $albumVersions;
    }

    function getBiography()
    {
        $query = "SELECT * FROM date_biografice";

        $biografie=$this->getDBResult($query);
        return $biografie;
    }

}

?>