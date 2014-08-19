<?php

session_start();
session_regenerate_id(true);

$username = $_GET['searchUsername'];

mysql_connect('', '', '');//Left blank to protect Chat Sphere's Database
mysql_select_db('ChatRoom');

$sql="SELECT * FROM Users WHERE Username='$username'";
$result=mysql_query($sql);

// mysqli_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){

header("Location: ../users/".$username);
echo "Success!!!";
return;

}else{header("Location: ../ChatRoom.php?Uname=NotFound");echo "Wrong Username";}

?>
