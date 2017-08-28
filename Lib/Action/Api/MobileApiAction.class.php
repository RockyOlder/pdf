<?php

/* 
 * 移动端接口调用
 * author：zhangdong
 * date：2016-06-29
 */
class MobileApiAction extends CommonAction {
    
    const MODIFY_ACCOUNT_PASSWORD = 103;//修改账号密码
    const MODIFY_MOBILE = 104;//修改手机号码
    const SET_PASSWORD = 105;//设置支付密码
    const MODIFY_PAY_PASSWORD = 106;//修改支付密码

    /**
     * desc 控制器基类初始化
     * @author zhangdong
     * @date 2016.06.29    
     */
    public function __construct()
    {
        parent::__construct();
    }
     /**
     * desc 修改、设置支付密码及修改用户密码
     * method：post 
     * @author zhangdong
     * @date 2016.06.29
     * url: http://tianxy.com/Api/MobileApi/revisePassword
     */
    public function revisePassword()
    {
        $data = $_REQUEST;
        $type = $data['type'];//修改类型(103,修改账号密码；104,修改手机号码；105,设置支付密码；106,修改支付密码)
        $mobile = $data['mobile'];//用户绑定手机号
        $oldPassword = $data['oldPassword'];//旧密码
        $newPassword = $data['newPassword'];//新密码
        $strLength = strlen(trim($newPassword));
        if($strLength>16 || $strLength<6){
            output_datas(null,['result'=>'1','desc'=>'密码长度应在6-16位之间！']);
        }
        $mMembers = D('Members');
        $condition = [
            'm_mobile'=>$mobile,
        ];
        $userInfo = $mMembers->getMemberInfo($condition);        
        if(!$userInfo){
            output_datas(null,['result'=>'1','desc'=>'没有此用户']);
        }        
        if($type == self::MODIFY_ACCOUNT_PASSWORD){//修改账号密码
            $oldPass = $userInfo['m_password'];
            $md5OldPass = md5(trim($oldPassword));
            if($md5OldPass != $oldPass){
                output_datas(null,['result'=>'1','desc'=>'原登录密码错误']);
            }
            $userPass = true;
            $result = $this->modifyPassword($mobile, $newPassword, $userPass);
            if (!$result) {
                output_datas(null,['result'=>'1','desc'=>'修改登录密码失败！']);
            }
            output_datas(null,['result'=>'0','desc'=>'success']);
            
        }else if ($type == self::MODIFY_PAY_PASSWORD){//修改支付密码
            $oldPass = $userInfo['pay_password'];
            $md5OldPass = md5(trim($oldPassword));
            if($md5OldPass != $oldPass){
                output_datas(null,['result'=>'1','desc'=>'原支付密码错误']);
            }
            $result = $this->modifyPassword($mobile, $newPassword);
            if (!$result) {
                output_datas(null,['result'=>'1','desc'=>'修改支付密码失败！']);
            }
            output_datas(null,['result'=>'0','desc'=>'success']);
            
        } else if($type == self::SET_PASSWORD) { //设置支付密码
            $result = $this->modifyPassword($mobile, $newPassword);
//            if (!$result) {
//                output_datas(null,['result'=>'1','desc'=>'设置支付密码失败！']);
//            }
            output_datas(null,['result'=>'0','desc'=>'success']);
        }
        
    }//end of function
    
    /**
     * 修改用户登录或支付密码
     * @author zhangdong
     * @date 2016-06-18
     */
    protected function modifyPassword($mobile, $password, $userPass=false)
    {
        $pay_password = md5(trim($password));
        if(!$userPass){
            $members = [
                'pay_password' => $pay_password,
            ];
        } else {
            $members = [
                'm_password' => $pay_password,
            ];
        }        
        $where = [
            'm_mobile'=>$mobile,
        ];
        $result = M("members")->where($where)->save($members);
        //设置其他已发送验证码无效
        D('SmsLog')->updateSms(array('check_status'=>1,'mobile'=>$mobile),array('check_status'=>2));  
        return $result;
    }
    
    /**
     * desc 修改用户手机号码
     * method：post 
     * @author zhangdong
     * @date 2016.07.08
     * url: http://tianxy.com/Api/MobileApi/reviseMobile?userid=xxx&newMobile=xxx&mobileCode=xxx
     */
    public function reviseMobile()
    {
        $data = $_REQUEST;
        $userId = intval($data['userid']);
        $newMobile = trim($data['newMobile']);
        $mobileCode = trim($data['mobileCode']);
        $mMembers = M("members");
        $mobileWhere = [
            'm_mobile'=>$newMobile,
        ];
        $checkMobile = $mMembers->where($mobileWhere)->find();
        if($checkMobile){
            output_datas(null,['result'=>'1','desc'=>'该手机号码已被绑定！']);
        }
        //根据手机号码检查短信验证码是否正确--10分钟内有效
        $checkMobileCode = $this->checkMobileCode($mobileCode, $newMobile);
        if($checkMobileCode == 1000){
            output_datas(null,['result'=>'1','desc'=>'手机验证码不能为空！']);
        }else if($checkMobileCode == 1001){
            output_datas(null,['result'=>'1','desc'=>'手机验证码有误!']);
        }else if($checkMobileCode == 1003){
            output_datas(null,['result'=>'1','desc'=>'验证码不存在或已过期!']);
        }
        $members = [
            'm_mobile' => $newMobile,
        ];              
        $where = [
            'm_id'=>$userId,
        ];
        $result = $mMembers->where($where)->save($members);
        //设置其他已发送验证码无效
        D('SmsLog')->updateSms(array('check_status'=>1,'mobile'=>$newMobile),array('check_status'=>2));   
        if(!$result){
            output_datas(null,['result'=>'1','desc'=>'修改用户手机号码失败！']);
        }
        output_datas(null,['result'=>'0','desc'=>'success']);
    }
     
    /**
    * desc 检查手机验证码
    * author zhangdong
    * date 2016.07.08
    */
    protected function checkMobileCode($mobileCode, $mobile) {
        //判读是不是手机格式
        if(empty($mobileCode)){
            return 1000;//手机验证码不能为空
        }
        $where = [];
        $where = [
            'check_status'=>1,
            'status'=>1,
            'mobile'=>$mobile,
            'sms_type'=>0,
            'code'=>$mobileCode,            
            //'create_time'=>['egt',date("Y-m-d H:i:s", strtotime(" -90 second"))],            
        ];       
        $sms_log = D('SmsLog')->getSmsInfo($where);
        if(empty($sms_log)){
            return 1003;//验证码不存在或已过期
        }
        if($sms_log['code'] != $mobileCode){
            return 1001;//手机验证码有误
        }
        return 1002;       
    }
    
    
    
    
}
