<?php

/**
 * 前台财务相关控制器
 *
 * @package Action
 * @subpackage Ucenter
 * @stage 7.0
 * @author listen <>
 * @date 2013-01-13
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 *
 */
class FinancialAction extends CommonAction {

    /**
     * 默认控制器，需要重定向到用户消费记录
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-13
     */
    public function index() {
        $this->redirect(U('Ucenter/Financial/pageDepositList'));
    }
    /**
     * 我的预存款 - 预存款收支明细
     * @author listen
     * @date 2013-01-14
     */
    public function pageDepositList() {
        $this->getSubNav(4, 3, 30);
		
		//查询条件，默认的开始和结束时间（默认显示30天以内的）
		$start_time = date("Y-m-d",time()-30*24*60*60);
		$end_time = date("Y-m-d");
		if(isset($_GET["starttime"]) && preg_match("/^\d{4}-\d{2}-\d{2}/s",$_GET["starttime"])){
			$start_time = $_GET["starttime"];
		}
		if(isset($_GET["endtime"]) && preg_match("/^\d{4}-\d{2}-\d{2}/s",$_GET["endtime"])){
			$end_time = $_GET["endtime"];
		}
		
		//只显示已审核的记录
		$array_cond = array("bi_verify_status"=>array("eq",1));
		$array_cond["bi_create_time"] = array("between",array($start_time . ' 00:00:00',$end_time . ' 23:59:59'));
		
		//如果指定了类型ID
		if(isset($_GET["bt_id"]) && is_numeric($_GET["bt_id"]) && $_GET["bt_id"] > 0){
			$array_cond["bt_id"] = $_GET["bt_id"];
		}
		$member = $_SESSION['Members'];
		$array_cond["fx_balance_info.m_id"] = $member['m_id'];

        // 订单号
        if (isset($_GET['o_id']) && $_GET['o_id'] != '') {
            $array_cond ['fx_orders.o_id'] = array(
                'EQ',
                $_GET['o_id']
            );
            //获取结余款调整单记录 
            $int_count = D("BalanceInfo")
                ->join('fx_orders on fx_orders.o_id=fx_balance_info.o_id')
                ->where($array_cond)->count();
            $pageObj = new Page($int_count,20);
            $string_limit = $pageObj->firstRow . ',' . $pageObj->listRows;
            $array_balance_info = D("BalanceInfo")
                ->join('fx_orders on fx_orders.o_id=fx_balance_info.o_id')
                ->where($array_cond)->order(array("bi_id"=>'desc'))->limit($string_limit)->select();
            //echo D("BalanceInfo")->getLastSql();exit();
        }else{
            //获取结余款调整单记录
            $int_count = D("BalanceInfo")->where($array_cond)->count();
            $pageObj = new Page($int_count,20);
            $string_limit = $pageObj->firstRow . ',' . $pageObj->listRows;
            $array_balance_info = D("BalanceInfo")->where($array_cond)->order(array("bi_id"=>'desc'))->limit($string_limit)->select();
        }
        $array_cond["m_id"] = $_SESSION['Members']['m_id'];
		//获取会员信息
        $array_member_info = D("Members")->getInfo($_SESSION['Members']['m_name'],$_SESSION['Members']['open_id']);
		$_SESSION["Members"] = $array_member_info;
		//结余款调整类型获取
		$balancetype = D("BalanceType")->where(array("bt_status"=>1))->order(array("bt_orderby"=>"desc"))->select();
        
        //是否开启充值卡充值
        $PREPAID_OPEN = D('SysConfig')->getCfg('PREPAID_CARD_SET','PREPAID_OPEN','1','是否启用充值卡功能');
        $this->assign($PREPAID_OPEN);
        $this->assign("member",$array_member_info);
        $this->assign("balancetype",$balancetype);
        $this->assign("datalist",$array_balance_info);
        $this->assign("start_time",$start_time);
        $this->assign("end_time",$end_time);
        $this->assign("page",$pageObj->show());
        $this->display();
    }

    /**
     * 线下充值页面
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-13
     */
    public function pageDepositOffline() {
        $this->getSubNav(4, 4, 50);
        $this->getSeoInfo(' - 线下充值');
        $oid = $this->_get('oid');
        
        //获取收款帐号列表 ++++++++++++++++++++++++++++++++++++++
        $Account = D('Account');
        $data['list'] = $Account->where(array('a_status'=>1))->select();
		$members = D("Members")->getInfo($_SESSION['Members']['m_name'],$_SESSION['Members']['open_id']);
		$_SESSION["Members"] = $members;
        //是否开启充值卡充值
        $PREPAID_OPEN = D('SysConfig')->getCfg('PREPAID_CARD_SET','PREPAID_OPEN','1','是否启用充值卡功能');
        $this->assign($PREPAID_OPEN);
        $this->assign('members', $members);
        $this->assign($data);
        $this->display();
    }
    
    /**
     * 执行添加线下充值
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-13
     */
    public function doAddDepositOffline() {
        $member = session('Members');
        if(!isset($_POST["a_id"])){
			$this->error("请选择汇款帐号。");
		}
        $Recharge = D('RechargeExamine');
        $data = $Recharge->create();
        
        if(!$this->OfflinePaymentSn($data['re_payment_sn'])){
            $this->error('线下汇款单号申请过。！');
        }     
        $ary_account = D('Account')->where(array('a_id' => $data['a_id']))->find();
        if (false != $ary_account) {
            $data['a_account_number'] = $ary_account['a_account_number'];
            $data['a_apply_bank'] = $ary_account['a_apply_bank'];
            $data['a_apply_name'] = $ary_account['a_apply_name'];
        }
        //echo "<pre>";print_r($data);exit;
        $data['re_status'] = 1;
        $data['re_verify'] = 0;
        $data['re_create_time'] = $data['re_update_time'] = date('Y-m-d H:i:s');
        $data['m_id'] = $member['m_id'];
        if ($Recharge->data($data)->add()) {
            $this->success('线下充值申请成功！管理员会尽快进行核实', U('Ucenter/Financial/pageVerifyDeposit'));
        } else {
            $this->error('线下充值申请失败！');
        }
    }
    
