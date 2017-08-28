$(document).ready(function(){
	window.hostUrl = window.location.origin;
	$(document).on('click','.column > i',function(){

		//var iState = $(this).attr('state');
		$(this).toggleClass("checkbox");
	});


	var bBtn = true;

	$(document).on('click','.type > ul > li',function(){
		
		$(this).closest("ul").siblings("input").val($(this).children("em").html());
		bBtn = false;
		//$(this).closest("ul").hide();

	});
	

	$(document).on('click','.type',function(){
		
		//console.debug(styleI);
		if(bBtn){
			$(this).children("ul").show();
		}else{
			$(this).children("ul").hide();
		}
		bBtn = !bBtn;
		//var e=event || window.event;
		//e.stopPropagation();
	})


	document.body.onclick = function(){
		
		$(".type").children('ul').hide();
		bBtn = true;
		//e.preventDefault();
	}

	// 点击上传
	$(".btn").click(function(){ 
		//return $(".file").click();
	});



	// 全选
	$(".check").click(function(){

		var liInfo = $(".list > li").length;
		for(var i=0;i<liInfo;i++){

			var iInfo = $(".list > li").eq(i).children('.wrapper').children('.column').children('i');
			//if( iInfo.attr('state') != 'failure' && iInfo.attr('state') != 'undefined'){
				iInfo.addClass("checkbox");
			//}
		}
		//bBtn = !bBtn;
	})
	//反选
	$(".invert").click(function(){

		var liInfo = $(".list > li").length;
		for(var i=0;i<liInfo;i++){

			var iInfo  = $(".list > li").eq(i).children('.wrapper').children('.column').children('i');
			var iClass = iInfo.attr('class');
			if(typeof iClass == 'undefined' || iClass == ''){
				iInfo.addClass('checkbox');
			}else{
				iInfo.removeClass('checkbox');
			}

		}			
	});


});

function delFile(file,liLength,ftate){
	
	var fileInfoList = new Array();
	//上传失败 重新上传处理，删除页面原有文件
	if(liLength > 0){

		var fileDataList = [];
		for(var liI=0;liI<liLength;liI++){

			var liInfo    = $(".list > li").eq(liI).children().children();
			var fileInfos = liInfo.children('.change').attr('alt');
			var fileSize  = liInfo.children('i').attr('alt');
			var fileType  = liInfo.children('.change').attr('acc');
			fileInfoList.push(fileType+'_'+fileSize+'_'+fileInfos);
		}
		//console.debug(fileInfoList);
		if(fileInfoList.length > 0){

			var queuedInfo = file.ext.toLocaleLowerCase()+'_'+file.size+'_'+file.name;
			var fileIndex  = $.inArray(queuedInfo,fileInfoList);
			if(fileIndex != -1){

				var fileState =  $(".list > li").eq(fileIndex).children().children().children('i').attr('file-state');
				//console.debug(fileState+'------'+window.fDuplicate);
				if(window.fDuplicate == true){
					var txt   = "您上传的文档重复";
					window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
					window.fDuplicate = false;
					window.frepeat = false;
					return false;
				}
				if(fileState != 'successful'){
					//console.debug(12333);
					$(".list > li").eq(fileIndex).remove();
					return true;
				}
				return false;
			}
		}	
	}
	return true;
}
/*
$(window).unload(function (evt) { 
	if (typeof evt == 'undefined') {
		evt = window.event; 
	}
	if (evt) {
		return '';
		var n = window.event.screenX - window.screenLeft;
		var b = n > document.documentElement.scrollWidth-20;
		if(b && window.event.clientY < 0 || window.event.altKey){
			return false;
		}
	} 
});
*/
//按F5提示
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

/*
document.onkeydown = function (e) {
    var ev = window.event || e;
    var code = ev.keyCode || ev.which;
    if (code == 116) {

        ev.keyCode ? ev.keyCode = 0 : ev.which = 0;
        cancelBubble = true;
        //alert(1233);
    }
}

//禁止鼠标右键菜单
document.oncontextmenu = function(e){
    //return false;
}
*/

function fileAjax(fileJson,faction){

	$.ajax({
		type:'post',
		url:window.hostUrl+'/action/upload.php?action='+faction,
		data:{"fileInfo":JSON.stringify(fileJson)},
		dataType:'json',
		async:false,
		success:function(returnlInfo){
		}		
	});
}

function onloadQuery(){
	
	var timestamp = getCookie('timestamp');
	//console.debug(timestamp);
	$.ajax({
		type:'post',
		url:window.hostUrl+'/action/upload.php?action=fileRequest',
		data:{"verify":"PDF","timestamp":timestamp},
		dataType:'json',
		async:false,
		success:function(returnlFile){

			if(typeof returnlFile.action != 'undefined' && returnlFile.action == 1){
				
				var fileInfo = returnlFile.success;
				$(".upload").show();
				var fInput = [];
				for(var f=0;f<fileInfo.length;f++){
					var fileHtml = refreshListHtml(fileInfo[f]);
					$(".list").append(fileHtml);
				}
			}else{
				window.timestamp = Date.parse(new Date()) / 1000;
				setCookie('timestamp',window.timestamp,0.354);
			}
		}		
	});
}

