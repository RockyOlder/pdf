<?php

/**
 * 前台模版首页生成
 *
 * @package Action
 * @subpackage Home
 * @stage 7.0
 * @author zuojianghua <zuojianghua@guanyisoft.com>
 * @date 2013-04-01
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class IndexAction extends HomeAction {

    protected $dir = '';


    /** 下载客户端链接 */
    const USER_DOWNLOAD_LINK = '/tags/create?';
    
    /** 未登录 */
    const USER_PRISSIONS_STATUS_0  = 0;   
    
    /** 表示上传成功 */
    const USER_PRISSIONS_STATUS_1  = 1;   

    /** 文件格式不对 */
    const USER_PRISSIONS_STATUS_2  = 2;   
    
    /** 上传失败 */
    const USER_PRISSIONS_STATUS_3  = 3;   
    
    /** 文件太大 */
    const USER_PRISSIONS_STATUS_4  = 4;   
    
    /** 授权不足，非充值用户,大于5M文件 */
    const USER_PRISSIONS_STATUS_5  = 5;   
    
    /** 使用次数已不足 */
    const USER_PRISSIONS_STATUS_6  = 6;   
    
    /** 时间额度已不足 （改成转换中）*/
    const USER_PRISSIONS_STATUS_7  = 7;  
    
    /** 文件已重复 */
    const USER_PRISSIONS_STATUS_8  = 8;   
    
    /** 文件已重复 */
    const USER_PRISSIONS_STATUS_9  = 9;   
    
    /** 内存不足 */
    const USER_PRISSIONS_STATUS_10  = 10;   
    
    /** 文档需要密码 */
    const USER_PRISSIONS_STATUS_11  = 11;   
    
    /** 文档已损坏,无法打开 */
    const USER_PRISSIONS_STATUS_12  = 12;   
    
    /** 文档保存失败 */
    const USER_PRISSIONS_STATUS_13  = 13;   
    
    /** 运行环境错误 */
    const USER_PRISSIONS_STATUS_14  = 14;   
    
    /** 转换失败 */
    const USER_PRISSIONS_STATUS_16  = 16;   
    
    /** 上传状态 */
    public $status;
    
    public $maxSize = 20971520;


    /** 消息提示 */
    public static $error_msg = array(
        '未登录',
        '上传成功',
        '文件格式不对',
        '上传失败',
        '文档大小超出限制请尝试客户端转换',
        '文档大小超出限制请充值后重试',
        '每日可免费转换一次50页PDF',
        '时间额度已不足',
        '文件重复',
        '您上传的文档超过数量（10个），请清理列表后，再重新上传',
        '内存不足',
        '文档需要密码',
        '文档已损坏',
        '文档保存失败',
        '运行环境错误',
    );
    /**  前台显示状态  */
    public static $ajax_msg = array(
        'successful',
        'failure',
        'await',
        'start',
        'on'
    );
    /**  文件大小类型  */
    public static $file_type_size = array(
        'Bytes',
        'KB',
        'MB',
        'GB',
        'TB'
    );
    
    /** 格式状态 */
    public $format;

    /** 文件格式 */
    public $cSuffix;
    
    /** 文档格式 */
    public $suffix_file_postfix;
    
    /** 文件字节 */
    public $file_Size_data;
    
    public $success;
    
    public $resState;
    
    public $number_page_pdf = 0;
    
    public $user_file_upload_weatherCities;

    public static $ary_member;


    public function _initialize() {
        parent::_initialize();
        static::$ary_member =  D('Members')->getMemberInfo(array('m_id'=>$_SESSION['Members']['m_id']),'m_id,m_email,m_name,Free_authorization,Free_obtain_time,end_time,number_remaining,conversion_type,open_source,open_id');
        $this->assign('ary_member', static::$ary_member);
      // $Member_object = D('Members')->where(array('m_id'=>4))->find();
       //session('Members', $Member_object);
    }
    public function getHeaderData(){
        $this->display();
    }
    public function ceshi(){
        set_time_limit(0);
         $members = session('Members');
          $email = new Mail();
          //echo $queue_lsize = $this->queue_lsize($members['open_id'],'SendEmail:');exit;
    //  $all_data_email = cls_redis::get(md5('SendEmailAll:'.$members['open_id']));
             $table = '<table style="border-collapse:collapse;width:900px;text-align:center;font-size:14px;color:#444;" cellspacing="0" cellpadding="0">';
            $table .= '
                     <thead>
                        <tr>
                           <th style="border:1px solid #caddea;padding:6px 10px;">文档名称</th>
                           <th style="border:1px solid #caddea;padding:6px 10px;">下载截止时间</th>
                           <th style="border:1px solid #caddea;padding:6px 10px;">操作</th>
                       </tr>
                    </thead>
            <tbody>';
            $all_data_email = cls_redis::get(md5('SendEmailAll:'.$members['open_id']));
                $all_data_email_array = json_decode($all_data_email,true);

                foreach($all_data_email_array as $value){
                        $Useremail = $value['email'];
                         
                        $table .='<tr><td  style="border:1px solid #caddea;padding:6px 10px;">'.$value['fileName'].'</td><td  style="border:1px solid #caddea;padding:6px 10px;">'. date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').'+3 day')).'</td><td  style="border:1px solid #caddea;padding:6px 10px;"><a href="http://www.baidu.com" target="_blank">下载</a></td></tr>';
                }
                $table .="</tbody></table>";
                $ary_option = D('EmailTemplates')->sendEmailFile($Useremail, count($all_data_email_array), $table);
                if ($email->send($ary_option)) {
                $ary_data = array();
                $ary_data['email_type'] = 1;
                $ary_data['email'] = $Useremail;
                $ary_data['content'] = $ary_option['message'];
                $sms_res = D('EmailLog')->addEmail($ary_data);
                if (!$sms_res) {
                    writeLog(json_encode($ary_data), date('Y-m-d') . "send_email.log");
                }
            }
        echo 1;exit;
    //  print_r($all_data_email);exit;
//         $table = '<table style="border-collapse:collapse;" cellspacing="0" cellpadding="0">';
//    $table .='<thead>
//            <tr>
//                <th style="border:1px solid #caddea;">文档名称</th>
//                <th style="border:1px solid #caddea;">下载截止时间</th>
//                <th style="border:1px solid #caddea;">操作</th>
//            </tr>
//        </thead>
//        <tbody>
//            <tr>
//                <td style="border:1px solid #caddea;">xxx</td>
//                <td style="border:1px solid #caddea;">xxx</td>
//                <td style="border:1px solid #caddea;">xxx</td>
//            </tr>
//        </tbody>';
//    $table .="</table>";
//    echo $table;exit;
//           echo $queue_lsize = $this->queue_lsize($members['open_id'],'SendEmail:');exit;
//          make_fsockopen('/Script/Batch/SendTimingEmail',array('open_id'=> self::$ary_member['open_id']));
//          exit;
       
      //  $EmailTemplates = D('EmailTemplates');
     
             //writeLog(111111,date('Y-m-d')."send_email_time_1.log");
        //$queue_lsize = 1;
        while( $queue_lsize=  $this->queue_lsize($members['open_id'],'SendEmail:'))
        { 
          $data = $this->queue_rpop($members['open_id'],'SendEmail:');
            $EmailLogTime = D('EmailLog')->where(array('status'=>1,'email'=>'574920453@qq.com'))->order('create_time desc')->getField("create_time");
//            //   writeLog(json_encode($data),date('Y-m-d')."send_email_data.log");
//            if((strtotime($EmailLogTime)+30) > time()){
//                 writeLog(111111,date('Y-m-d')."send_email_time_1.log");
//                sleep(30);
//            }
            $table = '<table> <tr><th>文档名称</th><th>下载截止时间</th><th>操作</th><tr>';
            $table .='<tr><td>'.$data['fileName'].'</td><td>'. date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').'+3 day')).'</td><td><a href="http://www.baidu.com" target="_blank">下载</a></td></tr>';
            $table .="</table>";
            print_r($table);exit;
            $ary_option = D('EmailTemplates')->sendEmailFile($data['email'], 1, $table);
            print_r($ary_option);exit;
            if ($email->send($ary_option)) {
                $ary_data = array();
                $ary_data['email_type'] = 1;
                $ary_data['email'] = '574920453@qq.com';
                $ary_data['content'] = 'xxxx';
                $sms_res = D('EmailLog')->addEmail($ary_data);
                if (!$sms_res) {
                    writeLog(json_encode($ary_data), date('Y-m-d') . "send_email.log");
                }
                //$queue_lsize++ ;
              //  sleep(30);
            }
        }
         echo 1;exit;
         
         
//        $aa = D("Members")->where(array('m_id'=>4))->getField("m_email");
//        print_r($aa);exit;
//        $EmailLog = D('EmailLog')->field('create_time,id')->where(array('status'=>1,'email'=>'574920453@qq.com'))->order('create_time desc')->find();
//        print_r($EmailLog);exit;
//        $data_1 = strtotime('2017-08-18 16:50:17');
//        $data_2 = strtotime('2017-08-18 16:49:17');
     //   echo $data_1- $data_2;exit;
                   $EmailLogTime = D('EmailLog')->where(array('status'=>1,'email'=>'574920453@qq.com'))->order('create_time desc')->getField("create_time");
                   if((strtotime($EmailLogTime)+30) > time()){
                echo (strtotime($EmailLogTime)+30) - time();exit;
                sleep((strtotime($EmailLogTime)+30) - time());
            }
        $data = $this->queue_lsize($members['open_id'],'SendEmail:');
        print_r($data);exit;
        $this->redirect('http://ucenter.wiserar.com/uploadFile/currentfile/20170912/4/pdf/%E5%A4%A7%E5%90%8C%E4%BC%98%E8%BD%A6%E6%B1%BD%E8%BD%A6%E9%94%80%E5%94%AE%E6%9C%8D%E5%8A%A1%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8%E5%B9%BF%E5%91%8A%E6%8A%95%E6%94%BE%E7%AD%96%E5%88%92%E6%A1%881505145600_1505145600.pdf');exit;
       // $count =  $ary_member = D("Members")->where(array('m_create_time'=>array('BETWEEN',array('2017-08-11 00:00:00','2017-08-31 23:59:59'))))->count();
        //echo $count;exit;
        $select =  $ary_member = D("Members")->field('m_id')->where(array('m_create_time'=>array('BETWEEN',array('2017-07-10 00:00:00','2017-08-10 23:59:59'))))->select();
        //$count  = D('PaymentSerial')->where(array('ps_create_time'=>array('BETWEEN',array('2017-07-10 00:00:00','2017-08-10 23:59:59')),'ps_status'=>1))->group('m_id')->count();
        
      //  $select  = D('PaymentSerial')->where(array('ps_create_time'=>array('BETWEEN',array('2017-08-11 00:00:00','2017-08-10 23:59:59'))))->group('m_id')->select();
        $i = 0;
        foreach($select as $value){
           $data =  D('PaymentSerial')->where(array('m_id'=>$value['m_id'],'ps_status'=>1))->count();
            if($data >= 1){
                $i ++;
            }
        }
        echo $i;exit;
      
    }
    /**
     * 客户模版默认首页
     * @author
     * @date
     */
    public function index() {
        //C("LAYOUT_ON",false);
        if( !empty($this->_get('token'))){
            $mb_user_token_info = D('MbUserToken')->getMbUserTokenInfoByToken($this->_get('token'));
            if(!empty($mb_user_token_info)){
                     $members = D('Members')->getMemberInfoByID($mb_user_token_info['m_id']);
                     D('MemberCookie')->DataMemberSave($members);
            }
        }
        if(empty(session('Members'))){
                   $member =  cls_redis::get(cookie('openid'));
                   $member_arr = json_decode($member, true);
                   if(!empty($member)){
                               $ary_member = D("Members")->where(array('m_id'=>$member_arr['m_id']))->find();
                               cls_redis::set($ary_member['open_id'],json_encode($ary_member));
                               session('Members', $member_arr);
                               cookie('openid',$member_arr['open_id'],3600*24);	
           }
        } 
        $halfMonther = self::getActivitp();
        if(!empty($halfMonther)){
            $this->assign('start_time',date('Y-m-d H:i:s'));
            $this->assign('halfMonther',date('Y-m-d H:i:s',$halfMonther));
            $this->assign('year',date('Y',$halfMonther));
            $this->assign('month',date('m',$halfMonther));
            $this->assign('day',date('d',$halfMonther));
        }else {
             $this->assign('ACTIVITY_OPEN',1);
        }
        $this->setTitle('首页','TITLE_INDEX','KEY_INDEX','DESC_INDEX');
        $this->assign('header_tag_highlighted', 3);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/index.html';
        $this->display($tpl); 
    }
    private static function getActivitp(){
            $ary_data = D('SysConfig')->getCfgByModule('GY_SHOP');
            if($ary_data['ACTIVITY_OPEN'] ==true) {
                    if(time() > $ary_data['ACTIVITPPROJECT_TIME'] )
                    {
                        if(time () < $ary_data['ACTIVITPPROJECT_end_TIME'] )
                        {
                            return $ary_data['ACTIVITPPROJECT_end_TIME'];
                        }
                    }
            }
            return false;
    }

    public function boot_page() {
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/Boot_page.html';
        $this->display($tpl); 
    }
    public function CoreBusiness(){
        if( !empty($this->_get('token'))){
            $mb_user_token_info = D('MbUserToken')->getMbUserTokenInfoByToken($this->_get('token'));
            if(!empty($mb_user_token_info)){
                    $members = D('Members')->getMemberInfoByID($mb_user_token_info['m_id']);
                     D('MemberCookie')->DataMemberSave($members);
            }
        }
        $halfMonther = self::getActivitp();
        if(!empty($halfMonther)){
            $this->assign('start_time',date('Y-m-d H:i:s'));
            $this->assign('halfMonther',date('Y-m-d H:i:s',$halfMonther));
            $this->assign('year',date('Y',$halfMonther));
            $this->assign('month',date('m',$halfMonther));
            $this->assign('day',date('d',$halfMonther));
        }else {
             $this->assign('ACTIVITY_OPEN',1);
        }
        $ary_member = self::$ary_member;
        if(!empty($ary_member)){
            if($ary_member['Free_authorization'] != self::USER_PRISSIONS_STATUS_1){
                    if(time() > strtotime($ary_member['Free_obtain_time'].'+1 day')){
                                D('Members')->where(array('m_id'=>$ary_member['m_id']))->data(array('Free_authorization'=>1,'Free_obtain_time'=> date('Y-m-d')))->save();
                    }
            }
        }
        $this->setTitle('开始转换','TITLE_INDEX','KEY_BRAND','DESC_BRAND');
        $tpl = FXINC . '/Public/Tpl/' . CI_SN . '/' . TPL . '/CoreBusiness.html';
        $this->assign('header_tag_highlighted', 4);
        $pdf_type = $this->_get('pdf_type');
        if(empty($pdf_type)){
            $pdf_type  = 0 ;
        }
        $this->assign("pdf_type",$pdf_type);
        $this->assign("Boot_page",FXINC . '/Public/Tpl/' . CI_SN . '/' . TPL . '/Boot_page.html');
        $this->display($tpl);
        
    }
    public function weixinlogin(){
         $config = D('SysConfig');
            $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
            $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);    
        if(!empty($ary_status['wx']) && $ary_status['wx'] == '1'){
            $arr_data = json_decode($logindata['THDDATA']['sc_value'],TRUE);
            $this->assign('wxid',$arr_data['wxid']);
            $this->assign('wxkey',$arr_data['wxkey']);
            $_SESSION['wx_rand'] = rand();
            $this->assign('wxrand',$_SESSION['wx_rand']);
            $this->assign('wxloginstatus',$ary_status['wx']);
            $uri = 'Home/User/getToken';
			$ary_shop_data = D('SysConfig')->getCfgByModule('GY_SHOP',1);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$uri;
			if(!empty($ary_shop_data['GY_SHOP_HOST'])){
				$url = $ary_shop_data['GY_SHOP_HOST'].$uri;
			}
            $redirect_uri = urlencode($url);
            $this->assign('wx_redirect_uri',$redirect_uri);
        }
        if(!empty($this->_post('redirect'))){
             cookie('redirect',$this->_post('redirect'),180);
        } else {
             cookie('redirect',$_SERVER['HTTP_REFERER'],180);
        }
        $this->assign($ary_status);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/weixinlogin.html';
        $this->display($tpl);
        
    }
    public function Clientapiweixinlogin(){
         $state  = md5(uniqid(rand(), TRUE));
        $config = D('SysConfig');
         $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
          $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);   
        if(!empty($ary_status['wx']) && $ary_status['wx'] == '1'){
            $arr_data = json_decode($logindata['THDDATA']['sc_value'],TRUE);
            $_SESSION['wx_rand'] = $state;
            $uri = 'Home/User/ApigetToken';
			$ary_shop_data = D('SysConfig')->getCfgByModule('GY_SHOP',1);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$uri;
			if(!empty($ary_shop_data['GY_SHOP_HOST'])){
				$url = $ary_shop_data['GY_SHOP_HOST'].$uri;
			}
        }
        
     //   cookie('redirect',$_SERVER['REDIRECT_URL'],180);	
        $callback = urlencode($url);
        $wxurl = C('WEIXIN_LOGIN')."?appid=".$arr_data['wxid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
        $weixin_html_preg = requests::get($wxurl);
         preg_match('/<img[^>]*?src=\"(.*?)\"[^>]*?>/ism', $weixin_html_preg, $collectImg);
         $wx_code = str_replace('/connect/qrcode/', '', $collectImg[1]);
         //print_r($wx_code);exit;
        $this->assign('wx_code',$wx_code);
        $this->assign('wx_img',$collectImg[1]);
        $this->assign($ary_status);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/Clientapiweixinlogin.html';
        $this->display($tpl);
        
    }
    
    public function NewClientapiweixinlogin(){
        $state  = md5(uniqid(rand(), TRUE));
        $config = D('SysConfig');
         $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
          $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);   
        if(!empty($ary_status['wx']) && $ary_status['wx'] == '1'){
            $arr_data = json_decode($logindata['THDDATA']['sc_value'],TRUE);
            $_SESSION['wx_rand'] = $state;
            $uri = 'Home/User/ApigetToken';
			$ary_shop_data = D('SysConfig')->getCfgByModule('GY_SHOP',1);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$uri;
			if(!empty($ary_shop_data['GY_SHOP_HOST'])){
				$url = $ary_shop_data['GY_SHOP_HOST'].$uri;
			}
        }
        $arr_data['wx_redirect_uri'] = $url;
        cookie('redirect',$_SERVER['REDIRECT_URL'],180);	
        $this->assign($arr_data);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/NewClientapiweixinlogin.html';
        $this->display($tpl);
        
    }

    public function upload() {
        set_time_limit(0);
        $formatList = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf');
        $files = $_FILES;
        foreach ($files as $value) {
            $fileInfo['file']['name'] = $value['name'][self::USER_PRISSIONS_STATUS_0];
            $fileInfo['file']['type'] = $value['type'][self::USER_PRISSIONS_STATUS_0];
            $fileInfo['file']['tmp_name'] = $value['tmp_name'][self::USER_PRISSIONS_STATUS_0];
            $fileInfo['file']['error'] = $value['error'][self::USER_PRISSIONS_STATUS_0];
            $fileInfo['file']['size'] = $value['size'][self::USER_PRISSIONS_STATUS_0];
        }

        $seesion = session('Members');
        if (!empty($seesion)) {
            $userinfo = self::$ary_member;
            $this->maxSize = 1024 * 1024 * 20;
        } else {
            $this->ajaxReturn(array('status' => self::USER_PRISSIONS_STATUS_1, 'files' => array('state' => self::USER_PRISSIONS_STATUS_0, 'error_msg' => self::$error_msg[self::USER_PRISSIONS_STATUS_0])), 'EVAL');
        }
        //文件上传限制
        $count = D("PdfList")->where(array('m_id' => $seesion['m_id'], 'fstate' => array('neq', 99), 'delete_remove' => array('neq', 1), 'fsize' => array('neq', 0)))->count();
        if (($count + self::USER_PRISSIONS_STATUS_1) > 10) {
            $this->ajaxReturn(array('status' => self::USER_PRISSIONS_STATUS_1, 'files' => array('state' => self::USER_PRISSIONS_STATUS_9, 'error_msg' => self::$error_msg[self::USER_PRISSIONS_STATUS_9])), 'EVAL');
        }
        $ip = getIp(); //获取ip
        $this->user_file_upload_weatherCities = APP_PATH . 'uploadFile/weatherCities/';
        if (!empty($fileInfo)) {
            foreach ($fileInfo as $fileList) {

                //判断文档格式
                $this->suffix_file_postfix = strtolower(substr($fileList['name'], strrpos($fileList['name'], '.') + self::USER_PRISSIONS_STATUS_1));
                //判定格式
                if (in_array($this->suffix_file_postfix, $formatList)) {
                    $this->format = self::USER_PRISSIONS_STATUS_1;
                } else {
                    $this->format = self::USER_PRISSIONS_STATUS_0;
                }
                $this->file_Size_data = $fileList['size'];
                if ($this->format == self::USER_PRISSIONS_STATUS_1) {

                    $uploadPaths = $this->user_file_upload_weatherCities . date('Ymd') . '/' . $seesion['m_id'] . '/' . $this->suffix_file_postfix;
                    if (!is_dir($uploadPaths)){
                        mkdir($uploadPaths, 0777, true);
                    }
                    if (!is_readable($uploadPaths)){
                        chmod($uploadPaths, 0777);
                    }
                    $fileTime = strtotime(date('Y-m-d'));
                    $fileNameInfo = safe_replace($fileList["name"]); //去掉特殊字符
                    //转换文件名
                    if (is_utf8($fileNameInfo)) {
                        $fileNames = iconv('utf-8', 'gbk//IGNORE', $fileNameInfo);
                    } else {
                        $fileNames = $fileNameInfo;
                    }
                    $fileNames = substr($fileNames, self::USER_PRISSIONS_STATUS_0, strrpos($fileNames, '.')) . '_' . $fileTime . '.' . $this->suffix_file_postfix;
                    $md5_file = md5_file($uploadPaths . '/' . $fileNames);
                   if(!empty($md5_file)){
                        $info = D("PdfList")->where(array('m_id' => $seesion['m_id'], 'md5_file' => $md5_file, 'delete_remove' => array('neq', 1), 'fstate' => array('neq', 99)))->find();
                   }
                    if ($this->suffix_file_postfix != 'pdf') {
                        $this->cSuffix = 'pdf';
                    } else {
                        $this->cSuffix = 'docx';
                    }
                    $cFileName = substr($fileNames, self::USER_PRISSIONS_STATUS_0, strrpos($fileNames, '.')) . '.' . $this->cSuffix;
                    if ($fileList['error'] > self::USER_PRISSIONS_STATUS_0) {
                                $this->status = getErrorState($fileList['error']);
                    } else if ($this->file_Size_data >= $this->maxSize) {
                                $this->status = self::USER_PRISSIONS_STATUS_4; //文件太大，充值用户只能上传小于20M的文档
                    } else  { //(!file_exists($uploadPaths . '/' . $fileNames))
                           if (!empty($info)) {
                             
                            $this->status = self::USER_PRISSIONS_STATUS_8;  //文件重复
                        }else {
                            $a = move_uploaded_file($fileList["tmp_name"], $uploadPaths . "/" . $fileNames);
                            if ($a) {
                                $this->status = self::USER_PRISSIONS_STATUS_1; //上传成功
                                chmod($uploadPaths . "/" . $fileNames, 0777);
                            } else {
                                $this->status = self::USER_PRISSIONS_STATUS_3; //上传失败
                            }
                            $md5_file = md5_file($uploadPaths . '/' . $fileNames);
                        }
                    } 
//                    else {
//                        $this->status = self::USER_PRISSIONS_STATUS_1; //文件已有
//                        if (!empty($info)) {
//                            $this->status = self::USER_PRISSIONS_STATUS_8;  //文件重复
//                        }
//                    }
                } else {
                    $this->status = self::USER_PRISSIONS_STATUS_2;
                }
                $suffixName = getSuffix($this->suffix_file_postfix); //判定文件格式名称
                if (!is_utf8($cFileName)) {
                    $cFileName = iconv('gbk', 'utf-8//IGNORE', $cFileName);
                }
            }
            if($this->suffix_file_postfix  == 'pdf'){
                    if(($userinfo['conversion_type'] == self::USER_PRISSIONS_STATUS_0 && $userinfo['Free_authorization']  !=  self::USER_PRISSIONS_STATUS_1  ) || ($userinfo['conversion_type'] == self::USER_PRISSIONS_STATUS_1 && $userinfo['number_remaining'] == self::USER_PRISSIONS_STATUS_0   && $userinfo['Free_authorization']  !=  self::USER_PRISSIONS_STATUS_1)){
                        $user_pdf_count =  D("PdfList")->where(array('m_id' => $seesion['m_id'], 'ftype' => 'pdf', 'cstate' =>array('neq', 0), 'delete_remove' => array('neq', 1)))->count();
                        if($user_pdf_count >= 1){
                              $this->status = self::USER_PRISSIONS_STATUS_6;
                         }
                    }
            }
      
           if($this->suffix_file_postfix  == 'pdf'){
             $this->number_page_pdf = countPdfPage($uploadPaths . '/' . $fileNames);
                if($this->number_page_pdf < 0 || empty($this->number_page_pdf)){
                    switch ($this->number_page_pdf){
    //                    case -1:
    //                     $this->status = self::USER_PRISSIONS_STATUS_10;
    //                     break;
                        case 0:
                         $this->status = self::USER_PRISSIONS_STATUS_12;
                         break;
                        case -2:
                         $this->status = self::USER_PRISSIONS_STATUS_11;
                         break;
                        case -3:
                         $this->status = self::USER_PRISSIONS_STATUS_12;
                         break;
    //                    case -4:
    //                     $this->status = self::USER_PRISSIONS_STATUS_13;
    //                     break;
                        case $this->number_page_pdf < -500000:
                            $this->number_page_pdf = -(500000+ $this->number_page_pdf);
                            $fileNames = $fileNames."_decryp.pdf";
                            //$this->status = self::USER_PRISSIONS_STATUS_1;
                         break;
                     default :
                         $this->status = self::USER_PRISSIONS_STATUS_3;
                         //$this->status = self::USER_PRISSIONS_STATUS_14;
                    }
                    if($this->number_page_pdf < 0){
                        $this->number_page_pdf  = 0;
                    }
                  //  $this->status = self::USER_PRISSIONS_STATUS_3; //上传失败
                }
           }
            if (!is_utf8($fileNames)) {
                $fileNames = iconv('gbk', 'utf-8//IGNORE', $fileNames);
            }
            if (getSuffix($this->suffix_file_postfix) != 'PDF') {
                $ctype = 'PDF';
            } else {
                $ctype = 'Word';
            }
            $fpath = '';
            $fpath = C('HOST_DOWNLOAD') . '/uploadFile/weatherCities/' . date('Ymd') . '/' . $seesion['m_id'] . '/' . $this->suffix_file_postfix . '/' . $fileNames;
            $time = trim($fileTime) ? $fileTime : time();
            $postfix = $fileTime;
            $addList = array();
            $addList['m_id'] = $userinfo['m_id'];
            $addList['fname'] = addslashes($fileList['name']);
            if($this->suffix_file_postfix == 'pdf'){
                $addList['number_page'] = $this->number_page_pdf;
            }
            $addList['ftype'] = $this->suffix_file_postfix;
            $addList['ctype'] = $ctype;
            $addList['fsize'] = $this->file_Size_data;
            $addList['fpath'] = addslashes($fpath);
            $addList['ftime'] = $time;
            $addList['ip'] = $ip;
            $addList['fstate'] = $this->status;
            $addList['timestamp'] = $time;
            $addList['postfix'] = $postfix;
            $addList['crate_time'] = time();
            $addList['cname'] = addslashes($fileNames);
            $addList['md5_file'] = $md5_file;
            $info['id'] = D("PdfList")->GetListAdd($addList);
            if ($this->status == self::USER_PRISSIONS_STATUS_1) {
                $this->success = self::$ajax_msg[self::USER_PRISSIONS_STATUS_0];
            } else {
                $this->success = self::$ajax_msg[self::USER_PRISSIONS_STATUS_1];
            }
            $json = array(
                'success' => $this->success,
                'id' => $info['id'],
                'name' => $fileList['name'],
                'state' => $this->status,
                'md5file' => $md5_file,
                'formatState' => $this->format,
                'suffixName' => $suffixName,
                'size' => $this->file_Size_data,
                'suffix' => $this->suffix_file_postfix,
                'fileTime' => $fileTime,
                'time' => time(),
                'pdf_authorization' => 1,
                'number_page_pdf'=>$this->number_page_pdf,
                'downIp' => $ip,
                'fName' => $cFileName,
                'tname' => $fileInfo['file']['name'],
                'error_msg' => self::$error_msg[$this->status]
            );
            if($this->status != self::USER_PRISSIONS_STATUS_8){
                make_fsockopen('/Script/Batch/ScwsFileNameAddData',array('id'=>$info['id'],'m_id'=>$userinfo['m_id'],'fname'=>$addList['fname']));
            }

            $this->ajaxReturn(json_encode(array('status' => self::USER_PRISSIONS_STATUS_1, 'files' => $json)), 'EVAL');
        }
    }


    public function SelectGetMember(){
        $this->ajaxReturn(array('action'=>1,'success'=>static::$ary_member));
    }
    /**
     * 表示文件上传成功
     */
    public function upload_name_save(){
        $fileInfoList = $_POST['fileInfo'];
        $fileJsonCode = json_decode($fileInfoList);
         D("PdfList")->where(array('m_id'=>$_SESSION['Members']['m_id'],'id'=>$fileJsonCode->id))->data(array('c_fsiz_state'=>2))->save();
    }
    /**
     * 添加文件重复状态
     */
    public function upload_cype_save(){
        $fileInfoList = $_POST['fileInfo'];
        $fileJsonCode = json_decode($fileInfoList);
         D("PdfList")->where(array('m_id'=>$_SESSION['Members']['m_id'],'id'=>$fileJsonCode->id))->data(array('c_type_state'=>2))->save();
    }
    public function upload_state_save(){
        $fileInfoList = $_POST['fileInfo'];
        $fileJsonCode = json_decode($fileInfoList);
         D("PdfList")->where(array('m_id'=>$_SESSION['Members']['m_id'],'id'=>$fileJsonCode->fileId))->data(array('fstate'=>9))->save();
    }
    public function upload_state_six(){
        $fileInfoList = $_POST['fileInfo'];
        $fileJsonCode = json_decode($fileInfoList);
         D("PdfList")->where(array('m_id'=>$_SESSION['Members']['m_id'],'id'=>$fileJsonCode->fileId))->data(array('fstate'=>6))->save();
    }
    public function batchConversion(){
         set_time_limit(0);
	$fileInfo   = $_FILES;
	$ip         = getIp();//获取ip
        $member  =  session('Members');
        if(isset($_POST['fileInfo'])){

                $fileInfoList = $_POST['fileInfo'];
                $fileJsonCode = json_decode($fileInfoList);
                $conversion   = 0;
                foreach($fileJsonCode as $fileData){
                        if(!$fileData)continue;

                        $reqFile = $fileData->fileName;
                        $fileData->suffix  = str_replace('.','',$fileData->suffix);
                        $this->suffix_file_postfix   = getSuffixType($fileData->fileType);//获取后缀
                        $fileData->fileName = safe_replace($fileData->fileName);//去掉特殊字符
                        $fileData->fileName = substr($fileData->fileName,0,strrpos($fileData->fileName,'.')).'_'.$fileData->fileTime.'.'.$fileData->suffix;
                        $data_add_file = array();
                        $data_add_file['conversion_format']  = $this->suffix_file_postfix ;   //转换格式
                        $data_add_file['format']  = $fileData->suffix;  //原本格式
                        $data_add_file['fileSize']  = $fileData->fileSize; //文件大小
                        $data_add_file['id']  = $fileData->id; //文件大小
                        $data_add_file['m_id']  = $member['m_id']; //用户id
                        if(!empty($fileData->email)){
                            $data_add_file['email']  = $fileData->email; //用户id
                        }
                        if(!empty($fileData->batchEmail)){
                              $data_add_file['batchEmail']  = $fileData->batchEmail; //用户邮箱发送
                        }
                        $md5Data  = md5(json_encode($data_add_file));
                        $md5Data_time = $md5Data."_time";
                        cls_redis::set($md5Data_time,microtime(true),3000);
                        cls_redis::set($md5Data,10,3000);
                        $this->queue_lpush($data_add_file);
                        $conversion  = self::USER_PRISSIONS_STATUS_1;
                        if($this->status  == self::USER_PRISSIONS_STATUS_1  || $this->status == self::USER_PRISSIONS_STATUS_2){
                                $conversion  = self::USER_PRISSIONS_STATUS_1;
                                cls_redis::del($md5Data);
                        } else {
                                if(empty(cls_redis::get($md5Data_time))){
                                    $this->status  = self::USER_PRISSIONS_STATUS_5;   //这个暂定为时间过期
                                    cls_redis::del($md5Data);
                                }
                        }
                        
                        $json[] = array('m_id'=>$member['m_id'],'fileType'=>$fileData->fileType,'fileName'=>$reqFile,'downIp'=>$ip,'fileSize'=>$fileData->fileSize,'fileState'=>$this->status,'conversion'=>$conversion);
                }
                $this->ajaxReturn(array('action'=>1,'conversion'=>$conversion,'success'=>$json));
        }
        
    }
    
    public function batchConversionAjax(){
         set_time_limit(0);
	$fileInfo   = $_FILES;
	$ip         = getIp();//获取ip
        $member  =  session('Members');
        if(isset($_POST['fileInfo'])){
                $fileInfoList = $_POST['fileInfo'];
                $fileJsonCode = json_decode($fileInfoList);
                $conversion   = 0;
                foreach($fileJsonCode as $fileData){
                        if(!$fileData)continue;
                        $reqFile = $fileData->fileName;
                        $fileData->suffix  = str_replace('.','',$fileData->suffix);
                        $this->suffix_file_postfix   = getSuffixType($fileData->fileType);//获取后缀
                        $fileData->fileName = safe_replace($fileData->fileName);//去掉特殊字符
                        $fileData->fileName = substr($fileData->fileName,0,strrpos($fileData->fileName,'.')).'_'.$fileData->fileTime.'.'.$fileData->suffix;
                        $data_add_file = array();
                        $data_add_file['conversion_format']  = $this->suffix_file_postfix ;   //转换格式
                        $data_add_file['format']  = $fileData->suffix;  //原本格式
                        $data_add_file['fileSize']  = $fileData->fileSize; //文件大小
                        $data_add_file['id']  = $fileData->id; //文件大小
                        $data_add_file['m_id']  = $member['m_id']; //用户id
                        if(!empty($fileData->email)){
                            $data_add_file['email']  = $fileData->email; //用户id
                        }
                        if(!empty($fileData->batchEmail)){
                              $data_add_file['batchEmail']  = $fileData->batchEmail; //用户邮箱发送
                        }
                        $md5Data = md5(json_encode($data_add_file));
                        $md5Data_time = $md5Data."_time";
                        $this->status = cls_redis::get($md5Data);
                        if($this->status  == self::USER_PRISSIONS_STATUS_1  || $this->status == self::USER_PRISSIONS_STATUS_2){
                                $conversion  = self::USER_PRISSIONS_STATUS_1;
                                cls_redis::del($md5Data);
                                 if(empty(cls_redis::get(md5('SendEmail:'.self::$ary_member['open_id']))) && empty($fileData->batchEmail)){
                                      make_fsockopen('/Script/Batch/SendTimingEmail',array('open_id'=> self::$ary_member['open_id']));
                                      cls_redis::set(md5('SendEmail:'.self::$ary_member['open_id']), self::USER_PRISSIONS_STATUS_1);
                                 }
                               
                        } else {
                                if(empty(cls_redis::get($md5Data_time))){
                                    $this->status  = self::USER_PRISSIONS_STATUS_5;   //这个暂定为时间过期
                                    cls_redis::del($md5Data);
                                    D("PdfList")->where(array('m_id' => $member['m_id'], 'id' => $fileData->id))->data(array('fstate' => self::USER_PRISSIONS_STATUS_5))->save();
                                }
                        }
                        $json[] = array('m_id'=>$member['m_id'],'fileType'=>$fileData->fileType,'fileName'=>$reqFile,'downIp'=>$ip,'fileSize'=>$fileData->fileSize,'fileState'=>$this->status,'conversion'=>$conversion);
                }
                if(count($fileJsonCode) == 1){
                     make_fsockopen('/Script/Batch/SendTimingEmail',array('open_id'=> self::$ary_member['open_id'],'emailAll'=>1));
                }
                $this->ajaxReturn(array('action'=>1,'conversion'=>$conversion,'success'=>$json));
        }
        
    }

    public function getFileDownload(){
        $data = $this->_post();
        $member  =  session('Members');
       $File_download_find = D("PdfList")->where(array('m_id'=>$member['m_id'],'id'=>$data['id']))->find();
       if(empty($File_download_find)){
                echo '{"action":5}';exit;
       }            
        $createTime = filemtime($File_download_find['cpath']);
        $nowTime    = time();
        $timeState  = $nowTime - 15*60;

        //如果为fase则为gbk编码
        if(!is_utf8($File_download_find['cname'])){
                $File_download_find['cname'] = iconv('gbk','utf-8//IGNORE',$File_download_find['cname']);
        }

                $_SESSION['session_time'] = time();
                $key = md5($_SESSION['session_time'].'_PDF_KEY');
                echo '{"action":1,"downUrl":"'.$File_download_find['cname'].'","key":"'.$key.'","id":"'.$File_download_find['id'].'"}';
  
    }

    public function ajaxDownload(){
            if(isset($_POST) && !empty($_POST)){
                    $fileInfo = $_POST;
                    $this->suffix_file_postfix = getSuffixType($fileInfo['downType']);
                    $downName = substr($fileInfo['fileName'],0,strrpos($fileInfo['fileName'],'.')).'_'.$fileInfo['fileTime'].'.'.$this->suffix_file_postfix;
                    $downName = $downName;//safe_replace($downName);//去掉特殊字符
                    if(preg_match('/[\S][\s]+/',$downName)){
                            $downName =  $downName; //str_replace(' ','',$downName);
                    }
                    if(is_utf8($downName)){
                            $downNames = iconv('utf-8','gbk//IGNORE',$downName);

                    }else{
                            $downNames = $downName;
                    }
                    if(!is_utf8($downNames)){
                            $downNames = iconv('gbk','utf-8//IGNORE',$downNames);
                    }
                    $_SESSION['session_time'] = time();
                    $key = md5($_SESSION['session_time'].'_PDF_KEY');
                    echo '{"action":1,"downUrl":"'.$downNames.'","key":"'.$key.'","fileId":"'.$fileInfo['fileId'].'"}';
            }else{
                    echo '{"action":5}';
            }
        
    }

    public function downloadFile(){
            //set_time_limit(0);
            //ini_set("memory_limit", "1024M");
            $fileInfo    = $this->_get();
            $member  =  session('Members');
            $File_download_find = D("PdfList")->where(array('m_id'=>$member['m_id'],'id'=>$fileInfo['id']))->find();
            $fileInfo['url'] = urldecode($fileInfo['url']);
            $application = applicationType($File_download_find['ctype']);
            $downLoad = $File_download_find['cpath'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $downLoad,//"http://ucenter.wiserar.com/uploadFile/currentfile/20170613/2/pdf/%E5%91%A8%E6%8A%A5-%E6%9D%8E%E6%97%B6%E5%98%89-%E7%AC%AC15%E5%91%A8%20_1497283200.pdf",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
            //  CURLOPT_HTTPHEADER => array(
            //    "cache-control: no-cache",
            //    "postman-token: fe075be2-cb87-964e-5e26-f67762299ea0"
            //  ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                    echo "cURL Error #:" . $err;exit;
            } 
            $fileStr     = substr($fileInfo['url'],0,strrpos($fileInfo['url'],'.'));
            $fileLink    = substr($fileStr,0,strrpos($fileStr,'_'));
            $downName    = $fileLink.'.'.$File_download_find['ctype'];
            if (is_utf8($downName)) {
                $downName= iconv('utf-8', 'gbk//IGNORE', $downName);
            } 
            header('Pragma: public');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: pre-check=0, post-check=0, max-age=0');
            header('Content-Transfer-Encoding: binary');
            header('Content-Encoding: none');
            header('Content-type: '.$application);
            header('Content-Disposition: attachment; filename="'.$downName.'"');
           header('Content-length: '.strlen($response));
          echo $response;exit;
    }

    public function download(){
            set_time_limit(0);
//            $sessionMD5 = md5($_SESSION['session_time'].'_PDF_KEY');
//            if(!isset($_GET['key']) || $sessionMD5 != $_GET['key']){
//                    exit('Not normal visit');
//            }
            $members = session("Members");
            $fileInfo    = $_GET;
            $File_download_find = D("PdfList")->where(array('m_id'=>$members['m_id'],'id'=>$fileInfo['id']))->find();
            $application = applicationType($fileInfo['downType']);
            $downLoad = $File_download_find['cpath'];
            $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $downLoad,//"http://ucenter.wiserar.com/uploadFile/currentfile/20170613/2/pdf/%E5%91%A8%E6%8A%A5-%E6%9D%8E%E6%97%B6%E5%98%89-%E7%AC%AC15%E5%91%A8%20_1497283200.pdf",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                //  CURLOPT_HTTPHEADER => array(
                //    "cache-control: no-cache",
                //    "postman-token: fe075be2-cb87-964e-5e26-f67762299ea0"
                //  ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                         echo "cURL Error #:" . $err;exit;
                } 
            if (is_utf8($File_download_find["cname"])) {
                $File_download_find["cname"] = iconv('utf-8', 'gbk//IGNORE', $File_download_find["cname"]);
            } 
            header('Pragma: public');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: pre-check=0, post-check=0, max-age=0');
            header('Content-Transfer-Encoding: binary');
            header('Content-Encoding: none');
            header('Content-type: '.$application);
            header('Content-Disposition: attachment; filename="'.$File_download_find['cname'].'"');
            header('Content-length: '.strlen($response));
            echo $response;
        
    }

    public function ConvertAsynchronous(){
        
        $data = $this->_get();
        writeLog("ConvertAsynchronous:". json_encode($data),date('Y-m-d')."ConvertAsynchronous.log");
         if(!empty($data['result']) && !empty($data['key'])){
                $this->resState  = $data['result'];
                $base_json_decode = json_decode(base64_decode($data['key']),true);
                $member_data = D('Members')->where(array('m_id' => $base_json_decode['m_id']))->find();
                $this->suffix_file_postfix = $base_json_decode['conversion_format']; //获取后缀
                writeLog("ConvertAsynchronous_1:". json_encode($base_json_decode),date('Y-m-d')."ConvertAsynchronous_1.log");
                $md5Data = md5(json_encode($base_json_decode));
                $File__find = D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $base_json_decode['id']))->field('cname,fname,number_page')->find();
                if ($this->resState == self::USER_PRISSIONS_STATUS_1 ) {
                    $localHost = $_SERVER['DOCUMENT_ROOT'];
                    $fileName = substr($File__find['cname'], self::USER_PRISSIONS_STATUS_0, strrpos($File__find['cname'], '.')) . '.' . $base_json_decode['format'];
                    if (is_utf8($File__find["fname"])) {
                        $fileName = iconv('utf-8', 'gbk//IGNORE', $fileName);
                    } else {
                        $fileName = $fileName;
                    }
                    $currentfilePath = $localHost . '/uploadFile/currentfile/' . date('Ymd') . '/' . $member_data['m_id'] . '/' . $this->suffix_file_postfix;
                    $HostFilePath = '/uploadFile/currentfile/' . date('Ymd') . '/' . $member_data['m_id'] . '/' . $this->suffix_file_postfix;
                    $fileReplacePaths = getLocalPathHost($this->suffix_file_postfix, $File__find['cname'], $currentfilePath, $HostFilePath); //获取转换后保存文件的路径
                    $fileReplacePath = getLocalPath($this->suffix_file_postfix, $fileName, $currentfilePath); //获取转换后保存文件的路径
                    if (is_file($fileReplacePath)) {
                        $fileName = substr($File__find['cname'], self::USER_PRISSIONS_STATUS_0, strrpos($File__find['cname'], '.'));
                        $fileName = $fileName . "." . $this->suffix_file_postfix;
                        $conversion_type = self::USER_PRISSIONS_STATUS_0;
                        if ($this->suffix_file_postfix != 'pdf') {
                            switch ($member_data['conversion_type']) {
                                case self::USER_PRISSIONS_STATUS_0:
                                    if ($member_data['Free_authorization'] == self::USER_PRISSIONS_STATUS_1) {
                                        D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('Free_authorization' => 0,'Free_obtain_time'=> date('Y-m-d')))->save();
                                    } else {
                                        D("PdfList")->where(array('m_id'=>$member_data['m_id'],'id'=>$base_json_decode['id']))->data(array('fstate'=>6))->save();
                                        cls_redis::set($md5Data, self::USER_PRISSIONS_STATUS_6);
                                        return FALSE;
                                    }
                                    break;
                                case self::USER_PRISSIONS_STATUS_1:
                                    $conversion_type = self::USER_PRISSIONS_STATUS_1;
                                    if ($member_data['Free_authorization'] == self::USER_PRISSIONS_STATUS_1 && $File__find['number_page'] <= 50) {
                                        D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('Free_authorization' => 0,'Free_obtain_time'=> date('Y-m-d')))->save();
                                    } else {
                                        if ($member_data['number_remaining'] == self::USER_PRISSIONS_STATUS_0) {
                                            cls_redis::set($md5Data, self::USER_PRISSIONS_STATUS_2);
                                            return FALSE;
                                        } else {
                                            if (($member_data['number_remaining'] - 1) == 0) {
                                                D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('number_remaining' => $member_data['number_remaining'] - 1, 'conversion_type' => 0, 'number_use' => $member_data['number_use'] + 1))->save();
                                            } else {
                                                D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('number_remaining' => $member_data['number_remaining'] - 1, 'number_use' => $member_data['number_use'] + 1))->save();
                                            }
                                        }
                                    }
                                    break;
                                case self::USER_PRISSIONS_STATUS_2:
                                    $conversion_type = self::USER_PRISSIONS_STATUS_2;
                                    if (time() > strtotime($member_data['end_time'])) {
                                        if ($member_data['number_remaining'] > 0) {
                                            D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('number_remaining' => $member_data['number_remaining'] - 1, 'number_use' => $member_data['number_use'] + 1, 'conversion_type' => 1))->save();
                                        } else {
                                            D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('conversion_type' => 0))->save();
                                            cls_redis::set($md5Data, self::USER_PRISSIONS_STATUS_2);
                                            return FALSE;
                                        }
                                    } else {
                                        D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('number_use' => $member_data['number_use'] + 1))->save();
                                    }
                                    break;
                            }
                        }
                        //转换成功，将当前转换的文件转移到集合fileRes
                        D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $base_json_decode['id']))->data(
                                            array(
                                                'cpath' => addslashes($fileReplacePaths),
                                                'cstate' => self::USER_PRISSIONS_STATUS_1,
                                                'conversion_type' => $conversion_type,
                                                'fstate'=>$this->resState,
                                                'cname' => $fileName,
                                                'fdown' => self::USER_PRISSIONS_STATUS_1,
                                                'ctype' => $this->suffix_file_postfix,
                                                'cstyle' => self::USER_PRISSIONS_STATUS_1)
                                            )->save();
                    if (!empty($base_json_decode['email'])) {
                            if (empty($member_data['m_email'])) {
                                D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('m_email' => $base_json_decode['email']))->save();
                            } else {
                                if ($member_data['m_email'] != $base_json_decode['email']) {
                                    D('Members')->where(array('m_id' => $member_data['m_id']))->data(array('m_email' => $base_json_decode['email']))->save();
                                }
                            }
                            $data_add_file = array();
                            $all_data_email_array = array();
                            $data_add_file['cpath'] = addslashes($fileReplacePaths);
                            $data_add_file['id'] = $base_json_decode['id'];
                            $data_add_file['fileName'] = $fileName;
                            $data_add_file['email'] = $base_json_decode['email'];
                            $data_add_file['time'] = date('Y-m-d H:i:s');
                            $data_add_file['conversion_format'] = $base_json_decode['conversion_format']; //获取后缀
                            if(empty($base_json_decode['batchEmail'])){
                                    $this->queue_lpush($data_add_file,'SendEmail:', $member_data['open_id']);
                            } else {
                                $all_data_email = cls_redis::get(md5('SendEmailAll:'.$member_data['open_id']));
                                if(empty($all_data_email)){
                                    array_push($all_data_email_array, $data_add_file);
                                    cls_redis::set(md5('SendEmailAll:'.$member_data['open_id']), json_encode($all_data_email_array));
                                } else {
                                    $all_data_email_array = json_decode($all_data_email,true);
                                    array_push($all_data_email_array, $data_add_file);
                                    cls_redis::set(md5('SendEmailAll:'.$member_data['open_id']), json_encode($all_data_email_array));
                                }
                            }
                    }
                    $MemberAuthorization  = D('MemberAuthorization');
                    $add_aray_authorization = array();
                    $add_aray_authorization['m_id']  = $member_data['m_id'];
                    $add_aray_authorization['creation_time']  = date('Y-m-d H:i:s');
                    $add_aray_authorization['type']  = $member_data['conversion_type'];
