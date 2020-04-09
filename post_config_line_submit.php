<?







include_once("./library/session.php");
$sql="UPDATE reg SET reg_line=''";
$sql.=" WHERE id='{$_SESSION["id"]}'";
mysqli_query($mysqli,$sql);

echo $dat;
exit;
?>
