<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($page_title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="keywords" content="<?php echo ($page_keywords); ?>">
        <meta name="description" content="<?php echo ($page_description); ?>">
        <link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
        <script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js" ></script>
        <script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/jquery/xcConfirm.js" ></script>
        <script type="text/javascript" src="__PUBLIC__/Lib/jquery/js/main.js?version=2.1" ></script>
        <link rel="stylesheet" type="text/css" href="__CSS__webuploader.css">
	<link rel="stylesheet" type="text/css" href="__CSS__style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="__CSS__loaders.css"/>
	<link rel="stylesheet" type="text/css" href="__CSS__xcConfirm.css"/>
        <link rel="stylesheet" type="text/css" href="__CSS__jquery.fileupload.css"/>

        <style>
.progress {
    overflow: hidden;
    height: 20px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}
.progress-bar {
    float: left;
    width: 0;
    height: 100%;
    font-size: 12px;
    line-height: 20px;
    color: #fff;
    text-align: center;
    background-color: #428bca;
    -webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    -webkit-transition: width .6s ease;
    transition: width .6s ease;
}
.progress-bar-success {
    background-color: #5cb85c;
}
#fileSpan {
    display: inline-block;
    width: 100%;
/*    height: 120px;*/
    border: 2px dashed #ccc;
    text-align: center;
    line-height: 150px;
}
.fileinput-button {
    position: relative;
    overflow: hidden;
}
.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
}

        </style>
<!--        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
<!--		<link href="__CSS__global.css" rel="stylesheet">
		<link href="__PUBLIC__/Lib/jquery/css/base/jquery-ui.css" rel="stylesheet">
		<script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>-->
