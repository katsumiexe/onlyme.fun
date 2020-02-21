$(function(){ 
	$('.head_mymenu').on('click',function(){
		if($(this).hasClass('mypage_on')){
			$(this).removeClass('mypage_on');
			$('.mypage').animate({'left':'-100vw'},150);
			$('.mymenu_b').fadeIn(150);

			$('.mymenu_a,.mymenu_c').animate({'left':'1vh','width':'5vh'},150);
			$('.head_mymenu').animate({'border-radius':'1vh'},150);

			$({deg:-23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

		}else{
			$(this).addClass('mypage_on');
			$('.mypage').animate({'left':'0'},150);
			$('.mymenu_b').fadeOut(150);
			$('.mymenu_a,.mymenu_c').animate({'left':'0vh','width':'5.6vh'},150);
			$('.head_mymenu').animate({'border-radius':'3.5vh'},150);

	

			$({deg:0}).animate({deg:-45}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:0}).animate({deg:45}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});
		}
	});

	$('.tuto').on('click',function(){
		if($('#tuto_pg2').css('display')=='none'){
			$('#tuto_pg1').fadeOut(100);
			$('#tuto_pg2').fadeIn(500);
		}else{
			$('.tuto').hide();
		}
	});

	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('#to_top').fadeIn();
		} else {
			$('#to_top').fadeOut();
		}
	});

	$('#to_top').on('click',function () {
		$('body,html').animate({scrollTop: 0}, 500);
	});

});
