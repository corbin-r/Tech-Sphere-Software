<?php
session_start();
session_regenerate_id(true);

$username = $_GET['searchHastag'];

mysql_connect('', '', '');//Left blank to protect Chat Sphere's Database
mysql_select_db('ChatRoom');

$sql="SELECT * FROM Hashtags WHERE `Tag`='".$username."'";
$result=mysql_query($sql);

// mysqli_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1)
{
	$username = str_replace("#", "", $username);
	header("Location: ../hashtags/".$username);
	echo "Success!!!";
	return;
}
else {header("Location: ../chatroom.php?Hashtag=NotFound");echo "Wrong hashtag";}
?>
