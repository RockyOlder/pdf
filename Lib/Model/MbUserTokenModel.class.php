<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MbUserTokenModel extends GyfxModel {
    private $member;
    private $memberCookie;


    public function __construct() {
        parent::__construct();
        $this->member = D('Members');
        $this->memberCookie = D('MemberCookie');
    }
     public function getMbUserTokenInfo($condition) {
        return $this->where($condition)->find();
    }

    public function addMemberTokenKey($member_id, $member_name){
        
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0,999999)));
        if(!empty($token)){
            $this->getMeberTokenSave($token, $member_id);
        }
        return $token;
    }

    public function getMeberTokenSave($token,$m_id){
        
        return $this->where(array('m_id'=>$m_id))->save(array('token'=>$token));
    }


    public function getMbUserTokenInfoByToken($token) {
        if(empty($token)) {
            return null;
        }
        return $this->getMbUserTokenInfo(array('token' => $token));
    }
    
    public function getMemberLoginStateUpdateToken($token){
        $user_token = $this->getMbUserTokenInfoByToken($token);
        if(!empty($user_token)){
                $member_find_select = $this->member->getMemberInfoByID($user_token['m_id']);
                $db_get_cookie = $this->memberCookie->where(array('m_id'=>$member_find_select['m_id']))->find();
                if(!empty($db_get_cookie)){
                         cookie('userToken',$db_get_cookie['key'],3600 * 86400);
                } else {
                        $key = md5($member_find_select['m_id'].time());
                        $add_member_cookie = array();
                        $add_member_cookie['m_id'] = $member_find_select['m_id'];
                        $add_member_cookie['key'] = $key;
                        $add_member_cookie['create_time'] = time();
                        $add_member_cookie['update_time'] = time();
                        $add_member_cookie['login_click'] = 1;
                        $this->memberCookie->add($add_member_cookie);
                        cookie('userToken',$key,3600 * 86400);
                }
                session('Members', $member_find_select);
                return $this->addMemberTokenKey($member_find_select['m_id'], $member_find_select['m_name']);
        }
        return FALSE;

    }

    /**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addMbUserToken($param){
            return $this->data($param)->add();
	}
	
	/**
	 * 删除
	 *
	 * @param int $condition 条件
	 * @return bool 布尔类型的返回结果
	 */
	public function delMbUserToken($condition){
        return $this->where($condition)->delete();
	}	
}
