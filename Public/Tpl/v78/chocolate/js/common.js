require.config( {
        paths: {                    //如果某个前缀的依赖不是按照baseUrl拼接这么简单，就需要在这里指出
              wxLogin:'http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin'
        }
});
require(['jquery','xcConfirm','tool','wxLogin'], function($,xcConfirm,tool,wxLogin) {  
if(tool.checkNotEmpty($('#year').val()) && tool.checkNotEmpty($('#month').val()) && tool.checkNotEmpty($('#day').val())){
   // setInterval(function(){},1000);
    tool.ShowCountDown();
    tool.BehaviorStatisticsBanner();
    tool.ClickTheBanner();
    if(tool.checkNotEmpty($("#LoadDataType").val()) == false && tool.checkNotEmpty($("#gy_member_open").val()) == true && $("#Authorizationtype").val() == 0){
          if(!$("#open_box").length>0){tool.rsdConfirm('teachesDay',null,tool);}
    }
}
$(document).ready(function(){
	window.hostUrl = window.location.origin;
        	// 全选
	$(document).on('click','.column > i',function(){

		var iState = $(this).attr('file-state');
                if(iState == 'successful'){
                    $(this).toggleClass("checkbox");
                }
	});
  $(document).on('click','.change',function(){
		
		var thisName = $(this).html();
		if(thisName == '重新选择'){

			//重新选择文件
		  $("#fileupload").click();
			
		}
	});
        var bBtn = true;
	$(document).on('click','.type > ul > li',function(){
		
		$(this).closest("ul").siblings("input").val($(this).children("em").html());
		bBtn = false;
		//$(this).closest("ul").hide();

	});

	$(".check").click(function(){

		var liInfo = $(".list > li").length;
		for(var i=0;i<liInfo;i++){

			var iInfo = $(".list > li").eq(i).children('.wrapper').children('.column').children('i');
			if( iInfo.attr('file-state') == 'successful' ){
				iInfo.addClass("checkbox");
			}
		}
		//bBtn = !bBtn;
	})
   
     

    })
$(function(){
  $('.email_div .email').change(function(){
       var email= $(this).val();
       checkEmail(email);
  })
    // 单选
    $('.upload_file .label').click(function() {
         if($(this).hasClass('checked')){
            $(this).removeClass('checked');
         }else{
            $(this).addClass('checked');
         }
     });
    // 单个删除
    $('.icon_delete').click(function(){       
        $(this).parents("tr").remove();
    })

//套餐选择
    $('.package .item').not('.num_input').click(function(){
        //console.log($(this).data('number'));
        $('#pdt_id').val($(this).data('pdt_id'));
        $('#pdt_sn').val($(this).data('pdt_sn'));
        $('#pdt_sale_price').val($(this).data('now'));
        $('#details').val($(this).data('details'));
        $(this).addClass('current').siblings('.item').removeClass('current');
        $(this).parents('.section').siblings('.section').find('.item').removeClass('current');
        var dataNow = $(this).data('now');
        var dataFisrt = $(this).data('first');       
        // 此代码期限要到期时优惠
        ExpireDiscount(dataNow,dataFisrt);

        
    })



 


//即将到期优惠
  function ExpireDiscount(now,fisrt){
    $('.original').show();
    var state = $("#end_time").val();
    var timeCountOut = $('#end_time_count_out').val();
    $('#pay .save_money').html('省'+(fisrt-now)+'元');
    $('#pay .pay_money').html(now+'元');
    $('#pay .first_price').html('原价'+fisrt+'元');
    if(state <= 7 && state !=0){
          tool.yearsMiddle(9); 
          $('.last_pay .pay_money').html(accMul(now,0.9)); 
    }else if(timeCountOut <= 30 && timeCountOut !=0){
          tool.yearsMiddle(9.5);         
          $('.last_pay .pay_money').html(accMul(now,0.95));    
    }else if((state ==0 && timeCountOut==0) || timeCountOut>30 || state>7){
          tool.yearsMiddle2();
          $('.last_pay .pay_money').html(now);       
    }

  //console.log('guoqi'+timeCountOut);
  //console.log('结束'+state);
  }


//即将到期优惠 初始化
var dataNowinit = $('.item[name="tc_default"]').data('now');
var dataFisrtinit = $('.item[name="tc_default"]').data('first'); 
  ExpireDiscount(dataNowinit,dataFisrtinit);

  var Authorizationtype = $('#Authorizationtype').val();
//递增
  var amount = $('.section_one .amount').val();
   $('.add_numberof').click(function(){
        amount++;
        if(amount > 1000){
            amount = 1000;          
        }
        $('#pdt_id').val(1);
        $('.section_one .amount').val(amount);
        getTimesAct(amount);
         
   })

// 活动次数初始化
if(tool.checkNotEmpty($('#ACTIVITY_OPEN').val()) ==false){
    var inintimes = $('.section_one .amount').val();
    $('.give_promet span').html(inintimes*2);
    $('.section_one').addClass('getTimes');
}
//递减
   $('.reduce_numberof').click(function(){
      if(tool.checkNotEmpty($('#ACTIVITY_OPEN').val()) ==false){
          if(amount>1){
            amount--;
            $('.section_one .amount').val(amount);
            $('#pdt_stock').val(amount);
            $('#pdt_id').val(1);
            addCalculation2(amount);            
          }else if(amount==""){
              amount=1;
          }
      }else{
          if(amount>1){
            amount--;
            $('.section_one .amount').val(amount);
            $('#pdt_stock').val(amount);
            $('#pdt_id').val(1);
            addCalculation(amount);            
          }else if(amount==""){
              amount=1;
          }
        } 
                
   })

  //次数加减算钱 5次送1
   function addCalculation(number){
      $('.discount').html('');
      $('#pay .save_money').html("");
      $('#pay .first_price').html(""); 
      $('.original').hide();
      // 次数单价
      var UnitPrice = parseInt($('#times').data('now'));
      //console.log(UnitPrice)
      $('.last_pay .pay_money').html((UnitPrice*number));      
      if(number%5==0){
        var time = parseInt(number)+parseInt(number/5);
        $('.give_promet span').html(time);
      }else{
         var time = parseInt(number)+Math.floor(number/5);
         $('.give_promet span').html(time);
      }
   }

   //次数加减算钱 买1送一
   function addCalculation2(number){
      $('.discount').html('<div class="left">限期优惠:</div><div class="right">赠送'+number+'次转换</div>');
      $('#pay .save_money').html("");
      $('#pay .first_price').html(""); 
      $('.original').hide();
      // 次数单价
      var UnitPrice = parseInt($('#times').data('now'));
      $('.last_pay .pay_money').html((UnitPrice*number)); 
      $('.give_promet span').html(number*UnitPrice);
   }

   function getTimesAct(a){
      if(tool.checkNotEmpty($('#ACTIVITY_OPEN').val()) ==false){
         addCalculation2(a);
       }else{
           addCalculation(a);
       }
   }

    
 // 点击加减回到次数
   $('.upor_down').click(function(){
      $(this).parent().siblings('.item').addClass('current').parents(".section").siblings().find('.item').removeClass('current');
      $('#pdt_stock').val(amount);
      $('#details').val($(this).parent().siblings('.item').data('details'));     
      getTimesAct(amount);
   });


// 点击次数
   $('#times').click(function(){
       amount = $('.section_one .amount').val();
        $('#pdt_stock').val(amount);
        $('#details').val($(this).data('details'));
        $('#pdt_id').val($(this).data('pdt_id'));
        $(this).addClass('current').parents(".section").siblings().find('.item').removeClass('current');
        getTimesAct(amount);
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
        getTimesAct(amount);
        //
        if(amount==""){
          $('.section_one .amount').val(1);
          if(tool.checkNotEmpty($('#ACTIVITY_OPEN').val()) ==false){
             addCalculation2(1);
             $('.give_promet span').html('2');
           }else{
              addCalculation(1);
              $('.give_promet span').html('1');
           }   
        }
     
  })

//微信登录
function weixinlogin2(){
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
        //    $('#'+item).html(htm);
                $('.popup_weixin').html(htm);
                $('.popup_weixin').show(); 
                $('.actlogin_promet').hide();
                $('.popup_weixin .content').css({'margin-top':($(window).height()-460)/2});
                $('.popup_weixin .close').click(function(){
                     $('#weixin_ifram').remove();
                     $('.popup_weixin').hide();
                });
              }
            });
        return false;
}
   $(document).on('click','.login_weixin',function(){    
        weixinlogin2()
    });


// 支付宝弹窗
  $('.popup_zfb .content').css('margin-top',($(window).height()-460)/2);
  $('.success_box,.login_promet').css('min-height',$(window).height()-376);
  $('.btn_contain,.btn_return').click(function(){
      $('#play_success,.popup_zfb').hide();
  });

  $('.zfb_info .btn_end').click(function(){
     $('.popup').hide();
  })
  
  $('.choose_reason li').click(function(){
      $(this).addClass('on').siblings().removeClass('on');
  })


$('.popup .close').click(function(){
    $(this).parents('.popup_other,.content,.popup_zfb,.popup_actpay').hide();
    $(this).parents('.popup_other').find('.content').hide();
});


  //ie 点击input取消光标闪动
  $('.choose_file .btn_file input').click(function() {
    $(this).blur();
  });

  $('.add_banner .icon,.item_banner .icon').click(function() {
      $(this).parents('.add_banner,.item_banner').remove();
  });


  //年中活动
  var href = window.location.href.split('#');
  var hrefIndex = href.length-1;
  var dataPay =0,imgSrc="";
  function changeInfo(){
    var Authorizationtype = $('#Authorizationtype').val();
    if(Authorizationtype !==""){
        $('.popup_actpay').show();
        $('.popup_actpay .content').show();
    }else{
       $('.actlogin_promet').show();
       setTimeout(function(){
          $('.actlogin_promet').hide();
          weixinlogin2()
       },1000)
    }
  }
 
   if(tool.checkNotEmpty($('#ACTIVITY_OPEN').val()) ==false){
      if(href[hrefIndex]=="01"){
        imgSrc = $('.onemouth img').attr('setsrc');        
        dataPay = $('.onemouth .btn').data('pay');
        var details = $('.onemouth .btn').data('details');
        generateOrder(details)
        $('.zfb_pay').attr('onclick','generaAlypay('+details+')');
        $('.weixin_pay').attr('onclick','sendWXorder('+details+')');
        changeInfo();
      }else if(href[hrefIndex] =='02'){
          imgSrc = $('.oneyears img').attr('setsrc');
          dataPay = $('.oneyears .btn').data('pay');
            var details = $('.oneyears .btn').data('details');
            generateOrder(details)
            $('.zfb_pay').attr('onclick','generaAlypay('+details+')');
            $('.weixin_pay').attr('onclick','sendWXorder('+details+')');
          changeInfo();
      }else if(href[hrefIndex] =='03'){
          imgSrc = $('.twoyears img').attr('setsrc');
          dataPay = $('.twoyears .btn').data('pay');
          var details = $('.twoyears .btn').data('details');
          generateOrder(details)
          $('.zfb_pay').attr('onclick','generaAlypay('+details+')');
          $('.weixin_pay').attr('onclick','sendWXorder('+details+')');
          changeInfo();    
      }
      $('.popup_actpay .imgtype').attr('src',imgSrc);
   }else{
       $('.act_promet').show();
   }
     
      //console.log(dataPay);            
  $('.act_type_box .btn').click(function(){
        if(Authorizationtype !==""){
            dataPay = $(this).data('pay');
            var details = $(this).data('details');
            imgSrc = $(this).parent().siblings('img').attr('setsrc');
           /// console.log(imgSrc);
            generateOrder(details);
            $('.zfb_pay').attr('onclick','generaAlypay('+details+')');
            $('.weixin_pay').attr('onclick','sendWXorder('+details+')');
 
            $('.popup_actpay .imgtype').attr('src',imgSrc);
            //console.log(dataPay);
        }else{
           $('.actlogin_promet').show();
               setTimeout(function(){
                  $('.actlogin_promet').hide();
                  weixinlogin2()
           },1000)
        }      
    });
    
    $('.gettimes .degree').hover(function() {
        $(this).find('.degree_bottom').show();
    }, function() {
        $(this).find('.degree_bottom').hide();
    });

    $('.degree_bottom .current').click(function() {
         $(this).parent().hide();
    });

  })
})   
//require注释