<!--		<?php if(TPL != 'tmall' && TPL != 'blue' && TPL != 'bimai'){ ?>
	
		<?php } ?>-->
		<!--</script>-->
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
	<body id="goTop"  ><!--      -->
	        <div class="header">
        <div class="wrap clearfix">
            <a href="/" class="brand"><img src="__IMAGES__brand.png"  alt="pdf在线转换器" /></a>
            <ul class="nav">
                <li <?php if($header_tag_highlighted == 1 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/artificialvip');?>">人工VIP</a></li>
                <li <?php if($header_tag_highlighted == 2 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/informationRecords');?>">信息记录</a></li>
                <li>联系我们
                    <div class="info">
                        <i class="arrow_up"></i>
                        <p><i class="icon icon_qq"></i>官方QQ群<a href="http://shang.qq.com/wpa/qunwpa?idkey=5b012a15f072526bb9334848d8f60dbcaf7c8e2f7023f3378e1655ddd364dd00" target="_blank">(点击加入)</a></p>
                        <p><i class="icon icon_qq"></i>QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" target="_blank">3004137938</a></p>
                        <p><i class="icon icon_phone"></i>0755-86952275</p>
                        <div class="work_time">周一至周日 09:00-21:00</div>                        
                    </div>
                </li>
            </ul>
               
            <div class="login">
            <?php if(empty($_SESSION['Members']['m_name'])): ?><a href="javascript:return false;" id="login_weixin" >登录</a><!-- <?php echo U('Home/Index/weixin_login');?> --><?php endif; ?>
                <?php if(!empty($_SESSION['Members']['m_name'])): ?><div class="user">
                     你好，<?php echo ($_SESSION['Members']['m_name']); ?>
                     <div class="info">
                         <i class="arrow_up"></i>
                         <div class="content">
                             <h3><?php echo ($_SESSION['Members']['m_name']); ?><span class="promet2"> 
                                <?php if($ary_member["conversion_type"] == 0 ): ?>您当前还未充值<?php endif; ?></span></h3>
                                        <?php if($ary_member["conversion_type"] == 1 ): ?><p>次数套餐：<span class="times"><?php echo ($ary_member["number_remaining"]); ?> </span>次&nbsp;&nbsp;&nbsp;
                                                <?php elseif($ary_member["conversion_type"] == 2): ?>
                                                <?php if($ary_member["number_remaining"] != 0 ): ?><p>VIP套餐：<span class="times"><?php if(time() > strtotime($ary_member['end_time'])){ echo 0; }else { echo count_days(strtotime(date('Y-m-d')),strtotime($ary_member['end_time'])); } ?> </span>天(优先)&nbsp;&nbsp;&nbsp;次数套餐：<span class="times"><?php echo ($ary_member["number_remaining"]); ?> </span>次</p>
                                                   <?php else: ?>
                                                    <p>VIP套餐：<span class="times"><?php echo count_days(strtotime(date('Y-m-d')),strtotime($ary_member['end_time'])); ?> </span>天</p><?php endif; endif; ?>
                             <p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p> 
                         </div>
                         <div class="work_time">
                             <a href="<?php echo U('Home/Index/informationRecords',array('record'=>Prepaidrecords));?>" class="record">充值记录</a>
                             <a href="<?php echo U('Home/Index/informationRecords',array('record'=>Conversionrecord));?>" class="record">转换记录</a>
                             <a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="now_cz">立即充值</a>
                         </div>
                        <a href="<?php echo U('Home/User/doLogout');?>"> <div class="exit">退出<i class="icon icon_exit"></i></div> </a>
                     </div>
                 </div><?php endif; ?>

                &nbsp;&nbsp;│&nbsp;&nbsp;<a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="recharge">充值</a>
                <input type="hidden" value="<?php echo ($_SESSION['Members']['m_id']); ?>" name ="gy_member_open" id="gy_member_open"/>
                <input type="hidden" value="<?php echo ($redirect); ?>" name ="redirect" id="redirect"/>
            </div>
        </div>
    </div>
	    <script src="__JS__productslist.js"></script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-1.7.2.min.js"></script>
<link href="__PUBLIC__/Lib/thinkbox/css/style.css" rel="stylesheet">
<script src="__PUBLIC__/Lib/thinkbox/js/jquery.ThinkBox.min.js"></script>

<div class="content w1192">
<div class="proLTop clearfix">
    <p class="fleft"><a href="<?php echo U('Home/Index/index');?>">首页</a><!--<i>></i>-->
        <?php $catebreadcrumbs= array ( 0 => array ( 'gcid' => NULL, 'gcname' => NULL, 'gcpid' => NULL, 'gcurl' => '/Home/Products/index', ), ); if(is_array($catebreadcrumbs)): $i = 0; $__LIST__ = $catebreadcrumbs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$catebreadcrumb): $mod = ($i % 2 );++$i; if($catebreadcrumb["gcname"] != ''): ?><i>></i><a href="<?php echo ($catebreadcrumb["gcurl"]); ?>"><?php echo ($catebreadcrumb["gcname"]); ?></a>
                <?php $ary_tmp_cate[] = $catebreadcrumb['gcid']; endif; endforeach; endif; else: echo "" ;endif; ?>
    </p>
</div>
<div class="navBar">
    <!--导航-->
    <div class="barTitle ">全部搜索分类</div>
    <div class="navBarCon mb10" id="navBarCon">
        <?php $cateslist = array ( 0 => array ( 'cid' => '1', 'fid' => '0', 'cname' => '收费授权', 'clevel' => '0', 'gc_parent_id' => '0', 'gc_is_display' => '1', 'gc_ad_type' => '0', 'gc_is_hot' => '0', 'gc_pic_url' => '', 'curl' => '/Home/Products/Index/cid/1', ), ); if(is_array($cateslist)): $k = 0; $__LIST__ = $cateslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goodcate): $mod = ($k % 2 );++$k;?><dl>
            <dt>
                <i class="icon icon-add" id="cid_<?php echo ($goodcate["cid"]); ?>"></i>
                <a><?php echo ($goodcate["cname"]); ?></a>
            </dt>
            <dd>
                <?php foreach($goodcate['sub'] as $key=>$val){ ?>
                <span id="cid_<?php echo ($val["cid"]); ?>"><a href="<?php echo ($val["curl"]); ?>" title="<?php echo ($val["cname"]); ?>" <?php if(isset($ary_request["cid"])): if($val[cid] == $ary_request[cid]): ?>class="on"<?php endif; endif; ?> ><?php echo ($val["cname"]); ?></a></span>
                <?php } ?>
            </dd>
        </dl><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div id="buyLastHtml">
        <div class="mb10 aBuy">
            <div class="title">热卖商品Top5</div>
			<div>
				<ul>
					<?php $sales= array ( 0 => array ( 'gid' => '1', 'lgname' => '收费授权', 'gname' => '收费授权', 'gpicture' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'gprice' => '10.000', 'gsales' => '0', 'gurl' => '/Home/Products/detail/gid/1', ), ); if(is_array($sales)): $k = 0; $__LIST__ = $sales;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sale): $mod = ($k % 2 );++$k;?><li>
						<span style="padding:5px 0;margin:0 auto">
							<a href="<?php echo ($sale["gurl"]); ?>" class="proPic">
							<img class="err-product" width="170" height="170" src="<?php echo (showimage($sale["gpicture"],200,200)); ?>"></a>
						</span>
						<span>
							<a href="<?php echo ($sale["gurl"]); ?>" target="_blank">
								<?php echo ($sale["gname"]); ?><em></em>
							</a>
						</span>
						<p style="padding:5px 0">销售量：<label style="color:red"><?php echo ($sale["gsales"]); ?></label>件</p>
						<span>商城价：<label style="color:red">&yen; <?php echo (sprintf('%.2f',$sale["gprice"])); ?></label></span>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
        </div>
    </div>
</div>

