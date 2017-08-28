<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE ^ E_WARNING);
ini_set("session.cookie_httponly", 1);
//session_start();
define('GYFX', true);

define('APP_PHPUNIT', false);

//配置是否连接SAAS化中心数据库
define('SAAS_ON', false);
//取得客户编号
if(SAAS_ON == TRUE){
	require 'custom.php';
}else{
	$config_info = require_once("./Conf/database_config.php");
	//取得客户编号，此处是管易授予用户的唯一识别码，也是数据库名称，请勿修改
	//修改可能会导致模板文件不能加载或者会员中心错乱或者数据库连接出错
	define('CI_SN', $config_info['CI_SN']);
	//同时将CI_SN写入到session，供第三方程序使用，例如ueditor
	$_SESSION['CI_SN'] = $config_info['CI_SN'];
	//定义密钥
	define('APP_SECRET', $config_info['APP_SECRET']);
	//定义数据库链接
	$db_custom = $config_info['DB_CUSTOM'];
	$array_center_config = explode('/', ltrim($db_custom, 'mysql://'));
	$array_hostinfo = explode("@", $array_center_config[0]);
	$array_host_info = explode(":", $array_hostinfo[1]);
	$array_userinfo = explode(":", $array_hostinfo[0]);
	define('DB_HOST', $array_host_info['0']);
	define('DB_USER', $array_userinfo[0]);
	if(isset($array_userinfo[1])){
		define('DB_PWD', $array_userinfo[1]);
	}else{define('DB_PWD', '');}
	if(isset($array_host_info[1]) && $array_host_info[1] !='3306'){
		define('DB_PORT', $array_host_info[1]);
	}else{define('DB_PORT', '');}
}

define('APP_DEBUG', true);
define('FXINC',str_replace('\\','/',substr(dirname(__FILE__),0)));
//定义客户runtime目录
define('RUNTIME_PATH', './Runtime/' . CI_SN . '/');
//定义静态缓存目录
define('HTML_PATH', RUNTIME_PATH.'TmpHtml/'.CI_SN);
//区域限购开关
define('GLOBAL_STOCK',FALSE);
//创建客户上传目录
@mkdir('./Public/Uploads/' . CI_SN);
//创建客户模版目录
@mkdir('./Public/Tpl/' . CI_SN);

require 'ThinkPHP/ThinkPHP.php';



