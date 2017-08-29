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
                <script type="text/javascript" src="__PUBLIC__/Admin/js/order.js"></script>
<div class="rightInner" style="height:auto">
    <table width="100%" class="tbList" >
        <thead>
            <tr class="title">
                <th colspan="22">
<!--                    <p class="conOneP" style="float: left;">
                        <a href="javascript:void(0);" class="btnG ico_explort">导出Excel</a>
                    </p>-->
<!--                    <p class="conOneP" style="float: left;">
                        <a href="javascript:void(0);" class="btnG Set" id="setAutoOrders">批量审核订单</a>
                    </p>-->

                <span style="text-align:right;font-size: 12px;float: left;">
                    <form id="searchForm" method="get" action="<?php echo U('Admin/Orders/pageList');?>" style='width:55%;'>
                        订单号：<input type="text" name="o_id" class="large" value="<?php echo ($filter["o_id"]); ?>" style="width: 145px;">
                        昵称：<input type="text" name="m_name" class="large" value="<?php echo ($filter["m_name"]); ?>" validate="{ isCheck:true,messages:{isCheck:'您输入的参数非法，请重新输入'}}"  style="width: 145px;">
                        来源Id：<input type="text" name="o_source_type" class="large" value="<?php echo ($filter["o_source_type"]); ?>" style="width: 145px;">
                        充值类型：<select id="" class="medium" name="pdt_id">
                            <option value="0" <?php if($filter['pdt_id'] == '0'){ ?>selected="selected"<?php } ?>>请选择</option>
                            <option value="1" <?php if($filter['pdt_id'] == '1'){ ?>selected="selected"<?php } ?>>单次</option>
                            <option value="2" <?php if($filter['pdt_id'] == '2'){ ?>selected="selected"<?php } ?>>一个月</option>
                            <option value="3" <?php if($filter['pdt_id'] == '3'){ ?>selected="selected"<?php } ?>>三个月</option>		
                            <option value="4" <?php if($filter['pdt_id'] == '4'){ ?>selected="selected"<?php } ?>>六个月</option>	
                            <option value="5" <?php if($filter['pdt_id'] == '5'){ ?>selected="selected"<?php } ?>>一年</option> 
                            <option value="6" <?php if($filter['pdt_id'] == '6'){ ?>selected="selected"<?php } ?>>二年</option> 
                        </select>
                        支付入口：<select id="" class="medium" name="o_source">
                            <option value="pc" <?php if($filter['o_source'] == 'pc'){ ?>selected="selected"<?php } ?>>在线转换</option>
                            <option value="client" <?php if($filter['o_source'] == 'client'){ ?>selected="selected"<?php } ?>>离线转换</option>
                        </select>
                                <input type="submit" name="search" value="搜 索" class="btnHeader inpButton">
                                <a href="javascript:void(0);" class="btnG ico_syn order_search" style='position: relative;top: 2px;background-position: 0px -413px;'>高级搜索</a>
                    </form>
                    
                </span>
                </th>
        </tr>
        <tr>
            <th><input type="checkbox" class="checkAll" data-checklist="checkSon_x" data-direction="x"></th>
<!--            <th style="width:60px">操作</th>-->
            <th style="width:120px;">订单号</th>
            <th style="width:120px;">下单时间</th>
            <th>用户ID</th>
            <th>来源ID</th>
            <th>支付状态</th>
            <th>支付方式</th>
            <th>支付入口</th>
            <th>充值金额</th>
            <th>充值类型</th>
            <th>次数/月份</th>
            <th>订单状态</th>
            <th>会员名</th>
            <th>邮箱</th>

            <th>商品名字</th>
<!--             <th style="width:120px;">会员名</th>
            <th style="width:120px;">会员名</th> -->
        </tr>

        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" class="checkSon" data-xid="checkSon_x" name="o_id[]" value="<?php echo ($order["o_id"]); ?>" o_sn="<?php echo ($datas["o_sn"]); ?>" /></td>
