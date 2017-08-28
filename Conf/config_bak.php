<?php

return array(
    //调试模式
    'APP_STATUS' => 'debug',
    'SHOW_PAGE_TRACE' => false,
    //分组信息
    'APP_GROUP_LIST' => 'Home,Admin,Ucenter,System,Script,Clientapi',
    'DEFAULT_GROUP' => 'Home',
    //URL模式
    'URL_MODEL' => 2,
    //类库
    'APP_AUTOLOAD_PATH' => '@.Common,@.Common.Apis,@.Common.Promotions,@.Common.Payments',
    //数据库信息
    "GY_PREFIX" => 'gy_',
    //SAAS中控数据库
    'DB_PREFIX' => 'fx_', // 数据库表前缀
    'DB_CENTER' => 'mysql://root:123456@localhost:3306/service_ecdrp_com',
    //客户真正数据库
    'DB_CUSTOM' => 'mysql://root:123456@localhost:3306/',
    //数据库信息
    //布局默认信息
    'LAYOUT_ON' => true,
    'LAYOUT_NAME' => 'layout',
    //多语言信息
    'LANG_SWITCH_ON' => true, // 开启语言包功能
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'TAGLIB_LOAD'   => true,    //自动加载自定义标签
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST' => 'zh-cn,zh-tw,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE' => 'l', // 默认语言切换变量
    //自定义配置项
    'FX_TAOBAO_CENTER' => 'http://223.4.49.169/oauth.php', //淘宝授权中心化服务器
    'FX_TAOBAO_CENTER_API' => 'http://223.4.49.169/api.php', //淘宝授权中心化服务器
    'FX_TAOBAO_REDIRECT' => 'http://223.4.48.68/index.php', //淘宝API请求中转服务器
    'FX_TAOBAO_KEY' => '999999999',
    'FX_TAOBAO_SECRET' => 'e146b46acc20d96ab09a18616150de12',
    //文件缓存设置
    'DATA_CACHE_SUBDIR' => true,
    'DATA_PATH_LEVEL' => 2,
    //自定义模版常量
    'TMPL_PARSE_STRING' => array(
        '__TPL__'   => '/Public/Tpl/' . CI_SN . '/' . TPL .'/',         // 客户模版js路径替换规则
        '__JS__' => '/Public/Tpl/' . CI_SN . '/' . TPL . '/js/',         // 客户模版js路径替换规则
        '__IMAGES__' => '/Public/Tpl/' . CI_SN . '/' . TPL . '/images/', // 客户模版images路径替换规则
        '__CSS__' => '/Public/Tpl/' . CI_SN . '/' . TPL . '/css/',       // 客户模版css路径替换规则
        '__UPLOAD__' => '/Public/Uploads/' . CI_SN . '/',                   // 客户上传路径替换规则
        //'__FXCENTER__' => 'http://192.168.0.164:8050',                               // 中心化管理地址
        '__FXCENTER__' => 'http://fx_saas.com',                               // 中心化管理地址
    ),
    //api的版本数组
    'API_VERSION'=>array(
        'Top'=>'标准版',
        'ZhiXun'=>'智讯版',
    ),
    //定义中心化SAAS API信息
    'SAAS_KEY'  =>  '555555',
    'SAAS_SECRET'   => '85d6b7020a621e06b1dc55eadd226c62',
);