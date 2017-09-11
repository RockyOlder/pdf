<?php

/**
 * 会员登录注册Action
 *
 * @package Action
 * @subpackage Ucenter
 * @version 7.1
 * @author wangguibin
 * @date 2013-04-11
 * @copyright Copyright (C) 2013, Shanghai GuanYiSoft Co., Ltd.
 */
class UserAction extends HomeAction {
    /**
     * 初始化操作
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2013-04-11
     */
    public function _initialize() {
		if($_REQUEST['code']!='' && ($_REQUEST['code']=='CHINAPAYV5'  || $_REQUEST['code']=='ICBC')){
			writeLog(json_encode($_REQUEST),"order_pay11.log");
			$this->synPayNotify();
		}
		parent::_initialize();
		$shop_close = D('SysConfig')->getCfgByModule('GY_SHOP',1);
		//店铺关闭调到会员中心
		if($shop_close['GY_SHOP_OPEN'] == 0 && MODULE_NAME !='Cart'){

			header("location:" . U('Ucenter/Index/index'));exit;
		}

		//判断是否启用店铺
       // $this->doCheckOn();
       // $this->getOnlineService();
        $this->doCheckLogin();

        if($shop_close['GY_MUST_LOGIN'] == 1 && !session('?Members')){
                $this->assign("must_login", '1');
        }
        //将custom文件中的TPL常量和SESSION的定义搬到这里
        //降低系统对custom。php文件的依赖性，提高后台和会员中心的访问效率（减少一次数据库查询）
        $array_config = D("SysConfig")->where(array("sc_key" => 'GY_TEMPLATE_DEFAULT'))->find();
        if (is_array($array_config) && !empty($array_config)) {
            define('TPL', $array_config['sc_value']);
            $_SESSION['NOW_TPL'] = $array_config['sc_value'];
        } else {
            define('TPL', 'default');
            $_SESSION['NOW_TPL'] = 'default';
        }
        $this->dir = TPL;

        //如果是预览，则根据预览算法规则重新定义预览模板所在目录
        $ary_request = $this->_request();
        if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $this->dir = 'preview_' . $ary_request['dir'];
        }
        $config = array(
            'tpl' => '/Public/Tpl/' . CI_SN . '/' . $this->dir . '/',
            'js' => '/Public/Tpl/' . CI_SN . '/' . $this->dir . '/js/',
            'images' => '/Public/Tpl/' . CI_SN . '/' . $this->dir . '/images/', // 客户模版images路径替换规则
            'css' => '/Public/Tpl/' . CI_SN . '/' . $this->dir . '/css/', // 客户模版css路径替换规则
        );
        C('TMPL_PARSE_STRING.__TPL__', $config['tpl']);
        C('TMPL_PARSE_STRING.__JS__', $config['js']);
        C('TMPL_PARSE_STRING.__IMAGES__', $config['images']);
        C('TMPL_PARSE_STRING.__CSS__', $config['css']);
        if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $header_tpl = './Public/Tpl/' . CI_SN . '/preview_' . $ary_request['dir'] . '/header.html';
        } else {
            $header_tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/header.html';
        }
        if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $footer_tpl = './Public/Tpl/' . CI_SN . '/preview_' . $ary_request['dir'] . '/footer.html';
        } else {
            $footer_tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/footer.html';
        }
        //$ary_pagecount = M('siteConfig',C('DB_PREFIX'),'DB_CUSTOM')->where(array('sc_module' => 'GY_COUNT'))->find();
		$ary_pagecount = D('Gyfx')->selectOneCache('site_config','sc_value',array('sc_module' => 'GY_COUNT'));
		//M('siteConfig',C('DB_PREFIX'),'DB_CUSTOM')->where(array('sc_module' => 'GY_COUNT'))->find();
        if($ary_pagecount){
            $pagecount = base64_decode($ary_pagecount['sc_memo']);
            $this->assign("pageCount", $pagecount);
        }
		$this->header_tpl = $header_tpl;

        $str_shop_info = M('siteConfig',C('DB_PREFIX'),'DB_CUSTOM')->where(array('sc_module' => 'GY_COUNT'))->find();
        if($str_shop_info){
            $str_shop_code = base64_decode($str_shop_info['sc_memo']);
            $this->assign("shop_code", $str_shop_code);
        }

        $this->assign("headerTpl", $header_tpl);
        $this->assign("footerTpl", $footer_tpl);
        $this->assign("cisn", CI_SN);
        $this->assign("view", $this->dir);
    }

    /**
     * 会员登陆
     * @author Terry<wanghui@guanyisoft.com>
     * @date 2013-06-28
     */
    public function Login() {
    	$this->setTitle('会员登录');
        $config = D('SysConfig');
        $ary_request = $this->_request();
        /* 取出会员扩展属性项字段 start*/  /* purple模板专用  2015-09-08  */
        $ary_extend_data = D('MembersFields')->displayFields($m_id,'register');
        foreach($ary_extend_data as $key => $extend){
            if($extend['fields_content']=="m_name"){
                $recommended = $extend['content'];
            }
        }

        $this->assign('ary_extend_data', $ary_extend_data);
        $this->assign('m_recommended', $recommended);
        /* 取出会员扩展属性项字段 end*/
        if ($_SESSION['Members']['m_id']) {
            $this->redirect(U('Home/Index/index'));
        }
        if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $tpl = './Public/Tpl/' . CI_SN . '/preview_' . $ary_request['dir'] . '/login.html';
        } else {
            $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/login.html';
        }
        $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
        $verification = $config->getCfg('VERIFICATION_SET','VERIFICATION_STATUS','1','会员登录是否验证');
		$_SESSION['rand'] = rand();
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
        $_SESSION['rand'] = rand();

		
		$this->assign($ary_status);
        $requset_url = urldecode($ary_request['requsetUrl']);
		if(empty($requset_url)){
		$requset_url = trim($ary_request['redirect_uri']);
		}
		//数据处理
		$requset_url = RemoveXSS($requset_url);
		if(empty($requset_url)){
			$requset_url = $_SERVER['HTTP_REFERER'];
		}
                
		$mobile_set = D('SysConfig')->getCfg('VERIFIPHONE_SET','VERIFIPHONE_STATUS','0','开启手机验证');
		$this->assign('is_mobile_validate',intval($mobile_set['VERIFIPHONE_STATUS']['sc_value']));
        //获取登陆页广告图片 
        $ad = $this->getTopAds();
        $this->assign('ad_arr',$ad);
        $this->assign('vef',$verification['VERIFICATION_STATUS']);
        $this->assign('requset_url',$requset_url);
        $this->display($tpl);
    }
	 /**
     * 批发/供货商登陆
     * @author LiXiaoLong<lixiaolong@guanyisoft.com>
     * @date 2014-07-21
     */
	public function ghLogin(){
		$this->setTitle('批发/供货商登录');
        $config = D('SysConfig');
        $ary_request = $this->_request();
        if ($_SESSION['Members']['m_id']) {
            $this->redirect(U('Home/Index/index'));
        }
        if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $tpl = './Public/Tpl/' . CI_SN . '/preview_' . $ary_request['dir'] . '/ghLogin.html';
        } else {
            $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/ghLogin.html';
        }
        $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
        $verification = $config->getCfg('VERIFICATION_SET','VERIFICATION_STATUS','1','会员登录是否验证');
		$_SESSION['rand'] = rand();
        $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);        $this->assign($ary_status);
        $requset_url = urldecode($ary_request['requsetUrl']);
        //获取登陆页广告图片 
        $ad = $this->getTopAds();
        $this->assign('ad_arr',$ad);
        $this->assign('vef',$verification['VERIFICATION_STATUS']);
        $this->assign('requset_url',$requset_url);
        $this->display($tpl);
	}
	public function sunday($patt,$text){

    	$patt_size = strlen($patt);
    	$text_size = strlen($text);

    	for ($i = 0;$i < $patt_size; $i++){
    		$shift[$patt[$i]] = $patt_size - $i;
    	}
    	$i = 0;
    	$limit = $text_size - $patt_size;
    	while ($i <= $limit){
    		$match_size = 0;
    		while ($text[$i + $match_size] == $patt[$match_size]) {
    			$match_size++;
    			if ($match_size == $patt_size) {
    				return $i;
    			}
    		}
    		$shift_index = $i + $patt_size;
    		if ($shift_index < $text_size && isset($shift[$text[$shift_index]])) {
    			$i += $shift[$text[$shift_index]];
    		}else{
    			$i += $patt_size;
    		}
    	}
    }

	/**
     * 会员注册页
     *
     * @version 7.1
     * @author wangguibin
     * @date 2012-04-11
     */
    public function pageRegister() {
        $this->setTitle('用户注册');
		//获得注册协议
        $data = D('SysConfig')->getCfgByModule('GY_REGISTER_CONFIG',1);
        $ary_data['content'] = '';
        if (!empty($data) && is_array($data)) {
            $ary_data['content'] = $data['REGISTER'];
			$ary_data['content'] = D('ViewGoods')->ReplaceItemDescPicDomain($ary_data['content']);
            $this->assign('content',$ary_data['content']);
        }
        //获取推荐人设置
        if (isset($_GET['m_id'])) {
             if (is_numeric(base64_decode($_GET['m_id']))) {
                $m_id=base64_decode($_GET['m_id']);
             }
        }

        /* 取出会员扩展属性项字段 start*/
        $ary_extend_data = D('MembersFields')->displayFields($m_id,'register');
        foreach($ary_extend_data as $key => $extend){
            if($extend['fields_content']=="m_name"){
                $recommended = $extend['content'];
            }
        }

        $this->assign('ary_extend_data', $ary_extend_data);
        $this->assign('m_recommended', $recommended);
        /* 取出会员扩展属性项字段 end*/
        if ($_SESSION['Members']['m_id']) {
            $this->redirect(U('Home/Index/index'));
        }
        $this->assign($ary_data);
        if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $tpl = './Public/Tpl/' . CI_SN . '/preview_' . $ary_request['dir'] . '/register.html';
        } else {
            $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/register.html';
        }
        $config = D('SysConfig');
        $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
        $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);
        //获取注册页广告图片 
        $ad = $this->getTopAds(2);
        $verification = $config->getCfg('VERIFICATION_SET','VERIFICATION_STATUS','1','会员登录是否验证');
        $this->assign('ad_arr',$ad);
        $this->assign('vef',$verification);
        $this->assign($ary_status);
        $requset_url = urldecode($ary_request['requsetUrl']);
        $this->assign('requset_url',$requset_url);
		//开启手机验证
		$_SESSION['rand'] = rand();
		$mobile_set = D('SysConfig')->getCfg('VERIFIPHONE_SET','VERIFIPHONE_STATUS','0','开启手机验证');
		$this->assign('is_mobile_validate',intval($mobile_set['VERIFIPHONE_STATUS']['sc_value']));
        $this->display($tpl);
    }
	/**
     * 批发供货会员注册页
     *
     * @version 7.6
     * @author LiXiaoLong
     * @date 2014-07-21
     */
	public function ghReg(){
		$this->setTitle('批发/供货用户注册');
        //获得注册协议
        $data = D('SysConfig')->getCfgByModule('GY_REGISTER_CONFIG',1);
        $ary_data['content'] = '';
        if (!empty($data) && is_array($data)) {
            $ary_data['content'] = $data['REGISTER'];
            $this->assign('content',$ary_data['content']);
        }
        //获取推荐人设置
        if (isset($_GET['m_id'])) {
             if (is_numeric(base64_decode($_GET['m_id']))) {
                $m_id=base64_decode($_GET['m_id']);
             }
        }

        /* 取出会员扩展属性项字段 start*/
        $ary_extend_data = D('MembersFields')->displayFields($m_id,'register');
        $this->assign('ary_extend_data', $ary_extend_data);
        /* 取出会员扩展属性项字段 end*/
        if ($_SESSION['Members']['m_id']) {
            $this->redirect(U('Home/Index/index'));
        }
        $this->assign($ary_data);
        if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $tpl = './Public/Tpl/' . CI_SN . '/preview_' . $ary_request['dir'] . '/ghReg.html';
        } else {
            $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/ghReg.html';
        }
        $config = D('SysConfig');
        $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
        $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);
        //获取注册页广告图片 
        $ad = $this->getTopAds(2);
        $verification = $config->getCfg('VERIFICATION_SET','VERIFICATION_STATUS','1','会员登录是否验证');
        $this->assign('ad_arr',$ad);
        $this->assign('vef',$verification);
        $this->assign($ary_status);
        $requset_url = urldecode($ary_request['requsetUrl']);
        $this->assign('requset_url',$requset_url);
        $this->display($tpl);
	}
    /**
     * 验证码
     */
    public function verify() {
        import('ORG.Util.Image');
		// ob_end_clean();
        Image::buildImageVerify();
    }
	/**
	 * 生成二维码
	 * get方式传入参数：data
	 * @author wade 
	 */
	public function qrcode()
	{
                require_once FXINC . '/Lib/Common/' . 'Phpqrcode.class.php';
		$url = urldecode($this->_get('data'));
		QRcode::png($url);
		exit();
	}
    /**
     * Home处理用户登录
     * @author wangguibin
     * @date 2013-04-11
     */
    public function doLogin() {
        $member = D('Members');
		$ary_post = $this->_post();
		$password = base64_decode($this->_post('m_password'));
        $rand = $_SESSION['rand'];
        $m_password = substr($password,0,$this->sunday(strval($rand),strval($password)));
        $m_password = !empty($m_password) ? $m_password : $this->_post('m_password');
        $ary_result = $member->doLoginApi($this->_post('m_name'), $m_password, $this->_post("verify"));
        if ($ary_result['status']) {
            $home_access = D('SysConfig')->getCfgByModule('HOME_USER_ACCESS',1);
            $exitTime = intval($home_access['EXPIRED_TIME']);
            if($exitTime > 0){
                @import('ORG.Util.Session');
                Session::setExpire(time() + $exitTime * 60);
            }
            $ary_member = $member->getInfo($this->_post('m_name'));
            //同步erp会员查询接口
            //将会员信息存入session
            //$_SESSION['Members'] = $ary_member;
            session('Members', $ary_member);
			/**
			把用户信息存在memcache里面去start
			**/
			$SESSION_TYPE = (ini_get('session.save_handler') == 'redis')?1:0;
			if(empty($SESSION_TYPE)){
				$uniqid = md5(uniqid(microtime()));
				writeMemberCache($uniqid,$ary_member);
				cookie('session_mid',$uniqid,3600);			
			}
			/**
			把用户信息存在memcache里面去end
			**/
			//注册成功判断是否开启积分
			$pointCfg = D('PointConfig')->getConfigs();
            //echo $pointCfg['login_points'];die;
            if($pointCfg['is_consumed'] == '1' && $pointCfg['login_points'] > 0){
                //判断今天是否已登陆一次
                $ary_where = array();
                $ary_where['u_create'] = array(between,array(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')));
                $ary_where['type'] = 13;
                $ary_where['m_id'] = $ary_member['m_id'];
                $point_exsit = D('Gyfx')->selectOne('point_log','log_id', $ary_where);
                if(empty($point_exsit)){
                    $res_point = D('PointConfig')->setMemberRewardPoints($pointCfg['login_points'],$ary_member['m_id'],13);
                }
            }
            $ary_cart = array();
            if (!empty($ary_member['m_id'])) {
                $update_member['m_last_login_time']=date('Y-m-d H:i:s');
                D('Members')->where(array('m_id'=>$ary_member['m_id']))->save($update_member);
                
             	$session_carts = session("Cart");
               // echo "<pre>";print_r($session_carts);exit;
                $ary_db_carts = D('Cart')->ReadMycart();
                foreach ($session_carts as $str_pdt => $int_num) {
                	if($int_num['type'] == '4' || $int_num['type'] == '6'){
                		$ary_cart[$str_pdt] = $int_num;
                	}else{
                	    $tmp_int_num = (int) $int_num['num'];
	                    //大于0的新插入/更新. 小于等于0的不作处理
	                    if ($tmp_int_num > 0) {
	                        $ary_cart[$str_pdt] = $int_num;
	                    }
                	}
                }
                foreach ($ary_cart as $key => $int_num) {
                    $good_type = $int_num['type'];
                    if (!empty($ary_member['m_id'])) {//database
                    	if($good_type == '4' ||$good_type == '6'){
                    		$ary_db_carts[$key] = $int_num;
                    	}else{
                    	    if (array_key_exists($key, $ary_db_carts) && isset($ary_db_carts[$key]['type']) && ($good_type == $ary_db_carts[$key]['type'])) {
	                            $ary_db_carts[$key]['num']+=$int_num['num'];
	                        } else {
	                            $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num['num'], 'type' => $good_type);
	                        }
                    	}
                    }
                }
                $Cart = D('Cart')->WriteMycart($ary_db_carts);
                session('Cart', NULL);
				//更新会员等级
				D('MembersLevel')->autoUpgrade($ary_member['m_id']);
				$url = U('Home/Index/index');
		       	if (!empty($_REQUEST['requsetUrl'])) {
		            $url = $_REQUEST['requsetUrl'];
		        }
		       	if (!empty($_REQUEST['redirect_uri'])) {
		            $url = $_REQUEST['redirect_uri'];
		        }
                $is_on = D('SysConfig')->getConfigs('GY_SHOP', 'GY_SHOP_OPEN');
                if ($is_on['GY_SHOP_OPEN']['sc_value'] == '0'){
                    $url = U('Ucenter/Index/index');
                }
                $this->success("登录成功", $url);
                //$this->ajaxReturn(array('result' => $ary_result['status'], 'msg' => $ary_result['msg']));
            }
        } else {
            $this->error($ary_result['msg'],U('Home/User/Login'),2);
        }
        //$this->ajaxReturn(array('result' => $ary_result['status'], 'msg' => $ary_result['msg']));
    }
	/**
     * Home处理批发/供应商用户登录
     * @author wangguibin
     * @date 2013-04-11
     */
	public function doGhLogin() {
        $member = D('Members');
		$password = base64_decode($this->_post('m_password'));
        $rand = $_SESSION['rand'];
        $m_password = substr($password,0,$this->sunday(strval($rand),strval($password)));
        $m_password = !empty($m_password) ? $m_password : $this->_post('m_password');
		$ary_member = $member->getInfo($this->_post('m_name'));
		if (($ary_member['m_type'] =='1') || ($ary_member['m_type'] =='2')) {
        $ary_result = $member->doLoginApi($this->_post('m_name'), $m_password, $this->_post("verify"));
        if ($ary_result['status']) {
            $home_access = D('SysConfig')->getCfgByModule('HOME_USER_ACCESS');
            $exitTime = intval($home_access['EXPIRED_TIME']);
            if($exitTime > 0){
                @import('ORG.Util.Session');
                Session::setExpire(time() + $exitTime * 60);
            }

			//dump( $ary_member);die;
            //同步erp会员查询接口
            //将会员信息存入session
            //$_SESSION['Members'] = $ary_member;
            session('Members', $ary_member);

            $ary_cart = array();
            if (!empty($ary_member['m_id'])) {
                $update_member['m_last_login_time']=date('Y-m-d H:i:s');
                D('Members')->where(array('m_id'=>$ary_member['m_id']))->save($update_member);
             	$session_carts = session("Cart");
               // echo "<pre>";print_r($session_carts);exit;
                $ary_db_carts = D('Cart')->ReadMycart();
                foreach ($session_carts as $str_pdt => $int_num) {
                	if($int_num['type'] == '4' || $int_num['type'] == '6'){
                		$ary_cart[$str_pdt] = $int_num;
                	}else{
                	    $tmp_int_num = (int) $int_num['num'];
	                    //大于0的新插入/更新. 小于等于0的不作处理
	                    if ($tmp_int_num > 0) {
	                        $ary_cart[$str_pdt] = $int_num;
	                    }
                	}
                }
                foreach ($ary_cart as $key => $int_num) {
                    $good_type = $int_num['type'];
                    if (!empty($ary_member['m_id'])) {//database
                    	if($good_type == '4' ||$good_type == '6'){
                    		$ary_db_carts[$key] = $int_num;
                    	}else{
                    	    if (array_key_exists($key, $ary_db_carts) && isset($ary_db_carts[$key]['type']) && ($good_type == $ary_db_carts[$key]['type'])) {
	                            $ary_db_carts[$key]['num']+=$int_num['num'];
	                        } else {
	                            $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num['num'], 'type' => $good_type);
	                        }
                    	}
                    }
                }
                $Cart = D('Cart')->WriteMycart($ary_db_carts);
                session('Cart', NULL);
				//更新会员等级
				D('MembersLevel')->autoUpgrade($ary_member['m_id']);
		       	if (!empty($_POST['requsetUrl'])) {
		            $url = $_POST['requsetUrl'];
		        } else {
		            $url = U('Home/Index/index');
		        }
                $is_on = D('SysConfig')->getConfigs('GY_SHOP', 'GY_SHOP_OPEN');
				//dump($is_on['GY_SHOP_OPEN']['sc_value']);die();
				//dump($ary_member['m_type']);die;

                if ($is_on['GY_SHOP_OPEN']['sc_value'] == '0'){
                    $url = U('Ucenter/Index/index');
                }
                $this->success("登录成功", $url);
                //$this->ajaxReturn(array('result' => $ary_result['status'], 'msg' => $ary_result['msg']));
            }
        } else {
           $this->error($ary_result['msg'],U('Home/User/ghLogin'),2);

        }
        //$this->ajaxReturn(array('result' => $ary_result['status'], 'msg' => $ary_result['msg']));
	  }else {
		$this->error('您还不是批发/供货会员，请先注册', U('Home/User/ghReg'),2);die();
	  }
	}

    /**
     * 处理用户退出，退出后进入登录页
     * @author wangguibin
     * @date 2013-04-11
     */
    public function doLogout() {
        //D('Members')->where(array('m_id'=>$_SESSION['Members']['m_id']))->save(array('login_type'=>0));
//		$SESSION_TYPE = (ini_get('session.save_handler') == 'redis')?1:0;
//		if(empty($SESSION_TYPE)){
//			writeMemberCache($_COOKIE['session_mid'],null,-100);
//			cookie('session_mid',null);			
//		}
            cookie('openid',null);
            session('Members', null);
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = U('Home/Index/index');
        }
        $url = str_ireplace('/token', '', $url);
        $this->redirect($url);
        //$this->success('用户退出成功', $url);
    }

    /**
     * 处理用户注册
     *
     * @author wangguibin
     * @date 2013-04-11
     */
    public function doRegister() {
        //获取默认配置的会员等级
        $ml = D('MembersLevel')->getSelectedLevel();
		$password = base64_decode($this->_post('m_password'));
        $rand = $_SESSION['rand'];
        $m_password = substr($password,0,$this->sunday(strval($rand),strval($password)));
        $m_password = !empty($m_password) ? $m_password : $this->_post('m_password');
		$password_1 = base64_decode($this->_post('m_password_1'));
        $m_password_1 = substr($password_1,0,$this->sunday(strval($rand),strval($password_1)));
        $m_password_1 = !empty($m_password_1) ? $m_password_1 : $this->_post('m_password_1');

        //拼接数组
        $ary_member = array(
            'm_name' => trim($this->_post('m_name')),
            'm_password' => $m_password,
            'm_password_c' => $m_password_1,
            'm_mobile' => $this->_post('m_mobile'),
            'm_wangwang' => ($this->_post('m_wangwang')) ? $this->_post('m_wangwang') : "",
            'm_qq' => ($this->_post('m_qq')) ? $this->_post('m_qq') : "",
			'm_id_card' => ($this->_post('m_id_card')) ? $this->_post('m_id_card') : "",
            'm_website_url' => ($this->_post('m_website_url')) ? $this->_post('m_website_url') : "",
            'm_create_time' => date('Y-m-d H:i:s'),
            'm_status' => '1',
            'ml_id' =>  $ml,
            'm_recommended' => $this->_post('m_recommended'));
		if(!empty($ary_member['m_recommended'])){
			$reMid = D('Members')->where(array('m_name'=>$ary_member['m_recommended']))->getField('m_id');
			if(empty($reMid)){
				unset($ary_member['m_recommended']);
			}
		}
        if (!empty($_POST['m_real_name']) && isset($_POST['m_real_name'])) {
            $ary_member['m_real_name'] = $this->_post('m_real_name');
        }
        if (!empty($_POST['m_email']) && isset($_POST['m_email'])) {
            $ary_member['m_email'] = $this->_post('m_email');
        }
        if (!empty($_POST['region1']) && isset($_POST['region1'])) {
            $ary_member['cr_id'] = $this->_post('region1');
        }else{
			if(!empty($_POST['city']) && isset($_POST['city'])){
				$ary_member['cr_id'] = $this->_post('city');
			}else{
			 $ary_member['cr_id'] = $this->_post('province');
			}
		}
        if (!empty($_POST['m_address_detail']) && isset($_POST['m_address_detail'])) {
            $ary_member['m_address_detail'] = $this->_post('m_address_detail');
        }
        if (!empty($_POST['m_zipcode']) && isset($_POST['m_zipcode'])) {
            $ary_member['m_zipcode'] = $this->_post('m_zipcode');
        }
        if (!empty($_POST['m_telphone']) && isset($_POST['m_telphone'])) {
            $ary_member['m_telphone'] = $this->_post('m_telphone');
        }
        if (!empty($_POST['m_alipay_name']) && isset($_POST['m_alipay_name'])) {
            $ary_member['m_alipay_name'] = $this->_post('m_alipay_name');
        }
        if (!empty($_POST['m_balance_name']) && isset($_POST['m_balance_name'])) {
            $ary_member['m_balance_name'] = $this->_post('m_balance_name');
        }
        if (!empty($_POST['province']) && isset($_POST['province'])) {
            $area_data=D('AreaJurisdiction')->where(array('cr_id'=>$_POST['province']))->find();
            if(!empty($area_data['s_id'])){
                $ary_member['m_subcompany_id'] = $area_data['s_id'];
            }
        }

        $data = D('SysConfig')->getCfgByModule('MEMBER_SET');
        if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
            $ary_member['m_verify'] = '2';
        }
		//扩展攻击
		foreach($ary_member as &$str_member){
			$str_member = htmlspecialchars($str_member);
			$str_member = RemoveXSS($str_member);
		}
        $member = D('Members');
		//开启手机验证,验证验证码是否正确
		$mobile_set = D('SysConfig')->getCfg('VERIFIPHONE_SET','VERIFIPHONE_STATUS','0','开启手机验证');
		if($mobile_set['VERIFIPHONE_STATUS']['sc_value'] == 1){
			$m_mobile_code = $this->_post('m_mobile_code');
			if(empty($m_mobile_code) || empty($ary_member['m_mobile'])){
				if(IS_AJAX){
					 $this->ajaxReturn(array('status'=>0,'msg'=>'已开启手机验证，请输入验证码'));exit;
				}else{
					$this->error('已开启手机验证，请输入验证码');exit;
				}
			}else{
				//判断手机号是否在90秒内已发送短信验证码
				$ary_sms_where = array();
				$ary_sms_where['check_status'] = 0;
				$ary_sms_where['status'] = 1;
				$ary_sms_where['sms_type'] = 1;
				$ary_sms_where['code'] = $m_mobile_code;
				//$ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
				$sms_log = D('SmsLog')->getSmsInfo($ary_sms_where);
				if($sms_log['code'] != $m_mobile_code){
					if(IS_AJAX){
						 $this->ajaxReturn(array('status'=>0,'msg'=>'验证码不存在或已过期'));exit;
					}else{
						$this->error('验证码不存在或已过期');exit;
					}
				}else{
					//更新验证码使用状态
					$up_res = D('SmsLog')->updateSms(array('id'=>$sms_log['id']),array('check_status'=>1));
					if(!$up_res){
						if(IS_AJAX){
							 $this->ajaxReturn(array('status'=>0,'msg'=>'注册失败,更新验证码状态失败'));exit;
						}else{
							$this->error('注册失败,更新验证码状态失败');exit;
						}
					}
					//设置其他已发送验证码无效
					D('SmsLog')->updateSms(array('sms_type'=>2,'check_status'=>0,'mobile'=>$ary_member['m_mobile']),array('check_status'=>2));
				}
			}
			$ary_member['m_mobile_code'] = $m_mobile_code;
		}
        $ary_result = $member->doRegister($ary_member, $this->_post('verify'));
		if(isset($ary_member['m_mobile_code'])){
			unset($ary_member['m_mobile_code']);
		}
        $_SESSION['last_member_id']= $ary_result['data']['m_id'];
        $ary_result['data']['m_name'] = $this->_post('m_name');
        //print_r($ary_result);exit;
        if ($ary_result['status'] == '1') {
			if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
				$verify = 2;
			}
            /*把新增加用户属性项信息插入数据库 start*/
            D('MembersFieldsInfo')->doAdd($_POST,$ary_result['data']['m_id'],$verify);
            //注册成功判断是否开启积分
            $pointCfg = D('PointConfig')->getConfigs();
            if($pointCfg['is_consumed'] == '1' ){
                if($pointCfg['regist_points'] > 0){
                    D('PointConfig')->setMemberRewardPoints($pointCfg['regist_points'],$ary_result['m_id'],2);
                }
                if($pointCfg['invites_points']>0 && !empty($ary_member['m_recommended'])){
                    //$reMid = D('Members')->where(array('m_name'=>$ary_member['m_recommended']))->getField('m_id');
                    if($reMid){
                        D('PointConfig')->setMemberRewardPoints($pointCfg['invites_points'],$reMid,14);
                    }
                }
            }
			//注册成功之后如果是自动审核默认自动登陆
			if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
				$ary_member = $member->getInfo($this->_post('m_name'));
				$SESSION_TYPE = (ini_get('session.save_handler') == 'redis')?1:0;
				if(empty($SESSION_TYPE)){
				session('Members', $ary_member);
				$uniqid = md5(uniqid(microtime()));
				writeMemberCache($uniqid,$ary_member);
				cookie('session_mid',$uniqid,3600);			
				}
			}
			//注册成功之后 如果有推荐人，成为子分销商
			$ary_member['m_id'] = $ary_result['data']['m_id'];
			if($reMid){
				D('Members')->addRecommended($ary_member);
			}
            //注册成功 送注册优惠券一张
            D('CouponActivities')->doRegisterCoupon($ary_member['m_id']);
			if(IS_AJAX){
                $this->ajaxReturn($ary_result);
            }else{
                $this->success("恭喜您注册成功，3秒后跳转至首页", "/Home/Index", 3);
            }        
        } else {
			if(IS_AJAX){
                $this->ajaxReturn($ary_result);
            }else{
                $this->error($ary_result['msg']);
            }        
        }
        //$this->ajaxReturn($ary_result);
    }
    /**
     * chaopin模版注册
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-25
     */
    public function doRegisterByChaoPin(){
        //获取默认配置的会员等级
        $ml = D('MembersLevel')->getSelectedLevel();
        $backUrl = '';  // 跳转页面
        //拼接数组
        $ary_member = array(
            'm_name'        => $this->_post('m_name'),
            'm_password'    => $this->_post('m_password'),
            'm_password_c'  => $this->_post('m_password_1'),
            // 'm_mobile'      => $this->_post('m_mobile'),
            'm_wangwang'    => ($this->_post('m_wangwang')) ? $this->_post('m_wangwang') : "",
            'm_qq'          => ($this->_post('m_qq')) ? $this->_post('m_qq') : "",
            'm_website_url' => ($this->_post('m_website_url')) ? $this->_post('m_website_url') : "",
            'm_create_time' => date('Y-m-d H:i:s'),
            'm_status'      => '1',
            'ml_id'         => $ml,
            'm_recommended' => $this->_post('m_recommended'));
        $Mname = $this->_post('another');
        // 验证是否是邮箱
        if(ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+",$Mname)){
            $ary_member['m_email'] = $Mname;
            $backUrl = '/Home/User/InvalidEmail';
            if (D('Members')->checkEmail($Mname)) {
                $this->error('该邮箱已被注册，请重新输入！');exit();
            }
        }
        // 验证手机
        if(preg_match("/^1[0-9]{1}[0-9]{1}[0-9]{8}$/",$Mname)){
            $ary_member['m_mobile'] = $Mname;
            $backUrl = '/Home/User/InvalidMobile';
            if (D('Members')->checkMobile($Mname)) {
                $this->error('该手机号已被注册，请重新输入！');exit();
            }
        }
        if(empty($ary_member['m_email']) && empty($ary_member['m_mobile'])){
            $this->error('用户名请输入邮箱或者手机号码!');exit();
        }
        if (!empty($_POST['m_real_name']) && isset($_POST['m_real_name'])) {
            $ary_member['m_real_name'] = $this->_post('m_real_name');
        }
        // if (!empty($_POST['m_email']) && isset($_POST['m_email'])) {
        //     $ary_member['m_email'] = $this->_post('m_email');
        // }
        if (!empty($_POST['region1']) && isset($_POST['region1'])) {
            $ary_member['cr_id'] = $this->_post('region1');
        }
        if (!empty($_POST['m_address_detail']) && isset($_POST['m_address_detail'])) {
            $ary_member['m_address_detail'] = $this->_post('m_address_detail');
        }
        if (!empty($_POST['m_zipcode']) && isset($_POST['m_zipcode'])) {
            $ary_member['m_zipcode'] = $this->_post('m_zipcode');
        }
        if (!empty($_POST['m_telphone']) && isset($_POST['m_telphone'])) {
            $ary_member['m_telphone'] = $this->_post('m_telphone');
        }
        if (!empty($_POST['m_alipay_name']) && isset($_POST['m_alipay_name'])) {
            $ary_member['m_alipay_name'] = $this->_post('m_alipay_name');
        }
        if (!empty($_POST['m_balance_name']) && isset($_POST['m_balance_name'])) {
            $ary_member['m_balance_name'] = $this->_post('m_balance_name');
        }
        if (!empty($_POST['province']) && isset($_POST['province'])) {
            $area_data=D('AreaJurisdiction')->where(array('cr_id'=>$_POST['province']))->find();
            if(!empty($area_data['s_id'])){
                $ary_member['m_subcompany_id'] = $area_data['s_id'];
            }
        }
        // 判断是否自动审核
        $data = D('SysConfig')->getCfgByModule('MEMBER_SET');
        $member = D('Members');
        if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
            $ary_member['m_verify'] = '2';
        }else{
            //开启手机验证,验证验证码是否正确
            $mobile_set = D('SysConfig')->getCfg('VERIFIPHONE_SET','VERIFIPHONE_STATUS','0','开启手机验证');
            $email_set = D('SysConfig')->getCfg('VERIFYEMAIL_SET','VERIFYEMAIL_STATUS','0','开启邮箱验证');
            /**
             * 1.发送邮箱验证码/手机验证码
             */
            if($mobile_set['VERIFIPHONE_STATUS']['sc_value'] == 1 && !empty($ary_member['m_mobile'])){
                $mobile_result = $this->sendRegisterMobileCode($ary_member['m_mobile']);
                if(!$mobile_result){
                    $this->error('短信发送失败!');
                }
            }elseif($email_set['VERIFYEMAIL_STATUS']['sc_value'] == 1 && !empty($ary_member['m_email'])){
                $email_url = 'Home/User/doInvalidEmail/';
                $ary_option = D('EmailTemplates')->sendValidateEmail(md5($ary_member['m_password']),$ary_member['m_name'],$ary_member['m_email'],$email_url);
                //发送邮件
                $email = new Mail();
                if ($email->sendMail($ary_option)) {
                    //日志记录下
                    $ary_data = array();
                    $ary_data['email_type'] = 1;
                    $ary_data['email'] = $ary_member['m_email'];
                    $ary_data['content'] = $ary_option['message'];
                    $email_res = D('EmailLog')->addEmail($ary_data);
                    if(!$email_res){
                        writeLog(json_encode($ary_data),date('Y-m-d')."send_email.log");
                        $this->error('邮件发送失败!');
                    }
                    // $this->success('邮件已经发送到您的邮箱', U('Home/User/login'));
                } else {
                    $this->error('邮件发送失败!');
                }
            }
        }
        $ary_result = $member->doRegister($ary_member, $this->_post('verify'));
        $_SESSION['last_member_id']= $ary_result['data']['m_id'];
        $ary_result['data']['m_name'] = $this->_post('m_name');
        if ($ary_result['status'] == '1') {
            /*把新增加用户属性项信息插入数据库 start*/
            $int_extend_res = D('MembersFieldsInfo')->doAdd($_POST,$ary_result['data']['m_id']);
            if(!$int_extend_res['result']){
                $this->error('您注册失败');
            }
            //注册成功判断是否开启积分
            $pointCfg = D('PointConfig')->getConfigs();
            if($pointCfg['is_consumed'] == '1' ){
                if($pointCfg['regist_points'] > 0){
                    $res_point = D('PointConfig')->setMemberRewardPoints($pointCfg['regist_points'],$ary_result['m_id'],2);
                    //echo D()->getLastSql();exit();
                    if(!$res_point['result']){
                        $this->error($res_point['message']);
                    }
                }
                if($pointCfg['invites_points']>0 && !empty($ary_member['m_recommended'])){
                    $reMid = D('Members')->where(array('m_name'=>$ary_member['m_recommended']))->getField('m_id');
                    if($reMid){
                        $res_invites_point = D('PointConfig')->setMemberRewardPoints($pointCfg['invites_points'],$reMid,14);
                        if(!$res_invites_point['result']){
                            $this->error($res_invites_point['message']);
                        }
                    }
                }
            }
            //注册成功之后如果是自动审核默认自动登陆     
            // if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
            //     $ary_member = $member->getInfo($this->_post('m_name'));
            //     session('Members', $ary_member);
            //     $backUrl = '/Home/Index';
            // }
            /*把新增加用户属性项信息插入数据库 end*/
            //注册成功之后 如果有推荐人，成为子分销商  
            D('Members')->addRecommended($ary_member);
            $this->success("恭喜您注册成功，3秒后跳转", $backUrl, 3);
        } else {
            $this->error($ary_result['msg']);
        }
    }

    /**
     * 验证邮箱或者手机
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-28
     */
    public function checkEmailMobile(){
        $Mname = $this->_request('another');
        // 验证是否是邮箱
        if(ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+",$Mname)){
            $ary_member['m_email'] = $Mname;
            $backUrl = '/Home/User/InvalidEmail';
            if (D('Members')->checkEmail($Mname)) {
                $this->ajaxReturn('该邮箱已被注册，请重新输入！');exit();
            }
        }
        // 验证手机
        if(preg_match("/^1[0-9]{1}[0-9]{1}[0-9]{8}$/",$Mname)){
            $ary_member['m_mobile'] = $Mname;
            $backUrl = '/Home/User/InvalidMobile';
            if (D('Members')->checkMobile($Mname)) {
                $this->ajaxReturn('该手机号已被注册，请重新输入！');exit();
            }
        }
        $this->ajaxReturn(true);
    }
    /**
     * 验证页面
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-27
     */
    public function InvalidMobileEmail(){
        $data = D('SysConfig')->getCfgByModule('MEMBER_SET',1);
        $mobile_set = D('SysConfig')->getCfg('VERIFIPHONE_SET','VERIFIPHONE_STATUS','0','开启手机验证');
        $email_set = D('SysConfig')->getCfg('VERIFYEMAIL_SET','VERIFYEMAIL_STATUS','0','开启邮箱验证');
        $member = D('Members');
        $m_id = $_SESSION['last_member_id'];
        if(empty($m_id)){
            $this->success('已经验证',U('Home/Index/index'));exit();
        }
        $member_info = $member->getByNameLevel(array('m_id'=>$m_id));
        //注册成功之后如果是自动审核默认自动登陆     
        if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
            session('Members', $member_info);
            header('Location:'.'/Home/Index/index');
        }
        if(empty($member_info) && !isset($member_info['m_name']) && empty($member_info['m_name'])){
            $this->success('请先注册!',U('Home/User/register'));
        }
        $tpl = '';
        if(isset($member_info['m_email']) && !empty($member_info['m_email']) && $mobile_set['VERIFIPHONE_STATUS']['sc_value'] == 1){
            $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/email_code.html';
        }elseif(isset($member_info['m_mobile']) && !empty($member_info['m_mobile']) && $email_set['VERIFYEMAIL_STATUS']['sc_value'] == 1){
            $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/mobile_code.html';
        }else{
            $this->success('注册成功',U('Home/User/Login'));
        }
        $this->assign('member',$member_info);
        $this->display($tpl);
    }

    /**
     * 提交验证手机
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-27
     */
    public function doInvalidMobile(){
        $m_mobile_code = $this->_request('mobile_code');
        $m_id = $_SESSION['last_member_id'];
        $member = D('Members');
        if(empty($m_id)){
            $this->error('请先注册!',U('Home/User/register'));
        }
        $member_info = $member->getByNameLevel(array('m_id'=>$m_id));
        //判断手机号是否在90秒内已发送短信验证码
        $ary_sms_where = array();
        $ary_sms_where['check_status'] = 0;
        $ary_sms_where['status'] = 1;
        $ary_sms_where['sms_type'] = 1;
        $ary_sms_where['code'] = $m_mobile_code;
        //$ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
        $sms_log = D('SmsLog')->getSmsInfo($ary_sms_where);
        if($sms_log['code'] != $m_mobile_code && IS_AJAX){
            $this->ajaxReturn(array('status'=>0,'info'=>'验证码不存在或已过期'));exit;
        }else{
            //更新验证码使用状态
            $up_res = D('SmsLog')->updateSms(array('id'=>$sms_log['id']),array('check_status'=>1));
            if(!$up_res && IS_AJAX){
                $this->ajaxReturn(array('status'=>0,'info'=>'更新验证码状态失败'));exit;
            }
            //设置其他已发送验证码无效
            D('SmsLog')->updateSms(array('sms_type'=>2,'check_status'=>0,'mobile'=>$member_info['m_mobile']),array('check_status'=>2));
            // 更新用户审核状态
            $invalid_res = $member->doEdit(array('m_verify'=>2),$member_info['m_id']);
            if($invalid_res){
                unset($_SESSION['last_member_id']);
                // 默认自动登陆     
                session('Members', $member_info);
                $this->success('手机验证成功', U('Home/Index/index'));
            }else{
                $this->error('手机验证失败', U('Home/User/InvalidMobileEmail'));
            }
        }
    }

    /**
     * 提交验证邮箱
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-27
     */
    public function doInvalidEmail(){
        $member = D('Members');
        $m_id = $_SESSION['last_member_id'];
        if(empty($m_id)){
            $this->error('请先注册!',U('Home/User/pageRegister'));
        }
        $member_info = $member->getByNameLevel(array('m_id'=>$m_id));
        // 解密连接代码
        $code = authcode(base64_decode($this->_get('code')), 'DECODE');
        // 验证
        $result = $member->checkNamePassword($this->_get('name'), $code);
        if (FALSE == $code || FALSE == $result) {
            $this->error('非法链接或者链接已经失效!');exit();
        }
        if($result['m_verify'] != 0){
            $this->error('您已经验证或者已经失效!');exit();
        }
        // 更新验证码使用状态
        $up_res = D('EmailLog')->updateEmail(array('email'=>$result['m_email'],'email_type'=>1,'check_status'=>0),array('check_status'=>1));
        // 更新用户审核状态
        $invalid_res = $member->doEdit(array('m_verify'=>2),$result['m_id']);
        if($up_res && $invalid_res){
            unset($_SESSION['last_member_id']);
            // 默认自动登陆     
            session('Members', $member_info);
            $this->success('邮箱验证成功', U('Home/Index/index'));
        }else{
            $this->error('邮箱验证失败', U('Home/User/InvalidMobileEmail'));
        }
    }

    /**
     * 重发邮件
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-27
     */
    public function doResetEmail(){
        $m_id = $_SESSION['last_member_id'];
        $m_post_id = $this->_post('m_id');
        if(empty($m_id) && $m_id != $m_post_id){
            $this->error('已经验证!请勿重复验证');exit();
        }
        $ary_member = D('Members')->getByNameLevel(array('m_id'=>$m_id,'m_verify'=>0),'m_name,m_email,m_mobile,m_id');
        if(empty($ary_member)){
            $this->error('已经验证!请勿重复验证');exit();
        }
        //判断邮件是否在90秒内已发送短信验证码
        $ary_email_where = array();
        $ary_email_where['check_status'] = 0;
        $ary_email_where['status'] = 1;
        $ary_email_where['email_type'] = 1;
        $ary_email_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
        $email_log = D('EmailLog')->getEmailInfo($ary_email_where);
        if(count($email_log) >= 1){
            $this->error('请等待90秒后,再发送邮件!');exit();
        }else{
            $email_url = 'Home/User/doInvalidEmail/';
            $ary_option = D('EmailTemplates')->sendValidateEmail($ary_member['m_password'],$ary_member['m_name'],$ary_member['m_email'],$email_url);
            //发送邮件
            $email = new Mail();
            if ($email->sendMail($ary_option)) {
                //日志记录下
                $ary_data = array();
                $ary_data['email_type'] = 1;
                $ary_data['email'] = $ary_member['m_email'];
                $ary_data['content'] = $ary_option['message'];
                $email_res = D('EmailLog')->addEmail($ary_data);
                if(!$email_res){
                    writeLog(json_encode($ary_data),date('Y-m-d')."send_email.log");
                    $this->error('邮件发送失败!');exit();
                }
                $this->success('邮件已经发送到您的邮箱!');exit();
            } else {
                $this->error('邮件发送失败!');
            }
        }
    }

    /**
     * 重发注册短信
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-27
     */
    public function doResetMobile(){
        $m_id = $_SESSION['last_member_id'];
        $m_post_id = $this->_post('m_id');
        if(empty($m_id) && $m_id != $m_post_id){
            $this->error('已经验证!请勿重复验证');exit;
        }
        $ary_member = D('Members')->getByNameLevel(array('m_id'=>$m_id,'m_verify'=>0),'m_name,m_email,m_mobile,m_id');
        if(empty($ary_member)){
            $this->error('已经验证!请勿重复验证');exit;
        }
        //判断手机号是否在90秒内已重置过
        $ary_sms_where = array();
        $ary_sms_where['check_status'] = 0;
        $ary_sms_where['status'] = 1;
        $ary_sms_where['sms_type'] = 1;
        $ary_sms_where['mobile'] = $ary_member['m_mobile'];
        $ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
        $sms_count = D('SmsLog')->getCount($ary_sms_where);
        if($sms_count>0){
            $this->error('请等待90秒后,再发送短信!');exit;
        }
        M('')->startTrans();
        //更新验证码使用状态
        // $ary_where = array(
        //     'mobile'       => $ary_member['m_mobile'],
        //     'check_status' => 0,
        //     'status'       => 1,
        //     'sms_type'     => 1
        //     );
        // $up_res = D('SmsLog')->updateSms($ary_where,array('check_status'=>2));
        // if(!$up_res){
        //     M('')->rollback();
        //     $this->error('更新验证码失败');exit;
        // }
        $send_res = $this->sendRegisterMobileCode($ary_member['m_mobile']);
        if(!$send_res){
            M('')->rollback();
            $this->error('更新验证码失败');exit();
        }else{
            M('')->commit();
            $this->error('更新验证码成功');exit();
        }
    }

	/**
     * 处理批发/供货用户注册
     *
     * @author LiXiaoLong
     * @date 2013-04-11
     */
    public function doGhRegister() {
        //获取默认配置的会员等级
        $ml = D('MembersLevel')->getSelectedLevel();
        //拼接数组
        $ary_member = array(
            'm_name' => $this->_post('m_name'),
            'm_password' => $this->_post('m_password'),
            'm_password_c' => $this->_post('m_password_1'),
            'm_mobile' => $this->_post('m_mobile'),
            'm_wangwang' => ($this->_post('m_wangwang')) ? $this->_post('m_wangwang') : "",
            'm_qq' => ($this->_post('m_qq')) ? $this->_post('m_qq') : "",
            'm_website_url' => ($this->_post('m_website_url')) ? $this->_post('m_website_url') : "",
            'm_create_time' => date('Y-m-d H:i:s'),
            'm_status' => '1',
            'ml_id' =>  $ml,
			'm_recommended' => $this->_post('m_recommended'),
			'm_type' => ($this->_post('m_type')) ? $this->_post('m_type'): 0
			);
        if (!empty($_POST['m_real_name']) && isset($_POST['m_real_name'])) {
            $ary_member['m_real_name'] = $this->_post('m_real_name');
        }
        if (!empty($_POST['m_email']) && isset($_POST['m_email'])) {
            $ary_member['m_email'] = $this->_post('m_email');
        }
        if (!empty($_POST['region1']) && isset($_POST['region1'])) {
            $ary_member['cr_id'] = $this->_post('region1');
        }
        if (!empty($_POST['m_address_detail']) && isset($_POST['m_address_detail'])) {
            $ary_member['m_address_detail'] = $this->_post('m_address_detail');
        }
        if (!empty($_POST['m_zipcode']) && isset($_POST['m_zipcode'])) {
            $ary_member['m_zipcode'] = $this->_post('m_zipcode');
        }
        if (!empty($_POST['m_telphone']) && isset($_POST['m_telphone'])) {
            $ary_member['m_telphone'] = $this->_post('m_telphone');
        }
        if (!empty($_POST['m_alipay_name']) && isset($_POST['m_alipay_name'])) {
            $ary_member['m_alipay_name'] = $this->_post('m_alipay_name');
        }
        if (!empty($_POST['m_balance_name']) && isset($_POST['m_balance_name'])) {
            $ary_member['m_balance_name'] = $this->_post('m_balance_name');
        }
		if (!empty($_POST['m_type']) && isset($_POST['m_type'])) {
			$ary_member['m_type'] = $this->_post('m_type');
		}
        if (!empty($_POST['province']) && isset($_POST['province'])) {
            $area_data=D('AreaJurisdiction')->where(array('cr_id'=>$_POST['province']))->find();
            if(!empty($area_data['s_id'])){
                $ary_member['m_subcompany_id'] = $area_data['s_id'];
            }
        }

        $data = D('SysConfig')->getCfgByModule('MEMBER_SET');
        if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
            $ary_member['m_verify'] = '2';
        }
        $member = D('Members');
        $ary_result = $member->doRegister($ary_member, $this->_post('verify'));
        $_SESSION['last_member_id']= $ary_result['data']['m_id'];
        $ary_result['data']['m_name'] = $this->_post('m_name');
        //print_r($ary_result);exit;
        if ($ary_result['status'] == '1') {
            /*把新增加用户属性项信息插入数据库 start*/
            $int_extend_res = D('MembersFieldsInfo')->doAdd($_POST,$ary_result['data']['m_id']);
            if(!$int_extend_res['result']){
                $this->error('您注册失败');
            }
            /*把新增加用户属性项信息插入数据库 end*/
			if(IS_AJAX){
                $this->ajaxReturn($ary_result);
            }else{
                $this->success("恭喜您注册成功，3秒后跳转至首页", "/Home/Index", 3);
            }        } else {
            $this->error($ary_result['msg']);
        }
        //$this->ajaxReturn($ary_result);
    }

    /**
     * 验证验证码是否正确
     * @author wangguibin
     * @date 2013-04-11
     */
    public function checkVerify() {
       if ($_COOKIE['verify'] != md5($this->_get('verify'))) {
            $this->ajaxReturn('验证码有误,请点击换一张！');
        } else {
            $this->ajaxReturn(true);
        }
    }

    /**
     * 验证用户是否唯一
     */
    public function checkName() {
        if (D('Members')->checkName($this->_get('m_name'))) {
            $this->ajaxReturn('该用户已存在！');
        } else {
            $this->ajaxReturn(true);
        }
    }

    /**
     * 验证用户名是否唯一
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-28
     */
    public function checkNameByChaoPin(){
        if (D('Members')->checkName($this->_get('m_name'))) {
            $this->ajaxReturn('您的帐号已经是澳道会员,澳道会员可以直接登录本站哦!<a href="'.U('Home/User/Login').'">前往登录</a>');
        } else {
            $this->ajaxReturn(true);
        }
    }

    /**
     * 验证邮箱是否唯一
     */
    public function checkEmail() {
        if (D('Members')->checkEmail($this->_get('m_email'))) {
            $this->ajaxReturn('该邮箱已被注册，请重新输入！');
        } else {
            $this->ajaxReturn(true);
        }
    }

	/**
     * 验证手机号是否唯一及格式验证
     */
    public function checkMobile() {
		//判读是不是手机格式
		$m_mobile = $this->_get('m_mobile');
		if(!preg_match("/^1[0-9]{1}[0-9]{1}[0-9]{8}$/",$m_mobile)){
			$this->ajaxReturn('请输入正确的手机号格式！');
		}
        if (D('Members')->checkMobile(encrypt($m_mobile))) {
            $this->ajaxReturn('该手机号已被注册，请重新输入！');
        } else {
            $this->ajaxReturn(true);
        }
    }

	/**
     * 验证手机验证码是否存在
	 * @author wangguibin wangguibin@guanyisoft.com
     * @date 2013-08-05
     */
    public function checkMobileCode() {
		//判读是不是手机格式
		$m_mobile_code = $this->_get('m_mobile_code');
		if(empty($m_mobile_code)){
			$this->ajaxReturn('手机验证码不正确');
		}
		//判断手机号是否在90秒内已发送短信验证码
		$ary_sms_where = array();
		$ary_sms_where['check_status'] = 0;
		$ary_sms_where['status'] = 1;
		$ary_sms_where['sms_type'] = 1;
		$ary_sms_where['code'] = $m_mobile_code;
		//$ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
		$sms_log = D('SmsLog')->getSmsInfo($ary_sms_where);
		if($sms_log['code'] != $m_mobile_code){
			$this->ajaxReturn('验证码不存在或已过期');exit;
		}else{
			$this->ajaxReturn(true);exit;
		}
		$this->ajaxReturn('验证码不存在或已过期');exit;
    }

	/**
     * 验证手机验证码是否存在
	 * @author wangguibin wangguibin@guanyisoft.com
     * @date 2013-08-05
     */
    public function checkMobilePwdCode() {
		//判读是不是手机格式
		$m_mobile_code = $this->_get('m_mobile_code');
		if(empty($m_mobile_code)){
			$this->ajaxReturn('手机验证码不正确');
		}
		//判断手机号是否在90秒内已发送短信验证码
		$ary_sms_where = array();
		$ary_sms_where['check_status'] = 0;
		$ary_sms_where['status'] = 1;
		$ary_sms_where['sms_type'] = 1;
		$ary_sms_where['code'] = $m_mobile_code;
		//$ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
		$sms_log = D('SmsLog')->getSmsInfo($ary_sms_where);
		if($sms_log['code'] != $m_mobile_code){
			$this->ajaxReturn('验证码不存在或已过期');exit;
		}else{
			$this->ajaxReturn(true);exit;
		}
		$this->ajaxReturn('验证码不存在或已过期');exit;
    }

    #### 忘记密码 ##############################################################
    /**
     * 忘记密码提交页面
     * @author wangguibin wangguibin@guanyisoft.com
     * @date 2013-04-11
     */

    public function pageFoget() {
        //$ary_data['page_title'] = ' - 找回密码';
		$this->setTitle('找回密码');
        //$this->assign($ary_data);
		$tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/pageFoget.html';
        $this->display($tpl);
    }

	/**
     * 向用户重置密码并发送密码到用户手机
     * @author wangguibin wangguibin@guanyisoft.com
     * @date 2013-08-06
     */
    public function synResetByMobile() {
		$ary_data = $this->_request();
		$m_mobile_code = trim($ary_data['m_mobile_code']);
		$m_mobile = trim($ary_data['m_mobile']);
		//判断手机号是否在90秒内已发送短信验证码
		$ary_sms_where = array();
		$ary_sms_where['check_status'] = 0;
		$ary_sms_where['status'] = 1;
		$ary_sms_where['sms_type'] = 1;
		$ary_sms_where['mobile'] = $m_mobile;
		$ary_sms_where['code'] = $m_mobile_code;
		//$ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
		$sms_log = D('SmsLog')->getSmsInfo($ary_sms_where);
		if($sms_log['code'] != $m_mobile_code){
			$this->error('验证码不存在或已过期');exit;
		}else{
			//判断手机号是否在90秒内已重置过
			$ary_sms_where = array();
			$ary_sms_where['check_status'] = 0;
			$ary_sms_where['status'] = 1;
			$ary_sms_where['sms_type'] = 3;
			$ary_sms_where['mobile'] = $m_mobile;
			$ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
			$sms_count = D('SmsLog')->getCount($ary_sms_where);
			if($sms_count>0){
				$this->error('您已经重置过密码了。');exit;
			}
			M('')->startTrans();
			//更新验证码使用状态
			$up_res = D('SmsLog')->updateSms(array('id'=>$sms_log['id']),array('check_status'=>1));
			if(!$up_res){
				M('')->rollback();
				$this->error('更新验证码状态失败');exit;
			}
			//发送重置密码到手机
			$SmsApi_obj=new SmsApi();
			//获取注册发送验证码模板
			$template_info = D('SmsTemplates')->sendSmsTemplates(array('code'=>'SEND_PASSWORD'));
			$send_content = '';
			if($template_info['status'] == true){
				$send_content = $template_info['content'];
			}
			if(empty($send_content)){
				M('')->rollback();
				$this->error('短信发送失败！');exit;
			}
			//设置其他已发送验证码无效
			D('SmsLog')->updateSms(array('sms_type'=>3,'check_status'=>0,'mobile'=>$m_mobile),array('check_status'=>2));
			$array_params=array('mobile'=>decrypt($m_mobile),'','content'=>$send_content);
			$res=$SmsApi_obj->smsSend($array_params);
			if($res['code'] == '200'){
				//日志记录下
				$ary_data = array();
				$ary_data['sms_type'] = 3;
				$ary_data['mobile'] = $m_mobile;
				$ary_data['content'] = $send_content;
				$ary_data['code'] = $template_info['code'];
				$sms_res = D('SmsLog')->addSms($ary_data);
				if(!$sms_res){
					M('')->rollback();
					$this->error('短信发送失败！');exit;
					//writeLog('短信发送失败', 'SMS/'.date('Y-m-d').txt);
				}
			}else{
				M('')->rollback();
				$this->error('短信发送失败！'.$res['msg']);exit;
			}
			//重置密码之后发送短信成功后更改会员表密码信息
			$m_res = D('Members')->where(array('m_mobile'=>$m_mobile))->data(array('m_password'=>md5($template_info['code']),'m_update_time'=>date('Y-m-d H:i:s')))->save();
			//dump($m_res);die;
			if($m_res === false) {
				M('')->rollback();
				$this->error('重置密码失败！');exit;
			}
			M('')->commit();
			$this->success('密码重置成功，您的新密码已经发送到您的手机，请尽快使用新密码登录或修改您的密码',"/Home/User/login",3);exit;
		}
    }

  	/**
     * 向用户重置密码并发送密码到用户邮箱
     * @author hcaijin
     * @date 2013-10-27
     */
    public function synResetByEmail() {
		$ary_data = $this->_request();
		$m_email = trim($ary_data['memail']);
        $result = D('Members')->where(array('m_email'=>$m_email))->find();
		$ary_option = D('EmailTemplates')->sendForgotPasswordEmail($result['m_password'],$result['m_name'],$result['m_email']);
		//发送邮件
        $email = new Mail();
        if ($email->sendMail($ary_option)) {
			//日志记录下
			$ary_data = array();
			$ary_data['email_type'] = 1;
			$ary_data['email'] = $result['m_email'];
			$ary_data['content'] = $ary_option['message'];
			$sms_res = D('EmailLog')->addEmail($ary_data);
			if(!$sms_res){
				writeLog(json_encode($ary_data),date('Y-m-d')."send_email.log");
			}
            $this->success('邮件已经发送到您的邮箱', U('Home/User/login'),3);
        } else {
            $this->error('重置密码邮件发送失败，请管理员检查邮件发送设置');
        }
    }

    /**
     * 向用户邮箱发送重置邮件
	 * 用户名或邮箱
     * @author wangguibin wangguibin@guanyisoft.com
     * @date 2013-04-11
     */
    public function synReset() {
		$this->setTitle('忘记密码重置');
		$is_mobile = 0;
        //接收页面数据
        //判断数据是否有效
        $forget = trim($this->_post('username'));
		$forget = RemoveXSS($forget);
		$result=D('Members')->where(array('m_email'=>$forget))->find();
		if(false == $result){
			$result=D('Members')->where(array('m_name'=>$forget))->find();
		}
		//判断是否是手机号
		if(false == $result || !$result['m_email']){
			$result=D('Members')->where(array('m_mobile'=>$forget))->find();
            if(!$result){
                $this->error('该用户没有绑定任何找回密码方式,请联系客服中心处理！');exit;
            }
		}
		$verify = RemoveXSS($this->_post('verify'));
        if (session('verify') != md5($verify)) {
            $this->error('验证码出错!');
        }
		if(false == $result){
			$this->error('用户名或邮箱或手机号不正确!');
		}
        $resMobile=D('Members')->where(array('m_mobile'=>$forget))->getField('m_mobile');
        $resName=D('Members')->where(array('m_name'=>$forget))->getField('m_name');
        if(!empty($resMobile) && !empty($result['m_mobile'])) {
            if (($result['m_name'] == $resMobile || ($result['m_mobile'] == $resName && !$resName)) && ($result['m_name'] != $result['m_mobile'])) {
                $this->error('尊敬的会员，您好，此手机号在两个会员中出现，请到客服中心处理!');
                exit;
            }
        }
        $name = $result['m_name'];
        if(isset($name)){
            $ary_cover['m_name'] = coverStr($name,strlen($name)-2);
        }
        $email = $result['m_email'];
        if(isset($email)){
            $head_email = substr($email,0,strpos($email,'@'));
            $head_email = coverStr($head_email,strlen($head_email)-2);
            $tail_email = substr($email,strpos($email,'@'));
            $ary_cover['m_email'] = $head_email.$tail_email;
        }
        $mobile = strpos($result['m_mobile'],'=') ? decrypt($result['m_mobile']) : $result['m_mobile'];
        if(isset($mobile)){
            $ary_cover['m_mobile'] = coverStr($mobile,strlen($mobile)-6);
        }
        $this->assign('ary_cover',$ary_cover);
        $this->assign('ary_member',$result);
        $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/findPwd.html';
        $this->display($tpl);
    }

    /**
     * 执行重置密码命令
     * @author wangguibin wangguibin@guanyisoft.com
     * @date 2013-04-11
     */
    public function doReset() {
        $member = D('Members');
        //解密连接代码
        $code = authcode(base64_decode($this->_get('code')), 'DECODE');
        //验证
        $result = $member->checkNamePassword($this->_get('name'), $code);
        if (FALSE == $code || FALSE == $result) {
            $this->error('非法链接或者链接已经失效',U('Home/Index'));
        }
        //生成新密码并重置
        $new_password = randStr();
        $save_result = $member->where(array('m_name' => $this->_get('name'), 'm_password' => $code))->data(array('m_update_time'=>date('Y-m-d H:i:s'),'m_password' => md5($new_password)))->save();
        if (false == $save_result) {
           $this->error('密码重置失败');
        }
		//D('MembersVerify')->where(array('m_name' => $this->_get('name')))->data(array('m_update_time'=>date('Y-m-d H:i:s'),'m_password' => md5($new_password)))->save();
        //生成邮件
        $ary_email_cfg = D('SysConfig')->getEmailCfg();

        $ary_option = array(
            'receiveMail' => $result['m_email'],
            'subject' => '您重置的新密码',
            'message' => "您的新密码是:$new_password",
            'from' => $ary_email_cfg['GY_SMTP_FROM'],
            'fromName' => $ary_email_cfg['GY_SMTP_FROM_NAME'],
            'host' => $ary_email_cfg['GY_SMTP_HOST'],
            'port' => $ary_email_cfg['GY_SMTP_PORT'],
            'smtpAuth' => $ary_email_cfg['GY_SMTP_AUTH'],
            'username' => $ary_email_cfg['GY_SMTP_NAME'],
            'password' => $ary_email_cfg['GY_SMTP_PASS'],
            'isHtml' => true
        );
        //发送邮件
        $email = new Mail();
        if ($email->sendMail($ary_option)) {
			//日志记录下
			$ary_data = array();
			$ary_data['email_type'] = 3;
			$ary_data['email'] = $result['m_email'];
			$ary_data['content'] = $ary_option['message'];
			$ary_data['code'] = $new_password;
			$ary_data['check_status'] = 1;
			$sms_res = D('EmailLog')->addEmail($ary_data);
			//更新验证码使用状态
			$up_res = D('EmailLog')->updateEmail(array('email'=>$result['m_email'],'email_type'=>1,'check_status'=>0),array('check_status'=>1));
            $this->success('密码重置成功，您的新密码已经发送到邮箱，请尽快使用新密码登录或修改您的密码', U('Home/User/login'),3);
        } else {
            $this->error('重置密码邮件发送失败，请管理员检查邮件发送设置');
        }
    }

    /**
     * 会员登录操作
     * @author Terry<wanghui@guanyisoft.com>
     * @date 2013-06-30
     */
    public function doUserLogin() {
        $member = D('Members');
        $ary_result = $member->doLoginApi($this->_post('m_name'), $this->_post('m_password'), $this->_post("verify"));
       // echo "<pre>";print_r($ary_result);exit;
        if ($ary_result['status']) {
            $ary_member = $member->getInfo($this->_post('m_name'));
            //同步erp会员查询接口
            //将会员信息存入session
            session('Members', $ary_member);
            /**
            把用户信息存在memcache里面去start
             **/
            $uniqid = md5(uniqid(microtime()));
            writeMemberCache($uniqid,$ary_member);
            cookie('session_mid',$uniqid,3600);
            /**
            把用户信息存在memcache里面去end
             **/
            $ary_cart = array();
            if (!empty($ary_member['m_id'])) {
                $session_carts = session("Cart");
                $ary_db_carts = D('Cart')->ReadMycart();
                foreach ($session_carts as $str_pdt => $int_num) {
                    if($int_num['type'] == '4'){
                		$ary_cart[$str_pdt] = $int_num;
                	}else{
                	    $tmp_int_num = (int) $int_num['num'];
	                    //大于0的新插入/更新. 小于等于0的不作处理
	                    if ($tmp_int_num > 0) {
	                        $ary_cart[$str_pdt] = $int_num;
	                    }
                	}
                }
                foreach ($ary_cart as $key => $int_num) {
                    $good_type = $int_num['type'];
                    if (!empty($ary_member['m_id'])) {//database
                    	if($good_type == '4'){
                    		$ary_db_carts[$key] = $int_num;
                    	}else{
                    	    if (array_key_exists($key, $ary_db_carts) && isset($ary_db_carts[$key]['type']) && ($good_type == $ary_db_carts[$key]['type'])) {
	                            $ary_db_carts[$key]['num']+=$int_num['num'];
	                        } else {
	                            $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num['num'], 'type' => $good_type);
	                        }
                    	}
                    }
                }
                $Cart = D('Cart')->WriteMycart($ary_db_carts);
                session('Cart', NULL);
                $redirect_uri = $_GET['redirect_uri'];
                if(empty($redirect_uri)){
                	$redirect_uri = '/Home/Index/index';
                }
                $this->success("登录成功", $redirect_uri);
            }
        } else {
            $this->error($ary_result['msg']);
        }

