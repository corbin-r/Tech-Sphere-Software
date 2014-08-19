<?php
	session_start();
  	session_regenerate_id(true);

    
    $bioFile = '../users/'.$_SESSION['Username'].'/settings/bio.txt';
	
    $file = fopen($bioFile, "w");
	
    fwrite($file, $_POST['Bio']);
	
    fclose();

	header("Location: ../settings.php?Bio=Updated");
?>
