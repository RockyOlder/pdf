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
    <form id="erp_set" name="erp_set" method="post" action="<?php echo U('Admin/Home/doSet');?>" enctype="multipart/form-data">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">官网基本信息设置</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th colspan="99">官网状态</th>
                </tr>
                <tr>
                    <td class="first">开启/关闭：</td>
                    <td>
						<span>
							<input type="radio" name="GY_SHOP_OPEN" id="GY_SHOP_OPEN_1" value="1" <?php if(($GY_SHOP_OPEN) == "1"): ?>checked="checked"<?php endif; ?> />
							<label for="GY_SHOP_OPEN_1">开启</label>
						</span>
						<span style="margin-left:15px;">
                        <input type="radio" name="GY_SHOP_OPEN" id="GY_SHOP_OPEN_0" value="0" <?php if(($GY_SHOP_OPEN) == "0"): ?>checked="checked"<?php endif; ?> />
						<label for="GY_SHOP_OPEN_0">关闭</label>
						</span>
						<span style="margin-left:20px;color:#ff0000;">*官网关闭以后，用户访问将会直接跳转到会员中心。</span>
                    </td>
                    <td class="last"></td>
                </tr>
				<tr>
                    <td class="first">是否登录：</td>
                    <td>
						<span>
							<input type="radio" name="GY_MUST_LOGIN" id="GY_MUST_LOGIN_1" value="1" <?php if(($GY_MUST_LOGIN) == "1"): ?>checked="checked"<?php endif; ?> />
							<label for="GY_MUST_LOGIN_1">是</label>
						</span>
						<span style="margin-left:15px;">
                        <input type="radio" name="GY_MUST_LOGIN" id="GY_MUST_LOGIN_0" value="0" <?php if(($GY_MUST_LOGIN) == "0"): ?>checked="checked"<?php endif; ?> />
						<label for="GY_MUST_LOGIN_0">否</label>
						</span>
						<span style="margin-left:20px;color:#ff0000;">*选择是表示用户必须登录才能访问网站,官网必须为开启状态</span>
                    </td>
                    <td class="last"></td>
                </tr>
                <?php if(SAAS_ON == FALSE){ ?>
                <tr>
                    <th colspan="99">官网类型</th>
                </tr>
                <tr>
                    <td class="first">类型:</td>
                    <td>
						<span>
                            <input type="radio" name="GY_SHOP_TYPE" id="GY_SHOP_TYPE_1" value="1" <?php if($GY_SHOP_TYPE == ''): ?>checked="checked"<?php else: if(($GY_SHOP_TYPE) == "1"): ?>checked="checked"<?php endif; endif; ?> />
							<label for="GY_SHOP_TYPE_1">B2B</label>
						</span>
						<span style="margin-left:15px;">
                        <input type="radio" name="GY_SHOP_TYPE" id="GY_SHOP_TYPE_2" value="2" <?php if(($GY_SHOP_TYPE) == "2"): ?>checked="checked"<?php endif; ?> />
						<label for="GY_SHOP_TYPE_2">B2C</label>
						</span>
						<span style="margin-left:15px;">
                        <input type="radio" name="GY_SHOP_TYPE" id="GY_SHOP_TYPE_3" value="3" <?php if(($GY_SHOP_TYPE) == "3"): ?>checked="checked"<?php endif; ?> />
						<label for="GY_SHOP_TYPE_3">B2B2C</label>
						</span>
						
						<span style="margin-left:20px;color:#ff0000;">*店铺类型。</span>
                    </td>
                    <td class="last"></td>
                </tr>
                <?php } ?>
