<?php

/* 
 * desc:订单相关接口
 * author：wangpan 
 * date：2016-06-27
 * 演示地址:www.xingyun.com:8080/Api/Orders/test
 * request_type:POST或GET
 */
class OrdersAction extends CommonAction {
    
    public function __construct(){	
        parent::__construct();
    }




    // 请求方式：get  http://www.xingyun.com:8080/Api/Orders/OrderStatusNum?token=237c3e69bad23b0e0a56866fdb12faea
    // 请求参数：Action ：OrderStatusNum（固定）
    // token:  凭证

    // 返回data 
    public function OrderStatusNum(){

        $ary_post = $this->_get();


        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];

        $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
        //待付款
        $ary_orders_no_pay =$orders->where(array("m_id" => $m_id, "o_pay_status" => array('in','0,3'), "initial_o_id" => 0,'o_status'=>array('not in',array(2,4)),'order_type'=>array("neq",'3')))->count();
            //echo $orders->getLastSql();exit;
        $join_where = "";
        // $join_where[] = 'fx_orders_items on fx_orders.o_id=fx_orders_items.o_id';
        // $join_where[] = 'fx_related_goods_category on fx_related_goods_category.g_id=fx_orders_items.g_id';
        // $join_where[] = 'fx_goods_category on fx_related_goods_category.gc_id=fx_goods_category.gc_id';  
        //待确认           
        $ary_orders_audit = $orders->join($join_where)->where(array("m_id" => $m_id, "express_status" => 0, "o_audit" => 0,"is_diff" => 0,'order_type'=>array("neq",'3'),"o_pay_status"=>1, 'o_status'=>array('not in',array(2,4))))->count();
        //待收货
        $ary_orders_audit_success = $orders->where(array("m_id" => $m_id, 'o_status'=>array('not in',array(2,4)),"express_status" => 2,'order_type'=>array("neq",'3')))->count();
        //通关中
        $ary_orders_express_status =$orders->where(array("m_id" => $m_id, "express_status" => 0,"o_audit" => 1, 'o_status'=>array('not in',array(2,4)),"o_audit" => 1,'order_type'=>array('not in',array("0","3"))))->count();
        //异常订单（datahub取消）
        $ary_orders_info_count =$orders->where(array("m_id" => $m_id, "erp_status" => 5, "o_status" => 2))->count();


        //显示页面
        $status['wait_pay'] = $ary_orders_no_pay;
        $status['wait_audit'] = $ary_orders_audit;
        $status['wait_receipt'] = $ary_orders_audit_success;
        $status['on_way'] = $ary_orders_express_status;
        $status['cancel'] = $ary_orders_info_count;
        //dump($status);exit;

