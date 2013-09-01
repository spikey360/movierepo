<?php
$mov=$_POST['movnam'];
$own=$_COOKIE['id'];
include('../lib/opendb.php');
$query="INSERT INTO movies (title, owner) VALUES (\"".$mov."\",\"". $own."\")";
mysql_query($query) or die("Query failed");
if(!$query){
echo "F";
}else{
echo "S";
//add into events
//find out mid
$query="SELECT mid FROM movies WHERE owner=$own AND title='$mov'";
$res=mysql_query($query);
$row=mysql_fetch_row($res);
//insert into events
$query="INSERT INTO events (mid, uid, action) VALUES ($row[0], $own, 'added')";
mysql_query($query);
}
include('../lib/closedb.php');
?>
