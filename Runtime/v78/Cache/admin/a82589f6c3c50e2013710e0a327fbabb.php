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
    <table class="tbForm" width="100%">
        <thead>
            <tr class="title">
                <th colspan="99">地址库管理</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="first">选择地区</td>
                <td>
                    <select id="province" name="province" onchange="selectCityRegion($(this),'1');CityName($(this));" class="medium">
                        <option value="-1" selected="selected">请选择</option>
                        <?php if(is_array($cityRegion)): $i = 0; $__LIST__ = $cityRegion;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cr): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cr["cr_id"]); ?>"><?php echo ($cr["cr_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select >
                    <select id="city"  name="city" onchange="selectCityRegion($(this),'2');CityName($(this));" class="medium">
                        <option value="-1" selected="selected">请选择</option>
                    </select>
                    <select id="region" name="cr_id" class="medium" onchange="CityName($(this));">
                        <option value="-1" selected="selected">请选择</option>
                    </select>
                </td>
                <td class="last">
                    请不要随意改变地址库信息，会导致订单地址错误货品将无法发送到正确地址
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99" style="text-align: center;">
                    <input type="button" value="删 除" id="delCity" class="btnA"  />&nbsp;
                    <input type="button" value="添 加" id="addCity" class="btnA" cr_path="" />&nbsp;
                    <input type="button" value="修 改" id="editCity" class="btnA" />&nbsp;
                </td>
            </tr>
        </tfoot>
    </table>
    <div id="pro_diglog" style="display: none;">
        <div id="addCityname">
            <table class="tbForm" width="100%">
                <tr>
                    <td class="first">* 名称</td>
                    <td><input name="cityname" type="text" value="" /></td>
                    <td class="last">请输入需要添加的城市名称</td>
                </tr>
            </table>
        </div>
        <div id="editCityname">
            <table class="tbForm" width="100%">
                <tr>
                    <td class="first">* 名称</td>
                    <td><input name="editname" type="text" value="" id="editName" cr_id="" /></td>
                    <td class="last">请输入需要添加的城市名称</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clear"></div>

</div>
<script>
    function CityName(obj){
        var cr_id = obj.val();
        var name = obj.find("option:selected").html();
        $("#editName").val(name);
        $("#editName").attr("cr_id",cr_id);
    }
    function selectCityRegion(obj,pcth){
        var cr_id = obj.val();
        var cr_type = obj.attr('id');
        var url = "<?php echo U('Admin/Address/getSelectHtml');?>";
        $.get(url,{'cr_id':cr_id},function(info){
            if(cr_type == 'province'){
                $('#city').html(info);
                $('#region').html('<option value="-1" selected="selected">请选择</option>');
            }else if(cr_type == 'city'){
                $('#region').html(info);
            }
        });
    }
    
    //删除城市
    $("#delCity").click(function(){
        //选择省
        var province = $("#province").find("option:selected").val();
        var city = $("#city").find("option:selected").val();
        var region = $("#region").find("option:selected").val();
        var cr_id = 0;
        if(province != '-1' && province != ''){
            cr_id = province;
        }
        if(city != '-1' && city != ''){
            cr_id = city;
        }
        if(region != '-1' && region != ''){
            cr_id = region;
        }
        if(province == '-1' && city == '-1' && region == '-1'){
            showAlert(false,'出错了','请选择省/市/区');
            return false;
        }
        var url = "<?php echo U('Admin/Delivery/delCityAddress');?>";
        if(confirm("确认删除")){
            $.post(url, {'cr_id':cr_id}, function(msgObj){
                if(msgObj.success == '1'){
                    showAlert(true,'成功','删除成功');
                    return false;
                }else{
                    showAlert(false,'出错了',msgObj.msg);
                    return false;
                }
                
            }, 'json');
        }
    });
    
    //添加省市区
    $("#addCity").click(function(){
        //选择省
        var province = $("#province").find("option:selected").val();
        var city = $("#city").find("option:selected").val();
        var region = $("#region").find("option:selected").val();
        var cr_id = 0;
        if(province != '-1' && province != ''){
            cr_id = province;
        }else{
            cr_id = '1';
        }
        if(city != '-1' && city != ''){
            cr_id = city;
        }
        if(region != '-1' && region != ''){
            cr_id = region;
        }
        
        $("#addCityname").dialog({
            width:500,
            height:'auto',
            modal:true,
            title:'提示：添加城市',
            closeOnEscape:'false',
            close:function (){
                $("#addCityname").dialog('destroy');
                $('#pro_diglog').append($('#addCityname'));
            },
            buttons:{
                '确定':function(){
                    $("#addCityname").dialog('destroy');
                    $('#pro_diglog').append($('#addCityname'));
                    addCity(cr_id);
                },
                "取消": function() {
                    $("#addCityname").dialog('destroy');
                    $('#pro_diglog').append($('#addCityname'));
                }
            }
        });
        
    });
    
    $("#editCity").click(function(){
        var cr_id = $("#editName").attr("cr_id");
        var cityname = $("#editName").val();
        if(cr_id == '' || cr_id == '-1'){
            showAlert(false,'出错了','请选择省/市/区');
            return false;
        }
        $("#editCityname").dialog({
            width:500,
            height:'auto',
            modal:true,
            title:'提示：添加城市',
            closeOnEscape:'false',
            close:function (){
                $("#editCityname").dialog('destroy');
                $('#pro_diglog').append($('#editCityname'));
            },
            buttons:{
                '确定':function(){
                    $("#editCityname").dialog('destroy');
                    $('#pro_diglog').append($('#editCityname'));
                    editCity(cr_id,cityname);
                },
                "取消": function() {
                    $("#editCityname").dialog('destroy');
                    $('#pro_diglog').append($('#editCityname'));
                }
            }
        });
        
    });

    function editCity(cr_id,cityname){
        var cityname = $("#editName").val();
        var url = "<?php echo U('Admin/Delivery/editCityAddress');?>";
        $.post(url, {'cr_id':cr_id,'cityname':cityname}, function(msgObj){
            if(msgObj.success == '1'){
                showAlert(true,'成功',msgObj.msg);
                return false;
            }else{
                showAlert(false,'出错了',msgObj.msg);
                return false;
            }
                
        }, 'json');
    }

    function addCity(cr_id){
        var cityname = $("#addCityname input").val();
        var url = "<?php echo U('Admin/Delivery/addCityAddress');?>";
        $.post(url, {'cr_id':cr_id,'cityname':cityname}, function(msgObj){
            if(msgObj.success == '1'){
                showAlert(true,'成功','添加成功');
                return false;
            }else{
                showAlert(false,'出错了',msgObj.msg);
                return false;
            }
                
        }, 'json');
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