<!--                <td style="padding-right: 45px;">
                <span style="width:120px;display:block;">
                    <a class="blue setPoint" href="javascript:void(0);" o_id="<?php echo ($order["o_id"]); ?>" data-uri='<?php echo U("Admin/Orders/setOrdersRemark");?>' data-acttype="ajax">备注</a>
                    <div id="children_<?php echo ($order["o_id"]); ?>"  style="display:none" title="卖家备注"></div>
                     <?php if(($order["o_goods_type"] != '5') and ($order["o_status"] != '4')): ?><a href="javascript:void(0);" id="EditOrderGoodsPrice" onClick="javascript:EditOrderGoodsPrice('<?php echo ($order["o_id"]); ?>');">修改价格</a><?php endif; ?> 

                     <?php if($order["o_pay_status"] == '1'): if(($order["deliver_status"] != '已发货') and ($order["refund_status"] == '') and $order["o_audit"] == '0'): ?>&nbsp;<a href="<?php echo U('Admin/Orders/pageEditOk');?>?o_id=<?php echo ($order["o_id"]); ?>" >编辑</a><?php endif; ?>
                         
                      <?php else: ?>
                    	 <?php if($order["str_status"] != '作废'): ?>&nbsp;<a href="<?php echo U('Admin/Orders/pageEdit');?>?o_id=<?php echo ($order["o_id"]); ?>" >编辑</a><?php endif; endif; ?>
                      <?php if($order["o_status"] != '4'): ?><a href="javascript:void(0);" onclick="overOrders('<?php echo ($order["o_id"]); ?>',this);" <?php if($order['pay_back'] == 1): ?>title="请先支付与发货才能返利"<?php endif; ?> >完成</a><?php endif; ?>
                      	 <?php if($order["is_diff"] == '1'): ?><span style="margin-left:10px;">已拆单</span>
	                     <?php else: ?>
	                     <?php if((($order["o_pay_status"] == '1') or ($order["o_payment"] == '6')) and($order["deliver_status"] != '已发货') and ($order["refund_status"] == '') and ($filter['order_remove_on'] == '1') and ($order["refund_goods_status"] == '') and ($order["str_status"] != '作废')): ?><a style="margin-left:10px;"  href="<?php echo U('Admin/Orders/autoRemoveOrderItems');?>?o_id=<?php echo ($order["o_id"]); ?>"  title="手动拆单">手动拆单</a><?php endif; endif; ?>            
				</span>
                </td>-->
                <td id="oid_<?php echo ($order["o_id"]); ?>">
                    <a href="<?php echo U('Admin/Orders/pageDetails');?>?o_id=<?php echo ($order["o_id"]); ?>" style="width:150px;display:block;<?php if($order['oi_range'] == 1): ?>color:red;<?php endif; ?>">
                        <?php echo ($order["o_id"]); ?>
                    </a>
                </td>
                <td> <span style="width:120px;"><?php echo ($order["o_create_time"]); ?></span></td>		
              <td><?php echo ($order["m_id"]); ?></td>	
              <td>pc</td>
              <td>  <span style="margin-left:10px;"><?php echo ($order["str_pay_status"]); ?></span></td>
               <td><?php echo ($order["pc_name"]); ?></td>
               <td><?php echo ($order["o_source"]); ?></td>
                               <td><?php echo ($order["o_all_price"]); ?></td>
                                 <td><?php echo ($order["pdf_type_order"]); ?></td>
                                 <td><?php echo ($order["oi_nums"]); ?></td>
                <td>
                <span style="width:150px;display:block;">
                    <!-- 订单的作废状态 start -->
                    <?php if($order["str_status"] == '作废'): ?><span><?php echo ($order["str_status"]); ?></span>
                    <?php elseif($order["o_status"] == '4'): ?>
                        <span>完结</span>
                    <?php else: ?>
                    
                        <!-- 订单的付款状态 start -->    
                        <span style="margin-left:10px;"><?php echo ($order["str_pay_status"]); ?></span>
                        <!-- 订单的发货状态 start --><?php endif; ?>
                   </span> 
                </td>
                     <td><?php echo ($order["m_name"]); ?></td>
                     <td> <span style="width:110px;display:block;"><?php echo ($order["m_email"]); ?></span></td>
                     <td><?php echo ($order["g_name"]); ?></td>
