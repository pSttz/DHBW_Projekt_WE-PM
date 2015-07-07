<?php
function validator($field, $value)
{
	switch($field)
	{
		case "prename":
		case "name":
			if(strlen(htmlspecialchars($value))>1 && strlen(htmlspecialchars($value))<64)
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
			if(strlen(htmlspecialchars($value))>20)
			{
				if(strlen(htmlspecialchars($value))<2048)
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
		case "where":
			
			if(htmlspecialchars($value) == $value)
			{
					
				$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");
				$db->set_charset("utf8");

				
				// changes characters used in html to their equivalents (e.g. < to &gt;)
				$query = htmlspecialchars($value); 
				
				// makes sure nobody uses SQL injection
				$query = mysqli_real_escape_string($db, $query); 
				$resultstring="";
				
				$db_results = mysqli_query($db, "SELECT * FROM plz_de
					WHERE (`Plz` LIKE '".$query."%') 
						OR (`Ort` LIKE '%".$query."%') ORDER BY `Plz` LIMIT 15") 
						or die( mysql_error());
					 
				$count = mysqli_num_rows($db_results);
				$resultstring = "<option>Keine Angabe</option>";
				// if one or more rows are returned 
				if($count > 0) { 
					while($results = mysqli_fetch_array($db_results)) {
						$resultstring .= "<option> " . $results['Plz'] . ", " . $results['Ort'] . "</option>";
					}
				}
				mysqli_close($db);
				return $resultstring;
			}
			break;
		default:
			return("Fehler. Bitte Seite neuladen");
			break;
	}
}
?>