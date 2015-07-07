<?php 
	$password = "admin"; 

	if ( (isset($_POST["password"]) && ($_POST["password"] == $password)) || 
		(isset($_COOKIE["password"]) && $_COOKIE["password"] == $password) ) {
?> 

	<form id="add_images_form"> 
		<input type="text" id="image-title" placeholder="Bild Title" />
		<input type="text" id="image-href" placeholder="Bild Dateiname mit Erweiterung"/>
		<textarea rows="7" id="image-description" placeholder="Bild Beschreibung"></textarea>
		<input type="text" id="image-tags" placeholder="Tags, mit Komma getrennt" />
		<label for="image-download" class="image-download">Herunterladbar? <input type="checkbox" id="image-download" checked /></label>
		<button type="button" id="add_button">Hinzufügen</button>
	</form>

	<div id="result"></div>

	<script>
		$(document).ready(function() {
			
			var newImage = {};

			$("#add_button").click(function(){
				newImage["title"] = $("#image-title").val();
				newImage["href"] = $("#image-href").val();
				newImage["description"] = $("#image-description").val();
				newImage["tags"] = $("#image-tags").val();
				newImage["downloadable"] = $('#image-download').is(':checked') ? 1 : 0;

				$.ajax({
					type: "GET",
					url: 'admin/add-images.php',
					data: { "newImages": newImage},

					success: function(msg) {
						$("#result").append("<div class='alert success'>Bild wurde erfolgreich hinzugefügt.</div>");
					},
					error: function(msg) {
						$("#result").append("<div class='alert error'>Fehler: "+msg+"</div>");
					},
				});

				setTimeout(function() { $('.alert').fadeOut(); }, 3000); 

			});

		});
	</script>


<?php } else { ?> 

	<h1>Login</h1> 

	<form name="form" method="post" id="login_form" onsubmit="rememberPassword();" action="<?php echo $_SERVER['PHP_SELF'] . "?p=images"; ?>"> 
	    <label for="password">Password:</label> 
	    <input type="password" title="Enter your password" name="password" id="password" />
	    <input type="submit" name="Submit" value="Login" />

	</form> 

	<script type="text/javascript">
		function rememberPassword() {
			document.cookie = "password" + "=" + $("#password").val() + "; " + 86400;			
		}
	</script>

<?php } ?> 

