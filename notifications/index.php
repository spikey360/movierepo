<?php
$id=$_COOKIE['id'];
if(empty($id)){
include('../login/index.html');
exit();
}
include('../lib/opendb.php');
//////////color scheme////////
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
/////////////////////////////

//subscribed threads
$query="SELECT DISTINCT tid FROM disc_posts WHERE user=$id";
$res=mysql_query($query);

?>
<html>
<head>
<title>Spikey Movie Repo:Notifications</title>
<link rel="stylesheet" type="text/css" href="../style/notif<?php echo $cs?>">
</head>
<body>
<div class='dash'>
<a href="../discussions/"><span>Home</span></a>
<?php
if(!empty($id)){
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
<div class="banner2">Notifications</div>
<?php
if(mysql_num_rows($res)>0){
 echo "<div class='param'>New posts in subscribed threads</div>";
 echo "<ul>";
while($row=mysql_fetch_row($res)){
 $query="SELECT disc_threads.topic, users.username, disc_posts.user FROM disc_posts INNER JOIN disc_threads ON disc_posts.tid = disc_threads.tid JOIN users ON disc_posts.user = users.uid WHERE disc_posts.tid=$row[0] ORDER BY disc_posts.pid DESC LIMIT 1"; //correct
 $rres=mysql_query($query);
 $rrow=mysql_fetch_row($rres);
 if($rrow[2]!=$id){
 echo "<li><a href='../discussions/thread.php?t=$row[0]'>$rrow[0]</a><br><a href='../profile/viewid.php?v_name=$rrow[1]'><span class='user'>$rrow[1]</span></a></li>";
 }
}
echo "</ul>";
}else{
 echo "<div class='param'>No new posts in subscribed threads</div>";
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
?>
</div>
<script src="../res/libAjax.js"></script>
<script src="../res/util.js"></script>
<script src="../res/util2.js"></script>
<script>
initiateAjax();
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
</div>
</body>
</html>
<?php
include('../lib/closedb.php');
?>
