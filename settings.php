<?php 
	/*
	Author:  Drew D. Lenhart
	http://www.snowytech.com
	Page: settings.php
	Desc: Change user settings.	
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
	include ("includes/libClean.php");
?>
<div data-role="page" id="page" class = "mainPage" data-theme="a">
	<?php include("navHeaderPanel.php");  ?>
   <div data-role="content" style="margin-left:5%; margin-right:5%">
		
	  <?php
		//query to get title
		$sth = $conn->query("SELECT * FROM profile where User_ID = '$login'");
			if (!$sth) {
				die("Database query failed: ERR NOemailQuery");
			}
		// Set fetching mode
		$sth->setFetchMode(PDO::FETCH_ASSOC);				
		$row  = $sth -> fetch();

		$email_out = $row['email'];
		$first_out = $row['first_name'];
		$last_out = $row['last_name'];
		$check_lvl = $row['usr_lvl'];
	 ?>
	 <center><h1>Settings for <?php echo $first_out . " " . $last_out; ?></h1></center>
	  <hr>
	  <h3>Update Profile</h3>
	 		<!--Edit portion -->
		<form name="form1" method="post" action="">
		 
		<label for="email"><b>Email: </b></label>
		<input type="text" name="email" id="email" data-theme="a" value="<?php echo $email_out;?>" />
		<br />
		<label for="first"><b>First name: </b></label>
		<input type="text" name="first" id="first" data-theme="a" value="<?php echo $first_out;?>" />
		<br />
		<label for="last"><b>Last name: </b></label>
		<input type="text" name="last" id="last" data-theme="a" value="<?php echo $last_out;?>" />
		<br />
		<input name="submit" type="submit" value="Update Information" data-inline="true" onClick="return confirm('Are you sure you want update?')" data-theme="a"></form>
        
        <a href='usr_change_pass.php' data-inline='true' data-role='button' data-theme='a'>Change Password</a>
        
		<hr><br />
				<?php 
		if(isset($_POST['submit']))
		{
			$new_email = sqlClean($_POST['email']);
			$new_first = sqlClean($_POST['first']);
			$new_last = sqlClean($_POST['last']);
	
			$sql="UPDATE profile SET email='$new_email', first_name='$new_first', last_name='$new_last' WHERE User_ID='$login'";
			$result=$conn->exec($sql);
	
			if($result){echo "<meta http-equiv=\"refresh\" content=\"0;URL=settings.php\">";}
		}
		?>
		 <?php
			if($check_lvl == 1 || $check_lvl > 0){
				echo "<b>You have superuser priveledges</b><br /><br />";
				echo "<a href='admin_new_usr.php' data-inline='true' data-role='button' data-theme='a'>Create New Users</a>";
				echo "<br />";
				echo "<a href='admin_create_message.php' data-inline='true' data-role='button' data-theme='a'>Message System</a>";
			}
		 ?>
   </div>
   </div>
	<?php include("navFooterPanel.php");  ?>
</div>
<?php include("includes/footer.php"); ?>
