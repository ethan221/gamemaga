//AJAX公共函数
function loadXMLDoc(url,divname){
    var xmlhttp,url,divname;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	xmlhttp.open("GET",url, true);
	xmlhttp.send(null);
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById(divname).innerHTML = xmlhttp.responseText;
        } else {
		}
    }
}