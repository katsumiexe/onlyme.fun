<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
const uA = window.navigator.userAgent.toLowerCase();
const Width = window.screen.width;
const Height = window.screen.height;

if(uA.indexOf("edge") !== -1 || uA.indexOf("edga") !== -1 || uA.indexOf("edgios") !== -1) {
bW="Edge";
} else if (uA.indexOf("opera") !== -1 || uA.indexOf("opr") !== -1) {
bW="Opera";

} else if (uA.indexOf("samsungbrowser") !== -1) {
bW="Samsung";

} else if (uA.indexOf("ucbrowser") !== -1) {
bW="UC";

} else if(uA.indexOf("chrome") !== -1 || uA.indexOf("crios") !== -1) {
bW="Chrome";

} else if(uA.indexOf("firefox") !== -1 || uA.indexOf("fxios") !== -1) {
bW="firefox";

} else if(uA.indexOf("safari") !== -1) {
bW="safari";

} else if (uA.indexOf("msie") !== -1 || uA.indexOf("trident") !== -1) {
bW="IE";

} else {
bW="None";


}



$(function(){ 
let P=0;
let St=$.now();
	$('.start').on('click',function () {
		$('.start').prop("disabled", true).css('background','#d00000'),
		$('#wait').show()

		$.post("post_bench.php",function(dat){
			Tm=$.now()-dat;
			$('#wait').hide();

			$('#box').text(Tm);
			$('#ua').text(uA);
			$('#width').text(Width);
			$('#height').text(Height);
			$('#browse').text(bW);

		});
	});
});
</script>

<style>
.gage{
	display		:inline-block;
	position	:absolute;
	top			:0;
	left		:0;
	width		:10px;
	height		:30px;
	background	:linear-gradient(270deg,#ffc0c0,#d00000);
}

.box{
	display		:block;
	position	:relative;
	width		:256px;
	height		:30px;
	border		:1px solid #909090;
}

.start{
	height:30px;
	width:80px;
	font-size:20px;
}

#wait{
	display		:none;
	position	:fixed;
	top			:0;
	left		:0;
	right		:0;
	bottom		:0;
	margin		:auto;
	width		:100px;
	height		:100px;
	line-height	:100px;
	background	:rgba(255,200,225,0.6);
	text-align	:center;
	border-radius:50%;
	z-index		:100;
}

#wait_in{
	position		:absolute;
	top				:0;
	left			:0;
	right			:0;
	bottom			:0;
	margin			:auto;
	border-top		:1vw solid #ffffff;
	border-left		:1vw solid #ffffff;
	border-right	:1vw solid #ffffff;
	border-bottom	:1vw solid #f17766;
	border-radius	:50%;
	animation		:r1 2s linear infinite;
	display			:inline-block;
	height			:80px;
	width			:80px;
}

@keyframes r1 {
	0%   { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}


td{
	border:1px solid #606060;
	padding:3px 5px;
}

</style>
</head>
<body>
<div style="text-align:center;">
<div class="box">
<div id="gage" class="gage">
</div>
</div>
<button type="button" class="start">Start</button>
■

<table>
<tr>
<td>Bench Mark</td><td id="box"></td>
</tr><tr>
<td>Browser</td><td id="browse"></td>
</tr><tr>
<td>UA</td><td id="ua"></td>
</tr><tr>
<td>Width</td><td id="width"></td>
</tr><tr>
<td>Height</td><td id="height"></td>
</tr>
</table>


<div id="wait"><span id="wait_in"></span></div>
</div>
</body>
</html>
