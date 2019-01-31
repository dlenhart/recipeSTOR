<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: usr_change_pass.php
    Desc: Change passcode.
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

    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if ($pass1 == $pass2) {
        if (isset($_POST['submit'])) {
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

            $password = hash('sha256', $_POST['pass1'] . $salt);

            for ($round = 0; $round < 65536; $round++) {
                $password = hash('sha256', $password . $salt);
            }

            $sql="UPDATE profile SET u_pass='$password', salt='$salt' WHERE User_ID='$login'";
            $result=$conn->exec($sql);

            if ($result) {
                $success = "You have changed your passcode!";
                ;
            }
        }
    } else {
        $err = "Your passwords do not match!";
    }

?>

<!--Email Popup-->
<div data-role="page" id="email" data-theme="a" data-dismissible="false" data-overlay-theme="a">

	<?php include("navHeaderPanel.php");  ?>

		<div data-role="content" style="margin-left:10%; margin-right:10%">

		Change Password (Enter twice to verify:)<br />
        <center><h3><?php echo $err;?><?php echo $success;?></h3></center><br />
		<form name='form1' method='post' action=''>
		<label for='pass1'><b>Password:</b></label>
		<input type='password' name='pass1' id='pass1' data-theme='a' value='' />
        <label for='pass2'><b>Verify:</b></label>
		<input type='password' name='pass2' id='pass2' data-theme='a' value='' />
		<input name='submit' type='submit' id='submit' value='Update!' onClick='' data-theme='a'>

		</form>

		<a href="#" data-rel="back" data-role="button" data-theme="a">Cancel</a>
		</div>

</div>
<?php include("includes/footer.php"); ?>
