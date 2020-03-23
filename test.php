<?
$rnd=array(1,2,3,4,5,6,7,8,9);
shuffle($rnd);

$dat[0]=$rnd[0];
$dat[1]=$rnd[1];
$dat[2]=$rnd[2];

print($dat[0]."<br>\n");
print($dat[1]."<br>\n");
print($dat[2]."<br>\n");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
.main{
    width:100%;
    max-width:600px;
    background:#f0f0f0;
    margin:0 auto;    
}

.hako{ 
    display:inline-block;
    width:55px;
    height:55px;
    line-height:55px;
    background:#f00000;
    box-sizing:border-box;
    border:0.5vw solid #0000ff;
    text-align:center;
    font-size:20px;

}
</style>
<script>
$(function(){ 

});
</script>
</head>
<body style="text-align:center">
<div class="main">
<span class="hako">あ</span><span class="hako">い</span><span class="hako">う</span><span class="hako">あ</span><span class="hako">い</span><span class="hako">う</span><span class="hako">あ</span><span class="hako">い</span><span class="hako">う</span><span class="hako">あ</span>
</div>
</body>
</html>


