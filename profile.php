<?php
session_start();
$errors = array();


if(!isset($_SESSION['username']))
{
    header("Location: login.php");//redirect to login page to secure the welcome page without login access.
}

if ($_SESSION['username'] == 'admin')
{
    header("Location: admin.php");//redirect to login page to secure the welcome page without login access.
}

$user_id = $_SESSION['id'];

if (isset($_POST['fg'])) {
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
// receive all input values from the form
    $fg1 = $_POST['fg1'];
    $fg2 = $_POST['fg2'];
	$fg3 = $_POST['fg3'];
	
    $upd = "UPDATE fav_genres SET fg1='$fg1', fg2='$fg2', fg3='$fg3' WHERE id_user='$user_id'";
	$ins = "INSERT INTO fav_genres (id_user, fg1, fg2, fg3) VALUES('$user_id', '$fg1', '$fg2', '$fg3')";
	$select = "SELECT * FROM fav_genres WHERE id_user=$user_id";
	$res = mysqli_query($db, $select);
	//$res = mysqli_fetch_array($res);
	if (mysqli_num_rows($res) == 1) {
		mysqli_query($db, $upd);
		$_SESSION['message'] = "Genres " . " update!";
} else {
        mysqli_query($db, $ins);
		$_SESSION['message'] = "Genres " . " insert!";
		
}
	
	unset($_POST['fg']);
	//header("Location: profile.php");
	
	
}
			?>
		


<html>
<head>
    <title>
        Profile
    </title>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<div class="header">
    <h2>User profile </h2>
</div>
<p class="bg-primary text-center"> Welcome, <?php echo $_SESSION['username']; ?><p>
<p class="bg-primary text-center"> id = <?php echo $_SESSION['id']; ?><p>
<nav class="navbar navbar-default">
    <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="profile.php">User profile</a></li>
                <li><a href="index.php">List Film</a></li>

				<li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
    </div><!-- /.container-fluid -->
</nav>




<form method="post" action="profile.php" >
    <div class="input-group">
        <label>Your Favourite Genres 1</label>
        <select name="fg1">
			<option value="Maroon">Maroon</option>
			<option value="Green">Green</option>
			<option value="Yellow">Yellow</option>
			<option value="Blue">Blue</option>
			<option value="Red">Red</option>
		</select>
    </div>
	<div class="input-group">
        <label>Your Favourite Genres 2</label>
        <select name="fg2">
			<option value="Maroon">Maroon</option>
			<option value="Green">Green</option>
			<option value="Yellow">Yellow</option>
			<option value="Blue">Blue</option>
			<option value="Red">Red</option>
		</select>
    </div>
	<div class="input-group">
        <label>Your Favourite Genres 3</label>
        <select name="fg3">
			<option value="Maroon">Maroon</option>
			<option value="Green">Green</option>
			<option value="Yellow">Yellow</option>
			<option value="Blue">Blue</option>
			<option value="Red">Red</option>
		</select>
    </div>
    <div class="input-group">
        <button class="btn" type="submit" name="fg" >Save</button>
    </div>
</form>
<?php

if (!empty($_SESSION['message'])) {?>
    <p class="bg-danger"> <?php echo $_SESSION['message']; ?><p>

    <?php } ?>


</body>

</html>