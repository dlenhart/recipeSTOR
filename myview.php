<?php 
	/*
	Author:  Drew D. Lenhart
	http://www.snowytech.com
	Page: myview.php
	Desc: Displays owners entries.	
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
<!--View----------------------------------------------------- -->
<div data-role="page" id="view" data-theme="a">
<?php include("navHeaderPanel.php");  ?>
		<!--- ORDER BY postdate DESC  --->
		<div data-role="content" style="margin-left:5%; margin-right:5%">
		<?php
				// Select table with query
				$sth = $conn->query("SELECT * FROM dinners WHERE login_ID = '$login' ORDER BY title");
					if (!$sth) {
						die("Database query failed: " . mysql_error());
					}
				// Set fetching mode
				$sth->setFetchMode(PDO::FETCH_ASSOC);
		?>
				<center><h1>My Recipes</h1></center>
				<br />
				<ol data-role='listview' data-theme="a" data-inset='true' data-filter="true" data-filter-placeholder="Search foods...">
					<?php foreach ($sth as $row) : 
					$entryID = $row['id'];
					$author = $row['login_ID'];
					$title_out = $row["title"];				
					?>
					<li><a href='full_view.php?ID=<?php echo $entryID;?>' data-rel=''><?php echo $title_out;?></a></li>
				<?php endforeach; ?>

				</ol>
				
	</div>
	<?php include("navFooterPanel.php");  ?>
</div>
<?php include("includes/footer.php"); ?>
