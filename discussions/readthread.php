<html>
<head><title></title></head>
<body
onload="getAllPosts(<?php $t=$_GET[] ?>)"
>
<div id="thread"></div>
</body>
<script src="../res/libAjax.js"></script>
<script>
initiateAjax(); //ajax up and running
function dispAllPosts(){
if(xmlHttp.readyState==4){
xml=xmlHttp.responseXML;
doc=xml.documentElement;
posts=doc.getElementsByTagName("post");
users=doc.getElementsByTagName("user");
threadposts="";
for(i=0;i<posts.length;i++){
threadposts+="<span class='post'><p>"+posts.item(i).firstChild.data+"</p>-"+users.item(i).firstChild.data+"</span><br>";
}
document.getElementById("thread").innerHTML=threadposts;
}
}
function getAllPosts(thread){
setFunction(dispAllPosts);
sendRequest("getAll.php?t="+thread);
}
</script>
<style>
.post{

}
</style>
</html>
