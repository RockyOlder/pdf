<?php

class ApiOrderCallbackAction extends CommonAction {
    
    
    public function __construct() {
        parent::__construct();
        $arr_array = file_get_contents('php://input');
        $ary_post = json_decode($arr_array, true);
        if (empty($ary_post)) {
            $this->ceshi();exit;
            output_error(null, array('result' => "1", 'error' => '数据有误'));
        }
        switch ($ary_post['action'])
        {
            case "ChangeOrder":
                $this->ChangeOrder($ary_post);
                break;
            case "syn_order":
                $this->callbackOrder();
                break;
            case "callbackOrder":
                $this->updateSaveOrder($ary_post);
                break;
            case "Refund":
                $this->Refund($ary_post);
                break;
        }
    }
    private function Refund($ary_post){
            $o_id = $ary_post['orderno'];
            if(empty($ary_post['OutRemark']))
            {
                $ary_post['OutRemark'] = "暂无填写";
            }
         
            $ary_orders_data = M("orders", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->find();
            $ary_orders_data_items = M("orders_items", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->select();
            $nums  =  0;
            $price = 0 ;
            $oi_frozen_number = 0;
            foreach($ary_orders_data_items as $value)
            {
                $ary_orders_data_products = M("goods_products", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('pdt_id' => $value['pdt_id']))->find();
                $pdt_weight += $ary_orders_data_products['pdt_weight'];
                $check[] = $value['oi_id'];
                $inputNum[$value['oi_id']] = $ary_post['quantity'];
                $oi_frozen_number =  $value['oi_frozen_number'] + $ary_post['quantity'];
                if($oi_frozen_number > $value['oi_nums'])
                {
                    output_msg("商品退款数量,超出实际退货数量！", array('orderno'=>$ary_orders_data['o_id'],'flag' => FALSE));
                }
                  
                $nums += $value['oi_nums'];
//                $price +=  $value['oi_price'] * $ary_post['quantity'];
//                $o_tax_rate +=  $value['oi_price'] / $value['oi_nums'];
//                $price_coupon[] = $value['oi_price'];
            }
//            if($ary_orders_data['o_coupon_menoy'] ==0)
//            {
//                if($ary_orders_data['o_tax_rate'] == 0)
//                {
//                    $ary_data['application_money']  = $price;
//                }else{
//                  $tax_rate  =  round($ary_orders_data['o_tax_rate'] / $nums,2);
//                  $ary_data['application_money']  = round($tax_rate * $ary_post['quantity'],2) + $price;
//                }
//               
//            }else{
//              $coupon  =  round($ary_orders_data['o_coupon_menoy'] / $nums,2);
//              $o_pay   =  round($ary_orders_data['o_pay'] / $nums,2);
//              $total   =  round(( $o_pay +  $coupon ) * $ary_post['quantity'],2);
//                if($ary_orders_data['o_tax_rate'] == 0)
//                {
//                      $ary_data['application_money']  = $total;             
//                 }else{
//                  $tax_rate  =  round($ary_orders_data['o_tax_rate'] / $nums,2);
//                  $ary_data['application_money']  = round($tax_rate * $ary_post['quantity'],2) + $total;
//                 }
//            }
            $ary_data['checkSon'] = $check;
            $ary_data['inputNum'] = $inputNum;
            $ary_data['allow_refund_delivery'] = 0.000;
            $ary_data['sh_radio'] = 1;
            $ary_data['th_radio'] = 1;
            $ary_data['m_id'] = $ary_orders_data['m_id'];
            $ary_data['ary_reason'] = $ary_post['OutRemark'];
            $ary_data['AfterSalesCode'] = $ary_post['AfterSalesCode'];
            $ary_data['application_money']  = $ary_post['price'];
            $ary_data['od_logi_no'] = "000000000000000";
            $ary_data['or_refund_type'] = 2;
            $ary_data['or_buyer_memo'] = $ary_post['OutRemark'];
            $ary_data['o_id'] = $o_id;
            $ObjectSaveADD = $this->AftersaleDoAdd($ary_data,$ary_orders_data['o_payment']);
            $total_nums = $nums - $ary_post['quantity'];
             M('orders_items', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('oi_frozen_number' => $oi_frozen_number, 'o_update_time' => date('Y-m-d H:i:s')))->save();
            if($total_nums <=0)
            {
                $order_info['nums'] = 0;
                $order_info['weight'] = 0.00;
                $order_info['TotalCount '] = 0;
                $order_info['FeeAmount'] = 0;
            }else{
                $order_info['nums'] = $total_nums;
                $order_info['weight'] = $pdt_weight * $total_nums;
            }
            if($ObjectSaveADD == TRUE)
            {
                 output_msg("订单退货成功", array('orderno'=>$o_id,'GoodsWeight'=>$order_info['weight'],'flag' => TRUE));
                
            }
    }

	/**
	 * 检测是否已经提交
	 * @author donkey 
	 * @date 2016-6-15
	 */
    private function checkOrderRefunds($params){
		$ary_where = array('o_id' => $params['o_id']);
		//$ary_where['oi_refund_status'] = array('in', '1,6');
		//判断是退款/退货。1是退款，2是退货
//		if ($params['or_refund_type'] == 1) {
//			$ary_where['oi_ship_status'] = array('NEQ', 2);
//		}
//		if ($params['or_refund_type'] == 2) {
//			//申请退货的商品数量
//			//$ary_delivery = M('view_delivery',C('DB_PREFIX'),'DB_CUSTOM')->where(array('o_id' => $o_id))->select();
//			$ary_where['oi_ship_status'] = 2;
//		}
		//$ary_where['oi_refund_status'] = array('in',array(1,6));
		//满足退款、退货的商品
              //  print_r($ary_where);exit;
		$ary_orders = D('Orders')->where($ary_where)->find();
                //echo  D('Orders')->getLastSql();exit;
		if(empty($ary_orders)){
                        output_msg("无此订单", array('orderno'=>$ary_where['o_id'],'flag' => FALSE));
		}
		return $ary_orders[0]['o_cost_freight'];
	}
        
    private function updateSaveOrder($ary_post){
                $ary_goods =  $ary_post['data'];
                $oid  =  $ary_post['data']['order_no'];
                $ary_where = array('o_id' => $oid);
		$ary_orders = D('Orders')->where($ary_where)->find();
                $ary_orders_log = array(
                    'o_id' => $oid,
                    'ol_behavior' => '同步订单日志',
                    'ol_uname' => "管理员：Admin" ,
                    'ol_text'=>  json_encode($ary_goods),
                    'ol_create' => date('Y-m-d H:i:s')
                );
                D('OrdersLog')->add($ary_orders_log);
             //  $area      = explode(',', $ary_post['data']['area']);
		$array_fx_goods["express_status"] = (isset($ary_goods["express_status"]) && is_numeric($ary_goods["express_status"]))?$ary_goods["express_status"]:0;
                
                if($ary_goods["express_status"] !=2)
                {
                      $array_fx_goods["o_customs"] = (isset($ary_goods["express_status"]) && is_numeric($ary_goods["express_status"]))?$ary_goods["express_status"]:0;
                      $array_fx_goods["DeliveredTime"] = (isset($ary_goods['express_time']))?$ary_goods['express_time']:date('Y-m-d H:i:s');
                }else{
                     if(empty($ary_orders['express_no']) && empty($ary_orders['express']))
                    {
                        if(!empty($ary_goods['express_no']) && !empty($ary_goods['express']))
                       {
                             $this->UpdateOrderStatus($oid,$ary_goods['express_no'],strtolower($ary_goods['express']));
                             M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $oid))->data(array('erp_status' => $ary_goods['status'],'express_status' => $ary_goods['express_status'],  'DeliveredTime' => date('Y-m-d H:i:s')))->save();
                             //调用有赞api by wangpan 2016.09.18  kdt.logistics.online.confirm 卖家确认发货
                            if($ary_orders['o_source'] == 'youzan'|| $ary_orders['o_source_type'] == 'youzan'){

                                $post_data = array();
                                $post_data['tid'] = $ary_orders['o_thd_sn'];//交易编号
                                $post_data['oids'] = $ary_orders['o_sn'];//如果需要拆单发货，使用该字段指定要发货的交易明细的编号，多个明细编号用半角逗号“,”分隔；不需要拆单发货，则改字段不传或值为空；
                                //$post_data['is_no_express'] = 0;
                                $ary_logi = M("logistic_corp", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('lc_name'=>array("LIKE", '%' . $ary_goods['express'] . '%')))->find();
                                if (empty($ary_logi)) {
                                     output_msg("物流公司不匹配", array('flag' => FALSE));
                                }                                
                                $post_data['out_stype'] = (int)$ary_logi['yz_delivery_guid'];//有赞平台物流id

                                $post_data['out_sid'] = (string)$ary_goods['express_no'];//快递单号
                                
                                //调用接口 kdt.logistics.online.confirm
                                $url = 'http://www.xyb2b.com/Api/KdtApiClient/confirm';
                                
                                $o = "";
                                foreach ( $post_data as $k => $v ) 
                                { 
                                    $o.= "$k=" . urlencode( $v ). "&" ;
                                }
                                $post_data = substr($o,0,-1);

                                $res = $this->request_post($url, $post_data);       
                                //print_r($res);

                            }   


                       }
                     }
                     $this->logistic_corp($oid,$ary_goods['express_no'],strtolower($ary_goods['express']));
                }
                $array_fx_goods["express"] = (isset($ary_goods['express']))?$ary_goods['express']:'';
                $array_fx_goods["express_no"] = (isset($ary_goods['express_no']))?$ary_goods['express_no']:'';
                $array_fx_goods["o_error"] = (isset($ary_goods['error']))?$ary_goods['error']:'';
		$array_fx_goods["declareTime"] = (isset($ary_goods['express_time']))?$ary_goods['express_time']:date('Y-m-d H:i:s');
		$array_fx_goods["o_receiver_name"] = (isset($ary_goods["accept_name"]) && "" != trim($ary_goods["accept_name"]))?trim($ary_goods["accept_name"]):'';
		$array_fx_goods["o_receiver_mobile"] = (isset($ary_goods["mobile"]) && is_numeric($ary_goods["mobile"]))?$ary_goods["mobile"]:2;
		$array_fx_goods["o_receiver_email"] = (isset($ary_goods["email"]) && "" != trim($ary_goods["email"]))?trim($ary_goods["email"]):'';
                
                $array_fx_goods["o_receiver_state"] = (isset($ary_goods['province']))?$ary_goods['province']:'';
                $array_fx_goods["o_receiver_city"] = (isset($ary_goods['city']))?$ary_goods['city']:'';
                $array_fx_goods["o_receiver_county"] = (isset($ary_goods['area']))?$ary_goods['area']:'';
                $array_fx_goods["o_receiver_address"] = (isset($ary_goods['address']) && "" != trim($ary_goods['address']))?trim($ary_goods['address']):'';
                $array_fx_goods["o_seller_comments"] = (isset($ary_goods['remark']) && "" != trim($ary_goods['remark']))?trim($ary_goods['remark']):'';
                $array_fx_goods["o_receiver_zipcode"] = (isset($ary_goods['post_code']) && "" != trim($ary_goods['post_code']))?trim($ary_goods['post_code']):'';
                $array_fx_goods["o_receiver_idcard"] = (isset($ary_goods['IDNO']) && "" != trim($ary_goods['IDNO']))?trim($ary_goods['IDNO']):'';
                
		$array_fx_goods["o_goods_all_price"] = (isset($ary_goods["payable_amount"]) && is_numeric($ary_goods["payable_amount"]))?$ary_goods["payable_amount"]:0;
                
		$array_fx_goods["o_goods_all_price"] = (isset($ary_goods["real_amount"]) && is_numeric($ary_goods["real_amount"]))?$ary_goods["real_amount"]:0;
		$array_fx_goods["o_pay"] = (isset($ary_goods["user_amount"]) && is_numeric($ary_goods["user_amount"]))?$ary_goods["user_amount"]:0;
                
		$array_fx_goods["o_reward_point"] = (isset($ary_goods["point"]) && is_numeric($ary_goods["point"]))?$ary_goods["point"]:0;
		$array_fx_goods["erp_status"] = (isset($ary_goods["status"]) && is_numeric($ary_goods["status"]))?$ary_goods["status"]:0;

                //事务开始，商品资料数据复杂，必须启用事务。
		M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->startTrans();
		//修改D方法Goods模型对应的表名
		
                if(false === M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array("o_id"=>$oid))->save($array_fx_goods)){
			D("GoodsBase")->rollback();
                        output_error(null, array('result' => "1", 'error' => '数据有误'));
		}else{
                    M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->commit();
                    output_msg("同步成功", array('flag' => TRUE));
                }
    }

	/**
	 * 申请退款/退货页面
	 * @author donkey
	 * @date 2016-06-15
	 */
	private function AftersaleDoAdd($ary_data,$o_payment) {
		
		//获取页面POST过来的数据
		//$ary_data = $this->_request();
		$o_cost_feight = $this->checkOrderRefunds($ary_data);
//          echo "<pre>";print_r($ary_data);exit;
		//数据操作模型初始化
		$obj_refunds = D('OrdersRefunds');
		$date = date('Y-m-d H:i:s');
                $members =  M('members', C('DB_PREFIX'), 'DB_CUSTOM')->where(array("m_id"=>$ary_data['m_id']))->find();
        //判断是否提交过（只能申请一次）
        // $ary_refunds = $obj_refunds->where(array('o_id'=>$ary_data['o_id']))->select();
        // if($ary_data['o_id'] == $ary_refunds['o_id']){
        //     $this->error('您已申请过，请耐心等待处理！');
        // }
		//验证是否传递要退款/退货的订单号
		if (!isset($ary_data['o_id']) || empty($ary_data['o_id'])) {
                    output_msg("缺少订单号", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
		}
		//验证请选择原因
//		if (!isset($ary_data['ary_reason']) || empty($ary_data['ary_reason'])) {
//			$this->error('请选择原因');
//		}
      
        $item_where['o_id'] = $ary_data['o_id'];
//        if(!empty($ary_data['checkSon'])){
//            $item_where['oi_id'] = array('in',$ary_data['checkSon']);
//        }
        $orders_items_info = M('orders_items',C('DB_PREFIX'),'DB_CUSTOM')->where($item_where)->select();
       // echo M('orders_items',C('DB_PREFIX'),'DB_CUSTOM')->getLastSql();die;
        $total_price = 0;
        if (!empty($orders_items_info) && is_array($orders_items_info)) {
			foreach ($orders_items_info as $k => $v) {
				$item_promotion['promotion_price'] = $v['oi_coupon_menoy']+$v['oi_bonus_money']+$v['oi_cards_money']+$v['oi_jlb_money']+$v['oi_point_money']+$v['promotion_price'];
				$total_price += $v['oi_price']*$v['oi_nums'] - $item_promotion['promotion_price'];
			}
		}
		//退款时退运费
		$result_price = $total_price;
                     
		if($ary_data['or_refund_type']==1){
			$result_price = $result_price+$o_cost_feight;
		}else{
			$refund_delivery = D('SysConfig')->getCfgByModule('ALLOW_REFUND_DELIVERY');
			if(isset($refund_delivery['ALLOW_REFUND_DELIVERY']) && $refund_delivery['ALLOW_REFUND_DELIVERY'] == 1){
				$result_price = $result_price+$o_cost_feight;
                       
			}		
		}
		if($ary_data['or_refund_type']==1){
                            
			$result_price = M('orders',C('DB_PREFIX'),'DB_CUSTOM')->where(array('o_id'=>$ary_data['o_id']))->getField('o_pay');
                      
		}
		//跨境贸易
		/**
		$is_foreign = D('SysConfig')->getCfg('GY_SHOP','GY_IS_FOREIGN');
		if($is_foreign['GY_IS_FOREIGN']['sc_value'] == 1){
			$orders_res = M('orders',C('DB_PREFIX'),'DB_CUSTOM')->field('o_tax_rate')->where(array('o_id'=>$ary_data['o_id']))->find();
			if($orders_res['o_tax_rate']>0){
				$result_price += $orders_res['o_tax_rate'];
			}
		}**/
		if(sprintf("%.2f", $ary_data['application_money'])-sprintf("%.2f", $result_price)>0) {
                 
                    output_msg("退款金额不合法", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			exit;
		}
			
		//erp退款退货标志  2退款:3  退货:
		$refund_type = 0;

		//售后单据基本信息
		$ary_refunds = array(
			'o_id' => $ary_data['o_id'],
			'm_id' => $members['m_id'],
			'or_money' => sprintf('%.2f',$ary_data['application_money']),
			'or_refund_type' => $ary_data['or_refund_type'],
			'or_create_time' => $date,
			'm_name' => $members['m_mobile'],
			'or_buyer_memo'=>$ary_data['or_buyer_memo']
		);
		//已经退货商品
		$ary_refunds_items = array();
		//要退货或者退款商品 - 获取此订单的订单明细数据
		$ary_orders_items = D('OrdersItems')->field('oi_id,o_id,pdt_id,oi_price,oi_nums,g_sn,oi_g_name,erp_id')->where(array('o_id'=>$ary_data['o_id']))->select();
		
		$ary_temp_items = array();
		foreach($ary_orders_items as $val){
			$ary_temp_items[$val['oi_id']] = $val;
		}

		//区分不同的售后逻辑进行退款
		if($ary_data['or_refund_type']==1){
			//退款时此订单未发货，则退款金额如果用户输入，以用户输入为准
			//如果用户没有输入  或者输入的退款金额不合法，则取订单的付款金额
			//TODO：前端需要对用户输入退款金额的数字进行验证
			$ary_refunds['or_refund_type'] = 1;
			//退款金额的处理：判断退款金额是否合法
			if(!isset($ary_data["application_money"]) || !is_numeric($ary_data["application_money"]) || $ary_data["application_money"] < 0){
				output_msg("退款金额不合法：必须是一个大于等于0的数字。", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
			$ary_refunds['or_money'] = sprintf('%.2f',$ary_data["application_money"]);
				
			$refund_type = 2;
		}elseif($ary_data['or_refund_type']==2 && $ary_data['sh_radio']==0){
			//未收到货，产生退款单,退款金额由双方协商确定
			//此时售后类型为退款，退款金额由双方协商确定
			$ary_refunds['or_refund_type'] = 1;
			$refund_type = 2;
			//对用户申请的退款金额合法性进行判断
			if(!is_numeric($ary_data['application_money']) || $ary_data['application_money']<0){
                            output_msg("未收到货，产生退款单,请正确填写退款金额", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
			$ary_refunds['or_money'] = sprintf('%.2f',$ary_data['application_money']);
		}elseif($ary_data['or_refund_type']==2 && $ary_data['sh_radio']==1 && $ary_data['th_radio']==0){
			//已收到货，且无需退货，退款金额由双方协商确定，生成的单据为退款单
			//这种情况是考虑到买家买到货以后不满意，退部分金额，此时售后类型也是退款
			$ary_refunds['or_refund_type'] = 1;
			$refund_type = 2;
			//对用户申请的退款金额合法性进行判断
			if(!is_numeric($ary_data['application_money']) || $ary_data['application_money']<0){
                             output_msg("已收到货且无需退货，产生退款单,请正确填写退款金额", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
			$ary_refunds['or_money'] = sprintf('%.2f',$ary_data['application_money']);
		}elseif($ary_data['or_refund_type']==2 && $ary_data['sh_radio']==1 && $ary_data['th_radio']==1){
		     //已收到货，且需要换货，无须退款金额
             //$ary_refunds['or_money'] = 0.00;
             //此处改造成退货
            if(!is_numeric($ary_data['application_money']) || $ary_data['application_money']<0){
                            output_msg("已收到货且需退货，产生退货单,请正确填写退货金额", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
             $ary_refunds['or_money'] = sprintf('%.2f',$ary_data['application_money']);
			//已收到货，需退货，退款金额由选择商品确定，生成的单据为退货单
			if(!isset($ary_data['checkSon']) || empty($ary_data['checkSon'])){
                             output_msg("请选择您要退货的商品", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
				
			//TODO:如果勾选退货的商品为积分商城商品，则不允许退货！
				
			//买家将商品寄回时的物流单号，可不填（不填是由于买家自提或者上门送回的情况）
			$ary_refunds["or_return_logic_sn"] = (isset($ary_data['od_logi_no']) && "" != trim($ary_data['od_logi_no']))?trim($ary_data['od_logi_no']):"";
			//售后申请操作类型为退货
			$ary_refunds['or_refund_type'] = 2;
			$refund_type = 3;
		}
      
		//对用户申请的售后请求进行验证，分以下几种情况
		if($ary_refunds['or_refund_type'] == 1){
			/**
			 * 第一种情况：退款：
			 * 如果未发货，应该是一次性退全款；
			 * 如果已发货，且退款时不需要退货（买家对商品不满意，双方达成一致需要补偿的）；
			 * 系统中有且仅有一张关于此订单的退款单
			 */
			$ary_where = array(
				'o_id'=>$ary_data['o_id'],
				'm_id' => $members['m_id'],
				'or_processing_status'=>array('neq',2),
				'or_refund_type'=>array('eq',1)
			);
			$ary_refunds_orders = D('OrdersRefunds')->where($ary_where)->select();
			if(false === $ary_refunds_orders){
                                output_msg("无法验证此订单是否已经存在退款单。", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
			if(is_array($ary_refunds_orders) && count($ary_refunds_orders)>0){
                                output_msg("已存在此订单对应的退款单，不能重复退款。", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			
			}
		}
        elseif($ary_refunds['or_refund_type'] == 2 && $ary_data['sh_radio'] == 1 && $ary_data['th_radio'] == 1){
			/**
			 * 第二种情况：退货并且用户已收到货且需要退货
			 * 此时需要对退货的商品进行验证：退货数量不能超过（此SKU的购买量-为作废已申请退货数量）
			 * TODO:退款此处先走不通。。。。待调试
			 */
              
			//商品可能部分退掉进行商品数量判断
			foreach ($ary_data['checkSon'] as $v) {
				if(!empty($ary_data['inputNum'][$v]) && isset($ary_returns_temp[$v])) {
					if(!ctype_digit($ary_data['inputNum'][$v])) $this->error("退货数量填写需正整数");
					if($ary_data['inputNum'][$v]>$ary_returns_temp[$v]['nums']) $this->error("商品编号是{$ary_returns_temp[$v]['g_sn']}退货数量不能大于购买商量");
					if(($ary_data['inputNum'][$v] + $ary_returns_temp[$v]['num'] )> $ary_returns_temp[$v]['nums']){
						$str_th_sum = intval($ary_returns_temp[$v]['nums'] - $ary_returns_temp[$v]['num']);
						if($str_th_sum>0){
                                                    output_msg("商品编号是{$ary_returns_temp[$v]['g_sn']}的退货数量只能退{$str_th_sum}件", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
						}
						else{
                                                     output_msg("商品编号是{$ary_returns_temp[$v]['g_sn']}的已经退过货，不能重复退货", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
						}
					}
				}
			}
			$ary_where = array(
				'fx_orders_refunds.o_id'=>$ary_data['o_id'],
				'fx_orders_refunds.m_id' => $members['m_id'],
				'fx_orders_refunds.or_processing_status'=>array('neq',2),
				'fx_orders_refunds.or_refund_type'=>2
			);
			$ary_returns_orders = D('OrdersRefunds')
			->field('fx_orders_items.pdt_id,fx_orders_items.oi_nums,fx_orders_refunds_items.ori_num,fx_orders_items.g_sn')
			->join('left join fx_orders_refunds_items on fx_orders_refunds.or_id = fx_orders_refunds_items.or_id')
			->join(" fx_orders_items ON fx_orders_refunds_items.oi_id=fx_orders_items.oi_id")
			->where($ary_where)
			->select();


			if($ary_returns_orders){
				//已经加入的退货单商品详情
				$ary_returns_temp = array();
				foreach($ary_returns_orders as $val) {

					if(!isset($ary_returns_temp[$val['pdt_id']])){
						$ary_returns_temp[$val['pdt_id']]['num'] = $val['ori_num'];//已退货的货号商品总数
						$ary_returns_temp[$val['pdt_id']]['nums'] = $val['oi_nums'];//此订单货号总数
						$ary_returns_temp[$val['pdt_id']]['g_sn'] = $val['g_sn'];
					}
					else{
						$ary_returns_temp[$val['pdt_id']]['num'] += $val['ori_num'];
					}
				}
					

			}
			else{
				foreach ($ary_data['checkSon'] as $v) {
					if(!empty($ary_data['inputNum'][$v]) && isset($ary_temp_items[$v])) {
						if(!is_numeric($ary_data['inputNum'][$v])){
                                                    output_msg("退货数量填写需正整数", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
                        }
						if($ary_data['inputNum'][$v]>$ary_temp_items[$v]['oi_nums']){
                                                    output_msg("商品编号是{$ary_temp_items[$v]['g_sn']}退货数量不能大于购买商量", array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
                        }
					}
				}
			}
		}
        //上传图片
        if($_FILES['upload_file_0']['name']){
			$path = './Public/Uploads/' . CI_SN.'/images/aftersale/'.date('Ymd').'/';
			if(!file_exists($path)){
				@mkdir('./Public/Uploads/' . CI_SN.'/images/aftersale/'.date('Ymd').'/', 0777, true);
			}
			
	    	//import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg','bmp');// 设置附件上传类型GIF，JPG，JPEG，PNG，BM
			$upload->savePath =  $path;// 设置附件上传目录
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->error($upload->getErrorMsg());
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
				$ary_refunds['or_picture'] = '/Public/Uploads/'.CI_SN.'/images/aftersale/' .date('Ymd').'/'. $info[0]['savename'];
				$ary_refunds['or_picture'] = D('ViewGoods')->ReplaceItemPicReal($ary_refunds['or_picture']);
			}
    	}
		//上传图片  -- 用户上传的退货凭证图片文件
		// if(isset($ary_data['extend_field_0']) && !empty($ary_data['extend_field_0'])) {
		// 	$ary_refunds['or_picture'] = '/'.str_replace("//","/",ltrim(str_replace('Lib/ueditor/php/../../../','',$ary_data['extend_field_0']),'/'));
		// }
         $ary_refunds['or_reason']     = $ary_data['ary_reason'];
         $ary_refunds['or_return_sn']  = strtotime("now");
         if(!empty($ary_data['AfterSalesCode']))
         {
            $ary_refunds['AfterSalesCode'] = $ary_data['AfterSalesCode'];
         }

        //$this->assign('ary_extend_data', $ary_extend_data);$ary_data
		//售后数据存入数据库  需要启用事务机制
		M('', '', 'DB_CUSTOM')->startTrans();
		$ary_refunds['or_update_time'] = date('Y-m-d H:i:s');
		//插入退款主表
		$int_or_id = D('OrdersRefunds')->add($ary_refunds);
		if (false === $int_or_id) {
            
		   // var_dump($int_or_id);exit;
			M('', '', 'DB_CUSTOM')->rollback();
                         output_msg('售后申请提交失败。', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
		}
        
        /*附加属性组装数据 start*/
        $ary_extend_temp = array();
       
        $ary_extend_data=D('RefundsSpec')->getSpecByType($ary_data['or_refund_type']);
       
        foreach($ary_extend_data as $val) {
            switch($val['gs_input_type']){
                case 1://文本框
                      if(isset($ary_data['extend_field_'.$val['gs_id']]) && !empty($ary_data['extend_field_'.$val['gs_id']])) {
                        //echo $ary_data['extend_field_'.$val['gs_id']];var_dump(trim(htmlspecialchars($ary_data['extend_field_'.$val['gs_id']],'ENT_QUOTES')));exit;
                        $ary_extend_temp[] = array('or_id'=>$int_or_id,'gs_id'=>$val['gs_id'],'content'=>trim($ary_data['extend_field_'.$val['gs_id']]));
                      }
                   break;
                case 2:
                    if($_FILES['upload_file_'.$val['gs_id']]['name']){
			            @mkdir('./Public/Uploads/' . CI_SN.'/images/'.date('Ymd').'/');
				    	//import('ORG.Net.UploadFile');
						$upload = new UploadFile();// 实例化上传类
						$upload->maxSize  = 3145728 ;// 设置附件上传大小
						$upload->allowExts = array('rar', 'zip');// 设置附件上传类型GIF，JPG，JPEG，PNG，BM
						$upload->savePath =  './Public/Uploads/'.CI_SN.'/images/'.date('Ymd').'/';// 设置附件上传目录
						if(!$upload->upload()) {// 上传错误提示错误信息
							$this->error($upload->getErrorMsg());
						}else{// 上传成功 获取上传文件信息
							$info =  $upload->getUploadFileInfo();
							$ary_data['extend_field_'.$val['gs_id']] = '/Public/Uploads/'.CI_SN.'/images/' .date('Ymd').'/'. $info[0]['savename'];
						}
			    	}
                   //附件
                      if(isset($ary_data['extend_field_'.$val['gs_id']]) && !empty($ary_data['extend_field_'.$val['gs_id']])) {
                        //$ary_extend_temp[] = array('or_id'=>$int_or_id,'gs_id'=>$val['gs_id'],'content'=>'/'.str_replace("//","/",ltrim(str_replace('Lib/ueditor/php/../../../','',$ary_data['extend_field_'.$val['gs_id']]),'/')));
                        $ary_extend_temp[] = array('or_id'=>$int_or_id,'gs_id'=>$val['gs_id'],'content'=>$ary_data['extend_field_'.$val['gs_id']]);
				      }
                   break;
                case 3://文本域
                      if(isset($ary_data['extend_field_'.$val['gs_id']]) && !empty($ary_data['extend_field_'.$val['gs_id']])) {
                        $ary_extend_temp[] = array('or_id'=>$int_or_id,'gs_id'=>$val['gs_id'],'content'=>trim($ary_data['extend_field_'.$val['gs_id']],'ENT_QUOTES'));
                      } 
                   break; 
                default:
                  break;
            }
        }
       
        if(count($ary_extend_temp)>0) {
                $int_return_refund_spec = D('RelatedRefundSpec')->addAll($ary_extend_temp);
                //var_dump($int_return_refund_spec);exit;
			     if (false == $int_return_refund_spec) {
				        M('', '', 'DB_CUSTOM')->rollback();
                                         output_msg('批量插入自定义属性失败。', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			   }
        }
      
        /*附加属性组装数据 end*/

		//自动生成售后单据编号，单据编号的规则为20130628+8位单据ID（不足8位左侧以0补全）
		$int_tmp_or_id = $int_or_id;
		$or_return_sn = date("Ymd") . sprintf('%07s',$int_tmp_or_id);
		$array_modify_data = array("or_return_sn"=>$or_return_sn);
                if($o_payment == 16)
                {
                    $array_modify_data['or_refunds_type'] = 4;
                }
		$mixed_result = D('OrdersRefunds')->where(array("or_id"=>$int_or_id,'or_update_time'=>date('Y-m-d H:i:s')))->save($array_modify_data);
                   //     $balance = new Balance();
                        //$ary_order_refund_info = $orders->where(array('or_id' => $ary_post['id']))->find();
                        $arr_data = array();

                        $arr_data['o_id'] = $ary_data['o_id'];
                        $arr_data['m_id'] =$members['m_id'];
                        $arr_data['bi_accounts_receivable'] = $ary_refunds['or_account'];
                        $arr_data['bi_accounts_bank'] = $ary_refunds['or_bank'];
                        $arr_data['bi_payeec'] = $ary_refunds['or_payee'];
                        $arr_data['bi_type'] = '0';
                        $arr_data['or_id'] = $or_return_sn;
                        $arr_data['o_payment'] = $o_payment;
                        $arr_data['bi_money'] = $ary_refunds['or_money'];
                        $arr_data['u_id'] = "admin";
                        $arr_data['bi_create_time'] = date("Y-m-d H:i:s");
                        $arr_data['bi_payment_time'] = date("Y-m-d H:i:s");
                        $arr_data['bt_id'] = '2';
                        $arr_data['bi_finance_verify'] = '0';
                        $arr_data['bi_service_verify'] = '0';
                        $arr_data['bi_verify_status'] = '1';
                        $arr_data['bi_desc'] = '买家退款或退货';
                        $ary_rest = M('balance_info',C('DB_PREFIX'),'DB_CUSTOM')->add($arr_data);
                        $str_sn = str_pad($ary_rest,6,"0",STR_PAD_LEFT);
                        $ary_data['bi_sn'] = time() . $str_sn;
                        M('balance_info',C('DB_PREFIX'),'DB_CUSTOM')->where(array('bi_id'=>$ary_rest))->data($ary_data)->save();
                        //获取结余款调整单基本表
                        $balance_info = M('balance_info',C('DB_PREFIX'),'DB_CUSTOM')->where(array('bi_id'=>$ary_rest))->find();

                        //写入客审结余款调整单日志
//                        $balance_server_log['u_id'] = $ary_refunds['or_service_u_id'];
//                        $balance_server_log['u_name'] = $ary_refunds['or_service_u_name'];
//                        $balance_server_log['bi_sn'] = $balance_info['bi_sn'];
//                        $balance_server_log['bvl_desc'] = '审核成功';
//                        $balance_server_log['bvl_type'] = '2';
//                        $balance_server_log['bvl_status'] = '1';
//                        $balance_server_log['bvl_create_time'] = $ary_refunds['or_service_time'];
//                        if(false === M('balance_verify_log',C('DB_PREFIX'),'DB_CUSTOM')->add($balance_server_log)){
//                         M('', '', 'DB_CUSTOM')->rollback();
//                            output_msg('生成结余款调整单日志失败。', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
//                        }
                        //写入财审结余款调整单日志
//                        $balance_finance_log['u_id'] = $ary_refunds['or_finance_u_id'];
//                        $balance_finance_log['u_name'] = $ary_refunds['or_finance_u_name'];
//                        $balance_finance_log['bi_sn'] = $balance_info['bi_sn'];
//                        $balance_finance_log['bvl_desc'] = '审核成功';
//                        $balance_finance_log['bvl_type'] = '3';
//                        $balance_finance_log['bvl_status'] = '1';
//                        $balance_finance_log['bvl_create_time'] = $ary_refunds['or_finance_time'];
//                        if(false === M('balance_verify_log',C('DB_PREFIX'),'DB_CUSTOM')->add($balance_finance_log)){
//                          M('', '', 'DB_CUSTOM')->rollback();
//                                     output_msg('生成结余款调整单日志失败。', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
//                        }
                        //写入支付序列日志
//                        $m_balance = M('members',C('DB_PREFIX'),'DB_CUSTOM')->where(array('m_id'=>$ary_refunds['m_id']))->getField('m_balance');
//                        $running_acc['ra_payment_method'] = "预存款";
//                        $running_acc['ra_before_money'] = $m_balance - $ary_refunds['or_money'];
//                        $running_acc['ra_after_money'] = $m_balance;
//                        $running_acc['ra_money'] = $ary_refunds['or_money'];
//                        $running_acc['m_id'] = $ary_refunds['m_id'];
//                        $running_acc['ra_memo'] = "买家退款或退货";
//                        $running_acc['ra_type'] = 4;
//                        M('running_account',C('DB_PREFIX'),'DB_CUSTOM')->add($running_acc);
		if(false === $mixed_result){
			M('', '', 'DB_CUSTOM')->rollback();
                        output_msg('售后申请提交失败。CODE:CREATE-REFUND-SN-ERROR.。', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
		}
		//插入明细表
		$ary_refunds_items = array();
		if($ary_data['or_refund_type']==2 && $ary_data['sh_radio']==1 && $ary_data['th_radio']==1){
			$or_money = 0;
			//商品可能部分退掉

			foreach ($ary_data['checkSon'] as $v) {
				if(!empty($ary_data['inputNum'][$v]) && isset($ary_temp_items[$v])) {
					$ary_refunds_items[] = array(
							'o_id' => $ary_temp_items[$v]['o_id'],
							'or_id' => $int_or_id,
							'oi_id' => $ary_temp_items[$v]['oi_id'],
							'ori_num' => $ary_data['inputNum'][$v],
							'erp_id' =>$ary_temp_items[$v]['erp_id']
					);
					$or_money +=  $ary_data['inputNum'][$v]*$ary_temp_items[$v]['oi_price']/$ary_temp_items[$v]['oi_nums'];

				}
			}
            
            //如果申请退货并需要换货，无须添加退款金额
			/*$res = D('OrdersRefunds')->where(array('or_id'=>$int_or_id,'or_update_time'=>date('Y-m-d H:i:s')))->save(array('or_money'=>$or_money));
			if(!$res){
				M('', '', 'DB_CUSTOM')->rollback();
				$this->error('更新退货主表金额失败','',true);
			}*/
				
			//批量插明细表
			$int_return_refunds_itmes = D('OrdersRefundsItems')->addAll($ary_refunds_items);

			if (false === $int_return_refunds_itmes) {
				M('', '', 'DB_CUSTOM')->rollback();
                                 output_msg('批量插入明细失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
            
            //更改订单详情表商品退货状态
            foreach ($ary_data['checkSon'] as $oi_id){
                if(false === M('orders_items',C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id'=>$ary_data['o_id'],'oi_id'=>$oi_id))->data(array('oi_refund_status'=>3))->save()){
                    M('', '', 'DB_CUSTOM')->rollback();
                      output_msg('更新退货状态失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
                }
            }
		}elseif($ary_data['or_refund_type']==2 && $ary_data['sh_radio']==1 && $ary_data['th_radio']==0){
            $or_money = 0;
            foreach ($ary_temp_items as $v) {
                $ary_refunds_items[] = array(
                            'o_id' => $v['o_id'],
                            'or_id' => $int_or_id,
                            'oi_id' => $v['oi_id'],
                            'ori_num' => $v['oi_nums'],
                            'erp_id' =>$v['erp_id']
                );
                $or_money +=  $v['oi_price']*$v['oi_nums'];
            }
			//跨境贸易
			if(isset($orders_res['o_tax_rate']) && $orders_res['o_tax_rate']>0){
				$or_money += $orders_res['o_tax_rate'];
			}
            //print_r($ary_refunds_items);exit;
            //批量插明细表
            //获取物流费用
            $o_cost_freight = D('Orders')->where(array('o_id'=>$ary_data['o_id']))->getField('o_cost_freight');
			if(sprintf("%.2f",$or_money+$o_cost_freight)-sprintf("%.2f",$ary_data['application_money'])>=0) {
				if($ary_refunds_items){
					$int_return_refunds_itmes = D('OrdersRefundsItems')->addAll($ary_refunds_items);
					if (!$int_return_refunds_itmes) {
						M('', '', 'DB_CUSTOM')->rollback();
                                                  output_msg('批量插入明细失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
					}
				}
			}else {
				//暂时隐藏
                             output_msg('输入退款金额必须小于订单商品总金额', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
            //更改订单详情表商品退款状态

            if(false === M('orders_items',C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id'=>$ary_data['o_id']))->data(array('oi_refund_status'=>2))->save()){
                M('', '', 'DB_CUSTOM')->rollback();
                output_msg('更新退货状态失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
            }
            
        }elseif($ary_data['or_refund_type']==1){
			/* by Mithern 退款时不需要想明细表写入数据 */
			/*	$or_money = 0;
			 foreach ($ary_temp_items as $v) {
				$ary_refunds_items[] = array(
				'o_id' => $v['o_id'],
				'or_id' => $int_or_id,
				'oi_id' => $v['oi_id'],
				'ori_num' => $v['oi_nums']
				);
				$or_money +=  $v['oi_price'];
				}

				$res = D('OrdersRefunds')->where(array('or_id'=>$int_or_id))->save(array('or_money'=>$or_money));
				if(!$res){
				$obj_refunds->rollback();
				$this->error('更新退款主表金额失败');
				}*/
			//
			$or_money = 0;
			foreach ($ary_temp_items as $v) {
				$ary_refunds_items[] = array(
							'o_id' => $v['o_id'],
							'or_id' => $int_or_id,
							'oi_id' => $v['oi_id'],
							'ori_num' => $v['oi_nums'],
							'erp_id' =>$v['erp_id']
				);
				$or_money +=  $v['oi_price']*$v['oi_nums'];
			}
			//跨境贸易
			if(isset($orders_res['o_tax_rate']) && $orders_res['o_tax_rate']>0){
				$or_money += $orders_res['o_tax_rate'];
			}
			
			if($ary_data['or_refund_type']==1){
				//当商品有折扣，按照商品总价打折计算的订单四舍五入成小数位两位的总价大于按照商品单价打折后乘以件数计算总价时，申请全额退款会报错
				$or_money = $result_price;
			}
			//批量插明细表
            //获取物流费用
            $o_cost_freight = D('Orders')->where(array('o_id'=>$ary_data['o_id']))->getField('o_cost_freight');
			if(sprintf("%.2f",$or_money+$o_cost_freight)-sprintf("%.2f",$ary_data['application_money'])>=0) {
				if($ary_refunds_items){
					$int_return_refunds_itmes = D('OrdersRefundsItems')->addAll($ary_refunds_items);
					if (!$int_return_refunds_itmes) {
						M('', '', 'DB_CUSTOM')->rollback();
                                                output_msg('批量插入明细失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
					}
				}
			}else {
				//暂时隐藏
                             output_msg('输入退款金额必须小于订单商品总金额', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
            //更改订单详情表商品退款状态
 
            if(false === M('orders_items',C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id'=>$ary_data['o_id']))->data(array('oi_refund_status'=>2))->save()){
                M('', '', 'DB_CUSTOM')->rollback();
                 output_msg('更新退货状态失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
            }
            
		}

		//用户提示语定义
		$str_type = '售后';
		switch($refund_type){
			case 2:
				$str_type = '退款';
				break;
			case 3:
				$str_type = '退货';
				break;
		}
		//判读是否需要拆分
		$orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
		$order_info = $orders->where(array('o_id'=>$ary_data['o_id']))->find();
		$resdata1 = D('SysConfig')->getCfg('ORDERS_REMOVE','ORDERS_REMOVE','1','是否开启订单拆分');
		$resdata2 = D('SysConfig')->getCfg('ORDERS_REMOVETYPE','ORDERS_REMOVETYPE','1','订单拆分方式(1:自动拆分;0:手动拆分)');
		if(($resdata1['ORDERS_REMOVE']['sc_value'] == '1') && ($resdata2['ORDERS_REMOVETYPE']['sc_value'] == '1')){
			if($order_info['is_diff'] == '1'){
				//售后拆单$int_or_id
				$erp_ids = M('orders_refunds_items', C('DB_PREFIX'), 'DB_CUSTOM')->field('erp_id')->where(array('or_id'=>$int_or_id))->group('erp_id')->select();
				if(count($erp_ids) == '1'){
					$res_refund = M('orders_refunds', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('or_id'=>$int_or_id))->data(array('or_update_time'=>date('Y-m-d H:i:s')))->save();
					if(false === $res_refund){
						M('', '', 'DB_CUSTOM')->rollback();
                                                output_msg('售后单更新失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
					}
				}else{
					foreach($erp_ids as $erp){
						$refund_data = M('orders_refunds', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('or_id'=>$int_or_id))->find();
						$refund_data['initial_tid'] = $int_or_id;
						unset($refund_data['or_id']);
						$refund_data['or_money'] = 0;
						$refund_data['erp_id'] = $erp['erp_id'];
						$refund_data['or_update_time'] = date('Y-m-d H:i:s');
						$res_refund_id = M('orders_refunds', C('DB_PREFIX'), 'DB_CUSTOM')->data($refund_data)->add();
						if(!$res_refund_id){
							M('', '', 'DB_CUSTOM')->rollback();
                                                        output_msg('售后单拆单失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
						}
						$refund_items_data = M('orders_refunds_items', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('or_id'=>$int_or_id,'erp_id'=>$erp['erp_id']))->select();
						foreach ($refund_items_data as $refund_items){
							unset($refund_items['ori_id']);
							$refund_items['or_id'] = $res_refund_id;
							
							$refund_item_res = M('orders_refunds_items', C('DB_PREFIX'), 'DB_CUSTOM')->data($refund_items)->add();
							if(!$refund_item_res){
								M('', '', 'DB_CUSTOM')->rollback();
                                                                 output_msg('售后单新增失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
							}
						}	
					}
				}
			}else{
				M('', '', 'DB_CUSTOM')->rollback();
                                 output_msg('此订单拆单之后才可进行售后操作', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
			}
		}

		//单据id:$int_or_id;订单号：$ary_data['o_id'] 
		//更新日志表
		$ary_orders_log = array(
				'o_id'=>$ary_data['o_id'],
				'ol_behavior' => '会员新增售后申请',
				'ol_uname'=>$members['m_mobile']
		);
		$res_orders_log = D('OrdersLog')->addOrderLog($ary_orders_log);
		if(!$res_orders_log){
			M('', '', 'DB_CUSTOM')->rollback();
                        output_msg('会员新增售后申请日志失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
		}
		$res_orders = D('Orders')
		->data(array('o_update_time'=>date('Y-m-d H:i:s')))
		->where(array('o_id'=>$ary_data['o_id']))->save();
		
		if(!$res_orders){
			M('', '', 'DB_CUSTOM')->rollback();
                         output_msg('会员新增售后申请失败', array('orderno'=>$ary_data['o_id'],'flag' => FALSE));
		}
		//事务提交
		M('', '', 'DB_CUSTOM')->commit();
                return TRUE;
	}
    
    
    
    private function ApiCallback() {
    
        $arr_array = file_get_contents('php://input');  
        $ary_post = json_decode($arr_array, true);
        if (empty($ary_post)) {
            output_error(null, array('result' => "1", 'error' => '数据有误'));
        }
        $o_id = $ary_post['order_no'];

        switch ($ary_post['status']) {
            case 2:
                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
                if($ary_post['express_status'] == 0)
                {
                        $ary_orders = $orders_info->where(array("erp_status" => $ary_post['status'], 'AuditStatus' =>1, 'o_id' => $o_id))->find();
                        if ($ary_orders) {
                             output_msg("已审核，无需再次审核", array('flag' => TRUE));
                        }                                                                                           
                        $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('AuditStatus' => 1, 'erp_status' => $ary_post['status'], 'IdentificationStatusTime' => date('Y-m-d H:i:s')))->save();
                        if ($res) {
                            output_msg("同步成功", array('flag' => TRUE));
                        }else{
                            output_msg("同步失败", array('flag' => FALSE));
                        }
                }else{
                        $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');//"erp_status" => $ary_post['status'], 
                        $ary_orders_data = $orders_info->where(array('o_id' => $o_id, 'express_status' => $ary_post['express_status']))->find(); //
                        if ($ary_orders_data) {
                            output_error(null, array('result' => "1", 'error' => '订单' . $o_id . '已发货，无需再次发货')); //'DeclareStatus' => $ary_post['DeclareStatus'], 
                        }
                        if(empty($ary_post['express_no']))
                        {
                               output_msg("运单号不能为空", array('flag' => FALSE));
                        }
                        if($ary_post['express_status'] == 1)
                        {
                            $this->UpdateOrderStatus($o_id,$ary_post['express_no'],$ary_post['express']);
                        }
                        $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('erp_status' => $ary_post['status'],'express_status' => $ary_post['express_status'],  'DeliveredTime' => $ary_post['status']))->save();
                        if ($res) {
                            output_msg("同步发货成功", array('flag' => TRUE));
                        }else{
                             output_msg("同步发货失败", array('flag' => FALSE));
                        }
                }
                   break;
            case 3:
                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');//"erp_status" => $ary_post['status'],
                $ary_order = $orders_info->where(array( 'o_id' => $o_id))->find(); //, 'DeclarationStatus' => $ary_post['DeclarationStatus']
                if ($ary_order['erp_status'] == $ary_post['status']) {
                      output_msg('订单' . $o_id . '已收货，无需再次收货', array('flag' => TRUE));
                }
                  //  $ary_order = M('Orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->find();
                    if (!empty($ary_order) && is_array($ary_order)) {
                        M('', '', 'DB_CUSTOM')->startTrans();
                        $ary_result = M('Orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                                    'o_id' => $o_id
                                ))->data(array(
                                    'o_status' => '5'
                                ))->save();
                        if (FALSE !== $ary_result) {
                            /*                 * ** 处理订单积分****start****By Joe***** */
                            $array_point_config = D('PointConfig')->getConfigs();
                            if ($array_point_config ['is_consumed'] == '1' && $array_point_config['cinsumed_channel'] == '1') {
                                // 确认收货后处理赠送积分
                                if ($ary_order['o_reward_point'] > 0) {
                                    $ary_reward_result = D('PointConfig')->setMemberRewardPoint($ary_order['o_reward_point'], $ary_order ['m_id'],$ary_order['o_id']);
                                    if (!$ary_reward_result ['result']) {
                                        M('', '', 'DB_CUSTOM')->rollback();
                                          output_msg($ary_reward_result['message'], array('flag' => FALSE));
                                        exit();
                                    }
                                }

                                // 确认收货后处理消费积分
                                if ($ary_order ['o_freeze_point'] > 0) {
                                    $ary_freeze_result = D('PointConfig')->setMemberFreezePoint($ary_order['o_freeze_point'], $ary_order ['m_id']);
                                    if (!$ary_freeze_result['result']) {
                                        M('', '', 'DB_CUSTOM')->rollback();
                                        $this->error($ary_freeze_result['message']);
                                        exit();
                                    }
                                }
                            }
                            /*                 * ** 处理订单积分****end********* */

                            /*                 * * 订单发货后获取订单优惠券**star by Joe* */
                            //获取优惠券节点
                            $coupon_config = D('SysConfig')->getCfgByModule('GET_COUPON');
                            $where = array('fx_orders.o_id' => $o_id);
                            $ary_field = array('fx_orders.o_pay', 'fx_orders.o_all_price', 'fx_orders.coupon_sn', 'fx_orders_items.pdt_id', 'fx_orders_items.oi_nums', 'fx_orders_items.oi_type');
                            $ary_orders = D('Orders')->getOrdersData($where, $ary_field);
                            // 本次消费金额=支付单最后一次消费记录
                            $payment_serial = M('payment_serial')->where(array('o_id' => $o_id))->order('ps_create_time desc')->select();
                            $payment_price = $payment_serial[0]['ps_money'];
                            $all_price = $ary_orders[0]['o_all_price'];
                            $coupon_sn = $ary_orders[0]['coupon_sn'];
                            if ($coupon_sn == "" && $coupon_config['GET_COUPON_SET'] == '2') {
                                D('Coupon')->setPoinGetCoupon($ary_orders, $ary_order['m_id']);
                            }
                            /*                 * * 订单发货后获取订单优惠券****end********* */
                            /**              * 确认收货后更新商品库存                 */
                            $order_items = D('OrdersItems')
                                ->field('oi_nums, oi_type, pdt_id, g_id')
                                ->where(array(
                                'o_id'  => $o_id
                            ))->select();
                            /* 确认收货 库存不变(库存的减少和冻结在 支付成功时候操作)
                            $goodsProductsModel = D('GoodsProductsTable');
                            foreach($order_items as $item) {
                                $good_sale_status=D('Goods')->field(array('g_pre_sale_status'))->where(array('g_id'=>$item['g_id']))->find();
                                //预售商品和商品预售状态为1的商品不减库存
                                if($item['oi_type'] != 8 && $good_sale_status['g_pre_sale_status'] != 1) {
                                    $update_stock = $goodsProductsModel->data(array(
                                        'pdt_total_stock' => array('exp', 'pdt_total_stock-' . $item['oi_nums']),
                                        'pdt_freeze_stock' => array('exp', 'pdt_freeze_stock-' . $item['oi_nums']),
                                    ))->where(array(
                                        'pdt_id' => $item['pdt_id']
                                    ))->save();
                                    if ($update_stock == false) {
                                        M('', '', 'DB_CUSTOM')->rollback();
                                        $this->error("订单 " . $ary_get ['oid'] . " 确认收货失败，请重试...");
                                    }
                                }
                            }
                            */
                            /**   +++++++++++++ 确认收货后更新商品库存  +++++++++++++++EMD+++++++++++++  */
                            M('', '', 'DB_CUSTOM')->commit();
                      
                        } else {
                            M('', '', 'DB_CUSTOM')->rollback();
                            output_msg("订单 " . $o_id . " 确认收货失败，请重试...", array('flag' => FALSE));
                        }
                    } else {
                        output_msg("订单 " . $o_id . " 不存在", array('flag' => FALSE));
                    }
                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('erp_status' => $ary_post['status'], 'ReceivedTime' => date('Y-m-d H:i:s')))->save();
                if ($res) {
                               output_msg("同步确认收货成功", array('flag' => TRUE));
                }else{
                     output_msg("同步收货失败", array('flag' => FALSE));
                }
                break;
            case 5:
                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
                $ary_orders = $orders_info->where(array("erp_status" => $ary_post['status'], 'o_id' => $o_id))->find(); //, 'IdentificationStatus' => $ary_post['IdentificationStatus']
                if ($ary_orders) {
                      output_msg("订单 " . $o_id . " 已作废,请不要重复", array('flag' => FALSE));
                }                                                                                                               //'IdentificationStatus' => $ary_post['IdentificationStatus'],
                      $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array( 'erp_status' => 5,'o_error'=>$ary_post['error']))->save();
                if ($res) {
                      output_msg("同步作废成功", array('flag' => TRUE));
                }else{
                      output_msg("同步作废失败", array('flag' => FALSE));
                }
                break;
//            case 2:
//                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
//                $ary_orders = $orders_info->where(array("erp_status" => $ary_post['status'], 'o_id' => $o_id))->find(); //, 'IdentificationStatus' => $ary_post['IdentificationStatus']
//                if ($ary_orders) {
//                    output_error(null, array('result' => "1", 'error' => '订单' . $o_id . '已验证，无需再次验证'));
//                }                                                                                                               //'IdentificationStatus' => $ary_post['IdentificationStatus'],
//                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array( 'erp_status' => $ary_post['status']))->save();
//                if ($res) {
//                      output_msg("同步验证成功", array('flag' => TRUE));
//                }else{
//                      output_msg("同步验证失败", array('flag' => FALSE));
//                }
//                break;
//            case 3:
//                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
//                $ary_orders = $orders_info->where(array("erp_status" => $ary_post['status'], 'o_id' => $o_id))->find(); //, 'PseudoPayStatus' => $ary_post['PseudoPayStatus']
//                if ($ary_orders) {
//                    output_error(null, array('result' => "1", 'error' => '订单' . $o_id . '已代扣，无需再次代扣'));     //'PseudoPayStatus' => $ary_post['PseudoPayStatus'],
//                }
//                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array( 'erp_status' => $ary_post['status'], 'PseudoPayStatusTime' => date('Y-m-d H:i:s')))->save();
//                if ($res) {
//                        output_msg("同步代扣成功", array('flag' => TRUE));
//                }else{
//                        output_msg("同步代扣失败", array('flag' => FALSE));
//                }
//                break;
//            case 4:
//                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
//                $ary_orders = $orders_info->where(array("erp_status" => $ary_post['status'], 'o_id' => $o_id))->find(); //, 'TransportationStatus' => $ary_post['TransportationStatus']
//                if ($ary_orders) {
//                    output_error(null, array('result' => "1", 'error' => '订单' . $o_id . '已报运，无需再次代扣'));//'TransportationStatus' => $ary_post['TransportationStatus'],
//                }                                   
//                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array( 'erp_status' => $ary_post['status'], 'TransportationStatusTime' => date('Y-m-d H:i:s')))->save();
//                if ($res) {
//                       output_msg("同步报运成功", array('flag' => TRUE));
//                }else{
//                      output_msg("同步报运失败", array('flag' => FALSE));
//                }
//                break;
//            case 5:
//                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
//                $ary_orders = $orders_info->where(array("erp_status" => $ary_post['status'], 'o_id' => $o_id))->find(); //, 'DeclarationStatus' => $ary_post['DeclarationStatus']
//                if ($ary_orders) {
//                    output_error(null, array('result' => "1", 'error' => '订单' . $o_id . '已报关，无需再次代扣'));//'DeclarationStatus' => $ary_post['DeclarationStatus'], 
//                }
//                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('erp_status' => $ary_post['status'], 'DeclarationStatusTime' => date('Y-m-d H:i:s')))->save();
//                if ($res) {
//                              output_msg("同步报关成功", array('flag' => TRUE));
//                }else{
//                     output_msg("同步报关失败", array('flag' => FALSE));
//                }
//                break;
//            case 6:
//                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');        
//                $ary_orders = $orders_info->where(array("erp_status" => $ary_post['status'], 'o_id' => $o_id))->find();//, 'DeclareStatus' => $ary_post['DeclareStatus']
//                if ($ary_orders) {
//                    output_error(null, array('result' => "1", 'error' => '订单' . $o_id . '已申报，无需再次代扣'));//'DeclareStatus' => $ary_post['DeclareStatus'], 
//                }
//                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('erp_status' => $ary_post['status'], 'DeclareStatusTime' =>date('Y-m-d H:i:s')))->save();
//                if ($res) {
//                        output_msg("同步申报成功", array('flag' => TRUE));
//                }else{
//                      output_msg("同步申报失败", array('flag' => FALSE));
//                }
//                break;
//            case 7:
//                $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');//"erp_status" => $ary_post['status'], 
//                $ary_orders_data = $orders_info->where(array('o_id' => $o_id))->find(); //, 'DeclareStatus' => $ary_post['DeclareStatus']
//                if ($ary_orders_data['erp_status'] == $ary_post['status']) {
//                    output_error(null, array('result' => "1", 'error' => '订单' . $o_id . '已发货，无需再次发货')); //'DeclareStatus' => $ary_post['DeclareStatus'], 
//                }
//                if(empty($ary_post['express_no']))
//                {
//                       output_msg("运单号不能为空", array('flag' => FALSE));
//                }
//                if($ary_post['express_status'] == 1)
//                {
//                    $this->UpdateOrderStatus($o_id,$ary_post['express_no'],$ary_post['express']);
//                }
//                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('erp_status' => $ary_post['status'],'express_status' => $ary_post['DeclareStatus'],  'DeliveredTime' => $ary_post['status']))->save();
//                if ($res) {
//                    output_msg("同步发货成功", array('flag' => TRUE));
//                }else{
//                     output_msg("同步发货失败", array('flag' => FALSE));
//                }
//                break;
        }
    }

   public function ceshi() {
//               $a['cart'] = array(1164=>3,602=>3,1874=>4);
//        $a['token'] = "f15814bc224dd50442affbd86e78e593";
//      //  print_r(json_encode($a));exit;
//       $CC = makeRequestApiJsonceshi("http://txy.com/Api/Cart/doAddAll", json_encode($a),"POST");201608221414598064

//      print_r($CC);exit;
//       
//         $json_order  = '{"action":"ChangeOrder","operation":"order_cancel","error":"你好啊","orderno":"201609291030302948"}';
//       $success = makeRequestApiJsonceshi("http://txy.com/Api/ApiOrderCallback/", $json_order, "POST");
// print_r($success);exit;
       
   //    $json_order  = '{"action":"ChangeOrder","operation":"order_express","express":"EMS","express_no":"9735206032501","express_fee":0.00,"express_time":null,"orderno":"201610100956184715"}';
//      
//       $ary_post = json_decode($json_order,true);	

         $json_order = '{"action":"Refund","orderno":"201610141135405398","goodsno":"GMH04728-J","quantity":2,"price":222.00,"OutRemark":"teset","AfterSalesCode":"C1608250610248131347"}';
//    
//        //$aa =  $this->ChangeOrder($ary_post);
//      //  print_r($aa);exit;
       $success = makeRequestApiJsonceshi("http://txy.com/Api/ApiOrderCallback/", $json_order, "POST");
 print_r($success);exit;
////        exit;
//echo  $this->callbackOrder();exit;
        $json_one= '{"action":"Refund","price":"156.00","orderno":"201609291027561390","goodsno":"GMH04738-J","quantity":2,"OutRemark":"213213"}';
        $success = makeRequestApiJsonceshi("http://txy.com/Api/ApiOrderCallback/", $json_one, "POST");
        print_r($success);      
        exit;

        
    $json = '{
    "action": "callbackOrder",
    "data": {
        "order_no": "201606081504522474",
        "user_name": "13687292751",
        "payment_title": "上海盛付通电子支付服务有限公司",
        "payment_fee": 0,
        "payment_status": 1,
        "payment_time": null,
        "express": "顺丰快递",
        "express_no": "4154515",
        "express_fee": 0,
        "express_status": 2,
        "declareTime": null,
        "express_time": null,
        "accept_name": "ads",
        "post_code": "",
        "mobile": "18983178741",
        "email": "",
        "area": "山西省,长治市,长治县",
        "address": "123",
        "IDNO": "111111111111111112",
        "remark": "",
        "payable_amount": 240,
        "real_amount": 240,
        "order_amount": 240,
        "user_amount": 0,
        "point": 0,
        "status": 1,
        "error": "你好啊",
        "add_time": "2016-04-29T21:30:11.963",
        "confirm_time": null,
        "complete_time": null,
        "_ToOrderDetail": [
            {
                "Goods_no": "10223054131001",
                "Goods_title": "日本花王Merries纸尿裤 大号L 54片（9-14kg）",
                "Img_url": "www.haigouchuan.com/upload/201509/25/201509251005109718.jpg",
                "Spec_text": "",
                "Goods_price": 120,
                "Real_price": 120,
                "Quantity": 2,
                "Point": 0,
                "Unit": "包",
                "Origin": null,
                "Goods_Weight": null,
                "Id": 0
            }
        ]
    }
}';
    $success = makeRequestApiJsonceshi("http://txy.com/Api/ApiOrderCallback/", $json, "POST");
    print_r($success);exit;
      
    }

    private function getRawData() {
        $put = array();
        parse_str(file_get_contents('php://input'), $put);
        return $put;
    }
    
    
    /**
     * 修改已发货订单物流信息
     * @author Donkey
     * @date 2016年6月17日
     */
    
    private function logistic_corp($o_id,$express_no,$express){
        
            $ary_orders_data = M("orders", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->find();
            if(empty($ary_orders_data))
            {
                  output_msg("无此订单", array('flag' => FALSE));
            }
            $ary_logi = M("logistic_corp", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('lc_name'=>array("LIKE", '%' . $express . '%')))->find();
            $orders_delivery = M("orders_delivery", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->find();  
            if(!empty($orders_delivery) && !empty($ary_logi))
            {
                 M('orders_delivery', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('od_logi_id' => $orders_delivery['od_logi_id'],'od_logi_name' => $express, 'od_logi_no' => $express_no, 'od_created' => date('Y-m-d H:i:s')))->save();
            }
           
    }


    /**
     * 更改订单状态(发货状态)
     * @author Donkey
     * @date 2016年5月4日
     */
    private function UpdateOrderStatus($o_id,$express_no,$express) {

        $ary_orders_data = M("orders", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->find();
        $ary_order_data['o_id'] = $o_id;
        $ary_order_data['od_created'] = date("Y-m-d H:i:s");
        $ary_order_data['m_id'] = $ary_orders_data['m_id'];
        $ary_order_data['od_money'] = $ary_orders_data['o_cost_freight'];
        
        $ary_logi = M("logistic_corp", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('lc_name'=>$express))->find();
        if (empty($ary_logi)) {
             output_msg("物流公司不匹配", array('flag' => FALSE));
        }
        $ary_orders_log = array(
            'o_id' => $o_id,
            'ol_behavior' => '发货日志',
            'ol_uname' => "管理员：Admin" ,
            'ol_text'=>  M("logistic_corp", C('DB_PREFIX'), 'DB_CUSTOM')->getLastSql(),
            'ol_create' => date('Y-m-d H:i:s')
        );
        D('OrdersLog')->add($ary_orders_log);
        $expres  = explode(",", $express_no);
        $ary_orders_item_data = M("orders_items", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->select();
                foreach($expres as $v)
                {
                    $ary_order_data['od_logi_no'] = $v;
                    $ary_order_data['od_logi_name'] = $ary_logi['lc_name'];
                    $ary_order_data['od_logi_id'] = $ary_logi['lc_id'];
                    $ary_order_data['u_name'] = "admin";
                    $ary_order_data['u_id'] = 1;
                    $ary_order_data['od_memo'] = "发货" ;
                    $ary_order_data['od_receiver_name'] = $ary_orders_data['o_receiver_name'];
                    $ary_order_data['od_receiver_mobile'] = $ary_orders_data['o_receiver_mobile'];
                    $ary_order_data['od_receiver_telphone'] = $ary_orders_data['o_receiver_telphone'];
                    $ary_order_data['od_receiver_address'] = $ary_orders_data['o_receiver_address'];
                    $ary_order_data['od_receiver_zipcode'] = $ary_orders_data['o_receiver_zipcode'];
                    $ary_order_data['od_receiver_email'] = $ary_orders_data['o_receiver_email'];
                    $ary_order_data['od_receiver_city'] = $ary_orders_data['o_receiver_city'];
                    $ary_order_data['od_receiver_province'] = $ary_orders_data['o_receiver_state'];

                    M('', '', 'DB_CUSTOM')->startTrans();
                    $result_id = M("orders_delivery", C('DB_PREFIX'), 'DB_CUSTOM')->data($ary_order_data)->add();
                    foreach ($ary_orders_item_data as $value) {
                            $item_data['od_id'] = $result_id;
                            $item_data['o_id'] = $o_id;
                            $item_data['oi_id'] = $value['oi_id'];
                            $item_data['odi_num'] = $value['oi_nums'];
                            $item_result_id = M("orders_delivery_items", C('DB_PREFIX'), 'DB_CUSTOM')->data($item_data)->add();
                            if (!$item_result_id) {
                                M('', '', 'DB_CUSTOM')->rollback();
                                $this->orderLog($o_id, "发货失败");
                                 output_msg("订单发货明细失败，请重试...", array('flag' => FALSE));
                                exit;
                            }
                            //把订单明细标记为已发货
                            if (false === D("OrdersItems")->where(array('oi_id' => $value['oi_id']))->save(array('oi_sendnum' => $value['oi_nums'], 'oi_ship_status' => 2))) {
                                D("OrdersItems")->rollBack();
                                $this->orderLog($o_id, "发货失败");
                                output_msg("订单发货明细失败，请重试...", array('flag' => FALSE));
                                exit;
                            }
                        }
                }
        /*** 处理订单积分****start****By Joe******/
        $array_point_config = D('PointConfig')->getConfigs();
        if($array_point_config['is_consumed'] == '1' && $array_point_config['cinsumed_channel'] == '0'){
            //发货后处理赠送积分
            if($ary_orders_data['o_reward_point']>0){
                $ary_reward_result = D('PointConfig')->setMemberRewardPoint($ary_orders_data['o_reward_point'],$ary_orders_data['m_id'],$ary_orders_data['o_id']);
                if(!$ary_reward_result['result']){
                    M('', '', 'DB_CUSTOM')->rollback();
                    $this->error($ary_reward_result['message']);
                    exit;
                }
            }
            
            //发货后处理消费积分
            if($ary_orders_data['o_freeze_point'] > 0){
                $ary_freeze_result = D('PointConfig')->setMemberFreezePoint($ary_orders_data['o_freeze_point'],$ary_orders_data['m_id']);
                if(!$ary_freeze_result['result']){
                    M('', '', 'DB_CUSTOM')->rollback();
                    $this->error($ary_freeze_result['message']);
                    exit;
                }
            }
        }
        /*** 处理订单积分****end**********/
        
        /*** 处理赠送金币****start**********/
		/**
        $ary_jlb_data = D('SysConfig')->getCfgByModule('JIULONGBI_MONEY_SET');
        if($ary_jlb_data['JIULONGBI_AUTO_OPEN'] == '1' && $ary_jlb_data['cinsumed_channel'] == '0'){
            //发货后处理赠送金币
            if($ary_orders_data['o_reward_jlb']>0){
                $arr_jlb = array(
                    'jt_id' => '2',
                    'm_id'  => $ary_orders_data['m_id'],
                    'ji_create_time'  => date("Y-m-d H:i:s"),
                    'ji_type' => '0',
                    'ji_money' => $ary_orders_data['o_reward_jlb'],
                    'ji_desc' => '订单发货赠送金币：'.$ary_orders_data['o_reward_jlb'],
                    'o_id' => $ary_orders_data['o_id'],
                    'ji_finance_verify' => '1',
                    'ji_service_verify' => '1',
                    'ji_verify_status' => '1',
                    'single_type' => '2'
                    );
                $res_jlb = D('JlbInfo')->addJlb($arr_jlb);
                if(!$res_jlb){
                    M('', '', 'DB_CUSTOM')->rollback();
                    $this->error("生成发货赠送金币调整单错误！");
                    exit;
                }
            }
        }
		**/
        /*** 处理赠送金币****end**********/
        
        /*** 订单发货后获取订单优惠券**star by Joe**/
        //获取优惠券节点
        $coupon_config = D('SysConfig')->getCfgByModule('GET_COUPON');
        $where = array ('fx_orders.o_id' => $o_id);
        $ary_field = array('fx_orders.o_pay','fx_orders.o_id','fx_orders.o_all_price','fx_orders.coupon_sn','fx_orders_items.pdt_id','fx_orders_items.oi_nums','fx_orders_items.oi_type');
        $ary_orders = D('Orders')->getOrdersData($where,$ary_field);
        // 本次消费金额=支付单最后一次消费记录
        $payment_serial = M('payment_serial')->where(array('o_id'=>$o_id))->order('ps_create_time desc')->select();
        $payment_price = $payment_serial[0]['ps_money'];
        $all_price = $ary_orders[0]['o_all_price'];
        $coupon_sn = $ary_orders[0]['coupon_sn'];
        //print_r($ary_orders);exit;
        if ($coupon_sn == "" && $coupon_config['GET_COUPON_SET'] == '1') {
            D('Coupon')->setPoinGetCoupon($ary_orders,$ary_orders_data['m_id']);
        }
        /*** 订单发货后获取订单优惠券****end**********/
        
        
        $resdata = D('SysConfig')->getCfg('ORDERS_OPERATOR','ORDERS_OPERATOR','1','只记录第一次操作人');
        //查询订单是否存在操作者ID
        $admin_id = $_SESSION['Admin'];
        if($resdata['ORDERS_OPERATOR']['sc_value'] == '1'){
        	$order_admin_id =  M("orders", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id'=>$o_id))->getField('admin_id');
        	if(empty($order_admin_id)){
        		$ary_order_up['admin_id'] = $admin_id;
        	}
        }else{
        	$ary_order_up['admin_id'] = $admin_id;
        }
        $bl_o_res = D('Orders')->updateOrderInfo($o_id, $ary_order_up);
        $this->orderLog($o_id,"发货成功");
		//发货成功是否发站内性
		$is_ship = D('SysConfig')->getCfg('SHIP_SEND_MESSAGE','SHIP_SEND_MESSAGE','0','发货之后发送站内信');
		if($is_ship['SHIP_SEND_MESSAGE']['sc_value'] == '1'){
			$sl_title = '订单'.$o_id.'发货成功';
			$sl_content = '订单'.$o_id.'已发货,请及时收货，<a href="/Ucenter/Orders/pageShow/oid/'.$o_id.'">查看订单</a>';
			$m_id = $ary_order_data['m_id'];
			$sl_res = D('StationLetters')->addStationLotters($sl_title,$sl_content,$m_id,$o_id);
			if(!$sl_res){
				M('', '', 'DB_CUSTOM')->rollback();
                                 output_msg("站内信发送失败，请重试...", array('flag' => FALSE));
				exit;
			}
		}
		//更新会员等级
        //D('MembersLevel')->autoUpgrade($ary_order_data['m_id']);
        M('', '', 'DB_CUSTOM')->commit();
    
    }
    
    private function ChangeOrder($ary_post){
        
        if (empty($ary_post)) {
            output_msg(null, array('result' => "1", 'error' => '数据有误'));
        }
        
        $orders_info = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
        $o_id = $ary_post['orderno'];
        $error = $ary_post['error'];
        if(empty($error))
        {
            $error = '您的订单为异常订单，请联系客服了解详情';
        }
        switch ($ary_post['operation']) {
            
            case "order_payment":
                        $ary_orders = $orders_info->where(array("AuditOrdersPay" =>1, 'o_id' => $o_id))->find();
                        if ($ary_orders) {
                             output_msg("已确认付款，无需再次确认", array('flag' => TRUE));
                        }                                                                                           
                        $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('AuditOrdersPay' => 1, 'erp_status' => $ary_post['status'], 'AuditOrdersPayTime' => date('Y-m-d H:i:s')))->save();
                        if ($res) {
                            output_msg("同步成功", array('orderno'=>$o_id,'flag' => TRUE));
                        }else{
                            output_msg("同步失败", array('orderno'=>$o_id,'flag' => FALSE));
                        }
            break;
        
            case "order_cancel":
                $request = $this->ApiOrdersRefunds($o_id,"取消订单",$error);
                if($request == true)
                {
                     output_msg("订单取消成功", array('orderno'=>$o_id,'flag' => TRUE));
                }else{
                     output_msg("订单取消失败", array('orderno'=>$o_id,'flag' => FALSE));
                }
                
                
            break;
        
            case "order_confirm":
                $ary_orders = $orders_info->where(array("erp_status" => 2, 'AuditStatus' => 1, 'o_id' => $o_id))->find();
                if ($ary_orders) {
                    output_msg("已审核，无需再次审核", array('flag' => TRUE));
                }
                $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('AuditStatus' => 1, 'erp_status' => 2, 'IdentificationStatusTime' => date('Y-m-d H:i:s')))->save();
                if ($res) {
                    output_msg("同步成功", array('flag' => TRUE));
                } else {
                    output_msg("同步失败", array('flag' => FALSE));
                }
                break;
        
            case "order_express":
                        $ary_orders = $orders_info->where(array( 'express_status' =>1, 'o_id' => $o_id))->find();
                        if ($ary_orders) {
                             output_msg("确认发货，无需再次确认", array('orderno'=>$o_id,'flag' => TRUE));
                        }   
                       if(empty($ary_post['express_no']))
                        {
                               output_msg("运单号不能为空", array('orderno'=>$o_id,'flag' => FALSE));
                        }
                       
                        $this->UpdateOrderStatus($o_id,$ary_post['express_no'],strtolower($ary_post['express']));
                       $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('express_status' => $ary_post['express_status'], 'DeliveredTime' => $ary_post['express_time']))->save();
                     //   $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $o_id))->data(array('erp_status' => $ary_post['status'],'express_status' => $ary_post['express_status'],  'DeliveredTime' => $ary_post['express_time']))->save();
                        if ($res) {
                            output_msg("同步发货成功", array('orderno'=>$o_id,'flag' => TRUE));
                        }else{
                             output_msg("同步发货失败", array('orderno'=>$o_id,'flag' => FALSE));
                        }
                 
                
            break;
        
            case "order_complete":
                
                if(empty($o_id)){
                   output_msg("参数有误，请重试", array('orderno'=>$o_id,'flag' => FALSE));
                }
                $ary_order = D('Orders')->where(array('o_id'=>$o_id))->find();
                if($ary_order['o_pay_status'] != '1'){
                     output_msg('订单'.$o_id.'还有未支付或部分未支付金额', array('orderno'=>$o_id,'flag' => FALSE));
                }
//                        if($ary_order['o_status'] != '5'){
//                                $this->ajaxReturn(array('status'=>false,'msg'=>'订单'.$o_id.'请先确认收货'));
//                        }
                $ary_refund_type = D('Orders')->getOrdersStatus($o_id);
                if($ary_refund_type['deliver_status'] == '未发货'){
                    output_msg('订单'.$o_id.$ary_refund_type['deliver_status'], array('orderno'=>$o_id,'flag' => FALSE));
                }
                $ary_afersale = M('orders_refunds',C('DB_PREFIX'),'DB_CUSTOM')->where(array('o_id'=>$o_id))->order('or_create_time desc')->select();
                if(!empty($ary_afersale) && is_array($ary_afersale)){
                    foreach($ary_afersale as $keyaf=>$valaf){
                        //退款
                        if($valaf['or_refund_type'] == 1){
                            switch($valaf['or_processing_status']){
                                case 0:
                                    output_msg('订单'.$o_id.'退款中', array('orderno'=>$o_id,'flag' => FALSE));
                                    break;
                                default:
                                    break;
                            }
                        }elseif($valaf['or_refund_type'] == 2){         //退货
                            switch($valaf['or_processing_status']){
                                case 0:
                                    output_msg('订单'.$o_id.'退货中', array('orderno'=>$o_id,'flag' => FALSE));
                                    break;
                                default:
                                    break;
                            }
                        }
                                        elseif($valaf['or_refund_type'] == 3){         //退运费
                            switch($valaf['or_processing_status']){
                                case 0:
                                    output_msg('订单'.$o_id.'退运费中', array('orderno'=>$o_id,'flag' => FALSE));
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                }
                M('', '', 'DB_CUSTOM')->startTrans();
                //更改订单状态$ary_post['complete_time']
                if(false === D('Orders')->where(array('o_id'=>$o_id))->save(array('o_status'=>4,'completeStatusTime'=>date("Y-m-d H:i:s")))){
                    output_msg('更新订单状态失败，请重试', array('orderno'=>$o_id,'flag' => FALSE));
                    M('', '', 'DB_CUSTOM')->rollback();
                }
                $array_point_config = D('PointConfig')->getConfigs();
                if($array_point_config['is_consumed'] == '1' && $array_point_config['cinsumed_channel'] == '2'){
                    //订单完结后处理赠送积分
                    if($ary_order['o_reward_point']>0){
                        $ary_reward_result = D('PointConfig')->setMemberRewardPoint($ary_order['o_reward_point'],$ary_order['m_id'],$ary_order['o_id']);
                        if(!$ary_reward_result['result']){
                            M('', '', 'DB_CUSTOM')->rollback();
                            $this->ajaxReturn(array('status'=>false,'msg'=>$ary_reward_result['message']));
                            exit;
                        }
                    }
                    //订单完结后处理消费积分
                    if($ary_order['o_freeze_point'] > 0){
                        $ary_freeze_result = D('PointConfig')->setMemberFreezePoint($ary_order['o_freeze_point'],$ary_order['m_id']);
                        if(!$ary_freeze_result['result']){
                            M('', '', 'DB_CUSTOM')->rollback();
                            $this->ajaxReturn(array('status'=>false,'msg'=>$ary_freeze_result['message']));
                            exit;
                        }
                    }
                }
                /*** 处理赠送金币****start**********/
                        /**
                $ary_jlb_data = D('SysConfig')->getCfgByModule('JIULONGBI_MONEY_SET');
                if($ary_jlb_data['JIULONGBI_AUTO_OPEN'] == '1' && $ary_jlb_data['cinsumed_channel'] == '0'){
                    //发货后处理赠送金币
                    if($ary_order['o_reward_jlb']>0){
                        $arr_jlb = array(
                            'jt_id' => '2',
                            'm_id'  => $ary_order['m_id'],
                            'ji_create_time'  => date("Y-m-d H:i:s"),
                            'ji_type' => '0',
                            'ji_money' => $ary_order['o_reward_jlb'],
                            'ji_desc' => '订单完结赠送金币：'.$ary_order['o_reward_jlb'],
                            'o_id' => $ary_order['o_id'],
                            'ji_finance_verify' => '1',
                            'ji_service_verify' => '1',
                            'ji_verify_status' => '1',
                            'single_type' => '2'
                            );
                        $res_jlb = D('JlbInfo')->addJlb($arr_jlb);
                        if(!$res_jlb){
                            M('', '', 'DB_CUSTOM')->rollback();
                            $this->error("生成订单完结赠送金币调整单错误！");
                            exit;
                        }
                    }
                }
                        **/
                /*** 处理赠送金币****end**********/

                /*** 订单发货后获取订单优惠券**star by Joe**/
                //获取优惠券节点
               // $coupon_config = D('SysConfig')->getCfgByModule('GET_COUPON');
                $where = array('fx_orders.o_id' => $o_id);
                $ary_field = array('fx_orders.o_pay','fx_orders.m_id','fx_orders.o_all_price','fx_orders.coupon_sn','fx_orders_items.pdt_id','fx_orders_items.oi_nums','fx_orders_items.oi_type');
                $ary_orders = D('Orders')->getOrdersData($where,$ary_field);
                // 本次消费金额=支付单最后一次消费记录
                $payment_serial = M('payment_serial')->where(array('o_id'=>$o_id))->order('ps_create_time desc')->select();
                $payment_price = $payment_serial[0]['ps_money'];
                $all_price = $ary_orders[0]['o_all_price'];
                $coupon_sn = $ary_orders[0]['coupon_sn'];
//                if ($coupon_sn == "" && $coupon_config['GET_COUPON_SET'] == '3') {
//                    D('Coupon')->setPoinGetCoupon($ary_orders,$ary_order['m_id']);
//                }
                /*** 订单发货后获取订单优惠券****end**********/
                        //订单完成订单完成触发返利
                        $res_payback_res = D('Promotings')->ajaxOrderPakback($ary_order);
                        if(!$res_payback_res){
                                M('', '', 'DB_CUSTOM')->rollback();
                                output_msg('订单完成订单完成触发返利错误', array('orderno'=>$o_id,'flag' => FALSE));
                                exit;
                        }		
                        $this->orderLog($o_id, "订单完结");
                M('', '', 'DB_CUSTOM')->commit();
                output_msg("同步成功", array('orderno'=>$o_id,'flag' => TRUE));
            break;
            case "order_invalid":
                $request = $this->ApiOrdersRefunds($o_id,"作废订单",$error);
                if($request == true)
                {
                     output_msg("订单作废成功", array('orderno'=>$o_id,'flag' => TRUE));
                }else{
                     output_msg("订单作废失败", array('orderno'=>$o_id,'flag' => FALSE));
                }
                
            break;
        }
    }


    private function matchLogisticsCompanieCode($str_name) {
        if (false !== stripos($str_name, '平邮')) {
            $str_code = 'POST';
            $str_name = '平邮';
        } elseif (false !== stripos($str_name, 'EMS')) {
            $str_code = 'EMS';
            $str_name = '邮政EMS';
        } elseif (false !== stripos($str_name, '邮宝') || false !== stripos($str_name, 'e邮宝') || false !== stripos($str_name, 'E邮宝')) {
            $str_code = 'EMS';
            $str_name = 'E邮宝';
        } elseif (false !== stripos($str_name, '申通')) {
            $str_code = 'STO';
            $str_name = '申通快递';
        } elseif (false !== stripos($str_name, '圆通')) {
            $str_code = 'YTO';
            $str_name = '圆通速递';
        } elseif (false !== stripos($str_name, '中通')) {
            $str_code = 'ZTO';
            $str_name = '中通速递';
        } elseif (false !== stripos($str_name, '宅急送')) {
            $str_code = 'ZJS';
            $str_name = '宅急送';
        } elseif (false !== stripos($str_name, '顺丰')) {
            $str_code = 'SF';
            $str_name = '顺丰速运';
        } elseif (false !== stripos($str_name, '汇通')) {
            $str_code = 'HTKY';
        } elseif (false !== stripos($str_name, '韵达')) {
            $str_code = 'YUNDA';
            $str_name = '韵达快运';
        } elseif (false !== stripos($str_name, '天天')) {
            $str_code = 'TTKDEX';
            $str_name = '天天快递';
        } elseif (false !== stripos($str_name, '联邦')) {
            $str_code = 'FEDEX';
        } elseif (false !== stripos($str_name, '淘物流')) {
            $str_code = 'TWL';
        } elseif (false !== stripos($str_name, '风火天地')) {
            $str_code = 'FIREWIND';
        } elseif (false !== stripos($str_name, '华强')) {
            $str_code = 'YUD';
        } elseif (false !== stripos($str_name, '烽火')) {
            $str_code = 'DDS';
        } elseif (false !== stripos($str_name, '希伊艾斯')) {
            $str_code = 'ZOC';
        } elseif (false !== stripos($str_name, '亚风')) {
            $str_code = 'AIRFEX';
        } elseif (false !== stripos($str_name, '全一')) {
            $str_code = 'APEX';
        } elseif (false !== stripos($str_name, '小红马')) {
            $str_code = 'PONYEX';
        } elseif (false !== stripos($str_name, '龙邦')) {
            $str_code = 'LBEX';
        } elseif (false !== stripos($str_name, '长宇')) {
            $str_code = 'CYEXP';
        } elseif (false !== stripos($str_name, '大田')) {
            $str_code = 'DTW';
        } elseif (false !== stripos($str_name, '长发')) {
            $str_code = 'YUD';
        } elseif (false !== stripos($str_name, '特能')) {
            $str_code = 'SHQ';
        } else {
            $str_code = 'OTHER';
        }
        return array('name' => $str_name, 'code' => $str_code);
    }

        function orderLog($oid, $msg) {
        //订单日志记录
        $ary_orders_log = array(
            'o_id' => $oid,
            'ol_behavior' => $msg,
            'ol_uname' => "管理员：Admin" ,
            'ol_create' => date('Y-m-d H:i:s')
        );
        $obj_res_orders_log = D('OrdersLog')->add($ary_orders_log);
        if (!$obj_res_orders_log) {
            return false;
        } else {
            return true;
        }
    }
     /*
      * 退款退货退库存退销量退所有商品
      * Donkey
      * 2016年5月11日
      */
    private function ApiOrdersRefunds($oid,$msg,$error){
                
                $obj_refunds = D('OrdersRefunds');
                $ary_refunds = $obj_refunds->where(array('o_id'=>$oid))->select();
                $pay_orderObjectInfo = 0;
                foreach ($ary_refunds as $value)
                {
                        if($value['or_processing_status'] !=2 && $value['or_service_verify'] == 1 && $value['or_finance_verify'] == 1)
                        {
                           $pay_orderObjectInfo += $value['or_money'];
                        }

                }
                //echo $pay_orderObjectInfo;exit;
//                 if(!empty($ary_refunds)){
//                       output_msg("已申请退款！", array('orderno'=>$oid,'flag' => FALSE));
//                 }
		$ary_data = array();
                $orderObjectInfo = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array("o_id"=>$oid))->find();
                 if(empty($orderObjectInfo)){
                       output_msg("无此订单", array('orderno'=>$oid,'flag' => FALSE));
                 }
                $Menbers = D('members')->where(array("m_id"=>$orderObjectInfo['m_id']))->find();
                $orders_items_info = M('orders_items', C('DB_PREFIX'), 'DB_CUSTOM')->where(array("o_id"=>$oid))->select();
                $total_price = 0;
                $ary_temp_items = array();
                foreach($orders_items_info as $value)
                {
                     $ary_data['checkSon'][] = $value['oi_id'];
                     $ary_data['inputNum'][$value['oi_id']] = $value['oi_nums'] - $value['oi_frozen_number'];
                     $item_promotion['promotion_price'] = $value['oi_coupon_menoy']+$value['oi_bonus_money']+$value['oi_cards_money']+$value['oi_jlb_money']+$value['oi_point_money']+$value['promotion_price'];
                     $total_price += $value['oi_price']*$value['oi_nums'] - $item_promotion['promotion_price'];
                     $ary_temp_items[$value['oi_id']] = $value;
                }
            
                $ary_data['sh_radio'] = 1;
                $ary_data['th_radio'] = 1;
                $ary_data['ary_reason'] = $msg;
                $ary_data['application_money'] = $orderObjectInfo['o_pay'] - $pay_orderObjectInfo;
                $ary_data['or_refund_type'] = 2;
                $ary_data['o_id'] = $oid;
             //   print_r($ary_data);exit;
                $result_price = $total_price;
                	//erp退款退货标志  2退款:3  退货:
                $refund_type = 0;
		//售后单据基本信息
		$ary_refunds = array(
			'o_id' => $ary_data['o_id'],
			'm_id' => $orderObjectInfo['m_id'],
			'or_money' => sprintf('%.2f',$ary_data['application_money']),
			'or_refund_type' => $ary_data['or_refund_type'],
			'or_create_time' => date("Y-m-d"),
			'm_name' => $Menbers['m_name'],
			'or_buyer_memo'=>$this->_post('or_buyer_memo','htmlspecialchars','')
		);
                
                if (!is_numeric($ary_data['application_money']) || $ary_data['application_money'] < 0) {
                    
                      output_msg("已收到货且需退货，产生退货单,请正确填写退货金额", array('orderno'=>$oid,'flag' => FALSE));
                  }
                  $ary_refunds['or_money'] = sprintf('%.2f', $ary_data['application_money']);
                  //已收到货，需退货，退款金额由选择商品确定，生成的单据为退货单
                  if (!isset($ary_data['checkSon']) || empty($ary_data['checkSon'])) {
                      output_msg("请选择您要退货的商品", array('orderno'=>$oid,'flag' => FALSE));
                  }
                  //买家将商品寄回时的物流单号，可不填（不填是由于买家自提或者上门送回的情况）
                  $ary_refunds["or_return_logic_sn"] = (isset($ary_data['od_logi_no']) && "" != trim($ary_data['od_logi_no'])) ? trim($ary_data['od_logi_no']) : "";
                  //售后申请操作类型为退货
                  $ary_refunds['or_refund_type'] = 2;
                  $refund_type = 3;
                  
			//商品可能部分退掉进行商品数量判断
			foreach ($ary_data['checkSon'] as $v) {
				if(!empty($ary_data['inputNum'][$v]) && isset($ary_returns_temp[$v])) {
					if(!ctype_digit($ary_data['inputNum'][$v])) $this->error("退货数量填写需正整数");
					if($ary_data['inputNum'][$v]>$ary_returns_temp[$v]['nums']) $this->error("商品编号是{$ary_returns_temp[$v]['g_sn']}退货数量不能大于购买商量");
					if(($ary_data['inputNum'][$v] + $ary_returns_temp[$v]['num'] )> $ary_returns_temp[$v]['nums']){
						$str_th_sum = intval($ary_returns_temp[$v]['nums'] - $ary_returns_temp[$v]['num']);
						if($str_th_sum>0){
                                                      output_msg("{$ary_returns_temp[$v]['g_sn']}的退货数量只能退{$str_th_sum}件", array('orderno'=>$oid,'flag' => FALSE));
						}
						else{
                                                     output_msg("商品编号是{$ary_returns_temp[$v]['g_sn']}的已经退过货，不能重复退货", array('orderno'=>$oid,'flag' => FALSE));
						}
					}
				}
			}
			$ary_where = array(
				'fx_orders_refunds.o_id'=>$ary_data['o_id'],
				'fx_orders_refunds.m_id' => $members['m_id'],
				'fx_orders_refunds.or_processing_status'=>array('neq',2),
				'fx_orders_refunds.or_refund_type'=>2
			);
			$ary_returns_orders = D('OrdersRefunds')
			->field('fx_orders_items.pdt_id,fx_orders_items.oi_nums,fx_orders_refunds_items.ori_num,fx_orders_items.g_sn')
			->join('left join fx_orders_refunds_items on fx_orders_refunds.or_id = fx_orders_refunds_items.or_id')
			->join(" fx_orders_items ON fx_orders_refunds_items.oi_id=fx_orders_items.oi_id")
			->where($ary_where)
			->select();
                        
			if($ary_returns_orders){
				//已经加入的退货单商品详情
				$ary_returns_temp = array();
				foreach($ary_returns_orders as $val) {
                                
					if(!isset($ary_returns_temp[$val['pdt_id']])){
						$ary_returns_temp[$val['pdt_id']]['num'] = $val['ori_num'];//已退货的货号商品总数
						$ary_returns_temp[$val['pdt_id']]['nums'] = $val['oi_nums'];//此订单货号总数
						$ary_returns_temp[$val['pdt_id']]['g_sn'] = $val['g_sn'];
					}
					else{
						$ary_returns_temp[$val['pdt_id']]['num'] += $val['ori_num'];
					}
				}
			}
			else{
				foreach ($ary_data['checkSon'] as $v) {
					if(!empty($ary_data['inputNum'][$v]) && isset($ary_temp_items[$v])) {
						if(!is_numeric($ary_data['inputNum'][$v])){
                                                           output_msg("退货数量填写需正整数", array('orderno'=>$oid,'flag' => FALSE));
                        }
						if($ary_data['inputNum'][$v]>$ary_temp_items[$v]['oi_nums']){
                                                     output_msg("商品编号是{$ary_temp_items[$v]['g_sn']}退货数量不能大于购买商量", array('orderno'=>$oid,'flag' => FALSE));
                        }
					}
				}
			}
                        
                        $ary_refunds['or_reason'] = $ary_data['ary_reason'];
                        $ary_refunds['or_return_sn'] = strtotime("now");

                        if($orderObjectInfo['o_payment'] == 16)
                        {
                            $ary_refunds['or_refunds_type'] = 4;
                        }else{
                        $ary_refunds['or_refunds_type'] = 1;
                        }
                   
                        $ary_refunds['or_service_verify'] = 1;
                        $ary_refunds['or_finance_verify'] = 1;
                        $ary_refunds['or_processing_status'] = 1;
                        $ary_order_data['or_service_u_id'] = 1;
                        $ary_order_data['or_service_u_name'] = "admin";
                // $ary_order_data['service_time'] = date('Y-m-d H:i:s');
                        $ary_order_data['or_service_time'] = date('Y-m-d H:i:s');
		M('', '', 'DB_CUSTOM')->startTrans();
		$ary_refunds['or_update_time'] = date('Y-m-d H:i:s');
		//插入退款主表
		$int_or_id = D('OrdersRefunds')->add($ary_refunds);
		if (false === $int_or_id) {
		   // var_dump($int_or_id);exit;
			M('', '', 'DB_CUSTOM')->rollback();
                           output_msg("售后申请提交失败", array('orderno'=>$oid,'flag' => FALSE));
		}
		$int_tmp_or_id = $int_or_id;
		$or_return_sn = date("Ymd") . sprintf('%07s',$int_tmp_or_id);
		$array_modify_data = array("or_return_sn"=>$or_return_sn);
		$mixed_result = D('OrdersRefunds')->where(array("or_id"=>$int_or_id,'or_update_time'=>date('Y-m-d H:i:s')))->save($array_modify_data);
		if(false === $mixed_result){
			M('', '', 'DB_CUSTOM')->rollback();
                          output_msg("售后申请提交失败。CODE:CREATE-REFUND-SN-ERROR.", array('orderno'=>$oid,'flag' => FALSE));
		}
                $or_money = 0;
			//商品可能部分退掉
                $ary_refunds_items = array();
			foreach ($ary_data['checkSon'] as $v) {
				if(!empty($ary_data['inputNum'][$v]) && isset($ary_temp_items[$v])) {
					$ary_refunds_items[] = array(
							'o_id' => $ary_temp_items[$v]['o_id'],
							'or_id' => $int_or_id,
							'oi_id' => $ary_temp_items[$v]['oi_id'],
							'ori_num' => $ary_data['inputNum'][$v],
							'erp_id' =>$ary_temp_items[$v]['erp_id']
					);
					$or_money +=  $ary_data['inputNum'][$v]*$ary_temp_items[$v]['oi_price']/$ary_temp_items[$v]['oi_nums'];

				}
			}
			$int_return_refunds_itmes = D('OrdersRefundsItems')->addAll($ary_refunds_items);

			if (false === $int_return_refunds_itmes) {
				M('', '', 'DB_CUSTOM')->rollback();
                                 output_msg("批量插入明细失败", array('orderno'=>$oid,'flag' => FALSE));
			}
           foreach ($ary_data['checkSon'] as $oi_id){
                if(false === M('orders_items',C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id'=>$ary_data['o_id'],'oi_id'=>$oi_id))->data(array('oi_refund_status'=>3))->save()){
                    M('', '', 'DB_CUSTOM')->rollback();
                       output_msg("更新退货状态失败", array('orderno'=>$oid,'flag' => FALSE));
                }
            }
		//单据id:$int_or_id;订单号：$ary_data['o_id'] 
		//更新日志表
		$ary_orders_log = array(
				'o_id'=>$ary_data['o_id'],
				'ol_behavior' => '会员新增售后申请',
				'ol_uname'=>$Menbers['m_name']
		);
               
		$res_orders_log = D('OrdersLog')->addOrderLog($ary_orders_log);
		if(!$res_orders_log){
                
			M('', '', 'DB_CUSTOM')->rollback();
                        output_msg("会员新增售后申请日志失败", array('orderno'=>$oid,'flag' => FALSE));
		}
		$res_orders = D('Orders')
		->data(array('o_update_time'=>date('Y-m-d H:i:s')))
		->where(array('o_id'=>$ary_data['o_id']))->save();
                
		$orders = M('orders_refunds', C('DB_PREFIX'), 'DB_CUSTOM');
                $balance = new Balance();
		if(!$res_orders){
                    
			M('', '', 'DB_CUSTOM')->rollback();
                        output_msg("会员新增售后申请失败", array('orderno'=>$oid,'flag' => FALSE));
		}
           
                        $ary_order_refund_info = $orders->where(array('or_id' =>$int_or_id))->find();
                        $arr_data = array();

                        $arr_data['o_id'] = $ary_order_refund_info['o_id'];
                        $arr_data['m_id'] = $ary_order_refund_info['m_id'];
                        $arr_data['o_payment'] = $orderObjectInfo['o_payment'];
                        $arr_data['bi_accounts_receivable'] = $ary_order_refund_info['or_account'];
                        $arr_data['bi_accounts_bank'] = $ary_order_refund_info['or_bank'];
                        $arr_data['bi_payeec'] = $ary_order_refund_info['or_payee'];
                        $arr_data['bi_type'] = '0';
                        $arr_data['or_id'] = $ary_order_refund_info['or_return_sn'];
                        $arr_data['bi_money'] = $ary_order_refund_info['or_money'];
                        $arr_data['u_id'] = $Menbers['m_id'];
                        $arr_data['bi_create_time'] = date("Y-m-d H:i:s");
                        $arr_data['bi_payment_time'] = date("Y-m-d H:i:s");
                        $arr_data['bt_id'] = '2';
                        $arr_data['bi_finance_verify'] = '0';
                        $arr_data['bi_service_verify'] = '1';
                        $arr_data['bi_verify_status'] = '1';
                        if($orderObjectInfo['o_payment'] == 16)
                        {
                            $arr_data['bi_desc'] = '信用账户退款';
                        } else {
                            $arr_data['bi_desc'] = '买家退款或退货';
                        }
                        $ary_rest = $balance->addBalanceInfo($arr_data);
//                        if($orderObjectInfo['o_payment'] == 16)
//                        {
//                            $msg = '财审成功，退信用余额成功';
//                            $ary_rest = $balance->addBalanceInfo($arr_data,1);
//                        }else{
//                            $ary_rest = $balance->addBalanceInfo($arr_data);
//                            $msg = '财审成功，退结余款成功';
//                        }
                         $ary_res = $orders->where(array('or_id' => $int_or_id))->find();
                        
                        $ary_balance = $balance->getBalanceInfo(array('or_id' => $ary_res['or_return_sn']));
                          if (!empty($ary_balance) && is_array($ary_balance)) {
                              
                                $ary_post['or_id'] = $ary_res['or_return_sn'];
                                $ary_post['m_id'] = $ary_res['m_id'];
                                $ary_post['or_money'] = $ary_res['or_money'];
                                $ary_post['or_refund_type'] = $ary_res['or_refund_type'];
                                $ary_post['field'] ='or_finance_verify' ;
                                $ary_post['id'] =$int_or_id;
                                $ary_post['val'] =1;
                                $ary_post['or_refunds_type'] =2;
                        if($orderObjectInfo['o_payment'] == 16)
                        {
                                
                            $msg = '财审成功，退信用余额成功';
                               $ary_rest = $balance->doBalanceInfoStatus($ary_post,1);
                        }else{
                                $ary_rest = $balance->doBalanceInfoStatus($ary_post);
                            $msg = '财审成功，退结余款成功';
                        }
                            
                            
                    if ($ary_rest['success']) {
                            
                            //更新日志表
                            $ary_orders_log = array(
                                'o_id' => $ary_res['o_id'],
                                'ol_behavior' => $msg,
                                'ol_uname'    =>$Menbers['m_name'],
                                'ol_text' => serialize($ary_post)
                            );
                          
                            $res_orders_log = D('OrdersLog')->addOrderLog($ary_orders_log);
                            if (!$res_orders_log) {
                               
                                $orders->rollback();
                                     output_msg("更新失败", array('orderno'=>$oid,'flag' => FALSE));
                                exit;
                            }
                        
                    //暂时这么处理$ary_rest['success']
                    if ($ary_rest['success']) {
                        if ($ary_res['or_refund_type'] == 2) {

                                      $order_item['oi_refund_status'] = 5; //退货成功
                                        $order_item['oi_update_time'] = date('Y-m-d H:i:s');
                                        //退货单
                                        $ary_oi_id = M('orders_refunds_items')->field(array('oi_id,ori_num'))->where(array('or_id' => $ary_res['or_id']))->select();
                                     //   print_r($ary_res);exit;
                                        $orderItems = M('orders_items')->field('oi_id,o_id,g_id,g_sn,pdt_sn,pdt_id,oi_bonus_money,oi_nums,oi_cards_money,oi_jlb_money,oi_point_money,oi_type,fc_id')->where(array('o_id' =>$ary_data['o_id']))->select();
                                        foreach ($ary_oi_id as $key) {
                                            if (false === M('orders_items')->where(array('oi_id' => $key['oi_id']))->save($order_item)) {
                                                $orders->rollback();
                                                 output_msg("更新订单状态失败", array('orderno'=>$oid,'flag' => FALSE));
                                            } else {
                                                //库存返回
                                                foreach ($orderItems as $item) {
                                                    if (empty($item['g_sn']) || empty($item['pdt_sn'])) {
                                                        $orders->rollback();
                                                        output_msg("销量返回失败", array('orderno'=>$oid,'flag' => FALSE));
                                                        exit;
                                                    }
                                                    if ($item['oi_id'] == $key['oi_id']) {
                                                        $int_pdt_id_suk = D("GoodsProductsTable")->field("pdt_id,g_id")->where(array("g_sn"=>$item['g_sn'],"pdt_is_combination_goods"=>'0'))->select();
                                                       if(count($int_pdt_id_suk) > 1)
                                                       {
                                                            $stock_res = M('goods_products')->where(array('g_sn' => $item['g_sn']))
                                                                ->data(array(
                                                                    'pdt_update_time' => date('Y-m-d H:i:s'),
                                                                    'pdt_freeze_stock' => array('exp', "pdt_freeze_stock-" . $key['ori_num']),
                                                                    'pdt_stock' => array('exp', "pdt_stock+" . $key['ori_num'])))
                                                                ->save();
                                                       } else {
                                                         $stock_res = M('goods_products')->where(array('g_sn' => $item['g_sn'], 'pdt_sn' => $item['pdt_sn']))
                                                                ->data(array(
                                                                    'pdt_update_time' => date('Y-m-d H:i:s'),
                                                                    'pdt_freeze_stock' => array('exp', "pdt_freeze_stock-" . $key['ori_num']),
                                                                    'pdt_stock' => array('exp', "pdt_stock+" . $key['ori_num'])))
                                                                ->save();
                                                       }

                                                        if (!$stock_res) {
                                                            //$orders->rollback();
                                                            //$this->error("库存返回失败");exit;
                                                        }
                                                        $goods_num_res = M("goods_info")->where(array(
                                                                    'g_id' => $item['g_id']
                                                                ))->data(array(
                                                                    'g_salenum' => array(
                                                                        'exp',
                                                                        'g_salenum - ' . $key['ori_num']
                                                                    )
                                                                ))->save();
                                                        if (false === $goods_num_res) {
                                                            $orders->rollback();
                                                             output_msg("销量返回失败", array('orderno'=>$oid,'flag' => FALSE));
                                                 
                                                            exit;
                                                        }
                                                        //团购秒杀返回
                                                        if ($item['oi_type'] == 5 && !empty($item['fc_id'])) {
                                                            $return_groupbuy_nums = D("Groupbuy")->where(array('gp_id' => $item['fc_id']))->setDec("gp_now_number", $item['oi_nums']);
                                                            if (!$return_groupbuy_nums) {
                                                                $orders->rollback();
                                                                 output_msg("订单团购量更新失败", array('orderno'=>$oid,'flag' => FALSE));
                                                                exit;
                                                            }
                                                        } elseif ($item['oi_type'] == 7 && !empty($item['fc_id'])) {

                                                            $retun_spike_nums = D("Spike")->where(array('sp_id' => $item['fc_id']))->setDec("sp_now_number", $item['oi_nums']);
                                                            if (!$retun_spike_nums) {
                                                                $orders->rollback();
                                                                output_msg("订单秒杀量更新失败", array('orderno'=>$oid,'flag' => FALSE));
                                                                exit;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        if ($stock_res) {
                                            $stock_res = array(
                                                'o_id' => $ary_res['o_id'],
                                                'ol_behavior' => '订单退货库存返回成功',
                                                'ol_uname'    =>$Menbers['m_name'],
                                                'ol_text' => serialize($ary_oi_id)
                                            );
                                            $stock_res_log = D('OrdersLog')->addOrderLog($stock_res);
                                            if (!$stock_res_log) {
                                                $orders->rollback();
                                                output_msg("更新库存日志失败", array('orderno'=>$o_id,'flag' => FALSE));
                                                exit;
                                            }
                                        }
                                        
                                    }
                    }
                            $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('o_id' => $oid))->data(array( 'erp_status' => 5,'o_status'=>2,'o_error'=>$error))->save(); //,'o_error'=>$ary_post['error']
                            if (!$res) {
                                     $orders->rollback();
                                      output_msg("同步作废失败", array('orderno'=>$oid,'flag' => FALSE));
                                 
                            }
			$sl_title = $ary_res['o_id'].'';
			$sl_content = $ary_post['o_id'].$error;
			$m_id = $orderObjectInfo['m_id'];
                        $sl_res = D('StationLetters')->addStationLotters($sl_title,$sl_content,$m_id,$ary_res['o_id']);
			if(!$sl_res){
				M('', '', 'DB_CUSTOM')->rollback();
                                output_msg("站内信发送失败", array('orderno'=>$oid,'flag' => FALSE));
				exit;
			}
                            M('', '', 'DB_CUSTOM')->commit();
                     
                     $SmsApi_obj = new SmsApi();
                    //获取注册发送验证码模板
                     if($this->pregPN($Menbers['m_telphone']))
                     {
                         $auth_info_mobile = $Menbers['m_telphone'];
                     }else{
                         $auth_info_mobile = $Menbers['m_mobile'];
                     }
                    $template_info = D('SmsTemplates')->sendSmsTemplatesAdmin(array('code'=>'REGISTER_ADMIN'),$error,$ary_res['o_id']);
                    $send_content = '';
                    if($template_info['status'] == true){
                        $send_content = $template_info['content'];
                    }
                    $array_params=array('mobile'=>$auth_info_mobile,'','content'=>$send_content);
                    //print_r($array_params);exit;
                    $res=$SmsApi_obj->regSmsSend($array_params);    
                    if($res['code'] == '200'){
                        //日志记录下
                        $ary_data = array();
                        $ary_data['sms_type'] = 1;
                        $ary_data['mobile'] = $auth_info_mobile;
                        $ary_data['content'] = $send_content;
                        $ary_data['code'] = $template_info['code'];
                        $sms_res = D('SmsLog')->addSms($ary_data);
                        if(!$sms_res){
                            writeLog('短信发送失败', 'SMS/'.date('Y-m-d').txt);
                        }
                    }
                            
                           return true;
                        } else {
                            $orders->rollback();
                             output_msg("同步作废失败", array('orderno'=>$oid,'flag' => FALSE));
                        }
                                
            }
    }
    
    public function pregPN($test){  
        $rule  = "/^((13[0-9])|147|(15[0-35-9])|180|182|(18[5-9]))[0-9]{8}$/A";  
        preg_match($rule,$test,$result);  
        return $result;  
    }  
    
    private function callbackOrder(){
        
          $field = array(
            'fx_orders.o_id as OrderNo',                                        //订单id
            'fx_orders.o_status as Status',                                     //订单状态
     //       'fx_orders.o_audit as AuditStatus',                                 //审核
            'fx_orders.o_all_price as OrderTotalAmount',                        //订单总价
           // 'fx_orders.o_source_type as OrderSource',                           //订单来源
            'fx_orders.o_tax_rate as OrderTaxAmount',                           //订单税费
            'fx_orders.o_goods_all_price as OrderGoodsAmount',                  //订单货款
            'fx_orders.o_cost_freight as FeeAmount',                            //订单运费
           // 'fx_orders.order_type as OrderType',                                //订单运费
                       'fx_orders.initial_o_id',
          //     'fx_orders.o_coupon_menoy',
            'fx_orders.o_all_price as TotalAmount',                             //成交总价
            'fx_orders.o_goods_all_price as Real_amount',                       //付商品总金额
            'fx_orders.o_all_price as Payable_amount',                          //付商品总金额
            'fx_orders.o_pay as User_amount',                                   //已支付金额
            'fx_orders.o_buyer_comments as Note',                               //备注信息
            'fx_orders.o_cost_payment as Payment_fee',                          //支付手续费
            'fx_orders.o_receiver_email as ConsigneeEmail',                     // 收件人邮箱
            'fx_orders.o_receiver_mobile as ConsigneeTel',                    // 收件人电话
            'fx_orders.o_receiver_name as Consignee',                           // 收件人
            'fx_orders.o_receiver_state as ConsigneeProvince',                  // 收件人省份
            'fx_orders.o_receiver_city as ConsigneeCity',                       // 收件人城市
            'fx_orders.o_receiver_county as ConsigneeArea',                     // 收件人地区
            'fx_orders.o_receiver_address as ConsigneeAddress',                    // 收件人地址
            'fx_orders.o_receiver_zipcode as ZipCode',                          // 收件人邮编
            'fx_orders.o_reward_point as Point',                                // 积分
            'fx_orders.admin_id as LastUpdatorUserId',                          //修改人
            'fx_orders.o_update_time as LastUpdatedTime',                       //修改时间
            'fx_orders.o_create_time as CreatedTime',                           //修改时间
            'fx_orders.o_receiver_idcard as PurchaserIdno',                     //省份证
            'fx_orders.order_type',
            'fx_orders.CardFaceImg',
            'fx_orders.CardOppositeImg',
            'fx_members.m_id as PurchaserId',
            'fx_members.m_name as Purchaser',
            'fx_members.m_mobile as PurchaserTel',
            'fx_members.m_email as PurchaserEmail',
            'fx_members.m_address_detail as PurchaserAddress',
            'fx_orders.o_payment'
        );
        $field_info = array(
            'fx_orders_items.g_id as Good_id',                                        //订单id
            'fx_orders_items.g_sn as Goods_no',       
            'fx_orders_items.oi_g_name as Goods_title',      
            'fx_orders_items.pdt_sale_price as Goods_price',  
            'fx_orders_items.oi_price as Real_price',  
            'fx_orders_items.pdt_sale_price as PurchasePrice',     
            'fx_orders_items.oi_nums as Quantity',  
            'fx_orders_items.oi_point as Point',
            'fx_goods_info.g_unit as Unit',
            'fx_goods_info.g_picture as Img_url',
            'fx_nationality.n_name as Origin',
            'fx_goods_info.g_weight as Goods_Weight'
        );
        $where = array(
            'fx_orders.o_Synchronization' => '0',
            'fx_orders.o_pay_status'=> 1,
            'fx_orders.o_audit'=> 1,
            'fx_orders.o_Synchronization' => '0' 
        );
            $ary_orders = D('Orders')->getOrdersSelectMenber($where, $field);
            $count  = count($ary_orders);
            
            if($count == 0)
            {
                  output_msg("同步成功", array('flag' => TRUE,"count"=>0));exit;
            }
            foreach($ary_orders as $key=>$value)
            {
                            $order_id[] = $value['OrderNo'];
                            if(!empty($value['initial_o_id']))
                            {
                                $Account_info = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                                        "o_id" => $value['initial_o_id']
                                    ))->find();
                            }else{
                                $Account_info = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                                        "o_id" => $value['OrderNo']
                                    ))->find();
                            }
                          //  $Account_info = M('payment_serial',C('DB_PREFIX'),'DB_CUSTOM')->where(array("o_id"=>$value['OrderNo']))->find();
                            $ary_orders[$key]['OrderSource']  =  "行云全球汇 V2.1 ";   // 订单来源
                            $ary_orders[$key]['AuditStatus']  =  0;   // 订单来源
                            $ary_orders[$key]['BusinessCode']  =  "";   // 业务编码
                            $ary_orders[$key]['ExitSign']  =  "I";         // 进出口标志
                            $ary_orders[$key]['RetailersName']  =  "";    // 电商企业名称
                            $ary_orders[$key]['RetailersCode']  =  "";    // 电商企业编码
                            $ary_orders[$key]['PlatformName']  =  "";     // 电商平台名称
                            $ary_orders[$key]['PlatformCode']  =  "";     //  电商平台编码
                          //  $ary_orders[$key]['OrderGoodsAmount'] = $value['User_amount'] + $value['o_coupon_menoy'];
                         //   unset($value['o_coupon_menoy']);
                         
                            $ary_orders[$key]['CurrCode']  =  "142";
                            $ary_orders[$key]['Rate']  =  0;
                            //   $ary_orders[$key]['Payment_title'] = $Account_info['pc_custom_name'];
                            //   $ary_orders[$key]['Payment_CompanyCode'] = $Account_info['pc_custom_name'];
                            if($value['o_payment'] == 1)
                            {
                                $pay_name = "余额";
                            }else if($value['o_payment'] == 2)
                            {
                                $pay_name = "支付宝";
                            }else{
                                $pay_name = "信用账户";
                            }
                            if($ary_orders[$key]['order_type'] != '1')
                            {
                                $ary_orders[$key]['CardFaceImg'] = "";
                                $ary_orders[$key]['CardOppositeImg'] = "";
                            }
                            $ary_orders[$key]['Payment_Code'] = "";
                            $ary_orders[$key]['PurchaserType'] = "01";
                            $ary_orders[$key]['insureAmount'] =0;
                            $ary_orders[$key]['Payment_Type'] =$pay_name;
                            $ary_orders[$key]['PaymentTime'] = $Account_info['ps_create_time'];
                            $ary_orders[$key]['Payment_Code'] = "";
                            $ary_orders[$key]['LogisCompanyName'] = "";
                            $ary_orders[$key]['LogisCompanyCode'] = "";
                            $ary_orders[$key]['Payment_Code'] = "";
                            $ary_orders[$key]['PostMode'] = "";
                            $ary_orders[$key]['WayBills'] = "";
                            $ary_orders[$key]['SenderCountry'] = "";
                            $ary_orders[$key]['SenderName'] = "";
                            $ary_orders[$key]['DeliveredTime'] = "";
                            $ary_orders[$key]['DeliveredStatus'] = 0;
                            $ary_orders[$key]['ReceivedTime'] = "";
                            $ary_orders[$key]['IdentificationStatus'] = 0;
                            $ary_orders[$key]['PseudoPayStatus'] = 0;
                            $ary_orders[$key]['PaymentStatus'] = 1;
                            $ary_orders[$key]['TransportationStatus'] = 0;
                            $ary_orders[$key]['DeclarationStatus'] = 0;
                            $ary_orders[$key]['DeclareStatus'] = 0;
                                 
                            $order_info = D("OrdersItems")->GetOrdersInfo(array("o_id"=>$value['OrderNo']),$field_info);
             
                            foreach($order_info as $k=>$order)
                            {
                                  $order_info[$k]['Img_url'] = getFullPictureWebPath($order['Img_url']);

                                  $ary_orders[$key]['TotalCount']  +=  $order['Quantity'];
                                  $ary_orders[$key]['GoodsWeight']  +=  $order['Goods_Weight'];
                                  $order_info[$k]['Spec_text'] =  "";
                            }
                            $ary_orders[$key]['OrderDetails'] = $order_info;
            }
          
           // $ary_orders_json[]= $ary_orders;
            $Api_token = Api_erp_token();
            $api_token_json_array  = json_decode($Api_token,true);
           
            $success = makeRequestApiJson(json_encode($ary_orders),"POST",$api_token_json_array);
            $success_api = json_decode($success,true);
  
            if($success_api == true)
            {
                $SaveWhere['o_id'] = array("in",$order_id);
              $res = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where($SaveWhere)->data(array('o_Synchronization' => '1', 'o_Synchronization_time' => date('Y-m-d H:i:s')))->save();
                 if ($res) {
                     foreach ($order_id as $id)
                     {
                              //更新日志表
                        $ary_orders_log = array(
                            'o_id' => $id,
                            'ol_behavior' => '订单同步',
                            'ol_uname'=> 'admin',
                            'ol_text' => serialize($ary_orders),
                        );
                        D('OrdersLog')->addOrderLog($ary_orders_log);
                     }
                    } else {
                         output_msg("订单同步失败", array('flag' => FALSE,"count"=>0));
                        exit;
                    }
            }else{
                    foreach ($order_id as $id)
                     {
                              //更新日志表
                            $ary_orders_log = array(
                                'o_id' => $id,
                                'ol_behavior' => '订单同步失败',
                                'ol_uname' =>'admin',
                                'ol_text' => $success,
                            );
                        D('OrdersLog')->addOrderLog($ary_orders_log);
                     }
                   output_msg("订单同步失败", array('flag' => FALSE,"count"=>0));
            }
            M('', '', 'DB_CUSTOM')->commit();
             output_msg("同步成功", array('flag' => TRUE,"count"=>$count));exit;
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
    
}
