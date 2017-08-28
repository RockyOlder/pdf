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
    <a href='<?php echo U("Admin/Orders/pageDetails?o_id=$ary_orders[o_id]");?>'><span onclick="setTab('tabListP',1,3)" id="tabListP1"class="onHover">订单详情</span></a>
    <a href='<?php echo U("Admin/Orders/pageOrdersLog?o_id=$ary_orders[o_id]");?>'><span onclick="setTab('tabListP',2,3)" id="tabListP2">订单日志</span></a>
    <a href='<?php echo U("Admin/Orders/pageOrdersReceipt?o_id=$ary_orders[o_id]");?>'><span onclick="setTab('tabListP',3,3)" id="tabListP3">售后单据</span></a>
</p>
<div class="rightInner" id="con_tabListP_1"><!--rightInner  start-->
    <table width="100%" class="tbList">
        <thead>
            <tr class="title">
                <th colspan="99">
					<P class="conOneP">
					<?php if(($$ary_orders["str_status"]) != "作废"): if($ary_orders['o_pay_status'] == 0 && $ary_orders["deliver_status"] != '已发货' && $ary_orders['o_status'] != 2): ?><a href="javascript:void(0)" onclick='InvalidOrder("<?php echo ($ary_orders["o_id"]); ?>")' class="btnB del03" id="order_cancel">强制作废</a><?php endif; ?>
                        <?php if($ary_orders["o_pay_status"] == '1' ): if($ary_orders['o_status'] != 2): if(!empty($$ary_orders['deliver_status'])): if($ary_orders['deliver_status'] != '已发货' && empty($ary_orders['refund_status']) && empty($ary_orders['o_audit'])){ ?>
                                <a href='<?php echo U("/Admin/Orders/pageEditOk?o_id=$ary_orders[o_id]");?>' class="btnB del03">订单编辑</a>
                            <?php } endif; endif; ?>
                        <?php else: ?>
						<?php if($ary_orders['o_status'] != 2): ?><a href='<?php echo U("/Admin/Orders/pageEdit?o_id=$ary_orders[o_id]");?>' class="btnB del03">订单编辑</a><?php endif; endif; endif; ?>
					</P>
				</th>
        </tr>
        </thead>
    </table>
    <div class="orderDetails"><!--orderDetails   start-->
        <div class="orderCon"><!--orderCon   start-->
            <h2 class="titleH2">买家信息</h2>
            <table class="tableOrder">
                <tr>
                    <td width="30%">会员：<?php echo ($members["m_name"]); ?></td>
                    <td width="30%">城市：<?php echo ($members["city"]); ?> <?php echo ($members["area"]); ?></td>
                    <td>邮件：<?php echo ($members["m_email"]); ?></td>
                </tr>
                <tr>
                    <td>真实姓名： <?php echo ($members["m_real_name"]); ?> </td>
                    <td>联系电话： <?php echo ($members['m_mobile']?$members['m_mobile']:$members['m_telphone']); ?></td>
                    <td>支付宝：<?php echo ($members['m_alipay_name']?$members['m_alipay_name']:'无'); ?></td>
                </tr>
            </table>
        </div><!--orderCon   end-->

        <div class="orderCon"><!--orderCon   start-->
            <h2 class="titleH2">订单信息</h2>
            <table class="tableOrder">
                <tr>
                    <td width="25%" name="o_id">订单编号：<?php echo ($ary_orders["o_id"]); ?></td>
                    <td width="25%">支付方式：<?php echo ($ary_orders["payment_name"]); ?></td>
                    <td>客服：<?php echo ($ary_orders["admin_name"]); ?></td>
                    <td>花费积分：<?php echo ($ary_orders['o_freeze_point']?$ary_orders['o_freeze_point']:'0'); ?></td>
                    <!--同步状态：<?php if($ary_orders[erp_sn] == ''): ?><span class="red">未同步</span><?php else: ?><span class="blue" style="color:green;">已同步</span><?php endif; ?></td>-->
                <!--<td>订单来源：<?php if($ary_orders['o_source_type'] == local): ?>分销本地 <elseif condition="$ary_orders['o_source_type'] eq taobao">淘宝<elseif condition="$ary_orders['o_source_type'] eq paipai">拍拍<?php endif; ?></td>-->
                </tr>
                <tr>
                    <td width="25%">优惠券金额：<?php echo ($ary_orders['o_coupon_menoy']?$ary_orders['o_coupon_menoy']:'0'); ?></td>
                    <td>红包金额：<?php echo ($ary_orders['o_bonus_money']?$ary_orders['o_bonus_money']:'0'); ?></td>
                    <!--
					<td>储值卡金额：<?php echo ($ary_orders['o_cards_money']?$ary_orders['o_cards_money']:'0'); ?></td>
                    <td>金币金额：<?php echo ($ary_orders['o_jlb_money']?$ary_orders['o_jlb_money']:'0'); ?></td>
					-->
					<td>积分抵扣金额：<?php echo ($ary_orders['o_point_money']?$ary_orders['o_point_money']:'0'); ?></td>
					<td>商品总金额：<?php echo ($ary_orders["o_goods_all_price"]); ?></td>
			   </tr>
                <tr>
                	<!-- 
                    <td>ERP订单号：<?php echo ($ary_orders["erp_sn"]); ?> </td>-->
                    <td>订单应付金额：<?php echo ($ary_orders["o_all_price"]); ?></td>
                    <td>第三方平台单号：<?php echo (($ary_orders["o_source_id"])?($ary_orders["o_source_id"]):""); ?></td>
                    <td>发货备注：<?php if($ary_orders['o_shipping_remarks'] == '1'): ?>发货先发，缺货后发
                                  <?php elseif($ary_orders['o_shipping_remarks'] == '2'): ?> 
                                    等缺货一起发
                                  <?php elseif($ary_orders['o_shipping_remarks'] == '3'): ?>
                                    修改订单，删除缺货商品<?php endif; ?> 
                    </td>
					<td>是否开发票：<?php if($ary_orders[is_invoice] == 1): ?><a href="#new">是</a><?php else: ?>否<?php endif; ?></td>
                </tr>
                <tr>
                    <td>下单时间：<?php echo ($ary_orders["o_create_time"]); ?> </td>
                    <td>支付手续费：<?php echo ($ary_orders["o_cost_payment"]); ?></td>
                    <td>订单实付金额：<?php echo ($ary_orders["o_pay"]); ?></td>

                    <td>订单买家留言：<?php echo ($ary_orders["o_buyer_comments"]); ?></td>
                </tr>
                <tr>
                    <td>订单状态：<?php if($ary_orders[str_status] != ''): ?><span class="red"><?php echo ($ary_orders["str_status"]); ?></span><?php else: echo ($ary_orders["str_pay_status"]); echo ($ary_orders["refund_status"]); echo ($ary_orders["refund_goods_status"]); echo ($ary_orders["deliver_status"]); endif; ?></td>
                    <td>配送费用：<?php echo ($ary_orders["o_cost_freight"]); ?></td>                       
                    <td>促销优惠金额：<?php echo ($ary_orders["o_discount"]); ?></td>
                    <td>订单卖家留言：<?php echo ($ary_orders["o_seller_comments"]); ?></td>
                </tr>
                 <tr>
                    <td><?php if($ary_orders[cacel_title] != ''): ?>作废类型：<?php echo ($ary_orders["cacel_title"]); endif; ?></td>
                    <td><?php if($ary_orders_info[0]['oi_type'] == 9): ?>是否试用订单: 是<?php endif; ?></td>                       
                    <td></td>
                    <td></td>
                </tr>
				<tr>
					<?php if($ary_orders['o_tax_rate'] > 0 ): ?><td>订单税额：<?php echo (number_format($ary_orders["o_tax_rate"],2)); ?></td><?php endif; ?>
				</tr>
            </table>
        </div><!--orderCon   end-->

        <h3 class="proInfoh3">订单信息</h3>
        <table width="100%" class="tbList addBorder">
            <thead>
                <tr>
                    <th>商品图片</th>
                    <th>商品货号</th>
                    <th>商品名称</th>
                    <th>商品编码</th>
                    <th>商品规格</th>
                    <th>原始单价</th>
                    <th>销售单价</th>
                    <th>数量</th>
                    <th>小计</th>
                    <th>促销</th>
                    <th>第三方成交价</th>
                    <th>价格区间</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($ary_orders_info)): $i = 0; $__LIST__ = $ary_orders_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$orders_info): $mod = ($i % 2 );++$i;?><tr>
                    <td><img src='<?php echo (C("DOMAIN_HOST")); echo (showimage($orders_info["g_picture"],68,68)); ?>' width="72" height="72" /></td>
                    <td <?php if($orders_info['pdt_range'] == 1): ?>style="color:red;"<?php endif; ?> ><?php echo ($orders_info["pdt_sn"]); ?></td>
                    <td><?php echo ($orders_info["oi_g_name"]); ?></td>
                    <td><?php echo ($orders_info["g_sn"]); ?></td>
                    <td><?php echo ($orders_info["pdt_spec"]); ?></td>
                    <td><?php echo ($orders_info["oi_price"]); ?></td>
                    <td>
						<?php echo sprintf("%0.2f",(($orders_info['subtotal']-$orders_info['promotion_price'])/$orders_info['oi_nums'])); ?>
					</td>
					<td><?php echo ($orders_info["oi_nums"]); ?></td>
                    <td>
						<?php echo sprintf("%0.2f",$orders_info['subtotal']-$orders_info['promotion_price']); ?>
					</td>
                    <td><span style="color:#E87A01;"><?php echo ($orders_info["promotion"]); ?></span></td>
                    <td><?php echo ($orders_info["oi_thd_sale_price"]); ?></td>
                    <td>
                        <span style="display:block"><?php echo (($orders_info["price_down"])?($orders_info["price_down"]):'0.000'); ?></span>
                        --
                        <span style="display:block"><?php echo (($orders_info["price_up"])?($orders_info["price_up"]):'0.000'); ?></span>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>    
            </tbody>
        </table>

        <div class="orderCon"><!--orderCon   start-->
            <h2 class="titleH2">物流信息</h2>
            <table class="tableOrder">
                <tr>
                    <td>收货人:<?php echo ($ary_orders["o_receiver_name"]); ?></td>
                </tr>
                <?php if(($ary_orders["o_receiver_idcard"]) != ""): ?><tr>
                    <td name="o_receiver_idcard">身份证号:<?php echo ($ary_orders["o_receiver_idcard"]); ?>&nbsp;<a href="javascript:void(0);" onClick="lookIDcard(this);">查看身份证号</a></td>
                    <input type="hidden" name="receiver_idcard" value="<?php echo ($ary_orders["o_receiver_idcard"]); ?>"/>
                </tr><?php endif; ?>
                <tr>
                    <td>收货地址:<?php echo ($ary_orders["o_receiver_state"]); echo ($ary_orders["o_receiver_city"]); echo ($ary_orders["o_receiver_county"]); echo ($ary_orders["o_receiver_address"]); ?></td>
                </tr>
                <tr>
                    <td>固定电话:<?php echo ($ary_orders["o_receiver_telphone"]); ?></td>
                </tr>
                <tr>
                    <td name="o_receiver_mobile">手机号码:<?php echo ($ary_orders["o_receiver_mobile"]); ?>&nbsp;<a href="javascript:void(0);" onClick="lookMobile(this);">查看手机号</a></td>
                    <input type="hidden" name="receiver_mobile" value="<?php echo ($ary_orders["o_receiver_mobile"]); ?>"/>
                </tr>
                <tr>
                    <td>运送方式:<?php echo ($ary_orders["str_logistic"]); ?></td>
                </tr>
                <tr>
                    <td>物流公司:<?php echo ($ary_delivery['delivery']['od_logi_name']); ?> </td>
                </tr>
                <tr>
                    <td>运单号:<?php echo ($ary_delivery['delivery']['od_logi_no']); ?></td>
                </tr>
                <tr>
					<?php if($is_zt == 1): ?><td>提货时间:<?php echo ($ary_orders["o_receiver_time"]); ?></td>
					<?php else: ?>
						<td>送货时间:<?php echo ($ary_orders["o_receiver_time"]); ?></td><?php endif; ?>
                </tr>
            </table>
        </div><!--orderCon   end-->
        <!--对发票显示的判断-->
        
     <?php if($ary_orders["is_invoice"] == 1): ?><div class="orderCon"><!--inVoice   start-->
            <h2 class="titleH2"><a name="new" style="color:black">发票信息</a></h2>
            <?php if($ary_orders["invoice_type"] == 2): ?><table class="tableOrder">
                <tr>
                    <td>发票类型：增值税发票</td>
                </tr>
                <tr>  
                    <td>单位名称：<?php echo ($ary_orders["invoice_name"]); ?></td>
                </tr>
                <tr>
                    <td>纳税人识别号：<?php echo ($ary_orders["invoice_identification_number"]); ?></td>
                </tr>
                <tr>
                    <td>注册地址：<?php echo ($ary_orders["invoice_address"]); ?></td>
                </tr>
                <tr>
                    <td>注册电话：<?php echo ($ary_orders["invoice_phone"]); ?></td>
                </tr>
                <tr>
                    <td>开户银行：<?php echo ($ary_orders["invoice_bank"]); ?></td>
                </tr>
                <tr>
                    <td>银行账户： <?php echo ($ary_orders["invoice_account"]); ?> </td>
                </tr>
                <tr>
                    <td>发票内容： <?php echo ($ary_orders["invoice_content"]); ?> </td>
                </tr>
            </table>
            <?php elseif($ary_orders["invoice_type"] == 1): ?>
            <table class="tableOrder">
                <tr>
                    <td>发票类型：普通发票</td>
                </tr>
                 <tr>
                    <td>发票抬头：<?php if($ary_orders['invoice_head'] == 1){ echo "个人";}else{echo "单位";} ?></td>
                </tr>
                <tr>
                    <td>发票内容:<?php echo ($ary_orders["invoice_content"]); ?></td>
                </tr>
                <tr>
                    <td>个人/公司名：<?php if($ary_orders['invoice_head'] == 1){echo $ary_orders['invoice_people'];}else{echo $ary_orders['invoice_name'];} ?></td>
                </tr>
            </table><?php endif; ?>
        </div><!--inVoice   end--><?php endif; ?>

        <!--
        <table width="100%" class="tbList">
            <tfoot>
            <td align="center"><input type="submit" class="btnA" value="保 存"> <input type="submit" class="btnA" value="关 闭"></td>
            </tfoot>
        </table>
        -->
    </div><!--orderDetails   end-->
