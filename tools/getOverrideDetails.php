<?php
$cb=$_GET['callback'];
$mid=$_GET['mid'];
include('../lib/opendb.php');
$query="SELECT movies.title, year, plot, director, starring FROM details INNER JOIN movies ON details.mid=movies.mid WHERE details.mid=$mid";
$res=mysql_query($query);
if($res){
if(mysql_num_rows($res)>0){
$row=mysql_fetch_row($res);
$array=array('valid'=>"true",'Title'=>"$row[0]",'Year'=>"$row[1]",'Plot'=>"$row[2]",'Director'=>"$row[3]",'Actors'=>"$row[4]",'ID'=>'#');
echo $cb.'('.json_encode($array).');';
}else{
$array=array('valid'=>"false");
echo $cb.'('.json_encode($array).');';
}
}else{
$array=array('valid'=>"false");
echo $cb.'('.json_encode($array).');';
}
include('../lib/closedb.php');
?>
