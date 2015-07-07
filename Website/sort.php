<?php 

	$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");
	$db->set_charset("utf8");

	// check connection
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	// get sort query
	$sort = $_REQUEST["s"];
	$sort_dir = $_REQUEST["dir"];

	// make search
	if ($sort !== "") {
		if($sort_dir == "") {
			$sort_dir = "asc";
		}
		else if($sort_dir == "asc" || $sort_dir == "desc") {
			$sort = strtolower($sort);
			makeSort($sort, $sort_dir, $db);
		}
	}


	function makeSort($sort, $sort_dir, $db) {

        // changes characters used in html to their equivalents (e.g. < to &gt;)
        $sort = htmlspecialchars($sort); 
        $sort_dir = htmlspecialchars($sort_dir); 
        
        // makes sure nobody uses SQL injection
        $sort = mysqli_real_escape_string($db, $sort); 
        $sort_dir = mysqli_real_escape_string($db, $sort_dir); 
        
        // if there's a 
        if (isset($_GET['q'])) {
			$db_results = mysqli_query($db, "SELECT * FROM galerie
	            WHERE (`title` LIKE '%".$_GET['q']."%') 
	            	OR (`id` LIKE '%".$_GET['q']."%') 
	            	OR (replace(tags, ',', '') LIKE '%".$_GET['q']."%')") 
	        		or die(mysql_error());

			// $db_results = mysqli_query($db, "SELECT * FROM galerie") or die(mysql_error());
        }
        else {
        	$db_results = mysqli_query($db, "SELECT * FROM galerie") or die(mysql_error());
        }
             
        // if one or more rows are returned 
        if(mysqli_num_rows($db_results) > 0) { 

        	// make associative array
        	$results = [];
        	while($value = mysqli_fetch_assoc($db_results)) {
				array_push($results, $value);
        	}; 

        	// make usort on a chosen key ($sort)
        	if($sort_dir == "asc") {
        		usort($results, function($a, $b) use ($sort) { // accept regular argument $sort
					return strcmp(strtolower($a[$sort]), strtolower($b[$sort]));
				});
        	}
        	else {
        		usort($results, function($a, $b) use ($sort) {
					return strcmp(strtolower($b[$sort]), strtolower($a[$sort]));
				});   		
        	}

         	// echo "<pre>";
    		// print_r($results);
    		// echo "</pre>";
        	
        	echo "<ul>";
         
            $block = 0;
            foreach($results as $result) {
                echo "<li class='image'>";
                echo "<a class='popover level0 block".$block."' href='images/gallery/"  . $result['href'] . "'>";
                echo "<img src='images/gallery/" . $result['href'] . "' data-id='" . $result['id'] . "' data-date='" . $result['date'] . "' data-description='" . $result['description'] . "' data-likes='" . $result['likes'] . "' title='" . $result['title'] . "'/>";
                echo "</a></li>";
                $block++;
            }

            echo "</ul>";
        }
        // if there is no matching rows
        else { 
            echo "No results";
        }
	         

	}

	mysqli_close($db);
?>
