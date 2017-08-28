<?php

/**
 * @author Donkey 
 * @access 移动端基类
 * @生成令牌 token
 */

abstract class MobileAction extends ApiAction{

  
    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios','Client');
    //列表默认分页数
    protected $page = 10;
    
    protected $member_info = array();

    public function __construct() {
        
        parent::__construct();
        $model_mb_user_token = D('MbUserToken');
        $key = $this->array_params['token'];
//        if(empty($key)) {
//            $key = $_GET['token'];
//            if(empty($key))
//            {
//                $arr_array = file_get_contents('php://input');
//                $ary_post = json_decode($arr_array, true);
//                $_POST = $ary_post;
//                $key = $ary_post['token'];
//            }
//        }
     //  print_r($key);exit;
       
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) {
            $this->errorResult(false,10002,array('token'=>FALSE),'token Pairing failure','Remote service error',true);
        }
//        $model_member = D('Members');
//        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['m_id']);
//        
//        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
//        if(empty($this->member_info)) {
//            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'请登录'));
//        }
                //导入分页类包
        import('ORG.Util.Page');
       // $this->getOnlineService();

        //分页数处理
        $page = intval($_GET['page']);
        if($page > 0) {
            $this->page = $page;
        }
    }
}
