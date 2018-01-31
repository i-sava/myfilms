<?php

session_start();



if( !($_SESSION['username'] == 'admin'))
{
    header("Location: login.php");//redirect to login page to secure the welcome page without login access.
}


$db = mysqli_connect('localhost', 'root', '', 'myfilms');

$movies=mysqli_query($db, "SELECT * FROM rating");
$matrix = array();

while ($movie=mysqli_fetch_array($movies))
{
    $query = "SELECT movie.id, movie.title, users.username, rating.score FROM movie 
                          INNER JOIN rating ON movie.id = rating.id_movie left JOIN users ON rating.id_user=users.id WHERE users.id=$movie[id_user]";

    //$users=mysqli_query($db, "SELECT username, FROM users WHERE id=$movie[id_user]");
    $users=mysqli_query($db, $query);
    $username=mysqli_fetch_array($users);

    $matrix[$username['username']][$movie['id_movie']]=$movie['score'];


}


?>


<!DOCTYPE html>
<html>
<head>
    <title>
        Matrix
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
                <li><a href="index.php">List Film</a></li>
                <li><a href="matrix.php">Matrix Score</a></li>
				<li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
    </div><!-- /.container-fluid -->
</nav>

<?php if (!empty($_SESSION['message'])) {?>
    <p class="bg-danger"> <?php echo $_SESSION['message']; ?><p>

<?php } ?>


<?php

echo "<pre>";

print_r($matrix);

echo "</pre>";

include("recommend.php");



var_dump(getSimilar($matrix, "admin",3));
echo '<br>';

var_dump(getRecommendation($matrix,"admin",2));

?>

</body>

</html>