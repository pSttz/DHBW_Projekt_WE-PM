function makeSearch(query) {
	if (query.length == 0) { 
		document.getElementById("result").innerHTML = "";
		
		var url = getCurrentUrl();
		url = removeParamFromUrl(url, "q");
    	window.location = url;
    	
		return;
	} 
	else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				$(".gallery").empty();
				document.getElementById("result").innerHTML = xmlhttp.responseText;
				
				// var url = getCurrentUrl();
				// window.history.pushState("", "", removeAllParamsFromUrl(url)); 

				addParamToUrl('q', query);
			}
		}
		xmlhttp.open("GET", "search.php?q=" + query, true);
		xmlhttp.send();
	}
}

function getCurrentUrl() {
	var loc = window.location;
    var url = loc.protocol + '//' + loc.host + loc.pathname + loc.search;
    return url;
}


function addParamToUrl(param, value) {
    //check if param exists
    var param_value = new RegExp(param + "=([^&]*)", "i").exec(window.location.search);
    param_value = param_value && param_value[1] || "";

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
    return url;
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

function removeAllParamsFromUrl(url) {
	var url = String(url);
	var base_url = url.split("?");
	var page_url = base_url[1].split("&");
	// console.log(base_url[0]);
	// console.log(page_url[0]);
	return base_url[0] + "?" + page_url[0];
}