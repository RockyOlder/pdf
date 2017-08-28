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
    <form id="member_form" name="member_form" method="post" action="<?php echo U('Admin/Distirbution/doSet');?>">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">淘宝铺货相关设置</th>
                </tr>
            </thead>
            <tbody>    			
                <tr>
                    <td class="first">是否使用淘宝分类：</td>
                    <td>
                        <input type="radio" value="是否使用淘宝分类-1" name="TAOBAO_SET_CATEGORY" <?php if($TAOBAO_SET_CATEGORY["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否使用淘宝分类-0" name="TAOBAO_SET_CATEGORY" <?php if($TAOBAO_SET_CATEGORY["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">不使用淘宝分类，淘宝商品转换为系统商品时默认把商品归到"淘宝未分类商品"中。</label></td>
                </tr>   
                <tr>
                    <td class="first">是否使用淘宝品牌：</td>
                    <td>
                        <input type="radio" value="是否使用淘宝品牌-1" name="TAOBAO_SET_BRAND" <?php if($TAOBAO_SET_BRAND["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否使用淘宝品牌-0" name="TAOBAO_SET_BRAND" <?php if($TAOBAO_SET_BRAND["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">不使用淘宝品牌，淘宝商品转换为系统商品默认把商品归到"淘宝未分品牌商品"中。</label></td>
                </tr>     
                <tr>
                    <td class="first">是否新品：</td>
                    <td>
                        <input type="radio" value="是否新品-1" name="TAOBAO_SET_NEW" <?php if($TAOBAO_SET_NEW["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否新品-0" name="TAOBAO_SET_NEW" <?php if($TAOBAO_SET_NEW["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">设置新品后，淘宝商品转换为系统商品时系统商品为新品商品</label></td>
                </tr>  
                <tr>
                    <td class="first">是否热销：</td>
                    <td>
                        <input type="radio" value="是否热销-1" name="TAOBAO_SET_HOT" <?php if($TAOBAO_SET_HOT["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否热销-0" name="TAOBAO_SET_HOT" <?php if($TAOBAO_SET_HOT["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">设置热销后，淘宝商品转换为系统商品时系统商品热销商品</label></td>
                </tr>        
                <tr>
                    <td class="first">是否上架销售：</td>
                    <td>
                        <input type="radio" value="是否上架销售-1" name="TAOBAO_SET_SALE" <?php if($TAOBAO_SET_SALE["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否上架销售-0" name="TAOBAO_SET_SALE" <?php if($TAOBAO_SET_SALE["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">设置上架后,淘宝商品转换为系统商品时系统商品为上架状态，</label></td>
                </tr> 
                <tr>
                    <td class="first">商品是否预售：</td>
                    <td>
                        <input type="radio" value="商品是否预售-1" name="TAOBAO_SET_PRESALE" <?php if($TAOBAO_SET_PRESALE["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="商品是否预售-0" name="TAOBAO_SET_PRESALE" <?php if($TAOBAO_SET_PRESALE["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">设置预售后，商品没有库存也可下单购买</label></td>
                </tr> 				
				<tr>
                    <td class="first">是否下载非销售属性：</td>
                    <td>
                        <input type="radio" value="是否下载非销售属性-1" name="TAOBAO_SET_DOWN_UNSALE" <?php if($TAOBAO_SET_DOWN_UNSALE["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否下载非销售属性-0" name="TAOBAO_SET_DOWN_UNSALE" <?php if($TAOBAO_SET_DOWN_UNSALE["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">设置否后，现在淘宝商品时不下载非销售属性</label></td>
                </tr> 
                <tr>
                    <td class="first">是否更新商品数据：</td>
                    <td>
                        <input type="radio" value="是否更新商品数据-1" name="TAOBAO_SET_FRESH" <?php if($TAOBAO_SET_FRESH["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否更新商品数据-0" name="TAOBAO_SET_FRESH" <?php if($TAOBAO_SET_FRESH["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">设置更新后,淘宝商品转换为系统商品时会更新系统商品数据（目前只支持更新商品主图和描述），</label></td>
                </tr>        
                 <tr>
                    <td class="first">是否允许上传物流模版：</td>
                    <td>
                        <input type="radio" value="是否允许上传物流模版-1" name="TAOBAO_SET_DELIVER" <?php if($TAOBAO_SET_DELIVER["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否允许上传物流模版-0" name="TAOBAO_SET_DELIVER" <?php if($TAOBAO_SET_DELIVER["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">开启的情况下，分销商可以选择采用供货商的物流模版。</label></td>
                </tr>   
                <tr>
                    <td class="first" style="width:230px;">分销商铺货默认物流模板设置：</td>
                    <td>
                        <input type="radio" value="分销商铺货默认物流模板设置-0" name="TAOBAO_SET_DELIVERDEFAULT" <?php if($TAOBAO_SET_DELIVERDEFAULT["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 卖家包邮 <br />
                        <input type="radio" value="分销商铺货默认物流模板设置-1" name="TAOBAO_SET_DELIVERDEFAULT" <?php if($TAOBAO_SET_DELIVERDEFAULT["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 采用供货商配置 <br />
                   		<input type="radio" value="分销商铺货默认物流模板设置-2" name="TAOBAO_SET_DELIVERDEFAULT" <?php if($TAOBAO_SET_DELIVERDEFAULT["sc_value"] == 2): ?>checked="checked"<?php endif; ?>> 采用淘宝默认平邮/快递/EMS 
                    </td>                    
                    <td><label class="last">配置前台铺货时默认的物流模板选项。</label></td>
                </tr>            
                <tr>
                    <td class="first" style="width:230px;">是否允许分销商同步库存时额外同步价格：</td>
                    <td>
                         <input type="radio" value="是否允许分销商同步库存时额外同步价格-1" name="TAOBAO_SET_PRICE" <?php if($TAOBAO_SET_PRICE["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否允许分销商同步库存时额外同步价格-0" name="TAOBAO_SET_PRICE" <?php if($TAOBAO_SET_PRICE["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last">配置前台铺货时是否允许同步库存和价格。</label></td>
                </tr> 
				<tr>
                    <td class="first" style="width:230px;">淘宝KEY授权：</td>
                    <td>
                         <input type="radio" value="是否允许淘宝key授权-1" name="TAOBAO_SET_KEY" <?php if($TAOBAO_SET_KEY["sc_value"] == 1): ?>checked="checked"<?php endif; ?>> 是
                        <input type="radio" value="是否允许淘宝key授权-0" name="TAOBAO_SET_KEY" <?php if($TAOBAO_SET_KEY["sc_value"] == 0): ?>checked="checked"<?php endif; ?>> 否
                    </td>                    
                    <td><label class="last"></label></td>
                </tr> 
				<tr>
                    <td class="first" style="width:230px;">FX_TAOBAO_KEY：</td>
                    <td>
                        <input type="text" value="<?php echo ($FX_TAOBAO_KEY); ?>" name="FX_TAOBAO_KEY" > 
                    </td>                    
                    <td><label class="last">淘宝授权key</label></td>
                </tr> 
				<tr>
                    <td class="first" style="width:230px;">FX_TAOBAO_SECRET：</td>
                    <td>
                        <input type="password" value="<?php echo ($FX_TAOBAO_SECRET); ?>" name="FX_TAOBAO_SECRET" > 
                    </td>                    
                    <td><label class="last">授权密码</label></td>
                </tr> 
				<tr>
                    <td class="first" style="width:230px;">TAOBAO_REQUEST_URL：</td>
                    <td>
                        <input type="text" value="<?php echo ($TAOBAO_REQUEST_URL); ?>" name="TAOBAO_REQUEST_URL" > 
                    </td>                    
                    <td><label class="last">淘宝无签名方式调用</label></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="99">
                        <input type="submit" value="提 交" class="btnA" >
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>
<script>
    $(document).ready(function(){   
        $("#orders_form").validate({
                errorPlacement: function(error, element) {
                    var error_td = element.parent('td').next();
                    error_td.find('label').hide();
                    error_td.append(error);
                },
                submitHandler:function(form){
                    ajaxpost('orders_form', '', '', 'onerror') 
                },
                rules : {
                    STATUS : {
                        required:true
                    }
                },
                messages : {
                    STATUS : {
                        required : '请选择'
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