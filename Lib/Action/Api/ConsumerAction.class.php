<?php

/* 
 * desc:演示地址
 * author：wangpan
 * date：2016.6.13
 * request_url:http://www.xingyun.com:8080/Api/Consumer/test
 * request_type:POST
 */
class ConsumerAction extends CommonAction {
    
	public function __construct(){
		parent::__construct();
	}


      /**
     * 一、登录生成app_key
     */

    public function get_appkey() {
        
        if(empty($_POST['user_name']) || empty($_POST['password'])) {

            //output_msg(null, array('error_code' => "10011", 'reason' => '用户名或密码不为空'));
            output_datas(null,array('error_code' =>10011,'reason'=>'用户名或密码不为空'));
        } 

        $model_member = D('Members');

        $condition = array();
        $condition['m_name'] = $_POST['user_name'];
        $condition['m_password'] = md5($_POST['password']);
        $member_info = $model_member->where($condition)->find();
         //dump($member_info);exit;
  
        if(!empty($member_info)) {
           
            $token = $this->_get_token($member_info['m_id'], $member_info['m_name'],'api');

            if(!$token) {
                //output_msg(null, array('error_code' => "10012", 'reason' => 'appkey获取失败'));
                output_datas(null,array('error_code' =>10012,'reason'=>'appkey获取失败'));
            }else{
                //output_msg(null, array('error_code' => "0", 'result'=>array('app_key'=>$token), 'reason' => '成功'));
                output_datas(array('app_key'=>$token),array('error_code' =>0,'reason'=>'成功'));
            }

        } else {

            //output_msg(null, array('error_code' => "205801", 'reason' => '用户名密码错误'));
            output_datas(null,array('error_code' =>205801,'reason'=>'用户不存在或密码错误'));
        }

    }  

