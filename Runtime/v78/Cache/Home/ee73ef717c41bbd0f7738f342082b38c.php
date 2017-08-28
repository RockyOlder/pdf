<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($page_title); ?></title>
	<link href="__CSS__global.css" rel="stylesheet">
        <link href="__PUBLIC__/Lib/jquery/css/base/jquery-ui.css" rel="stylesheet">
        <script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>
        <script src="__PUBLIC__/Lib/jquery/js/jquery-ui-1.9.2.custom.js"></script>
        <script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script>		
        <script src="__JS__global.js"></script>
    </head>
<style>
	table img {vertical-align: top;}
	.proPic img {vertical-align: top;}
	.proPic {padding: 10px;width: auto;}
	.proPic {height: auto;overflow: hidden;}
	.proPic table {border-collapse: separate;margin: 0;text-align: left;}
	.proPic td {padding: 0;}
	.proPic th {padding: 0;}
	.proPic p {line-height: 25px;margin: 0;padding: 0;}
	.proPic p img {float: none;margin: 0 auto;padding: 0 auto;width: 100%;}
	.proPic strong {font-weight: 700;}
	.proPic em {font-style: italic;}
</style>
	<body>
<html>
<script type="text/javascript" src="__JS__jquery.jqzoom.js"></script>
<script type="text/javascript" src="__JS__jqzoombase.js"></script>
<link href="__CSS__jqzoom.css" rel="stylesheet">
<!--中间内容 start-->
<div class="warp">
<?php $detail = array ( 'skuNames' => array ( '颜色' => array ( 0 => '计时', 1 => '每月', 2 => '3个月', 3 => '6个月', 4 => '每年', 5 => '2年', ), ), 'authorize' => true, 'magnifier_on' => '1', 'magnifier_pic_width' => '500', 'magnifier_pic_height' => '500', 'thumb_pic_width' => '328', 'thumb_pic_height' => '328', 'gid' => '1', 'gsn' => 'js_001', 'gonsale' => '1', 'onsale' => '0000-00-00 00:00:00', 'offsale' => '0000-00-00 00:00:00', 'gname' => '收费授权', 'gprice' => '10.000', 'g_tax_rate' => 0, 'gsalenum' => '0', 'gispres' => '0', 'mprice' => '109.000', 'gstock' => 59999994, 'gunit' => '', 'gdesc' => '', 'gpic' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', 'gpics' => array ( 0 => array ( 'gp_picture' => '/Public/Uploads/v78/goods/20170510/14943983528904.jpg', ), ), 'gnew' => '0', 'ghot' => '0', 'gurl' => '/Home/Products/ajaxGoodsProducts/gid/1', 'skus' => array ( 0 => array ( 'pdt_sn' => 'pdf_001', 'pdt_weight' => '0.000', 'pdt_stock' => '9999999', 'pdt_memo' => '', 'pdt_id' => '1', 'pdt_sale_price' => '10.000', 'pdt_market_price' => '10.000', 'pdt_on_way_stock' => '0', 'pdt_is_combination_goods' => '0', 'pdt_min_num' => '0', 'zhgoods' => array ( 0 => NULL, ), 'specName' => '颜色:计时', 'skuName' => '计时', 'stock_num' => 30, ), 1 => array ( 'pdt_sn' => 'pdf_002', 'pdt_weight' => '0.000', 'pdt_stock' => '9999999', 'pdt_memo' => '', 'pdt_id' => '2', 'pdt_sale_price' => '20.000', 'pdt_market_price' => '20.000', 'pdt_on_way_stock' => '0', 'pdt_is_combination_goods' => '0', 'pdt_min_num' => '0', 'zhgoods' => array ( 0 => NULL, 1 => NULL, ), 'specName' => '颜色:每月', 'skuName' => '每月', 'stock_num' => 30, ), 2 => array ( 'pdt_sn' => 'pdf_003', 'pdt_weight' => '0.000', 'pdt_stock' => '9999999', 'pdt_memo' => '', 'pdt_id' => '3', 'pdt_sale_price' => '39.000', 'pdt_market_price' => '39.000', 'pdt_on_way_stock' => '0', 'pdt_is_combination_goods' => '0', 'pdt_min_num' => '0', 'zhgoods' => array ( 0 => NULL, 1 => NULL, 2 => NULL, ), 'specName' => '颜色:3个月', 'skuName' => '3个月', 'stock_num' => 30, ), 3 => array ( 'pdt_sn' => 'pdf_004', 'pdt_weight' => '0.000', 'pdt_stock' => '9999999', 'pdt_memo' => '', 'pdt_id' => '4', 'pdt_sale_price' => '59.000', 'pdt_market_price' => '59.000', 'pdt_on_way_stock' => '0', 'pdt_is_combination_goods' => '0', 'pdt_min_num' => '0', 'zhgoods' => array ( 0 => NULL, 1 => NULL, 2 => NULL, 3 => NULL, ), 'specName' => '颜色:6个月', 'skuName' => '6个月', 'stock_num' => 30, ), 4 => array ( 'pdt_sn' => 'pdf_005', 'pdt_weight' => '0.000', 'pdt_stock' => '9999999', 'pdt_memo' => '', 'pdt_id' => '5', 'pdt_sale_price' => '79.000', 'pdt_market_price' => '79.000', 'pdt_on_way_stock' => '0', 'pdt_is_combination_goods' => '0', 'pdt_min_num' => '0', 'zhgoods' => array ( 0 => NULL, 1 => NULL, 2 => NULL, 3 => NULL, 4 => NULL, ), 'specName' => '颜色:每年', 'skuName' => '每年', 'stock_num' => 30, ), 5 => array ( 'pdt_sn' => 'pdf_006', 'pdt_weight' => '0.000', 'pdt_stock' => '9999999', 'pdt_memo' => '', 'pdt_id' => '6', 'pdt_sale_price' => '109.000', 'pdt_market_price' => '109.000', 'pdt_on_way_stock' => '0', 'pdt_is_combination_goods' => '0', 'pdt_min_num' => '0', 'zhgoods' => array ( 0 => NULL, 1 => NULL, 2 => NULL, 3 => NULL, 4 => NULL, 5 => NULL, ), 'specName' => '颜色:2年', 'skuName' => '2年', 'stock_num' => 30, ), ), 'cid' => '1', 'cname' => '测试', 'field1' => '', 'field2' => '', 'field3' => '', 'field4' => '', 'field5' => '', 'bid' => '0', 'bname' => NULL, 'gremark' => '', 'coll_nums' => 0, ); $pageinfo['detail'] = ' 6 条记录 1/1 页          '; ?>
<input type="hidden" value="<?php echo ($ary_request["gid"]); ?>" id="gid">
          <div class="proDOLR"><!--proDOLR start-->
                <h2><?php echo ($detail["gname"]); ?></h2>
                <div class="proPrice">
                    <div class="proPriceT">
                        <p class="p02">
                            <strong><b>商城价</b><i>¥</i><i id="showPrice"><?php echo (sprintf('%.2f',$detail["gprice"])); ?></i></strong>
                            <span>市场价<del><i>¥</i><label id="showMarketPrice"><?php echo (sprintf('%.2f',$g_market_price)); ?></label></del></span>
                        </p>
                    </div>
                </div>
				<?php if($detail['field1'] != '' or $warm_prompt != ''): ?><div class="proPriceB"><span>温馨提示：</span>
                    <p><?php echo (($detail["field1"])?($detail["field1"]):"$warm_prompt"); ?><br>					
                </div><?php endif; ?>
			<script>
				var goods_url = new Array();
				<?php if(is_array($detail["goods_url"])): $k = 0; $__LIST__ = $detail["goods_url"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$da): $mod = ($k % 2 );++$k;?>goods_url['<?php echo ($key); ?>'] = "<?php echo ($da); ?>";<?php endforeach; endif; else: echo "" ;endif; ?>
			</script>		
			<div class="proPriceC" id="showDetailSkus">规格加载中......</div>
            <!--proDOLR end-->
			<div class="trade-btn">
				<input type="hidden" name="way_type" value="" id="way_type"/>
				<a href="javascript:void(0)" id="addToOrder" class="goTobuy">立即购买</a>
				<a href="javascript:void(0)" id="addToCart" class="j_gwc">加入购物车</a>
			</div>
			</form>
		</div>
<a href="#" onclick="gotoTop();return false;" class="totop"></a>
<input type="hidden" name="error_1" value="<?php echo (L("STOCK_ERROR_1")); ?>" id="error_1" />
<input type="hidden" name="error_2" value="<?php echo (L("STOCK_ERROR_2")); ?>" id="error_2" />
<input type="hidden" name="error_3" value="<?php echo (L("STOCK_ERROR_3")); ?>" id="error_3" />
<input type="hidden" name="error_4" value="<?php echo (L("STOCK_ERROR_4")); ?>" id="error_4" />

<form id="submitSkipFrom" name="submitSkipFrom" method="post" action="/Ucenter/Orders/pageAdd">
    <input type="hidden" name="pid[]" id="submitSkipItemPid" value="" />
    <input type="hidden" name="type[]" id="submitSkipItemtype" value=""/>
</form>
</div>
<!--content end-->
</div>
<script src="__JS__productsdetail.js"></script>
<script src="__JS__js.js" type="text/javascript"></script>
<!--中间内容 end-->
<script type="text/javascript">
	getDetailSkus('<?php echo ($ary_request["gid"]); ?>', 0);
	getCollGoodsPage('<?php echo ($ary_request["gid"]); ?>');
	getRelateGoodsPage('<?php echo ($ary_request["gid"]); ?>');
	getGoodsAdvice('<?php echo ($ary_request["gid"]); ?>',1);
	<?php if($common['comments_switch'] == 1): ?>getCommentPage('<?php echo ($ary_request["gid"]); ?>');<?php endif; ?>
	getBuyRecordPage('<?php echo ($detail["gid"]); ?>',20);
</script>
<link href="__PUBLIC__/Admin/css/etalage.css" rel="stylesheet">
<link href="__PUBLIC__/Lib/thinkbox/css/style.css" rel="stylesheet">
<script src="__PUBLIC__/Lib/jquery/js/jquery.etalage.min.js"></script>
<script src="__PUBLIC__/Lib/thinkbox/js/jquery.ThinkBox.min.js"></script>
<script src="__PUBLIC__/Lib/validate/jquery.validate.1.9.js"></script>
<script src="__PUBLIC__/Lib/validate/jquery.metadata.js"></script>
<script src="__PUBLIC__/Lib/validate/messages_cn.js"></script>
<script src="__JS__jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
	</body>
</html>