function refreshListHtml(fileInfo){

		if(typeof fileInfo.timestamp == 'undefined' || !fileInfo.timestamp){
			var del_time = window.timestamp;
		}else{
			var del_time = fileInfo.timestamp;
			window.timestamp = del_time;
		}

		var listHtmls = '';
		listHtmls += '	<li id="'+fileInfo.fid+'" del-time="'+del_time+'" f-name="'+fileInfo.cname+'">';
		listHtmls += '		<div class="wrapper">';
		listHtmls += '			<div class="column">';
		listHtmls += '				<i alt="'+fileInfo.fsize+'" file-state="successful"></i>';
		var ftype = fileInfo.ftype.toLowerCase();
		if(ftype == 'doc' || ftype == 'docx'){
			var emClass = 'icon_doc';
		}else if(ftype == 'ppt' || ftype == 'pptx'){
			var emClass = 'icon_ppt';
		}else if(ftype == 'xlsx' || ftype == 'xls'){
			var emClass = 'icon_xls';
		}else if(ftype == 'pdf'){
			var emClass = 'icon_pdf';
		}else{
			var emClass = 'icon_doc';
		}		
		listHtmls += '				<em class="'+emClass+'"></em>';

		listHtmls += '				<div class="name">';
		listHtmls += '					<h3 class="pdf" title="'+fileInfo.fname+'">'+fileInfo.fname+'</h3>';
		listHtmls += '					<div class="progressB">';
		listHtmls += '						<div class="container" style="display:none;">';
		listHtmls += '							<div class="loading per10"></div>';
		listHtmls += '						</div>';
		listHtmls += '					</div>';
		//listHtmls += '					<span class="before">'+getHint(fileState)+'</span>';
		listHtmls += '				</div>';
		//console.debug(file.ext);
		var fileType = getType(ftype);
		//console.debug(fileType);
		if(!fileType){
			fileType     = ftype.toUpperCase();
			var typeList = [''];
		}else if(fileType != 'PDF'){
			var typeList = ['PDF'];
		}else{
			var typeList = ['Word'];
		}		
		listHtmls += '				<div class="label">'+fileType+'</div>';
		listHtmls += '				<div class="turn">转</div>';
		listHtmls += '				<div class="type">';
		listHtmls += '					<input type="button" value="'+typeList[0]+'"/>';
		/*
		listHtmls += '					<span class="gou"></span>';
		listHtmls += '					<ul>';
		if(typeof typeList[0] != 'undefined' && typeList[0] != ''){
			for(var t=0;t<typeList.length;t++){
				if(typeList[t] == 'Excel') 
					var typeClass = 'xls';
				else
					var typeClass = typeList[t].toLowerCase();
				listHtmls += '						<li class="'+typeClass+'"><b></b><em>'+typeList[t]+'</em></li>';
			}			
		}

		listHtmls += '					</ul>';
		*/
		listHtmls += '				</div>';
		//var fstate = returnlFile.fstate;
		if(fileInfo.fdown != 0){
			var fileStates = fileInfo.fdown == 1 ? 15 : 12;
		}else if(fileInfo.cstate != 0){
			var fileStates = fileInfo.cstate == 1 ? 15 : 16;
		}else if(fileInfo.fstate != 0){
			if(fileInfo.fstate == 2){
				var fileStates = 3
			}else{
				var fileStates = fileInfo.fstate;
			}
			
		}
		if(fileStates == 15 || fileStates == 1){
			var $spanClass = 'after';
		}else if(fileStates == 16 || fileStates == 3 || fileStates == 4 || fileStates == 12){
			var $spanClass = 'before';
		}
		listHtmls += '				<span  class="'+$spanClass+' span">'+getHint(fileStates)+'</span>';
		var dStyle = '';
		var clickF = '';
		var clickC = '';
		var clickN = '';
		var cDown  = 'off'; 
		if(fileStates == 15 || fileStates == 12){
			var cStyle = 'display: none;';
			dStyle = 'display: inline-block;';
			clickF = 'onclick="getDownload(this,\''+fileInfo.ip+'\')"';
			cDown  = 'on';
		}else if(fileStates == 16){
			var cStyle = 'display: inline-block;';
			clickC = 'onclick="startTransition(this)"';
			clickN = '重新转换';
		}else if(fileStates == 1){
			var cStyle = 'display: inline-block;';
			clickC = 'onclick="startTransition(this)"';
			clickN = '开始转换';
		}else if(fileStates == 3 || fileStates == 4){
			var cStyle = 'display: inline-block;';
			clickN = '重新选择';
		}
		listHtmls += '				<span class="change" alt="'+fileInfo.fname+'" acc="'+ftype+'" file-time="'+fileInfo.postfix+'" style="'+cStyle+'" '+clickC+'>'+clickN+'</span>';
		listHtmls += '				<span class="down" style="'+dStyle+'" '+clickF+' f-down="'+cDown+'">下载</span>';
		listHtmls += '				<div class="transform"><span style="display:none;"></span></div>';
		listHtmls += '				<span alt="'+fileInfo.fname+'" f-del="on" class="delete"><span></span>删除</span>';
		listHtmls += '			</div>';
		listHtmls += '		</div>';
		listHtmls += '	</li>';
		return listHtmls;
}

function setCookie(c_name,value,expiredays){
	
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	//document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	//console.debug(exdate);
	document.cookie=c_name+"="+escape(value);
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