<!--                      <td><?php echo ($order["m_name"]); ?></td>
                     <td><?php echo ($order["m_name"]); ?></td> -->
<!--                <td style="width:52px" title="<?php echo ($order["g_name"]); ?>"><span class="proN"><?php echo ($order["g_name"]); ?></span></td>
                <td>
				   <?php if(($order["refund_status"] == '') && ($order["refund_goods_status"] == '')): ?>暂无
						<?php else: ?>    
						<span style='color:red;font-weight: bold;'><?php echo ($order["refund_status"]); ?> <?php echo ($order["refund_goods_status"]); ?></span><?php endif; ?>
                </td>
                <td><?php echo ($order["oi_nums"]); ?></td>

               
                <td><?php echo ($order["o_receiver_name"]); ?></td>
                <td>{ $order.o_receiver_mobile}</td>
                <td><?php echo ($order["delivery_company_name"]); ?></td>
                <td id="td_freight_<?php echo ($order["o_id"]); ?>"><?php echo ($order["o_cost_freight"]); ?></td>
           
                <td><?php echo ($order["o_update_time"]); ?></td>
                <td><?php echo (($order["order_pay_time"])?($order["order_pay_time"]):"0000-00-00 00:00:00"); ?></td>
                <td><?php echo (($order["order_deliver_time"])?($order["order_deliver_time"]):"0000-00-00 00:00:00"); ?></td>
                <td><?php echo ($order["admin_name"]); ?></td>
                <td title="<?php echo ($order["o_seller_comments"]); ?>"><span class="comments" style="white-space:normal"><?php echo ($order["o_seller_comments"]); ?></span></td>
                <td><?php echo ($order["channel_id"]); ?></td>
				<td><?php echo ($order["o_source"]); ?></td>-->
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(empty($data)): ?><tr><td colspan="99" class="left">暂时没有数据!</td></tr><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99"><span class="left page"><?php echo ($page); ?></span></td>
            </tr>
        </tfoot>
    </table>
    <div class="clear"></div>
    <div id="pro_dialog" style="display:none;">
        <div id="ajax_loading">
            <div id="ajaxsenddiv_loading">
                <img src="__PUBLIC__/images/loading.gif" title="正在加载中..." style="margin-top:30px;"/>
            </div>
        </div>
        <div id="orders_dialog">
            
            
            
        </div>
        <div id="orders_price_edit"></div>
        <div id="select_orders_property"></div>
    </div>
    
