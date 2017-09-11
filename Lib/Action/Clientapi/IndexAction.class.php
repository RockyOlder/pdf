<?php
class IndexAction extends MobileAction{

    public static $ip;
    public static $request_uri;
    public function __construct(){
		$array_params = $_REQUEST;
		//暂时隐藏验证
		parent::__construct();
                //print_r($this->array_params);exit;
                $array_params  = $this->array_params;
		//验证是否传入method方法
		if(!isset($array_params["method"]) || "" == $array_params["method"]){
			$this->errorResult(false,10001,array(),'缺少系统级参数method');
		}
		//测试连接
 		//$str_db_info = 'mysql://root@localhost:3306/v785';
		//C('DB_CUSTOM', $str_db_info);
 		//$_SESSION['HOST_URL'] = 'http://fx_785.com/';
	  // 判断是否开启阿里云OSS服务器
        if(empty($_SESSION['OSS']['GY_OSS_ON']) || empty($_SESSION['OSS']['GY_OTHER_ON']) || empty($_SESSION['OSS']['GY_QN_ON'])){
        	$oss_config = D("SysConfig")->getCfgByModule('GY_OSS',1);
			if(!empty($oss_config)){
				if($oss_config['GY_OSS_ON'] == '1' || $oss_config['GY_OTHER_ON'] == '1' || $oss_config['GY_QN_ON'] == '1'){
					$_SESSION['OSS'] = $oss_config;
				}				
			}
        }
		if(empty($_SESSION['OSS']['GY_QN_ON']) && C('UPLOAD_SITEIMG_QINIU.GY_QN_ON') == 1){
			$driverConfig = C('UPLOAD_SITEIMG_QINIU');
			$_SESSION['OSS']['GY_QN_ON'] = $driverConfig['GY_QN_ON'];
			$_SESSION['OSS']['GY_QN_ACCESS_KEY'] = $driverConfig['driverConfig']['accessKey'];
			$_SESSION['OSS']['GY_QN_BUCKET_NAME'] = $driverConfig['driverConfig']['bucket'];
			$_SESSION['OSS']['GY_QN_DOMAIN'] = $driverConfig['driverConfig']['domain'];
			$_SESSION['OSS']['GY_QN_SECRECT_KEY'] = $driverConfig['driverConfig']['secrectKey'];
			$_SESSION['OSS']['GY_QN_PRIVATE'] = isset($driverConfig['driverConfig']['is_private'])?$driverConfig['driverConfig']['is_private']:false;
		}
		if($_SESSION['OSS']['GY_QN_ON'] == 1 && empty($_SESSION['OSS']['GY_QN_ACCESS_KEY']) && empty($_SESSION['OSS']['GY_QN_SECRECT_KEY'])){
			$driverConfig = C('UPLOAD_SITEIMG_QINIU');
			if(!empty($driverConfig['driverConfig']['accessKey'])){
				$_SESSION['OSS']['GY_QN_ACCESS_KEY'] = $driverConfig['driverConfig']['accessKey'];
			}
			if(!empty($driverConfig['driverConfig']['bucket'])){
				$_SESSION['OSS']['GY_QN_BUCKET_NAME'] = $driverConfig['driverConfig']['bucket'];
			}		
			if(!empty($driverConfig['driverConfig']['domain'])){
				$_SESSION['OSS']['GY_QN_DOMAIN'] = $driverConfig['driverConfig']['domain'];
			}	
			if(!empty($driverConfig['driverConfig']['secrectKey'])){
				$_SESSION['OSS']['GY_QN_SECRECT_KEY'] = $driverConfig['driverConfig']['secrectKey'];
			}		
			$_SESSION['OSS']['GY_QN_PRIVATE'] = isset($driverConfig['driverConfig']['is_private'])?$driverConfig['driverConfig']['is_private']:false;		
			if(empty($_SESSION['OSS']['GY_QN_ACCESS_KEY']) && empty($_SESSION['OSS']['GY_QN_SECRECT_KEY'])){
				$_SESSION['OSS']['GY_QN_ON'] = false;
			}
		}	
         //判断是否是负载均衡
        if(!empty($_SESSION['OSS']['GY_OSS_PIC_URL']) || (!empty($_SESSION['OSS']['GY_OTHER_IP']) && !empty($_SESSION['OSS']['GY_OTHER_ON']) )){
			$oss_pic_url = D("SysConfig")->getConfigs('GY_OSS', 'GY_OSS_PIC_URL',null,null,'Y');
			if(!empty($oss_pic_url['GY_OSS_PIC_URL']['sc_value'])){
				$_SESSION['OSS']['GY_OSS_PIC_URL'] = $oss_pic_url['GY_OSS_PIC_URL']['sc_value'];
			}
			if(!empty($oss_pic_url['GY_OSS_PIC_URL']['sc_value'])){
				$_SESSION['OSS']['GY_OTHER_IP'] = $oss_pic_url['GY_OTHER_IP']['sc_value'];
			}
			$ary_static_urls = array();
			if(!empty($_SESSION['OSS']['GY_STATE_URL1'])){
				$ary_static_urls[] = $_SESSION['OSS']['GY_STATE_URL1'];
			}
			if(!empty($_SESSION['OSS']['GY_STATE_URL2'])){
				$ary_static_urls[] = $_SESSION['OSS']['GY_STATE_URL2'];
			}
			if(!empty($_SESSION['OSS']['GY_STATE_URL3'])){
				$ary_static_urls[] = $_SESSION['OSS']['GY_STATE_URL3'];
			}			
			
			if(!empty($ary_static_urls)){
				C('DOMAIN_HOST',$ary_static_urls[array_rand($ary_static_urls)]);
			}			
        }		
        //记录日志
        $ip = get_client_ip();
        self::$ip = $ip;
        $int_port = "";
        if($_SERVER["SERVER_PORT"] != 80){
            $int_port = ':' . $_SERVER["SERVER_PORT"];
        }
		unset($array_params['_URL_']);
        $request_uri = http_build_query($array_params);
        $uri = urldecode($request_uri);
        self::$request_uri = $uri;
        $url = 'http://'.$_SERVER["HTTP_HOST"].$int_port.'/'.$_SERVER["PATH_INFO"].'?'.$uri;//$_SERVER["REQUEST_URI"]; 
        $msg = 'IP地址为：'.$ip.'    接口调用时间：'.date('Y-m-d H:i:s').'     '.$url."\r\n";
        $this->logs($array_params["method"],$msg);
	}

