<?php
require_once 'inc/inc.php';
use Models\User;
if (!isset($_SESSION['user'])) {
    header("Location: /login.php");
    exit();
}
$user = User::find($_SESSION['user']->id);
$username = $_SESSION['user']->username;
$profilePic = $_SESSION['user']->avatarUrl;
$pageHeader = "Home";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://assets.teamundefined.net/css/materialize.min.css"  media="screen,projection"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
<p>hey there <?=$user->username?></p>
</body>
</html>