<?php

class CouponsAction extends MobileAction {
    
    public function __construct() {
        parent::__construct();
        $this->cart = D('Cart');
    
        $arr_array = file_get_contents('php://input');

        $ary_post = json_decode($arr_array, true);
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'desc'=>'数据有误'));
        }
        switch ($ary_post['action'])
        {
            case "CouponsChoose":
                $this->CouponsChoose($ary_post);
                break;
        }
    }
    
   public function ceshi() {

       $json_order  = '{"action":"CouponsChoose","operation":"order_express","t_money":"300","Whether ":"0","data": [{"g_id": "233","num": "2"},{"g_id": "1114","num": "5"}]}';
      
//       $ary_post = json_decode($json_order,true);	

//    
//        //$aa =  $this->ChangeOrder($ary_post);
//      //  print_r($aa);exit;
       $success = makeRequestApiJsonceshi("http://txy.com/Api/Coupons/", $json_order, "POST");
       print_r($success);exit;
////        exit;
//echo  $this->callbackOrder();exit;
   //     $json_one= '{"action":"Refund","price":"105","orderno":"201606161813446935","goodsno":"cccccc_123123223211v","quantity":1,"OutRemark":"213213"}';
        
        $json_one= '{"action":"CouponsChoose","operation":"order_express","t_money":"100","data": [{"id": "1004","idno": "440881199508265937"}]}';
        $aa =  $this->CouponsChoose($json_one);
        print_r($aa);exit;
//        $success = makeRequestApiJsonceshi("http://txy/Api/Coupons/", $ary_post, "POST");
//        print_r($success);
//        exit;
    }
    
    
    public function CouponsChoose($ary_post){

        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'desc'=>'数据有误'));
        }
       
        switch ($ary_post['operation']) {
            
            case "order_express":
                $pids = array();
                foreach ($ary_post['data'] as $v )
                {
                    $pids[] = $v['g_id'];
                }
                $coupon = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM');
               $checkOrder = $this->cart->getCartItems($pids, $this->member_info['m_id'], $gift_except=false);//$this->member_info['m_id']
                foreach ($checkOrder as $v) {
                    $gIds[] = $v['g_id'];
                }
            
                $field = array(
                    'fx_goods_info.g_id',
                    'fx_goods.gb_id',
                    'fx_goods.card_img',
                    'fx_related_goods_category.gc_id',
                    'fx_goods_info.trade_type',
                    'fx_goods_info.g_name'
                );
                $where['fx_goods_info.g_id'] = array('in', implode(',', $gIds));
                $ary_result = M('goods_info', C('DB_PREFIX'), 'DB_CUSTOM')
                                ->join('fx_goods ON fx_goods_info.g_id = fx_goods.g_id')
                                ->join('fx_related_goods_category ON fx_related_goods_category.g_id = fx_goods_info.g_id')
                                ->field($field)->where($where)->select();
                
                foreach($ary_result as $value)
                {
                    $gid[]   = $value['g_id'];
                    $gb_id[] = $value['gb_id'];
                    $gc_id[] = $value['gc_id'];
                }
                $gid    = implode(',', $gid);
                $gb_id  = implode(',', $gb_id);
                $gc_id  = implode(',', $gc_id);
                $couponWhere['gc_id'] = array('in', $gc_id);
                $couponWhere['gb_id'] = array('in', $gb_id);
                $couponWhere['c_user_id'] = $this->member_info['m_id'];
                $couponWhere['c_is_use'] = 0;    
                $couponWhere ['c_end_time'] = array(
                array(
                    'EGT',
                    date("Y-m-d H:s:i")
                    )
                );
                $couponSelect  = $coupon->where($couponWhere)->select();
                $couponGoodsList = array();
                if(!empty($couponSelect))      
                {
                            foreach($couponSelect as $value)
                            {
                                        foreach($gIds as $g)
                                        {   
                                                if(in_array($g, explode(',', $value['c_coupon_good_id'])))
                                                {
                                                     $dataObject[]  =  1;
                                                }else{
                                                     $dataObject[]  =  2;
                                                }
                                        }
                                        if(in_array(1,$dataObject))
                                        {
                                                 $couponGoodsList[] = $value;
                                        }
                                        unset($dataObject);
                            }
                            if(empty($couponGoodsList))
                            {
                                 $couponGoodsList = $couponSelect;
                            }
                           
                } else {
                            $couponWhere_gid['gc_id'] = 0;
                            $couponWhere_gid['gb_id'] = 0;
                            $couponWhere_gid['c_user_id'] = $this->member_info['m_id'];
                            $couponWhere_gid['c_is_use'] = 0;
                            $couponWhere_gid ['c_end_time'] = array(
                            array(
                                'EGT',
                                date("Y-m-d H:s:i")
                                )
                            );
                            $couponObject  = $coupon->where($couponWhere_gid)->select();
                         
                            if(!empty($couponObject))
                            {
                                foreach($couponObject as $value)
                                {
                                            foreach($gIds as $g)
                                            {   
                                                    if(in_array($g, explode(',', $value['c_coupon_good_id'])))
                                                    {
                                                         $dataObject[]  =  1;
                                                    }else{
                                                         $dataObject[]  =  2;
                                                    }
                                            }
                                            if(in_array(1,$dataObject))
                                            {
                                                     $couponGoodsList_push[] = $value;
                                            }
                                            unset($dataObject);
                                }
                            }
                            
           
                            $couponWhere_gc['gc_id'] = array('in', $gc_id);
                            $couponWhere_gc['c_user_id'] = $this->member_info['m_id'];
                            $couponWhere_gc['c_is_use'] = 0;    
                            $couponWhere_gc ['c_end_time'] = array(
                            array(
                                'EGT',
                                date("Y-m-d H:s:i")
                                )
                            );
                            $couponGoodsList  = $coupon->where($couponWhere_gc)->select();
                            if(empty($couponGoodsList))
                            {
                                $couponWhere_gb['gb_id'] = array('in', $gb_id);
                                $couponWhere_gb['c_user_id'] = $this->member_info['m_id'];
                                $couponWhere_gb['c_is_use'] = 0; 
                                $couponWhere_gb ['c_end_time'] = array(
                                array(
                                    'EGT',
                                    date("Y-m-d H:s:i")
                                    )
                                );
                                $couponGoodsList  = $coupon->where($couponWhere_gb)->select();
                            }
                            
                            if(empty($couponGoodsList))
                            {
                                
                                $couponWhere_all['c_coupon_good_id'] = "all";
                                $couponWhere_all['c_user_id'] = $this->member_info['m_id'];
                                $couponWhere_all['c_is_use'] = 0;    
                                $couponWhere_all ['c_end_time'] = array(
                                array(
                                    'EGT',
                                    date("Y-m-d H:s:i")
                                    )
                                );
                                $couponGoodsList  = $coupon->where($couponWhere_all)->select();  
                              
                            }else{
                                    
                                $couponWhere_all['c_coupon_good_id'] = "all";
                                $couponWhere_all['c_user_id'] = $this->member_info['m_id'];
                                $couponWhere_all['c_is_use'] = 0;    
                                $couponWhere_all ['c_end_time'] = array(
                                array(
                                    'EGT',
                                    date("Y-m-d H:s:i")
                                    )
                                );
                                $couponGoods = $coupon->where($couponWhere_all)->select();  
                           
                                if(!empty($couponGoods))
                                {
                                        foreach($couponGoods as $value)
                                        {
                                            array_push($couponGoodsList, $value);
                                        }
                                }
                            }
                }
                                if(!empty($couponGoodsList_push))
                                {
                                    if(empty($couponGoodsList)){
                                        $couponGoodsList = $couponGoodsList_push;
                                    }else{
                                        foreach($couponGoodsList_push as $value)
                                        {
                                            array_push($couponGoodsList, $value);
                                        }
                                    }
                                }
                if(!empty($couponGoodsList))
                {
                    foreach($couponGoodsList as $value)
                    {
                        if($ary_post['t_money'] >= $value['c_condition_money'] || $value['c_condition_money']==0.00 )
                        {
                            $couponList[] =$value;
                            $cid[] = $v['c_id'];
                        }
                    }
                     $c_idList    = implode(',', $cid);
                }

               
               if($ary_post['Whether'] ==1)
               {
                $couponWhere['c_id'] = array('not in', $c_idList);
                $couponWhere['c_user_id'] =$this->member_info['m_id'];
                $couponWhere['c_is_use'] = 0;    
                $couponWhere ['c_end_time'] = array(
                array(
                    'EGT',
                    date("Y-m-d H:s:i")
                    )
                );
                     $couponWhether = $coupon->where($couponWhere_all)->select();  
                     if(empty($couponWhether))
                     {
                         $couponWhether = array();
                     }
                       output_datas($couponWhether,array('result' =>"0",'desc'=>'查询成功！'));
               }else{
                    if(empty($couponList))
                     {
                         $couponWhether = array();
                     }
                      output_datas($couponList,array('result' =>"0",'desc'=>'查询成功！'));
               }
            break;
            
        }
 
    }
    
    
    
    
}

