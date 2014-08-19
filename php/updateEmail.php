<?php
session_start();
session_regenerate_id();

$oldEmail = $_POST['oldEmail'];
$newEmail = $_POST['newEmail'];
$confirmNewEmail = $_POST['confirmNewEmail'];

if($newEmail != $confirmNewEmail){
	header("Location: ../settings.php?EmailsMatch=False");	
}

mysql_connect("", "", "") or die("Error - ".mysql_error());//Left blank to protect Chat Sphere's Database
mysql_select_db("ChatRoom") or die("Error - ".mysql_error());

$sql = "UPDATE `Users` SET `Email`='". $newEmail ."' WHERE `Email`='".$oldEmail."'";
mysql_query($sql) or die("Error Changing Email - ".mysql_error());

header("Location: ../settings.php?EmailChanged=True");
?>
