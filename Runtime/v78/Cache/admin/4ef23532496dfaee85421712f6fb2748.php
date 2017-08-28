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
    <form id="coupon_add" method="post" action="<?php echo U('Admin/Coupon/doPostActivities');?>">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">修改优惠券活动</th>
                </tr>
            </thead>

            <tbody>
				<tr>
                    <td class="first">* 优惠券活动类型</td>
                    <td>
                        <input type="radio" value="0" name="ca_type" <?php if(($ca_type) == "0"): ?>checked<?php endif; ?> />同号券
                       <input type="radio" value="1" name="ca_type" <?php if(($ca_type) == "1"): ?>checked<?php endif; ?>/>异号券
                       <input type="radio" value="2" name="ca_type" <?php if(($ca_type) == "2"): ?>checked<?php endif; ?>/>注册券
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 优惠券活动名称</td>
                    <td><input type="text" value="<?php echo ($ca_name); ?>" name="ca_name" class="medium" validate="{ required:true}" /></td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 活动开始时间</td>
                    <td>
                        <input type="text" value="<?php echo ($ca_start_time); ?>" name="ca_start_time" id="ca_start_time" class="medium timer" validate="{ required:true}"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 活动结束时间</td>
                    <td>
                        <input type="text" value="<?php echo ($ca_end_time); ?>" name="ca_end_time" id="ca_end_time" class="medium timer" validate="{ required:true}"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr class="ca_sn_all ca_sn_0" <?php if(($ca_type) != "0"): ?>style="display: none;"<?php endif; ?> >
                    <td class="first">* 同号优惠券编码</td>
                    <td>
                        <input type="text" value="<?php echo ($ca_sn); ?>" name="ca_sn" class="medium" validate="{ required:true,path:true,minlength:6 }" />
                    </td>
                    <td class="last">数字与字母组合，至少6位</td>
                </tr>
                <tr class="ca_sn_all ca_sn_1" <?php if(($ca_type) == "0"): ?>style="display: none;"<?php endif; ?> >
                    <td class="first">优惠券编码前缀</td>
                    <td><input type="text" value="<?php echo ($c_sn_prefix); ?>" name="c_sn_prefix" class="medium" validate="{ path:true}" /></td>
                    <td class="last">可以不填</td>
                </tr>
                <tr class="ca_sn_all ca_sn_1" <?php if(($ca_type) == "0"): ?>style="display:none;"<?php endif; ?> >
                    <td class="first">优惠券编码后缀</td>
                    <td><input type="text" value="<?php echo ($c_sn_suffix); ?>" name="c_sn_suffix" class="medium" validate="{ path:true}" /></td>
                    <td class="last">可以不填</td>
                </tr>
                <tr class="ca_sn_all ca_sn_1" <?php if(($ca_type) == "0"): ?>style="display:none;"<?php endif; ?> >
                    <td class="first">* 编码长度(除前后缀)</td>
                    <td><input type="text" value="<?php echo ($c_long); ?>" name="c_long" class="small" validate="{ required:true,number:true,digits:true,range:[6,18] }" /></td>
                    <td class="last">最少6位，最多18位</td>
                </tr>
				<tr>
                    <td class="first">* 优惠券类型</td>
                    <td>
                        <input type="radio" value="0" name="c_type" <?php if(($c_type) == "0"): ?>checked<?php endif; ?> />现金券
                        <input type="radio" value="1" name="c_type" <?php if(($c_type) == "1"): ?>checked<?php endif; ?> />折扣券
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 优惠券面额或折扣比率</td>
                    <td><input type="text" name="c_money" class="medium" validate="{ required:true,number:true}" value="<?php echo ($c_money); ?>" /></td>
                    <td class="last">当优惠券类型为折扣券时请输入折扣比率<br />范围大于0小于1,例如8折,请输入0.8</td>
                </tr>
                <tr>
                    <td class="first">添加商品货号：</td>
                    <td>
                        <input type="text"  id="pdt_sn" class="large" onkeypress="EnterPress(event)" />
                        直接按回车
                        <button type="button" id="addGoods"  class="btnA submit-button">添加商品</button>
                        <input type="radio" value="all" name="coupon_gid" <?php if($chek == 1): ?>checked='true'<?php endif; ?>  />全部商品
                        <div id="goodsSelect" style="display: none;" title="请选择商品">
                                
