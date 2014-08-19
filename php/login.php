<?php

session_start();
session_regenerate_id(true);

$myEmail = $_POST['Email'];
$myPassword = md5($_POST['Password']);

mysql_connect('', '', '');//Left blank to protect Chat Sphere's Database
mysql_select_db('ChatRoom');

$sql="SELECT * FROM Users WHERE Email='$myEmail' and Password='$myPassword'";
$result=mysql_query($sql);

// mysqli_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){

while($row = mysql_fetch_assoc($result)){
$table[] = $row;
}

$_SESSION['Username'] = $table[0]['Username'];

$_SESSION['loggedIn'] = 'True';

header("Location: ../chatroom.php");
echo "Success!!!";
return;

}
else {
header("Location: ../register.php?UnamePass=Incorect");
echo "Wrong Username or Password";
$_SESSION['loggedIn'] = 'False';
}

?>
