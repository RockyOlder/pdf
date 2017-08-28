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
							<a href="<?php echo U('Admin/Seo/deleteMemcache');?>" style="float:right;color:#fff;">清空缓存</a>
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
    <form id="spec_form" name="spec_form" method="post" action="<?php echo U('Admin/GoodsProperty/doAddSpec');?>">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">商品属性添加</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first">属性名称：</td>
                    <td>
                        <input type="text" name="spec[gs_name]" id="gs_name" class="medium" value="" /> <br> 
                    </td>                    
                     <td class="last">请输入属性名称，同一商品类型下，不能出现相同名称的商品属性。</td>
                </tr>
				<tr>
                    <td class="first">所属商品类型：</td>
                    <td>
						<?php if(is_array($array_type_info)): $i = 0; $__LIST__ = $array_type_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><span style="margin-right:15px;">
							<input type="checkbox" name="gt_id[]" id="goods_type_id<?php echo ($type["gt_id"]); ?>" value="<?php echo ($type["gt_id"]); ?>" <?php if($type["gt_id"] == $int_gt_id): ?>checked="checked"<?php endif; ?> style="vertical-align:middle;" />
							<label for="goods_type_id<?php echo ($type["gt_id"]); ?>" style="vertical-align:middle;"><?php echo ($type["gt_name"]); ?></label>
						</span><?php endforeach; endif; else: echo "" ;endif; ?>
					</td>                    
                     <td class="last"></td>
                </tr>
				<tr>
                    <td class="first">排序：</td>
                    <td>
						<input type="text" name="spec[gs_order]" class="medium" value="0" />
					</td>                    
                    <td class="last">请填入一个数字，数字越小越靠前。</td>
                </tr>
				<?php if($int_gt_type != 1): ?><tr>
                    <td class="first">是否是销售属性：</td>
                    <td>
                        <input type="checkbox" id="gs_is_sale_spec" name="spec[gs_is_sale_spec]" value="1" />
                    </td>
					<td class="last">勾选表示此属性是销售属性！</td>
                </tr><?php endif; ?>
                <tr>
                    <td class="first">属性值录入方式：</td>
                    <td>
                        <input type="radio" name="spec[gs_input_type]" value="1" checked="checked" id="gs_input_type_1" />
						<label for="gs_input_type_1" title="单行文本框">手工录入</label>
						<input type="radio" name="spec[gs_input_type]" value="2" id="gs_input_type_2" />
						<label for="gs_input_type_2" title="设置商品属性时显示为下拉选框">从下面的列表中选择</label>
						<input type="radio" name="spec[gs_input_type]" value="3" id="gs_input_type_3" />
						<label for="gs_input_type_3" title="适合以一段文字的形式描述商品的某个属性">多行文本框</label>
						<?php if($int_gt_type == 1): ?><input type="radio" name="spec[gs_input_type]" value="4" id="gs_input_type_4" />
						<label for="gs_input_type_4" title="以评分的形式提现">评分</label><?php endif; ?>
                    </td>
                    <td class="last"></td>
                </tr>
				<tr id="good_spec_value_select_2" style="display:none;">
					<td class="first">可选值列表：</td>
                    <td>
                        <textarea name="spec_values" style="width:400px;height:140px;"></textarea>
                    </td>
					<td class="last" style="color:#ff0000;">*多个属性值以换行分隔，属性值在此属性中必须唯一！</td>
				</tr>
				<tr style="border:1px solid #ff0000;" title="此项只是演示，添加属性时不需要处理此字段。">
                    <td class="first">属性值的录入展示形式：</td>
                    <td id="good_spec_style">
                        <input type="text" name="" class="medium" id="input_style_1" value="请填入属性值......" readonly="readonly" />
                        <select name="" id="input_style_2" readonly="readonly" style="display:none;">
							<option value="xxx" disabled="disabled">以服装尺码为例：SL码</option>
							<option value="xxx" disabled="disabled">以服装尺码为例：L码</option>
							<option value="xxx" disabled="disabled">以服装尺码为例：XL码</option>
							<option value="xxx" disabled="disabled">以服装尺码为例：XXL码</option>
						</select>
                        <textarea name="" id="input_style_3" style="display:none;width:300px;height:60px;" readonly="readonly">请填入属性值......</textarea>
                    </td>
					<td class="last" style="color:#ff0000;">*添加或者修改商品时，此属性值的录入方式将以左侧显示的方式呈现，演示而已不用做处理。</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="99">
						<input type="hidden" name="dosubmit" value="1" /> 
						<input type="hidden" name="jump" id="pageJumpType" value="1" /> 
                        <input type="submit" value="保 存" jump="0" class="btnA" />
                        <input type="submit" value="添加同类属性" jump="1" class="btnA" />
                        <input type="button" value="取 消" onClick="onUrl('/Admin/GoodsType/pageList');" class="btnA" >
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("input[type='submit']").click(function(){
		$("#pageJumpType").val($(this).attr("jump"));
	});
	//表单验证
	$("#spec_form").validate();
	//是否是销售属性
	$("#gs_is_sale_spec").click(function(){
		if(this.checked){
			$("#gs_input_type_1,#gs_input_type_3").attr({'disabled':'disabled'});
			$("#gs_input_type_2").attr({"checked":"checked"});
			$("#input_style_1,#input_style_3").hide();
			$("#input_style_2,#good_spec_value_select_2").show();
		}else{
			$("#gs_input_type_1,#gs_input_type_2,#gs_input_type_3").removeAttr('disabled');
		}
	});
	//显示方式切换
	$("#gs_input_type_1,#gs_input_type_2,#gs_input_type_3,#gs_input_type_4").click(function(){
		if(this.checked){
			var value= $(this).val();
			$("#input_style_1,#input_style_2,#input_style_3,#good_spec_value_select_2").hide();
			$("#input_style_" + value + ',#good_spec_value_select_' + value).show();
			
		}
	});
});
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
        <script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script>
    </body>
</html>