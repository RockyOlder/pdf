<?php

/* 
 * desc:个人信息接口
 * author：wangpan 
 * date：2016-06-21
 * 演示地址:www.xingyun.com:8080/Api/Ucenter/test
 * request_type:POST或GET
 */
class UcenterAction extends CommonAction {
    
	public function __construct(){
		parent::__construct();
	}


	// 请求方式： get
	// 请求参数：
	// action=get_userinfo 固定

	// Token:	凭证 
	public function get_userinfo(){

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
        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->where($condition)->find();
        //echo M("Members")->getlastsql();exit;
        //dump($member_info);exit;
        $path="Public/images";
        $member_info['m_head_img'] = 'http://'.$_SERVER['HTTP_HOST']."/".$path."/".$member_info['m_head_img'];
        if($member_info){
                            output_datas(
                    array('userid'          =>      $member_info['m_id'],
                          'mobile'          =>      $member_info['m_mobile'],
                          //'member_id'       =>      $member_info['member_id'],
                          //'qq'              =>      $member_info['m_qq'],
                          'sex'             =>      $member_info['m_sex'],
                          'telphone'        =>      $member_info['m_telphone'],
                          'user_name'       =>      $member_info['m_name'],
                          'exp'             =>      $member_info['total_point'],
                          'area'            =>      $member_info['m_address_detail'],
                          'avatar'          =>      $member_info['m_head_img'],
                          'birthday'        =>      $member_info['m_birthday'],
                          'email'           =>      $member_info['m_email'],
                          //'address'         =>      $member_info['cr_id'],

                        ),
                    array('result' =>"0",'error_code' =>0,'desc'=>'null')
                 );
        }


	}


