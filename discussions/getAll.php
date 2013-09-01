<?php
$tid=$_GET['t'];
header('Content-Type: text/xml');
$dom = new DOMDocument();
$response=$dom->createElement('response');
$dom->appendChild($response);
$posts=$dom->createElement('posts');
$response->appendChild($posts);

include('../lib/opendb.php');
$query="SELECT * from (select post, user, pid FROM disc_posts where tid=$tid order by pid desc) as tbl order by pid";

/*if(empty($rpc)){
$query="select post, date, user from posts";
}*/

$res=mysql_query($query) or die('query failed');
if(mysql_num_rows($res)>0){
while($row=mysql_fetch_row($res)){
//////////////////////////
$upost=$dom->createElement('post');
//$date=$dom->createElement('date');
$username=$dom->createElement('user');

$uposttext=$dom->createTextNode($row[0]);
//$datetext=$dom->createTextNode($row[1]);
$usernametext=$dom->createTextNode($row[1]);

$upost->appendChild($uposttext);
//$date->appendChild($datetext);
$username->appendChild($usernametext);

$post=$dom->createElement('posts');

$post->appendChild($upost);
//$post->appendChild($date);
$post->appendChild($username);

$posts->appendChild($post);
}
}
$xmlstring=$dom->saveXML();
echo $xmlstring;

//////////////////////////
include('../lib/closedb.php');
?>
