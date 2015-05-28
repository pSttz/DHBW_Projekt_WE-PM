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
	<script type="text/javascript" src="script/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="script/script.js"></script>

</head>
<body>
	<?php
	$link = $_GET['link'];
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