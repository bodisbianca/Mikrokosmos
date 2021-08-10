<?php 
require_once "../db/DBController.php";

class MagazinAdmin extends DBController 
{
    function getAllProducts()
    {
        $query = "SELECT * FROM produse WHERE categorie !='albume' ORDER BY id DESC";

        $result=$this->getDBResult($query);
		return $result;
    }
    function getProductCategories()
	{
		$query = "SELECT categorie FROM categorii_produse WHERE categorie !='albume'";
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


	function addNewProduct($denumire, $poza, $categorie_prod, $pret, $cantitate, $descriere)
    {
        $query = "INSERT INTO produse (denumire, poza, categorie, pret, cantitate, descriere) VALUES (?,?,?,?,?,?)";

        $params = array(
            array("param_type" => "s", "param_value" => $denumire),
            array("param_type" => "s", "param_value" => $poza),
			array("param_type" => "s", "param_value" => $categorie_prod),
			array("param_type" => "d", "param_value" => $pret),
			array("param_type" => "i", "param_value" => $cantitate),
			array("param_type" => "s", "param_value" => $descriere)
        );
        $this -> updateDB($query, $params);
    }
	function getLastInsertedProductId()
    {
        $query = "SELECT id FROM produse ORDER BY id DESC LIMIT 1;";

        $result=$this->getDBSingleResult($query);
		return $result['id'];
    }
	function updateProdus($id_produs, $denumire, $poza, $categorie_prod, $pret, $cantitate, $descriere)
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
	function deleteProduct($id_produs)
	{
		$query = "DELETE FROM produse WHERE id=?";
		
		$params = array(
			array("param_type" => "i", "param_value" => $id_produs)
		);
		$this -> updateDB($query, $params);
	}
	function getProductPhotos($id_produs)
	{
		$query = "SELECT * FROM imagini_produse WHERE id_prod = ?";
		$params = array(
			array("param_type" => "i", "param_value" => $id_produs)
				);
		$result=$this->getDBResult($query, $params);
		return $result;
	}
	function insertNewPhoto($id_produs, $poza)
	{
		$query = "INSERT INTO imagini_produse (id_prod, poza) VALUES (?,?)";
		
		$params = array(
            array("param_type" => "i", "param_value" => $id_produs),
			array("param_type" => "s", "param_value" => $poza)
		);
		$this -> updateDB($query, $params);
	}
	function updatePhoto($id_poza, $id_produs, $poza)
	{
		$query = "UPDATE imagini_produse SET poza=? WHERE id=? AND id_prod=?";
		
		$params = array(
            array("param_type" => "s", "param_value" => $poza),
			array("param_type" => "i", "param_value" => $id_poza),
			array("param_type" => "i", "param_value" => $id_produs)
		);
		$this -> updateDB($query, $params);
	}
	
	function updateOrder($id_comanda, $stare)
	{
		$query = "UPDATE comenzi SET stare=? WHERE id_comanda=?";
		
		$params = array(
            array("param_type" => "s", "param_value" => $stare),
			array("param_type" => "i", "param_value" => $id_comanda)
		);
		$this -> updateDB($query, $params);
	}
	function deleteOrderProduct($id_comanda, $id_prod)
	{
		$query = "DELETE FROM comenzi_produse WHERE id_comanda=? && id_prod=?";
		
		$params = array(
			array("param_type" => "i", "param_value" => $id_comanda),
			array("param_type" => "i", "param_value" => $id_prod)
		);
		$this -> updateDB($query, $params);
	}

	function getOrderProductPriceQuantity($id_comanda, $id_prod)
	{
		$query = "SELECT comenzi_produse.cantitate, produse.pret 
					FROM comenzi_produse JOIN produse ON comenzi_produse.id_prod = produse.id
					WHERE comenzi_produse.id_prod = ? AND comenzi_produse.id_comanda=?";
		$params = array(
			array("param_type" => "i", "param_value" => $id_prod),
			array("param_type" => "i", "param_value" => $id_comanda)
				);
		$result=$this->getDBSingleResult($query, $params);
		return $result;
	}

	function updateOrderValue($id_comanda, $suma_plata)
	{
		$query = "UPDATE comenzi SET suma_plata=? WHERE id_comanda=?";
		
		$params = array(
            array("param_type" => "d", "param_value" => $suma_plata),
			array("param_type" => "i", "param_value" => $id_comanda)
		);
		$this -> updateDB($query, $params);
	}
	function deleteOrder($id_comanda)
	{
		$query = "DELETE FROM comenzi WHERE id_comanda=?";
		
		$params = array(
			array("param_type" => "i", "param_value" => $id_comanda)
		);
		$this -> updateDB($query, $params);
	}

	function getOrderStates()
	{
		$query = "SELECT DISTINCT stare FROM comenzi";

        $categoriesResult=$this->getDBResult($query);
		return $categoriesResult;
	}

}
?>