        output_datas($status,array('result' =>"0",'error_code' =>0,'desc'=>'成功'));

 

    }





	// url : http://www.xingyun.com:8080/Api/Orders/orderList?token=dd11d73ecd604e79ca13a74b15cd9177&pagesize=10&pageindex=1
	// 请求方式： get
	// 请求参数： 
	// Action: orderList
	// Token:	凭证
	// 返回数据：
	public function orderList(){//TODO:通关中的状态到底取express_status还是o_customs?很乱…………

        $ary_post = $this->_get();


        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->where($condition)->find();

        $ary_where = array();  
        $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');

        $ary_where['o.m_id'] = $token['member_id']; 
        //$ary_where['o.initial_o_id'] = array('eq','');
        //$ary_where['o.initial_o_id'] = 0;  
        $ary_where['o.order_type'] = array("neq",'3');
		//$ary_where['o.import_status'] = '0'; //0,正常订单 1，导入订单时生成的合并订单
        //$ary_where['o.o_id']="201606281739016509";     
        // 订单的状态条件搜索处理
        switch ($ary_post['status']) {//传0,1或者空都是全部订单

            case '0' :
                $str_orders_status = '全部订单';
                $ary_where['o.initial_o_id'] = 0; //父订单 

                break;

            case '2' :
                $str_orders_status = '待收货';
                $ary_where ['o.express_status']    = 2;
                $ary_where ['o.o_status'] =  array('not in',array(2,4));         
                // $ary_where ['o.express_status'] = 2;
                // $ary_where ['o.o_status'] =  array('in','1,5');
                // $ary_where['o.order_type'] = array("neq",'3');
                break;
            case '3' :
                $str_orders_status = '待付款';
                $ary_where['o.initial_o_id'] = 0; //父订单 
                $ary_where ['o.o_pay_status'] = array('in','0,3');//部分支付和待支付
                // $ary_where ['o.o_status'] = 1;
                $ary_where['o.o_status'] = array("neq",'2');
                $ary_where['o.order_type'] = array("neq",'3');
                break;
            case '4' :
                $str_orders_status = '退款/退货';
                
                $ary_where ['oi.oi_refund_status'] =  array('neq',1);
                break;
            case '5' :
                $str_orders_status = '已完成';
                $ary_where ['o.express_status'] = 2;
                $ary_where ['o.o_status'] =  4;
                //$ary_where ['o.o_audit'] = 1;
                break;
            case '6' :
                $str_orders_status = '待确认';
               
                $ary_where ['o.o_pay_status'] = 1;
                $ary_where ['o.o_audit'] = 0;
                $ary_where ['o.express_status']    = 0;
                $ary_where ['o.is_diff'] = 0;//未拆单
                //$ary_where['o.order_type'] = array("neq",'3');
                $ary_where ['o.o_status']=array('not in',array(2,4));
                break;
            case '7' :
                $str_orders_status = '通关中';
                // $ary_where['o.order_type'] = array("neq",'3');
                // $ary_where ['o.o_audit'] = 1;
                $ary_where ['o.express_status']    = 0;
                // $ary_where ['o.o_status'] =  array("neq",'2');
                $ary_where ['o.o_audit'] = 1;
                $ary_where ['o.o_pay_status'] = 1;
                $ary_where ['o.o_status'] =  array('not in',array(2,4));
                $ary_where ['o.order_type'] =  array('not in',array("0","3"));                
                break;
            case '9' :
                $str_orders_status = '已取消';
                $ary_where['o.initial_o_id'] = 0; //父订单 
                $ary_where ['o.o_status'] =  2;
                break;
            case '10' :
                $str_orders_status = '异常订单';
                //$ary_where['o.initial_o_id'] = 0; //父订单 
                $ary_where ['o.erp_status'] = 5;
                $ary_where ['o.o_status'] =  2;
                break;
            // default :
            //     $str_orders_status = '所有订单';                
        }
        //必传参数
        if(isset($ary_post["pageindex"]) && $ary_post["pageindex"]!=""){
            $pageindex = $ary_post['pageindex'];
        }
        if(isset($ary_post["pagesize"]) && $ary_post["pagesize"]!=""){
            $pagesize = $ary_post['pagesize']; 
        }    

        $offset = ($pageindex-1) * $pagesize;
             
        $ary_orders_info = $orders
                        ->alias('o')
                        ->field('o.o_id,o.o_all_price,o_status,o.o_receiver_name,oi.oi_refund_status,o.o_audit,o.express_status,o.o_pay_status,o.is_diff,o.o_create_time,o.o_pay,o.o_cost_freight,o.order_type')
                        ->join('fx_orders_items oi on oi.o_id = o.o_id')
                        // ->join('fx_goods_info gi on gi.g_id = oi.g_id')
                        ->where($ary_where)
                        ->order('o.o_create_time desc')
                        ->distinct('o.o_id')
                        ->limit($offset . ',' . $pagesize)
                        //->group('o.o_id')
                        ->select();
		//echo M()->getLastSql();exit;
        //dump($ary_orders_info);exit;                
        foreach($ary_orders_info as $key=>$value){
            //$value['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];
            $map=array();
            if($value['is_diff'] == '0'){//未拆分
                $map['o.o_id'] = $value ['o_id'];
            }else{
                //$map['o.initial_o_id'] = array('neq',''); 
                $map['o.initial_o_id'] = array('neq',0);
				$map['o.initial_o_id'] = $value ['o_id'];
            }
            //$map['o.initial_o_id'] = array('neq','0');
            //$map['oi.o_id'] = $value ['o_id'];
            $ary_goods = M('orders_items', C('DB_PREFIX'), 'DB_CUSTOM')
                        ->alias('oi')
                        // ->join('fx_goods_info gi on gi.g_id = oi.g_id')
                        // ->join('fx_goods_products gp on gp.g_id = gi.g_id')
                        // ->join('fx_orders o on oi.o_id = o.o_id')
                        ->join('fx_goods_info gi on gi.g_id = oi.g_id')
                        ->join('fx_goods g on g.g_id = oi.g_id')
                        ->join('fx_goods_products gp on gp.pdt_id = oi.pdt_id')
                        ->join('fx_orders o on oi.o_id = o.o_id')                        
                        ->where($map)
                        // ->where(array(
                        //             'oi.o_id' => $value ['o_id']
                        //         ))
                        ->field('oi.o_id,oi.g_id,oi.oi_g_name,oi.oi_nums,oi.oi_price,gp.pdt_id,gi.g_picture,gi.extension_spec,o.o_receiver_name,o.o_status,o.o_all_price,oi.oi_refund_status,o.o_audit,o.express_status,o.o_pay_status,o.o_cost_freight,o.order_type')
                        ->select();
            //dump($ary_goods);exit;
            $count_num = count($ary_goods);//订单中的商品种类（不是件数）          
            foreach($ary_goods as $k=>$v){
                $thumbname = $this->thumbname($v['g_picture'],200,200);                
                $ary_goods[$k]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;
                // if($count_num == '1'){//订单内只有一种商品
                //     $ary_goods[$k]['total_price'] = sprintf('%0.2f',$v['oi_nums']*$v['oi_price']+$value['o_cost_freight']-$value['o_coupon_menoy']);//单价X数量+运费-优惠（运费是指父订单的总运费） 
                // }else{
                //     $ary_goods[$k]['total_price'] = sprintf('%0.2f',$v['oi_nums']*$v['oi_price']+$v['o_cost_freight']);//单价X数量+每种商品均摊运费-每种商品均摊优惠（运费是指父订单的总运费）  
                // }
                $ary_goods[$k]['total_price'] = sprintf('%0.2f',$v['o_all_price']);
				//$ary_goods[$k]['rr_status'] = '6'

                //返回子订单状态


                if( $v['o_status'] != 2 ) {
                    if( $v['o_pay_status'] == 0) {
                        
                        $ary_goods[$k]['rr_status'] = "3";//待付款

                    }elseif($v['o_pay_status'] == 3){
                        $ary_goods[$k]['rr_status'] = "8";//部分支付
                        
                    }else{
                          if( $v['o_audit'] == 0){
                                 $ary_goods[$k]['rr_status'] = "6";//待确认
                          }else{
                                // if( $v['express_status'] == 3){
                                //         $ary_goods[$k]['rr_status'] = "7";//通关中  
                                // }else if($v['express_status'] == 2){
                                //         $ary_goods[$k]['rr_status'] = "2";//待收货  
                                //     if ($v['o_status'] == 4) {
                                //         $ary_goods[$k]['rr_status'] = "5";//已完成 
                                //     }
                                //     // else{
                                //     //     $ary_goods[$k]['rr_status'] = "6";//待确认 
                                //     // }    
                                // }else{
                                //     // if ($v['o_status'] == 4) {
                                //     //     $ary_goods[$k]['rr_status'] = "5";//已完成  
                                //     // }else{
                                //         $ary_goods[$k]['rr_status'] = "6"; //待确认（其实是已确认，但app端没有 已确认 这个状态） 
                                //     // }    
                                // }
                                 if ($v['o_status'] == 4) {
                                     $ary_goods[$k]['rr_status'] = "5";//已完成   
                                 }else{//未完成，已确认
                                    if($v['order_type'] == 0 && $v['express_status'] != 2){//0：完税  1：保税 2：直邮 3:合并支付
                                       $ary_goods[$k]['rr_status'] = "6";//待确认  
                                    }else{
                                       // $ary_goods[$k]['rr_status'] = "7";//通关中 
                                        if($v['express_status'] == 2){
                                            $ary_goods[$k]['rr_status'] = "2";//待收货
                                        }else{                                         
                                            $ary_goods[$k]['rr_status'] = "7";//通关中    
                                        }

                                    }

                                 } 

                          }

                   }
                }elseif($v['o_status'] == '2' && $v['erp_status'] == '5'){
                  
                    $ary_goods[$k]['rr_status'] = "10";//异常订单

                }else{
                    $ary_goods[$k]['rr_status'] = "9";//已取消
                }


                $ary_orders_info[$key]['total_quantity'] += $v['oi_nums'];

            }            

            $ary_orders_info[$key]['details'] = $ary_goods;
            
            //返回父订单状态

            if( $value['o_status'] != 2 ) {
                if( $value['o_pay_status'] == 0) {
                    
                    $ary_orders_info[$key]['r_status'] = "3";//待付款

                }elseif($value['o_pay_status'] == 3){
                    $ary_orders_info[$key]['r_status'] = "8";//部分支付
                    
                }else{
                      if( $value['o_audit'] == 0){
                             $ary_orders_info[$key]['r_status'] = "6";//待确认
                      }else{
                            // if( $value['express_status'] == 3){
                            //         $ary_orders_info[$key]['r_status'] = "7";//通关中  
                            // }else if($value['express_status'] == 2){
                            //         $ary_orders_info[$key]['r_status'] = "2";//待收货  
                            //     if ($value['o_status'] == 4) {
                            //         $ary_orders_info[$key]['r_status'] = "5";//已完成 
                            //     }
                            //     // else{
                            //     //     $ary_orders_info[$key]['r_status'] = "6";//待确认 
                            //     // }    
                            // }else{
                            //     // if ($value['o_status'] == 4) {
                            //     //     $ary_orders_info[$key]['r_status'] = "5";//已完成  
                            //     // }else{
                            //         $ary_orders_info[$key]['r_status'] = "6"; //待确认（其实是已确认，但app端没有 已确认 这个状态） 
                            //     // }    
                            // }
                                 if ($value['o_status'] == 4) {
                                     $ary_orders_info[$key]['r_status'] = "5";//已完成  
                                 }else{//未完成，已确认
                                    if($value['order_type'] == 0 && $value['express_status'] != 2){//0：完税  1：保税 2：直邮 3:合并支付
                                       $ary_orders_info[$key]['r_status'] = "6";//待确认  
                                    }else{
                                        //$ary_orders_info[$key]['r_status'] = "7";//通关中
                                        if($value['express_status'] == 2){
                                            $ary_orders_info[$key]['r_status'] = "2";//待收货
                                        }else{
                                            $ary_orders_info[$key]['r_status'] = "7";//通关中
                                        }
                                    }

                                 }  

                      }

               }
            }elseif($value['o_status'] == '2' && $value['erp_status'] == '5'){
              
                $ary_orders_info[$key]['r_status'] = "10";//异常订单

            }else{
                $ary_orders_info[$key]['r_status'] = "9";//已取消
            }

            // $ary_orders_info[$key]['r_status'] = $r_status;

            //如果是未付款，返回时间戳或者空
    
            if($value['o_status'] != '2'&&$value['o_pay_status'] != '1'){//未取消且未付款的订单
				//if($value['o_pay_status'] != '1'){
					$now_time = time();//
					//dump($now_time);exit;
					$o_create_time = strtotime('+1 day',strtotime($value['o_create_time']));//订单创建时间24小时
					//dump($o_create_time);exit;
					$time_diff = $o_create_time - $now_time;//时间差
                    if(0>$time_diff){//如果到时间了，则把订单状态变成已取消
                        $time_diff = '';
                        $status = 2;//已取消 o_status == '2'
                        D('Orders')->UpdateOrderStatus($value ['o_id'], $status);
                        
                    }
				//}

            }else{
                $time_diff = '';
            }

            $ary_orders_info[$key]['time_diff'] = (string)$time_diff;

            $ary_orders_info[$key]['need_pay'] = sprintf('%0.2f',$value['o_all_price'] - $value['o_pay']); //还需支付  	
			

        }  


        //dump($ary_goods);exit;
        //$ary_orders_info = array_unique($ary_orders_info);//只能去除一维数组
        $ary_orders_info = $this->array_unique_2d($ary_orders_info);
        //dump($ary_orders_info);exit;
        //echo $orders->getlastsql();

        output_datas($ary_orders_info,array('result' =>"0",'error_code' =>0,'desc'=>'成功'));


	}

	public function time2second($seconds){
		$seconds = (int)$seconds;
		if( $seconds<86400 ){//如果不到一天
			$format_time = gmstrftime('%H时%M分%S秒', $seconds);
		}else{
			$time = explode(' ', gmstrftime('%j %H %M %S', $seconds));//Array ( [0] => 04 [1] => 14 [2] => 14 [3] => 35 ) 
			$format_time = ($time[0]-1).'天'.$time[1].'时'.$time[2].'分'.$time[3].'秒';
		}
		return $format_time;
	}	
	




    // url : http://www.xingyun.com:8080/Api/Orders/orderDetlide?token=dd11d73ecd604e79ca13a74b15cd9177&order_id=201607110946089343
    // 请求方式：get
    // 请求参数： 
    // Action: orderDetlide
    // token:  凭证
    // order_id:订单ID
    // 返回数据
    public function orderDetlide(){

        $ary_post = $this->_get();


        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];


        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->where($condition)->find();

        $ary_where = array();  
        $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');

        $ary_where['o.m_id'] = $m_id; 
        $ary_where['o.o_id'] = $ary_post['order_id'];     
        //父订单信息     
        $value = $orders
                        ->alias('o')
                        ->field('o.o_id,o.ra_id,o.o_all_price,o.o_status,o.o_pay,oi.oi_refund_status,o.o_audit,o.express_status,o.o_pay_status,o.is_diff,o.o_create_time,o.o_cost_freight,o.o_coupon_menoy,o.initial_o_id,bi.bi_money,ps.pc_code,o.o_receiver_state,o.o_receiver_city,o.o_receiver_county,o.o_receiver_name,o.o_receiver_mobile,o.o_receiver_address,o.o_receiver_idcard,o.order_type')
                        ->join('fx_orders_items oi on oi.o_id = o.o_id')
                        ->join('fx_balance_info bi on bi.o_id = o.o_id')
                        ->join('fx_payment_serial ps on ps.o_id = o.o_id')
                        ->where($ary_where)
                        ->distinct('o.o_id')
                        ->find();
        if(empty($value)){
            output_datas(null,array('result' =>"1",'error_code' =>60014,'desc'=>'订单不存在'));
        }                
        //echo M()->getLastSql();exit;            
        //dump($value);exit;                           
        //地址数组
        $addressDic = M('ReceiveAddress')
        ->alias('ra')
        ->join('fx_city_region cr on cr.cr_id = ra.cr_id')
        ->where(array('ra.ra_id'=>$value['ra_id']))
        ->field()
        ->find();
         //dump($addressDic);exit;

        // $cr_id = D('CityRegion')->getFullAddressName($addressDic['cr_id']);   
        $ary_deliver = array();
        //  存到新的地址数组
        $ary_deliver['id'] = $value['ra_id'];//
        // $ary_deliver['province'] = $value['o_receiver_state'];//
        // $ary_deliver['city'] = $value['o_receiver_city'];//
        // $ary_deliver['area'] = $value['o_receiver_county'];//
        $ary_deliver['address'] = $value['o_receiver_address'];//详细地址
        $ary_deliver['idno'] = $value['o_receiver_idcard'];
        //$ary_deliver['idno'] = $addressDic['ra_id_card'];
        $ary_deliver['accept_name'] = $value['o_receiver_name'];//
        $ary_deliver['mobile'] = $value['o_receiver_mobile'];//
        $ary_deliver['cr_id'] = $value['o_receiver_state'].' '.$value['o_receiver_city'].' '.$value['o_receiver_county'];
        //返回省市区id
        $ary_deliver['province_id']= $this->get_address_id($value['o_receiver_state']);
        $ary_deliver['city_id']= $this->get_address_id($value['o_receiver_city']);
        $ary_deliver['area_id']= $this->get_address_id($value['o_receiver_county']);
        //dump($ary_deliver);exit;
        // if(empty($ary_deliver)){
        //     $ary_deliver = array();
        // }
                        
        $map=array();
        if($value['is_diff'] == '0'){//未拆分
            $map['o.o_id'] = $value ['o_id'];
        }else{
            // $map['o.initial_o_id'] = array('neq',''); 
            $map['o.initial_o_id'] = array('neq',0);
            $map['o.initial_o_id'] = $value ['o_id'];
        }
        //$map['o.initial_o_id'] = array('neq','0');
        //$map['oi.o_id'] = $value ['o_id'];
        $ary_goods = M('orders_items', C('DB_PREFIX'), 'DB_CUSTOM')
                    ->alias('oi')
                    ->join('fx_goods_info gi on gi.g_id = oi.g_id')
                    ->join('fx_goods g on g.g_id = oi.g_id')
                    ->join('fx_goods_products gp on gp.pdt_id = oi.pdt_id')
                    ->join('fx_orders o on oi.o_id = o.o_id')
                    ->where($map)
                    // ->where(array(
                    //             'oi.o_id' => $value ['o_id']
                    //         ))
                    ->field('oi.o_id,oi.g_id,oi.oi_g_name,oi.oi_nums,oi.oi_price,gi.g_picture,gi.extension_spec,gi.g_unit,gi.trade_type,gp.pdt_id,o.o_status,oi.oi_refund_status,o.o_audit,o.express_status,o.o_pay_status,o.o_cost_freight,o.order_type')
                    ->order('gi.trade_type desc')
                    ->select();
        //dump($ary_goods);exit;            
        foreach($ary_goods as $k=>$v){
            $thumbname = $this->thumbname($v['g_picture'],200,200);
            $ary_goods[$k]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;
            $ary_goods[$k]['oi_price'] = sprintf('%0.2f',$v['oi_price']);
            $ary_goods[$k]['total_price'] = sprintf('%0.2f',$v['oi_nums']*$v['oi_price']+$v['o_cost_freight']);
            // if($value['initial_o_id'] == ""){//父订单
            //     $value['o_cost_freight'] = $value['o_cost_freight'];//父订单的运费字段有值
            // }else{//数据库中每个子订单的o_all_price字段已包含运费，子订单的运费字段无值，需单独算出
            //     $value['o_cost_freight'] = sprintf('%0.2f',$value['o_all_price'] - $v['oi_nums']*$v['oi_price']);
            // }

            //$ary_goods[$k]['rr_status'] = '6';
            //返回子订单状态

            if( $v['o_status'] != 2 ) {
                if( $v['o_pay_status'] == 0) {
                    
                    $ary_goods[$k]['rr_status'] = "3";//待付款

                }elseif($v['o_pay_status'] == 3){
                    $ary_goods[$k]['rr_status'] = "8";//部分支付
                    
                }else{
                      if( $v['o_audit'] == 0){
                             $ary_goods[$k]['rr_status'] = "6";//待确认
                      }else{
                            // if( $v['express_status'] == 3){
                            //         $ary_goods[$k]['rr_status'] = "7";//通关中  
                            // }else if($v['express_status'] == 2){
                            //         $ary_goods[$k]['rr_status'] = "2";//待收货  
                            //     if ($v['o_status'] == 4) {
                            //         $ary_goods[$k]['rr_status'] = "5";//已完成 
                            //     }
                            //     // else{
                            //     //     $ary_goods[$k]['rr_status'] = "6";//待确认 
                            //     // }    
                            // }else{
                            //     // if ($v['o_status'] == 4) {
                            //     //     $ary_goods[$k]['rr_status'] = "5";//已完成  
                            //     // }else{
                            //         $ary_goods[$k]['rr_status'] = "6"; //待确认（其实是已确认，但app端没有 已确认 这个状态） 
                            //     // }    
                            // }
                                 if ($v['o_status'] == 4) {
                                     $ary_goods[$k]['rr_status'] = "5";//已完成   
                                 }else{//未完成，已确认
                                    if($v['order_type'] == 0 && $v['express_status'] != 2){//0：完税  1：保税 2：直邮 3:合并支付
                                       $ary_goods[$k]['rr_status'] = "6";//待确认   
                                    }else{
                                       //$ary_goods[$k]['rr_status'] = "7";//通关中 
                                        if($v['express_status'] == 2){
                                            $ary_goods[$k]['rr_status'] = "2";//待收货
                                        }else{
                                            $ary_goods[$k]['rr_status'] = "7";//通关中
                                        }

                                    }

                                 } 

                      }

               }
            }elseif($v['o_status'] == '2' && $v['erp_status'] == '5'){
              
                $ary_goods[$k]['rr_status'] = "10";//异常订单

            }else{
                $ary_goods[$k]['rr_status'] = "9";//已取消
            }


        }            

  
            //dump($ary_goods);exit;
            $tax_goods = array();
            $pos_goods = array();
            $tax_goods = array();

            //1保税2直邮0普通

        foreach($ary_goods as $val){
            switch ($val['trade_type']) {
                case '1':
                    $tax_goods['name'] = '保税商品';
                    $tax_goods['freight'] = "0.00";//运费
                    $tax_goods['order_amount'] += strval($val['oi_nums']*$val['oi_price']);//商品总计价格
                    $tax_goods['order_amount'] =  sprintf('%0.2f',$tax_goods['order_amount']);
                    $tax_goods['total_quantity'] += $val['oi_nums']; //商品总数量              
                    $tax_goods["totalTaxes"] = "0.00";//税费
                    $tax_goods['goodsList'][] = $val;//商品列表
                    break;
                case '2':
                    $pos_goods['name'] = '直邮商品';
                    $pos_goods['freight'] = "0.00";//运费       
                    $pos_goods['order_amount'] += strval($val['oi_nums']*$val['oi_price']);
                    $pos_goods['order_amount'] =  sprintf('%0.2f',$pos_goods['order_amount']);
                    $pos_goods['total_quantity'] += $val['oi_nums']; 
                    $pos_goods["totalTaxes"] = "0.00";//税费   
                    $pos_goods['goodsList'][] = $val; 
                    break;
                case '0':
                    $odn_goods['name'] = '完税商品';
                    $odn_goods['freight'] = "0.00";//运费           
                    $odn_goods['order_amount'] += strval($val['oi_nums']*$val['oi_price']);
                    $odn_goods['order_amount'] =  sprintf('%0.2f',$odn_goods['order_amount']);
                    $odn_goods['total_quantity'] += $val['oi_nums'];  
                    $odn_goods["totalTaxes"] = "0.00";//税费   
                    $odn_goods['goodsList'][] = $val;  
                    break;                                    
                // default:
                //     # code...
                //     break;
            }

         
            //dump($tax_goods);exit;
            $orderList = array($tax_goods,$pos_goods,$odn_goods);
            //$orderList = array_filter($orderList);//过滤空数组
            $arr = array();
            foreach($orderList as $ok => $ov){
                if (empty($ov)) {  
                    continue;  
                }  
                $arr[] = $ov;//去掉空数组是，键值自增  

            }

        }
            
        //返回父订单状态

        if( $value['o_status'] != 2 ) {
            if( $value['o_pay_status'] == 0) {
                
                $value['r_status'] = "3";//待付款

            }elseif($value['o_pay_status'] == 3){
                $value['r_status'] = "8";//部分支付
                
            }else{
                  if( $value['o_audit'] == 0){
                         $value['r_status'] = "6";//待确认
                  }else{
                        // if( $value['express_status'] == 3){
                        //         $value['r_status'] = "7";//通关中  
                        // }else if($value['express_status'] == 2){
                        //         $value['r_status'] = "2";//待收货  
                        //     if ($value['o_status'] == 4) {
                        //         $value['r_status'] = "5";//已完成 
                        //     }
                        //     // else{
                        //     //     $value['r_status'] = "6";//待确认 
                        //     // }    
                        // }else{
                        //     // if ($value['o_status'] == 4) {
                        //     //     $value['r_status'] = "5";//已完成  
                        //     // }else{
                        //          $value['r_status'] = "6"; //待确认（其实是已确认，但app端没有 已确认 这个状态） 
                        //     // }    
                        // }
                                 if ($value['o_status'] == 4) {
                                     $value['r_status'] = "5";//已完成  
                                 }else{//未完成，已确认
                                    if($value['order_type'] == 0 && $value['express_status'] != 2){//0：完税  1：保税 2：直邮 3:合并支付
                                       $value['r_status'] = "6";//待确认   
                                    }else{
                                        //$value['r_status'] = "7";//通关中
                                        if($value['express_status'] == 2){
                                            $value['r_status'] = "2";//待收货   
                                        }else{
                                            $value['r_status'] = "7";//通关中
                                        }
                                    }

                                 } 

                  }

           }
        }elseif($value['o_status'] == '2' && $value['erp_status'] == '5'){
          
            $value['r_status'] = "10";//异常订单

        }else{
            $value['r_status'] = "9";//已取消
        }



        //$value['r_status'] = $r_status;

        //如果是未付款，返回时间戳或者空

        if($value['o_status'] != '2'&&$value['o_pay_status'] != '1'){//未取消且未付款的订单
            //if($value['o_pay_status'] != '1'){
                $now_time = time();//
                //dump($now_time);exit;
                $o_create_time = strtotime('+1 day',strtotime($value['o_create_time']));//订单创建时间24小时
                //dump($o_create_time);exit;
                $time_diff = $o_create_time - $now_time;//时间差
                if(0>$time_diff){//如果到时间了，则把订单状态变成已取消
                    $time_diff = '';
                    $status = 2;//已取消 o_status == '2'
                    D('Orders')->UpdateOrderStatus($value ['o_id'], $status);
                    
                }
            //}

        }else{
            $time_diff = '';
        }

        $value['time_diff'] = (string)$time_diff;   
        //计算订单总金额：商品总金额+运费-优惠券金额    
        // $value['o_all_order_price'] = sprintf('%0.2f',$value['o_all_price'] + $value['o_cost_freight'] - $value['o_coupon_menoy']);
        $value['o_all_order_price'] = $value['o_all_price'];//订单总额
        $value['o_goods_price'] = sprintf('%0.2f',$value['o_all_price'] - $value['o_cost_freight'] + $value['o_coupon_menoy']);//商品总额
        //显示这个订单余额支付部分balance_fee，第三方支付部分(主要是支付宝)third_fee，还需支付部分need_fee
        //先查与这个订单有关的消费记录 balance_info表
        //M('BalanceInfo')->where(array('o_id'=>$value['o_id']))->find();
        //$value['balance_fee'] = $value['bi_money'];
        
        // if($value['o_pay_status'] == '3'){//混合支付未完成，部分支付
        //     $value['third_fee'] = '0.00';
        //     $value['need_fee'] = sprintf('%0.2f',$value['o_all_price'] - $value['bi_money']);     
        // }else{//混合支付已完成
        //     $value['third_fee'] = sprintf('%0.2f',$value['o_all_price'] - $value['bi_money']);
        //     $value['need_fee'] = '0.00';
        // }
        $value['need_pay'] = sprintf('%0.2f',$value['o_all_price'] - $value['o_pay']); //还需支付
        //$value['need_fee'] = $value['third_fee'];
        $value['payment'] = $value['pc_code'];
        $value['addressDic'] = $ary_deliver;

        $value['orderList'] = $arr;


        output_datas($value,array('result' =>"0",'error_code' =>0,'desc'=>'成功'));
       

    }




    public function test(){

        $url = 'http://www.xingyun.com:8080/Api/Orders/shopping';
      
        $post_data['token'] = '94d6658000bbc30693b9d31989615462';

        $post_data['shopping_buy']='[
            {
                "pdt_id": "1083",
                "pdt_nums": "2"
            },
            {
                "pdt_id": "1030",
                "pdt_nums": "5"
            },
            {
                "pdt_id": "1031",
                "pdt_nums": "6"
            },
            {
                "pdt_id": "172",
                "pdt_nums": "2"
            },
            {
                "pdt_id": "173",
                "pdt_nums": "2"
            }


        ]';
        $post_data['coupon_input'] = 'HxXZ12787670';

        $post_data['order_id'] = '201606021525537638';
        $post_data['o_payment'] = '2';
        $post_data['mixture'] = '1';
        $post_data['mobile'] = '18825500151';
        $post_data['idno'] = '429001198504121111';
        $post_data['goodsSn'] = 'MBS03782-B';
        $post_data['nums'] = '5';
        //$post_data['provinceName'] = '西藏';
        //$post_data['province_id'] = '540000';
        //$post_data['order_id'] = '201607250853461241';

        $post_data['addressDic'] = '{"idno": "429004198501231145","accept_name": "12345","province_id": "330000","city_id": "330100","area_id": "330104","id": "657","mobile": "15976887741","address": "天行云公司"}';

        $o = "";
        foreach ( $post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url, $post_data);       
        print_r($res);

    }





    // 请求方式：post
    // 请求参数：Action ：shopping（固定）
    // token:  凭证
    // province_id 省份id （为空则取默认地址的省份id）
    // mobile:  手机号
    // idno:  身份证号
    // shopping_buy=[
    //     {
    //         "pdt_id": "588",
    //         " pdt_nums ": "5"
    //     },
    //     {
    //         " pdt_id ": "589",
    //         " pdt_nums ": "6"
    //     },
    //     {
    //         " pdt_id ": "233",
    //         " pdt_nums ": "2"
    //     }
    // ]
    // 返回data
    public function shopping(){

        $ary_post = $this->_post();
        


        //$address = json_decode($ary_post['address'],true);

        $shopping_buy = json_decode($ary_post['shopping_buy'],true); 
        //dump($shopping_buy);exit;      
        //dump($address);exit;
        $coupon_input = $ary_post['coupon_input'];
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];

        $ml_id = $this->get_user_level($m_id);//会员等级id
        //dump($ml_id);exit;
        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->where($condition)->find();
        //dump($member_info);exit;
        //如果接收到province_id
        if($ary_post['province_id']){

            $provinceName = $this->getProvinceName($ary_post['province_id']);//获取省份名称，方便算运费     
        }else{
            $ary_addr = D('CityRegion')->ApiReceivingAddressPage($m_id); 
            $ary_deliver = $ary_addr['addr'][0];//取默认地址

            //dump($ary_deliver);exit;

            $id = M('ReceiveAddress')
            ->alias('ra')
            ->join('fx_city_region cr on cr.cr_id = ra.cr_id')
            ->where(array('ra.ra_id'=>$ary_deliver['id']))
            ->field('cr.cr_path,cr.cr_id')
            ->find();
            //echo M()->getLastSql();exit;
            //dump($id);exit;
            $id_arr = explode('|', $id['cr_path']);
            //dump($id_arr[1]);exit;
           
            //  存到新的地址数组
            //dump($id_arr);exit;
            $ary_deliver_new = $ary_addr['addr'][0];
            $ary_deliver_new['province_id'] = $id_arr[1];//省
            $ary_deliver_new['city_id'] = $id_arr[2];//市
            $ary_deliver_new['area_id'] = $id['cr_id'];//区

            if(empty($id_arr[2])){//例如东莞,最后一级没有
                $ary_deliver_new['city_id'] = $id['cr_id'];//市id = 区id
                $ary_deliver_new['area_id'] = '';
            }
            //dump($ary_deliver_new);exit;

            $provinceName = $this->getProvinceName($id_arr[1]);//获取省份名称，方便算运费

        }

        //dump($provinceName);exit;
        $ary_orders = array();

        foreach($shopping_buy as $k=>$v){
            // $ary_orders['user_order_num'] += $v['quantity'];
            //$ary_orders[$k]['g_id'] = $v['goodsid'];
            $info = $this->get_goods_info($v['pdt_id'],$ml_id);
            //库存$info['pdt_stock'],最小起发数$info['number_least']
            if(0 >= $info['pdt_stock']){

               
                output_datas(null,array('result' =>"1",'error_code' =>60005,'desc'=>$info['g_name'].'已售完'));
                die();
            }
            if($info['pdt_stock']<$v['pdt_nums']){

                output_datas(null,array('result' =>"1",'error_code' =>60027,'desc'=>$info['g_name'].'库存数量仅剩'.$info['pdt_stock']));
                die();
            }                                       
            // if($v['pdt_nums'] < $info['number_least']){//$info['pdt_min_num']
               
            //     output_datas(null,array('result' =>"1",'error_code' => 60006, 'desc' => $info['g_name'].'购买数量不能小于'.$info['number_least']));
            //     die();
            // }

            if ($v['pdt_nums'] < $info['pdt_min_num']){

                output_datas(null,array('result' =>"1",'error_code' => 60006, 'desc' => $info['g_name'].'至少需购买'.$info['pdt_min_num'].'件！'));
                die();
            }
            if ($info['pdt_max_num'] > 0 && $v['pdt_nums'] > $info['pdt_max_num']){

                output_datas(null,array('result' =>"1",'error_code' => 60026, 'desc' => $info['g_name'].'最大可购买'.$info['pdt_max_num'].'件！'));
                die();                
            }

         
            // //通过商品货号查询商品贸易类型(仅保税和直邮才有限额判断)
            // $goodsSn = $info['g_sn'];//商品货号
            // $mobile = $ary_post['mobile'];//手机号
            // $cardNum = $ary_post['idno'];//身份证号
            // //dump($cardNum);exit;

            // $goodsTrade = $info['g_trade'];//1保税2直邮0完税
            // //dump($goodsTrade);exit;
            // //检查手机号和身份证号是否有限额
            // $countResult = D("Orders")->limitIsExit($goodsTrade, $mobile, $cardNum);
            // //echo M()->getlastsql();exit;
            // //var_dump($countResult);die;
            // $countMobileNum = intval($countResult['mobileCount']);
            // $countCardNum = intval($countResult['cardCount']); 
            // if($goodsTrade=="1" && $countMobileNum>2 || $countCardNum>2){//保税
            //     output_datas(null,array('result' =>"1",'error_code' =>60028,'desc'=>'由于海关清关限制,同一手机或身份证保税商品一天不能超2单,直邮商品一天只能1单!'));
            // }elseif($goodsTrade=="2" && $countMobileNum>1 || $countCardNum>1){//直邮
            //     output_datas(null,array('result' =>"1",'error_code' =>60028,'desc'=>'由于海关清关限制,同一手机或身份证保税商品一天不能超2单,直邮商品一天只能1单！'));
            // }


            //dump($info);exit;
            if(empty($info['c_name'])){//发货仓
                $info['c_name'] = "其他仓";
            }            

            $shopping_buy[$k]['g_trade'] = $info['g_trade'];
            $shopping_buy[$k]['g_name'] = $info['g_name'];
            $shopping_buy[$k]['g_picture'] = $info['g_picture'];
            $shopping_buy[$k]['c_name'] = $info['c_name'];
            $shopping_buy[$k]['g_sn'] = $info['g_sn'];
            $shopping_buy[$k]['extension_spec'] = $info['extension_spec'];
            $shopping_buy[$k]['g_price'] = $info['g_price'];
            //$shopping_buy[$k]['pmlp_price'] = sprintf("%0.2f",$info['pmlp_price']);
            if($info['pmlp_price'] == '0.000'){
                $shopping_buy[$k]['pmlp_price'] = $info['g_price'];//价格保留两位小数
            }else{
                $shopping_buy[$k]['pmlp_price'] = sprintf("%0.2f",$info['pmlp_price']);//价格保留两位小数
            }
            
            $shopping_buy[$k]['g_id'] = $info['g_id'];
            $shopping_buy[$k]['gb_id'] = $info['gb_id'];
            $shopping_buy[$k]['gc_id'] = $info['gc_id'];
            $thumbname = $this->thumbname($info['g_picture'],200,200);
            $shopping_buy[$k]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;

            $date = date('Y-m-d');
            $where = array();
            $where['c.c_user_id'] = $m_id;
            //优惠券使用状态

            $where['c.c_is_use'] = '0';//未使用
            $where['c.c_end_time'] = array('EGT', $date);//未过期
            //$where['c.gc_id'] = $info['gc_id'];
            $where['c.gc_id'] = array('in',array('0',$info['gc_id']));
            //$where['c.gb_id'] = array('in', $info['gb_id']);
            $ary_coupon = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')
                        ->field('c.c_id,c.c_name,c.gc_id,c.gb_id')
                        ->alias('c')
                        ->where($where)
                        ->order()
                        ->select();
            //echo M()->getlastsql();exit;
            //dump($ary_coupon);exit;
            $count = count($ary_coupon);
            $shopping_buy[$k]['coupon'] = $count;            
       
        }
        //dump($shopping_buy);exit;
        $tax_goods = array();
        $pos_goods = array();
        $odn_goods = array();

        $mCarriageTemplate = D("CarriageTemplate");

        foreach($shopping_buy as $value){//1保税2直邮0普通
            if($value['g_trade'] == '1'){
                $tax_goods['name'] = '保税商品';
                $tax_goods['groupType'] = (int)$value['g_trade'];
                // $postage = $mCarriageTemplate->countCarriage($value['pdt_sn'],$value['pdt_nums'],$provinceName);                
                // $tax_goods['freight'] = sprintf('%0.2f',$postage);//运费
                //如果确认订单页面地址为空，则运费显示为0.00
                // if(empty($ary_deliver) && !$ary_post['province_id']){//当既没有默认地址也没有传省份id（新用户没有收货地址）
                //     $tax_goods['freight'] = '0.00';//运费            
                // }else{
                //     $postage += $mCarriageTemplate->countCarriage($value['g_sn'],$value['pdt_nums'],$provinceName);                
                //     $tax_goods['freight'] = sprintf('%0.2f',$postage);//运费                   
                // }
                $tax_goods['freight'] = "0.00";//假运费                
                $tax_goods['order_amount'] += $value['pdt_nums']*$value['pmlp_price'];//商品总计价格
                $tax_goods['order_amount_clean'] += $value['pdt_nums']*$value['pmlp_price'];//商品总金额  单价X数量
                $tax_goods['order_amount_clean'] = sprintf('%0.2f',$tax_goods['order_amount_clean']);//格式化价格
                $tax_goods['order_amount'] =  sprintf('%0.2f',$tax_goods['order_amount'] + $postage);//加上运费后的订单价格
                $tax_goods['total_quantity'] += $value['pdt_nums']; //商品总数量              
                $tax_goods['total_coupon'] += $value['coupon']; //优惠券总数量 
                $tax_goods["totalTaxes"] = "0.00";//税费
                $tax_goods['goodsList'][] = $value;//商品列表

            }elseif ($value['g_trade'] == '2') {
                $pos_goods['name'] = '直邮商品';
                $pos_goods['groupType'] = (int)$value['g_trade'];
                // $postage = $mCarriageTemplate->countCarriage($value['pdt_sn'],$value['pdt_nums'],$provinceName);                
                // $pos_goods['freight'] = sprintf('%0.2f',$postage);//运费
                //如果确认订单页面地址为空，则运费显示为0.00
                // if(empty($ary_deliver) && !$ary_post['province_id']){//当既没有默认地址也没有传省份id（新用户没有收货地址）
                //     $pos_goods['freight'] = '0.00';//运费            
                // }else{
                //     $postage += $mCarriageTemplate->countCarriage($value['g_sn'],$value['pdt_nums'],$provinceName);                
                //     $pos_goods['freight'] = sprintf('%0.2f',$postage);//运费                   
                // } 
                $pos_goods['freight'] = "0.00";//假运费                 
                $pos_goods['order_amount'] += $value['pdt_nums']*$value['pmlp_price'];//商品总计价格
                $pos_goods['order_amount_clean'] += $value['pdt_nums']*$value['pmlp_price'];//商品总金额  单价X数量
                $pos_goods['order_amount_clean'] = sprintf('%0.2f',$pos_goods['order_amount_clean']);//格式化价格
                $pos_goods['order_amount'] =  sprintf('%0.2f',$pos_goods['order_amount'] + $postage);//加上运费后的订单价格
                $pos_goods['total_quantity'] += $value['pdt_nums']; 
                $pos_goods['total_coupon'] += $value['coupon']; //优惠券总数量
                $pos_goods["totalTaxes"] = "0.00";//税费   
                $pos_goods['goodsList'][] = $value; 
           
            }elseif ($value['g_trade'] == '0'){
                $odn_goods['name'] = '完税商品';
                $odn_goods['groupType'] = (int)$value['g_trade'];
                // $postage = $mCarriageTemplate->countCarriage($value['pdt_sn'],$value['pdt_nums'],$provinceName);                
                // $odn_goods['freight'] = sprintf('%0.2f',$postage);//运费
                //如果确认订单页面地址为空，则运费显示为0.00
                // if(empty($ary_deliver) && !$ary_post['province_id']){//当既没有默认地址也没有传省份id（新用户没有收货地址）
                //     $odn_goods['freight'] = '0.00';//运费            
                // }else{
                //     $postage += $mCarriageTemplate->countCarriage($value['g_sn'],$value['pdt_nums'],$provinceName); 
                //     //dump($postage);exit;               
                //     $odn_goods['freight'] = sprintf('%0.2f',$postage);//运费                   
                // } 
                $odn_goods['freight'] = "0.00";//假运费                 
                $odn_goods['order_amount'] += $value['pdt_nums']*$value['pmlp_price'];//商品总计价格
                $odn_goods['order_amount_clean'] += $value['pdt_nums']*$value['pmlp_price'];//商品总金额  单价X数量
                $odn_goods['order_amount_clean'] = sprintf('%0.2f',$odn_goods['order_amount_clean']);//格式化价格
                $odn_goods['order_amount'] =  sprintf('%0.2f',$odn_goods['order_amount'] + $postage);//加上运费后的订单价格
                $odn_goods['total_quantity'] += $value['pdt_nums'];  
                $odn_goods['total_coupon'] += $value['coupon']; //优惠券总数量 
                $odn_goods["totalTaxes"] = "0.00";//税费   
                $odn_goods['goodsList'][] = $value;  
                                   
            }


            if(empty($ary_deliver) && !$ary_post['province_id']){//当既没有默认地址也没有传省份id（新用户没有收货地址）
                $all_freight = '0.00';//运费            
            }else{
                $postage += $mCarriageTemplate->countCarriage($value['g_sn'],$value['pdt_nums'],$provinceName); 
                //dump($postage);exit;               
                $all_freight = sprintf('%0.2f',$postage);//运费                   
            }  




        }
        //dump($tax_goods);exit;
        $orderList = array($tax_goods,$pos_goods,$odn_goods);
        //$orderList = array_filter($orderList);//过滤空数组
        $arr = array();
        foreach($orderList as $ok => $ov){
            if (empty($ov)) {  
                continue;  
            }  
            $arr[] = $ov;//去掉空数组是，键值自增  

        }
        //dump($arr);exit;
        //dump($orderList);exit;
        $all_price_clean = sprintf("%0.2f",($tax_goods['order_amount_clean'] + $pos_goods['order_amount_clean'] + $odn_goods['order_amount_clean']));
        //dump($all_price_clean);exit;

        //根据coupons_id,查优惠金额（使用优惠券）

        // $coupons_where['c.c_condition_money'] = array('elt',$all_price_clean);
 
        // $now_time = date("Y-m-d H:i:s");
        // $coupons_where['cu.u_id'] = $m_id;
        // $coupons_where['cu.c_sn'] = $coupon_input;//优惠券编码
        // $coupons_where['cu.c_end_time'] = array('EGT', $now_time);
        // $coupons_where['c.c_is_use'] = '0';//未使用
        // $coupon_user = M('couponUser', C('DB_PREFIX'), 'DB_CUSTOM');
        // $couponsToUse = $coupon_user
        //                     ->alias('cu')
        //                     ->join('fx_coupon c on c.c_id = cu.c_id')
        //                     ->field('c.c_id,c.c_name,c.c_sn,c.c_start_time,c.c_end_time,c.c_condition_money,c.c_type,c.c_memo,c.c_money,c.c_coupon_good_id,c.receiveNumber,c.txtIssueNum,c.c_status')
        //                     ->where($coupons_where)
        //                     ->find(); 
                            //echo M()->getlastsql();exit;
        //dump($couponsToUse);exit;   


        $date = date('Y-m-d');
        $where = array();
        $where['c.c_user_id'] = $m_id;
        //优惠券使用状态
        $where['c.c_is_use'] = '0';//未使用
        $where['c.c_end_time'] = array('EGT', $date);//未过期
        $where['c.c_sn'] = $coupon_input;//优惠券编码 
        $couponsToUse = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')
                    //->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_type,c_memo,c_money,gb_id,gc_id,c_coupon_good_id,receiveNumber,txtIssueNum')
                    ->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_is_use,c_condition_money,c_type,c_memo,c_money,c_coupon_good_id')
                    ->alias('c')
                    ->where($where)
                    ->find();
        //dump($couponsToUse);exit;            
        if($couponsToUse){
            $c_money = $couponsToUse['c_money'];
        }else{
            $c_money = '0.00';
        } 
        //dump($c_money);exit;  
        //$all_price = sprintf("%0.2f",($tax_goods['order_amount'] + $pos_goods['order_amount'] + $odn_goods['order_amount']));//单价X数量+运费
        
        //dump($all_price);exit;
        $all_num = $tax_goods['total_quantity'] + $pos_goods['total_quantity'] + $odn_goods['total_quantity'];
        $all_cate = count($tax_goods['goodsList']) + count($pos_goods['goodsList']) + count($odn_goods['goodsList']);
        // $all_freight = sprintf('%0.2f',$tax_goods['freight'] + $pos_goods['freight'] + $odn_goods['freight']);
        $all_price = sprintf("%0.2f",($all_price_clean +$all_freight - $c_money));//单价X数量+运费-优惠 = 实付款
        $ary_where = array();
        $ary_where['c.c_condition_money'] = array('elt',$all_price_clean);
 
        // $now_time = date("Y-m-d H:i:s");
        // $ary_where['cu.u_id'] = $m_id;
        // $ary_where['cu.c_end_time'] = array('EGT', $now_time);
        // $ary_where['c.c_is_use'] = '0';//未使用
        // $coupon_user = M('couponUser', C('DB_PREFIX'), 'DB_CUSTOM');
        // $UserCouponValidation = $coupon_user
        //                     ->alias('cu')
        //                     ->join('fx_coupon c on c.c_id = cu.c_id')
        //                     ->field('c.c_id,c.c_name,c.c_sn,c.c_start_time,c.c_end_time,c.c_condition_money,c.c_type,c.c_memo,c.c_money,c.c_coupon_good_id,c.receiveNumber,c.txtIssueNum,c.c_status')
        //                     ->where($ary_where)
        //                     ->select();
                            //echo M()->getlastsql();exit;
        //dump($UserCouponValidation);exit;    

        $date = date('Y-m-d');
        
        $ary_where['c.c_user_id'] = $m_id;
        //优惠券使用状态
        $ary_where['c.c_is_use'] = '0';//未使用
        $ary_where['c.c_end_time'] = array('EGT', $date);//未过期
 
        $UserCouponValidation = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')
                    //->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_type,c_memo,c_money,gb_id,gc_id,c_coupon_good_id,receiveNumber,txtIssueNum')
                    ->field()
                    ->alias('c')
                    ->where($ary_where)
                    ->select();

        $all_coupon_num = count($UserCouponValidation);

        //dump($all_coupon_num);exit;
                  
        //dump($orderList);exit;
        //dump($all_cate);exit;
        //dump($all_price);
        //dump($all_num);exit;
        if(empty($ary_deliver_new)){
            $ary_deliver_new = array();
        }
        output_datas(array('ml_id'=>$ml_id,'amount'=>$member_info['m_balance'],'all_price'=>$all_price,'all_goods_price'=>$all_price_clean,'all_num'=>$all_num,'all_coupon_num'=>$all_coupon_num,'all_cate'=>$all_cate,'all_freight'=>$all_freight,'c_money'=>$c_money,'orderList'=>$arr,'address'=>$ary_deliver_new),array('result' =>"0",'error_code' =>0,'desc'=>''));




    }



    // 请求方式：post
    // 请求参数：Action ：OrderFinish（固定）
    // token:  凭证
    // order_id 订单号
    // 返回data 
    public function OrderFinish() {

        $ary_post = $this->_post();

        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }

        $m_id = $token['member_id'];
        $condition = array();
        $condition['o.o_id'] = $ary_post ['order_id'];
        $condition['o.m_id'] = $m_id;
        $ary_order_info = M('Orders')
                        ->alias('o')
                        ->field('o.o_status,o.o_pay_status,o.express_status,o.o_audit,oi.oi_refund_status')
                        ->join('fx_orders_items oi on oi.o_id = o.o_id')
                        ->where($condition)
                        ->find();
        //dump($ary_order_info);exit;
        if(!$ary_order_info){
            output_datas(null,array('result' =>"1",'error_code' =>60014,'desc'=>'订单不存在!'));
        }
        
        //已发货的且不是异常状态的才能确认收货 oi_refund_status=1 正常订单
        if($ary_order_info['express_status'] == '2' && $ary_order_info['o_audit'] == '1' && $ary_order_info['oi_refund_status'] == '1'){
            $status = 4;
            D('Orders')->UpdateOrderStatus($ary_post ['order_id'], $status);
            output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'确认收货成功!'));   
        }else{
            output_datas(null,array('result' =>"1",'error_code' =>60015,'desc'=>'确认收货失败!'));  
        }
     

    }







    // 请求方式： post
    // 请求参数： 
    // Action GetFreight （固定）
    // goodsSn 商品货号
    // province_id 省id
    // nums    发货数量
    // 返回data  
    public function GetFreight(){

        $ary_post = $this->_post();
        // $model_mb_user_token = D('MbUserToken');
        // $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        // //dump($token);exit;
        // if(!$token){
        //     output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        // }
        // $m_id = $token['member_id'];
        // $condition = array();
        // $condition['m_id'] = $m_id;
        // $member_info = M("Members")->where($condition)->find();  


        //计算运费 add by zhangdong at 2016-07-21 begin
        $mCarriageTemplate = D("CarriageTemplate");
        // $mOrdersItems = D("OrdersItems");
        // $provinceName = trim($ary_post ['o_receiver_state']);
        // //通过订单号获取对应商品数量和货号
        // $int_oid = $data['o_id'];
        // $ary_field = 'g_sn,oi_nums,o_all_price,o_cost_freight';
        // $orderInfo = $mOrdersItems->getOrderInfo($int_oid, $ary_field);
        // foreach($orderInfo as $value){
        $num = $ary_post['nums'];
        $goodsSn = $ary_post['goodsSn'];
        $provinceName = $this->getProvinceName($ary_post['province_id']);
        //dump($provinceName);exit;
        $postage = $mCarriageTemplate->countCarriage($goodsSn,$num,$provinceName);
        $allPostage[] = $postage;
        // }
        $postPrice = (string)array_sum($allPostage);
        
        //计算运费 end
        // $ary_orders ['o_all_price'] = $orderInfo[0]['o_all_price']-$orderInfo[0]['o_cost_freight']+$postPrice;
        // $ary_orders ['o_cost_freight'] = $postPrice;



        // $freight = $this->countCarriage($ary_post['pdt_id'],$ary_post['pdt_nums'],$ary_post['province_id']);
        $newarr = array();
        $newarr['result'] = '0';
        $newarr['error_code'] = '0';
        $newarr['desc'] = '';
        $newarr['data']['freight'] = $postPrice;    
        $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);
        echo $json;die;        

    }




    
    /**
     * 根据省份id获取省份名称     
     * @author zhangdong
     * @date 2016-07-13
     */
    public function getProvinceName($province_id)
    {
        $mCityRegion = D("CityRegion");
        $where = [];
        $where = [
            //"cr_parent_id"=>1,
            //"cr_type"=>2,
            "cr_id"=>$province_id
        ];
        $result = $mCityRegion->where($where)->getfield("cr_name");        
        return $result;
    }





    // 请求url：http://www.xingyun.com:8080/Api/Orders/order_express?token=dd11d73ecd604e79ca13a74b15cd9177&order_id=201607131007596373 
    // Action (固定) :order_express
    // token:  凭证
    // order_id:订单号
    // 返回data
    public function order_express(){


        $ary_post = $this->_get();

        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];

        $ary_where = array();  
        $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');

        //$ary_where['m_id'] = $m_id;      
        $ary_where['o.o_id'] = $ary_post['order_id'];
             
        $ary_orders_info = $orders
        ->field('o.express,o.express_no,o.o_all_price')
        ->alias('o')
        //->join('fx_orders_items oi on oi.o_id = o.o_id')
        ->where($ary_where)
        ->find();
        //echo M()->getlastsql();exit;
        //dump($ary_orders_info);exit;
        if(!$ary_orders_info){
          output_datas(null,array('result' =>"1",'error_code' =>60014,'desc'=>'订单不存在'));  
          
        }


        output_datas(array('express_no'=>$ary_orders_info['express_no'],'express_cpy'=>$ary_orders_info['express'],'order_price'=>$ary_orders_info['o_all_price']),array('result' =>"0",'error_code' =>0,'desc'=>'查询成功'));
   

    }



    /**
     * 查询物流跟踪信息
     */
     public function getOrdersPostTrack() {

            $ary_post = $this->_post();

            $model_mb_user_token = D('MbUserToken');
            $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
            //dump($token);exit;
            if(!$token){
                output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
            }

            if (!isset($ary_post ["order_id"]) || "" == $ary_post ["order_id"]) {

                // output_datas(null,array('result' =>"1",'error_code' =>70001,'desc'=>'系统集成出错：非法的发货单ID参数传入。')); 
                  output_datas(null,array('result' =>"1",'error_code' =>70001,'desc'=>'物流信息查询失败（错误码70001）'));             
            }

            // 获取订单的物流单信息
            $array_info = D("OrdersDelivery")->where(array(
                        "o_id" => $ary_post ["order_id"]
                    ))->find();
            //dump($array_info);exit;
            $Logistic_company = $array_info['od_logi_name'];//物流公司
            $Logistic_no = $array_info['od_logi_no'];//物流单号
            $Deliver_time = $array_info['od_created'];//发货单创建时间
            if (!is_array($array_info) || empty($array_info)) {

                output_datas(null,array('result' =>"1",'error_code' =>70002,'desc'=>'暂无物流信息'));     
            }

            // 根据物流公司ID获取物流公司对应的快递100的物流公司代码
            $kuaidi100_code = D("LogisticCorp")->where(array(
                        "lc_id" => $array_info ["od_logi_id"]
                    ))->getField("lc_kuaidi100_name");
            //echo M()->getlastsql();exit;
            //dump($kuaidi100_code);exit;
            if (false === $kuaidi100_code || "" == $kuaidi100_code) {

                // output_datas(null,array('result' =>"1",'error_code' =>70003,'desc'=>'快递100物流公司代码未设置。')); 
                output_datas(null,array('result' =>"1",'error_code' =>70003,'desc'=>'物流信息查询失败（错误码70003）')); 
            }

            // 调用快递100接口获取物流跟踪数据
            $kuaidi100_obj = new Kuaidi100 ();
            $result = $kuaidi100_obj->queryDeliveryTrack($kuaidi100_code, $array_info ["od_logi_no"]);
            //dump($result);exit;
            //krsort($result ["data"] ["data"]);
            $post_track_info = $result ["data"] ["data"];
            
            if (empty($post_track_info)){
                $post_track_info = array();
            }            
            //krsort($post_track_info);
            //$post_track_info = array_reverse($post_track_info);
            //dump($post_track_info);exit;
            //加一条额外信息
            $extraInfo = array(
                "time" => $Deliver_time,
                "context" => "卖家已发货",
                "ftime" => $Deliver_time
            );
            //dump($extraInfo);exit;
            array_push($post_track_info, $extraInfo);
            //dump($post_track_info);exit;
            output_datas(array('express'=>$Logistic_company,'express_no'=>$Logistic_no,'express_info'=>$post_track_info),array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!')); 
            
        }







        /**
     * 生成一张支付序列单
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-23
     * @param int $int_type 0代表支付订单 1代表预存款充值
     * @param array $ary_order 订单信息
     * @param $pay_type 付款类型 0全额支付 1定金支付 2尾款支付
     * @return int 返回支付单序列号，用于第三方平台支付
     */
    protected function addPaymentSerial($int_type = 0, $ary_order = array(),$pay_type = 0,$m_id,$pc_code) {
        //订单支付时，确定支付宝商户订单号 Add Terry 2013-08-26
        if($pay_type==''){ //add by zhangjiasuo 2015-05-29
            $pay_type =0;
        }
        $ary_ps = D('PaymentSerial')->where(array('o_id'=>$ary_order['o_id']))->find();
        if(!empty($ary_ps) && $ary_ps['ps_money'] == $ary_order['o_all_price']){
            return $ary_ps['ps_id'];
        }else{
            $data = array(
                'm_id' => $m_id,
                'pc_code' => $pc_code,
                'ps_money' => $ary_order['o_all_price'],
                'ps_type' => $int_type,
                'o_id' => $ary_order['o_id'],
                'ps_status' => 0,
                'pay_type' => $pay_type,
                'ps_create_time' => date('Y-m-d H:i:s'),
                'ps_update_time' => date('Y-m-d H:i:s')
            );
            $int_ps_id = D('PaymentSerial')->data($data)->add();
            if (false == $int_ps_id) {
                output_datas(null,array('result' =>"1",'desc'=>'生成支付序列号失败'));
            } else {
                return $int_ps_id;
            }
        }

        
    }






    /**
     * 订单支付
     * 
     * @param int $order_id
     *          订单ID
     * @param ary $oreder
     *          更新订单表数组
     * @return boolean
     */
    public function paymentPage($int_id,$payment_id,$pay_stat,$pay_code,$m_id) 
    {

        $where = array();
        $condition = array();
        $condition['m_id'] = $m_id;
        $ary_member = M("Members")->where($condition)->find();		
        //$ary_member = $this->member_info;
        $where ['fx_orders.o_id'] = $int_id;
        // if ($pay_stat == 2) { // 如果当前是尾款支付
        //     $where ['fx_orders.o_pay_status'] = 3;
        // } else {
        //     $where ['fx_orders.o_pay_status'] = 0;
        // }
        $where ['fx_orders.o_pay_status'] = array('in','0,3');
        $where ['fx_orders.o_status'] = array(array('eq','1'),array('eq','3'),'or');
        $search_field = array(
            'fx_orders.o_all_price',
            'fx_orders.o_payment',
            'fx_orders.o_pay',
            'fx_members.m_id',
            'fx_orders.o_pay_status',
            'fx_orders.o_reward_point',
            'fx_orders.o_freeze_point',
            'fx_orders_items.pdt_id',
            'fx_orders_items.oi_nums',
            'fx_orders_items.oi_type',
            'fx_orders_items.fc_id',
            'fx_orders_items.g_id',
            'fx_orders.lt_id',
            'fx_orders.o_receiver_mobile',
            'fx_orders.o_receiver_name'
        );

        if (isset($int_id)) {
            $ary_orders_data = D('Orders')->getOrdersData($where, $search_field, $group='');
            
            if (empty($ary_orders_data) && count($ary_orders_data) <= 0) {
                 output_datas(null,array('result' =>"1",'desc'=>'订单不存在或已支付！'));
            }
            $ary_orders = $ary_orders_data [0];
        }
        //查询库存,如果库存数为负数则不再扣除库存
        $int_pdt_stock = M('orders_items',C('DB_PREFIX'),'DB_CUSTOM')
                        ->field('pdt_stock,oi_nums')
                        ->where(array('o_id'=>$int_id))
                        ->join(C('DB_PREFIX').'goods_products as gp on gp.pdt_id = '.C('DB_PREFIX').'orders_items.pdt_id')
                        ->find();
        if($ary_orders['oi_type'] ==5 || $ary_orders['oi_type'] ==8){
                if(0 >= $int_pdt_stock['pdt_stock']){
                    output_datas(null,array('result' =>"1",'desc'=>'该货品已售完！'));
                }
                //没有结果
                if($int_pdt_stock['pdt_stock']<$int_pdt_stock['oi_nums']){
                     output_datas(null,array('result' =>"1",'desc'=>'该货品已售完！'));
                }
        }else{
            if(0 >= $int_pdt_stock['pdt_stock']){
              output_datas(null,array('result' =>"1",'desc'=>'该货品已售完！'));
            }
                //没有结果      
        }
        M('', '', 'DB_CUSTOM')->startTrans();
        
        // 支付流程改造【团购】
        if ($ary_orders ['oi_type'] == '5') { // 团购订单
       
            $groupbuy = M('groupbuy', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                        'gp_id' => $ary_orders ['fc_id']
                    ))->find();
            if ($pay_stat == 0) {
                // 团购全额支付
                //验证团购商品是否可以支付
                $is_pay = D('Groupbuy')->checkBulkIsBuy($ary_orders['m_id'],$groupbuy['gp_id'],$int_id,1);
                if($is_pay['status'] == false){
                    M('', '', 'DB_CUSTOM')->rollback();
                    $this->error($is_pay['msg'], U('Ucenter/Orders/pageShow/', array('oid' => $int_id)));
                }
                $o_pay = $ary_orders ['o_all_price'];
            } elseif ($pay_stat == 1) {
                // 团购定金支付,获取定金
                $is_pay = D('Groupbuy')->checkBulkIsBuy($ary_orders['m_id'],$groupbuy['gp_id'],$int_id,1);
                if($is_pay['status'] == false){
                    M('', '', 'DB_CUSTOM')->rollback();
                    $this->error($is_pay['msg'], U('Ucenter/Orders/pageShow/', array('oid' => $int_id)));
                }
                $o_pay = sprintf("%0.3f", $groupbuy ['gp_deposit_price'] * $ary_orders ['oi_nums']);
            } elseif ($pay_stat == 2) {
                // 尾款支付。检测当前时间是否在指定支付尾款时间内
                $gp_overdue_start_time = strtotime($groupbuy ['gp_overdue_start_time']);
                $gp_overdue_end_time = strtotime($groupbuy ['gp_overdue_end_time']);
                if ($gp_overdue_start_time > mktime()) {
                    // 还未到支付尾款时间
                    $this->error('请于' . date('Y年m月d日 H:i:s', $gp_overdue_start_time) . '后补交尾款');
                } elseif (($gp_overdue_start_time < mktime()) && ($gp_overdue_end_time < mktime())) {
                    // 支付尾款时间已过
                    output_datas(null,array('result' =>"1",'desc'=>'补交尾款时间已过，请联系客服人员！'));
                }
                $o_pay = sprintf("%0.3f", $ary_orders ['o_all_price'] - $ary_orders ['o_pay']);
            }
        }elseif ($ary_orders['oi_type'] == '8') {  //预售商品
            $presale = M('presale', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                        'g_id' => $ary_orders ['g_id']
                    ))->find();
            if ($pay_stat == 0) {
                // 预售全额支付
                $o_pay = $ary_orders ['o_all_price'];
            } elseif ($pay_stat == 1) {
                // 预售定金支付,获取定金
                $o_pay = sprintf("%0.3f", $presale ['p_deposit_price'] * $ary_orders ['oi_nums']);
            } elseif ($pay_stat == 2) {
                // 尾款支付。检测当前时间是否在指定支付尾款时间内
                $p_overdue_start_time = strtotime($presale ['p_overdue_start_time']);
                $p_overdue_end_time = strtotime($presale ['p_overdue_end_time']);
                if ($p_overdue_start_time > mktime()) {
                    // 还未到支付尾款时间
                    $this->error('请于' . date('Y年m月d日 H:i:s', $p_overdue_start_time) . '后补交尾款');
                } elseif (($p_overdue_start_time < mktime()) && ($p_overdue_end_time < mktime())) {
                    // 支付尾款时间已过
                    $this->error('补交尾款时间已过，请联系客服人员');
                }
                $o_pay = sprintf("%0.3f", $ary_orders ['o_all_price'] - $ary_orders ['o_pay']);
            }
        }else if($ary_orders ['oi_type'] == '7'){           
            $o_pay = sprintf("%0.3f", $ary_orders ['o_all_price'] - $ary_orders ['o_pay']);
        }else {
            $o_pay = sprintf("%0.2f", $ary_orders ['o_all_price'] - $ary_orders ['o_pay']);
        }
        // # 使用支付模型 支付订单 ###############################################
        $Payment = D('PaymentCfg');
        if ($ary_orders ['o_payment'] != $payment_id && !empty($payment_id)) {
            $ary_orders ['o_payment'] = $payment_id;
            $update_payment_res = D('Orders')->UpdateOrdersPayment($int_id, $payment_id);
            if ($update_payment_res == false) {
                M('', '', 'DB_CUSTOM')->rollback();
                exit();
            }
        }

        $info = $Payment->where(array(
                    'pc_id' => $ary_orders ['o_payment']
                ))->find();
        
        if (false == $info) {
            // 支付方式不存在 XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            M('', '', 'DB_CUSTOM')->rollback();
            output_datas(null,array('result' =>"1",'desc'=>'支付方式不存在，或不可用'));
            exit();
        }
        
        if($int_id){
                //更新最后支付时间
                $ps_update = D('PaymentSerial')->data(array('ps_update_time'=>date('Y-m-d H:i:s')))->where(array('o_id' => $int_id))->save();
        }
        
        // 线下支付进erp
        if ($info ['pc_abbreviation'] != 'OFFLINE' && $info ['pc_abbreviation'] != 'DELIVERY' && $ary_orders ['pc_abbreviation'] != 'DELIVERY') {
            //盛付通支付时将订单信息写入支付序列表 begin
            if ($info ['pc_abbreviation'] == 'SHENGFUPAY') {
                $add_payment_serial ['m_id'] =$ary_member['m_id'];
                $add_payment_serial ['pc_code'] = 'SHENGFUPAY';
                $add_payment_serial ['ps_money'] = $o_pay;
                $add_payment_serial ['ps_type'] = 0;
                $add_payment_serial ['o_id'] = $int_id;
                $add_payment_serial ['ps_status'] = 1;
                $add_payment_serial ['pay_type'] = $pay_stat;
                $add_payment_serial ['ps_create_time'] = date('Y-m-d H:i:s');
                M('payment_serial')->startTrans();
                $ary_result = M('payment_serial')->add($add_payment_serial);
                if (false === $ary_result) {
                    M('payment_serial')->rollback();
                    output_datas(null,array('result' =>"1",'desc'=>'生成支付明细失败，请重试..'));
                    exit();
                }
                M('payment_serial')->commit();
            }
            //盛付通支付时将订单信息写入支付序列表 end
            $pay_stat = 5;
            if($info ['pc_abbreviation']=='SHENGFUPAY'){
                //盛付通支付
                $this->redirect(U("Ucenter/Orders/XingyuSuccess",["oid"=>$int_id]));
            }elseif($info ['pc_abbreviation']=='DEPOSIT'){
                //支付宝支付
                $Pay = $Payment::factory($info ['pc_abbreviation'], json_decode($info ['pc_config'], true));
                $result = $Pay->pay($int_id, $ary_orders ['oi_type'], $o_pay, $pay_stat,$ary_member,$pay_code); //支付宝支付      
            }else{
                $Pay = $Payment::factory($info ['pc_abbreviation'], json_decode($info ['pc_config'], true));
                $result = $Pay->pay($int_id, $ary_orders ['oi_type'], $o_pay, $pay_stat,$payment_id,$pay_code); //支付宝支付      
            }                
            writeLog($result, "order_pay.log");
            if (!$result ['result']) {
                // 支付失败了 XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                M('', '', 'DB_CUSTOM')->rollback();
                $this->error($result ['message'],U('Ucenter/Userhome/SalesOrder/', array('oid' => $int_id)));
            }
            // 支付成功了
            // die('@tudo 支付成功继续完成：1）流水账 2）更新订单状态 3）进入ERP');
            $ary_orders ['o_pay'] = $o_pay;         
            if ($pay_stat == 1) {
                // 如果是定金支付，支付状态为部分支付
                $ary_orders ['o_pay_status'] = 3;
            } else {
                $ary_orders ['o_pay_status'] = 1;
            } // print_r($ary_orders);exit;
            //查询库存,如果库存数为负数则不再扣除库存
            $int_pdt_stock = M('orders_items',C('DB_PREFIX'),'DB_CUSTOM')
                                           ->field('pdt_stock,oi_nums')
                                           ->where(array('o_id'=>$int_id))
                                           ->join(C('DB_PREFIX').'goods_products as gp on gp.pdt_id = '.C('DB_PREFIX').'orders_items.pdt_id')
                                           ->find();
            
            if($ary_orders['oi_type'] ==5 || $ary_orders['oi_type'] ==8){
                if(0 >= $int_pdt_stock['pdt_stock']){
                        output_datas(null,array('result' =>"1",'desc'=>'该货品已售完'));
     
                }
                
                //没有结果
                if($int_pdt_stock['pdt_stock']<$int_pdt_stock['oi_nums']){
                          output_datas(null,array('result' =>"1",'desc'=>'该货品已售完'));
                }
            }else{
                if(0 >= $int_pdt_stock['pdt_stock']){
                         output_datas(null,array('result' =>"1",'desc'=>'该货品已售完'));
                }
            }
           
            $result_order = D('Orders')->orderPayment($int_id, $ary_orders);
        
            if (!$result_order ['result']) {
                // 后续工作失败 XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                M('', '', 'DB_CUSTOM')->rollback();
                $this->error($result_order ['message']);
                exit();
            }            
            
            
            $ary_balance_info = array(
                'bt_id' => '1',
                'bi_sn' => time(),
                'm_id' => $ary_member ['m_id'],
                'bi_money' => $o_pay,
                'bi_type' => '1',
                'bi_payment_time' => date("Y-m-d H:i:s"),
                'o_id' => $int_id,
                'bi_desc' => '订单支付',
                'single_type' => '2',
                'o_payment'=>$ary_orders ['o_payment'],
                'bi_verify_status' => '1',
                'bi_service_verify' => '1',
                'bi_finance_verify' => '1',
                'bi_create_time' => date("Y-m-d H:i:s")
            );
            $arr_res = M('BalanceInfo', C('DB_PREFIX'), 'DB_CUSTOM')->add($ary_balance_info);
                  
            if (!$arr_res) {
            
                M('', '', 'DB_CUSTOM')->rollback();
                output_datas(null,array('result' =>"1",'desc'=>'生成支付明细失败，请重试...'));
                exit();
            } else {
                $arr_data = array();
                $str_sn = str_pad($arr_res, 6, "0", STR_PAD_LEFT);
                $arr_data ['bi_sn'] = time() . $str_sn;
                $arr_result = M('BalanceInfo', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                            'bi_id' => $arr_res
                        ))->data($arr_data)->save();
                if (!$arr_result) {
                    M('', '', 'DB_CUSTOM')->rollback();
                    output_datas(null,array('result' =>"1",'desc'=>'生成支付明细失败，请重试...'));
                    exit();
                }
                // 结余款调整单日志
                $add_balance_log ['u_id'] = 0;
                $add_balance_log ['bi_sn'] = $arr_data ['bi_sn'];
                $add_balance_log ['bvl_desc'] = '审核成功';
                $add_balance_log ['bvl_type'] = '2';
                $add_balance_log ['bvl_status'] = '2';
                $add_balance_log ['bvl_create_time'] = date('Y-m-d H:i:s');
                if (false === M('balance_verify_log', C('DB_PREFIX'), 'DB_CUSTOM')->add($add_balance_log)) {
                    M('', '', 'DB_CUSTOM')->rollback();
                    output_datas(null,array('result' =>"1",'desc'=>'生成结余款调整单日志失败，请重试...'));
                    exit();
                }
                $add_balance_log ['bvl_type'] = '3';
                if (false === M('balance_verify_log', C('DB_PREFIX'), 'DB_CUSTOM')->add($add_balance_log)) {
                    M('', '', 'DB_CUSTOM')->rollback();
                     output_datas(null,array('result' =>"1",'desc'=>'生成结余款调整单日志失败，请重试...'));
                    exit();
                }
            }
            if ($info ['pc_abbreviation'] == 'DEPOSIT') {
                $add_payment_serial ['m_id'] = $ary_member['m_id'];
                $add_payment_serial ['pc_code'] = 'DEPOSIT';
                $add_payment_serial ['ps_money'] = $o_pay;
                $add_payment_serial ['ps_type'] = 0;
                $add_payment_serial ['o_id'] = $int_id;
                $add_payment_serial ['ps_status'] = 1;
                $add_payment_serial ['pay_type'] = $pay_stat;
                $add_payment_serial ['ps_create_time'] = date('Y-m-d H:i:s');
                $ary_result = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->add($add_payment_serial);
                if (false === $ary_result) {
                    M('', '', 'DB_CUSTOM')->rollback();
                    output_datas(null,array('result' =>"1",'desc'=>'生成支付明细失败，请重试...'));
                    exit();
                }
            }
            
            if ($info ['pc_abbreviation'] == 'CREDITACCOUNT') {
                $add_payment_serial ['m_id'] = $ary_member['m_id'];
                $add_payment_serial ['pc_code'] = 'CREDITACCOUNT';
                $add_payment_serial ['ps_money'] = $o_pay;
                $add_payment_serial ['ps_type'] = 0;
                $add_payment_serial ['o_id'] = $int_id;
                $add_payment_serial ['ps_status'] = 1;
                $add_payment_serial ['pay_type'] = $pay_stat;
                $add_payment_serial ['ps_create_time'] = date('Y-m-d H:i:s');
                $ary_result = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->add($add_payment_serial);
                if (false === $ary_result) {
                    M('', '', 'DB_CUSTOM')->rollback();
                    output_datas(null,array('result' =>"1",'desc'=>'生成支付明细失败，请重试...'));
                    exit();
                }
            }
        } else {
            //查询库存,如果库存数为负数则不再扣除库存
            $int_pdt_stock = M('orders_items',C('DB_PREFIX'),'DB_CUSTOM')
                                           ->field('pdt_stock,oi_nums')
                                           ->where(array('o_id'=>$int_id))
                                           ->join(C('DB_PREFIX').'goods_products as gp on gp.pdt_id = '.C('DB_PREFIX').'orders_items.pdt_id')
                                           ->find();
            if(0 >= $int_pdt_stock['pdt_stock']){
               output_datas(null,array('result' =>"1",'desc'=>'该货品已售完!'));
            }
            if($int_pdt_stock['pdt_stock']<$int_pdt_stock['oi_nums']){
                              output_datas(null,array('result' =>"1",'desc'=>'该货品已售完!'));
            }
            $ary_orders ['o_pay_status'] = 0;
            $result_order = D('Orders')->orderPayment($int_id, $ary_orders);
            
            if (!$result_order ['result']) {
                M('', '', 'DB_CUSTOM')->rollback();
                $this->error($result_order ['message']);
                exit();
            }            
        }
        D("Orders")->doRemoveOrderItems($int_id);
        //$this->doRemoveOrderItems($int_id);
        M('', '', 'DB_CUSTOM')->commit();
        if($ary_orders ['o_payment'] == 1 || $ary_orders ['o_payment'] == 16)
        {
            output_datas(array("o_pay"=>$o_pay,"o_id"=>$int_id),array('result' =>"0",'desc'=>'支付成功！'));
        }else{
                    $url = U("Ucenter/Orders/PaymentSaleSuccess", array(
            'oid' => $int_id ));
        }
    }






    public function ApiOrdersPay(){


        //$ary_sgp = array();
        $ary_datas = $this->_post();


        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_datas['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }

        $m_id = $token['member_id'];
		$order_id = $ary_datas['order_id'];
		$ary_order = D('Orders')->where(array('o_id' => $order_id))->find();
		//dump($ary_order);exit;
		//if($ary_order['o_pay_status'] == '0'||$ary_order['o_pay_status']=="3"){//未支付待付款
			//$ary_datas = $this->_beforeDoAdd($ary_datas);
			$UserPrice = D("Members")->GetBalance(array("m_id" => $m_id), 'm_balance,ca_status');
			//dump($UserPrice);exit;
			if($ary_datas['o_payment'] == 16)
			{
				if ($UserPrice['ca_status']  == 0) {
					 output_datas(null,array('result' =>"1",'desc'=>'您的信用帐号已冻结，请联系客服！'));
				}
			}
			
	  
			
			$sql_model = M('', C('DB_PREFIX'), 'DB_CUSTOM');
			$sql_model->startTrans();
			 
			 
				
				if ($ary_datas['o_payment'] == "1" || $ary_datas['o_payment'] == "16") {
					   $sql_model->commit();
					   $this->paymentPage($order_id,$ary_datas['o_payment'],0,0,$m_id);
				}else if($ary_datas['o_payment'] == "19"){//手机微信支付
				//edit on 2016.10.10	
					
					//$ary_order = D('Orders')->where(array('o_id' => $order_id))->find();
					//dump($ary_order);exit;
				   $int_ps_id = $this->addPaymentSerial(0, $ary_order,0,$m_id,'APPWEIXIN');
				   //dump($int_ps_id);exit;
					if ($ary_datas['mixture'] == "1") {//混合支付
						$needPrice = $ary_order['o_all_price'] - $ary_order['o_pay'];//还需支付的钱


							$ary_orders_log = array(
								'o_id' => $order_id,
								'ol_behavior' => '混合支付,扣除一部分余额',
								'ol_uname' => $m_id,
								'ol_create' => date('Y-m-d H:i:s')
							);
						 $OrdersLogAdd =  D('OrdersLog')->add($ary_orders_log);
						 if (empty($OrdersLogAdd)) {
								 $sql_model->rollback();
								  output_datas(null,array('result' =>"1",'desc'=>'订单日志添加失败！'));
							}
							$int_order_update = D("Orders")->where(array('o_id' => $order_id))->save(array("o_pay_status"=>3,"o_payment"=>$ary_datas['o_payment']));
							//echo M()->getLastSql();exit;
							//if (false == $int_order_update) {
									//$sql_model->rollback();
									//output_datas(null,array('result' =>"1",'desc'=>'更新订单状态出错！'));
							//}
							$sql_model->commit();
							$o_pay_order = sprintf("%.2f",$needPrice - $UserPrice['m_balance']);
                            $OrdersSave =  D("Orders")->UpdateOrdersO_pay($order_id,$UserPrice['m_balance'] + $ary_order['o_pay']);
                            $MemberSave =  D("Members")->UpdateBalance($m_id,0);//把余额置0
                          if(!empty($MemberSave))
                          {
                           // $OrdersSave =  D("Orders")->UpdateOrdersO_pay($order_id,$UserPrice['m_balance']);

                                $arr_balance_data = array();
                                //$ary_prepaid_card['pc_money'] = sprintf("%.2f",$UserPrice['m_balance']);
                             //   $arr_balance_data['pc_serial_number'] = $ary_prepaid_card['pc_serial_number'];
                                $arr_balance_data['bt_id'] = 1;//账户消费
                                $arr_balance_data['m_id'] = $m_id;
                                $arr_balance_data['o_id'] = $order_id;
                                $arr_balance_data['bi_money'] = $UserPrice['m_balance'];
                                $arr_balance_data['u_id'] = 0;
                                $arr_balance_data['o_payment'] = 1;
                                $arr_balance_data['bi_type'] = 1;//支出
                                $arr_balance_data['bi_verify_status'] = 1;
                                $arr_balance_data['bi_service_verify'] = 1;
                                $arr_balance_data['bi_finance_verify'] = 1;
                                $arr_balance_data['bi_payment_time'] = date('Y-m-d H:i:s');
                                $arr_balance_data['bi_desc'] = "余额已支付金额{$UserPrice['m_balance']}元";
                                $arr_balance_data['bi_create_time'] =  date('Y-m-d H:i:s');
                                $arr_balance_data['bi_update_time'] =  date('Y-m-d H:i:s');
                                $arr_balance_data['single_type'] = 1;
                                $balance = new Balance();
                                $ary_rest = $balance->addBalanceInfoOrders($arr_balance_data);
                              if(FALSE === $ary_rest){
                                    $sql_model->rollback();
                                      output_datas(null,array('result' =>"1",'desc'=>'订单日志添加失败！'));
                                 }
                          }

                            if(FALSE === $OrdersSave){
                                output_datas(null,array('result' =>"1",'desc'=>'更新结余款失败！'));
                            }

                            $orderBody = "订单支付";
                            $tade_no = $int_ps_id;
                            $total_fee = $o_pay_order*100;
                            $notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/Home/User/ApisynWxNotify?code=APPWEIXIN';
                            //$WxPayHelper = new WxPayHelper();
                            $response = D('ApiWeixin')->getPrePayOrder($orderBody, $tade_no, $total_fee,$notify_url);
                            //dump($response);exit;
                            // p_val("---response----");
                            // p_val($response);
                            // p_val("---拿到prepayId再次签名----");
                            $x = D('ApiWeixin')->getOrder($response['prepay_id']);
                            $x['out_trade_no'] = (string)$int_ps_id;
                            $x['total_fee'] = $o_pay_order;
                            $x['order_id'] = $order_id;
                            //dump($x);exit;
                            output_datas($x,array('result' =>"0",'error_code' =>0,'desc'=>'请求预支付id成功'));
							//output_datas(array("oid"=>$order_id,'out_trade_no'=>(string)$int_ps_id,'o_all_price'=>$o_pay_order,'notify_url'=> U('Home/User/ApisynPayNotify?code=APPALIPAY', '', true, false, true)),array('result' =>"0",'desc'=>'提交成功！'));
						//}	
					}
					 $sql_model->commit();

					 $int_order_update = D("Orders")->where(array('o_id' => $order_id))->save(array("o_pay_status"=>3,"o_payment"=>$ary_datas['o_payment']));
					 if($ary_order['o_pay_status'] == '3'){//部分支付
						$o_pay_order = $ary_order['o_all_price'] - $ary_order['o_pay'];
					 }else{
						$o_pay_order = sprintf("%.2f",$ary_order['o_all_price']);
					 }

                    $orderBody = "订单支付";
                    $tade_no = $int_ps_id;
                    $total_fee = $o_pay_order*100;
                    $notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/Home/User/ApisynWxNotify?code=APPWEIXIN';
                    //$WxPayHelper = new WxPayHelper();
                    $response = D('ApiWeixin')->getPrePayOrder($orderBody, $tade_no, $total_fee,$notify_url);
                    //dump($response);exit;
                    // p_val("---response----");
                    // p_val($response);
                    // p_val("---拿到prepayId再次签名----");
                    $x = D('ApiWeixin')->getOrder($response['prepay_id']);
                    $x['out_trade_no'] = (string)$int_ps_id;
                    $x['total_fee'] = $o_pay_order;
                    $x['order_id'] = $order_id;
                    //dump($x);exit;
                    output_datas($x,array('result' =>"0",'error_code' =>0,'desc'=>'请求预支付id成功'));                
					 //output_datas(array("oid"=>$order_id,'out_trade_no'=>(string)$int_ps_id,'o_all_price'=>$o_pay_order,'notify_url'=> U('Home/User/ApisynPayNotify?code=APPALIPAY', '', true, false, true)),array('result' =>"0",'desc'=>'提交成功！'));					
																				
				} else {
					//$ary_order = D('Orders')->where(array('o_id' => $order_id))->find();
					//dump($ary_order);exit;
				   $int_ps_id = $this->addPaymentSerial(0, $ary_order,0,$m_id,'APPALIPAY');
				   //dump($int_ps_id);exit;
					if ($ary_datas['mixture'] == "1") {//混合支付
						$needPrice = $ary_order['o_all_price'] - $ary_order['o_pay'];//还需支付的钱


							$ary_orders_log = array(
								'o_id' => $order_id,
								'ol_behavior' => '混合支付,扣除一部分余额',
								'ol_uname' => $m_id,
								'ol_create' => date('Y-m-d H:i:s')
							);
						 $OrdersLogAdd =  D('OrdersLog')->add($ary_orders_log);
						 if (empty($OrdersLogAdd)) {
								 $sql_model->rollback();
								  output_datas(null,array('result' =>"1",'desc'=>'订单日志添加失败！'));
							}
							$int_order_update = D("Orders")->where(array('o_id' => $order_id))->save(array("o_pay_status"=>3,"o_payment"=>$ary_datas['o_payment']));
							//echo M()->getLastSql();exit;
							//if (false == $int_order_update) {
									//$sql_model->rollback();
									//output_datas(null,array('result' =>"1",'desc'=>'更新订单状态出错！'));
							//}
							$sql_model->commit();
							$o_pay_order = sprintf("%.2f",$needPrice - $UserPrice['m_balance']);
                            $OrdersSave =  D("Orders")->UpdateOrdersO_pay($order_id,$UserPrice['m_balance'] + $ary_order['o_pay']);
                            $MemberSave =  D("Members")->UpdateBalance($m_id,0);//把余额置0
                          if(!empty($MemberSave))
                          {
                           // $OrdersSave =  D("Orders")->UpdateOrdersO_pay($order_id,$UserPrice['m_balance']);

                                $arr_balance_data = array();
                                //$ary_prepaid_card['pc_money'] = sprintf("%.2f",$UserPrice['m_balance']);
                             //   $arr_balance_data['pc_serial_number'] = $ary_prepaid_card['pc_serial_number'];
                                $arr_balance_data['bt_id'] = 1;//账户消费
                                $arr_balance_data['m_id'] = $m_id;
                                $arr_balance_data['o_id'] = $order_id;
                                $arr_balance_data['bi_money'] = $UserPrice['m_balance'];
                                $arr_balance_data['u_id'] = 0;
                                $arr_balance_data['o_payment'] = 1;
                                $arr_balance_data['bi_type'] = 1;//支出
                                $arr_balance_data['bi_verify_status'] = 1;
                                $arr_balance_data['bi_service_verify'] = 1;
                                $arr_balance_data['bi_finance_verify'] = 1;
                                $arr_balance_data['bi_payment_time'] = date('Y-m-d H:i:s');
                                $arr_balance_data['bi_desc'] = "余额已支付金额{$UserPrice['m_balance']}元";
                                $arr_balance_data['bi_create_time'] =  date('Y-m-d H:i:s');
                                $arr_balance_data['bi_update_time'] =  date('Y-m-d H:i:s');
                                $arr_balance_data['single_type'] = 1;
                                $balance = new Balance();
                                $ary_rest = $balance->addBalanceInfoOrders($arr_balance_data);
                              if(FALSE === $ary_rest){
                                    $sql_model->rollback();
                                      output_datas(null,array('result' =>"1",'desc'=>'订单日志添加失败！'));
                                 }
                          }

                            if(FALSE === $OrdersSave){
                                output_datas(null,array('result' =>"1",'desc'=>'更新结余款失败！'));
                            }
							output_datas(array("oid"=>$order_id,'out_trade_no'=>(string)$int_ps_id,'o_all_price'=>$o_pay_order,'notify_url'=> U('Home/User/ApisynPayNotify?code=APPALIPAY', '', true, false, true)),array('result' =>"0",'desc'=>'提交成功！'));
						//}	
					}
					 $sql_model->commit();

					 $int_order_update = D("Orders")->where(array('o_id' => $order_id))->save(array("o_pay_status"=>3,"o_payment"=>$ary_datas['o_payment']));
					 if($ary_order['o_pay_status'] == '3'){//部分支付
						$o_pay_order = $ary_order['o_all_price'] - $ary_order['o_pay'];
					 }else{
						$o_pay_order = sprintf("%.2f",$ary_order['o_all_price']);
					 }
					 output_datas(array("oid"=>$order_id,'out_trade_no'=>(string)$int_ps_id,'o_all_price'=>$o_pay_order,'notify_url'=> U('Home/User/ApisynPayNotify?code=APPALIPAY', '', true, false, true)),array('result' =>"0",'desc'=>'提交成功！'));
				}
			//更改订单支付方式
			

		//}

    }



    //根据名字，找到地区
    public function get_address_id($cr_name){
        return M('CityRegion')->where(array('cr_name'=>$cr_name))->getfield('cr_id');   
    }



    //根据地区id，找到名字
    public function get_address_name($cr_id){
        return M('CityRegion')->where(array('cr_id'=>$cr_id))->getfield('cr_name');   
    }



    // url :www.xingyun.com:8080/Api/Orders/OrderSaveAddress?token=237c3e69bad23b0e0a56866fdb12faea&order_id=201607181457428238
    // 请求方式：post
    //      请求参数： 
    //      Action: OrderSaveAddress
    //      token:  凭证
    //      order_id:订单ID

    //      addressDic = 
    // {
    //      "idno": "123",
    //      "accept_name": "12345",
    //      "province_id": "12345",//省id
    //      "city_id": "12345",//市id
    //      "area_id": "12345",//区id
    //      "id": "665",//详细地址id   即fx_receive_address表ra_id字段
    //      "mobile": "123456",//手机
    //      "address":"天行云公司"//要修改的街道地址   
    //  }
    // 返回数据
    public function OrderSaveAddress()
    {

       $ary_post = $this->_post();
 
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
   
        $ary_where = array();  
        $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');

        $ary_where['o.m_id'] = $m_id; 
        $ary_where['o.o_id'] = $ary_post['order_id'];     
        //父订单信息     
        $value = $orders
                        ->alias('o')
                        ->field('o.o_id,o.o_all_price,o_status,oi.oi_refund_status,o.o_audit,o.express_status,o.o_pay_status,o.is_diff,o.o_create_time,o.o_receiver_name,o.o_receiver_mobile,o.o_receiver_address,o.o_receiver_idcard,o.o_receiver_county,o_receiver_city,o.o_receiver_state,o.ra_id,o.o_pay')
                        ->join('fx_orders_items oi on oi.o_id = o.o_id')
                        ->where($ary_where)
                        ->distinct('o.o_id')
                        ->find();
        //echo M()->getLastSql();exit;
        //dump($value);exit;                

        // if($value['o_pay_status'] == '0' || $value['oi_refund_status'] != '1' || $value['o_pay_status'] == '3'){

        $addressDic = json_decode($ary_post['addressDic'],true); 
        //dump($addressDic);exit;

        // 收货人省份
        $ary_orders['o_receiver_state'] = $this->get_address_name($addressDic['province_id']);//省
        // 收货人城市
        $ary_orders['o_receiver_city'] = $this->get_address_name($addressDic['city_id']); //市  
        // 收货人地区
        $ary_orders['o_receiver_county'] = $this->get_address_name($addressDic['area_id']); //区;

        $ary_orders ['o_receiver_name'] = $addressDic['accept_name'];
      
        $ary_orders ['o_receiver_mobile'] = $addressDic['mobile'];
       
        $ary_orders ['o_receiver_address'] = $addressDic['address'];
          
        $ary_orders ['o_receiver_idcard'] = $addressDic['idno'];
        //计算运费 add by zhangdong at 2016-07-21 begin
        $mCarriageTemplate = D("CarriageTemplate");
        $mOrdersItems = D("OrdersItems");
        $provinceName = trim($ary_orders ['o_receiver_state']);          

        //dump($provinceName);exit;
        $mOrdersItems = D('OrdersItems');
        //通过订单号获取对应商品数量和货号
        $int_oid = $value['o_id'];
        $ary_field = 'g_sn,oi_nums,o_all_price,o_cost_freight,o_pay';
        $orderInfo = $mOrdersItems->getOrderInfo($int_oid, $ary_field);
        //dump($orderInfo);exit;
        foreach($orderInfo as $value){
            $num = $value['oi_nums'];
            $goodsSn = $value['g_sn'];
            $postage = $mCarriageTemplate->countCarriage($goodsSn,$num,$provinceName);
            $allPostage[] = $postage;
        }
        $postPrice = sprintf('%0.2f',array_sum($allPostage));
        //dump($postPrice);exit;
        //计算运费 end
        $ary_orders ['o_all_price'] = sprintf('%0.2f',$orderInfo[0]['o_all_price']-$orderInfo[0]['o_cost_freight']+$postPrice);
        $ary_orders ['o_pay'] = $orderInfo[0]['o_pay'];
        $ary_orders ['o_cost_freight'] = $postPrice;
        $ary_orders ['o_update_time'] = date('Y-m-d H:i:s');

        $newOrder = array();
        $newOrder['o_all_price'] = $ary_orders ['o_all_price'];
        $newOrder['o_cost_freight'] = $ary_orders ['o_cost_freight'];
        $newOrder['need_pay'] = sprintf('%0.2f',$ary_orders['o_all_price'] - $ary_orders['o_pay']); //还需支付

        $OrderSave = D("Orders")->UpdateOrdersAddress($ary_post['order_id'],$ary_orders);
        //echo D("Orders")->getlastsql();exit;
 
        if($OrderSave== false){
            output_datas(null,array('result' =>"1",'error_code' =>10003,'desc'=>'修改失败'));
        }else{
            output_datas($newOrder,array('result' =>"0",'error_code' =>0,'desc'=>'修改成功'));          
        }



        // }
                
        
    }




    //手机微信查询订单状态
    public function WxOrderQuery(){

        $ary_post = $this->_get(); 
        $int_ps_id = $ary_post['out_trade_no'];
        $result = D('ApiWeixin')->OrderQuery($int_ps_id);
        $status = $result['trade_state'];
        // if($result){
            output_datas($status,array('result' =>"0",'error_code' =>0,'desc'=>'成功'));
        // }

    }





    //根据货号id获取商品信息（包括会员价）
    public function get_goods_info($id,$ml_id){
        $condition = array();
        $condition['gp.pdt_id'] = $id;
        $condition['pmlp.ml_id'] = $ml_id;
        $result = M('GoodsInfo')
                ->field('g.g_id,g.number_least,g.gb_id,rgc.gc_id,g.g_trade,gi.g_name,gi.g_picture,gi.g_price,gi.extension_spec,wh.c_name,gp.g_sn,gp.pdt_cost_price,gp.pdt_cost_price,gp.pdt_sale_price,gp.pdt_stock,gp.pdt_min_num,gp.pdt_max_num,pmlp.pmlp_price')
                ->alias('gi')
                ->join('fx_goods g on g.g_id = gi.g_id')
                ->join('fx_related_goods_category rgc on rgc.g_id = gi.g_id')
                ->join('fx_goods_products gp on gp.g_id = g.g_id')
                ->join('fx_product_member_level_price pmlp on pmlp.pdt_id = gp.pdt_id')
                ->join('fx_warehouses wh on wh.c_id = g.c_id')
                ->where($condition)
                ->find();
        return $result;
    }



    //二维数组去掉重复值
    public function array_unique_2d($array2D){
        $temp = $res = array();
        foreach ($array2D as $v){
            $v = json_encode($v);  //降维,将一维数组转换字符串      

                $temp[] = $v;
            }
            $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $item){

            $res[] = json_decode($item,true);   //再将拆开的数组重新组装
        }
        return $res;
    }



    /**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
    public function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }

    /**
     * 根据用戶名得到用戶id
     */
    public function get_user_id($user_name) {

        $map = array();
        $map['m_name'] = $user_name;
        $m_id = M('Members')->where($map)->getfield('m_id');
        return $m_id; 
    }

    /**
     * 根据用戶id得到用戶会员等级
     */
    public function get_user_level($member_id) {

        $map = array();
        $map['m_id'] = $member_id;
        $ml_id = M('Members')->where($map)->getfield('ml_id');
        return $ml_id; 
    }


}    