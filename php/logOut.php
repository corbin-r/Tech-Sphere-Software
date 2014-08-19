<?php

session_start();
session_unset();
session_destroy();

$_SESSION['loggedIn'] = 'False';
header("Location: ../index.php?LoggedIn=False");
echo "Logged Out";
?>
