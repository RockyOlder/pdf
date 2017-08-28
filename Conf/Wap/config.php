<?php
return array(
    //导入管易分销的自定义标签库
    'TAGLIB_PRE_LOAD'     => 'Gyfx' ,
    //跳转桥页模版
    'TMPL_ACTION_ERROR'   => 'Wap:Common:jump',
    'TMPL_ACTION_SUCCESS' => 'Wap:Common:jump',
	'TMPL_EXCEPTION_FILE'=>'./Tpl/404.html',
    'HTML_CACHE_ON'=> false,//是否启用静态缓存
    'HTML_CACHE_TIME'=>60,
    'HTML_CACHE_RULES'=> array(
        'Index:index'=>array('{|setHtmlRule}',600),//首页
        'Products:index'=>array('{|setHtmlRule}',3600),//列表页
        //'Products:detail'=>array('{|setHtmlRule}'),//详情页
        //'Products:getGoodsAdvice'=>array('{|setHtmlRule}'),//静态化购买咨询
        //'Comment:getCommentPage'=>array('{|setHtmlRule}'),//获取商品评论信息
        //'Article:articleList'=>array('{|setHtmlRule}'),//文章列表页
        'Article:articleDetail'=>array('{|setHtmlRule}',3600),//文章详情页
        //'BrandList:index'=>array('{|setHtmlRule}'),//品牌列表页
        'Wrong:Index'=>array('{|setHtmlRule}',2592000)//404页面
	)
);
