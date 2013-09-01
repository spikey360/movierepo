<?php
$id=$_COOKIE['id'];
$ornt=$_POST['o'];
$post=$_POST['p'];
include('../lib/opendb.php');
$query="SELECT * FROM orientatn WHERE pid=$post AND uid=$id";
$res=mysql_query($query) or die("QF");
if(mysql_num_rows($res)>0){
echo "VA";
}
else{
$query="INSERT INTO orientatn (pid, ornt, uid) VALUES ($post,$ornt,$id)";
$res=mysql_query($query) or die("QF");
if($res==TRUE){
echo "PS";
}
}
include('../lib/closedb.php');
?>
