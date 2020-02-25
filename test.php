<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style>
/*
svg {
transform: rotate(-90deg);
}
*/
circle {
fill: transparent;
stroke: #ffffe0;
stroke-width: 4;
animation: circle 2s;
}

@keyframes circle {
0% { stroke-dasharray: 0 377; }
99.9%{ stroke-dasharray: 377 377; }
}


.main_circle {
position: relative;
width: 150px;
height: 150px;
border-radius: 50%;
background:linear-gradient(135deg, #aaaaaa, #888888);
z-index:100;
}
.circle {
position: absolute;
top:0;
left:0;
right:0;
bottom:0;
margin:auto;
border-radius: 50%;
width: 116px;
height: 116px;
background:linear-gradient(135deg, #00a000, #004000);
border:4px solid #fff; /* ボーダーで円を描く */
z-index:101;
}

.point_2{
position :absolute;
top :0;
left :0;
right :0;
bottom :0;
margin :auto;
height :2px;
width :2px;
border-radius:50%;
background :#ffffff;
box-shadow :0px 0px 4px 4px rgba(255,255,255,0.5);
z-index :112;
}

.point{
position :absolute;
top :0;
left :0;
right :0;
bottom :0;
margin :auto;
z-index :111;

border :1px solid #ffffff;
display :inline-block;
height :1px;
width :1px;
border-radius:50%;
box-shadow :0 0 2px 4px rgba(255,255,255,0.5),0 0 1px 2px rgba(255,255,255,0.5) inset;
}
</style>
</head>
<body>
<div class="main_circle">
<div class="point"></div>
<div class="point_2"></div>
<div class="circle">
<!-- 
<svg width="124" height="124">
<circle cx="62" cy="62" r="60" />
</svg> 
-->
</div>
</div> 
<script>

$(function(){
setInterval(function(){
$('.point').animate({width:'30px',height:'30px', opacity: 0}, 1000).animate({width:'1px',height:'1px', opacity: 1}, 1);
},1000);
});

</script>
</body>
</html>