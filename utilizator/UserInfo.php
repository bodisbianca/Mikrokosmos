<?php

require_once "../db/DBController.php";

class UserInfo extends DBController
{
	function getUser($id_user)
	{
		$query = "SELECT * FROM utilizatori WHERE id_user=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);					
		
		$personalInfo=$this->getDBSingleResult($query,$params);
		return $personalInfo;		
	}

	function getUserTotalOrders($id_user)
	{
		$query = "SELECT COUNT(id_comanda) AS nr_comenzi FROM comenzi WHERE id_user=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);					
		
		$ordersCount=$this->getDBSingleResult($query,$params);
		$orders = $ordersCount['nr_comenzi'];
		return $orders;		
	}

	function getUserTotalTickets($id_user)
	{
		$query = "SELECT COUNT(id_rezervare) AS nr_rezervari FROM comenzi_bilete WHERE id_user=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);					
		
		$ticketsCount=$this->getDBSingleResult($query,$params);
		$tickets = $ticketsCount['nr_rezervari'];
		return $tickets;		
	}

	function updateUserInfo($id_user, $nume, $prenume, $email, $parola)
	{
		$query = "UPDATE utilizatori SET nume=?, prenume=?, email=?, parola=? WHERE id_user=?";
		$parola = password_hash($parola, PASSWORD_DEFAULT);
		$params = array(
			array("param_type" => "s", "param_value" => $nume),
			array("param_type" => "s", "param_value" => $prenume),
			array("param_type" => "s", "param_value" => $email),
			array("param_type" => "s", "param_value" => $parola),
			array("param_type" => "i", "param_value" => $id_user)
				);
		
		$this -> updateDB($query, $params);	
	}
}

?>