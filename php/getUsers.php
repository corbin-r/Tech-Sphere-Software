<?php

session_start();
session_regenerate_id(true);

// Connect to server and select databse.
mysql_connect("", "", "")or die("cannot connect");//Left blank to protect Chat Sphere's Database
mysql_select_db("ChatRoom");

$sql = "SELECT * FROM Users";
$result = mysql_query($sql) or die("Query Error - ".mysql_error());

$table = array();

while($row = mysql_fetch_assoc($result)){
$table[] = $row;
}

for($i=0; $i<count($table); $i--){

  $Username = $table[$i]['Username'];

  echo '
  <div class=" well">
   <a href="../users/'.$Username.'">'.$Username.'</a>
  </div>
  ';
}

?>
