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
                <style>
.settitle{margin-left:20px;font-size:12px;font-weight:normal;color:#555}
.infomation {padding: 10px;border: 1px solid #b5cfd9;background: #f2f9fd;margin: 10px 0px;}
.thdlogin h3 {font-size: 14px;color: #0099cc;border-bottom: 3px solid #deeffa;padding-bottom: 5px;margin-bottom: 5px;}
.thdlogin h3 img {border: 0;vertical-align: middle;}
.thdlogin .table {font-size: 12px;border: 0px;width: 100%;text-indent: 15px;_text-indent: 0px;}
.thdlogin .table tr {height: 25px;}
.thdlogin .table td {border-bottom: 1px dashed #deeffa;padding-top: 5px;padding-bottom: 5px;_padding-left: 13px;}
</style>

<div class="infomation">
    <b>说明：</b>
    开启微博一键登录功能前，请进入相应开放平台申请APIkey以及Secretkey。
</div>
<form action="<?php echo U('Admin/Thdlogin/doAdd');?>" method="POST" class="thdlogin">
    <h3><img src="__PUBLIC__/images/sinaweibo.png" width="20px">&nbsp;&nbsp;新浪微博设置<span class="settitle">新浪开放平台地址：<a href="http://open.weibo.com" target="_blank">http://open.weibo.com</a></span></h3>
    <table class="table" style="margin:5px 0 20px 0;line-height:250%">
        <tr>
            <td width="150px">是否开启</td>
            <td width="330px"><input type="radio" name="thdlogin[status][sina]" value="1" <?php if($sina == '1'): ?>checked="true"<?php endif; ?>> 开启&nbsp;&nbsp;&nbsp;
            <input type="radio" name="thdlogin[status][sina]" value="0" <?php if($sina == '0'): ?>checked="true"<?php endif; ?>> 关闭</td>
            <td class="info">● 支持一键登录</td>
        </tr>
        <tr>
            <td>App Key</td>
            <td><input type="text" name="thdlogin[data][sinaid]" class="medium" value="<?php echo ($sinaid); ?>"></td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>App Secret</td>
            <td><input type="text" name="thdlogin[data][sinakey]" class="medium" value="<?php echo ($sinakey); ?>"></td>
            <td class="info"></td>
        </tr>
    </table>
<!--    <h3><img src="__PUBLIC__/images/qqweibo.png" width="20px">&nbsp;&nbsp;腾讯微博设置<span class="settitle">腾讯微博开放平台地址：<a href="http://open.t.qq.com" target="_blank">http://open.t.qq.com</a></span></h3>
    <table class="table" style="margin:5px 0 20px 0;line-height:250%">
        <tr>
            <td width="150px">是否开启</td>
            <td width="330px"><input type="radio" name="thdlogin[status][tqq]" value="1" <?php if($tqq == '1'): ?>checked="true"<?php endif; ?>> 开启&nbsp;&nbsp;&nbsp;
            <input type="radio" name="thdlogin[status][tqq]" value="0" <?php if($tqq == '0'): ?>checked="true"<?php endif; ?>> 关闭</td>
            <td class="info">● 支持一键登录</td>
        </tr>
        <tr>
            <td>App Key</td>
            <td><input type="text" name="thdlogin[data][tqqid]" class="medium" value="<?php echo ($tqqid); ?>"></td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>App Secret</td>
            <td><input type="text" name="thdlogin[data][tqqkey]" class="medium" value="<?php echo ($tqqkey); ?>"></td>
            <td class="info"></td>
        </tr>
    </table>-->
    
    <h3><img src="__PUBLIC__/images/qzone.png" width="20px">&nbsp;&nbsp;QQ号码一键登陆<span class="settitle">QQ开放平台地址：<a href="http://open.qq.com/" target="_blank">http://open.qq.com</a></span></h3>
    <table class="table" style="margin:5px 0 20px 0;line-height:250%">
        <tr>
            <td width="150px">是否开启</td>
            <td width="330px"><input type="radio" name="thdlogin[status][qq]" value="1" <?php if($qq == '1'): ?>checked="true"<?php endif; ?>> 开启&nbsp;&nbsp;&nbsp;
            <input type="radio" name="thdlogin[status][qq]" value="0" <?php if($qq == '0'): ?>checked="true"<?php endif; ?>> 关闭</td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>APP ID</td>
            <td><input type="text" name="thdlogin[data][qqid]" class="medium" value="<?php echo ($qqid); ?>"></td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>KEY</td>
            <td><input type="text" name="thdlogin[data][qqkey]" class="medium" value="<?php echo ($qqkey); ?>"></td>
            <td class="info"></td>
        </tr>
    </table>
    
    <h3><img src="__PUBLIC__/images/renren.png" width="20px">&nbsp;&nbsp;人人帐号一键登陆<span class="settitle">人人开放平台地址：<a href="http://dev.renren.com/" target="_blank">http://dev.renren.com</a></span></h3>
    <table class="table" style="margin:5px 0 20px 0;line-height:250%">
        <tr>
            <td width="150px">是否开启</td>
            <td width="330px"><input type="radio" name="thdlogin[status][renren]" value="1" <?php if($renren == '1'): ?>checked="true"<?php endif; ?>> 开启&nbsp;&nbsp;&nbsp;
            <input type="radio" name="thdlogin[status][renren]" value="0" <?php if($renren == '0'): ?>checked="true"<?php endif; ?>> 关闭</td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>API Key</td>
            <td><input type="text" name="thdlogin[data][renrenid]" class="medium" value="<?php echo ($renrenid); ?>"></td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>Secret Key</td>
            <td><input type="text" name="thdlogin[data][renrenkey]" class="medium" value="<?php echo ($renrenkey); ?>"></td>
            <td class="info"></td>
        </tr>
    </table>
    
<!--    <h3><img src="__PUBLIC__/images/wangwang.gif" width="20px" height="20px">&nbsp;&nbsp;旺旺帐号一键登陆<span class="settitle">旺旺开放平台地址：<a href="http://open.taobao.com/" target="_blank">http://open.taobao.com</a></span></h3>
    <table class="table" style="margin:5px 0 20px 0;line-height:250%">
        <tr>
            <td width="150px">是否开启</td>
            <td width="330px"><input type="radio" name="thdlogin[status][wangwang]" value="1" <?php if($wangwang == '1'): ?>checked="true"<?php endif; ?>> 开启&nbsp;&nbsp;&nbsp;
            <input type="radio" name="thdlogin[status][wangwang]" value="0" <?php if($wangwang == '0'): ?>checked="true"<?php endif; ?>> 关闭</td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>API Key</td>
            <td><input type="text" name="thdlogin[data][wangwangid]" class="medium" value="<?php echo ($wangwangid); ?>"></td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>Secret Key</td>
            <td><input type="text" name="thdlogin[data][wangwangkey]" class="medium" value="<?php echo ($wangwangkey); ?>"></td>
            <td class="info"></td>
        </tr>
    </table>-->
    <h3><img src="__PUBLIC__/images/weixin.png" width="20px">&nbsp;&nbsp;微信扫描二维码登陆<span class="settitle">微信开放平台地址：<a href="http://open.weixin.qq.com" target="_blank">http://open.weixin.qq.com</a></span></h3>
    <table class="table" style="margin:5px 0 20px 0;line-height:250%">
        <tr>
            <td width="150px">是否开启</td>
            <td width="330px"><input type="radio" name="thdlogin[status][wx]" value="1" <?php if($wx == '1'): ?>checked="true"<?php endif; ?>> 开启&nbsp;&nbsp;&nbsp;
            <input type="radio" name="thdlogin[status][wx]" value="0" <?php if($wx == '0'): ?>checked="true"<?php endif; ?>> 关闭</td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>APP ID</td>
            <td><input type="text" name="thdlogin[data][wxid]" class="medium" value="<?php echo ($wxid); ?>"></td>
            <td class="info"></td>
        </tr>
        <tr>
            <td>Secret KEY</td>
            <td><input type="text" name="thdlogin[data][wxkey]" class="medium" value="<?php echo ($wxkey); ?>"></td>
            <td class="info"></td>
        </tr>
    </table>
    <input type="submit" value="提 交" class="btnA" >
    <input type="button" value="取 消" onClick="onUrl('<?php echo U('Admin/Thdlogin/pageSet');?>');" class="btnA" >
</form>


<!--<div class="rightInner">
    <form  method="post" action="<?php echo U('Admin/Thdlogin/doAdd');?>">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">第三方授权登录设置</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first">腾讯APP_ID：</td>
                    <td>
                        <input type="text" name="QQ_ID" id="QQ_ID" class="medium" value="<?php echo ($QQ_ID["sc_value"]); ?>"  /> <br> 
                    </td>
                </tr>
                <tr>
                    <td class="first">腾讯APP_KEY：</td>
                    <td>
                        <input type="text" name="QQ_KEY" id="QQ_KEY" class="medium" value="<?php echo ($QQ_KEY["sc_value"]); ?>"  /><br> 
                    </td>
                </tr>
                <tr>
                    <td class="first">新浪APP_ID：</td>
                    <td>
                        <input type="text" name="SINA_ID" id="SINA_ID" class="medium" value="<?php echo ($SINA_ID["sc_value"]); ?>"  /> <br> 
                    </td>
                </tr>
                <tr>
                    <td class="first">新浪APP_KEY：</td>
                    <td>
                        <input type="text" name="SINA_KEY" id="SINA_KEY" class="medium" value="<?php echo ($SINA_KEY["sc_value"]); ?>"  /><br> 
                    </td>
                </tr>
                <tr>
                    <td class="first">旺旺APP_ID：</td>
                    <td>
                        <input type="text" name="WANGWANG_ID" id="WANGWANG_ID" class="medium" value="<?php echo ($WANGWANG_ID["sc_value"]); ?>" /> <br> 
                    </td>
                </tr>
                <tr>
                    <td class="first">旺旺APP_KEY：</td>
                    <td>
                        <input type="text" name="WANGWANG_KEY" id="WANGWANG_KEY" class="medium" value="<?php echo ($WANGWANG_KEY["sc_value"]); ?>" /><br> 
                    </td>

                </tr>
                <tr>
                    <td class="first">人人网APP_ID：</td>
                    <td>
                        <input type="text" name="RENREN_ID" id="RENREN_ID" class="medium" value="<?php echo ($RENREN_ID["sc_value"]); ?>"/> <br> 
                    </td>
                </tr>
                <tr>
                    <td class="first">人人网APP_KEY：</td>
                    <td>
                        <input type="text" name="RENREN_KEY" id="RENREN_KEY" class="medium" value="<?php echo ($RENREN_KEY["sc_value"]); ?>"/><br> 
                    </td>
                </tr>
                 <tr>
                </tr> 
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="99">
                        <input type="submit" value="提 交" class="btnA" >
                        <input type="button" value="取 消" onClick="onUrl('<?php echo U('Admin/Thdlogin/pageSet');?>');" class="btnA" >
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>-->

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