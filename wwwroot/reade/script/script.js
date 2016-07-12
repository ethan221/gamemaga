function CloseId(divid,set){
    document.getElementById(divid).style.display = "none";
    if(set=='1'){
        setCookie(divid,'1');
    }
}
function getCookie(name){ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)"); 
    if(arr=document.cookie.match(reg)) 
        return unescape(arr[2]); 
    else
        return null; 
} 
function setCookie(name,value){
    document.cookie = name + "="+ escape (value);
}
function gbook(){
    var gbookbox=document.getElementById("showgbook");
    var gbookimg=document.getElementById("gbookimg");
    if(gbookbox.style.display!="block"){
        gbookbox.style.display="block";
        gbookimg.src="images/btnGbook_2.gif";
    }else{
        gbookbox.style.display="none";
        gbookimg.src="images/btnGbook.gif";
    }
}