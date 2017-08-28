<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
    <title><?php echo ($common_title); echo ($page_title); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="<?php echo ($common_keywords); echo ($page_keywords); ?>">
    <meta name="description" content="<?php echo ($common_desc); echo ($page_desc); ?>">
    <meta property="wb:webmaster" content="82baef01ae9c16a4" />
    <meta property="qc:admins" content="23604016463070601356356375" />
    <link href="__PUBLIC__/Lib/jquery/css/base/jquery-ui.css" rel="stylesheet">
    <script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>
    <script src="__PUBLIC__/Lib/jquery/js/jquery.blockUI.js"></script>
    <script src="__PUBLIC__/Lib/jquery/js/jquery-ui-1.9.2.custom.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.validate.1.9.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.metadata.js"></script>
	<script type="text/javascript">var __ROOT = '<?php echo __ROOT__;?>/';</script>
    <script src="__PUBLIC__/Lib/validate/messages_cn.js"></script>
    <script src="__PUBLIC__/Ucenter/js/common.js"></script>
    <link href="__PUBLIC__/Ucenter/css/global.css" rel="stylesheet">
    <link href="__PUBLIC__/Ucenter/css/Cart.css"  rel="stylesheet" />
    <link href="/Public/Lib/thinkbox/css/style.css" rel="stylesheet">
    <script src="/Public/Lib/thinkbox/js/jquery.ThinkBox.min.js"></script>
    <script src="/Public/Lib/jquery/js/jquery-ui-timepicker-addon.js"></script>
    <script src="/Public/Lib/jquery/js/jquery-ui-timepicker-zh-CN.js"></script>
    <script src="__PUBLIC__/Common/js/global.js"></script>
    <script type="text/javascript">
	
    //var _mvq = _mvq || [];
    //_mvq.push(['$setAccount', 'm-24416-0']);

    //_mvq.push(['$logConversion']);
    //(function() {
        //var mvl = document.createElement('script');
        //mvl.type = 'text/javascript'; mvl.async = true;
       // mvl.src = ('https:' == document.location.protocol ? 'https://static-ssl.mediav.com/mvl.js' : 'http://static.mediav.com/mvl.js');
        //var s = document.getElementsByTagName('script')[0];
        //s.parentNode.insertBefore(mvl, s); 
    //})();	

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
    <body>
 		<div class="" id="sideTools">
    <p class="iToTop">
        <a id="iToTop" href="javascript:void(0);" name="dac_index_ycdhsh06" title="回到顶部">
            <s></s>
        </a>
    </p>
