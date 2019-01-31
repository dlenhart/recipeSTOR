<?php 
	/*
	Author:  Drew D. Lenhart
	http://www.snowytech.com
	Page: view.php
	Desc: Displays public entries.	
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
				$sth = $conn->query("SELECT * FROM dinners WHERE privacy = '0' ORDER BY title");
					if (!$sth) {
						die("Database query failed: " . mysql_error());
					}
				// Set fetching mode
				$sth->setFetchMode(PDO::FETCH_ASSOC);
		?>
				<center><h1>Public View</h1></center>
				<br />
				<ol data-role='listview' data-theme="a" data-inset='true' data-filter="true" data-filter-placeholder="Search foods...">
				
				<?php foreach ($sth as $row) : 
					$entryID = $row['id'];
					$author = $row['login_ID'];
					$title_out = $row["title"];				
				?>
					<li><a href='full_view.php?ID=<?php echo $entryID;?>' data-rel=''><?php echo $title_out;?> - by <em><?php echo $author;?></em></a></li>
				<?php endforeach; ?>

				</ol>
				
	</div>
	<?php include("navFooterPanel.php");  ?>
</div>

<?php include("includes/footer.php"); ?>
