<?php 

	$db = mysqli_connect("localhost", "skymap", "u6&bNl58", "skymap");

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
        
        $db_results = mysqli_query($db, "SELECT * FROM galerie") or die(mysql_error());

        if (isset($_GET['q'])) {
        	// echo $_GET['q'];
			// setcookie("search", $_REQUEST['q'], time() + (86400 * 30), "/"); // 86400 = 1 day
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
					return strcmp($a[$sort], $b[$sort]);
				});
        	}
        	else {
        		usort($results, function($a, $b) use ($sort) {
					return strcmp($b[$sort], $a[$sort]);
				});   		
        	}

         	// echo "<pre>";
    		// print_r($results);
    		// echo "</pre>";
        	
        	echo "<ul>";
         
            foreach($results as $result) {
                echo "<li><div class='image' style='background-image:url(images/gallery/"  . $result['href'] . ")'></div>";
                echo "<div class='title'><a href='"  . $result['href'] . "'>". $result['title'] . "</a></div>";
                echo "<div class='description'>" . $result['description'] . "</div></li>";
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
