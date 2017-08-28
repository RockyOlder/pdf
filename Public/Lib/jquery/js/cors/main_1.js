require(['jquery'], function($,main) {
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
            // 单选
     $(document).on('click','.upload_file .label',function(){
                if($(this).hasClass('checked')){
                   $(this).removeClass('checked');
                }else{
                   $(this).addClass('checked');
                }
//         if($(this).find('i').attr('file-state') == 'successful'){
//
//         }

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
   
     
     $(document).on('click','.secondary li',function(e){
        e.stopPropagation();
        var txt = $(this).text();
        $(this).parent().siblings('.info').text(txt);
        $(this).parent().hide();

    })
    $(document).on('click','.drop',function(e){
        e.stopPropagation();
        if($(this).not('.rmoveData').find(".secondary").is(":hidden")){
            $(this).find(".secondary").show();
          
           /// $(this).parents("tr").siblings('tr').find('.secondary').hide();
        }else{
            $(this).find(".secondary").hide();
        
        } 
    })

    $(document).click(function(){
        $('.secondary').hide();
    })
})
$(function(){
	 $('.choose_file_box .label').click(function() {
         if($(this).hasClass('checked')){
            $(this).removeClass('checked');
            $(this).siblings('.email_div').hide();
            $(this).parent().find('.btn_file').css({'background':'#d2d2d2','color':'#fff','cursor':'not-allowed'}).find('.bubble_promet').show().siblings('#fileupload').hide(); 
              if($('#Authorizationtype').val() !==""){
                  $('.bubble_promet').hide();
              }            
         }else{
            $(this).addClass('checked');
            $(this).siblings('.email_div').show();
            if($('#Authorizationtype').val() !==""){
                $(this).parent().find('.btn_file').removeAttr('style').find('.bubble_promet').hide().siblings('#fileupload').show();
            }
            
         }
     });

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
    // 全选

    $('.file_operation .all_choose').click(function(){
      var labelLength = $(".upload_file .label").length;
      var checkedLength = $(".upload_file .checked").length;
      if(labelLength==checkedLength){
          $(".upload_file .label").removeClass('checked');
      }else{
          $(".upload_file .label").addClass('checked');
      }
         // if($(".upload_file .label").hasClass('checked')){
         //    $(".upload_file .label").removeClass('checked');
         // }else{
         //    $(".upload_file .label").addClass('checked');
         // }
    })
//反选
    $('.in_turn').click(function(){
        for (var i = 0; i < $(".upload_file .label").length; i++) {
            if($(".upload_file .label").eq(i).hasClass('checked')){
                $(".upload_file .label").eq(i).removeClass('checked');
            }else{
                $(".upload_file .label").eq(i).addClass('checked');
            }
        };
         
    })
    //批量删除 
//    $('.batch_delete').click(function(){
//         if($(".upload_file .checked").length>0) {
//             $(this).parent().siblings('.table').find(".checked").parents("tr").remove();
//         }else{
//            alert('您至少选择一个')
//         }       
//       
//    })

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
        //console.log(typeof(dataNow));
        $('.pay').html('<span class="pay_money">'+dataNow+'</span>元<span class="first_price">原价&yen;'+dataFisrt+'</span><span class="save_money">省'+(dataFisrt-dataNow)+'元</span>');
    })
//递增
    var amount = $('.section_one .amount').val();
   $('.add_numberof').click(function(){
        amount++;
        if(amount > 1000){
            amount = 1000;
        }
        $('#pdt_id').val(1);
        $('.section_one .amount').val(amount);
        $('.pay').html('<span class="pay_money">'+(2*amount)+'</span>元')
        
   })

//递减
   $('.reduce_numberof').click(function(){
       
        if(amount>1){
            amount--;
            $('.section_one .amount').val(amount);
            $('#pdt_stock').val(amount);
            $('#pdt_id').val(1);
            $('.pay').html('<span class="pay_money">'+(2*amount)+'</span>元')
        }else if(amount==""){
            amount=1;
        }
        
   })

   // 点击加减回到次数

   $('.upor_down').click(function(){
      $(this).parent().siblings('.item').addClass('current').parents(".section").siblings().find('.item').removeClass('current');
      $('#pdt_stock').val(amount);
      $('#details').val($(this).parent().siblings('.item').data('details'));
      $('.pay').html('<span class="pay_money">'+(2*amount)+'</span>元');
   });

// 点击次数
   $('#times').click(function(){
       amount = $('.section_one .amount').val();
        $('#pdt_stock').val(amount);
        $('#details').val($(this).data('details'));
        $('#pdt_id').val($(this).data('pdt_id'));
       $(this).addClass('current').parents(".section").siblings().find('.item').removeClass('current');
     
       $('.pay').html('<span class="pay_money">'+(2*amount)+'</span>元');
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
        $('.pay').html('<span class="pay_money">'+(2*amount)+'</span>元');
        //
        if(amount==""){
            $('.section_one .amount').val(1);
            $('.pay').html('<span class="pay_money">'+2+'</span>元');
        }
     
  })

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
// 支付宝弹窗
  $('.popup_zfb .content').css('margin-top',($(window).height()-460)/2);
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

  //ie 点击input取消光标闪动
  $('.choose_file .btn_file input').click(function() {
    $(this).blur();
  });
})

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

 
//转换执行
    var  conversion = {
        
        single_url:"/Home/Index/batchConversion",
        batch_url:"/Home/Index/batchConversion",
        /**
         * @desc 页面初始化
         */
        init: function () {
                // 事件绑定
              this.RunOnBeforeUnload();
              this.delete_one();
              //this.batch_delete();
        },
        /*
         * @description 单个转换
         */
        startTransition: function ($this,url) {
                if ( typeof(url) =="undefined" || url == 0){ 
                    url = this.single_url;
                }

		var iState      = $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('file-state');
		//var fDown       = $($this).siblings('.down').attr('f-down');|| fDown == 'on'
		if(iState == 'failure' || iState == 'await' || iState == 'start' || iState == 'on' ){
			return false;
		}		
		var fileName    = $($this).parents('tr').find('td').eq(1).children('div').find('h3').html();
		var fileTypeL   = $($this).parents('tr').find('td').eq(4).find('.drop').find('div').html();
                var fileId 		= $($this).parents('tr').find('td').eq(0).attr('id');
		var fileSize    = $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
		var fileSuffix  = $($this).attr('acc');
		var fileTime    = $($this).parents('tr').find('td').eq(0).attr('del-time');

		var inputFile   = $("#fileVal").val().split(',');
		var fileText    = fileTypeL+'_'+fileSize+'_'+fileName;
		//var inArr       = $.inArray(fileText,inputFile);
		
		if($("#"+fileId).length <= 0){clearTimeout(startTransition);return false;}
		var fileJson = [];
		//if(inArr == -1){
                        $($this).parents('tr').find('td').eq(5).find('div').removeClass('success').addClass('now_switch').html('正在转换');
                        $($this).parents('tr').find('td').eq(4).find('div').attr('name','disabled').addClass('rmoveData');;
                     //   $($this).parents('tr').find('td').eq(6).find('div').removeClass('start_switch').addClass('loading').html('');
			$($this).removeClass('reture_switch').removeClass('start_switch').addClass('loading').removeAttr("onclick").html('');
			fileJson.push({"fileName":fileName,"fileType":fileTypeL,"fileSize":fileSize,"suffix":fileSuffix,"fileTime":fileTime,"id":fileId});
		//}
		if(fileJson.length>0){

			$.ajax({
				type:'post',
				url:url,
				data:{"fileInfo":JSON.stringify(fileJson)},
				dataType:'json',
				success:function(resultData){
					//var delFileList = $('#delFile').val().split(',');
					if(resultData.action == 1){

						var successInfo = resultData.success[0];
						var cName = $($this).parents('tr').find('td').eq(0).attr('f-name');
						var cTime = $($this).parents('tr').find('td').eq(0).attr('del-time');
//                                                if( successInfo.conversion == 1){
//                                                }
                                                    var emial_type_click = $(".sendfor_email .checked").length;
                                                    if(emial_type_click == 1){
                                                        var fileJson = {"email":$("#email").val()};
                                                    }
                                                  fileAjaxAsynchronous(fileJson,'timngProcess');
						if(successInfo.fileState == 1){
                                                    
                                                        $($this).parents('tr').find('td').eq(6).find('div').removeClass('failure loading').addClass('now_down').html('下载').attr("onclick","conversion.getDownload(this,'"+successInfo.m_id+"')");
                                                        $($this).parents('tr').find('td').eq(5).find('div').removeClass('failure now_switch').addClass('success').html('转换成功');
                                                        $($this).parents('tr').find('td').eq(4).find('.drop').attr('name','disabled').addClass('rmoveData');
                                                        $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('file-state','on');
                                                        $($this).parents('tr').find('td').eq(0).children('label').removeClass('checked');
							inputFile.push(fileText);
							$("#fileVal").val(inputFile.join(','))							
							//fileAjax(cjson,'cManage');
							clearTimeout(conversion.startTransition);
						}else if(successInfo.fileState == 2){
                                                         $($this).parents('tr').find('td').eq(6).find('div').removeClass('loading').addClass('reture_switch').html('重新转换').attr("onclick","conversion.startTransition(this)");
                                                        $($this).parents('tr').find('td').eq(5).find('div').addClass('failure').html('转换失败');	
                                                        
//							$($this).html('重新转换').attr('onclick','startTransition(this)');
//							$($this).siblings(".span").removeClass('after').addClass('before').html('转换失败');
//							$($this).siblings(".transform").children('span').hide();
//							$(".batchUpload").removeClass("batchNone").attr('href','javascript:batchConversion();');
							clearTimeout(conversion.startTransition);
						}else if(successInfo.fileState == 5){
                                                         $($this).parents('tr').find('td').eq(6).find('div').removeClass('loading').addClass('down_client').html('<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>');
                                                        $($this).parents('tr').eq(5).find('div').addClass('failure').html('转换超时');	
                                                        
//							$($this).html('重新转换').attr('onclick','startTransition(this)');
//							$($this).siblings(".span").removeClass('after').addClass('before').html('转换失败');
//							$($this).siblings(".transform").children('span').hide();
//							$(".batchUpload").removeClass("batchNone").attr('href','javascript:batchConversion();');
							clearTimeout(conversion.startTransition);
						}else{
							setTimeout(function(){conversion.startTransition($this,'/Home/Index/batchConversionAjax')}, 5000);
						}
					}

				}
			});
		}
        },
        RunOnBeforeUnload: function () {
                this.onloadQuery();
                window.onbeforeunload = function(){
                        closeStr = '当前操作将丢失上传和转换的文档，确认执行该操作？';
                        var liLength = $(".list > li").length;
                        if(liLength > 0){
                                return closeStr;
                        }		
                }
        },
        onloadQuery: function () {
                var timestamp = getCookie('timestamp');
                $.ajax({
                        type:'post',
                        url:'/Home/Index/fileRequest',
                        data:{"verify":"PDF","timestamp":timestamp},
                        dataType:'json',
                        success:function(returnlFile){
                                if(typeof returnlFile.action != 'undefined' && returnlFile.action == 1){

                                        var fileInfo = returnlFile.success;
                                        $(".upload").show();
                                        var fInput = [];
                                        for(var f=0;f<fileInfo.length;f++){
                                                var fileHtml = conversion.refreshListHtml(fileInfo[f]);
                                                $(".table").append(fileHtml);
                                        }
                                }else{
                                        window.timestamp = Date.parse(new Date()) / 1000;
                                        setCookie('timestamp',window.timestamp,0.354);
                                }
                        }		
                });
                    
        },
        refreshListHtml:function (fileInfo){
            if (typeof fileInfo.timestamp == 'undefined' || !fileInfo.timestamp) {
                var del_time = window.timestamp;
            } else {
                var del_time = fileInfo.timestamp;
                window.timestamp = del_time;
            }
            if (fileInfo.fdown == 1 || fileInfo.c_fsiz_state == 8 || fileInfo.c_type_state == 2) {
                var success_start = 'on';
            } else if (fileInfo.c_fsiz_state == 8 || fileInfo.c_type_state == 2) {
                var success_start = 'await';
            } else {
                var success_start = 'successful';
            }
            var listHtmls = '';
            listHtmls += '<tr>';
            listHtmls += '<td id="' + fileInfo.id + '" del-time="' + del_time + '" f-name="' + fileInfo.cname + '" ><label class="label"><i class="icon" alt="' + fileInfo.fsize + '" file-state="' + success_start + '" file-state_type="' + fileInfo.fstate + '"  ></i></label></td>'
            var ftype = fileInfo.ftype.toLowerCase();
            var ctype = fileInfo.ctype.toLowerCase();
            if (ftype == 'doc' || ftype == 'docx') {
                var emClass = 'icon icon_doc';
            } else if (ftype == 'ppt' || ftype == 'pptx') {
                var emClass = 'icon icon_ppt';
            } else if (ftype == 'xlsx' || ftype == 'xls') {
                var emClass = 'icon icon_xls';
            } else if (ftype == 'pdf') {
                var emClass = 'icon icon_pdf';
            } else {
                var emClass = 'icon icon_doc';
            }
            listHtmls += '<td><div class="txt_name">  <i class="' + emClass + '"></i><div class="txt"><h3>' + fileInfo.fname + '</h3></div></div> </td>'

            //console.debug(file.ext);
            var fileType = this.getType(ftype);
            var fileCtype = this.getType(ctype);
            //console.log(fileCtype);
            if (!fileType) {
                fileType = ftype.toUpperCase();
                var typeList = [''];
            } else if (fileType != 'PDF') {
                var typeList = ['PDF'];
                listHtmls += '<td><div class="file_format">' + fileType + '</div></td>'
                listHtmls += '<td>转</td>';
                listHtmls += '<td><div class="drop" name="disabled"><div class="info">' + typeList[0] + '</div><div class="caret"></div></div></td>'
            } else {
                var typeList = ['Word'];
                listHtmls += '<td><div class="file_format">' + fileType + '</div></td>'
                listHtmls += '<td>转</td>';
                if (fileInfo.fdown == 1 && fileInfo.cstate == 1) {
                    listHtmls += '<td><div class="drop" name="disabled"><div class="info">' + fileCtype + '</div><div class="caret"></div></div></td>'
                } else {
                    listHtmls += '<td><div class="drop"><div class="info">' + typeList[0] + '</div><div class="caret"></div><ul class="secondary"><li>Excel</li><li>Word</li><li>PPT</li></ul></div></td>'
                }
            }
            if (fileInfo.fdown != 0) {
                var fileStates = fileInfo.fdown == 1 ? 15 : 12;
            } else if (fileInfo.cstate != 0) {
                var fileStates = fileInfo.cstate == 1 ? 15 : 16;
            } else if (fileInfo.fstate != 0) {
                if (fileInfo.fstate == 2) {
                    var fileStates = 3
                } else {
                    var fileStates = fileInfo.fstate;
                }
            }
            if (fileStates == 15 || fileStates == 1) {
                var $spanClass = 'state success';
            } else if (fileStates == 16 || fileStates == 3 || fileStates == 4 || fileStates == 12) {
                var $spanClass = 'state failure';
            } else if (fileStates == 8 || fileStates == 5) {
                var $spanClass = 'state failure';
            }
            listHtmls += '<td><div class="' + $spanClass + '">' + this.getHint(fileStates) + '</div></td>';
            var dStyle = '';
            var clickF = '';
            var clickC = '';
            var clickN = '';
            var cDown = 'off';
            if (fileStates == 15 || fileStates == 12) {
                var calss = 'operation now_down';
                dStyle = 'display: inline-block;';
                clickF = 'onclick="conversion.getDownload(this,\'' + fileInfo.m_id + '\')"';
                clickN = '下载';
                cDown = 'on';
            } else if (fileStates == 16) {
                var calss = 'operation reture_switch';
                clickC = 'onclick="conversion.startTransition(this)"';
                clickN = '重新转换';
            } else if (fileStates == 1) {
                var calss = 'operation start_switch';
                clickC = 'onclick="conversion.startTransition(this)"';
                clickN = '开始转换';
            } else if (fileStates == 3) {
                var calss = 'operation reture_switch';
                clickN = '重新选择';
            } else if (fileStates == 5) {
                var calss = 'operation down_client';
                clickN = '<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>';
            } else if (fileStates == 8) {
                var calss = 'operation reture_switch';
                clickN = '上传失败';
            } else if (fileStates == 4) {
                var calss = 'operation rg_vip';
                clickN = '人工vip';
            }

            listHtmls += '<td><div class="' + calss + '" alt="' + fileInfo.fname + '" acc="' + ftype + '" file-time="' + fileInfo.postfix + '"   ' + clickC + ' ' + clickF + '>' + clickN + '</div></td>';
            listHtmls += '<td><i class="icon icon_delete" alt="' + fileInfo.fname + '" ></i></td>';
            listHtmls += '	</tr>';
            return listHtmls;
        },
        getType:function (filetype){
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
            
        },
        getHint:function ($hintId){
            
		if(!$hintId)return;
		var hintId = parseInt($hintId);
		switch(hintId){

			case 1: var $hint  = '上传成功';break;
			case 2: var $hint  = '该文件已有';break;
			case 3: var $hint  = '上传失败';break;
			case 4: var $hint  = '<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>';break;
			case 5: var $hint  = '<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>';break;
			case 6: var $hint  = '<a href="/Home/Products/ConversionFeeDetail" >立即充值</a>';break;
			case 7: var $hint  = '服务器临时文件夹丢失';break;
			case 8: var $hint  = '文件重复';break;
			case 9: var $hint  = '文件写入失败';break;
			case 10: var $hint = 'PHP文件上传扩展没有打开';break;
			case 11: var $hint = '格式不支持';break;
			case 12: var $hint = '下载链接已失效';break;
			case 13: var $hint = '正在上传';break;
			case 14: var $hint = '等待上传';break;
			case 15: var $hint = '转换成功';break;
			case 16: var $hint = '转换失败';break;
			default: var $hint = '';break;

		}
		return $hint;
            
        },
        getHost:function ($hintId){
                if(!$hintId)return;
		var hintId = parseInt($hintId);
		switch(hintId){

			case 1: var $hint  = '上传成功';break;
			case 2: var $hint  = '该文件已有';break;
			case 3: var $hint  = '上传失败';break;
			case 4: var $hint  = '<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>';break;
			case 5: var $hint  = '<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>';break;
			case 6: var $hint  = '<a href="/Home/Products/ConversionFeeDetail" >立即充值</a>';break;
			case 7: var $hint  = '服务器临时文件夹丢失';break;
			case 8: var $hint  = '上传失败';break;
			case 9: var $hint  = '文件写入失败';break;
			case 10: var $hint = 'PHP文件上传扩展没有打开';break;
			case 11: var $hint = '格式不支持';break;
			case 12: var $hint = '下载链接已失效';break;
			case 13: var $hint = '正在上传';break;
			case 14: var $hint = '正在上传';break;
			case 15: var $hint = '转换成功';break;
			case 16: var $hint = '转换失败';break;
			default: var $hint = '';break;

		}
		return $hint;
        },
        getDownload:function ($this,downIp){
            		var types     = $($this).parents('tr').find('td').eq(4).find('.drop').find('div').html();
		var fileName  = $($this).parents('tr').find('td').eq(1).children('div').find('h3').html();
		var fileTime  = $($this).parents('tr').find('td').eq(6).find('div').attr('file-time');;
		var fsize     = $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
		var cTime     = $($this).parents('tr').find('td').eq(0).attr('del-time');
		var fileId    = $($this).parents('tr').find('td').eq(0).attr('id');
		$.ajax({
			type:'post',
			url:'/Home/Index/ajaxDownload',
			data:{"downType":types,"fileName":fileName,"downIp":downIp,"fileTime":cTime,"fileId":fileId},
			dataType:'json',
			async:false,
			success:function(down){

				if(down.action == 1){

					var uploadUrl = '/Home/Index/download?url='+down.downUrl+'&key='+down.key+'&downType='+types;
                                     
					location.href =  encodeURI(encodeURI(uploadUrl));
					//$("#iframeId").attr('src',encodeURI(encodeURI(uploadUrl)));
					var djson = [{"fid":fileId,"fileName":fileName,"fsize":fsize,"fdown":1,"cTime":cTime}];
				}else{
					
					var returnHtml = conversion.getHint(down.action);
                                        $($this).parents('tr').find('td').eq(5).find('div').addClass('failure').html('下载链接已失效');	
					$($this).siblings('.span').removeClass('after').addClass('before').html(returnHtml);
					//下载链接失效，删除隐藏input的值
                                        $($this).removeClass('now_down').addClass('failure').html('下载过期');
					var fileTypeL = $($this).siblings('.label').html();
					var fileSize  = $($this).siblings('i').attr('alt');
					var fileText  = fileTypeL+'_'+fileSize+'_'+fileName;
					
					var inputFile = $("#fileVal").val().split(',');
					var inArr     = $.inArray(fileText,inputFile);
					if(inArr != -1){
						inputFile.splice(inArr,1);
						$("#fileVal").val(inputFile.join(','));
					}
					var djson = [{"fid":fileId,"fileName":fileName,"fsize":fsize,"fdown":2,"cTime":cTime}];
				}
				fileAjax(djson,'fileDownLoad');
			}		
		});
            
        },
        listHtml:function (file,fileStates){
            
            var liInfo = $(".table tbody tr");
            var liLength = liInfo.length;
            for(var i=0;i<liLength;i++){

                    var listLi       = liInfo.eq(i);
                    var listFileName = listLi.find('td').eq(1).children('div').find('h3').html();
                    var listFileMd5 = listLi.find('td').eq(0).attr('md5file');
                    var fileT        = listLi.find('td').eq(2).find('div').html();
                    var listFileType = listLi.find('td').eq(0).children('label').find('i').attr('file-state_type');
                    var success      = listLi.find('td').eq(0).children('label').find('i').attr('file-state');
                    var id           = listLi.find('td').eq(0).attr('id');
                    //file.size == listFileSize &&
                    if( typeof(id)== 'undefined' &&  success !=='successful' && listFileType !== '4' && listFileType!== '5' && listFileType!== '8' ){
                            if(file.state  == 1){
                                    listLi.find('td').eq(0).attr('id',file.id);
                                    listLi.find('td').eq(0).attr('del-time',file.fileTime);
                                    listLi.find('td').eq(0).attr('md5file',file.fileTime);
                                    listLi.find('td').eq(0).children('label').find('i').attr('file-state',file.success);
                                    listLi.find('td').eq(0).children('label').addClass('checked');
                                    listLi.find('td').eq(6).find('div').html('开始转换').attr("onclick","conversion.startTransition(this)");
                                    listLi.find('td').eq(5).find('div').removeClass('failure').addClass('success').html(file.error_msg);
                            } else {
                                    if(file.state == 5 || file.state == 4){
                                            listLi.find('td').eq(6).find('div').removeClass('start_switch').addClass('down_client').html(this.getHost(file.state));
                                    } else {
                                        listLi.find('td').eq(6).find('div').removeClass('start_switch').addClass('reture_switch').html(this.getHost(file.state));//
                                    }
                                    listLi.find('td').eq(0).attr('md5file',file.fileTime);
                                    listLi.find('td').eq(4).find('.drop').attr('name','disabled').addClass('rmoveData');
                                    listLi.find('td').eq(0).attr('id',file.id);
                                    listLi.find('td').eq(0).children('label').find('i').attr('file-state',file.success);
                                    listLi.find('td').eq(0).children('label').find('i').attr('file-state_type',file.state);
                                    listLi.find('td').eq(5).find('div').html(file.error_msg);
                            }									
                    }
            }
            
        },
        getTypeUpload:function (filetype){
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
            
        },
        listHtmlFind:function (file,fileStates,file_error,m_type){
                    if(typeof file.time == 'undefined'){
                            var del_time = window.timestamp;
                    }else{
                            var del_time = file.time;
                    }
         //console.log(file.name.substr(file.name.lastIndexOf(".")))
                    var listHtmls = '';
                    listHtmls  +=  '<tr>';
                    listHtmls  += '<td del-time="'+del_time+'" ><label class="label"><i class="icon" alt="'+file.size+'" file-state="start"  ></i></label></td>'
                    var ext = file.name.substr((file.name.lastIndexOf(".")));
                    file.ext = ext.toLowerCase();

                    if(this.getTypeUpload(file.ext) == 'Word'){
                            var emClass = 'icon icon_doc';
                    }else if(this.getTypeUpload(file.ext) == 'PPT'){
                            var emClass = 'icon icon_ppt';
                    }else if(this.getTypeUpload(file.ext) == 'Excel'){
                            var emClass = 'icon  icon_xls';
                    }else if(this.getTypeUpload(file.ext) == 'PDF'){
                            var emClass = 'icon icon_pdf';
                    }else{
                            var emClass = 'icon icon_doc';
                    }
                    listHtmls += '<td><div class="txt_name">  <i class="'+emClass+'"></i><div class="txt"><h3>'+file.name+'</h3> <div class="progress_bar"></div></div></div> </td>'

                    var fileType = this.getTypeUpload(file.ext);
                    if(!fileType){
                            fileType     = file.ext.toUpperCase();
                            var typeList = [''];
                    }else if(fileType != 'PDF'){
                            var typeList = ['PDF'];
                    listHtmls  += '<td><div class="file_format">'+fileType+'</div></td>'
                    listHtmls  += '<td>转</td>';
                    listHtmls  += '<td><div class="drop" name="disabled"><div class="info">'+typeList[0]+'</div><div class="caret"></div></div></td>'
                    }else{
                            var typeList = ['Word'];
                    listHtmls  += '<td><div class="file_format">'+fileType+'</div></td>'
                    listHtmls  += '<td>转</td>';
                        if(file_error == 2){
                             listHtmls  += '<td><div class="drop rmoveData" name="disabled"><div class="info">'+typeList[0]+'</div><div class="caret"></div><ul class="secondary"><li>Excel</li><li>Word</li><li>PPT</li></ul></div></td>'
                        } else {
                             listHtmls  += '<td><div class="drop" ><div class="info">'+typeList[0]+'</div><div class="caret"></div><ul class="secondary"><li>Excel</li><li>Word</li><li>PPT</li></ul></div></td>'
                    }	

                    }	
                    if(file_error == 2){
                        if(m_type  == 0){
                             listHtmls += '<td><div class="state failure">文档大小超出限制请充值后重试</div></td>';
                        } else {
                             listHtmls += '<td><div class="state failure">文档大小超出限制请尝试客户端转换</div></td>';
                        }

                    } else {
                    listHtmls += '<td><div class="state failure">正在上传</div></td>';
                    }
                         if(file_error == 2){
                             var operation = 'operation down_client';
                         } else {
                             var operation = 'operation start_switch';
                         }
                    listHtmls += '<td><div class="'+operation+'" alt="'+file.name+'" acc="'+file.ext+'" file-time="'+file.lastModified+'"  >'+this.getHost(fileStates)+'</div></td>';
                    listHtmls += '<td><i class="icon icon_delete" alt="'+file.name+'" ></i></td>';
                    //listHtmls += '				<span class="down" f-down="off">下载</span>';
                    //listHtmls += '				<div class="transform"><span style="display:none;"></span></div>';
                    listHtmls += '	</tr>';
                    $(".table tbody").prepend(listHtmls);
            
            
        },
        batchConversion:function (url){
                if ( typeof(url) =="undefined" || url == 0){ 
                    url = this.batch_url;
                }
            var batchLenth = $(".upload_file .checked").length;
            if (batchLenth > 0) {

                var fileJson = [];
                //var inputFile = $("#fileVal").val().split(',');
                $(".upload_file .checked").each(function () {
                    var fileName = $(this).parents('tr').find('td').eq(1).children('div').find('h3').html();
                    var fileTypeL = $(this).parents('tr').find('td').eq(2).find('div').html();
                    var fileTypeS = $(this).parents('tr').find('td').eq(4).find('.drop').find('div').html();
                    var filesuffix = $(this).parents('tr').find('td').eq(6).find('div').attr('acc');
                    var iState = $(this).find('i').attr('file-state');
                    var fileTime = $(this).parents('tr').find('td').attr("del-time");
                    var id = $(this).parents('tr').find('td').eq(0).attr('id');
                    var fileSize = $(this).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
                    if (iState == 'failure' || iState == 'await' || iState == 'start' || iState == 'on') {
                        $(this).parents('tr').find('td').eq(0).children('label').removeClass('checked');
                        return true;
                    }
                    $(this).parents('tr').find('td').eq(5).find('div').removeClass('success').addClass('now_switch').html('正在转换');
                    $(this).parents('tr').find('td').eq(4).find('div').attr('name', 'disabled').addClass('rmoveData');
                    $(this).parents('tr').find('td').eq(6).find('div').removeClass('reture_switch').removeClass('start_switch').addClass('loading').html('');
                    fileJson.push({"fileName": fileName, "fileType": fileTypeS, "fileSize": fileSize, "suffix": filesuffix, "fileTime": fileTime, "id": id});
                });
                if (fileJson.length > 0) {
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {"fileInfo": JSON.stringify(fileJson)},
                        dataType: 'json',
                        //async:false,
                        success: function (resultData) {

                            var checkboxInfo = $("#fileVal").val().split(',');

                            var liInfo = $(".table tr");
                            var liLength = liInfo.length;
                            if (resultData.action == 1) {
    //                                                        if( resultData.conversion == 1){
    //                                                             
    //                                                        }
                                var emial_type_click = $(".sendfor_email .checked").length;
                                if (emial_type_click == 1) {
                                    var fileJson = {"email": $("#email").val()};
                                }
                                fileAjaxAsynchronous(fileJson, 'timngProcess');
                                var successInfo = resultData.success;
                                var resInfo = [];
                                var cJsonList = [];
                                for (var s = 0; s < successInfo.length; s++) {

                                    for (var i = 1; i <= liLength; i++) {

                                        var listLi = liInfo.eq(i);

                                        var listFileName = listLi.find('td').eq(1).children('div').find('h3').html();
                                        var listFileSize = listLi.find('td').eq(0).children('label').find('i').attr('alt');
                                        var liListId = listLi.find('td').eq(0).attr('id');
                                        var listiState = listLi.find('td').eq(0).children('label').find('i').attr('file-state');
                                        var fileT = listLi.find('td').eq(2).find('div').html();
                                        var listFileType = listLi.find('td').eq(4).find('.drop').find('div').html();
                                        var cTime = listLi.find('td').eq(0).attr('del-time');
                                        var cName = listLi.find('td').eq(0).attr('f-name');
                                        if (listFileName == successInfo[s].fileName && listiState == 'successful' && listFileType == successInfo[s].fileType && successInfo[s].fileSize == listFileSize) {

                                            if (successInfo[s].fileState == 1) {
                                                listLi.find('td').eq(6).find('div').removeClass('failure loading').addClass('now_down').html('下载').attr("onclick", "conversion.getDownload(this,'" + successInfo[s].m_id + "')");
                                                listLi.find('td').eq(5).find('div').removeClass('now_switch').addClass('success').html('转换成功');
                                                listLi.find('td').eq(0).children('label').find('i').attr('file-state', 'on');
                                                listLi.find('td').eq(4).find('.drop').attr('disabled', true);
                                                listLi.find('td').eq(0).children('label').removeClass('checked');
                                                var cjson = {"fid": liListId, "fileName": listFileName, "fsize": listFileSize, "cstate": 1, "cTime": cTime, "cstyle": 2, "cName": cName};
                                                cJsonList.push(cjson);
                                            } else if (successInfo[s].fileState == 2) {

                                                listLi.find('td').eq(6).find('div').removeClass('loading').addClass('reture_switch').html('重新转换').attr("onclick", "conversion.startTransition(this)");
                                                listLi.find('td').eq(5).find('div').addClass('failure').html('转换失败');
                                                var cjson = {"fid": liListId, "fileName": listFileName, "fsize": listFileSize, "cstate": 2, "cTime": cTime, "cstyle": 2, "cName": cName};
                                                cJsonList.push(cjson);
                                            } else if (successInfo[s].fileState == 5) {
                                                listLi.find('td').eq(6).find('div').removeClass('loading').addClass('down_client').html('<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>');
                                                listLi.find('td').eq(5).find('div').addClass('failure').html('转换超时');
                                                var cjson = {"fid": liListId, "fileName": listFileName, "fsize": listFileSize, "cstate": 5, "cTime": cTime, "cstyle": 2, "cName": cName};
                                                cJsonList.push(cjson);
                                            } else {
                                                resInfo[s] = s;
                                            }
                                        }
                                    }
                                }
                                $("#fileVal").val(checkboxInfo.join(','));
                                if (resInfo.length > 0) {

                                    setTimeout(function(){conversion.batchConversion('/Home/Index/batchConversionAjax')}, 3000);
                                } else {
                                    $(".batchUpload").removeClass("batchNone").attr('href', 'javascript:batchConversion();');
                                    ajaxFile = false;
                                    clearTimeout(conversion.batchConversion);
                                }
                            }
                        }
                    });
                }
            } else {
                clearTimeout(batchConversion);
            }
        },
        batch_delete:function (){
                //批量删除文件
                            // console.log($(".table tbody tr").eq(2).html());return false;
                            var fileInput  = $("#fileVal").val().split(',');
                            var batchLenth = $(".upload_file .checked").length;
                            var inputL     = fileInput.length;
                            if(batchLenth > 0){
                                    var txt =  '是否确认删除当前<font color="red">'+batchLenth+'</font>个文档';
                                    var option = {
                                            title: "删除",
                                            btn: parseInt("0011",2),
                                            onOk: function(){

                                                    var delJson = [];

                                                    for(var b=batchLenth-1;b>=0;b--){

                                                            var fileName = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(1).children('div').find('h3').html();
                                                            var fileType = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(2).find('div').html();
                                                            var fileSize = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
                                                            var fileId   = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(0).attr('id');
                                                            var delTime  = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(0).attr('del-time');

                                                            var jsonInfo = {"fid":fileId,"fileName":fileName,"fsize":fileSize,"delTime":delTime,"dstyle":2};
                                                            delJson.push(jsonInfo);
                                                            //console.debug(inputL);				
                                                            if(inputL>0){

                                                                    var fileInfoList = fileType+'_'+fileSize+'_'+fileName;
                                                                    //console.debug(fileInfoList);
                                                                    var valIndex = $.inArray(fileInfoList,fileInput);
                                                                    //console.debug(valIndex);
                                                                    if(valIndex != -1){

                                                                            fileInput.splice(valIndex,1);
                                                                    }
                                                                    $("#fileVal").val(fileInput.join(','));
                                                            }
                                                            //var fileId = $(".checkbox").eq(b).parent().parent().parent('li').eq(0);
                                                            //var fileId = liInfo.attr('id');
                                                            //var fdel   = $(".checkbox").eq(b).siblings('.delete').attr('f-del');
                                                            //var iState = $(".checkbox").eq(b).attr('file-state');
                                                            //if(iState != 'failure' && fdel == 'off')
                                                         //   console.log($(".table tr").eq(b).html())
                                                                    //uploader.removeFile(fileId,true);//删除插件里面的队列文件				
                                                              $(".upload_file .checked").eq(b).parents('tr').remove();//删除页面节点

                                                    }
                                                    if(delJson.length > 0){
                                                            fileAjax(delJson,'delete');
                                                    }
                                                    var liLen = $(".table tr");
                                                    if(liLen.length == 0){
                                                            window.timestamp = Date.parse(new Date()) / 1000;
                                                            setCookie('timestamp',window.timestamp,0.354);
                                                    }					
                                            }
                                    }
                                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.confirm,option);
                            }
        },
        delete_one:function (){
                $(document).on('click', '.icon_delete', function () {
                    var fileId = $(this).parents('tr').find('td').eq(0).attr('id');
                    var delTime = $(this).parents('tr').find('td').eq(0).attr('del-time');
                    var fileName = $(this).attr('alt');
                    var _this = $(this);
                    var fileType = $(this).parents('tr').find('td').eq(2).find('div').html();
                    var fileSize = $(this).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
                    var fileInput = $("#fileVal").val().split(',');
                    var txt = "是否确认删除文件：" + fileName;
                    var option = {
                        title: "删除",
                        btn: parseInt("0011", 2),
                        onOk: function () {

                            if (fileInput.length > 0) {

                                var fileInfo = fileType + '_' + fileSize + '_' + fileName;

                                var valIndex = $.inArray(fileInfo, fileInput);
                                if (valIndex != -1) {

                                    fileInput.splice(valIndex, 1);
                                }
                                $("#fileVal").val(fileInput.join(','));
                            }
                            _this.parents('tr').remove();
                            //if(iState != 'failure' && fdel == 'off')
                            //uploader.removeFile(fileId,true);//删除插件里面的队列文件

                            var jsonInfo = [{"fid": fileId, "fileName": fileName, "fsize": fileSize, "dstyle": 1, "delTime": delTime}];
                            fileAjax(jsonInfo, 'delete');
                            var liLen = $(".table tr");
                            if (liLen.length == 0) {
                                window.timestamp = Date.parse(new Date()) / 1000;
                                setCookie('timestamp', window.timestamp, 0.354);
                            }
                        }
                    }
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.info, option);
                });
        }
        
    };
    //转换结束
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
        conversion.init();
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
        }else{
          
          var returnHtml = getHint(down.action);
          $($this).siblings('.span').removeClass('after').addClass('before').html(returnHtml);
          //下载链接失效，删除隐藏input的值
          var fileTypeL = $($this).siblings('.label').html();
          var fileSize  = $($this).siblings('i').attr('alt');
          var fileText  = fileTypeL+'_'+fileSize+'_'+fileName;
          
          var inputFile = $("#fileVal").val().split(',');
          var inArr     = $.inArray(fileText,inputFile);
          if(inArr != -1){
            inputFile.splice(inArr,1);
            $("#fileVal").val(inputFile.join(','));
          }
          var djson = [{"fid":fileId,"fileName":fileName,"fsize":fsize,"fdown":2,"cTime":cTime}];
        }
        fileAjax(djson,'fileDownLoad');
      }   
    });
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
  });
