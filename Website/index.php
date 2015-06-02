<?php
	session_start();

	$content = mysql_connect("localhost", "skymap",  "u6&bNl58") or die (mysql_error());
	mysql_select_db("skymap") or die (mysql_error());
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="script/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="script/script.js"></script>

</head>
<body>
	<?php

		include('header.php');
	?>
	<?php

		include('menu.php');
	?>

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

	<div>
		<?php 
			//include("menu.php");
			
			$item = mysql_query("SELECT * FROM galerie");
			while($data = mysql_fetch_array($item))
			{
				echo($data[1]."<img src='".$data[2]."' width='100px'><br />");
			}
			
		?>
	</div>
</body>
</html>