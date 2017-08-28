<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title><?php echo ($page_title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="keywords" content="<?php echo ($page_keywords); ?>">
        <meta name="description" content="<?php echo ($page_description); ?>">
        <link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
		<link href="__CSS__global.css" rel="stylesheet">
		<link href="__PUBLIC__/Lib/jquery/css/base/jquery-ui.css" rel="stylesheet">
		<script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>
		<?php if(TPL != 'tmall' && TPL != 'blue' && TPL != 'bimai'){ ?>
		<script src="__JS__global.js"></script>
		<?php } ?>
		<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-1.9.2.custom.js"></script>
		<!--<script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/jquery.lazyload.js"></script>-->
		<script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script>		
		<?php if($ary_request[index]== true){ ?>
			<!--可视化编辑 start-->
			<link href="__PUBLIC__/Lib/jquery/css/jquery.slideshow.css" rel="stylesheet">
			<script src="__PUBLIC__/Lib/jquery/js/jquery.slideshow.js"></script>
			<!--可视化编辑 end-->
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
			<!-- 标准模板只有一个js文件js.js,css文件style.css Start-->
			<script src="__JS__js.js"></script>
			<link href="__CSS__style.css" rel="stylesheet">
			<!-- 标准模板只有一个js文件js.js,css文件style.css End-->
		<?php } ?>
    </head>
	<body id="goTop">
	    <!-- 获取公共信息 -->
<?php $commonInfo = array ( 'GY_SHOP_CODE' => '', 'GY_SHOP_HOST' => 'http://test001.abcde.com:8071/', 'GY_SHOP_ICP' => '', 'GY_SHOP_LOGO' => '', 'GY_SHOP_OPEN' => '1', 'GY_SHOP_TITLE' => '分销测试店铺', ); $cfg = array ( ); $ary_top_ads = array ( ); ?>
<!--头部 开始-->
<div id="header" class="header">
	<!--headerOne 开始-->
	<div class="headerOne">
		<div class="content1000">
			<span id="shopping_member_list">您好，
				<a href="<?php echo U('Home/User/login');?>">[<strong>请登录</strong>]</a><a href="<?php echo U('Home/User/pageRegister');?>">[免费注册]</a>
		    </span>
            <p>
                <a href="<?php echo U('Ucenter/Index/index');?>" target="_blank" class="myAccount">我的账户</a>|
                <a onclick="SetHome(window.location)" href="javascript:void(0)"> 设为首页 </a>|
                <a onclick="AddFavorite(window.location,document.title)" href="javascript:void(0)">加入收藏</a >|
                <a href="<?php echo U('Home/Article/articleDetail',array('aid'=>'2'));?>">联系我们</a>|
                <a href="<?php echo U('Home/Article/articleDetail',array('aid'=>'1'));?>">关于我们</a>
                <a target="_blank" class="weibo" href="http://e.weibo.com/guanyisoft" target="_blank">新浪微博</a>                
				<a target="_blank" class="txweibo" href="http://t.qq.com/guanyisoft" target="_blank">腾讯微博</a> 
            </p>
        </div>
    </div><!--headerOne 结束-->
    <!--headerTwo 开始-->
    <div class="headerTwo">
    	<div class="content1000">
    		<h1><a href="/"><img src="<?php echo (C("DOMAIN_HOST")); echo ($commonInfo['GY_SHOP_LOGO']); ?>" width="250" height="60" style="border:0"></a></h1>
            <!--sch 开始-->
            <div class="sch">
            	<!--schTop 开始-->
            	<div class="schTop">
            		<!-- 购物车 Start -->
            		<div class="shopcartCon">
						<span class="goj" onMouseOver="this.className='gojOver'" onMouseOut="this.className='goj'" id="shopping_cart_list"></span>
					</div><!--shopcartCon 结束-->
					<!-- 购物车 End -->
					<!-- 商品搜索 Start -->
                    <p class="schTop">
		             	 <span>
						 
	                        <?php if($itemInfo["keyword"] != ''): ?><input type="text" class="txt" id="head_serach_keyword" value="<?php echo ($itemInfo["keyword"]); ?>" onblur="if (value=='') {value='搜搜呗....说不定有您喜欢的...'}" value="搜搜呗....说不定有您喜欢的..." onfocus="if(value=='搜搜呗....说不定有您喜欢的...') {value=''}" name="keyword" onkeypress="EnterPress(event)" onkeydown="EnterPress()" />
	                        <?php else: ?>
	                        <input type="text" class="txt" id="head_serach_keyword" onblur="if (value=='') {value='搜搜呗....说不定有您喜欢的...'}" value="搜搜呗....说不定有您喜欢的..." onfocus="if(value=='搜搜呗....说不定有您喜欢的...') {value=''}" name="keyword" onkeypress="EnterPress(event)" onkeydown="EnterPress()" /><?php endif; ?>
	                     </span>
	                     <input type="submit" id="search_submit_button" value="搜索" class="sub">
                    </p>
                    <!-- 商品搜索 End -->
                </div><!--schTop 结束-->
                <!-- 热门搜索 Start -->
                <p class="hotSch">
                	<strong>热门搜索：</strong>
	                <?php $nav = NULL; $nav_count = 0; if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><a href="<?php echo ($nav["nurl"]); ?>" target="<?php echo ($nav["ntarget"]); ?>"><?php echo ($nav["nname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                </p>
                <!-- 热门搜索 End -->
            </div><!--sch 结束-->
       	</div>
    </div><!--headerTwo 结束-->
    <!--headerThree 开始-->
    <div class="headerThree">
    	<div class="content1000">
        	<!--allGoods 开始-->
    		<div class="allGoods" >
            	<a href="<?php echo U('Home/Products/Index');?>" class="nolink"><h2>所有商品分类</h2></a>
                <!--allGoodsCon 开始-->
                <div class="allGoodsCon allGoodshide" id="category_show">
                	<ul>
                		<?php $cateslist = array ( ); if(is_array($cateslist)): $k = 0; $__LIST__ = $cateslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($k % 2 );++$k;?><li>
                        	<dl>
                                <dt><a href="<?php echo ($cate["curl"]); ?>"><?php echo ($cate["cname"]); ?></a></dt>
                                <dd>
                                <!-- 显示2级子类目 -->
								<?php if(isset($cate['sub'])): if(is_array($cate['sub'])): $i = 0; $__LIST__ = $cate['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i; if($key < 5): ?><a href="<?php echo ($cat["curl"]); ?>"><?php echo ($cat["cname"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                                </dd>
                            </dl>
                            <i></i>
							<?php if(isset($cate['sub'])): if(count($cate['sub']) > 5): ?><!-- 显示3级子类目 -->
                            <div class="allSorts">
                            	<?php if(is_array($cate['sub'])): $i = 0; $__LIST__ = $cate['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><a href="<?php echo ($cat["curl"]); ?>"><?php echo ($cat["cname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div><?php endif; endif; ?>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div><!--allGoodsCon 结束-->
        	</div><!--allGoods 结束-->
            <ul class="mainNav">
                <?php $nav = NULL; $nav_count = 0; if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li><a <?php if(isset($_REQUEST['name'])): if(($_REQUEST['name']) == $nav['nname']): ?>class="on"<?php endif; endif; ?> href="<?php echo ($nav["nurl"]); ?>" target="<?php echo ($nav["ntarget"]); ?>"><?php echo ($nav["nname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div><!--headerThree 结束-->
</div>
<!--头部 结束-->
<script type="text/javascript">
$(function(){
	//实现搜索功能
    $("#search_submit_button").click(function(){
        var search_key = $("#head_serach_keyword").val();
        if(search_key == ''){
            return false;
        }
        search_key = search_key.replace(/%0D%0A/,'');
        search_key = search_key.replace(/%0d%0a/,'');
        var __search_base_url = "<?php echo U('Home/Hisense/');?>?keyword="+ search_key;
        window.location.href = __search_base_url;
    });
});
function EnterPress(e){ //传入 event 
    var e = e || window.event; 
    if(e.keyCode == 13){ 
        var search_key = $("#head_serach_keyword").val();
        if(search_key == ''){
            return false;
        }
        search_key = search_key.replace(/%0D%0A/,'');
        search_key = search_key.replace(/%0d%0a/,'');
        var __search_base_url = "<?php echo U('Home/Hisense/');?>?keyword="+ search_key;
        window.location.href = __search_base_url;
    } 
}
</script>
<!-- 页面加载获取购物车信息 Start-->
<script src="__JS__function.js"></script>
<!-- 页面加载获取购物车信息 End-->
	    <!--中间内容 开始--->
<div id="main">
    <div class="warp">
        <div><!--area  start--> 
            <div ><!--col  start-->    
                <div class="content1000"><!--content1000   start-->
                    <!--焦点图开始-->
                    <div class="banner area">
                        <div class="indexcss blocss">
                        	<!-- 可视化轮播图片编辑  Start-->
                        	<div class="col">
	                        	<div class="index_show_html block" block-dat='{"imagecontent":{"2":"__TPL__demo/img01.png","4":"__TPL__demo/img02.png","6":"__TPL__demo/img01.png","8":"__TPL__demo/img02.png","10":"__TPL__demo/img01.png"}}'>
		                            <div class="container" id="main1">
		                                <ul class="slider" id="Lb_show">
				                            <li><a href="#" target="_blank" edit-name="图片1链接" linkcontent-editable="true" content-num="1"><img src="__TPL__demo/img01.png" edit-name="展示图片1" imagecontent-editable="true" content-num="2" imagestyle-editable="true" style-num="1" /></a></li>
			                                <li><a href="#" target="_blank" edit-name="图片2链接" linkcontent-editable="true" content-num="3"><img src="__TPL__demo/img02.png" edit-name="展示图片2" imagecontent-editable="true" content-num="4" imagestyle-editable="true" style-num="1"  /></a></li>
			                                <li><a href="#" target="_blank" edit-name="图片3链接" linkcontent-editable="true" content-num="5"><img src="__TPL__demo/img01.png" edit-name="展示图片3" imagecontent-editable="true" content-num="6" imagestyle-editable="true" style-num="1"  /></a></li>
			                                <li><a href="#" target="_blank" edit-name="图片4链接" linkcontent-editable="true" content-num="7"><img src="__TPL__demo/img02.png" edit-name="展示图片4" imagecontent-editable="true" content-num="8" imagestyle-editable="true" style-num="1"  /></a></li>
			                                <li><a href="#" target="_blank" edit-name="图片5链接" linkcontent-editable="true" content-num="9"><img src="__TPL__demo/img01.png" edit-name="展示图片5" imagecontent-editable="true" content-num="10" imagestyle-editable="true" style-num="1"  /></a></li>
		                                </ul>
		                            </div>
		                        </div>
                        	</div>
	                        <!-- 可视化轮播图片编辑 End-->
                            <ul class="num" id="Lb_button">
                                <li class="on"><a href="#" target="_blank"></a></li>
                                <li><a href="#" target="_blank"></a></li>
                                <li><a href="#" target="_blank"></a></li>
                                <li><a href="#" target="_blank"></a></li>
                                <li><a href="#" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div><!--焦点图 end-->
                    <!--mainCon开始-->
					<div class="area">
					   <div class="col">
		                    <div class="mainCon">
		                        <!--mainConL开始-->
		                        <div class="mainConL">
		                            <div class="show_common_html" >
		                            	<div class="news">
		                            		<p><span onMouseOver="setTab('navS',1,2)" id="navS1" >品牌资讯</span><span onMouseOver="setTab('navS',2,2)" id="navS2" class="onHover">最新快报</span></p>
			                                <div class="index_article_list block" block-dat='{"cid":"2","num":"4","textcontent":{},"imagecontent":{},"linkcontent":{}}' id="con_navS_1" style="display:none;">
						                        <?php $art = array ( ); $pageinfo['art'] = ''; $pagearr['art'] = ''; if(is_array($art)): $i = 0; $__LIST__ = $art;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$artinfo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($artinfo["aurl"]); ?>"><?php echo ($artinfo["atitle"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
			                                </div>
			                                <div class="index_notice_list block" block-dat='{"num":"4","textcontent":{},"imagecontent":{},"linkcontent":{}}' id="con_navS_2" style="display:blocss;">
						                        <?php $noticelist = array ( ); if(is_array($noticelist)): $i = 0; $__LIST__ = $noticelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$note): $mod = ($i % 2 );++$i;?><a href="<?php echo ($note["pnurl"]); ?>"><?php echo ($note["pntitle"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
			                                </div>
		                            	</div>
		                            </div>
		                            <p class="block"><a href="#" edit-name="广告图链接" linkcontent-editable="true" content-num="1"><img src="__TPL__demo/pic01.png" width="220" height="165" edit-name="广告图" imagecontent-editable="true" content-num="2" imagestyle-editable="true" style-num="1"></a></p>
		                        </div><!--mainConL 结束-->
		                        
		                        <!--mainConR开始-->
		                        <div class="mainConR">
		                            <!--mainConRA开始-->
		                            <div class="mainConRA">
		                                <p>
		                                    <span onMouseOver="setTab('navSt',1,5)" id="navSt1">新品专区 </span>
		                                    <span onMouseOver="setTab('navSt',2,5)" id="navSt2" class="onHover">热销排行</span>
		                                    <span onMouseOver="setTab('navSt',3,5)" id="navSt3">推荐专区</span>
		                                    <span onMouseOver="setTab('navSt',4,5)" id="navSt4">特价专区</span>
		                                    <span onMouseOver="setTab('navSt',5,5)" id="navSt5">猜你喜欢</span>
		                                </p>
		                                <!--products开始-->

			        <div class="products" id="con_navSt_1" style="display:none;">
			           <div class="index_product_list_H block" block-dat='{"num":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"15","g_instead":"...","textcontent":{"1":"新品专区"},"imagecontent":{"10":"/Public/Tpl/sntugbw1/haixin/demo/prod.png"}}'><!--新品专区  start--->
	                   		<ul>
							 <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>																						                            
	                        </ul>
	                    </div>
			    </div>
			    
			   <div class="products" id="con_navSt_2" style="display:blocss;">
			           <div class="index_product_list_I block" block-dat='{"num":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"15","g_instead":"...","textcontent":{"1":"热销排行"},"imagecontent":{"10":"/Public/Tpl/sntugbw1/haixin/demo/prod.png"}}'><!--新品专区  start--->
	                   		<ul>
							 <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>																						                            
	                        </ul>
	                    </div>
			    </div>
			    
			   <div class="products" id="con_navSt_3" style="display:none;">
			           <div class="index_product_list_J block" block-dat='{"num":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"15","g_instead":"...","textcontent":{"1":"推荐专区"},"imagecontent":{"10":"/Public/Tpl/sntugbw1/haixin/demo/prod.png"}}'><!--新品专区  start--->
	                   		<ul>
							 <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>																						                            
	                        </ul>
	                    </div>
			    </div>

			   <div class="products" id="con_navSt_4" style="display:none;">
			           <div class="index_product_list_K block" block-dat='{"num":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"15","g_instead":"...","textcontent":{"1":"特价专区"},"imagecontent":{"10":"/Public/Tpl/sntugbw1/haixin/demo/prod.png"}}'><!--新品专区  start--->
	                   		<ul>
							 <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>																						                            
	                        </ul>
	                    </div>
			    </div>

			   <div class="products" id="con_navSt_5" style="display:none;">
			           <div class="index_product_list_L block" block-dat='{"num":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"15","g_instead":"...","textcontent":{"1":"猜你喜欢"},"imagecontent":{"10":"/Public/Tpl/sntugbw1/haixin/demo/prod.png"}}'><!--新品专区  start--->
	                   		<ul>
							 <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>	
                             <li>
                       	        <a href="#"><img src="__TPL__demo/img03.png" width="185px" height="185px"edit-name="列表图片" imagestyle-editable="true" style-num="4" /></a>
                                <strong  textstyle-editable="true" style-num="6">RMB<label>699.00</label></strong>  
                                <a href="#" class="proN"  edit-name="商品标题" textstyle-editable="true" style-num="5">ONLY秋装新品双层腰小脚口S仔</a>
							</li>																						                            
	                        </ul>
	                    </div>
			    </div>
				<!--products结束-->
		                            </div><!--mainConRA结束-->
		                        </div><!--mainConR 结束-->
		                    </div><!--mainCon 结束-->

                    <!-- 可视化编辑 产品展示 A Start-->
                    <div class="index_product_list_A block"  block-dat='{"num":"8","column":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"6","g_instead":"...","textcontent":{"1":"ONLY  牛仔裤"},"imagecontent":{"11":"__TPL__demo/img03.png"}}'><!--1F ONLY  牛仔裤  开始-->
	                    <div class="index_product_list_A_css blocss"><!--index_product_list_A_css  start--->
	                        <a href="#" class="fleft" edit-name="首张大图" linkcontent-editable="true" content-num="10" textstyle-editable="true" style-num="3"><img src="__TPL__demo/pic02.png" width="220" height="540" edit-name="首张图片" imagestyle-editable="true" style-num="4" imagecontent-editable="true" content-num="11"></a>
	                        <div class="mainConRB"> <!--mainConRB开始-->
	                            <h2><span edit-name="模块标题" textstyle-editable="true" style-num="1" textcontent-editable="true" content-num="1">ONLY&nbsp;&nbsp;牛仔裤</span></h2>
	                            <div class="products proCon">
	                                <ul>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                    <li>
	                                        <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
	                                        <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
	                                        <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
	                                    </li>
	                                </ul>
	                            </div>
	                        </div><!--mainConRB结束-->
	                    </div><!--index_product_list_A_css  end--->
                    </div>
                    <!-- 可视化编辑 产品展示 A End-->
                    
                    <!-- 可视化编辑 产品展示B Start -->
                    <div class="index_product_list_B block"  block-dat='{"num":"8","column":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"6","g_instead":"...","textcontent":{"1":"ONLY  西服"},"imagecontent":{"11":"__TPL__demo/img03.png"}}'><!--2F ONLY  西服  开始-->
							<div class="index_product_list_A_css blocss">
							    <a href="#" class="fleft" edit-name="首张大图" linkcontent-editable="true" content-num="10" textstyle-editable="true" style-num="3"><img src="__TPL__demo/pic02.png" width="220" height="540" edit-name="首张图片" imagestyle-editable="true" style-num="4" imagecontent-editable="true" content-num="11"></a>
							    <div class="mainConRB"> <!--mainConRB开始-->
							        <h2><span edit-name="模块标题" textstyle-editable="true" style-num="1" textcontent-editable="true" content-num="1">ONLY&nbsp;&nbsp; 西服</span></h2>
							        <div class="products proCon">
							            <ul>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							                <li>
							                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
							                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
							                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
							                </li>
							            </ul>
							        </div>
							    </div>
							</div>                 
                   	</div>
                    <!-- 可视化编辑 产品展示 B End-->
                    
                    <!-- 可视化编辑 产品展示C Start -->
                    <div class="index_product_list_C block"  block-dat='{"num":"8","column":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"6","g_instead":"...","textcontent":{"1":"ONLY  风衣/长外套"},"imagecontent":{"11":"__TPL__demo/img03.png"}}'><!--3F ONLY  风衣/长外套  开始-->
						<div class="index_product_list_A_css blocss">
						    <a href="#" class="fleft" edit-name="首张大图" linkcontent-editable="true" content-num="10" textstyle-editable="true" style-num="3"><img src="__TPL__demo/pic02.png" width="220" height="540" edit-name="首张图片" imagestyle-editable="true" style-num="4" imagecontent-editable="true" content-num="11"></a>
						    <div class="mainConRB"> <!--mainConRB开始-->
						        <h2><span edit-name="模块标题" textstyle-editable="true" style-num="1" textcontent-editable="true" content-num="1">ONLY&nbsp;&nbsp;风衣/长外套</span></h2>
						        <div class="products proCon">
						            <ul>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						            </ul>
						        </div>
						    </div>
						</div>                    
                   	</div>
                    <!-- 可视化编辑 产品展示 C End-->

                    <!-- 可视化编辑 产品展示D Start -->
                    <div class="index_product_list_D block"  block-dat='{"num":"8","column":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"6","g_instead":"...","textcontent":{"1":"ONLY  皮衣"},"imagecontent":{"11":"__TPL__demo/img03.png"}}'><!--4F ONLY  皮衣  开始-->
						<div class="index_product_list_A_css blocss">
						    <a href="#" class="fleft" edit-name="首张大图" linkcontent-editable="true" content-num="10" textstyle-editable="true" style-num="3"><img src="__TPL__demo/pic02.png" width="220" height="540" edit-name="首张图片" imagestyle-editable="true" style-num="4" imagecontent-editable="true" content-num="11"></a>
						    <div class="mainConRB"> <!--mainConRB开始-->
						        <h2><span edit-name="模块标题" textstyle-editable="true" style-num="1" textcontent-editable="true" content-num="1">ONLY&nbsp;&nbsp;皮衣</span></h2>
						        <div class="products proCon">
						            <ul>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						            </ul>
						        </div>
						    </div>
						</div>                    
                   	</div>
                    <!-- 可视化编辑 产品展示 D End-->                    

                    <!-- 可视化编辑 产品展示E Start -->
                    <div class="index_product_list_E block"  block-dat='{"num":"8","column":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"6","g_instead":"...","textcontent":{"1":"ONLY  针织衫"},"imagecontent":{"11":"__TPL__demo/img03.png"}}'><!--5F ONLY  针织衫  开始-->
					 	<div class="index_product_list_A_css blocss">
						    <a href="#" class="fleft" edit-name="首张大图" linkcontent-editable="true" content-num="10" textstyle-editable="true" style-num="3"><img src="__TPL__demo/pic02.png" width="220" height="540" edit-name="首张图片" imagestyle-editable="true" style-num="4" imagecontent-editable="true" content-num="11"></a>
						    <div class="mainConRB"> <!--mainConRB开始-->
						        <h2><span edit-name="模块标题" textstyle-editable="true" style-num="1" textcontent-editable="true" content-num="1">ONLY&nbsp;&nbsp;针织衫</span></h2>
						        <div class="products proCon">
						            <ul>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						            </ul>
						        </div>
						    </div>
						</div>                   
                   	</div>
                    <!-- 可视化编辑 产品展示 E End-->                                          

                    <!-- 可视化编辑 产品展示F Start -->
                    <div class="index_product_list_F block"  block-dat='{"num":"8","column":"4","show_name":"1","show_pic":"1","price":{"market_price":{"show":"市场价:￥"},"sale_price":{"show":"￥："},"save_price":{},"discount_price":{}},"a":100,"g_nums":"6","g_instead":"...","textcontent":{"1":"ONLY  连衣裙"},"imagecontent":{"11":"__TPL__demo/img03.png"}}'><!--6F ONLY  连衣裙  开始-->
					 	<div class="index_product_list_A_css blocss">
						    <a href="#" class="fleft" edit-name="首张大图" linkcontent-editable="true" content-num="10" textstyle-editable="true" style-num="3"><img src="__TPL__demo/pic02.png" width="220" height="540" edit-name="首张图片" imagestyle-editable="true" style-num="4" imagecontent-editable="true" content-num="11"></a>
						    <div class="mainConRB"> <!--mainConRB开始-->
						        <h2><span edit-name="模块标题" textstyle-editable="true" style-num="1" textcontent-editable="true" content-num="1">ONLY&nbsp;&nbsp;连衣裙</span></h2>
						        <div class="products proCon">
						            <ul>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						                <li>
						                    <a href="#" class="pro" ><img src="__TPL__demo/img03.png" width="185" height="185" edit-name="列表图上" imagestyle-editable="true" style-num="5"/></a> 
						                    <a href="#" class="proN" edit-name="商品标题" textstyle-editable="true" style-num="7">ONLY秋装新品双层腰小脚口SK牛仔裤长裤T|112432035 930水洗牛仔</a>
						                    <p><strong edit-name="销售价" textstyle-editable="true" style-num="8"><label>699.00</label></strong><del edit-name="市场价" textstyle-editable="true" style-num="9">>参考价：<label>699.00</label></del></p>
						                </li>
						            </ul>
						        </div>
						    </div>
						</div>                   
                   	</div>
                    <!-- 可视化编辑 产品展示 F End-->  
                                   
                    </div>
                    </div>
                </div><!--content1000   end-->
            </div><!--col  end-->
        </div><!--area  end-->
    </div>
    <!-- 判断页面是首页还是其他页面,首页隐藏类目  Start-->
<!-- <input type="hidden" value="0" id="is_show_category"/> -->
<!-- 判断页面是首页还是其他页面,首页隐藏类目 End-->
<!--中间内容 结束--->
<!-- 广告轮播图 Start -->
<script src="__JS__lunbo.js"></script>
<!-- 广告轮播图 End -->
</div><!--end of main-->
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
	    <!--尾部 开始-->
<div id="footer" class="footer" style="padding-top:0px;">
    <!--footCon 开始-->
    <div class="footCon">
    	<!-- 可视化开始 Start -->
	    <div class="area">
			<div class="col" >
			
			   <div class="content1000">
		        	<!--foot_tags 开始-->
		        	<div class="foot_tags">
		                <div class="footLeft">
		                    <span><a href="<?php echo (C("DOMAIN_HOST")); echo ($ary_top_ads['bottom_pic_url']); ?>"><img src="<?php echo ($ary_top_ads['bottom_pic']); ?>" width="200px" height="47px" ></a></span>
		                    <p><span>订购热线/客服电话</span><br /><label>021-58390211</label></p>
		                </div>
		                <!--footRight 开始-->
		                <div class="footRight">
		                	<ul>
								<?php $artcat = array ( ); if(is_array($artcat)): $k = 0; $__LIST__ = $artcat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$arts): $mod = ($k % 2 );++$k;?><li>
										<strong><?php echo ($arts["cat_name"]); ?></strong>
											<?php if(is_array($arts["list"])): $k = 0; $__LIST__ = $arts["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$artinfo): $mod = ($k % 2 );++$k; if($k <= 4): ?><div style="width:10px;height:10px;float:left" <?php if($artinfo["hot"] == '1'): ?>class="hot2"<?php endif; ?>></div>
											<a href="<?php echo ($artinfo["aurl"]); ?>" target="_blank"><?php echo ($artinfo["a_title"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
									</li><?php endforeach; endif; else: echo "" ;endif; ?>
		                    </ul>
		                </div><!--footRight 结束-->
		            </div><!--foot_tags 结束-->
		        </div>
			</div>
		</div>
		<!-- 可视化结束 End -->
    </div><!--footCon 结束-->
    <p class="footnav">
        <?php $nav = NULL; $nav_count = 0; if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; if($nav["nname"] != ''): ?><a href="<?php echo ($nav["nurl"]); ?>" target="<?php echo ($nav["ntarget"]); ?>"><?php echo ($nav["nname"]); ?></a>
            <span>|</span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </p>
</div>

<!--尾部 结束-->
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
<div align="center" style="background:#DDDDDD"> 
	<?php echo (($commonInfo['GY_SHOP_ICP'])?($commonInfo['GY_SHOP_ICP']):'Copyright © 2009-2016 沪ICP备：12035449号-2'); ?>
</div> 
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