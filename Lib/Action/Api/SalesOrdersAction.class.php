<?php

class SalesOrdersAction extends MobileAction {
    
    /**
     * 订单对象
     * 
     * @autho donkey
     * @date 2016年7月11日
     */
    private $orders;

    /**
     * 地址对象
     * 
     * @autho donkey
     * @date 2016年7月11日
     */
    private $cityRegion;
    private $receiveAddr;
    /**
     * 订单控制器初始化
     * 
     * @autho donkey
     * @date 2016年7月11日
     */
    public function __construct() {
        parent::__construct();        
        $this->orders = D('Orders');
        $this->cityRegion = D('CityRegion');
        $this->logistic = D('Logistic');
        $this->cart = D('Cart');
    }
    
    
    // 作废订单
    public function ajaxInvalidOrder() {
        $int_oid = $this->_post('oid');
        $cacel_type = 4;
       
        if (isset($int_oid) && isset($cacel_type)) {
            M()->startTrans();
            //断订单是满足作废条件,只有未支付的订单才能作废
            $ary_where = array('o_id' => $int_oid, 'o_pay_status' =>array('in','0,3'), 'o_status' => 1);
            $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
            $ary_orders = $orders->where($ary_where)->find();
            if (empty($ary_orders)) {
                   output_datas(null,array('result' =>"1",'desc'=>'此订单不能不存在'));
            } else {
                if($ary_orders['o_pay']!=0.00)
                {
                        $arr_balance_data = array();
                        $ary_prepaid_card['pc_money'] = sprintf("%.2f",$ary_orders['o_pay']);
                     //   $arr_balance_data['pc_serial_number'] = $ary_prepaid_card['pc_serial_number'];
                        $arr_balance_data['bt_id'] = 2;//账户退款
                        $arr_balance_data['m_id'] = $ary_orders['m_id'];
                        $arr_balance_data['bi_money'] = $ary_prepaid_card['pc_money'];
                        $arr_balance_data['u_id'] = 0;
                        $arr_balance_data['bi_type'] = 0;//收入
                        $arr_balance_data['bi_verify_status'] = 1;
                        $arr_balance_data['bi_service_verify'] = 1;
                        $arr_balance_data['bi_finance_verify'] = 1;
                        $arr_balance_data['bi_payment_time'] = date('Y-m-d H:i:s');
                        $arr_balance_data['bi_desc'] = "退款金额{$ary_prepaid_card['pc_money']}元";
                        $arr_balance_data['bi_create_time'] =  date('Y-m-d H:i:s');
                        $arr_balance_data['bi_update_time'] =  date('Y-m-d H:i:s');
                        $arr_balance_data['single_type'] = 1;

                        $balance = new Balance();
                        $ary_rest = $balance->addBalanceInfo($arr_balance_data);
                        
            $balance_info = M('balance_info',C('DB_PREFIX'),'DB_CUSTOM')->where($arr_balance_data)->find();
            //写入客审结余款调整单日志
            $balance_server_log['u_id'] = 0;
            $balance_server_log['u_name'] = 'System';
            $balance_server_log['bi_sn'] = $balance_info['bi_sn'];
            $balance_server_log['bvl_desc'] = "退款{$ary_prepaid_card['pc_money']}元客审成功";
            $balance_server_log['bvl_type'] = '2';
            $balance_server_log['bvl_status'] = '1';
            $balance_server_log['bvl_create_time'] = date('Y-m-d H:i:s');
            if(false === M('balance_verify_log',C('DB_PREFIX'),'DB_CUSTOM')->add($balance_server_log)){
                     M()->rollback();
                     output_datas(null,array('result' =>"1",'desc'=>'生成客审结余款调整单日志失败'));
            }
            
            //写入财审结余款调整单日志
            $balance_finance_log['u_id'] = 0;
            $balance_finance_log['u_name'] = 'System';
            $balance_finance_log['bi_sn'] = $balance_info['bi_sn'];
            $balance_finance_log['bvl_desc'] = "退款{$ary_prepaid_card['pc_money']}元财审成功";
            $balance_finance_log['bvl_type'] = '2';
            $balance_finance_log['bvl_status'] = '1';
            $balance_finance_log['bvl_create_time'] = date('Y-m-d H:i:s');
            if(false === M('balance_verify_log',C('DB_PREFIX'),'DB_CUSTOM')->add($balance_finance_log)){
                M()->rollback();
                output_datas(null,array('result' =>"1",'desc'=>'生成财审结余款调整单日志失败'));
            }
                }
                $return_orders = $orders->where(array(
                            'o_id' => $int_oid
                        ))->save(array(
                    'o_status' => 2,
                    'erp_status'=>5
                        ));	
                // 订单日志记录
                if ($return_orders) {
                    $ary_orders_log = array(
                        'o_id' => $int_oid,
                        'ol_behavior' => '作废',
                        'ol_uname' =>$this->member_info['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                }else{
                    M()->rollback();
                     output_datas(null,array('result' =>"1",'desc'=>'更新订单状态失败'));
                }
                if (false != $return_orders) {
                    //销量返回
                    $orderItems = M('orders_items')->field('oi_id,o_id,g_id,pdt_id,oi_nums,fc_id,oi_type')->where(array('o_id'=>$int_oid))->select();
                    foreach($orderItems as $item){
                        if($item['oi_type']==5 && !empty($item['fc_id'])){
                            $return_groupbuy_nums = D("Groupbuy")->where(array('gp_id' => $item['fc_id']))->setDec("gp_now_number",$item['oi_nums']);
                            if(!$return_groupbuy_nums){
                                M()->rollback();
                                 output_datas(null,array('result' =>"1",'desc'=>'作废订单团购量更新失败'));
                            }
                        }elseif($item['oi_type']==7 && !empty($item['fc_id'])){
                            $retun_spike_nums=D("Spike")->where(array('sp_id' => $item['fc_id']))->setDec("sp_now_number",$item['oi_nums']);
                            if(!$retun_spike_nums){
                                M()->rollback();
                                output_datas(null,array('result' =>"1",'desc'=>'作废订单秒杀量更新失败'));
                            }
                        }elseif($item['oi_type']==11 && !empty($item['fc_id'])) {
                            $retun_spike_nums = D("Integral")->where(array('integral_id' => $item['fc_id']))->setDec("integral_now_number", $item['oi_nums']);
                            if (!$retun_spike_nums) {
                                M()->rollback();
                                output_datas(null,array('result' =>"1",'desc'=>'作废积分加金额兑换数量更新失败'));
                            }
                        }
                        $goods_num_res = M("goods_info")->where(array(
                                    'g_id' => $item ['g_id']
                                ))->data(array(
                                    'g_salenum' => array(
                                        'exp',
                                        'g_salenum - '.$item['oi_nums']
                                    )
                                ))->save();
                        if(!$goods_num_res){
                            M()->rollback();
                            output_datas(null,array('result' =>"1",'desc'=>'作废订单销量更新失败'));
                        }
						//库存释放
						if($ary_orders['o_payment'] == 3 || $ary_orders['o_payment'] == 6){
							$item_stock_info=M('goods_products', C('DB_PREFIX'), 'DB_CUSTOM')->field('pdt_freeze_stock,pdt_stock,pdt_total_stock')->where(array('g_id' => $item ['g_id'],'pdt_id'=>$item['pdt_id']))->find();
							if(isset($item_stock_info['pdt_freeze_stock']) && $item_stock_info['pdt_freeze_stock'] >0){
								$item_stock_data['pdt_freeze_stock']=$item_stock_info['pdt_freeze_stock']-$item['oi_nums'];
								if($item_stock_data['pdt_freeze_stock'] < 0 ){
									$item_stock_data['pdt_freeze_stock']= 0;
									$item_stock_data['pdt_stock'] = $item_stock_info['pdt_stock'] + $item_stock_info['pdt_freeze_stock'];
									//$item_stock_data['pdt_total_stock'] =$item_stock_info['pdt_total_stock'] + $item_stock_info['pdt_freeze_stock'];
								}else{
									$item_stock_data['pdt_stock'] = $item_stock_info['pdt_stock'] + $item['oi_nums'];
									//$item_stock_data['pdt_total_stock'] =$item_stock_info['pdt_total_stock'] + $item['oi_nums'];
								}
								$updata_item_stock = M('goods_products', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('g_id' => $item ['g_id'],'pdt_id'=>$item['pdt_id']))->save($item_stock_data);
								if(!$updata_item_stock){
									M()->rollback();
                                                                          output_datas(null,array('result' =>"1",'desc'=>'作废订单库存更新失败'));
								}
							}							
						}
						
                    }
                    // 冻结积分释放掉
                    $point_orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->field('m_id,o_freeze_point')->where(array('o_id' => $int_oid))->find();
                    if (isset($point_orders['o_freeze_point']) && $point_orders['o_freeze_point'] > 0 && $point_orders['m_id'] > 0) {
                         $ary_member = M('Members', C('DB_PREFIX'), 'DB_CUSTOM')->field('freeze_point')->where(array('m_id' => $point_orders['m_id']))->find();
                         if ($ary_member && $ary_member['freeze_point'] > 0) {
                            //订单作废返还冻结积分日志
                            $ary_log = array(
                                        'type'=>8,
                                        'consume_point'=> 0,
                                        'reward_point'=> $point_orders['o_freeze_point']
                                        );
                            $ary_info =D('PointLog')->addPointLog($ary_log,$point_orders['m_id']);
                            if($ary_info['status'] == 1){
                                 $ary_member_data['freeze_point'] = $ary_member['freeze_point'] - $point_orders['o_freeze_point'];
                                 $res_member = M('Members', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('m_id' => $point_orders['m_id']))->save($ary_member_data);
                                 if(!$res_member){
                                     $orders->rollback();
                                      output_datas(null,array('result' =>"1",'desc'=>'作废返回冻结积分失败'));
                                 }
                            }else{
                                 $orders->rollback();
                                 output_datas(null,array('result' =>"1",'desc'=>'作废返回冻结积分写日志失败'));
                            }
                        }else{
                             $orders->rollback();
                             output_datas(null,array('result' =>"1",'desc'=>'作废返回冻结积分没有找到要返回的用户冻结金额'));
                        }
                    }
                    if(!empty($ary_orders['o_source_id'])){
                        $bool_result = M('thd_orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('to_oid'=>$ary_orders['o_source_id']))->data(array('to_tt_status'=>'0'))->save();
                        if(false === $bool_result){
                            M()->rollback();
                             output_datas(null,array('result' =>"1",'desc'=>'更新第三方来源单号失败'));
                        }
                    }
                    M()->commit();
                    output_datas(null,array('result' =>"0",'desc'=>'取消成功！'));
                } else {
                    M()->rollback();
                    output_datas(null,array('result' =>"1",'desc'=>'此订单不能取消'));
                }
            }
        }
    }
    
    public function SalesOrderDetails(){
         
    $int_o_id = $this->_param('oid');
        $field = array(
            'fx_orders.o_id',
            'fx_orders_items.oi_id',
            'fx_orders.o_status',
            'fx_orders.o_all_price',
            'fx_orders.o_pay',
            'fx_orders.o_create_time',
            'fx_orders.o_goods_all_price',
            'fx_orders.o_goods_all_saleprice',
            'fx_orders.o_tax_rate',
            'fx_orders.o_pay_status',
            'fx_orders.express_status',
            'fx_orders.o_receiver_name',
            'fx_orders.o_receiver_state',
            'fx_orders.o_receiver_city',
            'fx_orders.o_receiver_county',
            'fx_orders.erp_status',
            'fx_orders.o_discount',
            'fx_orders.o_customs',
            'fx_orders.completeStatusTime',
            'fx_orders.o_shipping_remarks',
            'fx_orders.o_receiver_address',
            'fx_orders.o_receiver_telphone',
            'fx_orders.o_receiver_mobile',
            'fx_orders.o_receiver_email',
            'fx_orders.o_coupon_menoy',
            'fx_orders.o_cost_payment',
            'fx_orders.order_type',
            'fx_orders.initial_o_id',
            'fx_orders.o_buyer_comments',
            'fx_orders.o_source_id',
            'fx_orders.o_payment',
            'fx_orders.o_update_time',
            'fx_orders.lt_id',
            'fx_orders.ra_id',
            'fx_orders.o_reward_point',
            'fx_orders.o_freeze_point',
            'fx_orders.o_cost_freight',
            'fx_orders.o_receiver_time',
            'fx_orders_items.pdt_id',
            'fx_orders_items.g_id',
            'fx_orders_items.oi_ship_status',
            'fx_orders_items.g_sn',
            'fx_orders_items.oi_g_name',
            'fx_orders_items.oi_score',
            'fx_orders_items.oi_nums',
            'fx_orders_items.oi_type',
            'fx_orders_items.oi_price',
            'fx_orders_items.pdt_sale_price',
            'fx_orders_items.pdt_sn',
            'fx_orders_items.promotion',
            'fx_orders_items.promotion_price',
            'fx_members.m_balance',
            'fx_orders.o_audit',
            'fx_orders.o_bonus_money',
            'fx_orders.o_cards_money',
            'fx_orders.o_jlb_money',
            'fx_orders.o_point_money',
            'fx_orders.o_reward_jlb',
            'fx_orders.o_audit_time',
            'fx_orders.declareTime',
            'fx_orders.express',
            'fx_orders.express_no',
            'fx_orders.DeliveredTime',
            'fx_orders.o_receiver_idcard'
        );
        $where = array(
            'fx_orders.o_id' => $int_o_id,
            'fx_members.m_id' =>  $this->member_info['m_id']
        );
        $ary_orders_info = D('Orders')->getOrdersData($where, $field);
        if($ary_orders_info[0]['o_receiver_telphone']){
            $ary_orders_info[0]['o_receiver_telphone'] = decrypt($ary_orders_info[0]['o_receiver_telphone']);
        }
    //    $RegExp  = "/^((13[0-9])|147|(15[0-35-9])|180|182|(18[5-9]))[0-9]{8}$/A";
//        if(!preg_match($RegExp,$ary_orders_info[0]['o_receiver_mobile'])){
//            $ary_orders_info[0]['o_receiver_mobile'] = vagueMobile(decrypt($ary_orders_info[0]['o_receiver_mobile']));
//        }else{
//            $ary_orders_info[0]['o_receiver_mobile'] = vagueMobile( $ary_orders_info[0]['o_receiver_mobile']);
//        }
        if(strpos($ary_orders_info[0]['o_receiver_idcard'],':')){
            $ary_orders_info[0]['o_receiver_idcard'] = decrypt($ary_orders_info[0]['o_receiver_idcard']);
        }
        $ary_orders_info[0]['o_receiver_idcard'] = coverStr($ary_orders_info[0]['o_receiver_idcard'],13);

        $ary_orders = $ary_orders_info[0];
      
        // 订单作废状态
        $ary_status = array(
            'o_status' => $ary_orders ['o_status']
        );
        $str_status = $this->orders->getOrderItmesStauts('o_status', $ary_status);
        $ary_orders ['str_status'] = $str_status;

        // 订单状态
        $ary_orders_status = $this->orders->getOrdersStatus($int_o_id);
        $ary_afersale = M('orders_refunds', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                    'o_id' => $int_o_id
                ))->order('or_update_time asc')->select();

        if ($ary_orders ['refund_goods_status'] == '') {
            $ary_orders ['deliver_status'] = $ary_orders_status ['deliver_status'];
        }
        if ($ary_orders ['refund_status'] == '') {
            // 订单支付状态
            $ary_pay_status = array(
                'o_pay_status' => $ary_orders ['o_pay_status']
            );
            $str_pay_status = $this->orders->getOrderItmesStauts('o_pay_status', $ary_pay_status);
            $ary_orders ['str_pay_status'] = $str_pay_status;
        }

        // 退款、退货类型
        $ary_orders ['refund_type'] = $ary_orders_status ['refund_type'];
        // 支付方式
        $ary_payment_where = array(
            'pc_id' => $ary_orders ['o_payment']
        );
        $ary_payment = D('PaymentCfg')->getPayCfgId($ary_payment_where);
        $ary_orders ['payment_name'] = $ary_payment ['pc_custom_name'];
        $ary_orders ['pc_id'] = $ary_payment ['pc_id'];
        // 配送方式
        $ary_logistic_where = array(
            'lt_id' => $ary_orders ['lt_id']
        );
        $ary_field = array(
            'lc_name'
        );
        //$ary_logistic_info = $this->logistic->getLogisticInfo($ary_logistic_where, $ary_field);
        //$ary_orders ['str_logistic'] = $ary_logistic_info [0] ['lc_name'];

        // 订单详情商品
        if (!empty($ary_orders_info) && is_array($ary_orders_info)) {
            $combo_price_total = 0;
            foreach ($ary_orders_info as $k => $v) {

                //处理使用的促销问题
                $ary_orders_info[$k]['promotions'] = array();
                if (strlen($v['promotion']) > 0) {
                    $ary_orders_info[$k]['promotions'] = explode(' ', $v['promotion']);
                }

                $ary_orders_info [$k] ['pdt_spec'] = D("GoodsSpec")->getProductsSpec($v ['pdt_id']);

                $ary_goods_pic = M('goods_info', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                            'g_id' => $v ['g_id']
                        ))->field('g_picture')->find();

                $ary_orders_info [$k] ['g_picture'] = "http://".$_SERVER['HTTP_HOST'].getFullPictureWebPath($ary_goods_pic ['g_picture']);
                // 订单商品退款、退货状态
                $ary_orders_info [$k] ['str_refund_status'] = $this->orders->getOrderItmesStauts('oi_refund_status', $v);
                // 订单商品发货
                // echo "<pre>";print_r($ary_orders_info);exit;
                $ary_orders_info [$k] ['str_ship_status'] = $this->orders->getOrderItmesStauts('oi_ship_status', $v);
                // 分销系统商品小计 和  从第三下单的商品小计
                $ary_orders_info [$k] ['subtotal'] = empty($v['o_source_id']) ? $v ['oi_nums'] * $v ['oi_price'] : $v['oi_price'];
               // echo "<pre>";print_r($v);die;
                if ($v ['oi_type'] == 3) {
                    $combo_sn = $v ['pdt_sn'];
                    $tmp_ary = array(
                        'g_sn' => $ary_orders_info [$k] ['g_sn'],
                        'pdt_spec' => $ary_orders_info [$k] ['pdt_spec'],
                        'g_picture' => $ary_orders_info [$k] ['g_picture'],
                        'oi_g_name' => $ary_orders_info [$k] ['oi_g_name'],
                        'pdt_id' => $ary_orders_info [$k] ['pdt_id']
                    );

                    $combo_pdt_gid = D('GoodsProducts')->Search(array(
                        'pdt_sn' => $v ['pdt_sn']
                            ), array(
                        'g_id'
                            ));
                    $combo_where = array(
                        'g_id' => $combo_pdt_gid ['g_id'],
                        'releted_pdt_id' => $ary_orders_info [$k] ['pdt_id']
                    );
                    $combo_field = array(
                        'com_nums',
                        'com_price'
                    );
                    $combo_res = D('ReletedCombinationGoods')->getComboReletedList($combo_where, $combo_field);
                    
                    $combo_num = $combo_res [0] ['com_nums'];
                    $combo_price_total += sprintf("%0.3f", $combo_res [0] ['com_nums'] * $combo_res [0] ['com_price']);

                    $ary_combo [$combo_sn] ['item'] [$k] = $tmp_ary;
                    $ary_combo [$combo_sn] ['num'] = $ary_orders_info [$k] ['oi_nums'] / $combo_num;
                    $ary_combo [$combo_sn] ['pdt_sale_price'] = $ary_orders_info [$k] ['pdt_sale_price'];
                    $ary_combo [$combo_sn] ['o_all_price'] = sprintf("%0.3f", $combo_price_total * $ary_combo [$combo_sn] ['num']);
                    $ary_combo [$combo_sn] ['str_ship_status'] = $ary_orders_info [$k] ['str_ship_status'];
                    $ary_combo [$combo_sn] ['str_refund_status'] = $ary_orders_info [$k] ['str_refund_status'];
                    unset($ary_orders_info [$k]);
                }
            }
        }
        
        // 物流信息
        $ary_delivery = D('Orders')->ordersLogistic($int_o_id);
      
        // 商品总价=商品折扣后价格+折扣价
        $ary_orders ['o_goods_all_price'] = sprintf("%0.3f", $ary_orders['o_goods_all_price']);
       // echo "<pre>";print_r($ary_orders);exit;
        // 判断是否已生成退款/退货单
        if ($ary_orders ['refund_type'] == '1') {
            $where = array();
            $where ['o_id'] = $ary_orders ['o_id'];
            $where ['or_refund_type'] = 1;
            $where ['or_processing_status'] = array(
                'neq',
                2
            );
            $num_refund = D('OrdersRefunds')->where($where)->count();
        }

        // 审核后是否允许申请退款
        $resdata = D('SysConfig')->getCfg('ALLOW_REFUND_APPLY','ALLOW_REFUND_APPLY','0','审核后是否允许申请退款');

        // 是否开启退运费 --modify By Tom <helong@guanyisoft.com> 2014-10-30
        $openDelivery = D('SysConfig')->getCfgByModule('ALLOW_REFUND_DELIVERY_ALL');
        $isOpenDelivery = 0;
        if(isset($openDelivery['ALLOW_REFUND_DELIVERY_ALL']) && $openDelivery['ALLOW_REFUND_DELIVERY_ALL']== 1){
            $delivery_where = array(
                'o_id' => $ary_orders['o_id'],
                'or_refund_type' => 3
                );
            $isOpenDelivery = 1;
            // 判断是否已经提交退运费申请
            $delivery_data = D('OrdersRefunds')->where($delivery_where)->count();
            if($delivery_data >= 1){
                $isOpenDelivery = 0;
            }
        }

        // 判断淘宝担保交易
        $arr_payment = M('payment_cfg', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                    'ps_id' => $ary_orders ['o_payment']
                ))->find();

       // echo "<pre>";print_r($ary_orders);exit;
        // 还应支付金额
        $ary_orders ['o_order_amount'] = sprintf("%0.3f", $ary_orders ['o_all_price'] - $ary_orders ['o_pay']);
        if(in_array(C('CUSTOMER_TYPE'),array(1,3)) && !empty($ary_orders['o_source_id'])){
            $this->assign('o_source_id', $ary_orders['o_source_id']);
        }
        //是否审核
        $ary_orders['str_auto_status'] = ($ary_orders['o_audit'] == 1) ? '已审核' : '未审核';
		//提货方式
		$ary_logistic_where = array(
            'lt_id' => $ary_orders ['lt_id']
        );
        $ary_field = array(
            'lc_abbreviation_name'
        );
        $ary_log = $this->logistic->getLogisticInfo($ary_logistic_where, $ary_field);
		$ary_orders['lc_abbreviation_name'] = $ary_log[0]['lc_abbreviation_name'];
                $deliveryTime = D("OrdersDelivery")->where(array("o_id"=>$ary_orders['o_id']))->find();
            
     //   $GetOrderRefundsTimeSelect = D("OrdersRefunds")->GetOrderRefundsTimeSelect(array("o_id"=>$ary_orders['o_id']));
      //  print_r($ary_orders['o_id']);exit;
            if(!empty($ary_orders['initial_o_id']))
            {
                $payment = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                        'ps_code' => $arr_payment ['pc_abbreviation'],
                        "o_id" => $ary_orders['initial_o_id']
                    ))->find();
            }else{
                $payment = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->where(array(
                        'ps_code' => $arr_payment ['pc_abbreviation'],
                        "o_id" => $int_o_id
                    ))->find();
            }
        $ary_orders['pay_time']  = $payment['ps_create_time'];
        $ary_orders['o_receiver_time'] = $deliveryTime['od_created'];
    //    $ary_orders['GetOrderRefunds_time']  =$GetOrderRefundsTimeSelect["or_create_time"];
        if(empty($ary_orders))
        {
            $ary_orders = array();
        }else{
             $ary_orders['orderGoods'] = $ary_orders_info;
        }
         output_datas($ary_orders,array('result' =>"0",'desc'=>'查询成功！'));
       

        }   
        
    public function ApiOrdersDoadd(){
        
        $ary_sgp = array();
        $ary_datas = $this->_post();
        $ary_datas['m_id'] = $this->member_info['m_id'];
        $ary_datas['o_status'] = 1;
        $ary_datas['lt_id'] = 2;
        $ary_datas = $this->_beforeDoAdd($ary_datas);
        $UserPrice = D("Members")->GetBalance(array("m_id" => $ary_datas['m_id']), 'm_balance,ca_status');
//        if($ary_datas['mixture'] == 1)
//        {
//            $ary_datas['o_payment'] = 1 ;  
//        }
//        if($ary_datas['o_payment'] != 17 && $ary_datas['o_payment'] != 16 && $ary_datas['o_payment'] != 2)
//        {
//            if ($UserPrice['m_balance'] < $ary_datas['goods_all_price']) {
//                 $ary_datas['o_payment'] = 2 ;  
//            }
//        }
        if($ary_datas['o_payment'] == 16)
        {
            if ($UserPrice['ca_status']  == 0) {
                 output_datas(null,array('result' =>"1",'desc'=>'您的信用帐号已冻结，请联系客服！'));
            }
        }
        //判断客户端类型
        $client_type = $ary_datas['client_type'];//客户端类型 android/ios
        
        $cart_data = D('Cart')->ApiReadMycart($this->member_info['m_id']);
        $ary_sgp = D('Cart')->getSgp($ary_datas['goods_pids'],$cart_data);
        $sgp = array();
        foreach($ary_sgp as $key=>$sgp_item) {
            $sgp[] = implode(',', $sgp_item);
        }
         $ary_datas['o_cost_freight'] = sprintf("%0.2f",D("Goods")->GoodsNumberPriceOperation($ary_sgp,(int)$ary_datas['province']));
         unset($ary_datas['province']);
        $ary_datas['g_tax_rate']  = $ary_datas['tax_rate'];       
        $array_params = array(
            'ra_id' =>  $ary_datas['ra_id'], //地址ID (必填)
            'm_id'  =>  $ary_datas['m_id'],   //会员ID (必填)
            'ml_id' =>  $ary_datas['ml_id'],   //会员ID (必填)
            'pc_id' =>  $ary_datas['o_payment'], //支付ID (必填)
            'lt_id' =>  $ary_datas['lt_id'],  //物流ID (必填)
            'sgp'   =>  base64_encode(implode(';', $sgp)),  //g_id,pdt_id(规格ID),num,type,type_id;g_id,pdt_id(规格ID),num,type,type_id
            'resource' => $client_type, //订单来源 (必填) (android或ios)
            'bonus' =>  $ary_datas['bonus_input'],      //可选，红包
            'cards' => '',      //可选，储值卡
            'csn'   =>  $ary_datas['coupon_input'],      //可选，优惠码
            'point' =>  $ary_datas['point_input'],      //可选，积分
            'type'	=>  '10',	       //可选，0：优惠券|1：红包|2：存储卡|4：积分
            'admin_id' => $ary_datas['admin_id'],	//可选，管理员id
            'shipping_remarks' => $ary_datas ['shipping_remarks'], //发货备注
            'o_point_money' => $ary_datas ['o_point_money'], //积分兑换金额
        );
                //发票信息
        $array_params ['is_on'] = '0';

        if (!empty($ary_datas ['invoices_val']) && $ary_datas ['invoices_val'] == "1") {//是否需要开启发票
            if (isset($ary_datas ['invoice_type']) && !empty($ary_datas ['invoice_type']) ) {//需要开发票
                if($ary_datas ['invoice_type'] == 2){//增值税发票
                    $array_params ['invoice_head'] = 2;//增值税发票 默认抬头为单位
                    //保存增值税 发票信息
                    if (!empty($ary_datas ['in_id'])) {
                        $array_params ['is_on'] = '4';//添加增值税 发票
                    }
                }elseif($ary_datas ['invoice_type'] == 1 && isset($ary_datas ['invoice_head'])){//普通发票
                    if ($ary_datas ['invoice_head'] == 2){//普通发票且为个人
                        $array_params ['is_on'] = '1';//需要个人开发票
                    }elseif($ary_datas ['invoice_head'] == 1){
                        $array_params ['is_on'] = '2';//需要开公司发票
                    }
                }
            }else{
                if (isset($ary_datas ['is_default']) && !empty($ary_datas ['is_default']) && !isset($ary_datas ['in_id'])) {//取默认发票
                    $array_params ['is_on'] = '3';//默认发票
                }
            }
        }
         
        $array_params = array_merge($ary_datas, $array_params);
        if(!empty($array_params['gb_logo_1']) && !empty($array_params['gb_logo_2']))
        {
            $array_params['gb_logo_1'] = D('ViewGoods')->ReplaceItemPicReal($array_params['gb_logo_1']);
            $array_params['gb_logo_2'] = D('ViewGoods')->ReplaceItemPicReal($array_params['gb_logo_2']);
        }
        $sql_model = M('', C('DB_PREFIX'), 'DB_CUSTOM');
        $sql_model->startTrans();
         
        $add_order_res = D('ApiOrders')->fxOrderDoAdd($array_params,$ary_datas);  
        if($add_order_res['result']) {         
            $order_id = $add_order_res['data']['o_id'];

            //edit by wangpan 2016年10月8日 手机微信支付
            if($ary_datas['o_payment'] == "19" ){

                    $ary_order = D('Orders')->where(array('o_id' => $order_id))->find();
                    $int_ps_id = $this->addPaymentSerial(0, $ary_order,0,0,'APPWEIXIN');
                    if ($ary_datas['mixture'] == "1") {
                         //   $userPrice = $add_order_res['data']['o_all_price'] - $UserPrice['m_balance'];
                          $MemberSave =  D("Members")->UpdateBalance($ary_datas['m_id'],0);
                          if(!empty($MemberSave))
                          {
                           $OrdersSave =  D("Orders")->UpdateOrdersO_pay($order_id,$UserPrice['m_balance']);
                            if(FALSE === $OrdersSave){
                                output_datas(null,array('result' =>"1",'desc'=>'更新结余款失败！'));
                            }
                                $arr_balance_data = array();
                                $ary_prepaid_card['pc_money'] = sprintf("%.2f",$UserPrice['m_balance']);
                             //   $arr_balance_data['pc_serial_number'] = $ary_prepaid_card['pc_serial_number'];
                                $arr_balance_data['bt_id'] = 1;//账户消费
                                $arr_balance_data['m_id'] = $ary_datas['m_id'];
                                $arr_balance_data['o_id'] = $order_id;
                                $arr_balance_data['bi_money'] = $ary_prepaid_card['pc_money'];
                                $arr_balance_data['u_id'] = 0;
                                $arr_balance_data['o_payment'] = 19;
                                $arr_balance_data['bi_type'] = 1;//支出
                                $arr_balance_data['bi_verify_status'] = 1;
                                $arr_balance_data['bi_service_verify'] = 1;
                                $arr_balance_data['bi_finance_verify'] = 1;
                                $arr_balance_data['bi_payment_time'] = date('Y-m-d H:i:s');
                                $arr_balance_data['bi_desc'] = "余额已支付金额{$ary_prepaid_card['pc_money']}元";
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
                        $ary_orders_log = array(
                            'o_id' => $order_id,
                            'ol_behavior' => '混合支付,扣除一部分余额',
                            'ol_uname' => $ary_datas['m_id'],
                            'ol_create' => date('Y-m-d H:i:s')
                        );
                         $OrdersLogAdd =  D('OrdersLog')->add($ary_orders_log);
                         if (empty($OrdersLogAdd)) {
                                 $sql_model->rollback();
                                  output_datas(null,array('result' =>"1",'desc'=>'订单日志添加失败！'));
                            }
                            $int_order_update = D("Orders")->where(array('o_id' => $order_id))->save(array("o_pay_status"=>3));
                            if (false == $int_order_update) {
                                    $sql_model->rollback();
                                    output_datas(null,array('result' =>"1",'desc'=>'更新订单状态出错！'));
                            }
                            $sql_model->commit();
                            $o_pay_order = sprintf("%.2f",$add_order_res['data']['o_all_price'] - $UserPrice['m_balance']);
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
                            $x['out_trade_no'] = $int_ps_id;
                            $x['total_fee'] = $o_pay_order;
                            $x['order_id'] = $order_id;
                            //dump($x);exit;
                            output_datas($x,array('result' =>"0",'error_code' =>0,'desc'=>'请求预支付id成功'));

                    }
                    $sql_model->commit();
                    $o_pay_order = sprintf("%.2f",$add_order_res['data']['o_all_price']);
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
                    $x['out_trade_no'] = $int_ps_id;
                    $x['total_fee'] = $o_pay_order;
                    $x['order_id'] = $order_id;
                    //dump($x);exit;
                    output_datas($x,array('result' =>"0",'error_code' =>0,'desc'=>'请求预支付id成功'));

            }


            if ($add_order_res['data']['o_payment'] == "1" || $add_order_res['data']['o_payment'] == "16") {
                   $sql_model->commit();
                   $this->paymentPage($order_id,$add_order_res['data']['o_payment'],0,0);
            } else {
                $ary_order = D('Orders')->where(array('o_id' => $order_id))->find();
               $int_ps_id = $this->addPaymentSerial(0, $ary_order,0,0,'APPALIPAY');
            if ($ary_datas['mixture'] == "1") {
                 //   $userPrice = $add_order_res['data']['o_all_price'] - $UserPrice['m_balance'];
                  $MemberSave =  D("Members")->UpdateBalance($ary_datas['m_id'],0);
                  if(!empty($MemberSave))
                  {
                   $OrdersSave =  D("Orders")->UpdateOrdersO_pay($order_id,$UserPrice['m_balance']);
                    if(FALSE === $OrdersSave){
                        output_datas(null,array('result' =>"1",'desc'=>'更新结余款失败！'));
                    }
                        $arr_balance_data = array();
                        $ary_prepaid_card['pc_money'] = sprintf("%.2f",$UserPrice['m_balance']);
                     //   $arr_balance_data['pc_serial_number'] = $ary_prepaid_card['pc_serial_number'];
                        $arr_balance_data['bt_id'] = 1;//账户消费
                        $arr_balance_data['m_id'] = $ary_datas['m_id'];
                        $arr_balance_data['o_id'] = $order_id;
                        $arr_balance_data['bi_money'] = $ary_prepaid_card['pc_money'];
                        $arr_balance_data['u_id'] = 0;
                        $arr_balance_data['o_payment'] = 18;
                        $arr_balance_data['bi_type'] = 1;//支出
                        $arr_balance_data['bi_verify_status'] = 1;
                        $arr_balance_data['bi_service_verify'] = 1;
                        $arr_balance_data['bi_finance_verify'] = 1;
                        $arr_balance_data['bi_payment_time'] = date('Y-m-d H:i:s');
                        $arr_balance_data['bi_desc'] = "余额已支付金额{$ary_prepaid_card['pc_money']}元";
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
		$ary_orders_log = array(
			'o_id' => $order_id,
			'ol_behavior' => '混合支付,扣除一部分余额',
			'ol_uname' => $ary_datas['m_id'],
			'ol_create' => date('Y-m-d H:i:s')
		);
                 $OrdersLogAdd =  D('OrdersLog')->add($ary_orders_log);
                 if (empty($OrdersLogAdd)) {
                         $sql_model->rollback();
                          output_datas(null,array('result' =>"1",'desc'=>'订单日志添加失败！'));
                    }
                    $int_order_update = D("Orders")->where(array('o_id' => $order_id))->save(array("o_pay_status"=>3));
                    if (false == $int_order_update) {
                            $sql_model->rollback();
                            output_datas(null,array('result' =>"1",'desc'=>'更新订单状态出错！'));
                    }
                $sql_model->commit();
                $o_pay_order = sprintf("%.2f",$add_order_res['data']['o_all_price'] - $UserPrice['m_balance']);
                output_datas(array("oid"=>$order_id,'out_trade_no'=>(string)$int_ps_id,'o_all_price'=>$o_pay_order,'notify_url'=> U('Home/User/ApisynPayNotify?code=APPALIPAY', '', true, false, true)),array('result' =>"0",'desc'=>'提交成功！'));
                }
                 $sql_model->commit();
                 $o_pay_order = sprintf("%.2f",$add_order_res['data']['o_all_price']);
                 output_datas(array("oid"=>$order_id,'out_trade_no'=>(string)$int_ps_id,'o_all_price'=>$add_order_res['data']['o_all_price'],'notify_url'=> U('Home/User/ApisynPayNotify?code=APPALIPAY', '', true, false, true)),array('result' =>"0",'desc'=>'提交成功！'));
            }
        } else {
            isset($queue_obj) && $queue_obj->unLock();
            $sql_model->rollback();
            output_datas(null,array('result' =>"1",'desc'=>$add_order_res['message']));
        }   
        
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
    protected function addPaymentSerial($int_type = 0, $ary_order = array(),$pay_type = 0,$m_id = 0,$pc_code) {
        //订单支付时，确定支付宝商户订单号 Add Terry 2013-08-26
        if($pay_type==''){ //add by zhangjiasuo 2015-05-29
            $pay_type =0;
        }
        $ary_ps = D('PaymentSerial')->where(array('o_id'=>$ary_order['o_id']))->find();
        if(!empty($ary_ps) && $ary_ps['ps_money'] == $ary_order['o_all_price']){
            return $ary_ps['ps_id'];
        }else{
            $data = array(
                'm_id' => !empty($m_id) ? $m_id : $this->member_info['m_id'],
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
    private function _beforeDoAdd($ary_datas) {
        
      
        $ary_member = $this->member_info;
        $ary_datas ['m_id']=$ary_member['m_id'];
        $ary_datas ['ml_id']=$ary_member['ml_id'];
        $ary_datas ['admin_id']=$ary_member['admin_id'];

        if(empty($ary_datas)){
             output_datas(null,array('result' =>"1",'desc'=>'未知的访问请求'));
        }
        if (empty($ary_datas ['m_id'])) {
            output_datas(null,array('result' =>"1",'desc'=>'登录过期，请重新登录！'));
        }
        $goods_pids = $ary_datas['goods_pids'];
        if(empty($goods_pids)){
            output_datas(null,array('result' =>"1",'desc'=>'没有要购买的商品，请重新选择商品！'));
        }
//        if (empty($ary_datas ['ra_id'])) {
//           //  $this->error('请选择收货地址！111');exit;
//            $this->error('请选择收货地址！');
//        }
		$now_tome = date('Y-m-d H:i',strtotime('+2 hours'));
		if(isset($ary_datas['o_receiver_time']) && $ary_datas['o_receiver_time'] < $now_tome && $ary_datas['o_receiver_time'] != ''){
            $date = new DateTime($ary_datas['o_receiver_time']);
            if(!$date)  output_datas(null,array('result' =>"1",'desc'=>'请选择正确的送货时间！')); 
            $o_receiver_time = $date->format('Y-m-d H:i:s');
            $now_time = strtotime('+2 hours');
            if(strtotime($o_receiver_time) < $now_time )
                output_datas(null,array('result' =>"1",'desc'=>'请选择正确的送货时间,送货时间在当前时间两小时之后！')); 
        }
        if(empty($ary_datas['o_payment'])){
             output_datas(null,array('result' =>"1",'desc'=>'请选择支付方式！')); 
        }
        // 配送方式
//        $str_code = $_SESSION['auto_code'];
//        if(isset($ary_datas['originator'])) {
//            if($ary_datas['originator'] == $str_code){
//                //将其清除掉此时再按F5则无效
//                unset($_SESSION["auto_code"]);
//            }else{
//                //$this->error("订单提交中,请不要刷新本页面或重复提交表单");
//            }
//        }

        return $ary_datas;
    }

    /**
     * 订单支付
     * 
     * @param int $order_id
     *        	订单ID
     * @param ary $oreder
     *        	更新订单表数组
     * @return boolean
     */
    public function paymentPage($int_id,$payment_id,$pay_stat,$pay_code) 
    {

        $where = array();
        $ary_member = $this->member_info;
        $where ['fx_orders.o_id'] = $int_id;
        if ($pay_stat == 2) { // 如果当前是尾款支付
            $where ['fx_orders.o_pay_status'] = 3;
        } else {
            $where ['fx_orders.o_pay_status'] = 0;
        }
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
            $update_payment_res = $this->orders->UpdateOrdersPayment($int_id, $payment_id);
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
           
            $result_order = $this->orders->orderPayment($int_id, $ary_orders);
        
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
            $result_order = $this->orders->orderPayment($int_id, $ary_orders);
            
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
    
    public function total_tax_rate(){
        
         $pids = explode(',', $this->_request('pid'));	
         $ary_member = $this->member_info;
        
        $checkOrder = $this->cart->getCartItems($pids, $ary_member['m_id'], $gift_except=false);
        $return_cart_res = $this->cart->checkOrder($checkOrder,$np,$ary_member['m_id']);
        $ary_cart = $return_cart_res['ary_cart'];
        $cart_data = $this->cart->handleCart($ary_cart);
        $pro_datas = D('Promotion')->calShopCartPro($ary_member['m_id'], $cart_data,1);
        if (is_array($cart_data) && !empty($cart_data)) {
            $ary_data ['ary_product_data'] = $this->cart->getProductInfo($cart_data,$ary_member['m_id'],1);
        }	
        $ary_cart_info = $this->cart->handleCartProductsAuthorize($ary_data['ary_product_data'],$ary_member['m_id']);
        $tmp_pro_datas = $this->cart->handleProdatas($pro_datas,$ary_cart_info);
        
        output_datas(array("total_tax"=>$tmp_pro_datas['total_tax_rate']),array('result' =>"0",'desc'=>'查询成功！'));
    }
        
}

