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
    <form id="spike_add" enctype="multipart/form-data" name="spike_add" method="post" action="<?php echo U('Admin/Spike/doAdd');?>">
        <table class="tbForm" width="100%" id="wrap">
            <thead>
                <tr class="title">
                    <th colspan="99">新增秒杀活动</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td  colspan="3" style="text-align:left;padding-left:100px;">
                        分类：
                        <select name="search_cats" class="related_goods_form_info medium" >
                            <option value="0"> -请选择- </option>
                            <?php if(is_array($array_category)): $i = 0; $__LIST__ = $array_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat["gc_id"]); ?>"><?php for($j=0;$j<$cat['gc_level'];$j++){echo '--';} echo ($cat["gc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        品牌：
                        <select name="search_brand" class="related_goods_form_info medium">
                            <option value="0"> -请选择- </option>
                            <?php if(is_array($array_brand)): $i = 0; $__LIST__ = $array_brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["gb_id"]); ?>"><?php echo ($vo["gb_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        关键词：
                        <input type="text" name="keywords" class="related_goods_form_info medium" id="search_keywords" value="" />
                        <button type="button" id="related_goods_form_search_info" class="btnA">搜索</button>
                    </td>
                </tr>
                <tr>
                    <td class="first">* 秒杀商品</td>
                    <td>
                        <input type="hidden" value="1" id="good_type"/>
                        <input type="hidden" value="" id="item_price" /> 
                        <select name="g_id" id="g_related_goods_ids_selected_info" onchange="showPic(this);" validate="{ required:true}">
                            <option value="0">请先搜索商品,再次生成选项列表</option>
                        </select>
                    </td>
                    <td class="last">必填，更加商品选择区域限售</td>
                </tr>
                <tr>
                    <td colspan="5" >
                        
<div style="margin-left:75px; width:887px" class='ajax_show_area'><!--rightInner  start-->
    <table width="100%" class="tbNew">
        <tbody>
        <tr id="add_goods_tr">
            <td>
                <table id="raGoodsId" class="tbList" width="100%">
                    <thead>
                    <tr>
                        <!--<th style="text-align:center;">
                            <input type="checkbox" onclick="checkAll()" class="checkAll_tr">
                        </th>-->
                        <th style="text-align:center;">商品名称</th>
                        <th style="text-align:center;">商品编号</th>
                        <th style="text-align:center;">销售价（元）</th>
                       <!-- <th style="text-align:center;">
                            预售价（元）<br/>
                            <span style="font-size: 10px;font-weight: lighter;">本输入框仅用于<span style="color: #AD0132;">批量设置</span>该商品对应的所有的货品金额。默认为0，无实际意义</span>
                        </th>-->
                        <th style="text-align:center;">操作</th>
                    </tr>
                    </thead>
                    <tbody id="getGoodsTr">
                    