</div>
<script type="text/javascript">
	//定义高度
	var divHeight=$(document.body).outerHeight(true);
	var height = (divHeight/2.6-10)+"px";
	$("#wrap").css('height',height);
    $(".ico_explort").click(function(){
        var o_ids = new Array();;
        $(".tbList input:checked[class='checkSon']").each(function(){
            o_ids.push($(this).val());
        });
        var o_id = o_ids;
        o_ids = o_ids.join(",");
        $.ajax({
            url:'<?php echo U("Admin/Orders/getOrdersDialog");?>',
            cache:false,
            dataType:'HTML',
            data:{o_ids:o_ids},
            type:'POST',
            success:function(msgObj){
                $("#orders_dialog").html(msgObj);
                $("#orders_dialog").dialog({
                    height:'300',
                    width:'auto',
                    resizable:false,
                    modal:true,
                    title:'订单导出',
                    buttons: {
                        '确认': function() {
                            selectOrders();
                            $("#orders_dialog").dialog('destroy');
                            $('#pro_dialog').append($('#orders_dialog'));
                        },
                        '关闭': function() {
                            $("#orders_dialog").dialog('destroy');
                            $('#pro_dialog').append($('#orders_dialog'));
                        }
                    },
                    close:function(){
                        $("#orders_dialog").dialog('destroy');
                        $('#pro_dialog').append($('#orders_dialog'));
                    }
                });
            }
        });
    });
    
    function selectOrders(){
        var data = new Object();
        var start = parseInt($("#orders_start").val());
        var end = parseInt($("#orders_end").val());
        var type = $("input[name='orders_type']:checked").val();
        data['orders_type'] = type;
        var start_time = $("input[name='o_create_time_start']").val();
        var end_time = $("input[name='o_create_time_end']").val();
        var o_ids = '';
        if(type == '0') {
            if(start < 0 || end <= 0 || end <= start ){
                alert("导出开始页必须小于结束页大小");return false;
            }
            data['start'] = start;
            data['end'] = end;
        }
        else if(type == '1'){
            o_ids = $(".order_ids").attr("o_ids");
            data['o_ids'] = o_ids;
            if(o_ids == ''){
                alert("请选择需要导出的单据");return false;
            }
            if(start <= 0){
                alert("输入有误请重新输入");return false;
            }
            if(end <= 0){
                alert("输入有误请重新输入");return false;
            }
        }else if(type == '3'){
            data['o_create_time_start'] = start_time;
            data['o_create_time_end'] = end_time;
            if(start_time == '' || end_time == ''){
                alert("下单时间不能为空，请重新输入");return false;
            }
        }else if(type=='4'){
			var requset = '<?php echo ($get); ?>';
            if(requset == '[]'){
                showAlert(false,"请先搜索后再导出订单");return false;
            }
			data['search'] = requset;
			
		}
        $.post("<?php echo U('Admin/Orders/selectOrdersPropetry');?>",{},function(dataHTML){
            $("#select_orders_property").html(dataHTML);
            $("#select_orders_property").dialog({
                    height:'auto',
                    width:'auto',
                    resizable:false,
                    modal:true,
                    title:'请选择要导出的可选字段',
                    buttons: {
                        '确认': function() {
                            data['export_type'] = {};
                            $('.goods_sale_property_checked').each(function(i){
                                data['export_type'][$(this).attr('ename')] = {}
                                data['export_type'][$(this).attr('ename')] = $(this).attr('e_value');
                            });
                            explortOrder(data);
                            $("#select_orders_property").dialog('destroy');
                            $('#pro_dialog').append($('#select_orders_property'));
                        },
                        '关闭': function() {
                            $("#select_orders_property").dialog('destroy');
                            $('#pro_dialog').append($('#select_orders_property'));
                        }
                    },
                    close:function(){
                        $("#select_orders_property").dialog('destroy');
                        $('#pro_dialog').append($('#select_orders_property'));
                    }
                });
        },'html')
    }
    
    function explortOrder(data){
        $.post('<?php echo U("Admin/Orders/explortOrdersInfo");?>',data,function(msgObj){
            if(msgObj.status == '1'){
                var url = "<?php echo U('Admin/BalanceInfo/getExportFileDownList');?>" + "?type=excel&file="+msgObj.data;
                window.location.href = url;
                return false;
            }else{
                alert(msgObj.info);return false;
            }
        },"json");
    }
    /*高级搜索*/
    $(".order_search").click(function(){
        $.ajax({
           url:'<?php echo U("Admin/Orders/getOrdersSearch");?>', 
            cache:false,
            dataType:"HTML",
            data:{},
            type:"POST",
            success:function(msgObj){
                $("#orders_dialog").html(msgObj);
                $("#orders_dialog").dialog({
                    width:'830',
                    resizable:false,
                    modal:true,
                    title:'高级搜索'
                });
            }
        });
    });

    
    //修改订单价格
    function EditOrderGoodsPrice(o_id) {
           $.ajax({
           url:'<?php echo U("Admin/Orders/ajaxGetOrderItems");?>', 
            cache:false,
            dataType:"JSON",
            data:{"o_id":o_id},
            type:"POST",
            success:function(json){
                if(json.success == 1) {
                    var html = '<table class="tbList">';
                    html += '<thead>';
                    html += '<tr><th>订单总价:</th><th>'+json.data.o_all_price+'</th><th>商品总价:</th><th>'+json.data.o_goods_all_price+'</th><th>物流费用:</th><th>'+json.data.o_cost_freight+'</th><th>优惠券金额:</th><th>'+json.data.o_coupon_menoy+'</th><th colspan="4"><input type="hidden" id="new_price_oid" value="'+json.data.o_id+'"/><input type="hidden" id="orderm_m_id" value="'+json.data.m_id+'"/></th></tr>';
                    html += '<tr><th>商品名称</th><th>商品编号</th><th>规格</th><th>销售价</th><th>购买价</th><th>数量</th><th>促销</th><th>新价格</th><th>可否修改价格</th><th>原因</td></tr></thead>';
                    html += '<tbody>';
                    var i=0;
                    for(i in json.data.items) {
                        html += ''+
                         '<tr class="editGoodsinfo" pdt_sn="'+json.data.items[i].pdt_sn+'" pdt_id="'+json.data.items[i].pdt_id+'" g_id="'+json.data.items[i].g_id+'" oi_type="'+json.data.items[i].oi_type+'" oi_nums="'+json.data.items[i].oi_nums+'" oi_id="'+json.data.items[i].oi_id+'">'+
                            '<td>'+json.data.items[i].g_name+'</td>'+
                            '<td>'+json.data.items[i].g_sn+'</td>'+
                            '<td>'+json.data.items[i].spec_value+'</td>'+
                            '<td>'+json.data.items[i].pdt_sale_price+'</td>'+
                            '<td>'+json.data.items[i].oi_price+'</td>'+
                            '<td>'+json.data.items[i].oi_nums+'</td>'+
                            '<td>'+json.data.items[i].promotion+'</td>';
                            if (json.data.items[i].can_modify != 1) {
                                html +=  '<td><input type="text"  class="new_price_input" value="" oi_nums="'+json.data.items[i].oi_nums+'" readonly="readonly" oi_id="'+json.data.items[i].oi_id+'"/></td>';
                                html += '<td style="color:red">否</td>';
                            } else {
                                html +=  '<td><input type="text"  class="new_price_input" value="" oi_nums="'+json.data.items[i].oi_nums+'" onKeyUp="javascript:newPriceChange();"  oi_id="'+json.data.items[i].oi_id+'"/></td>';
                                html += '<td>是</td>';
                            }
                            html += ''+
                            '<td>'+json.data.items[i].not_modify_reason+'</td>'+
                        '</tr>';
                        i++;
                    } 
                  
                    html += '<tr><td colSpan="6"></td><td>新商品总价：</td><td><input type="text" id="new_goods_total_price" value="" disabled style="width:80px;"/></td><td>新订单总价：</td><td><input type="text"  id="new_order_total_price" value="" disabled style="width:80px;"/></td></tr>';
                    html += '<tr><td colSpan="10" id="new_price_result"> </td></tr>';
                    html += '</tbody>';
                    html += '</table>';
                    $("#orders_price_edit").html(html);
                    $("#orders_price_edit").dialog({
                        height:'auto',
                        width:'auto',
                        resizable:true,
                        modal:true,
                        title:'订单高级搜索',
                        closeOnEscpe:true,
                        buttons:[
                            {
                                text:"计算总价",
                                id:'dialog_calculate_price',
                                click:function() {
                                    var data = new Object();
                                    data['o_id'] = $("#new_price_oid").val();
                                    data['m_id'] = $("#orderm_m_id").val();
                                    data['pageList'] = '1';
                                    data['pro_pdt_sn'] = {};
                                    data['pro_pdt_id'] = {};
                                    data['pro_g_id'] = {};
                                    data['pro_type'] = {};
                                    data['pro_price'] = {};
                                    data['pro_num'] = {};
                                    $(".editGoodsinfo").each(function(i){
                                        data['pro_pdt_sn'][i] = $(this).attr('pdt_sn');
                                        data['pro_pdt_id'][i] = $(this).attr('pdt_id');
                                        data['pro_g_id'][i] = $(this).attr('g_id');
                                        data['pro_type'][i] = $(this).attr('oi_type');
                                        data['pro_price'][i] = $("input[oi_id='"+$(this).attr('oi_id')+"']").val();
                                        data['pro_num'][i] = $(this).attr('oi_nums');
                                    });
                                    $.post('<?php echo U("/Admin/Orders/computePrice/");?>',data,function(dataJson){
                                        var new_order_total_price = (parseFloat(dataJson.ary_data.o_goods_all_price)+parseFloat(json.data.o_cost_freight)).toFixed(2);
                                        $("#new_goods_total_price").val(dataJson.ary_data.o_goods_all_price);
                                        $("#new_order_total_price").val(new_order_total_price);
                                        for (x in dataJson.ary_orders_info){
                                            var oi_price = dataJson.ary_orders_info[x]['oi_price'];
                                            var oi_id = $(".editGoodsinfo[pdt_id='"+dataJson.ary_orders_info[x]['pdt_id']+"']").attr("oi_id");
                                            $(".editGoodsinfo[pdt_id='"+dataJson.ary_orders_info[x]['pdt_id']+"']").children('td:eq(6)').html(dataJson.ary_orders_info[x]['pmn_name']);;
                                            $("input[oi_id='"+oi_id+"']").val(oi_price);
                                        }
                                        $("#dialog_ok_modified").show();
                                    },'json');
                                }
                            },
                            {
                                text:"确定修改",
                                id:'dialog_ok_modified',
                                style:'display:none',
                                click:function() {
                                    //return false;
                                    $("#dialog_ok_modified").hide();
                                    $("#new_price_result").html('<span style="color:green;">提交中,请稍后...</span>');
                                    var priceData = new Object();
                                    priceData['o_id'] = $("#new_price_oid").val();
                                    priceData['m_id'] = $("#orderm_m_id").val();
                                    priceData['pageList'] = '1';
                                    priceData['pro_pdt_sn'] = {};
                                    priceData['pro_pdt_id'] = {};
                                    priceData['pro_g_id'] = {};
                                    priceData['pro_type'] = {};
                                    priceData['pro_price'] = {};
                                    priceData['pro_num'] = {};
                                    $(".editGoodsinfo").each(function(i){
                                        priceData['pro_pdt_sn'][i] = $(this).attr('pdt_sn');
                                        priceData['pro_pdt_id'][i] = $(this).attr('pdt_id');
                                        priceData['pro_g_id'][i] = $(this).attr('g_id');
                                        priceData['pro_type'][i] = $(this).attr('oi_type');
                                        priceData['pro_price'][i] = $("input[oi_id='"+$(this).attr('oi_id')+"']").val();
                                        priceData['pro_num'][i] = $(this).attr('oi_nums');
                                    });
                                    //return false;
                                    $.ajax({
                                       url:'<?php echo U("Admin/Orders/ajaxUpdateOrderItemsPrice");?>', 
                                        cache:false,
                                        dataType:"JSON",
                                        data:priceData,
                                        type:"POST",
                                        success:function(json) {
                                            if(json.success == 1) {
                                                $("#new_price_result").html('<span style="color:green;">更新成功！</span>');
                                            } else {
                                                $("#new_price_result").html('<span style="color:red;">'+json.msg+'</span>');
                                            }
                                        }
                                    })
                                }
                            }
                        ]
                    });
                } else {
                    showAlert(false,'出错了',json.msg);
                    return false;
                }
            }
        });
    }
    
    function newPriceChange() {
         $("#new_goods_total_price").val('');
         $("#new_order_total_price").val('');
         $("#dialog_ok_modified").hide();
         $("#new_price_result").html('');
    }
	
    //设置备注
    $(".setPoint").click(function(){
        var _this = $(this);
        var o_id = _this.attr('o_id');
        var url = _this.attr('data-uri');
        $.post(url,{'o_id':o_id},function(html){
            $('#children_'+o_id).dialog({
                height:300,
                width:350,
                resizable:false,
                autoOpen: false,
                modal: true,
				title:'卖家备注',
                buttons: { 
                    '确定':function(){
                        addPoint(o_id,$( this ));
						$(".remarktable").remove();
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                        $(".remarktable").remove();
                    }
                },
				close:function(){
					$(".remarktable").remove();
				}
            });
            $('#children_'+o_id).dialog('open');
            $('#children_'+o_id).html(html);
        },'html');
        
    });
    //添加备注
    function addPoint(o_id,obj){
        var url = "<?php echo U('Admin/Orders/OrderRemarkUpdate');?>";
        var remark =$('#remark').val();
        $.post(url, {'o_id':o_id,'remark':remark}, function(msgObj){
            if(msgObj.status == '1'){
                showAlert(true,'备注设置成功');
                obj.dialog( "close" );
                $(".remarktable").remove();
                return false;
            }else{
                showAlert(false,'出错了',msgObj.info);
                return false;
            }
                
        }, 'json');
    }

    //订单审核
    $(".check_audit").click(function(){
        var o_id = $(this).attr("o_id");
        $.ajax({
           url:'<?php echo U("Admin/Orders/checkAudit");?>', 
            cache:false,
            dataType:"json",
            data:{o_id:o_id},
            type:"POST",
            success:function(msgObj){
                if(msgObj.status == '1'){
                    showAlert(true,'订单审核成功');
                	$("#hide_audit_"+o_id).css("display","none");
                    $("#check_audit_"+o_id).css("display","");
                }else{
                	showAlert(false,msgObj.info);
                }
            }
        });
    });
    //订单批量审核
    $("#setAutoOrders").click(function(){
        var o_id = '';
        $(".checkSon:checked").each(function(){
            o_id += this.value+',';
        });
        o_id = o_id.substring(0,o_id.length-1);
        if(o_id == ''){
            showAlert(false,'请选择要审核的订单');return false;
        }
        $.ajax({
           url:'<?php echo U("Admin/Orders/checkAudit");?>', 
            cache:false,
            dataType:"json",
            data:{o_id:o_id},
            type:"POST",
            success:function(msgObj){
                if(msgObj.status == '1'){
                    showAlert(true,'订单审核成功');
                    $(".checkSon:checked").each(function(){
                        $("#hide_audit_"+this.value).css("display","none");
                        $("#check_audit_"+this.value).css("display","");
                    });
                	
                }else{
                	showAlert(false,msgObj.info);
                }
            }
        });
    });
    function overOrders(oid,obj){
        if(!confirm("订单完结后不能做修改和售后操作,确认?")){
            return false;
        }
        $.ajax({
            url:'<?php echo U("Admin/Orders/overOrder");?>',
            dateType:'json',
            data:{oid:oid},
            type:'POST',
            success:function(msg){
                if(msg.status){
                    $(obj).parent().parent().next().next().next().children().html('完结');
                    $(obj).remove();
                }
                showAlert(msg.status,msg.msg);
            }
        
        });
    }
	//设置新物流费用(前提是订单未支付)
    $(".setFreight").click(function(){
        
        var _this = $(this);
        var o_id = _this.attr('o_id');
        var url = _this.attr('data-uri');
        $.post(url,{'o_id':o_id},function(html){
            $('#children_f_'+o_id).dialog({
                height:300,
                width:420,
                resizable:false,
                autoOpen: false,
                modal: true,
                buttons: { 
                    '确定':function(){
                                    
                        FeightUpdate(o_id,$( this ));
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                        $('#children_f_'+o_id).hide();
                    }
                }
            });
            $('#children_f_'+o_id).dialog('open');
            $('#children_f_'+o_id).html(html);
        },'html');
        
    });
    
    //修改物流费用
    function FeightUpdate(o_id,obj){
        var url = "<?php echo U('Admin/Orders/OrderFreightUpdate');?>";
        var tzfx =$('#tzfx_'+o_id).find('option:selected').val();
        var tzje =$('#tzje_'+o_id).val();
       
        $.post(url, {'o_id':o_id,'tzje':tzje,'tzfx':tzfx}, function(msgObj){
            if(msgObj.status == '1'){
                
                showAlert(true,'物流费用修改成功');
                obj.dialog( "close" );
                $('#children_f_'+o_id).hide();
				var td_freight = $('#td_freight_'+o_id);
				if(tzfx==1) td_freight.html((parseFloat(td_freight.html()-parseFloat(tzje))).toFixed(3));
				else td_freight.html((parseFloat(td_freight.html())+parseFloat(tzje)).toFixed(3));
                return false;
            }else{
                showAlert(false,'出错了',msgObj.info);
                return false;
            }
                
        }, 'json');
    }

	//跳转到订单详情页
    function openOrderDetail(oid) {
    	window.open("<?php echo U('Admin/Orders/pageDetails');?>?o_id="+oid);
    	return false;
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