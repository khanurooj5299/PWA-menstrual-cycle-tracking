<?php
session_start();
require_once 'functions.php';

//chcecking if session is already set
if(isset($_SESSION['user']))
{
	header("Location:./selection.php");
	die();
}

//checking if remember me was checked and cookies are still present
//if so, the user is automatically logged in if cookie data is correct
if(isset($_COOKIE['remember_me']))
{
	list($user,$cookie_pass_hash)=explode('||',$_COOKIE['remember_me']);
	$result = queryMySQL("SELECT * FROM users WHERE user='$user'");  //getting the values from DB
    if ($result->num_rows > 0)   //proceed only if cookie username exists
   {
		//now we need to match password
		$row = $result->fetch_assoc();
		$actual_pass_hash = $row['pass'];
		if(hash_equals($cookie_pass_hash,$actual_pass_hash))    //password matched
		{
			$_SESSION['user'] = $user;
			$_SESSION['name'] = $row['name'];
			$result->close();
			header("Location:./selection.php");
			die();
		}
   }
}

//else diplaying the login form
if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    if ($user == "" || $pass == "") //just to be sure
	{ $error = 'Not all fields were entered';
	  $display = 'block';
	}
    else
    {
      $result = queryMySQL("SELECT * FROM users WHERE user='$user'");  //getting the values from DB

      if ($result->num_rows == 0)   //no user with entered username exists
      {
        $error = "Invalid login attempt nouser";
		$display = 'block';
      }
      else   //a user with the entered username exists and now we need to match password 
      {
		$row = $result->fetch_assoc();
		$actual_pass_hash = $row['pass'];
		if(password_verify($pass,$actual_pass_hash))    //password matched
		{
			$_SESSION['user'] = $user;
			$_SESSION['name'] = $row['name'];
			
			//remember me functionality
			if(isset($_POST["remember"]))
			{
				$cookie = $user.'||'.$actual_pass_hash;
				setcookie("remember_me",$cookie,time()+60*60*24*30,'/',null,null,true);
			}
			
			header("Location:./selection.php");
			die();
		}
		else{     //password not matched
			$error = "Invalid login attempt";
			$display = 'block';
		}
      }
    }
  }
  else	
	$display = 'none';
echo <<<_END
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>LOGIN</title>
		<link rel="stylesheet" href="../css/topnav.css" type="text/css">
		<link rel="stylesheet" href="../css/background.css" type="text/css">
		<link rel="stylesheet" href="../css/card.css" type="text/css">
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
		<div class="topnav"><button class="close"  onclick="document.location.href='../menu.html'"><b>X</b></button></div>
		<div class='card' style="background-image:linear-gradient(to right,#FF5349,#FF4040);display:$display">$error</div>
		<div class="card">
		<form method="POST" action="login.php">
			Username: <input type="text" name="user" required pattern="^\S*$" title="fill out this field with no whitespaces"><br>
			Password: <input type="password" name="pass" required pattern="^\S*$" title="fill out this field with no whitespaces"><br>
			<input type="checkbox" name="remember">Remember me<br>
			<input type="submit" value="Login" style="background-color:#7CFC00">
		</form>
		<a href='./signup.php' style="color:black">Don't have an account</a>
		</div>
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	</html>
_END;
?>