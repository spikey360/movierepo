<?php
$mid=$_POST['mid'];
$name=$_POST['t'];
$id=$_COOKIE['id'];
if(!isset($_COOKIE['id'])){
include('/login/');
}
include('../lib/opendb.php');

$query="SELECT owner FROM movies WHERE mid=$mid";
$result=mysql_query($query) or die("QF");
$row=mysql_fetch_row($result);
if($row[0]==$id){
$query="UPDATE `movies` SET `title`='$name' WHERE mid=$mid";
$result=mysql_query($query) or die("QF");
echo "US"; //update successful
//add into events
//find out mid
$query="SELECT mid FROM movies WHERE owner=$id AND title='$name'";
$res=mysql_query($query);
$row=mysql_fetch_row($res);
//insert into events
$query="INSERT INTO events (mid, uid, action) VALUES ($row[0], $id, 'edited')";
mysql_query($query);
}else{
echo "NP"; //no permission
}

include('../lib/closedb.php')
?>
