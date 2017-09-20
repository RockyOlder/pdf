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
    <div id="good_dialog" style="display:none">
    </div>
</div>
<p class="tabListP" id="tabs">
    <span id="tabListP1" <?php if($filter["tabs"] == 'website'): ?>class="onHover"<?php endif; ?>><a href='<?php echo U("Admin/Products/pageList","tabs=website");?>'>待确认</a></span>
    <span id="tabListP2" <?php if($filter["tabs"] == 'shelves'): ?>class="onHover"<?php endif; ?> ><a href='<?php echo U("Admin/Products/pageList","tabs=shelves");?>'>进行中</a></span>
    <span id="tabListP4" <?php if($filter["tabs"] == 'recycle'): ?>class="onHover"<?php endif; ?> ><a href='<?php echo U("Admin/Products/pageList","tabs=recycle");?>'>已支付</a></span>
    <span id="tabListP5" <?php if($filter["tabs"] == 'new'): ?>class="onHover"<?php endif; ?> ><a href='<?php echo U("Admin/Products/pageList","tabs=new");?>'>已关闭</a></span>
</p>
<div id="content">
    <div class="rightInner" id="con_tabListP_1"><!--rightInner  start-->
        <table width="100%" class="tbList">
            <thead>
                <tr class="title" style="background-image:none;">
                    <th colspan="99">
            <p class="conOneP" style="float: left;padding-left:0px;">
				操作：
                <a href="<?php echo U('Admin/Goods/goodsAdd');?>" class="btnG ico_add">添加商品</a>
                <a href="<?php echo U('Admin/Goods/batchGoodsAdd');?>" class="btnG ico_add">批量添加商品</a>
                    <a href="javascript:void(0);" onclick="return isBatGoods(this);" data-uri='<?php echo U("Admin/Products/doGoodsisDel");?>' class="btnG ico_del">批量删除</a>

            </p>
            <p class="conOneP" style="float: left;">
				<form method="get" action='<?php echo U("Admin/Products/pageList","tabs=$filter[tabs]");?>' style="float: none;">
                    商品搜索：
					<select class="small" style="width: 120px;" onchange="changeGoodsGroup(this);" name="gpid">
                        <option <?php if($filter['gpid'] == ''): ?>selected="selected"<?php endif; ?> value="0">请选择分组信息</option>
                        <?php if(is_array($goodsgroups)): $i = 0; $__LIST__ = $goodsgroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gg): $mod = ($i % 2 );++$i;?><option <?php if($filter['gpid'] == $gg['gg_id']): ?>selected="selected"<?php endif; ?> value="<?php echo ($gg["gg_id"]); ?>" ><?php echo ($gg["gg_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <select name="field" class="small" style="width: 80px;">
						<option value="g_sn" <?php if($filter["field"] == 'g_sn'): endif; ?>>商品编码</option>
						<option value="g_name" <?php if($filter["field"] == 'g_name'): ?>selected="selected"<?php endif; ?>>商品名称</option>
                    </select>
                    <input type="hidden" value="easy" name="search" />
                    <input type="text" name="val" class="large" value="<?php echo ($filter["val"]); ?>" style="width: 145px;">
                    <input type="submit" value="搜 索" class="btnHeader"/>
                </form>
            </p>
            </th>
            </tr>			
  
            <tr>
                <th><input type="checkbox" class="checkAll" /></th>
                <th style="width:148px">操作</th>
				<th>新品</th>
                <th>热品</th>
                <th>销量</th>
                <th>商品编号</th>
                <th style="text-align: left;width:200px;">商品名称</th>
                <th>换购积分</th>
                <th>销售价</th>
                <th>总库存</th>
                <th>所属分组</th>
                <th>所属分类</th>
                <th>更新时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$datas): $mod = ($i % 2 );++$i;?><tr id="gid_<?php echo ($datas["g_id"]); ?>">
                    <td><input type="checkbox" class="checkSon" name="gid[]" value="<?php echo ($datas["g_id"]); ?>" g_sn="<?php echo ($datas["g_sn"]); ?>" /></td>
                    <td>
						<a class="blue" href="<?php echo U('Home/Products/detail');?>/gid/<?php echo ($datas[g_id]); ?>" title="预览" target="_blank" >[预览]</a>
                    <?php if($filter["tabs"] == 'recycle'): ?><a class="blue isDel delete" href="javascript:void(0);" title="删除商品" g_id="<?php echo ($datas["g_id"]); ?>" data-uri='<?php echo U("Admin/Products/doGoodsisDel");?>' data-acttype="ajax"></a>
                    <?php else: ?>
                        <a class="blue isDel delete" href="javascript:void(0);" title="进入回收站" g_id="<?php echo ($datas["g_id"]); ?>" data-uri='<?php echo U("Admin/Products/doGoodsisRecycle");?>' data-acttype="ajax"></a><?php endif; ?>
                        <a class="blue edit" href='<?php echo U("Admin/Goods/goodsEdit",array('id'=>$datas[g_id],'tabs'=>$filter['tabs']));?>' title="编辑此商品" ></a>
                    <?php if($filter["inventory_stock"] == 1): ?><a class="blue" href='<?php echo U("Admin/Inventory/pageList","id=$datas[g_id]");?>' title="分销商库存分配" >库存分配</a><?php endif; ?>
                        <a class="blue setPoint" href="javascript:void(0);" g_id="<?php echo ($datas["g_id"]); ?>" data-uri='<?php echo U("Admin/Products/setGoodPoint");?>' data-acttype="ajax">积分设置</a>
                        <div id="children_<?php echo ($datas["g_id"]); ?>"  style="display:none" title="积分设置"></div>
                    <?php if($datas["g_on_sale"] == '1'): ?><a href="javascript:void(0);" title="点击将商品下架">
                            <font  id="gsn_<?php echo ($datas["g_id"]); ?>" spdm="<?php echo ($datas["g_sn"]); ?>" g_id="<?php echo ($datas["g_id"]); ?>" val="<?php echo ($datas["g_on_sale"]); ?>"  data-uri='<?php echo U("Admin/Products/doGoodsOnSale");?>' data-acttype="ajax" class="doGoodsOnSale">下架</font>
                        </a>
                        <?php else: ?>
                        <a href="javascript:void(0);" title="点击将商品上架">
                            <font  color="blue" id="gsn_<?php echo ($datas["g_sn"]); ?>" spdm="<?php echo ($datas["g_sn"]); ?>"  g_id="<?php echo ($datas["g_id"]); ?>" val="<?php echo ($datas["g_on_sale"]); ?>" data-uri='<?php echo U("Admin/Products/doGoodsOnSale");?>' data-acttype="ajax" class="doGoodsOnSale">上架</font>
                        </a><?php endif; ?>
                    <a href="javascript:void(0);" class="batchSetPrice btnA" g_id="<?php echo ($datas["g_id"]); ?>">批量设置价格</a>
                    </td>
                    <td>
                    <?php if($datas["g_new"] == 1): ?><img src="__PUBLIC__/Admin/images/span-true.png" is_new="1" onclick="ajaxSetNew(<?php echo ($datas["g_id"]); ?>,this);" />
                        <?php else: ?>
                        <img src="__PUBLIC__/Admin/images/span-false.png" is_new="0" onclick="ajaxSetNew(<?php echo ($datas["g_id"]); ?>,this);" /><?php endif; ?>
                    </td>
                    <td>
                    <?php if($datas["g_hot"] == 1): ?><img src="__PUBLIC__/Admin/images/span-true.png" is_hot="1" onclick="ajaxSetHot(<?php echo ($datas["g_id"]); ?>,this);" />
                        <?php else: ?>
                        <img src="__PUBLIC__/Admin/images/span-false.png" is_hot="0" onclick="ajaxSetHot(<?php echo ($datas["g_id"]); ?>,this);" /><?php endif; ?>
                    </td>
                    <td>
                        <input type="text" name="g_salenum" value="<?php echo ($datas["g_salenum"]); ?>" class="input40 ajax-set-goods-salenum" int_goods_id="<?php echo ($datas["g_id"]); ?>" g_before_modify_salenum="<?php echo ($datas["g_salenum"]); ?>" />
                    </td>
                    <td style="text-align:left;"><?php echo ($datas["g_sn"]); ?></td>
                    <td  style="text-align: left;"><span style="width:200px;text-align:left; overflow: hidden;text-overflow: ellipsis;" class="blue"><a href='<?php echo U("Admin/Products/pageDetail","gid=$datas[g_id]");?>' title="<?php echo ($datas["g_name"]); ?>" style="overflow: hidden;text-overflow: ellipsis;"><?php echo ($datas["g_name"]); ?></a></span></td>
                    <td id="point_<?php echo ($datas["g_id"]); ?>"><?php if($datas["is_exchange"] == 1): echo ($datas["point"]); else: ?>不参与<?php endif; ?></td>
                    <td>￥<?php echo (sprintf('%.3f',$datas["g_price"])); ?></td>
                    <td><?php echo ($datas["total_stock"]); ?></td>
                    <td><?php echo ($datas["group_name"]); ?></td>
                    <td><?php echo ($datas["cat_name"]); ?></td>
                    <td><?php echo ($datas["g_update_time"]); ?></td>
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
<!--批量设置销售价格-->
<div id="goodsSetPriceBatch" style="display: none;text-align:center;" title="批量设置销售价">
    <form id="batchSetPriceForm">
    <input type="hidden" name="setPriceGid" value="" id="setPriceGid" class="small" />
    <table style="border:1px solid gray;margin-left:auto;margin-right:auto;">
    	<thead style="border:1px solid gray;text-align:center;">
    		<tr style="border:1px solid gray;text-align:center;">
    			<td style="border:1px solid gray;" width="150px;">销售价</td>
				<td style="border:1px solid gray;" width="150px;">成本价</td>
				<td style="border:1px solid gray;" width="150px;">市场价</td>
				<td style="border:1px solid gray;" width="150px;">重量</td>
				<td style="border:1px solid gray;" width="150px;">最少起拍数</td>
    		</tr>
    	</thead>
    	<tbody>
    		<tr style="border:1px solid gray;">
    			<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_sale_price" value="" id="pdt_set_sale_price" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_cost_price" value="" id="pdt_set_cost_price" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_market_price" value="" id="pdt_set_market_price" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_weight" value="" id="pdt_set_weight" class="small" />
				</td>
				<td style="border:1px solid gray;">
    				<input type="text" name="pdt_set_least" value="" id="pdt_set_least" class="small" />
				</td>
    		</tr>
    	</tbody>
    </table>
    </form>
</div>
<div id="allerp" name="" style="display:none" title="商品销量同步中"></div>
<div id="fastGroup" style="display:none"></div>
<script type="text/javascript">
    function getCheckedProducts(clickObj){
        var string_href = "<?php echo U('Admin/Stock/pageAdd');?>";
        var goods_ids = "";
        $(".checkSon").each(function(){
            if(this.checked){
                goods_ids += $(this).val() + '_';
            }
        });
        location.href = string_href + '?g_id=' + goods_ids;
    }
    function doGoodsOnSale(url,spdm,val,g_id){
        $.ajax({
            url:url,
            cache:false,
            dataType:"json",
            data: {spdm:spdm,val:val},
            type:"POST",
            beforeSend:function(){
                $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
            },
            error:function(){
                $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
            },
            success:function(msgObj){
                $("#J_ajax_loading").hide();
                if(msgObj.status == '1'){
                    $("#gid_"+g_id).remove();
                }else{
                    $("#J_ajax_loading").addClass('ajax_error').html(msgObj.info).show().fadeOut(2000);
                }
            }
        });
    }
    function doGoodsOnSaleBat(url,gids,val,field){
        $.ajax({
            url:url,
            cache:false,
            dateType:'json',
            type:'POST',
            data:{gid:gids,val:val,field:field},
            beforeSend:function(){
                $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
            },
            error:function(){
                $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
            },
            success:function(msgObj){
                $("#J_ajax_loading").hide();
                if(msgObj.status == '1'){
                    $.each(gid,function(index,value){
                        $("#gid_"+value).remove();
                    });
                    $("#J_ajax_loading").addClass('ajax_success').html(msgObj.info).show().fadeOut(5000);
                }else{
                    $("#J_ajax_loading").addClass('ajax_error').html(msgObj.info).show().fadeOut(5000);
                }
            }
        });
    }

    $(document).ready(function(){
        //根据货号上下架
        $(".doGoodsOnSale").click(function(){
            var url = $(this).attr("data-uri");
            var val = $(this).attr("val");
            var spdm = $(this).attr("spdm");
            var g_id = $(this).attr("g_id");
            if(spdm == ''){
                $("#J_ajax_loading").addClass('ajax_error').html("商品编码不能为空！").show().fadeOut(5000);
                return false;
            }
			if(val == 2){
                $.ajax({
                    url:'<?php echo U("Admin/Products/ajaxCheckStock");?>',
                    cache:false,
                    dataType:"json",
                    data: {spdm:spdm,g_id:g_id},
                    type:"POST",
                    beforeSend:function(){
                        $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
                    },
                    error:function(){
                        $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
                    },
                    success:function(msgObj){
                        if(msgObj['status'] == 3 && confirm("该商品库存为0,确定要上架该商品")){
                            doGoodsOnSale(url,spdm,val,g_id);
                        }else if(msgObj['status'] == 2){
                            doGoodsOnSale(url,spdm,val,g_id);
                        }else if(msgObj['status'] == 1){
                            $("#J_ajax_loading").addClass('ajax_error').html(msgObj.info).show().fadeOut(2000);
                        }
                    }
                });
            }else{
                doGoodsOnSale(url,spdm,val,g_id);
            }
        });
		//ajax方式修改商品销量
		$(".ajax-set-goods-salenum").change(function(){
			if(isNaN($(this).val())){
				//如果修改后的不是数字，则不予替换
				$(this).val($(this).attr("g_before_modify_salenum"));
				return false;
			}
			var obj_input_goods_salenum = $(this);
			var int_g_salenum = $(this).val();
			var int_goods_id = $(this).attr("int_goods_id");
			$.ajax({
                url:"<?php echo u('Admin/Products/setItemSaleNumbers');?>",
                cache:false,
                dataType:"json",
                data: {'int_goods_id':int_goods_id,int_sale_num:int_g_salenum},
                type:"POST",
                success:function(jsonObj){
					if(true === jsonObj.status){
						obj_input_goods_salenum.attr({"g_before_modify_salenum":int_g_salenum});
					}
                }
            });
		});
		
		//批量加入分组
		$("#removeGroupGoodsIn").change(function(){
			if($(this).val() > 0){
				var url = '<?php echo U("Admin/GoodsGroup/addGoodsToGroup");?>';
				var goods_ids = "";
				$(".checkSon").each(function(){
					if(this.checked){
						goods_ids += $(this).val() + ',';
					}
				});
				if("" == goods_ids){
					alert("请选择您要加入到此分组的商品。");
					$(this).val(0);
					return false;
				}
				
				//将要移入的数据post到服务器端，执行移入操作
				$.post(url,{g_ids:goods_ids,gg_id:$(this).val()},function(dataObj){
					if(dataObj.status === true){
						alert("批量加入分组成功。");
						$(this).val(0);
					}else{
						alert("批量加入分组失败。");
						$(this).val(0);
					}
				},'json');
			}
			$(this).val(0);
		});
		//批量移出分组
		$("#removeGroupGoodsOut").change(function(){
			if($(this).val() > 0){
				var url = '<?php echo U("Admin/GoodsGroup/removeGoodsToGroup");?>';
				var goods_ids = "";
				$(".checkSon").each(function(){
					if(this.checked){
						goods_ids += $(this).val() + ',';
					}
				});
				if("" == goods_ids){
					alert("请选择您要从此分组中移出的商品。");
					$(this).val(0);
					return false;
				}
				
				//将要移出的数据post到服务器端，执行移出操作
				$.post(url,{g_ids:goods_ids,gg_id:$(this).val()},function(dataObj){
					if(dataObj.status === true){
						alert("批量移出分组成功。");
						$(this).val(0);
					}else{
						alert("批量移出分组失败。");
						$(this).val(0);
					}
				},'json');
			}
			$(this).val(0);
		});
        
        //批量加入分类
		$("#removeGoodsCategoryIn").change(function(){
			if($(this).val() > 0){
				var url = '<?php echo U("Admin/GoodsCategory/addGoodsToCategory");?>';
				var goods_ids = "";
				$(".checkSon").each(function(){
					if(this.checked){
						goods_ids += $(this).val() + ',';
					}
				});
				if("" == goods_ids){
					alert("请选择您要加入到此分类的商品。");
					$(this).val(0);
					return false;
				}
				
				//将要移入的数据post到服务器端，执行移入操作
				$.post(url,{g_ids:goods_ids,gc_id:$(this).val()},function(dataObj){
					if(dataObj.status === true){
						alert("批量加入分类成功。");
						$(this).val(0);
					}else{
						alert("批量加入分类失败。");
						$(this).val(0);
					}
				},'json');
			}
			$(this).val(0);
		});
		//批量移出分类
		$("#removeGoodsCategoryOut").change(function(){
			if($(this).val() > 0){
				var url = '<?php echo U("Admin/GoodsCategory/removeGoodsToCategory");?>';
				var goods_ids = "";
				$(".checkSon").each(function(){
					if(this.checked){
						goods_ids += $(this).val() + ',';
					}
				});
				if("" == goods_ids){
					alert("请选择您要从此分类中移出的商品。");
					$(this).val(0);
					return false;
				}
				
				//将要移出的数据post到服务器端，执行移出操作
				$.post(url,{g_ids:goods_ids,gc_id:$(this).val()},function(dataObj){
					if(dataObj.status === true){
						alert("批量移出分类成功。");
						$(this).val(0);
					}else{
						alert("批量移出分类失败。");
						$(this).val(0);
					}
				},'json');
			}
			$(this).val(0);
		});
    });
    
    //删除商品
    $(".isDel").click(function(){
        var url = $(this).attr("data-uri");
        var gid = $(this).attr("g_id");
        var title = $(this).attr('title');
        if(gid == ''){
            $("#J_ajax_loading").addClass('ajax_error').html("商品编码不能为空！").show().fadeOut(5000);
            return false;
        }
        if(confirm("确定要"+title+"？")){
            $.ajax({
                url:url,
                cache:false,
                dataType:"json",
                data: {gid:gid},
                type:"POST",
                beforeSend:function(){
                    $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
                },
                error:function(){
                    $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
                },
                success:function(msgObj){
                    $("#J_ajax_loading").hide();
                    if(msgObj.status == '1'){
                        $("#gid_"+gid).remove();
                        $("#J_ajax_loading").addClass('ajax_success').html(msgObj.info).show().fadeOut(5000);
                    }else{
                        $("#J_ajax_loading").addClass('ajax_error').html(msgObj.info).show().fadeOut(5000);
                    }
                }
            });
            
        }
        
    });
    
    //设置商品积分
    $(".setPoint").click(function(){
        
        var _this = $(this);
        var g_id = _this.attr('g_id');
        var url = _this.attr('data-uri');
        $.post(url,{'g_id':g_id},function(html){
            $('#children_'+"<?php echo ($datas["g_id"]); ?>").dialog({
                height:265,
                width:540,
                resizable:false,
                autoOpen: false,
                modal: true,
                buttons: { 
                    '确定':function(){
                                    
                        addPoint(g_id,$( this ));
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                        $('#children_'+"<?php echo ($datas["g_id"]); ?>").hide();
                    }
                }
            });
            $('#children_'+"<?php echo ($datas["g_id"]); ?>").dialog('open');
            $('#children_'+"<?php echo ($datas["g_id"]); ?>").html(html);
        },'html');
        
    });
    
    
    //添加积分
    function addPoint(g_id,obj){
        var url = "<?php echo U('Admin/Products/GoodPointUpdate');?>";
        var point =$('#point').val();
        var gpoint =$('#gifts_point').val();
        var is_exchange = $("input:radio:checked[name=is_exchange]").val();
        $.post(url, {'g_id':g_id,'point':point,'gifts_point':gpoint,'is_exchange':is_exchange}, function(msgObj){
            if(msgObj.status == '1'){
                $('#point_'+g_id).html(point);
                
                obj.dialog( "close" );
                $('#children_'+g_id).hide();
                return false;
            }else{
                showAlert(false,'出错了',msgObj.info);
                return false;
            }
                
        }, 'json');
    }
	
    function ajaxSetNew(int_g_id,clickObj){
        var is_new = 1;
        if($(clickObj).attr("is_new") == 1){
            is_new = 0;
        }
        var msg = '取消新品设置 ';
        if(is_new == 1){
            msg = '标记为新品';
        }
        if(confirm("确定要将此商品" + msg + '吗？')){
            $.post(
            '<?php echo U("Admin/Goods/ajaxSetGoodsFlag");?>',
            {'g_id':int_g_id,'dotype':'new','value':is_new},
            function(jsonObj){
                if(jsonObj.status === true){
                    var image_path = '__PUBLIC__/Admin/images/span-false.png';
                    if(1 == is_new){
                        image_path = '__PUBLIC__/Admin/images/span-true.png';
                    }
                    $(clickObj).attr({src:image_path,is_new:is_new}).hide().show(2000);
                }
            },
            'json'
        );
        }
    }
	
    function ajaxSetHot(int_g_id,clickObj){
        var is_hot = 1;
        if($(clickObj).attr("is_hot") == 1){
            is_hot = 0;
        }
        var msg = '取消热卖设置 ';
        if(is_hot == 1){
            msg = '标记为热卖商品';
        }
        if(confirm("确定要将此商品" + msg + '吗？')){
            $.post(
            '<?php echo U("Admin/Goods/ajaxSetGoodsFlag");?>',
            {'g_id':int_g_id,'dotype':'hot','value':is_hot},
            function(jsonObj){
                if(jsonObj.status === true){
                    var image_path = '__PUBLIC__/Admin/images/span-false.png';
                    if(1 == is_hot){
                        image_path = '__PUBLIC__/Admin/images/span-true.png';
                    }
                    $(clickObj).attr({src:image_path,is_hot:is_hot}).hide().show(2000);
                }
            },
            'json'
        );
        }
    }
    
    function changeGoodsGroup(obj){
        var gpid = $(obj).val();
        if(gpid == 0){
            return false;
        }
        var field = $("select[name='field']").val();
        var val = $("input[name='val']").val();
        var url = '/Admin/Products/pageList/tabs/website';
        if(val){
            url += "?field="+field+"&search=easy&val="+val+"&gpid="+gpid;
        }else{
            url += "?search=easy&gpid="+gpid;
        }
        window.location.href = url;
    }
    
    /**
     * 执行批量操作
     * author Joe
     */
    function isBatGoods(obj){
        var val = $(obj).attr("val");
        var url = $(obj).attr("data-uri");
        var field = $(obj).attr("field");
        var gids = new Array();
        var spdm = new Array();
        if($(obj).hasClass('ico_del')){
            if(!confirm("确定要删除吗？")){
                return false;
            }
        }
        $(".tbList input:checked[class='checkSon']").each(function(){
            gids.push(this.value);
            spdm.push($(this).attr("g_sn"));
        });
        spdms = spdm;
        gid = gids;
        gids = gids.join(",");
        if(gids == ''){
            $("#J_ajax_loading").addClass('ajax_error').html("请选择需要操作的商品！").show().fadeOut(5000);
            return false;
        }
        $.ajax({
            url:'<?php echo U("Admin/Products/ajaxBatCheckStock");?>',
            cache:false,
            dateType:'json',
            type:'POST',
            data:{gid:gids,spdms:spdms.join(',')},
            beforeSend:function(){
                $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
            },
            error:function(){
                $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
            },
            success:function(msgObj){
				if(val==1){
					var msg = '确定要批量上架商品';
				}else{
					var msg = '确定要批量下架商品';
				}
				
                if(msgObj.status == 3 && confirm( msg ) ){
                    doGoodsOnSaleBat(url,gids,val,field);
                }else if(msgObj.status == 2 && confirm( msg ) ){
                    doGoodsOnSaleBat(url,gids,val,field);
                }else if(msgObj.status == 1 && confirm( msg ) ){
                    $("#J_ajax_loading").addClass('ajax_error').html(msgObj.info).show().fadeOut(2000);
                }
            }
        });
        return false;
    }
    
    /**
     * 快速归组操作
     *
     */
    function fastBelongToGroup(){
        $.post('/Admin/GoodsGroup/ajaxOpenFastGoodGroups/',{},function(htmlMsg){
            $("#fastGroup").html(htmlMsg);
            $("#fastGroup").dialog({
                title:'快速归组',
                width:'auto',
				height:'500',
                resizable:true,
                autoOpen: false,
                modal: true,
                buttons: { 
                    '确定':function(){
                        addGroupGoods();
                        
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
            $("#fastGroup").dialog('open');
        },'html');
        
    }
	
	/**
     * 快速归组操作
     * wangguibin@guanyisoft.com
	 * 2014-08-11 21:41:00
     */
    function fastUpdateTitle(){
        $.post('/Admin/GoodsGroup/ajaxOpenFastGoods/',{},function(htmlMsg){
            $("#fastGroup").html(htmlMsg);
            $("#fastGroup").dialog({
                title:'快速归组',
                width:'auto',
				height:'500',
                resizable:true,
                autoOpen: false,
                modal: true,
                buttons: { 
                    '确定':function(){
                        updateGoodsTitle();
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
            $("#fastGroup").dialog('open');
        },'html');
        
    }
	/**
	 *批量更改商品标题
     *wangguibin@guanyisoft.com 
	 *2014-08-12
	 */	 
	
   function updateGoodsTitle(){
        var data = new Object();
        var gg_type = $("#gg_type").val();
		var new_gg_name = $("#new_gg_name").val();
        if(new_gg_name == ''){
			showAlert(false,'请输入要添加的前缀或后缀');return false;
        }else{
			data['item_title'] = new_gg_name;
		}
		if(gg_type == 0){
			showAlert(false,'请选择更改商品标题类型');return false;
		}else{
			data['item_type'] = gg_type;
		}
		//获取类目
		var cat_length = $("input[type=checkbox][name=shopCat]:checked").length;
		if(cat_length>0){
			data['cat_ids'] = {};
			var i = 0;
			$("input[type=checkbox][name=shopCat]:checked").each(function(){
				data['cat_ids'][i] = $(this).val();
				i++;
			});		
		}
		//获取品牌
		var brand_length = $("input[type=checkbox][name=shopBrand]:checked").length;
		if(brand_length>0){
			data['brand_ids'] = {};
			var y=0;
			$("input[type=checkbox][name=shopBrand]:checked").each(function(){
				data['brand_ids'][y] = $(this).val();
				y++;
			});		
		}
		
        if($("#g_sn").val() == '请输入要修改标题的商品编号，多条商品以换行分隔。。。。'){
			if(brand_length==0 && cat_length==0){
				showAlert(false,'请输入商品货号，至少输入一条');return false;
			}
        }
        var g_sn = $("#g_sn").val().split('\n');
        data['g_sn'] = {};
        for (x in g_sn){
            if(g_sn[x] != ''){
				if(g_sn[x] != '请输入要修改标题的商品编号，多条商品以换行分隔。。。。'){
					data['g_sn'][x] = g_sn[x];
				}
            }
        }
        $.post('/Admin/GoodsGroup/doAddFastGoods/',data,function(dataMsg){
            showAlert(dataMsg.status,dataMsg.msg);
            if(dataMsg.status){
                $("#fastGroup").dialog( "close" );
            }
        },'json');
        
    }
    
    function addGroupGoods(){
        var data = new Object();
        var new_gg_name = $("#new_gg_name").val();
        if(new_gg_name != ''){
            data['skip'] = 0;
            data['new_gg_name'] = new_gg_name;
        }else{
            data['skip'] = 1;
            if($("#gg_id").val() == 0){
                showAlert(false,'请选择商品分组！');return false;
            }
            data['gg_id'] = $("#gg_id").val();
        }
		//获取类目
		var cat_length = $("input[type=checkbox][name=shopCat]:checked").length;
		if(cat_length>0){
			data['cat_ids'] = {};
			var i = 0;
			$("input[type=checkbox][name=shopCat]:checked").each(function(){
				data['cat_ids'][i] = $(this).val();
				i++;
			});		
		}
		//获取品牌
		var brand_length = $("input[type=checkbox][name=shopBrand]:checked").length;
		if(brand_length>0){
			data['brand_ids'] = {};
			var y=0;
			$("input[type=checkbox][name=shopBrand]:checked").each(function(){
				data['brand_ids'][y] = $(this).val();
				y++;
			});		
		}
		
        if($("#g_sn").val() == '请输入归组的商品编号，多条商品以换行分隔。。。。'){
			if(brand_length==0 && cat_length==0){
				showAlert(false,'请输入商品货号，至少输入一条');return false;
			}
        }
        var g_sn = $("#g_sn").val().split('\n');
        data['g_sn'] = {};
        for (x in g_sn){
            if(g_sn[x] != ''){
				if(g_sn[x] != '请输入归组的商品编号，多条商品以换行分隔。。。。'){
					data['g_sn'][x] = g_sn[x];
				}
            }
        }
        $.post('/Admin/GoodsGroup/doAddFastGroupGoods/',data,function(dataMsg){
            showAlert(dataMsg.status,dataMsg.msg);
            if(dataMsg.status){
                $("#fastGroup").dialog( "close" );
            }
        },'json');
        
    }
    
 var tableWidth=document.getElementById('con_tabListP_1');
 if(tableWidth.parentNode.parentNode.offsetWidth < 1400){
    var demo = tableWidth.parentNode.parentNode.offsetWidth+60;
 }else{
    var demo = tableWidth.parentNode.parentNode.offsetWidth-100;
 }
 
 tableWidth.style.width=demo+'px';
</script>
<script type="text/javascript">
function checkPrice(price){
	if(price.val() != '' && isNaN(price.val())){
		showAlert(false,'请正确填写');return false;
	}
}
$(document).ready(function(){
	// 批量设置销售价格
	$('.batchSetPrice').bind({'click':function(){
        var gid = $(this).attr('g_id');
		$('#setPriceGid').val(gid);
		// 初始化价格
		$('#pdt_set_sale_price').val('');
		$('#pdt_set_cost_price').val('');
		$('#pdt_set_market_price').val('');
		$('#pdt_set_weight').val('');
		$('#pdt_set_least').val('');

		$('#goodsSetPriceBatch').dialog({
			resizable:false,
			autoOpen: false,
			modal: true,
			width: 'auto',
			// position: [220,85],
			buttons: {
				'确认': function() {
					var pdt_set_sale_price   = $('#pdt_set_sale_price');
					var pdt_set_cost_price   = $('#pdt_set_cost_price');
					var pdt_set_market_price = $('#pdt_set_market_price');
					var pdt_set_weight       = $('#pdt_set_weight');
					var pdt_set_least        = $('#pdt_set_least');
					if(false === checkPrice(pdt_set_sale_price)){
						return false;
					}
					if(false === checkPrice(pdt_set_cost_price)){
						return false;
					}
					if(false === checkPrice(pdt_set_market_price)){
						return false;
					}
					if(false === checkPrice(pdt_set_weight)){
						return false;
					}
					if(false === checkPrice(pdt_set_least)){
						return false;
					}
                    var formdata = $("#batchSetPriceForm").serialize();
                    var isSuccess = 0;
                    $.ajax({
                        url:"<?php echo U('Admin/Products/doBatchSetPrice');?>",
                        data:formdata,
                        dataType:"json",
                        type:"post",
                        success:function(msgObj){
                            showAlert(msgObj.status, msgObj.info, '', msgObj.url);
                        }
                    });
				},
				'关闭': function() {
                    $(this).dialog( "close" );
                    return false;
				}
			}
		});
		$('#goodsSetPriceBatch').dialog('open');
	}});
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