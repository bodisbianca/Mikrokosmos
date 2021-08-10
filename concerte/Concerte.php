<?php 
require_once "../db/DBController.php";

class Concerte extends DBController 
{

    function getAllConcerts()
    {
        $query = "SELECT concerte.*, stadioane.denumire AS stadion, stadioane.oras AS oras FROM concerte JOIN stadioane ON concerte.id_stadion = stadioane.id_stadion";

        $concertsResult=$this->getDBResult($query);
		return $concertsResult;
    }

    function getConcertDetails($id_concert)
    {
        $query = "SELECT concerte.*, 
                            stadioane.denumire AS stadion, stadioane.oras AS oras 
                    FROM concerte JOIN stadioane ON concerte.id_stadion = stadioane.id_stadion
                    WHERE id_concert = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_concert)
        );

    $concertResult=$this->getDBSingleResult($query,$params);
    return $concertResult;
    }

}
?>