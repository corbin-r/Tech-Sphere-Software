<?php

session_start();
session_regenerate_id();

mysql_connect("", "", "") or die(mysql_error());//Left blank to protect Chat Sphere's Database
mysql_select_db("ChatRoom") or die(mysql_error());


$myUsername = $_SESSION['Username'];
$postTitle = $_POST['title'];
$postContent = $_POST['postbox'];

$postTitle = str_replace("'", "&apos;", $postTitle);
$postContent = str_replace("'", "&apos;", $postContent);
$postTitle = str_replace("\"", "&quot;", $postTitle);
$postContent = str_replace("\"", "&quot;", $postContent);

$postPrivacy = $_POST['privacy'];

$sql3 = "INSERT INTO PublicBlog(`PostBy`, `Title`, `Content`, `Date`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."')";

$sql2 = "INSERT INTO ".$myUsername."(`PostBy`, `Title`, `Content`, `Date`, `Privacy`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."', '".$postPrivacy."')";

$sql1 = "INSERT INTO ".$myUsername."(`PostBy`, `Title`, `Content`, `Date`, `Privacy`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."', '".$postPrivacy."')";

if (preg_match_all('/(?<!\w)#(\w+)/', $postContent, $matches)){
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
		if(!mysql_query($sql4)){
			$sql5 = "INSERT INTO `$hash`(`PostBy`, `Title`, `Content`, `Date`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."')";
			mysql_query($sql5);
			if($postPrivacy == "Private"){
				mysql_query($sql1) or die(mysql_error());
			}elseif($postPrivacy == "Public"){
				mysql_query($sql2) or die(mysql_error());
				mysql_query($sql3) or die(mysql_error());
			}

			//echo $sql1."<br>".$sql2."<br>".$sql3;

			if (preg_match_all('/(?<!\w)@(\w+)/', $postContent, $matches))
			{
			  $users = $matches[1];
			  // $users should now contain array: ['SantaClaus', 'Jesus']
			  foreach ($users as $user)
			  {
			      mysql_connect('', '', '');//Left blank to protect Chat Sphere's Database
			      mysql_select_db('ChatRoom');

			      $sql="SELECT * FROM Users WHERE Username='".$user."'";
			      $result=mysql_query($sql);

			      // mysqli_num_row is counting table row
			      $count=mysql_num_rows($result);

			      // If result matched $myusername and $mypassword, table row must be 1 row
				  $sql = "INSERT INTO ".$user."_MESSAGES(`PostBy`, `Title`, `Content`, `Date`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."')";


			      if($count==1){
			        mysql_query($sql) or die(mysql_error());
			      }
			  }
			}

			header("Location: ../chatroom.php?NewPost=Success");
			return;

		}

		mysql_query("INSERT INTO Hashtags(Tag) VALUES('$hash')") or die("Add User Error! - ".mysql_error());

		$sql5 = "INSERT INTO `$hash`(`PostBy`, `Title`, `Content`, `Date`) VALUES ('$myUsername', '$postTitle', '$postContent', '".date(r)."')";
		mysql_query($sql5);
        
      }else{
      	$sql5 = "INSERT INTO `$hash`(`PostBy`, `Title`, `Content`, `Date`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."')";
		mysql_query($sql5);
      }
  }
}

if (preg_match_all('/(?<!\w)@(\w+)/', $postContent, $matches))
{
  $users = $matches[1];
  // $users should now contain array: ['SantaClaus', 'Jesus']
  foreach ($users as $user)
  {
      mysql_connect('', '', '');//Left blank to protect Chat Sphere's Database
      mysql_select_db('ChatRoom');

      $sql="SELECT * FROM Users WHERE Username='".$user."'";
      $result=mysql_query($sql);

      // mysqli_num_row is counting table row
      $count=mysql_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row
	  $sql = "INSERT INTO ".$user."_MESSAGES(`PostBy`, `Title`, `Content`, `Date`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."')";


      if($count==1){
        mysql_query($sql) or die(mysql_error());
      }
  }
}

$sql3 = "INSERT INTO PublicBlog(`PostBy`, `Title`, `Content`, `Date`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."')";

$sql2 = "INSERT INTO ".$myUsername."(`PostBy`, `Title`, `Content`, `Date`, `Privacy`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."', '".$postPrivacy."')";

$sql1 = "INSERT INTO ".$myUsername."(`PostBy`, `Title`, `Content`, `Date`, `Privacy`) VALUES ('".$myUsername."', '".$postTitle."', '".$postContent."', '".date(r)."', '".$postPrivacy."')";


if($postPrivacy == "Private"){
	mysql_query($sql1) or die(mysql_error());
}elseif($postPrivacy == "Public"){
	mysql_query($sql2) or die(mysql_error());
	mysql_query($sql3) or die(mysql_error());
}

//echo $sql1."<br>".$sql2."<br>".$sql3;

header("Location: ../chatroom.php?NewPost=Success");

?>
