<?php

/* 
 * desc:用户注册接口
 * author：wangpan 
 * date：2016-06-20
 * 演示地址:www.xingyun.com:8080/Api/User/test
 * request_type:POST或GET
 */
class UserAction extends CommonAction {  

    public function __construct(){
        parent::__construct();
    }

    // 请求参数： post
    // Action : register (固定)
    // invitecode :注册邀请码 （可选）
    //// Mobilecode：手机验证码
    // Mobile： 手机号
    // Password ：密码
    // email
    // user_name
    // 返回data     
    public function register()
    {
        // if(empty($_POST['mobile']) || empty($_POST['mobilecode']) || empty($_POST['password'])) {            
  
        //     output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        // }
        if($_POST['invitecode']){//邀请码可不填
            $invitecode = $_POST['invitecode'];
            $mInvitationCode = D('InvitationCode');
            //验证邀请码
            $checkCode = $mInvitationCode->checkCode($invitecode);
            if(!$checkCode){
                output_datas(null,array('result' =>"1",'error_code' =>20022,'desc'=>'邀请码不存在或已过期！'));
            }
            //修改邀请码状态           
            $modifyStatus = $mInvitationCode->modifyCodeStatus($invitecode);           
        }else{
            $invitecode = "";
        }

        $this->checkUserName($_POST['user_name']);
        $this->checkUserEmail($_POST['email']);
        // $mSmsLog = D('SmsLog');
        // $where = [];
        // $where = [
        //     'mobile' => $_POST['mobile'],
        //     'code' => $_POST['mobilecode'],
        // ];
        // $mobileCodeInfo = $mSmsLog->getSmsInfo($where);
        // if (!$mobileCodeInfo) {

        //     output_datas(null,array('result' =>"1",'error_code' =>20006,'desc'=>'手机号码或验证码错误'));        
        // }
        $mMembers = D('Members');
        // $where = [];
        // $where = [
        //     'm_mobile'   => $_POST['mobile'],
        //     'm_password'   => md5($_POST['password']),
        // ];
        // $member_info = $mMembers->getMemberInfo($where);
        // if ($member_info) {            

        //     output_datas(null,array('result' =>"1",'error_code' =>20010,'desc'=>'手机号已注册！')); 
        // }else{

            $userInfo = [
                'm_mobile'    =>  $_POST['mobile'],
                'm_password' =>  md5($_POST['password']),
                'm_name'        =>  $_POST['user_name'],
                'm_email'        =>  $_POST['email'],
                'm_recommended'        =>  $invitecode,
                'm_create_time'       =>  date('Y-m-d H:i:s'),
                'm_last_login_time'=>date('Y-m-d H:i:s'),
                'ml_id'  =>  '3',//钻石会员
                "m_status"=>'1',//启用状态
                "attest_status"=>'1',//未认证
                // "m_verify"=>'4'//待审核
                "m_verify"=>'2'//审核通过
            ];
        // }
        $mMembers->data($userInfo)->add();

        //设置其他已发送验证码无效
        D('SmsLog')->updateSms(array('check_status'=>1,'mobile'=>$_POST['mobile']),array('check_status'=>2));       
        //注册后返回用户信息,外加一个token

        $condition = array();

        $condition['_string'] = "m_name='".$_POST['mobile']."' OR m_mobile='".$_POST['mobile']."'";

        $condition['m_password'] = md5($_POST['password']);
        $member_info = $mMembers->where($condition)->find();
        //echo M()->getlastsql();exit;
        //生成token
        $token = $this->_get_token($member_info['m_id'], $member_info['m_name'],'app');
        $path="Public/images";
        $member_info['m_head_img'] = 'http://'.$_SERVER['HTTP_HOST']."/".$path."/".$member_info['m_head_img'];

        output_datas(
            array('userid'          =>      $member_info['m_id'],
                  'mobile'          =>      $member_info['m_mobile'],
                  'member_id'       =>      $member_info['m_id'],
                  'qq'              =>      $member_info['m_qq'],
                  'sex'             =>      $member_info['m_sex'],
                  'telphone'        =>      $member_info['m_telphone'],
                  'user_name'       =>      $member_info['m_name'],
                  'exp'             =>      $member_info['total_point'],
                  'area'            =>      $member_info['m_address_detail'],
                  'avatar'          =>      $member_info['m_head_img'],
                  'birthday'        =>      $member_info['m_birthday'],
                  'address'         =>      $member_info['cr_id'],
                  'token'           =>      $token
                ),
            array('result' =>"0",'error_code' =>0,'desc'=>'注册成功')
         );
   

        // output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'注册成功')); 
    }    


    /**
     * 检查用户名是否唯一
     * author:zhangdong
     * date:2016-09-09
     */
    public function checkUserName($m_name) 
    {
       
        $where = [
            'm_name'=>$m_name,
        ];
        $exitName = D('Members')->checkUserInfo($where);
        if ($exitName) {
           output_datas(null,array('result' =>"1",'error_code' =>20023,'desc'=>'该用户名已被注册，请重新输入！'));
        } 
            
    }


