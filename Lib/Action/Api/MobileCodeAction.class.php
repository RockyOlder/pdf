<?php

/**
 * @author zhangdong
 * @desc 移动端获取短信验证码
 * @date：2016.4.19
 */

class MobileCodeAction extends GyfxAction
{
    /**
     * desc 移动端发送验证短信
     * @author zhangdong
     * @date 2016.04.12
     * url: http://tianxy.com/Api/MobileCode/sendMobileCode
     */
    public function sendMobileCode() 
    {        
        $ary_post =  $this->_post();
        if(empty($ary_post['m_mobile'])){
            $this->ajaxReturn(array('status'=>0,'msg'=>'请输入手机号'));
        }
        //判读是不是手机格式
        $m_mobile = $ary_post['m_mobile'];
        if(!preg_match("/^1[0-9]{1}[0-9]{1}[0-9]{8}$/",$m_mobile)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'请输入正确的手机号格式！'));
        }        
        //判断手机号是否在90秒内已发送短信验证码
        $ary_sms_where = array();
        $ary_sms_where['check_status'] = array('neq',2);
        $ary_sms_where['status'] = 1;
        $ary_sms_where['sms_type'] = 2;
        $ary_sms_where['mobile'] = $ary_post['m_mobile'];
        $ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
        $sms_log_count = D('SmsLog')->getCount($ary_sms_where);
        if($sms_log_count>0){
            $this->ajaxReturn(array('status'=>0,'msg'=>'90秒后才允许重新获取验证码！'));
        }
        
        $SmsApi_obj = new SmsApi();
        //获取注册发送验证码模板
        $template_info = D('SmsTemplates')->sendSmsTemplates(array('code'=>'REGISTER_CODE'));
        $send_content = '';
        if($template_info['status'] == true){
            $send_content = $template_info['content'];
        }
        if(empty($send_content)){
            $this->ajaxReturn(array('status'=>0,'msg'=>'短信发送失败！'));
        }
        $array_params=array('mobile'=>$ary_post['m_mobile'],'','content'=>$send_content);
        $res=$SmsApi_obj->regSmsSend($array_params);
         if($res['code'] == '200'){
            //日志记录下
            $ary_data = array();
            $ary_data['sms_type'] = 1;
            $ary_data['mobile'] = $ary_post['m_mobile'];
            $ary_data['content'] = $send_content;
            $ary_data['code'] = $template_info['code'];
            $sms_res = D('SmsLog')->addSms($ary_data);
            if(!$sms_res){
                writeLog('短信发送失败', 'SMS/'.date('Y-m-d').txt);
            }
            $this->ajaxReturn(['status'=>1,'msg'=>'短信发送成功！','mobile'=>$m_mobile]);
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'短信发送失败，'.$res['msg']]);
        }
    }
  
    
}//end of class
