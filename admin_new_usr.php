<?php
    /*
    Author:  Drew D. Lenhart
    http://www.snowytech.com
    Page: admin_new_usr.php
    Desc: Create new users.
    */
    require("includes/connPDO.php");
    session_start();
    $auth= $_SESSION['auth'];
    $login= $_SESSION['User_ID'];
    $check_lvl = $_SESSION['usr_lvl'];
    if ($auth != "yes") {
        header("Location: login_svs.php");
        exit();
    }

    if (!empty($_POST)) {
        if (empty($_POST['username'])) {
            die("Please enter a username.");
        }

        if (empty($_POST['password'])) {
            die("Please enter a password.");
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            die("Invalid E-Mail Address");
        }

        $query = "
            SELECT
                1
            FROM profile
            WHERE
                User_ID = :username
        ";

        $query_params = array(
            ':username' => $_POST['username']
        );

        try {
            $stmt = $conn->prepare($query);
            $result = $stmt->execute($query_params);
        } catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $row = $stmt->fetch();
        if ($row) {
            die("This username is already in use");
        }
        $query = "INSERT INTO profile (User_ID, u_pass, salt, first_name, last_name, email, usr_lvl) VALUES (:username, :password, :salt, :firstname, :lastname, :email, :level)";

        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

        $password = hash('sha256', $_POST['password'] . $salt);

        for ($round = 0; $round < 65536; $round++) {
            $password = hash('sha256', $password . $salt);
        }

        $query_params = array(
            ':username' => $_POST['username'],
            ':password' => $password,
            ':salt' => $salt,
            ':firstname' => $_POST['firstname'],
            ':lastname' => $_POST['lastname'],
            ':email' => $_POST['email'],
            ':level' => $_POST['level'],
        );

        try {
            $stmt = $conn->prepare($query);
            $result = $stmt->execute($query_params);
        } catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        header("Location: settings.php");
        die("Redirecting to settings.php");
    }

?>
<?php include("includes/header.php"); ?>
<div data-role="page" id="about" data-theme="a" data-dismissible="false" data-overlay-theme="a">
<?php include("navHeaderPanel.php");  ?>

		<div data-role="content" style="margin-left:10%; margin-right:10%">

<h1>Create New User</h1>
**Need to create user access for someone?  Perhaps you need to create a super user account, do so here:<br /><br />
<?php
require("includes/connPDO.php");
//Check if this person has SU access.
$sth2 = $conn->query("SELECT * FROM profile where User_ID = '$login'");
    if (!$sth2) {
        die("Database query failed: ERR NOlevelCheck");
    }
// Set fetching mode
$sth2->setFetchMode(PDO::FETCH_ASSOC);
$row2  = $sth2 -> fetch();

$check_lvl = $row2['usr_lvl'];

if ($check_lvl == 1 || $check_lvl > 0) {
    echo "<br />";
    echo "<center>";
    echo $success;
    echo $error;
    echo "</center>";
    echo "<br />";
    echo "<br />";
    echo "<form action='admin_new_usr.php' method='POST'>";
    echo "* User name:<input type= 'text' name='username' value='' size '20' maxlength='30'>";
    echo "* Password:<input type= 'password' name='password' value='' size '20' maxlength='30'>";
    echo "* First Name:<input type= 'text' name='firstname' value='' size '20' maxlength='30'>";
    echo "* Last Name:<input type= 'text' name='lastname' value='' size '20' maxlength='30'>";
    echo "* Email:<input type= 'text' name='email' value='' size '20' maxlength='30'>";
    echo "<label for='level'><b>Make this user a super user?:</b></label>";
    echo "<select name='level' id='level' class='group' data-theme'a' data-native-menu='false' data-mini='true' data-inline='true'>";
    echo "<option value='0'>no</option>";
    echo "<option value='1'>yes</option>";
    echo "</select><br />";
    echo "<br><input type='submit'value='Submit'>";
    echo "<a href='settings.php' data-role='button' data-theme='a'>Cancel</a>";
} else {
    echo "You do not have permissions to access this page" . $check_lvl;
}
?>

</form>

	</div>

</div>

<?php include("includes/footer.php"); ?>
