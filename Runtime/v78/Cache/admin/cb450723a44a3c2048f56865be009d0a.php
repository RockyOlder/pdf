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
				<th colspan="99">
				 <form method="post" action="<?php echo U('Admin/Groupbuy/pageList');?>">
                   <p class="conOneP" style="float: left;">
                       <a href="<?php echo U('Admin/Groupbuy/pageAdd');?>" class="btnG ico_add">添加团购</a>
                       <a href="javascript:void(0);" onclick="return getCheckedProducts(this);" class="btnG Set">批量删除</a>
                   </p>
					<span style="float: right;">
					有效期：<input type="text" class="width_100 timer search_cond" name="gp_start_time" value="<?php echo ($filter["gp_start_time"]); ?>" />
					- 
					<input type="text" class="width_100 timer search_cond" name="gp_end_time" value="<?php echo ($filter["gp_end_time"]); ?>" />
                    <select name="gcid" class="small search_cond" style="width: auto">
                             <option value="0"  >选择团购类目</option>
                             <?php if(is_array($cates)): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate['gc_id']); ?>" <?php if(($gcid == $cate['gc_id'])): ?>selected=selected<?php endif; ?> ><?php echo ($cate['gc_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							 <?php if(!empty($cate["sub"])): if(is_array($cate["sub"])): $i = 0; $__LIST__ = $cate["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($sub_cate['gc_id']); ?>" <?php if(($gcid == $sub_cate['gc_id'])): ?>selected=selected<?php endif; ?> >----<?php echo ($sub_cate['gc_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </select>	
					<select name="gbbid" class="small search_cond" style="width: auto">
                             <option value="0"  >选择团购品牌</option>
                             <?php if(is_array($brands)): $i = 0; $__LIST__ = $brands;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?><option value="<?php echo ($brand['gbb_id']); ?>" <?php if(($gbbid == $brand['gbb_id'])): ?>selected=selected<?php endif; ?> ><?php echo ($brand['gbb_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>	
					<select name="field" class="small search_cond" style="width: auto">
                             <option value="1" <?php if(($filter["field"] == 1)): ?>selected=selected<?php endif; ?> >团购标题</option>
                             <option value="2" <?php if(($filter["field"] == 2)): ?>selected=selected<?php endif; ?> >商品标题</option>
                             <option value="3" <?php if(($filter["field"] == 3)): ?>selected=selected<?php endif; ?> >商品编码</option>
                    </select>
                     <input type="text" name="val" class="large search_cond" value="<?php echo ($filter["val"]); ?>" style="width: 145px;">
					<a href="javascript:void(0);" class="btnA" id="searchButton">搜索</a>					
					</span>
				</form>
				</th>
			</tr>
			<tr>
				<th><input type="checkbox" class="checkAll" /></th>
				<th>操作</th>
				<th>团购标题</th>
				<th>团购商品名称</th>
				<th>状态</th>
				<th>起止时间</th>
				<th>实际销售</th>
				<th>虚拟购买</th>
				<th>限购</th>
				<th>每人限购</th>
			</tr>
		</thead>
    		<tbody>
        		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i;?><tr>
        				<td>
                            <input type="checkbox" class="checkSon" name="gp_id" value="<?php echo ($cp["gp_id"]); ?>" />
                        </td>
        				<td>
        					<span style="display:block;width:80px;">
							<?php if($is_bulk == 1){ ?>
							<a class="blue" href="<?php echo U('Home/Groupbuy/detail');?>/gpid/<?php echo ($cp[gp_id]); ?>/gid/<?php echo ($cp[g_id]); ?>" title="预览" target="_blank" >[预览]</a>
							<?php }else{ ?>
							<a class="blue" href="<?php echo U('Home/Bulk/detail');?>/gp_id/<?php echo ($cp[gp_id]); ?>/gid/<?php echo ($cp[g_id]); ?>" title="预览" target="_blank" >[预览]</a>
							<?php } ?>
        					<a href='<?php echo U("Admin/Groupbuy/pageEdit?gp_id=$cp[gp_id]");?>' class="edit"></a> | <a href='<?php echo U("Admin/Groupbuy/doDel?gp_id=$cp[gp_id]");?>' class="confirm delete"></a>
                            </span>
                        </td>
        				<td><?php echo ($cp["gp_title"]); ?></td>
        				<td><span class="blue"><?php echo ($cp["g_name"]); ?></span></td>
        				<td>
        				    <?php if(($cp["is_active"]) == "1"): ?><span class="green">启用</span>
                            <?php else: ?>
                                <span class="red">停用</span><?php endif; ?>
        				</td>
        				<td><?php echo ($cp["gp_start_time"]); ?> - <?php echo ($cp["gp_end_time"]); ?></td>
        				<td><?php echo ($cp["gp_now_number"]); ?></td>
        				<td>
						<?php echo ($cp["gp_pre_number"]); ?>
        				</td>
        				<td><?php echo ($cp["gp_number"]); ?></td>
        				<td><?php echo ($cp["gp_per_number"]); ?></td>
        			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
        		<?php if(empty($list)): ?><tr><td colspan="99" class="left">暂时没有数据!</td></tr><?php endif; ?>
    		</tbody>
    		<tfoot>
    			<tr>
    				<td colspan="99">
                        <span class="right page"><?php echo ($page); ?></span>
                    </td>
    			</tr>
    		</tfoot>
	</table>
    <div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#searchButton").click(function(){
		var redirect_url = "<?php echo U('Admin/Groupbuy/pageList');?>" + "?";
		$(".search_cond").each(function(){
			redirect_url += $(this).attr("name") + "=" + encodeURIComponent($(this).val()) + '&';
		});
		location.href= redirect_url;
	});
});
function getCheckedProducts(){
    var gp_id = '';
    $("input[class='checkSon']:checked").each(function(){
    	gp_id += this.value+',';
    });
    gp_id = gp_id.substring(0,gp_id.length-1);
    deleteCombiantionGoods(gp_id);
}
function deleteCombiantionGoods(gp_id){
    if(confirm('确定要删除吗？删除后不可恢复')){
        $.ajax({
            url:"<?php echo U('Admin/Groupbuy/doDel');?>",
            data:{'gp_id':gp_id},
            dateType:'json',
            type:'POST',
            success:function(DataMsg){
                if(DataMsg.status=='1'){
                    showAlert(true,DataMsg.info,'',{'成功':'/Admin/Groupbuy/pageList'});return false;
                }else{
                    showAlert(false,DataMsg.info);return false;
                }
            },
            error:function(){
            
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