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
                <div class="fxIndex"><!--fxIndex  start-->
	<div class="fxIlist">
		<p class="p1"></p>
		<div>
			<h2>快速开始工作</h2>
			<ul>
				<li>
					<a href="<?php echo U('Admin/Products/pageList');?>">在架商品</a>
					<a href="<?php echo U('Admin/Products/pageList','tabs=shelves');?>">下架商品</a>
					<a href="<?php echo U('Admin/Goods/goodsAdd');?>">商品发布</a>
				</li>
				<li>
					<a href="<?php echo U('Admin/Orders/pageList');?>">订单管理</a>
					<a href="<?php echo U('Admin/Orders/pageWaitPayOrdersList');?>">未付款订单</a>
					<a href="<?php echo U('Admin/Orders/pageWaitDeliverOrdersList');?>">待发货订单</a>
				</li>
				<li>
					<a href="<?php echo U('Admin/Members/pageList');?>">会员管理</a>
					<a href="<?php echo U('Admin/Members/memberAdd');?>">新增会员</a>
					<a href="<?php echo U('Admin/Members/feedBackList');?>">会员留言</a>
				</li>
				<li>
					<a href="<?php echo U('Admin/Financial/pageListVerify');?>">线下充值审核</a>
					<a href="<?php echo U('Admin/BalanceInfo/pageList','st=pending&status=2');?>">待客审结余款调整单</a>
				</li>
				<li></li>
			</ul>
		</div>
		<p class="p2"></p>
	</div>
	<div class="fxIlist">
		<p class="p1"></p>
		<div>
			<h2>商品信息</h2>
			<ul>
				<li>
					<a href="<?php echo U('Admin/Products/pageList');?>">在架商品</a>
					<span>
						<a href="<?php echo U('Admin/Products/pageList');?>">
							<b class="red"><?php echo (($goods_info["onsale_num"])?($goods_info["onsale_num"]):'0'); ?></b>
						</a>件
					</span>
				</li>
				<li>
					<a href="<?php echo U('Admin/Products/pageList','tabs=shelves');?>">下架商品</a>
					<span>
						<a href="<?php echo U('Admin/Products/pageList','tabs=shelves');?>">
							<b class="red"><?php echo (($goods_info["unsale_num"])?($goods_info["unsale_num"]):'0'); ?></b>
						</a>件
					</span>
				</li>
				<li>
					<a href="<?php echo U('Admin/Products/pageList','tabs=new');?>">新品上架</a>
					<span>
						<a href="<?php echo U('Admin/Products/pageList','tabs=new');?>">
							<b class="red"><?php echo (($goods_info["news_num"])?($goods_info["news_num"]):'0'); ?></b>
						</a>件
					</span>
				</li>
				<li>
					<a href="<?php echo U('Admin/Products/pageList','tabs=hot');?>">热卖商品</a>
					<span>
						<a href="<?php echo U('Admin/Products/pageList','tabs=hot');?>">
							<b class="red"><?php echo (($goods_info["hot_num"])?($goods_info["hot_num"]):'0'); ?></b>
						</a>件
					</span>
				</li>
				<li></li>
			</ul>
		</div>
		<p class="p2"></p>
	</div>
	<div class="fxIlist">
		<p class="p1"></p>
		<div>
			<h2>今日业务量</h2>
			<ul>
				<li>
					<a href="<?php echo U('Admin/Orders/pageList');?>">今日有效订单量</a>
					<span>
						<a href="<?php echo U('Admin/Orders/pageList');?>">
							<b class="red"><?php echo (($order_info["today_nums"])?($order_info["today_nums"]):'0'); ?></b>
						</a>单
					</span>
				</li>
				<li>
					<a href="<?php echo U('Admin/Orders/pageList');?>" >已付款单量</a>
					<span>
						<a href="<?php echo U('Admin/Orders/pageList');?>">
							<b class="red"><?php echo (($order_info["pay_nums"])?($order_info["pay_nums"]):'0'); ?></b>
						</a>单
					</span>
				</li>
				<li>
					<a href="<?php echo U('Admin/Orders/pageWaitPayOrdersList');?>" title="含部分付款和第三方担保交易">未付款订单[<font color="red">含部分付款</font>]</a>
					<span>
						<a href="<?php echo U('Admin/Orders/pageWaitPayOrdersList');?>">
							<b class="red"><?php echo (($order_info["un_pay_nums"])?($order_info["un_pay_nums"]):'0'); ?></b>
						</a>单
					</span>
				</li>
				<li>
					<a href="<?php echo U('Admin/Orders/pageWaitDeliverOrdersList');?>" title="不含货到付款和线下支付的订单">待发货订单[<font color="red">不含货到付款和线下支付</font>]</a>
					<span>
						<a href="<?php echo U('Admin/Orders/pageWaitDeliverOrdersList');?>">
							<b class="red"><?php echo (($order_info["un_delivery_nums"])?($order_info["un_delivery_nums"]):'0'); ?></b>
						</a>单
					</span>
				</li>
				<li></li>
			</ul>
		</div>
		<p class="p2"></p>
	</div>
	<div class="fxIlist">
		<p class="p1"></p>
		<div>
			<h2>安全提示</h2>
			<ul>
				<li style="color:#ff0000;">
					1. 离开座位时，请您将计算机屏幕锁定；
				</li>
				<li style="color:#ff0000;">
					2. 请定期修改您的密码，不要将密码外泄；
				</li>
				<li style="color:#ff0000;">
					3. 涉及库存或者财务的操作，请务必谨慎；
				</li>
				<li></li>
			</ul>
		</div>
		<p class="p2"></p>
	</div>
	<div class="fxIlist">
		<p class="p1"></p>
		<div>
			<h2>公告</h2>
			<ul>
				<?php if(!empty($array_notices)): if(is_array($array_notices)): $i = 0; $__LIST__ = $array_notices;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$notice): $mod = ($i % 2 );++$i;?><input type="hidden" name="notice_id" value="<?php echo ($notice["ai_id"]); ?>" id="notice_id" />
				<li>
					<a href="javascript:void(0);" location_href="<?php echo U('Admin/RemoteService/readNotice');?>?notice_id=<?php echo ($notice["ai_id"]); ?>" notice_id="<?php echo ($notice["ai_id"]); ?>" class="remote_service_notice_link" title="<?php echo ($notice["ai_title"]); ?>">
						[<font color="red"><?php echo date('Y-m-d',strtotime($notice['ai_update_time'])); ?></font>] 
						<?php echo ($notice["ai_title"]); ?>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
				<li></li>
				<?php else: ?>
					暂无公告消息。<?php endif; ?>
			</ul>
		</div>
		<p class="p2"></p>
	</div>
