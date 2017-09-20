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
                <script src="__PUBLIC__/Admin/js/order.js"></script>
<div class="content" style="width:990px; margin:0 auto;" >
<form  id="orderForm" name="orderForm" action="/Admin/Orders/doEdit" method="post">
	<div class="rightInner" style="border:none" id="getPageEdit">
    	<div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">订单信息</h2>
        	<table class="tbForm">
            	<tr>
                	<td width="120" align="right">订单号：</td>
                    <td width="290"><?php echo ($ary_orders["o_id"]); ?>
                    <input type="hidden" name="o_id" id="o_id" value="<?php echo ($ary_orders["o_id"]); ?>"/>
                    </td>
                    <td width="90" align="right">订单状态：</td>
                    <td><?php if($ary_orders[str_status] != ''): ?><span class="orange"><?php echo ($ary_orders["str_status"]); ?></span><?php else: if($ary_orders["str_pay_status"] != ''): ?><span class="orange"><?php echo ($ary_orders["str_pay_status"]); ?></span>&nbsp;<?php endif; ?>
                    <?php if($ary_orders["refund_status"] != ''): ?><span class="orange"><?php echo ($ary_orders["refund_status"]); ?></span>&nbsp;<?php endif; ?>
                    <?php if($ary_orders["refund_goods_status"] != ''): ?><span class="orange"> <?php echo ($ary_orders["refund_goods_status"]); ?></span>&nbsp;<?php endif; ?>
                    <?php if($ary_orders["deliver_status"] != ''): ?><span class="orange"><?php echo ($ary_orders["deliver_status"]); ?></span><?php endif; endif; ?></td>
                </tr>
                <tr>
                	<td align="right">会员名称：</td>
                    <td><?php echo ($members['m_name']); ?> &nbsp;&nbsp;&nbsp;<a href='<?php echo U("Admin/Members/pageList");?>?m_name_type=1&m_name=<?php echo ($members["m_name"]); ?>' target="_blank">会员信息</a></td>
                    <td align="right">下单时间：</td>
                    <td><?php echo ($ary_orders["o_create_time"]); ?></td>
                </tr>
                <tr>
                	<td align="right">支付方式：</td>
                    <td colspan="3">
                    	<select class="small" id="payment_list" name="o_payment" >
                    	     <?php if(is_array($ary_paymentcfg)): $key = 0; $__LIST__ = $ary_paymentcfg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$paymentcfg): $mod = ($key % 2 );++$key;?><option value="<?php echo ($paymentcfg["pc_id"]); ?>" pc_fee="<?php echo ($paymentcfg["pc_fee"]); ?>" <?php if($paymentcfg['pc_id'] == $ary_orders['o_payment']): ?>selected<?php endif; ?>><?php echo ($paymentcfg["pc_custom_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit" ><!--orderEdit  start-->
        	<h2 class="commonH2">收货人信息</h2>
        	<table class="tbForm">
            	<tr>
                	<td width="120" align="right">收货人：</td>
                    <td width="290"><input type="text" name="o_receiver_name" value="<?php echo ($ary_orders["o_receiver_name"]); ?>" class="medium"></td>
                    <td width="90" align="right">联系手机：</td>
                    <td><input type="text" name="o_receiver_mobile" value="<?php echo ($ary_orders["o_receiver_mobile"]); ?>" class="medium"></td>
                </tr>
                <tr>
                	<td align="right">联系电话：</td>
                    <td><input type="text" value="<?php echo ($ary_orders["o_receiver_telphone"]); ?>" name="o_receiver_telphone" class="medium"></td>
                    <td align="right">电子邮件：</td>
                    <td><input type="text" value="<?php echo ($ary_orders["o_receiver_email"]); ?>" name="o_receiver_email" class="medium"></td>
                </tr>
                <tr>
                	<td align="right">送货时间：</td>
                    <td><input type="text" class="medium timer" name="o_receiver_time" readonly="readonly" value="<?php echo ($ary_orders["o_receiver_time"]); ?>"></td>
                    <td align="right">邮政编码：</td>
                    <td><input type="text" class="medium" name="o_receiver_zipcode" value="<?php echo ($ary_orders["o_receiver_zipcode"]); ?>"></td>
                </tr>
                <tr>
                	<td align="right">收货地区：</td>
                    <td colspan="3">
                    
<style type="text/css">
.loading-box{background-color:#FFF8ED;width:auto;min-width:100px;font-size:16px;padding:3px;border:1px solid #FF9900;display:none;}
</style>

<select id="province" name="province" class="medium city_region_select" child_id="city" val="<?php echo ($region['province']); ?>">
   <option value="0" selected="selected">请选择省份</option>
</select>
<select id="city" name="city" child_id="region1" class="medium city_region_select" val="<?php echo ($region['city']); ?>" >
   <option value="0" selected="selected">请选择城市</option>
</select>
<select id="region1" name="region1" child_id="" class="medium city_region_select" val="<?php echo ($region['region']); ?>" >
   <option value="0" selected="selected">请选择地区</option>
</select>
<span class="loading-box">请稍等，载入中......</span>
<script type="text/javascript">
$(document).ready(function(){
	//文档载入完成以后自动加载一级省市区
    loadChildCityRegion(1,'province',$('#province'));
	$(".city_region_select").change(function(){
		$(".city_region_select").attr({'val':''});
		var parent_id = $(this).val();
		var selectDomId = $(this).attr("child_id");
		loadChildCityRegion(parent_id,selectDomId,this);
	});
});
function openLoadingBox(){
	$(".loading-box").show();
}
function closeLoadingBox(){
	$(".loading-box").hide();
}
function loadChildCityRegion(parent_id,selectDomId,clickObj){
	//如果当前选中的行政区ID小于等于0，则表示选择的是“请选择”，将后面的行政区select清楚
	$(clickObj).nextAll("select").hide().empty();
	
	//如果选中了“请选择”，则不理会。
	if(parent_id <= 0 || "region" == $(clickObj).attr("id")){
		return false;
	}
	
	//定义异步加载行政区的url
	var load_options_url = "<?php echo U('Admin/Members/cityRegionOptions');?>";
	//ajax异步加载下一级行政区域数据
	$.ajax({
		url:load_options_url,
		data:{parent_id:parent_id},
		beforeSend:openLoadingBox(),
		type:'POST',
		success:function(jsonObj){
			if(true === jsonObj.status && null !== jsonObj.data){
				$(clickObj).next("select").show();
				//select options 元素数据拼接
				var html_options = '<option value="0" selected="selected">请选择</option>';
				var next_child_parent = 0;
				for(var index in jsonObj.data){
					html_options += '<option value="' + index + '" ';
					if(index == $(clickObj).attr('val')){
						html_options += 'selected="selected" ';
						next_child_parent = index;
					}
					html_options += '>' + jsonObj.data[index] + '</option>';
				}

				//将拼接的结果追加到DOM中
				$("#" + selectDomId).html(html_options);
				
				//递归加载数据，用于初始化的时候
				if(next_child_parent > 0){
					var selectChildDomId = $("#" + selectDomId).attr("child_id");
					loadChildCityRegion(next_child_parent,selectChildDomId,$("#" + selectChildDomId));
				}
				
				//对空seletet元素进行隐藏操作
				if($("#province").val() <= 0){
					$("#province").nextAll("select").hide().empty();
				}else if($("#city").val() <= 0){
					$("#city").nextAll("select").hide().empty();
				}
                
			}else{
				if("region" == $(clickObj).attr("id")){
					$(clickObj).empty().hide();
				}else{
					$(clickObj).next("select").empty().hide();
				}
				
			}
			closeLoadingBox();
		},
		dataType:'json'
	});
}
</script>
                    </td>
                </tr>
                <tr>
                	<td width="120" align="right">收货地址：</td>
                    <td width="290"><input type="text" value="<?php echo ($ary_orders["o_receiver_address"]); ?>" name="o_receiver_address" class="medium"></td>
                    <?php if(($ary_orders["o_receiver_idcard"]) != ""): ?><td width="90" align="right">身份证号：</td>
                    <td><input type="text" name="o_receiver_idcard" value="<?php echo ($ary_orders["o_receiver_idcard"]); ?>" class="medium"></td><?php endif; ?>
                </tr>  
            </table>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">配送方式</h2>
           <dl class="dl02" id="logistic_dl" style="margin-left:10px;">
			<?php if($ary_logistic!=''): if(is_array($ary_logistic)): $key = 0; $__LIST__ = $ary_logistic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$logistic): $mod = ($key % 2 );++$key;?><dd>
			            <input type="radio" onclick="checkLogistic(<?php echo ($logistic["lt_id"]); ?>)" class="aaa" id="lt_id" value="<?php echo ($logistic["lt_id"]); ?>" name="lt_id"  <?php if($ary_orders[lt_id] == $logistic[lt_id]): ?>checked<?php endif; ?>>
			            <label  for="kuaidi"><?php echo ($logistic["lc_name"]); ?></label>
			            <span >运费 + <i id="logistic_price_<?php echo ($logistic["lt_id"]); ?>"><?php echo ($logistic["logistic_price"]); ?></i>元</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            <span >配送公司描述： <?php echo ($logistic["lc_description"]); ?></span>
			            <input type="hidden" id="o_cost_freight" name="o_cost_freight" value="<?php echo ($logistic["logistic_price"]); ?>">
			        </dd><?php endforeach; endif; else: echo "" ;endif; ?>
			<?php else: ?>
			    <dd>无配送方式</dd><?php endif; ?>   
           </dl>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">商品信息</h2>
            <div class="orderList">
                   
                <table class="tbList wtb edigt" >
                    <thead>
                        <tr>
                            <th>商品图片1</th>
                            <th>商品货号</th>
                            <th>商品名称</th>
                            <th>商品编码</th>
                            <th>商品规格</th>
                            <th>销售价</th>
                            <th>成交价</th>
                            <th>折扣或价格</th>
                            <th>数量</th>
                            <th>小计</th>
                            <th>促销</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="product_info">
                    <?php if(is_array($ary_orders_info)): $i = 0; $__LIST__ = $ary_orders_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$orders_info): $mod = ($i % 2 );++$i; if($orders_info[0]['fc_id'] != 0): if(is_array($orders_info)): $i = 0; $__LIST__ = $orders_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_items): $mod = ($i % 2 );++$i; if(is_array($free_items["items"])): $i = 0; $__LIST__ = $free_items["items"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_item): $mod = ($i % 2 );++$i;?><tr class="free_<?php echo ($free_item["fc_id"]); ?>">
			                            <td><img src='<?php echo (showimage($free_item["g_picture"],68,68)); ?>' width="58" height="58" /></td>
			                            <td><?php echo ($free_item["pdt_sn"]); ?>
			                            </td>
			                            <td><p class="proN"><?php echo ($free_item["oi_g_name"]); ?></p></td>
			                            <td><?php echo ($free_item["g_sn"]); ?></td>
			                            <td>
			                            <?php if($free_item["pdt_spec"] != ''): echo ($free_item['pdt_spec']); ?>
			                            <!-- 
			                                <select class="small">
			                                	<noempty name="free_item['pdt_specs']">
			                                	<?php foreach($free_item['pdt_specs'] as $spec){ ?>
			                                	<option value="<?php echo ($spec["gs_id"]); ?>" <?php if($free_item['pdt_spec'] == $spec['gsd_value']): ?>selected<?php endif; ?>><?php echo ($spec["gsd_value"]); ?></option>
			                                	<?php } ?>
			                                	</noempty>
			                                </select>   
			                             --><?php endif; ?>
			                        	</td>
			                            <td><span id=""><?php echo ($free_item["pdt_sale_price"]); ?></span></td>
			                            <td><span id=""><?php echo ($free_item["oi_price"]); ?></span></td>
			                            <td>
			                            	
			                            </td>
			                            <td>
			                            	<p class="width75">			
												<?php echo ($free_item["oi_nums"]); ?>
			                                </p>
			                            </td>
			                            
			                            <td style="border-right:1px solid #D7D7D7"> <?php echo ($free_item["subtotal"]); ?></td>
			                             <td><span class="orange">自由推荐</span></td>
			                            <?php if($key == 0): ?><td style="border-bottom:0px"><a item_type="4" o_id="<?php echo ($free_item["o_id"]); ?>" design_id="<?php echo ($free_item["fc_id"]); ?>"  class="delItem" >删除</a></td><?php endif; ?>
			                           
			                        </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                    	<?php else: ?>
                    	<!-- 赠品无需编辑 -->
                    		<?php if($orders_info["oi_type"] != 2): ?><!-- 积分商城商品只允许删除，团购商品暂时不允许编辑-->
                    			<?php if(($orders_info["oi_type"] == 1) or ($orders_info["oi_type"] == 5)): ?><tr class="point_<?php echo ($orders_info["pdt_id"]); ?>">
			                            <td><img src='<?php echo (showimage($orders_info["g_picture"],68,68)); ?>' width="58" height="58" /></td>
			                            <td><?php echo ($orders_info["pdt_sn"]); ?>
			                            </td>
			                            <td><p class="proN"><?php echo ($orders_info["oi_g_name"]); ?></p></td>
			                            <td><?php echo ($orders_info["g_sn"]); ?></td>
			                            <td>
											<?php echo ($orders_info["pdt_spec"]); ?>
			                        	</td>
			                        	<?php if($orders_info["oi_type"] == 5): ?><td> <?php echo ($orders_info["pdt_sale_price"]); ?></td>
			                        	<?php else: ?>
			                        	 <td> <?php echo ($orders_info["pdt_sale_price"]); ?>积分</td><?php endif; ?>
			                            <td> <?php echo ($orders_info["oi_price"]); ?></td>
			                            <td>
			                            </td>
			                            <td>
			                            <!-- 暂时不支持
				                          <a href="javascript:void(0);" class="down reduce cartRed add" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" stock="<?php echo ($orders_info['pdt_infos']['pdt_stock']); ?>" pdt_sale_price="<?php echo ($orders_info['pdt_infos']['pdt_sale_price']); ?>" type="1"></a>
		                                  <input type="text" class="inputNum" readonly value="<?php echo ($orders_info["oi_nums"]); ?>" types="3" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" stock="<?php echo ($orders_info['pdt_infos']['pdt_stock']); ?>"  good_type="1" id="nums_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_1"/>
		                                  <input type="hidden" value="<?php echo ($orders_info["oi_nums"]); ?>" id="old_nums_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_1"/>
		                                  <a href="javascript:void(0);" class="up add" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" stock="<?php echo ($orders_info['pdt_infos']['pdt_stock']); ?>" pdt_sale_price="<?php echo ($orders_info['pdt_infos']['pdt_sale_price']); ?>" type="2"></a>
		                                  <span class="brownblock marTop5" style="display: none;" id="jf_msg">积分不足</span>
		                                -->
		                                  <?php echo ($orders_info["oi_nums"]); ?>
			                            </td>
			                            <td> <?php echo ($orders_info["subtotal"]); ?></td>
			                            <td><span class="orange">团购</span></td>
			                            <td>
			                            <?php if($orders_info["oi_type"] != 5): ?><a data-url="/Admin/Orders/delItems?type=1&g_id=<?php echo ($orders_info["g_id"]); ?>"  item_type="1" o_id="<?php echo ($orders_info["o_id"]); ?>" design_id="<?php echo ($orders_info["pdt_id"]); ?>" onclick="delItem(1,<?php echo ($orders_info["pdt_id"]); ?>,<?php echo ($orders_info["o_id"]); ?>)" >删除</a><?php endif; ?>
			                            </td>
			                        </tr>    
                    			<?php else: ?>
                    			<!-- 3组合商品只允许删除-->
                    			<?php if($orders_info["oi_type"] == 3): if(is_array($orders_info)): $i = 0; $__LIST__ = $orders_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_items): $mod = ($i % 2 );++$i; if(is_array($free_items["items"])): $i = 0; $__LIST__ = $free_items["items"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_item): $mod = ($i % 2 );++$i;?><tr class="combo_<?php echo ($free_item["fc_id"]); ?>">
					                            <td><img src='<?php echo (showimage($free_item["g_picture"],68,68)); ?>' width="58" height="58" /></td>
					                            <td><?php echo ($free_item["pdt_sn"]); ?></td>
					                            <td><p class="proN"><?php echo ($free_item["oi_g_name"]); ?></p></td>
					                            <td><?php echo ($free_item["g_sn"]); ?></td>
					                            <td>
												<?php echo ($free_item['pdt_spec']); ?>
					                        	</td>
					                            <td> <?php echo ($free_item["pdt_sale_price"]); ?></td>
					                            <td> <?php echo ($free_item["oi_price"]); ?></td>
					                            <td>
					                            	
					                            </td>
					                            <td>
													<?php echo ($free_item["oi_nums"]); ?>
					                            </td>
					                            <td style="border-right:1px solid #D7D7D7"> <?php echo ($free_item["subtotal"]); ?></td>
					                            <td><span class="orange">组合商品</span></td>
					                            <?php if($key == 0): ?><td style="border-bottom:0px">
					                            <?php if($free_item["oi_type"] != 5): ?><a o_id="<?php echo ($free_item["o_id"]); ?>"  item_type="3"  design_id="<?php echo ($free_item["fc_id"]); ?>" class="delItem" >删除</a><?php endif; ?>
					                            </td><?php endif; ?>
					                        </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>                   			
                    			<?php else: ?>
                    			
                    				 <tr class="normal_<?php echo ($orders_info["pdt_id"]); ?>">
			                            <td><img src='<?php echo (showimage($orders_info["g_picture"],68,68)); ?>' width="58" height="58" /></td>
			                            <td><?php echo ($orders_info["pdt_sn"]); ?>
			                                <input type='hidden' class='pro_pdt_sn' name='pro_pdt_sn[]' value='<?php echo ($orders_info["pdt_sn"]); ?>'>
									        <input type='hidden' name='pro_pdt_id[]' value='<?php echo ($orders_info["pdt_id"]); ?>'>
									        <input type='hidden' name='pro_g_id[]' value='<?php echo ($orders_info["g_id"]); ?>'>
									        <input type='hidden' name='pro_type[]' value='0'>
											<input type='hidden' name='is_new[]' value='0'>
			                            </td>
			                            <td><p class="proN"><?php echo ($orders_info["oi_g_name"]); ?></p></td>
			                            <td><?php echo ($orders_info["g_sn"]); ?></td>
			                            <td>
			                            <if condition="$orders_info.pdt_spec neq ''">
			                            <?php echo ($orders_info['pdt_spec']); ?>
			                            <!-- 
			                                <select class="small" id="modifyNormalSku">
			                                    <noempty name="orders_info['pdt_specs']">
			                                	<?php foreach($orders_info['pdt_specs'] as $spec){ ?>
			                                	<option value="<?php echo ($spec["pdt_id"]); ?>" pdt_id="$spec['pdt_id']" <?php if($orders_info['pdt_spec'] == $spec['gsd_value']){ ?>selected<?php } ?>><?php echo ($spec["gsd_value"]); ?></option>
			                                	<?php } ?>
			                                	</noempty>
			                                </select>   
			                             --><?php endif; ?>
			                        	</td>
			                            <td> <span id="sp_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["pdt_sale_price"]); ?></span></td>
			                            <td> <span id="op_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["oi_price"]); ?></span></td>
			                            <td>
			                            	<input type="text"  class="tiny textbox1" pdt_sale_price="<?php echo ($orders_info["pdt_sale_price"]); ?>" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" > 折= <input type="text" name="pro_price[]" class="tiny textbox2" pdt_sale_price="<?php echo ($orders_info["pdt_sale_price"]); ?>" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" id="rp_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0" value="<?php echo ($orders_info["oi_price"]); ?>">元
			                            </td>
			                            <td>
			                           	<p class="width75">
			                           	<a href="javascript:void(0);" class="down reduce cartRed add" m_price="<?php echo ($orders_info["oi_price"]); ?>" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" stock="<?php echo ($orders_info['pdt_infos']['pdt_stock']); ?>" pdt_sale_price="<?php echo ($orders_info['pdt_infos']['pdt_sale_price']); ?>" type="1"></a>
		                                <input type="text" class="inputNum" id="itemnum_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0" name="pro_num[]"  value="<?php echo ($orders_info["oi_nums"]); ?>" types="3" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" stock="<?php echo ($orders_info['pdt_infos']['pdt_stock']); ?>" good_type="0" />
			                              <a href="javascript:void(0);" class="up add" m_price="<?php echo ($orders_info["oi_price"]); ?>" pdt_id="<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>" stock="<?php echo ($orders_info['pdt_infos']['pdt_stock']); ?>" pdt_sale_price="<?php echo ($orders_info['pdt_infos']['pdt_sale_price']); ?>" type="2"></a>
			                            </p>
			                            </td>
			                            <td> <span id="total_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["subtotal"]); ?></span></td>
			                            <td><span class="orange"><?php echo ($orders_info["promotion"]); ?></span></td>
			                            <td><a o_id="<?php echo ($orders_info["o_id"]); ?>"    item_type="0"  design_id="<?php echo ($orders_info["pdt_id"]); ?>"  class="delItem" >删除</a></td>
			                        </tr><?php endif; ?>
                    			<!-- 3组合商品只允许删除--><?php endif; ?>
                    			<!-- 积分商城商品只允许编辑 --><?php endif; ?>          	
                    	</if>
                    	<?php if($orders_info["oi_type"] == 2): ?><tr class="normal_<?php echo ($orders_info["pdt_id"]); ?>">
			                            <td><img src='<?php echo (($orders_info["g_picture"])?($orders_info["g_picture"]):"__PUBLIC__/Ucenter/images/pdtDefault.jpg"); ?>' width="58" height="58" /></td>
			                            <td><?php echo ($orders_info["pdt_sn"]); ?>
			                            </td>
			                            <td><p class="proN"><?php echo ($orders_info["oi_g_name"]); ?></p></td>
			                            <td><?php echo ($orders_info["g_sn"]); ?></td>
			                            <td>
			                            <?php if($orders_info["pdt_spec"] != ''): echo ($orders_info['pdt_spec']); endif; ?>
			                        	</td>
			                            <td> <span id="sp_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["pdt_sale_price"]); ?></span></td>
			                            <td> <span id="op_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["oi_price"]); ?></span></td>
			                            <td>
			                            	
			                            </td>
			                            <td>
			                            <?php echo ($orders_info["oi_nums"]); ?>
			                            </td>
			                            <td> <span id="total_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["subtotal"]); ?></span></td>
			                            <td><span class="orange">赠品</span></td>
			                            <td></td>
			                        </tr><?php endif; endforeach; endif; else: echo "" ;endif; ?> 
                    </tbody>
                </table>
				<?php if($ary_orders_info[0]['oi_type'] != 5): ?><p class="textCenter" style="text-align:left;">
                		添加商品货号：
                        <input type="text"  id="pdt_sn" class="large" onkeypress="EnterPress(event)" />
                        		直接按回车
                        <button type="button" id="addGoods"  class="btnA submit-button">添加商品</button>
                        &nbsp;&nbsp;<button type="button" id="getPrices"  class="btnA submit-button" >计算价格</button>
                        	<span style="color:red;">（如需及时看下订单相关金额请点击计算价格）</span>
                        <div id="goodsSelect" style="display: none;" title="请选择商品">
                            