//        $this->success($ary_result['msg']);
//        $this->ajaxReturn(array('result' => $ary_result['status'], 'msg' => $ary_result['msg']));
    }

    /**
     * 接收第三方支付时的异步通知
     * 注：异步通知无需登录
     * @author zhangjiasuo <zhangjiasuo@guanyisoft.com>
     * @date 2013-07-23
     */

    public function synPayNotify() {
        $data = $_REQUEST;
        writeLog("REQUEST: ".json_encode($data),date('Ymd')."order_status.log");
        $code = $data['code'];
        //过滤掉thinkphp自带的参数，和非回调参数
        unset($data['_URL_']);
        unset($data[0]);
        unset($data[1]);
        unset($data[2]);
        unset($data[3]);
        unset($data[4]);        
        unset($data['code']);
        //获取支付类型信息
        $Payment = D('PaymentCfg');
        $ary_pay = $Payment->where(array('pc_abbreviation' => $code))->find();
        if (false === $ary_pay) {
            writeLog("not PaymentCfg: not PaymentCfg:".$code,date('Ymd')."order_status.log");
            $this->error('不存在的支付方式');
			die;
        }
        $Pay = $Payment::factory($ary_pay['pc_abbreviation'], json_decode($ary_pay['pc_config'], true));
        $result = $Pay->respond($data);
        writeLog("callback_successful: ".json_encode($result),date('Ymd')."order_status.log");
        M('','','DB_CUSTOM')->startTrans();
        $result['o_id'] = trim($result['o_id'],"订单编号:");
        $ary_member = D('Members')->where(array('m_id'=>$result['m_id']))->find();
        if ($result['result']) {
            //检查请求签名正确
            $Order = D('Orders');
            $ary_order = $Order->where(array('o_id' => $result['o_id']))->find();
            if(empty($result['m_id']) && $ary_order['o_pay_status'] == 1){
                    writeLog("The same water number already exists o_id: ".$result['o_id'],date('Ymd')."order_status.log");
                    //已经存在相同流水号的
                    M('','','DB_CUSTOM')->commit();
                    echo "success";
                    die();
            }
            if($ary_order['o_status'] != 1) {
                    writeLog("当前订单状态【o_status={$ary_order['o_status']}】不允许做此操作",date('Ymd')."order_status.log");	
                    die;				
            }elseif($ary_order['o_pay_status'] == 1) {
                    writeLog("订单为已支付，丢弃此次通知【{$ary_order['o_id']}】",date('Ymd')."order_status.log");	
                    die;				
            } 
            if ($result['int_status'] == 1) {
                //在线支付即时交易成功情况
                $ary_order['o_pay'] = $result['total_fee'];
                $ary_order['o_pay_status'] = 1;
                $result_order = $Order->orderPayment($result['o_id'], $ary_order, $int_type = 5);
                if (!$result_order['result']) {
                    writeLog("order_log create save fail o_id: ".$result['o_id'],date('Ymd')."order_status.log");
                    M('','','DB_CUSTOM')->rollback();
                    $this->error($result_order['message']);
                } else {
                    //订单日志记录
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '支付成功',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    //更新用户购买时间及数量
                    if($result['ps_buy_type'] == 1){
                         $result['ps_buy_nunmber'] = $result['ps_buy_nunmber'] + $ary_order['ps_buy_giving'];
                         $updata_data['number_buy']= $ary_member['number_buy'] + $result['ps_buy_nunmber'];
                         $updata_data['number_remaining']= $ary_member['number_remaining'] + $result['ps_buy_nunmber'];
                    }else if($result['ps_buy_type'] == 2){
                        $OrdersItems = D('OrdersItems')->where(array('o_id' => $result['o_id']))->find();
                        if($OrdersItems['pdt_id'] == 2){
                            $updata_data['number_buy']= $ary_member['number_buy'] + $ary_order['ps_buy_giving'];
                            $updata_data['number_remaining']= $ary_member['number_remaining'] + $ary_order['ps_buy_giving'];
                        } else {
                            $result['ps_buy_nunmber'] = $result['ps_buy_nunmber'] + $ary_order['ps_buy_giving'];
                        }
                        if(time() > strtotime($ary_member['end_time'])){
                              $updata_data['Buy_time']=  date('Y-m-d H:i:s');
                              $updata_data['end_time']=  date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' +'.$result['ps_buy_nunmber'].' month'));
                        } else {
                              $add_time=strtotime($ary_member['end_time']);
                              $data_time =  $add_time  - time() ;
                              $buy_time = strtotime(date('Y-m-d H:i:s').' +'.$result['ps_buy_nunmber'].' month') ;
                              $updata_data['end_time']=  date('Y-m-d H:i:s',$buy_time + $data_time);
                              $updata_data['Buy_time']=  date('Y-m-d H:i:s');
                        }
                    }
                    if($result['ps_buy_type'] == 1){
                         if(time() < strtotime($ary_member['end_time'])){
                             $updata_data['conversion_type']= 2;
                         } else {
                             $updata_data['conversion_type']= 1;
                         }
                    }  else {
                        $updata_data['conversion_type']= 2;
                    }
                    M('members',C('DB_PREFIX'),'DB_CUSTOM')->where(array('m_id'=>$ary_member['m_id']))->save($updata_data);
                    if($updata_data['conversion_type'] == 1){
                         D("PdfList")->where(array('m_id'=>$ary_member['m_id'],'fstate'=>6))->data(array('fstate'=>1))->save();
                    } else {
                         D("PdfList")->where(array('m_id'=>$ary_member['m_id'],'fstate'=>array('in',array(6,9))))->data(array('fstate'=>1))->save();
                    }
                    $updata_data['m_id'] =  $ary_member['m_id'];
                    $updata_data['o_id'] =  $result['o_id'];
                    writeLog("data: ".json_encode($updata_data),date('Ymd')."member_update_type.log");
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }
                }
            }else if($result['int_status'] == 2){
                //在线支付即时交易成功情况
                $ary_order['o_pay'] = $result['total_fee'];
                $ary_order['o_pay_status'] = 1;
                $result_order = $Order->orderPayment($result['o_id'], $ary_order, $int_type = 5);

                if (!$result_order['result']) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error($result_order['message']);
                } else {
                    //订单日志记录
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '支付成功',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }

                }
            }elseif($result['int_status'] == 3){
		//在线支付即时交易成功情况
                $ary_order['o_pay'] = $result['total_fee'];
                $ary_order['o_pay_status'] = 1;
                $result_order = $Order->orderPayment($result['o_id'], $ary_order, $int_type = 5);

                if (!$result_order['result']) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error($result_order['message']);
                } else {

                    //订单日志记录
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '支付成功',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }
                }
            }
            else if($result['int_status'] == 5){//创建交易

                //订单日志记录
                if(D('OrdersLog')->where(array('o_id'=>$result['o_id'],'ol_behavior'=>'创建'.$ary_pay['pc_custom_name'].'交易','ol_uname'=>$ary_member['m_name']))->count() == 0){
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '创建'.$ary_pay['pc_custom_name'].'交易',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }
                }   else{
                //echo D('OrdersLog')->getLastSql();exit;
                    M('','','DB_CUSTOM')->commit();
                    echo "success";
                    die();
                }


            }
