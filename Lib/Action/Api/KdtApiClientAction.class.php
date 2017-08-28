<?php
/**
 * @require PHP>=5.3
 * url https://open.koudaitong.com/api/entry?sign=74d4c18b9f077ed998feb10e96c58497&timestamp=2013-05-06%2013:52:03&v=1.0&app_id=test&
 method=kdt.item.get&sign_method=md5&format=json&num_iid=3838293428
 *演示地址 http://www.xingyun.com:8080/Api/KdtApiClient/test
 */
require_once __DIR__ . '/KdtApiProtocol.php';
require_once __DIR__ . '/SimpleHttpClient.php';

class KdtApiClientAction extends GyfxAction {
	//echo 11;exit;
	const VERSION = '1.0';
	
	private static $apiEntry = 'https://open.koudaitong.com/api/entry';
	
	private $appId = '8c0550382a853fdc77';
	private $appSecret = 'dee9e289cd0d9128b79381d280274470';
	private $format = 'json';
	private $signMethod = 'md5';
	
	// public function __construct($appId, $appSecret) {
	// 	if ('' == $appId || '' == $appSecret) throw new Exception('appId 和 appSecret 不能为空');
		
	// 	$this->appId = $appId;
	// 	$this->appSecret = $appSecret;
	// }
	
	public function get($method, $params = array()) {
		return $this->parseResponse(
			SimpleHttpClient::get(self::$apiEntry, $this->buildRequestParams($method, $params))
		);
	}
	
	public function post($method, $params = array(), $files = array()) {
		return $this->parseResponse(
			SimpleHttpClient::post(self::$apiEntry, $this->buildRequestParams($method, $params), $files)
		);
	}
	
	
	
	public function setFormat($format) {
		if (!in_array($format, KdtApiProtocol::allowedFormat()))
			throw new Exception('设置的数据格式错误');
		
		$this->format = $format;
		
		return $this;
	}
	
	public function setSignMethod($method) {
		if (!in_array($method, KdtApiProtocol::allowedSignMethods()))
			throw new Exception('设置的签名方法错误');
		
		$this->signMethod = $method;
		
		return $this;
	}
	
	

	private function parseResponse($responseData) {
		$data = json_decode($responseData, true);
		if (null === $data) throw new Exception('response invalid, data: ' . $responseData);
		return $data;
	}
	
	private function buildRequestParams($method, $apiParams) {
		if (!is_array($apiParams)) $apiParams = array();
		$pairs = $this->getCommonParams($method);
		foreach ($apiParams as $k => $v) {
			if (isset($pairs[$k])) throw new Exception('参数名冲突');
			$pairs[$k] = $v;
		}
		
		$pairs[KdtApiProtocol::SIGN_KEY] = KdtApiProtocol::sign($this->appSecret, $pairs, $this->signMethod);
		//dump($pairs);exit;
		return $pairs;
	}
	
	private function getCommonParams($method) {
		$params = array();
		$params[KdtApiProtocol::APP_ID_KEY] = $this->appId;
		$params[KdtApiProtocol::METHOD_KEY] = $method;
		$params[KdtApiProtocol::TIMESTAMP_KEY] = date('Y-m-d H:i:s');
		$params[KdtApiProtocol::FORMAT_KEY] = $this->format;
		$params[KdtApiProtocol::SIGN_METHOD_KEY] = $this->signMethod;
		$params[KdtApiProtocol::VERSION_KEY] = self::VERSION;
		return $params;
	}

