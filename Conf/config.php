<?php

return array(
    //调试模式
    'APP_STATUS' => 'debug',
    'SHOW_PAGE_TRACE' => false,
    'LOAD_EXT_CONFIG' => 'database_config,base', //扩展配置
    'DEFAULT_GROUP' => 'Home',
    //URL模式
    'URL_MODEL' => 2,
    //配置URL对大小写不敏感
    'URL_CASE_INSENSITIVE' =>false,
    //'URL_ROUTER_ON' =>false,
    //类库
   // 'APP_AUTOLOAD_PATH' => '@.Common,@.Common.Apis,@.Common.Promotions,@.Common.Payments',
    //布局默认信息
    'LAYOUT_ON' => true,
    'LAYOUT_NAME' => 'layout',
    'TAGLIB_LOAD'   => FALSE,    //自动加载自定义标签
    'VAR_LANGUAGE' => 'l', // 默认语言切换变量
    //自定义配置项
    'FX_TAOBAO_CENTER' => '', //淘宝授权中心化服务器
    'FX_TAOBAO_CENTER_API' => '', //淘宝授权中心化服务器
    'FX_TAOBAO_REDIRECT' => '', //淘宝API请求中转服务器
    'FX_TAOBAO_KEY' => '',
    'FX_TAOBAO_SECRET' => '',
	'TAOBAO_REQUEST_URL' => '',//淘宝无签名方式调用
	'FX_JD_CENTER' =>'', //京东授权中心化服务器
	'JD_REQUEST_URL'=>'',//京东接口请求地址
	'JD_GY_APPKEY'=>'',
	'JD_GY_SECRET'=>'',
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
        //'__FXCENTER__' => '',                               // 中心化管理地址
        '__FXCENTER__' => '',                               // 中心化管理地址
    ),
    //api的版本数组
    'API_VERSION'=>array(
        'Top'=>'标准版',
        'ZhiXun'=>'智讯版',
    ),
    //定义中心化SAAS API信息
    'SAAS_KEY'  =>  'test',
    'SAAS_SECRET'   => '85d6b7020a621e06b1dc55eadd226c62',
    'WEIXIN_LOGIN'=>'https://open.weixin.qq.com/connect/qrconnect',//微信扫码登录
    'WEIXIN_ACCESS_TOKEN'=>'https://api.weixin.qq.com/sns/oauth2/access_token',//获取access_token
    'WEIXIN_USERINFO'=>'https://api.weixin.qq.com/sns/userinfo',//获取用户基本信息
    'WEIXIN_APPID'=>'wxfa7d707a8cdf4e0d',//微信appid 
    'WEIXIN_APPSECRET'=>'91255cd0e95cd0fa648a558bd60f4430', //微信appsecret
    //客户类型
    'CUSTOMER_TYPE' => '1',//1.B2B  2.B2C  3.B2B2C 默认B2B客户
    //开启自动升级
    'AUTO_SQL_UPDATE' => '0',//是否开启脚本自动升级
    'MEMCACHE_STAT' => 0,//是否开启Memcache缓存'
    'MEMCCACHE_HOST' => '127.0.0.1', //Memcache服务器IP地址
    'MEMCCACHE_PORT' => '11211', //Memcache服务器端口
    'MEMCCACHE_TIME' => '3600', //Memcache缓存有效时间
    
    'REDIS_HOST'=>'127.0.0.1', 
    'REDIS_PORT'=>6379, 
    'REDIS_AUTH'=>'', 
    'REDIS_DB_PREFIX'=>'', 
    
    'REDIS_STAT'=>1, //是否开启redis
    'cache_open'=> 1,    //是否开启数据缓存(默认开启)
	//wap主题所在目录
	'WAP_TPL_DIR'         => 'wap',
    // 手机端app主题所在目录
    'APP_TPL_DIR'         => 'app',
    'HOST_DOWNLOAD'=>'http://ucenter.wiserar.com',  //下载链接
    'HOST_CONVERSIONS'=>'ucenter.wiserar.com',
    // 默认图片
    'DEFAULT_IMAGE_PATH' => '/Public/Uploads/goods_default.jpg',
    'DEFAULT_IMAGE_SIZE' => '300,300', // 默认宽高
    //rsa私匙
	'PRIVATE_KEY'=> '-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAtwjO4HVES5IDGa4KP+vxFCtFta3TYY8buZF1M3r+yd2rqU/0
