<?php

require_once "../db/DBController.php";

class DiscografieAdmin extends DBController
{
    function getAllAlbums()
    {
        $query = "SELECT produse.id AS id_prod, produse.denumire AS titlu, produse.poza AS coperta, produse.pret, produse.descriere,
						 prod_albume.id_alb AS id_album, prod_albume.limba, prod_albume.durata, prod_albume.an_aparitie, prod_albume.tip_album
				  FROM prod_albume INNER JOIN produse ON prod_albume.id_prod = produse.id 
				  ORDER BY produse.id DESC";

        $albumResult=$this->getDBResult($query);
        return $albumResult;
    }
	function getAlbumsByYear($an)
	{
		$query = "SELECT produse.id AS id_prod, produse.poza AS coperta, produse.denumire AS titlu,
                    	prod_albume.an_aparitie, prod_albume.tip_album, prod_albume.id_alb AS id_album
                    FROM prod_albume INNER JOIN produse ON prod_albume.id_prod = produse.id  
                    WHERE produse.id=prod_albume.id_prod AND prod_albume.an_aparitie=?
					ORDER BY produse.id DESC";
		$params = array(
					array("param_type" => "i", "param_value" => $an)
						);
		$subcategoryResult=$this->getDBResult($query, $params);
        return $subcategoryResult;
	}
    function getAllCategories()
	{
		$query = "SELECT DISTINCT tip_album FROM prod_albume";
		$productResult=$this->getDBResult($query);
		return $productResult;
	}
    function getSubcategoryAlbums($subcategory_prod)
	{
		$query = "SELECT produse.*, prod_albume.id_prod, prod_albume.tip_album 
					FROM produse, prod_albume WHERE produse.id=prod_albume.id_prod AND prod_albume.tip_album=?
					ORDER BY produse.id DESC";
		$params = array(
					array("param_type" => "s", "param_value" => $subcategory_prod)
						);
		$subcategoryResult=$this->getDBResult($query, $params);
        return $subcategoryResult;
	}

	function addNewAlbum($id_produs, $limba, $an_aparitie, $durata, $nr_cantece, $tip_album)
	{
		$query = "INSERT INTO prod_albume (id_prod, limba, an_aparitie, durata, nr_cantece, tip_album) VALUES (?,?,?,?,?,?)";

        $params = array(
            array("param_type" => "i", "param_value" => $id_produs),
            array("param_type" => "s", "param_value" => $limba),
			array("param_type" => "i", "param_value" => $an_aparitie),
			array("param_type" => "i", "param_value" => $durata),
			array("param_type" => "i", "param_value" => $nr_cantece),
			array("param_type" => "s", "param_value" => $tip_album)
        );
        $this -> updateDB($query, $params);
	}
	function getAlbumId($id_produs) /* ia id_alb */
	{
		$query = "SELECT id_alb FROM prod_albume WHERE id_prod = ?";

		$params = array(
			array("param_type" => "i", "param_value" => $id_produs)
				);

        $result=$this->getDBSingleResult($query,$params);
		return $result['id_alb'];
	}
	function getAlbumProdId($id_alb) /* ia id_prod */
	{
		$query = "SELECT id_prod FROM prod_albume WHERE id_alb = ?";

		$params = array(
			array("param_type" => "i", "param_value" => $id_alb)
				);

        $result=$this->getDBSingleResult($query,$params);
		return $result['id_prod'];
	}
	function getLastInsertedAlbumId()
	{
		$query = "SELECT id_prod FROM prod_albume ORDER BY id_prod DESC LIMIT 1;";

        $result=$this->getDBSingleResult($query);
		return $result['id_prod'];
	}

	function deleteAlbum($id_prod)
	{
		$query = "DELETE FROM produse WHERE id=?";

        $params = array(
			array("param_type" => "i", "param_value" => $id_prod)
        );
        $this -> updateDB($query, $params);
	}

