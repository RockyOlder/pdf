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
    <table width="100%" class="tbList">
        <thead>
            <tr class="title">
                <th colspan="">充值审核列表</th>
                <th colspan="99" style="text-align:right;font-size: 12px;">
                    <form id="searchForm" method="get" action="<?php echo U('Admin/Financial/pageListVerify');?>">
                        用户名：<input type="text" name="user_name" class="large" value="<?php echo ($data["user_name"]); ?>" style="width: 145px;">
                        汇款人：<input type="text" name="re_user_name" class="large" value="<?php echo ($data["re_user_name"]); ?>" style="width: 145px;">
                        支付宝交易号：<input type="text" name="payment_sn" class="large" value="<?php echo ($data["payment_sn"]); ?>" style="width: 145px;">
                                <input type="submit" value="搜 索" class="btnHeader inpButton">
                    </form>
                </th>
        </tr>
        <tr>
            <th> #</th>
            <th>操作</th>
            <th>用户名</th>
            <th>汇款人</th>
            <th>充值金额</th>
            <th>尾数</th>
            <th>支付宝交易号</th>
            <th>会员留言</th>
            <th>回复</th>
			<th>充值时间</th>
            <th>创建时间</th>
			<th>更新时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($ary_examine)): $i = 0; $__LIST__ = $ary_examine;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$examine): $mod = ($i % 2 );++$i;?><tr>
                <td> <input type="checkbox" name="re_id" id="re_id" value="<?php echo ($examine["re_id"]); ?>" /></td>
                <?php if($examine["re_status"] == '0'): ?><td id="list_<?php echo ($examine["re_id"]); ?>">
                        <font id="re_status_<?php echo ($examine["re_id"]); ?>" color="red">已作废</font>
                    </td>
                <?php else: ?>
                    <td  id="list_<?php echo ($examine["re_id"]); ?>">
                        <?php if($examine[re_verify] == '2'): ?><font color="red">未通过</font>&nbsp;&nbsp;
                            <font id="re_status_<?php echo ($examine["re_id"]); ?>" color="blue" class="verify" data-field="re_status" data-value="0" data-id="<?php echo ($examine["re_id"]); ?>" style="cursor: pointer;">作废</font>
                        <?php elseif($examine[re_verify] == '1'): ?>
                            <font color="green">已审核</font>&nbsp;&nbsp;
                        <?php else: ?>
                            <font id="re_verify_1" color="blue" data-field="re_verify" data-value="1" data-id="<?php echo ($examine["re_id"]); ?>" class="verify" style="cursor: pointer;">审核</font>&nbsp;&nbsp;
                            <font id="re_verify_2" color="blue" data-field="re_verify" data-value="2" data-id="<?php echo ($examine["re_id"]); ?>" class="verify" style="cursor: pointer;">驳回</font>&nbsp;&nbsp;
                            <font id="re_status_<?php echo ($examine["re_id"]); ?>" color="blue" class="verify" data-field="re_status" data-value="0" data-id="<?php echo ($examine["re_id"]); ?>" style="cursor: pointer;">作废</font><?php endif; ?>
                    </td><?php endif; ?>
                <td><?php echo ($examine["m_name"]); ?></td>
                <td><?php echo ($examine["re_name"]); ?></td>
                <td><?php echo ($examine["re_money"]); ?></td>
                <td><?php echo ($examine["re_money_end"]); ?></td>
                <td><?php echo ($examine["re_payment_sn"]); ?></td>
                <td><?php echo ($examine["re_message"]); ?></td>
                <td><?php echo ($examine["re_admin_message"]); ?></td>
				<td><?php echo ($examine["re_time"]); ?></td>
                <td><?php echo ($examine["re_create_time"]); ?></td>
				<td><?php echo ($examine["re_update_time"]); ?></td>
            </tr>
            <tr id="next_<?php echo ($examine["re_id"]); ?>"  style="display:none">
                <td colspan="12"></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(empty($examine)): ?><tr><td colspan="99" class="left">暂时没有数据!</td></tr><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99"><span class="right page"><?php echo ($page); ?></span></td>
            </tr>
        </tfoot>
    </table>
    <div id="examine" style="display: none;" title="预存款详细信息">
      
    </div>
    <div class="clear"></div>
</div>

<div id="verify_div"  style="display: none"><!--弹框  开始-->
    <table class="alertTable">
        <tr>
            <td align="right" width="75" valign="top">备注：</td>
            <td>
                <textarea id="verify_comments" class="mediumBox"></textarea>
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
<script type="text/javascript">
$(document).ready(function(){
    $(".verify").live('click',function(){
        var id = $(this).attr("data-id");
        var field = $(this).attr("data-field");
        var val = $(this).attr("data-value");
        $("#verify_div").dialog({
            width:450,
            height:300,
            modal:true,
            title:'',
            buttons:{
                '确定':function(){
                    // if($("#verify_comments").val() == ''){
                    //     showAlert(false,'备注不能为空！');
                    //     $(this).dialog("close");
                    //     return false;
                    // }
                    $.ajax({
                        url:'<?php echo U("Admin/Financial/doStatus");?>',
                        cache:false,
                        dataType:'json',
                        type:'POST',
                        data:{id:id,field:field,val:val,comments:$('#verify_comments').val()},
                        error:function(){
                            $('<div id="resultMessage" />').addClass("msgError").html('AJAX请求发生错误！').appendTo('.mainBox').fadeOut(1000);
                        },
                        success:function(msgObj){
                            if(msgObj.status == '1'){
                                if(field == 're_status'){
                                    $("#list_"+id).html("<font color='red'>已作废</font>");
                                    return false;
                                }else if(field == 're_verify' && val == '2'){
                                    $("#list_"+id+" #re_verify_1").remove();
                                    $("#list_"+id).html("<font color='red'>未通过</font>\r\r<font color='blue' style='cursor: pointer;' data-id='"+id+"' data-value='0' data-field='re_status' class='verify' id='re_status_"+id+"'>作废</font>");
                                    return false;
                                }else{
                                    $("#list_"+id+" #re_verify_2").remove();
                                    $("#list_"+id).html("<font color='green'>已审核</font>\r\r");
                                    return false;
                                }
                            }else{
                                $('<div id="resultMessage" />').addClass("msgError").html(msgObj.info).appendTo('.mainBox').fadeOut(1000);
                            }
                        }
                    });
                    $(this).dialog("close");
                    return false;
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