<?php
session_start();
if (isset($_GET['user_id'])) {
    $id = $_GET['user_id'];
    $update = true;
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
    $record = mysqli_query($db, "SELECT * FROM users WHERE id=$id");

    if (count($record) == 1 ) {
        $row = mysqli_fetch_array($record);
        $username = $row['username'];
        $email = $row['email'];

    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>
        List users
    </title>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.css">

</head>

<body>

<h1 class="bg-primary text-center">Panel Admin</h1>

<p> Welcome, <?php echo $_SESSION['username']; ?><p>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="admin.php">Admin profile</a></li>
                <li><a href="list_users.php">List users</a></li>
                <li><a href="add_users.php">Add user</a></li>
                <li><a href="add_film.php">Add film</a></li>
                <li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>

<form class="navbar-form navbar-left"  METHOD="post" action="update_user.php">
    <div class="form-group">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="enter new email">
        <input type="text" class="form-control" name="password" value="" placeholder="enter new password" required>
        <button type="submit" class="btn btn-default" name="update">Save</button>
    </div>
</form>


</body>

</html>









