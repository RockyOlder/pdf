<?php

/**
 * @author Donkey 
 * @access 移动端基类
 * @生成令牌 token
 */

abstract class MobileAction extends GyfxAction{

  
    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios');
    //列表默认分页数
    protected $page = 10;
    
    protected $member_info = array();

    public function __construct() {
        
        parent::__construct();

        $model_mb_user_token = D('MbUserToken');
        $key = $_POST['token'];
        if(empty($key)) {
            $key = $_GET['token'];
            if(empty($key))
            {
                $arr_array = file_get_contents('php://input');
                $ary_post = json_decode($arr_array, true);
                $_POST = $ary_post;
                $key = $ary_post['token'];
            }
        }
     //  print_r($key);exit;
       
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
     
        if(empty($mb_user_token_info)) {
              output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
 
        }

        $model_member = D('Members');
        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
        
        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
        if(empty($this->member_info)) {
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'请登录'));
        }
                //导入分页类包
        import('ORG.Util.Page');
       // $this->getOnlineService();

        //分页数处理
        $page = intval($_GET['page']);
        if($page > 0) {
            $this->page = $page;
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
        $condition['member_id'] = $member_id;
        $condition['client_type'] = $client;
        $model_mb_user_token->delMbUserToken($condition);
  
        //生成新的token
        $mb_user_token_info = array();
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0,999999)));
        $mb_user_token_info['member_id'] = $member_id;
        $mb_user_token_info['member_name'] = $member_name;
        $mb_user_token_info['token'] = $token;
        $mb_user_token_info['login_time'] = time();
        $mb_user_token_info['client_type'] = $client;

        $result = $model_mb_user_token->addMbUserToken($mb_user_token_info);

        if($result) {
            return $token;
        } else {

            output_datas(null,array('result' =>"1",'error_code' =>10001,'desc'=>'错误的请求token'));  
        }

    }
}
