<?php

session_start();
session_regenerate_id(true);

function autolink($str, $attributes=array()) {
$attrs = '';
foreach ($attributes as $attribute => $value) {
  $attrs .= " {$attribute}=\"{$value}\"";
}

$str = ' ' . $str;
$str = preg_replace(
  '`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
  '$1<div class"embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" src="$2"'.$attrs.'></iframe><br><a href="$2"><button class="btn btn-info">Go Here</button></a></div>',
  $str
);
$str = substr($str, 1);

return $str;
}

$myUsername = $_SESSION['Name'];

// Connect to server and select databse.
mysql_connect("", "", "")or die("cannot connect");//Left blank to protect Chat Sphere's Database
mysql_select_db("ChatRoom");

$sql = "SELECT * FROM $myUsername";
$result = mysql_query($sql) or die("Querry Error - ".mysql_error());

$table = array();

while($row = mysql_fetch_assoc($result)){
$table[] = $row;
}

for($i=count($table)-1; $i>=0; $i--){

$Title = $table[$i]['Title'];
$Date = $table[$i]['Date'];
$PostBy = $table[$i]["PostBy"];
$Content = $table[$i]['Content'];

$Content = autolink($Content);
$Content = str_replace("!IMPORTANT", "<div class='alert alert-danger'>IMPORTANT!</div>", $Content);


if (preg_match_all('/(?<!\w)@(\w+)/', $Content, $matches))
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

      if($count==1){
        $word = ("@".$user);
        $Content = str_replace($word, " <a href='users/$user'>$word</a> ", $Content);
      }else{
        $word = ("@".$user);
        $Content = str_replace($word, " $word ", $Content);
      }
  }
}

if (preg_match_all('/(?<!\w)#(\w+)/', $Content, $matches)){
$hashtags = $matches[1];
// $users should now contain array: ['SantaClaus', 'Jesus']
foreach ($hashtags as $hash)
{
    mysql_connect('', '', '');//Left blank to protect Chat Sphere's Database
    mysql_select_db('ChatRoom');

    $hashtags = "#".$hash;

    $sql="SELECT * FROM Hashtags WHERE Tag='".$hashtags."'";
    $result=mysql_query($sql);

    // mysqli_num_row is counting table row
    $count=mysql_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count==1){
      $hashtag = ("#".$hash);
      $Content = str_replace($hashtag, " <a href='../../hashtags/$hash'>$hashtag</a> ", $Content);
    }
}
}

echo '
<div class="blog-post well">
<h2 class="blog-post-title">'.$Title.'</h2>
<p class="blog-post-meta">'.$Date.' By: <a href="../../users/'.$PostBy.'">'.$PostBy.'</a> </p>
'.$Content.'
</div>
';
}

?>
