<?php 
session_start();
$errors = array();
  

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
?>
<!DOCTYPE html>
<html>
<head>
	<title>MyFilms</title>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
	
</head>
<body>

<div class="header">
	<h2>MyFilms</h2>
</div>
<div class="">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<p>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</p>
      </div>
  	<?php endif ?>



</div>

<?php  if (isset($_SESSION['username'])) : ?><!-- logged in user information -->

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



<?php endif ?>

<table  class="table table-bordered table-hover table-striped" style="width: 50%; margin: 0 auto;">
    <thead>
    <tr class="header">

        <th class="text-center">id</th>
        <th class="text-center">title (year)</th>
        <th class="text-center">genres</th>
        <th class="text-center">Your rating</th>
        <th class="text-center">Average rating</th>

    </tr>
    </thead>

    <?php
	$id_movie=$_GET['id_movie'];
	//$_SESSION['id_movie']=$_GET['id_movie'];
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
    $view_movie_query="select * from movie WHERE id=$id_movie";//select query for viewing movies.
    $run=mysqli_query($db,$view_movie_query);//here run the sql query.





    while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
    {
        $id_movie=$row[0];
        $title=$row[1];
        $genres=$row[2];
        $id_user=$_SESSION['id'];
        $score_query="SELECT score from rating WHERE id_movie='$id_movie' and id_user=$id_user";
        $score = mysqli_query($db,$score_query);
        $score = round(mysqli_fetch_array($score)['0'],2);



        $avg_movie="SELECT AVG(score) from rating WHERE id_movie='$id_movie'";//select query for avg score movie.
        $avg = mysqli_query($db,$avg_movie);
        $avg = round(mysqli_fetch_array($avg)['0'],2);


        ?>

        <tr>
            <!--here showing results in the table -->
            <td class="text-center"><?php echo $id_movie;  ?></td>
            <td class="text-center"><?php echo $title;  ?></td>
            <td class="text-center"><?php echo $genres;  ?></td>
            <td class="text-center"><?php echo $score;  ?></td>
            <td class="text-center"><?php echo $avg;  ?></td>

        </tr>

    <?php } ?>

</table>
<?php include('errors.php'); ?>
<form method="post" action="rate_film.php?id_movie=<?php echo $id_movie ?>" >

    <div class="input-group">
        <label>Rate Film!</label>
        <select name="score">
			<option value="">--</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
    </div>
    <div class="input-group">
        <button class="btn" type="submit" name="rate_film" >Rate!</button>
    </div>
</form>

<?php

if (!empty($_SESSION['message'])) {?>
    <p class="bg-danger"> <?php echo $_SESSION['message']; ?><p>

    <?php } ?>
		
</body>
</html>