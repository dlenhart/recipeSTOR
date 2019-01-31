<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: scheduler.php
    Desc: Creates a simple daily meal plan.
    */
    session_start();
    $auth= $_SESSION['auth'];
    $login= $_SESSION['User_ID'];
    if ($auth != "yes") {
        header("Location: login_svs.php");
        exit();
    }


    require("includes/connPDO.php");

        if (isset($_POST['go'])) {
            $title = strip_tags($_POST['title']);
            $date = strip_tags($_POST['datepicker']);

            $statement = $conn->prepare('INSERT INTO scheduler (login_ID, dinner, date) VALUES (:var1,:var2,:var3)');

            $statement->bindParam(':var1', $login);
            $statement->bindParam(':var2', $title);
            $statement->bindParam(':var3', $date);
            $statement->execute();
        }
?>
<!--Scheduler-->
<?php include("includes/header.php"); ?>
<div data-role="page" id="shedule" data-theme="a">
<?php include("navHeaderPanel.php");  ?>
	<div data-role="content" style="margin-left:10%; margin-right:10%">
	<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
  </script>

		<center><h1>Simple Scheduler</h1></center>
		The Simple Scheduler can plan meals by using the date field to select date.  Choose an entry from the drop down
		below.  The drop down will pull fields from public view, as well as your own entries.
		<br /><br />
	<form name="form1" method="post" action="">
	<ul data-role='listview' data-theme="a" data-inset='true'>

	<?php
        $sth = $conn->query("SELECT * FROM scheduler WHERE login_ID = '$login' ORDER BY postdate DESC");
            if (!$sth) {
                die("Database query failed: " . mysql_error());
            }
        // Set fetching mode
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($sth as $row) :
            $food_ID = $row['id'];
            $food_title = $row['dinner'];
            $food_date = $row['date'];
            echo "<li>";
            echo "<input name='checkbox[]' type='checkbox' id='checkbox[]' value='$food_ID' class='M-checkbox-c'>";
            echo "<div style='margin-left:65px'>";
            echo $food_date . " - " . $food_title;
            echo "</div>";
            echo "</li>";
        endforeach;
    ?>

	</ul>
	<input name="delete" type="submit" id="delete" value="Delete Selected Entries!" data-inline='true' onClick="return confirm('Are you sure you want to delete these records?')">

	<?php
        if (isset($_POST['delete'])) {
            for ($i=0;$i<count($_POST['checkbox']);$i++) {
                $del_id = $_POST['checkbox'][$i];
                $sql = "DELETE FROM scheduler WHERE id='$del_id'";
                $result=$conn->exec($sql);
            }
            if ($result) {
                echo "<meta http-equiv=\"refresh\" content=\"0;URL=scheduler.php\">";
            }
        }
    ?>

	</form>
	<br />

	<hr />
	<center><h2>Plan a daily meal:</h3></center>
	<form name="form1" method="post" action="">
	Date: <input type="text" id="datepicker" name="datepicker" data-theme="a" />
	<br />
	*For now this list grabs all PUBLIC recipies as well as your PRIVATE recipe's:<br>

	<?php
    //Pulls data and puts into a select box.(for PUBLIC)
            $sth2 = $conn->query("SELECT * FROM dinners");
            if (!$sth2) {
                die("Database query failed: " . mysql_error());
            }
        // Set fetching mode
            $sth2->setFetchMode(PDO::FETCH_ASSOC);

            echo "<select name='title' id='title' class='group' data-theme'a' data-native-menu='false' data-mini='true' data-inline='true'>";

            foreach ($sth2 as $row2) :
                echo "<option value='".$row2['title']."'>".$row2['title']."</option>";
            endforeach;
            echo "<option value='dil'>blaaah</option>";
            echo "</select>";
    ?>
	<br />

	<br><input type='submit'value='Submit' name='go'><br />
	<?php
    echo $success;

    ?>
	</form>

	</div>
<?php include("navFooterPanel.php");  ?>
</div>
<?php include("includes/footer.php"); ?>
