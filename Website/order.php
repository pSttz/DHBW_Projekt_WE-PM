<div id="order">
	<form method="POST" >
		<h4>Vorname:</h4><input type="text" name="name" placeholder="Max" onblur="validateInput(this)">
		<h4>Nachname:</h4><input type="text" name="surname" placeholder="Mustermann">
		<h4>Adresse:</h4><input type="text" name="street" placeholder="Musterstraße 12">
		<h4>Postleitzahl:</h4><input type="text" name="pCode" placeholder="12345">
		<h4>Ort:</h4><input type="text" name="town" placeholder="Musterstadt">
		<h4>Produkte:</h4><select size="1" name="product">
			<?php
			
			$res = mysqli_query($content, "SELECT `title`, `href` FROM `galerie` WHERE `downloadable` = 1 ") OR DIE(mysql_error());
			
			while($row = mysqli_fetch_array($res))
			{
				?>
				<option><?php echo($row[0]);?></option>
				<?php
			}
			
			?>
		</select>
		<input type="button" value="Kostenlos Bestellen" name="send">
	</form>
</div>