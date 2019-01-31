<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: send_rec.php
    Desc: Email sender.
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

<!--Email Popup-->
<div data-role="page" id="email" data-theme="a" data-dismissible="false" data-overlay-theme="a">
	<div data-role="header" data-theme="a">
		<h1>Email Recipie</h1>

		</div>
		<!--- ORDER BY postdate DESC  --->
		<div data-role="content">
		<?php
        //Grabs the email from profile,this will do the sending:
        $sth = $conn->query("SELECT * FROM profile where User_ID = '$login'");
            if (!$sth) {
                die("Database query failed: ERR NOemailQuery");
            }
        // Set fetching mode
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $row2  = $sth -> fetch();
        $from = $row2['email'];

        //Get contents of the entry:
        $entryID2 = strip_tags($_GET['ID']);
        $sth2 = $conn->query("SELECT * FROM dinners where id = '$entryID2'");
            if (!$sth2) {
                die("Database query failed: ERR NOContentQuery");
            }
        // Set fetching mode
        $sth2->setFetchMode(PDO::FETCH_ASSOC);
        $row3  = $sth2 -> fetch();

        $g_title = $row3['title'];
        $g_author = $row3['login_ID'];
        $g_ingred = $row3['ingreed'];
        $g_structions = $row3['instruct'];
        ?>

		Email this recipe to someone you know!<br />
		<form name='form1' method='post' action=''>
		<label for='email'><b>Send to: (somebody@domain.com)</b></label>
		<input type='text' name='email' id='email' data-theme='a' value='' />
		<input name='submit2' type='submit' id='submit2' value='Send!' onClick='' data-theme='a'>

		<?php
            if (isset($_POST['submit2'])) {
                $to = sqlClean($_POST['email']);
                $subject = "A food recipie you might be interested in! - dinnerSTOR";
                $output .= $g_title;
                $output .= "\n";
                $output .= "by ";
                $output .= $g_author;
                $output .= "\n";
                $output .= "\n";
                $output .= "Ingredients: ";
                $output .= "\n";
                $output .= $g_ingred;
                $output .= "\n";
                $output .= "\n";
                $output .= "Instructions: ";
                $output .= "\n";
                $output .= $g_structions;
                $output .= "\n";
                $output .= "\n";
                $output .= "\n";
                $output .= "Powered by dinnerSTOR - snowytech";

                //Now send message
                mail($to, $subject, $output, "From:" . $from);
                echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
            }
        ?>
		</form>

		<a href="#" data-rel="back" data-role="button" data-theme="a">Cancel</a>
		</div>

</div>
<?php $conn = null; ?>
</body>
</html>
