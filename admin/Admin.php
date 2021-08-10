<?php

require_once "../db/DBController.php";

class Admin extends DBController
{
	function getAdmin($id_admin)
	{
		$query = "SELECT * FROM administratori WHERE id_admin=?";
		$params = array(
					array("param_type" => "i", "param_value" => $id_admin)
						);					
		
		$personalInfo=$this->getDBSingleResult($query,$params);
		return $personalInfo;		
	}
}

?>