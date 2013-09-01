
<?php
$id=$_COOKIE['id'];
include('../lib/opendb.php');
/////////////////////////
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
/////////////////////////
if(empty($id)){
$redir="<html><head><meta http-equiv='Refresh' content='2;url=http://spikeymovierepo.freevar.com/discussions/'></head><body>You are being redirected, please log in first</body></html>";
echo($redir);//do redirect
exit();
}else{
?>
<html>
<head><title>Profile</title>
<link rel="stylesheet" type="text/css" href="../style/notif<?php echo $cs?>">
</head>
<body>
<div class='dash'>
<a href="../discussions/"><span>Home</span></a>
<?php
if(!empty($cuser)){
?>
|<a onclick='tryLogout();'><span>Logout</span></a>
<?php
}else{
?>
|<a onclick='bringupLogin();'><span>Login</span></a>
<?php
}
?>
</div>
<div class="banner2"><img src='../tools/getAvatar.php' width='50' height='50'>My Profile</div>
<p></p>
<div>
<?php

$query="SELECT username, mail FROM users WHERE uid=$id";
$res=mysql_query($query);
$row=mysql_fetch_row($res);
?>
<div>
<table>
<tr>
<td><span class="param">Avatar </span></td><td><span class="userdata"><img src="../tools/getAvatar.php" width='50' height='50'></span></td><td><input type="button" title="change" value=".." onclick="window.open('../profile/changePic.html','Change Avatar','width=500,height=150,resizable=no');"></td>
</tr><tr>
<td><span class="param">Mail </span></td><td><span class="userdata"><?php echo $row[1]?></span></td><td></td>
</tr><tr>
<td><span class="param">Screen name </td><td></span><span class="userdata"><?php echo $row[0]?> </span></td><td><input type="button" title="change" value=".." onclick="trySnChange();"></td>
</tr><tr>
<td><span class="param">Change password</span><span></td><td><input type="password" size="16" id='np'></span></td><td><input type="button" title="change" value=".." onclick="tryPwdChange();"></td>
</tr></table>
</div>
<p></p>

<?php
//movies posted by user
$query="SELECT title, mid FROM movies WHERE owner=$id";
$res=mysql_query($query);
if($res){
?>
<div><span class="param">Movies added by you</span></div>
<?php
if(mysql_num_rows($res)>0){
echo "<ul>";
while($row=mysql_fetch_row($res)){
echo "<li>";
echo "<a href='../movie.php?mov=".$row[1]."'>".$row[0]."</a>";
echo "</li>";
}
echo "</ul>";
}else{
echo "<div>No movies added yet</div>";
}
}

//Threads participated in
$query="SELECT DISTINCT disc_threads.topic, disc_threads.tid FROM disc_posts INNER JOIN disc_threads ON disc_posts.tid=disc_threads.tid WHERE user=$id";
$res=mysql_query($query);
if($res){
?>
<div><span class="param">Threads posted in</span></div>
<?php
if(mysql_num_rows($res)>0){
echo "<ul>";
while($row=mysql_fetch_row($res)){
echo "<li>";
echo "<a href='../discussions/thread.php?t=$row[1]'>$row[0]</a>";
echo "</li>";
}
echo "</ul>";
}else{echo "<div>Not posted in any thread yet</div>";}
}


}
?>
<div class="footer">
<span>Spikey Movie Repo is a non profit organization and posts and opinions in the forum or website is the sole responsibility of the users posting them , at no point would the staff and management of Spikey Movie Repo be responsible for any damage arising from such opinions or posts and the management will not be responsible for any legal issues that might be associated with the said member. We respect and follow the internet norms and rules and expect our members also to follow the laws of the region while posting. Posts and Contents of Spikey Movie Repo must not be replicated without permission</span>
<br>
<span>All rights reserved. &#169; 2012</span>
<br>
<?php
if(!empty($cuser)){
$csquery="SELECT csid, name FROM cschemes";
$csres=mysql_query($csquery);
if($csres==TRUE){
 if(mysql_num_rows($csres)>0){
 echo "<select id='cscheme' onchange='changeCScheme();'>";
 while($csrow=mysql_fetch_row($csres)){
   $selected="";
  if(strcmp($cssrow[1],$csrow[1])==0){
   $selected=" selected='selected'";
   }
  echo "<option value='$csrow[0]'".$selected.">$csrow[1]</option>";
 }
 echo "</select>";
 }
}
}
include('../lib/closedb.php');
?>
</div>
</body>
<script src="../res/libAjax.js"></script>
<script src="../lib/md5.js"></script>
<script src="../res/util.js"></script>
<script src="../res/util2.js"></script>
<script>
initiateAjax(); //ajax up and running

function changeSnResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="US"){window.location=window.location;/*refresh*/}
if(rt=="QF"){alert("Failed to change name"); return;}
}
}

function trySnChange(){
setFunction(changeSnResp);
newname=window.prompt("New name");
if(newname.length<=0){return};
if(newname.length>32){alert("Name too long, max 32"); return;}
sendPostRequest("POST","changename.php","n="+escape(newname));
}

function changePwdResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="US"){window.location=window.location;/*refresh*/}
if(rt=="QF"){alert("Failed to change password"); return;}
}
}

function tryPwdChange(){
setFunction(changePwdResp);
newname=document.getElementById('np').value;
if(newname.length<=6){ alert("Password too short, min 6");return;}
if(newname.length>16){alert("Password too long, max 16"); return;}
sendPostRequest("POST","changepwd.php","n="+calcMD5(newname));
}
function csResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
 if(rt=="CS"){
  window.location.reload();
 }else{
 alert("Failed");
 }
}
}
function changeCScheme(){
x=document.getElementById('cscheme').selectedIndex;
setFunction(csResp);
sendPostRequest("POST","../settings/chcscheme.php","cs="+(x+1));
}
function bringupLogin(){
nw=window.open('../login/login.html','Login','width=260,height=80,location=no,resizable=no');
}
function loResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="LO")
 window.location.reload();
}
}
function tryLogout(){
setFunction(loResp);
sendRequest("../logout.php");
}
</script>
</html>
