function setDropdown() {
	var current_sort = getParamValue("s");
	var current_dir = getParamValue("dir");
	if(current_sort != "" && current_dir != "") {
		$("#sort_gallery").val(current_sort + "_" + current_dir);
	}
}

function setInputValue() {
	var current_query = getParamValue("q");
	if(current_query != "") {
		$("#search").val(current_query);
	}
}

function removeSort() {
	window.location = "index.php?p=gallery";
}

function showSortResults(sort, dir, cookie_sort, cookie_dir) {
	var search_query = getParamValue("q");
	setDropdown();
	setInputValue();

	var xmlhttp = null;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} 
	else if (window.ActiveXObject) {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { // 4 = loaded, 200 = success
			$(".gallery").empty();
			document.getElementById("result").innerHTML = xmlhttp.responseText;
			addParamToUrl('s', sort);
			addParamToUrl('dir', dir);

			if(cookie_sort != sort) {
				checkSetCookie("sort", sort, 365);
			}
			if(cookie_dir != dir) {
				checkSetCookie("dir", dir, 365);				
			}
		}
	}
	
	if(search_query != "") {
		xmlhttp.open("GET", "sort.php?q=" + search_query + "&s=" + sort + "&dir=" + dir, true);
	}
	else {
		xmlhttp.open("GET", "sort.php?s=" + sort + "&dir=" + dir, true);
	}
	xmlhttp.send();	
}


function makeSort(sort, dir) {
	var cookie_sort = getCookie("sort", sort);
	var cookie_dir = getCookie("dir", dir);

	if(cookie_sort != "") {
		// console.log("Sort from coockies");
		showSortResults(sort, dir, cookie_sort, cookie_dir);
	}
	else {
		if (sort.length == 0) { 
			document.getElementById("result").innerHTML = "";
			return;
		} 
		else {
			// console.log("New sort");
			$(window).trigger('load'); 
			showSortResults(sort, dir, cookie_sort, cookie_dir);
		}
	}
}

function getCurrentUrl() {
	var loc = window.location;
    var url = loc.protocol + '//' + loc.host + loc.pathname + loc.search;
    return url;
}

function getParamValue(param) {
    param = param.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + param + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function addParamToUrl(param, value) {
    //check if param exists
    var param_value = getParamValue(param);

    //added seperately to append ? before params
    var url = getCurrentUrl();

    //param exists in url, remove it
    if (param_value != '') {
    	url = removeParamFromUrl(url, param);
    	window.history.pushState("", "", url);
    }

    //doesn't have any params
    if (window.location.search == '') {
        url += "?" + param + '=' + value;
    }
    else {
        url += "&" + param + '=' + value;
    }
    
    window.history.pushState("", "", url);
}

function removeParamFromUrl(url, param) {
	var url = String(url);
	var regex = new RegExp( "\\?" + param + "=[^&]*&?", "gi");
	url = url.replace(regex,'?');
	regex = new RegExp( "\\&" + param + "=[^&]*&?", "gi");
	url = url.replace(regex,'&');
	url = url.replace(/(\?|&)$/,'');
	return url;
}