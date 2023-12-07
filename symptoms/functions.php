<?php //file containing all data and functions needed globally
	$dbhost  = 'localhost';    
	$dbname  = 'menses'; //change to menses later  
	$dbuser  = 'urooj';   
	$dbpass  = 'saba@123';   

	$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($connection->connect_error) 
	{
		header("Location:./error.html");
		die();
	}
	
	function queryMysql($query)
	  {
		global $connection;
		$result = $connection->query($query);
		if (!$result) 
		{	
			//header("Location:./error.html");
			die($connection->error);
		}
		return $result;
	  }
	function sanitizeString($var)
	  {
		global $connection;
		$var = strip_tags($var);
		$var = htmlentities($var);
		if (get_magic_quotes_gpc())
		  $var = stripslashes($var);
		return $connection->real_escape_string($var);
	  }
?>