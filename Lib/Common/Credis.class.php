<?php

class Credis{
    public $redis;
    public function __construct($set_time=''){
        $cahe_data = $this->getCacheConfig();
        include_once('Predis.class.php');
        $this->redis =  new Predis\Client ( $cahe_data);
//       $this->redis->set ( 'library' ,  'predis' ) ;
//       $retval  =   $this->redis -> get ( 'library' ) ;
//       print_r($retval);exit;
    }
    
    private function getCacheConfig(){
            $options = array (
                'host'          => C('REDIS_HOST') ? C('REDIS_HOST') : '127.0.0.1',
                'port'          => C('REDIS_PORT') ? C('REDIS_PORT') : 6379,
                'timeout'       => C('DATA_CACHE_TIMEOUT') ? C('DATA_CACHE_TIMEOUT') : false,
                'persistent'    => false,
            );
        return $options;
    }
    
}