//                    $response_data = array();
//                    $response_data['conversion_type'] = (int)$member_data['conversion_type'];
//                    $response_data['number_remaining'] = (int)$member_data['number_remaining'];
//                    if(time() > strtotime($member_data['end_time'])){
//                            $response_data['end_time']  = 0;
//                    } else {
//                            $response_data['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($member_data['end_time']));
//                    }
                    $MemberAuthorization->add($add_aray_authorization);
                    cls_redis::set($md5Data, self::USER_PRISSIONS_STATUS_1);
                    } else {
                        cls_redis::set($md5Data, self::USER_PRISSIONS_STATUS_2);
                        D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $base_json_decode['id']))->data(array(
                            'fstate'=>16,
                            //      'cpath'=>addslashes($fileReplacePath),
                            'cstate' => self::USER_PRISSIONS_STATUS_2,
                            'cstyle' => self::USER_PRISSIONS_STATUS_1))->save();
                    }
                } else {
                    $md5Data = md5(json_encode($base_json_decode));
                    if( $this->resState  == -10 || $this->resState  == self::USER_PRISSIONS_STATUS_5){
                         $this->resState  = self::USER_PRISSIONS_STATUS_2;
                    }
                    if( $this->resState  == self::USER_PRISSIONS_STATUS_4){
                         $this->resState  = self::USER_PRISSIONS_STATUS_5;
                    }
                    if( $this->resState  == -3 ||  $this->resState  == 3){
                        // $this->resState  = 11;
                         $this->resState  = 2;
                    }
                    cls_redis::set($md5Data, $this->resState);
                    D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $base_json_decode['id']))->data(array(
                        'fstate'=>16,
                        //      'cpath'=>addslashes($fileReplacePath),
                        'cstate' => self::USER_PRISSIONS_STATUS_2,
                        'cstyle' => self::USER_PRISSIONS_STATUS_1))->save();
                }
         }
   
    }

    public function timngProcess() {
        set_time_limit(0);
        $localHost = $_SERVER['DOCUMENT_ROOT'];
        $conversionPath = $localHost . '/conversion/CallConvert.exe'; //转换软件路径
        $pdfconversion =  $localHost . '/conversion/CallConvert.exe'; //pdf转换软件路径
        $members = session('Members');
        $data = $this->queue_rpop($members['open_id']);
        $member_data = D('Members')->where(array('m_id' => $members['m_id']))->find();
        if (!empty($data)) {
            $File__find = D("PdfList")->where(array('m_id' => $members['m_id'], 'id' => $data['id']))->field('cname,fname,number_page')->find();
            $fileName = $File__find['cname'];
            if (is_utf8($File__find["fname"])) {
                $fileName = iconv('utf-8', 'gbk//IGNORE', $fileName);
            } else {
                $fileName = $fileName;
            }
            $uploadPath = $localHost . '/uploadFile/weatherCities/' . date('Ymd') . '/' . $members['m_id'] . '/' . $data['format'];
            $filePath = $uploadPath . '/' . $fileName; //要转换文件的路径
            $this->suffix_file_postfix = $data['conversion_format']; //获取后缀
            $currentfilePath = $localHost . '/uploadFile/currentfile/' . date('Ymd') . '/' . $members['m_id'] . '/' . $this->suffix_file_postfix;
            $fileReplacePath = getLocalPath($this->suffix_file_postfix, $fileName, $currentfilePath); //获取转换后保存文件的路径
            $this->resState = ''; //word转pdf的状态
            $rsa_public_encrypt  = base64_encode(json_encode($data));
            $md5Data  = md5(json_encode($data));
            $md5Data_time = $md5Data."_time";
            cls_redis::set($md5Data_time,microtime(true),3000);
            if ($this->suffix_file_postfix == 'pdf') {
                $this->resState = self::USER_PRISSIONS_STATUS_0;
                if (!is_file($fileReplacePath)) {
                    writeLog('"' . $conversionPath . '" "' . $filePath . '" "' . $fileReplacePath . '" GMreader_OPV" "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"',date('Y-m-d')."conversion.log");
                    exec('"' . $conversionPath . '" "' . $filePath . '" "' . $fileReplacePath . '" GMreader_OPV "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"');
                    D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $data['id']))->data(array('fstate'=>self::USER_PRISSIONS_STATUS_7))->save();
                } else {
                    $this->redirect('/Home/Index/ConvertAsynchronous',array('key'=>$rsa_public_encrypt,'result'=>1));
               }
            } else {
                $split_start = 0;
                //pdf转其他格式
                if ($member_data['conversion_type'] == self::USER_PRISSIONS_STATUS_1 && $File__find['number_page'] < 500) {
                    $split_start = PdfSplit($filePath, '1-500');
                    $filePath = $filePath . "_split.pdf";
                } else if ($member_data['conversion_type'] == self::USER_PRISSIONS_STATUS_0 && $member_data['Free_authorization'] == 1 && $File__find['number_page'] > 50 ) {
                    $split_start = PdfSplit($filePath, '1-50');
                    $filePath = $filePath . "_split.pdf";
                } else {
                    $split_start = 1;
                }
                if ($split_start == 1) {
                    $this->resState = self::USER_PRISSIONS_STATUS_0;
                        writeLog('"' . $pdfconversion . '" "' . $filePath . '" "' . $fileReplacePath . '" ipdfReader_PDV "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"',date('Y-m-d')."conversion.log");
                        exec('"' . $pdfconversion . '" "' . $filePath . '" "' . $fileReplacePath . '" ipdfReader_PDV "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"');
                        D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $data['id']))->data(array('fstate'=>self::USER_PRISSIONS_STATUS_7))->save();
