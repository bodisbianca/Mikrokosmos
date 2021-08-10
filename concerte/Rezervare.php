<?php

require_once "../db/DBController.php";

class Rezervare extends DBController
{

    function getTicketOrder($id_user)
	{
		$query = "SELECT id_concert, id_sectiune, loc FROM cos_bilete WHERE id_user=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);					
		
		$ticketResult=$this->getDBResult($query,$params);
		return $ticketResult;		
	}

    /* toate detaliile despre biletele selectate*/
    function getUserCartTicket($id_user)
	{
		$query = "SELECT DISTINCT concerte.nume_concert, concerte.poster, concerte.id_concert,
						cos_bilete.id_cos AS id_cos, cos_bilete.loc, 
                        stadioane.denumire AS stadion, stadioane.oras AS oras,
                        sectionare_stadion.zona, sectionare_stadion.cod_num, sectionare_stadion.cod_alfa, sectionare_stadion.orientare,
						tarife_concerte.pret
                        FROM concerte
						JOIN cos_bilete ON concerte.id_concert = cos_bilete.id_concert
                        JOIN stadioane ON stadioane.id_stadion = concerte.id_stadion
                        JOIN sectionare_stadion ON sectionare_stadion.id_sectiune = cos_bilete.id_sectiune
						JOIN tarife_concerte ON cos_bilete.id_concert = tarife_concerte.id_concert
                        WHERE tarife_concerte.id_sectiune = cos_bilete.id_sectiune AND cos_bilete.id_user=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
						);
		$cartResult = $this->getDBResult($query,$params);
		return $cartResult;
	}

    function addTicketToCart($id_concert, $id_sectiune, $loc, $id_user)
	{
		$query = "INSERT INTO cos_bilete(id_user, id_concert, id_sectiune, loc) VALUES (?,?,?,?)";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_user),
					array("param_type" => "i", "param_value" => $id_concert),
					array("param_type" => "i", "param_value" => $id_sectiune),
                    array("param_type" => "s", "param_value" => $loc)
					);
		$this -> updateDB($query, $params);
	}

    function deleteCartTicket($id_cos)
	{
		$query="DELETE FROM cos_bilete WHERE id_cos=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_cos)
					);
		$this -> updateDB($query, $params);
	}
	
	function emptyCart($id_user)
	{
		$query="DELETE FROM cos_bilete WHERE id_user=?";
		
		$params = array(
					array("param_type" => "i", "param_value" => $id_user)
					);
		$this -> updateDB($query, $params);
	}

    function bookTickets($id_user, $id_concert, $id_sectiune, $loc)
    {
        $query = "INSERT INTO comenzi_bilete(id_user, id_concert, id_sectiune, loc) VALUES (?,?,?,?)";
		$params = array(
                    array("param_type" => "i", "param_value" => $id_user),
                    array("param_type" => "i", "param_value" => $id_concert),
                    array("param_type" => "i", "param_value" => $id_sectiune),
                    array("param_type" => "s", "param_value" => $loc)					
					);
		$this -> updateDB($query, $params);	
		
		$query2 = "DELETE FROM cos_bilete WHERE id_user=?";
		$params2 = array(
					array("param_type" => "i", "param_value" => $id_user)
					);
		$this -> updateDB($query2, $params2);
    }

	function getBookedTickets($id_user)
	{
		$query = "SELECT concerte.nume_concert, concerte.poster, concerte.data, concerte.ora, concerte.durata,
						comenzi_bilete.loc, comenzi_bilete.id_rezervare, comenzi_bilete.id_concert, comenzi_bilete.data AS data_rezervare,
						stadioane.denumire AS stadion, stadioane.oras AS oras,
						sectionare_stadion.zona, sectionare_stadion.cod_num, sectionare_stadion.cod_alfa, sectionare_stadion.orientare,
						tarife_concerte.pret
				FROM concerte
				JOIN comenzi_bilete ON concerte.id_concert = comenzi_bilete.id_concert
				JOIN stadioane ON stadioane.id_stadion = concerte.id_stadion
				JOIN sectionare_stadion ON sectionare_stadion.id_sectiune = comenzi_bilete.id_sectiune
				JOIN tarife_concerte ON comenzi_bilete.id_concert = tarife_concerte.id_concert
				WHERE tarife_concerte.id_sectiune = comenzi_bilete.id_sectiune AND comenzi_bilete.id_user=?
				ORDER BY comenzi_bilete.data DESC";
		
		$params = array(
			array("param_type" => "i", "param_value" => $id_user)
				);
		$bookedTicketsResult = $this->getDBResult($query,$params);
		return $bookedTicketsResult;

	}

	function getBookedTicketPDF($id_rezervare)
	{
		$query = "SELECT concerte.id_concert, concerte.nume_concert, concerte.poster, concerte.data, concerte.ora,
						comenzi_bilete.loc,
						stadioane.denumire AS stadion, stadioane.oras AS oras,
						sectionare_stadion.zona, sectionare_stadion.cod_num, sectionare_stadion.cod_alfa,sectionare_stadion.orientare,
						tarife_concerte.pret
				FROM concerte
				JOIN comenzi_bilete ON concerte.id_concert = comenzi_bilete.id_concert
				JOIN stadioane ON stadioane.id_stadion = concerte.id_stadion
				JOIN sectionare_stadion ON sectionare_stadion.id_sectiune = comenzi_bilete.id_sectiune
				JOIN tarife_concerte ON comenzi_bilete.id_concert = tarife_concerte.id_concert
				WHERE tarife_concerte.id_sectiune = comenzi_bilete.id_sectiune AND comenzi_bilete.id_rezervare=?";

		$params = array(
			array("param_type" => "i", "param_value" => $id_rezervare)
				);
		$bookedTicket = $this->getDBSingleResult($query,$params);
		return $bookedTicket;
	}

}


?>