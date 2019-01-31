<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: print_view.php
    Desc: Printer friendly view of recipe.
    */
    session_start();
    $auth= $_SESSION['auth'];
    $login= $_SESSION['User_ID'];
    if ($auth != "yes") {
        header("Location: login_svs.php");
        exit();
    }

    require("includes/connPDO.php");
?>
<html>
<head><title></title></head>

<body><div style="margin-left:10%; margin-right:10%">
		<?php
                $entryID = strip_tags($_GET['ID']);

                $sth = $conn->query("SELECT * FROM dinners where id = '$entryID'");
                    if (!$sth) {
                        die("Database query failed: ERR NOprintVIEWpage");
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

        if ($privacy == 1 && $login != $author) {
            echo " This is a private entry, you do not have permission to view this page.<br />";
        } elseif ($author == $login) {
            echo "<h2>" . $content . "</h2>";
            echo "<b>Posted on: </b><br />" . $dateConverted . " by " . $author;
            echo "<br /><hr />";
            echo "<b>Ingredients: </b><br />" . nl2br($ingred) . "<br /><br />";
            echo "<b>Instructions: </b><br />" . nl2br($structions) . "<br /><br /><br /><br />";
            echo "<center><em>powered by dinnerSTOR by snowytech</em></center>";
        } elseif ($privacy == 0) {
            echo "<h2>" . $content . "</h2>";
            echo "<b>Posted on: </b><br />" . $dateConverted . " by " . $author;
            echo "<br /><hr />";
            echo "<b>Ingredients: </b><br />" . nl2br($ingred) . "<br /><br />";
            echo "<b>Instructions: </b><br />" . nl2br($structions) . "<br /><br /><br /><br />";
            echo "<center><em>powered by dinnerSTOR by snowytech</em></center>";
        }
        $conn = null;
        ?>
</div>
		</body>
</html>
