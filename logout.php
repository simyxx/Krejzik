<?php

session_start();
if (isset($_SESSION['krejzik_userid']))
{
    $_SESSION['krejzik_userid'] = null;
    unset($_SESSION['krejzik_userid']);
}


header("Location: login.php");