<div class="proList mb10">
<?php $goodslist = array ( 0 => array ( 'gid' => '1', 'gdescription' => '', 'gt_id' => '1', 'maprice' => '10.000', 'g_is_pres' => '0', 'gsn' => 'js_001', 'onsale' => '0000-00-00 00:00:00', 'offsale' => '0000-00-00 00:00:00', 'gname' => '收费授权', 'gprice' => '10.000', 'gstock' => '59999994', 'gunit' => '', 'gpic' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'gnew' => '0', 'ghot' => '0', 'gsales' => '0', 'g_point' => '0', 'g_picture' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'remark' => '', 'field1' => '', 'field2' => '', 'field3' => '', 'field4' => '', 'field5' => '', 'pdt_market_price' => '109.000', 'products' => array ( 'specName' => '颜色:2年', 'skuName' => '2年', ), 'skuNames' => array ( '颜色' => array ( 0 => '每次', 1 => '每月', 2 => '3个月', 3 => '6个月', 4 => '每年', 5 => '2年', ), ), 'authorize' => true, 'gurl' => '/Home/Products/detail/gid/1', 'comment_nums' => '0', 'gpoint' => '0', 'collect_nums' => '0', 'market_price' => 0, 'column' => '', 'sale_price' => 0, 'discount_price' => 0, 'a' => '', 'show_name' => '', 'show_pic' => '', 'g_nums' => 0, 'g_instead' => '', 'hc_nums' => '', 'hcid' => '', ), ); if(is_array($goodslist)): $i = 0; $__LIST__ = $goodslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i; endforeach; endif; else: echo "" ;endif; $type['type'] = array ( 0 => array ( 'gt_id' => '1', 'gt_name' => '收费授权', 'gt_status' => '1', 'gt_create_time' => '0000-00-00 00:00:00', 'gt_update_time' => '2017-05-24 02:12:09', 'gt_type' => '0', ), ); $spec['type'] = ''; $pageinfo['type'] = ' 1 条记录 1/1 页          '; $pagearr['type'] = array ( 'nowPage' => 1, 'totalRow' => '1', 'totalPage' => 1, 'upPage' => '', 'downPage' => '', 'upUrl' => '', 'downUrl' => '', 'linkPage' => '', ); ?>


