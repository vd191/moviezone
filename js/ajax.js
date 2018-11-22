/*
from movie.js
makeAjaxGetRequest('movie_main.php','cmd_movie_select_all', null, updateContent);
requestid is the value that using for controller trigger the right function 
params: "?request=" + requestid + params. ex: ?request=cmd_movie_filter?actor=billy
*/

function makeAjaxGetRequest(request_handler, requestid, params, success) { // success = updateContent
	var xhttp;    

	xhttp = new XMLHttpRequest();
	if (params == null)	{
		xhttp.open("GET", request_handler + "?request=" + requestid, true);
	} else {
		xhttp.open("GET", request_handler + "?request=" + requestid + params, true);
	}
	xhttp.onreadystatechange = function() {
		//4: request finished and response is ready, 200: "OK"
		if (this.readyState == 4 && this.status == 200) { 
			if (success == null)
				return this.responseText;  
			else
				success(this.responseText); // updateContent(this.responseText); if the function updateContent existing then call that function with the paremeter is the respond data
		}
	};		
	xhttp.send();			
	
}


function makeAjaxGetMemberRequest(request_handler, requestid, params, success) {
	var xhttp;    

	xhttp = new XMLHttpRequest();
	if (params == null)	{
		xhttp.open("GET", request_handler + "?member_request=" + requestid, true);
	} else {
		xhttp.open("GET", request_handler + "?member_request=" + requestid + params, true);
	}
	xhttp.onreadystatechange = function() {
		//4: request finished and response is ready, 200: "OK"
		if (this.readyState == 4 && this.status == 200) { 
			if (success == null)
				return this.responseText;  // updateContent(this.responseText)
			else
				success(this.responseText);
		}
	};		
	xhttp.send();			
	
}

function makeAjaxPostRequest(request_handler, requestid, params, success) {
	var xhttp;    

	xhttp = new XMLHttpRequest();
	xhttp.open("POST", request_handler, true);	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (success == null)
				return this.responseText;
			else
				success(this.responseText);
		}
	};
	if (params == null) {
		xhttp.send("request=" + requestid);		
	} else {		
		if (params instanceof FormData) {
			//params is an instance of formdata	then append the requestid to it before sending out			
			params.append('request', requestid);
			xhttp.send(params);
		} else {
			//xhttp.setRequestHeader("Content-type", "multipart/form-data"); //for sending binary
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			//simple string params
			xhttp.send("request=" + requestid + params);
		}
		
	}
}



function makeAjaxPostMemberRequest(request_handler, requestid, params, success) {
	var xhttp;    

	xhttp = new XMLHttpRequest();
	xhttp.open("POST", request_handler, true);	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (success == null)
				return this.responseText;
			else
				success(this.responseText);
		}
	};
	if (params == null) {
		xhttp.send("member_request=" + requestid);		
	} else {		
		if (params instanceof FormData) {
			//params is an instance of formdata	then append the requestid to it before sending out			
			params.append('member_request', requestid);
			xhttp.send(params);
		} else {
			//xhttp.setRequestHeader("Content-type", "multipart/form-data"); //for sending binary
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			//simple string params
			xhttp.send("member_request=" + requestid + params);
		}
		
	}
}