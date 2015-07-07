<?php
  


	$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");
	$db->set_charset("utf8");

	// check connection
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

  	$qry = mysqli_query($db, "SELECT * FROM galerie ORDER BY RAND() LIMIT 5") or die(mysql_error());

  	//print_r($qry);

  	$rand_images = [];

	while($rand = mysqli_fetch_array($qry)) { 
		array_push($rand_images, $rand);
		
	}





?>


<table class="home">
		<tr>    
			<td width="340">
	            <div class="random-image image-top" style="background-image:url(images/gallery/<?php echo $rand_images[0]['href'] ?>);"></div>
	        </td>
		    <td width="490">		  
		        <h1>Herzlich Willkommen bei Skymap Photography</h1>
		        <h2>Ihr zuverlässiger Partner für Fotoshootings, Eventfotografie und Passbilder</h2>
		        <h4>Neben der professionellen Aufnahme Ihrer Bildmotive vor Ort und im Studio, bietet Skymap Photography einen kostenlosen Download von hochwertigen Fotographien an.</h4>
		    </td>
		    <td>
		   		<h4> Sie finden uns auch auf</h4>
		   		<a href="https://www.facebook.com/skymap.photography" target="_blank" class="soc-icon">
		   			<img class="corner" src="images/social_media/facebook.png" title="Facebook" width="30%">
		   		</a>
		    	<a href="https://twitter.com/SkymapPhoto" target="_blank" class="soc-icon">
		    		<img class="corner" src="images/social_media/twitter.png" width="30%" title="Twitter">
		    	</a>
		    	<a href="https://instagram.com/skymapphoto/" target="_blank" class="soc-icon">
		    		<img class="corner" src="images/social_media/instagram.png" width="30%" title="Instagram">
		    	</a>
		    	
		    </td>
		</tr>
		<tr>
		    <td>
	            <p>Über 500 Kunden von Skymap Photography sprechen für sich. Steigen auch Sie noch heute ein und bestellen Sie den kostenlosen Skymap-Newsletter.<br>
		        Dieser informiert Sie stets über aktuelle Entwicklungen und die neuesten Trends in der Foto-Branche. <BR>Selbstverständlich ist der Newsletter jederzeit abbestellbar.<br></p> 
		        <p> Hier geht es weiter zur Bestellung des SKYMAP-Newsletters:</p>

		        <form action="?p=contact" method="post">  
					<input type="submit" value="Newsletter anfordern"/>
		        </form>
		    </td> 			  	          
		    <td>
		    	<table>
			    	<td width="245" align="left">
			    		<div class="random-image image-middle" style="background-image:url(images/gallery/<?php echo $rand_images[1]['href'] ?>);"></div>
			    	</td>
                	<td width="245" align="right">
                		<div class="random-image image-middle" style="background-image:url(images/gallery/<?php echo $rand_images[2]['href'] ?>);"></div>
                	</td> 
               	</table>
            </td>				
		    <td>
			    <h2>Aktuelles:</h2>
		        <h4>Neue Suchfunktionen!</h4>

			    <p>Nutzen Sie SKYMAP-Photography noch intensiver. Mit der verbesserten Suchfunktion kommen Sie schneller zu Ihrem gewünschten Motiv.</p>
				<p>Hier geht es weiter zur Suchfuntion der Gallerie:</p>
				
				<form action="?p=gallery" method="post">
					<input type="submit" value="Suche starten"/>
				</form>
			</td>
		</tr>
								
		<tr>
		    <td>
			    <h4>Event-Fotografie</h4>
		        <p>Gerne kommt Skymap-Photography zu Ihnen und hält die schönsten Momente Ihrer Hochzeit, Ihrer Geburtstagsfeier oder Ihres Familienalltags fest.</p>
		        <p>Nutzen Sie unsere Kompetenz um berauschende Farbspiele, wirkungsvolle Motive und atemberaubende Momente zu erzeugen.</p>  
		    </td>		  
		    <td>
		    	<table>
			    	<td width="245" align="left">
			    		<div class="random-image image-bottom" style="background-image:url(images/gallery/<?php echo $rand_images[3]['href'] ?>);"></div>
			    	</td>
                	<td width="245" align="right">
                		<div class="random-image image-bottom" style="background-image:url(images/gallery/<?php echo $rand_images[4]['href'] ?>);"></div>
                	</td> 
               	</table>
            </td>	
		  
		    <td>
				<h4>Ihr neues Traummotiv!</h4>
		        <p>Können Sie ein bestimmtes Motiv nicht finden? Dann schreiben Sie uns und entdecken Sie mit SKYMAP-Photography Ihr neues Traumbild.</p>

		        <form action="?p=contact" method="post">
		        	<input type="submit" value="Kontaktformular anfordern">
				</form> 
		    </td>
		</tr>
		  
</table>		  