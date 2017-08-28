<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
<?php $commonInfo = array ( 'GY_IS_FOREIGN' => '1', 'GY_MUST_LOGIN' => NULL, 'GY_SHOP_CODE' => '', 'GY_SHOP_HOST' => 'http://demo.pdftoword.cqttech.com/', 'GY_SHOP_ICP' => '', 'GY_SHOP_LOGO' => '', 'GY_SHOP_ONLINE_END' => '18:00', 'GY_SHOP_ONLINE_START' => '9:00', 'GY_SHOP_OPEN' => '1', 'GY_SHOP_QC_LOGO' => '/Public/Uploads/v78/images/20170504141845.png', 'GY_SHOP_SERVER_PHONE' => '', 'GY_SHOP_TITLE' => 'pdf在线转换', 'GY_SHOP_TYPE' => '2', ); $cfg = array ( ); $ary_top_ads = array ( ); ?>
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
			<div style="clear:both;"></div>
            <div class="HXwarp" id="main">
                <div class="area">
                    <div class="content960"><!--content960 col  start-->
                        <?php if(isset($error)): ?><div class="wright"><!--wright  start-->
                            <!--<strong>用户名或密码错误！</strong>
                            <p>页面自动 跳转 等待时间： <span>1</span> 秒</p>-->
                            
                            <strong><?php echo($error); ?><br>页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></strong>
                        </div><!--wright  end-->
                        <?php else: ?>
                        <div class="wright ri"><!--wright  start-->
                            <!--<strong>用户名或密码错误！</strong>
                            <p>页面自动 跳转 等待时间： <span>1</span> 秒</p>-->
                            
                            <strong><?php echo($message); ?><br>页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></strong>
                        </div><!--wright  end--><?php endif; ?>
                    </div><!--content960 col  start-->
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
    <?php $footerTpl = FXINC . '/Public/Tpl/' . CI_SN . '/' . $_SESSION['NOW_TPL'] . '/custom/ucenterFooter.html'; ?>
	
    <!-- 底部结束 -->
</body>
<script type="text/javascript"> 
(function(){
var wait = $('#wait'),href = $('#href').attr('href');

var interval = setInterval(function(){
	var time = wait.html();
	time = parseInt(time) - 1;
    //IE7下不能将int数组放入html中
    time = time.toString();
    wait.html(time);
	if(time == 0 || isNaN(time)) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</html>