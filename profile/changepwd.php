<?php
$id=$_COOKIE['id'];
$nn=$_POST['n'];
include('../lib/opendb.php');
$query="UPDATE users SET password='$nn' WHERE uid=$id";
$res=mysql_query($query) or die("QF");
if($res){
echo "US";
}
include('../lib/closedb.php');
?>
