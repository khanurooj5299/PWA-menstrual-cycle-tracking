<?php //to destroy session and delete cookie on logout
session_start();
session_destroy();  //destroying all session variables
setcookie("remember_me","",time()-3600,'/',null,null,true); //deleting cookie
header("Location:./login.php");
die();
?>