//            elseif($result['int_status'] == 4){
//                //订单日志记录
//                $ary_orders_log = array(
//                    'o_id' => $result['o_id'],
//                    'ol_behavior' => '支付已在第三方创建--等待支付',
//                    'ol_uname' => $ary_member['m_name'],
//                    'ol_create' => date('Y-m-d H:i:s')
//                );
//                $res_orders_log = D('OrdersLog')->add($ary_orders_log);
//                writeLog(D('OrdersLog')->getLastSql(),"order_status.log");
//                if (!$res_orders_log) {
//                    M('','','DB_CUSTOM')->rollback();
//                    $this->error('订单日志记录失败');
//                    exit;
//                }else{
//                    M('','','DB_CUSTOM')->commit();
//                }
//            }
            else{
                /* $arr_result = D('Orders')->where(array('o_id'=>$result['o_id']))->data(array('o_status'=>'5'))->save();
                if (!$arr_result) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error("确认收货失败");
                } else {
                    M('','','DB_CUSTOM')->commit();
                    echo "success";
                    die();
                } */
            }
        }else{
            $this->error('支付失败');
        }
    }

	
    /**
     * 接收微信支付时的异步通知
     * 注：异步通知无需登录
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2015-04-01
     */
    public function synPayWeixinNotify() {
//            require_once FXINC . '/Lib/WxpayAPI_php_v3/' . 'notify.php';
//		Log::DEBUG("------------- begin notify -------------");
//		$notify = new PayNotifyCallBack();
//		$notify->Handle(false);
//		Log::DEBUG("------------- end notify -------------");
        
    
		$data = $_REQUEST;
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
		writeLog("REQUEST: ".$xml,"order_pay_weixin.log");
         $code = $data['code'];
        //过滤掉thinkphp自带的参数，和非回调参数
        unset($data['_URL_']);
        unset($data[0]);
        unset($data[1]);
        unset($data[2]);
        unset($data[3]);
        unset($data[4]);        
		unset($data['code']);
        //获取支付类型信息
        $Payment = D('PaymentCfg');
        $ary_pay = $Payment->where(array('pc_abbreviation' => $code))->find();
       
        if (false === $ary_pay) {
            writeLog("not PaymentCfg: not PaymentCfg:".$code,date('Ymd')."order_pay_weixin.log");
            $this->error('不存在的支付方式');
			die;
        }
        $Pay = $Payment::factory($ary_pay['pc_abbreviation'], json_decode($ary_pay['pc_config'], true));
        $result = $Pay->respond($xml);
        writeLog("callback_successful: ".json_encode($result),date('Ymd')."order_pay_weixin.log");
        M('','','DB_CUSTOM')->startTrans();
        $result['o_id'] = trim($result['o_id'],"订单编号:");
        $ary_member = D('Members')->where(array('m_id'=>$result['m_id']))->find();
        if ($result['result']) {
            //检查请求签名正确
            $Order = D('Orders');
            $ary_order = $Order->where(array('o_id' => $result['o_id']))->find();
            writeLog(json_encode($result),date('Ymd')."order_status.log");
            writeLog(json_encode($ary_order),date('Ymd')."order_status.log");	
			if(empty($result['m_id']) && $ary_order['o_pay_status'] == 1){
                            writeLog("The same water number already exists o_id: ".$result['o_id'],date('Ymd')."order_pay_weixin.log");
                //已经存在相同流水号的
				M('','','DB_CUSTOM')->commit();
				echo "success";
				die();
			}
			if($ary_order['o_status'] != 1) {
				writeLog("当前订单状态【o_status={$ary_order['o_status']}】不允许做此操作",date('Ymd')."order_pay_weixin.log");	
				die;				
			}elseif($ary_order['o_pay_status'] == 1) {
				writeLog("订单为已支付，丢弃此次通知【{$ary_order['o_id']}】",date('Ymd')."order_pay_weixin.log");	
				die;				
			}
            if ($result['int_status'] == 1) {
                //在线支付即时交易成功情况
                $ary_order['o_pay'] = $result['total_fee'];
                $ary_order['o_pay_status'] = 1;
                $result_order = $Order->orderPayment($result['o_id'], $ary_order, $int_type = 5);

                if (!$result_order['result']) {
                    writeLog("order save fail o_id: ".$result['o_id'],date('Ymd')."order_pay_weixin.log");
                    M('','','DB_CUSTOM')->rollback();
                    $this->error($result_order['message']);
                } else {
                    //订单日志记录
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '支付成功',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                                        //更新用户购买时间及数量
                    if($result['ps_buy_type'] == 1){
                         $result['ps_buy_nunmber'] = $result['ps_buy_nunmber'] + $ary_order['ps_buy_giving'];
                         $updata_data['number_buy']= $ary_member['number_buy'] + $result['ps_buy_nunmber'];
                         $updata_data['number_remaining']= $ary_member['number_remaining'] + $result['ps_buy_nunmber'];
                    }else if($result['ps_buy_type'] == 2){
                        $OrdersItems = D('OrdersItems')->where(array('o_id' => $result['o_id']))->find();
                        if($OrdersItems['pdt_id'] == 2){
                            $updata_data['number_buy']= $ary_member['number_buy'] + $ary_order['ps_buy_giving'];
                            $updata_data['number_remaining']= $ary_member['number_remaining'] + $ary_order['ps_buy_giving'];
                        } else {
                            $result['ps_buy_nunmber'] = $result['ps_buy_nunmber'] + $ary_order['ps_buy_giving'];
                        }
                        if(time() > strtotime($ary_member['end_time'])){
                              $updata_data['Buy_time']=  date('Y-m-d H:i:s');
                              $updata_data['end_time']=  date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' +'.$result['ps_buy_nunmber'].' month'));
                        } else {
                              $add_time=strtotime($ary_member['end_time']);
                              $data_time =  $add_time  - time() ;
                              $buy_time = strtotime(date('Y-m-d H:i:s').' +'.$result['ps_buy_nunmber'].' month') ;
                              $updata_data['end_time']=  date('Y-m-d H:i:s',$buy_time + $data_time);
                              $updata_data['Buy_time']=  date('Y-m-d H:i:s');
                        }
                    }
                    if($result['ps_buy_type'] == 1){
                         if(time() < strtotime($ary_member['end_time'])){
                             $updata_data['conversion_type']= 2;
                         } else {
                             $updata_data['conversion_type']= 1;
                         }
                    }  else {
                        $updata_data['conversion_type']= 2;
                    }
                    M('members',C('DB_PREFIX'),'DB_CUSTOM')->where(array('m_id'=>$ary_member['m_id']))->save($updata_data);
                    if($updata_data['conversion_type'] == 1){
                         D("PdfList")->where(array('m_id'=>$ary_member['m_id'],'fstate'=>6))->data(array('fstate'=>1))->save();
                    } else {
                         D("PdfList")->where(array('m_id'=>$ary_member['m_id'],'fstate'=>array('in',array(6,9))))->data(array('fstate'=>1))->save();
                    }
                    $updata_data['m_id'] =  $ary_member['m_id'];
                    $updata_data['o_id'] =  $result['o_id'];
                    writeLog("data: ".json_encode($updata_data),date('Ymd')."member_update_type.log");
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        writeLog("order_log create save fail o_id: ".$result['o_id'],date('Ymd')."order_pay_weixin.log");
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }
                }
            }else if($result['int_status'] == 2){
                //在线支付即时交易成功情况
                $ary_order['o_pay'] = $result['total_fee'];
                $ary_order['o_pay_status'] = 1;
                $result_order = $Order->orderPayment($result['o_id'], $ary_order, $int_type = 5);

                if (!$result_order['result']) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error($result_order['message']);
                } else {
                    //订单日志记录
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '支付成功',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }

                }
            }elseif($result['int_status'] == 3){
		//在线支付即时交易成功情况
                $ary_order['o_pay'] = $result['total_fee'];
                $ary_order['o_pay_status'] = 1;
                $result_order = $Order->orderPayment($result['o_id'], $ary_order, $int_type = 5);

                if (!$result_order['result']) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error($result_order['message']);
                } else {

                    //订单日志记录
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '支付成功',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }
                }
            }
            else if($result['int_status'] == 5){//创建交易

                //订单日志记录
                if(D('OrdersLog')->where(array('o_id'=>$result['o_id'],'ol_behavior'=>'创建'.$ary_pay['pc_custom_name'].'交易','ol_uname'=>$ary_member['m_name']))->count() == 0){
                    $ary_orders_log = array(
                        'o_id' => $result['o_id'],
                        'ol_behavior' => '创建'.$ary_pay['pc_custom_name'].'交易',
                        'ol_uname' => $ary_member['m_name'],
                        'ol_create' => date('Y-m-d H:i:s')
                    );
                    $res_orders_log = D('OrdersLog')->add($ary_orders_log);
                    writeLog(D('OrdersLog')->getLastSql(),date('Ymd')."order_status.log");
                    if(!$res_orders_log){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error("创建订单日志失败");
                    }else{
                        M('','','DB_CUSTOM')->commit();
                        echo "success";
                        die();
                    }
                }   else{
                //echo D('OrdersLog')->getLastSql();exit;
                    M('','','DB_CUSTOM')->commit();
                    echo "success";
                    die();
                }


            }
