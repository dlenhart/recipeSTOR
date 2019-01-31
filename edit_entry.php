<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: edit_entry.php
    Desc: Edit recipes created by owner.
    */
    session_start();
    $auth= $_SESSION['auth'];
    $login= $_SESSION['User_ID'];
    if ($auth != "yes") {
        header("Location: login_svs.php");
        exit();
    }

    include("includes/header.php");
    require("includes/connPDO.php");
    include("includes/libClean.php");
?>

<!--Full View-->
<div data-role="page" id="view" data-theme="a">
<?php include("navHeaderPanel.php");  ?>

		<div data-role="content" style="margin-left:10%; margin-right:10%">
		<?php
        //Get info about recipe and put into form.
        $entryID = strip_tags($_GET['ID']);
        $sth = $conn->query("SELECT * FROM dinners where id = '$entryID'");
            if (!$sth) {
                die("Database query failed: ERR NOeditQueryNO");
            }
        // Set fetching mode
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $row  = $sth -> fetch();

        $id = $row['id'];
        $content = $row['title'];
        $author = $row['login_ID'];
        $date = $row['postdate'];
        $ingred = $row['ingreed'];
        $structions = $row['instruct'];
        $privacy = $row['privacy'];
        $dateConverted = date('F d, Y  h:i:s A', strtotime($date));
        ?>
		<h2><?php echo $content; ?></h2>
		<b>Posted on:</b><br /> <?php echo $dateConverted; ?>
		<br />
		<hr />

		<?php
        if ($author == $login) {
            echo "<form name='form1' method='post' action=''>";
            echo "<input name ='id' type='hidden' id='id' value='$id'>";

            echo "<label for='food'><b>Food Name:</b></label>";
            echo "<input type='text' name='food' id='food' data-theme='a' value='$content' />";

            echo "<label for='ingreed'><b>Ingredients:</b></label>";
            echo "<textarea cols='' rows='8' name = 'ingreed' id='ingreed'>$ingred</textarea>";

            echo "<label for='instruct'><b>Instructions:</b></label>";
            echo "<textarea cols='' rows='8' name = 'instruct' id='instruct'>$structions</textarea>";

            echo "<br />";
            echo "<label for='privacy'><b>Privacy:</b></label><br />";
            if ($privacy == 0) {
                echo "Privacy level is currently set to: PUBLIC";
            } else {
                echo "Privacy level is currently set to: PRIVATE";
            }
            echo "<br />";
            //echo "<select name='priv' id='priv' class='group' data-theme'a' data-native-menu='false' data-mini='true' data-inline='true'>";
            //echo "<option>Reset privacy to:</option>";
            //foreach ($sth as $row) :
            //echo "<option value='".$row['privacy']."'>".$row['privacy']."</option>";
            //endforeach;
            //echo "<option value='0'>Public</option>";
            //echo "<option value='1'>Private</option>";
            //echo "</select>";
            echo "<br />";
            echo "<input name='submit' type='submit' value='Submit' onClick='return confirm('Are you sure you want to add to this record?')' data-theme='a'>";



            if (isset($_POST['submit'])) {
                $del_id = sqlClean($_POST['id']);
                $food_id = sqlClean($_POST['food']);
                $ingreed_id = sqlClean($_POST['ingreed']);
                $instruct_id = sqlClean($_POST['instruct']);
                $privacy = sqlClean($_POST['priv']);
                $sql="UPDATE dinners SET title='$food_id', ingreed='$ingreed_id', instruct='$instruct_id', privacy='$privacy' WHERE id='$del_id'";
                $result=$conn->exec($sql);

                if ($result) {
                    echo "<meta http-equiv=\"refresh\" content=\"0;URL=edit_success.php\">";
                }
            }
            echo "</form>";
        } else {
            echo "<b>You do not have permissions to edit this entry</b>";
        }
        ?>
		<a href="#" data-rel="back" data-role="button" data-theme="a">Cancel</a>
	</div>
<?php include("navFooterPanel.php");  ?>

</div>
<?php include("includes/footer.php"); ?>
