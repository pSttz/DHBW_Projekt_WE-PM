<?php


function validator($field, $value)
{
	switch($field)
	{
		case "prename":
		case "name":
			if(strlen(preg_replace("/[^0-9a-zA-Z]/","",$value))>1 && strlen(preg_replace("/[^0-9a-zA-Z]/","",$value))<64)
			{
				return true;
			}
			else
			{
				return("Bitte gültigen Namen eingeben.");
			}
			break;
		case "email":
			if(filter_var($value, FILTER_VALIDATE_EMAIL))
			{
				return true;
			}
			else
			{
				return("Bitte gültige Email-Adresse eingeben.");
			}
			break;
		case "content":
			if(strlen(preg_replace("/[^0-9a-zA-Z]/","",$value))>20)
			{
				if(strlen(preg_replace("/[^0-9a-zA-Z]/","",$value))<2048)
				{
					return true;
				}
				else
				{
					return("Bitte beschreiben Sie Ihr Anliegen kurz und direkt");
				}
			}
			else
			{
				return("Bitte geben Sie Ihr Anliegen ausführlicher an.");
			}
			break;
		default:
			return("Fehler. Bitte Seite neuladen");
			break;
	}
}

?>