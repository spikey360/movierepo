<html>
<head></head>
<body>
<?php
include('../lib/opendb.php');
$query="select users.username, events.action, movies.title, timestamp from events inner join users on events.uid=users.uid join movies on events.mid=movies.mid order by eid desc limit 10;";
$res=mysql_query($query) or die("Query failed");
if(mysql_num_rows($res)>0){
while($row=mysql_fetch_row($res)){
?>
<div><span><span class="users"><?php echo $row[0]; ?></span> <span class="action"><?php echo $row[1]; ?></span> <span class="movies"><?php echo $row[2]; ?></span> on <span class="action"><?php echo $row[3]; ?></span></span></div>
<?php
}
}
include('../lib/closedb.php');
?>
<style>
@font-face{
font-family: Play;
src: url(../res/play.woff);
}
body{
font-family: Play;
}

.users{
color: red;
}
.movies{
color: purple;
}
.action{
color: gray;
}

</style>
</body>
</html>
