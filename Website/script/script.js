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

function checkCookie(cname) {
	return getCookie(cname) != "" ?  true : false;
}

function checkSetCookie(cname, cvalue, exdays) {
	if (getCookie(cname) == "") {
		setCookie(cname, cvalue, exdays);
	}
	else {
		setCookie(cname, "", -1);
		setCookie(cname, cvalue, exdays);
	}
}

function appendCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+d.toUTCString();

	var cookie = getCookie(cname);
	cookie += cvalue+",";

	document.cookie = cname + "=" + cookie + "; " + expires;
}
