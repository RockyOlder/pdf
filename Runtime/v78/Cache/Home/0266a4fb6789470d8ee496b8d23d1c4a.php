<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title><?php echo ($page_title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="keywords" content="<?php echo ($page_keywords); ?>">
        <meta name="description" content="<?php echo ($page_description); ?>">
        <link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
        <script type="text/javascript" src="js/jquery1_11.js" ></script>
	<script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/html5.js" ></script>
	<script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/webupload/webuploader.js" ></script>
	<script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/jquery/xcConfirm.js" ></script>
	<script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/main.js" ></script>
        <link rel="stylesheet" type="text/css" href="__CSS__webuploader.css">
	<link rel="stylesheet" type="text/css" href="__CSS__style.css">
	<link rel="stylesheet" type="text/css" href="__CSS__loaders.css"/>
	<link rel="stylesheet" type="text/css" href="__CSS__xcConfirm.css"/>
<!--		<link href="__CSS__global.css" rel="stylesheet">
		<link href="__PUBLIC__/Lib/jquery/css/base/jquery-ui.css" rel="stylesheet">
		<script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>-->
<!--		<?php if(TPL != 'tmall' && TPL != 'blue' && TPL != 'bimai'){ ?>
		<script src="__JS__global.js"></script>
		<?php } ?>-->
		<!--<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-1.9.2.custom.js"></script>-->
		<!--<script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/jquery.lazyload.js"></script>-->
		<!--<script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script>-->		
<!--		<?php if($ary_request[index]== true){ ?>
			可视化编辑 start
			<link href="__PUBLIC__/Lib/jquery/css/jquery.slideshow.css" rel="stylesheet">
			<script src="__PUBLIC__/Lib/jquery/js/jquery.slideshow.js"></script>
			可视化编辑 end
		<?php } ?>		
		<?php if(TPL == 'blue' || TPL == 'tmall' || TPL == 'bimai' || TPL == 'chaopin' || TPL == 'self'){ ?>
			<link href="__PUBLIC__/Lib/thinkbox/css/style.css" rel="stylesheet">
			<script src="__PUBLIC__/Lib/validate/jquery.validate.1.9.js"></script>
			<script src="__PUBLIC__/Lib/validate/jquery.metadata.js"></script>
			<script src="__PUBLIC__/Lib/validate/messages_cn.js"></script>
			<script src="__PUBLIC__/Ucenter/js/passport.js"></script>
			<script src="__PUBLIC__/Lib/jquery/js/jquery.etalage.min.js"></script>
			<script src="__PUBLIC__/Lib/jquery/js/jquery.blockUI.js"></script>
			<script src="__PUBLIC__/Lib/jquery/js/jquery-webox.js"></script>
			<link href="__PUBLIC__/Lib/webox/image/jquery-webox.css" rel="stylesheet">
			<script src="__PUBLIC__/Lib/thinkbox/js/jquery.ThinkBox.min.js"></script>
			<link href="__PUBLIC__/Admin/css/etalage.css" rel="stylesheet">
			 标准模板只有一个js文件js.js,css文件style.css Start
			<script src="__JS__js.js"></script>
			<link href="__CSS__style.css" rel="stylesheet">
			 标准模板只有一个js文件js.js,css文件style.css End
		<?php } ?>-->
    </head>
	<body id="goTop" onload="RunOnBeforeUnload()">
	    	<div class="header">
		<div class="wrapper clearfix">
			<a href="http://www.cqttech.com/" class="logo f_l" target="_blank"><i></i><h1>悦书PDF阅读器</h1></a>
			<div class="nav f_r">
				<a href="http://www.cqttech.com/" target="_blank">官网</a>
				<a href="http://bbs.cqttech.com/forum.php" target="_blank">论坛</a>
			</div>
		</div>
	</div>
	    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>404-对不起！您访问的页面不存在</title>
<style type="text/css">
.head404{ width:580px; height:234px; margin:50px auto 0 auto; background:url(/Public/images/head404.png) no-repeat; }
.txtbg404{ width:499px; height:169px; margin:10px auto 0 auto; background:url(/Public/images/txtbg404.png) no-repeat;}
.txtbg404 .txtbox{ width:390px; position:relative; top:30px; left:60px;color:#eee; font-size:13px;}
.txtbg404 .txtbox p {margin:5px 0; line-height:18px;}
.txtbg404 .txtbox .paddingbox { padding-top:15px;}
.txtbg404 .txtbox p a { color:#eee; text-decoration:none;}
.txtbg404 .txtbox p a:hover { color:#FC9D1D; text-decoration:underline;}
</style>
</head>

<body bgcolor="#494949">
	<div class="head404"></div>
	<div class="txtbg404">
  	<div class="txtbox">
    	<p>对不起，您请求的页面不存在、或已被删除、或暂时不可用</p>
      
      <p class="paddingbox">请点击以下链接继续浏览网页</p>
      <p>》<a style="cursor:pointer" onclick="history.back()">返回上一页面</a></p>
      <p>》<a href="/">返回网站首页</a></p>
    </div>
  </div>
</body>
</html>

        <?php if(TPL!='sky'){ ?>
	    <noempty name="ary_online">
<style>
/*在线咨询   开始*/
.cusService { display:inline-block; position:fixed; left:0px; top:200px;}
.cusServiceCon { float:left; width:180px; border:1px solid #d7d7d7; background:white; display:none}
.cusServiceCon table { width:100%}
.cusServiceCon table thead td { border-bottom:1px solid #d7d7d7; color:#333; font-size:14px; text-shadow:1px 1px 3px #999;}
.cusServiceCon table td { padding:5px 0px; line-height:23px; padding-left:10px;}
.cusServiceCon table td.addBorder { border-top:1px dashed #d7d7d7;}
.cusServiceCon table td a { display:inline-block; white-space:nowrap}
.cusServiceCon table td span { position:relative; margin-left: 4px;}
.cusServiceCon table td a:hover { text-decoration:none; color:red;}
.cusServiceCon table tfoot td { border-top:1px sold #d7d7d7;}
a.cusSerClick { float:left; background:url(__PUBLIC__/Ucenter/images/customerService.jpg) no-repeat 0px -124px; width:42px; height:124px;}
a.cusSerClickAgain { background-position:0px 0px;}
/*在线咨询   结束*/
</style>
<?php if(isset($ary_online)): ?><div class="cusService" style="z-index:100"><!--cusService  客服 start-->
	<div class="cusServiceCon" id="cusCon">
    	<table>
        	<thead>
            	<tr>
                	<td><strong>在线咨询</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($ary_online)): $i = 0; $__LIST__ = $ary_online;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$online): $mod = ($i % 2 );++$i;?><tr><td align="center"><strong><?php echo ($online["oc_name"]); ?></strong></td></tr>
                <?php if(is_array($online["server"])): $i = 0; $__LIST__ = $online["server"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$server): $mod = ($i % 2 );++$i;?><tr>
                	<td>
                    	<?php echo ($server["o_code"]); ?><span><?php echo ($server["o_name"]); ?></span>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <tfoot>
            	<tr>
                	<td style="border-top:1px solid #d7d7d7;">在线时间：<?php echo (($online_start_time)?($online_start_time):'9:00'); ?>-<?php echo (($online_end_time)?($online_end_time):'18:00'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <a href="javascript:void(0)" class="cusSerClick" id="azx" style="display:block"></a>
</div><!--cusService  end-->
<script type="text/javascript">
/*$(function(){
	$("a.cusSerClick").hover(function(){
		$(".cusServiceCon").show();
		$(this).css("babkgroundPosition":"0px 0px")
	},function(){
		$(".cusServiceCon").hide();
		$(this).css("babkgroundPosition":"0px -124px")
	})
});*/

//window.onload=function(){
	var azx=document.getElementById('azx');
	var cus=document.getElementById('cusCon');
	
	azx.onclick=function(){
		if(cus.style.display=='block'){
			cus.style.display='none'
			this.style.backgroundPosition='0px -124px';
		}else {
			cus.style.display='block';
			this.style.backgroundPosition='0px 0px'
		}
	}
	
//}
</script><?php endif; ?>
</noempty>

        <?php } ?>
	    	<div class="footer">
		<div class="wrapper">
			<p>公司地址：深圳市南山区科苑路16号东方科技大厦1906  &nbsp;&nbsp;E-mail：<a href="mailto:ivy.tech@cqttech.com" target="_blank">ivy.tech@cqttech.com</a> &nbsp;&nbsp;网址：<a href="http://www.cqttech.com" target="_blank">http://www.cqttech.com</a></p>
			<p>Copyright (C) 2016  IVY Tec. All Rights Reserved.</p>
			<p>商务QQ：<a target=\"_blank\" href="http://wpa.qq.com/msgrd?v=3&uin=3004139668&site=qq&menu=yes">3004139668</a>  | 产品QQ：<a target=\"_blank\" href="http://wpa.qq.com/msgrd?v=3&uin=3004198912&site=qq&menu=yes">3004198912</a>  | 客服QQ：<a target=\"_blank\" href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes">3004137938</a></p>
			<div class="safety">
				<a href="http://www.12377.cn/" target="_blank"><i class="icon_safe1"></i>中国互联网举报中心</a>
				<a href="http://www.cyberpolice.cn/wfjb/" target="_blank"><i class="icon_safe2"></i>网络违法举报中心</a>
				<a href="http://www.12321.cn/" target="_blank"><i class="icon_safe3"></i>垃圾信息举报中心</a>
				<a href="http://www.miibeian.gov.cn/" target="_blank"><i class="icon_safe5"></i>备案号粤：ICP备14091133号-1</a>
			</div>
			<div class="companyLogo">
				
					<h3>深圳常青藤科技有限公司</h3>
					<p>IVY (ShenZhen) Software Technology Co., Ltd.</p>
			</div>
		</div>
	</div>
<!--ef-footer start
<div class="ef-footer">
    <div class="ef-footer-wrapper clearfix">
        <div class="ef-desc">
			<div class="ef-desc-detail clearfix">
			
                <?php $artcat = array ( ); if(is_array($artcat)): $keys = 0; $__LIST__ = $artcat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$arts): $mod = ($keys % 2 );++$keys;?><dl class="ef-newer">
							<dt><?php echo ($arts["cat_name"]); ?></dt>
							<?php if(is_array($arts["list"])): $k = 0; $__LIST__ = $arts["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$artinfo): $mod = ($k % 2 );++$k; if($k <= 4): ?><dd>
									<div style="width:10px;height:10px;float:left" <?php if($artinfo["hot"] == '1'): ?>class="hot2"<?php endif; ?>></div>
									<a name="hwg_none_yw_fw01" target="_blank" href="<?php echo ($artinfo["aurl"]); ?>">
									<?php echo ($artinfo["a_title"]); ?>
									</a>
								</dd><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</dl><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="ef-promise clearfix" style="text-align:center;position:relative;" >
                <a href="<?php echo (C("DOMAIN_HOST")); echo ($ary_top_ads['bottom_pic_url']); ?>" class="fl" target="_blank" edit-name="底部logo" linkcontent-editable="true" content-num="1">
                    <img style="position:relative;" src="<?php echo ($ary_top_ads['bottom_pic']); ?>" width="348" height="82">
                </a>
            </div>
        </div>
    </div>
</div>
		
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
<div align="center" style="background:#EBEBEB"> 
	<?php echo (($commonInfo['GY_SHOP_ICP'])?($commonInfo['GY_SHOP_ICP']):'Copyright © 2009-2016 沪ICP备：12035449号-2'); ?>
</div> 
ef-footer end-->
		<?php if($_SESSION['OSS']['GY_OSS_ON'] == '1'){ ?>
			<input type="hidden" value="1" id="oss_id" />
		<?php }else{ ?>
			<input type="hidden" value="0" id="oss_id" />
		<?php } ?>
		<?php if($ary_request[index]== true){ ?>
		<input type="hidden" id="is_index" value="1" />
		<?php }else{ ?>	
		<input type="hidden" id="is_index" value="0" />
		<?php } ?>
	    <!-- 是否有统计代码,有则显示  Start-->
		<?php if(isset($shop_code)): ?><noempty name="shop_code">
	    	<?php echo ($shop_code); ?>
	    </noempty><?php endif; ?>
	    <!-- 是否有统计代码，有则显示 End-->
	</body>
</html>