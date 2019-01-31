<?php 
	/*
	Author:  Drew D. Lenhart
	http://www.snowytech.com
	Page: add.php
	Desc: Add new recipes.	
	*/
	session_start(); 
	$auth= $_SESSION['auth'];
	$login= $_SESSION['User_ID'];
	if ( $auth != "yes" )
	{
		header("Location: login_svs.php");
		exit();
	}
	
	require("includes/connPDO.php");
	include ("includes/libClean.php");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["food"])) {
			$titleErr = "Missing *** Must have a title";
		}
		if (empty($_POST["ingreed"])) {
			$ingErr = "Missing *** Must have a ingredient";
		}
		if (empty($_POST["instruct"])) {
			$insErr = "Missing *** Must have instructions";
		}
		else {
        $title = sqlClean($_POST['food']);
		$ingred = sqlClean($_POST['ingreed']);
		$instructs = sqlClean($_POST['instruct']);
		$privacy_setting = sqlClean($_POST['privacy']);
		
		if(isset($_POST['save']))
			{
			//Now lets insert the data
			$statement = $conn->prepare('INSERT INTO dinners (login_ID, title, ingreed, instruct, privacy) VALUES (:var1,:var2,:var3,:var4,:var5)');

			$statement->bindParam(':var1',$login);
			$statement->bindParam(':var2',$title);
			$statement->bindParam(':var3',$ingred);
			$statement->bindParam(':var4',$instructs);
			$statement->bindParam(':var5',$privacy_setting);
			$statement->execute();

			$added = "You have successfully added a new recipie!";
			}
    }
	}
	
?>

<?php include("includes/header.php"); ?>
<!--Add----------------------------------------------------- -->

<div data-role="page" id="add" data-theme="a">
	<?php include("navHeaderPanel.php");  ?>
	<div data-role="content" style="margin-left:10%; margin-right:10%">
		<center><h1>Add Recipe</h1>
		<b><?php echo $added;?></b>
		</center>
				<br />
				**All fields require some text to be filled in.<br /><br />
				
	<form method="post" action="#">
		<label for="tax"><b>Food Name: </b></label>
		<b><?php echo $titleErr;?></b>
		<input type="text" name="food" id="food" data-theme="a" />
		
		<label for="ingreed"><b>Ingredients: </b></label>
		<b><?php echo $ingErr;?></b>
		<textarea cols="" rows="8" name = "ingreed" id="ingreed"></textarea>
		
		<label for="instruct"><b>Instructions: </b></label>
		<b><?php echo $insErr;?></b>
		<textarea cols="" rows="8" name = "instruct" id="instruct"></textarea>
		<br />
		<label for="privacy"><b>Make this entry public?:</b></label>
		<select name='privacy' id='privacy' class='group' data-theme'a' data-native-menu='false' data-mini='true' data-inline='true'>
		<option value='0'>yes</option>
		<option value='1'>no</option>
		</select><br />
		
		<input name="save" id ="save" type="submit" value="Send" onClick=""data-theme="a">
		<input type="reset" id="cancel" name="reset" value="Reset" data-theme="a">
		
	</form>

	</div>
<?php include("navFooterPanel.php");  ?>	
</div>

<!--Invalid Popup dialog-->
<div id="invalid" data-role="dialog" data-title="Invalid Note" data-theme="b">
		<div data-role="header" data-theme="a">

		<h1>Error!</h1>

		</div>
	<div data-role="content">
		This entry is not complete! <br />
		<br />
		**At minimum you must enter a food title**
	
		<br /><br />
		<a href="#" data-rel="back" data-role="button" data-theme="a">Ok</a>
	
	
	</div>

</div>
<?php include("includes/footer.php"); ?>
