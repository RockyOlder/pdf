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
                <div id="content">
    <div class="rightInner" id="con_tabListP_1"><!--rightInner  start-->
        <table width="100%" class="tbList">
            <thead>
                <tr class="title">
                    <th colspan="99">
            <p class="conOneP" style="float: left;">
                <a href='<?php echo U("Admin/BalanceInfo/addBalanceInfo");?>' class="btnG ico_add">新增</a>
                <a href="javascript:void(0);" class="btnG ico_explort">导出Excel</a>
            </p>
            <ul class="conOneUl" style="width:849px;">
                <form method="get" 
                      <?php if($filter["st"] == 'pending'): ?>action="<?php echo U('Admin/BalanceInfo/pageList','st=pending&status=2');?>"
                      <?php elseif($filter["st"] == 'finance'): ?>
                        action="<?php echo U('Admin/BalanceInfo/pageList','st=finance&status=2');?>"
                      <?php else: ?>
                        action="<?php echo U('Admin/BalanceInfo/pageList');?>"<?php endif; ?> style="float: none;">
                    <li>
                        <select name="bt_id" class="small" style="width: auto">
                            <option value="0">选择调整单类型</option>
                            <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ty): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ty["bt_id"]); ?>" <?php if($ty['bt_id'] == $filter['bt_id']): ?>selected="selected"<?php endif; ?>><?php echo ($ty["bt_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </li>
                    <li>制单时间：<input type="text" name="starttime" class="large medium timer" value="<?php echo ($filter["starttime"]); ?>"  style="width: 145px;float: none;"></li>
                    <li>至<input type="text" name="endtime" class="large medium timer" value="<?php echo ($filter["endtime"]); ?>"  style="width: 145px;float: none;"></li>
                    <li>
                        <select name="field" class="small" style="width: auto">
                            <option value="m_name" <?php if($filter['field'] == 'm_name'): ?>selected="selected"<?php endif; ?>>会员名</option>
                            <option value="bi_sn" <?php if($filter['field'] == 'bi_sn'): ?>selected="selected"<?php endif; ?>>单据编号</option>
                            <option value="bi_accounts_receivable" <?php if($filter['field'] == 'bi_accounts_receivable'): ?>selected="selected"<?php endif; ?>>收款帐号</option>
                            <option value="o_id" <?php if($filter['field'] == 'o_id'): ?>selected="selected"<?php endif; ?>>订单号</option>
                            <option value="or_id" <?php if($filter['field'] == 'or_id'): ?>selected="selected"<?php endif; ?>>退款单号</option>
                            <option value="pc_serial_number" <?php if($filter['field'] == 'pc_serial_number'): ?>selected="selected"<?php endif; ?>>充值卡流水号</option>
                        </select>
                    </li>
                    <li><input type="text" name="val" class="large" value="<?php echo ($filter["val"]); ?>" style="width: 145px;"></li>
                    <li><input type="submit" value="搜 索" class="btnHeader" style="margin-right: 0px;height: 23px;margin-top: 4px;"/></li>
                </form>
            </ul>
            </th>
            </tr>
            <tr>
                <th><input type="checkbox" class="checkAll" data-checklist="checkSon_x" data-direction="x"></th>
                <?php if($filter["st"] != ''): ?><th width="80px">操作</th><?php endif; ?>
                <th>单据编号</th>
                <th width="100px">审核状态</th>
                <th>类型名称</th>
                <th>会员名</th>
                <th>调整金额</th>
                <th>制单人</th>
                <th>制单日期</th>
                <th>收款账号</th>
                <th>订单号</th>
                <th>退款单号</th>
                <th>充值卡流水号</th>
                <?php if($filter["st"] == ''): ?><th>是否已作废</th><?php endif; ?>
                
                <th>备注</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$datas): $mod = ($i % 2 );++$i;?><tr>
                    <td><input type="checkbox" class="checkSon" data-xid="checkSon_x" name="bi_id[]" value="<?php echo ($datas["bi_id"]); ?>" bi_sn="<?php echo ($datas["bi_sn"]); ?>" /></td>
                    <?php if($filter["st"] != ''): if($datas["bi_verify_status"] == '2'): ?><td width="80px"><span id="bi_verify_status_<?php echo ($datas["bi_id"]); ?>" style="cursor: default;color: gray;">作废</span></td>
                        <?php else: ?>
                            <td width="80px" id="list_status_<?php echo ($datas["bi_id"]); ?>">
                                <span 
                                      <?php if($filter['st'] == 'pending'){ ?>
                                          <?php if($datas["bi_service_verify"] == '1'): ?>style="cursor: default;color: gray;"
                                          <?php else: ?>
                                            style="cursor: pointer;color: blue;"<?php endif; ?> 
                                          data-field="bi_service_verify" id="bi_service_verify_<?php echo ($datas["bi_id"]); ?>" 
                                      <?php }else{if($filter['st'] == 'finance'){ ?>
										  <?php if($datas["bi_finance_verify"] == '1'): ?>style="cursor: default;color: gray;"
                                          <?php else: ?>
                                            style="cursor: pointer;color: blue;"<?php endif; ?> 
                                      <?php } ?>
                                     

                                        data-field="bi_finance_verify" id="bi_finance_verify_<?php echo ($datas["bi_id"]); ?>" 
                                       <?php } ?>
                                    data-id="<?php echo ($datas["bi_id"]); ?>" data-value='1' class="ServiceVerify">审核</span>&nbsp;&nbsp;
                                <span id="bi_verify_status_<?php echo ($datas["bi_id"]); ?>" <?php if($datas["bi_verify_status"] == '2'): ?>style="cursor: default;color: gray;"<?php else: ?>style="cursor: pointer;color: blue;" class="ServiceVerify"<?php endif; ?>data-id="<?php echo ($datas["bi_id"]); ?>" data-field="bi_verify_status" data-value='2'>作废</span>
                            </td><?php endif; endif; ?>
                    <td>
                        <?php if($filter["st"] != ''): ?><a href='<?php echo U("Admin/BalanceInfo/detailBalanceInfo","st=$filter[st]&status=2&id=$datas[bi_id]");?>' title="<?php echo ($datas["bi_sn"]); ?>"><?php echo ($datas["bi_sn"]); ?></a>
                        <?php else: ?>    
                            <a href='<?php echo U("Admin/BalanceInfo/detailBalanceInfo","id=$datas[bi_id]");?>' title="<?php echo ($datas["bi_sn"]); ?>"><?php echo ($datas["bi_sn"]); ?></a><?php endif; ?>
                        
                    </td>
                    <td width="100px">
                        <?php if($datas["bi_verify_status"] == '2'): ?><font  color="red" >已作废</font>
                        <?php else: ?>
                           	<?php if($datas["bi_service_verify"] == '1'): ?><font  color="green" id="bi_service_verify_<?php echo ($datas["bi_id"]); ?>_status">已客审</font>
	                        <?php else: ?>
	                                <font  color="red" id="bi_service_verify_<?php echo ($datas["bi_id"]); ?>_status">未客审</font><?php endif; ?>
	                        &nbsp;&nbsp;
	                        <?php if($datas["bi_finance_verify"] == '1'): ?><font id="bi_finance_verify_<?php echo ($datas["bi_id"]); ?>_status" color="green">已财审</font>
	                        <?php else: ?>
	                                <font id="bi_finance_verify_<?php echo ($datas["bi_id"]); ?>_status" color="red">未财审</font><?php endif; endif; ?>
                </td>
                <td><?php echo ($datas["bt_name"]); ?></td>
                <td><?php echo ($datas["m_name"]); ?></td>
                <td><?php if($datas["bi_type"] == '1'): echo (sprintf('%.2f',$datas["bi_money"])); else: echo (sprintf('%.2f',$datas["bi_money"])); endif; ?></td>
                <?php if($datas["single_type"] == '2'): ?><td><?php echo ($datas["m_name"]); ?></td>
                <?php else: ?>
                    <td><?php echo ($datas["u_name"]); ?></td><?php endif; ?>
                <td><?php echo (($datas["bi_create_time"])?($datas["bi_create_time"]):'0000-00-00 00:00:00'); ?></td>
                <td><?php echo (($datas["bi_accounts_receivable"])?($datas["bi_accounts_receivable"]):'暂无'); ?></td>
                <td><?php echo (($datas["o_id"])?($datas["o_id"]):'暂无'); ?></td>
                <td><?php echo (($datas["or_id"])?($datas["or_id"]):'暂无'); ?></td>
                <td><?php echo (($datas["pc_serial_number"])?($datas["pc_serial_number"]):'暂无'); ?></td>
                <?php if($filter["st"] == ''): ?><td><?php if($datas["bi_verify_status"] == '2'): ?><fon color="red">是</font><?php else: ?>否<?php endif; ?></td><?php endif; ?>
                
                <td id="Note"><?php echo (($datas["bi_desc"])?($datas["bi_desc"]):"暂无"); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="99">
                        <span class="right page">
                            <?php echo ($page); ?>
                        </span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div><!--rightInner  end-->
