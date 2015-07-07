var checkedObjects = new Array();

var errorm = new errorObject();
/*
	"Class" to create an error Object (to handle validate-Messages)
*/
function errorObject()
{
	this.obj = document.getElementById("errors");			//div oder span as output
	this.content = "";										//content to display as error(s)
	this.timer =0;											//var to save the timeout-state
	
	//adds another message to the content-string and starts the timeout
	this.set = function(text) 
	{
		if(this.content.length >0)
		{
			this.content += "<br />"+text;
		}
		else
		{
			this.content += text;
		}
		
		if(text=="")
		{
			this.content = "";
		}
		else
		{
			this.out(this);
		}
		if(this.obj==null)
		{
			this.obj = document.getElementById("errors");
		}
		this.obj.innerHTML = this.content;
	}
	
	//manages the timeout (errors disapper after 4 seconds)
	this.out = function(self)
	{
		window.clearTimeout(this.timer);
		this.timer = window.setTimeout(function(){self.set("");}, 4000);
	}
}

function validateInput(obj)
{
	//errorm.set(obj.name);
	$.post("script/mailform.php?action=validate", {field:obj.name, value:obj.value}, function(data, status){ checkValResult(data, obj.name); })
	checkValResult(false, obj.name);
}

function checkValResult(data, name)
{
	if(data==true)
	{
		document.getElementById(name+"_h").innerHTML = "✓ ";
		checkedObjects[name]=true;
	}
	else if(name=="where")
	{
		//alert("asdf");
		var wlist = document.getElementById("wheres");
		wlist.innerHTML = data;
		//alert(data);
	}
	else
	{
		document.getElementById(name+"_h").innerHTML = "✗ ";
		checkedObjects[name]=false;
		errorm.set(data);
	}
}

function sendMail()
{
	if(document.mailf.privacystatement.checked == true)
	{
		if(checkedObjects["prename"] ==true && checkedObjects["name"] ==true && checkedObjects["email"]==true && checkedObjects["content"]==true)
		{
			document.mailf.submit();
		}
		else
		{
			errorm.set("Bitte überprüfen Sie Ihre Eingaben!");
		}
	}
	else
	{
		errorm.set("Sie müssen der Datenschutzerklärung zustimmen!");
	}
}
