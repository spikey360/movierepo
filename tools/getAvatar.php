<?php

// if id is set then get the file with the id from database


include ('../lib/opendb.php');
//mysql_select_db("_pic");

$id    = $_COOKIE['id'];
$pid=$_GET['pr'];
if(!empty($pid)){
$id=$pid;
}
$query = "SELECT name, type, size, avatar " .
         "FROM avatars WHERE uid = '$id'";

$result = mysql_query($query) or die('QF');
if(mysql_num_rows($result)<1){
$query="SELECT name, type, size, avatar FROM avatars WHERE uid = '0'";
$result=mysql_query($query);
}

list($name, $type, $size, $content) = mysql_fetch_array($result);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;
include ('../lib/closedb.php');
exit();


?>
