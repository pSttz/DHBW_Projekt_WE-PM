<?php 
	$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");
	$db->set_charset("utf8");

	// check connection
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	mysqli_query($db, "UPDATE galerie set `likes` = `likes`+1 where `id` = '$_GET[id]'");
?>