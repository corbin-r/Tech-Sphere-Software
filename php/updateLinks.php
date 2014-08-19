<?php
	session_start();
  	session_regenerate_id(true);

    fopen('../users/'.$myUsername.'/settings/Facebook.txt', "w");
    fopen('../users/'.$myUsername.'/settings/Twitter.txt', "w");
    fopen('../users/'.$myUsername.'/settings/Github.txt', "w");
    fopen('../users/'.$myUsername.'/settings/1_Title.txt', "w");
    fopen('../users/'.$myUsername.'/settings/1_URL.txt', "w");
    fopen('../users/'.$myUsername.'/settings/2_Title.txt', "w");
    fopen('../users/'.$myUsername.'/settings/2_URL.txt', "w");
    fopen('../users/'.$myUsername.'/settings/3_Title.txt', "w");
    fopen('../users/'.$myUsername.'/settings/3_URL.txt', "w");

    fwrite('../users/'.$myUsername.'/settings/Facebook.txt', $_POST['Facebook']);
    fwrite('../users/'.$myUsername.'/settings/Twitter.txt', $_POST['Twitter']);
    fwrite('../users/'.$myUsername.'/settings/Github.txt', $_POST['Github']);
    fwrite('../users/'.$myUsername.'/settings/1_Title.txt', $_POST['1_Title']);
    fwrite('../users/'.$myUsername.'/settings/1_URL.txt', $_POST['1_URL']);
    fwrite('../users/'.$myUsername.'/settings/2_Title.txt', $_POST['2_Title']);
    fwrite('../users/'.$myUsername.'/settings/2_URL.txt', $_POST['2_URL']);
    fwrite('../users/'.$myUsername.'/settings/3_Title.txt', $_POST['3_Title']);
    fwrite('../users/'.$myUsername.'/settings/3_URL.txt', $_POST['3_URL']);

	header("Location: ../settings.php?Links=Updated");
?>
