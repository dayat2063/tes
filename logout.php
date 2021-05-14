<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('id','', time() - 3660);
setcookie('key','',time() - 3660);
setcookie('name','',time() - 3660);

header("location: login.php");
exit;

?>