
$(function(){
window.hostUrl = window.location.origin;
//套餐选择
    $('.package .item').not('.num_input').click(function(){
        $('#pdt_id').val($(this).data('pdt_id'));
        $('#pdt_sn').val($(this).data('pdt_sn'));
        $('#pdt_sale_price').val($(this).data('now'));
        $('#details').val($(this).data('details'));
        $(this).addClass('current').siblings('.item').removeClass('current');
        $(this).parents('.section').siblings('.section').find('.item').removeClass('current');
        var dataNow = $(this).data('now');
        var dataFisrt = $(this).data('first');
//即将到期优惠
      ExpireDiscount(dataNow,dataFisrt);
    })


    // 年中活动赠送 并且 到期折扣，活动到期后折扣还原
         function yearsMiddle(discount){
           // $('#ACTIVITY_OPEN').attr('value','');
            // actState = $('#ACTIVITY_OPEN').val();
             if($('#ACTIVITY_OPEN').val() == ''){
                $('.actTxt').show();
                if($('#pdt_id').val()=="2"){      
                        $('.discount').html('<div class="left">限时优惠:</div><div class="right">老用户<strong>'+discount+'</strong>折！另送5次转换</div>');
                    }else if($('#pdt_id').val()=="5"){
                        $('.discount').html('<div class="left">限时优惠:</div><div class="right">老用户<strong>'+discount+'</strong>折！另送3个月</div>');
                    }else if($('#pdt_id').val()=="6"){
                         $('.discount').html('<div class="left">限时优惠:</div><div class="right">老用户<strong>'+discount+'</strong>折！另送6个月</div>');
                    }else if($('#pdt_id').val()=="3" || $('#pdt_id').val()=="4"){
                        $('.discount').html('<div class="left">限时优惠:</div><div class="right">老用户<strong>'+discount+'</strong>折！</div>');
                    } 
                    
              }else{
                   $('.discount').html('<div class="left">限时优惠:</div><div class="right">老用户<strong>'+discount+'</strong>折！</div>');
                   $('.actTxt').hide();
              }
          }


    function yearsMiddle2(){// 年中活动赠送 无折扣
        //$('#ACTIVITY_OPEN').attr('value','');
        if($('#ACTIVITY_OPEN').val() == ''){
            $('.actTxt').show();
            if($('#pdt_id').val()=="2"){      
                $('.discount').html('<div class="left">限时优惠:</div><div class="right">另送5次转换</div>');
            }else if($('#pdt_id').val()=="5"){
                $('.discount').html('<div class="left">限时优惠:</div><div class="right">另送3个月</div>');
            }else if($('#pdt_id').val()=="6"){
                 $('.discount').html('<div class="left">限时优惠:</div><div class="right">另送6个月</div>');
            }else if($('#pdt_id').val()=="3" || $('#pdt_id').val()=="4"){
                $('.discount').html('');
            }
            
        }else{
            $('.discount').html('');
            $('.actTxt').hide();
        }
       
    }

//即将到期优惠
  function ExpireDiscount(now,fisrt){
    $('.original').show();
    var state = $("#end_time").val();
    var timeCountOut = $('#end_time_count_out').val();
    $('#pay .save_money').html('省'+(fisrt-now)+'元');
    $('#pay .pay_money').html(now+'元');
    $('#pay .first_price').html('原价'+fisrt+'元');
    if(state <= 7 && state !=0){
          yearsMiddle(9);
          $('.last_pay .pay_money').html(accMul(now,0.9)); 
    }else if(timeCountOut <= 30 && timeCountOut !=0){
           yearsMiddle(9.5);         
          $('.last_pay .pay_money').html(accMul(now,0.95));    
    }else if((state ==0 && timeCountOut==0) || timeCountOut>30 || state>7){
          yearsMiddle2();
          $('.last_pay .pay_money').html(now);       
    }
 
  }
//即将到期优惠 初始化
 var dataNowinit = $('.item[name="tc_default"]').data('now');
 var dataFisrtinit = $('.item[name="tc_default"]').data('first'); 
  ExpireDiscount(dataNowinit,dataFisrtinit);

//递增
    var amount = $('.section_one .amount').val();
   $('.add_numberof').click(function(){
        amount++;
        if(amount > 1000){
            amount = 1000;
        }        
        $('#pdt_id').val(1);
        $('.section_one .amount').val(amount);
        addCalculation(amount);
        
   })

//递减
   $('.reduce_numberof').click(function(){
       
        if(amount>1){
            amount--;
            addCalculation(amount);
            $('.section_one .amount').val(amount);
            $('#pdt_stock').val(amount);
            $('#pdt_id').val(1);
        }
        
   })

   //次数加减算钱 5次送1
   function addCalculation(number){
      $('.discount').html("");
      $('#pay .save_money').html("");
      $('#pay .first_price').html(""); 
      $('.original').hide();
      // 次数单价
      var UnitPrice = parseInt($('#times').data('now'));
      if(parseInt(number)>0){
         $('.last_pay .pay_money').html((UnitPrice*number));
         if(number%5==0){
            var time = parseInt(number) + parseInt(number/5);
            $('.give_promet span').html(time);
          }else{
             var time = parseInt(number) + Math.floor(number/5);
             $('.give_promet span').html(time);
          }
      }
     
      
   }

   // 点击加减回到次数

   $('.upor_down').click(function(){
      $(this).parent().siblings('.item').addClass('current').parents(".section").siblings().find('.item').removeClass('current');
      $('#pdt_stock').val(amount);
      $('#details').val($(this).parent().siblings('.item').data('details'));
      addCalculation(amount); 
   });

// 点击次数
   $('#times').click(function(){
       amount = $('.section_one .amount').val();
        $('#pdt_stock').val(amount);
        $('#details').val($(this).data('details'));
        $('#pdt_id').val($(this).data('pdt_id'));
        $(this).addClass('current').parents(".section").siblings().find('.item').removeClass('current');
        addCalculation(amount);
   });



//只能输入数字
$('.section_one .amount').keyup(function() {
   
    var tmptxt = $(this).val(); 

    $(this).val(tmptxt.replace(/\D|^0/g, ''));
    if($(this).val() == '') $(this).val();
  }).bind("paste", function() {
    var tmptxt = parseInt($(this).val());

    $(this).val(tmptxt.replace(/\D|^0/g, ''));
    if($(this).val() == '') $(this).val();
  }).css("ime-mode", "disabled");
//次数文本值改变而改变pay 00
  $('.section_one .amount').keyup(function(){
    
        amount = $('.section_one .amount').val();
            if(amount  > 1000){
            amount = parseInt(1000);
        }
        $('.section_one .amount').val(amount);
        $('#pdt_stock').val(amount);
        $('#pdt_id').val(1);
        $(this).parent().siblings('.item').addClass('current').parents(".section").siblings().find('.item').removeClass('current'); 
        $('#details').val($(this).parent().siblings('.item').data('details'));
         addCalculation(amount);
        if(amount=="" || amount ==0){
            $('.section_one .amount').val(1);
            addCalculation(1);
        }
     
  })
  
  //支付宝支付
  $('.pay_zfb').click(function(){       
      var uploadUrl = '/Ucenter/Financial/doALIPAY?code=ALIPAY&o_id='+$("#o_id").val()+'&details='+parseInt($('#details').val());//
      window.open(uploadUrl)
      $("#be_paid").hide();
      $("#pay_Waiting").css('display','inline-block').siblings().hide();
        onloadQueryApplayOrderPAy();
   })
//生成支付宝订单
   $('#ALIPAY_PAY').click(function(){             
            var pdt_id = $('#pdt_id').val();
            var details = parseInt($('#details').val());
            var pdt_stock = parseInt($('#pdt_stock').val());
            var pdt_sn = $('#pdt_sn').val();
            var pdt_sale_price = $('#pdt_sale_price').val();
//            if (isNaN(details)){
//                    $.ThinkBox.error('异常错误');
//                    return;
//            }
//            if (pdt_sn == ''){
//                    $.ThinkBox.error('SKU编码不能为空');
//                    return;
//            }
//            if (isNaN(pdt_sale_price)){
//                    $.ThinkBox.error('价格不能为空');
//                    return;
//            }
//            if (pdt_id == ''){
//                    $.ThinkBox.error('异常错误:pdt为空');
//                    return;
//            }
//            if (pdt_stock < 1){
//                $.ThinkBox.error('数量不能小于一');
//                return;
//            }
                $('#pc_abbreviation').val('ALIPAY');
                $("#submitSkipFrom").submit();

  });
  
   //微信支付 
  
//  $('.weixin_pay').click(function(){    
//        var pdt_id = $('#pdt_id').val();
//            var details = parseInt($('#details').val());
//            var pdt_stock = parseInt($('#pdt_stock').val());
//            var pdt_sn = $('#pdt_sn').val();
//            var pdt_sale_price = $('#pdt_sale_price').val();
//            $("#pc_abbreviation").val('WEIXIN')
//            if (isNaN(details)){
//                    $.ThinkBox.error('异常错误');
//                    return;
//            }
//            if (pdt_sn == ''){
//                    $.ThinkBox.error('SKU编码不能为空');
//                    return;
//            }
//            if (isNaN(pdt_sale_price)){
//                    $.ThinkBox.error('价格不能为空');
//                    return;
//            }
//            if (pdt_id == ''){
//                    $.ThinkBox.error('异常错误:pdt为空');
//                    return;
//            }
//            if (pdt_stock < 1){
//                $.ThinkBox.error('数量不能小于一');
//                return;
//            }
////            var data = $('#submitSkipFrom').serialize();
////                data += '&pc_abbreviation=WEIXIN';
//                var url = '/Ucenter/Financial/doAddDepositOnline';
//                $('#submitSkipFrom').attr('action',url);
//                 $("#submitSkipFrom").submit();
//	/**************************************************/
////	$.ajax({
////            url:url,
////            dataType:"html",
////            type:"post",
////         //   async:false,
////            data:{
////                'details': details,
////                'pdt_stock':pdt_stock,
////                'pdt_id':pdt_id,
////                'pdt_sn':pdt_sn,
////                'pdt_sale_price':pdt_sale_price,
////                'clien':'clien',
////                'pc_abbreviation':'WEIXIN'
////            },
////            success:function(htm){
////			//    $('#'+item).html(htm);
////              $('.popup_content').html(htm);
////              $('.popup_weixin').show(); 
////              $('.popup_weixin .content').css({'margin-top':($(window).height()-460)/2});
////              $('.popup_weixin .close').click(function(){
////                   $('#weixin_ifram').remove();
////                   $('.popup_weixin').hide();
////              });
////                    onloadQueryOrderPAy();
////            }
////        });
//  });
//微信登录
    $('#login_weixin').click(function(){    
                var url = '/Home/Index/weixinlogin';               
                 
	/**************************************************/
	$.ajax({
            url:url,
            dataType:"html",
            data:{
                'redirect': $("#redirect").val()
            },
            type:"post",
            async:false,
            success:function(htm){
              $('.popup_weixin').html(htm);
              $('.popup_weixin').show(); 
              $('.popup_weixin .content').css({'margin-top':($(window).height()-460)/2});
              $('.popup_weixin .close').click(function(){
                   $('#weixin_ifram').remove();
                   $('.popup_weixin').hide();
              });
            }
        });
    return false;
  });
    $('#login_data').click(function(){    
                var url = '/Home/Index/weixinlogin';               

	/**************************************************/
	$.ajax({
            url:url,
            data:{
                'redirect': $("#redirect").val()
            },
            dataType:"html",
            type:"post",
            async:false,
            success:function(htm){
			//    $('#'+item).html(htm);
              $('.popup_weixin').html(htm);
              $('.popup_weixin').show(); 
              $('.popup_weixin .content').css({'margin-top':($(window).height()-460)/2});
              $('.popup_weixin .close').click(function(){
                   $('#weixin_ifram').remove();
                   $('.popup_weixin').hide();
              });
            }
        });
  });

// 支付宝弹窗
  $('.popup_zfb .close').click(function(){
      $('.popup_zfb').hide();
  });

  $('.success_box,.login_promet').css('min-height',$(window).height()-376);
  $('.btn_contain,.btn_return').click(function(){
      $('#play_success,.popup_zfb').hide();
  });

  $('.zfb_info .btn_end').click(function(){
     $('.popup').hide();
  })


  $('.popup_exceed .close').click(function(){
      $('.original').hide();
      var datanow = $('#times').data('now');
      var pdt_id_number = $('#pdt_id_number').val();
      $('.last_pay .pay_money').html(pdt_id_number*datanow);   
  })


  // 活动时间提示
  // 
  var start_time = document.getElementById("ACTIVITPPROJECT_TIME").value;
  var halfMonther = document.getElementById("halfMonther").value;
  var reg = new RegExp("-", "g");
  var timeStr = halfMonther.replace(reg, "/");
  var nowtimeStr = start_time.replace(reg, "/");
  var timeStr = new Date(timeStr);
  var nowtimeStr = new Date(nowtimeStr);
  $('.actDate').html((nowtimeStr.getMonth()+1)+'月'+nowtimeStr.getDate()+'日-'+(timeStr.getMonth()+1)+'月'+timeStr.getDate()+"日");



})
function checkNotEmpty(data) {
    data = data + "";
    if (data === null || data === undefined || data == "null" || data == "undefined" || data == "") {
        return false;
    } else {
        return true;
    }
}
function sendOrderGethref(type,pdt_id,details,pdt_sn){
            
            if(checkNotEmpty(pdt_id) ==true && checkNotEmpty(details) ==true && checkNotEmpty(pdt_sn) ==true ){
                    $('#pdt_id').val(pdt_id);
                    $('#details').val(details);
                    $('#pdt_sn').val(pdt_sn);
            }
            var pdt_id = $('#pdt_id').val();
            var details = parseInt($('#details').val());
            var pdt_stock = parseInt($('#pdt_stock').val());
            var pdt_sn = $('#pdt_sn').val();
            var pdt_sale_price = $('#pdt_sale_price').val();
            var token = $('#token').val();
            var union = $('#union').val();
            var client = $('#client').val();
            if (isNaN(details)){
                    $.ThinkBox.error('异常错误');
                    return;
            }
            if (pdt_sn == ''){
                    $.ThinkBox.error('SKU编码不能为空');
                    return;
            }
            if (isNaN(pdt_sale_price)){
                    $.ThinkBox.error('价格不能为空');
                    return;
            }
            if (pdt_id == ''){
                    $.ThinkBox.error('异常错误:pdt为空');
                    return;
            }
            if (pdt_stock < 1){
                $.ThinkBox.error('数量不能小于一');
                return;
            }
            var param = '?pdt_id='+pdt_id+'&details='+details+'&pdt_stock='+pdt_stock+'&pdt_sn='+pdt_sn+'&pdt_sale_price='+pdt_sale_price+'&pc_abbreviation='+type+'&token='+token+'&union='+union+'&client='+client;
        if(type == 'WEIXIN') {
                window.location.href = '/Ucenter/Financial/doAddDepositOnline'+param+'&clien=clien';
        } else {
                window.location.href = '/Ucenter/Financial/ClientapiALIPAYPayOnline'+param;
        }

    
}

