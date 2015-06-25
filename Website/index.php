<?php
	session_start();
	$content = mysqli_connect("localhost", "skymap",  "u6&bNl58", "skymap") or die (mysql_error());
?>

<!DOCTYPE html>
<html>
<head>
	<title>SKYMAP-Photography</title>
	<?php
	header('Content-Type: text/html; charset=UTF-8');
	?>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="script/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="script/script.js"></script>
</head>
<body>
<div class="page">
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
					case 'privacy':
						include('privacy.php');
						break;
					case 'cookie_policy':
						include('cookie_policy.php');
						break;
					default:
						include('home.php'); 
				}
			}
		?>
		<br>
	<br>
	<br>
	</div>
</div>
	<footer>©2015 SKYMAP Photography | <a href='?p=privacy'>Datenschutz</a> | <a href='?p=cookie_policy'>Cookies</a>  </footer>
</body>
</html>