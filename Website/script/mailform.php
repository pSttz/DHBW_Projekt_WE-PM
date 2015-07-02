<?php

$action = @$_GET['action'];

if($action=="validate")
{
	$field = $_POST['field'];
	$value = @$_POST['value'];
	echo(validator($field, $value));
}
/*
function to prove the entries of the contact formular
*/

include("validator.php");

/*
sends an email to webmaster@skymap.ixdee.de
*/
function sendMail($pre, $name, $mail, $cont, $priv, $nlet)
{
	
	if(
		validator("prename",$pre)==true &&
		validator("name",$name)==true &&
		validator("email",$mail)==true &&
		validator("content",$cont)==true &&
		$priv == "accept")
		{
			$auto = "Guten Tag!<br />Wir haben Ihre Nachricht erhalten und werden uns innerhalb der nächsten 3 Werktage bei Ihnen melden.<br /><br />Ihr SKYMAP-Team<br /><br />Hinweis:Dies ist eine automatisch generierte Email.";
			$empfaenger = "webmaster@skymap.ixdee.de";
			$betreff = "Kontaktaufnahme $pre $name";
			$from = "From: $pre $name <$mail>";
			$from .= "Content-Type: text/html\n";
			mail($empfaenger, $betreff , $cont, $from);
			
			$empfaenger = $mail;
			$betreff = "Empfangsbestätigung SKYMAP";
			$from = "From: SKYMAP <webmaster@skymap.ixdee.de>\n";
			$from .= "Content-Type: text/html";
			mail($empfaenger, $betreff, $auto, $from);
			
			$output = "<br /><b>Ihre Nachricht</b>:<br /><b>Von:</b><br />$pre $name ($mail)<br /><b>Inhalt:</b><br />$cont<br />";
			
			if($nlet=="newsletter")
			{
				$output = $output."<br />Sie erhalten die SKYMAP Newsletter";
				//TODO : Newsletter eintragung
			}
			$output = $output."<br /><a href='?p=contact'>zurück</a>";
			return $output;
					
		}
	else 
		{
			return "Fehler aufgetreten! <a href='?p=contact'>zurück</a>";
		}
}


?>

