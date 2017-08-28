<?php

/* 
 * @athour wangpan 2016.07.01
 * 优惠券接口
 * and open the template in the editor.
 */
class CouponAction extends CommonAction {



    // 获取某笔订单可使用和不可使用的优惠券列表
    // 请求方式：  post
    // 请求url: 120.25.249.28/Api/Coupon/couponsSelect
    // token:   凭证
    //money 订单金额
    //type 1 可用  2不可用
    // 返回data 
   
    public function couponsSelect(){

        $ary_post = $this->_post();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $money = $ary_post['money'];
        $type = $ary_post['type'];

        $date = date('Y-m-d');
        $where = array();
        //$where['c.c_user_id'] = $m_id;

            switch ($type) {
                case '1':
                    // $where['c.c_condition_money'] = array('elt',$money);
                    // $where['c.c_is_use'] = '0';//未使用
                    // $where['c.c_end_time'] = array('EGT', $date);//未过期
                    // $map['c.c_user_id'] = $m_id;

                    $where = "c.c_condition_money <= ".$money." and c.c_is_use = 0 and c.c_end_time >= ".$date." and c.c_user_id = ".$m_id;



                    break;
                case '2':
                    // $where['c.c_is_use'] = '1';//已使用
                    // $where['c.c_end_time'] = array('LT', $date);//已过期 
                    // $where['c.c_condition_money'] = array('gt',$money);   
                    // $where['_logic'] = 'OR';
                    // $map['_complex'] = $where;
                    // $map['c.c_user_id'] = $m_id;
                    // break;

                    //$where = "c.c_condition_money > ".$money." or c.c_is_use = 1 or c.c_end_time < ".$date." and c.c_user_id = ".$m_id;
                    $where = "c.c_user_id = ".$m_id." and (c.c_condition_money > ".$money." or c.c_is_use = 1 or c.c_end_time < ".$date.")";

                default:
                    //$where;
            }
       
        //dump($where);exit;
        $UserCouponValidation = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')
                    //->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_type,c_memo,c_money,gb_id,gc_id,c_coupon_good_id,receiveNumber,txtIssueNum')
                    ->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_is_use,c_condition_money,c_type,c_memo,c_money,gb_id,gc_id,c_coupon_good_id,receiveNumber,txtIssueNum,c_status')
                    ->alias('c')
                    //->join('fx_coupon c on c.c_id = cu.c_id')
                    ->where($where)
                    //->where($map)
                    //->limit($offset . ',' . $pagesize)
                    ->order()
                    ->select();
//echo M()->getlastsql();exit;
        foreach($UserCouponValidation as $key=>$value)
        {


                $UserCouponValidation[$key]['c_start_time'] = date('Y.m.d' ,strtotime($value['c_start_time']));
                $UserCouponValidation[$key]['c_end_time'] = date('Y.m.d' ,strtotime($value['c_end_time']));
                $UserCouponValidation[$key]['c_money'] = strval((int)$value['c_money']);
                if($value['c_coupon_good_id'] == 'all'){
                    $UserCouponValidation[$key]['c_coupon_good_id'] = '全部';
                }else{
                    $UserCouponValidation[$key]['c_coupon_good_id'] = '部分';
                }
                if($value['c_condition_money'] == "0.00"){
                    $UserCouponValidation[$key]['c_desc'] = '无条件';
                }else{
                    $UserCouponValidation[$key]['c_desc'] = "订单满".$value['c_condition_money']."元（不含运费）";
                }
           

        }
        
        if(empty($UserCouponValidation)){
            $UserCouponValidation = array();
        }

        // dump($UserCouponValidation);exit;


        output_datas($UserCouponValidation,array('result' =>"0",'error_code' =>0,'desc'=>'获取用户优惠券列表成功！'));

    }





    //判断新注册用户是否已认证的提示
    //请求方式 get
    //参数 token
    //url : 120.25.249.28/Api/Coupon/attestToAlert?token=94d6658000bbc30693b9d31989615462
    public function attestToAlert(){


        $ary_post = $this->_get();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];

