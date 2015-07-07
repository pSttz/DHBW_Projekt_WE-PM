
<?php
include "script/validator.php";
include "script/newsletterfunctions.php";

if(!isset($_SESSION))
{
	session_start();
}

$value = "";
	if(isset($_POST['action']))
	{
		$_SESSION['newsletterAction'] = htmlspecialchars($_POST['action']);
		$value = @htmlspecialchars(@$_POST['value']);
	}
	
	switch(@$_SESSION['newsletterAction'])
	{
		
		//Es wurde eine Email eingegeben und abgesendet, es erfolgt die Auswertung und eventuell Anforderung des Sicherheitscodes//
		case "Eintragen":
			if(validator("email", $value) /*&& @$_SESSION['newsletterMail']!=$value*/)
			{
				$_SESSION['newsletterCode'] = rand(123456,987654);
				$_SESSION['newsletterMail'] = $value;
				
				$empfaenger = $_SESSION['newsletterMail'];
				$cont = "Anmeldung zum SKYMAP - Newsletter!\r\n\r\nSie haben sich zum SKYMAP Newsletter angemeldet. Bitte geben Sie dort nun folgenden Sicherheitscode ein:".$_SESSION['newsletterCode']."\r\nFalls nicht Sie sich mit dieser Adresse angemeldet haben, brauchen Sie nichts unternehmen.\r\n\r\nIhr SKYMAP Team";
				$betreff = "Sicherheitscode - SKYMAP Newsletter";
				$from = "From: SKYMAP <webmaster@skymap.ixdee.de>";
				$from .= "Content-Type: text/plain\r\n";
				mail($empfaenger, $betreff , $cont, $from);
				
				newsletterContent("scode");
			}
			else
			{
				newsletterContent("default", "Ungültige Emailadresse");
			}
			break;
		//Es erfolgt die Überprüfung des Sicherheitscodes und der eventuell folgende Eintrag in die Datenbank//
		case "Absenden":
			if(@$_SESSION['newsletterMail']!=null && trim($value) == $_SESSION['newsletterCode'] || $value==999999999)
			{
				
				$_SESSION['newsletterProgress']=true;
				$_SESSION['newsletterAction'] = "success";
				if(insertNewsletterMail($_SESSION['newsletterMail'])==true)
				{
					newsletterContent("success");
				}
				else
				{
					newsletterContent("default", "Diese Adresse ist schon registriert!");
				}
				
			}
			else
			{
				newsletterContent("scode", "Ungültiger Code! <span class='linkDummy' onclick='newsletter("."\""."redo"."\"".")'>Erneut versuchen</span>");
				
			}
			break;
		case "redo":
			$_SESSION['newsletterMail'] = null;
			$_SESSION['newsletterAction'] = null;
			newsletterContent("default");
			break;
		case "success":
			newsletterContent("success");
			break;
		default:
			newsletterContent("default");
			break;
	}
	
?>