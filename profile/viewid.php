
<?php
include('../lib/opendb.php');
$id=$_GET['v_id'];
$name=$_GET['v_name'];
///////////colorscheme//////
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
////////////////////////////
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
<div class="banner2"><?php echo $name?>

<?php

$query="SELECT username, mail FROM users WHERE uid=$id";
if(!empty($name)){
$query="SELECT username, mail, uid FROM users WHERE username='$name'";
}
$res=mysql_query($query);
$row=mysql_fetch_row($res);

?>
<img src="../tools/getAvatar.php?pr=<?php echo $row[2]?>" width='50' height='50'>
</div>
<p></p>
<div>
<span class="param">Screen name </span><span class="userdata">
<?php echo '<br>'.$row[0];
if(!empty($name)){$id=$row[2];}
?> </span>
</div>
<p></p>

<?php
//movies posted by user
$query="SELECT title, mid FROM movies WHERE owner=$id";
$res=mysql_query($query);
if($res){
?>
<div><span class="param">Movies added</span></div>
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
echo "<div class='inf'>No movies added yet</div>";
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
}else{echo "<div class='inf'>Not posted in any thread yet</div>";}
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
</body>

</html>
