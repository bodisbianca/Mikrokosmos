<?php

require_once "../db/DBController.php";

class CosCumparaturi extends DBController
{	
    /* selectara tuturor informatiilor legate de cosul utilizatorului +  DETALIILE aferente produselor */
	function getUserCartItem($id_user)
	{
		$query = "SELECT produse.*, 
						cos_client.id_cos AS id_cos, cos_client.cantitate AS cantitate, 
						cos_client.id_ver AS id_ver,
						ver_albume.versiune AS versiune
						FROM produse, cos_client
						LEFT JOIN ver_albume ON cos_client.id_ver = ver_albume.id_ver
						WHERE produse.id = cos_client.id_prod AND cos_client.id_user=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);
		$cartResult = $this->getDBResult($query,$params);
		return $cartResult;
	}
		
	function getProductById($product_id)
	{
		$query = "SELECT * FROM produse WHERE id=?";
		
		$params = array(
					array("param_type" => "s", "param_value" => $product_id)
						);
		$productResult = $this->getDBResult($query,$params);
		return $productResult;
	}

	function getCartItemByProduct($id_prod, $id_user)
	{
		$query = "SELECT * FROM cos_client WHERE id_prod = ? AND id_user=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_prod),
					array("param_type" => "i", "param_value" => $id_user)
					);
		$cartResult = $this->getDBResult($query,$params);
		return $cartResult;
	}
	
	function addToCart($id_prod, $cantitate, $id_user)
	{
		$query = "INSERT INTO cos_client(id_prod, cantitate, id_user) VALUES (?,?,?)";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_prod),
					array("param_type" => "i", "param_value" => $cantitate),
					array("param_type" => "i", "param_value" => $id_user)
					);
		$this -> updateDB($query, $params);
	}

	function addAlbumToCart($id_prod, $id_ver, $cantitate, $id_user)
	{
		$query = "INSERT INTO cos_client(id_prod, id_ver, cantitate, id_user) VALUES (?,?,?,?)";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_prod),
					array("param_type" => "i", "param_value" => $id_ver),
					array("param_type" => "i", "param_value" => $cantitate),
					array("param_type" => "i", "param_value" => $id_user)
					);
		$this -> updateDB($query, $params);
	}
	
	function updateCartQuantity($cantitate, $id_cos)
	{
		$query="UPDATE cos_client SET cantitate=? WHERE id_cos=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $cantitate),
					array("param_type" => "i", "param_value" => $id_cos)
					);
		$this -> updateDB($query, $params);
	}
	
	function deleteCartItem($id_cos)
	{
		$query="DELETE FROM cos_client WHERE id_cos=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_cos)
					);
		$this -> updateDB($query, $params);
	}
	
	function emptyCart($id_user)
	{
		$query="DELETE FROM cos_client WHERE id_user=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
					);
		$this -> updateDB($query, $params);
	}

}


?>