    /**
     * 检查用户名是否唯一(已有类似功能的函数，主要为了区分系统函数)
     * author:zhangdong
     * date:2016-09-09
     */
    public function checkUserEmail($m_email) 
    {
        
        $where = [
            'm_email'=>$m_email,
        ];
        $exitEmail = D('Members')->checkUserInfo($where);
        if ($exitEmail) {
            output_datas(null,array('result' =>"1",'error_code' =>20024,'desc'=>'该邮箱已被注册，请重新输入！'));
        } 
   
    }


    // 请求方式：get 
    // 请求参数：
    // Action ：send_verify_sms_code（固定）                        
    // mobile: 手机号
    // type    ：101 注册验证 ,102 忘记密码验证，103 账户安全验证 ,104 修改手机号码验证
    // 返回data 

    public function send_verify_sms_code() 
    {        
        $ary_post =  $this->_post();
        if(empty($ary_post['mobile'])){

            output_datas(null,array('result' =>"1",'error_code' =>20001,'desc'=>'请输入手机号!'));


        }
        //判读是不是手机格式
        $m_mobile = $ary_post['mobile'];
        if(!preg_match("/^1[0-9]{1}[0-9]{1}[0-9]{8}$/",$m_mobile)){

            output_datas(null,array('result' =>"1",'error_code' =>20002,'desc'=>'请输入正确的手机号格式！'));
        }
        if($ary_post['type'] == "101"){//如果type类型是注册
            //手机号是否已注册
            $mMembers = D('Members');
            $where = [];
            $where = [
                'm_mobile'   => $_POST['mobile'],
            ];
            $member_info = $mMembers->getMemberInfo($where);
            if($member_info){
                output_datas(null,array('result' =>"1",'error_code' =>20003,'desc'=>'该手机号已注册！'));
            }
            
        }        
        if($ary_post['type'] == "102"){//如果type类型是忘记密码
            //手机号是否已注册
            $mMembers = D('Members');
            $where = [];
            $where = [
                'm_mobile'   => $_POST['mobile'],
            ];
            $member_info = $mMembers->getMemberInfo($where);
            if(!$member_info){
                output_datas(null,array('result' =>"1",'error_code' =>20015,'desc'=>'该手机号未注册！'));
            }
            
        }
        if($ary_post['type'] == "107"){//更换手机号码验证
            //验证新手机号
            $mMembers = D('Members');
            $where = [];
            $where = [
                'm_mobile'   => $ary_post['mobile'],
            ];
            $member_info = $mMembers->getMemberInfo($where);
            if($member_info){
                output_datas(null,array('result' =>"1",'error_code' =>20018,'desc'=>'该手机号已被绑定！'));
            }
            
        }


        // $model_member = D('Members');

        // $condition = array();
        // $condition['m_name'] = $_POST['mobile'];

        // $member_info = $model_member->where($condition)->find();
        // if(!empty($member_info)){
            //判断手机号是否在60秒内已发送短信验证码
            $ary_sms_where = array();
            $ary_sms_where['check_status'] = array('neq',2);
            $ary_sms_where['status'] = 1;
            // $ary_sms_where['sms_type'] = 1;
            $ary_sms_where['mobile'] = $ary_post['mobile'];
            $ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -60 second")));
            $sms_log_count = D('SmsLog')->getCount($ary_sms_where);
            if($sms_log_count>0){
                
                output_datas(null,array('result' =>"1",'error_code' =>20004,'desc'=>'60秒后才允许重新获取验证码！'));

            }
            
            $SmsApi_obj = new SmsApi();
            //获取注册发送验证码模板
            $template_info = D('SmsTemplates')->sendSmsTemplates(array('code'=>'REGISTER_CODE'));
            $send_content = '';
            if($template_info['status'] == true){
                $send_content = $template_info['content'];
            }
            if(empty($send_content)){

                output_datas(null,array('result' =>"1",'error_code' =>20005,'desc'=>'短信发送失败！'));
            }
            $array_params=array('mobile'=>$ary_post['mobile'],'','content'=>$send_content);
            $res=$SmsApi_obj->regSmsSend($array_params);
             if($res['code'] == '200'){
                //日志记录下
                $ary_data = array();
                switch ($ary_post['type']) {// type    ：101 注册验证 ,102 忘记密码验证，103 账户安全验证 ,104 修改手机号码验证
                                case '101':
                                    $ary_data['sms_type'] = 1;
                                    break;
                                case '102':
                                    $ary_data['sms_type'] = 3;
                                    break;
                                case '103':
                                    $ary_data['sms_type'] = 5;
                                    break;
                                case '104':
                                    $ary_data['sms_type'] = 2;
                                    break;
                                    
                            }            
                $ary_data['status'] = 1;
                $ary_data['check_status'] = 1;
                $ary_data['mobile'] = $ary_post['mobile'];
                $ary_data['content'] = $send_content;
                $ary_data['code'] = $template_info['code'];
                $sms_res = D('SmsLog')->addSms($ary_data);
                if(!$sms_res){
                    writeLog('短信发送失败', 'SMS/'.date('Y-m-d').txt);
                }
                
                output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'短信发送成功！'));
            }else{

                output_datas(null,array('result' =>"1",'error_code' =>20005  ,'desc'=>'短信发送失败，'.$res['msg']));
            }
        // }else{
        //     output_datas(null,array('result' =>"1",'error_code' =>20015,'desc'=>'该手机号尚未注册')); 

        // }  
    }

    // 请求方式：post
    // 请求参数：
    // Action ：login   （固定）                        
    // username:用户名或者手机号   
    // password :密码                  
    // 返回data 
    public function login(){

        // if(empty($_POST['username']) || empty($_POST['password'])) {

  
        //     output_datas(null,array('result' =>"0",'error_code' =>20007,'desc'=>'用户名或密码不为空'));
        // } 

        $model_member = D('Members');

        $condition = array();
        // $condition['m_name'] = $_POST['user_name'];
        // if(preg_match("/^1[0-9]{10}$/",$_POST['username'])){
        //      $condition['m_mobile'] = $_POST['username'];
        // }else{
        //      $condition['m_name']   = $_POST['username'];
        // }

        $user_name = $_POST['username'];
        //现在只能用用户名登录
        $condition['_string'] = "m_name='{$user_name}' OR m_mobile='{$user_name}'";

        $condition['m_password'] = md5($_POST['password']);
        $member_info = $model_member->where($condition)->find();
         //dump($member_info);exit;
        //echo M()->getlastsql();exit;
        //TODO:
        //根据注册时间是否在优惠券可用时间范围内(fx_coupon_activities表 根据创建时间排序)，返回字段isNew


        
        if(!empty($member_info)) {
           //会员审核状态
            // if($member_info['m_verify'] != "2"){
            //     output_datas(null,array('result' =>"0",'error_code' =>20016,'desc'=>'账号正在审核中'));
            // }
            $token = $this->_get_token($member_info['m_id'], $member_info['m_name'],'app');
            $path="Public/images";
            $member_info['m_head_img'] = 'http://'.$_SERVER['HTTP_HOST']."/".$path."/".$member_info['m_head_img'];
            if($token) {
                $model_member->where($condition)->data(array('m_last_login_time'=>date('Y-m-d H:i:s')))->save();
                output_datas(
                    array('userid'          =>      $member_info['m_id'],
                          'mobile'          =>      $member_info['m_mobile'],
                          'member_id'       =>      $member_info['m_id'],
                          'qq'              =>      $member_info['m_qq'],
                          'sex'             =>      $member_info['m_sex'],
                          'telphone'        =>      $member_info['m_telphone'],
                          'user_name'       =>      $member_info['m_name'],
                          'exp'             =>      $member_info['total_point'],
                          'area'            =>      $member_info['m_address_detail'],
                          'avatar'          =>      $member_info['m_head_img'],
                          'birthday'        =>      $member_info['m_birthday'],
                          'address'         =>      $member_info['cr_id'],
                          'attest_status'   =>      $member_info['attest_status'],//2已认证
                          'token'           =>      $token
                        ),
                    array('result' =>"0",'error_code' =>0,'desc'=>'登录成功')
                 );
            } else {

                    output_datas(null,array('result' =>"1",'error_code' =>20008,'desc'=>'登录失败'));                
            }

        } else {


                output_datas(null,array('result' =>"1",'error_code' =>20009,'desc'=>'用户名或密码错误'));   
        }

    }  


      /**
     * 登录生成token
     */
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

            output_datas(null,array('result' =>"1",'error_code' =>10001,'desc'=>'错误的请求token'));  
        }

    }

    // 请求方式：post
    // 请求参数：
    // Action ：reset_password（固定）                      
    // mobilecode: 手机验证码   
    // mobile  ：手机号
    // password :密码            
    // 返回data 
    public function reset_password(){

        if(empty($_POST['mobile']) || empty($_POST['mobilecode']) || empty($_POST['password'])) {            

            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $mSmsLog = D('SmsLog');
        $where = [];
        $where = [
            'mobile' => $_POST['mobile'],
            'code' => $_POST['mobilecode'],
        ];
        $mobileCodeInfo = $mSmsLog->getSmsInfo($where);
        if (!$mobileCodeInfo) {

            output_datas(null,array('result' =>"1",'error_code' =>20006,'desc'=>'手机号码或验证码错误'));        
        }
        $mMembers = D('Members');
        $codition = [];
        $codition = [
            'm_name'   => $_POST['mobile'],
        ];
        $userInfo = [
            'm_password' =>  md5($_POST['password']),
            'm_update_time'       =>  date('Y-m-d H:i:s'),

        ];
        
        $mMembers->where($codition)->data($userInfo)->save();
        //echo $mMembers->getlastsql();exit;
        
        output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'您的密码已修改成功，请记住新密码！')); 


    }

 
    public function test(){

        $url = 'http://www.xingyun.com:8080/Api/User/register';
        $post_data['mobile'] = '18825500158';
        $post_data['mobilecode'] = '3364';
        $post_data['password'] = '11111111';
        $post_data['invitecode'] = 'aaa2';
        $post_data['type'] = '102';
        $post_data['username'] = '18825500151';
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


    
}//end of class
