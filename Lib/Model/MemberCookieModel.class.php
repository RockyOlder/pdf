<?php

/**
 * 管理员日志Model
 *
 * @package Model
 * @stage 7.1
 * @author czy<chenzongyao@guanyisoft.com>
 * @date 2013-04-01
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class MemberCookieModel extends GyfxModel {
    
     /**
     * 构造方法
     * @author listen
     * @date 2012-12-14
     */
    public function __construct() {
        parent::__construct();
    }
    /**
     * 查询方法
     * @author Rocky
     */
    private function GetModelMemberCookieEnquiries($where){
        $return =  $this->where($where)->find();
        if($return){
            return $return;
        }
        return false;
    }
    /**
     * 变更或新增cookie信息
     * @author Rocky
     */
    public function DataMemberSave($where){
        $SelectTokenDataFind = $this->GetModelMemberCookieEnquiries(array('m_id'=>$where['m_id']));
        if(empty($SelectTokenDataFind)){
             $this->DataMemberAddCookie($where);
        } else {
            $this->DataMemberSaveCookie($where, $SelectTokenDataFind);
        }
        session('Members', $where);
        
    }
    /**
     * @author Rocky <john.doe@example.com>
     * @param type $where
     */
    private function DataMemberAddCookie($where){
        $add_member_cookie = array();
        $add_member_cookie['m_id'] = $where['m_id'];
        $add_member_cookie['key'] =  md5($where['m_id'].time());
        $add_member_cookie['create_time'] = time();
        $add_member_cookie['update_time'] = time();
        $add_member_cookie['login_click'] = 1;
        if($this->add($add_member_cookie)){
             cookie('userToken',$add_member_cookie['key'],3600 * 86400);
             return  true;
        } else {
            return false;
        }
    }
    /**
     * save cookie data
     * @author Rocky
     * @param type $where
     * @param type $SelectTokenDataFind
     * @return type bool
     */
    private function DataMemberSaveCookie($where,$SelectTokenDataFind){
        
        $save_member_cookie = array();
        $key =   md5($where['m_id'].time());
        if($SelectTokenDataFind['key'] !=  cookie('userToken') ){
             $save_member_cookie['key'] =$key;
             cookie('userToken',$key,3600 * 86400);
        }
        $save_member_cookie['update_time'] = time();
        $save_member_cookie['login_click'] = $SelectTokenDataFind['login_click'] +1;
        return $this->where(array('m_id'=>$where['m_id']))->save($save_member_cookie);
        
    }
    /**
     * 单元测试 DataMemberSaveCookie 方法
     * @author Rocky
     */
    public function TestDataMemberSaveCookie($where,$SelectTokenDataFind){
        return $this->DataMemberSaveCookie($where, $SelectTokenDataFind);
    }
    /**
     * 单元测试 DataMemberAddCookie 方法
     * @author Rocky
     */
    public function TestDataMemberAddCookie($where){
        return $this->DataMemberAddCookie($where);
    }
    
    /**
     * 单元测试 GetModelMemberCookieEnquiries 方法
     * @author Rocky
     */
    public function TestGetModelMemberCookieEnquiries($where){
        return $this->GetModelMemberCookieEnquiries($where);
    }
}