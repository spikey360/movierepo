<?php
$conn=mysql_connect('localhost','webuser','webpassword') or die("Connection to database failed");
mysql_select_db('movierepo') or die('Failed to select database');
?>
