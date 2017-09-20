<?php
return array(
    //导入管易分销的自定义标签库
    'TAGLIB_PRE_LOAD' => 'Gyfx' ,
    //跳转桥页模版
    'TMPL_ACTION_ERROR' => 'Home:Common:jump',
    'TMPL_ACTION_SUCCESS' => 'Home:Common:jump',
	'TMPL_EXCEPTION_FILE'=>'./Tpl/404.html',
	'HTML_CACHE_ON'=>true,//是否启用静态缓存
	'HTML_CACHE_TIME'=>60,
	'HTML_CACHE_RULES'=> array(
		'Index:index'=>array('{|setHtmlRule}',600,md5),//首页
		'Products:index'=>array('{|setHtmlRule}',60,md5),//列表页
		'Products:detail'=>array('{|setHtmlRule}',60,md5),//详情页
		'Wrong:Index'=>array('{|setHtmlRule}',3600,md5),//404页面
	),	
);