<?php 

	$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");

	// check connection
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	
	// get search query
	$query = $_REQUEST["q"];

	// make search
	if ($query !== "") {
		$query = strtolower($query);
		search($query, $db);
	}


	function search($query, $db) {
		$min_length = 1;

		// if query length is more or equal minimum length
		if(strlen($query) >= $min_length) { 
	         
	        // changes characters used in html to their equivalents (e.g. < to &gt;)
	        $query = htmlspecialchars($query); 
	        
	        // makes sure nobody uses SQL injection
	        $query = mysqli_real_escape_string($db, $query); 
	        
	        $db_results = mysqli_query($db, "SELECT * FROM galerie
	            WHERE (`title` LIKE '%".$query."%') 
	            	OR (`id` LIKE '%".$query."%') 
	            	OR (replace(tags, ',', '') LIKE '%".$query."%')") 
	        		or die(mysql_error());
	             
	        $count = mysqli_num_rows($db_results);
	        // if one or more rows are returned 
	        if($count > 0) { 
	        	$results_word = $count == 1 ? "Ergebnis" : "Ergebnissen";
	        	echo "<h3>" . $count . " " . $results_word . " in \"" . $query . "\"</h3>";
	        	echo "<ul>";
	             
	            // put data from database into array
	            while($results = mysqli_fetch_array($db_results)) {
	                echo "<li><img class='image' src='images/gallery/"  . $results['href'] . "'/>";
	                echo "<span class='title'><a href='"  . $results['href'] . "'>". $results['title'] . "</a></span>";
	                echo "<span class='description'>" . $results['description'] . "</span></li>";
	            }

	            echo "</ul>";
	        }
	        // if there is no matching rows
	        else { 
	            echo "No results";
	        }
	         
	    }
	    // if query length is less than minimum
	    else { 
	        echo "Minimum length is ".$min_length;
	    }

	}

	mysqli_close($db);
?>
