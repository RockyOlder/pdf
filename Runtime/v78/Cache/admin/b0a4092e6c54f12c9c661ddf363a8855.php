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
                <p class="tabListP">
	<span value_id="1" class="form_add_products_labels onHover">
		<a href="javascript:void(0);" style="text-decoration: none;">商品基本信息</a>
	</span>
	<span value_id="2" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">商品分类</a>
	</span>
	<span value_id="3" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">商品图片</a>
	</span>
	<span value_id="4" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">详细描述</a>
	</span>
	<span value_id="5" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">其他信息</a>
	</span>
	<span value_id="6" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">关联商品</a>
	</span>
	<span value_id="7" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">手机端描述</a>
	</span>
</p>
<form action="<?php echo U('Admin/Goods/doGoodsEdit');?>" method="POST" id="goodForm" onsubmit="return javascriptCheckBeforeSubmit();" >
<input type="hidden" name="goods[g_id]" value="<?php echo ($goods["g_id"]); ?>" />
<div class="rightInner"><!--rightInner  start-->
	<div id="con_addGoods_1" class="adCon"><!--商品基本信息  开始-->
		<table class="tbForm" width="100%">
			<tbody>
				<tr>
					<td class="first">商品名称：</td>
					<td>
						<input type="text" name="goods_info[g_name]" id="g_name" value="<?php echo ($goods_info["g_name"]); ?>" class="large" maxlength="30"/>
						<font style="color:#ff0000;">*</font>
						<span class="g_name" style="color:#ff0000;"></span>
						<br />
						<span style="color:gray;">最多输入<font id="input_text_nums" style="color:green;font-weight:900;">30</font>汉字(淘宝标题字数限制)。</span>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">商品编码：</td>
					<td>
						<input type="text" name="goods_info[g_sn]" value="<?php echo ($goods["g_sn"]); ?>" id="g_sn" old_goods_sn="<?php echo ($goods["g_sn"]); ?>" class="large" maxlength="100" />
						<span style="color:#ff0000;">*</span>
						<span class="g_sn" style="color:#ff0000;"></span>
						<br />
						<span style="color:gray;">字母、数字或“_”、“-”、“.”、“/”、“\”组成。</span>
					</td>
					<td></td>
				</tr>
                <tr>
                    <td class="first">排序：</td>
                    <td>
                        <input type="number" name="goods[g_order]" id="g_order" value="<?php echo ($goods["g_order"]); ?>" class="small" maxlength="30" min="0"/>
                        <em>排序越大越靠前</em>
                    </td>
                    <td></td>
                </tr>
				<tr>
					<td class="first">品牌：</td>
					<td>
						<select name="goods[gb_id]" class="medium">
							<option value="0">--请选择商品品牌--</option>
							<?php if(is_array($array_brand)): $i = 0; $__LIST__ = $array_brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["gb_id"] == $goods[gb_id]): ?><option value="<?php echo ($vo["gb_id"]); ?>" selected="selected"><?php echo ($vo["gb_name"]); ?></option>
							<?php else: ?>
							<option value="<?php echo ($vo["gb_id"]); ?>"><?php echo ($vo["gb_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">是否上架：</td>
					<td>
						<input type="radio" name="goods[g_on_sale]" <?php if($goods["g_on_sale"] == 1): ?>checked="checked"<?php endif; ?> value="1" id="goods_g_on_sale_1" />
						<label for="goods_g_on_sale_1" style="cursor:pointer;">是</label>
						<input type="radio" name="goods[g_on_sale]" <?php if($goods["g_on_sale"] == 2): ?>checked="checked"<?php endif; ?> value="2" id="goods_g_on_sale_2" style="margin-left:30px;" />
						<label for="goods_g_on_sale_2" style="cursor:pointer;">否</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">计量单位：</td>
					<td><input type="text" name="goods_info[g_unit]" value="<?php echo ($goods_info["g_unit"]); ?>" class="small" /></td>
					<td></td>
				</tr>
				<?php if(($GY_IS_FOREIGN["sc_value"]) == "1"): ?><tr>
						<td class="first">贸易类型：</td>
						<td>
							<select id="goods_trade_type_select" name="goods_info[trade_type]" class="medium" onchange= "trade_type(this)" >
								<option value="0" <?php if($goods_info["g_tax_rate"] == '0'): ?>selected="selected"<?php endif; ?>>--正常贸易--</option>
								<option value="1" <?php if($goods_info["g_tax_rate"] != '0'): ?>selected="selected"<?php endif; ?>>--跨境贸易--</option>
							</select>
						</td>
						<td></td>
					</tr>
					<tr id="g_tax_rate_tr" <?php if($goods_info["g_tax_rate"] == '0'): ?>style="display:none;"<?php endif; ?>>
						<td class="first">税率：</td>
						<td>
							<input type="text" name="goods_info[g_tax_rate]" id="g_tax_rate" value="<?php echo ($goods_info["g_tax_rate"]); ?>" class="small" />
							<span style="color:#ff0000;">*</span>
							<span class="g_tax_rate" style="color:#ff0000;"></span>
							<br />
							<span style="color:gray;">例如 10% 输入 0.1 </span>
						</td>
						<td></td>
					</tr><?php endif; ?>
				<!-- 商品不同行业自定义字段加载  开始 -->
				<?php if(is_array($industry_filed_config)): $i = 0; $__LIST__ = $industry_filed_config;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?><tr>
	<td class="first"><?php echo ($field["label"]); ?>：</td>
	<td>
	<?php switch($field["type"]): case "radio": if(is_array($field["options"])): foreach($field["options"] as $option_key=>$option): ?><span style="margin-left:10px;">
			<input type="radio" name="goods[<?php echo ($key); ?>]" value="<?php echo ($option["value"]); ?>" <?php if($goods[$key] == $option['value']): ?>checked="checked"<?php endif; ?> id="<?php echo ($key); ?>_<?php echo ($option['value']); ?>" />
			<label for="<?php echo ($key); ?>_<?php echo ($option['value']); ?>"><?php echo ($option["label"]); ?></label>
			</span><?php endforeach; endif; break;?>
		<?php case "input": ?><input type="text" name="goods[<?php echo ($key); ?>]" value="<?php echo ($goods[$key]); ?>" class="medinum" /><?php break;?>
		<?php case "select": ?><select name="goods[<?php echo ($key); ?>]">
				<?php if(is_array($field["options"])): foreach($field["options"] as $option_key=>$option): ?><option value="<?php echo ($option["value"]); ?>" <?php if($goods[$key] == $option['value']): ?>selected<?php endif; ?>><?php echo ($option["label"]); ?></option><?php endforeach; endif; ?>
			</select><?php break;?>
		<?php case "textarea": ?><textarea name="goods[<?php echo ($key); ?>]" class="medinum" ><?php echo ($goods[$key]); ?></textarea><?php break; endswitch;?>
	</td>
	<td></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<!-- 商品不同行业自定义字段加载  结束 -->
				<tr>
					<td class="first">商品类型：</td>
					<td>
						<select class="medium" id="goods_type_select">
							<option value="0" disabled="disabled">--请选择商品类型--</option>
							<?php if(is_array($array_type)): $i = 0; $__LIST__ = $array_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["gt_id"] == $goods[gt_id]): ?><option value="<?php echo ($vo["gt_id"]); ?>" selected="selected"><?php echo ($vo["gt_name"]); ?></option>
							<?php else: ?>
							<option value="<?php echo ($vo["gt_id"]); ?>" disabled="disabled"><?php echo ($vo["gt_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<span style="color:#ff0000;">*</span>
						<br />
						<span style="color:gray;">
							选择商品类型以后，您可以进一步编辑商品属性和规格。
						</span>
					</td>
					<td></td>
				</tr>
				<!-- 商品扩展属性输入位置开始 -->
				<tr id="tbody_goods_spec_area_tr">
					<td class="first">商品扩展属性：</td>
					<td id="tbody_goods_spec_area" class="ajax_show_area" colspan="2">
						<table>
<tbody>
<?php if(!empty($array_spec_info)): if(is_array($array_spec_info)): $i = 0; $__LIST__ = $array_spec_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		<td style="width:100px;text-align:right;padding-right:3px;"><?php echo ($vo["gs_name"]); ?>：</td>
		<td>
		<?php if($vo["gs_input_type"] == 1): ?><input type="text" class="large" name="goods_unsales_spec[<?php echo ($vo["gs_id"]); ?>]" value="<?php echo ($vo["gsd_aliases"]); ?>" />
		<?php elseif($vo["gs_input_type"] == 2): ?>
		<select class="medium" name="goods_unsales_spec[<?php echo ($vo["gs_id"]); ?>]" style="width:auto;">
			<option value="0" >请选择<?php echo ($vo["gs_name"]); ?>的属性值</option>
			<?php if(is_array($vo[spec_detail])): $i = 0; $__LIST__ = $vo[spec_detail];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sp): $mod = ($i % 2 );++$i; if($vo['gsd_id'] == $sp['gsd_id']): ?><option value="<?php echo ($sp["gsd_id"]); ?>" selected="selected" ><?php echo ($sp["gsd_value"]); ?></option>
				<?php else: ?>
					<option value="<?php echo ($sp["gsd_id"]); ?>" ><?php echo ($sp["gsd_value"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</select>
		<?php elseif($vo["gs_input_type"] == 3): ?>
		<textarea name="goods_unsales_spec[<?php echo ($vo["gs_id"]); ?>]" class="mediumBox"><?php echo ($vo["gsd_aliases"]); ?></textarea><?php endif; ?>
		</td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
<?php else: ?>
	<tr>
		<td colspan="2" style="text-align:left;padding-left:30px;color:#ff0000;">
			该商品类型下暂无扩展属性需要录入。如需录入，请先转到
			<a href="<?php echo U('Admin/GoodsType/pageList');?>" title="点击转到类型列表。" onclick="if(!confirm('确定要去录入属性吗？\n您之前录入的数据比如商品名称可能丢失！')){return false;}">类型列表</a>
			，添加相应的属性。
		</td>
	</tr><?php endif; ?>
	<!-- 启用规格 按钮 开始 -->
	<tr>
		<td colspan="2" style="text-align:left;padding-left:30px;">
            <?php if($enable != 0): else: ?>
			<button type="button" id="enable_goods_skus" enable="<?php echo ($enable); ?>" class="btnA">
                启用规格
			</button><?php endif; ?>
		</td>
	</tr>
	<!-- 启用规格 按钮 结束 -->
</tbody>
</table>
<script type="text/javascript">
$(document).ready(function(){
	//启用规格按钮被点击以后，异步加载商品销售属性的表单
	$("#enable_goods_skus").click(function(){
		var enable = parseInt($(this).attr("enable"));
		if(1 == enable && confirm("确定要取消规格吗？")){
			$(this).attr({"enable":0}).html("开启规格");
			$("#select_goods_sales_spec_box,#goods_sku_list_form").hide();
			$(".disabled_goods_sale_spec_info").show();
			return false;
		}
		$(this).attr({"enable":1}).html("取消规格");
		$("#select_goods_sales_spec_box,#goods_sku_list_form").show();
		$(".disabled_goods_sale_spec_info").hide();
	});
});
</script>
					</td>
				</tr>
				<!-- 商品扩展属性输入位置结束 -->
				
				<!-- 商品销售属性选择区域开始 -->
				<tr id="select_goods_sales_spec_box" <?php if($enabled_spec == ''): ?>style="display:none"<?php endif; ?>>
					<td class="first">商品销售属性：</td>
					<td id="goods_sales_spec_select_area" class="ajax_show_area" colspan="2">
						<table>
	<tbody>
		<?php if(is_array($array_sale_spec)): $i = 0; $__LIST__ = $array_sale_spec;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td style="width:60px;text-align:right;" class="spec_value_list_pname" valign="top"><?php echo ($vo["gs_name"]); ?>：</td>
			<td>
				<ul class="sku-box">
					<?php if(is_array($vo[spec_detail])): $i = 0; $__LIST__ = $vo[spec_detail];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec): $mod = ($i % 2 );++$i;?><li>
						<input type="checkbox" name="related_goods_spec[<?php echo ($spec["gs_id"]); ?>][]" <?php if($spec["checked"] == 1): ?>checked="checked"<?php endif; ?> class="checkbox sale_spec_detail" id="spec_<?php echo ($spec["gs_id"]); ?>_<?php echo ($spec["gsd_id"]); ?>" value="<?php echo ($spec["gsd_id"]); ?>" pid="<?php echo ($spec["gs_id"]); ?>" vid="<?php echo ($spec["gsd_id"]); ?>"/>
						<label for="spec_<?php echo ($spec["gs_id"]); ?>_<?php echo ($spec["gsd_id"]); ?>" style="cursor:pointer;">
						<?php if($spec["gs_id"] == 888): ?><span style="background-color:#<?php echo ($spec["gsd_rgb_value"]); ?>;color:#<?php echo ($spec["gsd_rgb_value"]); ?>;width:14px;height:14px;border:1px solid #000000;">&nbsp;&nbsp;&nbsp;</span><?php endif; ?>
						</label>
						<input type="text" name="spec_value[<?php echo ($spec["gsd_id"]); ?>]" value="<?php echo ($spec["gsd_value"]); ?>" pid="<?php echo ($spec["gs_id"]); ?>" vid="<?php echo ($spec["gsd_id"]); ?>" val="<?php echo ($spec["gsd_value"]); ?>" class="spec_input" />
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
			<td style="width:60px;text-align:right;"></td>
			<td>
				<?php if($enable == 1): ?><button type="button" onclick="javascript:createProductListForm(this);" click_num="0" class="btnA">重新生成</button>
				<?php else: ?>
				<button type="button" onclick="javascript:createProductListForm(this);" click_num="0" class="btnA">生成规格</button><?php endif; ?>
				<span id="createMessageBox" style="color:#ff0000;"></span>
				<br />
				<span style="color:#ff0000;">注意：重新生成规格以后，如果商品编码发生变化，可能会导致已下单商品无法发货！<br />最少起拍数默认为0表示不限数量!</span>
			</td>
		</tr>
		<tr>
			<td class="first">批量设置价格：</td>
			<td>
				<a href="javascript:void(0);" class="btnA" id="batchSetPrice">批量设置价格</a>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>
<!--批量设置销售价格-->
<div id="goodsSetPriceBatch" style="display: none;text-align:center;" title="批量设置销售价">
    <table style="border:1px solid gray;margin-left:auto;margin-right:auto;">
    	<thead style="border:1px solid gray;text-align:center;">
    		<tr style="border:1px solid gray;text-align:center;">
    			<td style="border:1px solid gray;" width="150px;">销售价</td>
				<td style="border:1px solid gray;" width="150px;">成本价</td>
				<td style="border:1px solid gray;" width="150px;">市场价</td>
				<td style="border:1px solid gray;" width="150px;">重量</td>
				<td style="border:1px solid gray;" width="150px;">最少起拍数</td>
    		</tr>
    	</thead>
    	<tbody>
    		<tr style="border:1px solid gray;">
    			<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_sale_price" value="" id="pdt_set_sale_price" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_cost_price" value="" id="pdt_set_cost_price" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_market_price" value="" id="pdt_set_market_price" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_weight" value="" id="pdt_set_weight" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_least" value="" id="pdt_set_least" class="small" />
				</td>
    		</tr>
    	</tbody>
    </table>
</div>
<script type="text/javascript">
function checkPrice(price){
	if(price.val() != '' && isNaN(price.val())){
		showAlert(false,'请正确填写');return false;
	}
}
$(document).ready(function(){
	// 批量设置销售价格
	$('#batchSetPrice').bind({'click':function(){
		// 初始化价格
		$('#pdt_set_sale_price').val('');
		$('#pdt_set_cost_price').val('');
		$('#pdt_set_market_price').val('');
		$('#pdt_set_weight').val('');
		$('#pdt_set_least').val('');

		$('#goodsSetPriceBatch').dialog({
			resizable:false,
			autoOpen: false,
			modal: true,
			width: 'auto',
			// position: [220,85],
			buttons: {
				'确认': function() {
					var pdt_set_sale_price   = $('#pdt_set_sale_price');
					var pdt_set_cost_price   = $('#pdt_set_cost_price');
					var pdt_set_market_price = $('#pdt_set_market_price');
					var pdt_set_weight       = $('#pdt_set_weight');
					var pdt_set_least        = $('#pdt_set_least');
					if(false === checkPrice(pdt_set_sale_price)){
						return false;
					}
					if(false === checkPrice(pdt_set_cost_price)){
						return false;
					}
					if(false === checkPrice(pdt_set_market_price)){
						return false;
					}
					if(false === checkPrice(pdt_set_weight)){
						return false;
					}
					if(false === checkPrice(pdt_set_least)){
						return false;
					}
					if(pdt_set_weight.val() != '' && pdt_set_weight.val() != undefined){
						$('.pdt_weight').each(function(){
							$(this).val(pdt_set_weight.val());
						});
					}
					if(pdt_set_sale_price.val() != '' && pdt_set_sale_price.val() != undefined){
						$('.pdt_sale_price').each(function(){
							$(this).val(pdt_set_sale_price.val());
						});
					}
					if(pdt_set_cost_price.val() != '' && pdt_set_cost_price.val() != undefined){
						$('.pdt_cost_price').each(function(){
							$(this).val(pdt_set_cost_price.val());
						});
					}
					if(pdt_set_market_price.val() != '' && pdt_set_market_price.val() != undefined){
						$('.pdt_market_price').each(function(){
							$(this).val(pdt_set_market_price.val());
						});
					}
					if(pdt_set_least.val() != '' && pdt_set_least.val() != undefined){
						$('.pdt_min_num').each(function(){
							$(this).val(pdt_set_least.val());
						});
					}
					$(this).dialog( "close" );
					return false;
				},
				'关闭': function() {
					if(confirm('确定不设置!')){
						// $('#pdt_set_sale_price').val('');
						// $('#pdt_price_down').val('');
						$(this).dialog( "close" );
						return false;
					}
				}
			}
		});
		$('#goodsSetPriceBatch').dialog('open');
	}});
	$(".spec_input").focus(function(){
		$(this).addClass("spec_input_border").parent("li").children("input").attr({checked:true});
	});
	$(".spec_input").change(function(){
		if("" == $(this).val()){
			$(this).val($(this).attr("val"));
		}
		$(".sku_list_spec_" + $(this).attr("vid")).html($(this).val());
	});
});
</script>
					</td>
				</tr>
				<!-- 商品销售属性选择区域结束 -->
				
				<!-- 商品SKU list 开始 -->
				<tr class="add_goods_sku_list" <?php if($enabled_spec == ''): ?>style="display:none;"<?php endif; ?>>
					<td class="first"></td>
					<td colspan="2" id="goods_sku_list_form" class="ajax_show_area">
					<?php if($enabled_spec != ''): ?><table class="tbList" width="100%">
	<thead>
		<tr>
			<th style="text-align:center;">商品编码</th>
			<?php if(is_array($array_spec)): $i = 0; $__LIST__ = $array_spec;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec): $mod = ($i % 2 );++$i;?><th style="text-align:center;" class="goods-sale-spec-colspan" pid="<?php echo ($spec["gs_id"]); ?>"><?php echo ($spec["gs_name"]); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
			<th style="text-align:center;">库存</th>
			<th style="text-align:center;">销售价</th>
			<th style="text-align:center;">成本价</th>
			<th style="text-align:center;">市场价</th>
			<th style="text-align:center;">重量</th>
			<th style="text-align:center;">最少起拍数</th>
			<th style="text-align:center;">商品备注</th>
			<th style="text-align:center;">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php if(is_array($product_list)): $i = 0; $__LIST__ = $product_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sku): $mod = ($i % 2 );++$i;?><tr class="sku-list-info-rows">
			<td>
				<input type="text" name="goods_products[pdt_sn][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["pdt_sn"]); ?>" old_pdt_sn="<?php echo ($sku["pdt_sn"]); ?>" class="small sku_info pdt_sn" style="width:100px;"/>
				<input type="hidden" name="goods_products[spec_vids][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["spec_pidvid"]); ?>" class="spec_vids" />
			</td>
			<?php if(is_array($sku['spec_info'])): $i = 0; $__LIST__ = $sku['spec_info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><td class="goods-sale-spec-value-colspan" pid="<?php echo ($v["gs_id"]); ?>" <?php if($v["gs_id"] == 888): ?>style="text-align:left;"<?php endif; ?>>
				<?php if($v["gs_id"] == 888): ?><span style="background-color:#<?php echo ($v["gsd_rgb_value"]); ?>;color:#<?php echo ($v["gsd_rgb_value"]); ?>;width:14px;height:14px;border:1px solid #000000;">&nbsp;&nbsp;&nbsp;</span><?php endif; ?>
				<span class="sku_list_spec_<?php echo ($v["gsd_id"]); ?>"><?php echo ($v["gsd_aliases"]); ?></span>
				<!--
				<?php if($v["gs_id"] == 888): ?><input type="text" name="related_goods_spec[rgs_picture][<?php echo ($v["gsd_id"]); ?>]" value="" class="input40" />
				<a href="javascript:void(0);" style="font-size:12px;">上传图片</a><?php endif; ?>
				-->
			</td><?php endforeach; endif; else: echo "" ;endif; ?>
			<td class="sku-list-stock-td"><?php echo ($sku["pdt_total_stock"]); ?></td>
			<td>
				<input type="text" name="goods_products[pdt_sale_price][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["pdt_sale_price"]); ?>" class="input40 sku_info pdt_sale_price" />
				<input type="hidden" name="goods_products[member_level_price][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["member_level_price"]); ?>" class="pdt_fixed_member_price" />
				<input type="hidden" name="goods_products[up_price][<?php echo ($sku["pdt_sn"]); ?>]" value="<?php echo ($sku["pdt_price_up"]); ?>" class="up_price"/>
				<input type="hidden" name="goods_products[down_price][<?php echo ($sku["pdt_sn"]); ?>]" value="<?php echo ($sku["pdt_price_down"]); ?>" class="down_price"/>
				<br />
				<a href="javascript:void(0);" class="btnA sku-list-member-level-price-button">会员价格</a>
				<br />
				<a href="javascript:void(0);" class="btnA sku-list-up-down-price-button" style="margin-top:2px;">价格区间</a>
			</td>
			<td><input type="text" name="goods_products[pdt_cost_price][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["pdt_cost_price"]); ?>" class="input40 sku_info pdt_cost_price" /></td>
			<td><input type="text" name="goods_products[pdt_market_price][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["pdt_market_price"]); ?>" class="input40 sku_info pdt_market_price" /></td>
			<td><input type="text" name="goods_products[pdt_weight][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["pdt_weight"]); ?>" class="input40 sku_info pdt_weight" /></td>
			<td><input type="text" name="goods_products[pdt_min_num][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["pdt_min_num"]); ?>" class="input40 sku_info pdt_min_num" /></td>
			<td><input type="text" name="goods_products[pdt_g_remark][<?php echo ($sku["pdt_id"]); ?>]" value="<?php echo ($sku["pdt_g_remark"]); ?>" class="input40 sku_info pdt_g_remark" /></td>
			<td><a href="javascript:void(0);" val="<?php echo ($sku["pdt_id"]); ?>" class="sku-list-delete-button">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
			<td colspan="99" style="text-align:right;margin-right:20px;">
				<span style="color:#ff0000;display:none;border:1px solid #00AA00;padding:2px;margin-right:15px;" id="add-new-sku-show-stock-msg">
					*新增的SKU不允许直接填入库存，请在商品资料保存成功以后通过库存调整单调整库存。
				</span>
				<button type="button" class="btnA sku-list-member-level-price-button-all">批量设置会员价</button>
				<button type="button" onclick="javascript:createNewProductListForm();" class="btnA"> + 添加规格</button>
			</td>
		<tr>
		<?php if(!empty($array_system_color_spec)): ?><tr>
			<td style="color:#ff0000;text-align:left;" colspan="99" >
				*友情提示：您可以为颜色属性上传图片，当用户在前台点击颜色色块时可见（仅对支持此规则的模板生效）。
			</td>
		</tr>
		<?php if(is_array($array_system_color_spec)): $i = 0; $__LIST__ = $array_system_color_spec;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><tr>
			<td style="text-align:left;">
				<span style="background-color:#<?php echo ($img["gsd_rgb_value"]); ?>;color:#<?php echo ($img["gsd_rgb_value"]); ?>;width:14px;height:14px;border:1px solid #000000;">&nbsp;&nbsp;&nbsp;</span>
				<span class="sku_list_spec_<?php echo ($img["gsd_id"]); ?>"><?php echo ($img["gsd_value"]); ?></span>
			</td>
			<td colspan="99" style="text-align:left;">
				<!--<input type="text" class="large" name="spec_image[<?php echo ($img["gsd_id"]); ?>]" value="<?php echo ($img["gsd_picture"]); ?>" />-->
				<!--<span style="color:#ff0000;">请在左侧文本框中输入远程图片URL地址。</span>-->
				<a href="javascript:upgsdImage('<?php echo ($img["gsd_id"]); ?>');" class="btnG ico_upload">上传图片</a>
				<img width="50px" height="50px" src="<?php echo ($img["gsd_picture"]); ?>" id="spec_image_<?php echo ($img["gsd_id"]); ?>">
				&nbsp;
				<input type="hidden" id="spec_image_input_<?php echo ($img["gsd_id"]); ?>" name="spec_image[<?php echo ($img["gsd_id"]); ?>]" value="<?php echo ($img["gsd_picture"]); ?>"/>
			</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
	</tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
	// 价格区间
	$(".sku-list-up-down-price-button").click(function(){
		//首先验证是否输入销售价格，如果没有输入输入销售价格，则提示需要先输入促销价格才行
		var pdt_sale_price = $(this).parent("td").children(".pdt_sale_price").val();
		var up_price = $(this).parent("td").children(".up_price").val();
		var down_price = $(this).parent("td").children(".down_price").val();
		var btn_object = $(this);
		if("" == pdt_sale_price || isNaN(pdt_sale_price)){
			alert("请先输入规格销售价。");
			return false;
		}
		//将规格销售价存入隐藏表单域中，方便计算折扣
		$("#member-level-price-input-spec-price").val(pdt_sale_price);
		// 销售价格
		$('#tck_sale_price').html(pdt_sale_price);
		// 初始化价格
		$('#tck_sale_price_area_up').val(up_price);
		$('#tck_sale_price_area_down').val(down_price);
		$('#tck_sale_price_admin_up').val(1);
		$('#tck_sale_price_admin_down').val(1);

		$('#goodsSetPriceUpDown').dialog({
			resizable:false,
			autoOpen: false,
			modal: true,
			width: 'auto',
			buttons: {
				'确认': function() {
					var tck_sale_price_area_up = $('#tck_sale_price_area_up');
					var tck_sale_price_area_down = $('#tck_sale_price_area_down');
					if(false === checkPriceUpDown(tck_sale_price_area_up,tck_sale_price_area_down)){
						return false;
					}
					btn_object.parent("td").children("input[type='hidden'][name^='goods_products[up_price]']").val(tck_sale_price_area_up.val());
					btn_object.parent("td").children("input[type='hidden'][name^='goods_products[down_price]']").val(tck_sale_price_area_down.val());
					$(this).dialog( "close" );
					return false;
				},
				'关闭': function() {
					if(confirm('确定不设置价格区间!')){
						btn_object.parent("td").children("input[type='hidden'][name^='goods_products[up_price]']").val('');
						btn_object.parent("td").children("input[type='hidden'][name^='goods_products[down_price]']").val('');
						$(this).dialog( "close" );
						return false;
					}
				}
			}
		});
		$('#goodsSetPriceUpDown').dialog('open');
	});
	// 会员价格
	$(".sku-list-delete-button").click(function(){
		if(confirm("确定要删除此规格吗？如果商品已下单，可能造成无法发货！")){
			//编辑商品时的删除SKU分为两种：一种是删除已经入库的，另一种是删除页面上的。
			if(!$(this).hasClass("is-new-add")){
				$("#delete_sku_pdt_ids").val($("#delete_sku_pdt_ids").val() + "," + $(this).attr("val"));
				//$(this).parent("td").parent("tr").remove();
			}
			var replace_html = '<td colspan="99" style="color:#ff0000;text-align:left;margin-left:30px;">已经将此规格删除，将会在您点击当前页面的保存按钮之后记录到数据库。</td>';
			$(this).parent("td").parent("tr").html(replace_html).fadeOut(5000,function(){
				$(this).parent("tr").remove();
			});
		}
	});
	$(".spec_input").each(function(){
		if("" == $(this).val()){
			$(this).val($(this).attr("val"));
		}
		$(".sku_list_spec_" + $(this).attr("vid")).html($(this).val());
	});
	$(".sku-list-member-level-price-button").click(function(){
		//首先验证是否输入销售价格，如果没有输入输入销售价格，则提示需要先输入促销价格才行
		var pdt_sale_price = $(this).parent("td").children(".pdt_sale_price").val();
		if("" == pdt_sale_price || isNaN(pdt_sale_price)){
			alert("请先输入规格销售价。");
			return false;
		}
		//将规格销售价存入隐藏表单域中，方便计算折扣
		$("#member-level-price-input-spec-price").val(pdt_sale_price);
		/**
		 * 处理表单数据自动回填
		 * 这里的解决办法是获取此规格的会员等级折扣价格字符串
		 * 格式为：ml_id:fixed_ml_price;ml_id:fixed_ml_price;ml_id:fixed_ml_price
		 * 将获取到的数据按照分号首先分隔（通过调用split方法实现）
		 * 然后遍历调用split方法根据冒号进行分割，判断如果得到的数组长度等于2，则表示是合法的数据
		 * 就将获取到的会员等级价格填充到表单中，并且计算会员等级折扣（折扣精确到三位小数）
		 * by Mithern 13.6.25
		 */
		var ml_fixed_price = $(this).parent("td").children("input[type='hidden']").val();
		if(ml_fixed_price != ""){
			var ml_prices = ml_fixed_price.split(';');
			for(var x in ml_prices){
				if("" != ml_prices[x]){
					var ml_p = ml_prices[x].split(':');
					var discount = '无优惠折扣';
					var input_obj = $(".member-level-price-input[ml_id='" + ml_p[0] + "']");
					input_obj.val(ml_p[1]);
					//自动计算会员等级折扣
					var discount_percent = parseInt(ml_p[1]/pdt_sale_price*10000)/1000;
					discount = discount_percent + '折';
				}
				input_obj.parent("td").next("td").html(discount);
			}
		}
		
		/** ****** dialog 对话框展示开始 ******** */
		var button_obj = $(this);
		$("#member-level-price-input").dialog({
			title:'设置会员等级固定价',
			width:'auto',
			height:'auto',
			modal: true,
			buttons:{
				'确定':function(){
					var ml_prices = "";
					$(".member-level-price-input").each(function(){
						if("" != $(this).val()){
							if(isNaN($(this).val())){
								alert("必须输入数字！");
								$(this).focus();
								return false;
							}
							ml_prices += $(this).attr("ml_id") + ":" + $(this).val() + ";";
						}
					});
					button_obj.parent("td").children("input[type='hidden'][name^='goods_products[member_level_price]']").val(ml_prices);
					$(this).dialog("close");
				},
				'取消':function(){
					if(confirm("确定要取消吗？")){
						$(this).dialog("close");
					}
				}
			},
            close:function(){
                //无论生成会员等级固定价格或者是取消会员等级固定价格，都要将这个值设置为空
                $("#member-level-price-input-spec-price").val('');
                $(".member-level-price-input").val("");
                $(".member-level-price-input-discount").html("无优惠折扣");
            }
		});
		/** ****** dialog 对话框展示结束 ******** */
	});

    //批量设置会员等级固定价功能
	$(".sku-list-member-level-price-button-all").click(function(){
		var pdt_sale_price = $('.sku-list-info-rows td').children(".pdt_sale_price").val();
		$("#member-level-price-input").dialog({
			title:'批量设置会员等级固定价',
			width:'auto',
			height:'auto',
			modal: true,
			buttons:{
				'确定':function(){
					var ml_prices = "";
					$(".member-level-price-input").each(function(){
						if("" != $(this).val()){
							if(isNaN($(this).val())){
								alert("必须输入数字！");
								$(this).focus();
								return false;
							}
							ml_prices += $(this).attr("ml_id") + ":" + $(this).val() + ";";
						}
					});
					$('.pdt_fixed_member_price').val(ml_prices);
					$(this).dialog("close");
				},
				'取消':function(){
					if(confirm("确定要取消吗？")){
						$(this).dialog("close");
					}
				}
			}
		});
		/** ****** dialog 对话框展示结束 ******** */
	});

	/** 规格商家编码变更验证：此项必填，且必须唯一（唯一性在比单提交时验证） **/
	$(".sku-list-info-rows .pdt_sn").change(function(){
		if($(this).val() != ""){
			$(this).css({"border":'1px solid gray'});
		}
	});
	
	/** 规格销售价变更验证：此项必填，且必须是数字 **/
	$(".sku-list-info-rows .pdt_sale_price").change(function(){
		if($(this).val() != "" && isNaN($(this).val())){
			$(this).css({"border":'1px solid gray'});
		}
	});
	
	/** 规格成本价变更验证：此项非必填，如果填入则必须是数字 **/
	$(".sku-list-info-rows .pdt_cost_price").change(function(){
		if(($(this).val() != "" && !isNaN($(this).val())) || "" == $(this).val()){
			$(this).css({"border":'1px solid gray'});
		}
	});
	
	/** 规格市场价变更验证，此项必填且必须是数字 **/
	$(".sku-list-info-rows .pdt_market_price").change(function(){
		if($(this).val() != "" && isNaN($(this).val())){
			$(this).css({"border":'1px solid gray'});
		}
	});
	
	/** 规格重量，此项必填且必须是数字 **/
	$(".sku-list-info-rows .pdt_weight").change(function(){
		if($(this).val() != "" && isNaN($(this).val())){
			$(this).css({"border":'1px solid gray'});
		}
	});
});





