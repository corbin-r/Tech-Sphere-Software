<?php

session_start();
session_regenerate_id(true);

$myUsername = $_POST["Username"];
$myUsernameMessages = $_POST["Username"]."_MESSAGES";
$myEmail = $_POST["Email"];
$myPassword1 = md5($_POST["Password"]);
$myPassword2 = md5($_POST["ConfirmPassword"]);

if($myPassword1 != $myPassword2){
	header("Location: ../register.php?PasswordsMatch=False");
	return;
}

mysql_connect("", "", "");//Left blank to protect Chat Sphere's Database
mysql_select_db("ChatRoom");

mysql_query("INSERT INTO Users(Username, Email, Password) VALUES('". $myUsername ."', '". $myEmail ."', '". $myPassword1 ."')") or die("Add User Error! - ".mysql_error());
$sql = "CREATE TABLE `".$myUsername."`(`UPID` int(255) NOT NULL AUTO_INCREMENT,`PostBy` VARCHAR(500), `Title` VARCHAR(500),`Content` VARCHAR(500000),`Date` VARCHAR(50),`Privacy` VARCHAR(50),PRIMARY KEY (UPID))";
mysql_query($sql) or die("Create Table Error! - ".mysql_error());
$sql2 = "CREATE TABLE `".$myUsernameMessages."`(`ID` int(255) NOT NULL AUTO_INCREMENT,`PostBy` VARCHAR(500), `Title` VARCHAR(500),`Content` VARCHAR(500000),`Date` VARCHAR(50),`ThreadId` VARCHAR(50), PRIMARY KEY (ID))";
mysql_query($sql2) or die("Create Table Error! - ".mysql_error());

mkdir("../users/".$myUsername);
$index = fopen("../users/".$myUsername."/index.php", "w");


mkdir("../users/".$myUsername."/settings");
$xml = fopen("../users/".$myUsername."/settings/bio.txt", "w");

$template = file_get_contents("../templates/userTemplate.htm");
$template = str_replace("USERNAME", $myUsername, $template);
fwrite($index, $template);

$settings = '
The user has yet to fill in their Bio Info.
';
fwrite($xml, $settings);

fopen('../users/'.$myUsername.'/settings/Links.txt', "w");

fwrite('../users/'.$myUsername.'/settings/Links.txt', "");



header("Location: ../index.php?Register=Success");
echo "Success!!!";
return;

?>
