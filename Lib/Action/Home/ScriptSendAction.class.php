<?php
/**
 * 定时脚本执行类
 *
 * @stage 7.5
 * @package Action
 * @subpackage Home
 * @author Joe <qianyijun@guanyisoft.com>
 * @date 2013-08-28
 * @copyright Copyright (C) 2013, Shanghai GuanYiSoft Co., Ltd.
 */
class ScriptSendAction extends ScriptAction{

    /*
     * 定时任务
     */
    public function UserDataRecordsDelete(){
            D("PdfList")->where(array('crate_time'=>array('LT', strtotime(date('Y-m-d H:i:s') .'-1 day'))))->data(array('delete_remove'=>1,'fstate'=>99))->save();
    }
    public function timngProcess(){
      //  print_r(json_decode($this->_post('fileInfo')));exit;
        $localHost = $_SERVER['DOCUMENT_ROOT'];
	$conversionPath = $localHost.'/conversion/opv.exe';//转换软件路径
        $pdfconversion  = $localHost.'/conversion/pdv2.exe';//pdf转换软件路径
      //  $Redis=new Credis(); 
     //   $redisObj = $Redis->redis;
	$lockFile   = dirname(__FILE__).'/redisManage.lock';
	$startLocks = startLock($lockFile);//开启文件锁
        $members = session('Members');
        print_r($_SESSION);exit;
	if(isset($_GET['lock']) && $_GET['lock'] == 1) unlink($lockFile);//手动删除文件锁
	try{

		//var_dump($redisObj->flushdb());
//            $redisSetInfo = $redisObj->lrange("fileInfo_127.0.0.1",0,100);
//		var_dump($redisSetInfo);
//		exit;
                while( $queue_lsize = $this->queue_lsize($members['openid']) )
                { 
                        $data  =  $this->queue_rpop($members['openid']);
                        $uploadPath      = $localHost.'/uploadFile/weatherCities/'.date('Ymd').'/'.$members['m_id'].'/'.$data['format'];
                        $fileName = iconv('utf-8','gbk//IGNORE',$data['fileName']);
                        $filePath     	 = $uploadPath.'/'.$fileName;//要转换文件的路径
                        $this->suffix_file_postfix      = $data['conversion_format'];//获取后缀
                        $currentfilePath = $localHost.'/uploadFile/currentfile/'.date('Ymd').'/'.$members['m_id'].'/'.$this->suffix_file_postfix ;
                        $fileReplacePath = getLocalPath($this->suffix_file_postfix ,$fileName,$currentfilePath);//获取转换后保存文件的路径
                        if(file_exists($fileReplacePath)){
                                unlink($fileReplacePath);
                        }
                        $this->resState ='';//word转pdf的状态
                        $pdfState = '';//pdf转word的状态
                                                 //   echo '"'.$pdfconversion.'" "'.$filePath.'" "'.$fileReplacePath.'" ipdfReader_PDV';exit;

                        if($this->suffix_file_postfix  == 'pdf'){
                                //$fileType = $this->suffix_file_postfix ;
                             //   $this->resState = fileSwitch($fileType,$filePath,$fileReplacePath);
                                //if($this->resState !== self::USER_PRISSIONS_STATUS_0){
                                        //其他格式转pdf
                              // $this->resState = system('"E:/webserver/pdftoword.wchtech.com/conversion/opv.exe" "E:/webserver/pdftoword.wchtech.com/uploadFile/weatherCities/20170605/3/ppt/22_1496592000.ppt" "E:/webserver/pdftoword.wchtech.com/uploadFile/currentfile/20170605/3/pdf/22_1496592000.pdf"'.'" GMreader_OPV');
				writeLog("conversion: ".'"'.$conversionPath.'" "'.$filePath.'" "'.$fileReplacePath.'" GMreader_OPV',"conversion.log");			
                                $this->resState = system('"'.$conversionPath.'" "'.$filePath.'" "'.$fileReplacePath.'" GMreader_OPV');
                                if($this->resState == self::USER_PRISSIONS_STATUS_2){
                                        system("kill.bat");
                                }				
                                //}
                        }else{		
                                //pdf转其他格式
                                system('"'.$pdfconversion.'" "'.$filePath.'" "'.$fileReplacePath.'" ipdfReader_PDV');
                                $this->resState = self::USER_PRISSIONS_STATUS_0;
                        }
                        if($this->resState == self::USER_PRISSIONS_STATUS_0 || $pdfState == self::USER_PRISSIONS_STATUS_1){
                                    $fileReplacePaths = getLocalPath($this->suffix_file_postfix ,$data['fileName'],$currentfilePath);//获取转换后保存文件的路径
                                     $md5Data = md5(json_encode($data));
                                    if(file_exists($fileReplacePath)){
                                            $fileName = substr($data['fileName'],self::USER_PRISSIONS_STATUS_0,strrpos($data['fileName'],'.'));
                                            $fileName = $fileName.".".$this->suffix_file_postfix ;
                                            $member_data =  D('Members')->where(array('m_id'=>$members['m_id']))->find();
                                            $conversion_type  =   self::USER_PRISSIONS_STATUS_0;
                                            if($data['fileSize'] > $this->maxSize ){
                                                 switch ($member_data['conversion_type']){
                                                     
                                                     case self::USER_PRISSIONS_STATUS_0:
                                                            cls_redis::set($md5Data,self::USER_PRISSIONS_STATUS_2);
                                                            return FALSE;
                                                     case self::USER_PRISSIONS_STATUS_1:
                                                            $conversion_type  =  self::USER_PRISSIONS_STATUS_1;
                                                            if($member_data['number_remaining'] == self::USER_PRISSIONS_STATUS_0 ){
                                                                cls_redis::set($md5Data,self::USER_PRISSIONS_STATUS_2);
                                                                return FALSE;
                                                            } else {
                                                                D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('number_remaining'=>$member_data['number_remaining'] -1,'number_use'=>$member_data['number_use'] + 1))->save();
                                                            }
                                                         break;
                                                     case self::USER_PRISSIONS_STATUS_2:
                                                            $conversion_type  =  self::USER_PRISSIONS_STATUS_2;
                                                            if(time() >  strtotime($member_data['end_time'])){
                                                                    if($member_data['number_remaining'] > 0){
                                                                        D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('number_remaining'=>$member_data['number_remaining'] -1,'number_use'=>$member_data['number_use'] + 1,'conversion_type'=>1))->save();
                                                                    } else {
                                                                        cls_redis::set($md5Data,self::USER_PRISSIONS_STATUS_2);
                                                                        return FALSE;
                                                                    }

                                                            } else {
                                                                D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('number_use'=>$member_data['number_use'] + 1))->save();
                                                            }
                                                         break;
                                                     
                                                 }
                                            }
                                            //转换成功，将当前转换的文件转移到集合fileRes
                                                    D("PdfList")->where(array('m_id'=>$members['m_id'],'id'=>$data['id']))->data(array(
                                                    'cpath'=>addslashes($fileReplacePaths),
                                                    'cstate'=>self::USER_PRISSIONS_STATUS_1,
                                                    'conversion_type'=>$conversion_type,
                                                    'cname'=>$fileName,
                                                     'fdown'=>self::USER_PRISSIONS_STATUS_1,
                                                    'ctype'=>$this->suffix_file_postfix ,
                                                    'cstyle'=>self::USER_PRISSIONS_STATUS_1))->save();
                                            if(!empty($_POST['fileInfo'])){
                                                    $fileJsonCode = json_decode($_POST['fileInfo']);
                                                    if(!empty($fileJsonCode->email)){
                                                        $email = new Mail();
                                                        $ary_option = D('EmailTemplates')->sendEmailFile($fileJsonCode->email,$fileReplacePath,$data['format'],$this->suffix_file_postfix );
                                                        if($email->send($ary_option)){
                                                                $ary_data = array();
                                                                $ary_data['email_type'] = 1;
                                                                $ary_data['email'] = $fileJsonCode->email;
                                                                $ary_data['content'] = $ary_option['message'];
                                                                $sms_res = D('EmailLog')->addEmail($ary_data);
                                                                if(!$sms_res){
                                                                        writeLog(json_encode($ary_data),date('Y-m-d')."send_email.log");
                                                                }
                                                        }
                                                        if(empty($member_data['m_email'])){
                                                             D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('m_email'=>$fileJsonCode->email))->save();
                                                        }else {
                                                            if($member_data['m_email']  != $fileJsonCode->email ){
                                                                 D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('m_email'=>$fileJsonCode->email))->save();
                                                            }
                                                        }
                                                    }
                                            }
                   
