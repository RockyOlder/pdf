<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
    <title><?php echo ($common_title); echo ($page_title); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="<?php echo ($common_keywords); ?>">
    <meta name="description" content="<?php echo ($common_desc); ?>">
    <link href="__PUBLIC__/Lib/jquery/css/base/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="__PUBLIC__/Lib/thinkbox/css/style.css">
    <script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>
    <script src="__PUBLIC__/Lib/jquery/js/jquery-ui-1.9.2.custom.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.validate.1.9.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.metadata.js"></script>
    <script src="__PUBLIC__/Lib/validate/messages_cn.js"></script>
    <script src="__PUBLIC__/Admin/js/common.js"></script>
    <script src="__PUBLIC__/Common/js/global.js"></script>
    <link href="__PUBLIC__/Admin/css/global.css" rel="stylesheet">
    <!--[if IE 6]>
        <script type="text/javascript" src="__PUBLIC__/Admin/js/iepng.js"></script>
        <script type="text/javascript">
        EvPNG.fix("#pngImg,.sliderNavBox dl dd");
        </script>
    <![endif]-->
	<script>
        function U(url) {
            return ("__WEBROOT__"+url).replace('//','/'); 
        }
    </script>
</head>
	<?php if(!empty($_SESSION['OSS']['GY_OSS_PIC_URL']) || (!empty($_SESSION['OSS']['GY_OTHER_IP']) && !empty($_SESSION['OSS']['GY_OTHER_ON']) )){ ?>
    <input type="hidden" value="1" id="oss_id" />
   	<?php }else{ ?>
   	<input type="hidden" value="0" id="oss_id" />
   	<?php } ?>
	<?php if($_SESSION['OSS']['GY_QN_ON'] == '1'){ ?>
    <input type="hidden" value="1" id="qn_id" />
   	<?php }else{ ?>
   	<input type="hidden" value="0" id="qn_id" />
   	<?php } ?>
    <body class="mainBox">
        <div id="J_ajax_loading" class="ajax_loading">提交请求中，请稍候...</div>
        <div class="header">
            <!--顶部LOGO和导航-->
