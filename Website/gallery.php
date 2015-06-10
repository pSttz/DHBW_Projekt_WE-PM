<h1>Galerie</h1>

<?php 
	$imageFolder = 'images/gallery/';
	$imageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}';

	# Add images to array
	# glob returns an array of filenames
	# GLOB_BRACE expands {a,b,c} to match 'a', 'b', or 'c'
	$images = glob($imageFolder . $imageTypes, GLOB_BRACE); 

	if(count($images)) {
		echo '<div class="gallery">';
		foreach ($images as $image) {
		    # Get the name of the image, stripped from image folder path and file type extension
		    $name = substr($image, strlen($imageFolder), strpos($image, '.') - strlen($imageFolder));
		    $lastModified = date('F d Y H:i:s', filemtime($image));
		    echo '<img src="' . $image . '" alt="' . $name . ' ' . $lastModified . '" title="' . $name . '"/>';
		}
		echo '<span class="loaded" style="display:none">loaded</span>';
		echo '</div>';
	}
?>

<script type="text/javascript" src="script/gallery.js"></script>