</script><?php endif; ?>
					</td>
				</tr>
				<!-- 商品SKU list 结束 -->
				
				
				<tr class="disabled_goods_sale_spec_info" style="<?php echo ($enabled_spec); ?>">
					<td class="first">成本价：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_cost_price" value="<?php echo ($disabled_pdt["pdt_cost_price"]); ?>" not_null="成本价必须输入。" input_number="成本价必须是一个数字。"  />
						<input type="hidden" name="pdt_price_up" value="<?php echo ($disabled_pdt["pdt_price_up"]); ?>" class="up_price" id="pdt_price_up" />
						<input type="hidden" name="pdt_price_down" value="<?php echo ($disabled_pdt["pdt_price_down"]); ?>" class="down_price" id="pdt_price_down" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>
						<button type="button" id="price_up_down" enable="" class="btnA">价格区间</button>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info" style="<?php echo ($enabled_spec); ?>">
					<td class="first">销售价：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_sale_price" id="pdt_sale_price" value="<?php echo ($disabled_pdt["pdt_sale_price"]); ?>" not_null="销售价必须输入。" input_number="销售价必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info" style="<?php echo ($enabled_spec); ?>">
					<td class="first">会员价格：</td>
					<td>
						<table style="border:1px solid gray;text-align:center;">
							<thead>
								<tr style="border:1px solid gray;">
									<td style="border:1px solid gray;" width="150px">会员等级</td>
									<td style="border:1px solid gray;" width="200px">固定价格</td>
									<td style="border:1px solid gray;" width="150px">折合折扣</td>
								</tr>
							</thead>
							<tbody>
							<?php if(is_array($array_member_level)): $i = 0; $__LIST__ = $array_member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><tr style="border:1px solid gray;">
									<td style="border:1px solid gray;text-align:right;"><?php echo ($ml["ml_name"]); ?>：</td>
									<td style="border:1px solid gray;">
										<input type="text" name="product_member_level_price[<?php echo ($ml["ml_id"]); ?>]" class="small input_number input_null member_level_fixed_price" value="<?php echo ($ml["ml_price"]); ?>"  input_number="会员等级固定价格必须是一个数字。"/>
										<span style="color:#ff0000;"></span>
									</td>
									<td style="border:1px solid gray;">暂无优惠折扣</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info" style="<?php echo ($enabled_spec); ?>">
					<td class="first">市场价：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_market_price" value="<?php echo ($disabled_pdt["pdt_market_price"]); ?>"  not_null="市场价格必须输入。" input_number="市场价格必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info" style="<?php echo ($enabled_spec); ?>">
					<td class="first">商品重量：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_weight" value="<?php echo ($disabled_pdt["pdt_weight"]); ?>" not_null="商品重量必须输入。" input_number="商品重量必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>g（克）
					</td>
					<td></td>
				</tr>
				<!--只读模式就好了-->
				<tr class="disabled_goods_sale_spec_info" style="<?php echo ($enabled_spec); ?>">
					<td class="first">商品库存：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_total_stock" disabled value="<?php echo ($disabled_pdt["pdt_total_stock"]); ?>" not_null="商品库存必须输入。" input_number="商品库存必须是一个数字。"  />
						<span style="color:#ff0000;"></span>
					</td>
					<td></td>
				</tr>
                <tr class="disabled_goods_sale_spec_info" style="<?php echo ($enabled_spec); ?>">
					<td class="first">最少起拍数：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_min_num" value="<?php echo ($disabled_pdt["pdt_min_num"]); ?>"  not_null="商品最少起拍数必须输入。" input_number="商品最少起拍数必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;">默认为0，为不限制</span>（件）
					</td>
					<td></td>
				</tr>
				<!--只读模式就好了-->
				<tr>
					<td class="first">开启积分兑换：</td>
					<td>
						<input type="radio" name="goods_info[is_exchange]" id="goods_info_is_exchange_1" class="is_exchange" value="1" <?php if($goods_info["is_exchange"] == 1): ?>checked="checked"<?php endif; ?> />
						<label for="goods_info_is_exchange_1">是</label>
						<input type="radio" name="goods_info[is_exchange]" id="goods_info_is_exchange_0" class="is_exchange" value="0" <?php if($goods_info["is_exchange"] == 0): ?>checked="checked"<?php endif; ?> />
						<label for="goods_info_is_exchange_0">否</label>
					</td>
					<td></td>
				</tr>
				<tr class="sh" id="goods_info_point_tr" <?php if($goods_info["is_exchange"] == 0): ?>style="display:none;"<?php endif; ?>>
					<td class="first">换购积分数：</td>
					<td>
						<input type="text" class="medium" name="goods_info[point]" value="<?php echo ($goods_info["point"]); ?>" />
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">手机APP是否显示：</td>
					<td>
						<input type="radio" name="goods_info[mobile_show]" id="goods_info_is_mobile_show_1" value="1" <?php if($goods_info["mobile_show"] == 1): ?>checked="checked"<?php endif; ?> />
						<label for="goods_info_is_mobile_show_1">是</label>
						<input type="radio" name="goods_info[mobile_show]" id="goods_info_is_mobile_show_0" value="0" <?php if($goods_info["mobile_show"] == 0): ?>checked="checked"<?php endif; ?> />
						<label for="goods_info_is_mobile_show_0">否</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">商品备注：</td>
					<td><input type="text" class="large" name="goods_info[g_remark]" value="<?php echo ($goods_info["g_remark"]); ?>" maxlength="100"/></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div><!--商品基本信息  结束-->
	
	<div id="con_addGoods_2" class="adCon" style="display:none;"><!--商品分类  开始-->
		<div class="wux"><!--wux  start-->
			<ul>
				<?php if(is_array($array_category)): $i = 0; $__LIST__ = $array_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><li class="cat_list_li checkbox_menus" id="li_catid_<?php echo ($cat["gc_id"]); ?>" is_parent="<?php echo ($cat["gc_is_parent"]); ?>" parent_id="<?php echo ($cat["gc_parent_id"]); ?>" style="margin-left:<?php echo ($cat['gc_level']*3); ?>em;" >
					<?php if($cat["gc_is_parent"] == 1): ?><!--<i class="parent_cat_button unfold" gc_id="<?php echo ($cat["gc_id"]); ?>"></i>--><?php endif; ?>
					<input type="checkbox" class="goods_category_checkbox" id="input_id_<?php echo ($cat["gc_id"]); ?>" name="related_goods_category[]" <?php if(in_array($cat['gc_id'],$array_catid)){echo 'checked="checked"';} ?> value="<?php echo ($cat["gc_id"]); ?>" />
					<label for="input_id_<?php echo ($cat["gc_id"]); ?>" style="cursor:pointer;"><?php echo ($cat["gc_name"]); if($cat["gc_is_display"] != 1): ?><span style="color:#ff0000;">[前台不显示]</span><?php endif; ?></label>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div><!--wux  end-->
		
	</div><!--商品分类  结束-->
	
	<div id="con_addGoods_3" class="adCon" style="display:none;"><!--商品图片  开始-->
		<div class="goodsPic"><!--goodsPic  start-->
			<ul>
				<?php if(is_array($array_images)): $i = 0; $__LIST__ = $array_images;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><li num_id="<?php echo ($i); ?>">
					<div class="imagebox_li_classname imagebox">
						<img src="<?php echo (C("DOMAIN_HOST")); echo ($pic["g_picture"]); ?>" id="pic_img_src_<?php echo ($i); ?>" style="width:120px;height:120px;" />
						<p id="imagebox_tools_bar_<?php echo ($pic["gp_order"]); ?>" style="display:none;">
							<a href="javascript:void(0);" image_id="<?php echo ($i); ?>" class="left images_tools_bar_left"></a>
							<a href="javascript:void(0);" image_id="<?php echo ($i); ?>" class="righ images_tools_bar_right"></a>
							<a href="javascript:void(0);" image_id="<?php echo ($i); ?>" class="del images_tools_bar_del"></a>
						</p>
					</div>
					<input type="hidden" name="goods_pictures[]" id="picture_input_<?php echo ($i); ?>" value="<?php echo ($pic["input_value"]); ?>" />
					<a href="javascript:void(0);" onclick="javascript:upImage(<?php echo ($i); ?>);" class="uploadImageForm btnA">上传图片</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div><!--goodsPic  end-->
		<p style="color:#ff0000;">
			提示：如果使用在线图片，您可以在弹出的对话框“在线管理”页签中一次选择多张图片，系统会自动依次添加到相应位置。
			<br />
			前台模板调用商品图片时请使用管易提供的缩略图方法，提高页面载入速度。
		</p>
	</div><!--商品图片  结束-->
	
	<div id="con_addGoods_4" class="adCon" style="display:none;"><!--详细描述  开始-->
		<table class="tbForm" width="100%" style="margin-top:10px">
			<tbody>
				<tr>
					<td class="first">商品描述：</td>
					<td colspan="2">
						<textarea name="goods_info[g_desc]" id="goods_editor" style="width:100%;"><?php echo ($goods_info["g_desc"]); ?></textarea>
					</td>
				</tr>
				<!--
				<tr>
					<td class="first">DPC:</td>
					<td>
						<input type="text" name="goods_info[g_dpc_path]" value="" class="large" />
					</td>
					<td>产品描述路径，通过http请求获取，如：http://dpc.guanyisoft.com/cool6/123.dpc。</td>
				</tr>
				-->
			</tbody>
		</table>
	</div><!--详细描述  结束-->
	
	<div id="con_addGoods_5" class="adCon" style="display:none;"><!--其他信息  开始-->
		<table class="tbForm" width="100%" style="margin-top:10px">
			<tbody>
				<tr>
					<td class="first">加入推荐：</td>
					<td>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_new]" id="goods_new" value="1" <?php if($goods["g_new"] == 1): ?>checked="checked"<?php endif; ?> />
							<label for="goods_new">新品</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_hot]" id="goods_hot" value="1" <?php if($goods["g_hot"] == 1): ?>checked="checked"<?php endif; ?> />
							<label for="goods_hot">热销</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_gifts]" id="goods_gifts" value="1" <?php if($goods["g_gifts"] == 1): ?>checked="checked"<?php endif; ?> />
							<label for="goods_gifts">不正常销售赠品</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_gifts]" id="goods_gifts_2" value="2" <?php if($goods["g_gifts"] == 2): ?>checked="checked"<?php endif; ?> />
							<label for="goods_gifts_2">正常销售赠品</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_pre_sale_status]" id="g_pre_sale_status" value="1" <?php if($goods["g_pre_sale_status"] == 1): ?>checked="checked"<?php endif; ?> />
							<label for="g_pre_sale_status">库存预售</label>
						</span>
					</td>
					<td></td>
				</tr>
				<!-- 加载商品资料自定义字段维护 开始 -->
				<tr class="sh">
	<td class="first">商品详情页温馨提醒：</td>
	<td>
		<input type="text" name="goods_info[g_custom_field_1]" value="<?php echo ($goods_info["g_custom_field_1"]); ?>" class="large" />
		<span class="font_999">自定义字段，根据自己需求维护，可不填。</span>
	</td>
	<td></td>
