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
<?php
$tid=$_GET['t'];
include('../lib/opendb.php');
$query="SELECT topic FROM disc_threads WHERE tid=$tid";
$res=mysql_query($query);
$row=mysql_fetch_row($res);?>
<html >
<head><title><?php echo substr($row[0],0,100);?></title>
<link rel="stylesheet" type="text/css" href="../style/threadstyle<?php echo $cs?>">
</head>
<body onload="getNotifCount();">

<div class='dash'>
<a href="../discussions/"><span>Home</span></a>|
<a href='../notifications/'><span>Notifications</span><span id='nc'></span></a>
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
<?php
echo "<div class='threadtitle'>$row[0]";?>
<?php echo "</div>"?>
<div align="right">
<table>
<tr><td>

</td></tr>
<tr>
<td>

</td>
</tr>
</table>
</div>
<?php
//poll time!
$pquery="SELECT title, opt1, opt2, opt3, opt4, users.username, pollid FROM polls INNER JOIN users ON polls.uid=users.uid WHERE tid=$tid";
$pres=mysql_query($pquery);
if($pres==TRUE){
if(mysql_num_rows($pres)>0){
$prow=mysql_fetch_row($pres);
echo "<br><div class='poll'>";
echo "Poll: $prow[0]<br>asked by <span class='user'>$prow[5]</span>";
////////////////////
$voted=0;
$vquery="SELECT vid FROM votes WHERE uid=$cuser AND pollid=$prow[6]";
$vres=mysql_query($vquery);
if($vres==TRUE){
 if(mysql_num_rows($vres)>0){
  $voted=1;
 }else{
  $voted=0;
 }
}
////////////////////
if(strcmp($prow[1],"")>0){
echo "<br>";
if($voted==0){echo "<input type='radio' value='1' name='poll' id='p1'/>";}
echo "<span class='verdict'>$prow[1]</span>";
$vcountquery="SELECT users.username FROM votes INNER JOIN users ON votes.uid=users.uid WHERE opt=1 AND pollid=$prow[6]";
$vcres=mysql_query($vcountquery);
$k=0; $noun="votes";
if($vcres==TRUE){
if(($k=mysql_num_rows($vcres))>0){
$vpeop="";
while($vcrow=mysql_fetch_row($vcres)){
$vpeop=$vpeop."$vcrow[0] ";
}
if($k==1) $noun="vote";
echo "<span class='count' title='$vpeop'> $k $noun</span>";
}
}
}
if(strcmp($prow[2],"")>0){
echo "<br>";
if($voted==0){echo "<input type='radio' value='2' name='poll' id='p2'/>";}
echo "<span>$prow[2]</span>";
$vcountquery="SELECT users.username FROM votes INNER JOIN users ON votes.uid=users.uid WHERE opt=2 AND pollid=$prow[6]";
$vcres=mysql_query($vcountquery);
$k=0; $noun="votes";
if($vcres==TRUE){
if(($k=mysql_num_rows($vcres))>0){
$vpeop="";
while($vcrow=mysql_fetch_row($vcres)){
$vpeop=$vpeop."$vcrow[0] ";
}
if($k==1) $noun="vote";
echo "<span class='count' title='$vpeop'> $k $noun</span>";
}
}
}
if(strcmp($prow[3],"")>0){
echo "<br>";
if($voted==0){echo "<input type='radio' value='3' name='poll' id='p3'/>";}
echo "<span>$prow[3]</span>";
$vcountquery="SELECT users.username FROM votes INNER JOIN users ON votes.uid=users.uid WHERE opt=3 AND pollid=$prow[6]";
$vcres=mysql_query($vcountquery);
$k=0; $noun="votes";
if($vcres==TRUE){
if(($k=mysql_num_rows($vcres))>0){
$vpeop="";
while($vcrow=mysql_fetch_row($vcres)){
$vpeop=$vpeop."$vcrow[0] ";
}
if($k==1) $noun="vote";
echo "<span class='count' title='$vpeop'> $k $noun</span>";
}
}
}
if(strcmp($prow[4],"")>0){
echo "<br>";
if($voted==0){echo "<input type='radio' value='4' name='poll' id='p4'/>";}
echo "<span>$prow[4]</span>";
$vcountquery="SELECT users.username FROM votes INNER JOIN users ON votes.uid=users.uid WHERE opt=4  AND pollid=$prow[6]";
$vcres=mysql_query($vcountquery);
$k=0; $noun="votes";
if($vcres==TRUE){
if(($k=mysql_num_rows($vcres))>0){
$vpeop="";
while($vcrow=mysql_fetch_row($vcres)){
$vpeop=$vpeop."$vcrow[0] ";
}
if($k==1) $noun="vote";
echo "<span class='count' title='$vpeop'> $k $noun</span>";
}
}
}
echo "<br>";
if($voted==0){echo "<input type='button' value='vote' onclick='tryVote(\"$prow[6]\");'/>";}else{
echo "<span class='av'>You have voted already</span>";
}
echo "</div>";
}
}
?>
<?php
$lpid=0;
$query="SELECT * from (select post, users.username, pid FROM disc_posts INNER JOIN users ON disc_posts.user=users.uid where tid=$tid order by pid desc) as tbl order by pid";
$res=mysql_query($query);
if($res==TRUE){
/////////////////CHECK FOR CLOSED THREAD
$closequery="SELECT closed FROM disc_threads WHERE tid=$tid";
$closed="false";
$closeres=mysql_query($closequery);
$closerow=mysql_fetch_row($closeres);
if($closerow[0]=="1")
 $closed="true";
if(mysql_num_rows($res)>0){

echo "<ul>";

while($row=mysql_fetch_row($res)){
$orquer="SELECT ornt, users.username FROM orientatn INNER JOIN users ON orientatn.uid=users.uid WHERE pid = $row[2]";
$lpid=$row[2];
$orres=mysql_query($orquer);
$agcount=0; $dagcount=0;
$aguid=""; $daguid="";
if(mysql_num_rows($orres)>0){
 while($orrow=mysql_fetch_row($orres)){
  if($orrow[0]=='1'){
   //agree
   $agcount++;
   $aguid=$aguid."$orrow[1] ";
  }
  if($orrow[0]=='0'){
  //disagree
   $dagcount++;
   $daguid=$daguid."$orrow[1] ";
  }
 }
}
?>
<li><table><td class="mainpost"><span class="post"><?php echo "$row[0]<br><a href='../profile/viewid.php?v_name=$row[1]'><span class='user'>$row[1]</span></a>"?></span></td><td class="ornt"><?php
if($agcount>0){
echo "<span class='agree' title='$aguid' onclick='giveOrnt(\"$row[2]\",\"1\")'> <b>&#8593;$agcount</b></span><br>";
}
else{
echo "<span class='agree' title='Agree?' onclick='giveOrnt(\"$row[2]\",\"1\")'> <b>&#8593;</b></span><br>";
}
if($dagcount>0){
echo "<span class='disagree' title='$daguid' onclick='giveOrnt(\"$row[2]\",\"0\")'> <b>&#8595;$dagcount</b></span>";
}
else{
echo "<span class='disagree' title='Disagree?' onclick='giveOrnt(\"$row[2]\",\"0\");'> <b>&#8595;</b></span>";
}

?></td></table></li>
<?php
}

echo "</ul>";

}
}
else{
?>
<div><span>Failed to load thread</span></div>
<?php
}


