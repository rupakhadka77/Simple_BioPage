<?php require_once("includes/Functions.php");?>
<?php require_once("includes/Sessions.php");?>
<?php
$_SESSION["UserId"] = null;
$_SESSION["UserName"] = null;
$_SESSION["UserEmail"] = null;
session_destroy();
Redirect_to("login.php");

 ?>
