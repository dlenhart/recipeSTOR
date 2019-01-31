<?php 
	/*
	Author:  Drew D. Lenhart
	http://www.snowytech.com
	Page: random.php
	Desc: Displays random recipe.	
	*/
	session_start(); 
	$auth= $_SESSION['auth'];
	$login= $_SESSION['User_ID'];
	if ( $auth != "yes" )
	{
		header("Location: login_svs.php");
		exit();
	}
	include("includes/header.php"); 
	require("includes/connPDO.php");
?>
<div data-role="page" id="page" class = "mainPage" data-theme="a">
	<?php include("navHeaderPanel.php");  ?>
   <div data-role="content" style="margin-left:15%; margin-right:15%">
		<center><h1>Todays Random Dinner:</h1></center>
	  
	  <?php
		$sth = $conn->query("SELECT * FROM dinners WHERE privacy='0' ORDER BY RAND() LIMIT 1");
			if (!$sth) {
				die("Database query failed: " . mysql_error());
			}
		// Set fetching mode
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$row  = $sth -> fetch();
		$output_random = $row['title'];
		$entryID = $row['id'];
	  
	  ?>
	  <center><h2><? echo $output_random; ?></h2></center>
	  <?php 
		echo "<center><a href='full_view.php?ID=$entryID' data-rel=''>Read more.....</a></center>";
	  ?>
	  <br />
	  <form action="<? $_SERVER['PHP_SELF'] ?>" method="post">
		<input type = "submit" data-theme="a" value="Refresh">
	  </form>
	  
	  <br /><center>
	  
	  
   </div>
<?php include("navFooterPanel.php");  ?>
</div>
<?php include("includes/footer.php"); ?>
