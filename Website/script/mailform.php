<?php

$action = @$_GET['action'];

/*
function to prove the entries of the contact formular
*/

include("validator.php");
include("newsletterfunctions.php"); 
if($action=="validate")
{
	$field = $_POST['field'];
	$value = @$_POST['value'];
	echo(validator($field, $value));
}
/*
sends an email to webmaster@skymap.ixdee.de
*/
function sendMail($pre, $name, $mail, $cont, $gender, $adress, $priv, $nlet)
{
	
	if(
		validator("prename",$pre)==true &&
		validator("name",$name)==true &&
		validator("email",$mail)==true &&
		validator("content",$cont)==true &&
		$priv == "accept")
		{
			$pre = htmlspecialchars($pre);
			$name = htmlspecialchars($name);
			$cont = htmlspecialchars($cont);
			$adress = htmlspecialchars($adress);
			$gender = htmlspecialchars($gender);
			
			
			$anrede;
			if($gender=="female"){
				$anrede = "Guten Tag Frau $name!";
			}
			else if($gender=="male"){
				$anrede = "Guten Tag Herr $name!";
			}
			else
			{
				$anrede = "Guten Tag!";
			}
			
			$auto = "$anrede\r\nWir haben Ihre Nachricht erhalten und werden uns innerhalb der nächsten 3 Werktage bei Ihnen melden.\r\n\r\nIhr SKYMAP-Team\r\n\r\nHinweis:Dies ist eine automatisch generierte Email.";
			$data = "\r\nVorname/Name: $pre $name, \r\nGeschlecht: $gender, \r\nWohnort: $adress, \r\nEmail: $mail";
			$empfaenger = "webmaster@skymap.ixdee.de";
			$betreff = "Kontaktaufnahme $pre $name";
			$from = "From: $pre $name <$mail>";
			$from .= "Content-Type: text/plain\r\n";
			mail($empfaenger, $betreff , $cont.$data, $from);
			
			$empfaenger = $mail;
			$betreff = "Empfangsbestätigung SKYMAP";
			$from = "From: SKYMAP <webmaster@skymap.ixdee.de>\n";
			$from .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
			mail($empfaenger, $betreff, $auto, $from);
			
			$output = "<br /><b>Ihre Nachricht</b>:<br /><b>Von:</b><br />$pre $name ($mail)<br /><b>Inhalt:</b><br />$cont<br />";
			
			if($nlet=="newsletter")
			{
				
				if(insertNewsletterMail($mail))
				{
					$output = $output."<br />Sie erhalten die SKYMAP Newsletter";
				}
				
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

