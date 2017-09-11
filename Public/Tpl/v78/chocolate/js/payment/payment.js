define(['tool'], function(tool){
  return payment = {
      /**
       * 
       * @returns 初始化
       */
        _this_number_Permission_PaymentSerialCount:document.getElementById("PaymentSerialCount").value,
        _this_number_value:3,
        init: function () {
                // 事件绑定
              this.PayTreasure();
              this.doCancel('content_payment');

              if(this._this_number_Permission_PaymentSerialCount > this._this_number_value){
                  this.parymentZfbComfim();
                  this.parymentWXComfim();
              } else {
                  
                    this.generateOrder();
                    this.WenxinPay();
              }
        },
        PayTreasure:function (){
            
                $('.pay_zfb').click(function(){       
                    var uploadUrl = '/Ucenter/Financial/doALIPAY?code=ALIPAY&o_id='+$("#o_id").val()+'&details='+parseInt($('#details').val());//
                    window.open(uploadUrl)
                    $("#be_paid").hide();
                    $("#pay_Waiting").css('display','inline-block').siblings().hide();
                      payment.onloadQueryApplayOrderPAy();
                 })
            
        },
        onloadQueryApplayOrderPAy:function (){
            
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
                            //您的授权剩余次数<span id="total_number">2</span>次，剩余时间还剩<span id="total_time">12</span>天
                            if(data.order.conversion_type == 1){
                                $('#permissions').html('您的授权剩余次数<span>'+data.order.number_remaining+'</span>次');
                            }else if(data.order.conversion_type == 2 && data.order.number_remaining != 0){
                                $('#permissions').html('您的授权剩余次数<span>'+data.order.number_remaining+'</span>次,剩余时间还剩<span>'+data.order.end_time+'</span>天');
                            } else {
                                $('#permissions').html('您的授权剩余时间还剩<span>'+data.order.end_time+'</span>天');
                            }
//                            $("#total_number").html(data.order.number_remaining);
//                            $("#total_time").html(data.order.end_time);
                            tool.ajaxLoadShoppingHeader();
                            clearTimeout(payment.onloadQueryApplayOrderPAy);

                        }else {
                            if($("#pay_Waiting").is(":hidden")) 
                            { 
                                clearTimeout(payment.onloadQueryApplayOrderPAy);
                            } else{
                                 setTimeout(function(){payment.onloadQueryApplayOrderPAy()}, 3000);
                            }

                        }
                    }
                });
            
        },
        sendWXorder:function (){
            var pdt_id = $('#pdt_id').val();
            var details = parseInt($('#details').val());
            var pdt_stock = parseInt($('#pdt_stock').val());
            var pdt_sn = $('#pdt_sn').val();
            var pdt_sale_price = $('#pdt_sale_price').val();
            $("#pc_abbreviation").val('WEIXIN')
            if (isNaN(details)) {
                $.ThinkBox.error('异常错误');
                return;
            }
            if (pdt_sn == '') {
                $.ThinkBox.error('SKU编码不能为空');
                return;
            }
            if (isNaN(pdt_sale_price)) {
                $.ThinkBox.error('价格不能为空');
                return;
            }
            if (pdt_id == '') {
                $.ThinkBox.error('异常错误:pdt为空');
                return;
            }
            if (pdt_stock < 1) {
                $.ThinkBox.error('数量不能小于一');
                return;
            }
            var data = $('#submitSkipFrom').serialize();
            // data += '&pc_abbreviation=ALIPAY';
            var url = '/Ucenter/Financial/doAddDepositOnline';
            /**************************************************/
            $.ajax({
                url: url,
                dataType: "html",
                type: "post",
                //   async:false,
                data: {
                    'details': details,
                    'pdt_stock': pdt_stock,
                    'pdt_id': pdt_id,
                    'pdt_sn': pdt_sn,
                    'pdt_sale_price': pdt_sale_price,
                    'pc_abbreviation': 'WEIXIN'
                },
                success: function (htm) {
                     var PaymentSerialCount = $('#PaymentSerialCount').val();
                    // console.log(PaymentSerialCount);
                     if(PaymentSerialCount!==1){
                        $('.popup_content').html(htm);
                        $('.popup_weixin').show();
                        $('.popup_weixin .content').show();
                        $('.popup_weixin .content').css({'margin-top': ($(window).height() - 460) / 2});
                        $('.popup_weixin .close').click(function () {
                            $('#weixin_ifram').remove();
                            $('.popup_weixin').hide();
                        });
                        payment.onloadQueryOrderPAy();
                        
                     }
                    
                }
            });
        },
        sendZfbOrder:function (){
            
                var pdt_id = $('#pdt_id').val();
                var details = parseInt($('#details').val());
                var pdt_stock = parseInt($('#pdt_stock').val());
                var pdt_sn = $('#pdt_sn').val();
                var pdt_sale_price = $('#pdt_sale_price').val();
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
                    $('#pc_abbreviation').val('ALIPAY');
            $.ajax({
                url:"/Ucenter/Financial/ALIPAYPayOnline",
                dataType:"json",
                type:"post",
            //    async:false,
                data:{
                    'details': details,
                    'pdt_stock':pdt_stock,
                    'pdt_id':pdt_id,
                    'pdt_sn':pdt_sn,
                    'pdt_sale_price':pdt_sale_price,
                    'pc_abbreviation':'ALIPAY'
                },
                success:function(data){
                    var PaymentSerialCount = $('#PaymentSerialCount').val();
                    //console.log(PaymentSerialCount)
                    if(data.action == 1 && PaymentSerialCount !==1){
                        $('.popup_zfb').show();
                        $('#be_paid').css('display','inline-block').siblings().hide();
                        $('.popup_zfb #be_paid').css({'margin-top':($(window).height()-460)/2});
                        $('#o_id_orders').html(data.data.o_id);
                        $('#o_id').val(data.data.o_id);
                        $('#zfb_sale_price').html(data.data.pdt_sale_price);//套餐原价
                        $('#pay_order_price').html(data.data.o_all_price);//现价格
                        $("#preferential_price").html(data.data.pdt_sale_price - data.data.o_all_price);//套餐省

                        
                    }
                }
            });
            
        },
        parymentWXComfim:function (){
            $('.weixin_pay').bind("click", function(e){
                 if($("#pdt_id_number").val() == 1){
                            if($('#details').val()  == 2){
                                payment.sendWXorder();

                            } else {
                                    payment.SendConversionConfirm('content_payment');
                                    $('.btn_recharge').attr('onclick','payment.WX_recharge()');
                                    $('.btn_only_change').attr('onclick','payment.sendWXorder()');
                                    $(".btn_only_change").one("click",function(){  
                                         payment.doCancelHide("content_payment");
                                    });
                                }
                 } else {
                      payment.sendWXorder();
                 }

            });
                                },
        SendConversionConfirm:function(itype){
               $('.popup_other').show().siblings('.popup').hide();
                $('.popup_other .content[name="'+itype+'"]').css('display','inline-block');
                $('.popup_other .content[name="'+itype+'"]').css('margin-top',($(window).height()-$('.popup_other .content[name="'+itype+'"]').height())/2);
          },
       doCancel:function(itype){
            $('.popup .close').unbind('click').click(function () {
                $('#open_box').hide();
                $(this).parent().hide();
                $('.popup_other .content[name="'+itype+'"]').hide();
           })
                 
                   //clsBtn.hide(); 
       },
        doCancelHide:function(itype){
                   var $o = $(this);
                    $('#open_box').hide();
                    $o.parent().hide();
                    $('.popup_other .content[name="'+itype+'"]').hide();
                   //clsBtn.hide(); 
       },
       btn_recharge:function(){
           $('#pdt_id').val(2);
           $('#details').val(2);
           $('#pc_abbreviation').val('ALIPAY');
           $('#pdt_sn').val('pdf_002');
           $('.item[data-pdt_sn="pdf_001"]').removeClass('current');
           $('.item[data-pdt_sn="pdf_002"]').addClass('current');
            this.doCancelHide("content_payment");
            this.sendZfbOrder();
            MonthlyRecommendation()
           
       },
       WX_recharge:function(){
           $('#pdt_id').val(2);
           $('#details').val(2);
           $('#pc_abbreviation').val('WEIXIN');
           $('#pdt_sn').val('pdf_002');
           $('.item[data-pdt_sn="pdf_001"]').removeClass('current');
           $('.item[data-pdt_sn="pdf_002"]').addClass('current');
            this.doCancelHide("content_payment");
            this.sendWXorder();
            MonthlyRecommendation();
           
        },
        parymentZfbComfim:function (){                  
                   $('.zfb_pay').bind("click", function(){
                      if($("#pdt_id_number").val() == 1){
                                if($('#details').val()  == 2){
                                    payment.sendZfbOrder();
                                } else {
                                    payment.SendConversionConfirm('content_payment');
                                    $('.btn_recharge').attr('onclick','payment.btn_recharge()');
                                    $('.btn_only_change').attr('onclick','payment.sendZfbOrder()');
                                    $(".btn_only_change").one("click",function(){  
                                         payment.doCancelHide("content_payment");
                                    });
                                }
                      } else {
                          payment.sendZfbOrder();
                      }

                });
            
        },
        generateOrder:function (){
                $('.zfb_pay').click(function(){         
                       payment.sendZfbOrder();
               });
            
        },
        WenxinPay:function (){
                $('.weixin_pay').click(function () {
                    payment.sendWXorder();
                });
        },
        onloadQueryOrderPAy:function(){
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
                        $('#weixin_ifram').remove();
                        $('.popup_weixin').hide();
                        clearTimeout(payment.onloadQueryOrderPAy);
                        var option = {
                            title: "确定",
                            btn: parseInt("0011", 2),
                            onOk: function () {
                                window.location.href = data.url;

                            }
                        };
                        tool.ajaxLoadShoppingHeader();
                        window.wxc.xcConfirm('已支付成功，进入转换界面', window.wxc.xcConfirm.typeEnum.success, option);
                        location.reload();

                    } else {
                        if ($(".popup_weixin").is(":hidden"))
                        {
                            clearTimeout(payment.onloadQueryOrderPAy);
                        } else {
                            setTimeout(function () {
                                payment.onloadQueryOrderPAy()
                            }, 3000);
                        }

                    }
                }
            });
        }
  };
});


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
        var actState = $("#actState").val();
        if(actState == 0){
            $('.discount').html('');
        }else if(actState == 1){
            $('.discount').html('<div class="left">优惠折扣:</div><div class="right">赠送5次转换</div>');
        }
        
    }
}