if($closed=="false"){
?>

<div class='postconsole'>
<?php
//if poll isn't there let there be a poll
if(mysql_num_rows($pres)==0){
?>
<input type="button" value="Poll" title="Create a Poll" onclick="bringupPoll('<?php echo $tid?>');">
<?php
}
?>
<input type="button" title="Insert link" onclick="insertLink();" class="linkButton">
<input type="button" title="Insert Web Image" onclick="insertImage();" class="imgButton">
<br>
<textarea class ="newpost" id="newpost"></textarea>
<br>

<input type="button" value="Post" id="newpostbutton" onclick="postToThread(<?php echo $tid ?>);">
<?php
}
?>
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

//store information about thread_viewed
//$cuser,$tid,$lpid
if(!empty($cuser)){
	$vtquery="SELECT nid FROM thread_viewed WHERE uid='$cuser' AND tid='$tid' AND lastPostSeen='$lpid'";
	$vtres=mysql_query($vtquery);
	if($vtres){
		if(mysql_num_rows($vtres)==0){
		//write
		$vtiquery="INSERT INTO `movierepo`.`thread_viewed` (`nid`, `uid`, `tid`, `lastPostSeen`) VALUES (NULL, '$cuser', '$tid', '$lpid')";
		//echo($vtquery);
		mysql_query($vtiquery) or die("went wrong");
		}else{
		//already record present
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
if(rt=="PS"){ document.getElementById('newpost').value=""; window.location=window.location;}
if(rt=="QF"){alert("Error while posting");}
}
}
function postToThread(tid){
if(getCookieParam('id')==""){
alert("Login required");
nw=window.open('../login/login.html','Login','width=260,height=80,location=no,resizable=no');
return;
}
setFunction(postresp);
txt=validate(document.getElementById('newpost').value);
if(txt.length>0){
sendPostRequest("POST","postToThread.php","p="+escape(txt)+"&t="+tid);
}
}

function orntResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="PS"){/*increase count*/}
if(rt=="QF"){alert("Error");}
if(rt=="VA"){alert("Voted already");}
}
}

