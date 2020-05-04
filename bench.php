<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(function(){ 
const P;
$('.start').on('click',function () {
	for (const i=0; i<100; i++) {
		let N=0;
		for (const j=0; j<600000; j++) {
			N++;
		}
		P++;
		$('#Gage').css('width',P);
	}
});
});
</script>

<style>
.gage{
	display		:inline-block;
	position	:absolute;
	top			:0
	left		:0;
	width		:0;
	height		:30px;
	background	:liner-gradient(90deg,#ffc0c0,#d00000);
}

.box{
	display		:inline-block;
	posision	:relative;
	width		:256px;
	height		:30px;
}
</style>
</head>
<body>
<div class="box">
<div id="gage" class="gage">
</div>
</div>

<button type="button" class="start">Start</button>
</body>
</html>

