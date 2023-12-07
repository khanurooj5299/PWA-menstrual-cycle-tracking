<?php
session_start();
require_once 'functions.php';
$user = $_SESSION['name'];
$greeting = "hello $user!";
if (isset($_POST['cycle_day']))  //form has been submitted;Data should be saved
{
//creating a table with name=username to store users data
	$username = $_SESSION['user']; //getting the username
	$query = "CREATE TABLE IF NOT EXISTS $username(date DATE NOT NULL PRIMARY KEY, cycle_day INT NOT NULL, 
				feelings VARCHAR(200), symptoms VARCHAR(200),flow VARCHAR(200), discharge VARCHAR(200))";
	queryMySQL($query);
//storing data in the table
	//making comma separated concatenated string for each category. Comma separation will later help in exploding
	$string_for_feelings = rtrim($_POST['feelings'],",");
	$string_for_symptoms = rtrim($_POST['symptoms'],",");
	$string_for_flow     = rtrim($_POST['flow'],",");
	$string_for_discharge = rtrim($_POST['discharge'],",");
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
		<div class="card" id='feelings_list'>
			How are you feeling ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='Happy'>Happy</button>
			<button type='button' onclick='button_clicked(this)' value='Emotional'>Emotional</button>
			<button type='button' onclick='button_clicked(this)' value='Stressed'>Stressed</button>
			<button type='button' onclick='button_clicked(this)' value='Calm'>Calm</button>
			<button type='button' onclick='button_clicked(this)' value='Tired'>Tired</button>
			<button type='button' onclick='button_clicked(this)' value='Irritated'>Irritated</button>
			<button type='button' onclick='button_clicked(this)' value='Mood Swings'>Mood Swings</button>
			<button type='button' onclick='button_clicked(this)' value='Sad'>Sad</button>
		</div>
		<div class="card" id='symptoms_list'> <br>
			Experiencing any Symptoms ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='Cramps'>Cramps</button>
			<button type='button' onclick='button_clicked(this)' value='Nausea'>Nausea</button>
			<button type='button' onclick='button_clicked(this)' value='Headache'>Headache</button>
			<button type='button' onclick='button_clicked(this)' value='Bloating'>Bloating</button>
			<button type='button' onclick='button_clicked(this)' value='Cravings'>Cravings</button>
			<button type='button' onclick='button_clicked(this)' value='Insomnia'>Insomnia</button>
			<button type='button' onclick='button_clicked(this)' value='Acne'>Acne</button>
			<button type='button' onclick='button_clicked(this)' value='Lowerback Pain'>Lowerback Pain</button>
			<button type='button' onclick='button_clicked(this)' value='Tender Breasts'>Tender Breasts</button>
		</div>
		<div class="card" id='flow_list'>
			How heavy is your flow ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='Light'>Light</button>
			<button type='button' onclick='button_clicked(this)' value='Medium'>Medium</button>
			<button type='button' onclick='button_clicked(this)' value='Heavy'>Heavy</button>
			<button type='button' onclick='button_clicked(this)' value='Crime Scene'>Crime Scene</button>
		</div>
		<div class="card" id='discharge_list'>
			Did you have any discharge ? <br><br>
			<button type='button' onclick='button_clicked(this)' value='White Discharge'>White Discharge</button>
			<button type='button' onclick='button_clicked(this)' value='Clear Discharge'>Clear Discharge</button>
			<button type='button' onclick='button_clicked(this)' value='Spotting'>Spotting</button>
		</div>
		<input type='hidden' name='cycle_day' value='' id='cycle_day'>
		<input type='hidden' name='date' value='' id='date'>
		<input type='hidden' name='feelings' value='' id='feelings'>
		<input type='hidden' name='symptoms' value='' id='symptoms'>
		<input type='hidden' name='flow' value='' id='flow'>
		<input type='hidden' name='discharge' value='' id='discharge'>
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
		name += ",";
		var list = button.parentElement.id ;
		if(list == "feelings_list")
			document.getElementById('feelings').value += name;
		else if(list == "symptoms_list")
			document.getElementById('symptoms').value += name;
		else if(list == "flow_list")
			document.getElementById('flow').value += name;
		else if(list == "discharge_list")
			document.getElementById('discharge').value += name;
	}
	function button_deselect(button)
	{
		button.style.backgroundImage = "linear-gradient(to right,#fee4e2,#fee4e2)";
		button.style.border = "none";
		var name = button.value;
		name += ",";
		var list = button.parentElement.id ;
		if(list == "feelings_list")
			document.getElementById('feelings').value = document.getElementById('feelings').value.replace(name,"");
		else if(list == "symptoms_list")
			document.getElementById('symptoms').value = document.getElementById('symptoms').value.replace(name,"");
		else if(list == "flow_list")
			document.getElementById('flow').value = document.getElementById('flow').value.replace(name,"");
		else if(list == "discharge_list")
			document.getElementById('discharge').value = document.getElementById('discharge').value.replace(name,"");
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