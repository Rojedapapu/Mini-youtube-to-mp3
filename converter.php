<?php

if (empty($_GET['vid_id'])) {
    header('Location: youtubetomp3.php');
}

$video_id = $_GET['vid_id'];

?>

<style type="text/css">
.myButton {
	background-color:#4584c7;
	border-radius:28px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	padding:10px 10px;
	text-decoration:none;
}
.myButton:hover {
	background-color:#5cbf2a;
}
.myButton:active {
	position:relative;
	top:1px;
}

        
</style>
<div style="height: 150px;width: 100%">
	
<a onClick="history.go(-1);" class="myButton">Volver</a>
<center><h1>Elije para descargar</h1></center>
<iframe src="https://api.vevioz.com/api/button/mp3/<?php echo $video_id ?>" width="100%" height="100%" allowtransparency="true" scrolling="no" style="border:none"></iframe>
<br>
</div>

<script type="text/javascript">
	
	echapatras()

</script>