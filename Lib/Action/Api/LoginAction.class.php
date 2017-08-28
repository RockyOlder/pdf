<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class LoginAction extends CommonAction {
    
	public function __construct(){
		parent::__construct();
	}
    
    	public function index(){
  
        if(empty($_POST['username']) || empty($_POST['password']) || !in_array($_POST['client'], $this->client_type_array)) {
             output_error(null,array('Role' =>0,'error'=>'登录失败'));
        }
        $model_member = D('Members');
        $array = array();
        if(preg_match("/^1[0-9]{10}$/",$_POST['username'])){
             $array['m_mobile']	= $_POST['username'];
        }else{
             $array['m_name']	= $_POST['username'];
        }
        $array['m_password']	= md5($_POST['password']);
        $member_info = $model_member->getMemberInfo($array);
        if(!empty($member_info)) {
           
            $token = $this->_get_token($member_info['m_id'], $member_info['m_name'], $_POST['client']);
            if($token) {
            
                output_data(
                    array('userid'          =>      $member_info['m_id'],
                          'mobile'          =>      $member_info['m_mobile'],
                          'member_id'       =>      $member_info['member_id'],
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
                    array('Role' =>1,'error'=>null)
                 );
            } else {
                output_error(null,array('Role' =>0,'error'=>'登录失败'));
            }
        } else {
            output_error(null,array('Role' =>0,'error'=>'用户名密码错误'));
        }
    }
    
      /**
     * 登录生成token
     */
    private function _get_token($member_id, $member_name, $client) {
        $model_mb_user_token = D('MbUserToken');
     
        //重新登录后以前的令牌失效
        //暂时停用
        $condition = array();
        $condition['member_id'] = $member_id;
        $condition['client_type'] = $_POST['client'];
        $model_mb_user_token->delMbUserToken($condition);
  
        //生成新的token
        $mb_user_token_info = array();
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0,999999)));
        $mb_user_token_info['member_id'] = $member_id;
        $mb_user_token_info['member_name'] = $member_name;
        $mb_user_token_info['token'] = $token;
        $mb_user_token_info['login_time'] = time();
        $mb_user_token_info['client_type'] = $_POST['client'];

        $result = $model_mb_user_token->addMbUserToken($mb_user_token_info);

        if($result) {
            return $token;
        } else {
            return null;
        }

    }  
}
