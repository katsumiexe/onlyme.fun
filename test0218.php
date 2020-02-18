<html>
<head>
<style>
.ques{
	display:block;
	width:300px;
	line-height:20px;
	text-align:left;
	border:1px solid #303030;
}


.result{
	display:block;
	height:300px;
	width:300px;
	line-height:120px;
	text-align:center;
	border:1px solid #303030;
}

.ok{
	display:none;
	height:260px;
	width:260px;
	border:5px solid #ff0000;
	border-radius:50%;
	font-size:30px;
	line-height:260px;
	text-align:center;
	color:#ff0000;
}

.ng{
	display:none;
}

.end{
	display:none;
}


</style>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
$(function(){ 
	var Ans=0;
	var QU=[];
	var AN=[];
QU[0]	='震源の真上の地表の部分を何というか';
AN[0]	='震央';

QU[1]	='地震の実際の揺れの単位は';
AN[1]	='進度';

QU[2]	='地震そのものの強さの単位は';
AN[2]	='マグニチュード';

	$("#q1").text(QU[Ans]);

	$('.btn').on('click',function () {
		if($("#a1").val()==AN[Ans]){
			$('.ok').show().delay(1000).fadeOut(500,function(){
				$("#a1").val("");

				if(Ans<2){
					Ans++;			
					$("#q1").text(QU[Ans]);
				}else{
					$('.end').show();
				}			
			});	
		
		}else{
			$('.ng').show();
		}
	});	
});	
</script>
</head>
<body>
<div id="q1" class="ques"></div>
<input id="a1" type="textbox" value="" name="a1" class="ans"><button id="r1" type="button" class="btn">回答</button><br>
<div class="result">
<div class="ok">正解！</div>
<div class="ng">残念！<br>不勉強！！</div>
<div class="end">全問正解！</div>
</div>
</body>
</html>