function generaAlypay(details){
        $('.popup_actpay').hide();
        $('.popup .content').hide();
        $('.popup_zfb').show();
        $("#pay_Waiting").show();
        //$('#be_paid').css('display','inline-block').siblings().hide();
        //$('.popup_zfb #be_paid').css({'margin-top':($(window).height()-460)/2});
        ajaxCount({"s_status":3,"s_value":details,"s_payment":"ALIPAY","s_type":$("#get_data").val()},'AjaxActiviOrderPay');
        onloadQueryApplayOrderPAy(details);
}

//微信支付
function sendWXorder(details){
        var url = '/Ucenter/Financial/doAddDepositOnline';
        var o_id = $("#o_id").val()
        if(details == 1){
            var pdt_type = 1;
        } else {
            var pdt_type = 2;
        }
        /**************************************************/
        $.ajax({
            url: url,
            dataType: "html",
            type: "post",
            //   async:false,
            data: {
            'details': pdt_type,
            'pdt_id':details,
            'activity':1,
            'activity_o_id':o_id,
            'pc_abbreviation':'WEIXIN'
            },
            success: function (htm) {
                $('.popup_content').html(htm);
                var getSysconfigActivity = $('#getSysconfigActivity').val();
                if(getSysconfigActivity == 2){
                    $('.popup_actpay').hide();
                    $('.popup .content').hide();
                    $('.act_promet').show();
                } else {
                    var PaymentSerialCount = $('#PaymentSerialCount').val();
                    if(PaymentSerialCount!==1){
                       $('.popup_actpay').hide();
                       $('.popup .content').hide();
                       $('.popup_weixin').show();
                       $('.popup_weixin .content').show();
                       $('.popup_weixin .content').css({'margin-top': ($(window).height() - 460) / 2});
                       $('.popup_weixin .close').click(function () {
                           $('#weixin_ifram').remove();
                           $('.popup_weixin').hide();
                       });
                       ajaxCount({"s_status":2,"s_value":details,"s_payment":"WEIXIN","s_type":$("#get_data").val()},'AjaxActiviOrderPay');
                       onloadQueryOrderPAy(details);
                    }
                }


            }
        });
    
}
function ajaxCount(fileJson,faction){
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

//微信请求支付结果
function onloadQueryOrderPAy(details){
        $.ajax({
        url: "/Ucenter/Orders/getOrderPyOid/?order_no=" + $("#order_no").val() + '&t=' + Math.round(Math.random() * 1000000),
        type: "GET",
        success: function (data) {
            var lvContent=""; 
            if (typeof data!="string"){  
                lvContent=data.innerText;  
            }  
            else{  
                lvContent=data;  
            }  
            data  = eval('('+lvContent+')');
            if (data.status == 1) {
                var o_id = $("#order_no").val();
                $('#weixin_ifram').remove();
                $('.popup_weixin').hide();
                clearTimeout(onloadQueryOrderPAy);
                ajaxCount({"s_status":5,"s_value":details,"s_payment":"WEIXIN","s_type":$("#get_data").val()},'AjaxActiviOrderPay');
                var option = {
                    title: "确定",
                    btn: parseInt("0011", 2),
                    onOk: function () {
                        window.location.href = data.url;
                    }
                };
                ajaxLoadShoppingHeader();
                window.wxc.xcConfirm('已支付成功，进入转换界面', window.wxc.xcConfirm.typeEnum.success, option);

            } else {
                if ($(".popup_weixin").is(":hidden"))
                {
                    clearTimeout(onloadQueryOrderPAy);
                } else {
                    setTimeout(function () {
                        onloadQueryOrderPAy(details);
                    }, 3000);
                }

            }
        }
    });
    
}

// 支付宝支付
function generateOrder(details){
                if(details == 1){
                    var pdt_type = 1;
                } else {
                    var pdt_type = 2;
                }
                $.ajax({
                url:"/Ucenter/Financial/ALIPAYPayOnline",
                dataType:"json",
                type:"post",
                async:true,
                data:{
                    'details': pdt_type,
                    'pdt_id':details,
                    'activity':1,
                    'pc_abbreviation':'ALIPAY'
                },
                success:function(data){
                    if(data.action == 1 ){
                        $('#o_id').val(data.data.o_id);
                        var uploadUrl = '/Ucenter/Financial/doALIPAY?code=ALIPAY&o_id='+data.data.o_id+'&details='+pdt_type;//
                        $('.zfb_pay a').attr('href',uploadUrl);
                        $('.popup_actpay').show();
                        $('.popup_actpay .content').show();
                        //newidnow.location = uploadUrl;
//                        $('.popup_actpay').hide();
//                        $('.popup .content').hide();
//                        $('.popup_zfb').show();
//                        $("#pay_Waiting").show();
//                        //$('#be_paid').css('display','inline-block').siblings().hide();
//                        //$('.popup_zfb #be_paid').css({'margin-top':($(window).height()-460)/2});
//                        ajaxCount({"s_status":3,"s_value":details},'AjaxActiviOrderPay');
//                        onloadQueryApplayOrderPAy();
                        
                    } else {
                        if(data.action == 2 && data.activity ==2 ){
                            $('.popup_actpay').hide();
                            $('.popup .content').hide();
                             $('.act_promet').show();
                        }
                    }
                }
            });

}
function onloadQueryApplayOrderPAy(details){
    
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
                    ajaxCount({"s_status":4,"s_value":details,"s_payment":"ALIPAY","s_type":$("#get_data").val()},'AjaxActiviOrderPay');
                    ajaxLoadShoppingHeader();
                    clearTimeout(onloadQueryApplayOrderPAy);

                }else {
                    if($("#pay_Waiting").is(":hidden")) 
                    { 
                        clearTimeout(onloadQueryApplayOrderPAy);
                    } else{
                         setTimeout(function(){onloadQueryApplayOrderPAy(details);}, 3000);
                    }

                }
            }
        });
    
}
function ajaxLoadShoppingHeader (){
     $("#hederGet").remove();
     $("#header_tag_data").remove();
     $.post('/Home/Index/getHeaderData',{},function(htmlObj){
         $("#appendHtml").html(htmlObj);
     },'html');
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


// 验证邮箱格式是否正确
 function checkEmail(str){   
    var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
      if(re.test(str)){
       // console.log('正确');
         return str;
      }else{
          alert("请输入正确的邮箱格式");
      }
  }
    function lookProperty(obj){
	ob=eval(obj);
	var Property="";
	for(var i in ob){
		Property+="属性："+i+"<br/>";
		document.getElementById("myp").innerHTML=Property;
	}
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
function getFileDownload(m_id,id){
       $.ajax({
      type:'post',
      url:'/Home/Index/getFileDownload',
      data:{"m_id":m_id,"id":id},
      dataType:'json',
      async:false,
      success:function(down){

        if(down.action == 1){

          var uploadUrl = '/Home/Index/downloadFile?url='+down.downUrl+'&key='+down.key+'&id='+down.id;
                                     
         location.href = encodeURI(encodeURI(uploadUrl));
          //$("#iframeId").attr('src',encodeURI(encodeURI(uploadUrl)));
         // var djson = [{"fid":fileId,"fileName":fileName,"fsize":fsize,"fdown":1,"cTime":cTime}];
        }
      }   
    });
}
// 清除浮点数

function accSub(arg1,arg2){      
    return accAdd(arg1,-arg2);  
}

function accAdd(arg1,arg2){  
    var r1,r2,m;  
    try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}  
    try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}  
    m=Math.pow(10,Math.max(r1,r2))  
    return (arg1*m+arg2*m)/m  
}


