<html>
<head><title>Edit details</title></head>
<body>
<?php
$tid=$_GET['t'];
?>

<div><span>Year</span><input type="text" id="year" /></div>
<div><span>Plot</span><textarea id="plot"></textarea></div>
<div><span>Director</span><input type="text" id="director" /></div>
<div><span>Actors</span><input type="text" id="actors" /></div>
</body>
<script src="../res/libAjax.js"></script>
<script>
initiateAjax(); //ajax up and running
function detailsresp(){
if(xmlHttp.readyState==4){
if(rt=="IS"){alert("Done");}
if(rt=="QF"){alert("Failed to update details"); return}
}
}
function tryUpdate(){
setFunction(detailsresp);
}
</script>
<style>

</style>
</html>