	/**
	 * APi路由功能
	 */
	public function index(){
		$array_params = $this->array_params;
		$str_real_method = $this->getRealMethodName($array_params["method"]);
		$array_methods = get_class_methods($this);
            //    print_r($array_methods);exit;
		if(!in_array($str_real_method,$array_methods)){
			$this->errorResult(false,10005,array(),'无效的API方法' . $str_real_method);
		}
       	writeLog('debug 0', 'erpapi.log');
		//路由到相应的API方法
		$this->$str_real_method($array_params);
	}
	/**
	 * 记录错误日志
	 * @author wangguibin <wangguibin@guanyisoft.com>
	 * @date 2013-07-31
	 * @param string $code 错误日志
	 */
	function logs($code,$msg){
		$log_dir = APP_PATH . 'Runtime/Clientapilog/';
		if(!file_exists($log_dir)){
			mkdir($log_dir,0700);
		}
		$log_file = $log_dir . date('Ymd') .$code . '.log';
		$fp = fopen($log_file, 'a+');
		fwrite($fp, $msg);
		fclose($fp);
	}



// +----------------------------------------------------------------------
// | 会员相关API START
// +----------------------------------------------------------------------
// | Author: wanghaijun
// +----------------------------------------------------------------------
    /**
     * 同步老客户端接口
     * @author Rocky
     */
    private function fxMemberSynchronousData($params=null){
                  
                    // $params['pcid'] = '9cbe834f1953aac31866b5ab422254a1';
                    //$params['open_id']  = 'oQWclwLBcb0-cHFkox2F0_lMRtgk';
                    $data_send  =  rsa_public_encrypt(json_encode(array('pcid'=>$params['pcid'])));
                    $response = makeRequestUtf8('http://readermgr.cqttech.com/api/getAuthData', array('data'=>$data_send),'post');
                    if(!empty($response)){
                        $rsa_data_decrypt  = rsa_public_decrypt($response);
                    }
                    $member = D('Members');
                    $add_day  = 0;
                    $member_last_data_jsonObject = json_decode($rsa_data_decrypt);
                    $ary_member = $member->where(array('open_id'=>$params['open_id']))->find();
                    $updata_data = array();
                    $response_data = array();
                    $response_data['conversion_type'] = isset($ary_member['conversion_type'])?(int)$ary_member['conversion_type']:0;
                    $response_data['m_head_img'] = isset($ary_member['m_head_img'])?(int)$ary_member['m_head_img']:0;
                    $response_data['end_time'] = $ary_member['end_time'];
                    $response_data['number_remaining'] = isset($ary_member['number_remaining'])?(int)$ary_member['number_remaining']:0;
                    if(empty($ary_member['m_pcid'])){
                            $Members_Object_data = D('Members')->where(array('m_pcid'=>$params['pcid']))->find();
                            if(empty($Members_Object_data)){
                                    if(time() < strtotime($member_last_data_jsonObject->data->months->expire)){

                                                if(time() < strtotime($ary_member['end_time'])){
                                                    $add_day =    count_days(strtotime(date('Y-m-d H:i:s')),strtotime($ary_member['end_time']));
                                                    $buy_time = strtotime($ary_member['end_time'].' +'.$add_day.' day') ;
                                                    $updata_data['end_time']=  date('Y-m-d H:i:s',$buy_time);
                                                }else {
                                                   // $add_day =    count_days(strtotime(date('Y-m-d H:i:s')),strtotime($member_last_data_jsonObject->data->months->expire));
                                                    $updata_data['end_time']=  date('Y-m-d H:i:s',strtotime($member_last_data_jsonObject->data->months->expire));
                                                }

                                                $updata_data['Buy_time']=  date('Y-m-d H:i:s');
                                                $updata_data['conversion_type'] = 2;
                                    } 
                                    $updata_data['number_remaining']  = $ary_member['number_remaining'] + $member_last_data_jsonObject->data->times->count;
                                    if($updata_data['number_remaining'] !=0  && empty($updata_data['conversion_type'])){
                                                $updata_data['conversion_type'] = 1;
                                    }
                                    $updata_data['m_pcid'] = $params['pcid'];
                                    $member->where(array('m_id'=>$ary_member['m_id']))->save($updata_data);
                                    $options = array(
                                        'root_tag' => 'Member_SynchronousData_response'
                                    );
                                    if(time() > strtotime($updata_data['end_time'])){
                                         $end_time_count_out =  count_days(strtotime(date('Y-m-d')),strtotime($updata_data['end_time']));
                                         if($end_time_count_out > 30){
                                             $response_data['end_time']  = 0;
                                         } else {
                                             $response_data['end_time']  = -1;
                                         }

                                    } else {
                                            $response_data['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($updata_data['end_time']));
                                    }
                                    $response_data['conversion_type']  = isset($updata_data['conversion_type'])?(int)$updata_data['conversion_type']:0;
                            }
                            if(is_numeric($response_data['end_time']) == FALSE){
                                    if(time() > strtotime($response_data['end_time'])){
                                         $end_time_count_out =  count_days(strtotime(date('Y-m-d')),strtotime($response_data['end_time']));
                                         if($end_time_count_out > 30){
                                             $response_data['end_time']  = 0;
                                         } else {
                                             $response_data['end_time']  = -1;
                                         }
                                         if($end_time_count_out  < 17000){
                                             if($response_data['conversion_type'] != 1){
                                                 $response_data['conversion_type']  = 2;
                                             }
                                         }
                                    } else {
                                            $response_data['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($response_data['end_time']));
                                    }
                            }
                            writeLog("fxMemberSynchronousData_emplty_pcid:". json_encode($response_data),date('Ym-d')."fxMemberSynchronousData.log");
                            $this->addLog();
                            $this->errorResult(true,10001,$response_data,'pcid is binding existing','Remote service error',true);
                    } else {
                    //    echo date('Y-m-d H:i:s',strtotime($response_data['end_time']));exit;
                                if(time() > strtotime($response_data['end_time'])){
                                         $end_time_count_out =  count_days(strtotime(date('Y-m-d')),strtotime($response_data['end_time']));
                                         if($end_time_count_out > 30){
                                             $response_data['end_time']  = 0;
                                         } else {
                                             $response_data['end_time']  = -1;
                                         }
                                         if($end_time_count_out  < 17000){
                                             if($response_data['conversion_type'] != 1){
                                                 $response_data['conversion_type']  = 2;
                                             }
                                         }
                                } else {
                                        $response_data['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($response_data['end_time']));
                                }
                                $options = array(
                                    'root_tag' => 'pcid is binding existing'
                                );
                                    writeLog("fxMemberSynchronousData:". json_encode($response_data),date('Ym-d')."fxMemberSynchronousData.log");
                                    $this->addLog();
                                    $this->errorResult(false,10001,$response_data,'pcid已绑定','Remote service error',true);
                               // $this->errorResult(false,10001,$response_data,'pcid is binding existing');
                        //      $this->result(false,'10001',$response_data,"failure",$options);
                            //$this->result(false,10001,$response_data,'pcid已绑定');
                    }

    }
    
    private function addLog(){
      $int_port = "";
      if($_SERVER["SERVER_PORT"] != 80){
          $int_port = ':' . $_SERVER["SERVER_PORT"];
      }
      $url = 'http://'.$_SERVER["HTTP_HOST"].$int_port.'/'.$_SERVER["PATH_INFO"].'?'.self::$request_uri;//$_SERVER["REQUEST_URI"]; 
      $msg = 'IP地址为：'.self::$ip.'    接口数据返回时间：'.date('Y-m-d H:i:s').'     '.$url."\r\n";
      $this->logs($this->array_params["method"],$msg);  
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
    /**
     * 检测客户端数据是否同步接口
     * @author Rocky
     */
    private function fxMemberConcurrentValidation($params=null){
        
        $Members_Object_data = D('Members')->where(array('m_pcid'=>$params['pcid']))->find();
        $Activity_time = (int)self::getActivitp();
        if(empty($Members_Object_data)){
            $this->addLog();
            $this->errorResult(false,10001,array('success'=>'success','result'=>true,'Activity_time'=>$Activity_time),'pcid可以使用','Remote service error',true);
        } else {
            $this->addLog();
            $this->errorResult(true,10001,array('success'=>'failure','result'=>FALSE,'Activity_time'=>$Activity_time),'pcid已绑定','Remote service error',true);
          //  $this->errorResult(false,10001,array('code'=>10001,'success'=>'failure','result'=>FALSE),'pcid is binding existing');
        }
        
    }
    /**
     * 返回用户头像
     * @param return string
     */
    private function fxMemberHeadPortrait($params=null){
            $member = D('Members');
            $ary_member = $member->where(array('open_id'=>$params['open_id']))->field('m_head_img')->find();
            $ary_member['Activity_time'] = (int)self::getActivitp();
            $ary_member['RightLogin'] = array('dataMsg'=>'感恩特惠,现购买时长套餐最高可送6个月','url'=>'/Home/Products/ClientapiConversionFeeDetail/s_type/3');
            $ary_member['ConvertBanner'] = array('ImgDownload'=>'http://cdnfile.cqttech.com/res/banner.png','url'=>'/Home/Products/ClientapiConversionFeeDetail/s_type/4');
            $ary_member['Free_of_charge_five'] = array('ImgDownload'=>'http://cdnfile.cqttech.com/res/tips.png','ImgClick'=>'/Home/Products/ClientapiConversionFeeDetail/s_type/5','SnapUrl'=>'/Home/Products/ClientapiConversionFeeDetail/s_type/6');
            if(!empty($ary_member['m_head_img'])){
                $this->addLog();
                  $this->errorResult(false,10007,$ary_member,'头像','Remote service error',FALSE);
            } else {
                $this->addLog();
                  $this->errorResult(false,10001,$ary_member,'用户无头像','Remote service error',FALSE);
              //  $this->errorResult(false,10001,array('code'=>10001,'success'=>'failure','result'=>FALSE),'pcid is binding existing');
            }
    }


    private function fxMemberAuthorizationSave($params=null){
            $member = D('Members');
            $member_data = $member->getInfo('',$params['open_id']);
            $Authorization_role  = 0;
            if( $member_data['conversion_type'] ==2){
                            if(time() >  strtotime($member_data['end_time'])){
                                    if($member_data['number_remaining'] > 0){
                                        $Authorization_role  = 1;
                                        D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('number_remaining'=>$member_data['number_remaining'] -1,'number_use'=>$member_data['number_use'] + 1,'conversion_type'=>1))->save();
                                    }
                            } else {
                                D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('number_use'=>$member_data['number_use'] + 1))->save();
                            }
            } else {
                            if($member_data['number_remaining'] > 0){
                                $Authorization_role  = 1;
                                D('Members')->where(array('m_id'=>$member_data['m_id']))->data(array('number_remaining'=>$member_data['number_remaining'] -1,'number_use'=>$member_data['number_use'] + 1,'conversion_type'=>1))->save();
                            }
            }
            $MemberAuthorization  = D('MemberAuthorization');
            $add_aray_authorization = array();
            $add_aray_authorization['m_id']  = $member_data['m_id'];
            $add_aray_authorization['creation_time']  = date('Y-m-d H:i:s');
            $add_aray_authorization['type']  = $member_data['conversion_type'];
            $response_data = array();
            $response_data['conversion_type'] = (int)$member_data['conversion_type'];
            $response_data['number_remaining'] = (int)$member_data['number_remaining'];
            if(time() > strtotime($member_data['end_time'])){
                    $response_data['end_time']  = 0;

            } else {
                    $response_data['end_time']  = count_days(strtotime(date('Y-m-d')),strtotime($member_data['end_time']));
            }
            if( $MemberAuthorization->add($add_aray_authorization) ==  true){
                if($Authorization_role == 1){
                    $response_data['number_remaining'] = (int)$response_data['number_remaining'] -1;
                }
                 $this->addLog();
                 $this->errorResult(true,10007,$response_data,'pcid is binding existing','Remote service error',true);
            }
    }




    /**
	 * [注册接口]
	 * @param  [array] $params [description]
	 * @example array(
	 *          (string) 'm_mobile' => 手机号码 (必填)
	 *          (string) 'm_password' => 密码 (必填)
	 *          (string) 'm_nickname' => 用户名 (必填)
	 *          (string) 'm_email' => 邮箱 (必填)
	 *			(int) m_val_type 会员验证项0，不验证;1：邮箱必填,且唯一;2:手机号必填且唯一;3:邮箱和手机号都必填且唯一
	 * );
	 * @return [type]         [description]
     * @date 2014-12-13
	 */
	private function fxMemberRegister($params=null){
       ////writeLog("注册接口请求参数\t". json_encode($params), 'fxMemberRegister' . date('Y_m_d') . '.log');
		$m_val_type = intval($params['m_val_type']);
        //验证用户名是否输入
		if (!isset($params['m_nickname']) || "" == $params['m_nickname']) {
            $this->errorResult(false,10002,array(),'用户名不能为空');
			exit;
		}

		//验证用户名的唯一性
		if (D('Members')->checkName($params['m_nickname'])) {
            $this->errorResult(false,10002,array(),'用户名已经存在');
			exit;
		}

		//验证是否输入密码和确认密码
		if (!isset($params["m_password"]) || "" == $params["m_password"]) {
            $this->errorResult(false,10002,array(),'请设置一个密码。');
			exit;
		}

		if($m_val_type == 1 || $m_val_type == 3){
			//验证是否输入会员邮箱
			if (!isset($params['m_email']) || "" == $params['m_email']) {
				$this->errorResult(false,10002,array(),'用户邮箱不能为空');
				exit;
			}

			//验证会员邮箱地址的合法性
			$email_preg = '/^[a-z0-9._%+-]+@(?:[a-z0-9-]+.)+[a-z]{2,4}$/i';
			if (false == preg_match($email_preg, $params['m_email'])) {
				$this->errorResult(false,10002,array(),'邮箱格式不合法。');
				exit;
			}

			//验证邮箱的唯一性
			if (D('Members')->checkEmail($params['m_email'])) {
				$this->errorResult(false,10002,array(),'用户邮箱已经存在');
				exit;
			}
		}
		//手机号验证
		if($m_val_type == 2 || $m_val_type == 3){
			//验证是否输入会员手机号
			if (!isset($params['m_mobile']) || "" == $params['m_mobile']) {
				$this->errorResult(false,10002,array(),'用户手机号不能为空');
				exit;
			}

			//验证会员手机号地址的合法性
			$mobile_preg = '/^1[3|4|5|8|7][0-9]\d{8}$/i';
			if (false == preg_match($mobile_preg, $params['m_mobile'])) {
				$this->errorResult(false,10002,array(),'手机号格式不合法。');
				exit;
			}

			//验证手机号的唯一性
			$params['m_mobile'] = encrypt($params['m_mobile']);
			if (D('Members')->checkMobile($params['m_mobile'])) {
				$this->errorResult(false,10002,array(),'用户手机号已经存在');
				exit;
			}
		}

        $member = D('Members');
        //获取默认配置的会员等级
        $ml = D('MembersLevel')->getSelectedLevel();
        //拼接数组
        $ary_member = array(
                'm_name' => trim($params['m_nickname']),
                'm_password' => md5($params['m_password']),
                'm_mobile' => $params['m_mobile'],
                'm_email' => $params['m_email'],
                'm_create_time' => date('Y-m-d H:i:s'),
                'ml_id' =>  $ml,
                'm_status' => '1'
            );
        $data = D('SysConfig')->getCfgByModule('MEMBER_SET');
        if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
            $ary_member['m_verify'] = '2';
        }
        //注册奖励积分
        $obj_point = D('PointConfig');
        $int_point = $obj_point->getConfigs('regist_points');
        if(null !== $int_point && is_numeric($int_point) && $int_point>0) {
            $ary_member['total_point'] = intval($int_point);
        }
        //扩展攻击
		foreach($ary_member as &$str_member){
			$str_member = htmlspecialchars($str_member);
			$str_member = RemoveXSS($str_member);
		}
        //会员基本资料入库
		$mixed_member_id = D("Members")->add($ary_member);
		if (false === $mixed_member_id) {
            $this->errorResult(false,10002,array(),'会员资料添加失败。');
			exit;
		}
        $ary_member = $member->getInfo(trim($params['m_nickname']));
        //注册成功 送注册优惠券一张
        D('CouponActivities')->doRegisterCoupon($ary_member['m_id']);
        if($ary_member['m_mobile'] && strpos($ary_member['m_mobile'],':')){
            $ary_member['m_mobile'] = decrypt($ary_member['m_mobile']);
        }
        if($ary_member['m_telphone'] && strpos($ary_member['m_telphone'],':')){
            $ary_member['m_telphone'] = decrypt($ary_member['m_telphone']);
        }
        $options = array(
            'root_tag' => 'Member_register_response'
            );
        $this->result(true,'10007',$ary_member,"success",$options);
	}

    /**
	 * 会员登陆API
	 * @param (array) $param
	 * @example array(
	 *          'm_name' => 会员名称 (必填)
	 *          'm_password' => 密码 (必填)
	 * )
	 * @wanghaijun
	 * @date 2014-12-13
	 */
	private function fxDoLogin($params=null){
		//writeLog("会员登陆请求参数\t". json_encode($params), 'fxDoLogin' . date('Y_m_d') . '.log');
		if(!isset($params['m_name']) || "" == $params['m_name']){
			$this->errorResult(false,10201,array(),'请填写用户名!');
		}
		if(!isset($params['m_password']) || "" == $params['m_password']){
			$this->errorResult(false,10201,array(),'请填写密码');
		}
		$ary_condition = array(
			'm_name' => $params['m_name'],
			'm_password' => $params['m_password']
			);
		$ary_result = D('ApiMember')->doLogin($ary_condition);
		//writeLog("会员登陆返回参数\t". json_encode($ary_result), 'fxDoLogin' . date('Y_m_d') . '.log');
		if($ary_result['status'] !== true){
			$this->logs('loginApi',$ary_result['sub_msg']);
			$this->errorResult(false,$ary_result['code'],array(),$ary_result['sub_msg']);
		}else{
			$options = array(
				'root_tag' => 'Login_response'
				);
			$this->result(true,$ary_result['code'],$ary_result['info'],"success",$options);
		}
	}

    /**
	 * 获取用户可用收货地址
	 * @param (array) $params
	 * @example $params = array(
	 *          'm_id' => 用户ID (必填)(19)
	 * );
	 * @wanghaijun
	 * @date 2014-12-13
	 */
	private function fxMemberAddressGet($params=null){
            echo 1;exit;
		//writeLog("获取用户可用收货地址请求参数\t". json_encode($params), 'fxMemberAddressGet' . date('Y_m_d') . '.log');
		$int_m_id = isset($params['m_id']) ? intval($params['m_id']) : 0;
		if(empty($int_m_id)){
			$this->errorResult(false,10401,array(),'请填写用户ID');
		}
		$condition = array(
			'm_id' => $int_m_id,
			);
		$ary_result = D('ApiMemberAddress')->getMemberAddress($condition);
		//writeLog("获取用户可用收货地址返回数据\t". json_encode($ary_result), 'fxMemberAddressGet' . date('Y_m_d') . '.log');
		if($ary_result['status'] !== true){
			$this->logs('MemberAddressApi',$ary_result['sub_msg']);
			$this->errorResult(false,$ary_result['code'],array(),$ary_result['sub_msg']);
		}else{
			$options = array(
				'root_tag' => 'Member_address_response'
				);
			$this->result(true,$ary_result['code'],$ary_result['info'],"success",$options);
		}
	}




	
}

