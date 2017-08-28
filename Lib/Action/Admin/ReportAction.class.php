<?php
/**
 * 后台管理员控制器
 *
 * @subpackage System
 * @package Action
 * @stage 7.0
 * @author Terry <wanghui@guanyisoft.com>
 * @date 2013-1-22
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class ReportAction extends AdminAction{
    protected $log = null;
    /**
     * 控制器初始化
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function _initialize() {
        parent::_initialize();
        $this->setTitle(' - '.L('MENU7_0'));
        $this->log = new ILog('db');       //提供了两个类型：file,db file为文件存储日志 db数据库存储 默认为文件
    }

    /**
     * 默认控制器
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function index() {
        $this->redirect(U('Admin/Report/pageList'));
    }

    /**
     * 管理员列表
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function pageList(){
        $this->getSubNav(9, 0, 10);
        //        $weekday = date('w');
        //        $weekday = ($weekday + 6) % 7;
        //        $date = date('Y-m-d', strtotime("-{$weekday} day"));
        $date = date("Y-m-d",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")));
        $week_time = array(
            'Monday'=> strtotime($date),
            'Tuesday'=> strtotime($date." +1 day" ),
            'Wednesday'=> strtotime($date." +2 day"),
            'Thursday'=> strtotime($date." +3 day"),
            'Friday'=> strtotime($date ." +4 day"),
            'Saturday'=> strtotime($date ." +5 day"),
            'Sunday'=> strtotime($date." +6 day"),
        );
        $CountPdf = $CountOffice = array(
            'Monday'=> 0,
            'Tuesday'=> 0,
            'Wednesday'=> 0,
            'Thursday'=> 0,
            'Friday'=> 0,
            'Saturday'=> 0,
            'Sunday'=> 0,
        );
        $ary_members_office  =D('PdfList')->where(array('ftime'=>array("BETWEEN", array(strtotime($date), strtotime($date." +6 day")))))->select();
         if(!empty($ary_members_office)){
             foreach($ary_members_office as $v){
                    foreach ($week_time as $key=>$time){
                             if($v['ftime'] == $time){  
                                    if($v['ctype'] == 'pdf')
                                    {
                                        $CountPdf[$key] = $CountPdf[$key] +1;
                                    } else {
                                        $CountOffice[$key] = $CountOffice[$key] +1;
                                    }
                             }
                    }
             }
            $json_pdf = json_encode(array($CountOffice['Monday'],$CountOffice['Tuesday'],$CountOffice['Wednesday'],$CountOffice['Thursday'],$CountOffice['Friday'],$CountOffice['Saturday'],$CountOffice['Sunday']));
            $json_Office = json_encode(array($CountPdf['Monday'],$CountPdf['Tuesday'],$CountPdf['Wednesday'],$CountPdf['Thursday'],$CountPdf['Friday'],$CountPdf['Saturday'],$CountPdf['Sunday']));
        }
        $this->assign('json_pdf',$json_pdf);
        $this->assign('json_Office',$json_Office);
        $this->display();
    }
    
    public function theme(){
        $jquery  = file_get_contents(FXINC.'/Public/Admin/theme/'.$_REQUEST['_URL_'][3].'.js');
        $this->assign("jquery",$jquery);
        $this->display();
    }
    
    public function pageDetails(){
        $this->getSubNav(9, 0, 20, '订单详细页');
        $ary_get = $this->_get();
        if (!empty($ary_get['o_create_time_1']) && !empty($ary_get['o_create_time_2'])) {
            if ($ary_get['o_create_time_1'] > $ary_get['o_create_time_2']) {
                $ary_where['m_create_time'] = array("BETWEEN", array($ary_get['o_create_time_2'], $ary_get['o_create_time_1']));
                $pdfList['crate_time'] = array("BETWEEN", array(strtotime($ary_get['o_create_time_2']), strtotime($ary_get['o_create_time_1'])));
            } else if ($ary_get['o_create_time_1'] < $ary_get['o_create_time_2']) {
                $ary_where['m_create_time']= array("BETWEEN", array($ary_get['o_create_time_1'], $ary_get['o_create_time_2']));
                $pdfList['crate_time'] = array("BETWEEN", array(strtotime($ary_get['o_create_time_1']), strtotime($ary_get['o_create_time_2'])));
            } else {
                $ary_where['m_create_time'] = $ary_get['o_create_time_1'];
                $pdfList['crate_time'] = strtotime($ary_get['o_create_time_1']);
            }
        
            $ary_members_type_where['m_create_time']  = $ary_where['m_create_time'];
            $AuthorizationCount_where['creation_time'] = $ary_where['m_create_time'];
            $AuthorizationCount_pay_where['creation_time'] = $ary_where['m_create_time'];
            $AuthorizationCount_number_where['creation_time'] = $ary_where['m_create_time'];
            $AuthorizationCount_combo_where['creation_time'] = $ary_where['m_create_time'];
            $ary_orders_where['o_create_time'] = $ary_where['m_create_time'];
            $Ordero_pay_statuswhere['o_create_time'] = $ary_where['m_create_time'];
            $o_status_where['o_create_time'] =  $ary_where['m_create_time'];
            $o_all_price_status_where['o_create_time'] = $ary_where['m_create_time'];
            $o_all_price_status['o_create_time'] = $ary_where['m_create_time'];
        }
        if(!empty($ary_get['sp_id'])){
            $join_where = " " . C("DB_PREFIX") . "related_members_source_platform ON " . C("DB_PREFIX") . "related_members_source_platform.m_id=" . C("DB_PREFIX") . "members.m_id";
            $join_order_where = " " . C("DB_PREFIX") . "related_members_source_platform ON " . C("DB_PREFIX") . "related_members_source_platform.m_id=" . C("DB_PREFIX") . "orders.m_id";
            $join_MemberAuthorization_where = " " . C("DB_PREFIX") . "related_members_source_platform ON " . C("DB_PREFIX") . "related_members_source_platform.m_id=" . C("DB_PREFIX") . "member_authorization.m_id";
            $ary_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id'] = $ary_get['sp_id'];
            $ary_members_type_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id']  = $ary_get['sp_id'];
            $AuthorizationCount_pay_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id']  =  $ary_get['sp_id'];
            $AuthorizationCount_number_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id']  =  $ary_get['sp_id'];
            $AuthorizationCount_combo_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id']  =  $ary_get['sp_id'];
            $Ordero_pay_statuswhere[C("DB_PREFIX") . 'related_members_source_platform.sp_id']  =  $ary_get['sp_id'];
            $o_status_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id'] =  $ary_get['sp_id'];
            $o_all_price_status_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id'] =  $ary_get['sp_id'];
            $ary_orders_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id'] = $ary_get['sp_id'];
            $o_all_price_status[C("DB_PREFIX") . 'related_members_source_platform.sp_id'] = $ary_get['sp_id'];
            $AuthorizationCount_where[C("DB_PREFIX") . 'related_members_source_platform.sp_id'] = $ary_get['sp_id'];
        }
        $ary_members_type_where['conversion_type']  = array('neq','0');
        $AuthorizationCount_pay_where['type']  = array('neq','0');
        $AuthorizationCount_number_where['type']  = array('neq','1');
        $AuthorizationCount_combo_where['type']  = array('neq','2');
	$Ordero_pay_statuswhere['o_status']  = array('neq','2');
        $Ordero_pay_statuswhere['o_pay_status']  = 1;
        $o_status_where['o_status'] = 2;
        $o_all_price_status_where['o_status'] = 2;
        $o_all_price_status['o_pay_status']  = 1;
        
        $ary_members = array();
        $ary_members['ary_members_count'] = D('Members')->join($join_where)->where($ary_where)->count();  //用户总数
        $ary_members['ary_members_type'] = D('Members')->join($join_where)->where($ary_members_type_where)->count(); //付费用户
        $ary_members['ary_members_gratis'] = $ary_members['ary_members_count'] - $ary_members['ary_members_type']; //免费用户
        
        $transition = array();
        $transition['AuthorizationCount'] = D('MemberAuthorization')->join($join_MemberAuthorization_where)->where($AuthorizationCount_where)->count('DISTINCT fx_member_authorization.m_id'); //转换的人数
        $transition['AuthorizationCount_pay'] = D('MemberAuthorization')->join($join_MemberAuthorization_where)->where($AuthorizationCount_pay_where)->count('DISTINCT fx_member_authorization.m_id'); //付费转换的人数
        $transition['AuthorizationCount_number'] = D('MemberAuthorization')->join($join_MemberAuthorization_where)->where($AuthorizationCount_number_where)->count('DISTINCT fx_member_authorization.m_id'); //使用次数消费
        $transition['AuthorizationCount_combo'] = D('MemberAuthorization')->join($join_MemberAuthorization_where)->where($AuthorizationCount_combo_where)->count('DISTINCT fx_member_authorization.m_id'); //使用套餐消费
        $transition['AuthorizationCount_document'] = D('PdfList')->join($join_MemberAuthorization_where)->where($pdfList)->count(); //转换文档总数
       //  echo D('PdfList')->getLastSql();exit;
        $ary_orders = array();
        $ary_orders['OrderCount'] = D('Orders')->join($join_order_where)->where($ary_orders_where)->count();  //订单总数
        $ary_orders['Ordero_pay_status'] = D('Orders')->join($join_order_where)->where($Ordero_pay_statuswhere)->count();  //已支付订单订单总数
        $ary_orders['Ordero_pay_status_notpay'] = $ary_orders['OrderCount'] - $ary_orders['Ordero_pay_status'];  //未支付订单
        $ary_orders['o_status'] = D('Orders')->join($join_order_where)->where($o_status_where)->count();  //退款订单总数
        $ary_orders['o_all_price'] = D('Orders')->join($join_order_where)->where($ary_orders_where)->sum('o_all_price');  //订单总额
        $ary_orders['o_all_price_pay'] = D('Orders')->join($join_order_where)->where($o_all_price_status)->sum('o_all_price');  //订单支付总额
        $ary_orders['o_all_price_status'] = D('Orders')->join($join_order_where)->where($o_all_price_status_where)->sum('o_all_price');  //退款订单总额

        $source_platform = M('source_platform',C('DB_PREFIX'),'DB_CUSTOM')->where(array('sp_default'=>0,'sp_stauts'=>1))->select();  //来源列表
        
        $this->assign('ary_get', $ary_get);
        $this->assign('source_platform', $source_platform);
        $this->assign('members', $ary_members);
        $this->assign('ary_members', $ary_members);
        $this->assign('transition', $transition);
        $this->assign('ary_orders', $ary_orders);
        $this->display();
        
    }

    /**
     * 添加管理员
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function pageAdd(){
        $this->getSubNav(8, 0, 20);
        $role = D("Role");
        $ary_data['role'] = $role->where()->select();
        $this->assign("data",$ary_data);
        $this->display();
    }

    /**
     * 编辑管理员
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function doAdd(){
        $this->getSubNav(8, 0, 20, '添加管理员');
        $system = D("System");
        $ary_post = $this->_post();
        if(!empty($ary_post) && is_array($ary_post)){
            $ip = get_client_ip();
            $ary_data = array(
                'u_name'    =>  trim($ary_post['u_name']),
                'role_id'    =>  $ary_post['role_id'],
                'u_real_name'    =>  trim($ary_post['u_real_name']),
                'u_no'    =>  $ary_post['u_no'],
                'u_mome'    =>  $ary_post['u_mome'],
                'u_department'    =>  $ary_post['u_department'],
                'u_status'  =>  $ary_post['u_status'],
                'u_passwd'  =>  md5(trim($ary_post['u_passwd'])),
                'u_create'  =>  date("Y-m-d H:i:s"),
                'u_lastlogin_ip'    =>  $ip
            );
            //echo "<pre>";print_r($ary_data);exit;
            $ary_res = $system->saveAddAdmin($ary_data);
            if($ary_res){
				$this->log->write('operation',array("管理员:".$_SESSION['admin_name'],"添加管理员",'添加管理员：'.trim($ary_post['u_name'])));				
                $this->success('管理员保存成功', U('Admin/System/pageList'));
            }else{
                $this->error("修改管理员失败");
            }
        }else{
            $this->error("提交数据有误，请重试！");
        }
    }
    /**
     * 验证管理员账号是否唯一
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function checkName(){
        $admin = D("Admin");
        $ary_get = $this->_get();
        $ary_data = $admin->where(array('u_name'=>$ary_get['u_name']))->find();
        if(!empty($ary_data) && is_array($ary_data)){
            $this->ajaxReturn('该管理员已存在！');
        }else{
            $this->ajaxReturn(true);
        }
    }

    /**
     * 验证管理员账号编辑是否唯一
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function checkEditName(){
        $admin = D("Admin");
        $ary_get = $this->_get();
        $where = array();
        $where['u_id'] = array("NEQ",intval($ary_get['u_id']));
        $where['u_name'] = $ary_get['u_name'];
        $ary_data = $admin->where($where)->find();
        if(!empty($ary_data) && is_array($ary_data)){
            $this->ajaxReturn('该管理员已存在！');
        }else{
            $this->ajaxReturn(true);
        }
    }

    /**
     * 编辑管理员
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function pageEdit(){
        $this->getSubNav(8, 0, 30, '编辑管理员');
        $ary_get = $this->_get();
        $ary_data = array();
        $admin = D("Admin");
        $ary_data['admin'] = $admin->where(array('u_id'=>$ary_get['uid']))->find();
        $role = D("Role");
        $ary_data['role'] = $role->where()->select();
        $this->assign("admin",$ary_data['admin']);
        $this->assign("data",$ary_data);
        $this->display();
    }

    /**
     * 编辑管理员
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function doEdit(){
        $system = D("System");
        $admin = D("Admin");
        $ary_post = $this->_post();
        if(!empty($ary_post) && is_array($ary_post)){
            $ip = get_client_ip();
            $ary_data = array(
                'u_name'    =>  $ary_post['u_name'],
                'role_id'    =>  $ary_post['role_id'],
                'u_real_name'    =>  $ary_post['u_real_name'],
                'u_no'    =>  $ary_post['u_no'],
                'u_mome'    =>  $ary_post['u_mome'],
                'u_department'    =>  $ary_post['u_department'],
                'u_update'  =>  date('Y-m-d H:i:s'),
                'u_lastlogin_ip'    =>  $ip
            );
            if(!empty($ary_post['u_id']) && isset($ary_post['u_id'])){
                if($ary_post['u_id'] != '1'){
                    $ary_data['u_status'] = $ary_post['u_status'];
                }
            }else{
                $this->error("提交数据有误，请重试！");
            }
            if(!empty($ary_post['u_passwd'])){
                $ary_data['u_passwd']   = md5($ary_post['u_passwd']);
            }
            $where = array(
                'u_id'  =>  $ary_post['u_id']
            );
            $ary_where = array();
            $ary_where['u_id'] = array("NEQ",$ary_post['u_id']);
            $ary_where['u_name'] = $ary_post['u_name'];
            $count = $admin->where($ary_where)->count();
            //echo "<pre>";print_r($ary_where);exit;
            if($count > 0){
                $this->error("编辑的管理员已经存在");
            }
            $ary_res = $system->saveUpdateAdmin($ary_data,$where);
            //echo "<pre>";print_r($ary_data);exit;
            if(FALSE !=$ary_res){
                
                $this->log->write('operation',array("管理员:".$_SESSION['admin_name'],"编辑管理员",'管理员：'.$ary_post['u_name']."资料被修改"));
                $this->success('管理员修改成功', U('Admin/System/pageList'));
            }else{
                $this->error("修改管理员失败");
            }
        }else{
            $this->error("提交数据有误，请重试！");
        }
    }

    /**
     * 启用/停用管理员账号
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-22
     */
    public function doEditStatus(){
        $system = D("System");
        $ary_request = $this->_request();
        if(!empty($ary_request) && is_array($ary_request)){
            $where= array();
            $where['u_id']  = $ary_request['id'];
            $ary_data = array();
            $ary_data[$ary_request['field']]    = $ary_request['val'];
            $ary_res = $system->saveUpdateAdmin($ary_data,$where);
            if(FALSE !== $ary_res){
                $this->success('修改成功');
            }else{
                $this->error("修改失败");
            }
        }else{
            $this->error("数据错误");
        }
    }

   /**
     * 删除操作
     * @author Terry<wanghui@guanyisoft.com>
     * @date 2013-1-25
     */
    public function doDelete(){
        $ary_get = $this->_request();
		unset($ary_get['_URL_']);
        $mod = D("Admin");
        if(!empty($ary_get) && is_array($ary_get)){
            $where= array();
            $where['u_id']  = is_array($ary_get['u_id'])? array("IN", $ary_get['u_id']) : intval($ary_get['u_id']);
			$ary_admins = $mod->where($where)->field('u_name')->select();
			$str_admin_name = '';
			foreach($ary_admins as $ary_admin){
				$str_admin_name .=$ary_admin['u_name'];
			}
			$str_admin_name = trim($str_admin_name,',');
            $ary_res = $mod->where($where)->delete();
            if($ary_res){
				$this->log->write('operation',array("管理员:".$_SESSION['admin_name'],"删除管理员",'删除管理员：'.$ary_get['u_id'].'-管理员名称:'.$str_admin_name));
                IS_AJAX && $this->ajaxReturn(1, "删除成功");
                $this->success('删除成功');
            }else{
                IS_AJAX && $this->ajaxReturn(0, "删除失败");
                $this->error("删除失败");
            }
        }else{
            IS_AJAX && $this->ajaxReturn(0, "数据错误");
            $this->error("数据错误");
        }
    }

    /**
     * 管理员登陆日志
     * @author  Terry<wanghui@guanyisoft.com>
     * @date 2013-1-28
     */
    public function pageAdminLog(){
        $this->getSubNav(8, 0, 50);
        $admin = D("AdminLog");
        $count = $admin->where()->count();
        $obj_page = new Page($count, 10);
        $page = $obj_page->show();
        $ary_data = $admin->where()->order(array('log_create'=>'desc'))->limit($obj_page->firstRow, $obj_page->listRows)->select();

        import('ORG.Net.IpLocation');// 导入IpLocation类
        $Ip = new IpLocation(); // 实例化类

        foreach ($ary_data as $k=>$v){
            $ary_data[$k]['ip_location'] = $Ip->getlocation($v['log_ip']);
            //dump($ary_data[$k]['ip_location']);exit;
        }

        $this->assign("data",$ary_data);
        $this->assign("page",$page);
        $this->display();

    }

    /**
     * 修改管理员登录密码
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-1-28
     */
    public function pageEditAdminPasswd(){
        $this->getSubNav(8, 0, 60,'修改管理员登录密码');
        $ary_data = M("Admin")->where(array('u_id'=>$_SESSION[C('USER_AUTH_KEY')]))->find();
        $data = array(
            'name'  => $ary_data['u_name'],
            'id'    => $ary_data['u_id']
        );
        $this->assign("data",$data);
        $this->display();
    }

    public function doEditPasswd(){
        $ary_post = $this->_post();
        //echo "<pre>";print_r($ary_post);exit;
        $admin = D("Admin");
        if(!empty($ary_post['u_id']) && intval($ary_post['u_id']) > 0){
            $data = $admin->where(array('u_id'=>$ary_post['u_id']))->find();
            if($data['u_passwd'] != md5($ary_post['old_passwd'])){
                $this->error("旧密码不正确");
            }else{
				if(md5($ary_post['u_passwd']) == md5($ary_post['old_passwd'])){
					$this->error("原密码与新密码不能相同");
				}
                $where= array();
                $system = D("System");
                $where['u_id']  = $ary_post['u_id'];
                $ary_data = array();
                $ary_data['u_passwd']    = md5($ary_post['u_passwd']);
                $ary_res = $system->saveUpdateAdmin($ary_data,$where);
                if($ary_res){
                    $this->success('修改成功');
                }else{
                    $this->error("修改失败");
                }
            }
        }else{
            $this->error("参数错误");
        }
    }
    
    /**
     * 管理员登陆提示控制页面
     *
     * @author Joe <qianyijun@guanyisoft.com>
     * @date 2013-10-17
     */
    public function pageAdminLoginSet(){
        $this->getSubNav(8, 0, 70);
        $data = D('SysConfig')->getCfgByModule('ADMIN_LOGIN_PROMPT');
        $this->assign($data);
        $this->display();
    }
    
    /**
     * 执行编辑管理员登陆提示
     *
     * @author Joe <qianyijun@guanyisoft.com>
     * @date 2013-10-17
     */
    public function doAdminLoginSet(){
        $post = $this->_post();
        if(false === D('SysConfig')->setConfig('ADMIN_LOGIN_PROMPT','ADMIN_LOGIN_PROMPT_SET',$post['ADMIN_LOGIN_PROMPT_SET'])){
            $this->error('保存失败！');
        }else{
            $this->success('保存成功！');
        }
    }
}
    