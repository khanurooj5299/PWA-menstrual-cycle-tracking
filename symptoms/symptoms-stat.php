<?php
session_start();
require_once 'functions.php';
$username = $_SESSION['user'];
$user = $_SESSION['name'];
$greeting = "hello $user!"; 

$symptoms = ['Cramps','Nausea','Headache','Bloating','Cravings','Insomnia','Acne','Lowerback Pain','Tender Breasts'];
/* yMatrix has a row for each symptom.
in each row there is a column for each cycle day.
any cell indicates the number of entries in DB for a particular symptom and a particular cycle day */
$yMatrix = array();

//loop to iterate over each symptom
for($i=0 ; $i<sizeof($symptoms) ; $i++)
{
	$symptom = $symptoms[$i];
	//loop for each cycle day
	for($j=0 ; $j<$_POST[cycle_length] ; $j++)
	{	//getting all rows for jth cycle day where ith symptom is present
		$cd = $j+1;
		$query = "SELECT * FROM $username where cycle_day='$cd' AND symptoms LIKE '%$symptom%'";
		$result = queryMySQL($query);
		
		//putting the number in yMatrix
		$yMatrix[$i][$j] = $result->num_rows;
	}
}
$yMatrix = json_encode($yMatrix);
echo <<<_END
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SYMPTOM</title>
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
		</style>
	</head>
	<body id="container">
		<div class="topnav">
			<span class="close" style="cursor:pointer" onclick="document.location.href='viewSymptoms-form.php'"><b>X</b></span>
			<span class='click'  style="float:right" onclick="document.location.href='destroy.php'">Logout</span>
		</div>
		<div class='card'>$greeting</div>
		<div class='card'>
		<canvas id='graph'>
		</canvas>
		</div>
		<div class='card'>
		Tip : hover over the data points to view information for overlapping plots
		</div>
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	<script type="text/javascript" src="../js/dates.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
	//link to the providing content delivery network for Charts.js library
	</script>
	
	<script type="text/javascript"> 
	
	//creating array for x axis . Elements are 1 to cycle_length
	var xValues = Array.from({length: cl}, (_,index)=>index+1);
	
	//creating graph
	var graph = new Chart("graph" , {
		type: "line",
		data : {
			labels : xValues,
			datasets : [
			]
		},
		options: {
			legend:{display:true},
			scales: {
				xAxes : [{scaleLabel :{display : true , labelString : 'Cycle Day'}}]
			}
		}
	});
	
	//pushing all datasets to the graph data
	var yMatrix = JSON.parse('$yMatrix');

	//add more colors here if more symptoms are added
	var colors = ['red','blue','green','black','white','yellow','orange','purple','cyan'];
	
	//normalizing the y values for each symptom between 0 and 1
	for(i=0; i<yMatrix.length ; i++)
	{
		var max = Math.max.apply(Math,yMatrix[i]);
		var min = 0;
		for(j=0; j<cl ;j++)
		{
			yMatrix[i][j] = (yMatrix[i][j] - min) / (max - min);
		}
	}
	
	var symptoms = ['Cramps','Nausea','Headache','Bloating','Cravings','Insomnia','Acne','Lowerback Pain','Tender Breasts'];
	
	for(i=0; i< yMatrix.length ; i++)
	{
		graph.data.datasets.push(
		{	
			label: symptoms[i],
			data : yMatrix[i],
			borderColor : colors[i],
			backgroundColor : colors[i],
			fill : false 
		}
		);
	}
	graph.update();
	
	</script>
	</html>
_END;
?>