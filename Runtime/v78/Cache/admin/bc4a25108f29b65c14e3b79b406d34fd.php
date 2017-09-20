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
                <script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/jquery/js/jquery.etalage.min.js"></script>
<link href="__PUBLIC__/Admin/css/etalage.css" rel="stylesheet">
<h2 class="commonH2">商品详情</h2>
<div class="rightInner"><!--rightInner  start-->

    <div class="proDetails"><!--proDetails  start-->
        <div class="probig"><!--probig   start-->
            <div id="examples">

                <ul id="example3">
                    <?php if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><li>
                        <img class="etalage_thumb_image" src="<?php echo (C("DOMAIN_HOST")); echo ($pic["gp_picture"]); ?>" />
                        <img class="etalage_source_image" src="<?php echo (C("DOMAIN_HOST")); echo ($pic["gp_picture"]); ?>" />
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>

            </div>

            <table class="tableBig">
                <tr>
                    <td width="75" align="right">商品名称：</td>
                    <td><strong><?php echo ($good["g_name"]); ?></strong></td>
                </tr>
                <tr>
                    <td align="right">商品编号：</td>
                    <td><?php echo ($good["g_sn"]); ?></td>
                </tr>
                <?php if(!empty($good["g_art_no"])): ?><tr>
                    <td align="right">长益货号：</td>
                    <td><?php echo ($good["g_art_no"]); ?></td>
                </tr><?php endif; ?>
                <?php if(!empty($good["taobao_id"])): ?><tr>
                    <td align="right">淘宝商品编号：</td>
                    <td><?php echo ($good["taobao_id"]); ?></td>
                </tr><?php endif; ?>
                <tr>
                    <td align="right">品牌：</td>
                    <td><?php echo (($good["gb_name"])?($good["gb_name"]):"暂无"); ?></td>
                </tr>
                <tr>
                    <td align="right">分类：</td>
                    <td><?php echo (($good["gc_name"])?($good["gc_name"]):"暂无"); ?></td>
                </tr>
				<tr>
					<td align="right">类型：</td>
					<td><?php echo (($good["gt_name"])?($good["gt_name"]):"暂无"); ?></td>
				</tr>
                <tr>
                    <td align="right">上架状态：</td>
					<?php if($good["g_on_sale"] == '1'): ?><td>在架</td>
						<?php else: ?>
						<td>下架</td><?php endif; ?>
                </tr>
            </table>
        </div><!--probig   end-->


        <p class="tabListP">
            <span onclick="setTab(this)" div_id="1" class="onHover tabListP_Span" style="cursor:pointer;">规格</span>
			<span onclick="setTab(this)" div_id="4" class="tabListP_Span" style="cursor:pointer;">属性</span>
            <span onclick="setTab(this)" div_id="2" class="tabListP_Span" style="cursor:pointer;">商品详细</span>
            <!--
			<span onclick="setTab(this)" div_id="3" class="tabListP_Span" style="cursor:pointer;">第三方平台</span>
			-->
        </p>
        <div class="borderDiv" id="con_tabListP_1">
            <table width="100%" class="tbList">
                <thead>
                    <tr>
                        <th>商品编码</th>
                        <th>规格</th>
                        <th>重量（g）</th>
                        <th>总库存</th>
                        <th>可下单库存</th>
                        <th>冻结库存</th>
                        <th>价格（元）</th>
                        <th>在途数</th>
						<!--
                        <th>淘宝商品SKU</th>
						-->
                    </tr>
                </thead>
                <tbody>
                <?php if(is_array($products)): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$product): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($product["pdt_sn"]); ?></td>
                        <td><?php echo (($product["specName"])?($product["specName"]):"暂无"); ?></td>
                        <td><?php echo ($product["pdt_weight"]); ?></td>
                        <td><?php echo ($product["pdt_total_stock"]); ?></td>
                        <td><?php echo ($product["pdt_stock"]); ?></td>
                        <td><?php echo ($product["pdt_freeze_stock"]); ?></td>
                        <td><?php echo ($product["pdt_sale_price"]); ?></td>
                        <td><?php echo ($product["pdt_on_way_stock"]); ?></td>
						<!--
                        <td><?php echo ($product["taobao_sku_id"]); ?></td>
						-->
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
		<div class="borderDiv" id="con_tabListP_4" style="display:none;">
			<table width="100%" class="tbList">
				<?php if(is_array($array_unsale_spec)): $i = 0; $__LIST__ = $array_unsale_spec;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec): $mod = ($i % 2 );++$i;?><tr>
                    <td width="150" style="text-align:right;"><?php echo ($spec["gs_name"]); ?>：</td>
                    <td style="text-align:left;"><?php echo ($spec["gsd_aliases"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</div>
        <div class="borderDiv" id="con_tabListP_2" style="display:none">
            <div class="paddingDiv">
                <!--
				<ul class="proDUL">
                    <li>商品编号：<?php echo ($good["g_sn"]); ?></li>
                    <li>商品品牌：<?php echo ($good["gb_name"]); ?></li>
                    <li>重量：<?php echo ($good["gb_name"]); ?></li>
                    <li>上架时间：<?php echo ($good["g_on_sale_time"]); ?></li>
                    <li>市场价：<?php echo (sprintf('%0.3f',$good["g_price"])); ?></li>
                </ul>
				-->
                <?php echo ($good["g_desc"]); ?>
            </div>
        </div>
        <!--
		<div class="borderDiv" id="con_tabListP_3" style="display:none">
            <table width="100%" class="tbList">
                <thead>
                    <tr>
                        <th>第三方平台</th>
                        <th>是否已发布</th>
                        <th>铺货次数</th>
                        <th>累计采购量</th>
                        <th>采购基准价</th>
                        <th>经销采购价</th>
                        <th>零售价格区间</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>淘宝供销平台</td>
                        <td><?php if(empty($good["top_info"])): ?><span class="red">未发布</span><?php else: ?><span class="green">已发布</span><?php endif; ?></td>
                        <?php if(empty($good["top_info"])): ?><td></td><td></td><td></td><td></td><td></td>
                        <?php else: ?>
                        <td><?php echo ($good["top_info"]["items_count"]); ?></td>
                        <td><?php echo ($good["top_info"]["orders_count"]); ?></td>
                        <td><?php echo ($good["top_info"]["standard_price"]); ?></td>
                        <td><?php echo ($good["top_info"]["dealer_cost_price"]); ?></td>
                        <td><?php echo ($good["top_info"]["retail_price_low"]); ?> - <?php echo ($good["top_info"]["retail_price_high"]); ?> [<a href="javascript:void(0);" class="buttonTrdPrice" pid="<?php echo ($good["top_info"]["pid"]); ?>" >设置</a>]</td><?php endif; ?>
                    </tr>
                </tbody>
            </table>
        </div>
		-->

    </div><!--proDetails  end-->

</div><!--rightInner  end-->

<!--第三方平台零售价格区间设置弹框-->
<div id="trdPriceWindow" style="display: none;" title="设置第三方平台销售价格区间">
    <form id="trdPriceForm" method="post" action="###">
    <table class="tbForm" width="100%">
        <thead>
            <tr>
                <td></td><td><input type="hidden" name="pid" value="" id="pid" /></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>最低零售价</td>
                <td><input type="text" class="small" name="retail_price_low" /></td>
            </tr>
            <tr>
                <td>最高零售价</td>
                <td><input type="text" class="small" name="retail_price_high" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" id="trdPriceSubmit" class="btnA" value="设置" /></td>
            </tr>
        </tbody>
    </table>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function($){
        $('#example3').etalage({
            thumb_image_width: 328,
            thumb_image_height: 328,
            source_image_width: 900,
            source_image_height: 900,
            zoom_area_width: 500,
            zoom_area_height: 500,
            zoom_area_distance: 5,
            small_thumbs: 5,
            smallthumb_inactive_opacity: 0.5,
            smallthumbs_position: 'top',
            show_icon: true,
            icon_offset: 20,
            autoplay: false,
            keyboard: false,
            zoom_easing: false
        });

        $('#trdPriceWindow').dialog({
            autoOpen: false,
            resizable: false,
            modal: true
        });

        $('.buttonTrdPrice').click(function(){
            $('#trdPriceWindow').dialog('open');
        });

        $('#trdPriceSubmit').click(function(){
            var pid = $(this).attr('pid');
            if($("#trdPriceForm").valid()){
                $('#pid').val(pid);
                var dat = $("#trdPriceForm").serialize();
                var url = '/Admin/Products/doTrdPriceSet/';
                $('#trdPriceWindow').dialog('close');
                ajaxReturn(url,dat);
            }
        });
    });
    // TAB 切换
    function setTab(clickObj){
		var id = $(clickObj).attr("div_id");
        var html_id_attr = 'con_tabListP_' + id;
		$(".tabListP_Span").removeClass("onHover");
		$(clickObj).addClass("onHover");
		$(".borderDiv").css({display:"none"});
		$("#con_tabListP_" + id).css({display:"block"});
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