</div>
<script>
$(document).ready(function(e) {
	$('#iToTop').click(function(){
		$(document).scrollTop(0);	
	})
});
</script>
<!-- 获取公共信息 -->
<?php $commonInfo = array ( 'GY_IS_FOREIGN' => '1', 'GY_MUST_LOGIN' => NULL, 'GY_SHOP_CODE' => '', 'GY_SHOP_HOST' => 'http://ucenter.wiserar.com/', 'GY_SHOP_ICP' => '', 'GY_SHOP_LOGO' => '', 'GY_SHOP_ONLINE_END' => '18:00', 'GY_SHOP_ONLINE_START' => '9:00', 'GY_SHOP_OPEN' => '1', 'GY_SHOP_QC_LOGO' => '/Public/Uploads/v78/images/20170504141845.png', 'GY_SHOP_SERVER_PHONE' => '', 'GY_SHOP_TITLE' => '分销测试店铺', 'GY_SHOP_TYPE' => '2', ); $cfg = array ( ); $ary_top_ads = array ( ); ?>
<input type="hidden" value="<?php echo ($commonInfo['GY_SHOP_OPEN']); ?>" name ="gy_shop_open" id="gy_shop_open"/>
<script src="__JS__global.js"></script>
<link href="__CSS__global.css" rel="stylesheet">
<script src="__PUBLIC__/Lib/jquery/js/jquery-webox.js"></script>
<link href="__PUBLIC__/Lib/webox/image/jquery-webox.css" rel="stylesheet">
<!--toolbar start-->
<div class="toolbar">
	<div class="main w1192">
		<div class="fl tool-left">
			<div class="tool-node"><a class="node-href" href="/"><i class="icon icon-size-24 icon-back"></i><span>首页</span></a>
			</div>
			<div class="tool-node has-node">
				<a class="node-href" href="###">
					<i class="icon icon-size-18-24 icon-mobile"></i><span>商城二维码</span>
					<i class="icon icon-size-12 icon-arrow"></i>
				</a>
				<div class="node-con">
					<div class="cod">
						<p><img src="<?php echo (C("DOMAIN_HOST")); echo ($commonInfo['GY_SHOP_QC_LOGO']); ?>" width="120" height="120" alt="商城二维码"/></p>
					</div>
				</div>
			</div>
		</div>
		<div class="fr tool-right">
			<div class="tool-node has-node">
				<a class="node-href" href="<?php echo U('/Ucenter/Orders/pageList');?>"><span>我的订单</span><i class="icon icon-size-12 icon-arrow"></i></a>

				<div class="node-con w-all">
					<div class="list service-list">
						<a href="<?php echo U('Ucenter/Orders/pageList','status=3');?>" target="_blank">待支付</a>
						<a href="<?php echo U('Ucenter/Orders/pageList','status=1');?>" target="_blank">待发货</a>
						<a href="<?php echo U('Ucenter/Orders/pageList','status=2');?>" target="_blank">待收货</a>
					</div>
				</div>
			</div>
			<div class="tool-node has-node">
				<a class="node-href" href="<?php echo U('/Ucenter/Index/index');?>"><span>我的小屋</span><i class="icon icon-size-12 icon-arrow"></i></a>

				<div class="node-con w-all">
					<div class="list service-list">
						<a href="<?php echo U('Ucenter/Financial/pageDepositList');?>" target="_blank">我的钱包</a>
						<a href="<?php echo U('Ucenter/Collect/pageList');?>" target="_blank">我的收藏</a>
						<a href="<?php echo U('Ucenter/MyCoupon/pageList');?>" target="_blank">我的卡包</a>
					</div>
				</div>
			</div>
			<div class="tool-node has-node">
				<a class="node-href" href="###">
					<span>服务中心</span><i class="icon icon-size-12 icon-arrow"></i>
				</a>
				<div class="node-con w-all">
					<div class="list service-list">
						<a href="<?php echo U('Home/Article/articleList');?>" target="_blank">帮助中心</a>
						<a href="<?php echo U('Ucenter/Orders/pageList','status=4');?>" target="_blank">退换货</a>
					</div>
				</div>
			</div>
			<div class="tool-node">
				<span id="shopping_member_list">
					<?php if($commonInfo['GY_SHOP_OPEN'] == '0' ): ?><a title="我的账户" style="color:#73B805;" href="<?php echo U('Ucenter/Index/index');?>"><?php echo ($_SESSION['Members']['m_name']); ?></a>
						<a href="/Ucenter/User/doLogout">[安全退出]</a><?php endif; ?>
				</span>
			</div>
			<div class="tool-node has-node cart">
				<a class="node-href" href="<?php echo U('Ucenter/Cart/pageList');?>">
					<i class="icon icon-size-29-24 icon-cart"></i><span>购物车</span>
				</a>
				<div class="node-con cart-con">
					<div class="cartCon" id="shopping_cart_list"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--toolbar end-->
