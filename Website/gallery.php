<script type="text/javascript" src="script/sort.js"></script>

<h1>Galerie</h1>

<form id="search_form"> 
	<input type="text" id="search" placeholder="Search" />
	<button type="button" id="search_button">Search</button>
</form>


<form id="sort_form"> 
	<label for="sort_gallery">Sortieren nach</label>
	<select name="sort_gallery" id="sort_gallery">
		<option value=""></option>
		<option value="title_asc">Title: aufsteigend</option>
		<option value="title_desc">Title: absteigend</option>
		<option value="date_asc">Datum: aufsteigend</option>
		<option value="date_desc">Datum: absteigend</option>
		<option value="category">Kategorie</option>
		<option value="rate">Bewertung</option>
	</select>
</form>

<div id="result"></div>

<script>
	$(document).ready(function() {
		$('#search_form').submit(function(e) {   
			makeSearch($(this).children('#search').val());
			e.preventDefault(); 
		});

		$('#search_button').click(function(e) {   
			makeSearch($(this).siblings('#search').val());
		});

		$('#sort_gallery').on('change', function() {
			if(this.value == "title_asc") makeSort("title", "asc");
			else if(this.value == "title_desc") makeSort("title", "desc");
			else if(this.value == "title_desc") makeSort("title", "desc");
			else if(this.value == "date_asc") makeSort("date", "asc");
			else if(this.value == "date_desc") makeSort("date", "desc");
			else if(this.value == "category") makeSort("tags", "asc");
			else if(this.value == "rate") makeSort("likes", "asc");
			// console.log(this.value);
		});

		$('#sort_button').click(function(e) {   
			makeSort("title", "desc");
		});
	});
</script>


<?php 
	$imageFolder = 'images/gallery/';
	$imageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}';

	// if sort url - make sort
	if (isset($_GET['s'])) {		
		?>
		<script>
			console.log("Make sort");
			makeSort("<?php echo $_GET['s']; ?>","<?php echo (isset($_GET['dir']) ? $_GET['dir'] : '') ?>");
		</script>
		<?php
	} 
	// if search url - make search
	else if (isset($_GET['q'])) {		
		?>
		<script>
			console.log("Make search");
			makeSearch("<?php echo $_GET['q'] ?>");
		</script>
		<?php
	} 
	// else show gallery
	else {
		// Add images to array
		// glob returns an array of filenames
		// GLOB_BRACE expands {a,b,c} to match 'a', 'b', or 'c'
		$images = glob($imageFolder . $imageTypes, GLOB_BRACE); 

		if(count($images)) {
			echo '<div class="gallery">';
			foreach ($images as $image) {
			    # Get the name of the image, stripped from image folder path and file type extension
			    $name = substr($image, strlen($imageFolder), strpos($image, '.') - strlen($imageFolder));
			    $lastModified = date('F d Y H:i:s', filemtime($image));
			    echo '<img src="' . $image . '" alt="' . $name . ' ' . $lastModified . '" title="' . $name . '"/>';
			}
			// echo '<span class="loaded" style="display:none">loaded</span>';
			echo '</div>';
			?> 
			<script type="text/javascript" src="script/gallery.js"></script>
			<?php
		}
	}
?>



