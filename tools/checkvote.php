<?php
//voting
$id=$_COOKIE['id'];
$poll=$_POST['pol'];

include('../lib/opendb.php');
//check if already voted
$query="SELECT vid FROM votes WHERE uid=$id AND pollid=$poll";
$res=mysql_query($query);
if($res==TRUE){
if(mysql_num_rows($res)>0){
echo "VA";
//exit();
}
}else{
echo "QF";
//exit();
}
include('../lib/closedb.php');
?>
