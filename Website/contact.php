<table id="aboutus">
	<tr>
		<td>
			<h1>Über uns & Kontakt</h1>
			<h3>Über SKYMAP</h3>
			<p>SKYMAP GmbH ist ein 2015 gegründetes Unternehmen in der Fotografie-Branche, das über ein eigenes Fotostudio verfügt.<br>
			Neben den klassischen Leistungen eines Fotostudio mit Passfotos und Fotoshootings, bietet SKYMAP auch Event-, Architektur- und Businessfotografien vor Ort an.<br> 
			Für Buisness-Kunden entwickelt SKYMAP darüber hinaus ein stimmiges Grafikkonzept für die Ihre Mediengestaltung.</p>
			
			<h3>Kontakt</h3>
			<p>Sie haben Fragen, Anregungen oder Wünsche an uns, unsere Produkte oder unsere Website? Treten Sie mit uns in Verbindung!</p>
			
			<h4><b><BLOCKQUOTE>	
					Max Muster<br>
					Musterweg<br>
					12345 Musterstadt<br>
					01234-789456</BLOCKQUOTE></b></h4>
			Sie erreichen uns zu den Geschäftszeiten unter dieser Adresse.
			
			<h3>Geschäftszeiten</h3>
			<p>Montag - Freitag von 9-18 Uhr</p>
			<p>Samstag von 9-13 Uhr</p>
		</td>
		
		<td>
			<div id="mailform">
				<?php
				
				if(@$_GET['mailsend']==true)
				{
					echo("Email gesendet! <br />Wir werden uns bald bei Ihnen melden. Bitte beachten Sie, dass unsere Antwort in Ihrem Postfach möglicherweise als Spam gekennzeichnet ist.<br /><hr/>");
					include("script/mailform.php");
					
					echo(sendMail(@$_POST['prename'], @$_POST['name'], @$_POST['email'], @$_POST['content'], @$_POST['privacystatement'], @$_POST['newsletter'])); 
				}
				else
				{
				?>
				<script type="text/javascript" src="script/contact.js"></script>
				<form method="POST" action="?p=contact&mailsend=true" onsubmit="alert('asdf');" name="mailf">
					<h3>Kontaktformular</h3>
					<h4><span id="prename_h"></span>Vorname</h4>
					<input type="text" name="prename" placeholder="Max" onblur="validateInput(this)"/>
					<h4><span id="name_h"></span>Nachname</h4>
					<input type="text" name="name" placeholder="Mustermann" onblur="validateInput(this)"/>
					<h4><span id="email_h"></span>Email</h4>
					<input type="text" name="email" placeholder="max.mustermann@muster.de" onblur="validateInput(this)"/>
					<h4><span id="content_h"></span>Anliegen</h4>
					<textarea name="content" placeholder="Hallo, ich möchte mich über etwas informieren!" onblur="validateInput(this)"></textarea>
					<input type="checkbox" name="privacystatement" value="accept"/><small>Ich stimme den Datenschutzerklärungen zu.</small><br/>
					<input type="checkbox" name="newsletter" value="newsletter"/><small>Ich möchte von SKYMAP Newsletter erhalten.<br />
					<input type="button" value="Senden" name="send" onclick="sendMail()"/>
				</form>
					<span id="errors"></span>
				<?php
				}
				?>
			</div>
		</td>
	</tr>
</table>


