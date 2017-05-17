<?php
require_once("../../includes/initialize.php");
session_start();
$session = Session::getInstance();
$session->logout();
redirect_to("login.php");
?>
