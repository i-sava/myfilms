<?php
session_start();
$errors = array();

if (isset($_POST['add_user'])) {
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
// receive all input values from the form
    $add_username = mysqli_real_escape_string($db, $_POST['username']);
    $add_email = mysqli_real_escape_string($db, $_POST['email']);
    $add_password = mysqli_real_escape_string($db, $_POST['password']);


// form validation: ensure that the form is correctly filled

    if (empty($add_username)) {
        array_push($errors, "Username is required");
    }
    if (empty($add_email)) {
        //array_push($errors, "Email is required");
        $add_email='';
    }
    if (empty($add_password)) {
        array_push($errors, "Password is required");
    }

// register user if there are no errors in the form
    if (count($errors) == 0) {
        $add_password = md5($add_password);//encrypt the password before saving in the database
        $query = "INSERT INTO users (username, email, password) VALUES('$add_username', '$add_email', '$add_password')";
        mysqli_query($db, $query);
    }
    $_SESSION['message'] = "User " . $add_username . " was added!";
    header("Location: admin.php");

}
unset($_POST['add_user']);

?>


<!DOCTYPE html>
<html>
<head>
    <title>
        List users
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





<form class="navbar-form" method="post" action="add_user.php">
    <?php include('errors.php'); ?>
    <div class="form-group">

        <label>Username</label>
        <input class="form-control" type="text" name="username" value="" required>


        <label>Email</label>
        <input class="form-control" type="email" name="email" value="">


        <label>Password</label>
        <input  class="form-control"type="password" name="password" required>

        <button type="submit" class="btn btn-default" name="add_user">Add user</button>

    </div>

</form>

</body>

</html>