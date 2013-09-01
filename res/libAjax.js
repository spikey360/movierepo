var xmlHttp;
function initiateAjax(){
//var x;
try{
xmlHttp= new XMLHttpRequest();
//return x;
}catch(e){
try{
xmlHttp= new ActiveXObject("Msxml2.XMLHTTP");
//return x;
}catch(e){
try{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
//return x;
}catch(e){
alert("Error initiating ajax");
return false;
}
}
}
}

function setFunction(func){
xmlHttp.onreadystatechange=func;
}

function sendRequest(param){
xmlHttp.open("GET",param,true);
xmlHttp.send(null);
}

function sendPostRequest(method,file,param){
xmlHttp.open(method,file,true);
xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", param.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(param);
}