<div class="filterContent">
	<div class="filterCond searchT">
		<b>您已选择：</b>
		<div>
			<span id="topFilter">
				<?php if($brand_data['gb_name'] != '' ): ?><a title="<?php echo ($brand_data["gb_name"]); ?>">
						<em><?php echo ($brand_data["gb_name"]); ?></em>
						<i title="关闭" onClick="CancelBrand('<?php echo ($ary_request["cid"]); ?>');">x</i>
					</a><?php endif; ?>
				<?php if($ary_request['startPrice'] != '' AND $ary_request['endPrice'] != '' ): ?><a title="<?php echo ($ary_request['startPrice']); ?>-<?php echo ($ary_request['endPrice']); ?>">
						<em>价格:<?php echo ($ary_request['startPrice']); ?>-<?php echo ($ary_request['endPrice']); ?></em>
						<i title="关闭" onClick="Cancel('<?php echo ($ary_request["bid"]); ?>','<?php echo ($ary_request["cid"]); ?>');">x</i>
					</a><?php endif; ?>
			</span>
			<a id="resetFilter" href="<?php echo U('Home/Products/index');?>" style="display: inline;">重置筛选条件</a>
		</div>
	</div>
	<ul>
		<li class="sortName" >
			<dl>
				<dt>分类名称：</dt>
				<dd>
				<?php $cname;$cid; $ary_cate = array(); ?>
				<a href='<?php echo U("Home/Products/index");?>' <?php if($ary_request["cid"] == ''): ?>class="on"<?php endif; ?>>全部</a>
				<?php $cateslist = array ( 0 => array ( 'cid' => '1', 'fid' => '0', 'cname' => '收费授权', 'clevel' => '0', 'gc_parent_id' => '0', 'gc_is_display' => '1', 'gc_ad_type' => '0', 'gc_is_hot' => '0', 'gc_pic_url' => '', 'curl' => '/Home/Products/Index/cid/1', ), ); if(is_array($cateslist)): $k = 0; $__LIST__ = $cateslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($k % 2 );++$k;?><a href="<?php echo ($cate["curl"]); ?>" <?php if(isset($ary_tmp_cate)): if($ary_tmp_cate[0] == $cate[cid]): ?>class="on"<?php endif; endif; ?> ><?php echo ($cate["cname"]); ?></a>
					<?php if(isset($ary_tmp_cate)): if($cate['cid'] == $ary_tmp_cate[0]){ $cname = $cate['cname']; $cid = $cate['cid']; $ary_cate = $cate['sub']; } endif; endforeach; endif; else: echo "" ;endif; ?>
				</dd>
			</dl>
			<?php if($cname != ''): ?><dl>
					<dt><?php echo ($cname); ?>：</dt>
					<dd>
						<p>
							<a href='<?php echo U("Home/Products/index");?>?cid=<?php echo ($cid); ?>&bid=<?php echo ($ary_request["bid"]); ?>' <?php if($cid == $ary_request[cid]): ?>class="on"<?php endif; ?> >全部</a>
							<?php foreach($ary_cate as $key=>$val){ ?>
								<a href="<?php echo ($val["curl"]); ?>" <?php if(isset($ary_tmp_cate)): if($val[cid] == $ary_tmp_cate[1]): ?>class="on"<?php endif; endif; ?> ><?php echo ($val["cname"]); ?></a>
							<?php } ?>
						</p>
					</dd>
				</dl><?php endif; ?>
		</li>
		<li>
			<dl>
				<dt>品牌：</dt>
				<dd>
				<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>" <?php if(isset($ary_request["bid"])): if($ary_request['bid'] == '' ): ?>class="on"<?php endif; endif; ?> >不限</a>
				<?php $brandlist = array ( ); if(is_array($brandlist)): $i = 0; $__LIST__ = $brandlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($brand["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&path=<?php echo ($ary_request["path"]); ?>" <?php if(isset($ary_request["bid"])): if(($brand["bid"] == $ary_request.bid) && ($ary_request["bid"] != '')): ?>class="on"<?php endif; endif; ?> ><?php echo ($brand["bname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				</dd>
			</dl>
		</li>
		<?php $goodslist = array ( 0 => array ( 'gid' => '1', 'gdescription' => '', 'gt_id' => '1', 'maprice' => '10.000', 'g_is_pres' => '0', 'gsn' => 'js_001', 'onsale' => '0000-00-00 00:00:00', 'offsale' => '0000-00-00 00:00:00', 'gname' => '收费授权', 'gprice' => '10.000', 'gstock' => '59999994', 'gunit' => '', 'gpic' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'gnew' => '0', 'ghot' => '0', 'gsales' => '0', 'g_point' => '0', 'g_picture' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'remark' => '', 'field1' => '', 'field2' => '', 'field3' => '', 'field4' => '', 'field5' => '', 'pdt_market_price' => '109.000', 'products' => array ( 'specName' => '颜色:2年', 'skuName' => '2年', ), 'skuNames' => array ( '颜色' => array ( 0 => '每次', 1 => '每月', 2 => '3个月', 3 => '6个月', 4 => '每年', 5 => '2年', ), ), 'authorize' => true, 'gurl' => '/Home/Products/detail/gid/1', 'comment_nums' => '0', 'gpoint' => '0', 'collect_nums' => '0', 'market_price' => 0, 'column' => '', 'sale_price' => 0, 'discount_price' => 0, 'a' => '', 'show_name' => '', 'show_pic' => '', 'g_nums' => 0, 'g_instead' => '', 'hc_nums' => '', 'hcid' => '', ), ); if(is_array($goodslist)): $i = 0; $__LIST__ = $goodslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec): $mod = ($i % 2 );++$i; endforeach; endif; else: echo "" ;endif; $type['spec'] = array ( 0 => array ( 'gt_id' => '1', 'gt_name' => '收费授权', 'gt_status' => '1', 'gt_create_time' => '0000-00-00 00:00:00', 'gt_update_time' => '2017-05-24 02:12:09', 'gt_type' => '0', ), ); $spec['spec'] = ''; $pageinfo['spec'] = ' 1 条记录 1/1 页          '; $pagearr['spec'] = array ( 'nowPage' => 1, 'totalRow' => '1', 'totalPage' => 1, 'upPage' => '', 'downPage' => '', 'upUrl' => '', 'downUrl' => '', 'linkPage' => '', ); ?>
	   <?php if(!empty($spec['spec'])): if(is_array($spec['spec'])): $i = 0; $__LIST__ = $spec['spec'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sc): $mod = ($i % 2 );++$i;?><li>
				<dl>
					<dt><?php echo ($sc["gs_name"]); ?>：</dt>
					<dd>
						
						<p>
							<?php $bpath = bpath($ary_request['path'],$sc['gs_id'].":0"); ?>
							<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($brand["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&path=<?php echo ($bpath); ?>&new=<?php echo ($ary_request["new"]); ?>&hot=<?php echo ($ary_request["hot"]); ?>" <?php if($ary_request['paths'][$sc['gs_id']] == '' ): ?>class="on"<?php endif; ?> >不限</a>
							
							<?php if(is_array($sc['specs'])): $i = 0; $__LIST__ = $sc['specs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sps): $mod = ($i % 2 );++$i; $bpath = bpath($ary_request['path'],$sc['gs_id'].":".$sps['gsd_id']); ?>
								<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($ary_request["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&path=<?php echo ($bpath); ?>&new=<?php echo ($ary_request["new"]); ?>&hot=<?php echo ($ary_request["hot"]); ?>" <?php if($ary_request['paths'][$sc['gs_id']] == $sps[gsd_id] ): ?>class="on"<?php endif; ?>><?php echo ($sps["gsd_aliases"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
						</p>
					</dd>
				 </dl>
			   </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
	  <?php $goodslist = array ( 0 => array ( 'gid' => '1', 'gdescription' => '', 'gt_id' => '1', 'maprice' => '10.000', 'g_is_pres' => '0', 'gsn' => 'js_001', 'onsale' => '0000-00-00 00:00:00', 'offsale' => '0000-00-00 00:00:00', 'gname' => '收费授权', 'gprice' => '10.000', 'gstock' => '59999994', 'gunit' => '', 'gpic' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'gnew' => '0', 'ghot' => '0', 'gsales' => '0', 'g_point' => '0', 'g_picture' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'remark' => '', 'field1' => '', 'field2' => '', 'field3' => '', 'field4' => '', 'field5' => '', 'pdt_market_price' => '109.000', 'products' => array ( 'specName' => '颜色:2年', 'skuName' => '2年', ), 'skuNames' => array ( '颜色' => array ( 0 => '每次', 1 => '每月', 2 => '3个月', 3 => '6个月', 4 => '每年', 5 => '2年', ), ), 'authorize' => true, 'gurl' => '/Home/Products/detail/gid/1', 'comment_nums' => '0', 'gpoint' => '0', 'collect_nums' => '0', 'market_price' => 0, 'column' => '', 'sale_price' => 0, 'discount_price' => 0, 'a' => '', 'show_name' => '', 'show_pic' => '', 'g_nums' => 0, 'g_instead' => '', 'hc_nums' => '', 'hcid' => '', ), ); if(is_array($goodslist)): $i = 0; $__LIST__ = $goodslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i; endforeach; endif; else: echo "" ;endif; $type['type'] = array ( 0 => array ( 'gt_id' => '1', 'gt_name' => '收费授权', 'gt_status' => '1', 'gt_create_time' => '0000-00-00 00:00:00', 'gt_update_time' => '2017-05-24 02:12:09', 'gt_type' => '0', ), ); $spec['type'] = ''; $pageinfo['type'] = ' 1 条记录 1/1 页          '; $pagearr['type'] = array ( 'nowPage' => 1, 'totalRow' => '1', 'totalPage' => 1, 'upPage' => '', 'downPage' => '', 'upUrl' => '', 'downUrl' => '', 'linkPage' => '', ); ?>
	   <?php if(!empty($type['type'])): ?><li>
		<dl>
			<dt>相关搜索：</dt>
			<dd>
				<p>
					<?php if(is_array($type['type'])): $i = 0; $__LIST__ = $type['type'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($ary_request["bid"]); ?>&tid=<?php echo ($type["gt_id"]); ?>" <?php if(($brand["bid"] == $ary_request[bid]) && ($ary_request["bid"] != '')): ?>class="on"<?php endif; ?> ><?php echo ($type["gt_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				</p>
			</dd>
		 </dl>
	   </li><?php endif; ?>
	   <dl class="price-filter">
		<dt class="nm">价格：</dt>
		<dd class="m">
			<div class="line-t">
				<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($ary_request["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&startPrice=0&endPrice=300&path=<?php echo ($ary_request["path"]); ?>&new=<?php echo ($ary_request["new"]); ?>&hot=<?php echo ($ary_request["hot"]); ?>">0-300</a>
				<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($ary_request["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&startPrice=300&endPrice=800&path=<?php echo ($ary_request["path"]); ?>&new=<?php echo ($ary_request["new"]); ?>&hot=<?php echo ($ary_request["hot"]); ?>">300-800</a>
				<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($ary_request["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&startPrice=800&endPrice=1000&path=<?php echo ($ary_request["path"]); ?>&new=<?php echo ($ary_request["new"]); ?>&hot=<?php echo ($ary_request["hot"]); ?>">800-1000</a>
				<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($ary_request["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&startPrice=1000&endPrice=1500&path=<?php echo ($ary_request["path"]); ?>&new=<?php echo ($ary_request["new"]); ?>&hot=<?php echo ($ary_request["hot"]); ?>">1000-1500</a>
				<a href="<?php echo U('Home/Products/index');?>?cid=<?php echo ($ary_request["cid"]); ?>&bid=<?php echo ($ary_request["bid"]); ?>&tid=<?php echo ($ary_request["tid"]); ?>&startPrice=1500&path=<?php echo ($ary_request["path"]); ?>&new=<?php echo ($ary_request["new"]); ?>&hot=<?php echo ($ary_request["hot"]); ?>">1500以上</a>
			</div>
		</dd>
	</dl>
	</ul>
</div>
<div id="refresh" class="Searchcond mt10">
    <span class="thirdBg showC" id="showTab"><i id="listS" title="列表展示"></i><i  id="layS" title="大图展示"></i></span>
    <?php $goodslist = NULL; if(is_array($goodslist)): $i = 0; $__LIST__ = $goodslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page1): $mod = ($i % 2 );++$i; endforeach; endif; else: echo "" ;endif; $type['page1'] = NULL; $spec['page1'] = ''; $pageinfo['page1'] = ' 1 条记录 1/1 页          '; $pagearr['page1'] = array ( 'nowPage' => 1, 'totalRow' => '1', 'totalPage' => 1, 'upPage' => '', 'downPage' => '', 'upUrl' => '', 'downUrl' => '', 'linkPage' => '', ); ?>
    <div id="sortTileN">
        <?php if(isset($itemInfo['order'])){ ?>
		<?php if($ret['hot'][0] != ''): ?><a href="javascript:void(0);" class="clickThisTab mask2" k="t" c="hot" t="<?php echo ($ret['hot'][0]); ?>">
				<i>销量</i>
			</a>
			<?php else: ?>
				<?php if($itemInfo["order"] == '_hot'): ?><a href="javascript:void(0);" class="clickThisTab mask2" k="c" c="hot" t="hot">
						<i>销量</i>
					</a>
				<?php else: ?>
					<a href="javascript:void(0);" class="clickThisTab up mask2" k="c" c="hot" t="_hot">
						<i>销量</i>
					</a><?php endif; endif; ?>
			<?php if($ret['price'][0] != ''): ?><a href="javascript:void(0);" class="clickThisTab mask2" k="t" c="price" t="<?php echo ($ret['price'][0]); ?>" >
				<i>价格</i>
			</a>
			<?php else: ?>
				<?php if($itemInfo["order"] == '_price'): ?><a href="javascript:void(0);" class="clickThisTab mask2" k="c" c="price" t="price">
						<i>价格</i>
					</a>
				<?php else: ?>
					<a href="javascript:void(0);" class="clickThisTab up mask2" k="c" c="price" t="_price">
						<i>价格</i>
					</a><?php endif; endif; ?>
			<?php if($ret['new'][0] != ''): ?><a href="javascript:void(0);" class="clickThisTab mask2" k="t" c="new" t="new" >
				<i>新品</i>
			</a>
			<?php else: ?>
				<?php if($itemInfo["order"] == '_new'): ?><a href="javascript:void(0);" class="clickThisTab mask2" k="c" c="new" t="new">
						<i>新品</i>
					</a>
				<?php else: ?>
					<a href="javascript:void(0);" class="clickThisTab up mask2" k="c" c="new" t="_new">
						<i>新品</i>
					</a><?php endif; endif; ?>
		<?php }else{ ?>
			<a href="javascript:void(0);" class="clickThisTab mask2" k="c" c="hot" t="_hot"><i>销量</i></a>
			<a href="javascript:void(0);" class="clickThisTab mask2" k="c" c="price" t="price"><i>价格</i></a>
			<a href="javascript:void(0);" class="clickThisTab mask2" k="c" c="new" t="new"><i>新品</i></a>
        <?php } ?>
    </div>
    <div id="customPB-search">
        <div class="price-item"><i class="ui-price-plain">¥</i><input type="text" class="ipt" id="startPrice" value="<?php echo ($ary_request['startPrice']); ?>"></div>
        <span>-</span>
        <div class="price-item"><i class="ui-price-plain">¥</i><input type="text" class="ipt" id="endPrice" value="<?php echo ($ary_request['endPrice']); ?>"></div>
    </div>
    <div style='position: absolute;left: 395px;height:26px;'>
        <input type="submit" id="submitPrice" value="确定" style="border:none;background-color: #73b805;line-height: 26px;width: 60px;cursor: pointer;color: #fff;margin-top: 2px;">
        </div>
    <div class="page">
        <?php if($pagearr[page1][totalRow] != ''): ?><span><i id="pageThis"><?php echo ($pagearr["page1"]["nowPage"]); ?></i>/<i id="pageTotal"><?php echo ($pagearr["page1"]["totalPage"]); ?></i></span><?php endif; ?>
            <?php if($pagearr['page1']['nowPage'] == 1){ ?>
         <a id="prev" class="prevN" href="javascript:void(0);" title="上一页"></a>
        <?php }else{ ?>
        <a id="prev" class="prevN" href="<?php echo ($pagearr["page1"]["upUrl"]); ?>" title="上一页"></a>
        <?php } ?>
        <?php if($pagearr['page1']['nowPage'] == $pagearr['page1']['totalPage']){ ?>
        <a id="next" class="nextN" href="javascript:void(0);" title="下一页"></a>
        <?php }else{ ?>
        <a href="<?php echo ($pagearr["page1"]["downUrl"]); ?>" id="next" class="nextN" href="javascript:void(0);"title="下一页"></a>
        <?php } ?>
    </div>
</div>

<div class="pro-list clearfix">
    <ul class="list">
        <?php $goodslist = array ( 0 => array ( 'gid' => '1', 'gdescription' => '', 'gt_id' => '1', 'maprice' => '10.000', 'g_is_pres' => '0', 'gsn' => 'js_001', 'onsale' => '0000-00-00 00:00:00', 'offsale' => '0000-00-00 00:00:00', 'gname' => '收费授权', 'gprice' => '10.000', 'gstock' => '59999994', 'gunit' => '', 'gpic' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'gnew' => '0', 'ghot' => '0', 'gsales' => '0', 'g_point' => '0', 'g_picture' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'remark' => '', 'field1' => '', 'field2' => '', 'field3' => '', 'field4' => '', 'field5' => '', 'pdt_market_price' => '109.000', 'products' => array ( 'specName' => '颜色:2年', 'skuName' => '2年', ), 'skuNames' => array ( '颜色' => array ( 0 => '每次', 1 => '每月', 2 => '3个月', 3 => '6个月', 4 => '每年', 5 => '2年', ), ), 'authorize' => true, 'gurl' => '/Home/Products/detail/gid/1', 'comment_nums' => '0', 'gpoint' => '0', 'collect_nums' => '0', 'market_price' => 0, 'column' => '', 'sale_price' => 0, 'discount_price' => 0, 'a' => '', 'show_name' => '', 'show_pic' => '', 'g_nums' => 0, 'g_instead' => '', 'hc_nums' => '', 'hcid' => '', ), ); if(is_array($goodslist)): $i = 0; $__LIST__ = $goodslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$showlist): $mod = ($i % 2 );++$i;?><li>
            <i class="searchBang"></i>
            <a  class="search-bl" href="<?php echo ($showlist["gurl"]); ?>" target="_blank" >
				<img class="err-product" src="<?php echo (showimage($showlist['g_picture'],200,200)); ?>" title="<?php echo ($showlist["gname"]); ?>" width="200" height="200" >
            </a>
            <div class="inforBg">
                <h3>
                    <a href="<?php echo ($showlist["gurl"]); ?>" target="_blank" ><p><?php echo ($showlist["gname"]); ?></p></a>
                </h3>
                <div class="infor-top clearfix">
                    <p class="price"><b>¥</b><?php echo (sprintf('%.2f',$showlist["gprice"])); ?></p>
                    <div class="tag"></div>
                </div>
                <div class="comment clearfix">
                    <p><a target="_blank"><i><?php echo ($showlist["comment_nums"]); ?></i>条评价</a></p>
                </div>
                <div class="stock"></div>
            </div>
            <dl class="opre clearfix">
                <?php if($showlist['products']['specName'] == ''): ?><input type="hidden" name="type" value="item" id="item_type_<?php echo ($showlist["gid"]); ?>" />
                    <input type="hidden" value="<?php echo ($showlist["pdt_id"]); ?>" name="pdt_id" id="pdt_id_<?php echo ($showlist["gid"]); ?>" />
                    <input type="hidden" value="<?php echo ($showlist["pdt_stock"]); ?>" name="pdt_stock" id="pdt_stock_<?php echo ($showlist["gid"]); ?>" />
                    <input type="hidden" value="1" id="item_num_<?php echo ($showlist["gid"]); ?>" name="num" /><?php endif; ?>
                <dd><a href="javascript:void(0);" class="buy" <?php if($showlist['products']['specName'] == ''): ?>onClick="addGoodsProductsCartElse('<?php echo ($showlist["authorize"]); ?>','<?php echo ($showlist["gid"]); ?>');"<?php else: ?>onClick='addGoodsCartElse("<?php echo ($showlist["gid"]); ?>","<?php echo ($showlist["authorize"]); ?>");'<?php endif; ?>>加入购物车</a></dd>
                <dd><a href="javascript:addToInterests(<?php echo ($showlist["gid"]); ?>);" class="compareBtn last">收藏</a></dd>
            </dl>
        </li><?php endforeach; endif; else: echo "" ;endif; $type['showlist'] = array ( 0 => array ( 'gt_id' => '1', 'gt_name' => '收费授权', 'gt_status' => '1', 'gt_create_time' => '0000-00-00 00:00:00', 'gt_update_time' => '2017-05-24 02:12:09', 'gt_type' => '0', ), ); $spec['showlist'] = ''; $pageinfo['showlist'] = ' 1 条记录 1/1 页          '; $pagearr['showlist'] = array ( 'nowPage' => 1, 'totalRow' => '1', 'totalPage' => 1, 'upPage' => '', 'downPage' => '', 'upUrl' => '', 'downUrl' => '', 'linkPage' => '', ); ?>
        <?php if(empty($showlist)): ?><span style="font-size: 20px;font-weight: bold;margin-left: 100px;position: relative;left: 150px;">非常抱歉，没有找到您想要的商品</span><?php endif; ?>
    </ul>
</div>

</div>

<div class="wrap mt15 clearfix">

    <div class="ui-page clearfix">
        <div class="ui-page-item r">
            <div class="item fr">
                <?php if(($pagearr['showlist']['nowPage'] == 1) || empty($pagearr['page1']['nowPage'])){ ?>
                <a class="prev prev-disable" href="javascript:void(0)"><i class="icon"></i>上一页</a>
                <?php }else{ ?>
                <?php if($pagearr['showlist']['nowPage'] != 1){ ?>
                <a href="<?php echo rtrim(substr($pagearr['showlist']['upUrl'],0,-8),'/').'/'; ?>" class="change">首页</a>
                <a href="<?php echo ($pagearr["showlist"]["upUrl"]); ?>" class="prev01">上一页</a>
                <?php }} ?>
                <?php $int_i = 1; $totalPage = 0; if($pagearr['showlist']['nowPage']<5 && $pagearr['showlist']['totalPage']>5){ $totalPage = 5; }else if($pagearr['showlist']['nowPage']<5 && $pagearr['showlist']['totalPage']<=5){ $totalPage = $pagearr['showlist']['totalPage']; } if($pagearr['showlist']['nowPage'] >=3){ $minPage = $pagearr['showlist']['totalPage'] - $pagearr['showlist']['nowPage']; if($minPage <4){ $totalPage = $pagearr['showlist']['totalPage']; $int_i = $pagearr['showlist']['totalPage']-4; }else{ $totalPage = $pagearr['showlist']['nowPage']+2; $int_i = $pagearr['showlist']['nowPage']-2; } if($int_i <= 0){ $int_i = 1; } } for($i=$int_i;$i<=$totalPage;$i++){ if($i>0){ if($i == $pagearr['showlist']['nowPage']){ echo "<a class='on'>".$i."</a>"; }else{ if($i > $pagearr['showlist']['nowPage']){ $url = rtrim(substr($pagearr['showlist']['downUrl'],0,-8),'/').'/'.'start/'.$i; echo "<a href=".$url.">".$i."</a>"; }else{ $url = rtrim(substr($pagearr['showlist']['upUrl'],0,-8),'/').'/'.'start/'.$i; echo "<a href=".$url.">".$i."</a>"; } } } } ?>
                <?php if($pagearr['showlist']['nowPage'] == $pagearr['showlist']['totalPage']){ ?>
                <a class="next next-disable" href="javascript:void(0)">下一页<i class="icon"></i></a>
                <?php } ?>
                <?php if($pagearr['showlist']['nowPage'] < $pagearr['showlist']['totalPage']){ ?>
                <a href="<?php echo ($pagearr["showlist"]["downUrl"]); ?>" class="next">下一页</a>
				<a href="<?php echo rtrim(substr($pagearr['showlist']['downUrl'],0,-8),'/').'/'; ?>start/<?php echo ($pagearr['showlist']['totalPage']); ?>" class="change">尾页</a>
                <?php } ?>
            </div>
        </div>
    </div>
	<input type="hidden" name="path" value="<?php echo ($ary_request['path']); ?>" id="path" />
	<input type="hidden" name="tid" value="<?php echo ($ary_request['tid']); ?>" id="tid" />
	<input type="hidden" name="cid" value="<?php echo ($ary_request['cid']); ?>" id="cid" />
	<input type="hidden" name="bid" value="<?php echo ($ary_request['bid']); ?>" id="bid" />
	<input type="hidden" name="is_new" value="<?php echo ($ary_request['is_new']); ?>" id="is_new" />
	<input type="hidden" name="is_hot" value="<?php echo ($ary_request['is_hot']); ?>" id="is_hot" />
	<input type="hidden" name="startPrice" value="<?php echo ($ary_request['startPrice']); ?>" id="startPrice" />
	<input type="hidden" name="endPrice" value="<?php echo ($ary_request['endPrice']); ?>" id="endPrice" />
</div>
<!--content end-->
</div>
<script type="text/javascript">
	var type;
	var cid = "<?php echo ($ary_request['cid']); ?>";
	var bid = "<?php echo ($ary_bid); ?>";
	
	$(function(){
		$("#navBarCon dl dt:first,#navBarCon dl dd:first").addClass('foc');
	})
	
	//js处理选择分类的效果
	$(function(){
		if(cid){
			//先清除原有的效果
			$('#navBarCon').find('dl').each(function(){
				$(this).find('dt').removeClass('foc');
				$(this).find('dd').removeClass('foc');
			});
			//根据分类id获取被选中的分类
			var dd = $('#cid_'+cid).parent('dt').length >0 ? $('#cid_'+cid).parent('dt') : $('#cid_'+cid).parent('dd');
			if(!dd.hasClass('foc')){
				dd.addClass('foc');
				if($('#cid_'+cid).parent('dt').length >0){
					dd.siblings('dd').addClass('foc');
				}else{
					dd.siblings('dt').addClass('foc');
				}
			}
		}
	});
	$("#navBarCon dl").find('dt').click(function () {
		if ($(this).hasClass('foc')) {
			$(this).removeClass('foc').siblings('dd').removeClass('foc');
		} else {
			$(this).addClass('foc').siblings('dd').addClass('foc');
		}
	})
    function Cancel(bid,cid){
		var startPrice = '';
        var endPrice = '';
		var  url = '/Home/Products/Index/?';
        url += 'startPrice=&endPrice=&cid='+cid+'&bid='+bid;
        
        location.href = url;
    }

    function CancelBrand(cid){
		var startPrice = $("#startPrice").val();
        var endPrice = $("#endPrice").val();
		var url = '/Home/Products/Index/?';
			url += 'bid=&cid='+cid+'&startPrice='+startPrice+'&endPrice='+endPrice;
        
        location.href = url;
    }
</script>
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
        <p>&nbsp;&nbsp;E-mail：<a href="mailto:service@cqttech.com" >service@cqttech.com</a>&nbsp;&nbsp;网址：<a href="http://www.cqttech.com" target="_blank">http://www.cqttech.com</a></p>
        <p>Copyright (C) 2017 IVY Tec. All Rights Reserved.  <a href="http://www.miibeian.gov.cn/" target="_blank">粤ICP备16105002号-2</a></p>
        <p>商务QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004139668&site=qq&menu=yes" target="_blank">3004139668</a> | 产品QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004198912&site=qq&menu=yes" target="_blank">3004198912</a> | 客服QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" target="_blank">3004137938</a></p>
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
	    	<div class="statistics"><?php echo ($shop_code); ?></div>
	    </noempty><?php endif; ?>
	    <!-- 是否有统计代码，有则显示 End-->
	</body>
</html>