<div class="headerBox">
    <h1><a href="#"><img  id="pngImg" <?php if($admin_logo == '/Public/Admin/images/logo.png'): ?>src="__PUBLIC__/Admin/images/logo.png"<?php else: ?>src="<?php echo ($admin_logo); ?>"<?php endif; ?> width="195" height="70"/></a></h1>
    <ul>
        <?php if(is_array($tops)): $i = 0; $__LIST__ = $tops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top): $mod = ($i % 2 );++$i;?><li <?php if(($i) == $nav1): ?>class='on'<?php endif; ?> nav="<?php echo ($i); ?>"><a href="<?php echo ($top["url"]); ?>"><?php echo ($top["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
        </div><!-- header end -->
        <div id="tip_dialog">
            
        </div>
        <div class="contentBox">
            <div class="sidebar">
                <div class="sildebarBox">
                    <div class="sidebarMasg">
                        <h2><?php echo (L("TOP_HELLO")); ?><span><?php echo (session('admin_name')); ?></span></h2>
                        <ul>
                            <h3>待办事务</h3>
                            <li>
							<a href="<?php echo U('Admin/Orders/pageWaitDeliverOrdersList');?>" style="color:#fff;">待发货订单(<?php echo ($wtrade_num); ?>笔)</a>&nbsp;
							<a href="<?php echo U('Admin/Seo/deleteRedis');?>" style="float:right;color:#fff;">清空缓存</a>
							</li>
                        </ul>
                        <a href="###">&nbsp;</a>
                        <a href="<?php echo U('Home/Index/index');?>" target="_blank" class="sc" title="<?php echo (L("TOP_HOME")); ?>"><?php echo (L("TOP_HOME")); ?></a>
                        <a href="<?php echo U('Admin/User/doLogout');?>" class="out" title="<?php echo (L("TOP_LOGOUT")); ?>"><?php echo (L("TOP_LOGOUT")); ?></a>
                        <a href="<?php echo U('Admin/Index/index');?>" class="more" title="<?php echo (L("MORE")); ?>"><?php echo (L("MORE")); ?></a>
                        <a href="<?php echo U('Admin/System/pageEditAdminPasswd');?>" class="editpasswd" title="<?php echo (L("EDITPW")); ?>"><?php echo (L("EDITPW")); ?></a>
                        <a href="javascript:void(0);" data-uri='<?php echo U("Admin/Index/getMap");?>' class="map" id="GyMap" title="后台地图"></a>
                    
                    </div>   
            		
                    <!-- 侧导航开始 -->
                    <!--左侧导航-->
                    <div class="sliderNavBox" id="sliderNavBox">
                        
<div id="sliderNavBoxInner" style="display: block; overflow:visible;">
    <?php if(is_array($menus[$nav1])): $k = 0; $__LIST__ = $menus[$nav1];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu1): $mod = ($k % 2 );++$k; $mk = $key; ?>
        <h2><img class="title" <?php if(($nav2) == $key): ?>src="__PUBLIC__/Admin/images/silderNavIcoF.png"<?php else: ?>src="__PUBLIC__/Admin/images/silderNavIcoJ.png"<?php endif; ?> /><?php echo ($menu1[0]['name']); ?></h2>
        <dl <?php if(($nav2) != $key): ?>style="display: none;"<?php endif; ?> >
            <?php if(is_array($menu1)): $i = 0; $__LIST__ = $menu1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu2): $mod = ($i % 2 );++$i; if(($i) != "1"): ?><dd <?php if(($key == $nav3) and ($mk == $nav2)): ?>class="on"<?php endif; ?> ><a href="<?php echo ($menu2['url']); ?>"><?php echo ($menu2['name']); ?></a></dd><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </dl><?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="clear"></div>
</div>
                    </div>
                    
                    <!-- 侧导航结束 -->
                </div>
            </div><!-- 左侧结束 -->
            <!-- 中间内容开始 -->
            <div class="breadcrumb">
                <!--面包屑导航-->
