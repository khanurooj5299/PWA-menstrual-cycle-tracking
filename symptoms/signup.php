<?
session_start();
require_once 'functions.php';

if (isset($_POST['user']))
{
	$user = sanitizeString($_POST['user']);
	$hashed_pass = password_hash(sanitizeString($_POST['pass']),PASSWORD_DEFAULT);
	$name = sanitizeString($_POST['name']);
	
	if ($user == "" || $hashed_pass == "" || $name == "")
	{
	  $error = 'Not all fields were entered<br><br>';
	  $display='block';
	}
	else
	{	
	  $result = queryMysql("SELECT * FROM users WHERE user='$user'");
	
	  if ($result->num_rows != 0)  
	  {
		$error = 'That username already exists<br><br>';
		$display = 'block';
	  }
	  else    //enter new user into DB ,set session and automatically login
	  {
		queryMysql("INSERT INTO users VALUES('$user', '$hashed_pass', '$name')");
		$_SESSION['user'] = $user;
		$_SESSION['name'] = $name;
		header("Location:./selection.php");
		die();
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
		<title>SIGNUP</title>
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
		<div class="topnav">
			<button class="close"  onclick="document.location.href='../menu.html'"><b>X</b></button>
		</div>
		<div class='card' style="background-image:linear-gradient(to right,#FF5349,#FF4040);display:$display">$error</div>
		<div class="card">
		<form method="POST" action="signup.php" onsubmit="return validate(this);"><pre>
Enter your name   : <input type="text" name="name" required pattern=".*[a-zA-Z]+.*" title="Name should contain at least one letter"><br>
Enter a username  : <input type="text" name="user" required pattern="^\S*$" title="fill out this field with no whitespaces"><br>
Choose a password : <input type="password" name="pass" required pattern="^\S*$" title="fill out this field with no whitespaces"><br>
Re-enter the password : <input type="password" name="pass2" required pattern="^\S*$" title="fill out this field with no whitespaces"><br>
<input type="submit" value="Create Account" style="background-color:#7CFC00">
		</form></pre>
		<a href='./login.php' style="color:black">Already have an account</a>
		</div>
	</body>
	<script type="text/javascript" src="../js/size.js"></script>
	<script type="text/javascript">
	function validate(form)
	{
		pass1=form.elements.pass.value;
		pass2=form.elements.pass2.value;
		if(pass1==pass2)
			return true;
		else
		{
			alert("Passwords do not match.\\nTry again!");
			form.elements.pass.value=form.elements.pass2.value='';
			return false;
		}
	}
	</script>
	</html>
_END;
?>