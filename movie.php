<?php

$mid=$_GET['mov'];
?>
<html>
<head>
<title>Movie</title>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<?php

include('lib/opendb.php');
//mysql_select_db('movierepo');
$query="SELECT title, users.username, mid FROM movies INNER JOIN users ON movies.owner = users.uid WHERE movies.mid =$mid";
$res=mysql_query($query) or die("Query failed");
if(mysql_num_rows($res)>0){
while($row=mysql_fetch_row($res)){
$x=urlencode($row[0]); 
?>
<body onload="tryWhoWatch(<?php echo $row[2]; ?>);">
<div class="movie">
<table>
<td>
<span  class="title"><?php echo $row[0]; ?></span>
<br><span  class="owner"><?php echo $row[1]; ?></span><br> 
<span class="request" onclick="tryReq(<?php echo $row[2]; ?>);">Request to borrow</span> | <?php if(!empty($_GET['win'])){}else{?><span class="request" onclick="window.location='./';">Back to list</span> | <?php } ?><span class="request" onclick="tryUpdate(<?php echo $row[2]; ?>);" title="You can edit the title only if you own the movie">Edit title</span> | <span class="request" onclick="tryWatch(<?php echo $row[2]; ?>);" title="Click if you've watched this">Watched?</span>
<br><span  class="desc" id="details"></span>
<br><span id="watch" class="watched"></span>
<br><a href="#" class="desc" id="imdb">IMDB</a>
</td>
<td><span><img id="moviePoster" alt="Poster" title="Powered by Google"></span></td>
</table>
</div>
<?php
}
}
include('lib/closedb.php');
?>

<script src="http://www.google.com/jsapi?key=AIzaSyA5m1Nc8ws2BbmPRwKu5gFradvD_hgq6G0" type="text/javascript"></script>
<script src="res/libAjax.js"></script>
<script src="res/util.js"></script>
<script>
function imdbapi(x){
if(x.Title==undefined) return;
det=""+x.Plot+"<br>Director: "+x.Director+"<br>Starring: "+x.Actors
document.getElementById('details').innerHTML=det;
//document.getElementById('moviePoster').src=x.Poster;
document.title="Movie Repo: "+x.Title;
document.getElementById('imdb').href="http://imdb.com/title/"+x.ID;
//google image search needs to be invoked after here
loadPosterFromGoogle(x.Title,x.Year);
}

function override(x){
if(x.valid=="false") return;
det=""+x.Plot+"<br>Director: "+x.Director+"<br>Starring: "+x.Actors
document.getElementById('details').innerHTML=det;
//document.getElementById('moviePoster').src=x.Poster;
document.title="Spikey Movie Repo: "+x.Title;
document.getElementById('imdb').href="http://imdb.com/title/"+x.ID;
//google image search needs to be invoked after here
loadPosterFromGoogle(x.Title,x.Year);
}

/////////GOOGLE IMAGE SEARCH API
google.load('search','1');

function searchFinished(searcher){
if(searcher.results && searcher.results.length>0){
//set the first image as the movie poster
var movpostimg=document.getElementById('moviePoster');
results=searcher.results;
fImage=results[0];
movpostimg.src=fImage.tbUrl;
//alert(fImage.url);
}
}

function loadPosterFromGoogle(title, year){
imageSearch=new google.search.ImageSearch();
imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_IMAGESIZE,google.search.ImageSearch.IMAGESIZE_MEDIUM);
imageSearch.setSearchCompleteCallback(this,searchFinished,[imageSearch]);
imageSearch.execute(title+" "+year+" movie poster");
}

/////////ajax for requesting a borrow
initiateAjax();
function reqresp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="RM"){ alert("Requested for a borrow"); return;}
if(rt=="QF"){alert("Request could not be made");}
else{
window.location="/login/";
}
}
}

function upresp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="US"){ alert("Title changed"); return;}
if(rt=="QF"){alert("Query could not be completed");}
if(rt=="NP"){alert("You do not own this movie");}
else{
//window.location="/login/";
}
}
}

function watchresp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="QF"){ alert("Query could not be completed"); return;}
if(rt=="WA") {alert("You've watched this"); return;}
if(rt=="IS") {alert("Duly noted!"); return;}
}
}

function whowatchresp(){
if(xmlHttp.readyState==4){
rt=xmlHttp.responseText;
if(rt=="QF"){  return;}
if(rt=="") {return ;}
else{
document.getElementById('watch').innerHTML=rt+" watched this movie";
}
}
}

function tryReq(mid){
if(getCookieParam("id")==""){
alert("Login required"); window.location="login/";
}else{
setFunction(reqresp);
sendRequest("request/request.php?mid="+mid);
}
}

function tryUpdate(mid){
if(getCookieParam("id")==""){
alert("Login required"); window.location="login/";
}else{
var newname=window.prompt("New Title?");
if(newname.length==0){return;}
setFunction(upresp);
sendPostRequest("POST","edit/edit.php","t="+encodeURIComponent(newname)+"&mid="+mid);
}
}

function tryWatch(mid){
if(getCookieParam("id")==""){
alert("Login required"); window.location="login/";
}else{
setFunction(watchresp);
sendRequest("watched/watched.php?t="+mid);
}
}

function tryWhoWatch(mid){

setFunction(whowatchresp);
sendRequest("watched/whowatched.php?t="+mid);

}
</script>
<script src="<?php echo 'http://imdbapi.com/?t='.$x.'&callback=imdbapi&plot=full';?>"></script>
<script src="<?php echo './tools/getOverrideDetails.php?mid='.$mid.'&callback=override';?>"></script>
</body>
</html>
