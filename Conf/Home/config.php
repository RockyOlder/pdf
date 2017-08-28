<?php
return array(
    //导入管易分销的自定义标签库
    'TAGLIB_PRE_LOAD' => 'Gyfx' ,
    //跳转桥页模版
    'TMPL_ACTION_ERROR' => 'Home:Common:jump',
    'TMPL_ACTION_SUCCESS' => 'Home:Common:jump',
//	'TMPL_EXCEPTION_FILE'=>'./Tpl/404.html',
	'HTML_CACHE_ON'=>false,//是否启用静态缓存
	'HTML_CACHE_TIME'=>60,
	'HTML_CACHE_RULES'=> array(
		'Index:index'=>array('{|setHtmlRule}',600,md5),//首页
		'Index:showThisHtml'=>array('{|setHtmlRule}',600,md5),//自定义专题页
		'Products:index'=>array('{|setHtmlRule}',60,md5),//列表页
		'Products:detail'=>array('{|setHtmlRule}',60,md5),//详情页
		'Products:getCollGoodsPage'=>array('{|setHtmlRule}',60,md5),//获取自由商品组合信息
		'Products:getRelateGoodsPage'=>array('{|setHtmlRule}',60,md5),//获取关联商品信息
		'Products:getDetailSkus'=>array('{|setHtmlRule}',2,md5),//获取SKU信息
		'Products:getGoodsAdvice'=>array('{|setHtmlRule}',5,md5),//获取购买建议
		'Comment:getCommentPage'=>array('{|setHtmlRule}',5,md5),//获取商品评论
		'Products:getBuyRecordPage'=>array('{|setHtmlRule}',5,md5),//获取购买记录
		'Article:articleList'=>array('{|setHtmlRule}',600,md5),//文章列表页
		'Article:articleDetail'=>array('{|setHtmlRule}',600,md5),//文章详情页
		'BrandList:index'=>array('{|setHtmlRule}',600,md5),//品牌列表页
		'Wrong:Index'=>array('{|setHtmlRule}',3600,md5),//404页面
	),	
);