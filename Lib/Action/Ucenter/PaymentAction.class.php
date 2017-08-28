<?php

/**
 * 前台支付回调通知
 *
 * @package Action
 * @subpackage Ucenter
 * @stage 7.0
 * @author zuojianghua <zuojianghua@guanyisoft.com>
 * @date 2013-01-23
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class PaymentAction extends CommonAction {

    /**
     * 接收第三方支付时的返回信息
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-23
     */
    public function synPayReturn() {
        //$data = $this->_param();
        $data = $_REQUEST;
        $code = $data['code'];
        //过滤掉thinkphp自带的参数，和非回调参数
        unset($data['_URL_']);
        unset($data[0]);
        unset($data[1]);
        unset($data[2]);
        unset($data[3]);
        unset($data[4]);
        unset($data['code']);

        //获取支付类型信息
        $Payment = D('PaymentCfg');
        $ary_pay = $Payment->where(array('pc_abbreviation' => $code))->find();
        writeLog(json_encode($data),"order_pay.log");
        if (false == $ary_pay) {
            $this->error('不存在的支付方式');
        }

        $Order = D('Orders');
        $ary_order = $Order->where(array('o_id' => $data['out_trade_no']))->find();
        $ary_pay_ser = M('payment_serial')->where(array('o_id'=>$data['out_trade_no'],'ps_status'=>array('neq',0)))->order('ps_update_time desc')->select();
        if($ary_pay_ser[0]['pay_type'] == '1'){
            //定金支付
            $ary_order['o_pay_status'] = 3;
        }else{
            $ary_order['o_pay_status'] = 1;
        }
        if($ary_order['o_pay_status'] == 1 || $ary_order['o_pay_status'] == 3){
        //已经存在相同流水号的
        $members = D('Members')->getMemberInfoByID($ary_order['m_id']);
        $memberCookie = D('MemberCookie');
        $key = md5($members['m_id'].time());
        $SelectTokenDataFind = $memberCookie->where(array('m_id'=>$members['m_id']))->find();
            if(empty($SelectTokenDataFind)){
                    $add_member_cookie = array();
                    $add_member_cookie['m_id'] = $members['m_id'];
                    $add_member_cookie['key'] = $key;
                    $add_member_cookie['create_time'] = time();
                    $add_member_cookie['update_time'] = time();
                    $add_member_cookie['login_click'] = 1;
                    $memberCookie->add($add_member_cookie);
                    cookie('userToken',$key,3600 * 86400);
            } else {
                    $save_member_cookie = array();
                    if($SelectTokenDataFind['key'] !=  cookie('userToken') ){
                         $save_member_cookie['key'] = $key;
                         cookie('userToken',$key,3600 * 86400);
                    }
                    $save_member_cookie['update_time'] = time();
                    $save_member_cookie['login_click'] = $SelectTokenDataFind['login_click'] +1;
                    $memberCookie->where(array('m_id'=>$members['m_id']))->save($save_member_cookie);
            }
            session('Members', $members);
            $jumpUrl = U('Home/Index/informationRecords');
            if(check_wap()){
                $jumpUrl = U('Home/Index/informationRecords');
            }
            //echo '充值成功，请关闭页面';exit;
                //完成并显示，返回到订单信息页面
                $this->redirect($jumpUrl);		
        }
        
     
    }

    /**
     * 接收第三方充值时的返回信息
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-25
     */
    public function synChargeReturn() {
        $data = $_REQUEST;
        $code = $data['code'];
        //过滤掉thinkphp自带的参数，和非回调参数
        unset($data['_URL_']);
        unset($data[0]);
        unset($data[1]);
        unset($data[2]);
        unset($data[3]);
        unset($data[4]);
        unset($data['code']);

        //获取支付类型信息
        $Payment = D('PaymentCfg');
        $ary_pay = $Payment->where(array('pc_abbreviation' => $code))->find();

        if (false == $ary_pay) {
            $this->error('不存在的支付方式');
        }
        $Pay = $Payment::factory($ary_pay['pc_abbreviation'], json_decode($ary_pay['pc_config'], true));

        $result = $Pay->respond($data);
        M('','','DB_CUSTOM')->startTrans();

        if ($result['result']) {
			//已充值完成不允许再次充值
			if(empty($result['m_id'])){
                //已经存在相同流水号的
                M('','','DB_CUSTOM')->commit();
                $this->success('支付成功', U('Ucenter/Financial/pageDepositList'));exit;
			}
            //检查请求签名正确
            //获取会员信息
            $ary_member = D('Members')->where(array('m_id' => $result['m_id']))->find();

            //已经充值过的不能重复充值
            $where = array('ra_payment_sn'=>$result['gw_code'],'ra_payment_method'=>$ary_pay['pc_custom_name']);
            $int_running_find = D('RunningAccount')->where($where)->find();
            if(false != $int_running_find){
                //已经存在相同流水号的
                M('','','DB_CUSTOM')->commit();
                $this->success('支付成功', U('Ucenter/Financial/pageDepositList'));exit;
            }
			//已充值完成不允许再次充值
			/**
			if(!empty($result['int_ps_id'])){
				$ary_paymentSerial = D('PaymentSerial')->where(array('ps_id'=>$result['int_ps_id'],'ps_status'=>1))->getField('ps_id');
				if(!empty($ary_paymentSerial)){
					//已经存在相同流水号的
					M('','','DB_CUSTOM')->rollback();
					$this->success('支付成功', U('Ucenter/Financial/pageDepositList'));exit;			
				}
			}
			**/
            if($result['int_status'] == 1 || $result['int_status'] == 3){
                //直接付款成功，交易成功
                $ary_where_account = array(
                    'm_id' => $result['m_id'],
                    'ra_money' => $result['total_fee'],
                    'ra_type' => 0, //充值
                    'ra_payment_method' => $ary_pay['pc_custom_name'],
                    'ra_before_money' => (float) $ary_member['m_balance'],
                    'ra_after_money' => (float) $ary_member['m_balance'] + (float) $result['total_fee'],
                    'ra_payment_sn' => $result['gw_code']
                );
                $RunningAccount_info = D('RunningAccount')->where($ary_where_account)->find();
                if(!isset($RunningAccount_info) && empty($RunningAccount_info)){
                    $ary_where_account['ra_create_time'] = date('Y-m-d h:i:s');
                    $RunningAccount_info = D('RunningAccount')->add($ary_where_account);
                }

                if (false === $RunningAccount_info) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error('充值流水账添加错误');
                } else {
                    $ary_where_balance=array(
                        'm_id'=>$result['m_id'],
                        'bi_money'=>$result['total_fee'],
                        'bi_sn'=>$result['gw_code'],
                        'bt_id'=>3,
                        'bi_verify_status'=>1,
                        'bi_service_verify'=>1,
                        'bi_finance_verify'=>1,
                        'bi_desc'=>$ary_pay['pc_custom_name'].'线上充值'
                    );
                    $BalanceInfo_info = D('BalanceInfo')->where($ary_where_balance)->find();
                    writeLog(D('BalanceInfo')->getLastSql(),'BalanceInfo.log');
                    if(!isset($BalanceInfo_info) && empty($BalanceInfo_info)){
                        $ary_where_balance['bi_create_time'] = date('Y-m-d H:i:s');
                        $ary_where_balance['bi_update_time'] = date('Y-m-d H:i:s');
                        $BalanceInfo_info = D('BalanceInfo')->add($ary_where_balance);
                        writeLog(D('BalanceInfo')->getLastSql(),'BalanceInfo.log');
                    }
                    if(false === $BalanceInfo_info){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error('结余款调整单添加失败！');exit;
                    }
                    //更新用户预存款
                    $updata_data['m_balance']= $ary_where_account['ra_after_money'];
                    M('members',C('DB_PREFIX'),'DB_CUSTOM')->where(array('m_id'=>$ary_where_account['m_id']))->save($updata_data);
                    M('','','DB_CUSTOM')->commit();
                    $this->success('支付成功', U('Ucenter/Financial/pageDepositList'));exit;
                }
            }else if($result['int_status'] == 2){
				/**隐藏
                //担保交易，等待管理员付款（生成结余款调整单）
                $ary_where_balance=array(
                    'm_id'=>$result['m_id'],
                    'bi_money'=>$result['total_fee'],
                    'bi_sn'=>$result['gw_code'],
                    'bt_id'=>3,
                    'bi_verify_status'=>0,
                    'bi_service_verify'=>0,
                    'bi_finance_verify'=>0,
                    'bi_desc'=>$ary_pay['pc_custom_name'].'线上充值'
                );
                $BalanceInfo_info = D('BalanceInfo')->where($ary_where_balance)->find();
                if(!isset($BalanceInfo_info) && empty($BalanceInfo_info)){
                    $ary_where_balance['bi_create_time'] = date('Y-m-d H:i:s');
                    $ary_where_balance['bi_update_time'] = date('Y-m-d H:i:s');
                    $BalanceInfo_info = D('BalanceInfo')->add($ary_where_balance);
                }
                if(false === $BalanceInfo_info){
                    M('','','DB_CUSTOM')->rollback();
                    $this->error('结余款调整单添加失败！');
                }
				**/
                M('','','DB_CUSTOM')->commit();
                $this->success('付款成功，等待发货', U('Ucenter/Financial/pageDepositList'));
            }
        } else {
            M('','','DB_CUSTOM')->rollback();
            $this->error('错误访问');
        }
    }

}
