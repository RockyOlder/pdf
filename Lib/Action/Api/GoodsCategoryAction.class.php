<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class GoodsCategoryAction extends CommonAction {
    
    public function get_class_list(){

        $int_cid = null;
		$int_gctype = 0;
		if(isset($tag['cid'])){
			$int_cid = $tag['cid'];
		}
		if(isset($tag['gctype'])){
			$int_gctype = $tag['gctype'];
		}
        $cate_info = D('ViewGoods')->getInfo($int_cid,null,$int_gctype,true);
        print_r($cate_info);exit;
        output_data($cate_info,array('result' =>"0",'error'=>null));
    }
    
}