    /**
     * 线下充值审核列表
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-14
     */
    public function pageVerifyDeposit() {
        $this->getSubNav(4, 4, 60);
        $this->getSeoInfo(' - 线下充值审核');
        //查询条件 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $status = $this->_get('v');
        switch ((string) $status) {
            case '0':
                $where = array('re_status' => 1, 're_verify' => 0);
                break;
            case '1':
                $where = array('re_status' => 1, 're_verify' => 1);
                break;
            case '2':
                $where = array('re_status' => 1, 're_verify' => 2);
                break;
            case '3':
                $where = array('re_status' => 0);
                break;
            case '4':
                $where = array('re_status' => 1);
                break;
            default:
                $where = array('m_id'=>$_SESSION['Members']['m_id']);
                break;
        }

        $verifys = array(
            0 => '待审核',
            1 => '已通过',
            2 => '不通过'
        );
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $Recharge = D('RechargeExamine');
        $count = $Recharge->where($where)->count();
        $Page = new Page($count, 10);
        $member = session("Members");
        $where['m_id'] = $member['m_id'];
        $data['list'] = $Recharge->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order(array('re_create_time' => 'desc'))->select();
        $data['page'] = $Page->show();

        foreach ($data['list'] as $k => $v) {
            $data['list'][$k]['re_money_all'] = sprintf('%.2f',$v['re_money']);
            $data['list'][$k]['re_date'] = date('Y-m-d',strtotime($v['re_time']));
        }
        //显示页面 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $this->assign('status', $status);
        $this->assign('verifys', $verifys);
        $this->assign($data);
        $this->display();
    }

    ### 在线充值部分 ###########################################################
    /**
     * 在线充值页面
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-25
     */
    public function pageDepositOnline(){
        $this->getSubNav(4, 4, 40);
        $this->getSeoInfo(' - 在线充值');
        //在线支付方式 ++++++++++++++++++++++++++++++++++++++
        $Payment = D('PaymentCfg');
		$where = array();
		$where['pc_status'] = 1;
		$where['pc_trd'] = 1;
		$where['pc_abbreviation'] = array('in','ALIPAY,TENPAY,CHINAPAYV5');
		
        $data['list'] = $Payment->where($where)->select();
        $members = D("Members")->getInfo($_SESSION['Members']['m_name'],$_SESSION['Members']['open_id']);
		$_SESSION["Members"] = $members;
        //是否开启充值卡充值
        $PREPAID_OPEN = D('SysConfig')->getCfg('PREPAID_CARD_SET','PREPAID_OPEN','1','是否启用充值卡功能');
        $this->assign($PREPAID_OPEN);
        $this->assign('members', $members);
        $this->assign($data);
        $this->display();
    }

    public function doALIPAY(){
      $ary_datas = $this->_get();
         //      $Member_object = D('Members')->where(array('m_id'=>$ary_datas['m_id']))->find();
    //  session('Members', $Member_object);
         //    $member = session('Members');
//              if(empty($member['m_id'])){
//            $this->error('请登录！');
//        }
        if(empty($ary_datas)){
            $this->error('未知的访问请求！');
        }
        if (empty($ary_datas ['o_id'])) {
            $this->error('未知的订单号！');
        }
        if (empty($ary_datas ['code'])) {
            $this->error('暂无支付方式！');
        }
        $orderItems = M('orders_items')->field('oi_id,o_id,g_id,pdt_id,oi_nums,fc_id,oi_type')->where(array('o_id'=>$ary_datas ['o_id']))->find();
        $Payment = D('PaymentCfg');
        $ary_payment = $Payment->where(array('pc_abbreviation'=>$ary_datas ['code']))->find();
        $Pay = $Payment::factory($ary_datas ['code'],  json_decode($ary_payment['pc_config'], true));
        $restult = $Pay->pay($ary_datas ['o_id'],$ary_datas ['details'],$orderItems['oi_nums'],$ary_datas['m_id']);
        
    }