<a href="<?php echo ($bread0["url"]); ?>"><?php echo ($bread0["name"]); ?></a>
 &nbsp;>&nbsp;
 <?php if(($bread1["name"]) != ""): ?><a href="<?php echo ($bread1["url"]); ?>"><?php echo ($bread1["name"]); ?></a><?php endif; ?>
 <?php if(($bread2["name"]) != ""): ?>&nbsp;>&nbsp;<a href="<?php echo ($bread2["url"]); ?>"><?php echo ($bread2["name"]); ?></a><?php endif; ?>
 <?php if(($bread3["name"]) != ""): ?>&nbsp;>&nbsp;<?php echo ($bread3["name"]); endif; ?>
            </div>
            <div class="content">
                <?php if($is_user_access == '1'){ ?>
                <script type="text/javascript" charset="utf-8">
    window.UEDITOR_HOME_URL = "__PUBLIC__/Lib/ueditor/";
</script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_all.js"></script>
<div class="rightInner">
<form id="noticeForm" method="post" action="<?php echo ($notice?U('Admin/Notice/doEdit'):U('Admin/Notice/doAdd')); ?>">
<table class="tbForm" width="100%">
<thead>
    <tr class="title">
        <th colspan="99"><?php echo ($notice?'修改公告':'添加公告'); ?></th>
    </tr>
</thead>
<tbody>
	<tr>
		<td class="first"><span class="red">*</span> 公告标题：</td>
		<td>
		    <input class="large" type="text" name="pn_title" value="<?php echo ($notice["pn_title"]); ?>" id="pn_title" validate="{required:true}">
		</td>
	</tr>
	<tr>
	    <td class="first">是否置顶：</td>
	    <td>
	        <input type="radio" name="pn_is_top" value="0" id="pn_is_top_0" <?php if($notice["pn_is_top"] == 0): ?>checked="checked"<?php endif; ?>} />
			<label for="pn_is_top_0">否</label>
	        <input type="radio" name="pn_is_top" value="1" id="pn_is_top_1" <?php if($notice["pn_is_top"] == 1): ?>checked="checked"<?php endif; ?> />
			<label for="pn_is_top_1">是</label>
		</td>
	</tr>
	<tr>
	    <td class="first">发布对象：</td>
		<td>
			<input class="pn_is_top" type="radio" name="pn_is_all" value="1" id="pn_is_all_1" <?php if($notice['pn_is_all'] == 1): ?>checked="checked"<?php endif; ?>} />
			<label for="pn_is_all_1">全部用户</label>
	        <input class="pn_is_top" type="radio" name="pn_is_all" value="0" id="pn_is_all_0" <?php if($notice['pn_is_all'] == 0): ?>checked="checked"<?php endif; ?>}>
			<label for="pn_is_all_0">部分用户</label>
		</td>
	</tr>
    <tr class="raMember <?php echo ($notice['pn_is_all']==='0'?'':'none'); ?>">
       <td class="first">会员组：</td>
       <td>
		<?php if(is_array($mGroups)): $i = 0; $__LIST__ = $mGroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mg): $mod = ($i % 2 );++$i;?><input type="checkbox" name="pn_mg[]" value="<?php echo ($mg["mg_id"]); ?>" <?php if(in_array($mg['mg_id'],$myGroups)): ?>checked="checked"<?php endif; ?> /><?php echo ($mg["mg_name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
		</td>
	</tr>
	<tr class="raMember <?php echo ($notice['pn_is_all']==='0'?'"':'none'); ?>">
	    <td class="first">会员等级：</td>
	 <td>
	<?php if(is_array($mLevels)): $i = 0; $__LIST__ = $mLevels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><input type="checkbox"<?php echo in_array($ml[ml_id],$myLevels)?' checked="checked"':''; ?> name="pn_ml[]" value="<?php echo ($ml["ml_id"]); ?>" /><?php echo ($ml["ml_name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
	</td>
	</tr>
	<tr class="raMember <?php echo ($notice['pn_is_all']==='0'?'"':'none'); ?>">
	    <td class="first" style="vertical-align:top">指定会员：</td>
	    <td>
	        <input type="text" name="" class="medium" id="memberName" /> <a href="javascript:void(0);" onclick="addMember();">添加会员</a><br>
	        <table id="raMemberId" class="tbInner" width="400px;">
	            <tr>
	                <th>会员名称</th><th>会员等级</th><th>操作</th>
	            </tr>
	            <?php if(is_array($myMember)): $i = 0; $__LIST__ = $myMember;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$member): $mod = ($i % 2 );++$i;?><tr>
				    <td><span class="m_name"><?php echo ($member["m_name"]); ?></span><input type="hidden" name="pn_mid[]" value="<?php echo ($member["m_id"]); ?>" /></td><td><?php echo ($member["ml_name"]); ?></td><td><a href="javascript:void(0);" onclick="delMember($(this));">删除</a></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	        </table>
	    </td>
	</tr>
	<tr>
	    <td class="first">文章内容：</td>
		<td><script id="editor" name="pn_content" type="text/plain"><?php echo ($notice["pn_content"]); ?></script></td>
	</tr>
</tbody>
<tfoot>
    <tr>
    	<td></td>
        <td colspan="99">
            <input type="submit" value="保 存" class="btnA" >
            <input type="button" onclick="window.history.go(-1);" value="取 消" class="btnA" >
        </td>
    </tr>
</tfoot>
</table>
<input name="pn_id" type="hidden" value="<?php echo ($notice["pn_id"]); ?>"/>
</form>
<div class="clear"></div>
</div>
<script type="text/javascript">
   	//实例化编辑器
	UE.getEditor('editor');
    $("document").ready(function(){
        $('#noticeForm').validate();
        /*全部会员还是部分会员*/
        $(".pn_is_top").click(function(){
            if($(this).val()=='0'){
                $('.raMember').fadeIn('fast');
            }else{
                $('.raMember').hide();
            }
        });
    });
    /*添加会员*/
    function addMember(){
    	var isexist = false;
    	$('.m_name').each(function(){
    		if($("#memberName").val()==$(this).text()){
    			isexist = true;
    			return false;
    		}
    	});
    	if(isexist){
    		return false;
    	}
        var url = "<?php echo U('Admin/Notice/getMemberTr');?>";
        var data = { name:$("#memberName").val()};
        $.post(url,data,function(info){
            if(info=="false"){
                showAlert(false,'出错了','请输入用户名或用户名不正确');
            }else{
                $('#raMemberId').append(info);
            }
        },'text');
    }
    /*删除会员*/
    function delMember(obj){
        obj.parent('td').parent('tr').remove();
    }
</script>
                <?php } ?>

                <?php if($is_user_access != 1): ?>您无权限访问此页。<?php endif; ?>
            </div>
            <!--<div class="fav-nav" style="background: url('__PUBLIC__/Admin/images/fav-nav-bg.png') repeat-x scroll left top transparent;height: 28px;line-height: 28px;">-->
			<div class="fav-nav" style="height: 28px;line-height: 28px;">               
			   <div style="text-align: center; width: 100%;" id="index_footer_text">版权所有 上海管易云</div>
                <div id="panellist"></div>
                <div id="paneladd"></div>
                <input type="hidden" id="menuid" value="">
                <input type="hidden" id="bigid" value="" />
                <div id="help" class="fav-help"></div>
            </div>
        </div>
        <!--后台页脚-->
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-sliderAccess.js"></script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-timepicker-addon.js"></script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-timepicker-zh-CN.js"></script>

        <!--弹出框-->
<div id="alert" style="display: none;" title="系统提示">
    <table width="100%">
        <tr>
            <td style="padding:5px; vertical-align: top;"><div id="alert_face" class=""></div></td>
            <td style="padding:5px; vertical-align: top;">
                <div id="alert_title">提示标题</div>
                <div id="alert_msg">提示内容</div>
            </td>
        </tr>
    </table>
</div>
<!--End of 弹出框-->
        <div style="width: 0px; height: 0px; overflow: hidden; visibility: hidden; clear: both;">
    <audio id="reader" src="" autoplay="autoplay" onended="javascript:void(0);" onemptied="javascript:void(0);" onerror="javascript:void(0);" />
</div>
		<script type="text/javascript">
			//load();
			function load(){
				$.ajax({
				    url:'<?php echo U("Script/Batch/ajaxAsynchronous");?>',//请求的url地址 
					type:"post", //请求的方式 
					dataType:"json", //数据的格式
					data:{}, //请求的数据 
					success:function(data){ //请求成功时，处理返回来的数据 
						
					} 
				})
			}
			/**
            var footer_text = '';
            var footer_text_index = 0;
            function footerTextWaveEffect(){
                var str = footer_text;
                var array_text = str.split('');
                for(var i =0;i<array_text.length;i++){
                    if(i == footer_text_index){
                        array_text[i] = '<span style="color:#ff0000;font-size:18px;">' + array_text[i] + '</span>';
                    }
                }
                $("#index_footer_text").html(array_text.join(''));
                footer_text_index ++ ;
                if(array_text[footer_text_index] == ' '){
                    footer_text_index ++;
                }
                if(footer_text_index >= array_text.length){
                    footer_text_index = 0;
                }
            }
            //默认页面加载
            $(document).ready(function(){
                footer_text = $("#index_footer_text").html();
                setInterval("footerTextWaveEffect()",350);
            });
			**/
		</script>
<!--         <script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script> -->
    </body>
</html>