//            elseif($result['int_status'] == 4){
//                //订单日志记录
//                $ary_orders_log = array(
//                    'o_id' => $result['o_id'],
//                    'ol_behavior' => '支付已在第三方创建--等待支付',
//                    'ol_uname' => $ary_member['m_name'],
//                    'ol_create' => date('Y-m-d H:i:s')
//                );
//                $res_orders_log = D('OrdersLog')->add($ary_orders_log);
//                writeLog(D('OrdersLog')->getLastSql(),"order_status.log");
//                if (!$res_orders_log) {
//                    M('','','DB_CUSTOM')->rollback();
//                    $this->error('订单日志记录失败');
//                    exit;
//                }else{
//                    M('','','DB_CUSTOM')->commit();
//                }
//            }
            else{
                /* $arr_result = D('Orders')->where(array('o_id'=>$result['o_id']))->data(array('o_status'=>'5'))->save();
                if (!$arr_result) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error("确认收货失败");
                } else {
                    M('','','DB_CUSTOM')->commit();
                    echo "success";
                    die();
                } */
            }
        }else{
            $this->error('支付失败');
        }
    }
	
    /**
     * 线上充值接收第三方支付时的异步通知
     * 注：异步通知无需登录
     * @author zhangjiasuo <zhangjiasuo@guanyisoft.com>
     * @date 2013-07-24
     */

    public function synChargeNotify() {
        $data = $_REQUEST;
        $code = $data['code'];
        //过滤掉thinkphp自带的参数，和非回调参数
        unset($data['_URL_']);
        unset($data[0]);
        unset($data[1]);
        unset($data[2]);
        unset($data[3]);
        unset($data[4]);
        unset($data['code']);
        //获取支付类型信息
        $Payment = D('PaymentCfg');
        $ary_pay = $Payment->where(array('pc_abbreviation' => $code))->find();

        if (false == $ary_pay) {
            $this->error('不存在的支付方式');
        }
        $Pay = $Payment::factory($ary_pay['pc_abbreviation'], json_decode($ary_pay['pc_config'], true));
        $result = $Pay->respond($data);

        M('','','DB_CUSTOM')->startTrans();
        if ($result['result']) {
			if(empty($result['m_id'])){
                //已经存在相同流水号的
                M('','','DB_CUSTOM')->commit();
                $this->success('支付成功', U('Ucenter/Financial/pageDepositList'));exit;
			}
            //检查请求签名正确
            //获取会员信息
            $ary_member = D('Members')->where(array('m_id' => $result['m_id']))->find();

            //已经充值过的不能重复充值
            $where = array('ra_payment_sn'=>$result['gw_code'],'ra_payment_method'=>$ary_pay['pc_custom_name']);
            $int_running_find = D('RunningAccount')->where($where)->find();
            if(false != $int_running_find){
                //已经存在相同流水号的
                M('','','DB_CUSTOM')->commit();
                $this->error('已经入账',U('Ucenter/Financial/pageDepositList'));exit;
            }
			//已充值完成不允许再次充值
			/**
			if(!empty($result['int_ps_id'])){
				$ary_paymentSerial = D('PaymentSerial')->where(array('ps_id'=>$result['int_ps_id'],'ps_status'=>1))->getField('ps_id');
				if(!empty($ary_paymentSerial)){
					//已经存在相同流水号的
					M('','','DB_CUSTOM')->rollback();
					$this->success('支付成功', U('Ucenter/Financial/pageDepositList'));exit;
				}
			}**/
            if($result['int_status'] == 1 || $result['int_status'] == 3){
                //直接付款成功，交易成功
                $ary_where_account = array(
                    'm_id' => $result['m_id'],
                    'ra_money' => $result['total_fee'],
                    'ra_type' => 0, //充值
                    'ra_payment_method' => $ary_pay['pc_custom_name'],
                    'ra_before_money' => (float) $ary_member['m_balance'],
                    'ra_after_money' => (float) $ary_member['m_balance'] + (float) $result['total_fee'],
                    'ra_payment_sn' => $result['gw_code']
                );
                $RunningAccount_info = D('RunningAccount')->where($ary_where_account)->find();
                if(!isset($RunningAccount_info) && empty($RunningAccount_info)){
                    $ary_where_account['ra_create_time'] = date('Y-m-d h:i:s');
                    $RunningAccount_info = D('RunningAccount')->add($ary_where_account);
                }


                if (false === $RunningAccount_info) {
                    M('','','DB_CUSTOM')->rollback();
                    $this->error('充值流水账添加错误');
                } else {
                    $ary_where_balance=array(
                        'm_id'=>$result['m_id'],
                        'bi_money'=>$result['total_fee'],
                        'bi_sn'=>$result['gw_code'],
                        'bt_id'=>3,
                        'bi_verify_status'=>1,
                        'bi_service_verify'=>1,
                        'bi_finance_verify'=>1,
                        'bi_desc'=>$ary_pay['pc_custom_name'].'线上充值'
                    );
                    $BalanceInfo_info = D('BalanceInfo')->where($ary_where_balance)->find();
                    if(!isset($BalanceInfo_info) && empty($BalanceInfo_info)){
                        $ary_where_balance['bi_create_time'] = date('Y-m-d H:i:s');
                        $ary_where_balance['bi_update_time'] = date('Y-m-d H:i:s');
                        $BalanceInfo_info = D('BalanceInfo')->add($ary_where_balance);
                    }
                    if(false === $BalanceInfo_info){
                        M('','','DB_CUSTOM')->rollback();
                        $this->error('结余款调整单添加失败！');exit;
                    }
                    //更新用户预存款
                    $updata_data['m_balance']= $ary_where_account['ra_after_money'];
                    M('members',C('DB_PREFIX'),'DB_CUSTOM')->where(array('m_id'=>$ary_where_account['m_id']))->save($updata_data);
                    M('','','DB_CUSTOM')->commit();
                    echo "success";die();
                   // $this->success('支付成功', U('Ucenter/Financial/pageDepositList'));exit;
                }
            }else if($result['int_status'] == 2){
				/**隐藏
                //担保交易，等待管理员付款（生成结余款调整单）
                $ary_where_balance=array(
                    'm_id'=>$result['m_id'],
                    'bi_money'=>$result['total_fee'],
                    'bi_sn'=>$result['gw_code'],
                    'bt_id'=>3,
                    'bi_verify_status'=>0,
                    'bi_service_verify'=>0,
                    'bi_finance_verify'=>0,
                    'bi_desc'=>$ary_pay['pc_custom_name'].'线上充值'
                );
                $BalanceInfo_info = D('BalanceInfo')->where($ary_where_balance)->find();
                if(!isset($BalanceInfo_info) && empty($BalanceInfo_info)){
                    $ary_where_balance['bi_create_time'] = date('Y-m-d H:i:s');
                    $ary_where_balance['bi_update_time'] = date('Y-m-d H:i:s');
                    $BalanceInfo_info = D('BalanceInfo')->add($ary_where_balance);
                }
                if(false === $BalanceInfo_info){
                    M('','','DB_CUSTOM')->rollback();
                    $this->error('结余款调整单添加失败！');
                }
				**/
                M('','','DB_CUSTOM')->commit();
                echo "success";die();
               // $this->success('付款成功，等待发货', U('Ucenter/Financial/pageDepositList'));
            }
        } else {
            M('','','DB_CUSTOM')->rollback();
            $this->error('错误访问');
        }
    }

    /**
     * 第三方登录请求地址
     * @date 2013-07-29
     */
    public function thdLoginUr(){
        $config = D('SysConfig');
        $common = new ThdrustLogin();
        $type = strtolower($_GET['type']);
        $logindata = $config->getConfigs("THDLOGIN",null,null,null,1);
        $ary_status = json_decode($logindata['THDSTATUS']['sc_value'],TRUE);
        $msg_data = array(
            'sina'  => '新浪',
            'qq'    =>'QQ',
            'tqq'   =>   '腾讯微博',
            'renren'  => '人人网',
            'wx'  => '微信'
        );
        if(!empty($ary_status[$type]) && $ary_status[$type] == '1'){
            echo $str_url = $common->getThdCodeUrl($this->_get('type'));
            header('location:'.$str_url);
        }else{
            $this->error($msg_data[$type]."授权登录已被停用,或已不存在,请联系管理员");
            // die($msg_data[$type]."授权登录已被停用,或已不存在,请联系管理员");
        }

    }
