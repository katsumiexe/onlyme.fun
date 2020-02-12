<?php
//■名前 

if($dat_tmpl["name_shadow_size"]>0){
	$shadow_color1=hexdec(substr($dat_tmpl['name_shadow_color'],1,2));		
	$shadow_color2=hexdec(substr($dat_tmpl['name_shadow_color'],3,2));		
	$shadow_color3=hexdec(substr($dat_tmpl['name_shadow_color'],5,2));		
	$color3 = imagecolorallocate($tmp2, $shadow_color1, $shadow_color2, $shadow_color3);
	$colorn3 = imagecolorallocate($tmpn, $shadow_color1, $shadow_color2, $shadow_color3);

	$ya_3=$name_y+$dat_tmpl["name_line_size"]*$b+$dat_tmpl["name_shadow_size"]*$b;
	$xa_3=$name_x+$dat_tmpl["name_line_size"]*$b+$dat_tmpl["name_shadow_size"]*$b;

	imagettftext($tmp2, $name_size, 0, $xa_3, $ya_3, $color3, $name_font, $name);//■影
	imagettftext($tmpn, $name_size, 0, $xa_3, $ya_3, $colorn3, $name_font, $name);//■影
}

if($dat_tmpl["name_line_size"]>0){
	$line_color1=hexdec(substr($dat_tmpl['name_line_color'],1,2));		
	$line_color2=hexdec(substr($dat_tmpl['name_line_color'],3,2));		
	$line_color3=hexdec(substr($dat_tmpl['name_line_color'],5,2));		

	$color2 = imagecolorallocate($tmp2, $line_color1, $line_color2, $line_color3);
	$colorn2 = imagecolorallocate($tmpn, $line_color1, $line_color2, $line_color3);

	for($n=$dat_tmpl["name_line_size"]*(-1);$n<$dat_tmpl["name_line_size"]+1;$n++){
		for($s=$dat_tmpl["name_line_size"]*(-1);$s<$dat_tmpl["name_line_size"]+1;$s++){
			$ya_1=$name_y+$n*$b;
			$xa_1=$name_x-$s*$b;
			imagettftext($tmp2, $name_size, 0, $xa_1, $ya_1, $color2, $name_font, $name);//■ふち    
			imagettftext($tmpn, $name_size, 0, $xa_1, $ya_1, $colorn2, $name_font, $name);//■ふち
		}
	}
}

$name_color1=hexdec(substr($dat_tmpl['name_color'],1,2));		
$name_color2=hexdec(substr($dat_tmpl['name_color'],3,2));		
$name_color3=hexdec(substr($dat_tmpl['name_color'],5,2));		

$color1	= imagecolorallocate($tmp2, $name_color1, $name_color2, $name_color3);
$colorn	= imagecolorallocate($tmpn, $name_color1, $name_color2, $name_color3);

imagettftext($tmp2, $name_size, 0, $name_x, $name_y, $color1, $name_font, $name);//■本文
imagettftext($tmpn, $name_size, 0, $name_x, $name_y, $colorn, $name_font, $name);//■本文
?>