<!--header start-->
<div class="header">
    <div class="hd-top w1192">
        <div class="ef-title">
            <h1 class="logo">
                <a href="<?php echo U('Home/Index/index');?>" class="no-trans">
					<img src="<?php echo (C("DOMAIN_HOST")); echo (($commonInfo['GY_SHOP_LOGO'])?($commonInfo['GY_SHOP_LOGO']):'__IMAGES__logo.png'); ?>" width="177" height="50" />
				</a>
            </h1>
        </div>
        <div class="ef-search">
            <div class="srch-main">
                <p class="fl">
                    <i class="icon icon-size-24 icon-search"></i>
                    <?php if(isset($itemInfo['keyword']) AND $itemInfo["keyword"] != ''): ?><input type="text" class="srch-txt" id="head_serach_keyword" value="<?php echo ($itemInfo["keyword"]); ?>" onblur="if (value=='') {value='搜一搜，更精彩！！！'}" value="搜一搜，更精彩！！！" onfocus="if(value=='搜一搜，更精彩！！！') {value=''}" name="keyword" onkeypress="EnterPress(event)" onkeydown="EnterPress()" />
                        <?php else: ?>
                        <input type="text" class="srch-txt" id="head_serach_keyword" onblur="if (value=='') {value='搜一搜，更精彩！！！'}" value="搜一搜，更精彩！！！" onfocus="if(value=='搜一搜，更精彩！！！') {value=''}" name="keyword" onkeypress="EnterPress(event)" onkeydown="EnterPress()" /><?php endif; ?>
                    <!--<input class="srch-txt" type="text"/>-->
                </p>
                <input class="srch-btn" id="search_submit_button" type="submit" value="搜索" style="cursor: pointer;"/>
            </div>
            <p class="p02">
                热门搜索：
                <?php $nav = NULL; $nav_count = 0; if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><a href="<?php echo ($nav["nurl"]); ?>" target="<?php echo ($nav["ntarget"]); ?>"><?php echo ($nav["nname"]); ?></a><span>|</span><?php endforeach; endif; else: echo "" ;endif; ?>
            </p>
        </div>
        <div class="title-promise"><img src="<?php echo ($ary_top_ads['right_pic']); ?>" width="406" height="40"></div>
    </div>
    <div class="ef-nav">
        <div class="ef-nav-main w1192">
            <div class="all">
                <a href="<?php echo U('/Home/Products/index/');?>" class="all-txt" style="cursor:pointer;">全部商品分类<i class="icon icon-size-16-12 icon-arrow1"></i></a>

                <div class="nav-category">
                    <?php $cateslist = array ( 0 => array ( 'cid' => '1', 'fid' => '0', 'cname' => '收费授权', 'clevel' => '0', 'gc_parent_id' => '0', 'gc_is_display' => '1', 'gc_ad_type' => '0', 'gc_is_hot' => '0', 'gc_pic_url' => '', 'curl' => '/Home/Products/Index/cid/1', ), ); if(is_array($cateslist)): $k = 0; $__LIST__ = $cateslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($k % 2 );++$k;?><dl>
                        <dt>
                        <h2><a href="<?php echo ($cate["curl"]); ?>" style="color: #fff;"><?php echo ($cate["cname"]); ?></a></h2>
                        <p class="nav-category-list">
                            <?php if(isset($cate['sub']) && !empty($cate['sub'])){ foreach($cate['sub'] as $cat){ ?>
                            <a href="<?php echo ($cat["curl"]); ?>" target="_blank"><?php echo ($cat["cname"]); ?></a>
                            <?php }} ?>
                        </p>
                        <b class="nav-line"></b>
                        </dt>
                    </dl><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <ul class="nav">
                <?php $nav = NULL; $nav_count = 0; if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li class="countries current">
                        <a href="<?php echo ($nav["nurl"]); ?>" target="<?php echo ($nav["ntarget"]); ?>" <?php if($_REQUEST['name']== $nav.nname): ?>class="on"<?php endif; ?>><?php echo ($nav["nname"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
<!--header end-->
<script type="text/javascript">
//实现搜索功能
$(function(){
	$("#search_submit_button").click(function(){
		var search_key=$("#head_serach_keyword").val();
		if(search_key==''){return false;}
		search_key=search_key.replace(/%0D%0A/,'');
		search_key=search_key.replace(/%0d%0a/,'');
		var __search_base_url="<?php echo U('Home/Hisense/index');?>?keyword="+search_key;
		window.location.href=__search_base_url;
	});
});
function EnterPress(e){
	var e=e||window.event;
	if(e.keyCode==13){
		var search_key=$("#head_serach_keyword").val();
		if(search_key==''){return false;}
		search_key=search_key.replace(/%0D%0A/,'');
		search_key=search_key.replace(/%0d%0a/,'');
		var __search_base_url="<?php echo U('Home/Hisense/');?>?keyword="+search_key;window.location.href=__search_base_url;
	}
}
</script>
<!-- 判断页面是首页还是其他页面,首页隐藏类目  Start-->
<input type="hidden" value="1" id="is_show_category"/>
<!-- 判断页面是首页还是其他页面,首页隐藏类目 End-->
 		<!-- 用户中心自定义样式修改 -->
<?php if(!empty($ucenter_skin)): ?><style type="text/css">
	.UheaderOne ul li.last a {background:url("<?php echo !empty($ucenter_skin['ICON_PIC']) ? $ucenter_skin['ICON_PIC'] : '/Public/Ucenter/images/UIcon.png'; ?>") no-repeat;}
	.UheaderNavBox ul li a b {background:url("<?php echo !empty($ucenter_skin['ICON_PIC']) ? $ucenter_skin['ICON_PIC'] : '/Public/Ucenter/images/UIcon.png'; ?>") no-repeat;}
	.contentLeft h2 span {background:url("<?php echo !empty($ucenter_skin['ICON_PIC']) ? $ucenter_skin['ICON_PIC'] : '/Public/Ucenter/images/UIcon.png'; ?>") no-repeat; overflow:hidden;}
	.contentLeft ul li a {background:url("<?php echo !empty($ucenter_skin['ICON_PIC']) ? $ucenter_skin['ICON_PIC'] : '/Public/Ucenter/images/UIcon.png'; ?>") no-repeat; background-position: 30px -456px;color: #666;display: block;font: 12px/29px 宋体;overflow: hidden;padding-left: 55px;text-shadow: 0 1px 0 #fff;width: 145px;}
	.contentLeft ul li a.on {background:url("<?php echo !empty($ucenter_skin['NAVON_PIC']) ? $ucenter_skin['NAVON_PIC'] : '/Public/Ucenter/images/UleftNavOn.png'; ?>") no-repeat right top #fff;}
	.contentLeft h2 {background:url("<?php echo !empty($ucenter_skin['LEFT_PIC']) ? $ucenter_skin['LEFT_PIC'] : '/Public/Ucenter/images/lefthbj.png'; ?>") no-repeat;
}
	</style><?php endif; ?>
        <div class="warp" style="margin-top:10px;margin-bottom:50px;">
            <div class="content1200">
                <div class="contentLeft" id="menus">
    <?php if(is_array($menus)): $k = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voMenus1): $mod = ($k % 2 );++$k;?><h2><span class="<?php echo ($tops[$key]['class']); ?>"><?php echo ($tops[$key]['name']); ?></span></h2>
        <?php $second_menus_id = $key; ?>
<!--        <ul class="subMenus" <?php if(($k) != $nav2): ?>style="display:none;"<?php endif; ?> >-->
        <ul class="subMenus" >
            <?php if(is_array($voMenus1)): $i = 0; $__LIST__ = $voMenus1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voMenus2): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($voMenus2["url"]); ?>" <?php if(($key == $nav3) and ($second_menus_id == $nav2)): ?>class="on"<?php endif; ?> ><?php echo ($voMenus2["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
                	<div class="popup weixin">
		<div class="popup-con">
			<h3>应付：<span class="pay">1</span>元</h3>
			<input type="hidden" id="order_no" value="123" />
			<div class="weixin-main">
				<ul>
					<li class="code">
						<div class="weixin-main-code">
					      <img alt="微信扫码支付" src="__APP__/Home/User/qrcode?data=<?php echo ($members["code_url"]); ?>" style="width:180px;height:180px;"/>
				        </div>
				        <div class="weixin-main-txt">微信扫码支付</div>
					</li>
					<li>
						<img src="static/img/pic-weixin.jpg" alt="">
					</li>
				</ul>
			</div>
			<div class="weixin-main-bottom">

			</div>
		</div>
	</div>
<script type="text/javascript">

</script>
            </div>

        </div>
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

window.onload=function(){
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
	
}
</script><?php endif; ?>
</noempty>

    <!-- 底部开始 -->
	<!--ef-footer start-->
<div class="ef-footer ef-footer-ucenter">
    <div class="ef-footer-wrapper w1192 clearfix">
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
			<div class="ef-promise clearfix" class="block"  style="text-align:center;position:relative;" >
				<a href="<?php echo (C("DOMAIN_HOST")); echo ($ary_top_ads['bottom_pic_url']); ?>" class="fl" target="_blank" edit-name="底部logo" linkcontent-editable="true" content-num="1">
					<img style="position:relative;" src="<?php echo ($ary_top_ads['bottom_pic']); ?>" width="348" height="82">
				</a>
			</div>
        </div>
    </div>
</div>
<!--ef-footer end-->
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
    <!-- 底部结束 -->
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
    <div style="width: 1px; height: 1px; overflow: hidden; clear: both;">
    <audio id="reader" src="" autoplay="autoplay" onended="javascript:void(0);" onemptied="javascript:void(0);" onerror="javascript:void(0);" />
</div>
	<script type="text/javascript">
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
        //load();
	</script>
	<script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script>
</body>
</html>