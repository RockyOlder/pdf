        require.config( {

      //  baseUrl: '/area/js',           //依赖相对路径
        paths: {                    //如果某个前缀的依赖不是按照baseUrl拼接这么简单，就需要在这里指出
              conversion: 'conversion/conversion',
              wxLogin:'http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin'

        }

    });
require(['jquery','conversion','jquery.ui.widget','jquery.iframe-transport','jquery.fileupload','remindSendConfirm','xcConfirm','tool','wxLogin'], function($,conversion,widget,transport,fileupload,remindSendConfirm,xcConfirm,tool,wxLogin) {
    'use strict';
    if($('#email').val() !==''){
           $('.email_div').show();
       }
//    if(tool.checkNotEmpty($("#gy_member_open").val()) == true){
//        tool.fixedBox($("#appendHtml"),{'setEvent':'scroll','id':2,'left':0,boxT:$(".main_header").offset().top,top:0,zIndex:9});
//    }
    if(tool.checkNotEmpty($("#LoadDataType").val()) == false && tool.checkNotEmpty($("#gy_member_open").val()) == true && $("#Authorizationtype").val() == 0){
            tool.rsdConfirm('teachesDay',null,tool);
    }
    var $list = $(".list");
    // Change this to the location of your server-side upload handler:
    var url = '/Home/Index/upload';
    //if($('.choose_file >.label').hasClass('checked')){}
    $('#fileupload').fileupload({
       //maxChunkSize : 5242881,
        url: url,
        sequentialUploads:true,
        acceptFileTypes:'/(.|\/)(doc|docx|xls|xlsx|ppt|pptx|pdf)$/i',//'doc,docx,xls,xlsx,ppt,pptx,pdf',
        // acceptFileTypes: /(.|\/)(jpe?g|png)$/i,//文件格式限制
        autoUpload:false,
        done: function (e, data) {

            var lvContent="";  
            if (typeof data.result!="string"){  
                lvContent=data.result[0].body.innerText;  
            }  
            else{  
                lvContent=data.result;  
            }  
            data  = eval('('+lvContent+')');

            //   $(".upload").show();
           if(data.files.state == 1){
                tool.fileAjax(data.files,'upload_name_save');
           }else if(data.files.state == 9){
                    window.wxc.xcConfirm(data.files.error_msg, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
           }else if(data.files.state == 0){
                    window.wxc.xcConfirm(data.files.error_msg, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
           }else if(data.files.state == 8 || data.files.state == 5 || data.files.state == 4 ){
                    tool.fileAjax(data.files,'upload_cype_save');
                   
           }
            $(".upload").show();
           conversion.listHtml(data.files,data.files.state);
           
//                var file = data.result.files;
//                var stampCookie = getCookie('timestamp');
//                var jsonInfo = [{"fileName":file.name,"fileType":'PDF',"fileSize":file.size,"fileState":file.formatState,"fileTime":file.fileTime,"postfix":file.fileTime,"cName":file.fName,"timestamp":stampCookie,"suffix":file.suffix}];
//                startTransition(jsonInfo);
//                fileAjax(jsonInfo,'upload_name_save');
////                 $.each(data.result.files, function (index, file) {
////                     $('<p/>').text(file.name).appendTo('#files');
////                 });
//            }

        },
          add: function (e, data) {
                //alert($(".table tbody tr").length)
                //console.log(data.originalFiles.length);return false;
                    // for ( i in data.originalFiles[0]) {console.log(i)}
          //  console.log(getTypeUpload(data.originalFiles[0].name.substr(data.originalFiles[0].name.lastIndexOf("."))));
                    if((data.files.length + $(".table tbody tr").length) > 10){
                var txt =  '您上传的文档超过数量（10个），请清理列表后，再重新上传';
                window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
            }
                var file_type = 1;
                var boolStart  = false;
                //     console.log('`````````````````````````````')
            if($('#gy_member_open').val() == ''){
                var option = {
                    title: "提示",
                    btn: parseInt("0011",2),
                    onOk: function(){
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
                    }
                }
                window.wxc.xcConfirm('您需要登录后才可以进行文档转换', window.wxc.xcConfirm.typeEnum.warning,option);
                return false;
            }
            if(!$('.choose_file .label').hasClass('checked')){
		window.wxc.xcConfirm('需要勾选才能转换', window.wxc.xcConfirm.typeEnum.warning,option);
                return false;
           } 
             $.each(data.files, function (index, file) {
                 var ext = file.name.substr((file.name.lastIndexOf(".")));
                 if(conversion.getTypeUpload(ext.toLowerCase()) == 0 ||  file.type == '' ){
                    if(conversion.getTypeUpload(ext.toLowerCase()) ==0 ){
                                    window.wxc.xcConfirm('上传的文件格式不正确，请重新上传', window.wxc.xcConfirm.typeEnum.warning);
                                    return false;
                    }
                 }
                 if(file.size > 20971520){
                       file_type  =  2;
                       conversion.listHtmlFind(file,5,file_type,1)
                        file.ext = file.name.substr(file.name.lastIndexOf("."));
                       var cjson = {"fileName":file.name,"fsize":file.size,"cstate":0,"type":file.ext};
                        tool.fileAjax(cjson,'bigupload');
                               return false;
                } else {
//                        if($("#Authorizationtype").val() == 0){
//                            if(file.size > 5242880){
//                                file_type  =  2;
//                                conversion.listHtmlFind(file,6,file_type,0);
//                                 return false;
//                            } else {
//                                 conversion.listHtmlFind(file,14);
//                            }
//                        } else {
//                             conversion.listHtmlFind(file,14);
//                        }
                         conversion.listHtmlFind(file,14);
                              
                }
           //     console.log(file.name.substr(file.name.lastIndexOf(".")))
            });
            if(file_type  !==2){
                 data.submit();
            }
        },
        drop: function(e, data) {
                if((data.files.length + $(".table tbody tr").length) > 10){
                                var txt =  '您上传的文档超过数量（10个），请清理列表后，再重新上传';
				window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }
        },
        progress: function (e, data) {
            //progressall
                  //      console.log('`````````````````````````````')
          //    console.log(e)
            var progress = parseInt(data.loaded / data.total * 100, 10);
         //console.log(progress)
//            if ($("#progress .progress-bar").css("display") == "none")  
//            {
//                $('#progress .progress-bar').css('display','block');
//            }
         //   console.log($('.progress_bar').eq(0).prev().html())
         
         $(".table tbody tr").each(function(){
             
             if(data.files[0].name  == $(this).find('td').eq(1).children('div').find('h3').html()){
                 $(this).find('td').eq(1).find('.progress_bar').css('width',progress + '%');
             }
                if(progress == 100){
                       if(data.files[0].name  == $(this).find('td').eq(1).children('div').find('h3').html()){
                           $(this).find('td').eq(1).find('.progress_bar').hide(100);
                       }
                }
             
         })
            
        }
    }).prop('disabled', !$.support.fileInput)

    tool.ActivityStatistics();
    tool.BehaviorStatisticsBanner();
    tool.WeixinLogin();
    tool.brandCommon();
    tool.ClickTheBanner();
    conversion.init();
    tool.ShowCountDown();
});