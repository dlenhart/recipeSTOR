<?php
	/*
	Author:  Drew D. Lenhart
	http://www.snowytech.com
	Page: admin_create_message.php
	Desc: Super user page, create news on main page.	
	*/
	session_start(); 
	$auth= $_SESSION['auth'];
	$login= $_SESSION['User_ID'];
	$check_lvl = $_SESSION['usr_lvl'];
	if ( $auth != "yes" )
	{
		header("Location: login_svs.php");
		exit();
	}
if(isset($_POST['go'])){
	$message = strip_tags($_POST['message']);
			
	require("includes/connPDO.php");			
	//Lets insert the message from the form into db.
	$statement = $conn->prepare('INSERT INTO news_ds (User_ID, message) VALUES (:var1,:var2)');

	$statement->bindParam(':var1',$login);
	$statement->bindParam(':var2',$message);
	$statement->execute();

	$success = "You successfully added a new message!";		
}

?>
<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>dinnerSTOR - by snowytech</title>
<link href="css/external.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery.mobile-1.3.1.min.css" rel="stylesheet" type="text/css"/>
<link href="css/snowyT2.css" rel="stylesheet" type="text/css"/>

<script src="javascript/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="javascript/jquery.mobile-1.3.1.min.js" type="text/javascript"></script>

<script src="javascript/main.js" type="text/javascript"></script>
</head> 
<body>

<div data-role="page" id="page" class = "mainPage" data-theme="a">
<?php include("navHeaderPanel.php");  ?>
<div data-role="content" style="margin-left:20%; margin-right:20%">
<b>This is the message center.  Use this to post news on the main page</b><br> <i>*Required field.</i><br />

<?php
require("includes/connPDO.php");
//query to get the user level.
$sth = $conn->query("SELECT * FROM profile where User_ID = '$login'");
	if (!$sth) {
		die("Database query failed: ERR NOlevelCheck");
	}
// Set fetching mode
$sth->setFetchMode(PDO::FETCH_ASSOC);				
$row  = $sth -> fetch();

$check_lvl = $row['usr_lvl'];
			
if($check_lvl == 1 || $check_lvl > 0){
	echo "<br />";
	echo "<center>";
	echo $success;
	echo "</center>";
	echo "<br />";
	echo "<br />";
	echo "<form action='#' method='POST'>";
	echo "<label for='message'><b>Message: </b></label>";
	echo "<textarea cols='' rows='8' name = 'message' id='message'></textarea>";
	echo "<br><input type='submit'value='Submit' name='go'>";
	echo "<a href='settings.php' data-role='button' data-theme='a'>Cancel</a>";
	
}else{
	echo "<b>You do not have permissions to access this page</b>";
}
?>

</form>
</div>
<?php include("navFooterPanel.php");  ?>
</div>
<?php include("includes/footer.php"); ?>