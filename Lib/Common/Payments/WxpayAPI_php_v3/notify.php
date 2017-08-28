<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler(APPPATH . "logs/".date('Y-m-d').'.wx.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("Queryorder:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//回调处理
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)) {
			$msg = "输入参数不正确";
			Log::DEBUG("--------- $msg ---------");
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			Log::DEBUG("--------- $msg ---------");
			return false;
		}

		if(!array_key_exists("attach", $data)) {
			$msg = "参数attach不存在";
			Log::DEBUG("--------- $msg ---------");
			return false;
		}
		list($client_id, $type, $count, $order_name) = explode('|', $data['attach']);
		if(!$client_id || !$type || !$count) { // || getTheFee($type, $count)!=$data['total_fee']/100
			$msg = "参数attach无效";
			Log::DEBUG("--------- $msg ---------");
			return false;
		}
		if(!$order_name) $order_name = getTitle($type, $count);

		$CI = &get_instance();
		$CI->load->Model('Orders');
		$order_data = array(
				'client_id' => $client_id,
				'name' => $order_name,
				'order_no' => $data['out_trade_no'],
				'fee' => $data['total_fee'] / 100,
				'status' => $data['result_code']=='SUCCESS' ? 1:0,
				'json' => json_encode($data),
			);
		Log::DEBUG("order_data:" . json_encode($order_data));
		$ret = $CI->Orders->add($order_data);
		if(!$ret) {
			$msg = "回调数据入库失败I";
			Log::DEBUG("--------- $msg ---------");
			return false;
		} elseif($ret == 'success') {
			$msg = "回调数据已入库，无需重复";
			Log::DEBUG("--------- $msg ---------");
			return true;
		}

		//计算授权
		$CI->load->Model('Clients');
		$ret = $auth_data = $CI->Clients->updateAuthData(array('id'=>$client_id), array('type'=>$type, 'count'=>$count));
		if(!$ret) {
			$msg = "回调数据入库失败II";
			Log::DEBUG("--------- $msg ---------");
			return false;
		}

		return true;
	}
}