<div id="isAjax" style="display:none">用此ID标识本页面是通过ajax载入进来的</div>
<div class="rightInner load" id="goodsSelecterInner">
    <table width="100%" class="tbForm">
        <thead>
            <tr class="title">
                <th colspan="99">查找商品</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>商品货号</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["pdt_sn"]); ?>" name="pdt_sn" id="pdt_sn" />
                </td>
                <td>商品名称</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["g_name"]); ?>" name="gs_name" id="gs_name" />
                </td>
                <td>商品分类</td>
                <td>
                    <select class="medium" name="gs_gcid" id="gs_gcid">
                        <option value="0"> - 全部分类 - </option>
                        <?php if(is_array($search["cates"])): $i = 0; $__LIST__ = $search["cates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["gc_id"]); ?>" <?php if(($chose["gcid"]) == $cate[gc_id]): ?>selected="selected"<?php endif; ?> ><?php $__FOR_START_14019__=0;$__FOR_END_14019__=$cate[gc_level];for($i=$__FOR_START_14019__;$i < $__FOR_END_14019__;$i+=1){ ?>&nbsp;&nbsp;<?php } echo ($cate["gc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
                <td colspan="99" align="right">
                    <input type="button" value="查 找" class="btnA" onclick="goodsSelecterSerch();" >
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="rightInner load" id="goodsSelecterList">
    <table width="100%" class="tbList">
        <thead>
            <tr>
                <th><input type="checkbox" class="ckeckAll" /></th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>商品货号</th>
                <th>规格名称</th>
                <th>分类</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" class="checkSon" name="gs_pdt_sn" value="<?php echo ($goods["pdt_sn"]); ?>" /></td>
                <td><img src='<?php echo (($goods["g_picture"])?($goods["g_picture"]):"Ucenter/images/pdtDefault.jpg"); ?>' class="img32" /></td>
                <td><?php echo ($goods["g_name"]); ?><br><span class="blue"><?php echo ($goods["g_sn"]); ?></span></td>
                <td><?php echo ($goods["pdt_sn"]); ?></td>
                <td><?php echo ($goods["pdt_spec"]); ?></td>
                <td><?php echo ($goods["gc_name"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(empty($list)): ?><tr><td colspan="99" class="left">没有查找到结果! 没有相关的数据或者请先进行查找~ </td></tr><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99"><span class="right page"><?php echo ($page); ?></span></td>
            </tr>
        </tfoot>
    </table>
    <div class="clear"></div>
</div>
<script src="__PUBLIC__/Admin/js/loading.js"></script>
<script>
$("#g_gifts").click(function(){
    if($(this).val()=='1'){
        $("#g_gifts").val('0');
    }else{
        $("#g_gifts").val('1');
    }
})

//查找商品 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function goodsSelecterSerch(){
    var g_gifts =  $("#g_gifts").val();
    var data = {
        'pdt_sn':$("input[name='pdt_sn']").val(),
        'g_name':$("input[name='gs_name']").val(),
        'gs_gcid':$('#gs_gcid').val(),
        'g_gifts':g_gifts
    };
    var url = "<?php echo U('Admin/Goods/getProductsInfo');?>";
    $.get(url,data,function(info){
        $('#isAjax').parent().html(info);
    },'text');
}
</script>
                        </div>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="first"></td>
                    <td>
                        <table style="border:1px solid gray;">
                            <thead>
                                <tr style="border:1px solid gray;text-align:center;">
                                    <td style="border:1px solid gray;" width="300px">商品名称</td>
                                    <td style="border:1px solid gray;" width="200px;">商品编号</td>
                                    <td style="border:1px solid gray;" width="150px;">库存数</td>
                                    <td style="border:1px solid gray;" width="150px;">销售价</td>
                                    <td style="border:1px solid gray;" width="150px;">操作</td>
                            </thead>
                            <tbody id="product_info">
                                
<?php if(is_array($goods_data)): foreach($goods_data as $key=>$list): ?><tr style='border:1px solid gray;text-align:center;' class='searchGoods'>
    <td style='border:1px solid gray;'><?php echo ($list["g_name"]); ?></td>
    <td style='border:1px solid gray;' class='pdt_sn_search'><?php echo ($list["pdt_sn"]); ?>
        <input type='hidden' name='pro_g_id' value='<?php echo ($list["g_id"]); ?>'>
        <input type='hidden' name='pro_pdt_sn' value='<?php echo ($list["pdt_sn"]); ?>'>
        <input type='hidden' name='pro_pdt_id' value='<?php echo ($list["pdt_id"]); ?>'>
        <input type='hidden' name='pro_have_sku' value='<?php if($list['products'] == ''): ?>1<?php endif; ?>'>	
        <input type='hidden' name='com_id' value="<?php echo ($list["g_id"]); ?>">	
    </td>
    <td style='border:1px solid gray;'>
        <?php echo ($list["g_stock"]); ?>
    </td>
    <td style='border:1px solid gray;'><?php echo ($list["g_price"]); ?></td>
    <td style='border:1px solid gray;'>
<a href='javascript:void(0);' onclick='deleteProduct(this);'>删除</a>
    <?php if(!empty($list["products"])): ?><a href='javascript:void(0);' onclick='hideProduct("<?php echo ($list["g_id"]); ?>");' class="hp<?php echo ($list["g_id"]); ?>">隐藏</a>
    <a href='javascript:void(0);' onclick='showProduct("<?php echo ($list["g_id"]); ?>");' class="sp<?php echo ($list["g_id"]); ?>" style="display:none;">展开</a><?php endif; ?>
    </td>
</tr>

<noempty name="list.products">
<?php if($list['products'] != ''): ?><tr style="border:1px solid gray;text-align:center;background:#DDDDDD;" class="hideTr<?php echo ($list["g_id"]); ?>">
    <td style="border:1px solid gray;" width="150px;">规格</td>
    <td style="border:1px solid gray;" width="300px;">商品规格</td>
    <td style="border:1px solid gray;" width="150px;">库存数</td>
    <td style="border:1px solid gray;" width="150px;">销售价</td>
    <td style="border:1px solid gray;" ></td>
</tr><?php endif; ?>
<?php if(is_array($list["products"])): $i = 0; $__LIST__ = $list["products"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data_info): $mod = ($i % 2 );++$i;?><tr style='border:1px solid gray;text-align:center;background:#DDDDDD;' class='searchGoods hideTr<?php echo ($list["g_id"]); ?>'>
    <td style='border:1px solid gray;'><?php echo ($data_info["specName"]); ?></td>
    <td style='border:1px solid gray;'><?php echo ($data_info["pdt_sn"]); ?>
     <input type='hidden' name='pro_g_id' value='<?php echo ($data_info["g_id"]); ?>'>
     <input type='hidden' name='pro_pdt_sn' value='<?php echo ($data_info["pdt_sn"]); ?>'>
     <input type='hidden' name='pro_pdt_id' value='<?php echo ($data_info["pdt_id"]); ?>'>
    </td>
    </td>
    <td style='border:1px solid gray;'>
       <?php echo ($data_info["pdt_stock"]); ?>
    </td>
    <td style='border:1px solid gray;'><?php echo ($data_info["pdt_sale_price"]); ?></td>
    <td style="border:1px solid gray;" ></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</noempty><?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="first">* 生效时间</td>
                    <td>
                        <input type="text" name="c_start_time" id="c_start_time" class="medium timer" validate="{ required:true}" value="<?php echo ($c_start_time); ?>"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 失效时间</td>
                    <td>
                        <input type="text" name="c_end_time" id="c_end_time" class="medium timer" validate="{ required:true}" value="<?php echo ($c_end_time); ?>"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 总数</td>
                    <td>
                        <input type="text" name="ca_total" class="small" validate="{ required:true,digits:true,range:[1,100000]}" value="<?php echo ($ca_total); ?>" />
                    </td>
                    <td class="last">活动可以生成的优惠券总数量,考虑性能问题，最多一个活动可以生成优惠券总数不超过100K</td>
                </tr>
                <tr>
                    <td class="first">活动限制</td>
                    <td>
                        <input type="text" name="ca_limit_nums" class="small" validate="{required:true,digits:true}" value="<?php echo (($ca_limit_nums)?($ca_limit_nums):'0'); ?>" />
                    </td>
                    <td class="last">同一个会员最多可以参与活动的次数，不填默认为0,表示不限次数</td>
                </tr>
                <tr>
                    <td class="first">是否不限使用条件</td>
                    <td>
                        <input type="checkbox" name="c_condition" id="c_condition" value="all" <?php if(($c_condition_money) == "0"): ?>checked="checked"<?php endif; ?> />
                        <span id="c_condition_money" <?php if(($c_condition_money) == "0"): ?>style="display: none;"<?php endif; ?> >订单满 <input type="text" class="small" name="c_condition_money" validate="{ number:true}" value="<?php echo ($c_condition_money); ?>" /> 元才可以使用</span>
                    </td>
                    <td class="last">勾选上表示不限定使用条件</td>
                </tr>
                  <tr>
                        <td class="first">商品分组</td>
                        <td>
                        <table class="tblist">
                            <tbody>
                                <?php if(is_array($goodsgroup)): $i = 0; $__LIST__ = $goodsgroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 10 );++$i; if(($mod) == "0"): ?><tr><?php endif; ?>
                                    <td><input type="checkbox" name="gg_name[]" id="gg_name" value="<?php echo ($data["gg_id"]); ?>" <?php if(in_array($data['gg_id'],$ary_ggid))echo 'checked' ?> /> <?php echo ($data["gg_name"]); ?></td>
                                <?php if(($mod) == "4"): ?></tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                     </td>
                </tr>
                <tr>
                    <td class="first">优惠券备注</td>
                    <td><textarea name="ca_memo" class="mediumBox" validate="{ maxlength:200}"><?php echo ($ca_memo); ?></textarea></td>
                    <td class="last">不超过200字</td>
                </tr>
                <tr>
                    <td class="first">是否启用</td>
                    <td><input type="checkbox" name="ca_status" value="1" <?php if(($ca_status) == "0"): ?>checked<?php endif; ?> /></td>
                    <td class="last"></td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="99">
                       <input type="hidden" name="ca_id" value="<?php echo ($ca_id); ?>" />
					   <input type="button" value="提 交" onclick="javascrpt:save(this.form);" class="btnA" >
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>

<script>
    $("document").ready(function(){
        $("#c_condition").click(function(){
            if($(this).attr('checked')=='checked'){
                $("#c_condition_money").fadeOut('fast');
            }else{
                $("#c_condition_money").fadeIn('fast');
            }
        });

        $("input[name='ca_type']").click(function(){
            var ca_type_val = $(this).val();
            if(ca_type_val == 2) ca_type_val = 1;
            $(".ca_sn_all").hide();
            $(".ca_sn_"+ca_type_val).show();
        })
        $('#goodsSelect').dialog({
            resizable: false,
            autoOpen: false,
            modal: true,
            width: 'auto',
            position: [220, 85],
            buttons: {
                '确认': function () {
                    $("input[name='gs_pdt_sn']:checked").each(function () {
                        //  alert(this.value)
                        ajaxSelectProducts(this.value);
                    });
                    $(this).dialog("close");
                },
                '关闭': function () {
                    $(this).dialog("close");
                }
            }
        });
        $("#addGoods").click(function () {
            $('#goodsSelect').dialog('open');
        });
        $('#coupon_add').validate();
    });
	function save(formObj){
        var startTime=$("#c_start_time").val();
        var endTime=$("#c_end_time").val();
        var start=new Date(startTime.replace("-", "/").replace("-", "/"));
        var end=new Date(endTime.replace("-", "/").replace("-", "/"));
        if(start > end){
            showAlert(false,'出错了','生效时间大于失效时间！');
            return false;
        }
		var c_type =  $("input[name='c_type']:checked").val();
		if(c_type == '1'){
			var c_money = parseFloat($("input[name='c_money']").val());
			if(c_money<=0 || c_money>=1){
				showAlert(false,'出错了','折扣券折扣比例大于0,小于1！');
				return false;
			}
		}
        var res = $('#coupon_add').valid();
        if(res){
            formObj.submit();
        }
    }
                        function ajaxSelectProducts(pdt_sn) {
                            $.ajax({
                                url: "<?php echo U('Admin/Goods/searchCouponInfo');?>",
                                type: 'POST',
                                dateType: 'json',
                                data: {'g_sn': pdt_sn,'save':1},
                                success: function (msg) {
                                    if (msg.status == 'error') {
                                        showAlert(false, msg.msg);
                                        return false;
                                    } else {
                                        var i = 0;
                                        $(".pro_pdt_sn").each(function () {
                                            if (this.value == pdt_sn) {
                                                i++;
                                            }
                                        });
                                        if (i == 0) {
                                            $("#product_info").append(msg);
                                        }
                                    }
                                }
                            });
                        }
                        function EnterPress(e) { //传入 event 
                            var e = e || window.event;
                            if (e.keyCode == 13) {
                                var pdt_sn = $("#pdt_sn").val();
                                if (pdt_sn == '') {
                                    showAlert(false, '商品货号不能为空！');
                                    return false;
                                }
                                ajaxSelectProducts(pdt_sn);
                            }
                        }
                        //删除货品
                        function deleteProduct(obj){
                            if(confirm('确定删除？')){
                                $(obj).parent().parent().remove();
                                var gid = $(obj).parent().parent().children("td:eq(1)").children("input[name='com_id']").val();
                                $('.hideTr'+gid).remove();
                                $(obj).parent().parent().remove();
                            }
                        }
                        //隐藏货品
                        function hideProduct(obj) {

                            var gid = $(obj).parent().parent().children("td:eq(1)").children("input[name='com_id']").val();
                            //   alert(gid)
                            $('.hideTr' + obj).hide();
                            $('.hp' + obj).hide();
                            $('.sp' + obj).show();
                        }
                        //展示货品
                        function showProduct(obj) {
                            var gid = $(obj).parent().parent().children("td:eq(1)").children("input[name='com_id']").val();
                            $('.hideTr' + obj).show();
                            $('.hp' + obj).show();
                            $('.sp' + obj).hide();
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