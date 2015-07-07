
<?php
function newsletterContent($cont, $err="")
{
	switch($cont)
	{
		case "scode":
			?>
			<div id="newsletterContent">
				<h3>Überprüfung</h3>
					Wir haben einen Sicherheits-Code an Ihre Emailadresse gesendet.<br />
					<small>Sie haben keinen Code erhalten? Es kann einige Minuten dauern, bis die Mail in Ihrem Postfach angezeigt wird. Die Mail kann als Spam gekennzeichnet sein. (<a href="">zurück</a>)</small>
				<form action="" method="POST" onsubmit="return false" id="newsletterForm">  
					<input type="text" name="itemValue" value="" placeholder="123456" autocomplete="off" />
					<input type="submit" value="Absenden" onclick="newsletter(this.value)"/>
				</form>
			</div>
			<div id="newsletterErrors">
				<?php echo($err);?>
			</div>
				<?php
			break;
		case "success":
			?>
			<div id="newsletterContent">	
				<h3>Anmeldung erfolgreich!</h3>
				Sie haben sich erfolgreich für den SKYMAP-Newsletter eingetragen und erhalten nun kostenlos alle neuen Infos zu Angeboten und neuen Inhalten!<br />
				<br /><span class="linkDummy" onclick="newsletter('default')">Weitere Adresse eintragen</span>
			</div>
				<?php
			break;
		case "default":
			?>
			<div id="newsletterContent">
				<h3>Newsletter Anmeldung</h3>
					Bestellen Sie noch heute den Newsletter von SKYMAP und bleiben Sie stets über aktuelle Angebote und neue Inhalte informiert!<br />
					<small>Mit der der Eintragung stimmen Sie automatisch den <a href="?p=privacy">Datenschutzbedingungen</a> zu.</small><br />
				<form action="" method="POST" onsubmit="return false" id="newsletterForm">  
					<input type="text" name="itemValue" value="" placeholder="max.muster@muster.de"/>
					<input type="submit" value="Eintragen" onclick="newsletter(this.value)"/>
				</form>
			</div>
			<div id="newsletterErrors">
				<?php echo($err);?>
			</div>
			<?php
			break;
		case "default":
			echo("you should not see this!");
			break;
	}
}


function insertNewsletterMail($mail)
{
	if(@$db==null)
	{
		$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");
		$db->set_charset("utf8");
	}
	
		
	$db_query = mysqli_query($db, "SELECT * FROM `newsletter` WHERE `mail` LIKE '".$mail."' ");
	
	if($res = mysqli_fetch_array($db_query))
	{
		return false;
	}
	else
	{
			
		$db_query = mysqli_query($db, "INSERT INTO `skymap`.`newsletter` (`mail`, `status`) VALUES ('".$mail."', 'active')")or die( mysql_error());
		
		$cont = "Anmeldung erfolgreich!\r\n\r\nSie haben sich erfolgreich zum SKYMAP Newsletter angemeldet. Falls Sie sich umentscheiden sollten, antworten Sie entsprechend auf diese Mail und wir nehmen Sie aus unserem Verteiler.\r\n\r\nIhr SKYMAP Team";
		$betreff = "Anmeldung erfolgreich - SKYMAP Newsletter";
		$from = "From: SKYMAP <webmaster@skymap.ixdee.de>";
		$from .= "Content-Type: text/plain\r\n";
		mail($mail, $betreff , $cont, $from);
		return true;
	}
}

?>
