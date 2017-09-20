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
    <form id="promotion_add" name="promotion_add" method="post" action="<?php echo U('Admin/ArtificialService/doArtificialadd');?>">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">新建人工订单</th>
                </tr>
            </thead>
            <tbody class="tab">
                <tr>
                    <th colspan="99">订单基本信息</th>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 文件名</td>
                    <td>
                        <input type="text" name="f_name" value="" class="large" validate="{ required:true,maxlength:100}" />
                    </td>
                    <td class="last">建议不超过100个字</td>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 文档页数</td>
                    <td>
                        <input type="text" name="document_pages" value="" class="small" validate="{ required:true,min:0,number:true}" />
                    </td>
                    <td class="last">请输入数字</td>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 权限密码</td>
                    <td>
                        <input type="radio" name="permissions_ps" value="0" /> 有
                        <input type="radio" name="permissions_ps" value="1" checked="checked" /> 无  </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 文档损坏</td>
                    <td>
                        <input type="radio" name="documents_badness" value="0" /> 有 
                        <input type="radio" name="documents_badness" value="1" checked="checked" /> 无  </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 服务类型</td>
                    <td>
                        <select id="pmn_rule" name="service_type" class="medium" validate="{ selected:true}" style="width:200px;" onchange="change_rule(this.value);">
                            <option value="0">请选择</option>
                                <option value="1">疑难件转换</option>
                                <option value="2">权限密码</option>
                                <option value="3">损坏修复</option>
                        </select>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">单价</td>
                    <td class="last"> <span id="price_data" style="color:red;"></span>元/页</td>
                    <td class="last"></td>
                </tr>
                <tr id='rule_box'></tr>
<!--                <tr>
                    <td class="first"><span class="red">*</span> 转换页数</td>
                    <td>
                        <input type="text" name="conversions_pages" value="" id="conversions_pages" class="small" validate="{ required:true,min:0,number:true}" />
                    </td>
                    <td class="last">请输入数字</td>
                </tr>-->
                <tr>
                    <td class="first">预计金额</td>
                    <td><span id="price_total" style="color:red;"></span>元</td>
                </tr>
                <tr class="last">
                    <td colspan="99">
                        <input type="button" value="提 交" class="btnA" onclick="javascrpt:save();"/>&nbsp;
                        <input type="button" value="取 消" class="btnA back" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div class="clear"></div>
</div>
<link href="__PUBLIC__/Admin/css/condition.css" rel="stylesheet">
<script type="text/javascript">
/**
 * 提交表单
 * @author zhangjiasuo <zhangjiasuo@guanyisoft.com>
 * @date 2013-05-29
 */
function save(){
    var res = $('#promotion_add').valid();
    //定义一个判断标示
    if(res){
        document.promotion_add.submit();
    }
} 

//修改促销规则
function change_rule(selectVal){
    //判断是否为真正的onchange事件
    if(selectVal != $('#rule_box').data('index')){
        $('#rule_box').data('index',selectVal);
    }else{
        return;
    }
              
    var html = '';
    switch(selectVal){
        case "1":
            html = "<td class='first' colspan='3'>"
                 + "<div style='margin-left: 110px;'>"
                 + "<table><tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 文档难度</td><td style='text-align:left;width:630px;'> <input type='radio' name='documents_difficulty' value='1' /> 普通件 <input type='radio' name='documents_difficulty' value='2' /> 疑难件 </td></td>"
                 + "</tr>"
                 + "<tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 文档类型</td><td style='text-align:left;width:630px;'> <input type='radio' name='documents_type' value='1' /> 文本 <input type='radio' name='documents_type' value='2' />扫描/图片</td>"
                 + "<tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 转换页数</td><td style='text-align:left;width:630px;'><input type='text' name='conversions_pages' value='' id='conversions_pages' onblur='NumberTotalPrice(this)' class='small' validate='{ required:true,min:0,number:true}'/></td>"
                 + "</tr></table>";
                
        break;
        case "2":
             $("#price_total").text(parseFloat(1).toFixed(2));
        break;
        case "3":
            html = "<td class='first' colspan='3'>"
                 + "<div style='margin-left: 110px;'>"
                 + "<table>"
                 + "<tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 文档类型</td><td style='text-align:left;width:630px;'> <input type='radio' name='documents_type' value='1' /> 文本 <input type='radio' name='documents_type' value='2' />扫描/图片</td>"
                 + "<tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 转换页数</td><td style='text-align:left;width:630px;'><input type='text' name='conversions_pages' value='' id='conversions_pages' onblur='NumberTotalPrice(this)' class='small' validate='{ required:true,min:0,number:true}'/></td>"
                 + "</tr></table>";
        break;
    }
    if(selectVal == 'PYIKOUJIA'){
        $("#group").hide();
		$("#category").hide();
		$("#brand").hide();
    }else{
        $("#group").show();
		$("#category").show();
		$("#brand").show();
    }
    
    $('#rule_box').html(html);
    //alert(selectVal);return false;
}

