<?php 
session_start(); 
include ("includes/connPDO.php");
include ("includes/libClean.php");
$loginName=strip_tags(sqlClean($_POST['loginName']));
$user_password=strip_tags(sqlClean($_POST['user_password']));


	
$sql = "SELECT User_ID FROM profile
			WHERE User_ID='$loginName'";
$result = mysql_query($sql)
		or die ("Query failed!");
$num = mysql_num_rows($result);

if($num == 1)  //login name was found
{
	//$encrypt_password=SHA1($user_password);
	$sql = "SELECT User_ID FROM profile
				WHERE User_ID='$loginName'
				AND u_pass= sha1('$user_password')";
	$result2 = mysql_query($sql)
			or die("query 2 failed!");
	$num2 = mysql_num_rows($result2);
	$row_check = mysql_fetch_array($result2);
	if($num2 > 0) //correct passcode
	{
		$_SESSION['auth']="yes";
		$row = mysql_fetch_array($result2);
		$_SESSION['User_ID']=$loginName;
		if($_SESSION['location']=="" or $_SESSION['location']=="index.php")
		{
			header("Location: index.php");
		}
		else
		{
			$goTo = $_SESSION['location'];
			header("Location: $goTo");
		}
	}
	else //password is incorrect
	{
		echo "<!DOCTYPE html> ";
		echo "<html>";
		echo "<head>";
		echo "<meta charset='utf-8'>";
		echo "<meta name='viewport' content='width=device-width'>";
		echo "<title>dinnerSTOR - snowytech</title>";
		echo "<link href='css/external.css' rel='stylesheet' type='text/css'/>";
		echo "<link href='css/jquery.mobile-1.3.1.min.css' rel='stylesheet' type='text/css'/>";
		echo "<link href='css/jquery-ui-1.10.3.custom.css' rel='stylesheet' type='text/css'/>";
		echo "<link href='css/snowyT2.css' rel='stylesheet' type='text/css'/>";

		echo "<script src='javascript/jquery-1.8.2.min.js' type='text/javascript'></script>";
		echo "<script src='javascript/jquery.mobile-1.3.1.min.js' type='text/javascript'></script>";
		echo "<script src='javascript/jquery-ui-1.10.3.custom.js' type='text/javascript'></script>";
		echo "<script src='javascript/main.js' type='text/javascript'></script>";
		echo "</head> ";
		echo "<body>";
		echo "<center><h1>Failed!</h1>";
		echo "User name $loginName is correct, but password is not! Please <a href='login_svs.php'> 
		try again.</a> </center>";
	}
}
elseif($Num == 0)  //login name not found
{
		include("includes/header.php"); 
		echo "<center><h1>Failed!</h1>";
		echo "<b>User name $loginName is incorrect! Please <a href='login_svs.php'> try 
		again.</a></b></center> ";
}

?>
</body>
</html>