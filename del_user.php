<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'myfilms');
$delete_id = $_GET['user_id'];
$username = $_GET['username'];

$delete_query="delete  from users WHERE id='$delete_id'";//delete query
$run=mysqli_query($db,$delete_query);
if($run)
{

    $_SESSION['message'] = "User " . $username . " was deleted!";
    //javascript function to open in the same window
    //echo "<script>window.open('admin.php','_self')</script>";
    header('location: admin.php');

}



