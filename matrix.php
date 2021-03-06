<?php
session_start();

if( !($_SESSION['username'] == 'admin'))
{
    header("Location: login.php");//redirect to login page to secure the welcome page without login access.
}


$db = mysqli_connect('localhost', 'root', '', 'myfilms');
$rows=mysqli_query($db, "SELECT * FROM rating INNER JOIN movie ON rating.id_movie=movie.id");


$users_rating_films = array();
$matrix = array();
while ($row=mysqli_fetch_array($rows))
{
    //$query = "SELECT movie.id, movie.title, users.id, users.username, rating.score FROM movie INNER JOIN rating
    // ON movie.id = rating.id_movie left JOIN users ON rating.id_user=users.id WHERE users.id=$movie[id_user]";

    $id_user=$row['id_user'];
    $user=mysqli_query($db, "SELECT username FROM users WHERE id=$id_user");
    $user=mysqli_fetch_array($user)['username'];

    $users_rating_films[$user] = $user;
    $matrix[$user][$row['title']]=$row['score'];
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

<body class="intro">

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
                <li><a href="matrix.php">System Recommendation</a></li>
				<li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
    </div><!-- /.container-fluid -->
</nav>








<form method="get" action="matrix.php" >

    <div class="input-group">
        <label>Choose given user  for recommendation</label>
        <select name="user">
            <?php
                foreach ($users_rating_films as $user) { ?>
              <option value = "<?php echo $user; ?>"><?php echo $user; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="input-group">
        <label>Users KNN, value K =</label>
        <input type="number" name="K"  min="1" max=<?php echo count($users_rating_films)-1 ?> step="1" value="2" style="width: auto;">
    </div>

    <div class="input-group">
        <label>Number films for recommendation, value M = </label>
        <input type="number" name="M"  min="1" max="5" step="1" value="1" style="width: auto;">
    </div>

    <div class="input-group">
        <button class="btn" type="submit"  >Get recommendation</button>
    </div>
</form>






<?php

include("recommend.php");


if (isset($_GET['user'])){ ?>

    <br>
    <div class="center-block" style="width: 50%;">
        <div class="panel panel-primary result">
            <div class="panel-heading">
                <h3 class="panel-title">KNN users  for  <?php echo $_GET['user']; ?>, where  K = <?php echo $_GET['K']; ?></h3>
            </div>
            <div class="panel-body">
                <?php
                echo "<pre>";
                print_r(getSimilar($matrix, $_GET['user'],$_GET['K']));
                echo "</pre>";
                ?>

        </div>
        </div>
    </div>
    <?php
    //echo "<pre>";
    //print_r(getMatrixKNN($matrix, $_GET['user'], $_GET['K']));
   //echo "</pre>";

    $matrix=getMatrixKNN($matrix,  $_GET['user'], $_GET['K']);
    ?>


    <div class="center-block" style="width: 50%;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Films recommendation for  <b><?php echo $_GET['user']; ?></b>, where  M = <?php echo $_GET['M']; ?> </h3>
            </div>
            <div class="panel-body">
                <?php
                echo "<pre>";
                getRecommendation($matrix, $_GET['user'], $_GET['M']);
                echo "</pre>";
                ?>

            </div>
        </div>
    </div>
<?php
}
?>



<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">MATRIX SCORES</h3>
    </div>
    <div class="panel-body">
        <?php
        echo "<pre>";
        print_r($matrix);
        echo "</pre>";
        ?>

    </div>
</div>

</body>

</html>