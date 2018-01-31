<?php
session_start();

if( !($_SESSION['username'] == 'admin'))
{
    header("Location: login.php");//redirect to login page to secure the welcome page without login access.
}

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
                <li class="active"><a href="admin.php">Admin profile</a></li>
                <li><a href="list_users.php">List users</a></li>
                <li><a href="add_user.php">Add user</a></li>
                <li><a href="add_film.php">Add film</a></li>
                <li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>






<div class="table-scrol">
    <h3 class="bg-primary text-center">List all the Users </h3>


    <div class="table-responsive"><!--this is used for responsive display in mobile and other devices-->

<table  class="table table-bordered table-hover table-striped">
    <thead>
    <tr>

        <th class="text-center">User Id</th>
        <th class="text-center">User Name</th>
        <th class="text-center">User E-mail</th>
        <th class="text-center">Profile</th>
        <th class="text-center">Edit User</th>
        <th class="text-center">Delete User</th>
    </tr>
    </thead>

    <?php
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
    $view_users_query="select * from users";//select query for viewing users.
    $run=mysqli_query($db,$view_users_query);//here run the sql query.



    while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
    {
        $user_id=$row[0];
        $user_name=$row[1];
        $user_email=$row[2];
        $user_pass=$row[3];

        ?>

        <tr>
            <!--here showing results in the table -->
            <td class="text-center"><?php echo $user_id;  ?></td>
            <td class="text-center"><?php echo $user_name;  ?></td>
            <td class="text-center"><?php echo $user_email;  ?></td>
            <td class="text-center"><a  href="profile.php?user_id=<?php echo $user_id ?>"><button class="btn btn-info">Profile</button></a></td>
            <td class="text-center"><a href="edit_user.php?user_id=<?php echo $user_id ?> & username=<?php echo $user_name;  ?>"><button class="btn btn-info">Edit</button></a></td>
            <td class="text-center"><a href="del_user.php?user_id=<?php echo $user_id ?> & username=<?php echo $user_name;  ?> "><button class="btn btn-danger">Delete</button></a></td> <!--btn btn-danger is a bootstrap button to show danger-->
        </tr>

    <?php } ?>

</table>
    </div>
</div>

</body>

</html>