	//查询所有的订单列表
	public function orderList(){

		// dump($this->parseResponse(
		// 	SimpleHttpClient::get(self::$apiEntry, $this->buildRequestParams('kdt.trades.sold.get', ''))
		// ));exit;
		$result = $this->parseResponse(
			SimpleHttpClient::get(self::$apiEntry, $this->buildRequestParams('kdt.trades.sold.get', ''))
		);
		output_datas($result,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功！'));

	}


	//获取仓库中的商品列表
	public function goodsList(){

		// dump($this->parseResponse(
		// 	SimpleHttpClient::get(self::$apiEntry, $this->buildRequestParams('kdt.items.inventory.get', ''))
		// ));exit;
		$result = $this->parseResponse(
			SimpleHttpClient::get(self::$apiEntry, $this->buildRequestParams('kdt.items.inventory.get', ''))
		);
		output_datas($result,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功！'));

	}


	//根据外部编号取商品Sku 
	public function goodsShow(){
		// fields	String	否	sku_id,num_iid,quantity,properties_name		需要返回的Sku对象字段，如sku_id,num_iid,quantity等。可选值：Sku结构体中所有字段均可返回；多个字段用“,”分隔。如果为空则返回所有
		// outer_id	String	必须	B1230233		商家编码（商家为Sku设置的外部编号）
		// num_iid	Number	必须	3838293428		商品数字编号
		// dump($this->parseResponse(
		// 	SimpleHttpClient::get(self::$apiEntry, $this->buildRequestParams('kdt.skus.custom.get', ''))
		// ));exit;
		$result = $this->parseResponse(
			SimpleHttpClient::get(self::$apiEntry, $this->buildRequestParams('kdt.skus.custom.get', ''))
		);
		output_datas($result,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功！'));

	}


    // 名称  类型  是否必须    示例值 默认值 描述
    // tid String  否   E123456     交易编号
    // outer_tid   String  否   X231958349      外部交易编号 也可以根据外部交易编号发货，tid、outer_tid 必须选其一
    // oids    String  否   14776,14778     如果需要拆单发货，使用该字段指定要发货的交易明细的编号，多个明细编号用半角逗号“,”分隔；不需要拆单发货，则改字段不传或值为空；
    // is_no_express   Number  必须  1   0   发货是否无需物流如果为 0 则必须传递物流参数，如果为 1 则无需传递物流参数（out_stype和out_sid），默认为 0
    // out_stype   Number  必须  1       快递公司类型（编号 => 名称）：1 => 申通E物流                             
    // out_sid String  必须  E123456     快递单号（具体一个物流公司的真实快递单号）
	public function confirm(){

		// $oid = '201609081629494734';
		// //dump(11);exit;
		// $ary_goods = array();
		// $ary_goods['express'] = '百世物流科技（中国）有限公司';
		// $ary_goods['express_no'] = '280521885035';
  //       $ary_where = array('o_id' => $oid);
		// $ary_orders = D('Orders')->where($ary_where)->find();
	 //    $post_data = array();
	 //    $post_data['tid'] = $ary_orders['o_thd_sn'];//交易编号
	 //    $post_data['oids'] = $ary_orders['o_sn'];//如果需要拆单发货，使用该字段指定要发货的交易明细的编号，多个明细编号用半角逗号“,”分隔；不需要拆单发货，则改字段不传或值为空；
	 //    $post_data['is_no_express'] = 0;
	 //    $ary_logi = M("logistic_corp", C('DB_PREFIX'), 'DB_CUSTOM')->where(array('lc_name'=>array("LIKE", '%' . $ary_goods['express'] . '%')))->find();
	 //    //dump($ary_logi);exit;
	 //    // if (empty($ary_logi)) {
	 //    //      output_msg("物流公司不匹配", array('flag' => FALSE));
	 //    // }                                
	 //    $post_data['out_stype'] = (int)$ary_logi['erp_delivery_guid'];//第三方物流公司id

	 //    $post_data['out_sid'] = (string)$ary_goods['express_no'];//快递单号
		$post_data = $this->_post();
		$post_data['is_no_express'] = 0;
		$post_data['out_stype'] = (int)$post_data['out_stype'];	    
	    //dump($post_data);exit;
	    $result = $this->parseResponse(
	        SimpleHttpClient::post(self::$apiEntry, $this->buildRequestParams('kdt.logistics.online.confirm', $post_data,''))
	    );

	    $newarr = array();                
	    $newarr['response']['shipping']['is_success'] = true;
	    $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);
	    echo $json;die;  
		
	}


}
