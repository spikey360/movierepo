<?php
if(isset($_POST['upload']) && $_FILES['userfile']['size']>0){
$filename=$_FILES['userfile']['name'];
$tmpname=$_FILES['userfile']['tmp_name'];
$filesize=$_FILES['userfile']['size'];
$filetype=$_FILES['userfile']['type'];
$usr="";
if(isset($_COOKIE["id"])){
$usr=$_COOKIE["id"];
}
$fp=fopen($tmpname,'r');
$content=fread($fp,filesize($tmpname));
$content=addslashes($content);
fclose($fp);
if(!get_magic_quotes_gpc()){
$filename=addslashes($filename);
}
//echo "<html><body style='background-color: BLACK;'><span style='font-family: Verdana; color: GRAY'>";
include('../lib/opendb.php');
$query="SELECT aid FROM avatars WHERE uid = '$usr'";
$res=mysql_query($query) or die("QF");
if(mysql_num_rows($res)>0){
$query="UPDATE avatars SET avatar = '$content', type = '$filetype', size = '$filesize', name='$filename' WHERE uid = '$usr'";
}else{
$query="INSERT INTO avatars (uid,avatar, size, type, name) "."VALUES ('$usr','$content','$filesize','$filetype','$filename')";
}
$res=mysql_query($query) or die ("QF");
include('../lib/closedb.php');
if($res==TRUE){
echo "AU";}
else{
echo "UF";
}

}
?>