tK9e5fpuLeSxlUNQovZuixFHmdA79oUuLa0o702Dxzxc4XnexVGsutmfyGyGiqzf
3rYoqaoS7ZxJVnIKSqcdnVMhMeTYYtfKhDqI70AaQHzB+Su/b/JhNE4uae7Ij6Vx
oioS/cxwx8uAssOqci1yp+m0+BZ47ccvf/QOGniP0vUkCeud5Qj9nIUAQ4gmzORH
0C2dLj90SGRL9VYWDjxWBO6Y1Nurk/y4BZewPFkueNnGXisZBZaOwJdY/2w7yT7H
6NBUfdyvtDkJg3nwPfyRHALorpMj6ESnOdh0NwIDAQABAoIBAQCAgFuVtF61W5Z3
ofuqMwC3M0YmrhoYhTtmxdttwC0/FjTdkrfvXqwWdAKEj+mpLHBhaPflBMWrFEn0
4j2wbcCueVJKP3PKDSC8kYHeUMlgEelHVOV7W5Iiw7e0QCQw37GgBcHB4UoN2Gee
xXd17A6VQgDsQ2p/gBpQAvABo93sGjuCEOiEzDKGLbkFDStDKzQpNiDOvtLkOewo
iTtmikPv2ccdIl6acu2kGY3KT1VfuVh0IUr7Hxgpk5UUvPkXqJ9v4ahZH8G6qdz3
LEHdpslOPZ4IWVl4ZSoZ+wIUU7+H3wYUeQies4T2BtK9XJnWtnpb9W6EschxRpI9
3M9nY1/JAoGBAN4m7SyrucmjMcY7eRHjtgN/4pgUDOTTT8zQ86ZmMVu7ie4msjPH
8kP1Zjb+OJmsz6nvmnqB71zMTcOaTK+zCPKBPFtBfLArZBpHbw332i3VcP9upeJ8
NSxA76yOHbCBybhO3Rl16IzgAkwWkmucV/OZuezawnV2mJbqJZghH5LTAoGBANLs
F4w1uU4hlvLL5NhDzDro/8ThDtcJew0nxhw44ZcijIM45D+IcXmiJYFrye3pzVtd
/lgLXtInFznd9UKIQIlAEUma3fAmDOHRxK4Fb3FWXxw9Wt2/Qr4hgF1NRwWjTggj
/vuuwV5Zs8WAENX6wqkQZrQ+qx7CL4KxBbKBv1KNAoGBANkVnOrsHK9HxBn8gADV
TkX5MEqAPWFWhUKWZaITduQ3TT/lnHoxRzLVmT7gChtR3dQoCgLw+iDqnIsqOwnu
oC2p0Hs0cU4N+NIdQA6cRx5G1xck3wGFcsh95Dfw4F5dVeu/VRvONqODO3tzCz4R
F3k6nY8w7pmufMnsoTQaGip1AoGAL6UNHKr2FOQZiPbt1rxZ4eTIAd0k0QZfOXWG
ltFyhAVV4D51sLRNjcBG4JlMn+V0cfMlhRXscWRLJtMwl7rXeSlzvkCxaZHuzwPn
fbfUmLF+Ao8Je5W8qd4/dNQD+w4MjmIzMv8ixwFUToTDSNLALhh6WrTdSrFqsgby
1oPgh/ECgYBgi2JMvgNhpXGMvzhxgB+eHExtlY9BiGVCS2v+u+AmES1q1m4053gz
XIEb1L+0XHp4rPq55ag2pOfeNhI5nPHDI8ttgoBL96LbnBRNzs2LNxekVCY+5KQm
WfU+/KD1y0uu49QTt/gnfR9De2V5l97JcSvi2BvtXWrwO9ZFMJxxrg==
-----END RSA PRIVATE KEY-----',
        //rsa共匙
    'PUBLIC_KEY'=>'-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtwjO4HVES5IDGa4KP+vx
FCtFta3TYY8buZF1M3r+yd2rqU/0tK9e5fpuLeSxlUNQovZuixFHmdA79oUuLa0o
702Dxzxc4XnexVGsutmfyGyGiqzf3rYoqaoS7ZxJVnIKSqcdnVMhMeTYYtfKhDqI
70AaQHzB+Su/b/JhNE4uae7Ij6VxoioS/cxwx8uAssOqci1yp+m0+BZ47ccvf/QO
GniP0vUkCeud5Qj9nIUAQ4gmzORH0C2dLj90SGRL9VYWDjxWBO6Y1Nurk/y4BZew
PFkueNnGXisZBZaOwJdY/2w7yT7H6NBUfdyvtDkJg3nwPfyRHALorpMj6ESnOdh0
NwIDAQAB
-----END PUBLIC KEY-----',
	//'SESSION_TYPE'=>'Db',//数据库存储需要新增表fx_session
	
	'API_URL'=>'',
	'AUTO_SNYC_MEMBER' =>0,
	//开启积分抵扣限制
	'IS_POINT_USE' =>1,
	'POINT_USE_VALUE' =>100, //积分100分起抵扣
		
	//阿里云OCS配置
	'MEMCACHED_OCS' => false,
	'MEMCACHED_HOST'=>'',
	'MEMCACHED_USER' =>'',
	'MEMCACHED_PWD' => '',
	'DATA_CACHE_TIME'=>'3600',
	//上传到七牛服务器配置
	'UPLOAD_SITEIMG_QINIU' => array ( 
		'GY_QN_ON'=>'0',
		'driverConfig' => array (
		'secrectKey' => '', //<这里填七牛SK>
		'accessKey' => '',//<这里填七牛AK>
		'domain' => '',//<空间名称>.qiniudn.com
		'bucket' => '', //<空间名称>
		)	
	),
);