</div><!--rightInner  end-->
<div id="pro_dialog" style="display:none;">
    <div id="ajax_loading">
        <div id="ajaxsenddiv_loading"><img src="__PUBLIC__/images/loading.gif" title="正在加载中..." style="margin-top:30px;"/></div>
    </div>
</div>

<div id="invalidOrder_div"  style="display: none"><!--弹框  开始-->
    <table class="alertTable">
       <tr>
            <td align="right" width="75" valign="top">作废类型：</td>
            <td>
                <select name="cacelType" id="cacelType" >
                	<option value="0">选择类型</option>
                	<option value="1">用户不想要了</option>
                	<option value="2">商品无货</option>
                	<option value="3">重新下单</option>
                	<option value="4">其他原因</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" width="75" valign="top">备注：</td>
            <td>
                <textarea id="orders_comments" class="mediumBox"><?php echo ($ary_orders["o_seller_comments"]); ?></textarea>
            </td>
        </tr>
        <!--
        <tr>
            <td></td>
            <td><input type="submit" class="btnA" value="确 定"> <input type="submit" class="btnA" value="取 消"></td>
        </tr>
        -->
    </table>
</div><!--弹框  结束-->
<script>
    function synOrders(obj){
        var oid = obj.attr("oid");
        var url = '/Admin/Orders/synOrder';
        $.ajax({
            url:url,
            cache:false,
            dataType:'json',
            type:'POST',
            data:{'oid':oid},
            beforeSend:function(){
                $("#ajax_loading").dialog({
                    height:150,
                    width:315,
                    modal:true,
                    title:'提示：努力加载中',
                    closeOnEscape:'false',
                    close:function (){
                        $("#ajax_loading").dialog('destroy');
                        $('#pro_diglog').append($('#ajax_loading'));
                    }
                });
            },
            success:function(msgObj){
                $("#ajax_loading").dialog('destroy');
                if(msgObj.success == '1'){
                    showAlert(true,"同步成功");
                }else{
                    showAlert(false,msgObj.msg);
                }
            }
        });
    }
    // TAB 切换
    function setTab(name,cursel,n){
        for(i=1;i<=n;i++){
            var tab=document.getElementById(name+i);
            var con=document.getElementById("con_"+name+"_"+i);
            tab.className=i==cursel?"onHover":"";
            con.style.display=i==cursel?"block":"none";
        }
    }
    function cacelReason(obj){
    	$("#orders_comments").val(obj.value);
    }
   //作废 
   function InvalidOrder(oid){
       var url ='/Admin/Orders/ajaxInvalidOrder';
       var orders_comments = $("#orders_comments").val();
       var cacel_type = $("#cacelType").val();
        $("#invalidOrder_div").dialog({
                    width:450,
                    height:300,
                    modal:true,
                    title:'',
                    buttons:{
                        '确定':function(){
                            if($("#orders_comments").val() == ''){
                                showAlert(false,'备注不能为空！');
                                $(this).dialog("close");
                                return false;
                            }
                            if($("#cacelType").val() == '0'){
                                showAlert(false,'作废类型为空！');
                                $(this).dialog("close");
                                return false;
                            }
                            $.post(url,{'oid':oid,'cacel_type':$("#cacelType").val(),'orders_comments':$("#orders_comments").val()},function(data){
                                // alert(data);return false;
                                 if(data==true){
									 $("#order_cancel").css('display', 'none');
                                     showAlert(true,'作废成功');
                                  }else{
                                     showAlert(false,'此订单不能作废');
                                  }
                             });
                            $(this).dialog("close");
                            return false;
                        }
                    }
                });
       //alert(oid);
       
       //var oid = '';
   }
    function lookMobile(obj){
        var url = "/Admin/Orders/showMobile";
        var html = $(obj);
        var or_oid = $("td[name='o_id']").html();
        var oid = or_oid.split("：")[1];
        var o_receiver_mobile = $("td[name='o_receiver_mobile']");
        var receiver_mobile = $("input[name='receiver_mobile']").val();
        if(html.html() == '查看手机号' && html.html() != '' && oid != '' && !isNaN(oid)){
            $.ajax({
                url : url,
                data : {'oid':oid},
                type:"post",
                dataType:"json",
                success:function(info){
                    if(info.mobile){
                        o_receiver_mobile.html('手机号码：'+info.mobile+'<a onclick="lookMobile(this)" href="javascript:void(0)">关闭显示'+'</a>');
                    }
                }
            })
        }
        if(html.html() == '关闭显示' && html.html() != ''){
            o_receiver_mobile.html('手机号码：'+receiver_mobile+'<a onclick="lookMobile(this)" href="javascript:void(0)">查看手机号'+'</a>');
        }

    }

    function lookIDcard(obj){
        var url = "/Admin/Orders/showIDcard";
        var html = $(obj);
        var or_oid = $("td[name='o_id']").html();
        var oid = or_oid.split("：")[1];
        var o_receiver_idcard = $("td[name='o_receiver_idcard']");
        var receiver_idcard = $("input[name='receiver_idcard']").val();
        if(html.html() == '查看身份证号' && html.html() != '' && oid != '' && !isNaN(oid)){
            $.ajax({
                url : url,
                data : {'oid':oid},
                type:"post",
                dataType:"json",
                success:function(info){
                    if(info.IDcard){
                        o_receiver_idcard.html('身份证号：'+info.IDcard+'&nbsp;<a onclick="lookIDcard(this)" href="javascript:void(0)">关闭显示'+'</a>');
                    }
                }
            })
        }
        if(html.html() == '关闭显示' && html.html() != ''){
            o_receiver_idcard.html('身份证号：'+receiver_idcard+'&nbsp;<a onclick="lookIDcard(this)" href="javascript:void(0)">查看身份证号'+'</a>');
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