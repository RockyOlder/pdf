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
<form action="<?php echo U('Admin/Goods/doGoodsAdd');?>" method="POST" id="goodForm" onsubmit="return javascriptCheckBeforeSubmit();" >
<div class="rightInner"><!--rightInner  start-->
	<div id="con_addGoods_1" class="adCon"><!--商品基本信息  开始-->
		<table class="tbForm" width="100%">
			<tbody>
				<tr>
					<td class="first">商品名称：</td>
					<td>
						<input type="text" name="goods_info[g_name]" id="g_name" value="" class="large" maxlength="30"/>
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
						<input type="text" name="goods_info[g_sn]" id="g_sn" value="" class="large" maxlength="100" />
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
                        <input type="number" name="goods[g_order]" id="g_order" value="" class="small" maxlength="30" min="0"/>
                        <em>排序越大越靠前</em>
                    </td>
                    <td></td>
                </tr>
				<tr>
					<td class="first">品牌：</td>
					<td>
						<select name="goods[gb_id]" class="medium">
							<option value="0">--请选择商品品牌--</option>
							<?php if(is_array($array_brand)): $i = 0; $__LIST__ = $array_brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["gb_id"]); ?>"><?php echo ($vo["gb_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">是否上架：</td>
					<td>
						<input type="radio" name="goods[g_on_sale]" checked="checked" value="1" id="goods_g_on_sale_1" />
						<label for="goods_g_on_sale_1" style="cursor:pointer;">是</label>
						<input type="radio" name="goods[g_on_sale]" value="2" id="goods_g_on_sale_2" style="margin-left:30px;" />
						<label for="goods_g_on_sale_2" style="cursor:pointer;">否</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">计量单位：</td>
					<td><input type="text" name="goods_info[g_unit]" value="" class="small" /></td>
					<td></td>
				</tr>
				<?php if(($GY_IS_FOREIGN["sc_value"]) == "1"): ?><tr>
					<td class="first">贸易类型：</td>
					<td>
						<select id="goods_trade_type_select" name="goods_info[trade_type]" class="medium" onchange= "trade_type(this)" >
							<option value="0">--正常贸易--</option>
							<option value="1">--跨境贸易--</option>
						</select>
					</td>
					<td></td>
				</tr>
				<tr id="g_tax_rate_tr" style="display:none;">
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
						<select class="medium" name="goods[gt_id]" id="goods_type_select">
							<option value="0">--请选择商品类型--</option>
							<?php if(is_array($array_type)): $i = 0; $__LIST__ = $array_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["gt_id"]); ?>"><?php echo ($vo["gt_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<font style="color:#ff0000;">*</font>
						<br />
						<span style="color:gray;">
							选择商品类型以后，您可以进一步编辑商品属性和规格。
						</span>
					</td>
					<td></td>
				</tr>
				<!-- 商品扩展属性输入位置开始 -->
				<tr style="display:none;" id="tbody_goods_spec_area_tr">
					<td class="first">商品扩展属性：</td>
					<td id="tbody_goods_spec_area" class="ajax_show_area" colspan="2"></td>
				</tr>
				<!-- 商品扩展属性输入位置结束 -->
				
				<!-- 商品销售属性选择区域开始 -->
				<tr style="display:none;" id="select_goods_sales_spec_box">
					<td class="first">商品销售属性：</td>
					<td id="goods_sales_spec_select_area" class="ajax_show_area" colspan="2"></td>
				</tr>
				<!-- 商品销售属性选择区域结束 -->
				
				<!-- 商品SKU list 开始 -->
				<tr style="display:none;" class="add_goods_sku_list">
					<td class="first"></td>
					<td colspan="2" id="goods_sku_list_form" class="ajax_show_area"></td>
				</tr>
				<!-- 商品SKU list 结束 -->
				<tr class="disabled_goods_sale_spec_info">
					<td class="first">成本价：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_cost_price" value="" not_null="成本价必须输入。" input_number="成本价必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info">
					<td class="first">销售价：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_sale_price" id="pdt_sale_price" value="" not_null="销售价必须输入。" input_number="销售价必须是一个数字。" />
						<input type="hidden" name="pdt_price_up" value="" class="up_price" id="pdt_price_up" />
						<input type="hidden" name="pdt_price_down" value="" class="down_price" id="pdt_price_down" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>
						<button type="button" id="price_up_down" enable="" class="btnA">价格区间</button>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info">
					<td class="first">会员价格：</td>
					<td>
						<table style="border:1px solid gray;">
							<thead>
								<tr style="border:1px solid gray;text-align:center;">
									<td style="border:1px solid gray;" width="150px;">会员等级</td>
									<td style="border:1px solid gray;" width="200px;">固定价格</td>
									<td style="border:1px solid gray;" width="150px;">折合折扣</td>
								</tr>
							</thead>
							<tbody>
							<?php if(is_array($array_member_level)): $i = 0; $__LIST__ = $array_member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><tr style="border:1px solid gray;">
									<td style="border:1px solid gray;text-align:right;"><?php echo ($ml["ml_name"]); ?>：</td>
									<td style="border:1px solid gray;">
										<input type="text" name="product_member_level_price[<?php echo ($ml["ml_id"]); ?>]" class="small input_number input_null member_level_fixed_price" value="" input_number="会员等级固定价格必须是一个数字。"/>
										<span style="color:#ff0000;"></span>
									</td>
									<td style="border:1px solid gray;text-align:center;">无优惠折扣</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info">
					<td class="first">市场价：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_market_price" value="" not_null="市场价格必须输入。" input_number="市场价格必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info">
					<td class="first">商品重量：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_weight" value=""  not_null="商品重量必须输入。" input_number="商品重量必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>g（克）
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info">
					<td class="first">商品库存：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_total_stock" value=""  not_null="商品库存必须输入。" input_number="商品库存必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;"></span>
					</td>
					<td></td>
				</tr>
				<tr class="disabled_goods_sale_spec_info">
					<td class="first">最少起拍数：</td>
					<td>
						<input type="text" class="small not_null input_number" name="pdt_min_num" value="0"  not_null="商品最少起拍数必须输入。" input_number="商品最少起拍数必须是一个数字。" />
						<font style="color:#ff0000;">*</font>
						<span style="color:#ff0000;">默认为0，为不限制</span>（件）
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">开启积分兑换：</td>
					<td>
						<input type="radio" name="goods_info[is_exchange]" id="goods_info_is_exchange_1" value="1" class="is_exchange" />
						<label for="goods_info_is_exchange_1">是</label>
						<input type="radio" name="goods_info[is_exchange]" checked="checked" id="goods_info_is_exchange_0" value="0" class="is_exchange" />
						<label for="goods_info_is_exchange_0">否</label>
					</td>
					<td></td>
				</tr>
				<tr class="sh" id="goods_info_point_tr" style="display:none;">
					<td class="first">换购积分数：</td>
					<td>
						<input type="text" class="medium" name="goods_info[point]" value="" />
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">手机APP是否显示：</td>
					<td>
						<input type="radio" name="goods_info[mobile_show]" checked="checked" id="goods_info_is_mobile_show_1" value="1" />
						<label for="goods_info_is_mobile_show_1">是</label>
						<input type="radio" name="goods_info[mobile_show]" id="goods_info_is_mobile_show_0" value="0" />
						<label for="goods_info_is_mobile_show_0">否</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">商品备注：</td>
					<td><input type="text" class="large" name="goods_info[g_remark]" value="" maxlength="100"/></td>
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
					<input type="checkbox" class="goods_category_checkbox" id="input_id_<?php echo ($cat["gc_id"]); ?>" name="related_goods_category[]" value="<?php echo ($cat["gc_id"]); ?>" />
					<label for="input_id_<?php echo ($cat["gc_id"]); ?>" style="cursor:pointer;"><?php echo ($cat["gc_name"]); if($cat["gc_is_display"] != 1): ?><span style="color:#ff0000;">[前台不显示]</span><?php endif; ?></label>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div><!--wux  end-->
		
	</div><!--商品分类  结束-->
	
	<div id="con_addGoods_3" class="adCon" style="display:none;"><!--商品图片  开始-->
		<div class="goodsPic"><!--goodsPic  start-->
			<ul>
				<?php $__FOR_START_17886__=0;$__FOR_END_17886__=10;for($i=$__FOR_START_17886__;$i < $__FOR_END_17886__;$i+=1){ ?><li num_id="<?php echo ($id); ?>">
					<div class="imagebox_li_classname imagebox">
						<?php if($i == 0): ?><img src="__PUBLIC__/Admin/images/product_image_index.png" id="pic_img_src_<?php echo ($i); ?>" style="width:120px;height:120px;" />
						<?php else: ?>
							<img src="__PUBLIC__/Admin/images/product_image_desc.png" id="pic_img_src_<?php echo ($i); ?>" style="width:120px;height:120px;" /><?php endif; ?>
						<p id="imagebox_tools_bar_<?php echo ($i); ?>" style="display:none;">
							<a href="javascript:void(0);" image_id="<?php echo ($i); ?>" class="left images_tools_bar_left"></a>
							<a href="javascript:void(0);" image_id="<?php echo ($i); ?>" class="righ images_tools_bar_right"></a>
							<a href="javascript:void(0);" image_id="<?php echo ($i); ?>" class="del images_tools_bar_del"></a>
						</p>
					</div>
					<?php if($i == 0): ?><input type="hidden" name="goods_info[g_picture]" id="picture_input_<?php echo ($i); ?>" value="" />
					<?php else: ?>
					<input type="hidden" name="goods_pictures[]" id="picture_input_<?php echo ($i); ?>" value="" /><?php endif; ?>
					<a href="javascript:void(0);" onclick="javascript:upImage(<?php echo ($i); ?>);" class="uploadImageForm btnA">上传图片</a>
				</li><?php } ?>
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
						<textarea name="goods_info[g_desc]" id="goods_editor"  style="width:100%;"></textarea>
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
							<input type="checkbox" name="goods[g_new]" id="goods_new" value="1" />
							<label for="goods_new">新品</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_hot]" id="goods_hot" value="1" />
							<label for="goods_hot">热销</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_gifts]" id="goods_gifts" value="1" />
							<label for="goods_gifts">不正常销售赠品</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_gifts]" id="goods_gifts_2" value="2" />
							<label for="goods_gifts_2">正常销售赠品</label>
						</span>
						<span class="checkbox_menus">
							<input type="checkbox" name="goods[g_pre_sale_status]" id="g_pre_sale_status" value="1" />
							<label for="g_pre_sale_status">预售</label>
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
						<input type="text" name="goods_info[g_keywords]" class="large" />
						<span class="font_999">用逗号或者空格分隔</span>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="first">描述[SEO DESCRIPTION]：</td>
					<td>
						<textarea class="mediumBox" name="goods_info[g_description]"></textarea>
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
	<div id="con_addGoods_7" class="adCon" style="display:none;"><!--详细描述  开始-->
		<table class="tbForm" width="100%" style="margin-top:10px">
			<tbody>
				<tr>
					<td class="first">手机端描述：</td>
					<td colspan="2">
						<textarea name="goods_info[g_phone_desc]" id="goods_editor2"  style="width:100%;"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div><!--详细描述  结束-->	
	<!-- 表单提交 开始 -->
	<p style="text-align:center; padding:10px 0px;">
		<input type="hidden" name="page_jump" value="1" id="submit-page-jump-type" />
		<button type="submit" page_jump="1" class="btnA submit-button">保存</button>
		<button type="submit" page_jump="2" class="btnA submit-button">保存并继续</button>
		<input type="button" value="重置" onclick="javascript:resetFrom();"  class="btnA" />
		<input type="button" value="批量添加商品" onClick="onUrl('<?php echo U("Admin/Goods/batchGoodsAdd");?>');"  class="btnA" />
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
<!--价格区间-->
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
	var ajaxSkuLists_url = "<?php echo U('Admin/Goods/ajaxSkuLists');?>";
	var resetFrom_url = "<?php echo U('Admin/Goods/goodsAdd');?>";
	var checkPdtSnUnique = "<?php echo U('Admin/Goods/checkPdtSnUnique');?>";
	window.UEDITOR_HOME_URL = "__PUBLIC__/Lib/ueditor/";
</script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_config.js?t=<?php echo rand(1,11111); ?>"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_all.js"></script>
<script type="text/javascript" src="__PUBLIC__/Admin/js/admin-goods-add.js?t=<?php echo rand(1,11111); ?>"></script>
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