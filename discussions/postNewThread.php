<?php
$id=$_COOKIE['id'];
$secid=$_POST['s'];
$topic=$_POST['p'];
include('../lib/opendb.php');
$query="INSERT INTO disc_threads (startedBy, topic, section) VALUES ($id,\"$topic\",$secid)";
$res=mysql_query($query) or die("QF");
if($res==TRUE){
echo "PS";
}
include('../lib/closedb.php');
?>
