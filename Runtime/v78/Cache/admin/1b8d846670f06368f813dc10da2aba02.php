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
<div class="rightInner">
    <table width="100%" class="tbList">
        <thead>
            <tr class="title">
                <th>待发货订单列表</th>
                <th colspan="99" style="text-align:right;font-size: 12px;">
                    <form id="searchForm" method="get" action="<?php echo U('Admin/Orders/pageWaitDeliverOrdersList');?>">
                        订单号：<input type="text" name="o_id" class="large" value="<?php echo ($filter["o_id"]); ?>" style="width: 145px;">
                                <input type="submit" value="搜 索" class="btnHeader inpButton">
                    </form>
                </th>
        </tr>
        <tr>
            <th>订单号</th>
            <th>数量</th>
            <th>订单状态</th>
			<th>订单金额</th>
			<th>支付方式</th>
            <th width="100">收货人</th>
            <th>会员名</th>
            <th>支付时间</th>
            <th>客服</th>
            <th>备注</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr id="o_id_<?php echo ($order["o_id"]); ?>">
                <td id="oid_<?php echo ($order["o_id"]); ?>">
					<a href="<?php echo U('Admin/Orders/pageDetails');?>?o_id=<?php echo ($order["o_id"]); ?>"><?php echo ($order["o_id"]); ?></a>
				</td>
                <td><?php echo ($order["oi_nums"]); ?></td>
                <td>
                    <?php if($order["str_status"] == '作废'): ?><span><?php echo ($order["str_status"]); ?></span>
                    <?php else: ?>        	
                        <?php if($order["o_pay_status"] == '1'): ?><span style="margin-left:10px;">已支付</span>
                        <?php else: ?>
                            <span style="margin-left:10px;">未支付</span><?php endif; ?>
                        
                        <?php if($order["deliver_status"] == '已发货'): ?><span style="margin-left:10px;">已发货</span>
                        <?php else: ?>
                                <a class="blue send_ship" id="send_ship_<?php echo ($order["o_id"]); ?>" pay_status="<?php echo ($order["str_pay_status"]); ?>" href="javascript:void(0);" oi_type="<?php echo ($order["oi_type"]); ?>" o_id="<?php echo ($order["o_id"]); ?>" oi_refund_status="<?php echo ($order["oi_refund_status"]); ?>" data-uri='<?php echo U("Admin/Orders/setSendShip");?>' data-acttype="ajax">发货</a>

                                <div id="children_<?php echo ($order["o_id"]); ?>"  style="display:none" title="发货设置"></div><?php endif; endif; ?>
				</td>
				<td><?php echo ($order["o_all_price"]); ?></td>
                <td><?php echo ($order["pc_name"]); ?></td>
                <td><?php echo ($order["o_receiver_name"]); ?></td>
                <td><?php echo ($order["m_name"]); ?></td>
                <td><?php echo (($order["order_pay_time"])?($order["order_pay_time"]):"0000-00-00:00:00:00"); ?></td>
                <td><?php echo ($order["admin_name"]); ?></td>
                <td><span href="javascript:void(0);" title="<?php echo ltrim($order['o_seller_comments'],'/') ?>" style="width:80px;white-space:nowrap; text-overflow:ellipsis; -o-text-overflow:ellipsis; overflow: hidden;"><?php echo ltrim($order['o_seller_comments'],'/') ?></span></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(empty($data)): ?><tr><td colspan="99" class="left">暂时没有数据!</td></tr><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99"><span class="right page"><?php echo ($page); ?></span></td>
            </tr>
        </tfoot>
    </table>
    <div class="clear"></div>
    <div id="pro_dialog" style="display:none;">
        <div id="ajax_loading">
            <div id="ajaxsenddiv_loading"><img src="__PUBLIC__/images/loading.gif" title="正在加载中..." style="margin-top:30px;"/></div>
        </div>
    </div>
    
</div>

<script>
$(".send_ship").click(function(){
    var _this = $(this);
    var oi_type = _this.attr('oi_type');
    var oi_pay_status = _this.attr('pay_status');
    var o_id = _this.attr('o_id');
    var url = _this.attr('data-uri');
	var oi_refund_status = _this.attr("oi_refund_status");
    if(oi_type == 8){
        if(oi_pay_status == '部分支付'){
            showAlert(false,'预售商品还没有支付尾款！不能发货！');return false;
        }
    }
	if(3 == oi_refund_status || 2 == oi_refund_status){
		if(!confirm("订单编号为"+o_id+"已申请售后，您确定要发货吗？")){
			return false;
		}
	}
    if(oi_refund_status == 4 || oi_refund_status == 5){
        if(!confirm("订单编号为"+o_id+"退款/退货成功，您确定要发货吗？")){
            return false;
        }
    }
	$.post(url,{'o_id':o_id},function(html){
		$('#children_'+o_id).html($(html));
		$("#children_"+o_id).dialog({
			height:265,
			width:540,
			resizable:false,
			autoOpen: false,
			modal: true,
			buttons: { 
				'确定':function(){         
					UpdateSendShipStatus(o_id,$(this));
				},
				'取消': function() {
					$( this ).dialog( "close" );
					$('#children_'+"<?php echo ($datas["g_id"]); ?>").hide();
				}
			}
		});
		$('#children_'+o_id).dialog('open');
	},'html');
});  
    
    
//更新发货状态
function UpdateSendShipStatus(o_id,obj){
    var url = "<?php echo U('Admin/Orders/UpdateOrderStatus');?>";
    var memo =$('#memo').val();
    var logistics_name =$('#logistics_name').val();
    var logistics_no =$('#logistics_no').val();
    $.post(url, 
    {
        'o_id':o_id,
        'memo':memo,
        'logistics_name':logistics_name,
        'logistics_no':logistics_no
    }, 
    function(data){
        if(data.status == '1'){
            obj.dialog( "close" );
            $('#o_id_'+o_id).remove();
            showAlert(true,'成功！','',{'成功':'/Admin/Orders/pageWaitDeliverOrdersList'});
            return false;
        }else{
            showAlert(false,'出错了',data.info);
            return false;
        }

    }, 'json');
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