<?php
session_start();
require_once 'functions.php';
$username = $_SESSION['user'];
$user = $_SESSION['name'];
$greeting = "hello $user!"; 
$cd = (int)$_POST['list']; //cycle day for which data is to be displayed
$query = "SELECT * FROM $username where cycle_day='$cd'";
$result = queryMySQL($query);
echo <<<_END
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>VIEW SYMPTOMS</title>
		<link rel="stylesheet" href="../css/topnav.css" type="text/css">
		<link rel="stylesheet" href="../css/background.css" type="text/css">
		<link rel="stylesheet" href="../css/card.css" type="text/css">
		<link rel="stylesheet" href="../css/click.css" type="text/css">
		<style type="text/css">
			body{	
					padding:2vh 4vw 2vh 4vw;
			}
			.card{
				padding:0.1vh 2vw 2vh 2vw;
				margin-bottom:2vh;
			}
			.click{
				background-image:linear-gradient(to right,#7CFC00,#7CFC00);
			}
			table{
				table-layout:fixed;
				width:100%;
				padding:0;
				margin-top:4px;
			}
			th{
				border-bottom:1px solid white;
				border-left:1px solid white;
			}
			td{
				border-bottom: 1px solid white;
			}
			ul{
				margin:0;
				padding:0;
				list-style-type:none;
			}
		</style>
	</head>
	<body id="container">
		<div class="topnav">
			<span class="close" style="cursor:pointer" onclick="document.location.href='viewSymptoms-form.php'"><b>X</b></span>
			<span class='click'  style="float:right" onclick="document.location.href='destroy.php'">Logout</span>
		</div>
		<div class='card'>$greeting<br>Viewing logged data for cycle day : $cd</div>
		<div class="card">
_END;
if($result->num_rows > 0)
{
	echo "<table> <tr>";
	//displaying the column headers
	while($col = $result->fetch_field())
	{
		$col_name = $col->name;
		if($col_name=="cycle_day")
			continue;
		echo "<th>$col_name</th>";
	}
	echo "</tr>";
	//displaying the rows
	$num_fields = mysqli_num_fields($result);
	//loop for each row
	while($row = $result->fetch_array(MYSQLI_NUM))
	{   
		echo "<tr>";
		//loop for each column of a row
		for($i=0 ; $i<$num_fields ; $i++)
		{
			if($i==1)
				continue;
			$list = explode(',',$row[$i]);   //getting a list where each element is a word
			echo "<td><ul>";
			//loop for each word in a column of a row
			for($j=0 ; $j<sizeof($list) ; $j++)
			{	if($list[0]=="")
					continue;
				echo "<li>~$list[$j]</li>";
			}
			echo "</ul></td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}
else
	echo "No data avaliable for this cycle day!";
echo <<<_END
		</div>
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	<script type="text/javascript" src="../js/dates.js"></script>
	<script type="text/javascript">
	
	</script>
	</html>
_END;
?>