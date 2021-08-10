<?php

require_once "../db/DBController.php";

class Magazin extends DBController
{
	/* INDEX MAGAZIN */

	function getNewestProducts($categorie)
	{
		$query = "SELECT * FROM produse  WHERE categorie=? ORDER BY id DESC LIMIT 3";
		$params = array(
			array("param_type" => "s", "param_value" => $categorie)
				);
		
		$productResult=$this->getDBResult($query, $params);
		return $productResult;
	}


    /* selectarea tuturor produselor */
	function getAllProducts()
	{
		$query = "SELECT * FROM produse ORDER BY id DESC";
		
		$productResult=$this->getDBResult($query);
		return $productResult;
	}

	function getAllCategories()
	{
		$query = "SELECT categorie FROM categorii_produse";
		$productResult=$this->getDBResult($query);
		return $productResult;
	}

	function getProductsByCategory($categorie)
	{
		$query = "SELECT * FROM produse  WHERE categorie=? ORDER BY id DESC";
		$params = array(
			array("param_type" => "s", "param_value" => $categorie)
				);
		
		$productResult=$this->getDBResult($query, $params);
		return $productResult;
	}

	function getProductById($product_id)
	{
		$query = "SELECT * FROM produse WHERE id=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $product_id)
						);
		$productResult = $this->getDBSingleResult($query,$params);
		return $productResult;
	}

	function getProductPhotos($product_id)
	{
		$query = "SELECT poza FROM imagini_produse WHERE imagini_produse.id_prod = ?";

		$params = array(
			array("param_type" => "i", "param_value" => $product_id)
				);
		$productResult = $this->getDBResult($query,$params);
		if(!empty($productResult))
			{$productResult = array_column($productResult, 'poza');}
		
		return $productResult;
	}



	/* ALBUME */
    /* selectarea tuturor albumelor + detaliile aferente  (FARA VERSIUNILE LOR)*/
    function getAllAlbums()
    {
        $query = "SELECT produse.*, 
						 prod_albume.limba, prod_albume.durata, prod_albume.an_aparitie 
				  FROM prod_albume INNER JOIN produse ON prod_albume.id_prod = produse.id 
				  ORDER BY produse.id DESC";

        $albumResult=$this->getDBResult($query);
        return $albumResult;
    }

	/* selectarea produselor dintr-o subcategorie */
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
	

	/* selectarea detaliilor legate de UN ALBUM */
	function getAlbumById($product_id)
	{
		$query = "SELECT produse.*, 
						 prod_albume.an_aparitie, prod_albume.durata, prod_albume.nr_cantece, prod_albume.limba, prod_albume.tip_album, prod_albume.id_alb 
					FROM prod_albume INNER JOIN produse ON prod_albume.id_prod = produse.id 
					WHERE produse.id=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $product_id)
						);
		$productResult = $this->getDBResult($query,$params);
		return $productResult;
	}

	function getAlbumVersions($product_id)
	{
		$query = "SELECT ver_albume.* FROM ver_albume WHERE ver_albume.id_album=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $product_id)
						);
		$versionResult = $this->getDBResult($query,$params);
		return $versionResult;
	}

	/* selectarea pozelor corespondente unui album */
	function getAlbumPhotos($product_id)
	{
		$query = "SELECT produse.poza AS coperta, 
						 prod_albume.poza_fizic AS fizic, prod_albume.poza_tracklist AS tracks
					FROM produse, prod_albume WHERE produse.id = prod_albume.id_prod AND produse.id = ?";

		$params = array(
			array("param_type" => "i", "param_value" => $product_id)
				);
		$productResult = $this->getDBSingleResult($query,$params);
		return $productResult;
	}
}

?>