<div id="isAjax" style="display:none">用此ID标识本页面是通过ajax载入进来的</div>
<div class="rightInner load" id="goodsSelecterInner">
    <table width="100%" class="tbForm">
        <thead>
            <tr class="title">
                <th colspan="99">查找商品</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>商品货号</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["pdt_sn"]); ?>" name="pdt_sn" id="pdt_sn" />
                </td>
                <td>商品名称</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["g_name"]); ?>" name="gs_name" id="gs_name" />
                </td>
                <td>商品分类</td>
                <td>
                    <select class="medium" name="gs_gcid" id="gs_gcid">
                        <option value="0"> - 全部分类 - </option>
                        <?php if(is_array($search["cates"])): $i = 0; $__LIST__ = $search["cates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["gc_id"]); ?>" <?php if(($chose["gcid"]) == $cate[gc_id]): ?>selected="selected"<?php endif; ?> ><?php $__FOR_START_3521__=0;$__FOR_END_3521__=$cate[gc_level];for($i=$__FOR_START_3521__;$i < $__FOR_END_3521__;$i+=1){ ?>&nbsp;&nbsp;<?php } echo ($cate["gc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
                <td colspan="99" align="right">
                    <input type="button" value="查 找" class="btnA" onclick="goodsSelecterSerch();" >
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="rightInner load" id="goodsSelecterList">
    <table width="100%" class="tbList">
        <thead>
            <tr>
                <th><input type="checkbox" class="ckeckAll" /></th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>商品货号</th>
                <th>规格名称</th>
                <th>分类</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" class="checkSon" name="gs_pdt_sn" value="<?php echo ($goods["pdt_sn"]); ?>" /></td>
                <td><img src='<?php echo (($goods["g_picture"])?($goods["g_picture"]):"Ucenter/images/pdtDefault.jpg"); ?>' class="img32" /></td>
                <td><?php echo ($goods["g_name"]); ?><br><span class="blue"><?php echo ($goods["g_sn"]); ?></span></td>
                <td><?php echo ($goods["pdt_sn"]); ?></td>
                <td><?php echo ($goods["pdt_spec"]); ?></td>
                <td><?php echo ($goods["gc_name"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(empty($list)): ?><tr><td colspan="99" class="left">没有查找到结果! 没有相关的数据或者请先进行查找~ </td></tr><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99"><span class="right page"><?php echo ($page); ?></span></td>
            </tr>
        </tfoot>
    </table>
    <div class="clear"></div>
</div>
<script src="__PUBLIC__/Admin/js/loading.js"></script>
<script>
$("#g_gifts").click(function(){
    if($(this).val()=='1'){
        $("#g_gifts").val('0');
    }else{
        $("#g_gifts").val('1');
    }
})

//查找商品 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function goodsSelecterSerch(){
    var g_gifts =  $("#g_gifts").val();
    var data = {
        'pdt_sn':$("input[name='pdt_sn']").val(),
        'g_name':$("input[name='gs_name']").val(),
        'gs_gcid':$('#gs_gcid').val(),
        'g_gifts':g_gifts
    };
    var url = "<?php echo U('Admin/Goods/getProductsInfo');?>";
    $.get(url,data,function(info){
        $('#isAjax').parent().html(info);
    },'text');
}
</script>
                        </div>
                        
                </p><?php endif; ?>
            </div>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">商品信息</h2>
            <table class="tbForm">
            	<tr>
                	<td width="120" align="right">商品总金额：</td>
                    <td width="290"><input type="text" class="medium" disabled id="o_goods_all_price" name="o_goods_all_price" value="<?php echo ($ary_orders["o_goods_all_price"]); ?>"></td>
                    <td width="90" align="right">配送费用：</td>
                    <td>
                    <input type="text" class="medium"  id="old_cost_freight" name="old_cost_freight"  value="<?php echo ($ary_orders["o_cost_freight"]); ?>">
                    <input type="hidden" class="medium"  id="cost_freight"  value="<?php echo ($ary_orders["o_cost_freight"]); ?>">
					<input type="hidden" id="last_freight" value="<?php echo ($ary_orders["o_cost_freight"]); ?>" />
                    </td>
                </tr>
                <tr>
                	<!-- 
                	<td align="right">发票税额：</td>
                    <td><input type="text" class="medium"></td>
                     -->
                 	<td align="right">发票抬头：</td>
                 	<?php if($ary_orders['invoice_head'] == '1'): ?><td><input type="text" class="medium" value="<?php echo ($ary_orders['invoice_people']); ?>" name="old_invoice_head" ></td>   
                 	<?php else: ?>
                 	<td><input type="text" class="medium" value="<?php echo ($ary_orders['invoice_name']); ?>" name="old_invoice_head" ></td><?php endif; ?>
                        
                    <td align="right">发票内容：</td>
                    <td><input type="text" class="medium" value="<?php echo ($ary_orders["invoice_content"]); ?>" name="old_invoice_content"> &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void()" class="updateA btnA">修改</a></td>
                </tr>
                <tr>
                	<td align="right">优惠金额：</td>
                    <td><input type="text" class="medium" id="pre_price" disabled value="<?php echo ($ary_orders["o_discount"]); ?>"></td>
                    <!-- 
                    <td align="right">商品重量：</td>
                    <td><input type="text" class="medium">g</td>
                     -->
                    <td align="right">支付手续费：</td>
                    <td><input type="text" name="o_cost_payment" id="o_cost_payment" disabled value="<?php echo ($ary_orders["o_cost_payment"]); ?>" class="medium"></td>
                </tr>
                <?php if($ary_orders['o_coupon_menoy'] == '0.000'): if($ary_orders_info[0]['oi_type'] != 5): ?><tr>
					<td width="72" align="right" valign="top">使用优惠券：</td>
					<td>
					<input type="text" class="medium" id="coupon_input" name="coupon_input"
											value="" class="input01" /> 
											
											<input class="btnA submit-button medium" type="button" id=""
											name="" onclick="doCoupon();"  value="使用" /> 
											
					</td>
				</tr><?php endif; ?>
				<tr id="showPromotion" style="display:none;">
				<td width="72" align="right" valign="top">享受促销信息：</td>
				<td colspan="3">
				<span id="sp_detail" class="orange">
				
				</span>
				</td>
				</tr><?php endif; ?>
                    </td>
                    <td align="right">订单总金额：</td>
                    <td><strong> <span id="showAllPricce"><?php echo ($ary_orders["o_all_price"]); ?></span></strong>
                    <input type="hidden" id="old_all_price"  readonly value="<?php echo ($ary_orders["o_all_price"]); ?>"/>
                    </td>
                </tr>
                <tr>
                	<td align="right">使用优惠券：</td>
                    <td colspan="3"><strong> <?php echo ($ary_orders['o_coupon_menoy']?$ary_orders['o_coupon_menoy']:'0'); ?></strong></td>
                </tr>
                <tr>
                	<td align="right">使用红包：</td>
                    <td colspan="3"><strong> <?php echo ($ary_orders['o_bonus_money']?$ary_orders['o_bonus_money']:'0'); ?></strong></td>
                </tr>
			</table>
            <div class="updateDiv" style="display:none;left:755px;pading-left:3px;top:-95px; padding-top:0px;"><!--updateDiv  start-->
            	 <?php if($invoice_info['is_invoice'] == 1 ): ?><div class="billInfo"><!--发票信息  开始-->
                        <style>
                        table.normalT01 td {
						    color: #333333;
						    padding: 5px 0;
						}
                        </style>
                        
                        <div class="billICon"  id="invoice_show"><!--billICon  start-->
                            <h2 style="height:25px; background-color:#ccc; line-height:25px; font-size:14px; padding-left:10px">发票</h2>
                            <table class="normalT01" style="margin-left:20px">
                                <tr>
                                    <td width="65">需要发票：</td>
                                    <td>
                                        <input type="radio"  name="is_invoice" value="1" <?php if($ary_orders['is_invoice'] =='1'){echo 'checked="checked"';} ?>> <label for="rada">需要</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="is_invoice" value="0"   <?php if($ary_orders['is_invoice'] ==0){echo 'checked="checked"';} ?>> <label for="rada02">不需要</label>
                                    </td>
                                </tr>                            
                                <tr>
                                    <td width="65">发票类型：</td>
                                    <td>
                                        <?php if(($invoice_info["invoice_comom"]) == "1"): ?><input type="radio" id="rada" name="invoice_type" value="1" <?php if($ary_orders['invoice_type'] =='1'){echo 'checked';} ?>> <label for="rada">普通发票</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?>
                                        <?php if(($invoice_info["invoice_special"]) == "2"): ?><input type="radio" id="rada02" name="invoice_type" value="2" <?php if($ary_orders['invoice_type'] =='2'){echo 'checked';} ?>> <label for="rada02">增值税发票</label><?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="hdT01">
                                            <tr>
                                                <td width="65">发票抬头：</td>
                                                <td>
                                                    <?php if(($invoice_info["invoice_personal"]) == "1"): ?><input type="radio" id="radp"  name="invoice_head" value="1" <?php if($ary_orders['invoice_head'] =='1'){echo 'checked';} ?> > <label for="radp">个人</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <eq>
                                                    <eq name="invoice_info.invoice_unit" value="1">
                                                    <input type="radio" id="radp02"  name="invoice_head" value="2" <?php if($ary_orders['invoice_head'] =='2'){echo 'checked';} ?> > <label for="radp02">单位 </label><?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <table class="personalT" <?php if($ary_orders["invoice_head"] != 1): ?>style="display:none"<?php endif; ?>>
                                                        <tr>
                                                            <td width="65">个人姓名：</td>
                                                            <td><span class="tex01"><input type="text" class="medium"  id="invoice_people" name="invoice_people" value="<?php echo ($ary_orders['invoice_people']); ?>"></span></td>
                                                        </tr>
                                                    </table>
                                                    <table class="unitT" <?php if($ary_orders["invoice_head"] != 2): ?>style="display:none"<?php endif; ?>>
                                                        <tr>
                                                            <td width="65">单位名称：</td>
                                                            <td><span class="tex01"><input type="text" class="medium"  id="invoice_name" name="invoice_name1" value="<?php echo ($ary_orders['invoice_name']); ?>"></span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                                <tr>
                                                    <td>发票内容：</td>
                                                    <td>
                                                        <input type="text" class="medium" value="<?php echo ($ary_orders['invoice_content']); ?>" name='invoice_content1' id='invoice_content'>
                                                    </td>
                                                </tr>
                                               <tr><td colspan="2" style="text-align:right;"><a class="delInvoice btnA" style="marin-left:10px;" vclass="hdT01">确定</a></td></tr>
                                        </table>
                                        <table class="hdT02" style="display:none;">
                                            <tr>
                                                <td colspan="2">增值税发票专用发票资质填写：</td>
                                            </tr>
                                            <tr>
                                                <td width="100" align="right">单位名称：</td>
                                                <td><span class="tex01"><input type="text" value="<?php echo ($ary_orders['invoice_name']); ?>" name='invoice_name' id='invoice_names' validate="{ required:true}"></span> <span class="red">*</span></td>
                                            </tr>
                                            <tr>
                                                <td align="right">纳税人识别号：</td>
                                                <td><span class="tex01"><input type="text" value="<?php echo ($ary_orders['invoice_identification_number']); ?>" name='invoice_identification_number' id='invoice_identification_number'></span> <span class="red">*</span></td>
                                            </tr>
                                            <tr>
                                                <td align="right">注册地址：</td>
                                                <td><span class="tex01"><input type="text" value="<?php echo ($ary_orders['invoice_address']); ?>"  name='invoice_address' id='invoice_address'></span> <span class="red">*</span></td>
                                            </tr>
                                            <tr>
                                                <td align="right">注册电话：</td>
                                                <td><span class="tex01"><input type="text" value="<?php echo ($ary_orders['invoice_phone']); ?>" name='invoice_phone' id='invoice_phone'></span> <span class="red">*</span></td>
                                            </tr>
                                            <tr>
                                                <td align="right">开户银行：</td>
                                                <td><span class="tex01"><input type="text" value="<?php echo ($ary_orders['invoice_bank']); ?>" name='invoice_bank' id='invoice_bank'></span> <span class="red">*</span></td>
                                            </tr>
                                            <tr>
                                                <td align="right" valign="top">银行帐户：</td>
                                                <td>
                                                    <span class="tex01"><input type="text" value="<?php echo ($ary_orders['invoice_account']); ?>" name='invoice_account' id='invoice_account'></span> <span class="red">*</span>                
                                                </td>
                                            </tr>
      
                                             <tr>
                                                 <td align="right">发票内容：</td>
                                                 <td>
													<input type="text" value="<?php echo ($ary_orders['invoice_account']); ?>" name='invoice_content' id='invoice_content'>
                                            	 </td>
                                             </tr>
											<tr><td colspan="2" style="text-align:right;"><a class="delInvoice btnA" style="marin-left:10px;" vclass="hdT02">确定</a></td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div><!--billICon  end-->
                    </div><!--发票信息  结束--><?php endif; ?>
                   
            </div><!--updateDiv  end-->
        </div><!--orderEdit  end-->
        </div>
        <div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">订单备注</h2>
            <table class="tbForm">
            	<tr>
                	<td width="120" align="right">订单买家留言：</td>
                    <td><?php echo ($ary_orders['o_buyer_comments']); ?></td>
                </tr>
                <tr>
                	<td align="right">标记：</td>
                    <td>
                    	<input type="radio" name="flag_type" <?php if($ary_orders['flag_type'] == '1'){echo 'checked';} ?> value="1" > <label><img src="__PUBLIC__/Admin/images/colorPic.png" width="12" height="12"></label> &nbsp;&nbsp;
                        <input type="radio" name="flag_type" <?php if($ary_orders['flag_type'] == '2'){echo 'checked';} ?> value="2"> <label><img src="__PUBLIC__/Admin/images/colorPic02.png" width="12" height="12"></label> &nbsp;&nbsp;
                        <input type="radio" name="flag_type" <?php if($ary_orders['flag_type'] == '3'){echo 'checked';} ?> value="3"> <label><img src="__PUBLIC__/Admin/images/colorPic03.png" width="12" height="12"></label> &nbsp;&nbsp;
                        <input type="radio" name="flag_type" <?php if($ary_orders['flag_type'] == '4'){echo 'checked';} ?> value="4"> <label><img src="__PUBLIC__/Admin/images/colorPic04.png" width="12" height="12"></label> &nbsp;&nbsp;
                        <input type="radio" name="flag_type" <?php if($ary_orders['flag_type'] == '5'){echo 'checked';} ?> value="5"> <label><img src="__PUBLIC__/Admin/images/colorPic05.png" width="12" height="12"></label> &nbsp;&nbsp;
                        <input type="radio" name="flag_type" <?php if($ary_orders['flag_type'] == '6'){echo 'checked';} ?> value="6"> <label><img src="__PUBLIC__/Admin/images/colorPic06.png" width="12" height="12"></label> &nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                	<td align="right" valign="top">订单卖家备注：</td>
                    <td><textarea class="mediumBox" name="o_seller_comments"><?php echo ($ary_orders['o_seller_comments']); ?></textarea></td>
                </tr>
            </table>
        <!--orderEdit  end-->
        <div>
        <p class="textCenter">
        <input type="hidden" value="<?php echo ($ary_orders['m_id']); ?>" id="m_id"  name="m_id"/>
        <input type="hidden" value="" id="edit_html"  name="edit_html"/>
        <input type="hidden" <?php if($ary_orders_info[0]['oi_type'] == '5'): ?>value="1"<?php else: ?>value="0"<?php endif; ?> id="is_edit"/>
        <input type="button" class="btnA" onclick="return submitFrom()" value="保存"> &nbsp;<a href="/Admin/Orders/pageList" class="btnA">关闭</a>
    </div>
</div>
</form>
<script src="__PUBLIC__/Admin/js/loading.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var pageEditHtml = $('#getPageEdit').html();
	//把html信息存起来
	$('#edit_html').val(pageEditHtml);
	<?php if($invoice_info['invoice_special'] == '2'){ ?>
    $(".hdT01").hide();
    $(".hdT02").show();
    <?php } ?>
	<?php if($invoice_info['invoice_comom'] == '1'){ ?>
    $(".hdT01").show();
    $(".hdT02").hide();
    <?php } ?>
}) 
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