</tr>
<tr class="sh">
	<td class="first">商品资料自定义字段二：</td>
	<td>
		<input type="text" name="goods_info[g_custom_field_2]" value="<?php echo ($goods_info["g_custom_field_2"]); ?>" class="large" />
		<span class="font_999">自定义字段，根据自己需求维护，可不填。</span>
	</td>
	<td></td>
</tr>
<tr class="sh">
	<td class="first">商品资料自定义字段三：</td>
	<td>
		<input type="text" name="goods_info[g_custom_field_3]" value="<?php echo ($goods_info["g_custom_field_3"]); ?>" class="large" />
		<span class="font_999">自定义字段，根据自己需求维护，可不填。</span>
	</td>
	<td></td>
</tr>
<tr class="sh">
	<td class="first">商品资料自定义字段四：</td>
	<td>
		<input type="text" name="goods_info[g_custom_field_4]" value="<?php echo ($goods_info["g_custom_field_4"]); ?>" class="large" />
		<span class="font_999">自定义字段，根据自己需求维护，可不填。</span>
	</td>
	<td></td>
</tr>
<tr class="sh">
	<td class="first">商品资料自定义字段五：</td>
	<td>
		<input type="text" name="goods_info[g_custom_field_5]" value="<?php echo ($goods_info["g_custom_field_5"]); ?>" class="large" />
		<span class="font_999">自定义字段，根据自己需求维护，可不填。</span>
	</td>
	<td></td>