                                            cls_redis::set($md5Data,self::USER_PRISSIONS_STATUS_1);
                                    }else{
                                            cls_redis::set($md5Data,self::USER_PRISSIONS_STATUS_2);
                                            D("PdfList")->where(array('m_id'=>$members['m_id'],'id'=>$data['id']))->data(array(
                                      //      'cpath'=>addslashes($fileReplacePath),
                                            'cstate'=>self::USER_PRISSIONS_STATUS_2,
                                            'cstyle'=>self::USER_PRISSIONS_STATUS_1))->save();
                                    }

                        }else{

                                $fileError = iconv('gbk','utf-8//IGNORE',$filePath).'-->'.iconv('gbk','utf-8//IGNORE',$fileReplacePath).'---> word转pdf: '.$this->resState.'| pdf转word: '.$pdfState;
                                file_put_contents(dirname(__FILE__).'\log\log.txt',$fileError."\r\n",FILE_APPEND);
                                 $md5Data = md5(json_encode($data));
                                 cls_redis::set($md5Data,self::USER_PRISSIONS_STATUS_2);
                                //$redisObj->LREM($redisSetVal,$redisSetInfo[0],0);
                                  D("PdfList")->where(array('m_id'=>$members['m_id'],'id'=>$data['id']))->data(array(
                                          //      'cpath'=>addslashes($fileReplacePath),
                                                'cstate'=>self::USER_PRISSIONS_STATUS_2,
                                                'cstyle'=>self::USER_PRISSIONS_STATUS_1))->save();
                        }
                }
	}catch(Exception  $e){
		endLock($lockFile);//删除文件锁文件
	}
	endLock($lockFile);//删除文件锁文件
    }
    
}