</div>
<div id="excel_dialog" style="display:none;">
    <table class="tbForm" width="100%">
        <tbody>
            <tr>
                <td><input name="member" type="radio" value="1" checked="checked">导出当前选中的充值卡</td>
            </tr>
            <tr>
                <td><input name="member" type="radio" value="2"/>导出所有充值卡</td>
            </tr>
            <tr>
                <td><input name="member" type="radio" value="3"/>导出当前搜索结果</td>
            </tr>
        </tbody>
    </table>
</div>
<input type="hidden" value="<?php echo ($filterExcel); ?>" name="filterExcel"/>
<script>
    $(document).ready(function(){
        // $(".ico_explort").click(function(){
        //     var bi_sns = new Array();;
        //     $(".tbList input:checked[class='checkSon']").each(function(){
        //         bi_sns.push($(this).attr("bi_sn"));
        //     });
        //     var bi_id = bi_sns;
        //     bi_sns = bi_sns.join(",");
        //     if(bi_sns == ''){
        //         alert("请选择需要导出的单据编号");
        //         return false;
        //     }
        //     $.ajax({
        //         url:'<?php echo U("Admin/BalanceInfo/explortBalanceInfo");?>',
        //         cache:false,
        //         dataType:'json',
        //         data:{bi_sns:bi_sns},
        //         type:'POST',
        //         success:function(msgObj){
        //             if(msgObj.status == '1'){
        //                 var url = "<?php echo U('Admin/BalanceInfo/getExportFileDownList');?>" + "?type=excel&file="+msgObj.data;
        //                 window.location.href = url;
        //                 return false;
        //             }else{
        //                 alert(msgObj.info);return false;
        //             }
        //         }
        //     });
        // });
        $(".ico_explort").bind({'click':function(){
            //弹出对话框，确认导出成员对象
            $('#excel_dialog').dialog({
                height : '205',
                width  : '300',
                resizable:false,
                title:'导出',
                buttons:{
                    '确认' : function(){
                        $('#excel_dialog').dialog('destroy');               //先关闭对话框
                        var bi_sns = setPcids();                            //通过单选获取m_ids的值
                        if(bi_sns == ''){
                            $("#J_ajax_loading").removeClass('ajax_success').addClass('ajax_error').html('请选择需要导出的单据编号').show().fadeOut(2000);
                            return false;
                        }else{
                            explortExcel(bi_sns,$('.tbForm input[type="radio"]:checked').val());  //将成员值以Excel格式导出
                        }
                    },
                    '取消' : function(){
                        $('#excel_dialog').dialog('destroy');
                    }
                },
                close:function(){
                    $('#excel_dialog').dialog('destroy');
                }
            });
        }});
        <?php if($filter["st"] != ''): endif; ?>
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
                        $("#"+field+"_"+id).css({"color":"gray","cursor":"default"});
                        $("#"+field+"_"+id).removeClass("ServiceVerify");
                        var strstatus = '<span style="color:gray;cursor:default;">作废</span>';
                        $("#list_status_"+id).html(strstatus);
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
function setPcids(){
    //获取Radio的值
    var select_type = $('.tbForm input[type="radio"]:checked').val();
    //初始化m_ids的值为选中成员
    var bi_sns = new Array();;
    $(".tbList input:checked[class='checkSon']").each(function(){
        bi_sns.push($(this).attr("bi_sn"));
    });
    var bi_id = bi_sns;
    bi_sns = bi_sns.join(",");
    switch(parseInt(select_type)){
        case 1 : return bi_sns;break;
        case 2 : return 'ALL';break;
        case 3 : return $('input[name="filterExcel"]').val();break;
        default: return bi_sns;
    }
}
function explortExcel(bi_sns,type){
    $.ajax({
        url      : '<?php echo U("Admin/BalanceInfo/explortBalanceInfo");?>',
        cache    : false,
        dataType : 'json',
        data     : {bi_sns:bi_sns,type:type},
        type     : 'POST',
        beforeSend:function(){
            $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
        },
        success:function(msgObj){
            if(msgObj.status == '1'){
                var url = "<?php echo U('Admin/BalanceInfo/getExportFileDownList');?>" + "?type=excel&file="+msgObj.data;
                $("#J_ajax_loading").removeClass('ajax_error').addClass('ajax_success').html(msgObj.info).show().fadeOut(2000);
                window.location.href = url;
                return false;
            }else{
                $("#J_ajax_loading").removeClass('ajax_success').addClass('ajax_error').html(msgObj.info).show().fadeOut(2000);
            }
        },
        error:function(){
            $("#J_ajax_loading").removeClass('ajax_success').addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(2000);
        },
    });
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