<?php if(is_array($rGoods)): $i = 0; $__LIST__ = $rGoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr class="selected_goods_tr_<?php echo ($goods["g_id"]); ?>">
        <td style="text-align:center;"><?php echo ($goods["g_name"]); ?></td>
        <td style="text-align:center;"><span class="blue"><?php echo ($goods["g_sn"]); ?></span></td>
        <td style="text-align:center;"><?php echo ($goods["g_price"]); ?></td>
       <!-- <td style="text-align:center;">
            <input type="text" onblur="shortcut(<?php echo ($goods["g_id"]); ?>)" id="shortcut_goods_<?php echo ($goods["g_id"]); ?>" validate="{ number:true}" name="cfg_discounts[<?php echo ($goods["g_id"]); ?>]" value="<?php echo ($goods["g_price_config"]["cfg_products"]); ?>" class="tiny ">
        </td>-->
        <td style="text-align:center;">
            <!--<a onclick="delGoods($(this),<?php echo ($goods["g_id"]); ?>);" href="javascript:void(0);">删除</a>-->
            <a href="javascript:void(0);" onclick="expansion(<?php echo ($goods["g_id"]); ?>);">展开</a>
            <input type="hidden" name="ra_gid[]" value="<?php echo ($goods["g_id"]); ?>">
        </td> 
    </tr>
    <tr class="selected_goods_tr_<?php echo ($goods["g_id"]); ?>" id="selected_goods_products_tr_<?php echo ($goods["g_id"]); ?>" style="display:none; padding-left:30px;">
        <td></td>
        <td colSpan="6">
            <table class="" style="width:100%">
                <thead>
                    <tr class="tbody_products_<?php echo ($goods["g_id"]); ?>">
                        <th style="text-align:center;">商家编码</th>
                        <th style="text-align:center;">规格</th>
                        <th style="text-align:center;">销售价</th>
                        <!--<th>预售价</th>-->
                        <th style="text-align:center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($goods['products'])): $i = 0; $__LIST__ = $goods['products'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?><tr class="tbody_products_<?php echo ($goods["g_id"]); ?>" style="display:">
                            <td><?php echo ($pro["pdt_sn"]); ?></td>
                            <td><?php echo ($pro["specName"]); ?></td>
                            <td><?php echo ($pro["pdt_sale_price"]); ?></td>
                            <!--<td>
                                <input type="text" name="cfg_products[<?php echo ($goods["g_id"]); ?>][<?php echo ($pro["pdt_id"]); ?>]" value="<?php echo ($pro["g_price_config"]["cfg_products"]); ?>" class="tiny cfg_discounts shortcut_pro_<?php echo ($goods["g_id"]); ?>" data-original="<?php echo ($pro["pdt_sale_price"]); ?>"/>
                                <input type="hidden" name="cfg_products[<?php echo ($goods["g_id"]); ?>][<?php echo ($pro["pdt_id"]); ?>]" value="<?php echo ($pro["g_price_config"]["cfg_products"]); ?>" class="tiny cfg_discounts shortcut_pro_<?php echo ($goods["g_id"]); ?>" data-original="<?php echo ($pro["pdt_sale_price"]); ?>"/>
                            </td>-->
                            <td>
                                <!--<a onclick="delGoods($(this));" href="javascript:void(0);">删除</a>-->
                                <a href="javascript:void(0);" onclick="expansion(<?php echo ($goods["g_id"]); ?>)">收起</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
<script type="text/javascript">
    /*
     * 设置价格
     */
    function shortcut(gid){
        $(".shortcut_pro_"+gid).val($("#shortcut_goods_"+gid).val());
    }
    /*批量设置商品折扣*/
    $(function(){
        $('#cfg_discounts_setAll').click(function(){
            //$("#cfg_discounts_system_all").show();
            var discount = parseFloat($('#cfg_discounts_all').val());
            if(confirm('你确定将所有已选择商品设置为'+(discount*10)+'折优惠吗？')){
                $('.cfg_discounts').each(function(){
                    var data_original = parseFloat($(this).attr('data-original'));
                    $(this).val((data_original*discount).toFixed(2));
                });
            }

            //$('.cfg_discounts').val($('#cfg_discounts_all').val());
        });

    });
     /*批量删除*/
    function batchDelGoods(){
        $("input[name='ra_gid[]']").each(function(){
            if($(this).prop("checked")== true){
               
                $(this).parent('td').parent('tr').remove();
                $("#selected_goods_products_tr_"+$(this).attr('g_id')).remove();
            }
        })
    }
    /*
     * 展开操作
     */
    function expansion(gid){
        var display_val = $("#selected_goods_products_tr_"+gid).css('display');
        if(display_val == 'none'){
            //$(".tbody_products_"+gid).css({'display':''});
            $("#selected_goods_products_tr_"+gid).show();
        }else {
            $("#selected_goods_products_tr_"+gid).hide();
            //$(".tbody_products_"+gid).css({'display':'none'});
        }
    }
     /*删除商品*/
    function delGoods(obj,gid){
        obj.parent('td').parent('tr').remove();
        $(".tbody_products_"+gid).remove();
        //console.log("selected_goods_products_tr_"+gid);
        $("#selected_goods_products_tr_"+gid).remove();
    }
    function checkAll(){
        if($('.checkAll_tr').attr('checked')=='checked'){
            $('.checkSon_tr').attr('checked','checked');
        }else{
            $('.checkSon_tr').removeAttr('checked');
        }
    }