</div><!--fxIndex  end-->
<div id="showRemoteServiceBox" style="display:none;"></div>
<script type="text/javascript">
$(document).ready(function(){
	//自动弹出提示
	var is_show = "<?php echo ($_SESSION['show_display']); ?>";
	var notice_id = $("#notice_id").val();
	if(is_show != '1' && notice_id!=undefined){
		showdisplay(notice_id);
	}
	//点击弹出公告详情
	$(".remote_service_notice_link").click(function(){
		showdisplay(notice_id);
	});
});

function showdisplay(id){
	var url ='/Admin/RemoteService/readNotice';
	$.ajax({
		url:url,
		data:{asd:12,bt_id:'dgfdg34',xx:'001100',notice_id:id},
		beforeSend:function(){
			//alert("正在请求远端数据，请稍候...");
		},
		success:function(htmlObj){
			if(htmlObj!=''){
			$("#showRemoteServiceBox").html(htmlObj).dialog({
				title:'升级公告',
				width:800,
				height:420,
				buttons:{
					'确定':function(){
						//TODO:此处需要增加一步操作
						var is_display = 0;
						ajaxReturn('/Admin/RemoteService/showdisplay',is_display);
						$(this).dialog("close");
					},
					'关闭':function(){
						$(this).dialog("close");
					}
				}
			});
			$("#show_display").attr("value", 1);
			}
		},
		type:'GET',
		timeout:30000,
		dataType:'html'
	});
	//return false;
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