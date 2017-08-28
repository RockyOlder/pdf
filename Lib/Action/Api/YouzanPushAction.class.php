<?php

/* 
 * @athour wangpan 2016.09.06
 * 推送消息类
 * and open the template in the editor.
 */
class YouzanPushAction extends CommonAction {

    private $appId = '8c0550382a853fdc77';  
    private $appSecret = 'dee9e289cd0d9128b79381d280274470';  
    // URL:
    // http://120.25.249.28/Api/YouzanPush/push
    // 请求方式：post
    // 请求参数：
    // Action ：push   （固定）   
    //Todo:怎样保证客户通过有赞下的单 一个不漏地推送给我们，是个问题,后期还需要查询订单列表
    // 返回data
    public function push(){

        //dump(11);
        $postStr = file_get_contents("php://input");
        //dump($postStr);
        writeLog("REQUEST: ".urldecode($postStr),date('Ymd')."order_status_Youzan_123.log");
        $appId = $this->appId;
        $appSecret = $this->appSecret;
        $push = json_decode($postStr,true);
        if(!empty($push)){
            $msg=json_decode(urldecode($push['msg']),true);
            //验证sign app_id version等
            $signature = $this->sign($appId, $appSecret, $push['msg']);
            if($push['test'] == false && $push['app_id'] == $appId && $push['sign'] == $signature && $push['type'] == 'TRADE'&& $push['send_count'] == 0){//false-非测试消息 true- 测试消息 ，PUSH 服务会定期通过发送测试消息检查商家服务是否正常 
                // 之后就可以用了，比如拿到价格：
                $user_order_no = $push['id'];//第三方订单号(父订单)
                $m_id = $push['kdt_id'];//店铺id
                $o_goods_all_price = $msg['trade']['total_fee'];//商品总价（商品价格乘以数量的总金额）。单位：元，精确到分
                $o_all_price = $msg['trade']['payment'];//实付金额。单位：元，精确到分
                $post_fee = $msg['trade']['post_fee'];//运费。单位：元，精确到分
                $o_nums = $msg['trade']['num'];//商品购买数量。当一个trade对应多个order的时候，值为所有商品购买数量之和
                $status = $push['status'];//父订单的交易状态
                $pay_type = $msg['trade']['pay_type'];//ALIPAY
                $o_create_time = $msg['trade']['created'];//交易创建时间  
                //推送的字段好多，底下的几个字段还不确定
                $pf_buy_way_str = $msg['trade']['pf_buy_way_str'];//运费到付 
                $buyer_id = $msg['trade']['buyer_id'];//买家ID，当 buyer_type 为 1 时，buyer_id 的值等于 weixin_user_id 的值
                $receiver_name = $msg['trade']['receiver_name'];//张三
                $receiver_mobile = $msg['trade']['receiver_mobile'];//手机号
                $receiver_state = $msg['trade']['receiver_state'];//广东省
                $receiver_city = $msg['trade']['receiver_city'];//广州市 
                $receiver_district = $msg['trade']['receiver_district'];//荔湾区
                $receiver_address = $msg['trade']['receiver_address'];//收货人的详细地址
                $receiver_zip = $msg['trade']['receiver_zip'];//邮编   
                $buyer_message = $msg['trade']['buyer_message'];//买家购买附言                


                    //遍历$msg['trade']['orders']数组
                    $count = count($msg['trade']['orders']);
                    foreach($msg['trade']['orders'] as $key=>$value){

                        $oi_id = $value['oid'];
                        $g_sn = $value['outer_item_id'];//sku编号
                        $goods_info = $this->get_goods_info($g_sn);//根据g_sn查询商品信息
                        //$g_id = $goods_info['g_id'];
                        $g_name = $value['title'];//商品名称
                        $oi_goods_price = $value['total_fee'];//每个子订单的商品总价（商品价格乘以数量的总金额）。单位：元，精确到分
                        //$payment = $value['payment'];//实付金额。单位：元，精确到分
                        $discount_fee = $value['discount_fee'];//交易优惠金额（不包含交易明细中的优惠金额）。单位：元，精确到分
                        $pic_url = $value['pic_thumb_path'];//每个商品的缩略图
                        $oi_price = $value['price'];//单价
                        $oi_num = $value['num'];//每个订单的商品数量
                        $num_iid = $value['num_iid'];//商品数字编号。扣库存或者下架要用到的字段
                        $o_buyer_messages = $value['buyer_messages'][0]['content'];//必须是留言一，才能是18位身份证号码
                        //推送订单是否已存在
                        $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
                        // $orders->startTrans();                
                        $push_id = $orders->where(array('o_sn'=>$oi_id))->find();
                        if($push_id){
                            if($status == "WAIT_SELLER_SEND_GOODS"||$status == "WAIT_GROUP"){//买家已付款
                                $ary_orders['o_pay_status'] = 1;
                                $ary_orders['o_pay_time'] = date('Y-m-d H:i:s');
                                $bool_orders = D('Orders')->where(array('o_sn'=>$oi_id))->data($ary_orders)->save();
                                //商品库存扣除
                                M("GoodsProducts")->where(array("g_sn"=>$g_sn))->setDec("pdt_stock",$oi_num); 

                            }elseif ($status == "WAIT_BUYER_CONFIRM_GOODS") {//等待买家确认收货，即：卖家已发货
                                $ary_orders['o_pay_status'] = 1;
                                $ary_orders['o_audit'] = 1;
                                $ary_orders['erp_status'] = 2;//物流状态
                                $ary_orders['express_status'] = 2;//物流状态
                                $bool_orders = D('Orders')->where(array('o_sn'=>$oi_id))->data($ary_orders)->save();

                            }elseif ($status == "TRADE_BUYER_SIGNED") {//买家已签收
                                $ary_orders['o_pay_status'] = 1;
                                $ary_orders['o_audit'] = 1;
                                $ary_orders['erp_status'] = 2;//物流状态
                                $ary_orders['express_status'] = 2;//物流状态
                                $ary_orders['o_status'] = 4;//已完成 
                                $bool_orders = D('Orders')->where(array('o_sn'=>$oi_id))->data($ary_orders)->save();

                            }elseif ($status == "TRADE_CLOSED") {//付款以后用户退款成功，交易自动关闭
                                $ary_orders['o_pay_status'] = 1;
                                $ary_orders['express_status'] = 0;//物流状态
                                $ary_orders['o_status'] = 2;//物流状态
                                $ary_orders['erp_status'] = 5;//物流状态
                                $ary_orders_items['oi_refund_status'] = 5;//1：正常订单，2:退款中，3退货中,4:退款成功,5退货成功，6：被驳回'
                                $ary_orders_items['oi_update_time'] = date('Y-m-d H:i:s');
                                $bool_orders = D('Orders')->where(array('o_sn'=>$oi_id))->data($ary_orders)->save();
                                $bool_orders_items = D('OrdersItems')->where(array('o_id'=>$oi_id))->data($ary_orders_itmes)->save();
                                M("GoodsProducts")->where(array("g_sn"=>$g_sn))->setInc("pdt_freeze_stock",$oi_num);  

                            }elseif ($status == "TRADE_CLOSED_BY_USER") {//付款以前，卖家或买家主动关闭交易
                                $ary_orders['o_pay_status'] = 0;
                                $ary_orders['o_status'] = 2;//已取消   
                                $bool_orders = D('Orders')->where(array('o_sn'=>$oi_id))->data($ary_orders)->save();                     
                            }

                            //订单表

                            // $ary_orders['o_update_time'] = date('Y-m-d H:i:s');

                            // $bool_orders = D('Orders')->where(array('o_sn'=>$oi_id))->data($ary_orders)->save();

                            //订单详情表    
                            
                            // $bool_orders_items = D('OrdersItems')->where(array('o_id'=>$oi_id))->data($ary_orders_itmes)->save();

                            
                        }else{

                            //写进orders表和orders_item表

                            //收货人
                            $ary_orders['o_receiver_name'] = $receiver_name;
                            // 收货人手机  
                            $ary_orders['o_receiver_mobile'] = $receiver_mobile;
                            // 收货人电话   
                            $ary_orders['o_receiver_telphone'] = $receiver_mobile;        

                            // 收货人省份  
                            $ary_orders['o_receiver_state'] = $receiver_state;
                            // 收货人城市
                            $ary_orders['o_receiver_city'] = $receiver_city;
                            // 收货人地区
                            $ary_orders['o_receiver_county'] = $receiver_district;
                            // 收货人地址              
                            $ary_orders['o_receiver_address'] = $receiver_address; 
                            // 收货人邮编       
                            $ary_orders['o_receiver_zipcode'] = $receiver_zip;              
                            // 留言
                            $ary_orders['o_buyer_comments'] = $buyer_message;
                            //用户id
                            $ary_orders['m_id'] = '7061'; //后期统一填某个管理员的
                            //有赞那里没有提供身份证号码，先不填
                            //$ary_orders['o_receiver_idcard'] = '429004197002221234'; 
                            if(is_numeric($o_buyer_messages)){
                                $ary_orders['o_receiver_idcard'] = $o_buyer_messages;
                            }
                            
                            //$ary_orders['o_receiver_idcard'] = '';
                            // $ary_orders['user_order_num'] = $user_order_no;//varchar(20)
                                    
                            // 订单id
                            // $ary_orders['o_id'] = $order_id = date('YmdHis') . rand(1000, 9999);
                            // $ary_orders['o_sn'] = $order_sn = date('YmdHis') . rand(1000, 9999);
                            //订单类型
                            $ary_orders['o_source_type'] = "youzan";
                            $ary_orders['o_source'] = "youzan";
                            $ary_orders['o_thd_sn'] = $user_order_no;
                            // $ary_orders['o_pay'] = $o_all_price;//订单实付金额
                            // $ary_orders['o_all_price'] = $o_all_price;//订单应付总金额
                            // $ary_orders['o_goods_all_price'] = $o_goods_all_price;//商品总金额,单价X数量

                            // $bool_orders = D('Orders')->doInsert($ary_orders);
                     
                            //遍历$msg['trade']['orders']数组


        //                        交易状态。取值范围：
        //                        TRADE_NO_CREATE_PAY (没有创建支付交易) 
        //                        WAIT_BUYER_PAY (等待买家付款) 
        //                        WAIT_PAY_RETURN (等待支付确认) 
        //                        WAIT_GROUP（等待成团，即：买家已付款，等待成团）
        //                        WAIT_SELLER_SEND_GOODS (等待卖家发货，即：买家已付款) 
        //                        WAIT_BUYER_CONFIRM_GOODS (等待买家确认收货，即：卖家已发货) 
        //                        TRADE_BUYER_SIGNED (买家已签收) 
        //                        TRADE_CLOSED (付款以后用户退款成功，交易自动关闭) 
        //                        TRADE_CLOSED_BY_USER (付款以前，卖家或买家主动关闭交易)

                            if($status == "TRADE_NO_CREATE_PAY" || $status == "WAIT_BUYER_PAY" || $status == "WAIT_PAY_RETURN"){//买家未付款
                                $ary_orders['o_pay_status'] = 0;
                            }    
                            // }elseif ($status == "TRADE_CLOSED_BY_USER") {//付款以前，卖家或买家主动关闭交易
                            //     $ary_orders['o_pay_status'] = 0;
                            //     $ary_orders['o_status'] = 2;//已取消                                                 
                            // }


                            //订单表
                            $ary_orders['order_type'] = $goods_info['g_trade'];
                            // 订单id
                            $ary_orders['o_id'] = date('YmdHis') . rand(1000, 9999);
                            $ary_orders['o_sn'] = $oi_id;
                            $ary_orders['o_cost_freight'] = $post_fee/$count;
                            $ary_orders['o_goods_all_price'] = $oi_goods_price;//商品总金额,单价X数量 
                            $ary_orders['o_all_price'] = $oi_goods_price + $ary_orders['o_cost_freight'];//订单总金额 单价X数量+运费
                            $ary_orders['o_pay'] = $oi_goods_price + $ary_orders['o_cost_freight'] - $discount_fee;//订单实付金额 单价X数量+运费-优惠
                            
                            $ary_orders['o_create_time'] = date('Y-m-d H:i:s');
                            // if($count>1){
                            //     $ary_orders['initial_o_id'] = $user_order_no;
                            // }


                            $bool_orders = D('Orders')->doInsert($ary_orders);

                            //订单详情表    
                            $ary_orders_items['o_id'] = $ary_orders['o_id'];

                            $ary_orders_items['g_id'] = $goods_info['g_id'];

                            $ary_orders_items['gt_id'] = 6;//通用

                            $ary_orders_items['pdt_id'] = $goods_info['pdt_id'];
                  
                            $ary_orders_items['g_sn'] = $goods_info['g_sn'];

                            $ary_orders_items['pdt_sn'] = $goods_info['g_sn'];
                            $ary_orders_items['oi_nums'] = $oi_num;
                                                // 商品名字
                            $ary_orders_items['oi_g_name'] = $g_name;
                                                // 单价
                            $ary_orders_items['oi_price'] = $oi_price;                            
                                                // 成本价
                            $ary_orders_items['oi_cost_price'] = $goods_info['pdt_cost_price'];
                                                // 货品销售原价
                            $ary_orders_items['pdt_sale_price'] = $goods_info['pdt_sale_price'];


                            $bool_orders_items = $this->doInsertOrdersItems($ary_orders_items);



                            //如果存在子订单，那么数据库还要再插一条父订单的数据 1+1 = 3
                            // if($count>1){

                            //     $ary_orders['o_id'] = date('YmdHis') . rand(1000, 9999);
                            //     $ary_orders['o_sn'] = $user_order_no;
                            //     $ary_orders['is_diff'] = '1';
                            //     $ary_orders['o_pay'] = $o_all_price;//订单实付金额
                            //     $ary_orders['o_all_price'] = $o_all_price;//订单应付总金额
                            //     $ary_orders['o_goods_all_price'] = $o_goods_all_price;//商品总金额,单价X数量
                            //     $ary_orders['o_cost_freight'] = $post_fee;
                            //     $ary_orders['initial_o_id'] = '';
                            //     $bool_orders = D('Orders')->doInsert($ary_orders);            

                            // }

                        }

                    }
                
            }
            // 订单日志记录
            $ary_orders_log = array(
                'o_id' => $ary_orders ['o_id'],
                'ol_behavior' => '有赞订单同步成功',
                'ol_uname' => 'youzuan',
                'ol_create' => date('Y-m-d H:i:s')
            );
            D('OrdersLog')->addOrderLog($ary_orders_log); 

        } 

        //返回成功标识
        $Code = array(
        'code' => 0,
        'msg'  => 'success'
        );
        //异步处理
        echo json_encode($Code); 


    }


    /**
     * 插入订单详情数据
     */
    public function doInsertOrdersItems($ary_orders_itmes = array()) {
        $ary_orders_itmes['oi_create_time'] = date('Y-m-d H:i:s');        
        $return_orders_items = M('OrdersItems')->data($ary_orders_itmes)->add();
        return $return_orders_items;
    }



    //根据货号sku获取数据库商品信息
    public function get_goods_info($g_sn){
        $condition = array();
        $condition['gp.g_sn'] = $g_sn;
        $result = M('GoodsInfo')
                ->field('g.g_id,g.g_trade,gi.g_name,gi.g_picture,gi.g_price,gi.extension_spec,gp.pdt_id,gp.g_sn,gp.pdt_stock,gp.pdt_cost_price,gp.pdt_sale_price')
                ->alias('gi')
                ->join('fx_goods g on g.g_id = gi.g_id')
                ->join('fx_goods_products gp on gp.g_id = g.g_id')
                ->where($condition)
                ->find();
        return $result;
    }


    private function sign($appId, $appSecret, $msg) {//防伪签名  ：MD5(appid+msg+appSecrect)
         
        return md5($appId . $msg . $appSecret);
    }
      

}    