</script>

                    </tbody>
                </table>
            </td>
        </tr>
        <!--<tr>
            <td>
                <table style="width:100%">
                    <tr>
                        <td width="90px">批量设置折扣：</td>
                        <td id="discounts_all" style="display:block">
                            <input type="text" class="small" id="cfg_discounts_all" name="cfg_discounts_all" value="<?php echo ($config['cfg_discount_all']); ?>" validate="{ number:true}" >
                            <span style="font-size: 10px; ">请输入折扣，0.80表示统一设置为8折</span>
                            <a href="javascript:void(0);" id="cfg_discounts_setAll" >批量设置</a>&nbsp;&nbsp;

                            <input type="text" class="small" style="display:none" id="cfg_discounts_system_all" name="cfg_discounts_system_all" validate="{ required:true,number:true,min:0.01}" value="<?php echo ($config['cfg_discounts_system_all']); ?>"/>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>-->
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var types=$("input:radio[name='cfg_goods_area']:checked").val();
        if(types == -1){
            //如果是全部商品则隐藏商品
            $("#add_goods_tr").hide();
            $('#add_goods').hide();
            $("#raGoodsId tbody").remove();
            $("#discounts_system_all").css("display","block");  
        }
         
    });

    /*
     * 设置价格
     */
    function shortcut(gid){
        $(".shortcut_pro_"+gid).val($("#shortcut_goods_"+gid).val());
    }
    /*批量设置商品折扣*/
    $(function(){
        $('#cfg_discounts_setAll').click(function(){
            //$("#cfg_discounts_system_all").show();
            var discount = parseFloat($('#cfg_discounts_all').val());
            if(confirm('你确定将所有已选择商品设置为'+(discount*10)+'折优惠吗？')){
                $('.cfg_discounts').each(function(){
                    var data_original = parseFloat($(this).attr('data-original'));
                    $(this).val((data_original*discount).toFixed(2));
                });
            }

            //$('.cfg_discounts').val($('#cfg_discounts_all').val());
        });
        
    });
    //显示商品选择框
    function add_pmn_goods() {
		$("#gifts").hide();
		$("#g_gifts").val("0");
		if($("#goodsSelect").attr('g_gifts') != '0'){
			$("#goodsSelecterList").html("");
		}
		
		//$("#goodsSelecterList").html("");
        $('#goodsSelect').dialog('open');
    }
