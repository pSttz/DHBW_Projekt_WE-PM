<?php 
	$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");
	$db->set_charset("utf8");
	// check connection
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
	$newImages = $_GET['newImages'];
	
	$title = $newImages["title"];
	$href = $newImages["href"];
	$description = $newImages["description"];
	$tags = $newImages["tags"];
	$downloadable = $newImages["downloadable"];
	mysqli_query($db, "INSERT INTO `skymap`.`galerie` (`id`, `title`, `href`, `description`, `date`, `tags`, `downloadable`, `likes`) VALUES (NULL, '$title', '$href', '$description', NOW(), '$tags', '$downloadable', '0')");
?>
