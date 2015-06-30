function showSortResults(sort, dir, cookie_sort, cookie_dir) {
	var search_query = getParamValue("q");

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			$(".gallery").empty();
			document.getElementById("result").innerHTML = xmlhttp.responseText;
			addParamToUrl('s', sort);
			addParamToUrl('dir', dir);

			if(cookie_sort != sort) {
				checkCookie("sort", sort, 365);
			}
			if(cookie_dir != dir) {
				checkCookie("dir", dir, 365);				
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

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname){
	var re = new RegExp(cname + "=([^;]+)");
	var value = re.exec(document.cookie);
	return (value != null) ? unescape(value[1]) : "";
}

function checkCookie(cname, cvalue, exdays) {
	if (getCookie(cname) == "") {
		// console.log("No cookie");
		setCookie(cname, cvalue, exdays);
	}
	else {
		// console.log("Remove cookie");
		setCookie(cname, "", -1);
		// console.log("Set new cookie");
		setCookie(cname, cvalue, exdays);
	}
}