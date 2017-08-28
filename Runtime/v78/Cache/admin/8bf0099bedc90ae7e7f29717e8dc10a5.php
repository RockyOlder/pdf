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
    <div id="member_dialog" style="display:none">
        <table style="margin-bottom: 10px;">
            <tr>
                <td>
                    会员名称：<input type="text" id="m_name" class="large" value="<?php echo ($filter["val"]); ?>" style="width: 244px;">
                    <input type="button" name="search" value="搜索" id="searchMember" style="border: 1px solid #cecece;padding: 3px 10px;cursor: pointer;"/>
                </td>
            </tr>
        </table>
        <table width="100%" class="tbList">
            <thead>
            <tr>
                <th width="80px">选择</th>
                <th style="text-align: left;">会员名称</th>
            </tr>
            </thead>
            <tbody id="memberList">

            </tbody>
    </table>
    
        
    </div>
</div>
<div id="content">
    <div class="rightInner">
        <form id="balance_add" name="balance_add" method="post" action="<?php echo U('Admin/BalanceInfo/doAddBalanceInfo');?>">
            <table class="tbForm" width="100%">
                <thead>
                    <tr class="title">
                        <th colspan="99">新增结余款调整单 </th>
                    </tr>
                </thead>

                <tbody class="tab">
                    <tr>
                        <td class="first"><font color="red">*</font> 调整类型</td>
                        <td>
                            <select name="bt_id" class="small" id="Balancetype" style="width: auto" onchange="balanceType(this.value);" validate="{ selected:true}">
                                <option value="0">选择调整单类型</option>
                                <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ty): $mod = ($i % 2 );++$i; if($ty["bt_id"] == 2): else: ?>
										<option value="<?php echo ($ty["bt_id"]); ?>" id="<?php echo ($ty["bt_id"]); ?>" <?php if($ty['bt_id'] == $filter['bt_id']): ?>selected="selected"<?php endif; ?>><?php echo ($ty["bt_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                        <td class="last">请先选择调整类型,然后选择对应的客户</td>
                    </tr>
                    <tr>
                        <td colspan="99" id="addHtml"></td>
                    </tr>
                    
                    <tr class="last">
                        <td colspan="99">
                            <input type="submit" value="确 定" class="btnA" />&nbsp;
                            <input type="button" value="取 消" class="btnA back" />
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
    $("#balance_add").validate();   
    $(".showSelectedMember").live("click",function(){
        $("#member_dialog").dialog({
                    height:'400',
                    width:'auto',
                    resizable:false,
                    modal:true,
                    title:'选择会员添加',
                    buttons: {
                        '确认': function() {
                            selectMembers();
                            //$(this).dialog( "close" );
                        },
                        '关闭': function() {
                            $( this ).dialog( "close" );
                        }
                    },
                    close:function(){
                        $("#member_dialog").dialog('destroy');
                        $('#tip_dialog').append($('#member_dialog'));
                    },
                    open:function(){
                        $(this).find('.ui-dialog-content').css("max-height","300px");
                        $(this).find('.ui-dialog-content').css("overflow-y","auto");
                        $(this).find('.ui-dialog-content').css("overflow-x","hidden");
                    }
                });
    });
    
    function selectMembers(){
            var m_id = $("#memberList input:radio[name='mid']:checked").val();
            if(m_id == null ){
                alert("请选中一个");
            }else{
                var m_name = $("#memberList input:radio[name='mid']:checked").attr("m_name");
                var m_bce = $("#memberList input:radio[name='mid']:checked").attr("m_bce");
                var m_conversion_type = $("#memberList input:radio[name='mid']:checked").attr("m_conversion_type");
                var m_time = $("#memberList input:radio[name='mid']:checked").attr("m_time");
                var m_number = $("#memberList input:radio[name='mid']:checked").attr("m_number");
                var m_conversion_types  = $("#memberList input:radio[name='mid']:checked").attr("m_conversion_types")
                $("#members").html("[ "+m_name+" ]");
                $("#m_id").val(m_id);
                //$("#bi_balance_money").attr("validate",'{ required:true,min:0,remote:"/Admin/BalanceInfo/checkBalanceMoney?id='+m_id+'",messages:{min:"金额不能为负数"}}');
                $(".bi_moneys").attr("validate",'{ required:true,min:0,messages:{min:"金额不能为负数"}}');
                $("#balance").html(m_bce);
                $("#conversion_type").html(m_conversion_type);
                $("#end_time").html(m_time);
                $("#number_remaining").html(m_number);
                $("#bi_conversion_type").val(m_conversion_types);
                $("#bi_number_remaining").val(m_number);
                $("#bi_end_time").val(m_time);
                $("#memberBalan").show();
                $("#memberBalan_end_time").show();
                $("#memberBalan_remaining").show();
                $("#member_dialog").dialog('destroy');
                $('#tip_dialog').append($('#member_dialog'));
            }
            
    
    }
    
    $("#searchMember").click(function(){
           var m_name = $("#m_name").val();
           if(m_name == ''){
               alert("请输入会员名称");return false;
           }
           $.ajax({
               url:'<?php echo U("Admin/BalanceInfo/selectMembers");?>',
               cache:false,
               dataType:'TEXT',
               type:'POST',
               data:{m_name:m_name},
               success:function(msgObj){
                   $("#memberList").html(msgObj);
               }
           });
       });
});    
function balanceType(val){
    if(val == '0'){
        $("#addHtml").html('');
        return false;
    }else{
        $.ajax({
            url:'<?php echo U("Admin/BalanceInfo/addHtml");?>',
            cache:false,
            dataType:'HTML',
            data:{val:val},
            type:'POST',
            success:function(msgObj){
                $("#addHtml").html(msgObj);
            }
        });
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