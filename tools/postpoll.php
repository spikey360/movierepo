<?php
$id=$_COOKIE['id'];
$tid=$_POST['th'];
$o1=$_POST['o1'];
$o2=$_POST['o2'];
$o3=$_POST['o3'];
$o4=$_POST['o4'];
$t=$_POST['t'];
include('../lib/opendb.php');
$query="INSERT into polls (tid, uid, opt1, opt2, opt3, opt4, title) VALUES ('$tid','$id','$o1','$o2','$o3','$o4','$t')";
$res=mysql_query($query);
if($res==TRUE){
echo "PS";
}else{
echo "QF";
}
include('../lib/closedb.php');
?>
