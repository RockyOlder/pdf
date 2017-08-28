<?php
return array(
	//数据库信息
    "GY_PREFIX" => 'gy_',
    //SAAS中控数据库
    'DB_PREFIX' => 'fx_', // 数据库表前缀
    'DB_CENTER' => 'mysql://root@localhost:3306/fx_center_v7',
    //客户真正数据库
    'DB_CUSTOM' => 'mysql://root:@localhost:3306/',
	//取得客户编号，此处是管易授予用户的唯一识别码，也是数据库名称
	'CI_SN' => 'v78',
	//客户不连接中心化数据库是的密钥
	'APP_SECRET' => 'kjoi_hio4u#oij6-lds2h+iof.09uio'
);