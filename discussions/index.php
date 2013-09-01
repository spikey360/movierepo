<?php
include('../lib/opendb.php');
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
<!doctype html>
<html>
<head><title>Spikey Movie Repo: Discussions</title>
<link rel="stylesheet" type="text/css" href="../style/threadstyle<?php echo $cs?>">

</head>
<body onload="getNotifCount();">

<div class="banner">
<div class='dash'>
<a href="../"><span>Movie Repo</span></a>|
<a href="section.php"><span>Sections</span></a>|
<a href='../notifications/'><span>Notifications</span><span id='nc'></span></a>
<?php
if(!empty($cuser)){
?>
|<a href='../profile/'><span>Profile</span></a>
|<a onclick='tryLogout();'><span>Logout</span></a>
<?php
}else{
?>
|<a href='' onclick='bringupLogin();'><span>Login</span></a>
|<a href='' onclick="window.open('../adduser/','Sign up','width=400,height=200');"><span>Sign Up</span></a>
<?php
}
?>
</div>
Spikey Movie Repo: Discussions
<div align="right">
<table>
<tr><td>
<fb:like align="center" href="http://spikey360.freevar.com/discussions/" send="true" layout="button_count" width="450" show_faces="true" font="verdana"></fb:like>
</td></tr>
<tr>
<td>

</td>
</tr>
</table>
</div>
</div>
<div align="center" class="threadlist">
<?php
//$query="SELECT tid, users.username, topic FROM disc_threads INNER JOIN users ON disc_threads.startedBy=users.uid order by tid desc";
$qa=array("select distinct disc_threads.topic, users.username, disc_threads.tid from (select tid, user, pid from disc_posts order by pid desc) as tbl right join disc_threads on tbl.tid=disc_threads.tid left join users on disc_threads.startedBy=users.uid where disc_threads.sticky=1 order by tbl.pid desc","select distinct disc_threads.topic, users.username, disc_threads.tid from (select tid, user, pid from disc_posts order by pid desc) as tbl right join disc_threads on tbl.tid=disc_threads.tid left join users on disc_threads.startedBy=users.uid where disc_threads.sticky=0 order by tbl.pid desc");
$c=0;
foreach($qa as $query){
//$query="select distinct disc_threads.topic, users.username, disc_threads.tid from (select tid, user, pid from disc_posts order by pid desc) as tbl right join disc_threads on tbl.tid=disc_threads.tid left join users on disc_threads.startedBy=users.uid order by tbl.pid desc";
$res=mysql_query($query) or die("Query failed");
if(mysql_num_rows($res)>0){
echo "<ul>";
while($row=mysql_fetch_row($res)){
////////////FINDING POST COUNT AND LAST POSTER
$pcquery="SELECT users.username FROM disc_posts INNER JOIN users ON disc_posts.user=users.uid WHERE tid=$row[2] ORDER BY pid DESC";
$pcres=mysql_query($pcquery);
$pcnum=mysql_num_rows($pcres);
$pcrow=mysql_fetch_row($pcres);
/////////////////SET STYLE FOR STICKY THREAD
$stickyclass="";
if($c==0)
 $stickyclass=" class='stickythread'";
/////////////////CHECK FOR CLOSED THREAD
$closequery="SELECT closed FROM disc_threads WHERE tid=$row[2]";
$closeclass="";
$closetitle="";
$closeres=mysql_query($closequery);
$closerow=mysql_fetch_row($closeres);
if($closerow[0]=="1"){
 $closeclass=" class='closethread'";
 $closetitle=" title='Thread closed' ";
 }
?>
<li<?php echo $stickyclass;?>>
<table class='threadproptable'>
<td width="500px">
<a href="thread.php?t=<?php echo $row[2]?>" <?php echo $closetitle?>><?php echo "<span".$closeclass.">$row[0]</span><br><span class='user'>$row[1]</span>"?></a>
</td>
<td class='lastpost'>
<?php
$pnoun="post";
if($pcnum>1){
$pnoun="posts";
}
echo "$pcnum $pnoun<br>Last: $pcrow[0]";
?>
</td>
</table>
</li>
<?php
}
echo "</ul>";
}
$c+=1;
}

?>
</div>
<div class="postconsole">Start a thread<br>
<input type="text" size="32" id="newthread"><input type="button" value="Start" onclick="postNewThread();">
<div>

<?php
$secquery="SELECT title FROM disc_sections";
$secres=mysql_query($secquery);
if($secres==TRUE){
 if(mysql_num_rows($secres)>0){
 echo "<select id='sec' >";
 while($secrow=mysql_fetch_row($secres)){
  
  echo "<option value='$secrow[0]'".">$secrow[0]</option>";
 }
 echo "</select>";
 }
}
?>

</div>
</div>
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
function postresp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="PS"){alert("Posted"); document.getElementById('newthread').value=""; window.location=window.location;}
if(rt=="QF"){alert("Error while posting");}
}
}
function postNewThread(){
if(getCookieParam('id')==""){
alert("Login required");
nw=window.open('../login/login.html','Login','width=260,height=80,location=no,resizable=no');
return;
}
section=document.getElementById('sec').selectedIndex;
setFunction(postresp);
txt=document.getElementById('newthread').value;
if(txt.length>100){alert("Topic too long, consider shortening"); return;}
if(txt.length>0)
sendPostRequest("POST","postNewThread.php","p="+escape(txt)+"&s="+(section+1));
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
</body>
</html>