</tr>

				<!-- 加载商品资料自定义字段维护 结束 -->
				<tr class="sh">
					<td class="first">关键词[SEO KEYWORDS]：</td>
					<td>
						<input type="text" name="goods_info[g_keywords]" value="<?php echo ($goods_info["g_keywords"]); ?>" class="large" />
						<span class="font_999">用逗号或者空格分隔</span>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">描述[SEO DESCRIPTION]：</td>
					<td>
						<textarea class="mediumBox" name="goods_info[g_description]"><?php echo ($goods_info["g_description"]); ?></textarea>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div><!--其他信息  结束-->
	
	<!-- 关联商品 开始 -->
	<div id="con_addGoods_6" class="adCon" style="display:none;">
		<table class="tbForm" width="100%" style="margin-top:10px">
			<tbody>
				<tr>
	<td style="text-align:left;margin-left:100px;" colspan="3">
		分类：
		<select name="search_cats" class="related_goods_form medium">
			<option value="0"> -请选择- </option>
			<?php if(is_array($array_category)): $i = 0; $__LIST__ = $array_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat["gc_id"]); ?>"><?php for($j=0;$j<$cat['gc_level'];$j++){echo '--';} echo ($cat["gc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		品牌：
		<select name="search_brand" class="related_goods_form medium">
			<option value="0"> -请选择- </option>
			<?php if(is_array($array_brand)): $i = 0; $__LIST__ = $array_brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["gb_id"]); ?>"><?php echo ($vo["gb_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		关键词：
		<input type="text" name="keywords" class="related_goods_form medium" id="search_keywords" value="" />
		<button type="button" id="related_goods_form_search" class="btnA">搜索</button>
	</td>
