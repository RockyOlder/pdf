<?php
//分销基本配置信息
return array(
    //类库
    'APP_AUTOLOAD_PATH' => '@.Common,@.Common.Apis,@.Common.Promotions,@.Common.Payments,@.Common.ILog',
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST' => 'zh-cn,zh-tw,en-us', // 允许切换的语言列表 用逗号分隔
    //分组信息
    'APP_GROUP_LIST' => 'Home,Admin,Ucenter,Wap,App,System,Script,Clientapi,Image,uploadFile',
    //多语言信息
    'LANG_SWITCH_ON' => true, // 开启语言包功能
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
);
