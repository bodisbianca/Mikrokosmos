<?php 
require_once "../db/DBController.php";

class ConcerteAdmin extends DBController 
{

    /* STADIOANE */
    function getAllStadiums()
    {
        $query = "SELECT * FROM stadioane";

        $result=$this->getDBResult($query);
		return $result;
    }
    function addNewStadium($denumire, $oras)
    {
        $query = "INSERT INTO stadioane (denumire, oras) VALUES (?, ?)";

        $params = array(
            array("param_type" => "s", "param_value" => $denumire),
            array("param_type" => "s", "param_value" => $oras)
        );
        $this -> updateDB($query, $params);
    }
    function getLastInsertedStadiumId()
    {
        $query = "SELECT id_stadion FROM stadioane ORDER BY id_stadion DESC LIMIT 1;";

        $result=$this->getDBSingleResult($query);
		return $result['id_stadion'];
    }
    function getStadiumById($id_stadion)
    {
        $query = "SELECT * FROM stadioane WHERE id_stadion =?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_stadion)
        );
        $result=$this->getDBSingleResult($query, $params);
        return $result;
    }
    function updateStadiumDetails($id_stadion, $denumire, $oras)
    {
        $query = "UPDATE stadioane SET denumire=?, oras=? WHERE id_stadion=?";

        $params = array(
            array("param_type" => "s", "param_value" => $denumire),
            array("param_type" => "s", "param_value" => $oras),
            array("param_type" => "i", "param_value" => $id_stadion)
        );
        $this->updateDB($query, $params);
    }
    function deleteStadium($id_stadion)
    {
        $query = "DELETE FROM stadioane WHERE id_stadion = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_stadion)
        );

        $this -> updateDB($query,$params); 
    }
    function insertNewStadiumSection($id_stadion, $zona, $cod_alfa, $cod_num, $orientare, $randuri, $coloane, $locuri)
    {
        if(empty($locuri))
        {
            if($coloane!=0 && $randuri !=0)
                {$locuri = $randuri * $coloane;}
            else return 0; //daca nu sunt introduse randuri si coloane si nici locuri, nu se poate insera sectiunea
        }
        else 
        {
            if(($coloane!=0 && $randuri !=0) && ($locuri != $randuri * $coloane))
                {$locuri = $randuri * $coloane;}
        }

        if(($randuri == 0 && $coloane != 0) || ($randuri != 0 && $coloane == 0) )
            {return -1;} //daca randurile si coloanele vin in perechi. daca unul e 0 si celalalt nu e, nu se poate insera sectiunea
        
        $query = "INSERT INTO sectionare_stadion (id_stadion, zona, cod_alfa, cod_num, orientare, randuri, coloane, locuri) VALUES (?,?,?,?,?,?,?,?)";

        $params = array(
            array("param_type" => "i", "param_value" => $id_stadion),
            array("param_type" => "s", "param_value" => $zona),
            array("param_type" => "s", "param_value" => $cod_alfa),
            array("param_type" => "i", "param_value" => $cod_num),
            array("param_type" => "s", "param_value" => $orientare),
            array("param_type" => "i", "param_value" => $randuri),
            array("param_type" => "i", "param_value" => $coloane),
            array("param_type" => "i", "param_value" => $locuri)
        );
        $this -> updateDB($query, $params);
        return 1; //inserare realizata cu succes
    }
    function updateStadiumSection($id_stadion, $id_sectiune, $zona, $cod_alfa, $cod_num, $orientare, $randuri, $coloane, $locuri)
    {
        if(empty($locuri))
        {
            if($coloane!=0 && $randuri !=0)
                {$locuri = $randuri * $coloane;}
            else return 0; //daca nu sunt introduse randuri si coloane si nici locuri, nu se poate actualiza sectiunea
        }
        else 
        {
            if(($coloane!=0 && $randuri !=0) && ($locuri != $randuri * $coloane))
                {$locuri = $randuri * $coloane;}
        }

        if(($randuri == 0 && $coloane != 0) || ($randuri != 0 && $coloane == 0) )
            {return -1;} //daca randurile si coloanele vin in perechi. daca unul e 0 si celalalt nu e, nu se poate actualiza sectiunea

        $query = "UPDATE sectionare_stadion SET zona=?, cod_alfa=?, cod_num=?, orientare=?, randuri=?, coloane=?, locuri=? WHERE id_stadion=? AND id_sectiune=?";
		
        $params = array(
			array("param_type" => "s", "param_value" => $zona),
			array("param_type" => "s", "param_value" => $cod_alfa),
			array("param_type" => "i", "param_value" => $cod_num),
			array("param_type" => "s", "param_value" => $orientare),
			array("param_type" => "i", "param_value" => $randuri),
            array("param_type" => "i", "param_value" => $coloane),
            array("param_type" => "i", "param_value" => $locuri),
            array("param_type" => "i", "param_value" => $id_stadion),
            array("param_type" => "i", "param_value" => $id_sectiune)
				);
		
		$this -> updateDB($query, $params);
        return 1; //actualizare realizata cu succes
    }
    function deleteStadiumSection($id_stadion, $id_sectiune)
    {
        $query = "DELETE FROM sectionare_stadion WHERE id_stadion = ? AND id_sectiune = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_stadion),
            array("param_type" => "i", "param_value" => $id_sectiune)
        );

        $this -> updateDB($query,$params); 
    }
    function getStadiumCapacity($id_stadion)
    {
        $query = "SELECT SUM(locuri) AS capacitate FROM sectionare_stadion WHERE id_stadion=?";
        $params = array(
            array("param_type" => "s", "param_value" => $id_stadion)
        );
        $result=$this->getDBSingleResult($query, $params);
        return $result['capacitate'];
    }


    /* CONCERTE */
    function getAllConcerts()
    {
        $query = "SELECT concerte.*, stadioane.id_stadion AS stadionID, stadioane.denumire AS stadion, stadioane.oras AS oras FROM concerte JOIN stadioane ON concerte.id_stadion = stadioane.id_stadion";

        $concertsResult=$this->getDBResult($query);
		return $concertsResult;
    }
    function getConcertDetails($id_concert)
    {
        $query = "SELECT concerte.*, 
                            stadioane.id_stadion AS stadionID, stadioane.denumire AS stadion, stadioane.oras AS oras 
                    FROM concerte JOIN stadioane ON concerte.id_stadion = stadioane.id_stadion
                    WHERE id_concert = ?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_concert)
        );

        $concertResult=$this->getDBSingleResult($query,$params);
        return $concertResult;
    }
    function insertNewConcert($id_stadion, $nume_concert, $poster, $data, $ora, $durata)
    {
        $data = date('Y-m-d', strtotime ($data));
        $ora = date('H:i', strtotime ($ora));
        
        $query = "INSERT INTO concerte (id_stadion, nume_concert, poster,"." data, ora, durata)
        VALUES ('".$id_stadion."','".$nume_concert."','".$poster."','".$data."','".$ora."','".$durata."')";

        $this -> updateDB($query);
    }
    function getLastInsertedConcertId()
    {
        $query = "SELECT id_concert FROM concerte ORDER BY id_concert DESC LIMIT 1;";

        $result=$this->getDBSingleResult($query);
		return $result['id_concert'];
    }
    function updateConcert($id_concert, $id_stadion, $nume_concert, $poster, $data, $ora, $durata)
    {
        $data = date('Y-m-d', strtotime ($data));
        $ora = date('H:i', strtotime ($ora));

        $query = "UPDATE concerte SET id_stadion=?, nume_concert=?, poster=?, data=?, ora=?, durata=? 
                WHERE id_concert=?";
		
        $params = array(
			array("param_type" => "i", "param_value" => $id_stadion),
			array("param_type" => "s", "param_value" => $nume_concert),
			array("param_type" => "s", "param_value" => $poster),
			array("param_type" => "s", "param_value" => $data),
			array("param_type" => "s", "param_value" => $ora),
            array("param_type" => "i", "param_value" => $durata),
            array("param_type" => "i", "param_value" => $id_concert)
				);
		
		$this -> updateDB($query, $params);
    }
    function deleteConcert($id_concert)
    {
        $query = "DELETE FROM concerte WHERE id_concert = ?";

        $params = array(
        array("param_type" => "i", "param_value" => $id_concert)
        );

        $this -> updateDB($query,$params);
    }

    function getConcertSeatsNumber ($id_concert)
    {
        $query = "SELECT SUM(locuri) AS nr_locuri FROM sectionare_stadion 
                    JOIN tarife_concerte ON sectionare_stadion.id_sectiune = tarife_concerte.id_sectiune 
                    WHERE tarife_concerte.id_concert = ?";
        
        $params = array(
            array("param_type" => "i", "param_value" => $id_concert)
        );

        $result=$this->getDBSingleResult($query,$params);
        return $result['nr_locuri'];
    
    }
    function getConcertBookedTickets ($id_concert)
    {
        $query="SELECT COUNT(id_rezervare) AS locuri_rezervate FROM comenzi_bilete WHERE id_concert=?";

        $params = array(
            array("param_type" => "i", "param_value" => $id_concert)
        );

        $result=$this->getDBSingleResult($query,$params);
        return $result['locuri_rezervate'];

    }

}
?>