<?php
$id=$_GET['mail'];
$uname=$_GET['sn'];
$pwd=$_GET['p'];
include('../lib/opendb.php');
$query="SELECT * FROM users WHERE mail='$id'";
$result=mysql_query($query) or die("QF");
if(mysql_num_rows($result)>0){
echo "UE"; //user exists
exit();
}
$query="INSERT INTO users (username, mail, password) VALUES (\"$uname\",\"$id\",\"$pwd\")";
$result=mysql_query($query) or die("QF");
$query="SELECT uid FROM users WHERE mail='$id'";
$result=mysql_query($query)or die("QF");
if(mysql_num_rows($result)>0){
//add to settings
$row=mysql_fetch_row($result);
$query="INSERT INTO settings (uid, cscheme) VALUES ('$row[0]','1')"; //1 default color scheme
$result=mysql_query($query)or die("QF");
}else{
//error condition
exit();
}
if($result==TRUE){
echo "IS"; //insertion successful
}else{
echo "IF";
}
include('../lib/closedb.php');
?>