	function updateImagesLinks($id_prod, $poza_fizic, $poza_grup, $poza_tracklist, $link_spotify, $link_itunes, $link_youtube)
	{
		$query = "UPDATE prod_albume SET poza_Fizic=?, poza_grup=?, poza_tracklist=?, link_spotify=?, link_itunes=?, link_youtube=? WHERE id_prod=?";
		
        $params = array(
			array("param_type" => "s", "param_value" => $poza_fizic),
			array("param_type" => "s", "param_value" => $poza_grup),
			array("param_type" => "s", "param_value" => $poza_tracklist),
			array("param_type" => "s", "param_value" => $link_spotify),
			array("param_type" => "s", "param_value" => $link_itunes),
            array("param_type" => "s", "param_value" => $link_youtube),
            array("param_type" => "i", "param_value" => $id_prod)
				);
		
		$this -> updateDB($query, $params);
	}
	function addNewVersion($id_album, $versiune, $poza_ver)
	{
		$query = "INSERT INTO ver_albume (id_album, versiune, poza_ver) VALUES (?,?,?)";

        $params = array(
            array("param_type" => "i", "param_value" => $id_album),
            array("param_type" => "s", "param_value" => $versiune),
			array("param_type" => "s", "param_value" => $poza_ver)
        );
        $this -> updateDB($query, $params);
	}

	function getInformatiiGenerale($id_prod)
	{
		$query = "SELECT produse.* , prod_albume.* FROM produse JOIN prod_albume ON produse.id=prod_albume.id_prod WHERE id_prod=?";
		$params = array(
			array("param_type" => "i", "param_value" => $id_prod)
				);

        $result=$this->getDBSingleResult($query,$params);
		return $result;
	}
	function getAlbumVersions($id_prod)
	{
		$query = "SELECT id_ver, versiune , poza_ver FROM ver_albume WHERE id_album=?";
		$params = array(
			array("param_type" => "i", "param_value" => $id_prod)
				);

        $result=$this->getDBResult($query,$params);
		return $result;
	}

	function updateAlbumProd($id_produs, $denumire, $poza, $categorie_prod, $pret, $cantitate, $descriere)
	{
		$query = "UPDATE produse SET denumire=?, poza=?, categorie=?, pret=?, cantitate=?, descriere=? WHERE id=?";
		
        $params = array(
			array("param_type" => "s", "param_value" => $denumire),
			array("param_type" => "s", "param_value" => $poza),
			array("param_type" => "s", "param_value" => $categorie_prod),
			array("param_type" => "d", "param_value" => $pret),
			array("param_type" => "i", "param_value" => $cantitate),
            array("param_type" => "s", "param_value" => $descriere),
            array("param_type" => "i", "param_value" => $id_produs)
				);
		
		$this -> updateDB($query, $params);
	}
	function updateAlbum($id_produs, $limba, $an_aparitie, $durata, $nr_cantece, $tip_album)
	{
		$query = "UPDATE prod_albume SET limba=?, an_aparitie=?, durata=?, nr_cantece=?, tip_album=? WHERE id_prod=?";

        $params = array(
            array("param_type" => "s", "param_value" => $limba),
			array("param_type" => "i", "param_value" => $an_aparitie),
			array("param_type" => "i", "param_value" => $durata),
			array("param_type" => "i", "param_value" => $nr_cantece),
			array("param_type" => "s", "param_value" => $tip_album),
			array("param_type" => "i", "param_value" => $id_produs)
        );
        $this -> updateDB($query, $params);
	}

	function updateVersion($id_ver, $versiune, $poza_ver)
	{
		$query = "UPDATE ver_albume SET versiune=?, poza_ver=? WHERE id_ver=?";

        $params = array(
            array("param_type" => "s", "param_value" => $versiune),
            array("param_type" => "s", "param_value" => $poza_ver),
			array("param_type" => "i", "param_value" => $id_ver)
        );
        $this -> updateDB($query, $params);
	}
	function deleteVersion($id_ver)
	{
		$query = "DELETE FROM ver_albume WHERE id_ver=?";

        $params = array(
			array("param_type" => "i", "param_value" => $id_ver)
        );
        $this -> updateDB($query, $params);
	}
}
?>