<?php
$id=$_COOKIE['id'];
$tid=$_POST['t'];
$post=$_POST['p'];
include('../lib/opendb.php');
$query="INSERT INTO disc_posts (tid, user, post) VALUES ($tid,$id,\"$post\")";
$res=mysql_query($query) or die("QF");
if($res==TRUE){
echo "PS";
}
include('../lib/closedb.php');
?>
