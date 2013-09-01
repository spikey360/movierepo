function notifResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="LR" || rt.length>3 || rt=="0")
 document.getElementById('nc').innerHTML="";
else
 document.getElementById('nc').innerHTML=rt;
}
}
function getNotifCount(){
setFunction(notifResp);
sendRequest("../tools/notif_count.php");
}