function OrderPayClient(type){
            
            var PaymentSerialCount = $('#PaymentSerialCount').val();
            if($('#details').val() == 1){
                    if(PaymentSerialCount > 3){
                        SendConversionConfirm();
                        $('#ContinueNumber').attr('onclick','sendOrderGethref("'+type+'")');
                        $('#TryMonthly').attr('onclick','sendOrderGethref("'+type+'","2","2","pdf_002")');
                        MonthlyRecommendation();
                    }else if(PaymentSerialCount == 1){
                        return false;
                    }else{
                       sendOrderGethref(type);  
                    }
            } else {
                sendOrderGethref(type); 
                MonthlyRecommendation2();  
            }


}

 function ajaxLoadLoginpingMember(){
	$.post('/Home/Index/showMemberInfo',{},function(htmlObj){
            $(".main_main").children("div").remove();
            $(".main_main").html(htmlObj);
	},'html');
}       

// 乘法 清除浮点数 
function accMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try {
        m += s1.split(".")[1].length;
    }
    catch (e) {
    }
    try {
        m += s2.split(".")[1].length;
    }
    catch (e) {
    }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}


function RunOnBeforeUnload(){
	onloadQuery();
	window.onbeforeunload = function(){
		closeStr = '当前操作将丢失上传和转换的文档，确认执行该操作？';
		var liLength = $(".list > li").length;
		if(liLength > 0){

			return closeStr;
		}		
	}
	
}
function onloadQueryOrderPAy(){
                   
   // setInterval(function () {
        $.ajax({
            url: "/Ucenter/Orders/getOrderPyOid/?order_no=" + $("#order_no").val() + '&t=' + Math.round(Math.random() * 1000000),
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.status == 1) {
                    $('#weixin_ifram').remove();
                    $('.popup_weixin').hide(); 
                    clearTimeout(onloadQueryOrderPAy);
                    var option = {
                        title: "确定",
                        btn: parseInt("0011", 2),
                        onOk: function () {
                            window.location.href = data.url[0];

                        }
                    }
                    window.wxc.xcConfirm(data.info, window.wxc.xcConfirm.typeEnum.success, option);

                }else {
                    if($(".popup_weixin").is(":hidden")) 
                    { 
                        clearTimeout(onloadQueryOrderPAy);
                    } else{
                         setTimeout(function(){onloadQueryOrderPAy()}, 3000);
                    }
                    
                }
//                                        if(data.code == 1) {
//                                           window.location.href = "<?=site_url('pay/success');?>?fee=<?=$total_fee;?>";
//                                        }
            }
        });
 //   }, 3000);
             
}
function onloadQueryApplayOrderPAy(){
                   
   // setInterval(function () {
        $.ajax({
            url: "/Ucenter/Orders/getApplayOid/?order_no=" + $("#o_id").val() + '&t=' + Math.round(Math.random() * 1000000),
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.action == 1) {
                    $('#pay_Waiting').hide();
                    $('#play_success').show();
                    $('#play_success').css('display','inline-block').siblings().hide(); 
                    $("#pay_sccess_price").html(data.order.o_all_price);
                    $("#total_number").html(data.order.number_remaining);
                    $("#total_time").html(data.order.end_time);
                    clearTimeout(onloadQueryApplayOrderPAy);

                }else {
                    if($("#pay_Waiting").is(":hidden")) 
                    { 
                        clearTimeout(onloadQueryApplayOrderPAy);
                    } else{
                         setTimeout(function(){onloadQueryApplayOrderPAy()}, 3000);
                    }
                    
                }
//                                        if(data.code == 1) {
//                                           window.location.href = "<?=site_url('pay/success');?>?fee=<?=$total_fee;?>";
//                                        }
            }
        });
 //   }, 3000);
             
}

        function fileAjax(fileJson,faction){

                $.ajax({
                        type:'post',
                        url:'/Home/Index/'+faction,
                        data:{"fileInfo":JSON.stringify(fileJson)},
                        dataType:'json',
                        //async:false,
                        success:function(returnlInfo){
                        }		
                });
        }
       function fileAjaxAsynchronous(fileJson,faction){
                $.ajax({
                        type:'post',
                        url:'/Home/Index/'+faction,
                        data:{"fileInfo":JSON.stringify(fileJson)},
                        dataType:'html',
                        success:function(returnlInfo){
                        }		
                });
       }
        function getTypeUpload(filetype){

		if(!filetype)return;

		filetype = filetype.toLowerCase();
		switch(filetype){
			
			case '.doc':
				$type = 'Word';
				break;
			case '.docx':
				$type = 'Word';
				break;
			case '.xls':
				$type = 'Excel';
				break;
			case '.xlsx':
				$type = 'Excel';
				break;
			case '.ppt':
				$type = 'PPT';
				break;
			case '.pptx':
				$type = 'PPT';
				break;
			case '.pdf':
				$type = 'PDF';
				break;
			default:
				$type = 0;

		}
		return $type;
	}
	function getType(filetype){

		if(!filetype)return;

		filetype = filetype.toLowerCase();
		switch(filetype){
			
			case 'doc':
			case 'docx':
				$type = 'Word';
				break;
			case 'xls':
			case 'xlsx':
				$type = 'Excel';
				break;
			case 'ppt':
			case 'pptx':
				$type = 'PPT';
				break;
			case 'pdf':
				$type = 'PDF';
				break;
			default:
				$type = 0;

		}

		return $type;
	}
