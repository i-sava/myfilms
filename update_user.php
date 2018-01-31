<?php
session_start();
if (isset($_POST['update'])) {
$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = md5($_POST['password']);

$db = mysqli_connect('localhost', 'root', '', 'myfilms');
mysqli_query($db, "UPDATE users SET username='$username', email='$email', password='$password' WHERE id=$id");
$_SESSION['message'] = "User " . $username . " updated!";
header('location: admin.php');
}

?>