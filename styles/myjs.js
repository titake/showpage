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
function submitForm(formID){
	document.getElementById(formID).submit();
}