function getCookie(c_name){
	
	if(document.cookie.length>0){
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start != -1){ 
	    
	    c_start=c_start + c_name.length+1;
	    c_end=document.cookie.indexOf(";",c_start);
	    if (c_end==-1) c_end=document.cookie.length;
	    return unescape(document.cookie.substring(c_start,c_end));
	   } 
	}
	return ""
}
function setCookie(c_name,value,expiredays){
	
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	//document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	//console.debug(exdate);
	document.cookie=c_name+"="+escape(value);
}


// 清除浮点数
function accMul(arg1,arg2)  
{  
    var m=0,s1=arg1.toString(),s2=arg2.toString();  
    try{m+=s1.split(".")[1].length}catch(e){}  
    try{m+=s2.split(".")[1].length}catch(e){}  
    return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)  
}

function accSub(arg1,arg2){      
    return accAdd(arg1,-arg2);  
}
function SendConversionConfirm(){
        $('.popup_exceed').show().siblings('.popup').hide();
        $('.popup_exceed .content').css('display','inline-block');
        $('.popup_exceed .content').css('margin-top',($(window).height()-$('.popup_exceed .content').height()-40)/2);
}
function accAdd(arg1,arg2){  
    var r1,r2,m;  
    try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}  
    try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}  
    m=Math.pow(10,Math.max(r1,r2))  
    return (arg1*m+arg2*m)/m  
}


//包月推荐
function MonthlyRecommendation(){
     //次数支付多次后提示 使用包月支付更实惠 
    var pdt_id_number = parseInt($('#pdt_id_number').val());
    if(pdt_id_number==1){
        $('.original').show();
        var dataNowinit = $('.item[name="tc_default"]').data('now');
        var dataFisrtinit = $('.item[name="tc_default"]').data('first'); 
        $('#pay .save_money').html('省'+(dataFisrtinit-dataNowinit)+'元');
        $('#pay .pay_money').html(dataNowinit+'元');
        $('.last_pay .pay_money').html(dataNowinit);
        $('#pay .first_price').html('原价'+dataFisrtinit+'元');
    }
}

//包月推荐
function MonthlyRecommendation2(){
     //次数支付多次后提示 使用包月支付更实惠 
    var pdt_id_number = parseInt($('#pdt_id_number').val());
    if(pdt_id_number==1){
        $('.original').hide();
        var dataNowdj = $('#time').data('now');
        $('#pay .save_money').html('');
        $('#pay .pay_money').html('');
        $('#pay .first_price').html('');
        $('.last_pay .pay_money').html(dataNowdj);
    }
}






