<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: delete_success.php
    Desc: Displays when an entry is removed..
    */
    session_start();
    $auth= $_SESSION['auth'];
    if ($auth != "yes") {
        header("Location: login_svs.php");
        exit();
    }

    include("includes/header.php");

?>

<!--success Popup dialog-->
<div id="add_success" data-role="dialog" data-title="Successfull Deletion!" data-theme="b">
		<div data-role="header" data-theme="a">

		<h1>Success!</h1>

		</div>
	<div data-role="content">

		<br />
		Your entry has been removed from the system.

		<br /><br />
		<a href="index.php" data-rel="" data-role="button" data-theme="a">Ok</a>


	</div>

</div>

<?php include("includes/footer.php"); ?>
