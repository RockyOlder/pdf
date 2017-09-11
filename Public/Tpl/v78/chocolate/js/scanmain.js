$(function() {
	$('#monthWay .row-right li').click(function() {
		$(this).addClass('checked').siblings().removeClass('checked');
		$('#times').removeClass('checked');
		$('.pay').html($(this).find('span').html());
		var packagEid = $(this).data('id');
		var txt_price ='';
		if(packagEid==1){
			txt_price = 20;
		}else if(packagEid==3){
			txt_price = 40;
		}else if(packagEid==6){
			txt_price = 60;
		}else if(packagEid==12){
			txt_price = 99;
		}else{
			txt_price = 159;
		}
		
		$('.prime-cost').html('原价'+txt_price+'元');
		// $(".input-nums").val(1);
		setData();
	});
	$('#times').click(function() {
		$(this).addClass('checked').parents('#timeWay').siblings('#monthWay').find('li').removeClass('checked');
		setData();
		timeChange();
	});

	$('.icon-add').click(function() {
		var vall = $('.input-nums').val();
		if(vall==''){
			$('.input-nums').val(1);
		}
		var inputVal = parseInt($('.input-nums').val());
		$('#times').addClass('checked').parents('#timeWay').siblings('#monthWay').find('li').removeClass('checked');
		inputVal++;
		$('.input-nums').attr('value', inputVal);
		$('#dataType').val(1);
		timeChange();
		setData();
	});

	$('.input-nums').blur(function() {
		var vall = $('.input-nums').val();
		if(vall==''){
			$('.input-nums').val(1);
			$('#times').addClass('checked').parents('#timeWay').siblings('#monthWay').find('li').removeClass('checked');
			// $('.input-nums').attr('value', inputVal);
			$('#dataType').val(1);
			timeChange();
			setData();
		}
	});

	$('.icon-reduce').click(function() {
		var inputVal = parseInt($('.input-nums').val());
		$('#times').addClass('checked').parents('#timeWay').siblings('#monthWay').find('li').removeClass('checked');
		inputVal--;
		if (inputVal >= 1) {
			$('.input-nums').attr('value', inputVal);
			timeChange();
		}
		setData();
	});
	
	$(".input-nums").keyup(function() {
		var tmptxt = $(this).val();
		$(this).val(tmptxt.replace(/\D|^0/g, ''));
		//if($(this).val() == '') $(this).val(1);
	}).bind("paste", function() {
		var tmptxt = parseInt($(this).val());
		$(this).val(tmptxt.replace(/\D|^0/g, ''));
		//if($(this).val() == '') $(this).val(1);
	}).css("ime-mode", "disabled");

	$('#input-num').bind('contextmenu', function() {
    	return false;
    });

	$('.popup .icon-close').click(function() {
		$('.popup').hide();
	});

	$('.payment-tips .icon-close,.payment-tips .btn-end,.payment-tips .btn-problem').click(function() {
		$('.payment-tips').hide();
	});

	$('.icon-zfb').bind('click', function() {
		$('.payment-tips').show();
	});

	$(".input-nums").keyup(function() {
		$('#times').addClass('checked').parents('#timeWay').siblings('#monthWay').find('li').removeClass('checked');
		var inputVal = parseInt($('.input-nums').val());
		if (inputVal >= 1) {
			$('.input-nums').attr('value', inputVal);
			timeChange();
		}
		setData();
	});

});
function ajaxCount(fileJson,faction){
            $.ajax({
                type:'post',
                url:'/Home/Products/'+faction,
                data:{"fileInfo":JSON.stringify(fileJson)},
                dataType:'json',
                //async:false,
                success:function(returnlInfo){
                }		
        });
}
function timeChange()
{
	var inputVal = parseInt($('.input-nums').val());
	$('.pay').html(inputVal*2);
	$('.prime-cost').html('');
	return true;
}

function setData()
{
	var type, count, fee;
	type = $("#timeWay li.checked").data("id") == 'times' ? 1:2;
	if(type == 1) {
		count = parseInt($(".input-nums").val());
		fee = count*2;
	} else {
		count = parseInt($('#monthWay .row-right li.checked').attr('data-id'));
		fee = $('.pay').html();
	}
	$("#dataType").val(type);
	$("#dataCount").val(count);
	$("#dataFee").val(fee);
}

// 乘法 清除浮点数
function accMul(arg1, arg2) {
	var m = 0,
		s1 = arg1.toString(),
		s2 = arg2.toString();
	try {
		m += s1.split(".")[1].length;
	} catch (e) {}
	try {
		m += s2.split(".")[1].length;
	} catch (e) {}
	return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}