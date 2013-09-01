<?php
include('../lib/opendb.php');
$t=$_GET['t'];
$cuser=$_COOKIE['id'];
$cs="style1.css";
if(empty($cuser)){
//do nothing, let usual css work
}else{
$csquery="SELECT cschemes.css, cschemes.name FROM settings INNER JOIN cschemes ON settings.cscheme=cschemes.csid WHERE uid=$cuser";
$csres=mysql_query($csquery);
 if($csres==TRUE){
  if(mysql_num_rows($csres)>0){
   $cssrow=mysql_fetch_row($csres);
   $cs=$cssrow[0];
  }
 }
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../style/threadstyle<?php echo $cs?>">
</head>
<body onload="<?php if(empty($cuser)){echo 'redirOnNoLogin()';} ?>">
<div class="newpoll">
<table>
<tr><td>Title</td><td><input type='text' id='pq' onchange='setPreview();'></td></tr>
<tr><td>Options</td><td><input type='text' id='pqo1' onchange='setPreview();'></td></tr>
<tr><td></td><td><input type='text' id='pqo2' onchange='setPreview();'></td></tr>
<tr><td></td><td><input type='text' id='pqo3' onchange='setPreview();'></td></tr>
<tr><td></td><td><input type='text' id='pqo4' onchange='setPreview();'></td></tr>
<tr><td><input type='button' value="Cancel" id='cancelpoll' onclick='window.close();'></td><td><input value="Post" type='button' id='postpoll' onclick="<?php echo 'tryPostPoll(\''.$t.'\')'?>"></td></tr>
</table>
<br>
<div>Preview</div>
</div>
<div class="poll">
<span id='prevq'></span>
<br><input type='radio' name='mockpoll'><span class='verdict' id='opt1'></span>
<br><input type='radio' name='mockpoll'><span class='verdict' id='opt2'></span>
<br><input type='radio' name='mockpoll'><span class='verdict' id='opt3'></span>
<br><input type='radio' name='mockpoll'><span class='verdict' id='opt4'></span>
<br><input type='button' value='vote' />
</div>
<script src="../res/libAjax.js"></script>
<script src="../res/util.js"></script>
<script>
initiateAjax();
function setPreview(){
document.getElementById('prevq').innerHTML=document.getElementById('pq').value;
document.getElementById('opt1').innerHTML=document.getElementById('pqo1').value;
document.getElementById('opt2').innerHTML=document.getElementById('pqo2').value;
document.getElementById('opt3').innerHTML=document.getElementById('pqo3').value;
document.getElementById('opt4').innerHTML=document.getElementById('pqo4').value;
}
function redirOnNoLogin(){
window.location='../login/login.html';
}
function pollResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="PS"){alert("Posted"); window.close();}
else{
alert("Failed");
}
}
}
function tryPostPoll(tid){
title=document.getElementById('pq').value;
first=document.getElementById('pqo1').value;
second=document.getElementById('pqo2').value;
third=document.getElementById('pqo3').value;
fourth=document.getElementById('pqo4').value;
if(title.length>0 && first.length>0 && second.length>0){
setFunction(pollResp);
sendPostRequest("POST","../tools/postpoll.php","th="+tid+"&o1="+first+"&o2="+second+"&o3="+third+"&o4="+fourth+"&t="+title);
}else{
alert("Title and atleast two options required");
}
}
</script>
</body>
</html>
