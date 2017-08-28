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
							<a href='<?php echo U("Admin/Voucher/addVoucher");?>' class="btnG ico_add">新增</a>
							<a href="javascript:void(0);" class="btnG ico_explort">导出Excel</a>
						</p>
						<ul class="conOneUl" style="width:815px;">
							<form method="get" action="<?php echo U('Admin/Voucher/pageList');?>" >
								<li>
									<select name="sr_type" class="small" style="width: auto">
										<option value="select">选择销货类型</option>
										<option value="0" <?php if($filter['sr_type'] == '0'): ?>selected="selected"<?php endif; ?>>线下支付</option>
										<option value="1" <?php if($filter['sr_type'] == '1'): ?>selected="selected"<?php endif; ?> >货到付款</option>
									</select>
								</li>
								<li>
									<select name="sr_verify_status" class="small" style="width: auto">
										<option value="select">确认状态</option>
										<option value="0" <?php if($filter['sr_verify_status'] == '0'): ?>selected="selected"<?php endif; ?> >未确认</option>
										<option value="1" <?php if($filter['sr_verify_status'] == '1'): ?>selected="selected"<?php endif; ?> >已确认</option>
										<option value="2" <?php if($filter['sr_verify_status'] == '2'): ?>selected="selected"<?php endif; ?> >已作废</option>
									</select>
								</li>
                    
								<li>制单时间：<input type="text" name="starttime" class="small medium timer" value="<?php echo ($filter["starttime"]); ?>"  style="width: 100px;float: none;"></li>
								<li>至<input type="text" name="endtime" class="small medium timer" value="<?php echo ($filter["endtime"]); ?>"  style="width: 100px;float: none;"></li>
								<li>
									<select name="field" class="small" style="width: auto">
									   <option value="m_name" <?php if($filter['field'] == 'm_name'): ?>selected="selected"<?php endif; ?>>会员名</option> 
									   <option value="o_id" <?php if($filter['field'] == 'o_id'): ?>selected="selected"<?php endif; ?>>订单号</option>
									   <option value="sr_id" <?php if($filter['field'] == 'sr_id'): ?>selected="selected"<?php endif; ?>>单据编号</option>
										<option value="sr_bank_sn" <?php if($filter['field'] == 'sr_bank_sn'): ?>selected="selected"<?php endif; ?>>流水号</option>
										<option value="sr_logistics_sn" <?php if($filter['field'] == 'sr_logistics_sn'): ?>selected="selected"<?php endif; ?>>物流单</option>
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
					<th width="60px">操作</th>
					<th>单据编号</th>
					<th>单据状态</th>
					<th>销货类型</th>
					<th>会员名称</th>
					<th>调整金额</th>
					<th>制单人</th>
					<th>制单日期</th>
					<th>订单号</th>
					<th>流水号</th>
					<th>汇款时间</th>
					<th>物流单</th>
					<th width="50px">备注</th>
				</tr>
            </thead>
            <tbody>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$datas): $mod = ($i % 2 );++$i;?><tr>
                  <td><input type="checkbox" class="checkSon" data-xid="checkSon_x" name="sr_id[]" value="<?php echo ($datas["sr_id"]); ?>" bi_sn="<?php echo ($datas["sr_id"]); ?>" /></td>
                  <td>
                      <?php if(($datas["sr_verify_status"] == '0') AND ($datas["sr_status"] != '0')): ?><span style="font-family:Arial;font-size:13px;font-weight:normal;font-style:normal;text-decoration:none;color:#0000FF;">
                           	<a href="<?php echo U('Admin/Voucher/pageEdit');?>?sr_id=<?php echo ($datas["sr_id"]); ?>">编辑</a>
                           </span>
                           <span style="font-family:Arial;font-size:13px;font-weight:normal;font-style:normal;text-decoration:none;color:#000000;">
                           	<a class="doStatus" data-id="<?php echo ($datas["sr_id"]); ?>">确认</a>
                           </span>   
                      <?php else: ?>
                          <span style="font-family:Arial;font-size:13px;font-weight:normal;font-style:normal;text-decoration:none;color:#999999;">编辑</span>
                          <span style="font-family:Arial;font-size:13px;font-weight:normal;font-style:normal;text-decoration:none;color:#000000;">确认</span><?php endif; ?>
                  </td>
                  <td>
                      <a title="查看详情" href="<?php echo U('Admin/Voucher/detailVoucher');?>?sr_id=<?php echo ($datas["sr_id"]); ?>"><?php echo ($datas["sr_id"]); ?></a>
                  </td>
                  <td width="100px">
                      <?php if($datas["sr_verify_status"] == '0'): if($datas["sr_status"] == '0'): ?>已作废
	 					<?php else: ?>
	 					未确认<?php endif; endif; ?>
                      <?php if($datas["sr_verify_status"] == '1'): ?>已确认<?php endif; ?>

                </td>
                <td>
                    <?php if($datas["sr_type"] == '0'): ?>线下支付<?php endif; ?>
                   <?php if($datas["sr_type"] == '1'): echo (($pay_name)?($pay_name):'货到付款'); endif; ?>               
                </td>
                <td><?php echo ($datas["m_name"]); ?></td>
                <td><?php echo ($datas["to_post_balance"]); ?></td>
                <td><?php echo ($datas["u_name"]); ?></td>
                <td><?php echo (($datas["sr_create_time"])?($datas["sr_create_time"]):'0000-00-00 00:00:00'); ?></td>
                <td><?php echo (($datas["o_id"])?($datas["o_id"]):'暂无'); ?></td>
                <td><?php echo (($datas["sr_bank_sn"])?($datas["sr_bank_sn"]):'暂无'); ?></td>
                <td><?php echo ($datas["sr_create_time"]); ?></td>
                <td><?php echo ($datas["sr_logistics_sn"]); ?></td>
                <td><span style="overflow:hidden;"><?php echo (($datas["sr_remark"])?($datas["sr_remark"]):"暂无"); ?></span></td>
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
    <script>
    $(document).ready(function(){
        $(".ico_explort").click(function(){
            var bi_sns = new Array();;
            $(".tbList input:checked[class='checkSon']").each(function(){
                bi_sns.push($(this).attr("bi_sn"));
            });
            var bi_id = bi_sns;
            bi_sns = bi_sns.join(",");
            if(bi_sns == ''){
                alert("请选择需要导出的单据编号");
                return false;
            }
            $.ajax({
                url:'<?php echo U("Admin/Voucher/explortVoucher");?>',
                cache:false,
                dataType:'json',
                data:{bi_sns:bi_sns},
                type:'POST',
                success:function(msgObj){
                    if(msgObj.status == '1'){
                        var url = "<?php echo U('Admin/Voucher/getExportFileDownList');?>" + "?type=excel&file="+msgObj.data;
                        window.location.href = url;
                        return false;
                    }else{
                        alert(msgObj.info);return false;
                    }
                }
            });
        });
        $(".doStatus").click(function(){
            var id = $(this).attr("data-id");
            $.ajax({
                url:'<?php echo U("Admin/Voucher/doStatus");?>',
                cache:false,
                dataType:'json',
                type:'POST',
                data:{'tid':id,'type':'conf'},
                success:function(msgObj){
                    if(msgObj.status == '0'){
                    	showAlert(false,msgObj.info); 
                    	return false;
                    }else{
                    	showAlert(true,msgObj.info); 
                    	location.href='<?php echo U("Admin/Voucher/pageList");?>';
                    }
                },
                error:function(msgObj){
                    showAlert('',msgObj.info); 
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