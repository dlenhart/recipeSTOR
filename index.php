<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: index.php
    Desc: Main page.
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

?>
<div data-role="page" id="page" class = "mainPage" data-theme="a">
	<?php include("navHeaderPanel.php");  ?>
   <div data-role="content" style="margin-left:5%; margin-right:5%">
		<center><h1>Main/News</h1></center>


	  <div id="mainGuy" style="color:black">
	  <div style="float:left; width: 64px; height: 64px; padding-right: 10px;"><img src="images/sticon.png" width="64" height="64" alt="" /></div>
		Welcome to recipeSTOR, your one stop site to store your favourite recipe's.  Click the top left menu icon for a full list
		of options.  The quick links are below for simple navigation.  This site uses jquery mobile!  So feel free to use this on your
		mobile device, it will scale perfectly to the size of your screen.<br /><br /><em>--Drew</em><br /><hr>

		<h3>Changes/News</h3>
		<?php
                $sth = $conn->query("SELECT * FROM news_ds ORDER BY post_date DESC");
                    if (!$sth) {
                        die("Database query failed: NonewNEWS");
                    }
                // Set fetching mode
                $sth->setFetchMode(PDO::FETCH_ASSOC);

                foreach ($sth as $row) :
                    $entryID = $row['id'];
                    $author = $row['User_ID'];
                    $myDate = strtotime($row["post_date"]);
                    $outDate = date("m/d/y", $myDate);
                    $message = nl2br($row["message"]);
                    echo $outDate . " - by <em>" . $author . "</em><br />" . $message . "<br />--------<br /><br />";
                endforeach;
        ?>
	  </div>
	  <br />

	  <center>
	  Version 1.07 - 10/6/2014 Release
	   <br />
	  www.drewlenhart.com</center>

   </div>
	<?php include("navFooterPanel.php");  ?>
</div>
<?php include("includes/footer.php"); ?>
