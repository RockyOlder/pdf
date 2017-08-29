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
<div class="content" style="width:990px; margin:0 auto;">
<form  id="orderForm" name="orderForm" action="/Admin/Orders/doEditOk" method="post">
	<div class="rightInner" style="border:none" id="getPageEdit">
    	<div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">订单信息</h2>
        	<table class="tbForm">
            	<tr>
                	<td width="120" align="right">订单号：</td>
                    <td width="290"><?php echo ($ary_orders["o_id"]); ?><input type="hidden" name="o_id" id="o_id" value="<?php echo ($ary_orders["o_id"]); ?>"/></td>
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
                    <td colspan="3"><?php echo ($ary_orders['payment_name']); ?></td>
                </tr>
            </table>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit"><!--orderEdit  start-->
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
                	<td align="right">收货地址：</td>
                    <td colspan="3" ><input type="text" value="<?php echo ($ary_orders["o_receiver_address"]); ?>" name="o_receiver_address" class="medium"></td>
                    </td>
                </tr>  
            </table>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">配送方式</h2>
           <dl class="dl02" id="logistic_dl" style="margin-left:10px;">
			<?php if($ary_logistic!=''): if(is_array($ary_logistic)): $key = 0; $__LIST__ = $ary_logistic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$logistic): $mod = ($key % 2 );++$key;?><dd>
			            <input type="radio" onclick="checkLogistic1(<?php echo ($logistic["lt_id"]); ?>)" class="aaa" id="lt_id" value="<?php echo ($logistic["lt_id"]); ?>" name="lt_id"  <?php if($ary_orders[lt_id] == $logistic[lt_id]): ?>checked<?php endif; ?>>
			            <label  for="kuaidi"><?php echo ($logistic["lc_name"]); ?></label>
			            <span >运费 + <i id="logistic_price_<?php echo ($logistic["lt_id"]); ?>"><?php echo ($logistic["logistic_price"]); ?></i>元</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            <span >配送公司描述： <?php echo ($logistic["lc_description"]); ?></span>
			        </dd><?php endforeach; endif; else: echo "" ;endif; ?>
			<?php else: ?>
			    <dd>无配送方式</dd><?php endif; ?>   
           </dl>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">商品信息</h2>
            <div class="orderList">
                <table class="tbList wtb">
                    <thead>
                        <tr>
                            <th>商品图片</th>
                            <th>商品货号</th>
                            <th>商品名称</th>
                            <th>商品编码</th>
                            <th>商品规格</th>
                            <th>销售价</th>
                            <th>会员价</th>
                            <th>折扣或价格</th>
                            <th>数量</th>
                            <th>小计</th>
                            <!-- 
                            <th>操作</th> -->
                        </tr>
                    </thead>
                    <tbody id="product_info">
                    
                    <?php if(is_array($ary_orders_info)): $i = 0; $__LIST__ = $ary_orders_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$orders_info): $mod = ($i % 2 );++$i; if($orders_info[0]['fc_id'] != 0): if(is_array($orders_info)): $i = 0; $__LIST__ = $orders_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_items): $mod = ($i % 2 );++$i; if(is_array($free_items["items"])): $i = 0; $__LIST__ = $free_items["items"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_item): $mod = ($i % 2 );++$i;?><tr class="free_<?php echo ($free_item["fc_id"]); ?>">
			                            <td><img src='<?php echo (($free_item["g_picture"])?($free_item["g_picture"]):"__PUBLIC__/Ucenter/images/pdtDefault.jpg"); ?>' width="58" height="58" /></td>
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
			                            	<?php echo ($free_item["oi_price"]); ?>
			                            </td>
			                            <td>
			                            	<p class="width75">			
												<?php echo ($free_item["oi_nums"]); ?>
			                                </p>
			                            </td>
			                            <td style="border-right:1px solid #D7D7D7"><?php echo ($free_item["subtotal"]); ?></td>
			                        </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                    	<?php else: ?>
                    	<!-- 赠品无需编辑 -->
                    		<?php if($orders_info["oi_type"] != 2): ?><!-- 积分商城商品只允许删除-->
                    			<?php if($orders_info["oi_type"] == 1): ?><tr class="point_<?php echo ($orders_info["pdt_id"]); ?>">
			                            <td><img src='<?php echo (($orders_info["g_picture"])?($orders_info["g_picture"]):"__PUBLIC__/Ucenter/images/pdtDefault.jpg"); ?>' width="58" height="58" /></td>
			                            <td><?php echo ($orders_info["pdt_sn"]); ?>
			                            </td>
			                            <td><p class="proN"><?php echo ($orders_info["oi_g_name"]); ?></p></td>
			                            <td><?php echo ($orders_info["g_sn"]); ?></td>
			                            <td>
											<?php echo ($orders_info["pdt_spec"]); ?>
			                        	</td>
			                            <td><?php echo ($orders_info["pdt_sale_price"]); ?>积分</td>
			                            <td><?php echo ($orders_info["oi_price"]); ?></td>
			                            <td>
			                            <?php echo ($orders_info["oi_price"]); ?>
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
			                            <td><?php echo ($orders_info["subtotal"]); ?></td>
			                            
			                        </tr>    
                    			<?php else: ?>
                    			<!-- 3组合商品只允许删除-->
                    			<?php if($orders_info["oi_type"] == 3): if(is_array($orders_info)): $i = 0; $__LIST__ = $orders_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_items): $mod = ($i % 2 );++$i; if(is_array($free_items["items"])): $i = 0; $__LIST__ = $free_items["items"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$free_item): $mod = ($i % 2 );++$i;?><tr class="combo_<?php echo ($free_item["fc_id"]); ?>">
					                            <td><img src='<?php echo (($free_item["g_picture"])?($free_item["g_picture"]):"__PUBLIC__/Ucenter/images/pdtDefault.jpg"); ?>' width="58" height="58" /></td>
					                            <td><?php echo ($free_item["pdt_sn"]); ?></td>
					                            <td><p class="proN"><?php echo ($free_item["oi_g_name"]); ?></p></td>
					                            <td><?php echo ($free_item["g_sn"]); ?></td>
					                            <td>
												<?php echo ($free_item['pdt_spec']); ?>
					                        	</td>
					                            <td><?php echo ($free_item["pdt_sale_price"]); ?></td>
					                            <td><?php echo ($free_item["oi_price"]); ?></td>
					                            <td>
					                            	<?php echo ($free_item["oi_price"]); ?>
					                            </td>
					                            <td>
													<?php echo ($free_item["oi_nums"]); ?>
					                            </td>
					                            <td style="border-right:1px solid #D7D7D7"><?php echo ($free_item["subtotal"]); ?></td>
					                        </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>                   			
                    			<?php else: ?>
                    				 <tr class="normal_<?php echo ($orders_info["pdt_id"]); ?>">
			                            <td><img src='<?php echo (($orders_info["g_picture"])?($orders_info["g_picture"]):"__PUBLIC__/Ucenter/images/pdtDefault.jpg"); ?>' width="58" height="58" /></td>
			                            <td><?php echo ($orders_info["pdt_sn"]); ?>
			                                <input type='hidden' class='pro_pdt_sn' name='pro_pdt_sn[]' value='<?php echo ($orders_info["pdt_sn"]); ?>'>
									        <input type='hidden' name='pro_pdt_id[]' value='<?php echo ($orders_info["pdt_id"]); ?>'>
									        <input type='hidden' name='pro_g_id[]' value='<?php echo ($orders_info["g_id"]); ?>'>
									        <input type='hidden' name='pro_type[]' value='0'>
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
			                            <td><span id="sp_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["pdt_sale_price"]); ?></span></td>
			                            <td><span id="op_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["oi_price"]); ?></span></td>
			                            <td>
			                            	<?php echo ($orders_info["oi_price"]); ?>
			                            </td>
			                            <td>
			                           	<p class="width75">
											<?php echo ($orders_info["oi_nums"]); ?>
			                            </p>
			                            </td>
			                            <td><span id="total_<?php echo ($orders_info['pdt_infos']['pdt_id']); ?>_0"><?php echo ($orders_info["subtotal"]); ?></span></td>
			                        </tr><?php endif; ?>
                    			<!-- 3组合商品只允许删除--><?php endif; ?>
                    			<!-- 积分商城商品只允许编辑 --><?php endif; ?>          	
                    	</if><?php endforeach; endif; else: echo "" ;endif; ?> 
                    </tbody>
                </table>
                
            </div>
        </div><!--orderEdit  end-->
        
        <div class="orderEdit"><!--orderEdit  start-->
        	<h2 class="commonH2">商品信息</h2>
            <table class="tbForm">
            	<tr>
                	<td width="120" align="right">商品总金额：</td>
                    <td width="290"><?php echo ($ary_orders["o_goods_all_price"]); ?></td>
                    <td width="90" align="right">支付手续费：</td>
                    <td><?php echo ($ary_orders["o_cost_payment"]); ?></td>
                </tr>
                <tr>
                	<td align="right">配送费用：</td>
                    <td><input type="hidden" class="medium" name="old_cost_freight"  id="old_cost_freight"  value="<?php echo ($ary_orders["o_cost_freight"]); ?>"><?php echo ($ary_orders["o_cost_freight"]); ?></td>
                    <td align="right">邮费差价：</td>
                    <td><input type="hidden" value="<?php echo ($ary_orders["o_diff_freight"]); ?>" id="o_diff_freight" name="o_diff_freight"/><strong id="o_diff_freight_show"><?php echo ($ary_orders['o_diff_freight']?$ary_orders['o_diff_freight']:'0'); ?></strong></td>
                </tr>
                <tr>
                    <td align="right">发票抬头：</td>
                    <td><?php echo ($ary_orders["invoice_head"]); ?></td>
                    <td align="right">发票内容：</td>
                    <td><?php echo ($ary_orders["invoice_content"]); ?></td>
                </tr>
                <tr>
                	<td align="right">优惠金额：</td>
                    <td><?php echo ($ary_orders["o_discount"]); ?></td>
                    <td align="right">使用优惠券：</td>
                    <td><?php echo ($ary_orders['o_coupon_menoy']?$ary_orders['o_coupon_menoy']:'0'); ?></td>
                </tr>
                <tr>
                	<td align="right">订单总金额：</td>
                    <td><strong><?php echo ($ary_orders["o_all_price"]); ?><input type="hidden" id="old_all_price"  readonly value="<?php echo ($ary_orders["o_all_price"]); ?>"/></strong></td>
                    <td align="right">应付款金额：</td>
                    <td><strong><?php echo ($ary_orders["o_all_price"]); ?></strong></td>
                </tr>
            </table>
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
        </div><!--orderEdit  end-->
        </div>
        <p class="textCenter">
        <input type="hidden" value="<?php echo ($ary_orders['m_id']); ?>" id="m_id"  name="m_id"/>
        <input type="hidden" value="" id="edit_html"  name="edit_html"/>
        <input type="button" class="btnA" onclick="return submitFrom()" value="保存"> &nbsp;<a href="/Admin/Orders/pageList" class="btnA">关闭</a>
        </p>
    </div>
</div>
</form>
<script src="__PUBLIC__/Admin/js/loading.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var pageEditHtml = $('#getPageEdit').html();
	//把html信息存起来
	$('#edit_html').val(pageEditHtml);
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