//                    if (!is_file($fileReplacePath)) {
//                        writeLog('"' . $pdfconversion . '" "' . $filePath . '" "' . $fileReplacePath . '" ipdfReader_PDV "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"',date('Y-m-d')."conversion.log");
//                        exec('"' . $pdfconversion . '" "' . $filePath . '" "' . $fileReplacePath . '" ipdfReader_PDV "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"');
//                        D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $data['id']))->data(array('fstate'=>self::USER_PRISSIONS_STATUS_7))->save();
//                    } else {
//                        if($member_data['Free_authorization'] == self::USER_PRISSIONS_STATUS_0){
//                                writeLog('"' . $pdfconversion . '" "' . $filePath . '" "' . $fileReplacePath . '" ipdfReader_PDV "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"',date('Y-m-d')."conversion.log");
//                                exec('"' . $pdfconversion . '" "' . $filePath . '" "' . $fileReplacePath . '" ipdfReader_PDV "'.C('HOST_CONVERSIONS').'" "'.$rsa_public_encrypt.'"');
//                                D("PdfList")->where(array('m_id' => $member_data['m_id'], 'id' => $data['id']))->data(array('fstate'=>self::USER_PRISSIONS_STATUS_7))->save();
//                        } else {
//                            $this->redirect('/Home/Index/ConvertAsynchronous',array('key'=>$rsa_public_encrypt,'result'=>1));
//                        }
//                    }
                } else {
                    $this->redirect('/Home/Index/ConvertAsynchronous',array('key'=>$rsa_public_encrypt,'result'=>-10));
                }
            }

        }
    }

    public function delete(){
	$fileInfo   = $_FILES;
	$ip         = getIp();//获取ip
        $fileInfo = json_decode($_POST['fileInfo']);
        $members = session('Members');
            if($fileInfo){
                foreach($fileInfo as $val){
                    D("PdfList")->where(array('m_id'=>$members['m_id'],'id'=>$val->fid))->data(array(
                               'fstate'=>99,
                               'dstyle'=>$val->dstyle,
                    ))->save();
    		}
            }
    }
    
    public function weixin_login(){
       
         $state  = md5(uniqid(rand(), TRUE));
        $config = D('SysConfig');
         $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
          $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);   
        if(!empty($ary_status['wx']) && $ary_status['wx'] == '1'){
            $arr_data = json_decode($logindata['THDDATA']['sc_value'],TRUE);
            $_SESSION['wx_rand'] = $state;
            $uri = 'Home/User/getToken';
			$ary_shop_data = D('SysConfig')->getCfgByModule('GY_SHOP',1);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$uri;
			if(!empty($ary_shop_data['GY_SHOP_HOST'])){
				$url = $ary_shop_data['GY_SHOP_HOST'].$uri;
			}
        }
        
        cookie('redirect',$_SERVER['REDIRECT_URL'],180);	
          // print_r($_SERVER);exit;//REDIRECT_URL
        /*
                $str_url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
                $ary_result['appid'] = $this->wx_api_id;
                $ary_result['secret'] = $this->wx_api_key;
                $str_url .= '?1=1';
                foreach($ary_result as $key=>$value){
                    $str_url .= '&'.$key.'='.$value;
                }
                $return_token = $Communications->httpGetRequest($str_url,$ary_result);
                $ary_return = $this->getThdWX($return_token);
         */
        //微信登录
        //-------生成唯一随机串防CSRF攻击
        $callback = urlencode($url);
        $wxurl = C('WEIXIN_LOGIN')."?appid=".$arr_data['wxid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
      //  $aa = requests::get($wxurl);

     //   print_r($collectImg[1]);exit;
header("Location: $wxurl");
        
    }
    
    public function Weixinopen(){
         $state  =  $_SESSION['wx_rand'];
        $config = D('SysConfig');
         $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
          $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);   
        if(!empty($ary_status['wx']) && $ary_status['wx'] == '1'){
            $arr_data = json_decode($logindata['THDDATA']['sc_value'],TRUE);
            $uri = 'Home/User/ApigetToken';
			$ary_shop_data = D('SysConfig')->getCfgByModule('GY_SHOP',1);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$uri;
			if(!empty($ary_shop_data['GY_SHOP_HOST'])){
				$url = $ary_shop_data['GY_SHOP_HOST'].$uri;
			}
        }
        //微信登录
        //-------生成唯一随机串防CSRF攻击
        $callback = urlencode($url);
        $wxurl = C('WEIXIN_LOGIN')."?appid=".$arr_data['wxid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
        requests::set_header("Referer", $wxurl);
        $wx_url = "https://long.open.weixin.qq.com/connect/l/qrconnect?uuid=".$this->_get('uuid')."&last=404&_=".$this->_get('_');
        $aa = requests::get($wx_url);
        //    $wx_code = str_replace('/connect/qrcode/', '', $collectImg[1]);
        //"window.wx_errcode=405;window.wx_code='041Kfj0728ULRL0kQt3723r2072Kfj0m';"
        $code_callack = explode(';', $aa);
        if(!empty($code_callack[0]) && !empty($code_callack[1])){
            $wx_errcode  = str_replace('window.wx_errcode=', '', $code_callack[0]);
            $wx_code  = str_replace('window.wx_code=', '', $code_callack[1]);
            $wx_code  = str_replace("'", '', $wx_code);
            if($wx_errcode == 405 && !empty($wx_code)){
        
                    $this->ajaxReturn(json_encode(array('action'=>1,'code'=>$wx_code)),'EVAL');
            } else {
                        $this->ajaxReturn(json_encode(array('action'=>2,'code'=>$wx_code)),'EVAL');
            }
        }else {
                $this->ajaxReturn(json_encode(array('action'=>2,'code'=>$wx_code)),'EVAL');
        }
  
    }


    public function code(){
        if($_GET['state']!=$_SESSION["wx_state"]){
             exit("5001");
        }
        $url=C('WEIXIN_ACCESS_TOKEN').'?appid='.C('WEIXIN_APPID').'&secret='.C('WEIXIN_APPSECRET').'&code='.$_GET['code'].'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json =  curl_exec($ch);
        curl_close($ch);
        $arr=json_decode($json,1);
        //得到 access_token 与 openid
        $url=C('WEIXIN_USERINFO').'?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json =  curl_exec($ch);
        curl_close($ch);
        $arr=json_decode($json,1);
        $member  = D('Members')->checkopenid($arr['openid']);
            if (empty($member)) {
                $array_insert_data = array();
                 $array_insert_data['open_id'] = $arr['openid'];
                 $array_insert_data['open_name'] = $arr['nickname'];
                 $array_insert_data['m_sex'] = $arr['sex'];
                 $array_insert_data['open_source'] = 4;
                 $array_insert_data['m_create_time'] = date("Y-m-d H:i:s");
                 $array_insert_data['login_type'] = 1;
                 $array_insert_data['m_head_img'] = $arr['headimgurl'];
                 $mixed_member_id = D("Members")->add($array_insert_data);
                 $arr['m_id'] = $mixed_member_id;
            }else{
                 $arr['m_id'] = $member['m_id'];
            }
        cls_redis::set($arr['openid'],json_encode($arr),86400*3600);
        cookie('openid',$arr['openid'],86400*3600);	
        session('Members', $arr);
        
    }


    public function fileRequest(){
        $members =  session("Members");
            if(isset($_POST['verify']) && $_POST['verify'] == 'PDF'){
                //fstate in (1,2,4)
                    $returnFile = D("PdfList")->where(array('m_id'=>$members['m_id'],'fstate'=>array('neq',99),'delete_remove'=>array('neq',1),'fsize'=>array('neq',0)))->order("id desc")->select();
                    if($returnFile){
                        $this->ajaxReturn(array('action'=>1,'success'=>$returnFile));
                    }else{
                        $this->ajaxReturn(array('action'=>0));
                    }
            }
    }
    
    public function fileDownLoad() {
	$fileInfo   = $_FILES;
        $members = session('Members');
        $fileInfo = json_decode($_POST['fileInfo']);
        if($fileInfo){
        foreach($fileInfo as $val){
                    D("PdfList")->where(array('m_id'=>$members['m_id'],'fid'=>$val->fid,'fname'=>$val->fileName,'fsize'=>$val->fsize))->data(array(
                     'fdown'=>$val->fdown))->save();
                }

        }	
    }
    public function getIp() {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
	}
 
    
        /**
     * 队列长度
     * 
     * @return void
     * @author seatle <seatle@foxmail.com> 
     * @created time :2016-09-23 17:13
     */
    public function queue_lsize($key,$allowed_repeat = "collect_queue:")
    {
        $lsize = cls_redis::lsize($allowed_repeat.$key); 
     
        return $lsize;
    }
    /**
     * 从队列右边取出
     * 
     * @return void
     * @author seatle <seatle@foxmail.com> 
     * @created time :2016-09-23 17:13
     */
    public function queue_rpop($key,$allowed_repeat = "collect_queue:")
    {
            $link = cls_redis::rpop($allowed_repeat.$key); 
            $link = json_decode($link, true);
        return $link;
    }
    /**
     * 从队列左边插入
     * 
     * @return void
     * @author seatle <seatle@foxmail.com> 
     * @created time :2016-09-23 17:13
     */
    public function queue_lpush($link = array(), $allowed_repeat = "collect_queue:",$open_id)
    {
        $status = false;
        if(!empty($open_id)){
            $key = $allowed_repeat.$open_id;
        } else {
            $key = $allowed_repeat.$_SESSION['Members']['open_id'];
        }
        $link = json_encode($link);
        cls_redis::lpush($key, $link); 
        $status = true;
       
        return $status;
    }
    public function artificialvip(){
        
        $halfMonther = self::getActivitp();
        if(!empty($halfMonther)){
            $this->assign('start_time',date('Y-m-d H:i:s'));
            $this->assign('halfMonther',date('Y-m-d H:i:s',$halfMonther));
            $this->assign('year',date('Y',$halfMonther));
            $this->assign('month',date('m',$halfMonther));
            $this->assign('day',date('d',$halfMonther));
        }else {
             $this->assign('ACTIVITY_OPEN',1);
        }
        $this->assign('header_tag_highlighted', 1);
        $this->setTitle('人工VIP','TITLE_INDEX','KEY_CATEGORY','DESC_CATEGORY');
        $Boot_page = FXINC . '/Public/Tpl/' . CI_SN . '/' . TPL . '/Boot_page.html';
        $this->assign('Boot_page', $Boot_page);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/artificialvip.html';
        $this->display($tpl);
        
    }
    
    public function informationRecords(){
               // print_r($_SERVER);exit;//REDIRECT_URL
                if( !empty($this->_get('token'))){
                    $mb_user_token_info = D('MbUserToken')->getMbUserTokenInfoByToken($this->_get('token'));
                    if(!empty($mb_user_token_info)){
                            $members = D('Members')->getMemberInfoByID($mb_user_token_info['m_id']);
                             D('MemberCookie')->DataMemberSave($members);
                    }
                }
               if (!session('?Members')) {
			//未登录用户引导到登录页面
			$int_port = "";
			if($_SERVER["SERVER_PORT"] != 80){
				$int_port = ':' . $_SERVER["SERVER_PORT"];
			}
			$string_request_uri = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
			//立刻购买URL拼接
			$post_data = $_REQUEST;
			if(!empty($post_data['pid'][0])){
				$string_request_uri .='?pid='.$post_data['pid'][0];
			}
			//$this->error(L('NO_LOGIN'), U('Ucenter/User/pageLogin') . '?redirect_uri=' . urlencode($string_request_uri));
			$is_on = D('SysConfig')->getConfigs('GY_SHOP', 'GY_SHOP_OPEN');
			if ($is_on['GY_SHOP_OPEN']['sc_value'] == '0') {
                redirect(U('Home/Index/showMemberInfo?redirect='.base64_encode($_SERVER['REDIRECT_URL'])));
				//$this->error(L('NO_LOGIN'), array('确认' => U('Ucenter/User/pageLogin') . '?redirect_uri=' . urlencode($string_request_uri)));
			} else {
				//redirect(U('Home/Index/index'));
                redirect(U('Home/Index/showMemberInfo?redirect='.base64_encode($_SERVER['REDIRECT_URL'])));
				//$this->error(L('NO_LOGIN'), array('确认' => U('Home/User/Login') . '?redirect_uri=' . urlencode($string_request_uri)));
			}
            //已登录用户将session放入到私有属性
        }
        $halfMonther = self::getActivitp();
        if(!empty($halfMonther)){
            $this->assign('start_time',date('Y-m-d H:i:s'));
            $this->assign('halfMonther',date('Y-m-d H:i:s',$halfMonther));
            $this->assign('year',date('Y',$halfMonther));
            $this->assign('month',date('m',$halfMonther));
            $this->assign('day',date('d',$halfMonther));
        }else {
             $this->assign('ACTIVITY_OPEN',1);
        }
        $record = $this->_get('record');
        if(empty($record)){
            $record  = 'Prepaidrecords';
        }
        if($record  == 'Prepaidrecords') {
                $PaymentSerialCount  = D('PaymentSerial')->where(array('m_id'=>$_SESSION['Members']['m_id'],'ps_status'=>1))->count();
                $obj_page = new Page($PaymentSerialCount, 5);
                 $page = $obj_page->show();
                 $PaymentSerialSelect = D('PaymentSerial')->where(array('m_id'=>$_SESSION['Members']['m_id'],'ps_status'=>1))
                ->limit($obj_page->firstRow . ',' . $obj_page->listRows)->order('ps_id desc')->select();
        } else {
                $PdfListSelectCount  = D("PdfList")->where(array('m_id'=>$_SESSION['Members']['m_id'],'fsize'=>array('neq',0),'cstate'=>array('neq',0)))->count();//,'fstate'=>array('neq',99)
                $obj_page_PdfList = new Page($PdfListSelectCount, 5);
                 $pdf_page = $obj_page_PdfList->show();
                $PdfListSelect  = D("PdfList")->where(array('m_id'=>$_SESSION['Members']['m_id'],'fsize'=>array('neq',0),'cstate'=>array('neq',0)))->limit($obj_page_PdfList->firstRow . ',' . $obj_page_PdfList->listRows)->order('id desc')->select();//,'fstate'=>array('neq',99)
                foreach( $PdfListSelect as $key=>$value){
                       if(time()  >  strtotime(date('Y-m-d H:i:s',$value['crate_time']) .'+1 day')){
                            $PdfListSelect[$key]['lastDown']  = 1;
                       }
                       $PdfListSelect[$key]['crate_time'] = date('Y-m-d H:i:s',$value['crate_time']);
                }
        }
       $pdf_type = $this->_get('pdf_type');
        if(empty($pdf_type)){
            $pdf_type  = 0 ;
        }
        $Boot_page = FXINC . '/Public/Tpl/' . CI_SN . '/' . TPL . '/Boot_page.html';
        $this->assign('Boot_page', $Boot_page);
        $this->setTitle('信息记录','TITLE_INDEX','KEY_GOODS','DESC_GOODS');
        $this->assign('header_tag_highlighted', 2);
        $this->assign('record', $record);
        $this->assign('pdf_type', $pdf_type);
        $this->assign('PdfListSelect', $PdfListSelect);
        $this->assign('ary_article_list', $PaymentSerialSelect);
        $this->assign('page', $page); // 赋值分页输出
           $this->assign('pdf_page', $pdf_page);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/informationRecords.html';
        $this->display($tpl);
        
    }
    
    public function ApplayCollectPayTemplate(){

        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/ApplayCollectPayTemplate.html';
        $this->display($tpl);
        
    }
    
    public function showMemberInfo(){
        if($this->_get('redirectCode') == 'Pay'){
         $msg = '充值哦~~';
        } else {
            $msg = '查看信息记录哦~~';
            $this->assign('header_tag_highlighted', 2);
        }
        $this->setTitle('登录','TITLE_INDEX','KEY_INDEX','DESC_INDEX');
       // $this->assign('page_title', $title['GY_SHOP_TITLE']['sc_value'] . ' - 自由搭配推荐');
        $this->assign('msg', $msg);
        $this->assign('redirect',base64_decode($this->_get('redirect')));
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/showMemberInfo.html';
        $this->display($tpl); 
    }
    /*
     * 定时任务
     */
    public function UserDataRecordsDelete(){
            D("PdfList")->where(array('crate_time'=>array('LT', strtotime(date('Y-m-d H:i:s') .'-1 day'))))->data(array('delete_remove'=>1))->save();
    }
    
    
    public function ApiWeixinCallback(){ 
        $model_mb_user_token = D('MbUserToken');
        if( !empty($this->_get('token'))){
            $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($this->_get('token'));
            if(empty($mb_user_token_info)){
                  redirect(U('Home/Index/Clientapiweixinlogin'));
            }
            $members = D('Members')->getMemberInfoByID($mb_user_token_info['m_id']);
        } 
//        else {
//            $member = session('Members');
//            $members = D("Members")->where(array('m_id'=>$member['m_id']))->find();
//            $mb_user_token_info = $model_mb_user_token->where(array('m_id'=>$members['m_id']))->find();
//        }
        $members['token'] = $mb_user_token_info['token'];
        writeLog("ApiWeixinCallback:". json_encode($members),date('Ym-d')."weixin_callback.log");

        $this->assign('ary_member', $members);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/ApiWeixinCallback.html';
        $this->display($tpl); 
        
    }
        public function ApiWeixinPaymentGoodsCallback(){ 
        $model_mb_user_token = D('MbUserToken');
        if( !empty($this->_get('token'))){
            $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($this->_get('token'));
            if(empty($mb_user_token_info)){
                  redirect(U('Home/Index/Clientapiweixinlogin'));
            }
            $members = D('Members')->getMemberInfoByID($mb_user_token_info['m_id']);
        } 
//        else {
//            $member = session('Members');
//            $members = D("Members")->where(array('m_id'=>$member['m_id']))->find();
//            $mb_user_token_info = $model_mb_user_token->where(array('m_id'=>$members['m_id']))->find();
//        }
        $members['token'] = $mb_user_token_info['token'];
        writeLog("ApiWeixinCallback:". json_encode($members),date('Ym-d')."weixin_callback.log");

        $this->assign('ary_member', $members);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/ApiWeixinPaymentGoodsCallback.html';
        $this->display($tpl); 
        
    }
    /// 客户端登录
    public function weixinLogin_page(){
         $state  = md5(uniqid(rand(), TRUE));
        $config = D('SysConfig');
         $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
          $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);   
        if(!empty($ary_status['wx']) && $ary_status['wx'] == '1'){
            $arr_data = json_decode($logindata['THDDATA']['sc_value'],TRUE);
            $_SESSION['wx_rand'] = $state;
            $uri = 'Home/User/ApigetpaymentGoodsToken';
			$ary_shop_data = D('SysConfig')->getCfgByModule('GY_SHOP',1);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$uri;
			if(!empty($ary_shop_data['GY_SHOP_HOST'])){
				$url = $ary_shop_data['GY_SHOP_HOST'].$uri;
			}
        }
        
     //   cookie('redirect',$_SERVER['REDIRECT_URL'],180);	
        $callback = urlencode($url);
        $wxurl = C('WEIXIN_LOGIN')."?appid=".$arr_data['wxid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
        $weixin_html_preg = requests::get($wxurl);
         preg_match('/<img[^>]*?src=\"(.*?)\"[^>]*?>/ism', $weixin_html_preg, $collectImg);
         $wx_code = str_replace('/connect/qrcode/', '', $collectImg[1]);
         //print_r($wx_code);exit;
        $this->assign('wx_code',$wx_code);
        $this->assign('wx_img',$collectImg[1]);
        $this->assign($ary_status);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/weixinLogin_page.html';
        $this->display($tpl); 
        
    }
    /// 客户端登录
    public function NewWeixinLogin_page(){
        $state  = md5(uniqid(rand(), TRUE));
        $config = D('SysConfig');
         $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
          $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);   
        if(!empty($ary_status['wx']) && $ary_status['wx'] == '1'){
            $arr_data = json_decode($logindata['THDDATA']['sc_value'],TRUE);
            $_SESSION['wx_rand'] = $state;
            $uri = 'Home/User/ApigetpaymentGoodsToken';
			$ary_shop_data = D('SysConfig')->getCfgByModule('GY_SHOP',1);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$uri;
			if(!empty($ary_shop_data['GY_SHOP_HOST'])){
				$url = $ary_shop_data['GY_SHOP_HOST'].$uri;
			}
        }
        $arr_data['wx_redirect_uri'] = $url;
        cookie('redirect',$_SERVER['REDIRECT_URL'],180);	
     //   cookie('redirect',$_SERVER['REDIRECT_URL'],180);	