</tr>
<tr>
	<td style="width:40%;text-align:center;">搜索出来的可选商品</td>
	<td style="width:20%;text-align:center;">操作</td>
	<td style="width:40%;text-align:center;">与该商品关联的商品</td>
</tr>
<tr>
	<td style="width:40%;text-align:center;">
		<select name="xxxxx1" class="large" id="g_related_goods_ids_selected" multiple="multiple" style="margin-left:auto;margin-right:auto;height:200px;"></select>
	</td>
	<td style="width:20%;text-align:center;">
		<span>
			<input type="radio" name="goods[g_related_type]" value="1" id="related_tyoe_1" <?php if($goods["g_related_type"] == 1 || !isset($goods['g_related_type']) || 0 == $goods['g_related_type']): ?>checked<?php endif; ?> style="vertical-align:middle;" />
			<label for="related_tyoe_1" style="vertical-align:middle;">单向关联</label>
		<span>
		<br />
		<br />
		<span>
			<input type="radio" name="goods[g_related_type]" value="2" id="related_tyoe_2" <?php if($goods["g_related_type"] == 2): ?>checked<?php endif; ?>  style="vertical-align:middle;" />
			<label for="related_tyoe_2" style="vertical-align:middle;">双向关联</label>
		<span>
		<br />
		<br />
		<button type="button" id="related_button_right" class="btnA" onclick="removeTORight();" style="width:100px;text-align:center;">>></button>
		<br />
		<br />
		<button type="button" id="related_button_left" class="btnA" onclick="removeTOLeft();" style="width:100px;text-align:center;"><<</button>
	</td>
	<td style="width:40%;text-align:center;">
		<input type="hidden" name="goods[g_related_goods_ids]" value="<?php echo ($goods["g_related_goods_ids"]); ?>" id="g_related_goods_ids" />
		<select name="xxxxx2" id="g_related_goods_list" class="large" multiple="multiple" style="margin-left:auto;margin-right:auto;height:200px;">
			<?php if(is_array($related_goods_list)): $i = 0; $__LIST__ = $related_goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$related_goods): $mod = ($i % 2 );++$i;?><option value="<?php echo ($related_goods["g_id"]); ?>"><?php echo ($related_goods["g_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</td>
</tr>
<script type="text/javascript">
$(document).ready(function(){
	$("#related_goods_form_search").click(function(){
		var request_url = "<?php echo U('Admin/Goods/adminSearchGoods');?>?";
		$(".related_goods_form").each(function(){
			request_url += $(this).attr('name') + '=' + encodeURIComponent($(this).val()) + '&';
		});
		$.ajax({
			url:request_url,
			data:{},
			success:function(htmlObj){
				var htmls_options = "";
				for (var x in htmlObj){
					var goods = htmlObj[x];
					htmls_options += '<option value="' + goods.g_id + '">' + goods.g_name + '</option>';
				}
				$("#g_related_goods_ids_selected").html(htmls_options);
			},
			type:'GET',
			timeout:30000,
			dataType:'json'
		});
	});
});
function removeTORight(){
	$("#g_related_goods_ids_selected option").each(function(){
		if($(this).attr("selected")){
			$("#g_related_goods_list").append($(this).removeAttr("selected"));
		}
	});
	var related_goods_ids = "";
	$("#g_related_goods_list option").each(function(){
		related_goods_ids += $(this).attr("value") + ',';
	});
	return $("#g_related_goods_ids").val(related_goods_ids);
}

function removeTOLeft(){
	var related_goods_ids = "";
	$("#g_related_goods_list option").each(function(){
		if($(this).attr("selected")){
			$(this).remove();
		}else{
			related_goods_ids += $(this).attr("value") + ',';
		}
	});
	return $("#g_related_goods_ids").val(related_goods_ids);
}
</script>
			</tbody>
		</table>
	</div>
	<!-- 关联商品 结束 -->
	
	<!--手机端描述  开始-->
	<div id="con_addGoods_7" class="adCon" style="display:none;">
		<table class="tbForm" width="100%" style="margin-top:10px">
			<tbody>
				<tr>
					<td class="first">手机端描述：</td>
					<td colspan="2">
						<textarea name="goods_info[g_phone_desc]" id="goods_editor2" style="width:100%;"><?php echo ($goods_info["g_phone_desc"]); ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!--手机端描述  结束-->	
	
	<!-- 表单提交 开始 -->
	<p style="text-align:center; padding:10px 0px;">
		<input type="hidden" name="modify_delete_skus" id="delete_sku_pdt_ids" value="" />
		<input type="hidden" name="page_jump" value="1" id="submit-page-jump-type" />
		<input type="submit" page_jump="1" class="btnA submit-button" value="保存">
		<input type="button" value="重置" onclick="javascript:resetFrom();"  class="btnA" />

	</p>
</div><!--rightInner  end-->
</form>
<div id="member-level-price-input" style="display:none;text-align:center;">
	<input type="hidden" name="xx" value="" id="member-level-price-input-spec-price" />
	<table style="border:1px solid gray;margin-left:auto;margin-right:auto;">
		<thead>
			<tr style="border:1px solid gray;text-align:center;">
				<td style="border:1px solid gray;" width="150px;">会员等级</td>
				<td style="border:1px solid gray;" width="200px;">固定价格</td>
				<td style="border:1px solid gray;" width="150px;">折合折扣</td>
			</tr>
		</thead>
		<tbody>
		<?php if(is_array($array_member_level)): $i = 0; $__LIST__ = $array_member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><tr style="border:1px solid gray;">
				<td style="border:1px solid gray;"><?php echo ($ml["ml_name"]); ?>：</td>
				<td style="border:1px solid gray;">
					<input type="text" name="demo" ml_id="<?php echo ($ml["ml_id"]); ?>" class="small member-level-price-input" value=""/>
				</td>
				<td class="member-level-price-input-discount">无优惠折扣</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>
<!--
<div id="goods-edit-add-new-product-select-box" style="display:none;text-align:center;">
	<table width="100%" style="background-color: #F8F8F8;border: 1px solid #ECECEC;">
	<tbody>
		<?php if(is_array($array_sale_spec)): $i = 0; $__LIST__ = $array_sale_spec;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td style="width:100px;text-align:right;" valign="top" class="add-sku-spec-name" pname="<?php echo ($vo["gs_name"]); ?>"><?php echo ($vo["gs_name"]); ?>：</td>
			<td>
				<ul class="sku-box" style="text-align:left;">
					<?php if(is_array($vo[spec_detail])): $i = 0; $__LIST__ = $vo[spec_detail];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec): $mod = ($i % 2 );++$i;?><li>
						<input type="checkbox" name="add_spec_vid[]" class="checkbox add-spec-pid-vid-checkbox" id="add-spec_<?php echo ($spec["gs_id"]); ?>_<?php echo ($spec["gsd_id"]); ?>" value="<?php echo ($spec["gs_id"]); ?>:<?php echo ($spec["gsd_id"]); ?>;" />
						<label for="add-spec_<?php echo ($spec["gs_id"]); ?>_<?php echo ($spec["gsd_id"]); ?>" style="cursor:pointer;">
						<?php if($spec["gs_id"] == 888): ?><span style="background-color:#<?php echo ($spec["gsd_rgb_value"]); ?>;color:#<?php echo ($spec["gsd_rgb_value"]); ?>;width:14px;height:14px;border:1px solid #000000;">&nbsp;&nbsp;&nbsp;</span><?php endif; ?>
						<span><?php echo ($spec["gsd_value"]); ?></span>
						</label>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2" style="text-align:left;margin-left:20px;color:#ff0000;border:1px solid #FEC3A8;display:none;">
				<b id="show-add-new-spec-message-box"></b>
			</td>
		</tr>
	</tfoot>
</table>
<div>
-->
<div id="goodsSetPriceUpDown" style="display: none;" title="设置价格区间">
    
<div id="isAjax" style="display:none">用此ID标识本页面是通过ajax载入进来的</div>
<style type="text/css">
.tic_content{width:650px;margin:30px auto;border:1px solid #333;}
.tic_content tr{border:1px solid #333;}
.tic_content tr td{padding:5px;}
</style>
<div class="rightInner load" id="goodsSelecterList">
    <table cellspacing="0" cellpadding="0" class="tic_content">
        <tbody>
            <tr>
                <td align="right">当前销售价</td>
                <td><span id="tck_sale_price"></span></td>
                <td></td>
            </tr>
            <tr>
                <td align="right">最高价</td>
                <td> = 基础价
                    <select id="tck_sale_price_admin_up" style="width:120px;" >
                        <option value="1" selected="selected">请选择</option>
                        <option value="1.05">+%5</option>
                        <option value="1.10">+%10</option>
                        <option value="1.15">+%15</option>
                        <option value="1.2">+%20</option>
                        <option value="1.3">+%30</option>
                        <option value="1.5">+%50</option>
                        <option value="1.75">+%75</option>
                        <option value="2">+%100</option>
                        <option value="2.5">+%150</option>
                        <option value="3">+%200</option>
                        <option value="4">+%300</option>
                        <option value="6">+%500</option>
                        <option value="11">+%1000</option>
                    </select>
                </td>
                <td>或 直接录入 <input type="text" id="tck_sale_price_area_up" value=""></td>
            </tr>
            <tr>
                <td align="right">最低价</td>
                <td> = 基础价
                    <select id="tck_sale_price_admin_down" style="width:120px;" >
                        <option value="1" selected="selected">请选择</option>
                        <option value="0.95">-%5</option>
                        <option value="0.9">-%10</option>
                        <option value="0.85">-%15</option>
                        <option value="0.8">-%20</option>
                        <option value="0.7">-%30</option>
                        <option value="0.5">-%50</option>
                        <option value="0.25">-%75</option>
                        <option value="0.1">-%90</option>
                    </select>
                </td>
                <td>或 直接录入 <input type="text" id="tck_sale_price_area_down"  value=""></td>
            </tr>
            <tr>
                <td>说明</td>
                <td align="left" colspan="2" style="width:500px;">
                    销售价格区间为非必填项，填入以后，淘宝C2C下载的订单内的每件商品会做价格区间比对，一单内发现有任意一件乱价商品（即：销售价格不在此区间内的），该单会在后台订单列表标红，提示价格可能有乱。
                </td>
            </tr>
        </tbody>
    </table>
    <div class="clear"></div>
</div>
<script src="__PUBLIC__/Admin/js/loading.js"></script>
<script>
$(function(){
    $('#tck_sale_price_admin_up,#tck_sale_price_admin_down').bind({'change':function(){
        var price_up = parseFloat($(this).val());
        var sale_price = parseFloat($('#tck_sale_price').text());
        $(this).parent().next().find('input').val((price_up*sale_price).toFixed(2));
    }});
});
</script>
</div>
<script type="text/javascript">
	var PUBLIC_PATH = '__PUBLIC__';
	var ajaxLoadUnsaleSpec_url = "<?php echo U('Admin/Goods/ajaxLoadUnsaleSpec');?>";
	var loadGoodsSaleSpecForm_url = "<?php echo U('Admin/Goods/ajaxLoadSaleSpec');?>";
	var ajaxSkuLists_url = "<?php echo U('Admin/Goods/ajaxSkuLists','is_edit=1');?>";
	var resetFrom_url = "<?php echo U('Admin/Goods/goodsEdit');?>";
	var checkPdtSnUnique_url = "<?php echo U('Admin/Goods/checkPdtSnUnique');?>";
	var int_goods_id = '<?php echo ($goods["g_id"]); ?>';
	window.UEDITOR_HOME_URL = "__PUBLIC__/Lib/ueditor/";
</script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_config.js?t=<?php echo rand(1,11111); ?>"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_all.js"></script>
<script type="text/javascript" src="__PUBLIC__/Admin/js/admin-goods-edit.js?t=<?php echo rand(1,11111); ?>"></script>
<script type="text/javascript">
function checkPriceUpDown(tck_sale_price_area_up,tck_sale_price_area_down){
	if(tck_sale_price_area_up.val() == '' || tck_sale_price_area_down.val() == ''){
		showAlert(false,'请填写价格区间');return false;
	}
	if(isNaN(tck_sale_price_area_up.val()) || isNaN(tck_sale_price_area_down.val())){
		showAlert(false,'请正确填写价格区间');return false;
	}
}
$(function(){
	// 价格区间
	$('#price_up_down').bind({'click':function(){
		var pdt_sale_price = $('#pdt_sale_price').val();
		if(pdt_sale_price == '' || isNaN(pdt_sale_price)){
			showAlert(false,'请填写销售价格');return false;
		}
		// 销售价格
		$('#tck_sale_price').html(pdt_sale_price);
		// 初始化价格
		$('#tck_sale_price_area_up').val($('#pdt_price_up').val());
		$('#tck_sale_price_area_down').val($('#pdt_price_down').val());
		$('#tck_sale_price_admin_up').val(1);
		$('#tck_sale_price_admin_down').val(1);

		$('#goodsSetPriceUpDown').dialog({
			resizable:false,
			autoOpen: false,
			modal: true,
			width: 'auto',
			// position: [220,85],
			buttons: {
				'确认': function() {
					var tck_sale_price_area_up = $('#tck_sale_price_area_up');
					var tck_sale_price_area_down = $('#tck_sale_price_area_down');
					if(false === checkPriceUpDown(tck_sale_price_area_up,tck_sale_price_area_down)){
						return false;
					}
					$('#pdt_price_up').val(tck_sale_price_area_up.val());
					$('#pdt_price_down').val(tck_sale_price_area_down.val());
					$(this).dialog( "close" );
					return false;
				},
				'关闭': function() {
					if(confirm('确定不设置价格区间!')){
						$('#pdt_price_up').val('');
						$('#pdt_price_down').val('');
						$(this).dialog( "close" );
						return false;
					}
				}
			}
		});
		$('#goodsSetPriceUpDown').dialog('open');
	}});
})

//add by zhangjiasuo 2015-03-16
function trade_type($this){ 
	var type=$("#goods_trade_type_select").val();
	if( type == '1'){
		$("#g_tax_rate_tr").show();
	}else{
		$("#g_tax_rate_tr").hide();
	}
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