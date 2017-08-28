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
                <div class="rightInner tableColor">
    <table width="100%" class="tbList" data-uri='<?php echo U("Admin/Distirbution/doStatus");?>'>
        <thead>
           <tr class="title">
               <th style="text-align:left;font-size: 12px;" colspan="99">
                   <form id="searchForm" method="get" href='<?php echo U("Admin/GoodsBrand/pageList");?>'>
                   		店铺来源:
	                    <select name="shop_source" id="thd_source_shop" style="width:120px">
	                        <option value="0">请选择</option>
	                        <?php if(is_array($ary_shops)): $i = 0; $__LIST__ = $ary_shops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["ts_id"]); ?>" <?php if($vo["ts_id"] == $ary_data['shop_source']): ?>selected="selected"<?php endif; ?>><?php echo ($vo["ts_title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	                         <span style="color:red; margin-left:40px">*</span>
	                    </select>
                   		淘宝商品状态:
                   		<select name="item_status" id="item_status">
                   			<option vaLue="0">选择状态</option>
                   			<option value="1" <?php if($ary_data["item_status"] == 1): ?>selected="selected"<?php endif; ?>>在架</option>
                   			<option value="2" <?php if($ary_data["item_status"] == 2): ?>selected="selected"<?php endif; ?>>下架(仓库)</option>
                   		</select>
                       	商品名称：
                       <input type="text" value="<?php echo ($ary_data["items_name"]); ?>" name="items_name" id="items_name" class="medium" >
                   		更新时间：
	                    <input  name="update_starttime" id="update_starttime" type="text" style="width:100px;" class="medium timer" value="<?php echo ($ary_data["update_starttime"]); ?>" readonly />
	                    <span>至</span>
	                    <input name="update_endtime" id="update_endtime" type="text" style="width:100px;" class="medium timer" value="<?php echo ($ary_data["update_endtime"]); ?>" readonly />
                        显示条数 <select name="page_num">
                                    <option value="10" <?php if($ary_data["page_num"] == 10): ?>selected="selected"<?php endif; ?>>10条</option>
                                    <option value="20" <?php if($ary_data["page_num"] == 20): ?>selected="selected"<?php endif; ?>>20条</option>
                                    <option value="30" <?php if($ary_data["page_num"] == 30): ?>selected="selected"<?php endif; ?>>30条</option>
                                 </select>
                       <input class="btnHeader inpButton" type="button" id="searchFenxiao" value="搜分销">
                       <input class="btnHeader inpButton" type="button" id="searchTaobao" value="搜淘宝">
                       <input type="hidden" name="searchType" id="searchType" value="<?php echo ($ary_data['searchType']); ?>" />
                   </form>
               </th>
            </tr>
            <tr>
                <th><input type="checkbox" class="checkAll" /></th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>商家编码</th>
                <th>所属店铺</th> 
                <th>淘宝商品状态</th>
                <th>匹配状态</th> 
                <th>下载状态</th>
                <th>下载时间</th>
                <th>淘宝最后更新时间</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($ary_shop_items)): $i = 0; $__LIST__ = $ary_shop_items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr id="list_<?php echo ($item["thd_goods_id"]); ?>">
                <td>
					<input type="checkbox" class="checkSon" name="item_id[]"  value="<?php echo ($item["thd_goods_id"]); ?>" />
                </td>
                <td><img src="<?php echo ($item["thd_goods_picture"]); ?>" width="50px" height="50px" /></td>
                <td><?php echo ($item["thd_goods_name"]); ?></td>
                <td><?php echo ($item["thd_goods_sn"]); ?></td>
                <td>
                	<?php if(is_array($ary_shops)): $i = 0; $__LIST__ = $ary_shops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["ts_id"] == $item['ts_id']): echo ($vo["ts_title"]); endif; endforeach; endif; else: echo "" ;endif; ?>
                </td>
                <td><span style="color:green;"><?php echo ($item["approve_status_name"]); ?></span></td>
                <td><?php if($item["g_sn"] != ''): ?><span style="color:green;">已匹配</span><?php else: ?><span style="color:red;">未匹配</span><?php endif; ?></td>
                <td>
                <?php if($item["no_down"] == '1'): ?><span style="color:red;">未下载</span>
                <?php else: ?>
                <span style="color:green;">已下载</span><?php endif; ?>
                </td>
                <td><?php echo ($item["thd_goods_create_time"]); ?></td>
                <td><?php echo ($item["thd_goods_update_time"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(empty($ary_shops)): ?><tr><td colspan="99" class="left">暂时没有数据!</td></tr><?php endif; ?>
            <tr>
            <td style="border-right:0px;"><input type="checkbox" id="downToFx" name="downToFx"  value="1" checked="true" ></td>
            <td colspan='9' style="text-align:left;border-left:0px;"><strong>下载时，如果存在淘宝店铺商品与系统商品不匹配，则自动将淘宝商品转换为系统商品(<font color="red">只下载商家编码存在的商品</font>)。</strong></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99">
                <span class="wait" id="wait" style="display:none;"></span>
                <span id="wait1">
                <input type="button" data-uri='<?php echo U("Admin/Distirbution/doDelShopGoods");?>'  <?php if($ary_data['searchType'] == '1'): ?>style='display:none;'<?php endif; ?> value="批量删除" class="btnA confirm" id="delAll" />
                <input type="button" data-uri='<?php echo U("Admin/Distirbution/downShopGoods");?>'  value="批量下载" class="btnA confirm" id="downSelect" />
                <input type="button" data-uri='<?php echo U("Admin/Distirbution/downAllShopGoods");?>'  <?php if($ary_data['searchType'] != '1'): ?>style='display:none;'<?php endif; ?> value="一键下载" class="btnA confirm" id="downAll" />
          		<span class="right page"><?php echo ($page); ?></span>
          		</td>
            </tr>
        </tfoot>
    </table>
    <!--</form>-->
    <div class="clear"></div>
</div>
<div id="tip_div" name="tip_div" style="display:none" title="一键下载淘宝商品">
    
</div>
<style>
.wait{background:url("__PUBLIC__/images/loading.gif") no-repeat;height:13px;width:280px;float:left;}
</style>
<script>
    $(document).ready(function(){   
    	//分销搜索
        $('#searchFenxiao').click(function() {
        	$('#searchType').val(0);
        	$('#searchForm').submit();
        });
    	//淘宝搜索
        $('#searchTaobao').click(function() {
        	var shop_id = $('#thd_source_shop').val();
        	if(shop_id == '' || shop_id == '0'){
        		showAlert(false,'搜淘宝商品请先选择店铺');
        		return false;
        	}
        	$('#searchType').val(1);
        	$('#searchForm').submit();
        });
    	//批量删除淘宝商品
        $("#delAll").live("click",function(){
	        var item_ids = new Array();;
            $(".tbList input:checked[class='checkSon']").each(function(){
            	item_ids.push(this.value);
            });
            item_id = item_ids;
            item_ids = item_ids.join(",");
            if(item_ids == ''){
				showAlert(false,"请选择需要删除的商品！");
                return false;
            }
            var url = $(this).attr("data-uri");
            var field = $(this).attr('data-field');
            $.ajax({
                url:url,
                cache:false,
                dateType:'json',
                type:'GET',
                data:{item_ids:item_ids},
                error:function(){
                },
                success:function(msgObj){
                    if(msgObj.status == '1'){
                    	showAlert(true,msgObj.info);
                        $.each(item_id,function(index,value){
                            $("#list_"+value).remove();
                        });
                       
                    }else{
                    	showAlert(false,msgObj.info);
                    }
                }
            });
        });
    	
       //批量下载淘宝商品
        $("#downSelect").live("click",function(){
        	var is_down = 0;
        	if($("#downToFx").attr("checked")==true || $("#downToFx").attr("checked") == 'checked'){
   				is_down = 1;
   			};
   			var shop_source = $("#thd_source_shop").val();
   			if(shop_source == '0'){
        		showAlert(false,'请先选择店铺');
        		return false;
   			}
	        var item_ids = new Array();;
            $(".tbList input:checked[class='checkSon']").each(function(){
            	item_ids.push(this.value);
            });
            item_id = item_ids;
            item_ids = item_ids.join(",");
            if(item_ids == ''){
				showAlert(false,"请选择需要下载的商品！");
                return false;
            }
        	$('#wait').css('display','');
        	$('#wait1').css('display','none');
            var url = $(this).attr("data-uri");
            var field = $(this).attr('data-field');
            $.ajax({
                url:url,
                cache:false,
                dateType:'json',
                type:'GET',
                data:{item_ids:item_ids,is_down:is_down,shop_source:shop_source},
                error:function(){
                },
                success:function(msgObj){
                    if(msgObj.status == '1'){
                    	showAlert(true,msgObj.info.info);
                    	
                        $.each(item_id,function(index,value){
                            $("#list_"+value).css('background','#ececec');
                        });
                    	$('#wait').css('display','none');
                    	$('#wait1').css('display','');
                    }else{
                    	showAlert(false,msgObj.info);
                    	$('#wait').css('display','none');
                    	$('#wait1').css('display','');
                    }
                }
            });
        });
       
       //根据搜索条件下载所有
        $("#downAll").live("click",function(){
   			var shop_source = $("#thd_source_shop").val();
   			if(shop_source == '0'){
        		showAlert(false,'请先选择店铺');
        		return false;
   			}
            var page_size = 5;
            var page_no = 0;
            var page_num = 0
            var total_category = 0;
            var succRows	= 0;
            var errRows		= 0;
            var errMsg = '';
            var item_count = "<?php echo ($ary_data["item_count"]); ?>";
            var shop_source = shop_source;
            var item_status = $("#item_status").val();
            var items_name = $("#items_name").val();
            var update_endtime = $("#update_endtime").val();
            var update_starttime = $("#update_starttime").val();
            $('#tip_div').html('');
            var url = $(this).attr("data-uri");
            $.ajax({
                url:url,
                cache:false,
                dataType:'TEXT',
                data:{item_count:item_count,shop_source:shop_source,item_status:item_status,items_name:items_name,update_endtime:update_endtime,update_starttime:update_starttime},
                success:function(msgObj){
                    var total = parseInt(msgObj);
                    total_category = total;
    				page_num = Math.ceil(total/page_size);
                    $("#tip_div").dialog({
                        width:450,
                        height:240,
                        modal:true,
                        title:'同步淘宝商品 [ 共有 <span style="font-weight:bold; color:#F00;">' + total + '</span> 条商品记录]',
                        buttons:{
                            '关闭':function(){
                                $(this).dialog("close");
                                location.reload();
                            },
                            '下载中断,继续下载':function(){
                            	page_no--;
                            	saveAll();
                            }
                        }
                    });
                    page_no = 0;
                    saveAll();
                }
            }); 

            function saveAll(){
            	var post_data = $('#searchForm').serialize();
                page_no++;
                if(page_no <= page_num){
	                var w = Math.ceil((page_no / page_num) * 400);
	                var p = Math.ceil((page_no / page_num) * 100);
	                var innerHtmls = '<p align="center"><img src="__PUBLIC__/Admin/images/ajaxloading.gif"/>';
	                innerHtmls += '<span>正在同步前' + parseInt(page_no*page_size) + '条数据，共' + total_category + '条，请稍后......'+p+'%</span></p>';
	                innerHtmls += '<p><div style="min-width:400px; width:auto; min-height:8px; height:auto; border:1px solid silver; padding:2px; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;"><div id="loading" style="height:8px; background-color:green; border-radius: 2px; -moz-border-radius: 2px; -webkit-border-radius: 2px;"></div></div></p>';
	                $('#tip_div').html(innerHtmls);
	                $("#loading").css("width",w+'px');
	                post_data +='&page_size='+page_size;
	                post_data +='&page_no='+page_no;
	                //是否同步到本地数据
	            	var is_down = 0;
	            	if($("#downToFx").attr("checked")==true || $("#downToFx").attr("checked") == 'checked'){
	       				is_down = 1;
	       			};
	       			post_data +='&is_down='+is_down;
	                var url = '<?php echo U("Admin/Distirbution/downAllShopGoods");?>';
	                $.post(url,post_data,function(msgObj){
	                	succRows = parseInt(succRows)+parseInt(msgObj.succRows);
	                    errRows	= parseInt(errRows)+parseInt(msgObj.errRows);
	                    errMsg = errMsg+msgObj.errMsg;
	                    if(errMsg == '' || errMsg == 'undefined'){
	                    	errMsg = '';
	                    }
	                    if(page_no == page_num){
	                        var after_message = '<b>全部商品同步完成，同步成功<span style="color:#f00;">' + succRows + '</span>条数据！</b>'+
	                        '<b>同步失败<span style="color:red;">' + errRows + '</span>条数据！</b>'+
	                        '<b>同步失败的商品数据:<span style="color:red;">' + errMsg + '</span></b>';
	                        $('#tip_div').html(after_message);
	                    }
	                    saveAll();
	                },'json');
                }else{
    	            page_no = 0;
    	            succRows = 0;
    	            errRows	= 0;
               }
            }
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