function giveOrnt(pid, ornt){
if(getCookieParam('id')==""){
alert("Login required");
nw=window.open('../login/login.html','Login','width=260,height=80,location=no,resizable=no');
return;
}
setFunction(orntResp);
sendPostRequest("POST","setOrnt.php","o="+ornt+"&p="+pid);
}


function insertImage(){
url=window.prompt("URL","http://");
if(url.length<=7){// length of http://
return;
}else{
tag="<img src=\'"+url+"\'>";
document.getElementById('newpost').value+=tag;
}
}

function insertLink(){
url=window.prompt("URL","http://");
if(url.length<=7){// length of http://
return;
}else{
tag="<a href=\'"+url+"\'>"+url+"</a>";
document.getElementById('newpost').value+=tag;
}
}

function validate(txt){
//txt=document.getElementById('txt').value;
txt2="";
lines=txt.split("\n");
for(i=0;i<lines.length;i++){
if(i!=(lines.length-1))
 txt2+=lines[i]+"<br>";
else
 txt2+=lines[i];
}
//document.getElementById('valtext').innerHTML=txt2;
return txt2;
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
function vResp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
 if(rt=="VS"){
  alert("Polled");
 }
 if(rt=="VA"){
  alert("Voted previously");
 }
 if(rt=="QF"){
 alert("Failed");
 }
}
}
function tryVote(p){
if(getCookieParam('id')==""){
alert("Login required");
nw=window.open('../login/login.html','Login','width=200,height=50,location=no,resizable=no');
return;
}
o="";
pobj=null;
if((pobj=document.getElementById('p1'))!=null){
 if(pobj.checked==true){o="1";}
}
if((pobj=document.getElementById('p2'))!=null){
 if(pobj.checked==true){o="2";}
}
if((pobj=document.getElementById('p3'))!=null){
 if(pobj.checked==true){o="3";}
}
if((pobj=document.getElementById('p4'))!=null){
 if(pobj.checked==true){o="4";}
}
setFunction(vResp);
sendPostRequest("POST","../tools/vote.php","pol="+p+"&o="+o);
}
function bringupPoll(x){
if(getCookieParam('id')==""){
alert("Login required");
nw=window.open('../login/login.html','Login','width=200,height=50,location=no,resizable=no');
return;
}else{
nw=window.open('../tools/newpoll.php?t='+x,'Create a Poll','width=500,height=450,location=no,resizable=no');
}
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
