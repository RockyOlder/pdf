define(['tool'], function(tool){
    //转换执行
    return   conversion = {
        
        single_url:"/Home/Index/batchConversion",
        batch_url:"/Home/Index/batchConversion",
        _this_ajaxLoadMember_conversion_type:document.getElementById("Authorizationtype").value,
        _this_ajaxLoadMember_free_authorization:document.getElementById("Free_authorization").value,
        _this_number_Permission_0:0,
        _this_number_Permission_1:1,
        _this_number_Permission_2:2,
        _this_number_Permission_3:3,
        /**
         * @desc 页面初始化
         */
        init: function () {
                // 事件绑定
              this.RunOnBeforeUnload();
              this.delete_one();
              this.jquery_event();
              //this.batch_delete();
        },
        /*
         * @description 单个转换
         */
        startTransition: function ($this,url) {
         
                var number_page_pdf    = parseInt($($this).parents('tr').find('td').eq(0).attr('number_page_pdf')); 
                var File_type = $($this).parents('tr').find('td').eq(3).find('div').text();             
                var file_failure    = $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('file-failure');
                if(file_failure == conversion._this_number_Permission_2){
                     $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('file-state','successful');
                }
                if($("#Authorizationtype").val()  == this._this_number_Permission_1 ) {
                        if(number_page_pdf > 500){
                            $($this).parents('tr').find('td').eq(6).find('div').removeClass('success').addClass('failure').html('文档页数超出限制<br />请充值后尝试');
                            $($this).removeClass('reture_switch').removeClass('start_switch').addClass('rg_vip').removeAttr("onclick").html(this.getHost(6));
                            var fileId 		=   $($this).parents('tr').find('td').eq(0).attr('id');
                            tool.fileAjax({"fileId": fileId},'upload_state_save');
                            window.rsd.rsdConfirm('content_split');
                        }else {
                            conversion.AskstartTransition($this,url);
                        }
                } else if($("#Authorizationtype").val() == this._this_number_Permission_0) {
                        if($("#Free_authorization").val() == this._this_number_Permission_0 ){
                            if( File_type  == 'PDF') {
                                $($this).parents('tr').find('td').eq(6).find('div').removeClass('success').addClass('failure').html('每日可免费转换一次50页PDF');
                                $($this).removeClass('reture_switch').removeClass('start_switch').addClass('rg_vip').removeAttr("onclick").html(this.getHost(6));
                                var fileId 		=   $($this).parents('tr').find('td').eq(0).attr('id');
                                tool.fileAjax({"fileId": fileId},'upload_state_six');
                            } else {
                                 conversion.AskstartTransition($this,url);
                            }
                        } else {
                                if(number_page_pdf > 50){
                                   var option = {
                                            onOk: function(){
                                                conversion.AskstartTransition($this,url);
                                            }
                                    };
                                    window.rsd.rsdConfirm('content_overflow',option);
                                }else {
                                    conversion.AskstartTransition($this,url);
                                }
                        }

                } else {
                       conversion.AskstartTransition($this,url);
                }

        },
        AskstartTransition:function ($this,url){
            if ( !tool.checkNotEmpty(url)){ 
                    url = this.single_url;
                }
		var iState      = $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('file-state');
             
		//var fDown       = $($this).siblings('.down').attr('f-down');|| fDown == 'on'
		if(iState == 'failure' || iState == 'await' || iState == 'start' || iState == 'on' ){
			return false;
		}		
		var fileName    = $($this).parents('tr').find('td').eq(1).children('div').find('h3').html();
		var fileTypeL   = $($this).parents('tr').find('td').eq(5).find('.drop').find('div').html();
                var fileId 		= $($this).parents('tr').find('td').eq(0).attr('id');
		var fileSize    = $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
		var fileSuffix  = $($this).attr('acc');
                 if ( !tool.checkNotEmpty(fileSuffix)){ 
                   var fileSuffix = $($this).parents('tr').find('td').eq(0).attr('acc');
                }
		var fileTime    = $($this).parents('tr').find('td').eq(0).attr('del-time');
		var inputFile   = $("#fileVal").val().split(',');
		var fileText    = fileTypeL+'_'+fileSize+'_'+fileName;
	//	if($("#"+fileId).length <= 0){clearTimeout(conversion.AskstartTransition);return false;}
		var fileJson = [];
		//if(inArr == -1){
                $($this).parents('tr').find('td').eq(6).find('div').removeClass('success').addClass('now_switch').html('正在转换');
                $($this).parents('tr').find('td').eq(5).find('div').attr('name','disabled').addClass('rmoveData');;
                $($this).parents('tr').find('td').eq(7).find('div').removeClass('reture_switch start_switch').addClass('loading').removeAttr("onclick").html('');
                var emial_type_click = $(".sendfor_email .checked").length;
                if (emial_type_click == 1) {
                    var email = $("#email").val();
                }
                fileJson.push({"fileName":fileName,"fileType":fileTypeL,"fileSize":fileSize,"suffix":fileSuffix,"fileTime":fileTime,"id":fileId,"email":email});
		//}
		if(fileJson.length>0){
			$.ajax({
				type:'post',
				url:url,
				data:{"fileInfo":JSON.stringify(fileJson)},
				dataType:'json',
				success:function(resultData){
					if(resultData.action == 1){
                                            var successInfo = resultData.success[0];
                                            var FilfeType = $($this).parents('tr').find('td').eq(3).find('div').text();
                                            var cTime = $($this).parents('tr').find('td').eq(0).attr('del-time');
                //                                                if( successInfo.conversion == 1){
                //                                                }
                                             tool.fileAjaxAsynchronous(fileJson, 'timngProcess');
                                            if (successInfo.fileState == 1) {
                                                $($this).parents('tr').find('td').eq(7).find('div').removeClass('failure loading').addClass('now_down').html('下载').attr("onclick", "conversion.getDownload(this,'" + successInfo.m_id + "')");
                                                $($this).parents('tr').find('td').eq(6).find('div').removeClass('failure now_switch').addClass('success').html('转换成功');
                                                $($this).parents('tr').find('td').eq(5).find('.drop').attr('name', 'disabled').addClass('rmoveData');
                                                $($this).parents('tr').find('td').eq(0).children('label').find('i').attr('file-state', 'on');
                                                $($this).parents('tr').find('td').eq(0).children('label').removeClass('checked');
                                                inputFile.push(fileText);
                                                $("#fileVal").val(inputFile.join(','))
                                                clearTimeout(conversion.AskstartTransition);
                                                  if(FilfeType  == 'PDF') {
                                                        if($("#Free_authorization").val() == 1){
                                                           if($("#Authorizationtype").val()  == conversion._this_number_Permission_0){
                                                                if(tool.checkNotEmpty($('#ACTIVITY_OPEN').val()) ==false){
                                                                    tool.rsdConfirm('freeContent',null,tool);
                                                                   //  tool.rsdConfirm('teachesDay',null,tool);
                                                                } else {
                                                                    window.rsd.rsdConfirm('content_success');
                                                                    $("#Free_authorization").val(0);
                                                                }
                                                           }
                                                       }
                                                  }
                                                tool.ajaxLoadShoppingMember();
                                                tool.ajaxLoadShoppingHeader();
                                            } else if (successInfo.fileState == 2) {
                                                $($this).parents('tr').find('td').eq(7).find('div').removeClass('loading').addClass('reture_switch').html('重新转换').attr("onclick", "conversion.startTransition(this)");
                                                $($this).parents('tr').find('td').eq(6).find('div').addClass('failure').html('转换失败');
                                                clearTimeout(conversion.AskstartTransition);
                                            } else if (successInfo.fileState == 5) {
                                                $($this).parents('tr').find('td').eq(7).find('div').removeClass('loading now_down').addClass('down_client').html('<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>');
                                                $($this).parents('tr').find('td').eq(6).find('div').addClass('failure').html('转换超时');
                                                clearTimeout(conversion.AskstartTransition);
                                            } else {
                                                setTimeout(function () {
                                                    conversion.AskstartTransition($this, '/Home/Index/batchConversionAjax')
                                                }, 5000);
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
                };
        },
        onloadQuery: function () {
                //var timestamp = tool.getCookie('timestamp');
                $.ajax({
                        type:'post',
                        url:'/Home/Index/fileRequest',
                        data:{"verify":"PDF"},
                        dataType:'json',
                        success:function(returnlFile){
                                if(typeof returnlFile.action != 'undefined' && returnlFile.action == 1){

                                        var fileInfo = returnlFile.success;
                                        $(".upload").show();
                                        var fInput = [];
                                        for(var f=0;f<fileInfo.length;f++){
                                                var fileHtml = conversion.refreshListHtml(fileInfo[f]);
                                                $(".table").append(fileHtml);
                                                if(fileInfo[f].fstate == 7){
                                                    conversion.AskstartTransition($(".table").find("tbody").find("tr:eq("+f+")").find('td').eq(7).find('div'),'/Home/Index/batchConversionAjax');
                                                }
                                        }
                                }
                                //  tool.setCookie('timestamp',window.timestamp,0.354);
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
            } else  if( fileInfo.fstate == 6){
                var success_start = 'await';
            } else  if( fileInfo.fstate == 9){
                var success_start = 'await';
            } else {
                var success_start = 'successful';
            }
            var listHtmls = '';
            var ftype = fileInfo.ftype.toLowerCase();
            var ctype = fileInfo.ctype.toLowerCase();
            var check = '';
            if(fileInfo.fstate == 7){
                check  = 'checked';
            }
            listHtmls += '<tr>';
            listHtmls += '<td id="' + fileInfo.id + '"acc="'+ftype+'" del-time="' + del_time + '" f-name="' + fileInfo.cname + '" number_page_pdf="' + fileInfo.number_page + '" ><label class="label '+check+'"><i class="icon" alt="' + fileInfo.fsize + '" file-state="' + success_start + '" file-state_type="' + fileInfo.fstate + '"  ></i></label></td>'

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
            listHtmls += '<td><div class="txt_name">  <i class="' + emClass + '"></i><div class="txt"><h3>' + fileInfo.fname + '</h3></div></div> </td>';
            if(fileInfo.number_page !=0){
                 listHtmls += '<td>'+fileInfo.number_page+'页</td>';
            } else {
                listHtmls += '<td>/</td>';
            }
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
                var fileStates = fileInfo.fdown == 1 ? 20 : 22;
            } else if (fileInfo.cstate == 1) {
                var fileStates = fileInfo.cstate == 1 ? 20 : 22;
            } else if (fileInfo.cstate == 2) {
                var fileStates = fileInfo.cstate == 2 ? 16 : 22;
            } else if (fileInfo.fstate != 0) {
                if (fileInfo.fstate == 2) {
                    var fileStates = 3
                } else {
                    var fileStates = fileInfo.fstate;
                }
            }
            if (fileStates == 20 || fileStates == 1) {
                var $spanClass = 'state success';
            } else if (fileStates == 16 || fileStates == 3 || fileStates == 4 || fileStates == 12 || fileStates == 10 || fileStates == 11 || fileStates == 13 || fileStates == 14) {
                var $spanClass = 'state failure';
            } else if (fileStates == 8 || fileStates == 5) {
                var $spanClass = 'state failure';
            }else if (fileStates == 6 ) {
                var $spanClass = 'state failure';
            }else if (fileStates == 9 ) {
                var $spanClass = 'state failure';
            }else if (fileStates == 7 ) {
                var $spanClass = 'state success';
            }
            listHtmls += '<td><div class="' + $spanClass + '">' + this.getHint(fileStates) + '</div></td>';
            var dStyle = '';
            var clickF = '';
            var clickC = '';
            var clickN = '';
            var cDown = 'off';
            if (fileStates == 20 || fileStates == 22) {
                var calss = 'operation now_down';
                dStyle = 'display: inline-block;';
                clickF = 'onclick="conversion.getDownload(this,\'' + fileInfo.m_id + '\')"';
                clickN = '下载';
                cDown = 'on';
            } else
                if (fileStates == 16) {
                var calss = 'operation reture_switch';
                clickC = 'onclick="conversion.startTransition(this)"';
                clickN = '重新转换';
            } else if (fileStates == 1 && $('#pdf_authorization').val() !=1) {
                var calss = 'operation start_switch';
                clickC = 'onclick="conversion.startTransition(this)"';
                clickN = '开始转换';
            } else if (fileStates == 3) {
                var calss = 'operation reture_switch';
                clickN = '重新选择';
            } else if (fileStates == 5) {
                //var calss = 'operation down_client';
                //clickN = '<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>';
                var calss = 'operation reture_switch';
                 clickC = 'onclick="conversion.startTransition(this)"';
                 clickN = '重新转换';
            } else if (fileStates == 8 || $('#pdf_authorization').val() == 1) {
                var calss = 'operation reture_switch';
                clickN = '上传失败';
            } else if (fileStates == 4) {
                var calss = 'operation rg_vip';
                clickN = '人工vip';
            }else if (fileStates == 6) {
                var calss = 'operation rg_vip';
                clickN = '<a style="color: #fff;" href="/Home/Products/ConversionFeeDetail" >立即充值</a>';
            }else if (fileStates == 9) {
                var calss = 'operation rg_vip';
                clickN = '<a style="color: #fff;" href="/Home/Products/ConversionFeeDetail" >立即充值</a>';
            }else if (fileStates == 7) {
                var calss = 'operation start_switch';
                clickC = 'onclick="conversion.startTransition(this)"';
                clickN = '开始转换';
              
            }else if(fileStates >=10 && fileStates <=14){
                var calss = 'operation reture_switch';
                clickN = '上传失败';
            } 

            listHtmls += '<td><div class="' + calss + '" alt="' + fileInfo.fname + '" acc="' + ftype + '" file-time="' + fileInfo.postfix + '"   ' + clickC + ' ' + clickF + '>' + clickN + '</div></td>';
            listHtmls += '<td><i class="icon icon_delete" alt="' + fileInfo.fname + '" ></i></td>';
            listHtmls += '	</tr>';
            //$('#pdf_authorization').val(pdf_count);
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
			//case 5: var $hint  = '<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>';break;
                        case 5: var $hint  = '转换超时';break;
			case 6: var $hint  = '每日可免费转换1次50页pdf';break;
			case 7: var $hint  = '正在转换';break;
			case 8: var $hint  = '文件重复';break;
			case 9: var $hint  = '文档页数超出限制<br />请充值后尝试操作';break;
			case 10: var $hint = '内存不足';break;
			case 11: var $hint = '文档需要密码';break;
			case 12: var $hint = '文档已损坏';break;
			case 13: var $hint = '文档保存失败';break;
			case 14: var $hint = '运行环境错误';break;
			case 15: var $hint = '转换成功';break;
			case 16: var $hint = '转换失败';break;
			case 20: var $hint = '转换成功';break;
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
			case 6: var $hint  = '<a style="color:#fff" href="/Home/Products/ConversionFeeDetail" >立即充值</a>';break;
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
            		var types     = $($this).parents('tr').find('td').eq(5).find('.drop').find('div').html();
		var fileName  = $($this).parents('tr').find('td').eq(1).children('div').find('h3').html();
		var fileTime  = $($this).parents('tr').find('td').eq(7).find('div').attr('file-time');;
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

					var uploadUrl = '/Home/Index/download?url='+down.downUrl+'&key='+down.key+'&downType='+types+'&id='+down.fileId;
                                     
					location.href =  encodeURI(encodeURI(uploadUrl));
					//$("#iframeId").attr('src',encodeURI(encodeURI(uploadUrl)));
					var djson = [{"fid":fileId,"fileName":fileName,"fsize":fsize,"fdown":1,"cTime":cTime}];
				}else{
					
					var returnHtml = conversion.getHint(down.action);
                                        $($this).parents('tr').find('td').eq(6).find('div').addClass('failure').html('下载链接已失效');	
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
				tool.fileAjax(djson,'fileDownLoad');
			}		
		});
            
        },
        listHtml:function (file,fileStates){
            
            var liInfo = $(".table tbody tr");
            var liLength = liInfo.length;
            for(var i=0;i<liLength;i++){

                    var listLi       = liInfo.eq(i);
                    var listFileName = listLi.find('td').eq(1).children('div').find('h3').text();
                    var listFileMd5 = listLi.find('td').eq(0).attr('md5file');
                    var listFileType = listLi.find('td').eq(0).children('label').find('i').attr('file-state_type');
                    var success      = listLi.find('td').eq(0).children('label').find('i').attr('file-state');
                    var id           = listLi.find('td').eq(0).attr('id');

                    if( typeof(id)== 'undefined' && listFileMd5  != file.md5file  && listFileName == file.tname  && success !=='successful' && listFileType !== '4' && listFileType!== '5' && listFileType!== '8' ){
                            if(file.state  == 1){
                                    listLi.find('td').eq(7).find('div').html('开始转换').attr("onclick","conversion.startTransition(this)");
                                    //$('#pdf_authorization').val(file.pdf_authorization);
                                    listLi.find('td').eq(0).attr('id',file.id);
                                    listLi.find('td').eq(0).attr('del-time',file.fileTime);
                                    listLi.find('td').eq(0).attr('md5file',file.md5file);
                                    listLi.find('td').eq(0).attr('number_page_pdf',file.number_page_pdf);
                                    if(file.number_page_pdf !=0){
                                        listLi.find('td').eq(2).html(file.number_page_pdf+"页");
                                    }
                                    
                                    listLi.find('td').eq(0).children('label').find('i').attr('file-state',file.success);
                                    listLi.find('td').eq(0).children('label').addClass('checked');
                                    listLi.find('td').eq(6).find('div').removeClass('failure').addClass('success').html(file.error_msg);
                            } else {
                              
                                    if(file.state == 5 || file.state == 4){
                                            listLi.find('td').eq(7).find('div').removeClass('start_switch').addClass('down_client').html(this.getHost(file.state));
                                    } else if(file.state == 6){
                                        listLi.find('td').eq(7).find('div').removeClass('start_switch').addClass('rg_vip').html(this.getHost(file.state));//
                                    }else if(file.state >=10 && file.state <=14){
                                        listLi.find('td').eq(7).find('div').removeClass('start_switch').addClass('reture_switch').html(this.getHost(3));//
                                    } else {
                                        listLi.find('td').eq(7).find('div').removeClass('start_switch').addClass('reture_switch').html(this.getHost(file.state));//
                                    }
                                    if(file.number_page_pdf !=0){
                                        listLi.find('td').eq(2).html(file.number_page_pdf+"页");
                                    }
                                    listLi.find('td').eq(0).attr('md5file',file.fileTime);
                                    listLi.find('td').eq(5).find('.drop').attr('name','disabled').addClass('rmoveData');
                                    listLi.find('td').eq(0).attr('id',file.id);
                                    listLi.find('td').eq(0).attr('number_page_pdf',file.number_page_pdf);
                                    listLi.find('td').eq(0).children('label').find('i').attr('file-state',file.success);
                                    listLi.find('td').eq(0).children('label').find('i').attr('file-state_type',file.state);
                                    listLi.find('td').eq(6).find('div').html(file.error_msg);
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
//                    file.name = file.name.replace(/&nbsp;/ig,'');
//                    alert(file.name)
                    listHtmls += '<td><div class="txt_name">  <i class="'+emClass+'"></i><div class="txt"><h3>'+file.name+'</h3> <div class="progress_bar"></div></div></div> </td>';
                    listHtmls += '<td>/</td>';

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

                if ( !tool.checkNotEmpty(url)){ 
                    url = this.batch_url;
                }
                var batchSend = {
                    _this_number_page_pdf:0,
                    _this_text_msg:'',
                    init:function (){
                        this.AskBatchConversion(url);
                    },
                AskBatchConversion:function (url){

//                            if(conversion._this_ajaxLoadMember_conversion_type == batchSend._this_number_page_pdf){
//                                 window.rsd.rsdConfirm('content_start');
//                            }
                            $(".upload_file .checked").each(function () {
                                var number_page_pdf = $(this).parents('tr').find('td').eq(0).attr('number_page_pdf');
                                var file_failure    = $(this).parents('tr').find('td').eq(0).children('label').find('i').attr('file-failure');
                                var File_type       = $(this).parents('tr').find('td').eq(3).find('div').text();
                                if(file_failure == conversion._this_number_Permission_2){
                                   $(this).find('i').attr('file-state', 'successful');
                                }
                                 var iState = $(this).find('i').attr('file-state');
                                if (iState == 'failure' || iState == 'await' || iState == 'start' || iState == 'on') {
                                    $(this).parents('tr').find('td').eq(0).children('label').removeClass('checked');
                                    return true;
                                }
                                if($("#Authorizationtype").val()  == conversion._this_number_Permission_1 ) {
                                    if(number_page_pdf > 500){
                                        $(this).parents('tr').find('td').eq(6).find('div').removeClass('success').addClass('failure').html('文档页数超出限制<br />请充值后尝试');
                                        $(this).parents('tr').find('td').eq(7).find('div').removeClass('start_switch').addClass('rg_vip').removeAttr("onclick").html(conversion.getHost(6));
                                       $(this).find('i').attr('file-state','failure');
                                        tool.fileAjax({"fileId": $(this).parents('tr').find('td').eq(0).attr('id')},'upload_state_save');
                                        batchSend._this_number_page_pdf = conversion._this_number_Permission_2;
                                    }
                                } else if($("#Authorizationtype").val() == conversion._this_number_Permission_0) {
                                        if($('#Free_authorization').val() == conversion._this_number_Permission_0 ){
                                            if( File_type  == 'PDF') {
                                            $(this).parents('tr').find('td').eq(6).find('div').removeClass('success').addClass('failure').html('每日可免费转换一次50页PDF');
                                            $(this).parents('tr').find('td').eq(7).find('div').removeClass('start_switch reture_switch').addClass('rg_vip').removeAttr("onclick").html(conversion.getHost(6));
                                            $(this).find('i').attr('file-state','failure');
                                            tool.fileAjax({"fileId": $(this).parents('tr').find('td').eq(0).attr('id')},'upload_state_six');
                                            batchSend._this_number_page_pdf = conversion._this_number_Permission_3;
                                            }
                                        }else {
                                              if(number_page_pdf > 50){
                                            batchSend._this_number_page_pdf =  conversion._this_number_Permission_1;
                                        }    
                                    }
                              
                                }
                            });
                            if(batchSend._this_number_page_pdf == conversion._this_number_Permission_1){
                                var option = {
                                         onOk: function(){
                                             batchSend.AskBatchConversionSendPerform(url);
                                         }
                                 };
                                 window.rsd.rsdConfirm('content_overflow',option);
                            }else if(batchSend._this_number_page_pdf == conversion._this_number_Permission_2) {
                                 window.rsd.rsdConfirm('content_split');
                                batchSend.AskBatchConversionSendPerform(url);
                            } else {
                                 batchSend.AskBatchConversionSendPerform(url);
                            }
                    },
                    AskBatchConversionSendPerform:function (url){
            
                            var batchLenth = $(".upload_file .checked").length;
                            if (batchLenth > 0) {

                                var fileJson = [];
                                //var inputFile = $("#fileVal").val().split(',');
                                $(".upload_file .checked").each(function () {
                                    var fileName = $(this).parents('tr').find('td').eq(1).children('div').find('h3').html();
                                    var fileTypeL = $(this).parents('tr').find('td').eq(3).find('div').html();
                                    var fileTypeS = $(this).parents('tr').find('td').eq(5).find('.drop').find('div').html();
                                    var filesuffix = $(this).parents('tr').find('td').eq(7).find('div').attr('acc');
                                    var iState = $(this).find('i').attr('file-state');
                                    var fileTime = $(this).parents('tr').find('td').attr("del-time");
                                    var id = $(this).parents('tr').find('td').eq(0).attr('id');
                                    var fileSize = $(this).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
                                    if (iState == 'failure' || iState == 'await' || iState == 'start' || iState == 'on') {
                                        $(this).parents('tr').find('td').eq(0).children('label').removeClass('checked');
                                        return true;
                                    }
                                    $(this).parents('tr').find('td').eq(6).find('div').removeClass('success').addClass('now_switch').html('正在转换');
                                    $(this).parents('tr').find('td').eq(5).find('div').attr('name', 'disabled').addClass('rmoveData');
                                    $(this).parents('tr').find('td').eq(7).find('div').removeClass('reture_switch').removeClass('start_switch').addClass('loading').html('');
                                    var emial_type_click = $(".sendfor_email .checked").length;
                                    if (emial_type_click == 1) {
                                        var email =  $("#email").val();
                                    }
                                    fileJson.push({"fileName": fileName, "fileType": fileTypeS, "fileSize": fileSize, "suffix": filesuffix, "fileTime": fileTime, "id": id,"email":email,"batchEmail":2});
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
                                                 if(conversion.batch_url == url){
                                                     tool.fileAjaxAsynchronous(fileJson, 'timngProcess');
                                                 }
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
                                                        var fileT = listLi.find('td').eq(3).find('div').html();
                                                        var listFileType = listLi.find('td').eq(5).find('.drop').find('div').html();
                                                        var cTime = listLi.find('td').eq(0).attr('del-time');
                                                        var cName = listLi.find('td').eq(0).attr('f-name');
                                                        if (listFileName == successInfo[s].fileName && listiState == 'successful' && listFileType == successInfo[s].fileType && successInfo[s].fileSize == listFileSize) {

                                                            if (successInfo[s].fileState == 1) {
                                                                tool.fileAjaxAsynchronous(fileJson, 'timngProcess');
                                                                listLi.find('td').eq(7).find('div').removeClass('failure loading').addClass('now_down').html('下载').attr("onclick", "conversion.getDownload(this,'" + successInfo[s].m_id + "')");
                                                                listLi.find('td').eq(6).find('div').removeClass('failure now_switch').addClass('success').html('转换成功');
                                                                listLi.find('td').eq(0).children('label').find('i').attr('file-state', 'on');
                                                                listLi.find('td').eq(5).find('.drop').attr('disabled', true);
                                                                listLi.find('td').eq(0).children('label').removeClass('checked');
                                                                var cjson = {"fid": liListId, "fileName": listFileName, "fsize": listFileSize, "cstate": 1, "cTime": cTime, "cstyle": 2, "cName": cName};
                                                                cJsonList.push(cjson);
                                                            } else if (successInfo[s].fileState == 2) {
                                                                tool.fileAjaxAsynchronous(fileJson, 'timngProcess');
                                                                listLi.find('td').eq(7).find('div').removeClass('loading').addClass('reture_switch').html('重新转换').attr("onclick", "conversion.startTransition(this)");
                                                                listLi.find('td').eq(6).find('div').addClass('failure').html('转换失败');
                                                                listLi.find('td').eq(0).children('label').find('i').attr('file-state', 'on');
                                                                listLi.find('td').eq(0).children('label').find('i').attr('file-failure', '2');
                                                                var cjson = {"fid": liListId, "fileName": listFileName, "fsize": listFileSize, "cstate": 2, "cTime": cTime, "cstyle": 2, "cName": cName};
                                                                cJsonList.push(cjson);
                                                            }  else if (successInfo[s].fileState == 5) {
                                                                tool.fileAjaxAsynchronous(fileJson, 'timngProcess');
                                                                listLi.find('td').eq(7).find('div').removeClass('loading').addClass('down_client').html('<a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" target="_blank">下载客户端</a>');
                                                                listLi.find('td').eq(6).find('div').addClass('failure').html('转换超时');
                                                                var cjson = {"fid": liListId, "fileName": listFileName, "fsize": listFileSize, "cstate": 5, "cTime": cTime, "cstyle": 2, "cName": cName};
                                                                cJsonList.push(cjson);
                                                            }  else if (successInfo[s].fileState == 6) {
                                                                tool.fileAjaxAsynchronous(fileJson, 'timngProcess');
                                                                //$(this).parents('tr').find('td').eq(7).find('div').removeClass('start_switch reture_switch').addClass('rg_vip').removeAttr("onclick").html(conversion.getHost(6));
                                                                listLi.find('td').eq(0).children('label').find('i').attr('file-state', 'failure');
                                                                listLi.find('td').eq(7).find('div').removeClass('loading').addClass('rg_vip').html(conversion.getHost(6));
                                                                listLi.find('td').eq(6).find('div').addClass('failure').html('每日可免费转换一次50页PDF');
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

                                                    setTimeout(function(){batchSend.AskBatchConversionSendPerform('/Home/Index/batchConversionAjax')}, 4500);
                                                } else {
                                                    $(".batchUpload").removeClass("batchNone").attr('href', 'javascript:batchConversion();');
                                                    ajaxFile = false;
                                                    clearTimeout(batchSend.AskBatchConversionSendPerform);
                                                    tool.ajaxLoadShoppingMember();
                                                    tool.ajaxLoadShoppingHeader();
                                                }
                                            }
                                        }
                                    });
                                }
                            } else {
                                clearTimeout(batchSend.AskBatchConversionSendPerform);
                            }
                    }
                };
                batchSend.init();
                
        },
//        AskBatchConversionSendPerform:function (){
//            
//        },
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
                                                            var fileType = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(3).find('div').html();
                                                            var fileSize = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(0).children('label').find('i').attr('alt');
                                                            var fileId   = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(0).attr('id');
                                                            var delTime  = $(".upload_file .checked").eq(b).parents('tr').find('td').eq(0).attr('del-time');

                                                            var jsonInfo = {"fid":fileId,"fileName":fileName,"fsize":fileSize,"delTime":delTime,"dstyle":2};
                                                            delJson.push(jsonInfo);			
                                                            if(inputL>0){
                                                                    var fileInfoList = fileType+'_'+fileSize+'_'+fileName;
                                                                    var valIndex = $.inArray(fileInfoList,fileInput);
                                                                    if(valIndex != -1){
                                                                            fileInput.splice(valIndex,1);
                                                                    }
                                                                    $("#fileVal").val(fileInput.join(','));
                                                            }		
                                                              $(".upload_file .checked").eq(b).parents('tr').remove();//删除页面节点

                                                    }
                                                    if(delJson.length > 0){
                                                            tool.fileAjax(delJson,'delete');
                                                    }
//                                                    }					
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
                    var fileType = $(this).parents('tr').find('td').eq(3).find('div').html();
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
                            var jsonInfo = [{"fid": fileId, "fileName": fileName, "fsize": fileSize, "dstyle": 1, "delTime": delTime}];
                            tool.fileAjax(jsonInfo, 'delete');
                        }
                    }
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.info, option);
                });
        },
        jquery_event:function (){
            $(document).on('click','.upload_file .label',function(){
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
                if($('#Authorizationtype').val() ==""){
                   $('.btn_file').css({'background':'#d2d2d2','color':'#fff','cursor':'not-allowed'}).find('.bubble_promet').show().siblings('#fileupload').hide();          
                }else{
                   $('.btn_file').removeAttr('style').find('.bubble_promet').hide().siblings('#fileupload').show(); 
                }  
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
            $(document).on('click','.drop',function(e){
                e.stopPropagation();
                if($(this).not('.rmoveData').find(".secondary").is(":hidden")){
                    $(this).find(".secondary").show();
                    $(this).parents("tr").siblings('tr').find('.secondary').hide();
                }else{
                    $(this).find(".secondary").hide();

                } 
            })
     $(document).on('click','.secondary li',function(e){
        e.stopPropagation();
        var txt = $(this).text();
        $(this).parent().siblings('.info').text(txt);
        $(this).parent().hide();

    })


    $(document).click(function(){
        $('.secondary').hide();
    })

        }
    };
});