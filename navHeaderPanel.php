	<div data-role="header" data-theme="a">
		<h1>recipeSTOR</h1>
		<a href="#nav-panel" data-icon="bars" data-iconpos="">Menu</a>
		<a href="settings.php" data-icon="gear" data-iconpos="notext">Settings</a>
		
	</div>
	<div data-role="panel" data-position-fixed="true" data-theme="a" id="nav-panel" data-display="overlay">
        <ul data-role="listview" data-theme="a" class="nav-search">
            <li data-icon="delete"><a href="#" data-rel="close">Close menu</a></li>
				<li><a href="index.php">Main</a></li>
				<li><a href="random.php">Random</a></li>
				<li><a href="view.php">Public Recipes</a></li>
				<li><a href="myview.php">My Recipes</a></li>
				<li><a href="add.php">Add Recipe</a></li>
				<li><a href="scheduler.php">Schedule</a></li>
				<li><a href="settings.php">Settings</a></li>
				<li><a href="about.php" data-rel="dialog">About</a></li>
				<li><a href="logout.php">Log Out - <?php echo $login; ?></a></li>
        </ul>
    </div><!-- /panel -->