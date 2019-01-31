<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: full_view.php
    Desc: Displays full recipe with options.
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

		<div data-role="content" style="margin-left:5%; margin-right:5%">
		<?php
                $entryID = strip_tags($_GET['ID']);

                $sth = $conn->query("SELECT * FROM dinners where id = '$entryID'");
                    if (!$sth) {
                        die("Database query failed: ERR NOfullVIEWpage");
                    }
                // Set fetching mode
                $sth->setFetchMode(PDO::FETCH_ASSOC);

                $row  = $sth -> fetch();

                $content = $row['title'];
                $author = $row['login_ID'];
                $date = $row['postdate'];
                $ingred = $row['ingreed'];
                $structions = $row['instruct'];
                $privacy = $row['privacy'];
                $dateConverted = date('F d, Y  h:i:s A', strtotime($date));

        //Privacy check.  For example is someone guesses this page, checks first if the page is private and if the author is the poster.
        if ($privacy == 1 && $login != $author) {
            echo "This entry is a private entry, you do not have permission to view private posts!<br /><br />";
        } else {
            echo "<h2>";
            echo $content;
            echo "</h2>";
            echo "<b>Posted on:</b><br />" . $dateConverted . " - by " . $author;
            echo "<br />";
            echo "<hr />";
            echo "<b>Ingredients:</b><br />" . nl2br($ingred) . "<br /><br />";
            echo "<b>Instructions:</b><br />" . nl2br($structions) . "<br /><br />";
        }
        ?>
		<?php
        if ($author == $login) {
            echo "<a href='edit_entry.php?ID=$entryID' data-rel='' data-role='button' data-theme='a'>Edit</a>";
            echo "<form name='form1' method='post' action=''>";
            echo "<input name='delete' type='submit' id='delete' value='Delete' onClick='return confirm('Are you sure you want to delete this record? Your recipie will be permanently removed from the database!')' data-theme='a'>";

            if (isset($_POST['delete'])) {
                $sql = "DELETE FROM dinners WHERE id='$entryID'";
                $result=$conn->exec($sql);

                if ($result) {
                    echo "<meta http-equiv=\"refresh\" content=\"0;URL=delete_success.php\">";
                }
            }
            echo "</form>";
        } else {
            echo "You are not the owner of this entry, thus you cannot edit it.<br />";
        }
        ?>
		<?php
        //If we have a private page, we dont want to post the email and print buttons.
        if ($privacy == 1 && $login != $author) {
            echo " <br />";
        } elseif ($author == $login) {
            echo "<a href='print_view.php?ID=" . $entryID . "ANDtitle=" . $content . "' data-rel='' data-role='button' data-theme='a'>Print</a>";
            echo "<a href='send_rec.php?ID=" . $entryID . "' data-rel='dialog' data-role='button'>Email</a>";
        } elseif ($privacy == 0) {
            echo "<a href='print_view.php?ID=" . $entryID . "ANDtitle=" . $content . "' data-rel='' data-role='button' data-theme='a'>Print</a>";
            echo "<a href='send_rec.php?ID=" . $entryID . "' data-rel='dialog' data-role='button'>Email</a>";
        }

        ?>
		<a href="#" data-rel="back" data-role="button" data-theme="a">Back</a>
	</div>
<?php include("navFooterPanel.php");  ?>
</div>
<?php include("includes/footer.php"); ?>
