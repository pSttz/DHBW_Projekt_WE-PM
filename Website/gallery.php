<script type="text/javascript" src="script/gallery.js"></script>
<script type="text/javascript" src="script/sort.js"></script>

<h1>Galerie</h1>

<form id="search_form"> 
	<input type="text" id="search" placeholder="Search" />
	<button type="button" id="search_button">Search</button>
</form>


<form id="sort_form"> 
	<label for="sort_gallery">Sortieren nach</label>
	<select name="sort_gallery" id="sort_gallery">
		<option value="no_sort"></option>
		<option value="title_asc">Title: aufsteigend</option>
		<option value="title_desc">Title: absteigend</option>
		<option value="date_asc">Datum: aufsteigend</option>
		<option value="date_desc">Datum: absteigend</option>
		<option value="tags_asc">Kategorie</option>
		<option value="likes_asc">Bewertung</option>
	</select>
</form>

<div id="result"></div>

<?php 
	// if sort url - make sort
	if (isset($_GET['s'])) {		
		?>
		<script>
			// console.log("Make sort");
			makeSort("<?php echo $_GET['s']; ?>","<?php echo (isset($_GET['dir']) ? $_GET['dir'] : '') ?>");
		</script>
		<?php
	} 
	// if search url - make search
	else if (isset($_GET['q'])) {		
		?>
		<script>
			// console.log("Make search");
			makeSearch("<?php echo $_GET['q'] ?>");
		</script>
		<?php
	} 
	// else show gallery
	else {
		$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");
		$db->set_charset("utf8");

		// check connection
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		$gallery = mysqli_query($db, "SELECT * FROM galerie") or die(mysql_error());
		$count = mysqli_num_rows($gallery);

		if($count > 0) {
			echo '<div class="loader"><h2>Loading...</h2></div>';
			echo '<div class="gallery loading">';

			while($image = mysqli_fetch_array($gallery)) {
				echo '<img src="images/gallery/' . $image['href'] . '" alt="' . $image['title'] . '" data-date="' . $image['date'] . '" data-description="' . $image['description'] .'" data-likes="' . $image['likes'] .'" data-id="' . $image['id'] .'" title="' . $image['title'] . '"/>';
			}
			echo '</div>';
		}
	}
?>