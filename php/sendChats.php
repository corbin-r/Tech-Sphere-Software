<?php

session_start();
session_regenerate_id();

mysql_connect("", "", "") or die(mysql_error());//Left blank to protect Chat Sphere's Database
mysql_select_db("ChatRoom") or die(mysql_error());


$From = $_SESSION['Username'];
$Title = $_POST['Title'];
$To = $_POST['ToUser'];
$Message  = $_POST['Message'];

$Title = str_replace("'", "&apos;", $Title);
$Message = str_replace("'", "&apos;", $Message);
$Title = str_replace("\"", "&quot;", $Title);
$Message = str_replace("\"", "&quot;", $Message);

$sql1 = "INSERT INTO ".$To."_MESSAGES(`PostBy`, `Title`, `Content`, `Date`) VALUES ('".$From."', '".$Title."', '".$Message."', '".date(r)."')";

if (preg_match_all('/(?<!\w)#(\w+)/', $Message, $matches)){
  $hashtags = $matches[1];
  // $users should now contain array: ['SantaClaus', 'Jesus']
  foreach ($hashtags as $hash)
  {
      mysql_connect('', '', '');//Left blank to protect Chat Sphere's Database
      mysql_select_db('ChatRoom');

      $hashtag = "#".$hash;

      $sql="SELECT * FROM Hashtags WHERE Tag=`".$hashtag."`";
      $result=mysql_query($sql);

      // mysqli_num_row is counting table row
      $count=mysql_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count!=1){
      	mkdir("../hashtags/".$hash);
      	$index = fopen("../hashtags/".$hash."/index.php", "w");
      	$hash = ("#".$hash);
      	$template = file_get_contents("../templates/hashTemplate.htm");
		$template = str_replace("HASHTAG", $hash, $template);
		fwrite($index, $template);
		fclose();

      	$sql4 = "CREATE TABLE `".$hash."`(`UPID` int(255) NOT NULL AUTO_INCREMENT,`PostBy` VARCHAR(500), `Title` VARCHAR(500),`Content` VARCHAR(500000),`Date` VARCHAR(50),`Privacy` VARCHAR(50),PRIMARY KEY (UPID))";

		mysql_query("INSERT INTO Hashtags(Tag) VALUES('$hash')") or die("Add User Error! - ".mysql_error());
        
      }
  }
}


mysql_query($sql1) or die(mysql_error());

//echo $sql1."<br>".$sql2."<br>".$sql3;

header("Location: ../chatboard.php?NewPost=Success");

?>
