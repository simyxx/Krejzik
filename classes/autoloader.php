<?php 
session_start();

include("classes/connect.php");
include("classes/login.class.php");
include("classes/user.class.php");
include("classes/post.class.php");
include("classes/image.class.php");
include("classes/profile.class.php");

// Získaní username
$user = new User();
$userData = $user->getData($_SESSION['krejzik_userid']);

$USER = $userData; // Přihlášený uživatel a jeho data