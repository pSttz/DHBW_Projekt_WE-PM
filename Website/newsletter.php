
<script>

function newsletter()
{
	var form = document.getElementById("newsletterForm");
	
	$.post("newsletter.php", {action:"insert", mail:form.newsletterMail.value}, function(data, status){ document.getElementById("newsletter").innerHTML = data; })
}

</script>
<div id="newsletter">

<?php

	$errorstring="";
	$code = 0;
	
	if(@$_POST['action']=="insert" && isset($_POST['mail']))
	{
		include("script/validator.php");
		if(validator("email", $_POST['mail']))
		{
			$mail = $_POST['mail'];
			
			if(!isset($content))
			{
				$content = mysqli_connect("localhost", "skymap",  "u6&bNl58", "skymap") or die (mysql_error());
			}
			
			if($code==0)
			{
				$code = rand(12345,98765);
				$from = "From: SKYMAP <webmaster@skymap.ixdee.de>\n";
				mail($mail, "SKYMAP Verification", "Ihr Bestätigungscode für die Newsletteranmeldung: $code. Falls Sie nicht für diese Mail nicht verantwortlich sind, ignorieren Sie diese bitte.", $from);
				$_SESSION['newsletter'] = true;
			}
			else if(mysqli_query($content,"INSERT INTO `skymap`.`newsletter` (`mail`, `status`) VALUES ('$mail', 'active')") )
			{
				echo("Anmeldung erfolgreich!");
			}
			else
			{
				$errorstring = "Fehler beim eintragen in Datenbank. Eintrag schon vorhanden oder ungültige Daten.";
			}
			
		}
			else
			{
				$errorstring = "Emailadresse ungültig";
			}
	}
	//$_SESSION['newsletter'] = false;
	if(@$_SESSION['newsletter']!=true)
	{
	
	?>
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
<?php
	}
	else
	{
	?>
	<h3>Newsletter Bestätigung</h3>
	Sie haben von uns eine Mail mit einem Bestätigungscode erhalten. Um die Anmeldung abzuschließen, geben Sie den Code hier ein.<br />
	<form action="" method="POST" onsubmit="return false" id="newsletterForm">  
		<input type="text" name="newsletterCode" placeholder="1234"/>
		<input type="submit" value="Absenden" onclick="newsletter()"/>
	</form>
	<?php
	echo("<br />$errorstring");
	?>
	<?php
	};
?>
</div>