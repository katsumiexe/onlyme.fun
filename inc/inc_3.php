<?php
if($dat_tmpl["orgin_line_size"]>0){

    $line_color1=hexdec(substr($dat_tmpl['orgin_line_color'],1,2));		
    $line_color2=hexdec(substr($dat_tmpl['orgin_line_color'],3,2));		
    $line_color3=hexdec(substr($dat_tmpl['orgin_line_color'],5,2));		

    $color2 = imagecolorallocate($tmp2, $line_color1, $line_color2, $line_color3);
    $colorn2 = imagecolorallocate($tmpn, $line_color1, $line_color2, $line_color3);

	for($n=$dat_tmpl["orgin_line_size"]*(-1);$n<$dat_tmpl["orgin_line_size"]+1;$n++){
		for($s=$dat_tmpl["orgin_line_size"]*(-1);$s<$dat_tmpl["orgin_line_size"]+1;$s++){

			$ya_1=$orgin_y+$n*$b;
			$xa_1=$orgin_x-$s*$b;

			imagettftext($tmp2, $orgin_size, 0, $xa_1, $ya_1, $color2, $orgin_font, $orgin);//■ふち    
			imagettftext($tmpn, $orgin_size, 0, $xa_1, $ya_1, $colorn2, $orgin_font, $orgin);//■ふち
		}
	}
}

$orgin_color1=hexdec(substr($dat_tmpl['orgin_color'],1,2));		
$orgin_color2=hexdec(substr($dat_tmpl['orgin_color'],3,2));		
$orgin_color3=hexdec(substr($dat_tmpl['orgin_color'],5,2));		

$color1 = imagecolorallocate($tmp2, $orgin_color1, $orgin_color2, $orgin_color3);
$colorn1 = imagecolorallocate($tmpn, $orgin_color1, $orgin_color2, $orgin_color3);

imagettftext($tmp2, $orgin_size, 0, $orgin_x, $orgin_y, $color1, $orgin_font, $orgin);//■本文
imagettftext($tmpn, $orgin_size, 0, $orgin_x, $orgin_y, $colorn1, $orgin_font, $orgin);//■本文

?>
