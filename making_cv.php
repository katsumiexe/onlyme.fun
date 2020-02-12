<?php
	$cvimg	= $_REQUEST['cvimg'];
	$url1	= $_REQUEST['url1'];
	$url2	= $_REQUEST['url2'];
	$rote	= $_REQUEST['rote']+0;
	$rote2	= $_REQUEST['rote2']+0;

	$link="./".$url1.$url2;
	
//	."?r1=".$rote."&r2=".$rote2;
/*
	$fp = fopen($link, 'w');
	fwrite($fp,base64_decode($cvimg));
	fclose($fp);
*/

	if($rote ==90){
		$rote =270;

	}elseif($rote ==270){
		$rote =90;
	}


	$rote +=$rote2;

	if($rote>360){
		$rote=-360;
	}

	$img = imagecreatefromstring(base64_decode($cvimg));
	if ($newimg = imagerotate($img, $rote, 0, 0)){
		imagepng($newimg,$link);
	}

//	if ($newimage = imagerotate($image, 90, 0, 0)) { Imagejpeg($newimage , $out); }

?>
<?=$url1?><br>
<?=$url2?><br>
