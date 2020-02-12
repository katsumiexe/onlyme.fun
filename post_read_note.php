<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");

$pg=$_REQUEST["pg"];
if(!$pg) $pg="err";

include_once("./note/{$pg}.php");

echo json_encode($dat);
exit;
?>
