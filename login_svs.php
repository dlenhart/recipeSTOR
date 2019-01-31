<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: login_svs.php
    Desc: Login script.
    */
    session_start();
    require("includes/connPDO.php");
    include("includes/libClean.php");
    $loginName=strip_tags(sqlClean($_POST['username']));

    $submitted_username = '';

    if (!empty($_POST)) {
        $query = " SELECT User_ID, u_pass, salt, email FROM profile WHERE User_ID = :username";

        // The parameter values
        $query_params = array(
            ':username' => $_POST['username']
        );

        try {
            // RUN query!!!!
            $stmt = $conn->prepare($query);
            $result = $stmt->execute($query_params);
        } catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        // logged in? false to init
        $login_ok = false;

        $row = $stmt->fetch();
        if ($row) {
            $check_password = hash('sha256', $_POST['password'] . $row['salt']);
            for ($round = 0; $round < 65536; $round++) {
                $check_password = hash('sha256', $check_password . $row['salt']);
            }

            if ($check_password === $row['u_pass']) {
                // Password is correct, make true
                $login_ok = true;
            }
        } else {
            $err_uname = "Incorrect Username!";
        }

        // Success, now redirect
        if ($login_ok) {
            unset($row['salt']);
            unset($row['u_pass']);

            $_SESSION['auth']="yes";
            $_SESSION['User_ID']=$loginName;

            if ($_SESSION['location']=="" or $_SESSION['location']=="index.php") {
                header("Location: index.php");
            }
            //die("redirecting....");
        } else {
            //Password failure
            $err_pass = "Incorrect password!";
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        }
    }

?>

<?php include("includes/header.php"); ?>
<!--login View-->
<div data-role="page" id="login" class = "login" data-theme="a">
	<div data-role="header" data-theme="a">
		<h1>recipeSTOR Login</h1>


	</div>
   <div data-role="content" style="margin-left:20%; margin-right:20%">

		<form action='login_svs.php' method='POST'>
			Username: <b><?php echo $err_uname; ?></b><br />
			<input type= 'text' name='username' value="<?php echo $submitted_username; ?>" />
			Password: <b><?php echo $err_pass; ?></b><br />
			<input type= 'password' name='password' />
			<br />
			<input type='submit' value='Login' name="go" data-theme="a">
			<input type="reset" id="cancel" name="reset" value="Reset" data-theme="a">
		</form><br /><br />

		<center>Sorry this site is not accepting new users at this time.<br />
		<img src="images/sticon.png" width="64" height="64" alt="" /></center>
	</div>
</div>

</body>
</html>
