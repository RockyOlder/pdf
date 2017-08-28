<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class IndexAction extends CommonAction {

    public  function getjson() {
   
        $data = $this->getData($_SERVER["DOCUMENT_ROOT"].'/data.json');
    
        return $data;
    }

    public function getData($file) {
       
        // var_dump(file_exists($file));
        $text = file_get_contents($file);
       
        $text = preg_replace("%//\s+[^\n]+%", '', $text);
        $data = json_decode($text, true);
            
        if (empty($data)) {
            return false;
        } else {
            return $this->formatData($data);
        }
    }

    public function formatData($data) {
        $return = array();
        foreach ($data['controller'] as $key => $value) {
            $api = array_filter(explode(' ', $key));
            $temp = array('type' => $api[0], 'url' => trim(end($api)), 'request' => $value['request'], 'des' => $value['__desc__']);
            $return['api'][] = $temp;
        }
        $return['server'] = $data['server'];
        $return['model'] = $data['model'];
        return $return;
    }

    public function index() {
        
        $data=$this->getjson();
        $this->assign("data",$data);
        $this->display();

    }
    public function GoodsBrand(){
        echo 10;exit;
      //  print_r(json_decode($_POST));exit;
        $where = array();
        $where['gb_status']=1;
        $hot = $this->_get("gb_host");
        $content = trim($this->_post('gb_name'));
 
    	if($content){
    		$where['gb_name'] = array('LIKE', '%' . $content . '%');
    	}
        if(!empty($hot)){
            
        }

        $count =  M('goods_brand',C('DB_PREFIX'),'DB_CUSTOM')->where($where)->count();
        $page_size = 20;
        $obj_page = new Page($count, $page_size);
        $page = $obj_page->show();
        $limit = $obj_page->firstRow . ',' . $obj_page->listRows;
        $ary_brand =  M('goods_brand',C('DB_PREFIX'),'DB_CUSTOM')->field("gb_name,gb_logo,gb_id,gb_first_letter")->where($where)->limit($limit)->order('`gb_order` DESC')->select();
        $where['gb_hot']= '1';
        $ary_host =  M('goods_brand',C('DB_PREFIX'),'DB_CUSTOM')->field("gb_name,gb_logo,gb_id,gb_first_letter")->where($where)->limit($limit)->order('`gb_order` DESC')->select();
        $arr =  array();
        foreach ($ary_brand as $key=>$value)
        {
            $arr[$key]["k"] = $value['gb_first_letter'];
            $arr[$key]["value"] = $value;
        }
        $ary_data['brands'] = $arr;
        $ary_data['hot_brands'] = $ary_host;
        if(!empty($ary_brand))
        {
        
             output_data($ary_data,array('result' =>"0",'error'=>null));
        }else{
             output_error(null,array('result' =>"1",'error'=>'暂无数据'));
        }
     
    }
    


    public function GoodsBrandHost(){

        $where = array();
        $where['gb_status']=1;
        $where['gb_hot']= '1';
        $content = trim($this->_post('gb_name'));
 
    	if($content){
    		$where['gb_name'] = array('LIKE', '%' . $content . '%');
    	}
        $count =  M('goods_brand',C('DB_PREFIX'),'DB_CUSTOM')->where($where)->count();
  
        $page_size = 20;
        $obj_page = new Page($count, $page_size);
        $page = $obj_page->show();
        $limit = $obj_page->firstRow . ',' . $obj_page->listRows;
        $ary_brand =  M('goods_brand',C('DB_PREFIX'),'DB_CUSTOM')->field("gb_name,gb_logo,gb_id")->where($where)->limit($limit)->order('`gb_order` DESC')->select();
        if(!empty($ary_brand))
        {
             output_data(array('hot_brands' => $ary_brand),array('result' =>"0",'error'=>null));
        }else{
             output_error(null,array('result' =>"1",'error'=>'暂无数据'));
        }
     
    }
    
    
}