    // 请求方式： post
    // 请求参数： 
    // action=set_userinfo 固定
    // Token:  凭证
    // sex :性别
    // email: email
    // birthday:出生日期
    // file：头像
    // 返回data 
    public function set_userinfo(){

        $ary_post = $this->_post();

        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        //正则验证邮箱，出生日期
        // if(!preg_match("/^((?:19|20)\d\d)-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/",$ary_post['birthday'])){
        //     output_datas(null,array('result' =>"1",'error_code' =>30001,'desc'=>'日期格式不正确'));//规定格式2016-06-01
        //     exit();
        // } 
        // if(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$ary_post['email'])){
        //     output_datas(null,array('result' =>"1",'error_code' =>30002,'desc'=>'邮箱格式不正确'));//规定格式2016-06-01
        //     exit();
        // } 

        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $condition = array();
        $condition['m_id'] = $m_id;
        $savedata = array();
        if($ary_post['birthday']){
            $savedata['m_birthday'] = $ary_post['birthday'];
        }elseif ($ary_post['email']){
            $savedata['m_email'] = $ary_post['email'];
        // }elseif ($_FILES['file']){
        //     $savedata['m_head_img'] = $_FILES['file'];
        }elseif(isset($ary_post['sex'])){
            $savedata['m_sex'] = $ary_post['sex'];
        }elseif ($_FILES['file']) {
            # code...
        

            $path="Public/images";
            if(!is_dir($path))
            {
                mkdir($path,0777,true);
            }
            

            // print_r($members);
            // 头像上传
            $head_img=$_FILES['file'];
            if($head_img['name']!=="")
            {
                $head_img['name']=md5($head_img['name'].time()).substr($head_img['name'], strpos($head_img['name'],"."));
                move_uploaded_file($head_img['tmp_name'], $path."/".$head_img['name']);
                $savedata['m_head_img']=$head_img['name'];
            }

            // $upload = new UploadFile();// 实例化上传类
            // $upload->maxSize  = 3145728 ;// 设置附件上传大小
            // $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            // $upload->savePath =  './Public/Uploads/'.CI_SN.'/links/';// 设置附件上传目录
            // if(!$upload->upload()) {// 上传错误提示错误信息
            //     //$this->error($upload->getErrorMsg());
            //     output_datas(null,array('result' =>"1",'error_code' =>30003,'desc'=>'上传失败'));
            // }else{// 上传成功 获取上传文件信息
            //     $info =  $upload->getUploadFileInfo();
            //     $savedata['m_head_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/Public/Uploads/'.CI_SN.'/links/' . $info[0]['savename'];
            // }            
        }        
        // $savedata['m_birthday'] = $ary_post['birthday'];
        // $savedata['m_email'] = $ary_post['email'];
        // $savedata['m_sex'] = $ary_post['sex'];
        // $savedata['m_head_img'] = $ary_post['file'];
        $member_info = M("Members")->where($condition)->data($savedata)->save();
        //echo M("Members")->getlastsql();exit;
        
        output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'账户资料已修改成功！'));
        
    }


    // 请求方式： get
    // 请求参数： 
    // Action: get_amount(固定)
    // Token:  凭证
    // 返回data 
    public function get_amount(){
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
        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->field('m_balance,m_status,pay_password,freeze_balance')->where($condition)->find();
        if(empty($member_info['pay_password'])){
            $flag = 0;
        }else{
            $flag = 1;
        } 
        $newarr = array();
        $newarr['is_set'] = $flag;
        $newarr['m_balance'] = $member_info['m_balance'];
        $newarr['m_status'] = $member_info['m_status'];
        $ary_where_info['bi_withdrawal'] = array('neq','0');//账户提现
        $ary_where_info['bi_verify_status'] = array('neq',2);//有效
        $ary_where_info['bi_finance_verify'] = array('neq',1);//未财审
        $ary_where_info['m_id'] = $m_id;
        
        // $balace_type  = M('balance_type', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('bt_id' => 4))->find();
        //提现中的金额
        $balace_count = M('balance_info', C('DB_PREFIX'), 'DB_CUSTOM')->field('SUM(bi_money) as bi_money')->where($ary_where_info)->find();
        //echo M()->getlastsql();exit;
        //dump($balace_count);exit;
        if(empty($balace_count['bi_money'])){
            $balace_count['bi_money'] = '0.00';
        }
        $newarr['freeze_balance'] = $balace_count['bi_money'];//提现中的金额
        $freeze_balance_total = sprintf('%0.2f',$member_info['m_balance'] - $balace_count['bi_money']);//可提现金额
        if($freeze_balance_total < 0){
            $freeze_balance_total = '0.00';
        }
        $newarr['ok_balance'] = $freeze_balance_total;//可使用的余额
        output_datas($newarr,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功！'));

    }




    // 请求方式：get
    // 请求参数：Action ：pageDepositClick（固定）
    // token:  凭证

    // 返回data 
    public function pageDepositClick(){

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
        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->field('m_balance,m_status,pay_password')->where($condition)->find();
        if(empty($member_info['pay_password'])){
            $flag = 0;
        }else{
            $flag = 1;
        } 

        $newarr = array();
        $newarr['result'] = '0';
        $newarr['error_code'] = '0';
        $newarr['desc'] = '';
        $newarr['data']['is_set'] = $flag;    
        $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);
        echo $json;die;

    }







    // 请求方式： GET
    // 请求url： http://www.xingyun.com:8080/Api/Ucenter/checkVerification?mobile=18825500151&mobilecode=9837&type=105
    // Action : checkVerification (固定)
    // mobile： 手机号
    // mobilecode：手机验证码
    //type  ：101 注册验证 ,102 忘记密码验证，103 账户密码修改安全验证 ,104 修改手机号码验证,105支付密码安全验证 


    // 返回data 
    // 格式:数据：
    public function checkVerification(){//账户安全

        $ary_post = $this->_post();
        if(empty($ary_post['mobile']) || empty($ary_post['mobilecode'])) {            
  
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }

        $mSmsLog = D('SmsLog');
        $where = [];
        $where = [
            'mobile' => $ary_post['mobile'],
            'code' => $ary_post['mobilecode'],
            'check_status' => '1'
        ];
        $mobileCodeInfo = $mSmsLog->getSmsInfo($where);
        if (!$mobileCodeInfo) {

            output_datas(null,array('result' =>"1",'error_code' =>20017,'desc'=>'验证码不存在或已过期'));        
        }
        if($ary_post['type'] == '105') {//如果是修改支付密码验证
            $pay_password = M('Members')->where(array('m_name'=>$ary_post['mobile']))->getfield('pay_password');            
            if(empty($pay_password)){
                $flag = 0;
            }else{
                $flag = 1;
            }
        $newarr = array();
        $newarr['result'] = '0';
        $newarr['error_code'] = '0';
        $newarr['desc'] = '验证码正确';
        $newarr['data']['is_set'] = $flag;    
        $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);
        echo $json;die;

        }
        

        output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'success')); 



    }


    // 请求方式： 
    // 请求参数： POST
    // Action : reviseMobile (固定)
    // newmobile：新手机号
    // mobilecode：验证码

    // 返回data 
    // public function reviseMobile(){

    //     $ary_post = $this->_post();


    //     //验证新手机号
    //     $mMembers = D('Members');
    //     $where = [];
    //     $where = [
    //         'm_name'   => $ary_post['newmobile'],
    //     ];
    //     $member_info = $mMembers->getMemberInfo($where);
    //     if($member_info){
    //         output_datas(null,array('result' =>"1",'error_code' =>20018,'desc'=>'该手机号已被绑定！'));
    //     }

    //     $mSmsLog = D('SmsLog');
    //     $condition = [];
    //     $condition = [
    //         'mobile' => $ary_post['newmobile'],
    //         'code' => $ary_post['mobilecode'],
    //     ];
    //     $mobileCodeInfo = $mSmsLog->getSmsInfo($condition);
    //     if (!$mobileCodeInfo) {

    //         output_datas(null,array('result' =>"1",'error_code' =>20017,'desc'=>'验证码不正确'));        
    //     }

    //     $data = array();
    //     $data['m_mobile'] = $ary_post['newmobile'];     
    //     $result = M("Members")->where($where)->save($data);
    //     if(!$result){
    //         output_datas(null,array('result' =>"1",'error_code' =>20019,'desc'=>'修改手机号码失败！')); 
    //     }

    //     output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'success')); 

    // }



    public function test(){

        $url = 'http://www.xingyun.com:8080/Api/Ucenter/reviseMobile';
        $post_data['mobile'] = '18825500151';
        $post_data['mobilecode'] = '4789';
        $post_data['password'] = '123456';
        $post_data['type'] = '101';
        $post_data['username'] = '18825500151';
        $post_data['birthday'] = '2016-02-20';
        $post_data['sex'] = '1';
        $post_data['email'] = '888@qq.com';
        $post_data['file'] = 'www.baidu.com';
        $post_data['token'] = '237c3e69bad23b0e0a56866fdb12faea';
        $post_data['order_amount'] = '0.01';
        $post_data['payment_id'] = '1';
        $o = "";
        foreach ( $post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url, $post_data);       
        print_r($res);

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

}
