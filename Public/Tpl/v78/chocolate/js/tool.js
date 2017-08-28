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
        yearsMiddle2:function(){// 年中活动赠送 无折扣
           //$('#ACTIVITY_OPEN').attr('value','1');
            if($('#ACTIVITY_OPEN').val() == ''){
                if($('#pdt_id').val()=="2"){      
                    $('.discount').html('<div class="left">优惠折扣:</div><div class="right">赠送5次转换</div>');
                }else if($('#pdt_id').val()=="5"){
                    $('.discount').html('<div class="left">优惠折扣:</div><div class="right">赠送3个月</div>');
                }else if($('#pdt_id').val()=="6"){
                     $('.discount').html('<div class="left">优惠折扣:</div><div class="right">赠送6个月</div>');
                }else if($('#pdt_id').val()=="3" || $('#pdt_id').val()=="4"){
                    $('.discount').html('');
                }
                
            }else{
                $('.discount').html('');
            }
       
        },
        // 年中活动赠送 并且 到期折扣，活动到期后折扣还原
         yearsMiddle:function(discount){
              //$('#ACTIVITY_OPEN').attr('value','1');
            // actState = $('#ACTIVITY_OPEN').val();
             if($('#ACTIVITY_OPEN').val() == ''){
                if($('#pdt_id').val()=="2"){      
                        $('.discount').html('<div class="left">优惠折扣:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！赠送5次转换</div>');
                    }else if($('#pdt_id').val()=="5"){
                        $('.discount').html('<div class="left">优惠折扣:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！赠送3个月</div>');
                    }else if($('#pdt_id').val()=="6"){
                         $('.discount').html('<div class="left">优惠折扣:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！赠送6个月</div>');
                    }else if($('#pdt_id').val()=="3" || $('#pdt_id').val()=="4"){
                        $('.discount').html('<div class="left">优惠折扣:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！</div>');
                    } 
                    
              }else{
                   $('.discount').html('<div class="left">优惠折扣:</div><div class="right"><strong>'+discount+'折</strong>老用户专享！</div>');
              }
          }
        
 
    };
    
});