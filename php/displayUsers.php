<?php

session_start();
session_regenerate_id(true);

$username = $_GET[''];

mysql_connect('', '', '');//This is left blank to protect Chat Sphere's Database.
mysql_select_db('ChatRoom');

$sql="SELECT * FROM Users WHERE Username='$username'";
$result=mysql_db_query($sql);
?>
