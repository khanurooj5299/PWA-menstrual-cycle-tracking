<?php
session_start();
require_once 'functions.php';
$user = $_SESSION['name'];
$greeting = "hello $user!";
if (isset($_POST['Happy']))  //form has been submitted;Data should be saved
{
//creating a table with name=username to store users data
	$username = $_SESSION['user']; //getting the username
	$query = "CREATE TABLE IF NOT EXISTS $username(date DATE NOT NULL PRIMARY KEY, cycle_day INT NOT NULL, 
				feelings VARCHAR(200), symptoms VARCHAR(200),flow VARCHAR(200), discharge VARCHAR(200))";
	queryMySQL($query);
//storing data in the table
	//making comma separated concatenated string for each category. Comma separation will later help in exploding
	$string_for_feelings = $_POST['Happy'].",".$_POST['Emotional'].",".$_POST['Stressed'].",".$_POST['Calm'].",".$_POST['Tired'].",".
						   $_POST['Irritated'].",".$_POST['Mood Swings'].",".$_POST['Sad'];
	$string_for_symptoms = $_POST['Cramps'].",".$_POST['Nausea'].",".$_POST['Headache'].",".$_POST['Bloating'].",".$_POST['Cravings'].",".
						   $_POST['Insomnia'].",".$_POST['Acne'].",".$_POST['Lowerback Pain'].",".$_POST['Tender Breasts'];
	$string_for_flow     = $_POST['Light'].",".$_POST['Medium'].",".$_POST['Heavy'].",".$_POST['Crime Scene'];
	$string_for_discharge = $_POST['White Discharge'].",".$_POST['Clear Discharge'].",".$_POST['Spotting'];
	$cycle_day = (int)$_POST['cycle_day'];
	$date = $_POST['date'];
	
	//ON DUPLICATE KEY UPDATE IS USED because data for each user is stored on the basis of date
	//if user tries to enter symptoms for the same date again....the row in table will simply be overwritten
	//No new row created
	$query = "INSERT INTO $username(date,cycle_day,feelings,symptoms,flow,discharge) 
			VALUES('$date','$cycle_day','$string_for_feelings','$string_for_symptoms','$string_for_flow'
			,'$string_for_discharge')
			ON DUPLICATE KEY UPDATE date='$date',cycle_day='$cycle_day',feelings='$string_for_feelings',
			symptoms='$string_for_symptoms',flow='$string_for_flow',discharge='$string_for_discharge'";
	queryMySQL($query);
	$success = "alert(\"Symptoms Logged Successfully!\");";
}
echo <<<_END
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>LOG SYMPTOMS</title>
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
			button{
				border:none;
				box-shadow: 0px 3px 3px rgba(0,0,0,.25), 0px 4px 6px rgba(0,0,0,.1);
				background-image:linear-gradient(to right,#fee4e2,#fee4e2);
				cursor:pointer;
				padding:10px;
				font-family : "cursive","condensed";
		</style>
	</head>
	<body id="container">
		<div class="topnav">
			<span class="close" style="cursor:pointer" onclick="document.location.href='selection.php'"><b>X</b></span>
			<span class='click'  style="float:right" onclick="document.location.href='destroy.php'">Logout</span>
		</div>
		<div class='card'>$greeting</div>
		<form method="POST" action="logSymptoms.php">
		<div class="card">
			How are you feeling ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='Happy'>Happy</button><input type="hidden" name="Happy" value="" id="Happy">
			<button type='button' onclick='button_clicked(this)' value='Emotional'>Emotional</button><input type="hidden" name="Emotional" value="" id="Emotional">
			<button type='button' onclick='button_clicked(this)' value='Stressed'>Stressed</button><input type="hidden" name="Stressed" value="" id="Stressed">
			<button type='button' onclick='button_clicked(this)' value='Calm'>Calm</button><input type="hidden" name="Calm" value="" id="Calm">
			<button type='button' onclick='button_clicked(this)' value='Tired'>Tired</button><input type="hidden" name="Tired" value="" id="Tired">
			<button type='button' onclick='button_clicked(this)' value='Irritated'>Irritated</button><input type="hidden" name="Irritated" value="" id="Irritated">
			<button type='button' onclick='button_clicked(this)' value='Mood Swings'>Mood Swings</button><input type="hidden" name="Mood Swings" value="" id="Mood Swings">
			<button type='button' onclick='button_clicked(this)' value='Sad'>Sad</button><input type="hidden" name="Sad" value="" id="Sad">
		</div>
		<div class="card"> <br>
			Experiencing any Symptoms ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='Cramps'>Cramps</button><input type="hidden" name="Cramps" value="" id="Cramps">
			<button type='button' onclick='button_clicked(this)' value='Nausea'>Nausea</button><input type="hidden" name="Nausea" value="" id="Nausea">
			<button type='button' onclick='button_clicked(this)' value='Headache'>Headache</button><input type="hidden" name="Headache" value="" id="Headache">
			<button type='button' onclick='button_clicked(this)' value='Bloating'>Bloating</button><input type="hidden" name="Bloating" value="" id="Bloating">
			<button type='button' onclick='button_clicked(this)' value='Cravings'>Cravings</button><input type="hidden" name="Cravings" value="" id="Cravings">
			<button type='button' onclick='button_clicked(this)' value='Insomnia'>Insomnia</button><input type="hidden" name="Insomnia" value="" id="Insomnia">
			<button type='button' onclick='button_clicked(this)' value='Acne'>Acne</button><input type="hidden" name="Acne" value="" id="Acne">
			<button type='button' onclick='button_clicked(this)' value='Lowerback Pain'>Lowerback Pain</button><input type="hidden" name="Lowerback Pain" value="" id="Lowerback Pain">
			<button type='button' onclick='button_clicked(this)' value='Tender Breasts'>Tender Breasts</button><input type="hidden" name="Tender Breasts" value="" id="Tender Breasts">
		</div>
		<div class="card">
			How heavy is your flow ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='Light'>Light</button><input type="hidden" name="Light" value="" id="Light">
			<button type='button' onclick='button_clicked(this)' value='Medium'>Medium</button><input type="hidden" name="Medium" value="" id="Medium">
			<button type='button' onclick='button_clicked(this)' value='Heavy'>Heavy</button><input type="hidden" name="Heavy" value="" id="Heavy">
			<button type='button' onclick='button_clicked(this)' value='Crime Scene'>Crime Scene</button><input type="hidden" name="Crime Scene" value="" id="Crime Scene">
		</div>
		<div class="card">
			Did you have any discharge ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='White Discharge'>White Discharge</button><input type="hidden" name="White Discharge" value="" id="White Discharge">
			<button type='button' onclick='button_clicked(this)' value='Clear Discharge'>Clear Discharge</button><input type="hidden" name="Clear Discharge" value="" id="Clear Discharge">
			<button type='button' onclick='button_clicked(this)' value='Spotting'>Spotting</button><input type="hidden" name="Spotting" value="" id="Spotting">
		</div>
		<input type='hidden' name='cycle_day' value='' id='cycle_day'>
		<input type='hidden' name='date' value='' id='date'>
		<center><input type="submit" value="Done!" class="click" id="done"></center>
		</form>
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	<script type="text/javascript" src="../js/dates.js"></script>
	<script type="text/javascript">
	$success;
	function button_clicked(button)
	{
		var border = button.style.border;
		//checking if the button was selected or un-selected before clicking
		if(button.style.border == "" || button.style.border == "none")
			button_select(button);
		else
			button_deselect(button);
	}
	function button_select(button)
	{
		button.style.backgroundImage = "linear-gradient(to right,#7CFC00,#7CFC00)";
		button.style.border = "2px solid black";
		var name = button.value;
		document.getElementById(name).setAttribute("value",name);
	}
	function button_deselect(button)
	{
		button.style.backgroundImage = "linear-gradient(to right,#fee4e2,#fee4e2)";
		button.style.border = "none";
		var name = button.value;
		document.getElementById(name).setAttribute("value","");
	}
	//setting size for buttons
	all_buttons = document.getElementsByTagName('button');
	submit = document.getElementById("done");
	if(w>h)
	{//w and h are already defined in size.js
		submit.setAttribute("style","font-size:3vw");
		for(i=0 ; i<all_buttons.length ; i++)
				all_buttons[i].setAttribute("style","height:10vw;width:10vw;border-radius:5vw;font-size:1.5vw");
	}
	else
	{	submit.setAttribute("style","font-size:3vh");
		for(i=0 ; i<all_buttons.length ; i++)
				all_buttons[i].setAttribute("style","height:10vh;width:10vh;border-radius:5vh;font-size:1.5vh");
	}
	
	//setting hidden fields cycle_day and date
	document.getElementById('cycle_day').setAttribute('value',c_d); //c_d is defined in dates.js
	var date = String(t.getFullYear())+"-"+String((t.getMonth()+1))+"-"+String(t.getDate());
	document.getElementById('date').setAttribute('value',date);
	</script>
	</html>
_END;
?>