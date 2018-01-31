<?php
session_start();


if (isset($_POST['rate_film'])) {
    $db = mysqli_connect('localhost', 'root', '', 'myfilms');
// receive all input values from the form
    $id_user = $_SESSION['id'];
    $id_movie=$_GET['id_movie'];
	$score = $_POST['score'];
	
   


// form validation: ensure that the form is correctly filled

    if ( empty($score) ) {
        array_push($errors, "Please rate film!");
    }
   
    
// register user if there are no errors in the form
    if (count($errors) == 0) {
        $upd = "UPDATE rating SET id_user='$id_user', id_movie='$id_movie',score='$score' WHERE id_user='$id_user' AND id_movie='$id_movie'";
        $ins = "INSERT INTO rating (id_user,id_movie,score) VALUES('$id_user', '$id_movie', '$score')";
        $select = "SELECT * FROM rating WHERE id_user=$id_user AND id_movie='$id_movie'";
        $res = mysqli_query($db, $select);

        if (mysqli_num_rows($res) == 1) {
            mysqli_query($db, $upd);
            $_SESSION['message'] = "Rating " . " update!";
        } else {
            mysqli_query($db, $ins);
            $_SESSION['message'] = "Film " . " Rated!";

        }


        //mysqli_query($db, $query);
        //$_SESSION['message'] = "Film Rated " . $score . " . ";
        //unset($_POST['score']);
        //$url = "detail_movie.php?id_movie=" . $id_movie;
        //header ('Location: index.php');

    }

    unset($_POST['score']);
    header('Location: detail_movie.php?id_movie=' . $id_movie);
}
?>
