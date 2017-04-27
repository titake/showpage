function turnToBlur(objectID){
	document.getElementById(objectID).style.opacity = 0.7;
}
function turnToClear(objectID){
	document.getElementById(objectID).style.opacity = 1;
}
function showOrHide(objectID){
	var accounts_style = document.getElementById(objectID).style;
	if (accounts_style.display == "none") {
		accounts_style.display = "flex";
	}else{
		accounts_style.display = "none";
	}
}
function openWindow(url){
	window.location.href=url;
}
function logout(){
	var request = new XMLHttpRequest;
	request.open("GET","../ajax/editCookie.php?flag=delete&name=user_email",true);
	request.send();
	request.onreadystatechange = function(){
		if (request.readyState===4) {
			if (request.status===200) {
				window.location="../scripts/hello.html";
			}else{
				alert("error:"+request.status);
			}
		}
	}
}
