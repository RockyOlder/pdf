define(function (){
    
    return {
        ver: '0.0.1',
       /**
        * init 初始化
        */
        init: function () {

            console.log(this.ver)

        },
        /**
         * 验证空
         */
        checkNotEmpty: function checkNotEmpty(data) {
            data = data + "";
            if (data === null || data === undefined || data == "null" || data == "undefined" || data == "") {
                return false;
            } else {
                return true;
            }
        },

        /**
         * 获取cookie中参数
         */
        getQueryCookie: function getQueryCookie(name) {
            var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
            if (arr = document.cookie.match(reg))
                return (arr[2]);
            else
                return null;
        },
        /**
         * 获取当前url中参数
         * @param name
         * @returns {null}
         */
        getQueryString: function getQueryString(name) {
            var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
            var r = window.location.search.substr(1).match(reg);
            if (r != null) {
                return unescape(r[2]);
            }
            return null;
        },
        /**
         * 获取已知 url 中参数
         * @param name 是想获取的参数
         * @param url 已知url
         * @returns 成功则返回参数值,失败则返回  null
         * @description 这个还得再改造
         */
        getQstring: function (url, name) {
            var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
            var r = url.match(reg);
            if (r != null) {
                return unescape(r[2]);
            }
            return null;
        },
        /**
         * @desc 定位标签
         * @param el
         * @param time
         */
        scrollToElement: function (el, extra, time) {
            if (el) {
                var left = el.offsetLeft,
                    top = el.offsetTop;
                while (el = el.offsetParent) {
                    left -= el.offsetLeft;
                    top -= el.offsetTop;
                }
                scrollTo(Math.abs(left), Math.abs(top) + (extra ? extra : 0));
            }
        },

        /**
         * @desc 关闭Ajax请求
         */
        closeAjax:function(ajaxObj){
            if(ajaxObj){
                ajaxObj.abort();
                return true
            }
            return false
        },
        fileAjax:function (fileJson,faction){

                $.ajax({
                        type:'post',
                        url:'/Home/Index/'+faction,
                        data:{"fileInfo":JSON.stringify(fileJson)},
                        dataType:'json',
                        //async:false,
                        success:function(returnlInfo){
                        }		
                });
        },
        setCookie:function (c_name,value,expiredays){

                var exdate=new Date();
                exdate.setDate(exdate.getDate()+expiredays);
                //document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
                //console.debug(exdate);
                document.cookie=c_name+"="+escape(value);
        },
        getCookie:function (c_name){

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
        },
       fileAjaxAsynchronous:function (fileJson,faction){
                $.ajax({
                        type:'post',
                        url:'/Home/Index/'+faction,
                        data:{"fileInfo":JSON.stringify(fileJson)},
                        dataType:'html',
                        success:function(returnlInfo){
                        }		
                });
       },
       WeixinLogin:function (){
                        //微信登录
                $(document).on('click','.login_weixin',function(){    
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
                             $('.popup_weixin .content').css({'margin-top':($(window).height()-460)/2});
                             $('.popup_weixin .close').click(function(){
                                  $('#weixin_ifram').remove();
                                  $('.popup_weixin').hide();
                             });
                           }
                         });
                     return false;
                   });
       },
        ajaxLoadShoppingHeader:function (){
            $("#hederGet").remove();
            $("#header_tag_data").remove();
            $.post('/Home/Index/getHeaderData',{},function(htmlObj){
                $("#appendHtml").html(htmlObj);
//            $("#appendHtml").html(htmlObj).fadeIn('slow').delay(2000).fadeOut(200);
//            if($(document).scrollTop() <300){
//                var timer = setInterval(function () {
//                        $("#appendHtml").removeAttr('style');
//                        clearInterval(timer);
//                }, 3000);
//            }
            },'html');
        },
       ajaxLoadShoppingMember:function (){
            $.post('/Home/Index/SelectGetMember',{},function(data){
                $("#Authorizationtype").val(data.success.conversion_type);
                $("#Free_authorization").val(data.success.Free_authorization);
            },'json');
        },
        brandCommon:function (){
            $('.add_banner .icon-close').click(function(){
               $('.add_banner').remove();
            })
        },
        ShowCountDown:function(){
            var year = document.getElementById("year").value;
            var month = document.getElementById("month").value;
            var day = document.getElementById("day").value;
            var start_time = document.getElementById("start_time").value;
            var halfMonther = document.getElementById("halfMonther").value;
            var reg = new RegExp("-", "g");
            var timeStr = halfMonther.replace(reg, "/");
            var nowtimeStr = start_time.replace(reg, "/");
            var timeStr = new Date(timeStr);
            var nowtimeStr = new Date(nowtimeStr);
            console.log(timeStr);
            console.log(nowtimeStr);

            var end_time = timeStr.getTime(), //月份是实际月份-1
            sys_second = (end_time - nowtimeStr.getTime()) / 1000;
          
            var timer = setInterval(function() {
                if (sys_second > 0) {
                            sys_second -= 1;
                    var day1=Math.floor(sys_second/(60*60*24)); 
                    var hour=Math.floor((sys_second-day1*24*60*60)/3600); 
                if(hour<10){
                    hour = "0"+hour;
                } 
                    var minute=Math.floor((sys_second-day1*24*60*60-hour*3600)/60);
                if(minute<10){
                    minute = "0"+minute;
                }  
                    var second = Math.floor(sys_second-day1*24*60*60-hour*3600-minute*60);
                if(second<10){
                    second = "0"+second;
                } 
                $('.count_down .end_date').html(month+"."+day);
                if(day1>0){
                    $('.count_down .day').html(day1+'天');
                }
                $('.count_down .time').html(hour+":"+minute+":"+second);

                } else {
                        if($('#ACTIVITY_OPEN').val() == ''){
                             location.reload();
                         }
                        clearInterval(timer);
                        $('.activity_banner,.item_banner,.activity_con').html('').hide();
                        $('.add_banner').show();
                }
            }, 1000);
        },
        ActivityStatistics:function (){
             $(document).on('click','.linkbox',function(){    
                $.ajax({
                        type:'post',
                        url:'/Home/Index/ActivitCount',
                        dataType:'html',
                        success:function(returnlInfo){
                        }		
                });
             });
        },
        BehaviorStatisticsBanner:function (){
             $(document).on('click','.Behavior_Statistics_Banner',function(){    
                $.ajax({
                        type:'post',
                        url:'/Home/Index/ActivitCount',
                        dataType:'html',
                        success:function(returnlInfo){
                        }		
                });
             });
        },
        ClickTheBanner:function (){
             $(document).on('click','.ClickTheBanner',function(){    
                $.ajax({
                        type:'post',
                        url:'/Home/Index/ActivitLoadDataTypeAdd',
                        dataType:'html',
                        data:{"fileInfo":JSON.stringify({"s_status": $(this).attr('itemtype'),"s_type":$(this).attr('itemid')})},
                        success:function(returnlInfo){
                            console.log(returnlInfo)
                        }		
                });
             });
        },
        yearsMiddle2:function(){// 年中活动赠送 无折扣
           //$('#ACTIVITY_OPEN').attr('value','1');
            if($('#ACTIVITY_OPEN').val() == ''){
                if($('#pdt_id').val()=="2"){      
                    $('.discount').html('<div class="left">限期优惠:</div><div class="right">赠送5次转换</div>');
                }else if($('#pdt_id').val()=="5"){
                    $('.discount').html('<div class="left">限期优惠:</div><div class="right">赠送3个月</div>');
                }else if($('#pdt_id').val()=="6"){
                     $('.discount').html('<div class="left">限期优惠:</div><div class="right">赠送6个月</div>');
                }else if($('#pdt_id').val()=="3" || $('#pdt_id').val()=="4"){
                    $('.discount').html('');
                }
                
            }else{
                $('.discount').html('');
            }
           
        },
        // 活动赠送并且到期折扣，活动到期后折扣还原
         yearsMiddle:function(discount){
              //$('#ACTIVITY_OPEN').attr('value','1');
            // actState = $('#ACTIVITY_OPEN').val();
             if($('#ACTIVITY_OPEN').val() == ''){
                if($('#pdt_id').val()=="2"){      
                        $('.discount').html('<div class="left">限期优惠:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！赠送5次转换</div>');
                    }else if($('#pdt_id').val()=="5"){
                        $('.discount').html('<div class="left">限期优惠:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！赠送3个月</div>');
                    }else if($('#pdt_id').val()=="6"){
                         $('.discount').html('<div class="left">限期优惠:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！赠送6个月</div>');
                    }else if($('#pdt_id').val()=="3" || $('#pdt_id').val()=="4"){
                        $('.discount').html('<div class="left">限期优惠:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！</div>');
                    } 
                    
              }else{
                   $('.discount').html('<div class="left">限期优惠:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！</div>');
              }

              
          },
          fixedBox:function(_this,setting){
		var opts = $.extend({
			id:'',
			zIndex:'',
			setEvent:'auto',//auto||scroll 两种类型，auto是页面载入以后就执行素锁定事件，scroll是根据boxTop的距离来执行元素锁定事件
			parentObj : '.fixedBox',//设定了被锁定元素的框架，防止运行以后产生空缺位置后位移
			left:'auto',//被锁定元素距上一级相对定位元素的左边距
			right:'auto',//被锁定元素距上一级相对定位元素的右边距
			bottom:'auto',//被锁定元素距离浏览器窗口的底部距离
			top: 'auto',//被锁定元素块距离浏览器窗口的顶部距离
			boxT:''//滚动条滚动多少，来出发锁定元素事件（滚动条滚动多少以后这个块就被锁定）
		},setting);
		//获取要锁定Box的位置
		var boxT = _this.offset().top; 
		var boxL = _this.offset().left;
		var boxH = _this.height(); 
		var boxW =_this.width(); 
		var winH = $(window).height();
		var winW = $(window).width();
		//判断浏览器的版本
		window.sys = {};//保存浏览器信息，让外部可以使用
		var ua = navigator.userAgent.toLowerCase(); //获取浏览器的版本信息
		var s;
		(s = ua.match(/msie ([\d.]+)/)) ? sys.ie = s[1]:
		(s = ua.match(/firefox\/([\d.]+)/)) ? sys.firefox = s[1]:
		(s = ua.match(/chrome\/([\d.]+)/)) ? sys.chrome = s[1]:
		(s = ua.match(/opera\/.*version\/([\d.]+)/)) ?sys.opera = s[1]:
		(s = ua.match(/version\/([\d.]+).*safari/)) ? sys.safari = s[1]:0;
		//_this.css({'width':boxW,'height':boxH});
		_this.parent(opts.parentObj).css({'height':boxH,'width':boxW});
			if(sys.ie=='6.0'){
				$('html').css({'backgroundImage':'url(about:blank)','backgroundAttachment':'fixed'});
				var ie6class= 'ie6Fixed_'+opts.id;
				var ie6style = '<style type="text/css">.'+ie6class+'{position:absolute;';
				if(opts.setEvent=='scroll'){
					if(Number(opts.top)||opts.top==0){
						ie6style+='top:expression(eval(document.documentElement.scrollTop+'+opts.top+'));}</style>;';	
						}else {
						ie6style+='top:expression(eval(document.documentElement.scrollTop+'+0+'));}</style>;';	
					}
					$(ie6style).appendTo('head');
					wheelIe6(ie6class);
					$(window).scroll(function(){wheelIe6(ie6class)});
				}else if(opts.setEvent=='auto') {
					autorunIe6(ie6style);
				}
			}else {	 
				if(opts.setEvent=='scroll'){
					if(Number(opts.top)||opts.top==0) {
						var ctop = opts.top;
						//_this.css({'top':ctop});
						$(window).scroll(function(){wheel(ctop);});	
					}else{
						//var ctop=boxT
						//_this.css({'top':ctop});
						$(window).scroll(function(){wheel(0);});
					}
				}else if(opts.setEvent=='auto') {
                                  
					autorun();
					$(window).resize(function(){autorun();})
				}
			};	
			
		function autorun(){
			var halfW = ($(window).width()-_this.width())/2;
			var halfH = ($(window).height()-_this.height())/2;
			_this.css({'position':'fixed','top':opts.top,'left':opts.left,'bottom':opts.bottom,'right':opts.right});	
			if((opts.left!='auto')&&opts.right!='center'){if(Number(opts.left)||opts.left==0){_this.css({'left':opts.left});};};
			if((opts.right!='auto')&&opts.right!='center'){if(Number(opts.right)||opts.right==0){_this.css({'right':opts.right});};};
			if((opts.top!='auto')&&opts.top!='center'){if(Number(opts.top)||opts.top==0){_this.css({'top':opts.top});};};
			if((opts.bottom!='auto')&&opts.bottom!='center'){if(Number(opts.bottom)||opts.bottom==0){_this.css({'bottom':opts.bottom});};};
			if(opts.top=='center'||opts.bottom=='center'){_this.css({'top':halfH});};
			if(opts.left=='center'||opts.right=='center'){_this.css({'left':halfW});};
			};
		function autorunIe6(ie6style){
				if(opts.top=='auto'){
					ie6style+=topChk();//对top值进行判断
					ie6style+=leftChk();//对left值进行判断
				}else if(opts.top=='center'){
					ie6style+= 'top:expression(eval(document.documentElement.scrollTop+(document.documentElement.clientHeight-this.offsetHeight)/2-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));';	
					ie6style+=leftChk();
				}else if(Number(opts.top)||Number(opts.top)==0) {
					ie6style+='top:expression(eval(document.documentElement.scrollTop+'+opts.top+'));';
					ie6style+=leftChk();
				}else {alert("top/bottom只能一个为auto属性并且其中有一个为数值或者center");return false;};
					$(ie6style).appendTo('head');
					_this.addClass(ie6class);
		}	
		function topChk() {
			if(Number(opts.bottom)||Number(opts.bottom)==0){
				return'top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,'+(10+Number(opts.bottom))+')||0)));'
			}else if (opts.bottom=='center') {
				return 'top:expression(eval(document.documentElement.scrollTop+(document.documentElement.clientHeight-this.offsetHeight)/2-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));'
			}else{alert("top/bottom只能一个为auto属性,并且其中有一个为数值或center");return false;}
		}
		function leftChk(){
			if(opts.left=='auto'){
				if(Number(opts.right)||Number(opts.right)==0) {
					return 'left:expression(eval(document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt(this.currentStyle.marginRight,'+(10+Number(opts.right))+')||0));}</style>';
				}else if(opts.right=='center') {
					return 'left:expression(eval((document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt(this.currentStyle.marginRight,10)||0))/2);}</style>';
				}else if(opts.right=='auto'){
					return 'left:auto</style>';
			}else{alert("left/right值为非法字符！");return false;}
			}else if(Number(opts.left)||Number(opts.left)==0){
				return ie6style1='left:'+Number(opts.left)+'));}</style>';
			}else if(opts.left=='center'){
				return'left:expression(eval((document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt(this.currentStyle.marginRight,10)||0))/2);}</style>';
			}else{alert("left/right值为非法字符"); return false;}	
		}	
		function wheel(ctop){
			var ctop = ctop;
			if(Number(opts.boxT)){	
				wheelAdd(Number(opts.boxT),ctop);
			}else{
				wheelAdd(boxT,ctop);
			}	
		}
		function wheelAdd(value,ctop){
                    var halfW = ($(window).width()-_this.width())/5;
			if( $(this).scrollTop()>value){
				if(_this.css('position')!='fixed'){
				_this.css({'position':'fixed',right:halfW,'top':ctop});//,'display':'block'
				}
			}else{
				//if(_this.css('position')!='absolute'){
				_this.removeAttr('style');
				//}
			};
		}		
		function wheelIe6(ie6class){
			if(!Number(opts.boxT)){	
				wheelIe6Addclass(boxT);
			}else{
				wheelIe6Addclass(Number(opts.boxT));
			}	
		}
		function wheelIe6Addclass(value){
			if (($(this).scrollTop()>=value)){
					if(!_this.hasClass(ie6class)){
						_this.addClass(ie6class);
					}else {
						_this.addClass(ie6class);
					}
				}else {
					_this.removeClass(ie6class);
			}
		}
	},
        rsdConfirm:function(itype, options,obj) {
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
            var clsBtns =  $(".popup_other .close");//关闭按钮
            var recharge =  $(".btn_recharge");//立即充值按钮
            //建立按钮映射关系
//            var btns = {
//			ok: ok,
//			recharge: recharge
//            };
            inits();
           function inits (){
               SendConversionConfirms(itype);
               binds();
               btn_recharges();
               clsBtns.unbind('click').click(doCancels);

	}
           //属性赋值
           function SendConversionConfirms(itype){
                $('.popup_other').show().siblings('.popup').hide();
                 $('.popup_other .content[name="'+itype+'"]').css('display','inline-block');
                 $('.popup_other .content[name="'+itype+'"]').css('margin-top',($(window).height()-$('.popup_other .content[name="'+itype+'"]').height())/2);
           }
            function doOks(){
                      config.onOk();
                      
                        //点击关闭按钮
                        doCancels();
            }
            function Cancel(){
                    //config.onCancel();
                    //点击关闭按钮
                    doCancels();
            }
            function binds(){
                ok.unbind('click').click(function () {
                     doOks();
                });
                //回车键触发确认按钮事件
                $(window).bind("keydown", function(e){
                        if(e.keyCode == 13) {
                            doOks();
                        }
                });
            }
		//取消按钮事件
		function doCancels(){
               
                       if (typeof($(this).attr('itemid')) !== "undefined")  
                        {  
                              obj.fileAjax({"s_status": 99,"s_type":$(this).attr('itemid')},'ActivitLoadDataTypeAdd');
                        }  
                        $('.popup').hide();
                        $(this).parent().hide();
                        $('.popup_other .content[name="'+itype+'"]').hide();
			 //config.onCancel();
			//clsBtn.hide(); 
		}
                function recharge_one(){
                        Cancel();
                }
                //默认url 
                function btn_recharges(){
                     recharge.attr('href',config.url);
                }
       }
    };
    
});