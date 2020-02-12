<?php
//■frame1-------------
if($dat_tmpl['frame1']){
	if(strpos($dat_tmpl['frame1'], "png")){
		$frame1_bk = imagecreatefrompng("./img/frame2/{$dat_tmpl['frame1']}");
		list($tmp_width, $tmp_height, $type, $attr) = getimagesize($frame1_bk);
		ImageCopyResampled($tmp2, $frame1_bk, 0, 0, 0, 0, $base_x, $base_y, $tmp_width, $tmp_height);
		ImageCopyResampled($tmpn, $frame1_bk, 0, 0, 0, 0, $base_x, $base_y, $tmp_width, $tmp_height);

	}else{
		$f0_w=$frame1_w;
		$tmp=str_replace("#","",$dat_tmpl['frame1']);
		$r=hexdec(substr($tmp,0,2));
		$g=hexdec(substr($tmp,2,2));
		$b=hexdec(substr($tmp,4,2));
		$o=floor(127*(1-$dat_tmpl['frame1_op']));
		$tmp_color=imagecolorallocatealpha($tmp2,$r,$g,$b,$o);
		$tmp_colorn=imagecolorallocatealpha($tmpn,$r,$g,$b,$o);

		imagefilledrectangle($tmp2	,0			,0			,$f0_w		,$base_y-$f0_w	,$tmp_color);
		imagefilledrectangle($tmp2	,$f0_w		,0			,$base_x		,$f0_w		,$tmp_color);
		imagefilledrectangle($tmp2	,$base_x-$f0_w	,$f0_w		,$base_x		,$base_y		,$tmp_color);
		imagefilledrectangle($tmp2	,0			,$base_y-$f0_w	,$base_x-$f0_w	,$base_y		,$tmp_color);

		imagefilledrectangle($tmpn	,0			,0			,$f0_w		,$base_y-$f0_w	,$tmp_colorn);
		imagefilledrectangle($tmpn	,$f0_w		,0			,$base_x		,$f0_w		,$tmp_colorn);
		imagefilledrectangle($tmpn	,$base_x-$f0_w	,$f0_w		,$base_x		,$base_y		,$tmp_colorn);
		imagefilledrectangle($tmpn	,0			,$base_y-$f0_w	,$base_x-$f0_w	,$base_y		,$tmp_colorn);
	}
}

?>

