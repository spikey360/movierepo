<?php
$id=$_COOKIE['id'];
if(empty($id)){
echo "LR"; //login required
exit();
}
$c=0;
include('../lib/opendb.php');
$query="SELECT DISTINCT tid FROM disc_posts WHERE user=$id";
$res=mysql_query($query);
if(mysql_num_rows($res)>0){
while($row=mysql_fetch_row($res)){
$query="SELECT disc_threads.topic, users.username, disc_posts.user FROM disc_posts INNER JOIN disc_threads ON disc_posts.tid = disc_threads.tid JOIN users ON disc_posts.user = users.uid WHERE disc_posts.tid=$row[0] ORDER BY disc_posts.pid DESC LIMIT 1"; //correct
 $rres=mysql_query($query);
 $rrow=mysql_fetch_row($rres);
 if($rrow[2]!=$id){
 $c++;
 }else{
 }
}
}
echo $c;
include('../lib/closedb.php');
?>