/**
    * $str  微信昵称
**/
public function filter($str) {   
    
        if($str){
            $name = $str;
            $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name);
            $name = preg_replace('/xE0[x80-x9F][x80-xBF]‘.‘|xED[xA0-xBF][x80-xBF]/S','?', $name);
            $return = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#ie","",json_encode($name)));
            if(!$return){
                return $this->jsonName($return);
            }
        }else{
            $return = '';
        }    
        if(empty(trim($return))){
             $return = '悦书用户_'.$this->getRandChar();
        }
        return $return;

}
public function jsonName($str) {
    if($str){
        $tmpStr = json_encode($str);
        $tmpStr2 = preg_replace("#(\\\ud[0-9a-f]{3})#ie","",$tmpStr);
        $return = json_decode($tmpStr2);
        if(!$return){
            return $this->jsonName($return);
        }
    }else{
        $return = '悦书用户_'.$this->getRandChar();
    }    
    return $return;
}
public function getRandChar($length=2)  
{  
    $str = "";  
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";  
    $max = strlen($strPol)-1;  
  
    for($i=0;$i<$length;$i++){  
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数  
    }  
    return $str;  
}  
    /**
     * 请求完成code回调入口，再次请求token
     * 当所有请求完成后返回数据进行解析判断当前请求的用户在网站内是否存在
     *
     * @since stage 1.0
     * @author Joe <qianyijun@guanyisoft.com>
     * @date 2013-1-16
     */
    public function getToken(){
        if(!isset($_GET['code']) && empty($_GET['code'])){
			if(check_wap()){
				header("location:" . U('Wap/Index/index'));exit;
			}else{
				header('location:'."/Home/Index/index/");
			}
        }
	    if($_GET['state'] == $_SESSION['wx_rand']){
                    if(!empty($_SESSION['str_type'])){
                        $source  = $_SESSION['str_type'];
                    }
                    $_SESSION['str_type'] = 'WX';
		}

        $common = new ThdrustLogin();
        $member = D('Members');
        $memberCookie = D('MemberCookie');
        //获取第三方接口信息
        $ary_result = $common->getThdRequestUrl($_GET['code']);
     //   print_r($ary_result);exit;
        //判断当前用户是否存在
        $ary_member = $member->where(array('open_id'=>$ary_result['open_id']))->find();
        M('',C('DB_PREFIX'),'DB_CUSTOM')->startTrans();
        if(!isset($ary_member['open_id'])){
            //默认等级
            $ml = D('MembersLevel')->getSelectedLevel();
            //新增用户
            $add_member = array();
            $add_member['m_name'] =  $this->filter($ary_result['user_info']['nickname']);
            $add_member['open_name'] = $this->filter($ary_result['user_info']['nickname']);
            $add_member['open_id'] = $ary_result['open_id'];
            $add_member['open_token'] = $ary_result['open_token'];
            if(empty($source)){
                  $add_member['open_source'] = $_SESSION['str_type'];
            } else {
                $add_member['open_source'] = $source;  
            }
            $add_member['ml_id'] = $ml;
            $add_member['login_type'] = 1;
            if(!empty($ary_result['user_info']['province'])){
				$city_address = D('CityRegion')->getRegionFieldPinyin(strtoupper($ary_result['user_info']['province']),'cr_id');
				if(!empty($city_address)){
					$add_member['cr_id'] =$city_address; 
				}
                $add_member['open_cr_name'] = $ary_result['user_info']['province'];
            }
            $add_member['m_create_time'] = date('Y-m-d H:i:s');
            $add_member['m_status'] = 1; //为启用
            $data = D('SysConfig')->getCfgByModule('MEMBER_SET');
            if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
                $add_member['m_verify'] = '2';
            }
            if($ary_result['user_info']['gender'] == '男' || $ary_result['user_info']['sex'] == '1'){
                $add_member['m_sex'] = 1;
            }else{
                $add_member['m_sex'] = 0;
            }
            if(isset($ary_result['user_info']['headimgurl'])){
                $add_member['m_head_img'] = $ary_result['user_info']['headimgurl'];
            }
            $result = $member->add($add_member);
            if($result === false){
                writeLog("add_member:". json_encode($add_member),"weixin_login.log");
                writeLog("ary_result:". json_encode($ary_result),"weixin_login.log");
                M('',C('DB_PREFIX'),'DB_CUSTOM')->rollback();
                $this->error("登录失败", '/Home/Index/index');
            }else{
                $ary_member = $member->where(array('open_id'=>$ary_result['open_id']))->find();
            }
        }else{
            $name = $this->filter($ary_result['user_info']['nickname']);
            $member->where(array('m_id'=>$ary_member['m_id'],'m_name'=>$name,'open_name'=>$name))->save(array('login_type'=>1));
            $ary_member['login_type'] = 1;
            $ary_member['open_name'] = $name;
            $ary_member['m_name'] = $name;
            wcache($ary_member['m_id'], $ary_member, 'member');
        }
