require(['jquery'], function($) {
       window.rsd = window.rsd || {};
       window.rsd.rsdConfirm = function(itype, options) {
            var config = $.extend(true, {
                    //属性
                    url:"/Home/Products/ConversionFeeDetail", //自定义的url
                    title:0,
                    //事件
                    onOk: $.noop,//点击确定的按钮回调
                    onCancel: $.noop,//点击充值的按钮回调
                 //   onClose: $.noop//弹窗关闭的回调,返回触发事件
            }, itype, options);
            var ok = $(".btn_only_change");//确定按钮
            var clsBtn =  $(".popup_other .close");//关闭按钮
            var recharge =  $(".btn_recharge");//立即充值按钮
            //建立按钮映射关系
//            var btns = {
//			ok: ok,
//			recharge: recharge
//            };
            init();
           function init (){
               SendConversionConfirm(itype);
               bind();
        
                btn_recharge();
               clsBtn.click(doCancel);

           }
           //属性赋值
           function SendConversionConfirm(itype){
                $('.popup_other').show().siblings('.popup').hide();
                 $('.popup_other .content[name="'+itype+'"]').css('display','inline-block');
                 $('.popup_other .content[name="'+itype+'"]').css('margin-top',($(window).height()-$('.popup_other .content[name="'+itype+'"]').height())/2);
           }
            function doOk(){
                      config.onOk();
                      
                        //点击关闭按钮
                        doCancel();
            }
            function Cancel(){
                    config.onCancel();
                    //点击关闭按钮
                    doCancel();
            }
            function bind(){
                ok.unbind('click').click(function () {
                     doOk();
                });
                       
                //回车键触发确认按钮事件
                $(window).bind("keydown", function(e){
                        if(e.keyCode == 13) {
                            doOk();
                        }
                });
			//点击取消按钮
			//clsBtn.click(doCancel);

            }
		//取消按钮事件
		function doCancel(){

			var $o = $(this);
                         $('.popup').hide();
                         $o.parent().hide();
                         $('.popup_other .content[name="'+itype+'"]').hide();
			 //config.onCancel();
			//clsBtn.hide(); 
		}
                function recharge_one(){
                        Cancel();
                }
                //默认url 
                function btn_recharge(){
                     recharge.attr('href',config.url);
                }
       };
});
