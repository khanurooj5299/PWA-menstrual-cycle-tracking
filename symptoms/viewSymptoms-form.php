<?php
session_start();
$user = $_SESSION['name'];
$greeting = "hello $user!"; 
echo <<<_END
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>VIEW SYMPTOMS FORM</title>
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
			div>div{
				cursor:pointer;
			}
		</style>
	</head>
	<body id="container">
		<div class="topnav">
			<span class="close" style="cursor:pointer" onclick="document.location.href='selection.php'"><b>X</b></span>
			<span class='click'  style="float:right" onclick="document.location.href='destroy.php'">Logout</span>
		</div>
		<div class='card'>$greeting</div>
		<form method="post" action="viewSymptoms-data.php" id="form">
		<div class='card'>
			Select the cycle day for which you want to display all logged data :
			<select id='list' oninput="redirect()" name='list'>
			<option></option>   <!so that it doesn't select option 1 by default>
			</select>
		</div>
		</form>
		<div>
		<form method="post" id="statistics">
		<input type="hidden" name="cycle_length" id="cl">
		</form>
		<div class='card' onclick="go_to_statistics(this)">
		Statistics for Feelings
		</div>
		<div class='card' onclick="go_to_statistics(this)">
		Statistics for Symptoms
		</div>
		<div class='card' onclick="go_to_statistics(this)">
		Statistics for Flow
		</div>
		<div class='card' onclick="go_to_statistics(this)">
		Statistics for Discharge
		</div>
		</div>
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	<script type="text/javascript" src="../js/dates.js"></script>
	<script type="text/javascript">
	//adding options to drop down menu
		var list = document.getElementById('list');
		var min = 1 ,max = cl;   //cl is already defines in dates.js
		for(var i=min ; i<=max ; i++)
		{
			var opt = document.createElement('option');
			opt.value = i;
			opt.innerHTML = i;
			list.appendChild(opt);
		}
		
	//function for redirecting to page which will display data for selected cycle day
		function redirect()
		{
			document.getElementById('form').submit();
		}
		
	//function for redirecting to selected statistics page
		function go_to_statistics(div)
		{	
			document.getElementById("cl").setAttribute("value",cl);  //cl is already defined in dates.js
			
			if(div.innerHTML.includes("Feelings"))
				document.getElementById("statistics").setAttribute("action","feelings-stat.php");
			else if (div.innerHTML.includes("Symptoms"))
				document.getElementById("statistics").setAttribute("action","symptoms-stat.php");
			else if (div.innerHTML.includes("Flow"))
				document.getElementById("statistics").setAttribute("action","flow-stat.php");
			else 
				document.getElementById("statistics").setAttribute("action","discharge-stat.php");
			
			document.getElementById('statistics').submit();
		}
	</script>
	</html>
_END;
?>