<html>
<head>
<title>Movie Repo</title>
<link rel="stylesheet" type="text/css" href="style/style.css">
<script src="/spikey360/lib/jquery-1.7.1.js"></script>
<script src="/spikey360/lib/effects.js"></script>
</head>
<body>
<div class="header">
<div class="banner">Movie Repo</div>
<div><span class="request" onclick="window.location='./login/login.html';">Login</span> | <span class="request" onclick="window.location='./addmovie/';">Add a movie</span> | <span class="request" onclick="window.location='./discussions/';">Discussions</span> | <span class="request" onclick="window.location='./profile/';">Profile</span> | <span class="request" onclick="window.location='./adduser/';">Register</span> | <span class="request" onclick="window.location='./intro/';">Introduction</span></div>
</div>
<br>
<br>
<div>
<?php
include('lib/opendb.php');
//mysql_select_db('movierepo') or die("Could not select database");
$query="SELECT title, mid FROM movies ORDER BY title ASC";
$res=mysql_query($query) or die("Query failed");
if($res){
if(mysql_num_rows($res)>0){
echo "<ul id='repolist'>";
while($row=mysql_fetch_row($res)){
echo "<span onclick=\"centerViewport('movdet'); displayMovie('movie.php?win=x&mov=".$row[1]."'); appear('movdet')\"><li>";
echo "".$row[0]."";
echo "</li></span>\n";
}
echo "</ul>";
}else{
echo "No movies found";
}
}
else{
echo "Could not connect to repo";
}
include('lib/closedb.php');
?>
</div>
<div class="movframe" id="movdet"><div align="right" id="movdetclose"><span onclick="fade('movdet');">x</span></div><iframe id="moviframe" class="moviframe" src="about:blank"></iframe></div>
<script>
function displayMovie(url){
	document.getElementById('moviframe').src=url;
}
</script>
</body>
</html>