//        $Select  = D("PdfList")->where(array('m_id'=>$ary_member['m_id'],'fstate'=>array('neq',99),'cstate'=>1))->select();
//        if(!empty($Select)){
//                foreach ( $Select  as $value ){
//                            if(time()  > strtotime(date('Y-m-d H:s:i',$value['ftime']).'+1 day')){
//                                 D("PdfList")->where(array('m_id'=>$ary_member['m_id'],'id'=>$value['id']))->data(array('fstate'=>99))->save();
//                            }
//
//                }
//        }
        $key = md5($ary_member['m_id'].time());
        $SelectTokenDataFind = $memberCookie->where(array('m_id'=>$ary_member['m_id']))->find();
        if(empty($SelectTokenDataFind)){
                $add_member_cookie = array();
                $add_member_cookie['m_id'] = $ary_member['m_id'];
                $add_member_cookie['key'] = $key;
                $add_member_cookie['create_time'] = time();
                $add_member_cookie['update_time'] = time();
                $add_member_cookie['login_click'] = 1;
                $memberCookie->add($add_member_cookie);
                cookie('userToken',$key,3600 * 86400);
        } else {
                $save_member_cookie = array();
                if($SelectTokenDataFind['key'] !=  cookie('userToken') ){
                     $save_member_cookie['key'] = $key;
                     cookie('userToken',$key,3600 * 86400);
                }
                $save_member_cookie['update_time'] = time();
                $save_member_cookie['login_click'] = $SelectTokenDataFind['login_click'] +1;
                $memberCookie->where(array('m_id'=>$ary_member['m_id']))->save($save_member_cookie);
        }
        
        $ary_member['m_name'] = $ary_member['open_name'];
        session('Members', $ary_member);
        cls_redis::set($ary_member['open_id'],json_encode($ary_member));
        cookie('openid',$ary_member['open_id'],3600 * 24);	
        /**
        把用户信息存在memcache里面去start
         **/
		 /**
        $uniqid = md5(uniqid(microtime()));
        writeMemberCache($uniqid,$ary_member);
        cookie('session_mid',$uniqid,3600);**/
        /**
        把用户信息存在memcache里面去end
         **/
        $ary_cart = array();
        $redirect_uri = $_GET['redirect_uri'];
        if(empty($redirect_uri)){
			if(check_wap()){
				$redirect_uri = '/Wap/Index/index';
			}else{
				$redirect_uri = '/Home/Index/index';
			} 
        }
        if(!empty(cookie('redirect'))){
            $redirect_uri = cookie('redirect');
        }
        if (!empty($ary_member['m_id'])) {
            //$session_carts = session("Cart");
            if(empty($source)){
                $str_type = $_SESSION['str_type'];
            } else {
                $_SESSION['str_type'] = $source;
                 $str_type = $source;
            }
            $source_id = M('source_platform',C('DB_PREFIX'),'DB_CUSTOM')->where(array('sp_code'=>$str_type,'sp_stauts'=>1))->getField('sp_id');
            if(!D('RelatedMembersSourcePlatform')->where(array('m_id'=>$ary_member['m_id']))->count()){  //'sp_id'=>$source_id,
                if(false == D('RelatedMembersSourcePlatform')->add(array('sp_id'=>$source_id,'m_id'=>$ary_member['m_id']))){
                    M('',C('DB_PREFIX'),'DB_CUSTOM')->rollback();
                    $this->error('平台不存在，请联系管理员');
                }
            }
            M('',C('DB_PREFIX'),'DB_CUSTOM')->commit();
            //$this->success("登录成功", $redirect_uri);
			$this->redirect($redirect_uri);
        }else{
            writeLog("ary_result_notoepn_id:". json_encode($ary_result),"weixin_login.log");
            $this->success("登录失败", $redirect_uri);
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
        $condition['m_id'] = $member_id;
        $condition['client_type'] = $client;
        $model_mb_user_token->delMbUserToken($condition);
  
        //生成新的token
        $mb_user_token_info = array();
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0,999999)));
        $mb_user_token_info['m_id'] = $member_id;
        $mb_user_token_info['m_name'] = $member_name;
        $mb_user_token_info['token'] = $token;
        $mb_user_token_info['login_time'] = time();
        $mb_user_token_info['client_type'] = $client;
        $mb_user_token_info['ip'] = getIp();
        $result = $model_mb_user_token->addMbUserToken($mb_user_token_info);

        if($result) {
            return $token;
        } 

    }
    public function ApigetToken(){
        if(!empty($_SESSION['str_type'])){
            $source = $_SESSION['str_type'];
        }
         $_SESSION['str_type'] = 'WX';
        $common = new ThdrustLogin();
        $member = D('Members');
        $memberCookie = D('MemberCookie');
        //获取第三方接口信息
        $ary_result = $common->getApiThdRequestUrl($_GET['code']);
        //判断当前用户是否存在
        $ary_member = $member->where(array('open_id'=>$ary_result['open_id']))->find();
        M('',C('DB_PREFIX'),'DB_CUSTOM')->startTrans();
        if(!isset($ary_member['open_id'])){
            //默认等级
            $ml = D('MembersLevel')->getSelectedLevel();
            //新增用户 
            $add_member = array();
            $add_member['m_name'] =  $this->filter($ary_result['user_info']['nickname']);
            $add_member['open_name'] = $this->filter($ary_result['user_info']['nickname']);
            $add_member['open_id'] = $ary_result['open_id'];
            $add_member['open_token'] = $ary_result['open_token'];
            if(empty($source)){
                $add_member['open_source'] = $_SESSION['str_type'];
            } else {
                $add_member['open_source'] = $source;
            }
            $add_member['ml_id'] = $ml;
            $add_member['login_type'] = 1;
            if(!empty($ary_result['user_info']['province'])){
				$city_address = D('CityRegion')->getRegionFieldPinyin(strtoupper($ary_result['user_info']['province']),'cr_id');
				if(!empty($city_address)){
					$add_member['cr_id'] =$city_address; 
				}
                $add_member['open_cr_name'] = $ary_result['user_info']['province'];
            }
            $add_member['m_create_time'] = date('Y-m-d H:i:s');
            $add_member['m_status'] = 1; //为启用
            $data = D('SysConfig')->getCfgByModule('MEMBER_SET');
            if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
                $add_member['m_verify'] = '2';
            }
            if($ary_result['user_info']['gender'] == '男' || $ary_result['user_info']['sex'] == '1'){
                $add_member['m_sex'] = 1;
            }else{
                $add_member['m_sex'] = 0;
            }
            if(isset($ary_result['user_info']['headimgurl'])){
                $add_member['m_head_img'] = $ary_result['user_info']['headimgurl'];
            }
            $result = $member->add($add_member);
            if($result === false){
                writeLog("add_member:". json_encode($add_member),"weixin_login.log");
                writeLog("ary_result:". json_encode($ary_result),"weixin_login.log");
                M('',C('DB_PREFIX'),'DB_CUSTOM')->rollback();
                $this->redirect('/Home/Index/ApiWeixinCallback');
                //$this->ajaxReturn(array('code'=>10001,'success'=>'failure','msg'=>'Login failed','result'=>FALSE));
                //$this->error("登录失败", '/Home/Index/index');
            }else{
                $ary_member = $member->getInfo('',$ary_result['open_id']);
            }
        }else{
            $name = $this->filter($ary_result['user_info']['nickname']);
            $member->where(array('m_id'=>$ary_member['m_id'],'m_name'=>$name,'open_name'=>$name))->save(array('login_type'=>1));
            $ary_member['login_type'] = 1;
            $ary_member['open_name'] = $name;
            $ary_member['m_name'] = $name;
            wcache($ary_member['m_id'], $ary_member, 'member');
        }
        $token = $this->_get_token($ary_member['m_id'], $ary_member['m_name'], 'Client');
        $key = md5($ary_member['m_id'].time());
        $SelectTokenDataFind = $memberCookie->where(array('m_id'=>$ary_member['m_id']))->find();
        if(empty($SelectTokenDataFind)){
                $add_member_cookie = array();
                $add_member_cookie['m_id'] = $ary_member['m_id'];
                $add_member_cookie['key'] = $key;
                $add_member_cookie['create_time'] = time();
                $add_member_cookie['update_time'] = time();
                $add_member_cookie['login_click'] = 1;
                $memberCookie->add($add_member_cookie);
                cookie('userToken',$key,3600 * 86400);
        } else {
                $save_member_cookie = array();
                if($SelectTokenDataFind['key'] !=  cookie('userToken') ){
                     $save_member_cookie['key'] = $key;
                     cookie('userToken',$key,3600 * 86400);
                }
                $save_member_cookie['update_time'] = time();
                $save_member_cookie['login_click'] = $SelectTokenDataFind['login_click'] +1;
                $memberCookie->where(array('m_id'=>$ary_member['m_id']))->save($save_member_cookie);
        }
        $ary_member['m_name'] = $ary_member['open_name'];
        session('Members', $ary_member);
        cls_redis::set($ary_member['open_id'],json_encode($ary_member));
        cookie('openid',$ary_member['open_id'],3600 * 24);	
        /**
        把用户信息存在memcache里面去start
         **/
		 /**
        $uniqid = md5(uniqid(microtime()));
        writeMemberCache($uniqid,$ary_member);
        cookie('session_mid',$uniqid,3600);**/
        /**
        把用户信息存在memcache里面去end
         **/
        //$ary_cart = array();
        $redirect_uri = '/Home/Index/ApiWeixinCallback';