    private function _get_token($member_id, $member_name, $client) {//(TODO:目前是一刷新就重新生成，需设置token有效期)
        $model_mb_user_token = D('MbUserToken');
     
        //重新登录后以前的令牌失效
        //暂时停用
        $condition = array();
        $condition['member_id'] = $member_id;
        $condition['client_type'] = $client;
        $model_mb_user_token->delMbUserToken($condition);
  
        //生成新的token
        $mb_user_token_info = array();
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0,999999)));
        $mb_user_token_info['member_id'] = $member_id;
        $mb_user_token_info['member_name'] = $member_name;
        $mb_user_token_info['token'] = $token;
        $mb_user_token_info['login_time'] = time();
        $mb_user_token_info['client_type'] = $client;

        $result = $model_mb_user_token->addMbUserToken($mb_user_token_info);

        if($result) {
            return $token;
        } else {
            //output_msg(null, array('error_code' => "10001", 'reason' => '错误的请求KEY'));
            output_datas(null,array('error_code' =>10001,'reason'=>'错误的请求KEY'));
        }

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




    public function test(){

        $url = 'http://www.xingyun.com:8080/Api/Consumer/get_goods_list';
        $post_data['user_name'] = '18825500151';
        $post_data['goodsid'] = '1620';
        $post_data['order_no'] = '201608161422249523';
        //$post_data['order_id'] = '201607071754072337';
        $post_data['key']      = 'b70f93050ef64c1eeb2866d4d7e6ef36';
        $post_data['password'] = '11111111';
        $post_data['category_id'] = '0';
        $post_data['page_index'] = '1';
        $post_data['page_size'] = '5';
        $post_data['update_time'] = '2016-05-20';
        $post_data['accept_name'] = '刘备11';
        $post_data['card_id'] = '330327199309073261';
        // $post_data['post_code'] = '11111111';
        // $post_data['telphone'] = '';
        $post_data['mobile'] = '18825500151';
        $post_data['province'] = '内 蒙 古';
        $post_data['city'] = '荆州';
        $post_data['area'] = '荆州';
        $post_data['address'] = '11111111';
        // $post_data['message'] = '11111111';
        $post_data['goods_no'] = 'MBS03728-Y';
        $post_data['quantity'] = '2';
        //$post_data['goodsid'] = '104';
        $o = "";
        foreach ( $post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url, $post_data);       
        print_r($res);

    }



    public function trimall($str)//删除空格
    {
        $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
        return str_replace($qian,$hou,$str);    
    }


  

      /**
     * 二、增加销售订单
     */
    public function add() {

        // 名称  类型  必填  说明
        // key string  是 应用APPKEY
        // opcode  string  是 操作码，固定值: add 
        // order_id  string  是 订单标识Id(一般是对接方的订单号)
        // user_name string  是 用户名
        // accept_name string  是 收货人姓名
        // card_id string  是 身份证号码
        // post_code string  否 邮政编码
        // telphone  string  否 联系电话
        // mobile  string  是 手机
        // province  string  是 所属区域：省
        // city  string  是 所属区域：市
        // area  string  是 所属区域：区
        // address string  是 收货地址
        // message string  否 订单留言
        // goods_no  string  是 商品货号(SKU)
        // quantity  int 是 订购数量

        $ary_post = $this->_post();

        // if (empty($ary_post)) {
        //     //output_msg(null, array('error_code' => "10010", 'reason' => '请求参数为空'));
        //     output_datas(null,array('error_code' =>10010,'reason'=>'请求参数为空'));
        // }

        $flag = $this->getMbUserTokenInfo($ary_post['user_name'],$ary_post['key']);
        $m_id = $flag['member_id'];
        if(!$flag){
            //output_msg(null, array('error_code' =>'10009', 'reason' => '用户名或appkey不存在'));
                output_datas(null,array('error_code' =>10009,'reason'=>'用户不存在或appkey信息错误'));
        }else{

                //第一步，创建订单          
                $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');

                $orders->startTrans();
            
                 //echo "<pre>";print_r($ary_post);exit;

                // 收货人 
                // $this->isChineseName($ary_post['accept_name']);


                if($ary_post['accept_name'] == ""){
                    output_datas(null,array('error_code' =>205405,'reason'=>'收货人姓名错误'));
                }
                $ary_orders['o_receiver_name'] = $ary_post['accept_name'];
                // 收货人手机 
                if(!preg_match("/^1\d{10}$/",$ary_post['mobile'])){
                    //output_msg(null, array('error_code' => "205407", 'reason' => '手机信息错误'));
                    output_datas(null,array('error_code' =>205407,'reason'=>'手机信息错误'));
                    exit();
                }                
                $ary_orders['o_receiver_mobile'] = $ary_post['mobile'];
                // 收货人电话
                if((isset($ary_post['telphone'])) || $ary_post['telphone']!=""){
                    $ary_orders['o_receiver_telphone'] = $ary_post['telphone'];
                }
                // 收货人邮编
                if((isset($ary_post['post_code'])) || $ary_post['post_code']!=""){
                    $ary_orders['o_receiver_zipcode'] = $ary_post['post_code'];
                }
                // 收货人地址
                if($ary_post['address'] == ""){
                    output_datas(null,array('error_code' =>205409,'reason'=>'收货地址错误'));
                }                
                $ary_orders['o_receiver_address'] = $ary_post['address'];
                // 收货人省份
                if($ary_post['province'] == ""||$ary_post['city']==""||$ary_post['area']==""){
                    output_datas(null,array('error_code' =>205408,'reason'=>'所属省市区错误'));
                } 
                $province_arr = array('北京','天津','河北','山西','内蒙古','辽宁','吉林','黑龙江','上海','江苏','浙江','安徽','福建','江西','山东','河南','湖北','湖南','广东','广西','海南','重庆','四川','贵州','云南','西藏','陕西','甘肃','青海','宁夏','新疆','台湾','香港','澳门','海外','北京市','天津市','河北省','山西省','辽宁省','吉林省','黑龙江省','上海市','江苏省','浙江省','安徽省','福建省','江西省','山东省','河南省','湖北省','湖南省','广东省','广西省','海南省','重庆市','四川省','贵州省','云南省','陕西省','甘肃省','青海省'); 
                if(!in_array($this->trimall($ary_post['province']), $province_arr)){
                    output_datas(null,array('error_code' =>205410,'reason'=>'请检查省份名称是否有误，偏远地区请填简称'));
                }
                $ary_orders['m_id'] = $m_id;
                $ary_orders['o_receiver_state'] = $ary_post['province'];
                // 收货人城市
                $ary_orders['o_receiver_city'] = $ary_post['city'];
                // 收货人地区
                $ary_orders['o_receiver_county'] = $ary_post['area'];
                // 留言
                if((isset($ary_post['message'])) || $ary_post['message']!=""){
                    $ary_orders['o_buyer_comments'] = $ary_post['message'];
                }
                //用戶名 members表 根据用戶名得到用戶id
                $m_id = $this->get_user_id($ary_post['user_name']);

                //$ary_orders['m_id'] = $m_id;  
                // card_id string  
                $this->isIdCard($ary_post['card_id']);
                $ary_orders['o_receiver_idcard'] = $ary_post['card_id'];
                //商家订单号标识 可为空

                $length = strlen($ary_post['order_id']);
                if($length > 50){
                    //output_msg(null, array('error_code' => "205503", 'reason' => '订单编号长度超过20位'));
                    output_datas(null,array('error_code' =>205503,'reason'=>'订单编号长度超过50位'));
                    exit();
                }
                //判断商家订单号是否存在
                $user_order_num = $orders->where(array('user_order_num'=>$ary_post['order_id'],'m_id'=>$m_id))->getfield('user_order_num');
                //echo M()->getlastsql();exit;
                if($user_order_num){
                    output_datas(null,array('error_code' =>205504,'reason'=>'订单编号已存在,请勿重复推送！'));
                    exit();                    
                }
                $ary_orders['user_order_num'] = $ary_post['order_id'];//varchar(20)
                
                // 订单id
                $ary_orders['o_id'] = $order_id = date('YmdHis') . rand(1000, 9999);
                $ary_orders['o_sn'] = $order_sn = date('YmdHis') . rand(1000, 9999);
                //订单类型
                $ary_orders['o_source_type'] = "api";
                $ary_orders['o_source'] = "api";
                $ary_orders['o_thd_sn'] = $order_sn;
                $ary_where['gp.g_sn'] = $ary_post['goods_no'];
                $ary_where['g.g_on_sale'] = "1";//在架
                //第二步，创建订单明细
                $ary_orders_items = array();
                                    // 订单id
                $ary_orders_items ['o_id'] = $ary_orders ['o_id'];

                $ml_id = $this->get_user_level($ary_post['user_name']);
                //网站那里删除了金牌、银牌会员等级1,2，只有钻石等级3和渠道等级4，这里加个判断
                // if($ml_id < 4){
                //    $ml_id = '3';            
                // }
                $ary_where['pmlp.ml_id'] = $ml_id;
                if($ary_post['goods_no'] == ""){
                    output_datas(null,array('error_code' =>205414,'reason'=>'货号不为空'));
                }
                $ary_orders_goods = M('Goods')
                                    ->field('gp.*,gi.*,g.g_trade,g.authority_goods,pmlp.pmlp_price')
                                    ->alias('g')
                                    ->join('fx_goods_products gp on gp.g_id = g.g_id')
                                    ->join('fx_goods_info gi on gi.g_id = gp.g_id')
                                    ->join('fx_product_member_level_price pmlp on pmlp.pdt_id = gp.pdt_id')
                                    ->where($ary_where)
                                    ->find();
                //dump($ary_orders_goods); exit; 
                //echo M()->getlastsql();exit; 

                if(!$ary_orders_goods){
                    //output_msg(null, array('error_code' => "205402", 'reason' => '产品不存在或已下架'));
                    output_datas(null,array('error_code' =>205402,'reason'=>'产品不存在或已下架'));
                    exit();
                } 

                //商品贸易类型order_type
                $ary_orders['order_type'] = $ary_orders_goods['g_trade'];                    
                //dump($ary_orders['order_type']);exit;
                //查询奢侈品购买权限
                $authority = M('Members')->where(array('m_id'=>$m_id))->getfield('authority_goods');
                //dump($authority);exit;
                //dump($ary_orders_goods['authority_goods']);exit;                    
                if($ary_orders_goods['authority_goods'] == '2'){
                    if($authority == '1'){
                        output_datas(null,array('error_code' =>405202,'reason'=>'该产品为奢侈品，您暂无购买权限'));
                        exit();                        
                    }

                }

               
                $ary_orders_items['g_id'] = $ary_orders_goods ['g_id'];

                $ary_orders_items['pdt_id'] = $ary_orders_goods ['pdt_id'];
      
                $ary_orders_items['g_sn'] = $ary_orders_goods ['g_sn'];

                $ary_orders_items['pdt_sn'] = $ary_post['goods_no'];
                $ary_orders_items['oi_nums'] = $ary_post['quantity'];
                                    // 商品名字
                $ary_orders_items['oi_g_name'] = $ary_orders_goods['g_name'];
                                    // 成本价
                $ary_orders_items['oi_cost_price'] = $ary_orders_goods['pdt_cost_price'];
                                    // 货品销售原价
                $ary_orders_items['pdt_sale_price'] = $ary_orders_goods['pdt_sale_price'];
                                    // 购买单价
                //$ml_id = $this->get_user_level($ary_post['user_name']);


                if($ary_orders_goods['pmlp_price'] == '0.000'){
                    $ary_orders_goods['pmlp_price'] = sprintf('%0.2f',$ary_orders_goods['g_price']);
                }
                //$ary_orders_items['oi_price'] = $ary_orders_goods['pmlp_price'];//取会员价


                $mGoodsProducts = D("GoodsProductsTable");
               
                $where = [];
                $where = [
                    "gp.g_sn"=>$ary_post['goods_no'],
                    "pmlp.ml_id"=>$ml_id,
                ];
                $field = "max(pdt_max_num) as max,min(pdt_min_num) as min";
                $goodsRuleInfo = $mGoodsProducts->alias("gp")->join("INNER JOIN fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")->where($where)->field($field)->find();
                //dump($goodsRuleInfo);exit;

                //起发数和每个起发数对应的当前会员价
                $starting_number = M('Goods')
                            ->alias('g')
                            ->field('gp.pdt_id,gp.pdt_min_num,gp.pdt_max_num,pmlp.pmlp_price,gi.g_price')
                            ->join('fx_goods_info gi on gi.g_id = g.g_id')
                            ->join('fx_goods_products gp on gp.g_id = g.g_id')
                            ->join('fx_product_member_level_price pmlp on pmlp.pdt_id = gp.pdt_id')
                            ->join('fx_members_level ml on ml.ml_id = pmlp.ml_id')
                            ->where($ary_where)
                            ->select();            
                //dump($starting_number);exit; 

                
                $mGoods = D("Goods");
                if($mGoods->isRuleGoods($ary_post['goods_no'])){//多起发数
                    foreach($starting_number as $key=>$value){
                            if($ary_post['quantity']>$goodsRuleInfo['max']){
                                output_datas(null,array('error_code' =>205414,'reason'=>'购买数不能大于最大起发数'));
                                
                            }else if($ary_post['quantity']<$goodsRuleInfo['min']){
                                output_datas(null,array('error_code' =>205415,'reason'=>'购买数不能小于最小起发数'));
                                
                            }else{
                                //如果购买数量大于等于最小起发数，小于最大起发数
                                if($ary_post['quantity'] >= $value['pdt_min_num'] && $ary_post['quantity'] <= $value['pdt_max_num']){
                                    if($value['pmlp_price'] == '0.000'){
                                        $ary_orders_items['oi_price'] = $value['g_price'];
                                    }else{
                                        $ary_orders_items['oi_price'] = $value['pmlp_price'];
                                        
                                    }
                                    break;
                                }
                            }
                             
                    }

                }else{
                    $ary_orders_items['oi_price'] = $ary_orders_goods['pmlp_price'];

                }


                //起发数和每个起发数对应的当前会员价
                $starting_number = M('Goods')
                            ->alias('g')
                            ->field('gp.pdt_id,gp.pdt_min_num,gp.pdt_max_num,pmlp.pmlp_price,gi.g_price')
                            ->join('fx_goods_info gi on gi.g_id = g.g_id')
                            ->join('fx_goods_products gp on gp.g_id = g.g_id')
                            ->join('fx_product_member_level_price pmlp on pmlp.pdt_id = gp.pdt_id')
                            ->join('fx_members_level ml on ml.ml_id = pmlp.ml_id')
                            ->where($ary_where)
                            ->select();            
                //dump($starting_number);exit; 
                // foreach($starting_number as $key=>$value){
                //         if($ary_post['quantity']>$goodsRuleInfo['max']){
                //             output_datas(null,array('error_code' =>205804,'reason'=>'购买数不能大于最大起发数'));
                            
                //         }else if($ary_post['quantity']<$goodsRuleInfo['min']){
                //             output_datas(null,array('error_code' =>205804,'reason'=>'购买数不能小于最小起发数'));
                            
                //         }else{
                //             //如果购买数量大于等于最小起发数，小于最大起发数
                //             if($ary_post['quantity'] >= $value['pdt_min_num'] && $ary_post['quantity'] <= $value['pdt_max_num']){
                //                 if($value['pmlp_price'] == '0.000'){
                //                     $ary_orders_items['oi_price'] = $value['g_price'];
                //                 }else{
                //                     $ary_orders_items['oi_price'] = $value['pmlp_price'];
                                    
                //                 }
                //                 break;
                //             }
                //         }
                         
                // }
                //dump($ary_orders_items['oi_price']);exit;
                //计算运费 
                $mCarriageTemplate = D("CarriageTemplate");               
                $postage = $mCarriageTemplate->countCarriage($ary_orders_items['g_sn'],$ary_orders_items['oi_nums'],trim($ary_post['province']));
                $postage = sprintf('%0.2f',$postage);
                $ary_orders['o_cost_freight'] = $postage;
                //优惠券金额
                $coupon = '0.00';
                $o_goods_all_price = sprintf('%0.2f',$ary_orders_items['oi_price'] * $ary_orders_items['oi_nums']);
                $total_all_price = sprintf('%0.2f',$ary_orders_items['oi_price'] * $ary_orders_items['oi_nums'] + $postage - $coupon);

                //第三步：扣款操作（余额或信用账户）+ 日志记录 + 生成支付明细
                
                //如果开启了信用账户就用信用账户支付，信用账户余额不足就提示不给支付。否则使用余额支付
                //orders表 o_payment字段  1->余额 2->支付宝 16->信用账户
                //1.检查用户是否有信用账户且状态为开启(信用账户不能购买类型1->保税商品)
                $M = M('Members');
                $hcwhere = array();
                $hcwhere['m_name'] = $ary_post['user_name'];
                $memberinfo = $M->where($hcwhere)->find();
                if(isset($memberinfo['maxcredit']) && ($memberinfo['ca_status']=='1') && (($memberinfo['m_credit']>=$total_all_price))
                    ){
                    $m_credit = $memberinfo['m_credit'] - $total_all_price;
                    //2.更新信用账户 可用信用余额和已用信用额度
                    $upcredit['m_credit'] = $m_credit;
                    $upcredit['usedcredit'] = $memberinfo['usedcredit'] + $total_all_price;
                    $result = $M->where($hcwhere)->data($upcredit)->save();
                    if($result == false){
                        $ary_orders['o_status'] = '3';//未付款
                        //output_msg(null, array('error_code' => "205804", 'reason' => '信用账户余额不足'));
                        output_datas(null,array('error_code' =>205804,'reason'=>'信用账户余额不足'));
                        exit();
                        // 订单日志记录
                        $ary_orders_log = array(
                            'o_id' => $ary_orders ['o_id'],
                            'ol_behavior' => 'api订单未支付成功',
                            'ol_uname' => $ary_post ['user_name'],
                            'ol_create' => date('Y-m-d H:i:s')
                        );
                        $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                        if (!$res_orders_log) {
                            //output_msg(null, array('error_code' => "205805", 'reason' => '订单日志记录失败'));
                            output_datas(null,array('error_code' =>205805,'reason'=>'订单日志记录失败'));
                            exit();
                        }

                    }else{
                        $ary_orders['o_payment'] = '16';
                        $ary_orders['o_status'] = '1';//已付款
                        $ary_orders['o_pay'] = $total_all_price;//订单实付金额
                        $ary_orders['o_all_price'] = $total_all_price;//订单应付总金额
                        $ary_orders['o_goods_all_price'] = $o_goods_all_price;//商品总金额,单价X数量
                        $ary_orders['o_pay_status'] = '1';//已支付
                        $ary_orders['o_pay_time'] = date('Y-m-d H:i:s');//支付时间
                        // 订单日志记录
                        $ary_orders_log = array(
                            'o_id' => $ary_orders ['o_id'],
                            'ol_behavior' => 'api信用账户支付成功',
                            'ol_uname' => $ary_post ['user_name'],
                            'ol_create' => date('Y-m-d H:i:s')
                        );
                        $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                        if (!$res_orders_log) {
                            //output_msg(null, array('error_code' => "205805", 'reason' => '订单日志记录失败'));
                            output_datas(null,array('error_code' =>205805,'reason'=>'订单日志记录失败'));
                            exit();
                        }
                        //生成支付明细
                        $add_payment_serial ['m_id'] = $this->get_user_id($ary_post['user_name']);
                        $add_payment_serial ['pc_code'] = 'CREDITACCOUNT';
                        $add_payment_serial ['ps_money'] = $total_all_price;
                        $add_payment_serial ['ps_type'] = 0;//0:支付，1:充值
                        $add_payment_serial ['o_id'] = $ary_orders ['o_id'];
                        $add_payment_serial ['ps_status'] = 1;//支付成功
                        $add_payment_serial ['pay_type'] = 0;//全额支付
                        $add_payment_serial ['ps_create_time'] = date('Y-m-d H:i:s');
                        $ary_result = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->add($add_payment_serial);
                        if (false === $ary_result) {
                            M('', '', 'DB_CUSTOM')->rollback();
                            //output_msg(null, array('error_code' => "205807", 'reason' => '生成支付明细失败'));
                            output_datas(null,array('error_code' =>205807,'reason'=>'生成支付明细失败'));
                            exit();
                        }
                        //计入balance_info表
                        $balance_info =array(
                             'o_id' => $ary_orders ['o_id'],
                             'bt_id' => '1',//购物消费
                             'm_id' => $m_id,
                             'single_type'=>'2',//2为用户制单
                             'bi_money' => $total_all_price,
                             'bi_type'=>'1' ,//支出
                             'bi_finance_verify'=>'1',
                             'bi_desc' => '购物消费',
                             'bi_sn' => time(),
                             'bi_create_time' => date("Y-m-d H:i:s"),
                             'bi_payment_time' => date("Y-m-d H:i:s"),
                             'o_payment' => '16'

                         );
                         $ary_result = M('balance_info')->data($balance_info)->add();
                         //dump($ary_result);exit;
                         if(FALSE != $ary_result){
                             $ary_data = array();
                             $str_sn = str_pad($ary_result,6,"0",STR_PAD_LEFT);//单号str_pad(time(),6,"0",STR_PAD_LEFT)
                             $ary_data['bi_sn'] = time() . $str_sn;
                             //下面这条sql语句仅把单号改成自增的
                             $result = M('balance_info')->where(array('bi_id'=>$ary_result))->data($ary_data)->save();
                         }else{
                             //output_msg(null, array('error_code' => "205808", 'reason' => '生成结余款调整信息失败'));
                             output_datas(null,array('error_code' =>205808,'reason'=>'生成结余款调整信息失败'));
                         }
                        //echo M('balance_info')->getLastSql();exit;

                    }
                }else{//余额支付
                    if($memberinfo['m_balance']>=$total_all_price){
                        $m_balance = $memberinfo['m_balance'] - $total_all_price;
                        
                        $upbalance['m_balance'] = $m_balance;
                        $M->where($hcwhere)->data($upbalance)->save();
                        $ary_orders['o_payment'] = '1';
                        $ary_orders['o_status'] = '1';//已付款
                        $ary_orders['o_pay'] = $total_all_price;//订单实付金额
                        $ary_orders['o_all_price'] = $total_all_price;//订单应付总金额
                        $ary_orders['o_goods_all_price'] = $o_goods_all_price;//商品总金额,单价X数量
                        $ary_orders['o_pay_status'] = '1';//已支付
                        $ary_orders['o_pay_time'] = date('Y-m-d H:i:s');//支付时间
                        // 订单日志记录
                        $ary_orders_log = array(
                            'o_id' => $ary_orders ['o_id'],
                            'ol_behavior' => 'api余额支付成功',
                            'ol_uname' => $ary_post ['user_name'],
                            'ol_create' => date('Y-m-d H:i:s')
                        );
                        $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                        if (!$res_orders_log) {
                            //output_msg(null, array('error_code' => "205805", 'reason' => '订单日志记录失败'));
                            output_datas(null,array('error_code' =>205805,'reason'=>'订单日志记录失败'));
                            exit();
                        }

                        //生成支付明细
                        $add_payment_serial ['m_id'] = $this->get_user_id($ary_post['user_name']);
                        $add_payment_serial ['pc_code'] = 'DEPOSIT';
                        $add_payment_serial ['ps_money'] = $total_all_price;
                        $add_payment_serial ['ps_type'] = 0;//0:支付，1:充值
                        $add_payment_serial ['o_id'] = $ary_orders ['o_id'];
                        $add_payment_serial ['ps_status'] = 1;//支付成功
                        $add_payment_serial ['pay_type'] = 0;//全额支付
                        $add_payment_serial ['ps_create_time'] = date('Y-m-d H:i:s');
                        $ary_result = M('payment_serial', C('DB_PREFIX'), 'DB_CUSTOM')->add($add_payment_serial);
                        if (false === $ary_result) {
                            M('', '', 'DB_CUSTOM')->rollback();
                            //output_msg(null, array('error_code' => "205807", 'reason' => '生成支付明细失败'));
                            output_datas(null,array('error_code' =>205807,'reason'=>'生成支付明细失败'));
                            exit();
                        }
                        //计入balance_info表
                        $balance_info =array(
                             'o_id' => $ary_orders ['o_id'],
                             'bt_id' => '1',//购物消费
                             'm_id' => $m_id,
                             'single_type'=>'2',//2为用户制单
                             'bi_money' => $total_all_price,
                             'bi_type'=>'1' ,//支出
                             'bi_finance_verify'=>'1',
                             'bi_desc' => '购物消费',
                             'bi_sn' => time(),
                             'bi_create_time' => date("Y-m-d H:i:s"),
                             'bi_payment_time' => date("Y-m-d H:i:s"),
                             'o_payment' => '1'

                         );
                         $ary_result = M('balance_info')->data($balance_info)->add();
                         //dump($ary_result);exit;
                         if(FALSE != $ary_result){
                             $ary_data = array();
                             $str_sn = str_pad($ary_result,6,"0",STR_PAD_LEFT);//单号str_pad(time(),6,"0",STR_PAD_LEFT)
                             $ary_data['bi_sn'] = time() . $str_sn;
                             //下面这条sql语句仅把单号改成自增的
                             $result = M('balance_info')->where(array('bi_id'=>$ary_result))->data($ary_data)->save();
                         }else{
                             //output_msg(null, array('error_code' => "205808", 'reason' => '生成结余款调整信息失败'));
                             output_datas(null,array('error_code' =>205808,'reason'=>'生成结余款调整信息失败'));
                         }
                        //echo M('balance_info')->getLastSql();exit;


                    }else{
                        $ary_orders['o_status'] = '3';//未付款
                        //output_msg(null, array('error_code' => "205404", 'reason' => '账户余额不足'));
                        output_datas(null,array('error_code' =>205404,'reason'=>'账户余额不足'));
                        exit();
                        // 订单日志记录
                        $ary_orders_log = array(
                            'o_id' => $ary_orders ['o_id'],
                            'ol_behavior' => 'api订单未支付成功',
                            'ol_uname' => $ary_post ['user_name'],
                            'ol_create' => date('Y-m-d H:i:s')
                        );
                        $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                        if (!$res_orders_log) {
                            //output_msg(null, array('error_code' => "205805", 'reason' => '订单日志记录失败'));
                            output_datas(null,array('error_code' =>205805,'reason'=>'订单日志记录失败'));
                            exit();
                        }

                    }
                }


                // 第四步：商品库存扣除
                $goods_products_table = M('GoodsProducts');
                $ary_config = D('SysConfig')->getConfigs("GY_CAHE");
                $good_sale_status = D('Goods')->field(array('g_pre_sale_status'))->where(array('g_id' => $ary_orders_goods ['g_id']))->find();
                if ($good_sale_status ['g_pre_sale_status'] != 1) { // 如果是预售商品不扣库存
                        //查询库存,如果库存数为负数则不再扣除库存
                        $int_pdt_stock =$goods_products_table->field('pdt_stock,pdt_min_num')->where(array('pdt_id'=>$ary_orders_items['pdt_id']))->find();
                        //dump($int_pdt_stock);exit;

                        if(0 >= $int_pdt_stock['pdt_stock']){
                            //output_msg(null, array('error_code' => "205903", 'reason' => '该货品已售完！'));
                            output_datas(null,array('error_code' =>205903,'reason'=>'该货品已售完！'));
                            die();
                        }
                        if($int_pdt_stock['pdt_stock']<$ary_post['quantity']){
                            //output_msg(null, array('error_code' => "205903", 'reason' => '该货品已售完！'));
                            output_datas(null,array('error_code' =>205903,'reason'=>'该货品已售完！'));
                            die();
                        }                                       
                        if($ary_post['quantity'] < $int_pdt_stock['pdt_min_num']){
                            //output_msg(null, array('error_code' => "205411", 'reason' => '购买数量不能小于'.$int_pdt_stock['pdt_min_num']));
                            output_datas(null,array('error_code' => "205411", 'reason' => '购买数量不能小于'.$int_pdt_stock['pdt_min_num']));
                            die();
                        }
                        $array_result = D('GoodsProducts')->UpdateStock($ary_orders_items ['pdt_id'], $ary_post['quantity']);
                        if (false == $array_result ["status"]) {
                            $orders->rollback();
                            die();
                        }
                }
                                
                $bool_orders_items = $this->doInsertOrdersItems($ary_orders_items);

                if (!$bool_orders_items) {
                    $orders->rollback();
                    //output_msg(null, array('error_code' => "205806", 'reason' => '订单明细新增失败'));
                    output_datas(null,array('error_code' =>205806,'reason'=>'订单明细新增失败'));
                    exit();
                }

                $bool_orders = D('Orders')->doInsert($ary_orders);

                //echo D('Orders')->getlastsql();
                // $bool_orders = true;
                if (!$bool_orders) {
                    $orders->rollback();
                    //output_msg(null, array('error_code' => "205901", 'reason' => '下单失败'));
                    output_datas(null,array('error_code' =>205901,'reason'=>'下单失败'));
                    exit();
                } 


                      
                $orders->commit();
            
                //output_msg(null, array('error_code' => 0, 'result' => array('order_id'=>$ary_post['order_id'], 'order_no'=>$order_id), 'reason' => '成功'));
                output_datas(array('order_id'=>$ary_post['order_id'], 'order_no'=>$order_id, 'total_all_price'=>$total_all_price, 'freight'=>$postage),array('error_code' =>0,'reason'=>'成功'));

        }    
    } 

      /**
     * 三、查询订单状态 
     */
    public function get_status(){

        // key string  是   应用APPKEY
        // opcode  string  是   操作码，固定值: get_status
        // user_name   string  是   用户名
        // order_no    string  是   订单编号

        // 返回参数说明： 
        // 名称  类型  说明
        // error_code  int 返回码
        // reason  string  返回说明
        // result  string  返回结果集
        // status  int 订单状态
        $ary_post = $this->_post();

        // if (empty($ary_post)) {
        //     //output_msg(null, array('error_code' => "10010", 'reason' => '请求参数为空'));
        //     output_datas(null,array('error_code' =>10010,'reason'=>'请求参数为空'));
        // }
        $flag = $this->getMbUserTokenInfo($ary_post['user_name'],$ary_post['key']);
        if(!$flag){
  
            output_datas(null,array('error_code' =>10009,'reason'=>'用户不存在或appkey信息错误'));
        }else{

            $ary_where = array();  
            $orders = M('orders', C('DB_PREFIX'), 'DB_CUSTOM');
            //用戶名 members表 根据用戶名得到用戶id
            $m_id = $this->get_user_id($ary_post['user_name']);

            $ary_where['m_id'] = $m_id;      
            $ary_where['o.o_id'] = $ary_post['order_no'];
                 
            $ary_orders_info = $orders
            ->field('oi.g_id,oi.oi_g_name,oi.oi_price,o.o_receiver_name,o.o_status,oi.oi_refund_status,o.o_audit,o.express_status,o.o_pay_status,o.express,o.express_no,o.o_all_price,o.erp_status')
            ->alias('o')
            ->join('fx_orders_items oi on oi.o_id = o.o_id')
            ->where($ary_where)
            ->find();
            //echo M()->getlastsql();exit;
            //dump($value);exit;
            if(!$ary_orders_info){

              output_datas(null,array('error_code' =>205502,'reason'=>'订单不存在')); 
            }

            if($ary_orders_info['express_status'] == '2' && $ary_orders_info['o_audit'] == '1'){

                $str_orders_status = '已发货';//
                $code = '205203'; 
            }else if($ary_orders_info['o_pay_status'] == '0'){

                $str_orders_status = '待付款';//
                $code = '205209';                
            }else if($ary_orders_info['oi_refund_status'] != '1'){

                $str_orders_status = '退款/退货';
                $code = '205702';                
            }else if($ary_orders_info['o_status'] == '4'){

                $str_orders_status = '已完成';
                $code = '205301';                
            }else if($ary_orders_info['o_pay_status'] == '1' && $ary_orders_info['o_audit'] == '0'){

                $str_orders_status = '已付款';
                $code = '205102';

            }else if($ary_orders_info['express_status'] == '3' && $ary_orders_info['o_audit'] == '1'){

                $str_orders_status = '通关中';
                $code = '205202';                
            }else if($ary_orders_info['o_status'] == '2'){

                $str_orders_status = '已取消';
                $code = '205601';                
            }else{
                $str_orders_status = '未发货';
                $code = '205201';  

            }

            // if( $value['o_status'] != 2 ) {
            //     if( $value['o_pay_status'] == 0) {
                    
            //         $str_orders_status = '待付款';
            //         $code = '205209';

            //     }elseif($value['o_pay_status'] == 3){
            //         $str_orders_status = '部分支付';
                    
            //     }else{
            //           if( $value['o_audit'] == 0){
            //                  $str_orders_status = '待确认';
            //                  $code = '205102';
            //           }else{
            //                 if( $value['express_status'] == 3){
            //                         $str_orders_status = '通关中'; 
            //                         $code = '205202'; 
            //                 }else if($value['express_status'] == 2){
            //                         $str_orders_status = '待收货';
            //                         $code = '205203';  
            //                     if ($value['o_status'] == 4) {
            //                         $str_orders_status = '已完成'; 
            //                         $code = '205301';
            //                     }
            //                     // else{
            //                     //     $ary_orders_info[$key]['r_status'] = "6";//待确认 
            //                     // }    
            //                 }else{
            //                     // if ($value['o_status'] == 4) {
            //                     //     $ary_orders_info[$key]['r_status'] = "5";//已完成  
            //                     // }else{
            //                         $str_orders_status = '待确认'; //待确认（其实是已确认，但app端没有 已确认 这个状态）
            //                         $code = '205102'; 
            //                     // }    
            //                 }
            //           }

            //    }
            // }elseif($value['o_status'] == '2' && $value['erp_status'] == '5'){
              
            //     $str_orders_status = '异常订单';//异常订单

            // }else{
            //     $str_orders_status = '已取消';//已取消
            // }





            //output_msg(null, array('error_code' =>$code, 'result'=>array('status' => 1), 'reason' => '查询成功'));
                    output_datas(array('status' => $str_orders_status,'express_no'=>$ary_orders_info['express_no'],'express_cpy'=>
                        $ary_orders_info['express'],'order_price'=>$ary_orders_info['o_all_price']),array('error_code' =>$code,'reason'=>'查询成功'));
        }    

    }

 


      /**
     * 四、获取产品类别 
     */
    public function get_category_list(){

        // 请求参数说明： 
        // 名称  类型  必填  说明
        // key string  是   应用APPKEY
        // opcode  string  是   操作码，固定值: get_category_list 
        // user_name   string  是   用户名

        // 返回参数说明： 
        // 名称  类型  说明
        // error_code  int 返回码
        // reason  string  返回说明
        // result  string  返回结果集
        // status  int 状态
        $ary_post = $this->_post();
        // if (empty($ary_post)) {
        //     //output_msg(null, array('error_code' => "10010", 'reason' => '请求参数为空'));
        //     output_datas(null,array('error_code' =>10010,'reason'=>'请求参数为空'));
        // }
        $flag = $this->getMbUserTokenInfo($ary_post['user_name'],$ary_post['key']);
        if(!$flag){
            //output_msg(null, array('error_code' =>'10009', 'reason' => '用户名或appkey不存在'));
            output_datas(null,array('error_code' =>10009,'reason'=>'用户不存在或appkey信息错误'));
        }else{
            
            $ary_category = D('Gyfx')->selectAllCache('goods_category',$ary_field='gc_id,gc_name', $where='', 'gc_id ASC',$ary_group=null);
            
            foreach($ary_category as &$value){

                $child_ids = M('GoodsCategory')->field('gc_id,gc_name')->where('gc_parent_id ='. $value['gc_id'])->select(); 
                //如果数组为空，不返回null而是[],防止app端崩溃
                if(empty($child_ids)){
        
                    $child_ids = array();
                }
                //把$child_ids数组存到$ary_category里面
                $value['childList'] = $child_ids;


            }
            //dump($ary_category);exit;
 
            output_datas($ary_category,array('error_code' =>0,'reason'=>'查询成功'));
        }

    }


    //获取指定分类的父ID号
    public function getNavPid($id){
        $nav = M('GoodsCategory')->find($id);
        if($nav['gc_parent_id'] != 0){ return $this->getNavPid($nav['gc_parent_id']); }
        return $nav['gc_id'];
    }

    //获取指定分类的分类名
    public function getName($id){
        $nav = M('GoodsCategory')->find($id);
        return $nav['gc_name'];
    }

    //获取指定分类的所有子分类
    public function getCateIds($pid){
        
        $cate_list = M('GoodsCategory')->where('gc_id ='. $pid)->find();
        if($cate_list['gc_is_parent'] == '0'){//说明没有子类
            return $pid;
        } 

        //dump($cate_list);exit;

        $need_list = M('GoodsCategory')->where('gc_parent_id ='. $pid)->select();//获取到的一级分类 
       //dump($need_list);
       //echo M()->getlastsql();
        $need_id_str = ''; //获取需要的子类id
        foreach($need_list as $val){
            $need_id[] = $val['gc_id'];
        } 
        $need_id_str = join(',', $need_id);

        $where = "gc_parent_id in ($need_id_str)";
        $products = M('GoodsCategory')->field('gc_id')->where($where)->select(); 
        //dump($products);exit;
        //echo M('GoodsCategory')->getlastsql();exit;
        if(!$products){
            return $need_id_str;
        }else{
            foreach($products as $val){
                $need_ids[] = $val['gc_id'];
            } 
            $need_id_strs = join(',', $need_ids);                
            return $need_id_strs;
        }
    }



      /**
     * 五、获取产品列表 
     */
    public function get_goods_list(){

        // key string  是 应用APPKEY
        // opcode  string  是 操作码，固定值: get_category_list 
        // update_time date  是 产品列表更新时间（同步时间）
        // user_name string  是 用户名
        // category_id int 是 产品类别编号
        // page_size int 是 每页显示多少条
        // page_index  int 是 页码
        
        $ary_post = $this->_post();

        // if (empty($ary_post)) {
        //     //output_msg(null, array('error_code' => "10010", 'reason' => '请求参数为空'));
        //     output_datas(null,array('error_code' =>10010,'reason'=>'请求参数为空'));
        // }
        $flag = $this->getMbUserTokenInfo($ary_post['user_name'],$ary_post['key']);
        if(!$flag){
            //output_msg(null, array('error_code' =>'10009', 'reason' => '用户名或appkey不存在'));
            output_datas(null,array('error_code' =>10009,'reason'=>'用户不存在或appkey信息错误'));
        }else{ 

            // $this->_get_appkey($ary_post['user_name']);

            // if(!preg_match("/^((?:19|20)\d\d)-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/",$ary_post['update_time'])){
            //     //output_msg(null, array('error_code' => "305501", 'reason' => '日期格式不正确'));//规定格式2016-06-01
            //     output_datas(null,array('error_code' =>305501,'reason'=>'日期格式不正确'));
            //     exit();
            // } 
            //数据库日期格式是2016-06-01 00:00:00，与目标接收过来的格式2016-06-01不一致，需转换，得出产品列表同步时间
            // $start_time = date('Y-m-d H:i:s' ,strtotime($ary_post['update_time']));//如2016-06-01 00:00:00
            // $end_time = date('Y-m-d H:i:s' ,strtotime($ary_post['update_time'].'+23 hour +59 minute +59 second'));//如2016-06-01 23:59:59
               
                //dump($ary_post['update_time']);exit;

            if((!isset($ary_post['category_id'])) || $ary_post['category_id'] ==""){
                //output_msg(null, array('error_code' => "305301", 'reason' => '分类id为空'));
                output_datas(null,array('error_code' =>305301,'reason'=>'分类id为空'));
            }else{
                //获取到商品类型用到的所有属性
                $obj = M('goods as `g` ', C('DB_PREFIX'), 'DB_CUSTOM');
                //join查询
                $join_where = array();
                $ary_where = array();
                $join_where[] = '`fx_goods_info` `gi` on(`g`.`g_id` = `gi`.`g_id`)';
                $join_where[] = '`fx_goods_type` `gt` on(`g`.`gt_id` = `gt`.`gt_id`)';
                $join_where[] = '`fx_nationality` `na` on(`g`.`country_origin` = `na`.`n_id`)';
                $join_where[] = '`fx_related_goods_category` `rgc` on(`g`.`g_id` = `rgc`.`g_id`)';
                $join_where[] = '`fx_goods_category` `gc` on(`rgc`.`gc_id` = `gc`.`gc_id`)';
                $join_where[] = '`fx_goods_brand` `gb` on(`gb`.`gb_id` = `g`.`gb_id`)';
                
                //如果请求分类id为0，获取全部
                if($ary_post['category_id'] == 0){
                    $ary_where = "";
                }else{

                $ids = $this->getCateIds($ary_post['category_id']);
                //dump($ids);exit;
                //$category_name = $this->getName($category_id);
                $ary_where['gc.gc_id'] = array('in',$ids);

                    //$ary_where['rgc.gc_id'] = $ary_post['category_id'];
                    if((isset($ary_post['update_time'])) || $ary_post['update_time']!=""){
                        // $ary_where['g.g_update_time'] = array(between,array($start_time,$end_time)); 
                            $ary_where['g.g_update_time'] = array('EGT',$ary_post['update_time']);


                    }
                }
                $ml_id = $this->get_user_level($ary_post['user_name']);
                $ary_where['pmlp.ml_id'] = $ml_id;
                // $ary_where['g.g_on_sale'] = '1';//在架
                // $ary_where['g.g_status'] = '1';//数据记录状态，0为废弃，1为有效，2为进入回收站
                $ary_where['g.g_on_sale'] = array('neq',3);
                //查询字段
                $ary_fields = "g.g_id,g.g_trade,g.number_least,g.g_on_sale,gb.gb_name,g.g_update_time,gi.g_name,gi.g_cname,gi.extension_spec,gi.g_price,gi.g_market_price,gi.g_picture,gi.g_weight,gi.g_unit,na.n_name,gp.g_sn,gp.pdt_stock,gp.pdt_min_num,rgc.gc_id,gc.gc_name,pmlp.pmlp_price";
          
                // $count = $obj->field($ary_fields)
                // ->join($join_where)
                // ->join("fx_goods_products as gp ON gp.g_id = g.g_id")                
                // ->where($ary_where)
                // ->count();
                //dump($count);exit;
                $page_index = $ary_post['page_index'];  
                $page_size = $ary_post['page_size']; 
                if(!isset($page_index)){
                   
                    output_datas(null,array('error_code' =>305101,'reason'=>'请输入页码'));
                }
                if(!isset($page_size)){
                    
                    output_datas(null,array('error_code' =>305201,'reason'=>'请输入每页显示条数'));
                }

                //$obj_page = new Page($count, $page_size);

                $offset = ($page_index-1) * $page_size;//获取limit的第一个参数的值 offset ，假如第一页则为(1-1)*10=0,第二页为(2-1)*10=10。             (传入的页数-1) * 每页的数据 得到limit第一个参数的值
                 //假如传入的页数参数 大于总页数，则显示错误信息$pagenum=ceil($total/$num);      //获得总页数 pagenum
                $pagenum = ceil($count/$page_size);
                //dump($pagenum);exit;
                // if($page_index>$pagenum || $page_index == 0){

                //         output_datas($result,array('error_code' =>305402,'reason'=>'传入页码不合理或超过总页数'));

                // }


                $result = $obj->field($ary_fields)
                ->join($join_where)
                ->join("fx_goods_products as gp ON gp.g_id = g.g_id")
                ->join("fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")                                
                ->where($ary_where)
                ->order('g.g_update_time desc')
                ->group('g.g_id')
                //->distinct('g.g_id')
                ->limit($offset . ',' . $page_size)
                ->select();
                //echo $obj->getlastsql();exit;
                //dump($result);exit;
                // if(!$result){
                //     output_msg(null, array('error_code' => "305401", 'reason' => '分类id不存在'));
                // }


                //$ml_id = $this->get_user_level($ary_post['user_name']);
                //dump($ml_id);exit; 


                foreach ($result as $key=>$value) {
                    $result[$key]['pdt_sn'] = $value['g_sn'];
                    $result[$key]['number_least'] = $value['pdt_min_num'];
                    $result[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];
                    if($value['pdt_min_num'] == '0'){
                        $result[$key]['number_least'] = '1';
                    }
                    if($value['pmlp_price'] == '0.000'){
                        $result[$key]['pmlp_price'] = sprintf('%0.2f',$value['g_price']);
                    }else{
                        $result[$key]['pmlp_price'] = sprintf('%0.2f',$value['pmlp_price']);
                    }                    

                }
                //dump($result);exit;
                if(empty($result)){
        
                    $result = array();
                }

                //output_msg(null, array('error_code' => 0, 'reason' => '成功' ,'status' => 1 ,'goodslist' => $result)); 
                output_datas($result,array('error_code' =>0,'reason'=>'查询成功'));


            }
        }
       
        

    }




      /**
     * 六、获取产品详情 
     */
    public function goods_show(){

        // key string  是   应用APPKEY
        // opcode  string  是   操作码，固定值: goods_show
        // user_name   string  是   用户名
        // id_type string  否   goodsid类型,默认为产品ID,
        // goodsid Int 是   产品编号

        // 返回参数说明： 
        // 名称  类型  说明
        // error_code  int 返回码
        // reason  string  返回说明
        // result  string  返回结果集
        // status  int 状态
        $ary_post = $this->_post();

        // if (empty($ary_post)) {
        //     //output_msg(null, array('error_code' => "10010", 'reason' => '请求参数为空'));
        //     output_datas(null,array('error_code' =>10010,'reason'=>'请求参数为空'));
        // }
        $flag = $this->getMbUserTokenInfo($ary_post['user_name'],$ary_post['key']);
        if(!$flag){
            //output_msg(null, array('error_code' =>'10009', 'reason' => '用户名或appkey不存在'));
            output_datas(null,array('error_code' =>10009,'reason'=>'用户不存在或appkey信息错误'));
        }else{
            
            if(empty($ary_post['goodsid'])){
                //output_msg(null, array('error_code' => "405101", 'reason' => '商品id为空'));
                output_datas(null,array('error_code' =>405101,'reason'=>'商品id为空'));
            }else{
                //获取到商品类型用到的所有属性
                $obj = M('goods as `g` ', C('DB_PREFIX'), 'DB_CUSTOM');
                //join查询
                $join_where = array();
                $ary_where = array();
                $join_where[] = '`fx_goods_info` `gi` on(`g`.`g_id` = `gi`.`g_id`)';
                $join_where[] = '`fx_goods_type` `gt` on(`g`.`gt_id` = `gt`.`gt_id`)';
                $join_where[] = '`fx_nationality` `na` on(`g`.`country_origin` = `na`.`n_id`)';
                $join_where[] = '`fx_related_goods_category` `rgc` on(`g`.`g_id` = `rgc`.`g_id`)';
                $join_where[] = '`fx_goods_category` `gc` on(`rgc`.`gc_id` = `gc`.`gc_id`)';
                $join_where[] = '`fx_goods_brand` `gb` on(`gb`.`gb_id` = `g`.`gb_id`)';
                $ary_where['g.g_id'] = $ary_post['goodsid'];
                $ml_id = $this->get_user_level($ary_post['user_name']);
                $ary_where['pmlp.ml_id'] = $ml_id; 
                // $ary_where['g.g_on_sale'] = '1';//在架
                // $ary_where['g.g_status'] = '1';//数据记录状态，0为废弃，1为有效，2为进入回收站
                $ary_where['g.g_on_sale'] = array('neq',3);
                //查询字段
                $ary_fields = "g.g_trade,g.number_least,g.g_on_sale,g.Shelf_time,g.Shelf_time_end,gb.gb_name,gi.g_name,gi.g_cname,gi.extension_spec,gi.g_price,gi.g_picture,gi.g_weight,gi.g_unit,na.n_name,gp.g_sn,gp.pdt_stock,gp.pdt_max_num,gp.pdt_min_num,pmlp.pmlp_price,rgc.gc_id,gc.gc_name,wh.c_name";

                $result = $obj->field($ary_fields)
                ->join($join_where)
                ->join("fx_goods_products as gp ON gp.g_id = g.g_id")
                ->join("fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")
                ->join('fx_warehouses wh on wh.c_id = g.g_point_origin')
                ->where($ary_where)
                ->order()
                ->find();
                           
                //echo $obj->getlastsql();
                //dump($result);
                if(empty($result['c_name'])){//发货仓
                    $result['c_name'] = "其他仓";
                }
                // if(empty($result)){
                //    //output_msg(null, array('error_code' => "405201", 'reason' => '商品id不存在')); 
                //    output_datas(null,array('error_code' =>405201,'reason'=>'商品id不存在'));
                // }
                switch ($result['g_trade']) {
                    case '1' :
                        $g_trade = '保税';
                        break;
                    case '2' :
                        $g_trade = '直邮';
                        break;
                    case '0' :
                        $g_trade = '普通';
                        break;                              
                } 
         

                if($result['pmlp_price'] == '0.000'){
                    $result['pmlp_price'] = sprintf('%0.2f',$result['g_price']);
                }else{
                    $result['pmlp_price'] = sprintf('%0.2f',$result['pmlp_price']);
                }  
                if($result['pdt_min_num'] == '0'){//以免出现最小起发数为0的情况
                    $result['pdt_min_num'] = '1';
                }
                //起发数和每个起发数对应的当前会员价
                $starting_number = M('Goods')
                            ->alias('g')
                            ->field('gp.pdt_id,gp.pdt_min_num,gp.pdt_max_num,pmlp.pmlp_price,gi.g_price')
                            ->join('fx_goods_info gi on gi.g_id = g.g_id')
                            ->join('fx_goods_products gp on gp.g_id = g.g_id')
                            ->join('fx_product_member_level_price pmlp on pmlp.pdt_id = gp.pdt_id')
                            ->join('fx_members_level ml on ml.ml_id = pmlp.ml_id')
                            ->where($ary_where)
                            ->select();            
                //dump($starting_number);exit; 
                foreach($starting_number as $key=>$value){

                    if($value['pmlp_price'] == '0.000'){
                        $starting_number[$key]['pmlp_price'] = sprintf('%0.2f',$value['g_price']);//价格保留两位小数
                    }else{
                        $starting_number[$key]['pmlp_price'] = sprintf('%0.2f',$value['pmlp_price']);//价格保留两位小数
                    }
                    if($value['pdt_min_num'] == '0'){//以免出现最小起发数为0的情况
                        $starting_number[$key]['pdt_min_num'] = '1';
                    }                
                         
                } 
                $result['pdt_sn'] = $result['g_sn'];
                $result['starting_number'] = $starting_number;//起发数价格数组
                $result['number_least'] = $result['pdt_min_num'];
                if($result['pdt_min_num'] == '0'){//以免出现最小起发数为0的情况
                    $result['number_least'] = '1';
                }
                $result['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$result['g_picture'];
                //dump($result);exit;     
                output_datas($result,array('error_code' =>0,'reason'=>'成功'));


            }

        }
           

    }    

    /**
     * 插入订单详情数据
     */
    public function doInsertOrdersItems($ary_orders_itmes = array()) {
        $ary_orders_itmes['oi_create_time'] = date('Y-m-d H:i:s');        
        $return_orders_items = M('OrdersItems')->data($ary_orders_itmes)->add();
        return $return_orders_items;
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
     * 根据用戶名得到用戶会员等级
     */
    public function get_user_level($user_name) {

        $map = array();
        $map['m_name'] = $user_name;
        $ml_id = M('Members')->where($map)->getfield('ml_id');
        return $ml_id; 
    }

    /**
     * 登录验证，配对appkey
     */
     public function getMbUserTokenInfo($user_name,$token) {
        $map = array();
        $map['member_name'] = $user_name;
        $map['token'] = $token;
        return D('MbUserToken')->where($map)->find();
        //设置token过期时间
        // $map = array();
        // $map['member_name'] = $user_name;
        // $map['token'] = $token;
        // $mb_user_token_info = D('MbUserToken')->where($map)->find();
        // $login_time = $mb_user_token_info['login_time'];
        // $timestamp = (string)time();
        // if(ceil(($timestamp - $login_time)/86400) > 7){ 
        //     output_datas(null,array('error_code' =>10000,'reason'=>'token已失效，请重新获取！'));
        // }
        // return $mb_user_token_info;

    }


    // public function isIdCard($number) {
    //     if(strlen($number)>18){
    //         output_datas(null,array('error_code' =>205406,'reason'=>'身份证信息错误'));
    //     }
    //     //加权因子 
    //     $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //     //校验码串 
    //     $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    //     //按顺序循环处理前17位 
    //     for ($i = 0;$i < 17;$i++) { 
    //         //提取前17位的其中一位，并将变量类型转为实数 
    //         $b = (int) $number{$i}; 
     
    //         //提取相应的加权因子 
    //         $w = $wi[$i]; 
     
    //         //把从身份证号码中提取的一位数字和加权因子相乘，并累加 
    //         $sigma += $b * $w; 
    //     }
    //     //计算序号 
    //     $snumber = $sigma % 11; 
     
    //     //按照序号从校验码串中提取相应的字符。 
    //     $check_number = $ai[$snumber];
     
    //     if ($number{17} == $check_number) {
    //         return true;
    //     } else {
    //         //output_msg(null, array('error_code' => "205406", 'reason' => '身份证信息错误'));
    //         output_datas(null,array('error_code' =>205406,'reason'=>'身份证信息错误'));
    //     }
    // }



    public function isIdCard($number) {
        if(strlen($number)>18){
            output_datas(null,array('error_code' =>205406,'reason'=>'身份证信息错误'));
        }
        
        if (preg_match('/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([\d|X|x])$/', $number)) {
            return true;
        } else {
            //output_msg(null, array('error_code' => "205405", 'reason' => '收货人姓名错误'));
            output_datas(null,array('error_code' =>205406,'reason'=>'身份证信息错误'));
            
        }


    }


    public function isChineseName($name){
        if (preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $name)) {
            return true;
        } else {
            //output_msg(null, array('error_code' => "205405", 'reason' => '收货人姓名错误'));
            output_datas(null,array('error_code' =>205405,'reason'=>'收货人姓名错误'));
        }
    }


}

