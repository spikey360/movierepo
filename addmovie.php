<?php
$mov=$_POST['movnam'];
$own=$_POST['on'];
include('../lib/opendb.php');
$query="INSERT INTO movies (title, owner) VALUES (\"".$mov."\",\"". $own."\")";
mysql_query($query) or die("Query failed");
if(!$query){
echo "F";
}else{
echo "S";
}
include('../lib/closedb.php');
?>
