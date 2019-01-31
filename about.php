<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: about.php
    Desc: Information.
    */
    session_start();
    $auth= $_SESSION['auth'];
    if ($auth != "yes") {
        header("Location: login_svs.php");
        exit();
    }

    include("includes/header.php");

?>

<!--About View -->
<div data-role="page" id="about" data-theme="a" data-dismissible="false" data-overlay-theme="a">
	<div data-role="header" data-theme="a">
		<h1>About recipeSTOR</h1>

		</div>

		<div data-role="content">

		Thanks for downloading!<br /><br />
		Written by:  Drew D. Lenhart<br />
		Version:  <b>1.07</b><br />
		<a href="change_log.txt" target="_blank">Change log</a><br /><br />
		Support:<br /> <a href="http://www.snowytech.com" target="_blank">www.drewlenhart.com</a><br />

	<br /><br />
		<a href="#" data-rel="back" data-role="button" data-theme="a">Back</a>
	</div>

</div>

</body>
</html>
