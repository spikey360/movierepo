<?php
//data needed: by and mid
if(!isset($_COOKIE['id'])){
include('../login/index.html');
exit();
}
$by=$_COOKIE['id'];
$mid=$_GET['mid'];
include('../lib/opendb.php');
$query="INSERT INTO `movierepo`.`requests` (`rid`, `by`, `for`, `timestamp`) VALUES (NULL, '$by', '$mid', CURRENT_TIMESTAMP)";
$result=mysql_query($query) or die("QF");
if($result==TRUE){
echo "RM"; //request made
//////////CREATE A JOIN TABLE TO GET ALL DATA
$query="SELECT title, users.mail FROM movies INNER JOIN users ON movies.owner = users.uid WHERE movies.mid =$mid";
$result=mysql_query($query);
$row=mysql_fetch_row($result);
$to="$row[1]";
$movnam="$row[0]";
$query="SELECT mail, username FROM users WHERE uid=$by";
$result=mysql_query($query);
$row=mysql_fetch_row($result);
$from="$row[0]";
$fromnam="$row[1]";
///////////////////////
//$to      = 'nobody@example.com';
$subject = "Borrowing your ".$movnam;
$message = "Hey, I saw you have ".$movnam." listed at Spikey Movie Repo. Can you kindly lend it to me for sometime? -".$fromnam;
$headers = 'From: '.$from . "\r\n" .
    'Reply-To: '.$from . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
///////////////////////
}
include('../lib/closedb.php');
?>