//        if(!empty(cookie('redirect'))){
//            $redirect_uri = cookie('redirect');
//        }
        if (!empty($ary_member['m_id'])) {
            //$session_carts = session("Cart");
            if(empty($source)){
                $str_type = $_SESSION['str_type'];
            } else {
                $_SESSION['str_type'] = $source;
                $str_type = $source;
            }
            $source_id = M('source_platform',C('DB_PREFIX'),'DB_CUSTOM')->where(array('sp_code'=>$str_type,'sp_stauts'=>1))->getField('sp_id');
            if(!D('RelatedMembersSourcePlatform')->where(array('m_id'=>$ary_member['m_id']))->count()){//'sp_id'=>$source_id,
                if(false === D('RelatedMembersSourcePlatform')->add(array('sp_id'=>$source_id,'m_id'=>$ary_member['m_id']))){
                    M('',C('DB_PREFIX'),'DB_CUSTOM')->rollback();
                 //   $this->ajaxReturn(array('code'=>10001,'success'=>'failure','msg'=>'平台不存在，请联系管理员','result'=>FALSE));
                    //$this->error('平台不存在，请联系管理员');
                }
            }
           
            //$this->success("登录成功", $redirect_uri);
			
        }
        $ary_result['token'] = $token;
        writeLog("ary_result:". json_encode($ary_result),date('Y-m-d')."weixin_login_token.log");
         M('',C('DB_PREFIX'),'DB_CUSTOM')->commit();
        $this->redirect($redirect_uri,array('token'=>$token));
    }
    public function ApigetpaymentGoodsToken(){

        if(!empty($_SESSION['str_type'])){
            $source = $_SESSION['str_type'];
        }
        $_SESSION['str_type'] = 'WX';
        $common = new ThdrustLogin();
        $member = D('Members');
        $memberCookie = D('MemberCookie');
        //获取第三方接口信息
        $ary_result = $common->getApiThdRequestUrl($_GET['code']);
        //判断当前用户是否存在
        $ary_member = $member->where(array('open_id'=>$ary_result['open_id']))->find();
        M('',C('DB_PREFIX'),'DB_CUSTOM')->startTrans();
        if(!isset($ary_member['open_id'])){
            //默认等级
            $ml = D('MembersLevel')->getSelectedLevel();
            //新增用户 
            $add_member = array();
            $add_member['m_name'] =  $this->filter($ary_result['user_info']['nickname']);
            $add_member['open_name'] = $this->filter($ary_result['user_info']['nickname']);
            $add_member['open_id'] = $ary_result['open_id'];
            $add_member['open_token'] = $ary_result['open_token'];
            if(empty($source)){
                $add_member['open_source'] = $_SESSION['str_type'];
            } else {
                $add_member['open_source'] = $source;
            }
            $add_member['ml_id'] = $ml;
            $add_member['login_type'] = 1;
            if(!empty($ary_result['user_info']['province'])){
                $city_address = D('CityRegion')->getRegionFieldPinyin(strtoupper($ary_result['user_info']['province']),'cr_id');
                if(!empty($city_address)){
                        $add_member['cr_id'] =$city_address; 
                }
                $add_member['open_cr_name'] = $ary_result['user_info']['province'];
            }
            $add_member['m_create_time'] = date('Y-m-d H:i:s');
            $add_member['m_status'] = 1; //为启用
            $data = D('SysConfig')->getCfgByModule('MEMBER_SET');
            if (!empty($data['MEMBER_STATUS']) && $data['MEMBER_STATUS'] == '1') {
                $add_member['m_verify'] = '2';
            }
            if($ary_result['user_info']['gender'] == '男' || $ary_result['user_info']['sex'] == '1'){
                $add_member['m_sex'] = 1;
            }else{
                $add_member['m_sex'] = 0;
            }
            if(isset($ary_result['user_info']['headimgurl'])){
                $add_member['m_head_img'] = $ary_result['user_info']['headimgurl'];
            }
            $result = $member->add($add_member);
            if($result === false){
                writeLog("add_member:". json_encode($add_member),"weixin_login.log");
                writeLog("ary_result:". json_encode($ary_result),"weixin_login.log");
                M('',C('DB_PREFIX'),'DB_CUSTOM')->rollback();
                $this->redirect('/Home/Index/ApiWeixinPaymentGoodsCallback');
                //$this->ajaxReturn(array('code'=>10001,'success'=>'failure','msg'=>'Login failed','result'=>FALSE));
                //$this->error("登录失败", '/Home/Index/index');
            }else{
                $ary_member = $member->getInfo('',$ary_result['open_id']);
            }
        }else{
            $name = $this->filter($ary_result['user_info']['nickname']);
            $member->where(array('m_id'=>$ary_member['m_id'],'m_name'=>$name,'open_name'=>$name))->save(array('login_type'=>1));
            $ary_member['login_type'] = 1;
            $ary_member['open_name'] = $name;
            $ary_member['m_name'] = $name;
            wcache($ary_member['m_id'], $ary_member, 'member');
        }
        $token = $this->_get_token($ary_member['m_id'], $ary_member['m_name'], 'Client');
        $key = md5($ary_member['m_id'].time());
        $SelectTokenDataFind = $memberCookie->where(array('m_id'=>$ary_member['m_id']))->find();
        if(empty($SelectTokenDataFind)){
                $add_member_cookie = array();
                $add_member_cookie['m_id'] = $ary_member['m_id'];
                $add_member_cookie['key'] = $key;
                $add_member_cookie['create_time'] = time();
                $add_member_cookie['update_time'] = time();
                $add_member_cookie['login_click'] = 1;
                $memberCookie->add($add_member_cookie);
                cookie('userToken',$key,3600 * 86400);
        } else {
                $save_member_cookie = array();
                if($SelectTokenDataFind['key'] !=  cookie('userToken') ){
                     $save_member_cookie['key'] = $key;
                     cookie('userToken',$key,3600 * 86400);
                }
                $save_member_cookie['update_time'] = time();
                $save_member_cookie['login_click'] = $SelectTokenDataFind['login_click'] +1;
                $memberCookie->where(array('m_id'=>$ary_member['m_id']))->save($save_member_cookie);
        }
        $ary_member['m_name'] = $ary_member['open_name'];
        session('Members', $ary_member);
        cls_redis::set($ary_member['open_id'],json_encode($ary_member));
        cookie('openid',$ary_member['open_id'],3600 * 24);	
        /**
        把用户信息存在memcache里面去start
         **/
		 /**
        $uniqid = md5(uniqid(microtime()));
        writeMemberCache($uniqid,$ary_member);
        cookie('session_mid',$uniqid,3600);**/
        /**
        把用户信息存在memcache里面去end
         **/
        //$ary_cart = array();
        $redirect_uri = '/Home/Index/ApiWeixinPaymentGoodsCallback';
//        if(!empty(cookie('redirect'))){
//            $redirect_uri = cookie('redirect');
//        }
        if (!empty($ary_member['m_id'])) {
            if(empty($source)){
                $str_type = $_SESSION['str_type'];
            } else {
                $_SESSION['str_type'] = $source;
                $str_type = $source;
            }
            $source_id = M('source_platform',C('DB_PREFIX'),'DB_CUSTOM')->where(array('sp_code'=>$str_type,'sp_stauts'=>1))->getField('sp_id');
            if(!D('RelatedMembersSourcePlatform')->where(array('m_id'=>$ary_member['m_id']))->count()){//'sp_id'=>$source_id,
                if(false === D('RelatedMembersSourcePlatform')->add(array('sp_id'=>$source_id,'m_id'=>$ary_member['m_id']))){
                    M('',C('DB_PREFIX'),'DB_CUSTOM')->rollback();
                 //   $this->ajaxReturn(array('code'=>10001,'success'=>'failure','msg'=>'平台不存在，请联系管理员','result'=>FALSE));
                    //$this->error('平台不存在，请联系管理员');
                }
            }
           
            //$this->success("登录成功", $redirect_uri);
			
        }
        $ary_result['token'] = $token;
        writeLog("ary_result:". json_encode($ary_result),date('Y-m-d')."weixin_login_token.log");
         M('',C('DB_PREFIX'),'DB_CUSTOM')->commit();
        $this->redirect($redirect_uri,array('token'=>$token));
    }
    /**
     * 团购详情页，异步请求用户登录页面
     *
     */
    public function doBulkLogin(){
        $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/doBulkLogin.html';
        $this->display($tpl);
    }

    /**
     * 注册成功页面
     * @author WangHaoYu <why419163@163.com>
     * @version 7.4
     * @date
     *
     */
    public function registerSuccess() {
        $ary_member = M('members',C('DB_PREFIX'),'DB_CUSTOM')->where(array('m_id'=>$_SESSION['last_member_id']))->field('m_email,m_name')->find();
        unset($_SESSION['last_member_id']);
        $this->assign('member',$ary_member);
        $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/registerSuccess.html';
        $this->display($tpl);
    }

    /**
     * 注册协议页面
     *
     */
    public function agreement(){
        $html = D('SysConfig')->getCfgByModule('GY_REGISTER_CONFIG');
        $this->assign('html',$html['REGISTER']);
        $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/registeRagreement.html';
        $this->display($tpl);
    }

    /**
	 * 异步获取 区域数据
	 */
	public function cityRegionOptions() {
		if (!isset($_POST["parent_id"]) || !is_numeric($_POST["parent_id"]) || $_POST["parent_id"] <= 0) {
			echo json_encode(array("status" => false, "data" => array(), "message" => "父级区域ID不合法"));
			exit;
		}
		$int_parent_id = $_POST["parent_id"];
		//$array_result_info = D('Gyfx')->selectOneCache('city_region',$ary_field=null, array("cr_parent_id" => $int_parent_id,'cr_status'=>'1'), array("cr_order" => "asc"));
		$array_result = D("CityRegion")->where(array("cr_parent_id" => $int_parent_id,'cr_status'=>'1'))->order(array("cr_order" => "asc"))->getField("cr_id,cr_name");
		if (false === $array_result) {
			echo json_encode(array("status" => false, "data" => array(), "message" => "无法获取区域数据"));
			exit;
		}
		echo json_encode(array("status" => true, "data" => $array_result, "message" => "success"));
		exit;
	}

	/**
     * 获取会员信息
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @version 7.6
     * @date 2014-06-11
     *
     */
    public function getMemberInfo() {
		//session('Members',array ( 'm_id' => '1', 'm_name' => 'test123', 'm_real_name' => 'test123', 'm_sex' => '1', 'cr_id' => '310113', 'm_address_detail' => '泰和路2038号', 'm_birthday' => '0000-00-00', 'm_zipcode' => '201901', 'm_mobile' => '15901868641', 'm_telphone' => '', 'm_status' => '1', 'm_email' => 'test123@qq.com', 'ml_id' => '2', 'mo_id' => '0', 'm_wangwang' => '', 'm_qq' => '', 'm_website_url' => '', 'm_verify' => '2', 'm_balance' => '409.600', 'm_all_cost' => '15590.400', 'total_point' => '10000', 'freeze_point' => '3601', 'm_create_time' => '2013-11-25 03:05:28', 'm_last_login_time' => '2014-06-10 11:51:31', 'm_update_time' => '2014-06-10 11:51:31', 'thd_guid' => '', 'm_recommended' => 'test1234', 'm_security_deposit' => '0.000', 'm_alipay_name' => '', 'm_balance_name' => '', 'm_order_status' => '0', 'is_proxy' => '0', 'login_type' => '0', 'm_subcompany_id' => NULL, 'member_level' => array ( 'ml_id' => '2', 'ml_name' => '高级会员', 'ml_discount' => '80.000', ), ));
		$ary_member = session('Members');
		if(!empty($ary_member['m_id'])){
			/**
			//订单总数
			$ordercount = M('orders', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('m_id'=>$member['m_id']))->count();
			$ary_member['order_count'] = $ordercount;
			//收藏总数
			$collect_count=M('collect_goods',C('DB_PREFIX'),'DB_CUSTOM')->where(array('m_id'=>$member['m_id']))->count();
			$ary_member['collect_count'] = $collect_count;
			**/
			//判断是否已签到
			$ary_where = array();
			$ary_where['u_create'] = array(between,array(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')));
			$ary_where['type'] = 10;
			$ary_where['m_id'] = $ary_member['m_id'];
			$point_exsit = D('Gyfx')->selectOne('point_log','log_id', $ary_where);
			if(!empty($point_exsit)){
				$this->assign('v_type',1);
			}
			//余额积分重新获取一下
			$member_info = D('Gyfx')->selectOne('Members','m_balance,total_point,freeze_point', array('m_id'=>$ary_member['m_id']));
			$ary_member['m_balance'] = $member_info['m_balance'];
			$_SESSION['Members']['m_balance'] = $ary_member['m_balance'];
			$_SESSION['Members']['total_point'] = $ary_member['total_point'];
			$_SESSION['Members']['freeze_point'] = $ary_member['freeze_point'];
			$ary_member['total_point'] = $member_info['total_point']-$member_info['freeze_point'];
            if($ary_member['total_point']<0){
				$ary_member['total_point'] = 0;
			}
			/* 取出会员扩展属性项头像字段 start*/
            if($ary_member['m_id']){
                $sys_data=D('MembersVerify')->where(array('m_id'=>$ary_member['m_id']))->find();
            }else{
                $sys_data=D('Members')->where(array('m_id'=>$ary_member['m_id']))->find();
            }
            $ary_extend_info=D('MembersFieldsInfo')->getList(array('u_id'=>$ary_member['m_id'],'status'=>0),array('field_id,content'));
            if(empty($ary_extend_info)){
                $ary_extend_info=D('MembersFieldsInfo')->getList(array('u_id'=>$ary_member['m_id'],'status'=>1),array('field_id,content'));
            }
            foreach ($ary_extend_info as $val){
                if(!empty($val['content'])){
                    $val['content']=explode(",",$val['content']);
                    foreach ($val['content'] as $value){
                        $temp_ary[$val['field_id']][$value]=$value;
                    }
                }
            }
            $where=array('is_display'=>1,'is_status'=>1);
            $ary_extend_data = D('MembersFields')->getList($where);
            foreach ($ary_extend_data as $key => $value) {
                if ($value['fields_type'] == 'file') {
                    $ary_member['avater_url'] = $temp_ary[$value['id']] ? array_pop($temp_ary[$value['id']]) : $sys_data['m_head_img'];
                }
            }
            /*$ary_avater=M('MembersFieldsInfo',C('DB_PREFIX'),'DB_CUSTOM')
                ->join(C('DB_PREFIX')."members_fields as mf on(field_id=mf.id)")
                ->where(array('u_id'=>$ary_member['m_id'],'mf.is_status'=>1,'mf.is_display'=>1,'mf.field_name'=>'头像'))
                ->field("content")
                ->find();*/
//            $ary_member['avater_url'] = $ary_avater['content'];
            /* 取出会员扩展属性项头像字段 end*/
		}
        //dump($ary_member);exit();
        $this->assign('member',$ary_member);
        $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/memberInfo.html';
        $this->display($tpl);
    }

	/**
     * 签到获取积分
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @version 7.6
     * @date 2014-06-11
     */
    public function doSignOn(){
        $ary_post = $this->_post();
		$member = session("Members");
		if(!empty($member['m_id'])){
			//判断是否设置签到赠送积分
			$point_config = D('Gyfx')->selectOneCache('point_config');
			if(empty($point_config['sign_points'])){
				$this->ajaxReturn(array('status'=>'0','info'=>"未开启积分签到功能"));exit;
			}
			//判断是否已签到
			$ary_where = array();
			$ary_where['u_create'] = array(between,array(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')));
			$ary_where['type'] = 10;
			$ary_where['m_id'] = $member['m_id'];
			$point_exsit = D('Gyfx')->selectOne('point_log','log_id', $ary_where);
			if(!empty($point_exsit)){
				$this->ajaxReturn(array('status'=>'0','info'=>"已签到，欢迎明天再来!"));exit;
			}else{
				$ary_data = array();
				$ary_data['type'] = 10;
				$ary_data['reward_point'] = intval($point_config['sign_points']);
				$ary_data['memo'] = '会员签到';
				//事物开启
				M('')->startTrans();
				$point_res = D('PointLog')->addPointLog($ary_data, $member['m_id']);
				if($point_res['status'] != '1'){
					M('')->rollback();
					$this->ajaxReturn(array('status'=>'0','info'=>"添加积分日志表失败"));exit;
				}else{
					$mem_res = D('Members')->where(array('m_id'=>$member['m_id']))->data(array('total_point'=>$member['total_point']+$ary_data['reward_point'],'m_update_time'=>date('Y-m-d H:i:s')))->save();
					if(!$mem_res){
						M('')->rollback();
						$this->ajaxReturn(array('status'=>'0','info'=>"更新会员积分信息失败"));exit;
					}
				}
				//更新会员SESSION信息
				$_SESSION['Members']['total_point'] = $member['total_point']+$ary_data['reward_point'];
				M('')->commit();
				$this->ajaxReturn(array('status'=>'1','info'=>"已签到成功送".$ary_data['reward_point']."积分"));
			}
		}else{
			$this->ajaxReturn(array('status'=>'0','info'=>L('NO_LOGIN')));
		}
    }

    /**
     * 获取登陆注册页广告图设置
     * @author hcaijin <huangcaijin@guanyisoft.com>
     * @version 7.6
     * @date 2014-06-16
     */
    public function getTopAds($type=1) {
		$ary_ads = D('SysConfig')->getConfigs('GY_SHOP_TOP_AD');
		$ary_ads_data = array();
        if($type==2){
            $ary_ads_data['reg_pic'] = $ary_ads['REGISTER_PIC']['sc_value'];
			$ary_ads_data['reg_pic'] = D('QnPic')->picToQn($ary_ads_data['reg_pic']);
            $ary_ads_data['reg_url'] = $ary_ads['REGISTER_PIC_URL']['sc_value'];
        }else{
            $ary_ads_data['log_pic'] = $ary_ads['LOGIN_PIC']['sc_value'];
			$ary_ads_data['log_pic'] = D('QnPic')->picToQn($ary_ads_data['log_pic']);
            $ary_ads_data['log_url'] = $ary_ads['LOGIN_PIC_URL']['sc_value'];
        }
		return $ary_ads_data;
    }

    /**
     * 发送注册短信
     * @author Tom <helong@guanyisoft.com>
     * @date 2014-10-27
     */
    private function sendRegisterMobileCode($m_mobile){
        //判断手机号是否在90秒内已发送短信验证码
        $ary_sms_where = array();
        $ary_sms_where['check_status'] = array('neq',2);
        $ary_sms_where['status'] = 1;
        $ary_sms_where['sms_type'] = 2;
        $ary_sms_where['mobile'] = $m_mobile;
        $ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
        $sms_log_count = D('SmsLog')->getCount($ary_sms_where);
        if($sms_log_count>0){
            return false;
            // $this->ajaxReturn(array('status'=>0,'msg'=>'90秒后才允许重新获取验证码！'));
        }
        $SmsApi_obj=new SmsApi();
        //获取注册发送验证码模板
        $template_info = D('SmsTemplates')->sendSmsTemplates(array('code'=>'REGISTER_CODE'));
        $send_content = '';
        if($template_info['status'] == true){
            $send_content = $template_info['content'];
        }
        if(empty($send_content)){
            $this->ajaxReturn(array('status'=>0,'msg'=>'短信发送失败！'));
        }
        $array_params=array('mobile'=>$m_mobile,'','content'=>$send_content);
        $res=$SmsApi_obj->smsSend($array_params);
        if($res['code'] == '200'){
            //日志记录下
            $ary_data = array();
            $ary_data['sms_type'] = 1;
            $ary_data['mobile'] = $m_mobile;
            $ary_data['content'] = $send_content;
            $ary_data['code'] = $template_info['code'];
            $sms_res = D('SmsLog')->addSms($ary_data);
            if(!$sms_res){
                writeLog('短信发送失败', 'SMS/'.date('Y-m-d').txt);
                return false;
            }
            return true;
            // $this->ajaxReturn(array('status'=>1,'msg'=>'短信发送成功！'));
        }else{
            return false;
            // $this->ajaxReturn(array('status'=>0,'msg'=>'短信发送失败，'.$array_result['msg']));
        }
    }
    /**
     * 发送注册短信
     * @author Wangguibin <wangguibin@guanyisoft.com>
     * @version 7.6.1
     * @date 2014-06-16
     */
    public function sendMobileCode() {
		//开启手机验证
		$mobile_set = D('SysConfig')->getCfg('VERIFIPHONE_SET','VERIFIPHONE_STATUS','0','开启手机验证');
		if($mobile_set['VERIFIPHONE_STATUS']['sc_value'] != 1){
			$this->ajaxReturn(array('status'=>0,'msg'=>'未开启手机验证'));
		}
		$ary_post =  $this->_post();
		if(empty($ary_post['m_mobile'])){
			$this->ajaxReturn(array('status'=>0,'msg'=>'请先输入手机号'));
		}
		//判读是不是手机格式
		$m_mobile = $ary_post['m_mobile'];
		if(!preg_match("/^1[0-9]{1}[0-9]{1}[0-9]{8}$/",$m_mobile)){
			$this->ajaxReturn(array('status'=>0,'msg'=>'请输入正确的手机号格式！'));
		}
        if (D('Members')->checkMobile($m_mobile)) {
            $this->ajaxReturn(array('status'=>0,'msg'=>'该手机号已被注册，请重新输入！'));
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
		$SmsApi_obj=new SmsApi();
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
		$res=$SmsApi_obj->smsSend($array_params);
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
			$this->ajaxReturn(array('status'=>1,'msg'=>'短信发送成功！'));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'短信发送失败，'.$res['msg']));
        }
    }

	/**
     * 发送忘记密码短信
     * @author Wangguibin <wangguibin@guanyisoft.com>
     * @version 7.6.1
     * @date 2014-08-06
     */
    public function sendMobilePwdCode() {
		$ary_post =  $this->_post();
		if(empty($ary_post['m_mobile'])){
			$this->ajaxReturn(array('status'=>0,'msg'=>'请先输入手机号'));
		}
		//判读是不是手机格式
		$ary_post['m_mobile'] = trim($ary_post['m_mobile']);
		$m_mobile = strpos($ary_post['m_mobile'],':') ? decrypt($ary_post['m_mobile']) : $ary_post['m_mobile'];
		if(!preg_match("/^1[0-9]{1}[0-9]{1}[0-9]{8}$/",$m_mobile)){
			$this->ajaxReturn(array('status'=>0,'msg'=>'手机号格式不正确！'));
		}
        if (D('Members')->checkMobile($ary_post['m_mobile'])) {
        }else{
			$this->ajaxReturn(array('status'=>0,'msg'=>'手机号不存在！'));
		}
		//判断手机号是否在90秒内已发送短信验证码
		$ary_sms_where = array();
		$ary_sms_where['check_status'] = array('neq',2);
		$ary_sms_where['status'] = 1;
		$ary_sms_where['sms_type'] = 1;
		$ary_sms_where['mobile'] = $m_mobile;
		$ary_sms_where['create_time'] = array('egt',date("Y-m-d H:i:s", strtotime(" -90 second")));
		$sms_log_count = D('SmsLog')->getCount($ary_sms_where);
		if($sms_log_count>0){
			$this->ajaxReturn(array('status'=>0,'msg'=>'90秒后才允许重新获取验证码！'));
		}
		$SmsApi_obj=new SmsApi();
		//获取注册发送验证码模板
		$template_info = D('SmsTemplates')->sendSmsTemplates(array('code'=>'FORGET_PASSWORD'));
		$send_content = '';
		if($template_info['status'] == true){
			$send_content = $template_info['content'];
		}
		if(empty($send_content)){
			$this->ajaxReturn(array('status'=>0,'msg'=>'短信发送失败！'));
		}
		$array_params=array('mobile'=>$m_mobile,'','content'=>$send_content);
		$res=$SmsApi_obj->smsSend($array_params);
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
			$this->ajaxReturn(array('status'=>1,'msg'=>'短信发送成功！'));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'短信发送失败，'.$res['msg']));
        }
    }

	/**
     * 处理用户退出，退出后进入登录页(针对蓝源模板)
     * @author huhaiwei
     * @date 2013-09-28
     */
    public function doLoginout() {
        //D('Members')->where(array('m_id'=>$_SESSION['Members']['m_id']))->save(array('login_type'=>0));
        session('Members', null);

        $url = U('Home/Index/index');
        $this->success('用户退出成功', $url);
    }


    /**
     * Home处理用户登录(针对蓝源模板)
     * @author huhaiwei
     * @date 2014-09-29
     */
    public function doLoginin() {
        $member = D('Members');
		$password = $this->_post('m_password');
        $ary_result = $member->doLoginApi($this->_post('m_name'), $password);
        if ($ary_result['status']) {
            $home_access = D('SysConfig')->getCfgByModule('HOME_USER_ACCESS');
            $exitTime = intval($home_access['EXPIRED_TIME']);
            if($exitTime > 0){
                @import('ORG.Util.Session');
                Session::setExpire(time() + $exitTime * 60);
            }
            $ary_member = $member->getInfo($this->_post('m_name'));
            //同步erp会员查询接口
            //将会员信息存入session
            //$_SESSION['Members'] = $ary_member;
            session('Members', $ary_member);
			/**
			把用户信息存在memcache里面去start
			**/
			$SESSION_TYPE = (ini_get('session.save_handler') == 'redis')?1:0;
			if(empty($SESSION_TYPE)){
				$uniqid = md5(uniqid(microtime()));
				writeMemberCache($uniqid,$ary_member);
				cookie('session_mid',$uniqid,3600);			
			}			
            $ary_cart = array();
            if (!empty($ary_member['m_id'])) {
                $update_member['m_last_login_time']=date('Y-m-d H:i:s');
                D('Members')->where(array('m_id'=>$ary_member['m_id']))->save($update_member);
                //注册成功判断是否开启积分
                $pointCfg = D('PointConfig')->getConfigs();
                if($pointCfg['is_consumed'] == '1' && $pointCfg['login_points'] > 0){
                    //判断今天是否已登陆一次
                    $ary_where = array();
                    $ary_where['u_create'] = array(between,array(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')));
                    $ary_where['type'] = 13;
                    $ary_where['m_id'] = $ary_member['m_id'];
                    $point_exsit = D('Gyfx')->selectOne('point_log','log_id', $ary_where);
                    if(empty($point_exsit)){
                        $res_point = D('PointConfig')->setMemberRewardPoints($pointCfg['login_points'],$ary_result['m_id'],13);
                    }
                }
             	$session_carts = session("Cart");
               // echo "<pre>";print_r($session_carts);exit;
                $ary_db_carts = D('Cart')->ReadMycart();
                foreach ($session_carts as $str_pdt => $int_num) {
                	if($int_num['type'] == '4' || $int_num['type'] == '6'){
                		$ary_cart[$str_pdt] = $int_num;
                	}else{
                	    $tmp_int_num = (int) $int_num['num'];
	                    //大于0的新插入/更新. 小于等于0的不作处理
	                    if ($tmp_int_num > 0) {
	                        $ary_cart[$str_pdt] = $int_num;
	                    }
                	}
                }
                foreach ($ary_cart as $key => $int_num) {
                    $good_type = $int_num['type'];
                    if (!empty($ary_member['m_id'])) {//database
                    	if($good_type == '4' ||$good_type == '6'){
                    		$ary_db_carts[$key] = $int_num;
                    	}else{
                    	    if (array_key_exists($key, $ary_db_carts) && isset($ary_db_carts[$key]['type']) && ($good_type == $ary_db_carts[$key]['type'])) {
	                            $ary_db_carts[$key]['num']+=$int_num['num'];
	                        } else {
	                            $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num['num'], 'type' => $good_type);
	                        }
                    	}
                    }
                }
                $Cart = D('Cart')->WriteMycart($ary_db_carts);
                session('Cart', NULL);
				//更新会员等级
				D('MembersLevel')->autoUpgrade($ary_member['m_id']);
				$url = U('Home/Index/index');
		       	if (!empty($_REQUEST['requsetUrl'])) {
		            $url = $_REQUEST['requsetUrl'];
		        }
		       	if (!empty($_REQUEST['redirect_uri'])) {
		            $url = $_REQUEST['redirect_uri'];
		        }
                $is_on = D('SysConfig')->getConfigs('GY_SHOP', 'GY_SHOP_OPEN');
                if ($is_on['GY_SHOP_OPEN']['sc_value'] == '0'){
                    $url = U('Ucenter/Index/index');
                }
                $this->success("登录成功", $url);
                //$this->ajaxReturn(array('result' => $ary_result['status'], 'msg' => $ary_result['msg']));
            }
        } else {
            $this->error($ary_result['msg'],U('Home/Index/index'),2);
        }
        //$this->ajaxReturn(array('result' => $ary_result['status'], 'msg' => $ary_result['msg']));
    }
    /**
     * 加载登录(针对蓝源模板)
     * @author huhaiwei
     * @date 2014-10-10
     */
    public function ajaxLoginPage(){
		$config = D('SysConfig');
        $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/login.html';
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
        $_SESSION['rand'] = rand();
        $this->display($tpl);
    }
    /**
     * 加载注册(针对蓝源模板)
     * @author huhaiwei
     * @date 2014-10-11
     */
    public function ajaxRegPage(){
       $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/register.html';
      // echo $tpl;die;
       $this->display($tpl);
    }

    /**
     * 向用户邮箱发送重置邮件
	 * 用户名或邮箱
     * @author wangguibin wangguibin@guanyisoft.com
     * @date 2013-04-11
     */
    public function synResetEmail() {
        $member = D('Members');
		$is_mobile = 0;
        //接收页面数据
        //判断数据是否有效
		$result=D('Members')->where(array('m_email'=>$this->_post('memail')))->find();
		if(false == $result){
			$result=D('Members')->where(array('m_name'=>$this->_post('memail')))->find();
		}
		//判断是否是手机号
		if(false == $result){
			$result=D('Members')->where(array('m_mobile'=>$this->_post('memail')))->find();
			if(!empty($result)){
				$is_mobile = 1;
			}
		}
		//如果是手机验证
		if($is_mobile == 1){
            //发送重置密码到手机
			$SmsApi_obj=new SmsApi();
            //获取注册发送验证码模板
			$template_info = D('SmsTemplates')->sendSmsTemplates(array('code'=>'FORGET_PASSWORD'));
			$send_content = '';
			if($template_info['status'] == true){
				$send_content = $template_info['content'];
			}
			if(empty($send_content)){
				M('')->rollback();
				$this->error('短信发送失败！');exit;
			}
			$array_params=array('mobile'=>$result['m_mobile'],'','content'=>$send_content);
			$res=$SmsApi_obj->smsSend($array_params);
			if($res['code'] == '200'){
				//日志记录下
				$ary_data = array();
				$ary_data['sms_type'] = 3;
				$ary_data['mobile'] = $this->_post('mobile');
				$ary_data['content'] = $send_content;
				$ary_data['code'] = $template_info['code'];
				$sms_res = D('SmsLog')->addSms($ary_data);
                $this->assign('ary_member',$result);
                $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/mobile_code.html';
                $this->display($tpl);exit;
				if(!$sms_res){
					M('')->rollback();
					$this->error('短信发送失败！');exit;
					//writeLog('短信发送失败', 'SMS/'.date('Y-m-d').txt);
				}
			}else{
				M('')->rollback();
				$this->error('短信发送失败！'.$res['msg']);exit;
			}

		}
		if(false == $result){
			$this->error('邮箱不正确!');
		}

        if (session('verify') != md5($this->_post('verify'))) {
            $this->error('验证码出错!');
        }
		$ary_option = D('EmailTemplates')->sendForgotPasswordEmail($result['m_password'],$result['m_name'],$result['m_email']);
		//发送邮件
        $email = new Mail();
        if ($email->sendMail($ary_option)) {
			//日志记录下
			$ary_data = array();
			$ary_data['email_type'] = 1;
			$ary_data['email'] = $result['m_email'];
			$ary_data['content'] = $ary_option['message'];
			$sms_res = D('EmailLog')->addEmail($ary_data);
			if(!$sms_res){
				writeLog(json_encode($ary_data),date('Y-m-d')."send_email.log");
			}
            $this->success('邮件已经发送到您的邮箱', U('Home/Index/index'));
        } else {
            $this->error('重置密码邮件发送失败，请管理员检查邮件发送设置');
        }
    }
	
    /**
     * 模板获取会员登录信息
     * @author wangguibin wangguibin@guanyisoft.com
     * @date 2015-05-19
     */
    public function showMemberInfo() {
		if (!empty($ary_request['view']) && $ary_request['view'] == 'preview') {
            $tpl = './Public/Tpl/' . CI_SN . '/preview_' . $ary_request['dir'] . '/showMemberInfo.html';
        } else {
            $tpl = './Public/Tpl/' . CI_SN . '/' . TPL . '/showMemberInfo.html';
        }
        $this->display($tpl);
	}
    public function doALIPAY(){
      $ary_datas = $this->_get();
             // $member = session('Members');
//              if(empty($member['m_id'])){
//            $this->error('请登录！');
//        }
        if(empty($ary_datas)){
            $this->error('未知的访问请求！');
        }
        if (empty($ary_datas ['o_id'])) {
            $this->error('未知的订单号！');
        }
        if (empty($ary_datas ['code'])) {
            $this->error('暂无支付方式！');
        }
        $orderItems = M('orders_items')->field('oi_id,o_id,g_id,pdt_id,oi_nums,fc_id,oi_type')->where(array('o_id'=>$ary_datas ['o_id']))->find();
        $Payment = D('PaymentCfg');
        $ary_payment = $Payment->where(array('pc_abbreviation'=>$ary_datas ['code']))->find();
        $Pay = $Payment::factory($ary_datas ['code'],  json_decode($ary_payment['pc_config'], true));
        $restult = $Pay->pay($ary_datas ['o_id'],$ary_datas ['details'],$orderItems['oi_nums'],$ary_datas['m_id']);
        
    }
}
