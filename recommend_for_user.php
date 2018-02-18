<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['logins']);
    header("location: login.php");
}

$db = mysqli_connect('localhost', 'root', '', 'myfilms');
$rows=mysqli_query($db, "SELECT * FROM rating INNER JOIN movie ON rating.id_movie=movie.id");


$users_rating_films = array();
$matrix = array();
while ($row=mysqli_fetch_array($rows))
{
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
    <h2>User profile </h2>
</div>


<p class="bg-primary text-center"> Welcome, <?php echo $_SESSION['username'] . '  id=' . $_SESSION['id']; ?><p>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="profile.php">User profile</a></li>
                <li><a href="index.php">List Film</a></li>
                <li><a href="recommend_for_user.php">Recommendation for you</a></li>
                <li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>







<form method="get" action="recommend_for_user.php" >


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


if (isset($_GET['M'])){ ?>

    <br>
    <div class="center-block" style="width: 50%;">
        <div class="panel panel-primary result">
            <div class="panel-heading">
                <h3 class="panel-title">KNN users  for  <?php echo $_SESSION['username']; ?>, where  K = <?php echo $_GET['K']; ?></h3>
            </div>
            <div class="panel-body">
                <?php
                echo "<pre>";
                print_r(getSimilar($matrix,  $_SESSION['username'], $_GET['K']));
                echo "</pre>";
                ?>

        </div>
        </div>
    </div>
    <?php
    //echo "<pre>";
    //print_r(getMatrixKNN($matrix, $_GET['user'], $_GET['K']));
   //echo "</pre>";

    $matrix=getMatrixKNN($matrix,  $_SESSION['username'], $_GET['K']);
    ?>


    <div class="center-block" style="width: 50%;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Films recommendation for  <b><?php echo $_SESSION['username']; ?></b>, where  M = <?php echo $_GET['M']; ?> </h3>
            </div>
            <div class="panel-body">
                <?php
                echo "<pre>";
                getRecommendation($matrix, $_SESSION['username'], $_GET['M']);
                echo "</pre>";
                ?>

            </div>
        </div>
    </div>
<?php
}
?>





</body>

</html>