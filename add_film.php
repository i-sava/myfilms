<?php
session_start();
$errors = array();

if (isset($_POST['add_film'])) {
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
// receive all input values from the form
    $add_title = $_POST['title'];
    $add_genres = $_POST['genres'];
   


// form validation: ensure that the form is correctly filled

    if (empty($add_title)) {
        array_push($errors, "Title is required");
    }
    if (empty($add_genres)) {
        array_push($errors, "Genres is required");
    }
    
// register user if there are no errors in the form
    if (count($errors) == 0) {
        $query = "INSERT INTO movie (title,genres) VALUES('$add_title', '$add_genres')";
        mysqli_query($db, $query);
        $_SESSION['message'] = "Film " . $add_title . " was added!";
		unset($_POST['add_film']);
		header("Location: admin.php");
		
}
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>
        Add film
    </title>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

<div class="header">
    <h2>MyFilms Panel Admin</h2>
</div>


<p class="bg-primary text-center"> Welcome, <?php echo $_SESSION['username']; ?><p>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="admin.php">Admin profile</a></li>
                <li><a href="list_users.php">List users</a></li>
                <li><a href="add_user.php">Add user</a></li>
                <li><a href="add_film.php">Add film</a></li>
                <li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>





<form class="navbar-form" method="post" action="add_film.php">
    <?php include('errors.php'); ?>
    <div class="form-group">

        <label>Title</label>
        <input class="form-control" type="text" name="title" value="" >


        <label>genres</label>
        <input class="form-control" type="text" name="genres" value="" >


   

        <button type="submit" class="btn btn-default" name="add_film">Add film</button>

    </div>

</form>

</body>

</html>