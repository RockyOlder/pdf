<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: wangguibin <wangguibin@guanyisoft.com>
// +----------------------------------------------------------------------

defined('THINK_PATH') or exit();
/**
 * Memcache缓存驱动
 * @category   Extend
 * @package  Extend
 * @subpackage  Driver.Cache
 * @author    wangguibin <wanguibin@guanyisoft.com>
 */
class CacheMemcached extends Cache {

    /**
     * 架构函数
     * @param array $options 缓存参数
     * @access public
     */
    function __construct($options=array()) {
		if ( !extension_loaded('memcached') ) {
			throw_exception(L('_NOT_SUPPERT_').':memcached');
		}
		$options = array_merge(array (
			'host' => C('MEMCACHED_HOST') ? C('MEMCACHED_HOST') : '127.0.0.1',
			'port' => C('MEMCACHED_PORT') ? C('MEMCACHED_PORT') : '11211',
			'username' => C('MEMCACHED_USER') ? C('MEMCACHED_USER') : null,
			'password' => C('MEMCACHED_PWD') ? C('MEMCACHED_PWD') : null,
			'ocs' => C('MEMCACHED_OCS') ? C('MEMCACHED_OCS') : false,
			'timeout' => C('DATA_CACHE_TIMEOUT') ? C('DATA_CACHE_TIMEOUT') : false,
			'persistent' => false,
		),$options);
	    $this->options = $options;
	    $this->options['expire'] = isset($options['expire'])? $options['expire'] : C('DATA_CACHE_TIME');
	    $this->options['prefix'] = isset($options['prefix'])? $options['prefix'] : C('DATA_CACHE_PREFIX');
	    $this->options['length'] = isset($options['length'])? $options['length'] : 0;
	    $this->handler = new Memcached;
		//阿里云OCS
		if($options['ocs']){
			if (count($this->handler->getServerList()) == 0) /*建立连接前，先判断*/
			{
				if($options['persistent'] && $options['timeout'] !== false){
				  $this->handler->setOption(Memcached::OPT_CONNECT_TIMEOUT,$options['timeout']);
				}				
				$this->handler->setOption(Memcached::OPT_COMPRESSION, false);
				$this->handler->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
				$this->handler->addServer($options['host'],$options['port']);
				$this->handler->setSaslAuthData($options['username'], $options['password']);
			}
		}else{
			if($options['persistent'] && $options['timeout'] !== false){
			  $this->handler->setOption(Memcached::OPT_CONNECT_TIMEOUT,$options['timeout']);
			}			
			$this->handler->addServer($options['host'],$options['port']);
		}		
    }

    /**
     * 是否连接
     * @access private
     * @return boolen
     */
    private function isConnected() {
        return $this->connected;
    }

    /**
     * 读取缓存
     * @access public
     * @param string $name 缓存变量名
     * @return mixed
     */
    public function get($name) {
        N('cache_read',1);
        return $this->handler->get($this->options['prefix'].$name);
    }

    /**
     * 写入缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $value  存储数据
     * @param integer $expire  有效时间（秒）
     * @return boolen
     */
	public function set($name, $value, $expire = null) {
	  N('cache_write',1);
	  if(is_null($expire)) {
		$expire = $this->options['expire'];
	  }
	  $name = $this->options['prefix'].$name;
	  if($this->handler->set($name, $value , $expire)) {
		if($this->options['length']>0) {
		  // 记录缓存队列
		  $this->queue($name);
		}
		return true;
	  }
	  return false;
	}

    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolen
     */
    public function rm($name, $ttl = false) {
        $name   =   $this->options['prefix'].$name;
        return $ttl === false ?
            $this->handler->delete($name) :
            $this->handler->delete($name, $ttl);
    }

    /**
     * 清除缓存
     * @access public
     * @return boolen
     */
    public function clear() {
        return $this->handler->flush();
    }
}

/**
$cache = Cache::getInstance();
$cache->set('hello','world',60);
echo $cache->get('hello');
exit();
$cache = Cache::getInstance();
$cache->set('hello','world',60);
echo $cache->get('hello');
exit();
**/