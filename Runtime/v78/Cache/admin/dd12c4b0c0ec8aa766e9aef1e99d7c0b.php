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
                <div id="tip_dialog">
</div>
<div id="content">
    <div class="rightInner">
        <form id="promotion_edit" name="promotion_edit" method="post" action="<?php echo U('Admin/Voucher/doAdd');?>">
            <table class="tbForm" width="100%">
                <thead>
                    <tr class="title">
                        <th colspan="99">新增销货收款单 </th>
                    </tr>
                </thead>

                <tbody class="tab">
                    <tr>
                        <td class="first"><font color="red">*</font>销货类型：</td>
                        <td>
                            <select name="sr_type" id="sr_type"  class="small" style="width:152px;">
                                <option value="select" >选择调整单类型</option>
                                <option value="0" >线下支付</option>
                                <option value="1" ><?php echo (($pay_name)?($pay_name):'货到付款'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr class="type0 type1" style="display:none;">
                        <td class="first">订单号：</td>
                        <td>
                            <input type="text"  class="large medium oblur" value="" name="o_id" id="o_id" style="width: 145px;float: none;" />
                        </td>
                        <td class="last"></td>
                    </tr>
                    <tr class="type1" style="display:none;">
                        <td class="first">物流单：</td>
                        <td>
                            <input type="text"  value="" class="large medium"name="sr_logistics_sn" id="sr_logistics_sn" style="width: 145px;float: none;" />
                        </td>
                        <td class="last"></td>
                    </tr>                    
                   <tr id="memberName" style="display: none;">
                        <td class="first">会员名称：</td>
                        <td>
                            <span id="m_name"></span>
                        </td>
                    </tr>
                    <tr id="memberBalance" style="display: none;">
                        <td class="first">结余款余额：</td>
                        <td>
                            <span  id="balance">0.00</span>
                        </td>
                    </tr>
                    <tr id="memberTradePrice" style="display: none;">
                        <td class="first">当前订单金额：</td>
                        <td>
                            <span  id="tradeprice">0.00</span>
                        </td>
                    </tr>
                    <tr class="type0" style="display: none;">
                        <td class="first">汇款人：</td>
                        <td>
                            <input type="text"  value="" class="large medium" name="sr_remitter" id="sr_remitter"  style="width: 145px;float: none;"/>
                        </td>
                    </tr>
                    <tr class="type0" style="display: none;">
                        <td class="first">开户行：</td>
                        <td>
                            <input type="text"  value="" class="large medium" name="sr_bank" id="sr_bank"  style="width: 145px;float: none;"/>
                        </td>
                    </tr>
                   <tr class="type0 type1" style="display: none;">
                        <td class="first">金额：</td>
                        <td>
                            <input type="text" validate="{required:true}"  value="" class="large medium" name="to_post_balance" id="to_post_balance" style="width: 145px;float: none;" />
                        </td>
                    </tr>
                    <tr class="type0" style="display: none;">
                        <td class="first">流水号：</td>
                        <td>
                            <input type="text"  value="" class="large medium" name="sr_bank_sn" id="sr_bank_sn"  style="width: 145px;float: none;"/>
                        </td>
                    </tr>
                    <tr class="type0" style="display: none;">
                        <td class="first">汇款时间：</td>
                        <td>
                            <input type="text" name="sr_remit_time" class="large medium timer" value="<?php echo ($filter["starttime"]); ?>"  style="width: 145px;float: none;">
                        </td>
                    </tr>
                    <tr class="type0 type1" style="display: none;">
                        <td class="first">备注：</td>
                        <td>
                        	<textarea class="large medium" name="sr_remark" id="sr_remark" maxlength="200" style="width: 200px;height:100px;float: none;"> </textarea>
                        </td>
                    </tr>                                                                             
                    <tr class="last">
                    	<td></td>
                        <td>
                            <input type="submit" value="确 定" class="btnA" />&nbsp;
                            <input type="button" value="取 消" onClick="onUrl('<?php echo U("Admin/Voucher/pageList");?>');" class="btnA back" />
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </form>
        <div class="clear"></div>
    </div>
</div>
<script>
$(document).ready(function(){
	var type = $("#sr_type").attr("value");
	if(type == '0'){
		$(".type1").css('display','none');
		$(".type0").css('display','');
	}
	if(type == '1'){
		$(".type0").css('display','none');
		$(".type1").css('display','');
	}
	$('#promotion_edit').validate();
    $("#sr_type").change(function(){
		var type_value = $("#sr_type").attr("value");
		if(type_value == 'select'){
			$(".type0").css('display','none');
			$(".type1").css('display','none');
		}
		if(type_value == '0'){
			$(".type1").css('display','none');
			$(".type0").css('display','');
		}	
		if(type_value == '1'){
			$(".type0").css('display','none');
			$(".type1").css('display','');
		}			
    });
    $(".oblur").blur(function(){
        var tid = $("#o_id").val();
        if(tid == ''){
            showAlert("","请先输入订单号");return false;
        }
        $.ajax({
            url:'<?php echo U("Admin/Voucher/selectMembers");?>',
            cache:false,
            dataType:'TEXT',
            type:'POST',
            data:{tid:tid},
            success:function(msgObj){
                var msgobj = JSON.parse(msgObj);
                if(msgobj.status == '0'){
                	showAlert('',msgobj.msg);
                	document.getElementById("balance").innerHTML = "";
                	document.getElementById("m_name").innerHTML = "";
                	document.getElementById("tradeprice").innerHTML = "";
                	$("#memberName").css('display','none');
                	$("#memberBalance").css('display','none');  
                	$("#memberTradePrice").css('display','none');          	
                	return;
                }else{
                    if(msgobj.data.m_name){
                    	document.getElementById("balance").innerHTML = msgobj.data.m_balance;
                    	document.getElementById("m_name").innerHTML = msgobj.data.m_name;
                    	document.getElementById("tradeprice").innerHTML = msgobj.data.o_all_price;
                    	$("#memberName").css('display','');
                    	$("#memberBalance").css('display','');
                    	$("#memberTradePrice").css('display','');  
                    }
                }
            },
            error:function(msgObj){
                var msgobj = JSON.parse(msgObj);
                showAlert('',msgobj.msg);
            	document.getElementById("balance").innerHTML = "";
            	document.getElementById("m_name").innerHTML = "";
            	document.getElementById("tradeprice").innerHTML = "";
            	$("#memberName").css('display','none');
            	$("#memberBalance").css('display','none');  
            	$("#memberTradePrice").css('display','none');  
            }
        });
    });
});
$("#to_post_balance").blur(function(){
	var balance = $(this).val();
	var price = $("#tradeprice").html();
	if(balance > price){
		showAlert(false, '输入金额不能大于订单金额！');
		return false;
	}
	
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