<!--                <tr>
                    <td class="first">是否支持外汇:</td>
                    <td>
						<span>
							<input type="radio" name="GY_IS_FOREIGN" id="GY_IS_FOREIGN_1" value="1" <?php if(($GY_IS_FOREIGN) == "1"): ?>checked="checked"<?php endif; ?> />
							<label for="GY_MUST_LOGIN_1">是</label>
						</span>
						<span style="margin-left:15px;">
                        <input type="radio" name="GY_IS_FOREIGN" id="GY_IS_FOREIGN_0" value="0" <?php if(($GY_IS_FOREIGN) == "0"): ?>checked="checked"<?php endif; ?> />
						<label for="GY_MUST_LOGIN_0">否</label>
						</span>
						<span style="margin-left:20px;color:#ff0000;">*选择是则支持汇率计算,开启外汇功能（包括收货地址支持验证身份证）。</span>
                    </td>
                    <td class="last"></td>
                </tr>-->
                <tr>
                    <th colspan="99">网站信息设置：</th>
                </tr>
                <tr>
                    <td class="first">开启推广活动</td>
                    <td>
						<span>
							<input type="radio" name="ACTIVITY_OPEN" id="GY_IS_FOREIGN_1" value="1" <?php if(($ACTIVITY_OPEN) == "1"): ?>checked="checked"<?php endif; ?> />
							<label for="GY_MUST_LOGIN_1">是</label>
						</span>
						<span style="margin-left:15px;">
                        <input type="radio" name="ACTIVITY_OPEN" id="GY_IS_FOREIGN_0" value="0" <?php if(($ACTIVITY_OPEN) == "0"): ?>checked="checked"<?php endif; ?> />
						<label for="GY_MUST_LOGIN_0">否</label>
						</span>
						<span style="margin-left:20px;color:#ff0000;">*开关推广活动。</span>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">开始时间：</td>
                    <td>
                        <input type="text" class="large" id="ACTIVITPPROJECT_TIME" name="ACTIVITPPROJECT_TIME" value="<?php echo ($ACTIVITPPROJECT_TIME); ?>" validate="{required:true}"/>
                        <span style="margin-left:20px;color:#ff0000;">目前只针对web有效</span>
                    </td>
                </tr>
                <tr>
                    <td class="first">结束时间：</td>
                    <td>
                        <input type="text" class="large" id="ACTIVITPPROJECT_end_TIME" name="ACTIVITPPROJECT_end_TIME" value="<?php echo ($ACTIVITPPROJECT_end_TIME); ?>" validate="{required:true}"/>
                        <span style="margin-left:20px;color:#ff0000;">目前只针对web有效</span>
                    </td>
                </tr>
                <tr>
                    <td class="first">网站名称：</td>
                    <td>
                        <input type="text" class="large" name="GY_SHOP_TITLE" value="<?php echo ($GY_SHOP_TITLE); ?>" />
						<span style="margin-left:20px;color:#ff0000;">网站名称是显示在会员中心的您的网站的名称。</span>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">网站域名：</td>
                    <td>
                        <input type="text" class="large" name="GY_SHOP_HOST" value="<?php echo ($GY_SHOP_HOST); ?>" />
						<span style="margin-left:20px;color:#ff0000;">请填写可以访问的地址，http://开头,以/结尾。</span>
                    </td>
                    <td class="last"></td>
                </tr>                          
                <tr>
                    <td class="first">ICP备案号：</td>
                    <td>
                        <input type="text"  class="large" name="GY_SHOP_ICP" value="<?php echo ($GY_SHOP_ICP); ?>" />
						<span style="margin-left:20px;color:#ff0000;">
							您网站的ICP备案号。
							<a href="http://baike.baidu.com/view/67420.htm" target="_blank" title="什么是ICP备案？">什么是ICP备案号？</a>
							<a href="http://baike.baidu.com/view/439691.htm" target="_blank" title="为什么要备案？">为什么要备案？</a>
						</span>
                    </td>
                    <td class="last"></td>
                </tr>
<!--				<tr>
                    <td class="first">客服在线时间：</td>
                    <td>
                        <input type="text" class="small" name="GY_SHOP_ONLINE_START" value="<?php echo (($GY_SHOP_ONLINE_START)?($GY_SHOP_ONLINE_START):'9:00'); ?>" />
						-
						<input type="text" class="small" name="GY_SHOP_ONLINE_END" value="<?php echo (($GY_SHOP_ONLINE_END)?($GY_SHOP_ONLINE_END):'18:00'); ?>" />
                    <span style="margin-left:20px;color:#ff0000;">不填默认：9:00-18:00</span>
					</td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">APP客服电话：</td>
                    <td>
                        <input type="text" class="phone" name="GY_SHOP_SERVER_PHONE" value="<?php echo ($GY_SHOP_SERVER_PHONE); ?>" validate="{required:true}"/>
                        <span style="margin-left:20px;color:#ff0000;">目前只针对APP有效 400-032-0608 /021-58390211</span>
                    </td>
                </tr>
                <tr>
                    <td class="first">店铺LOGO：</td>
                    <td>
						<a href="javascript:upImage(0);" class="btnG ico_upload">上传图片</a>
                        <img width="50px" height="50px" src="<?php echo ($GY_SHOP_LOGO); ?>" id="SHOW_SHOP_LOGO_0">
                        &nbsp;
						<?php if($GY_SHOP_LOGO != '' ): ?>&nbsp;<a id="delPic" url="<?php echo U('Admin/Home/delLogoPic');?>" >删除</a><?php endif; ?>
                        <input type="hidden" id="GY_SHOP_LOGO_0" name="GY_SHOP_LOGO_0" value="<?php echo ($GY_SHOP_LOGO); ?>"/>
						<span style="margin-left:20px;color:#ff0000;">建议您上传符合您网站尺寸的图片</span>
					</td>
                    <td class="last"></td>
                </tr>
				<tr>
                    <td class="first">微商城LOGO：</td>
                    <td>
						<a href="javascript:upImage(1);" class="btnG ico_upload">上传图片</a>
                        <img width="50px" height="50px" src="<?php echo ($GY_WAP_LOGO); ?>" id="SHOW_SHOP_LOGO_1">
                        &nbsp;
						<?php if($GY_WAP_LOGO != '' ): ?>&nbsp;<a id="delWapPic" url="<?php echo U('Admin/Home/delWapPic');?>" >删除</a><?php endif; ?>
                        <input type="hidden" id="GY_SHOP_LOGO_1" name="GY_SHOP_LOGO_1" value="<?php echo ($GY_WAP_LOGO); ?>"/>
						<span style="margin-left:20px;color:#ff0000;">建议您上传符合您网站尺寸的图片</span>
					</td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">店铺二维码LOGO：</td>
                    <td>
                        <img width="100px" height="100px" src="<?php echo ($GY_SHOP_QC_LOGO); ?>" id="showQrPic" >
                        &nbsp;
						<?php if(!empty($GY_SHOP_QC_LOGO)){ ?>
						&nbsp;<a id="delQrPic" url="<?php echo U('Admin/Home/delQrPic');?>" >删除</a>
						<?php } ?>
						<span style="margin-left:20px;color:#ff0000;">删除之后访问页面重新生成</span>
					</td>
                    <td class="last"></td>
                </tr>				-->
                <!-- 
                 <tr>
                    <td class="first">网站统计代码:</td>
                    <td>
						<textarea name="GY_SHOP_CODE" style="width:300px;height:100px;text-align:left;"><?php echo ($GY_SHOP_CODE); ?></textarea>
						<span style="margin-left:20px;color:#ff0000;">
							您的网站统计代码。
							<a href="http://baike.baidu.com/view/3117940.htm" target="_blank" title="什么是网站统计？">什么是网站统计？</a>
						</span>
                    </td>
                    <td class="last"></td>
                </tr>
                 -->
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="99">
                        <input type="submit" value="保 存" class="btnA" >
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>
<script>
    /**
 * 时间日期控件
 * @author zuo <zuojianghua@guanyisoft.com>
 * @date 2013-01-07
 */
