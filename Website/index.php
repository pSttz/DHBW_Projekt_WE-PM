<?php
	session_start();
	$content = mysqli_connect("localhost", "skymap",  "u6&bNl58", "skymap") or die (mysql_error());
?>

<!DOCTYPE html>
<html>
<head>
	<title>SKYMAP-Photography</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="script/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="script/script.js"></script>
</head>
<body>
	<?php
		include('header.php');
		include('menu.php');
	?>

	<div class="content">
		<?php
			if (! isset($_GET['p']))
			{
				include('home.php');

			} else {    
				$page = $_GET['p'];  
				switch($page)
				{
					case 'gallery':
						include('gallery.php');
						break;  
					case 'products':
						include('products.php');
						break;  
					case 'contact':
						include('contact.php');
						break; 
					default:
						include('home.php'); 
				}
			}
		?>

		<?php 
			//$item = mysqli_query($content, "SELECT * FROM galerie");
			//while($data = mysqli_fetch_array($item))
			//{
			//	echo($data[1]."<img src='".$data[2]."' width='100px'><br />");
			//}
		?>
	</div>
</body>
</html>