</script>

                    </td>
                </tr>
                <tr>
                    <td class="first">* 秒杀标题</td>
                    <td>
                        <textarea  name="sp_title" id="sp_title"  maxlength="250" style="width:300px;height:100px;text-align:left;vertical-align:top;" validate="{ required:true,maxlength:250,remote:'<?php echo U('Admin/Spike/checkName');?>'}"></textarea>
                    </td>
                    <td class="last">限制250个字符</td>
                </tr>
                <tr>
                    <td class="first">* 活动开始时间</td>
                    <td>
                        <input type="text" name="sp_start_time" id="sp_start_time" class="medium timer" validate="{ required:true}"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 活动结束时间</td>
                    <td>
                        <input type="text" name="sp_end_time" id="sp_end_time" class="medium timer" validate="{ required:true}"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">价格设置类型</td>
                    <td>
                        <label><input type="radio" name="sp_tiered_pricing_type" id="sp_tiered_pricing_type_1" value="1"  onclick="changeDiscountType(this);" autocomplete="off" checked/>按减少指定金额计算</label>
                        <label><input type="radio" name="sp_tiered_pricing_type" id="sp_tiered_pricing_type_2" value="2"  onclick="changeDiscountType(this);" autocomplete="off"/>按价格折扣计算</label>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr class="price_discount_init" data-type="1">
                    <td class="first">* 秒杀优惠：</td>
                    <td>
                        减<input type="text" name="sp_price"  value="<?php echo (($info['sp_price'])?($info['sp_price']):0); ?>" class="medium input-text" onblur="checkSpikePrice(this);" />元&nbsp;&nbsp;
                    </td>
                    <td class="last">在普通销售价上减去指定金额作为秒杀价</td>
                </tr>
                <tr class="price_discount_init" data-type="2" style="display: none;">
                    <td class="first">* 秒杀优惠：</td>
                    <td>
                        <input type="text" value="<?php echo ($info['p_price']); ?>" class="medium input-text" onblur="checkSpikePrice(this);"/>折&nbsp;&nbsp;
                    </td>
                    <td class="last">在普通销售价上打指定折扣作为秒杀价 请输入小于等于1的正数，如0.88=8.8折</td>
                </tr>
                <tr style="height:50px;">
                    <td class="first">商品图片</td>
                    <td>
                        <a href="javascript:upImage();" class="btnG ico_upload">上传图片</a>
                        <img width="50px" height="50px" src="" id="show_pic">
                        &nbsp;
                        <input type="hidden" id="sp_pic" name="sp_pic" value=""/>
            </td>
            <td class="last">不上传图片按商品主图,建议您图片大小为500*500</td>
            </tr>
            <tr>
                <td class="first">区域限售</td>
                <td>
                    <a class="rule-chooser-trigger" ref="'.$this->index.'" href="javascript:void(0)">
                        <img title="Open Chooser" class="v-middle" alt="" src="__PUBLIC__/Admin/images/rule_chooser_trigger.gif"></a>
                    请点击按钮选择显示或隐藏限售区域
                    <div id="shopMulti_cat" class="shop-cat-list rule-chooser" style="display:none;padding-left: 15px;">
                        <table class="tbForm" width="100%" style="margin-top:10px">
	<tbody>
