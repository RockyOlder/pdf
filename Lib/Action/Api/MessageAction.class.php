<?php

/* 
 * desc:消息相关接口
 * author：wangpan 
 * date：2016-07-12
 * 演示地址:www.xingyun.com:8080/Api/Message/test
 * request_type:POST或GET
 */
class MessageAction extends CommonAction {
    
    public function __construct(){
        parent::__construct();
    }


	// 请求方式： get
	// 请求url： www.xingyun.com:8080/Api/Message/get_signal_qty?token=dd11d73ecd604e79ca13a74b15cd9177
	// Action : get_signal_qty（固定）
	// Token:	凭证
	// msg_switch:  0,1   消息类型为0 和1的数据不加入统计（多个用逗号分隔）
	// 返回data 
    public function get_signal_qty(){


    }



	// 请求方式： get
	// 请求参数： 
	// Action : get_diffTypeTop1Msg（固定）
	// Token:	凭证
	// msg_switch:  0,1   不返回消息类型为0 和1的数据
	// 返回data 
	public function get_diffTypeTop1Msg(){//取消息中心各个类型信息最新的一条记录（消息中心页面）
		

	}


	//查看消息是否已读 mid
	public function isRead(){
		$ary_post = $this->_get();
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
		$slid = $ary_post['mid'];
		// $type = $this->_get('type');
		$ary_where=array('sl_id'=>$slid);
		// if($type=="to"){
			$ary_where['rsl_to_m_id']=$m_id;
		// }
		$count = M('related_station_letters',C('DB_PREFIX'),'DB_CUSTOM')->where($ary_where)->count();
		//dump($count);exit;
		if($count == '0'){
			output_datas(null,array('result' =>"1",'error_code' =>80001,'desc'=>'消息不存在!'));
		}else{
		    $messageObj = M('station_letters',C('DB_PREFIX'),'DB_CUSTOM');
			$messageInfo = $messageObj->field('letter.sl_id,sl_title,sl_content,ifnull(m1.m_name,\'管理员\') from_name,ifnull(m2.m_name,\'管理员\') to_name,sl_from_m_id,sl_create_time')
							->join('left join fx_related_station_letters as letter on(letter.sl_id=fx_station_letters.sl_id)')
							->join('left join fx_members as m1 on(fx_station_letters.sl_from_m_id=m1.m_id)')
							->join('left join fx_members as m2 on(letter.rsl_to_m_id=m2.m_id)')
							->where(array('fx_station_letters.sl_id'=>$slid))
							->find();
							//echo $messageObj->getlastsql();exit;
							//dump($messageInfo);exit;
			if($messageInfo){
				$lettersObj = M('related_station_letters',C('DB_PREFIX'),'DB_CUSTOM');
				$letter = $lettersObj->where(array('sl_id'=>$messageInfo['sl_id'],'rsl_to_m_id'=>$m_id))->find();
				//dump($letter);exit;
	    		if($letter['rsl_is_look']==0){
	    			$lettersObj->where(array('sl_id'=>$messageInfo['sl_id'],'rsl_to_m_id'=>$m_id))->setField('rsl_is_look', 1);
	    		}
	    		// $messageInfo['sl_content'] = nl2br($messageInfo['sl_content']);
		
			}else{
				output_datas(null,array('result' =>"1",'error_code' =>80001,'desc'=>'消息不存在!'));
			}			
		}

        //$noticeObj = D('StationLetters');
        // $messageList = $messageObj->field('fx_station_letters.sl_id,sl_title,sl_content,ifnull(m_name,\'管理员\') from_name,rsl_is_look,sl_create_time')
        //                                 ->join('inner join fx_related_station_letters on(fx_station_letters.sl_id=fx_related_station_letters.sl_id)')
        //                                 ->join('left join fx_members on(fx_station_letters.sl_from_m_id=fx_members.m_id)')
        //                                 ->where("rsl_to_del_status=1 and rsl_to_m_id={$m_id}")
        //                                 ->order('sl_create_time desc')
        //                                 //->page($page_no,$page_size)
        //                                 ->select();		
        output_datas(null,array('result' =>"0",'error_code' =>'0','desc'=>'查询成功!'));                           
	}	



	//取未读消息数目
	public function getNum(){

		$ary_post = $this->_get();
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
		//$slid = $ary_post['mid'];
		// $type = $this->_get('type');
		$ary_where=array('rsl_is_look'=>0);
		$ary_where['rsl_to_del_status']=1;//0删除 1正常
		$ary_where['rsl_to_m_id']=$m_id;

		$count = M('related_station_letters',C('DB_PREFIX'),'DB_CUSTOM')->where($ary_where)->count();
		//dump($count);exit;
		$count = (int)$count;
		output_datas($count,array('result' =>"0",'error_code' =>'0','desc'=>'查询成功!'));  

	}




