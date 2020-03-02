$(function(){ 
	$('.album_box, .fav_b_box, .fav_c_box, .print_box, .print_box_out').hide();

	$('#id_notice').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.notice_box').fadeIn(100);
		$('.album_box,.fav_b_box,.fav_c_box,.print_box,.print_box_out').hide();

		$.post("post_read_notice.php",
			{
				'user_id':User_id,
				'next_notice':Next_notice,
			},
			function(data){
				$('#notice_in').html(data);				
			}
		);
	});

	$('#notice_in').on('click','.next_n',function () {
		Next_notice	= $(this).attr('id').replace("next_n", "");
		$.post("post_read_notice.php",
			{
				'user_id':User_id,
				'next_notice':Next_notice,
			},
			function(data){
				$('#next_n' + Next_notice).after(data).hide();				
			}
		);
	});

	$('#id_album').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.album_box').fadeIn(100);
		$('.notice_box,.fav_b_box,.fav_c_box,.print_box,.print_box_out').hide();

		$.post("post_read_album.php",
			{
				'user_id':User_id,
				'next_album':0,
			},
			function(data){
				$('#album_in').html(data);				
			}
		);
	});

	$('#album_in').on('click','.next_a',function () {
		Next_album	= $(this).attr('id').replace("next_a", "");
		$.post("post_read_album.php",
			{
				'user_id':User_id,
				'next_album':Next_album,
			},
			function(data){
				$('#next_a' + Next_album).after(data).hide();				

				TopNow=$(window).scrollTop();
				TopNow2=TopNow+360+"vw";
				$('body,html').animate({scrollTop:TopNow2},300);
			}
		);
	});

	$('#id_print').on('click',function () {
		Ck_count=0;
		$('.print_list').removeClass('print_list_on');
		$('.list_count').css({'background':'#909090','color':'#fafafa'});

		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');

		PrintCk=new Array();	
		$('.list_count').text(Ck_count);

		if(Maintenance==1 || Maintenance==2){
			$('.print_box_out').fadeIn(100);
			$('.notice_box,.fav_b_box,.fav_c_box,.album_box,.print_box').hide();

		}else{
			$('.print_box').fadeIn(100);
			$('.notice_box,.fav_b_box,.fav_c_box,.album_box,.print_box_out').hide();
			$.post({
				url:'post_read_print.php',
				data:{'user_id':User_id},
				dataType: 'json',
			}).done(function(data, textStatus, jqXHR){
				$('#print_in').html(data.list);				
				if(data.code){
					$('.print_list,.print_code_text').hide();
					$('.print_code,.print_code_limit').show();
					$('#id_code_del').addClass('del_on');

					$('.print_code_id').text(data.code);				
					$('#limit_date').text(data.limit);				

				}else{
					$('.print_list,.print_code_text,.pop09').show();
					$('.print_code,.print_code_limit').hide();
					$('#id_code_del').removeClass('del_on');
				}

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log("Error");
			});
		}
	});

	$('#print_in').on('click','.next_a',function () {
		Next_print	= $(this).attr('id').replace("next_p", "");

			$.post({
				url:'post_read_print.php',
				data:{'user_id':User_id,'next_print':Next_print},
				dataType: 'json',
				},

			function(data){
				$('#next_p' + Next_print).after(data.list).hide();				

				TopNow=$(window).scrollTop();
				TopNow2=TopNow+360+"vw";
				$('body,html').animate({scrollTop:TopNow2},300);
			}
		);
	});

	$('.print_back').on('click',function () {
		$('.print_page').animate({'left':'105vw'},200);				
	});

	$('#print_in').on('click','.p_btn',function () {
		Ck	= $(this).attr('id').replace("f", "");
		if($(this).hasClass('p_btn_on')){
			$(this).removeClass('p_btn_on');
			PrintCk[Ck]=0;
			Ck_count-=1;
			if(Ck_count<1){
				Ck_count=0;			
				$('.print_list').removeClass('print_list_on');
			}
			$('.list_count').text(Ck_count);

		}else{
			if(Ck_count>9){
				$('.pop06').stop(true,true).fadeIn(50).delay(1000).fadeOut(800);

			}else{
				$(this).addClass('p_btn_on');
				$('.print_list').addClass('print_list_on');
				PrintCk[Ck]=1;
				Ck_count+=1;
				$('.list_count').text(Ck_count);
			}	
		}

		if(Ck_count>0){
			$('.list_count').css({'background':'#fafafa','color':'#1d468f'});

		}else{
			$('.list_count').css({'background':'#909090','color':'#fafafa'});
		}
	});

	$('.print_box').on('click','.print_list_on',function () {
		$('#wait').show();
		var print_str = JSON.stringify(PrintCk);
		var Print = $.parseJSON(print_str);
		$.post({
			url:'post_set_print.php',
			data:{'user_id':User_id,'print_ck':Print},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('#wait,.print_list,.print_code_text').hide();
			$('.print_code,.print_code_limit').show();
			$('#id_code_del').addClass('del_on');

			$('#print_in').html(data.list);				
			$('.print_code_id').text(data.code);				
			$('#limit_date').text(data.limit);				
			$('.list_count').text("0");

		}).fail(function(jqXHR, textStatus, errorThrown){
			$('#wait').hide();
		})
	});

	$('#fav_b').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.fav_b_box').fadeIn(100);
		$('.album_box,.notice_box,.fav_c_box,.print_box,.print_box_out').hide();

		$.post("post_read_fav.php",
			{
				'tag':'b',
				'user_id':User_id,
				'next_fav_b':Next_fav_b,
			},
			function(data){
				$('#fav_in_b').html(data);				
			}
		);
	});

	$('#fav_in_b').on('click','.next_b',function () {
		Next_fav_b	= $(this).attr('id').replace("next_b", "");
		$.post("post_read_fav.php",
			{
				'tag':'b',
				'user_id':User_id,
				'next_fav_b':Next_fav_b,
			},
			function(data){
				$('#fav_in_b').html(data);				
				$('#next_b' + Next_fav_b).after(data).hide();				
			}
		);
	});

	$('#fav_c').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.fav_c_box').fadeIn(100);
		$('.album_box,.notice_box,.fav_b_box,.print_box').hide();

		$.post("post_read_fav.php",
			{
				'tag':'c',
				'user_id':User_id,
				'next_fav_c':Next_fav_c,
			},
			function(data){
				$('#fav_in_c').html(data);				
			}
		);
	});

	$('#fav_in_c').on('click','.next_c',function () {
		Next_fav_c	= $(this).attr('id').replace("next_c", "");
		$.post("post_read_fav.php",
			{
				'tag':'c',
				'user_id':User_id,
				'next_fav_c':Next_fav_c,
			},
			function(data){
				$('#fav_in_c').html(data);				
				$('#next_c' + Next_fav_c).after(data).hide();				
			}
		);
	});
	
	$('#notice_in').on('click','.prof_jump',function () {
		TmpP=$(this).attr('id').replace('p','');
		$('#p_jump_id').val(TmpP);
		$('#p_jump').submit();
	});

	$('#notice_in').on('click','.prof_jump2',function () {
		Img_id	=$(this).attr('id').replace('c','');
		$.post({
			url:'post_check_notice.php',
			data:{'user_id':User_id,'img_id':Img_id},
			dataType: 'json',

		}).done(function(data){
			console.log(data);
			Pritty	=parseInt(data.s_pritty)+0;
			Smart	=parseInt(data.s_smart)+0;
			Funny	=parseInt(data.s_funny)+0;
			Sexy	=parseInt(data.s_sexy)+0;
			All		=parseInt(data.s_all)+0;
			Pict	=data.url;
			Mdate	=data.mdate;

			$('#e_all').text(All);
			$('#e_pritty').text(Pritty);
			$('#e_smart').text(Smart);
			$('#e_funny').text(Funny);
			$('#e_sexy').text(Sexy);
			$('#tmpl').attr({'src':Pict});
			$('.p_date').text(Mdate);
			$('.p_page').animate({'left': '0.5vw'},50);

			$.post({
				url:'post_read_cheer.php',
				data:{'user_id':User_id,'card_id':Img_id},
				dataType: 'json',

			}).done(function(data2){				
				$('.cheer_list').html(data2);
			});
		});

		TopNow=$(window).scrollTop();
		var Pict	= $(this).children('input:hidden[name="pict"]').val();
		var Mdate	= $(this).children('input:hidden[name="mdate"]').val();

		$('#pict_face').attr({'src':Pict});
		Img_Url	=$(this).children('.index_img').attr('src');

		$('#tmpl').attr({'src':Img_Url});
		$('.p_date').text(Mdate);
		$('#p_pict').attr('src',Pict);
		$('.p_page').animate({'left': '0.5vw'},150);
	});

	$('#p_page_out,#p_pict').on('click',function () {
		$('.p_page').animate({'left': '105vw','height': '110vh'},100);
		$('#a_page_comment').removeClass('p_page_on');
		$('.p_cheer_box').val('');
		$(window).scrollTop(TopNow);
	});

	$('#a_page_comment').on('click',function () {
		if($(this).hasClass('p_page_comment_on')){
			$(this).removeClass('p_page_comment_on');
			$('.p_page_img').animate({'top': '7.5vw'},150);
			$('.p_cheer').animate({'top': '100vh'},150);
			$('.btm_flex').animate({'top': '115vw'},150);
			$('.tbl_p_page_msg').animate({'top': '118.5vw'},150);

		}else{
			$(this).addClass('p_page_comment_on');
			$('.p_page_img').animate({'top': '-100vh'},150);
			$('.p_cheer').animate({'top': '12vw'},150);
			$('.btm_flex').animate({'top': '1.5vw'},150);
			$('.tbl_p_page_msg').animate({'top': '7.5vw'},150);

			$.post("post_read_cheer.php",
			{
				'user_id':User_id,
				'card_id':Img_id,
				'pg':'1'
			},
			function(data){
				$('.cheer_list').html(data);
			});
		}
	});

	$('#fav_in_b,#fav_in_c').on('click', '.fav_member', function(){
	Tmp_Fav=$(this).attr('id').replace("mb_", "");
		$('#f_jump_id').val(Tmp_Fav);
		$('#f_jump').submit();
	});

	$('.pop09_b').on('click',function(){
		$.post("post_set_kiyaku.php",{
			'user_id':User_id,
		},
		function(data){
			console.log(data);
			$('#kiyaku_ck').text('');
			$('.pop09').delay(500).fadeOut(500,function(){$('#kiyaku_ck').text('')});
		});
	});

	$('#p_page_del').on('click',function(){
		$('.pop07, .pop07_a').fadeIn(300);
		$('.pop01_d1, .pop01_d2').show();
		$('.pop01_d3, .pop01_d4').hide();
	});

	$('#del_no').on('click',function(){
		$('.pop07, .pop07_a,.main').fadeOut(500);
	});

	$('#del_back').on('click',function(){
		$('.pop07, .pop07_a').fadeOut(500);

		$('.p_page').animate({'left': '105vw','height': '110vh'},100);

		$.post("post_read_album.php",
			{
				'user_id':User_id,
				'next_album':0,
			},
			function(data){
				$('#album_in').html(data);				
				$('#a_page_comment').removeClass('p_page_on');
				$('.p_cheer_box').val('');
				$('.main').show();
				$(window).scrollTop(TopNow);
			}
		);
	});

	$('#del_yes').on('click',function(){
		$('.pop01_d1, .pop01_d2').hide();
		$('.pop01_d3, .pop01_d4').show();
		
		$.post("post_image_del.php",
			{
				'img_url':Img_Url,
				'img_id':Img_id,
			},
			function(){

			}
		);
	});

	$('.print_box').on('click','.del_on',function(){
		$('.pop08, .pop08_a').fadeIn(300);
		$('.pop08_d1, .pop08_d2').show();
		$('.pop08_d3, .pop08_d4').hide();
	});

	$('#del_no2').on('click',function(){
		$('.pop08, .pop08_a').fadeOut(500);
	});

	$('#del_back2').on('click',function(){
		$('.pop08, .pop08_a').fadeOut(500);

		$.post("post_del_print.php",
			{
				'user_id':User_id,
			},

			function(data){

				$('#print_in').html(data.list);				
				$('.print_code_id').text(data.code);				

				$('#a_page_comment').removeClass('p_page_on');
				$('.p_cheer_box').val('');
				$('.main').show();
				$(window).scrollTop(TopNow);
			}
		);
	});

	$('#del_yes2').on('click',function(){
		$('.pop08_d1, .pop08_d2').hide();
		$('.pop08_d3, .pop08_d4').show();

		Ck_count=0;
		$('.print_list').removeClass('print_list_on');
		$('.list_count').css({'background':'#909090','color':'#fafafa'});

		Tmp=$('.print_code_id').text();	

		$.post({
			url:'post_del_print.php',
			data:{'user_id':User_id,'code':Tmp},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('#print_in').html(data.list);				
			$('.print_code, .print_code_limit').hide();				
			$('.print_list, .print_code_text').show();				
			$('#id_code_del').removeClass('del_on');				
		});
	});
});