<tr>
	<td style="text-align:left;margin-left:100px;" colspan="3">
	<style type="text/css">
	.loading-box{background-color:#FFF8ED;width:auto;min-width:100px;font-size:16px;padding:3px;border:1px solid #FF9900;display:none;}
	</style>
	选择省:
	<select id="province" name="province" class="medium" child_id="city" val="<?php echo ($region['province']); ?>">
	   <option value="0" selected="selected">请选择省份</option>
	</select>
	<select id="city" name="city" child_id="region1" class="medium" val="<?php echo ($region['city']); ?>" >
	   <option value="0" selected="selected">请选择城市</option>
	</select>
	<span class="loading-box">请稍等，载入中......</span>
		<button type="button" id="related_goods_form_search" class="btnA">搜索</button>
	</td>
</tr>
<tr>
	<td style="width:40%;text-align:center;">搜索出来的可选市区</td>
	<td style="width:20%;text-align:center;">操作</td>
	<td style="width:40%;text-align:center;">与该秒杀关联的市区</td>
</tr>
<tr>
	<td style="width:40%;text-align:center;">
		<select name="xxxxx1" class="large" id="g_related_goods_ids_selected" multiple="multiple" style="margin-left:auto;margin-right:auto;height:200px;"></select>
	</td>
	<td style="width:20%;text-align:center;">
		<span>
			<label for="related_tyoe_1" style="vertical-align:middle;">关联</label>
		<span>
		<br />
		<br />
		<button type="button" id="related_button_right" class="btnA" onclick="removeTORight();" style="width:100px;text-align:center;">>></button>
		<br />
		<br />
		<button type="button" id="related_button_left" class="btnA" onclick="removeTOLeft();" style="width:100px;text-align:center;"><<</button>
	</td>
	<td style="width:40%;text-align:center;">
		<input type="hidden" name="goods[g_related_goods_ids]" value="<?php echo ($ary_data["gs_related_city"]); ?>" id="g_related_goods_ids" />
		<select name="xxxxx2" id="g_related_goods_list" class="large" multiple="multiple" style="margin-left:auto;margin-right:auto;height:200px;">
			<?php if(is_array($info["related_areas"])): $i = 0; $__LIST__ = $info["related_areas"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$city): $mod = ($i % 2 );++$i;?><option value="<?php echo ($city["cr_id"]); ?>"><?php echo ($city["cr_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</td>
</tr>
	</tbody>
</table>
<script type="text/javascript">
$(document).ready(function(){
	//文档载入完成以后自动加载一级省市区
    loadChildCityRegion(1,'province',$('#province'));
	$("#related_goods_form_search").click(function(){
		var request_url = "<?php echo U('Admin/Groupbuy/cityRegionOptions');?>";
		var parent_id = $('#province').val();
		var type = $('#good_type').val();
		if(type == '1'){
			var g_id = $('#g_related_goods_ids_selected_info').val();
			if(g_id == '0'){
				showAlert(false,'请先选择商品信息');
				return false;
			}
		}
		$.ajax({
			url:request_url,
			data:{parent_id:parent_id,g_id:g_id},
			success:function(htmlObj){
				if(true === htmlObj.status && null !== htmlObj.data){
					var data = htmlObj.data;
					var htmls_options = "";
					for (var x in data){
						htmls_options += '<option value="' + x + '">' + data[x] + '</option>';
					}
					$("#g_related_goods_ids_selected").html(htmls_options);
				}
			},
			type:'POST',
			timeout:30000,
			dataType:'json'
		});
	});

});
function removeTORight(){
	var is_have = 0;
	$("#g_related_goods_ids_selected option").each(function(){
		if($(this).attr("selected")){
			var select_val = $(this).attr("value");
			$("#g_related_goods_list option").each(function(){
				if($(this).attr("value") == select_val){
					is_have = 1; 
				}
			});
			if(is_have != '1'){
				$("#g_related_goods_list").append($(this).removeAttr("selected"));
			}
		}
	});
	var related_goods_ids = "";
	$("#g_related_goods_list option").each(function(){
		related_goods_ids += $(this).attr("value") + ',';
	});
	return $("#g_related_goods_ids").val(related_goods_ids);
}

function removeTOLeft(){
	var related_goods_ids = "";
	var is_have = 0;
	$("#g_related_goods_list option").each(function(){
		
		if($(this).attr("selected")){
			var select_html = $(this).html();
			var select_val = $(this).attr('value');
			$("#g_related_goods_ids_selected option").each(function(){
				if($(this).attr('value') == select_val){
					is_have = 1;
				}
			});
			if(is_have != '1'){
				$("#g_related_goods_ids_selected").append('<option value="'+select_val+'">'+select_html+'</option>');
			}
			$(this).remove();
		}else{
			related_goods_ids += $(this).attr("value") + ',';
		}
	});
	return $("#g_related_goods_ids").val(related_goods_ids);
}

function openLoadingBox(){
	$(".loading-box").show();
}
function closeLoadingBox(){
	$(".loading-box").hide();
}
function loadChildCityRegion(parent_id,selectDomId,clickObj){
	//如果当前选中的行政区ID小于等于0，则表示选择的是“请选择”，将后面的行政区select清楚
	$(clickObj).nextAll("select").hide().empty();
	//如果选中了“请选择”，则不理会。
	if(parent_id <= 0 || "region" == $(clickObj).attr("id")){
		return false;
	}
	//定义异步加载行政区的url
	var load_options_url = "<?php echo U('Admin/Groupbuy/cityRegionOptions');?>";
	//ajax异步加载下一级行政区域数据
	$.ajax({
		url:load_options_url,
		data:{parent_id:parent_id},
		beforeSend:openLoadingBox(),
		type:'POST',
		success:function(jsonObj){
			if(true === jsonObj.status && null !== jsonObj.data){
				$(clickObj).next("select").show();
				//select options 元素数据拼接
				var html_options = '<option value="0" selected="selected">请选择</option>';
				var next_child_parent = 0;
				for(var index in jsonObj.data){
					html_options += '<option value="' + index + '" ';
					if(index == $(clickObj).attr('val')){
						html_options += 'selected="selected" ';
						next_child_parent = index;
					}
					html_options += '>' + jsonObj.data[index] + '</option>';
				}

				//将拼接的结果追加到DOM中
				$("#" + selectDomId).html(html_options);
				
				//递归加载数据，用于初始化的时候
				if(next_child_parent > 0){
					var selectChildDomId = $("#" + selectDomId).attr("child_id");
					loadChildCityRegion(next_child_parent,selectChildDomId,$("#" + selectChildDomId));
				}
				
				//对空seletet元素进行隐藏操作
				if($("#province").val() <= 0){
					$("#province").nextAll("select").hide().empty();
				}else if($("#city").val() <= 0){
					$("#city").nextAll("select").hide().empty();
				}
                
			}else{
				if("region" == $(clickObj).attr("id")){
					$(clickObj).empty().hide();
				}else{
					$(clickObj).next("select").empty().hide();
				}
				
			}
			closeLoadingBox();
		},
		dataType:'json'
	});
}
</script> 
                    </div> 
                </td>
                <td class="last">（移动端暂不支持）</td>
            </tr>
                
            <tr>
                <td class="first">限购数量</td>
                <td>
                    <input type="text" value="0" name="sp_number" id="sp_number" class="medium" validate="{ required:true}"/>
                </td>
                <td class="last">达到此数量，秒杀活动自动结束。0表示不限</td>
            </tr>       
           <tr>
                <td class="first">秒杀类目</td>
                <td>
                <select name="gcid" class="small search_cond" style="width: auto">
                         <option value="0" >选择类目</option>
                         <?php if(is_array($cates)): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate['gc_id']); ?>" <?php if(($gcid == $cate['gc_id'])): ?>selected=selected<?php endif; ?> ><?php echo ($cate['gc_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>	
                </td>
                <td class="last">（移动端暂不支持）</td>
            </tr>    			
            <tr style="display:none;">
                <td class="first">赠送积分数</td>
                <td>
                    <input type="text" name="sp_send_point" id="sp_send_point" class="medium" />
                </td>
                <td class="last"></td>
            </tr>                

            <tr>
                <td class="first">是否显示商品详情</td>
                <td>
                    <input type="radio" name="sp_goods_desc_status" id="sp_goods_desc_status_1" checked value="1" />启用
                    <input type="radio" name="sp_goods_desc_status" id="sp_goods_desc_status_0" value="0" />停用
                </td>
                <td class="last"></td>
            </tr>				
            <tr>
                <td class="first">是否启用</td>
                <td>
                    <input type="radio" name="sp_status" id="is_active_1" checked value="1" />启用
                    <input type="radio" name="sp_status" id="is_active_0" checked value="0" />停用
                </td>
                <td class="last">不勾选代表停用</td>
            </tr>	
            <tr>
                <td class="first">PC端秒杀描述</td>
                <td>
                    <textarea name="sp_desc" id="editor"  style="width:600px;"></textarea>
                </td>
                <td class="last"></td>
            </tr>	
            <tr>
                <td class="first">手机端秒杀描述</td>
                <td>
                    <textarea name="sp_mobile_desc" id="mobile_editor"  style="width:600px;"></textarea>
                </td>
                <td class="last"></td>
            </tr>				
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="99">
                        <input type="submit" value="提 交" class="btnA">
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>
<script type="text/javascript" charset="utf-8">
    window.UEDITOR_HOME_URL = "__PUBLIC__/Lib/ueditor/";
</script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Lib/ueditor/editor_all.js"></script>
<script type="text/javascript" src="__PUBLIC__/Admin/js/spike.js"></script>
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