$(document).ready(function(){
    $("#ACTIVITPPROJECT_TIME").datetimepicker({
         dateFormat:'yy-mm-dd',
         showSecond: true, //显示秒
         timeFormat: 'HH:mm:ss',//格式化时间
         stepHour: 1,//设置步长
         stepMinute: 1,
         stepSecond: 1
        });
    $("#ACTIVITPPROJECT_end_TIME").datetimepicker({
//            showMonthAfterYear: true,
//            changeMonth: true,
//            changeYear: true,
//            showSecond: true, //显示秒
//            buttonImageOnly: true
            dateFormat:'yy-mm-dd',
            showSecond: true, //显示秒
            timeFormat: 'HH:mm:ss',//格式化时间
            stepHour: 1,//设置步长
            stepMinute: 1,
            stepSecond: 1
        });
});  

</script>
<script type="text/javascript">
$("#delPic").click(function(){
    var url = $(this).attr("url");
   $.ajax({
       url:url,
       cache:false,
       dataType:'json',
       type:'POST',
       success:function(msgObj){
		$("#SHOW_SHOP_LOGO_0").css("display","none");
		$("#delPic").css("display","none");					
       },
       error:function(msgObj){
   		alert('删除失败');		
       }
       });
});
$("#delWapPic").click(function(){
    var url = $(this).attr("url");
   $.ajax({
       url:url,
       cache:false,
       dataType:'json',
       type:'POST',
       success:function(msgObj){	
		$("#SHOW_SHOP_LOGO_1").css("display","none");	
		$("#delWapPic").css("display","none");					
       },
       error:function(msgObj){
   		alert('删除失败');		
       }
       });
});
$("#delQrPic").click(function(){
    var url = $(this).attr("url");
   $.ajax({
       url:url,
       cache:false,
       dataType:'json',
       type:'POST',
       success:function(msgObj){
		$("#showQrPic").css("display","none");	
		$("#delQrPic").css("display","none");					
       },
       error:function(msgObj){
   		alert('删除失败');		
       }
       });
});
</script>
<script type="text/javascript">
    var dialog;
	var image_input_id;
    var editor = new UE.ui.Editor({
        imageRealPath:"editor"
    });
    editor.render("myEditor");
    editor.ready(function(){
        editor.hide()
        dialog = editor.getDialog("insertimage");
        editor.addListener('beforeInsertImage',function(t, arg){
			image_input_id = image_input_id-1;
            for(index in arg){
				if(typeof arg[index]['src']=='undefined')  continue;
				image_input_id = image_input_id + 1;
				console.log(image_input_id)
				if($("#GY_SHOP_LOGO_" + image_input_id)){
					var image_path = arg[index]['src'];
					$("#GY_SHOP_LOGO_" + image_input_id).val(image_path);
					$("#SHOW_SHOP_LOGO_" + image_input_id).attr({src:image_path});
				}
            }
			
        });
    });
    
    function upImage(imageId) {
		image_input_id = imageId;
        dialog.open();
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