function NumberTotalPrice(_this){
        if(_this.value >100 && $("#pmn_rule").val() == 1 ){
            
            if($("input[name='documents_difficulty']:checked").val() == 1 && $("input[name='documents_type']:checked").val() == 1){
                $("#price_data").text('0.03');
                $("#price_total").text(parseFloat(_this.value * 0.03).toFixed(2));
            }
            if($("input[name='documents_difficulty']:checked").val() == 2 && $("input[name='documents_type']:checked").val() == 1){
                $("#price_data").text('0.05');
                $("#price_total").text(parseFloat(_this.value * 0.05).toFixed(2));
            }
            if($("input[name='documents_difficulty']:checked").val() == 1 && $("input[name='documents_type']:checked").val() == 2){
                $("#price_data").text('0.1');
                $("#price_total").text(parseFloat(_this.value * 0.1).toFixed(2));
            }
            if($("input[name='documents_difficulty']:checked").val() == 2 && $("input[name='documents_type']:checked").val() == 2){
                $("#price_data").text('0.2');
                $("#price_total").text(parseFloat(_this.value * 0.2).toFixed(2));
            }
        } else if(_this.value <=100 && $("#pmn_rule").val() == 1) {
            
            if($("input[name='documents_difficulty']:checked").val() == 1 && $("input[name='documents_type']:checked").val() == 1){
                $("#price_data").text(3);
                $("#price_total").text(parseFloat(3).toFixed(2));
            }
            if($("input[name='documents_difficulty']:checked").val() == 2 && $("input[name='documents_type']:checked").val() == 1){
                $("#price_data").text(5);
                $("#price_total").text(parseFloat(5).toFixed(2));
            }
            if($("input[name='documents_difficulty']:checked").val() == 1 && $("input[name='documents_type']:checked").val() == 2){
                $("#price_data").text(10);
                $("#price_total").text(parseFloat(10).toFixed(2));
            }
            if($("input[name='documents_difficulty']:checked").val() == 2 && $("input[name='documents_type']:checked").val() == 2){
                $("#price_data").text(20);
                $("#price_total").text(parseFloat(20).toFixed(2));
            }
        } else if(_this.value <= 20 && $("#pmn_rule").val() == 3) {
            if($("input[name='documents_type']:checked").val() == 1){
                $("#price_data").text(1);
                $("#price_total").text(parseFloat(1).toFixed(2));
            }
            if($("input[name='documents_type']:checked").val() == 2){
                $("#price_data").text(2);
                $("#price_total").text(parseFloat(2).toFixed(2));
            }
        } else if(_this.value > 20 && $("#pmn_rule").val() == 3) {
            if($("input[name='documents_type']:checked").val() == 1){
                $("#price_data").text('0.05');
                $("#price_total").text(parseFloat(_this.value * 0.05).toFixed(2));
            }
            if($("input[name='documents_type']:checked").val() == 2){
                $("#price_data").text('0.1');
                $("#price_total").text(parseFloat(_this.value * 0.1).toFixed(2));
            }
        }

}
$(document).ready(function(){
    /*显示和隐藏已经被占用的优先级*/
    $('#showDisableOrder').click(function(){
        if($(this).attr('checked')=='checked'){
            $("#pmn_order option:disabled").show();
        }else{
            $("#pmn_order option:disabled").hide();
        }
    });
    //刷新页面后 自动调用被选的 促销规则
    change_rule($("#pmn_rule option:selected").val());
	
	//类目选择
	$(".rule-chooser-trigger").click(function(){
		if($("#shopMulti_cat").css('display') == 'block'){
			$("#shopMulti_cat").css("display","none");
		}else{
			$("#shopMulti_cat").css("display","block");
		}
	});

	 
	 $(".cat-checkbox").click(function(){
		var selValue = '';
		var now_id = $(this).attr("ref");
		if($(this).attr('checked') == 'checked'){
			$(".cat-checkbox").each(function(){
				if($(this).attr("pid") == now_id){
					$(this).attr("checked","checked");
				}
			});
		}else{
			$(".cat-checkbox").each(function(){
				if($(this).attr("pid") == now_id){
					$(this).attr("checked",false);
				}
			});
		}
		$(".cat-checkbox:checked").each(function(){
			selValue += $(this).attr("ref") + ',';
		});
		if(selValue.length>0){
			selValue = selValue.substr(0,selValue.length-1);
		}
		$("#cat_selValue").val(selValue);
	});

	//品牌选择
	$(".rule-chooser-trigger1").click(function(){
		if($("#shopMulti_brand").css('display') == 'block'){
			$("#shopMulti_brand").css("display","none");
		}else{
			$("#shopMulti_brand").css("display","block");
		}
	});  
	
	 $(".brand-checkbox").click(function(){
		var selValue = '';
		$(".brand-checkbox:checked").each(function(){
			selValue += $(this).attr("ref") + ',';
		});
		if(selValue.length>0){
			selValue = selValue.substr(0,selValue.length-1);
		}
		 
		$("#brand_selValue").val(selValue);
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