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
							<a href="<?php echo U('Admin/Seo/deleteMemcache');?>" style="float:right;color:#fff;">清空缓存</a>
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
                <p class="tabListP">
	<span value_id="1" class="form_add_products_labels onHover">
		<a href="javascript:void(0);" style="text-decoration: none;">阿里服务器</a>
	</span>
	<span value_id="3" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">七牛服务器</a>
	</span>
	<span value_id="2" class="form_add_products_labels">
		<a href="javascript:void(0);" style="text-decoration: none;">其他服务器</a>
	</span>
</p>
<div class="rightInner">
    <form id="toposs_set" name="toposs_set" method="post" action="<?php echo U('Admin/TopOss/doSetSms');?>">
        <table class="tbForm" width="100%">
            <tbody id="con_addGoods_1">
                <tr>
                    <th colspan="99"></th>
                </tr>
                <tr>
                    <td class="first">是否开启OSS上传</td>
                    <td>						
                        <input id="GY_OSS_ON" type="radio" value="1" name="GY_OSS_ON" <?php if($GY_OSS_ON == '1' ): ?>checked="checked"<?php endif; ?>>
                        <label>是</label>
                        <input id="GY_OSS_ON" type="radio" value="0" name="GY_OSS_ON" <?php if($GY_OSS_ON == '0' ): ?>checked="checked"<?php endif; ?>>
                        <label>否</label>
                    </td>
                    <td class="last"></td>
                </tr>
                
                <tr style="display:none;">
                    <td class="first">是否上传缩略图</td>
                    <td>
                        <input id="GY_OSS_THUMB_ON" type="radio" value="1" name="GY_OSS_THUMB_ON" <?php if($GY_OSS_THUMB_ON == '1' ): ?>checked="checked"<?php endif; ?>>
                        <label>是</label>
                        <input id="GY_OSS_THUMB_ON" type="radio" value="0" name="GY_OSS_THUMB_ON" <?php if($GY_OSS_THUMB_ON == '0' ): ?>checked="checked"<?php endif; ?>>
                        <label>否</label>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">是否开启自动上传</td>
                    <td>
                        <input id="GY_OSS_AUTO_ON" type="radio" value="1" name="GY_OSS_AUTO_ON" <?php if($GY_OSS_AUTO_ON == '1' ): ?>checked="checked"<?php endif; ?>>
                        <label>是</label>
                        <input id="GY_OSS_AUTO_ON" type="radio" value="0" name="GY_OSS_AUTO_ON" <?php if($GY_OSS_AUTO_ON == '0' ): ?>checked="checked"<?php endif; ?>>
                        <label>否</label>
                    </td>
                    <td class="last"></td>
                </tr>                
                <tr>
                    <td class="first"><font class="red">*</font>OSS的Bucket名称</td>
                    <td>
                        <input type="text" name="GY_OSS_BUCKET_NAME"　id="GY_OSS_BUCKET_NAME"  class="medium" value="<?php echo ($GY_OSS_BUCKET_NAME); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><font class="red">*</font>OSS的Access ID</td>
                    <td>
                        <input type="text" name="GY_OSS_ACCESS_ID" id="GY_OSS_ACCESS_ID"  class="medium" value="<?php echo ($GY_OSS_ACCESS_ID); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><font class="red">*</font>OSS的Access Key</td>
                    <td>
                        <input type="password" name="GY_OSS_ACCESS_KEY" id="GY_OSS_ACCESS_KEY"  class="medium" value="<?php echo ($GY_OSS_ACCESS_KEY); ?>"  />
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first">负载均衡指定图片服务器</td>
                    <td>
                        <input type="text" name="GY_OSS_PIC_URL" id="GY_OSS_PIC_URL"  class="medium" value="<?php echo ($GY_OSS_PIC_URL); ?>"  />
                    </td>
                    <td class="last"></td>
                </tr>   
                <tr>
                    <td class="first">静态资源域名(CNAME)</td>
                    <td>
                        <input type="text" name="GY_OSS_CNAME_URL" id="GY_OSS_CNAME_URL"  class="medium" value="<?php echo ($GY_OSS_CNAME_URL); ?>"  />
                    </td>
                    <td class="last"></td>
                </tr>   				
            </tbody>
			
			<tbody id="con_addGoods_3" style="display:none;">
                <tr>
                    <th colspan="99"></th>
                </tr>
                <tr>
                    <td class="first">是否开启七牛上传</td>
                    <td>						
                        <input id="GY_QN_ON" type="radio" value="1" name="GY_QN_ON" <?php if($GY_QN_ON == '1' ): ?>checked="checked"<?php endif; ?>>
                        <label>是</label>
                        <input id="GY_QN_ON" type="radio" value="0" name="GY_QN_ON" <?php if($GY_QN_ON == '0' ): ?>checked="checked"<?php endif; ?>>
                        <label>否</label>
                    </td>
                    <td class="last"></td>
                </tr>
                
                <tr>
                    <td class="first"><font class="red">*</font>bucket</td>
                    <td>
                        <input type="text" name="GY_QN_BUCKET_NAME"　id="GY_QN_BUCKET_NAME"  class="medium" value="<?php echo ($GY_QN_BUCKET_NAME); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><font class="red">*</font>access Key</td>
                    <td>
                        <input type="text" name="GY_QN_ACCESS_KEY" id="GY_QN_ACCESS_KEY"  class="medium" value="<?php echo ($GY_QN_ACCESS_KEY); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
				<tr>
                    <td class="first"><font class="red">*</font>secrect Key</td>
                    <td>
                        <input type="text" name="GY_QN_SECRECT_KEY" id="GY_QN_SECRECT_KEY"  class="medium" value="<?php echo ($GY_QN_SECRECT_KEY); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><font class="red">*</font>domain</td>
                    <td>
                        <input type="text" name="GY_QN_DOMAIN" id="GY_QN_DOMAIN"  class="medium" value="<?php echo ($GY_QN_DOMAIN); ?>"  />
                    </td>
                    <td class="last"></td>
                </tr> 				
            </tbody>

            <tbody id="con_addGoods_2" style="display:none;">
                <tr>
                    <th colspan="99"></th>
                </tr>
                
                <tr>
                    <td class="first">是否开启上传</td>
                    <td>						
                        <input id="GY_OTHER_ON" type="radio" value="1" name="GY_OTHER_ON" <?php if($GY_OTHER_ON == '1' ): ?>checked="checked"<?php endif; ?>>
                        <label>是</label>
                        <input id="GY_OTHER_ON" type="radio" value="0" name="GY_OTHER_ON" <?php if($GY_OTHER_ON == '0' ): ?>checked="checked"<?php endif; ?>>
                        <label>否</label>
                    </td>
                    <td class="last"></td>
                </tr>
                
                <tr>
                    <td class="first"><font class="red">*</font>服务器IP</td>
                    <td>
                        <input type="text" name="GY_OTHER_IP" id="GY_OTHER_IP"  class="medium" value="<?php echo ($GY_OTHER_IP); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
                
                <tr>
                    <td class="first"><font class="red">*</font>服务器域名</td>
                    <td>
                        <input type="text" name="GY_OTHER_DOMAIN" id="GY_OTHER_DOMAIN"  class="medium" value="<?php echo ($GY_OTHER_DOMAIN); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
                
                <tr>
                    <td class="first"><font class="red">*</font>模板地址</td>
                    <td>
                        <input type="text" name="GY_TPL_IP" id="GY_TPL_IP"  class="medium" value="<?php echo ($GY_TPL_IP); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>
	            <tr>
                    <td class="first"><font class="red"></font>静态资源域名1</td>
                    <td>
                        <input type="text" name="GY_STATE_URL1" id="GY_STATE_URL1"  class="medium" value="<?php echo ($GY_STATE_URL1); ?>" />
                    </td>
                    <td class="last">如果设置多个静态资源域名，前台显示则随机读取一个静态域名</td>
                </tr>
                <tr>
                    <td class="first"><font class="red"></font>静态资源域名2</td>
                    <td>
                        <input type="text" name="GY_STATE_URL2" id="GY_STATE_URL2"  class="medium" value="<?php echo ($GY_STATE_URL2); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>	
                <tr>
                    <td class="first"><font class="red"></font>静态资源域名3</td>
                    <td>
                        <input type="text" name="GY_STATE_URL3" id="GY_STATE_URL3"  class="medium" value="<?php echo ($GY_STATE_URL3); ?>" />
                    </td>
                    <td class="last"></td>
                </tr>					
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="99">
                        <input type="button" value="保 存" class="btnA" >
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
</div>
<script>
    $(document).ready(function(){
        $('.btnA').click(function(){ 
            var url = "<?php echo U('Admin/TopOss/doSet');?>";
            var data = $('#toposs_set').serialize();
            ajaxReturn(url,data);
        });
        
        $(".form_add_products_labels").click(function(){
            //所有隐藏
            $("#con_addGoods_1,#con_addGoods_2,#con_addGoods_3").hide();
            $(".form_add_products_labels").removeClass("onHover");
            //获取当前页签的ID
            $("#con_addGoods_" + $(this).attr("value_id")).show();
            $(this).addClass("onHover");
            return true;
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
        <script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script>
    </body>
</html>