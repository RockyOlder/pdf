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
    <form id="coupon_add" name="coupon_add" method="post" action="<?php echo U('Admin/Coupon/doAdd');?>">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">新生成优惠券</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="first">* 优惠券名称</td>
                    <td>
                        <input type="text" name="c_name" class="medium" validate="{ required:true}" />
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">* 优惠券编码</td>
                    <td>
                        <input type="text" name="c_sn" class="medium" validate="{ required:true,remote:'__APP__/Admin/Coupon/getCheck',path:true,minlength:6 }" />
                    </td>
                    <td class="last">数字与字母组合，至少6位</td>
                </tr>
	            <tr>
                    <td class="first">* 优惠券类型</td>
                    <td>
                       <input type="radio" value="0" name="c_type" checked/>现金券
                       <input type="radio" value="1" name="c_type" />折扣券			   
                    </td>
                    <td class="last"></td>
                </tr>			
                <tr>
                    <td class="first">* 优惠券面额或折扣比率</td>
                    <td>
                        <input type="text" name="c_money" class="medium" validate="{ required:true,number:true}" />
                    </td>
                    <td class="last">当优惠券类型为折扣券是请输入折扣比率<br />范围大于0小于1,例如8折,请输入0.8</td>
                </tr>				
                <tr>
                    <td class="first">生效时间</td>
                    <td>
                        <input type="text" name="c_start_time" id="c_start_time" class="medium timer" validate="{ required:true}"/> 
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">失效时间</td>
                    <td>
                        <input type="text" name="c_end_time" id="c_end_time" class="medium timer" validate="{ required:true}"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">指定会员</td>
                    <td>
                        <input type="checkbox" name="c_user_id" id="c_user_id" value="1" />
                        <input type="text" id="c_user_name" name="m_name" class="medium" style="display:none;" value="请输入会员账户名" validate="{ remote:'__APP__/Admin/Members/getCheckName'}" />
                    </td>
                    <td class="last">不勾选代表任何人均可使用，勾选上则指定使用者</td>
                </tr>
                <tr>
                    <td class="first">是否不限使用条件</td>
                    <td>
                        <input type="checkbox" name="c_condition" id="c_condition" value="all" checked="checked" />
                        <span id="c_condition_money" style="display: none;" >订单满
                             <input type="text" class="small" name="c_condition_money" validate="{ number:true}" /> 元才可以使用
                        </span>
                    </td>
                    <td class="last">勾选上表示不限定使用条件</td>
                </tr>
                <tr> 
                        <td class="first">商品分组</td>

                        <td>
                        <table class="tblist">
                            <tbody>
                                <?php if(is_array($goodsgroup)): $i = 0; $__LIST__ = $goodsgroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 10 );++$i; if(($mod) == "0"): ?><tr><?php endif; ?>
                                    <td><input type="checkbox" name="gg_name[]" id="gg_name" value="<?php echo ($data["gg_id"]); ?>"> <?php echo ($data["gg_name"]); ?></td>
                                <?php if(($mod) == "4"): ?></tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                     </td>
                </tr>

                <tr>
                    <td class="first">优惠券备注</td>
                    <td>
                        <textarea name="c_memo" class="mediumBox" validate="{ maxlength:200}"></textarea>
                    </td>
                    <td class="last">不超过200字</td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="99">
                        <input type="button" value="提 交" class="btnA" onclick="javascrpt:save();">
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $("document").ready(function(){

        $("#c_user_id").click(function(){
            if($(this).attr('checked')=='checked'){
                $("#c_user_name").fadeIn('fast');
            }else{
                $("#c_user_name").fadeOut('fast');
            }
        });
                
        $("#c_user_name").click(function(){
            $('#c_user_name').attr("value",'');
        });

        $("#c_condition").click(function(){
            if($(this).attr('checked')=='checked'){
                $("#c_condition_money").fadeOut('fast');
            }else{
                $("#c_condition_money").fadeIn('fast');
            }
        });

        $('#coupon_add').validate();
    });
    
    /**提交表单
     * @author zhangjiasuo <zhangjiasuo@guanyisoft.com>
     * @date 2013-07-10
     */
    function save(){
        var startTime=$("#c_start_time").val(); 
        var endTime=$("#c_end_time").val(); 
        var start=new Date(startTime.replace("-", "/").replace("-", "/"));  
        var end=new Date(endTime.replace("-", "/").replace("-", "/")); 
        if(start > end){
            showAlert(false,'出错了','生效时间大于失效时间！');
            return false;
        }
        var res = $('#coupon_add').valid();
		var c_type =  $("input[name='c_type']:checked").val();
		if(c_type == '1'){
			var c_money = parseFloat($("input[name='c_money']").val());
			if(c_money<=0 || c_money>=1){
				showAlert(false,'出错了','折扣券折扣比例大于0,小于1！');
				return false;			
			}
		}
        if(res){
            document.coupon_add.submit();
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