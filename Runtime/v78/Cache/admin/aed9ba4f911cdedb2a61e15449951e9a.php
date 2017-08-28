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
                <div class="rightInner">
<form action="<?php echo U('Admin/Images/itemImageConfig');?>" method="POST" enctype="multipart/form-data">
	<table width="100%" class="tbForm">
		<thead>
			<tr class="title">
				<th colspan="2">商品详情页显示设置</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td class="first">温馨提醒默认显示设置：</td>
			<td class="left">
				<textarea name="ITEM_IMAGE_CONFIG[TIPS]" class="large"><?php echo ($config_info["TIPS"]); ?></textarea>
				<span>显示在商品详情页的温馨提醒，如果商品资料上没有设置，则使用此处默认值。</span>
			</td>
		</tr>
        <tr>
			<td class="first">详情页显示购买价：</td>
			<td class="left">
                <input type="radio" name="ITEM_IMAGE_CONFIG[BUY_PRICE]" value="1" <?php if($config_info["BUY_PRICE"] == 1): ?>checked<?php endif; ?>/>是
                <input type="radio" name="ITEM_IMAGE_CONFIG[BUY_PRICE]" value="0" <?php if($config_info["BUY_PRICE"] == 0): ?>checked<?php endif; ?>/>否
                &nbsp;<span>商品详情页成交记录中的购买价是否显示。</span>
			</td>
		</tr>
		<!--
		<tr>
			<td class="first">是否开启：</td>
			<td style="text-align:left;">
				<span>
					<input type="radio" value="0" name="ITEM_IMAGE_CONFIG[WATER_SWITCH]" class="WATER_SWITCH" id="WATER_SWITCH_0" <?php if($config_info["WATER_SWITCH"] == 0): ?>checked<?php endif; ?>>
					<label for="WATER_SWITCH_0">关闭</label>
				</span>
				<span>
					<input type="radio" value="1" name="ITEM_IMAGE_CONFIG[WATER_SWITCH]" class="WATER_SWITCH" id="WATER_SWITCH_1" <?php if($config_info["WATER_SWITCH"] == 1): ?>checked<?php endif; ?>>
					<label for="WATER_SWITCH_1">开启图片水印</label>
				</span>
				<span>
					<input type="radio" value="2" name="ITEM_IMAGE_CONFIG[WATER_SWITCH]" class="WATER_SWITCH" id="WATER_SWITCH_2" <?php if($config_info["WATER_SWITCH"] == 1): ?>checked<?php endif; ?>>
					<label for="WATER_SWITCH_2">开启文字水印</label>
				</span>
			</td>
		</tr>
		<tr <?php if($config_info["WATER_SWITCH"] == 0): ?>style="display:none;"<?php endif; ?>>
			<td class="first">水印位置：</td>
			<td style="text-align:left;">
				<table class="water_area">
					<tr>
						<td>
							<input type="radio" value="TOP_LEFT" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="TOP_LEFT" <?php if($config_info["WATER_LOCATE"] == 'TOP_LEFT'): ?>checked<?php endif; ?>>
							<label for="TOP_LEFT">顶部居左</label>
						</td>
						<td>
							<input type="radio" value="TOP_CENTER" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="TOP_CENTER" <?php if($config_info["WATER_LOCATE"] == 'TOP_CENTER'): ?>checked<?php endif; ?>>
							<label for="TOP_CENTER">顶部居中</label>
						</td>
						<td>
							<input type="radio" value="TOP_RIGHT" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="TOP_RIGHT" <?php if($config_info["WATER_LOCATE"] == 'TOP_RIGHT'): ?>checked<?php endif; ?>>
							<label for="TOP_RIGHT">顶部居右</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="radio" value="MIDDLE_LEFT" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="MIDDLE_LEFT" <?php if($config_info["WATER_LOCATE"] == 'MIDDLE_LEFT'): ?>checked<?php endif; ?>>
							<label for="MIDDLE_LEFT">中部居左</label>
						</td>
						<td>
							<input type="radio" value="MIDDLE_CENTER" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="MIDDLE_CENTER" <?php if($config_info["WATER_LOCATE"] == 'MIDDLE_CENTER'): ?>checked<?php endif; ?>>
							<label for="MIDDLE_CENTER">中部居中</label>
						</td>
						<td>
							<input type="radio" value="MIDDLE_RIGHT" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="MIDDLE_RIGHT" <?php if($config_info["WATER_LOCATE"] == 'MIDDLE_RIGHT'): ?>checked<?php endif; ?>>
							<label for="MIDDLE_RIGHT">中部居右</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="radio" value="BOTTOM_LEFT" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="BOTTOM_LEFT" <?php if($config_info["WATER_LOCATE"] == 'BOTTOM_LEFT'): ?>checked<?php endif; ?>>
							<label for="BOTTOM_LEFT">底部居左</label>
						</td>
						<td>
							<input type="radio" value="BOTTOM_CENTER" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="BOTTOM_CENTER" <?php if($config_info["WATER_LOCATE"] == 'BOTTOM_CENTER'): ?>checked<?php endif; ?>>
							<label for="BOTTOM_CENTER">底部居中</label>
						</td>
						<td>
							<input type="radio" value="BOTTOM_RIGHT" name="ITEM_IMAGE_CONFIG[WATER_LOCATE]" id="BOTTOM_RIGHT" <?php if($config_info["WATER_LOCATE"] == 'BOTTOM_RIGHT'): ?>checked<?php endif; ?>>
							<label for="BOTTOM_RIGHT">底部居右</label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		-->
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2">
					<input type="hidden" name="dosubmit" value="1" />
					<button type="submit" class="btnA">保存</button>
				</td>
			</tr>
		</tfoot>
	</table>
</form>
<div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){});
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