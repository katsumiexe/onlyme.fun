<html>
<body>
<?
echo modifier_disp_date("2020-01-31 06:00:00");

function modifier_disp_date($string)
{

$timestamp = strtotime($string);
$nowstamp = mktime();
$sec = $nowstamp - $timestamp;
if($sec < 3600){
$rtn = round($sec/60) . '分前';
}elseif($sec < 3600 * 24){
$rtn = round($sec/(60*60)) . 'h前';
}elseif($sec < 3600 * 24 * 31){
$rtn = round($sec/(60*60*24)) . '日前';
}else{
$rtn = '1ヶ月以上';
}
return $rtn;
}
?>
</body>
</html>
