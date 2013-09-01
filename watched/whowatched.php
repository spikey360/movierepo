<?php
$mid=$_GET['t'];
include('../lib/opendb.php');
$query="SELECT users.username FROM watched INNER JOIN users ON watched.who=users.uid WHERE what=$mid";
$res=mysql_query($query) or die("QF");
if(mysql_num_rows($res)>0){
 while($row=mysql_fetch_row($res)){
 echo "$row[0], ";
 }
}
include('../lib/closedb.php');
?>
