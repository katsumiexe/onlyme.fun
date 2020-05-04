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
		$('.start').prop("disabled", true).css('background','#ffa090'),
		$('#wait').show()

		$.post("post_bench.php",function(dat){
			Tm=$.now()-dat;
			$('#wait').hide();

			$('#box').text(Tm);
			$('#ua').text(uA);
			$('#width').text(Width);
			$('#height').text(Height);
			$('#browse').text(bW);

			$('.start').hide();
			$('.send').show();

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

.send{
	display			:none;
	height:30px;
	width:80px;
	font-size:20px;
}

#wait{
	display			:none;
	position		:fixed;
	top				:200px;
	left			:0;
	right			:0;
	margin			:auto;
	width			:100px;
	height			:100px;
	line-height		:100px;
/*	background		:rgba(255,200,225,0.6);-*/
	text-align		:center;
	border-radius	:50%;
	z-index			:100;
}

#wait_in{
	position		:absolute;
	top				:0;
	left			:0;
	right			:0;
	bottom			:0;
	margin			:auto;
	border-top		:1vw solid #ffe0f0;
	border-left		:1vw solid #ffe0f0;
	border-right	:1vw solid #ffe0f0;
	border-bottom	:1vw solid #ff3030;
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

.td_l{
	width:120px;
}

.td_r{
	width:400px;
}

</style>
</head>
<body style="text-align:center;background:#f0f0f0;">
<div style="text-align:center; width:100%; max-width:600px;background:#fafafa;margin:0 auto;height:100vh;">
<table>
<tr>
<td class="td_l">Bench Mark</td><td id="box" class="td_r"></td>
</tr><tr>
<td class="td_l">Browser</td><td id="browse" class="td_r"></td>
</tr><tr>
<td class="td_l">UA</td><td id="ua" class="td_r"></td>
</tr><tr>
<td class="td_l">Width</td><td id="width" class="td_r"></td>
</tr><tr>
<td class="td_l">Height</td><td id="height" class="td_r"></td>
</tr>
</table>
<button type="button" class="start">Start</button>
<button type="button" class="send">情報送信</button>
<div id="wait"><span id="wait_in"></span></div>
</div>
</body>
</html>