	// url:www.xingyun.com:8080/Api/Message/getMessage?type=1
	// 请求方式：get
	// 请求参数： 
	// Action: getMessage
	// type:消息类型 1系统公告 2.优惠促销
	// 返回数据
	public function getMessage(){

        $ary_post = $this->_get();

       if(empty($ary_post['type']))
        {
            $ary_post['type'] = 1;
        }
        if($ary_post['type'] == 1){
        	$map['pn_title'] = array('like','%公告%');

        }elseif($ary_post['type'] == 2){
        	$map['pn_title'] = array('like','%促销%');
      
        }else{

           
        }

        $noticeObj = M('PublicNotice');


        //pn_is_all字段为0,1登录会员能看到,2已注册但未登录，3.游客

		$noticelist = $noticeObj->field('pn_id,pn_title,pn_create_time')
						->where($map)
						->order('pn_is_top desc,pn_create_time desc')
						->select();

        foreach($noticelist as $k=>$v){
            //$noticelist[$k]['pn_content'] = strip_tags($v['pn_content']);
       		$noticelist[$k]['pn_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Home/Index/notice_detail/nid/'.$v['pn_id'];//http://120.25.249.28/Home/Index/notice_detail/nid/36  
       		$noticelist[$k]['from_name'] = "管理员";
       		$noticelist[$k]['pn_is_read'] = '0';

        }	
        //dump($noticelist);
        if($ary_post['type'] == 3){//我的消息
        	
	        $model_mb_user_token = D('MbUserToken');
	        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
	        //dump($token);exit;
	        if(!$token){
	            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
	        }
	        $m_id = $token['member_id'];
	        $noticeObj = D('StationLetters');
	        $noticelist = $noticeObj->field('fx_station_letters.sl_id,sl_title,sl_content,ifnull(m_name,\'管理员\') from_name,rsl_is_look,sl_create_time')
	                                        ->join('inner join fx_related_station_letters on(fx_station_letters.sl_id=fx_related_station_letters.sl_id)')
	                                        ->join('left join fx_members on(fx_station_letters.sl_from_m_id=fx_members.m_id)')
	                                        ->where("rsl_to_del_status=1 and rsl_to_m_id={$m_id}")
	                                        ->order('sl_create_time desc')
	                                        ->page($page_no,$page_size)
	                                        ->select();
	        //echo M()->getlastsql();exit;
	        //dump($noticelist);exit;
	        foreach($noticelist as $k=>$v){
	            //$noticelist[$k]['pn_content'] = strip_tags($v['pn_content']);
	       		$noticelist[$k]['pn_id'] = $v['sl_id']; 
	       		$noticelist[$k]['pn_title'] = $v['sl_title']; 
	       		$noticelist[$k]['pn_url'] = $v['sl_content']; 
	       		$noticelist[$k]['pn_is_read'] = $v['rsl_is_look'];
	       		$noticelist[$k]['pn_create_time'] = $v['sl_create_time']; 
	       		unset($noticelist[$k]['sl_id']); 
	       		unset($noticelist[$k]['sl_title']);
	       		unset($noticelist[$k]['sl_content']);
	       		unset($noticelist[$k]['rsl_is_look']);
	       		unset($noticelist[$k]['sl_create_time']);

	        }	                                        





        }

        if(empty($noticelist)){
        	$noticelist = array();
        }

        output_datas($noticelist,array('result' =>"0",'error_code' =>'0','desc'=>'查询成功!'));

	}







	//冒泡排序
	public function maopao(){

	  $arr = array (12,45,28,30,88,67);
	  //dump($arr);exit;
	  // 进行第一层遍历
	  for($i=0,$k=count($arr);$i<$k;$i++) {
	    // 进行第二层遍历 将数组中每一个元素都与外层元素比较
	    // 这里的i+1意思是外层遍历当前元素往后的
	    for ($j=$i+1;$j<$k;$j++) {
	      // 内外层两个数比较
	        if($arr[$i]<$arr[$j]){
	        // 先把其中一个数组赋值给临时变量
	          $temp = $arr[$j];//大数赋值
	        // 交换位置
	        $arr[$j] = $arr[$i];
	        // 再从临时变量中赋值回来
	        $arr[$i] = $temp;
	      }
	    }
	  }
	  // 返回排序后的数组
	  dump($arr);
	}
	  

  

	//by wangpan 2016-06-20
	public function output_datas($datas, $extend_data = array()) {
	    $data = array();
	   
	    if(!empty($extend_data)) {
	        $data = array_merge($data, $extend_data);
	    }

	    $data['data'] = $datas;

	    if(!empty($_GET['callback'])) {
	        echo $_GET['callback'].'('.json_encode($data,JSON_UNESCAPED_UNICODE).')';die;
	    } else {
	        echo json_encode($data,JSON_UNESCAPED_UNICODE);die;
	    }

	}    

}
