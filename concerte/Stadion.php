<?php 
require_once "../db/DBController.php";

class Stadion extends DBController 
{
	/* PENTRU ADMIN */
	function getStadiumDetails($id_stadion)
    {
        $query = "SELECT * FROM stadioane WHERE id_stadion = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_stadion)
        );
        
        $result=$this->getDBSingleResult($query,$params);
		return $result;
    }
	
	function getStadiumSections($id_stadion)
	{
		$query = "SELECT id_sectiune, zona, cod_alfa, cod_num, orientare, randuri, coloane, locuri 
				FROM sectionare_stadion 
				WHERE sectionare_stadion.id_stadion=? AND id_sectiune = ?";

		$params = array(
			array("param_type" => "i", "param_value" => $id_stadion),
			array("param_type" => "i", "param_value" => $id_sectiune)
		);

		$sectionResult=$this->getDBSingleResult($query,$params);
		return $sectionResult;
	}

	function getStadiumSectionById($id_stadion, $id_sectiune)
	{
		$query = "SELECT * FROM sectionare_stadion WHERE id_stadion =? AND id_sectiune=?";

		$params = array(
			array("param_type" => "i", "param_value" => $id_stadion),
			array("param_type" => "i", "param_value" => $id_sectiune)
		);

		$sectionResult=$this->getDBSingleResult($query,$params);
		return $sectionResult;
	}






	/* UTILIZATORI SI ADMINI */
	function getAllSections()
	{
		$query = "SELECT * FROM sectionare_stadion";
		
		$sectionResult=$this->getDBResult($query);
		return $sectionResult;
	}

	function getAreaSections($punct_cardinal, $id_stadion) 
	{
		$query = "SELECT id_sectiune, cod_num, cod_alfa FROM sectionare_stadion WHERE orientare=? AND id_stadion=? ";

		$params = array(
					array("param_type" => "s", "param_value" => $punct_cardinal),
					array("param_type" => "i", "param_value" => $id_stadion)
				);

		$sectionResult=$this->getDBResult($query,$params);
		return $sectionResult;
	}

	function getSectionDetails($id_sectiune, $id_concert)
	{
		$query = "SELECT pret, 
						sectionare_stadion.id_sectiune, sectionare_stadion.zona, sectionare_stadion.cod_alfa, sectionare_stadion.cod_num, orientare, zona, randuri, coloane,locuri 
					FROM tarife_concerte 
					JOIN sectionare_stadion ON tarife_concerte.id_sectiune = sectionare_stadion.id_sectiune 
					WHERE sectionare_stadion.id_sectiune =? AND tarife_concerte.id_concert=?";

		$params = array(
				array("param_type" => "i", "param_value" => $id_sectiune),
				array("param_type" => "i", "param_value" => $id_concert)
			);

		$sectionResult=$this->getDBSingleResult($query,$params);
		return $sectionResult;
	}

	function getNotPricedSection ($id_sectiune)
	{
		$query = "SELECT *	FROM sectionare_stadion WHERE id_sectiune =?";

		$params = array(
				array("param_type" => "i", "param_value" => $id_sectiune)
				);

		$sectionResult=$this->getDBSingleResult($query,$params);
		return $sectionResult;
	}

	function getSectionTicketDetails($id_concert)
	{
		$query = "SELECT pret, sectionare_stadion.zona, sectionare_stadion.cod_alfa, sectionare_stadion.cod_num 
					FROM tarife_concerte 
					JOIN sectionare_stadion ON tarife_concerte.id_sectiune = sectionare_stadion.id_sectiune 
					WHERE tarife_concerte.id_concert =?";

		$params = array(
					array("param_type" => "i", "param_value" => $id_concert)
				);

		$sectionResult=$this->getDBResult($query,$params);
		return $sectionResult;
	}

	function checkUnavailableSeats ($id_sectiune, $id_concert)
	{
		$query = "SELECT loc FROM comenzi_bilete WHERE id_concert = ? AND id_sectiune = ?";
		$params = array (
			array("param_type" => "i", "param_value" => $id_concert),
			array("param_type" => "i", "param_value" => $id_sectiune)
		);
		$seatsResult=$this->getDBResult($query,$params);
		if(!empty($seatsResult))
		{
			$seatsResult = array_column($seatsResult, 'loc'); /* converteste din array of arrays intr-un array simplu */
		}
		return $seatsResult;
	}

	function updateSectionTicketPrice ($id_concert, $id_sectiune, $pret)
	{
		$query = "UPDATE tarife_concerte SET pret=? WHERE id_concert =? AND id_sectiune=?";

		$params = array (
					array("param_type" => "d", "param_value" => $pret),
					array("param_type" => "i", "param_value" => $id_concert),
					array("param_type" => "i", "param_value" => $id_sectiune)
				);
		
		$this -> updateDB($query, $params);	
	}

	function setSectionTicketPrice ($id_concert, $id_sectiune, $pret)
	{
		$query = "INSERT INTO tarife_concerte(id_concert, id_sectiune, pret) VALUES (?, ?, ?)";

		$params = array (
					array("param_type" => "i", "param_value" => $id_concert),
					array("param_type" => "i", "param_value" => $id_sectiune),
					array("param_type" => "d", "param_value" => $pret)
				);
		
		$this -> updateDB($query, $params);	
	}

}
?>