        $member_info = M('Members')->field('m_create_time,attest_status')->where(array('m_id'=>$m_id))->find();
        //dump($member_info);exit;  
        $check  = 2;//初始值已认证 
        $datalist = M('CouponActivities')->where(array("ca_status"=>0))->find();
        if(!empty($datalist))
        {
            if(time() > strtotime($datalist['ca_start_time']) && time() < strtotime($datalist['ca_end_time']))
            {
                    if(strtotime($member_info['m_create_time']) > strtotime($datalist['ca_start_time']) && strtotime($member_info['m_create_time']) < strtotime($datalist['ca_end_time']))
                    {
                            if( $member_info['attest_status'] !=2)
                            {
                                 $check = 1;//新用户未认证   
                                //output_datas(null,array('result' =>"1",'error_code' =>10003,'desc'=>'您还未企业认证,请认证完才能下单！'));
                            }
                    }
            }
        }


        output_datas($check,array('result' =>"0",'error_code' =>0,'desc'=>''));

    }







    //POST请求时使用
    //request_url:http://www.xingyun.com:8080/Api/Coupon/test
    public function test(){

        $url = 'http://www.xingyun.com:8080/Api/Coupon/couponsSelect';
        // $post_data['user_name'] = '13302907442';
        $post_data['goodsList'] = '[{"g_id":"443","nums":"2"},{"g_id":"104","nums":"4"}]';
         $post_data['type'] = '1';
        $post_data['token'] = '94d6658000bbc30693b9d31989615462';
        $post_data['type'] = '1';
        $post_data['money'] = '200';
        //$post_data['type'] = '0';
        // $post_data['password'] = '11111111';
        // $post_data['category_id'] = '171';
        // $post_data['pageindex'] = '1';
        // $post_data['pagesize'] = '5';

        // $post_data['goodsid'] = '607';
        $o = "";
        foreach ( $post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url, $post_data);       
        print_r($res);

    } 




	// 请求方式：  get
	// 请求url: http://www.xingyun.com:8080/Api/Coupon/get_coupons_list?token=dd11d73ecd604e79ca13a74b15cd9177
	// Action ：get_coupons_list（固定）	
	// Token:	凭证
	// 返回data 
	// 格式: coupons_id 券ID，title 名称，desc 描述 ，type 优惠券类型（1. 体验券"，2 现金券），start_time 开始时间，end_time 结束时间 , issue_num 发行数 , claim_num 认领数 , Percent 已领取（百分比）
    //取可领优惠券列表
	public function get_coupons_list(){

		$ary_post = $this->_get();

        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        //暂不分页
        // if($ary_post['pagesize']){
        // 	 $pagesize = $ary_post['pagesize'];
        // }
        // if($ary_post['pageindex']){
        // 	 $pageindex = $ary_post['pageindex'];
        // } 
        // $offset = ($pageindex-1) * $pagesize;       
		// $ids = array($token['member_id'],0);
		// $ary_where['c_user_id'] = array('in',$ids);
        $now_time = date("Y-m-d H:i:s");
        $ary_where['p_id'] = 0;
		$ary_where['c_user_id'] = 0;
        $ary_where['c_status'] = 1;//前台显示
        $ary_where['c_end_time'] = array('EGT', $now_time);
		$ary_coupon = M('Coupon')
					->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_condition_money,c_type,c_memo,c_money,gb_id,gc_id,c_coupon_good_id,receiveNumber,txtIssueNum')
					->where($ary_where)
					//->limit($offset . ',' . $pagesize)
					->order()
                    //->distinct('c_id')
					->select();
		//echo M('Coupon')->getlastsql();exit;
		 //dump($ary_coupon);exit;
        // foreach($ary_coupon as &$value){
        //     //现在是"0000-00-00 00:00:00",转换时间格式如2013.02.13

        //         // $value['c_start_time'] = date('Y.m.d' ,strtotime($value['c_start_time']));
        //         // $value['c_end_time'] = date('Y.m.d' ,strtotime($value['c_end_time']));
        //         // $value['c_money'] = strval((int)$value['c_money']);
        //         // if($value['c_coupon_good_id'] == 'all'){
        //         //     $value['c_coupon_good_id'] = '全部';
        //         // }else{
        //         //     $value['c_coupon_good_id'] = '部分';
        //         // }
        //         // if($value['c_condition_money'] == "0.00"){
        //         //     $value['c_condition_money'] = '无条件';
        //         // }else{
        //         //     $value['c_condition_money'] = "订单满".$value['c_condition_money']."元（不含运费）";
        //         // }
            

        // }
        $coupon_user = M('couponUser', C('DB_PREFIX'), 'DB_CUSTOM');
        $UserCouponValidation = $coupon_user->field('c_id')->where(array("u_id"=>$token['member_id']))->select();
        //dump($UserCouponValidation);exit;
        foreach($UserCouponValidation as $c_id_val)
        {
            $c_id[] = $c_id_val['c_id'];
        }
        //dump($c_id);exit;
      
        
        foreach($ary_coupon as $key=>$value)
        {
            if(in_array($value['c_id'], $c_id))
            {
                $ary_coupon[$key]['over']  = 2 ;//已领取
            }else{
                $ary_coupon[$key]['over']  = 1 ;//未领取
            }

                $ary_coupon[$key]['c_start_time'] = date('Y.m.d' ,strtotime($value['c_start_time']));
                $ary_coupon[$key]['c_end_time'] = date('Y.m.d' ,strtotime($value['c_end_time']));
                $ary_coupon[$key]['c_money'] = strval((int)$value['c_money']);
                if($value['c_coupon_good_id'] == 'all'){
                    $ary_coupon[$key]['c_coupon_good_id'] = '全部';
                }else{
                    $ary_coupon[$key]['c_coupon_good_id'] = '部分';
                }
                if($value['c_condition_money'] == "0.00"){
                    $ary_coupon[$key]['c_condition_money'] = '无条件';
                }else{
                    $ary_coupon[$key]['c_condition_money'] = "订单满".$value['c_condition_money']."元（不含运费）";
                }
                $ary_coupon[$key]['c_desc'] = $ary_coupon[$key]['c_condition_money'];
                if($ary_coupon[$key]['over'] == 2){//已领取的不显示
                    unset($ary_coupon[$key]);
                //dump($v['over']);exit;
                }
                if($value['txtIssueNum'] == $value['receiveNumber']){//数量领完的不显示
                    unset($ary_coupon[$key]);
                //dump($value['txtIssueNum']);exit;
                }


        }
        //dump($ary_coupon);

        $res = $this->mymArrsort($ary_coupon,'over');
        //dump($res);exit;
        // foreach($res as $k=>$v){
        //     if($v['over'] == 2){
        //         unset($res[$k]);
        //     //dump($v['over']);exit;
        //     }
        // }
        //dump($res);exit;



        if(empty($res)){
            $res = array();
        }
		output_datas($res,array('result' =>"0",'error_code' =>0,'desc'=>''));

	}


	// 请求方式：  get
	// 请求url: http://www.xingyun.com:8080/Api/Coupon/get_usercoupons?token=dd11d73ecd604e79ca13a74b15cd9177
	// Action ：get_usercoupons（固定）	
	// Token:	凭证
	// type：status=0  未使用，status=1  已使用，status=2  已过期
	// 返回data 
    //取已领取的优惠券
	public function get_usercoupons(){

		$ary_post = $this->_get();

        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        // 暂不分页
        // if($ary_post['pagesize']){
        // 	 $pagesize = $ary_post['pagesize'];
        // }
        // if($ary_post['pageindex']){
        // 	 $pageindex = $ary_post['pageindex'];
        // } 
        // $offset = ($pageindex-1) * $pagesize;       
       
        $date = date('Y-m-d');
        $where = array();
        $where['c.c_user_id'] = $token['member_id'];
        //优惠券使用状态
        $type = $ary_post['status'];
        
            switch ($type) {
                case '0':
                    $where['c.c_is_use'] = '0';//未使用
                    $where['c.c_end_time'] = array('EGT', $date);//未过期
                    break;
                case '1':
                    $where['c.c_is_use'] = '1';//已使用
                    break;
                case '2':
                    $where['c.c_end_time'] = array('LT', $date);//已过期
                    break;
                default:
                    $where;
            }
       
        
        $ary_coupon = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')
                    //->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_type,c_memo,c_money,gb_id,gc_id,c_coupon_good_id,receiveNumber,txtIssueNum')
                    ->field('c_id,c_name,c_sn,c_start_time,c_end_time,c_is_use,c_condition_money,c_type,c_memo,c_money,gb_id,gc_id,c_coupon_good_id,receiveNumber,txtIssueNum')
                    ->alias('c')
                    //->join('fx_coupon c on c.c_id = cu.c_id')
                    ->where($where)
                    //->limit($offset . ',' . $pagesize)
                    ->order()
                    ->select();
        //echo M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')->getlastsql();exit;
        //dump($ary_coupon);exit;
        foreach($ary_coupon as $key=>$value){
            //现在是"0000-00-00 00:00:00",转换时间格式如2013.02.13

                $now_time = date("Y-m-d H:i:s");
                //dump($now_time);exit;
                if(($value['c_is_use'] == 0)&&($value['c_end_time'] <= $now_time)){
                    //dump(111);exit;
                    //$value['c_status'] = '2';//已过期  
                    $ary_coupon[$key]['c_status'] = '2';                 
                }
                if(($value['c_is_use'] == 0)&&($value['c_end_time'] > $date)){
                    //$value['c_status'] = '0';//未使用
                    $ary_coupon[$key]['c_status'] = '0';  
                }
                if(($value['c_is_use'] == 1)&&($value['c_end_time'] > $date)){
                    //$value['c_status'] = '1';//已使用
                    $ary_coupon[$key]['c_status'] = '1';  
                }

                if($value['c_coupon_good_id'] == 'all'){
                    //$value['c_coupon_good_id'] = '全部';
                    $ary_coupon[$key]['c_coupon_good_id'] = '全部';  
                }else{
                    //$value['c_coupon_good_id'] = '部分';
                    $ary_coupon[$key]['c_coupon_good_id'] = '部分';
                }
                if($value['c_condition_money'] == "0.00"){
                    //$value['c_condition_money'] = '无条件';
                    $ary_coupon[$key]['c_condition_money'] = '无条件';
                }else{
                    //$value['c_condition_money'] = "订单满".$value['c_condition_money']."元（不含运费）";
                    $ary_coupon[$key]['c_condition_money'] = "订单满".$value['c_condition_money']."元（不含运费）";
                } 
                $ary_coupon[$key]['c_desc'] = $ary_coupon[$key]['c_condition_money'];
                $ary_coupon[$key]['c_start_time'] = date('Y.m.d' ,strtotime($value['c_start_time']));
                $ary_coupon[$key]['c_end_time'] = date('Y.m.d' ,strtotime($value['c_end_time']));
                $ary_coupon[$key]['c_money'] = strval((int)$value['c_money']);                                           

        }
         //dump($ary_coupon);exit;           
        if(empty($ary_coupon)){
            $ary_coupon = array();
        }
        

		output_datas($ary_coupon,array('result' =>"0",'error_code' =>0,'desc'=>''));

	}



    // url:  120.25.249.28/Api/Coupon/couponsChoose
    // 请求方式： post
    // 请求参数  
    // Action ：couponsChoose（固定）   
    // token:  凭证
    // goodsList=[
    //     {
    //         "g_id": "588",
    //         "pdt_nums ": "5"
    //     },
    //     {
    //         " g_id ": "589",
    //         " pdt_nums ": "6"
    //     },
    //     {
    //         " g_id ": "233",
    //         " pdt_nums ": "2"
    //     }
    // ]
    public function couponsChoose(){

        $ary_post = $this->_post();

        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];

        $checkOrder = json_decode($ary_post['goodsList'],true);



        foreach ($checkOrder as $v) {
            $gIds[] = $v['g_id'];
        }
    
        $field = array(
            'fx_goods_info.g_id',
            'fx_goods.gb_id',
            'fx_related_goods_category.gc_id',
            'fx_goods_info.trade_type',
            'fx_goods_info.g_name'
        );
        $where['fx_goods_info.g_id'] = array('in', implode(',', $gIds));
        $ary_result = M('goods_info', C('DB_PREFIX'), 'DB_CUSTOM')
                        ->join('fx_goods ON fx_goods_info.g_id = fx_goods.g_id')
                        ->join('fx_related_goods_category ON fx_related_goods_category.g_id = fx_goods_info.g_id')
                        ->field($field)->where($where)->select();
                        //echo M()->getlastsql();exit;
        // dump($ary_result);exit;
        // $coupon = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM');


        foreach($ary_result as $val){           
              $gc_ids[] = $val['gc_id']; 
             
        } 

        $date = date('Y-m-d');
        $where = array();
        $where['c.c_user_id'] = $m_id;
        //优惠券使用状态

        $where['c.c_is_use'] = '0';//未使用
        $where['c.c_end_time'] = array('EGT', $date);//未过期
        $where['c.gc_id'] = array('in',$gc_ids);

        $ary_coupon = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')
                    ->field('c.c_id,c.c_name,c.c_sn,c.c_money,c.c_type,c.c_condition_money,c.c_coupon_good_id,c.c_start_time,c.c_end_time,c.gc_id,c.gb_id')
                    ->alias('c')
                    ->where($where)
                    ->order()
                    ->select();


        //echo M()->getlastsql();exit; 
        //dump($ary_coupon);exit;     
        foreach($ary_coupon as $key=>$value){           
         
            if($value['c_coupon_good_id'] == 'all'){
  
                $ary_coupon[$key]['c_coupon_good_id'] = '全部';  
            }else{
   
                $ary_coupon[$key]['c_coupon_good_id'] = '部分';
            }
            if($value['c_condition_money'] == "0.00"){

                $ary_coupon[$key]['c_condition_money'] = '无条件';
            }else{
                
                $ary_coupon[$key]['c_condition_money'] = "订单满".$value['c_condition_money']."元（不含运费）";
            } 
            $ary_coupon[$key]['c_desc'] = $ary_coupon[$key]['c_condition_money'];
            //时间转换
            $ary_coupon[$key]['c_start_time'] = date('Y.m.d' ,strtotime($value['c_start_time']));
            $ary_coupon[$key]['c_end_time'] = date('Y.m.d' ,strtotime($value['c_end_time']));

        }
 
        //dump($ary_coupon);exit;
        $new_arr = array(); 
        foreach ($ary_coupon as $ok => $ov) {
            if(isset($ov['gc_id'])){
                $new_arr[$ov['gc_id']]['gc_id'] = $ov['gc_id'];
                $new_arr[$ov['gc_id']]['couponList'][] = $ov;
                    
            }                

        }    

        $new_arr = array_values($new_arr); 
       
        //dump($new_arr);exit;
  
        output_datas($new_arr,array('result' =>"0",'error_code' =>0,'desc'=>''));    



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


    // 请求方式： post
    // url： http://www.xingyun.com:8080/Api/Coupon/test
    // Action : add_coupons
    // Token:  凭证
    // coupons_id:  优惠券ID
    // 返回data 
    // 格式:数据：
    //领取优惠券
    public function add_coupons(){

        $ary_post = $this->_post();

        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $u_id = $token['member_id'];
        $coupon = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM');
        $c_id   =  $ary_post['coupons_id'];
        $data  = $coupon->where(array("c_id"=>$c_id))->find();
        $coupon_user = M('couponUser', C('DB_PREFIX'), 'DB_CUSTOM');
        $UserCouponValidation = $coupon_user->where(array("u_id"=>$token['member_id'],'c_id'=>$c_id))->find();
        if(isset($UserCouponValidation))
        {
            
            output_datas(null,array('result' =>"1",'error_code' =>50000,'desc'=>'该优惠券已领取'));
        }
        if($data['txtIssueNum'] == $data['receiveNumber'] )
        {
 
            output_datas(null,array('result' =>"1",'error_code' =>50001,'desc'=>'该优惠券已领完！'));
        }
        $msg = $this->getCouponAdd($data,$c_id,4,8,$u_id);
        if($msg['start'] == 1)
        {
            
            output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'优惠券领取成功'));
        }else{
            output_datas(null,array('result' =>"1",'error_code' =>$code,'desc'=>''.$msg['msg'].''));
        }



    }


    /*
     * @author donkey
     * @details 生成优惠卷 
     */

    public function getCouponAdd($data, $id, $strleng, $intLeng, $u_id) {

        $ary_data = array();
        $ary_data['c_name'] = "商品已购满".$data['c_condition_money']."元，可使用".$data['c_money']."元优惠券"; //$_SESSION['Members']['m_name'] . $data['c_name']
        $ary_data['c_money'] = $data['c_money'];
        $ary_data['c_memo'] = $data['c_money'];
        $ary_data['c_start_time'] = $data['c_start_time'];
        $ary_data['c_end_time'] = $data['c_end_time'];
        $ary_data['c_condition_money'] = $data['c_condition_money'];
        $ary_data['c_is_use'] = 0;
        $ary_data['c_create_time'] = date('Y-m-d h:i:s');
        $ary_data['c_user_id'] = $u_id;
        $ary_data['c_type'] = $data['c_type'];
        $ary_data['c_coupon_good_id'] = $data['c_coupon_good_id'];
        $ary_data['gb_id'] = $data['gb_id'];
        $ary_data['gc_id'] = $data['gc_id'];
        $ary_data['p_id'] = $id;
        $ary_data['c_species']  = "1";
        $sn = $this->getRandChar($strleng) . randStr($intLeng);
        $RoleSn = $this->getCatTree($sn, $strleng, $intLeng);
        $ary_data['c_sn'] = $RoleSn;
      
        D("Coupon")->startTrans();
      
        $insert = D("Coupon")->data($ary_data)->add();
        if (false === $insert) {
            D("Coupon")->rollback();
            $message['msg'] = '优惠券表添加失败';
            $code = '50002';
            $message['start'] = 0;
            return $message;
        }
        $userCoupon = D("CouponUser");
        $userCouponID = $userCoupon->data(array(
                    "u_id" => $u_id,
                    "c_id" => $data['c_id'],
                    "c_sn" => $RoleSn,
                    "c_pid"=> $id,
                    "ru_number" => 1,
                    "ru_create_time" => $data['c_start_time'],
                    "c_end_time" => $data['c_end_time'],
                    "create_time" => date('Y-m-d h:i:s')
                ))->add();
        //echo $userCoupon->getlastsql();exit;
        if (false == $userCouponID) {
            D("Coupon")->rollback();
            $message['msg'] = '优惠券关联表添加失败';
            $code = '50003';
            $message['start'] = 0;
            return $message;
        }
        $ary_save['receiveNumber'] = $data['receiveNumber'] + 1;
        $res = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('c_sn' => $data['c_sn']))->save($ary_save);
        if (!$res) {
            D("Coupon")->rollback();
            $message['msg'] = '优惠券领取数量异常';
            $code = '50004';
            $message['start'] = 0;
            return $message;
        }
        if ($ary_save['receiveNumber'] == $data['txtIssueNum']) {
            $ary_User['c_is_use'] = 1;
            $res = M('coupon', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('c_sn' => $data['c_sn']))->save($ary_User);
            if (!$res) {
                D("Coupon")->rollback();
                $message['msg'] = '优惠券发行数量异常';
                $code = '50005';
                $message['start'] = 0;
                return $message;
            }
        }
                D("Coupon")->commit();
                $message['msg'] = '优惠券领取成功';
                $message['start'] = 1;
                return $message;
    }




    // 请求方式： get
    // 请求url： http://www.xingyun.com:8080/Api/Coupon/toCouponList?token=dd11d73ecd604e79ca13a74b15cd9177&gc_id=24&token=dd11d73ecd604e79ca13a74b15cd9177
    // Action : toCouponList
    // Token:  凭证
    // gc_id:  优惠券分类ID
    // 返回data 
    public function toCouponList(){

        $ary_post = $this->_get();




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
            
            $ary_where['gc.gc_id'] = array('in',$ary_post['gc_id']);

            if($ary_post['gc_id'] == 0){
                    $ary_where = "";
            }
            //有token才能看到会员价格
            // if(!empty($ary_post['token'])){

                // if(!$token){
                //     output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
                // }
                if($ary_post['token']){
                    $model_mb_user_token = D('MbUserToken');
                    $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
                    $ml_id = $this->get_user_level($token['member_id']);//会员等级id
                    //dump($ml_id);exit;
                    $ary_where['pmlp.ml_id'] = $ml_id;
                    if(!$token){
                        output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
                    }   
                }



            //查询字段
            $ary_fields = "g.g_id,g.g_trade,g.number_least,g.g_on_sale,gb.gb_name,g.g_update_time,gi.g_name,gi.g_cname,gi.extension_spec,gi.g_price,gi.g_market_price,gi.g_picture,gi.g_weight,gi.g_unit,gi.g_salenum,pmlp.pmlp_price,na.n_name,na.n_pic,gp.pdt_sn,gp.pdt_stock,rgc.gc_id,gc.gc_name";
      

            //必传参数
            if($ary_post['pageindex']){
                $pageindex = $ary_post['pageindex'];
            }
            if($ary_post['pagesize']){
                $pagesize = $ary_post['pagesize']; 
            }    

            $offset = ($pageindex-1) * $pagesize;

            $result = $obj->field($ary_fields)
            ->join($join_where)
            ->join("fx_goods_products as gp ON gp.g_id = g.g_id")
            ->join("fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")                
            ->where($ary_where)
            ->order()
            //->group('g.g_id')
            ->limit($offset . ',' . $pagesize)
            ->select();
            //echo $obj->getlastsql();exit;
            //dump($result);exit;
            foreach ($result as &$value) {
                $value['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];
                $value['n_pic'] = 'http://'.$_SERVER['HTTP_HOST'].$value['n_pic'];

                    //dump($token);exit;
                    if(!isset($token)){

                        $value['pmlp_price'] = '登录后可见';
                    }
                   
            }

            //dump($result);exit;
            if(empty($result)){
    
                $result = array();
                $count = 0;
            }


 
        output_datas($result,array('result' =>"0",'error_code' =>0,'desc'=>'取产品列表成功'));





    }

    /**
     * 根据用戶id得到用戶会员等级
     */
    public function get_user_level($member_id) {

        $map = array();
        $map['m_id'] = $member_id;
        $ml_id = M('Members')->where($map)->getfield('ml_id');
        return $ml_id; 
    }


    /*
     * 判断sn优惠卷唯一性
     * donkey
     */

    public function getCatTree($sn, $strleng = 4, $intLeng = 5) {

        $res = D("Coupon")->where(array('c_sn' => $sn))->find();
        if (false == $res) {
            return $sn;
        } else {
            $sn_new = $this->getRandChar($strleng) . randStr($intLeng);
            return $this->getCatTree($sn_new, $strleng, $intLeng);
        }
    }

    /*
     * 随机生成字符串
     * donkey
     */

    public function getRandChar($length) {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str.=$strPol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }


    /**
     * 根据指定字段排序二维数组，保留原有键值(降序)
     * @param $arr @输入二维数组
     * @param $var @要排序的字段名
     * return array
     */
    private function mymArrsort($arr, $var){
        $tmp=array();
        $rst=array();
        foreach($arr as $key=>$trim){
            $tmp[$key] = $trim[$var];
        }
        arsort($tmp);
        $i=0;
        foreach($tmp as $key1=>$trim1){
            $rst[$i] = $arr[$key1];
            $i++;
        }
        return $rst;
    }


}