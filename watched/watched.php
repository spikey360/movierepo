<?php

$id=$_COOKIE['id'];
$mov=$_GET['t'];
include('../lib/opendb.php');
$query="SELECT * from watched where who=$id and what=$mov";
$res=mysql_query($query) or die("QF");
if(mysql_num_rows($res)>0){
echo "WA"; //watched already
exit();
}else{
$query="insert into watched (who, what) values ($id, $mov)";
$res=mysql_query($query) or die("QF");
if($res==TRUE){
echo "IS"; //insertion successful
$query="INSERT INTO events (mid, uid, action) VALUES ($mov, $id, 'watched')";
mysql_query($query);
}
}
include('../lib/closedb.php');
?>