//        $this->assign('wx_img',$collectImg[1]);
        $this->assign($arr_data);
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/NewWeixinLogin_page.html';
        $this->display($tpl); 
        
    }
    
    public function ActivitCount() {
        $source = array();
        $source['s_status'] =1;
        $source['s_create_time'] =date('Y-m-d H:i:s');
        $source['m_id'] = isset(self::$ary_member['m_id'])?self::$ary_member['m_id']:0;
        $source['source'] = isset(self::$ary_member['open_source'])?self::$ary_member['open_source']:'';
        D("Source")->add($source);
    }
    public function ActivitLoadDataTypeAdd() {
        $source = array();
        $fileJsonPost              =   $this->_post();
        $fileJsonCode               = json_decode($fileJsonPost['fileInfo']);
        static::$ary_member['LoadDataType'] = 1;
        session('Members',static::$ary_member);
        $source['s_status']         =       $fileJsonCode->s_status;
        $source['s_type']           =       $fileJsonCode->s_type;
        $source['m_id']             =       static::$ary_member['m_id'];
        $source['source']           =       static::$ary_member['open_source'];
        $source['s_create_time']    =       date('Y-m-d H:i:s');
        D("Source")->add($source);
    }
// 年中促销活动页面
     public function YearMiddlePage(){
        $tpl ='./Public/Tpl/' . CI_SN . '/' . TPL . '/YearMiddlePage.html';
        $halfMonther = self::getActivitp();
        $get_data = $this->_get();
        $this->assign('get_data',$get_data['s_type']);
        $sc_value= D('SysConfig')->where(array('sc_key'=>'ACTIVITPPROJECT_TIME'))->getField("sc_value");
        $this->assign('ACTIVITPPROJECT_TIME',date('Y-m-d H:i:s',$sc_value));
        if(empty($halfMonther)){
             $this->assign('ACTIVITY_OPEN',1);
        } else {
            if(!empty(static::$ary_member)){
                static::$ary_member['LoadDataType'] = 1;
                session('Members',static::$ary_member);
            }
            $this->assign('start_time',date('Y-m-d H:i:s'));
            $this->assign('halfMonther',date('Y-m-d H:i:s',$halfMonther));
            $this->assign('year',date('Y',$halfMonther));
            $this->assign('month',date('m',$halfMonther));
            $this->assign('day',date('d',$halfMonther));
        }
        $this->display($tpl);    
    }
    
    public function AjaxActiviOrderPay(){
                $fileInfoList = $_POST['fileInfo'];
                $fileInfo_array = json_decode($fileInfoList,true);
                $fileInfo_array['s_create_time'] = date('Y-m-d H:i:s');
                $fileInfo_array['m_id'] = isset(self::$ary_member['m_id'])?self::$ary_member['m_id']:0;
                $fileInfo_array['source'] = isset(self::$ary_member['open_source'])?self::$ary_member['open_source']:'';
                writeLog("fileInfo_array:". json_encode($fileInfo_array),date('Ym-d')."membersCount.log");
                D("Source")->add($fileInfo_array);
    }
}


