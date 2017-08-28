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
                <div class="rightInner">
    <table class="tbForm" width="100%">
        <thead>
            <tr class="title">
                <th colspan="99">结余款调整单详情</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="first">单据编号：</td>
                <td>
                    <?php echo ($data["bi_sn"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">调整类型：</td>
                <td>
                    <?php echo ($data["bt_name"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">会员名称：</td>
                <td>
                    <?php echo ($data["m_name"]); ?>
                </td>
                <td class="last"></td>
            </tr>
<!--            <tr>
                <td class="first">调整金额：</td>
                <td>
                    <?php echo ($data["bi_money"]); ?>
                </td>
            </tr>-->
<!--            <tr>
                <td class="first">收款银行：</td>
                <td>
                    <?php echo ($data["bi_accounts_bank"]); ?>
                </td>
            </tr>
            <tr>
                <td class="first">收款账号：</td>
                <td>
                    <?php echo ($data["bi_accounts_receivable"]); ?>
                </td>
            </tr>
            <tr>
                <td class="first">付款日期：</td>
                <td>
                    <?php echo ($data["bi_payment_time"]); ?>
                </td>
                <td class="last"></td>
            </tr>-->
            <tr>
                <td class="first">授权类型：</td>
                <td>
                    <?php echo ($data["conversion_type"]); ?>
                </td>
            </tr>
            <tr>
                <td class="first">授权次数：</td>
                <td>
                    <?php echo ($data["number_remaining"]); ?>
                </td>
            </tr>
            <tr>
                <td class="first">授权时间：</td>
                <td>
                    <?php echo ($data["end_time"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">制单人：</td>
                <td>
                    <?php echo ($data["u_name"]); ?>
                </td>
            </tr>
            <tr>
                <td class="first">制单日期：</td>
                <td>
                    <?php echo ($data["bi_create_time"]); ?>
                </td>
            </tr>
            <tr>
                <td class="first">客审人：</td>
                <td>
                    <?php echo ($data["pending"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">审核日期：</td>
                <td>
                    <?php echo ($data["pending_time"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">财审人：</td>
                <td>
                    <?php echo ($data["finance"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">审核日期：</td>
                <td>
                    <?php echo ($data["finance_time"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">作废人：</td>
                <td>
                    <?php echo ($data["invalid"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">作废日期：</td>
                <td>
                    <?php echo ($data["invalid_time"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">备注：</td>
                <td>
                    <?php echo ($data["bi_desc"]); ?>
                </td>
                <td class="last"></td>
            </tr>
            <tr>
                <td class="first">状态：</td>
                <td>
        <?php if($data["bi_service_verify"] == '1'): ?><font  color="green" id="bi_service_verify_<?php echo ($data["bi_id"]); ?>_status">已客审</font>
            <?php else: ?>
            <font  color="red" id="bi_service_verify_<?php echo ($data["bi_id"]); ?>_status"><b>未客审</b></font><?php endif; ?>
        &nbsp;&nbsp;
        <?php if($data["bi_finance_verify"] == '1'): ?><font id="bi_finance_verify_<?php echo ($data["bi_id"]); ?>_status" color="green">已财审</font>
            <?php else: ?>
            <font id="bi_finance_verify_<?php echo ($data["bi_id"]); ?>_status" color="red"><b>未财审</b></font><?php endif; ?>
        </td>
        </tr> 
        </tbody>
        <?php if($filter["st"] != ''): ?><tfoot>
                <tr>
                    <td colspan="99">
                        <?php if(($filter["st"] == 'pending') && ($data["bi_service_verify"] == '1') && ($data["bi_verify_status"] != '2')): ?><input type="button" value="已审核" class="btnA" style="background-color: gray;">
                            <input type="button" value="作 废" class="btnA ServiceVerify" id="bi_verify_status_<?php echo ($data["bi_id"]); ?>" data-id="<?php echo ($data["bi_id"]); ?>" data-field="bi_verify_status" data-value='2'>
                        <?php elseif(($filter["st"] == 'pending') && ($data["bi_service_verify"] == '0') && ($data["bi_verify_status"] != '2')): ?>    
                            <input type="button" value="审 核" class="btnA ServiceVerify" data-field="bi_service_verify" id="bi_service_verify_<?php echo ($data["bi_id"]); ?>" data-id="<?php echo ($data["bi_id"]); ?>" data-value='1'/>
                            <input type="button" value="作 废" class="btnA ServiceVerify" id="bi_verify_status_<?php echo ($data["bi_id"]); ?>" data-id="<?php echo ($data["bi_id"]); ?>" data-field="bi_verify_status" data-value='2'>
                        <?php elseif(($filter["st"] == 'finance') && ($data["bi_finance_verify"] == '0') && ($data["bi_verify_status"] != '2')): ?>    
                            <input type="button" value="审 核" class="btnA ServiceVerify" data-field="bi_finance_verify" id="bi_finance_verify_<?php echo ($data["bi_id"]); ?>" data-id="<?php echo ($data["bi_id"]); ?>" data-value='1'/>
                            <input type="button" value="作 废" class="btnA ServiceVerify" id="bi_verify_status_<?php echo ($data["bi_id"]); ?>" data-id="<?php echo ($data["bi_id"]); ?>" data-field="bi_verify_status" data-value='2'>
                        <?php elseif(($filter["st"] == 'finance') && ($data["bi_finance_verify"] == '1') && ($data["bi_verify_status"] != '2')): ?>
                            <input type="button" value="已审核" class="btnA" style="background-color: gray;">
                            <input type="button" value="作 废" class="btnA ServiceVerify" id="bi_verify_status_<?php echo ($data["bi_id"]); ?>" data-id="<?php echo ($data["bi_id"]); ?>" data-field="bi_verify_status" data-value='2'>
                        <?php else: ?>
                            <input type="button" value="已作废" class="btnA" style="background-color: gray;"><?php endif; ?>

            </td>
            </tr>
            </tfoot><?php endif; ?>

    </table>
    <div class="clear"></div>
</div>
<script>
    $(document).ready(function(){
        $(".ServiceVerify").live("click",function(){
            var field = $(this).attr("data-field");
            var id = $(this).attr("data-id");
            var val = $(this).attr("data-value");
            if(field == 'bi_verify_status'){
                var r=confirm("单据作废后不可恢复,确认操作?");
                if(r == false){
                    return false;
                }
            }
            $.ajax({
                url:'<?php echo U("Admin/BalanceInfo/doStatus");?>',
                cache:false,
                dataType:'json',
                type:'POST',
                data:{field:field,id:id,val:val},
                error:function(){
                    $('<div id="resultMessage" />').addClass("msgError").html('AJAX请求发生错误！').appendTo('.mainBox').fadeOut(1000);
                },
                success:function(msgObj){
                    if(msgObj.status == '1'){
                        $("#"+field+"_"+id).css({"background-color":"gray"});
                        $("#"+field+"_"+id).removeClass("ServiceVerify");
                        if(field == 'bi_service_verify'){
                            $("#bi_service_verify_"+id+"_status").css({"color":"green"});
                            $("#bi_service_verify_"+id+"_status").html("已客审");
                        }else if(field == 'bi_finance_verify'){
                            $("#bi_finance_verify_"+id+"_status").css({"color":"green"});
                            $("#bi_finance_verify_"+id+"_status").html("已财审");
                        }
                    }else{
                        $('<div id="resultMessage" />').addClass("msgError").html(msgObj.info).appendTo('.mainBox').fadeOut(1000);
                    }
                }
            });
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
<!--         <script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script> -->
    </body>
</html>