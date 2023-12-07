<?php
session_start();
require_once 'functions.php';
$user = $_SESSION['name'];
$greeting = "hello $user!";
echo <<<_END
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Selection</title>
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
		</style>
	</head>
	<body id="container">
		<div class="topnav">
			<button class="close"  onclick="document.location.href='../menu.html'"><b>X</b></button>
		</div>
		<div class='card'>$greeting</div>
		<div class='card click' onclick="document.location.href='logSymptoms.php'">
			Log Symptoms for today's cycle day
		</div>
		<div class='card click' onclick="document.location.href='viewSymptoms-form.php'">
			View Symptoms
		</div>
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	</html>
_END;
?>