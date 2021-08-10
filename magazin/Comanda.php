<?php

require_once "../db/DBController.php";

class Comanda extends DBController
{	
	/* PENTRU ADMIN */
	function getAllOrders()
	{
		$query = "SELECT comenzi.id_comanda, stare, data_comanda, suma_plata, nr_prod.nr_produse
					FROM comenzi 
					JOIN (
						SELECT comenzi_produse.id_comanda, SUM(comenzi_produse.cantitate) as nr_produse FROM comenzi_produse GROUP BY (id_comanda)
						) nr_prod
					ON nr_prod.id_comanda = comenzi.id_comanda
					ORDER BY comenzi.data_comanda DESC";
		
		$result=$this->getDBResult($query);
		return $result;		
	}
	function getOrderUser($id_comanda)
	{
		$query = " SELECT nume, prenume, comenzi.stare, comenzi.suma_plata FROM utilizatori JOIN comenzi ON utilizatori.id_user = comenzi.id_user WHERE comenzi.id_comanda = ?";

		$params = array(
			array("param_type" => "i", "param_value" => $id_comanda)
				);

		$result=$this->getDBSingleResult($query,$params);
		return $result;

	}
	
	function getOrdersByState($stare)
	{
		$query = "SELECT comenzi.id_comanda, stare, data_comanda, suma_plata, nr_prod.nr_produse
				FROM comenzi 
				JOIN (
					SELECT comenzi_produse.id_comanda, SUM(comenzi_produse.cantitate) as nr_produse FROM comenzi_produse GROUP BY (id_comanda)
					) nr_prod
				ON nr_prod.id_comanda = comenzi.id_comanda
				WHERE stare=?
				ORDER BY comenzi.data_comanda DESC";

		$params = array(
			array("param_type" => "s", "param_value" => $stare)
				);

		$result=$this->getDBResult($query,$params);
		return $result;
	}


	function getOrder($id_user)
	{
		$query = "SELECT * FROM cos_client WHERE id_user=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);
		$result=$this->getDBResult($query,$params);
		return $result;	
	}

	// VIZUALIZAREA COMENZILOR DPDV A UTILIZATORULUI
	function getUserOrders($id_user)
	{
		$query = "SELECT comenzi.id_comanda, stare, data_comanda, suma_plata, nr_prod.nr_produse
				  	FROM comenzi 
					JOIN (
						SELECT comenzi_produse.id_comanda, SUM(comenzi_produse.cantitate) as nr_produse FROM comenzi_produse GROUP BY (id_comanda)
						) nr_prod
					ON nr_prod.id_comanda = comenzi.id_comanda
					WHERE id_user=?
					ORDER BY comenzi.data_comanda DESC";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);					
		
		$orderResult=$this->getDBResult($query,$params);
		return $orderResult;
	}

	function getUserOrdersAddress($id_comanda)
	{
		$query = "SELECT judet, localitate, strada, numar, apartament, cod_postal FROM comenzi WHERE id_comanda =?";
		$params = array(
			array("param_type" => "i", "param_value" => $id_comanda)
				);
		
		$addressResult=$this->getDBSingleResult($query,$params);
		return $addressResult;

	}

	function getUserOrderDetails($id_comanda)
	{
		$query = "SELECT comenzi_produse.id_prod, comenzi_produse.id_ver, comenzi_produse.cantitate,
						 produse.denumire, produse.pret, produse.poza, produse.categorie,
        				 ver_albume.versiune
					FROM
						comenzi_produse JOIN produse ON comenzi_produse.id_prod = produse.id
						LEFT JOIN ver_albume ON comenzi_produse.id_ver = ver_albume.id_ver 
					WHERE 
						comenzi_produse.id_comanda=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_comanda)
						);					
		
		$orderDetailsResult=$this->getDBResult($query,$params);
		return $orderDetailsResult;
	}
	


	function registerOrderAddress($id_user, $suma_plata, $judet, $localitate, $strada, $numar, $apartament, $codzip)
	{
		$query = "INSERT INTO comenzi(id_user, suma_plata, judet, localitate, strada, numar, apartament, cod_postal) VALUES (?,?,?,?,?,?,?,?)";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user),
					array("param_type" => "i", "param_value" => $suma_plata),
					array("param_type" => "s", "param_value" => $judet),
					array("param_type" => "s", "param_value" => $localitate),
					array("param_type" => "s", "param_value" => $strada),	
					array("param_type" => "i", "param_value" => $numar),
					array("param_type" => "i", "param_value" => $apartament),
					array("param_type" => "s", "param_value" => $codzip)				
					);
		$this -> updateDB($query, $params);	
	}

	function registerOrderProducts($id_user, $id_prod, $id_ver, $cantitate)
	{
		$query_orderid = "SELECT id_comanda FROM comenzi WHERE id_user=? ORDER BY data_comanda DESC LIMIT 1";
		$params_orderid = array(
			array("param_type" => "i", "param_value" => $id_user)
				);
		$order_id = $this->getDBSingleResult($query_orderid, $params_orderid);
		$order_id = $order_id['id_comanda'];

		$query = "INSERT INTO comenzi_produse(id_comanda, id_prod, id_ver, cantitate) VALUES (?,?,?,?)";
		$params = array(
					array("param_type" => "i", "param_value" => $order_id),
					array("param_type" => "i", "param_value" => $id_prod),
					array("param_type" => "i", "param_value" => $id_ver),
					array("param_type" => "i", "param_value" => $cantitate)					
					);
		$this -> updateDB($query, $params);	
		
		$query2 = "DELETE FROM cos_client WHERE id_user=?";
		$params2 = array(
					array("param_type" => "i", "param_value" => $id_user)
					);
		$this -> updateDB($query2, $params2);
		
	}
	
	
}

?>