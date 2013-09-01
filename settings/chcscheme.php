<?php
$id=$_COOKIE['id'];
$cs=$_POST['cs'];
include('../lib/opendb.php');
$query="SELECT sid FROM settings WHERE uid=$id";
$res=mysql_query($query) or die("QF");
if(mysql_num_rows($res)>0){
$altquery="UPDATE movierepo.settings SET cscheme = $cs WHERE settings.uid=$id";
$res=mysql_query($altquery) or die("QF");
if($res==TRUE){
echo "CS";
}
}
include('../lib/closedb.php');
?>
