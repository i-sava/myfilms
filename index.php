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
?>
<!DOCTYPE html>
<html>
<head>
	<title>MyFilms</title>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({
                placement : 'right'
            });
        });
    </script>
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

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="profile.php">User profile</a></li>
                <li><a href="recommend_for_user.php">Recommendation for you</a></li>
                <li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>



<?php endif ?>

<div class="success text-center">LIST FILMS</div>

<table  class="table table-bordered table-hover table-striped" style="width: 50%; margin: 0 auto;">
    <thead>
    <tr class="header">

        <th class="text-center">id</th>
        <th class="text-center">title (year)</th>
        <th class="text-center">genres</th>
        <th class="text-center"></th>
        <th class="text-center"  data-toggle="tooltip" title="Average rating of film is the sum of the scores from users divided by the total number of users which rated this film.">Average Rating</th>

    </tr>
    </thead>

    <?php
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
    $view_movie_query="select * from movie LIMIT 20";//select query for viewing movies.
    $run=mysqli_query($db,$view_movie_query);//here run the sql query.


    while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
    {
        $id_movie=$row[0];
        $title=$row[1];
        $genres=$row[2];

        $avg_movie="SELECT AVG(score) from rating WHERE id_movie='$id_movie'";//select query for avg score movie.
        $avg = mysqli_query($db,$avg_movie);
        $avg = round(mysqli_fetch_array($avg)['0'],2);

        ?>

        <tr>
            <!--here showing results in the table -->
            <td class="text-center"><?php echo $id_movie;  ?></td>
            <td class="text-center"><?php echo $title;  ?></td>
            <td class="text-center"><?php echo $genres;  ?></td>
            <td class="text-center"><a  href="detail_movie.php?id_movie=<?php echo $id_movie ?> & title=<?php echo $title;  ?>"><button class="btn btn-info">Rate</button></a></td>
            <td class="text-center" data-toggle="tooltip" title="Average rating of film is the sum of the scores from users divided by the total number of users which rated this film."><?php echo $avg;  ?></td>
            

        </tr>

    <?php } ?>

</table>


<br>

<div class="success text-center">LAST SCORE FILMS</div>


<table  class="table table-bordered table-hover table-striped" style="width: 50%; margin: 0 auto;">
    <thead>
    <tr class="header">

        <th class="text-center">title</th>
        <th class="text-center">genres</th>
        <th class="text-center">user</th>
        <th class="text-center"></th>
        <th class="text-center">score</th>

    </tr>
    </thead>

    <?php
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    }
    //$db = mysqli_connect('localhost', 'root', '', 'myfilms');
    $view_movie_query2 = "SELECT movie.id, movie.title, movie.genres, users.username, rating.score FROM movie 
                          INNER JOIN rating ON movie.id = rating.id_movie left JOIN users ON rating.id_user=users.id WHERE users.id=$id ORDER BY rating.id DESC";
    $run2=mysqli_query($db,$view_movie_query2);//here run the sql query.


    while($row=mysqli_fetch_array($run2))//while look to fetch the result and store in a array $row.
    {
        $id_movie=$row['id'];
        $title=$row['title'];
        $genres=$row['genres'];
        $user=$row['username'];
        $score = $row['score'];

        ?>

        <tr>
            <!--here showing results in the table -->
            <td class="text-center"><?php echo $title;  ?></td>
            <td class="text-center"><?php echo $genres;  ?></td>
           <td class="text-center"><?php echo $user;  ?></td>
            <td class="text-center"><a  href="detail_movie.php?id_movie=<?php echo $id_movie ?> & title=<?php echo $title;  ?>"><button class="btn btn-info">Rate</button></a></td>
            <td class="text-center"><?php echo $score;  ?></td>


        </tr>

    <?php } ?>

</table>




</body>
</html>