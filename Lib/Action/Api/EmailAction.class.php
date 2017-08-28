<?php

/* 
 * 发送邮件类接口 
 * author：zhangdong
 * date：2016.08.08
 *
 */
class EmailAction extends CommonAction {    
    
    /**
     * 发送邮箱--中英文页面用
     * @author zhangdong
     * @date 2016.08.08
     * @url：http://tianxy.com/Api/Email/sendEmail
     */
    public function sendEmail()
    {
        $data = $_REQUEST;
        $reEmailAddr = 'marketing@xyb2b.com';
    if (!$data['userName']||!$data['emailAddr']||!$data['mobilePhone']||!$data['companyName']||!$data['message']) {
            return $this->ajaxReturn(["status"=>2,"msg"=>"名字、邮箱地址、电话号码、邮箱内容等不能为空！"]);
        }        
        //验证邮箱地址的合法性
	$email_preg = '/^[a-z0-9._%+-]+@(?:[a-z0-9-]+.)+[a-z]{2,4}$/i';
        if (!preg_match($email_preg, $data['emailAddr'])) {
            return $this->ajaxReturn(["status"=>3,"msg"=>"邮箱格式不正确！"]);
        }
        //验证手机号码
	$mobile_preg = '/^1[3|4|5|8|7][0-9]\d{8}$/i';
        if (!preg_match($mobile_preg, $data['mobilePhone'])) {
            return $this->ajaxReturn(["status"=>4,"msg"=>"手机号码格式不正确！"]);
        }
        $emailContent = '用户名称：'.$data['userName'].',<br>用户邮箱地址：'.$data['emailAddr'].',<br>用户手机号码：'.$data['mobilePhone'].',<br>用户公司名称：'.$data['companyName'].',<br>邮箱内容：'.$data['message'];
        $subject = "来自中文/英文官网的客户留言";
        $result = M('sys_config')->where("sc_module = 'GY_SMTP'")->select();
        foreach ($result as $value) {
            $email = [
                $value['sc_key']=>$value['sc_value'],               
            ];
            $emailConfig[array_keys($email)[0]] = array_values($email)[0];
        }
        
        $ary_option = array(
            'receiveMail' => trim($reEmailAddr),
            'subject' => trim($subject),
            'message' => trim($emailContent),
            'from' => trim($emailConfig['GY_SMTP_FROM']),
            'fromName' => trim($emailConfig['GY_SMTP_FROM_NAME']),
            'host' => trim($emailConfig['GY_SMTP_HOST']),
            'port' => intval($emailConfig['GY_SMTP_PORT']),
            'smtpAuth' => intval($emailConfig['GY_SMTP_AUTH']),
            'username' => trim($emailConfig['GY_SMTP_NAME']),
            'password' => trim($emailConfig['GY_SMTP_PASS']),
            'isHtml' => true,
        );
        //发送邮件
        $email = new Mail();
        $sendStatus = $email->sendMail($ary_option);
        if (!$sendStatus) {       
            return $this->ajaxReturn(["status"=>0,"msg"=>"failure"]);
        }        
        return $this->ajaxReturn(["status"=>1,"msg"=>"success"]);        
    }
    /**
     * 发送认证邮箱--个人中心的认证
     * @author zhangdong
     * @date 2016.09.18
     * @url：http://tianxy.com/Api/Email/sendAuditEmail
     */
    public function sendAuditEmail()
    {
        $data = $_REQUEST;
        $reEmailAddr = '1039562325@qq.com';
        if (!$data['userName']||!$data['mobilePhone']||!$data['message']) {
            return $this->ajaxReturn(["status"=>2,"msg"=>"名字、电话号码、邮箱内容等不能为空！"]);
        }    
        //验证手机号码
	$mobile_preg = '/^1[3|4|5|8|7][0-9]\d{8}$/i';
        if (!preg_match($mobile_preg, $data['mobilePhone'])) {
            return $this->ajaxReturn(["status"=>4,"msg"=>"手机号码格式不正确！"]);
        }
        $emailContent = '用户名称：'.$data['userName'].',<br>用户手机号码：'.$data['mobilePhone'].',<br>邮箱内容：'.$data['message'];
        $subject = "用户认证提示";
        $result = M('sys_config')->where("sc_module = 'GY_SMTP'")->select();
        foreach ($result as $value) {
            $email = [
                $value['sc_key']=>$value['sc_value'],               
            ];
            $emailConfig[array_keys($email)[0]] = array_values($email)[0];
        }
        
        $ary_option = array(
            'receiveMail' => trim($reEmailAddr),
            'subject' => trim($subject),
            'message' => trim($emailContent),
            'from' => trim($emailConfig['GY_SMTP_FROM']),
            'fromName' => trim($emailConfig['GY_SMTP_FROM_NAME']),
            'host' => trim($emailConfig['GY_SMTP_HOST']),
            'port' => intval($emailConfig['GY_SMTP_PORT']),
            'smtpAuth' => intval($emailConfig['GY_SMTP_AUTH']),
            'username' => trim($emailConfig['GY_SMTP_NAME']),
            'password' => trim($emailConfig['GY_SMTP_PASS']),
            'isHtml' => true,
        );
        //发送邮件
        $email = new Mail();
        $sendStatus = $email->sendMail($ary_option);
        if (!$sendStatus) {       
            return $this->ajaxReturn(["status"=>0,"msg"=>"failure"]);
        }        
        return $this->ajaxReturn(["status"=>1,"msg"=>"success"]);        
    }
    
}//end of class

