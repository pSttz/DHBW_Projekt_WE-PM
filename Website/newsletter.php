
<script>

function newsletter()
{
	var form = document.getElementById("newsletterForm");
	
	$.post("newsletter.php", {action:"insert", mail:form.newsletterMail}, function(data, status){ document.getElementById("newsletter").innerHTML = data; })
}

</script>

<?php

	$errorstring="";
	
	if(@$_POST['action']=="insert" && isset($_POST['mail']))
	{
		include("script/validator.php");
		if(validator("email", $_POST['mail']))
		{
			mysqli_query("INSERT INTO `skymap`.`newsletter` (`mail`, `status`) VALUES ('test@example.de', 'active')");
			$_SESSION['newsletter'] = true;
		}
	}
	
	if(@$_SESSION['newsletter']!=true)
	{
	
	?>
	<div id="newsletter">
	<h3>Newsletter Anmeldung</h3>
	Bestellen Sie noch heute den Newsletter von SKYMAP und bleiben Sie stets über aktuelle Angebote und neue Inhalte informiert!<br />
	<small>Mit der der Eintragung stimmen Sie automatisch den <a href="?p=privacy">Datenschutzbedingungen</a> zu.</small><br />
	<form action="" method="POST" onsubmit="return false" id="newsletterForm">  
		<input type="text" name="newsletterMail" placeholder="max.muster@muster.de"/>
		<input type="submit" value="Eintragen" onclick="newsletter()"/>
	</form>
	<?php
	echo("<br />$errorstring");
	?>
	</div>
<?php
	};
?>