    public function  ALIPAYPayOnline(){
        
        $ary_datas = $this->_request();
        $member = session('Members');
        if(empty($member['m_id'])){
            $this->error('请登录！');
        }
        if(empty($ary_datas)){
            $this->error('未知的访问请求！');
        }
        if (empty($ary_datas ['pdt_id'])) {
            $this->error('暂无商品信息！');
        }
        if (empty($ary_datas ['pc_abbreviation'])) {
            $this->error('暂无支付方式！');
        }
        if (empty($ary_datas ['details'])) {
            $this->error('暂无购买类型！');
        }
        $code = $ary_datas['pc_abbreviation'];
        $pdt_id = $ary_datas['pdt_id'];
        $data_type = $ary_datas['details'];
        $num = $ary_datas ['pdt_stock'];
        if(!empty($ary_datas['activity'])){
            $num =  5;
        }
        $Payment = D('PaymentCfg');
        $ary_payment = $Payment->where(array('pc_abbreviation'=>$code))->find();
        $ary_member = D("Members")->where(array('m_id'=>$_SESSION['Members']['m_id']))->find();
        $ordersModel = D('Orders');
        $data = M('goods_products')->where(array('pdt_id'=>$pdt_id))->find();
        $goods = D('GoodsInfo')->where(array(array('g_id'=>$data['g_id'])))->find();
        $price = M("ProductMemberLevelPrice")->where(array('pdt_id'=>$pdt_id))->field('pmlp_price')->find();
        $sql_model = M('', C('DB_PREFIX'), 'DB_CUSTOM');
        $sql_model->startTrans();
        $ary_orders =  array();
        $ary_orders['o_payment'] = $ary_payment['pc_id'];
        $ary_orders ['m_id'] = $member['m_id'];
        $now_time = date('Y-m-d H:i:s',time());
        if(!empty($_SESSION['str_type'])){
            $ary_orders['o_source_type'] = $_SESSION['str_type'];
        }
        $ary_orders['o_create_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        $ary_orders ['o_id'] = $order_id = '400'.date('YmdHis') . rand(1000, 9999);
        $ary_orders['o_goods_all_price'] = $price['pmlp_price'];
        $end_time_count_out  = 0;
        $activity =  D('SysConfig')->getSysconfigActivity();
        if($data_type  == 2){
                if(time() > strtotime($ary_member['end_time'])){
                        $end_time_count_out =  count_days(strtotime($ary_member['end_time']),strtotime(date('Y-m-d')));
                        $out_day_small =  time() - strtotime($ary_member['end_time']);
                        if($out_day_small < 86400){
                            $end_time_count_out = 1;
                        }
                        $ary_member['end_time']  = 0;
                } else {
                        $ary_member['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($ary_member['end_time']));
                }
                if($ary_member['end_time']  <=7 && $ary_member['end_time'] !=0){
                    $price['pmlp_price']  = $price['pmlp_price'] * 0.90;
                }
                if($end_time_count_out <= 30 && $end_time_count_out > 0 ){
                    $price['pmlp_price']  = $price['pmlp_price'] * 0.95;
                }

            $ary_orders['o_all_price'] = $price['pmlp_price'];
		//保存订单
        } else {
            $ary_orders['o_all_price'] = $price['pmlp_price'] * $num;
            if(empty($activity)){
                $num = (floor($num /5)) +$num;
            }
        }

        if(!empty($activity)){
                switch ($data['pdt_id']){
                    case 1:
                        $ps_buy_giving = $num;
                        break;
                    case 2:
                        $ps_buy_giving = 5;
                        break;
                    case 5:
                        $ps_buy_giving = 3;
                        break;
                    case 6:
                        $ps_buy_giving = 6;
                        break;
                    default :
                        $ps_buy_giving = 0;
                }
                $ary_orders['ps_buy_giving'] = $ps_buy_giving;
        } else {
            if(!empty($ary_datas['activity'])){
                 $this->ajaxReturn(array('action'=>2,'data'=>'msg end','activity'=>2));
            }
        }
        $bool_orders = $ordersModel->data($ary_orders)->add();
        if(empty($bool_orders)){
              $sql_model->rollback();
              $this->error('订单创建失败'); 
        }
        
        //订单商品详情 
        $arr_orders_items = array();
        $arr_orders_items['o_id'] = $ary_orders ['o_id'];
        $arr_orders_items['g_id'] = $data['g_id'];
        $arr_orders_items['pdt_id'] = $data['pdt_id'];
        //    $arr_orders_items['gt_id'] = $bool_orders;
        $arr_orders_items['g_sn'] = $data['g_sn'];
        $arr_orders_items['oi_g_name'] = $goods['g_name'];
        $arr_orders_items['oi_cost_price'] = $data['pdt_cost_price'];
        $arr_orders_items['pdt_sale_price'] = $data['pdt_sale_price'];
        $arr_orders_items['oi_price'] = $price['pmlp_price'];
        if($data_type  == 2){
                $arr_orders_items['oi_nums'] = $data['pdt_g_remark'];
                $data_type_number = $data['pdt_g_remark'];
        } else {
                $data_type_number = $num;
                $arr_orders_items['oi_nums'] = $num;
        }
        $arr_orders_items['oi_refund_status'] = 1;
        $arr_orders_items['oi_create_time'] = $now_time;
        $arr_orders_items['oi_update_time'] = $now_time;
        $bool_orders_items = D('OrdersItems')->data($arr_orders_items)->add();
//        if(!empty($ary_datas['YearMiddlePage'])){
//            $Pay = $Payment::factory($code,  json_decode($ary_payment['pc_config'], true));
//            $restult = $Pay->pay($ary_orders ['o_id'],$data_type,$data_type_number,$member['m_id']);
//            return true;
//        }

        if(!empty($bool_orders_items)){
            $sql_model->commit();
            $ary_orders['pdt_sale_price'] = $data['pdt_sale_price'];
            $this->ajaxReturn(array('action'=>1,'data'=>$ary_orders));
        } else {
            $this->ajaxReturn(array('action'=>2,'data'=>$ary_orders));
        }
    }
    

    /**
     * 执行添加线上充值
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-25
     */
    public function ClientapiALIPAYPayOnline(){
        
        $ary_datas = $this->_get();
        if( !empty($this->_get('token'))){
            $model_mb_user_token = D('MbUserToken');
            $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($this->_get('token'));
            if(empty($mb_user_token_info) || $mb_user_token_info['ip'] != getIp()){
                  redirect(U('Home/Index/Clientapiweixinlogin'));
            }
            $member = D('Members')->getMemberInfoByID($mb_user_token_info['m_id']);
            $this->assign('token', $this->_get('token'));
        } else {
            $member = session('Members');
        }
        $this->assign('client', $this->_get('client'));
        $this->assign('s_type', $this->_get('s_type'));
        if(empty($member['m_id'])){
            $this->error('请登录！');
        }
        if(empty($ary_datas)){
            $this->error('未知的访问请求！');
        }
        if (empty($ary_datas ['pdt_id'])) {
            $this->error('暂无商品信息！');
        }
        if (empty($ary_datas ['pc_abbreviation'])) {
            $this->error('暂无支付方式！');
        }
        if (empty($ary_datas ['details'])) {
            $this->error('暂无购买类型！');
        }
        $code = $ary_datas['pc_abbreviation'];
        $pdt_id = $ary_datas['pdt_id'];
        $data_type = $ary_datas['details'];
        $num = $ary_datas ['pdt_stock'];
        $Payment = D('PaymentCfg');
        $ary_payment = $Payment->where(array('pc_abbreviation'=>$code))->find();
        $ordersModel = D('Orders');
        $data = M('goods_products')->where(array('pdt_id'=>$pdt_id))->find();
        $goods = D('GoodsInfo')->where(array(array('g_id'=>$data['g_id'])))->find();
        $price = M("ProductMemberLevelPrice")->where(array('pdt_id'=>$pdt_id))->field('pmlp_price')->find();
        $sql_model = M('', C('DB_PREFIX'), 'DB_CUSTOM');
        $sql_model->startTrans();
        $ary_orders =  array();
        $ary_orders['o_payment'] = $ary_payment['pc_id'];
        $ary_orders ['m_id'] = $member['m_id'];
        $now_time = date('Y-m-d H:i:s',time());
        if(!empty($_SESSION['str_type'])){
            $ary_orders['o_source_type'] = $_SESSION['str_type'];
        }
        $ary_orders['o_create_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        $ary_orders['o_source'] = 'client';
        $ary_orders ['o_id'] = $order_id = '400'.date('YmdHis') . rand(1000, 9999);
        $ary_orders['o_goods_all_price'] = $price['pmlp_price'];
        $ary_member = D("Members")->where(array('m_id'=>$member['m_id']))->find();
        if(!empty($ary_datas['union'])){
            $ary_orders['union'] = $ary_datas['union'];
        }
        $activity =  D('SysConfig')->getSysconfigActivity();
        if($data_type  == 2){
                $end_time_count_out  = 0;
                if(time() > strtotime($ary_member['end_time'])){
                    $end_time_count_out =  count_days(strtotime($ary_member['end_time']),strtotime(date('Y-m-d')));
                    $out_day_small =  time() - strtotime($ary_member['end_time']);
                    if($out_day_small < 86400){
                        $end_time_count_out = 1;
                    }
                    $ary_member['end_time']  = 0;
                } else {
                        $ary_member['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($ary_member['end_time']));
                }
                if($ary_member['end_time']  <=7 && $ary_member['end_time'] !=0){
                    $price['pmlp_price']  = $price['pmlp_price'] * 0.90;
                }
                if($end_time_count_out <= 30 && $end_time_count_out > 0 ){
                    $price['pmlp_price']  = $price['pmlp_price'] * 0.95;
                }
            $ary_orders['o_all_price'] = $price['pmlp_price'];
		//保存订单
        } else {
            $ary_orders['o_all_price'] = $price['pmlp_price'] * $num;
            if(empty($activity)){
                $num = (floor($num /5)) +$num;
            }
        }

        if(!empty($activity)){
                switch ($data['pdt_id']){
                    case 1:
                        $ps_buy_giving = $num;
                        break;
                    case 2:
                        $ps_buy_giving = 5;
                        break;
                    case 5:
                        $ps_buy_giving = 3;
                        break;
                    case 6:
                        $ps_buy_giving = 6;
                        break;
                    default :
                        $ps_buy_giving = 0;
                }
                $ary_orders['ps_buy_giving'] = $ps_buy_giving;
        } else {
            if(!empty($ary_datas['activity'])){
                 $this->ajaxReturn(array('action'=>2,'data'=>'msg end','activity'=>2));
            }
        }
        $bool_orders = $ordersModel->data($ary_orders)->add();
        if(empty($bool_orders)){
              $sql_model->rollback();
              $this->error('订单创建失败'); 
        }
        //订单商品详情 
        $arr_orders_items = array();
        $arr_orders_items['o_id'] = $ary_orders ['o_id'];
        $arr_orders_items['g_id'] = $data['g_id'];
        $arr_orders_items['pdt_id'] = $data['pdt_id'];
        //    $arr_orders_items['gt_id'] = $bool_orders;
        $arr_orders_items['g_sn'] = $data['g_sn'];
        $arr_orders_items['oi_g_name'] = $goods['g_name'];
        $arr_orders_items['oi_cost_price'] = $data['pdt_cost_price'];
        $arr_orders_items['pdt_sale_price'] = $data['pdt_sale_price'];
        $arr_orders_items['oi_price'] = $price['pmlp_price'];
        if($data_type  == 2){
                $arr_orders_items['oi_nums'] = $data['pdt_g_remark'];
                $data_type_number = $data['pdt_g_remark'];
        } else {
                $data_type_number = $num;
                $arr_orders_items['oi_nums'] = $num;
        }
        $arr_orders_items['oi_refund_status'] = 1;
        $arr_orders_items['oi_create_time'] = $now_time;
        $arr_orders_items['oi_update_time'] = $now_time;
        $bool_orders_items = D('OrdersItems')->data($arr_orders_items)->add();
        if(!empty($bool_orders_items)){
                 $sql_model->commit();
                 $ary_orders['pdt_sale_price'] = $data['pdt_sale_price'];
                 $ary_orders['details'] = $data_type;
                $this->assign('arr_order',$ary_orders);
                $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/apiConfirm.html';
                $this->display($tpl);
        } else {
            $this->ajaxReturn(array('action'=>2,'data'=>$ary_orders));
        }

    }


    /**
     * 执行添加线上充值
     * @author zuo <zuojianghua@guanyisoft.com>
     * @date 2013-01-25
     */
    public function doAddDepositOnline() {
        $ary_datas = $this->_request();
        if( !empty($this->_get('token'))){
            $model_mb_user_token = D('MbUserToken');
            $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($this->_get('token'));
            if(empty($mb_user_token_info) || $mb_user_token_info['ip'] != getIp()){
                  redirect(U('Home/Index/Clientapiweixinlogin'));
            }
            $member = D('Members')->getMemberInfoByID($mb_user_token_info['m_id']);
            $this->assign('token', $this->_get('token'));
    
        } else {
            $member = session('Members');
        }
        $this->assign('client', $this->_get('client'));
        $this->assign('s_type', $this->_get('s_type'));
        if(empty($member['m_id'])){
            $this->error('请登录！');
        }
        if(empty($ary_datas)){
            $this->error('未知的访问请求！');
        }
        if (empty($ary_datas ['pdt_id'])) {
            $this->error('暂无商品信息！');
        }
        if (empty($ary_datas ['pc_abbreviation'])) {
            $this->error('暂无支付方式！');
        }
        if (empty($ary_datas ['details'])) {
            $this->error('暂无购买类型！');
        }
        $code = $ary_datas['pc_abbreviation'];
        $pdt_id = $ary_datas['pdt_id'];
        $data_type = $ary_datas['details'];
        $num = $ary_datas ['pdt_stock'];
        $Payment = D('PaymentCfg');
        $ary_payment = $Payment->where(array('pc_abbreviation'=>$code))->find();
        if(empty($ary_datas['activity_o_id'])){
        $ordersModel = D('Orders');
        $data = M('goods_products')->where(array('pdt_id'=>$pdt_id))->find();
        $goods = D('GoodsInfo')->where(array(array('g_id'=>$data['g_id'])))->find();
        $price = M("ProductMemberLevelPrice")->where(array('pdt_id'=>$pdt_id))->field('pmlp_price')->find();
        $sql_model = M('', C('DB_PREFIX'), 'DB_CUSTOM');
        $sql_model->startTrans();
        $ary_orders =  array();
        $ary_orders['o_payment'] = $ary_payment['pc_id'];
        $ary_orders ['m_id'] = $member['m_id'];
        if(!empty($_SESSION['str_type'])){
            $ary_orders['o_source_type'] = $_SESSION['str_type'];
        }
        $now_time = date('Y-m-d H:i:s',time());
        $ary_orders['o_create_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        if($ary_datas['clien'] == 'clien'){
            $ary_orders['o_source'] = 'client';
        }
        $ary_orders ['o_id'] = $order_id = '400'.date('YmdHis') . rand(1000, 9999);
        $ary_orders['o_goods_all_price'] = $price['pmlp_price'];
        $ary_member = D("Members")->where(array('m_id'=>$member['m_id']))->find();
        if(!empty($ary_datas['union'])){
            $ary_orders['union'] = $ary_datas['union'];
        }
        $activity =  D('SysConfig')->getSysconfigActivity();
        if($data_type  == 2){
                $end_time_count_out  = 0;
                if(time() > strtotime($ary_member['end_time'])){
                        $end_time_count_out =  count_days(strtotime($ary_member['end_time']),strtotime(date('Y-m-d')));
                        $out_day_small =  time() - strtotime($ary_member['end_time']);
                        if($out_day_small < 86400){
                            $end_time_count_out = 1;
                        }
                        $ary_member['end_time']  = 0;
                } else {
                        $ary_member['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($ary_member['end_time']));
                }
                if($ary_member['end_time']  <=7 && $ary_member['end_time'] !=0){
                    $price['pmlp_price']  = $price['pmlp_price'] * 0.90;
                }
                if($end_time_count_out <= 30 && $end_time_count_out > 0 ){
                    $price['pmlp_price']  = $price['pmlp_price'] * 0.95;
                }

            $ary_orders['o_all_price'] = $price['pmlp_price'];
		//保存订单
        } else {
            $ary_orders['o_all_price'] = $price['pmlp_price'] * $num;
            if(empty($activity)){
                $num = (floor($num /5)) +$num; 
            }
        }
            if(!empty($activity)){
                    switch ($data['pdt_id']){
                        case 1:
                            $ps_buy_giving = $num;
                            break;
                        case 2:
                            $ps_buy_giving = 5;
                            break;
                        case 5:
                            $ps_buy_giving = 3;
                            break;
                        case 6:
                            $ps_buy_giving = 6;
                            break;
                        default :
                            $ps_buy_giving = 0;
                    }
                    $ary_orders['ps_buy_giving'] = $ps_buy_giving;
            } else {
                if(!empty($ary_datas['activity'])){
                     $this->assign('getSysconfigActivity',1);
                }
            }
        $bool_orders = $ordersModel->data($ary_orders)->add();
        if(empty($bool_orders)){
              $sql_model->rollback();
              $this->error('订单创建失败'); 
        }
        //订单商品详情 
        $arr_orders_items = array();
        $arr_orders_items['o_id'] = $ary_orders ['o_id'];
        $arr_orders_items['g_id'] = $data['g_id'];
        $arr_orders_items['pdt_id'] = $data['pdt_id'];
        //    $arr_orders_items['gt_id'] = $bool_orders;
        $arr_orders_items['g_sn'] = $data['g_sn'];
        $arr_orders_items['oi_g_name'] = $goods['g_name'];
        $arr_orders_items['oi_cost_price'] = $data['pdt_cost_price'];
        $arr_orders_items['pdt_sale_price'] = $data['pdt_sale_price'];
        $arr_orders_items['oi_price'] = $price['pmlp_price'];
        if($data_type  == 2){
                $arr_orders_items['oi_nums'] = $data['pdt_g_remark'];
                $data_type_number = $data['pdt_g_remark'];
        } else {
                $data_type_number = $num;
                $arr_orders_items['oi_nums'] = $num;
        }
        $arr_orders_items['oi_refund_status'] = 1;
        $arr_orders_items['oi_create_time'] = $now_time;
        $arr_orders_items['oi_update_time'] = $now_time;
        $bool_orders_items = D('OrdersItems')->data($arr_orders_items)->add();
        if(!empty($bool_orders_items)){
            $sql_model->commit();
        }
        } else {
            $ary_orders = D("Orders")->getOrdersInfoFind(array('o_id'=>$ary_datas['activity_o_id']));
            $data_type_number = $ary_orders['oi_nums'];
            D("Orders")->where(array('o_id'=>$ary_datas['activity_o_id']))->save(array('o_payment'=>$ary_payment['pc_id']));
        }
        $Pay = $Payment::factory($code,  json_decode($ary_payment['pc_config'], true));
        $restult = $Pay->pay($ary_orders ['o_id'],$data_type,$data_type_number,$member['m_id']);
        $restult['o_all_price'] = $ary_orders['o_all_price'];
        $restult['o_id'] = $ary_orders['o_id'];
        $restult['details'] = $pdt_id;
        $this->assign('Weixinprepay',$restult);
        if($ary_datas['clien'] == 'clien'){
                $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/scan.html';
        } else {
                $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/Weixinprepay.html';
        }

        // echo "<pre>";print_r($ary_goods);exit;
        $this->display($tpl);
    }
    public function pdf_billing(){
        
      $PdfBilling =   D("PdfBilling")->select();
      print_r($PdfBilling);exit;
        
    }




    /**
     * 线下充值单号是否提交（驳回可以再次申请）
     * @author listen   
     * @pama $str_sn 货款单号
     * @date 2013-04-02
     * @return bool 
     */
    public function OfflinePaymentSn($str_sn){
       // $str_sn = $this->_get('p_sn');
       
        $Recharge = D('RechargeExamine');
       // dump($Recharge);exit;
        if(!$str_sn){
            return false;
            exit;
        }else {
            $ary_recharge = $Recharge->where(array('re_payment_sn'=>$str_sn,'re_verify'=>2))->find();
            if(!empty($ary_recharge)){
                if($ary_recharge['re_verify'] != 2){
                      return false;
                }
            }
        }
        
        return true;
    }
    
    /**
     * 会员中心充值卡充值页面
     * @author Joe <qianyijun@guanyisoft.com>   
     * @date 2013-04-02
     */
    public function pagePrepaidCard(){
        $this->getSubNav(4, 4, 40);
        //是否开启充值卡充值
        
        $PREPAID_OPEN = D('SysConfig')->getCfg('PREPAID_CARD_SET','PREPAID_OPEN','1','是否启用充值卡功能');
        if($PREPAID_OPEN['PREPAID_OPEN']['sc_value'] == 0){
            $this->error('暂未开发充值卡充值功能，敬请期待');
        }
        $members = D("Members")->getInfo($_SESSION["Members"]["m_name"]);
        $this->assign('members', $members);
        $this->display();
    }
    
    /**
     * 执行充值卡充值功能
     * @author Joe <qianyijun@guanyisoft.com>
     * @date 2014-03-19
     */
    public function doAddPrepaidCard(){
        $array_post = $this->_post();
        $prepaidCard = M('prepaid_card',C('DB_PREFIX'),'DB_CUSTOM');
        $member = $_SESSION['Members'];
        //获取充值卡审核配置
        $ary_prepaid_set = D('SysConfig')->getCfgByModule('PREPAID_CARD_SET');
        //系统内置时间
        $time = date('Y-m-d H:i:s');
        //检测充值卡
        $ary_prepaid_status = $this->doCheckPrepaidCard($array_post['pc_card_number'],$array_post['pc_password'],1);
        if(false == $ary_prepaid_status['status']){
            $this->error($ary_prepaid_status['msg']);
        }
        $ary_prepaid_card = $ary_prepaid_status['msg'];
        $array_save['m_id'] = $member['m_id'];
        $array_save['m_name'] = $member['m_name'];
        $array_save['pc_use_time'] = $time;
        if($ary_prepaid_set['IS_SERVER'] == 1){
            $array_save['pc_service_verify'] = 1;
            $array_save['pc_service_u_name'] = 'System';
            $array_save['pc_service_time'] = $time;
        }
        if($ary_prepaid_set['IS_SERVER'] == 1 && $ary_prepaid_set['IS_FINANCE'] == 1){
            $array_save['pc_finance_verify'] = 1;
            $array_save['pc_finance_u_name'] = 'System';
            $array_save['pc_finance_time'] = $time;
            $array_save['pc_processing_status'] = 1;
        }
        
        //开启事物
        M('')->startTrans();
        if(false === $prepaidCard->where(array('pc_id'=>$ary_prepaid_card['pc_id']))->save($array_save)){
            M('')->rollback();
            $this->error('充值失败');
        }
        if($ary_prepaid_set['IS_SERVER'] == 1 && $ary_prepaid_set['IS_FINANCE'] == 1){
            $arr_balance_data = array();
            $ary_prepaid_card['pc_money'] = sprintf("%.2f",$ary_prepaid_card['pc_money']);
            $arr_balance_data['pc_serial_number'] = $ary_prepaid_card['pc_serial_number'];
            $arr_balance_data['bt_id'] = 3;//账户充值
            $arr_balance_data['m_id'] = $array_save['m_id'];
            $arr_balance_data['bi_money'] = $ary_prepaid_card['pc_money'];
            $arr_balance_data['u_id'] = 0;
            $arr_balance_data['bi_type'] = 0;//收入
            $arr_balance_data['bi_verify_status'] = 1;
            $arr_balance_data['bi_service_verify'] = 1;
            $arr_balance_data['bi_finance_verify'] = 1;
            $arr_balance_data['bi_payment_time'] = $time;
            $arr_balance_data['bi_desc'] = "流水号 {$ary_prepaid_card['pc_serial_number']} <br/>充值金额{$ary_prepaid_card['pc_money']}元";
            $arr_balance_data['bi_create_time'] = $time;
            $arr_balance_data['bi_update_time'] = $time;
            $arr_balance_data['single_type'] = 1;
            
            $balance = new Balance();
            $ary_rest = $balance->addBalanceInfo($arr_balance_data);
            
            //获取结余款调整单基本表
            $balance_info = M('balance_info',C('DB_PREFIX'),'DB_CUSTOM')->where($arr_balance_data)->find();
            //写入客审结余款调整单日志
            $balance_server_log['u_id'] = 0;
            $balance_server_log['u_name'] = 'System';
            $balance_server_log['bi_sn'] = $balance_info['bi_sn'];
            $balance_server_log['bvl_desc'] = "流水号 {$ary_prepaid_card['pc_serial_number']} 充值{$ary_prepaid_card['pc_money']}元客审成功";
            $balance_server_log['bvl_type'] = '2';
            $balance_server_log['bvl_status'] = '1';
            $balance_server_log['bvl_create_time'] = $array_save['pc_service_time'];
            if(false === M('balance_verify_log',C('DB_PREFIX'),'DB_CUSTOM')->add($balance_server_log)){
                M('')->rollback();
                $this->error('生成客审结余款调整单日志失败');
            }
            
            //写入财审结余款调整单日志
            $balance_finance_log['u_id'] = 0;
            $balance_finance_log['u_name'] = 'System';
            $balance_finance_log['bi_sn'] = $balance_info['bi_sn'];
            $balance_finance_log['bvl_desc'] = "流水号 {$ary_prepaid_card['pc_serial_number']} 充值{$ary_prepaid_card['pc_money']}元财审成功";
            $balance_finance_log['bvl_type'] = '3';
            $balance_finance_log['bvl_status'] = '1';
            $balance_finance_log['bvl_create_time'] = $array_save['pc_finance_time'];
            if(false === M('balance_verify_log',C('DB_PREFIX'),'DB_CUSTOM')->add($balance_finance_log)){
                M('')->rollback();
                $this->error('生成财审结余款调整单日志失败');
            }
            M('')->commit();
            $this->success('充值成功！',U('Ucenter/MyPrepaidCard/pageList'));
        }else{
            M('')->commit();
            $this->success('操作成功！请等待客服审核',U('Ucenter/MyPrepaidCard/pageList'));
        }
    }
    
    /**
     * 检测当前充值卡是否有效
     * @author Joe <qianyijun@guanyisoft.com>   
     * @date 2014-03-19
     */
    public function doCheckPrepaidCard($pc_card_number='',$pc_password='',$is_post = 0){
        if($is_post == 0){
            $array_post = $this->_post();
            $pc_card_number = $array_post['pc_card_number'];
            $pc_password = $array_post['pc_password'];
        }
        
        $array_return = array('status'=>false,'msg'=>'');
        $prepaidCard = M('prepaid_card',C('DB_PREFIX'),'DB_CUSTOM');
        $member = $_SESSION['Members'];
        
        try{
            //检测当前充值卡是否存在
            $ary_prepaid_card = $prepaidCard->where(array('pc_card_number'=>$pc_card_number,'pc_password'=>$pc_password))->find();
            if(!isset($ary_prepaid_card) && empty($ary_prepaid_card)){
                throw new Exception('您输入的卡号或密码有误，请重试');
            }
            //检测当前充值卡是否已被使用
            if($ary_prepaid_card['m_id'] != 0){
                throw new Exception("您输入的卡号已被使用");
            }
            if($ary_prepaid_card['is_open'] == 0){
                throw new Exception("此卡无效，请联系客服");
            }
            //检测当前充值卡是否过期或未到时间
            if(strtotime($ary_prepaid_card['pc_start_time']) > mktime()){
                //充值卡未开始使用
                throw new Exception("请于". date('Y年m月d号',strtotime($ary_prepaid_card['pc_start_time']))."使用");
            }elseif((strtotime($ary_prepaid_card['pc_start_time']) < mktime()) && (strtotime($ary_prepaid_card['pc_end_time'])< mktime())){
                //充值卡已经过期
                throw new Exception("您的充值卡已过期");
            }
            
            $is_use = 0;
            //检测当前登录会员是否有权限使用该充值卡
            if($ary_prepaid_card['pc_member_group'] != ''){
                $pc_member_group = explode(',',$ary_prepaid_card['pc_member_group']);
                $is_group = 0;
                foreach ($pc_member_group as $mg_id){
                    $info = M('related_members_group',C('DB_PREFIX'),'DB_CUSTOM')->where(array('mg_id'=>$mg_id,'m_id'=>$member['m_id']))->count();
                    if($info != 0){
                        $is_use = 1;
                    }
                }
            }
            if($ary_prepaid_card['pc_member_level'] != ''){
                $pc_member_level = explode(',',$ary_prepaid_card['pc_member_level']);
                if(in_array($member['ml_id'],$pc_member_level)){
                    $is_use = 1;
                }
            }
            if($ary_prepaid_card['pc_member_level'] == '' && $ary_prepaid_card['pc_member_group'] == ''){
                //如果不指定会员等级和会员组，表示所有用户都可以充值
                $is_use = 1;
            }
            if($is_use == 0){
                throw new Exception("您无权使用该充值卡，请联系管理员");
            }
            
            $array_return['status'] = true;
            $array_return['msg'] = $ary_prepaid_card['pc_money'];
        }catch(Exception $e){
            $array_return['msg'] = $e->getMessage();
        }
        if($is_post != 0){
            $array_return['msg'] = $ary_prepaid_card;
            return $array_return;
        }else{
            $this->ajaxReturn($array_return);
        }
        
        
    }

    /**
     * 会员中心预存款提现
     * @author Hcaijin <Huangcaijin@guanyisoft.com>   
     * @date 2014-08-11
     */
    public function pageDepositWithdraw(){
        $this->getSubNav(4, 3, 30);
        //是否开启充值卡充值
        if($PREPAID_OPEN['PREPAID_OPEN']['sc_value'] != 0){
            $this->error('暂未开启预存款提现功能，敬请期待');
        }
        $members = D("Members")->getInfo($_SESSION["Members"]["m_name"]);
        $this->assign('members', $members);
        $this->display();
    }

    /**
     * 会员中心新增结余款提现调整单
     * @author Hcaijin <Huangcaijin@guanyisoft.com>   
     * @date 2014-08-11
     */
    public function doAddDepositWithdraw() {
        $ary_post = $this->_post();
        $members = D("Members")->getInfo($_SESSION["Members"]["m_name"]);
        if(!empty($ary_post) && is_array($ary_post)){
            $balanceObj = D("BalanceInfo");
            $balanceObj->startTrans();
            $ary_post['bi_sn'] = time();
            $ary_post['bt_id'] = '4';
            $ary_post['bi_type'] = '1';
            $ary_post['single_type'] = '2';
            $ary_post['u_id'] = $members['m_id'];
            $ary_post['m_id'] = $members['m_id'];
            $ary_post['bi_create_time'] = date("Y-m-d H:i:s");
            $ary_post['bi_desc'] = '结余款提现：'.$ary_post['bi_desc'];
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
                    $balanceObj->commit();
                    $this->success('提现申请成功！管理员会尽快进行核实', U('Ucenter/Financial/pageVerifyDeposit'));
                }
            }else{
                $balanceObj->rollback();
                $this->error("操作失败");
            }
        }else{
            $this->error("数据有误,请重新输入");
        }
    }

    /**
     * 会员中心预存款兑换金币
     * @author Hcaijin <Huangcaijin@guanyisoft.com>   
     * @date 2014-08-11
     */
    public function pageDepositToJlb(){
        $this->getSubNav(4, 3, 30);
        $ary_jlb_data = D('SysConfig')->getCfgByModule('JIULONGBI_MONEY_SET');
        if($ary_jlb_data['JIULONGBI_AUTO_OPEN'] != 1){
            $this->error('暂未开启预存款提现功能，敬请期待');
        }
        $members = D("Members")->getInfo($_SESSION["Members"]["m_name"]);
        $jlbNums = $members['m_balance']*$ary_jlb_data['jlb_proportion'];
        $this->assign('members', $members);
        $this->assign('jlb', $jlbNums);
        $this->display();
    }

    /**
     * 会员中心新增结余款兑换金币调整单
     * @author Hcaijin <Huangcaijin@guanyisoft.com>   
     * @date 2014-08-11
     */
    public function doAddDepositToJlb() {
        $ary_post = $this->_post();
        $members = D("Members")->getInfo($_SESSION["Members"]["m_name"]);
        D('SysConfig')->getCfg('JIULONGBI_MONEY_SET','JIULONGBI_AUTO_OPEN','1','是否启用金币功能');
        $ary_jlb_data = D('SysConfig')->getCfgByModule('JIULONGBI_MONEY_SET');
        if($ary_jlb_data['JIULONGBI_AUTO_OPEN'] == 1 && $ary_jlb_data['jlb_proportion'] > 0){
            if(!empty($ary_post) && is_array($ary_post) && $ary_post['jlb_num'] > 0){
                $totaljlb = $members['m_balance']*$ary_jlb_data['jlb_proportion'];
                if($post_post['jlb_num']<$totaljlb){
                    D('')->startTrans();
                    $arr_jlb = array(
                        'jt_id' => '3',
                        'm_id'  => $members['m_id'],
                        'ji_create_time'  => date("Y-m-d H:i:s"),
                        'ji_type' => '0',
                        'ji_money' => $ary_post['jlb_num'],
                        'ji_desc' => $ary_post['jlb_num']."个",
                        'ji_finance_verify' => '1',
                        'ji_service_verify' => '1',
                        'ji_verify_status' => '1',
                        'single_type' => '2'
                    );
                    $res_jlb = D('JlbInfo')->addJlb($arr_jlb);

                    $balanceObj = D("BalanceInfo");
                    $ary_post['bi_sn'] = time();
                    $ary_post['bt_id'] = '4';
                    $ary_post['bi_type'] = '1';
                    $ary_post['bi_money'] = $ary_post['jlb_num']/$ary_jlb_data['jlb_proportion'];
                    $ary_post['single_type'] = '2';
                    $ary_post['u_id'] = $members['m_id'];
                    $ary_post['m_id'] = $members['m_id'];
                    $ary_post['bi_create_time'] = date("Y-m-d H:i:s");
                    $ary_post['bi_desc'] = '结余款兑换金币：'.$ary_post['bi_desc'];
                    $ary_post['bi_finance_verify'] = '1';
                    $ary_post['bi_service_verify'] = '1';
                    $ary_post['bi_verify_status'] = '1';

                    $ary_result = $balanceObj->add($ary_post);
                    if(FALSE != $ary_result){
                        $ary_data = array();
                        $str_sn = str_pad($ary_result,6,"0",STR_PAD_LEFT);
                        $ary_data['bi_sn'] = time() . $str_sn;
                        $result = $balanceObj->where(array('bi_id'=>$ary_result))->data($ary_data)->save();
                        if(!$result){
                            D('')->rollback();
                            $this->error("操作失败");
                        }else{
                            if($ary_post['bi_finance_verify']){
                                $ary_data = D("Members")->field("m_balance")->where(array("m_id"=>$ary_post['m_id']))->find();
                                $m_balance = '';
                                $m_balance = $ary_data['m_balance'] - $ary_post['bi_money'];
                                D("Members")->where(array('m_id'=>$ary_post['m_id']))->data(array('m_balance'=>$m_balance))->save();
                            }
                            D('')->commit();
                            $this->success('兑换金币成功！');
                        }
                    }else{
                        D('')->rollback();
                        $this->error("操作失败");
                    }
                }else{
                    $this-error("输入的兑换数量不能大于可兑换的金币");
                }
            }else{
                $this->error("数据有误,请重新输入");
            }
        }else{
            $this->error("未开启兑换金币功能！");
        }
    }
}

