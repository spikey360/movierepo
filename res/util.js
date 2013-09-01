function getCookieParam(param){
arr=document.cookie.split(";");
for(i=0;i<arr.length;i++){
if(arr[i].indexOf(param)!=-1){
return arr[i].substring(arr[i].lastIndexOf("=")+1);
}
}
return "";
}

function addCookie(name,value){
document.cookie=name+"="+value+";";
}

function clearCookie(name){
document.cookie=name+"="+";";
}

function addZero(x){
y=""+x;
if(y.length<2){return "0"+y;}
else return y;
}

function getDate(){
d=new Date();
dstring=""+d.getFullYear()+"-"+addZero(d.getMonth()+1)+"-"+addZero(d.getDate())+" "+addZero(d.getHours())+":"+addZero(d.getMinutes())+":"+addZero(d.getSeconds())+"";
return dstring;
}

function isLeap(x){
if(x%100==0 && x%4==0){return true;}
else if(x%4==0) return true;
return false;
}

function hideElement(id){
document.getElementById(id).style.visibility="hidden";
}

function showElement(id){
document.getElementById(id).style.visibility="visible";
}

function disableFormElement(x){
document.getElementById(x).disabled=true;
}

function enableFormElement(x){
document.getElementById(x).disabled=false;
}

function checkAlphaNum(x){
for(i=0;i<x.length;i++){
c=x.charAt(i);
if((c>='a' && c<='z') || (c>='A' && c<='Z') || (c>='0' && c<='9')){}
else {return false;}
}
return true;
}

function _setStatus(x){
window.status=x;
//window.alert(x);
}

function _reinstateStatus(){
window.status=window.defaultStatus;
}

function createCookie(name, value, days){
if(days){
 var d=new Date();
 d.setTime(d.getTime()+(24*3600*1000*days));
 var expires="; expires="+d.toGMTString();
}
else var expires="";
document.cookie=name+"="+value+expires;
}
