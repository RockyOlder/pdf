<?php

class MembersAction extends MobileAction {
    
    
    public function pageDepositWithdraw(){
        
        
        $ary_member= $this->_post();
  
        //$ary_post['bi_withdrawal']  = $ary_member['get_type'];
        //$ary_post['accountName']  = $ary_member['accountName'];//银行账号和用户名暂时不需要
        //$ary_post['bi_accounts_receivable']  = $ary_member['account'];
        $ary_post['bi_money']  = $ary_member['tx_money'];
        $ary_post['pay_password']  = $ary_member['pay_password'];
        //$ary_post['pay_password']
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_member['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $condition = array();
        $condition['m_id'] = $m_id;
        $members = M("Members")->where($condition)->find();

        //$members  = M('members', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('m_id' => $this->member_info['m_id']))->find();
        // $freeze_balance_total = $members['freeze_balance'] + $ary_post['bi_money'];
        $freeze_balance_total = $ary_post['bi_money'];//提现中的金额
        if(empty($members['pay_password']))
        {
            output_datas(null,array('error_code'=>60016,'result' =>"1",'desc'=>'支付密码为空'));
        }
        
        if($members['pay_password'] != md5($ary_post['pay_password']))
        {
            output_datas(null,array('error_code'=>60017,'result' =>"1",'desc'=>'支付密码错误,请重新输入'));
        }
        if($freeze_balance_total>0){        
            if($freeze_balance_total > $members['m_balance'] )
            {
                output_datas(null,array('error_code'=>60018,'result' =>"1",'desc'=>'提现的金额不能大于余额'));
            }
        } 
        if(!empty($ary_post) && is_array($ary_post)){
            $balanceObj = D("BalanceInfo");
            $balanceObj->startTrans();
            $ary_post['bi_sn'] = time();
            $ary_post['bt_id'] = '4';//提现
            $ary_post['bi_type'] = '1';//调整类型：0为收入，1为支出，2为冻结
            $ary_post['single_type'] = '2';//制单类型：1.系统管理员制单，2.用户制单
            $ary_post['u_id'] = $members['m_id'];
            $ary_post['m_id'] = $members['m_id'];
            $ary_post['bi_create_time'] = date("Y-m-d H:i:s");
            $ary_post['bi_payment_time'] = date("Y-m-d H:i:s");
            $ary_post['bi_desc'] = '余款提现';
            $ary_post['bi_withdrawal'] = "1";
//            if(!empty($ary_post['bi_poundage']))
//            {
//                $ary_post['bi_money'] = $ary_post['bi_money'] -  $ary_post['bi_poundage'];
//            }
            
            $ary_result = $balanceObj->add($ary_post);
            if(FALSE != $ary_result){
                $ary_data = array();
                $str_sn = str_pad($ary_result,6,"0",STR_PAD_LEFT);
                $ary_data['bi_sn'] = time() . $str_sn;
                $result = $balanceObj->where(array('bi_id'=>$ary_result))->data($ary_data)->save();
                if(!$result){
                    $balanceObj->rollback();
                    $this->error("操作失败");
                }else{
                    D("Members")->where(array('m_id'=>$members['m_id']))->data(array('freeze_balance'=>$members['freeze_balance'] + $ary_post['bi_money']))->save();
                    $balanceObj->commit();
                    output_datas(null,array('result' =>"0",'desc'=>'申请提现成功，我们将根据您的实际情况，在3个工作日内把资金转入您相应的账户中！'));
                }
            }else{
                $balanceObj->rollback();
                output_datas(null,array('result' =>"1",'desc'=>'操作失败'));
            }
        }else{
             output_datas(null,array('result' =>"1",'desc'=>'数据有误,请重新输入'));
        }
    }
    public function pageDepositList(){
        
            $p= $this->_get("p");
            //查询个人信息
            $token_id = $this->_get("token");
            $model_mb_user_token = D('MbUserToken');
            $token = $model_mb_user_token->getMbUserTokenInfoByToken($token_id);
            //dump($token);exit;
            if(!$token){
                output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
            }
            $m_id = $token['member_id'];
            $condition = array();
            $condition['m_id'] = $m_id;
            $member_info = M("Members")->where($condition)->find();

            $array_cond['fx_balance_info.bi_finance_verify'] = 1 ;
            $array_cond["fx_balance_info.m_id"] = $this->member_info['m_id'];
            $array_cond["fx_balance_info.bi_money"] = array('neq','0');        
            $int_count = D("BalanceInfo")
            ->join('fx_orders on fx_orders.o_id=fx_balance_info.o_id')
            ->join('fx_payment_cfg on fx_orders.o_payment=fx_payment_cfg.pc_id')
            ->where($array_cond)
            ->count();
            $pageObj = new Page($int_count,20);
            if($p > $pageObj->totalPages)
            {
                 output_datas(array(),array('result' =>"0",'desc'=>'查询成功！'));
            }
            $string_limit = $pageObj->firstRow . ',' . $pageObj->listRows;
            $array_balance_info = D("BalanceInfo")
            ->field('fx_payment_cfg.pc_custom_name,fx_orders.o_payment,fx_orders.o_all_price,fx_balance_info.*')
            ->join('fx_orders on fx_orders.o_id=fx_balance_info.o_id')
            ->join('fx_payment_cfg on fx_orders.o_payment=fx_payment_cfg.pc_id')
            ->where($array_cond)
            ->order(array("bi_create_time"=>'desc'))
            ->limit($string_limit)->select();
            //dump($array_balance_info);exit;
            foreach($array_balance_info as $kk=>$vv){
                
                   //增加一个提现的状态，处理中和已打款
                if($vv['bt_id'] == '4'){
                    if($vv['bi_withdrawal'] == '1'){
                        $array_balance_info[$kk]['withdrawal'] = '处理中';
                    }else{
                        $array_balance_info[$kk]['withdrawal'] = '已打款';
                    }
                }else{
                    $array_balance_info[$kk]['withdrawal'] = '';
                }             
            }            
            $item =array();
            //echo date('m', strtotime('2016-06-24'));
            foreach($array_balance_info as $k=>$v){
                for($i = 1;$i<=12;$i++){
                    if(date('m', strtotime($v['bi_create_time'])) == $i){
                        $item[$i]['month'] = (string)$i; //月份
                        $item[$i]['year'] = date('Y', strtotime($v['bi_create_time']));//年份
                        $item[$i]['details'][] = $v;//详情
                    }

                }

            }
            $item = array_values($item);//数组重构，重新按键排序
            //dump($item[0]['details']);exit;
            foreach($item as $key=>$value){
                $item[$key]['m_balance'] = $member_info['m_balance'];                  
             
            }
            //dump($item);exit;

            output_datas($item,array('result' =>"0",'desc'=>'查询成功！'));
    }
    
    public function doAddDepositOnline(){
       
        $money = (float) trim($this->_post('order_amount'));//金额
        $code = trim($this->_post('code'));//支付方式
     //   $ary_payment = $Payment->where(array("pc_abbreviation"=>$code))->find();
        //edit by wangpan 2016.10.10
        if($code=='APPWEIXIN'){

            $int_ps_id = $this->addPaymentSerial(1, array('o_all_price' => $money, 'o_id' => date('YmdHis')),0,0,'APPWEIXIN');        
            $orderBody = "手机微信充值";
            $tade_no = $int_ps_id;
            $total_fee = $money*100;
            $notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/Home/User/WxChargeNotify?code=APPWEIXIN';
            //$WxPayHelper = new WxPayHelper();
            $response = D('ApiWeixin')->getPrePayOrder($orderBody, $tade_no, $total_fee,$notify_url);
            //dump($response);exit;
            // p_val("---response----");
            // p_val($response);
            // p_val("---拿到prepayId再次签名----");
            $x = D('ApiWeixin')->getOrder($response['prepay_id']);
            $x['out_trade_no'] = $int_ps_id;
            $x['total_fee'] = $money;

            //dump($x);exit;
            output_datas($x,array('result' =>"0",'error_code' =>0,'desc'=>'请求预支付id成功'));

        }

        $int_ps_id = $this->addPaymentSerial(1, array('o_all_price' => $money, 'o_id' => date('YmdHis')),0,0,'APPALIPAY');
        $ary_data =  array();
        $ary_data['out_trade_no'] = (string)$int_ps_id;
        $ary_data['price'] = (string)$money;  
        $ary_data['notify_url'] = U('Home/User/synChargeNotify?code=' . $code, '', true, false, true); //充值异步通知地址;  
        $ary_data['return_url'] = U('Ucenter/Payment/synChargeReturn?code=' . $code, '', true, false, true); //充值直接回跳地址;  
        output_datas($ary_data,array('result' =>"0",'desc'=>'订单生成成功！'));

    }
    
        protected function updataPaymentSerial_api($o_id, $ps_status, $ps_status_sn, $ps_gateway_sn) 
    {
        $data = array(
            'ps_status'=>$ps_status,
            'ps_status_sn'=>$ps_status_sn,
            'ps_gateway_sn'=>$ps_gateway_sn,
            'ps_update_time'=>date('Y-m-d H:i:s')
        );
        $result = D('PaymentSerial')->where(array('ps_id'=>$o_id))->data($data)->save();
    
        if(false == $result){
            return false;
        }else{
            return true;
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
    
    public function ApicheckTimeOrderSelect(){
        
        $authorization = $this->_request();
        $check =  D("Orders")->checkTimeOrderSelect($authorization['ra_id_card'],$authorization['ra_mobile_phone'],$authorization['goods_pids']);
        if($check == 3 && $check !=1)
        {
                $ary_return['goods_check'] =  true;
                $ary_return['check'] =  true;
        }else{
                $ary_return['check'] =  $check==true?true:FALSE;
                $ary_return['goods_check'] =  FALSE;
        }
         output_datas($ary_return,array('result' =>"0",'desc'=>'查询成功！'));
        
    }
    
    
    
}
