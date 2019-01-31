<?php 
	/*
	Author:  Drew D. Lenhart
	http://www.snowytech.com
	Page: edit_success.php
	Desc: Display success message when entry changed.	
	*/
	session_start(); 
	$auth= $_SESSION['auth'];
	if ( $auth != "yes" )
	{
		header("Location: login_svs.php");
		exit();
	}

	include("includes/header.php"); 
	
?>

<!--success Popup dialog-->
<div id="add_success" data-role="dialog" data-title="Success!" data-theme="b">
		<div data-role="header" data-theme="a">

		<h1>Success!</h1>

		</div>
	<div data-role="content">
		
		<br />
		You updated an entry!
	
		<br /><br />
		<a href="myview.php" data-rel="" data-role="button" data-theme="a">Ok</a>
	
	
	</div>

</div>

<?php include("includes/footer.php"); ?>