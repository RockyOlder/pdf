<?php
require_once('wxpay/WxPayPubHelper.php');
/**
 * 支付宝支付类
 *
 * @package Common
 * @subpackage Payments
 * @stage 7.8.2
 * @author wangguibin <wangguibin@guanyisoft.com>
 * @date 2015-03-30
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class WEIXIN extends Payments implements IPayments {

    /**
     * 设置支付方式的配置信息
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2015-03-30
     * @param array $param 支付方式的配置数组
     */
    public function setCfg($param = array()) {
        $config = array();
        $config['weixin_account'] = $param['weixin_account'];
        $config['weixin_appid'] = $param['weixin_appid'];
        $config['weixin_appsecret'] = $param['weixin_appsecret'];
		$config['weixin_key'] = $param['weixin_key'];
        $config['pc_fee'] = $param['pc_fee'];
        $this->config = $config;
    }

    /**
     * 支付订单
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date  2015-03-30
     * @param string $str_oid 订单编号
     * @param type $ary_param 订单参数
     */
    public function pay($str_oid,$type=2,$data=2,$m_id=null) {
        require_once "WxpayAPI_php_v3/lib/WxPay.Api.php";
        require_once "WxpayAPI_php_v3/WxPay.NativePay.php";
        $ary_order = parent::pay($str_oid);
	        //生成支付序列号 +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $ary_order['type']  = $type;
        $ary_order['data']  = $data;
        $int_ps_id = $this->addPaymentSerial(0, $ary_order,0,$m_id);
        if($type == 1){
            $text = '悦书PDF阅读授权购买--次数'.$data.'次授权';
        } else {
            $text = '悦书PDF阅读授权购买-套餐'.$data.'个月授权';
        }
      //  echo $int_ps_id;exit;
       // $shop_title = D('SysConfig')->where(array('sc_module'=>'GY_SHOP','sc_key'=>'GY_SHOP_TITLE'))->getField('sc_value');
        $pay = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody($text);
        $input->SetAttach('悦书PDF阅读器授权购买');
        $input->SetOut_trade_no($int_ps_id);
        $input->SetTotal_fee($ary_order['o_all_price'] * 100); //分
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 60*60));
        $input->SetNotify_url(U('Home/User/synPayWeixinNotify?code=' . $this->code, '', true, false, true));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id(time());

        $result = $pay->GetPayUrl($input);
        return $result;
    }

    /**
     * 预存款充值
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2013-01-25
     * @param float $flt_money 要充值的金额
     */
    public function charge($str_oid,$type=2,$data=2) {
        require_once "WxpayAPI_php_v3/lib/WxPay.Api.php";
        require_once "WxpayAPI_php_v3/WxPay.NativePay.php";
        $ary_order = parent::pay($str_oid);
	        //生成支付序列号 +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $ary_order['type']  = $type;
        $ary_order['data']  = $data;
        $int_ps_id = $this->addPaymentSerial(0, $ary_order,0);
      //  echo $int_ps_id;exit;
       // $shop_title = D('SysConfig')->where(array('sc_module'=>'GY_SHOP','sc_key'=>'GY_SHOP_TITLE'))->getField('sc_value');
        $pay = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody('ceshi');
        $input->SetAttach('ceshi');
        $input->SetOut_trade_no($int_ps_id);
        $input->SetTotal_fee($ary_order['o_all_price'] * 100); //分
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 60*60));
        $input->SetNotify_url(U('Home/User/synPayWeixinNotify?code=' . $this->code, '', true, false, true));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id(time());

        $result = $pay->GetPayUrl($input);
        return $result;
    }
    public function createTradeId(){
	$curDateTime = date("YmdHis");
	//date_default_timezone_set(PRC);
	$strDate = date("Ymd");
	$strTime = date("His");
	//4位随机数
	$randNum = rand(1000, 9999);
	//10位序列号,可以自行调整。
	$strReq = $strTime . $randNum;
	/* 商家的定单号 */
	$mch_vno = $curDateTime . $strReq;
	/********************/
	/*todo 保存订单信息到数据库中*/
    /********************/
	return $mch_vno;
}

    /**
     * 响应支付宝通知
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2015-04-02
     * @param array $data 从服务器端返回的数据
     * @return array 返回订单号和支付状态
     */
    public function respond($xml) {
        $data = xml2array($xml);
		$data['total_fee'] = $data['total_fee']/100;
        //自定义的流水号 GY+ps_id
		$int_ps_id = $data['out_trade_no'];
        //外部网关流水号
        $str_trade_no = $data['transaction_id'];
		$pay_config = D('Gyfx')->selectOneCache('payment_cfg','pc_config',array('pc_abbreviation' => 'WEIXIN'));
		$pay_config['pc_config'] = json_decode($pay_config['pc_config'], TRUE);
		//使用通用通知接口
                writeLog("REQUEST: ". json_encode($pay_config['pc_config']),"order_pay_weixin.log");
		$notify = new Notify_pub($pay_config['pc_config']);
		$notify->saveData($xml);
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
		//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		
		//以log文件形式记录回调信息
		//$log_ = new Log_();
		//$log_name="./notify_url.log";//log文件路径
		//$log_->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");
		$int_status = 0;
		if($notify->checkSign() == TRUE)
		{
			if ($notify->data["return_code"] == "FAIL") {
				//此处应该更新一下订单状态，商户自行增删操作
				//$log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
				return array('result' => false);
			}
			elseif($notify->data["result_code"] == "FAIL"){
				//此处应该更新一下订单状态，商户自行增删操作
				//$log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
				return array('result' => false);
			}
			else{
				//此处应该更新一下订单状态，商户自行增删操作
				//$log_->log_result($log_name,"【支付成功】:\n".$xml."\n");
				 $int_status = 1;
			}
			
			//商户自行增加处理流程,
			//例如：更新订单状态
			//例如：数据库操作
			//例如：推送支付完成信息
		}
        //支付状态
        //1为直接付款成功，2为付款至担保方，3为付款至担保方结算完成，4为其他状态.退款退货暂不处理
		if($int_status == '1'){

			if(!empty($int_ps_id)){
				$ary_paymentSerial = D('PaymentSerial')->where(array('o_id'=>$int_ps_id))->find();
				if(!empty($ary_paymentSerial)){
					if($ary_paymentSerial['ps_status'] == 1){
						//已经存在相同支付流水号的
						return array('result' => true,'o_id'=>$data['subject']);
					}
				}else{
					//流水号不存在
					return array('result' => false);
				}
			}else{				
				return array('result' => false);
			}
		}
        //更改第三方流水单状态
        $result = $this->updataPaymentSerial($int_ps_id, $int_status, $notify->data["result_code"], $str_trade_no);
        //根据流水单号返回会员ID
        $m_id = $this->getMemberIdByPsid($int_ps_id);
        return array(
            'result' => $result,
            'o_id' => $ary_paymentSerial['o_id'],
            'ps_buy_type' => $ary_paymentSerial['ps_buy_type'],
        //    'ps_buy_time' => $ary_paymentSerial['ps_buy_time'],
            'ps_buy_nunmber' => $ary_paymentSerial['ps_buy_nunmber'],
            'int_status' => $int_status,
            "total_fee" => $data['total_fee'],
            "gw_code" => $str_trade_no,
            'm_id' => $m_id,
            'int_ps_id'=>$int_ps_id
        );
    }
	
}
