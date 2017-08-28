<?php

/* 
 * desc:认证接口
 * author：wangpan 
 * date：2016-09-20
 * 演示地址:www.xingyun.com:8080/Api/Attest/test
 * request_type:POST或GET
 */
class AttestAction extends CommonAction {
    
	public function __construct(){
		parent::__construct();
	}


	// 请求方式： get
	// 请求参数：
	// action=get_attest_list 固定
    // url : http://www.xingyun.com:8080/Api/Attest/get_attest_list?token=94d6658000bbc30693b9d31989615462
	// Token:	凭证 
	public function get_attest_list(){

        $ary_post = $this->_get();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
        	output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $mid = $token['member_id'];
        $where = [
            'm_id'=>$mid,
        ];
        $field = '';
        //认证状态（1，未认证 2，已认证 3,审核中 4,未通过）
        //电商平台卖家
        $electBusInfo = D('AttestElectbusiness')->where($where)->field($field)->find();
        if($electBusInfo){
            //如果这条记录存在，给图片加域名           
            $electBusInfo['ident_picture_front'] = $electBusInfo['ident_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$electBusInfo['ident_picture_front']:'';
            
            $electBusInfo['ident_picture_back'] = $electBusInfo['ident_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$electBusInfo['ident_picture_back']:'';
            
            $electBusInfo['run_picture_front'] = $electBusInfo['run_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$electBusInfo['run_picture_front']:'';
            
            $electBusInfo['sale_center_pict'] = $electBusInfo['sale_center_pict']?'http://'.$_SERVER['HTTP_HOST'].$electBusInfo['sale_center_pict']:'';
            
            $electBusInfo['taob_home_page'] = $electBusInfo['taob_home_page']?'http://'.$_SERVER['HTTP_HOST'].$electBusInfo['taob_home_page']:'';
        }
        //dump($electBusInfo);exit;
        //线下个体店铺
        $offLineInfo = D('AttestOfflineUnity')->where($where)->field($field)->find();
        if($offLineInfo){

            $offLineInfo['shop_picture_head'] = $offLineInfo['shop_picture_head']?'http://'.$_SERVER['HTTP_HOST'].$offLineInfo['shop_picture_head']:'';
            
            $offLineInfo['shop_picture_scene'] = $offLineInfo['shop_picture_scene']?'http://'.$_SERVER['HTTP_HOST'].$offLineInfo['shop_picture_scene']:'';
            
            $offLineInfo['run_picture_front'] = $offLineInfo['run_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$offLineInfo['run_picture_front']:'';
            
            $offLineInfo['ident_picture_front'] = $offLineInfo['ident_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$offLineInfo['ident_picture_front']:'';
            
            $offLineInfo['ident_picture_back'] = $offLineInfo['ident_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$offLineInfo['ident_picture_back']:'';
            //dump($offLineInfo);exit;
        }
        //个人微商
        $personUnityInfo = D('AttestPersonUnity')->where($where)->field($field)->find();
        if($personUnityInfo){
            
            $personUnityInfo['ident_picture_front'] = $personUnityInfo['ident_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$personUnityInfo['ident_picture_front']:'';
            
            $personUnityInfo['ident_picture_back'] = $personUnityInfo['ident_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$personUnityInfo['ident_picture_back']:'';
            //dump($personUnityInfo);exit;
        }
        //微商平台
        $unityTableInfo = D('AttestUnityTable')->where($where)->field($field)->find();
        if($unityTableInfo){
            
            $unityTableInfo['run_picture_front'] = $unityTableInfo['run_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$unityTableInfo['run_picture_front']:'';
            
            $unityTableInfo['legal_picture_front'] = $unityTableInfo['legal_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$unityTableInfo['legal_picture_front']:'';
            
            $unityTableInfo['legal_picture_back'] = $unityTableInfo['legal_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$unityTableInfo['legal_picture_back']:'';
            //dump($unityTableInfo);exit;
        }    
                
        //自营B2C平台
        $btcWhere = [
            'table_type'=>1,//自营B2C平台
            'm_id'=>$mid,
        ];
        $btwocFenxiaoInfo = D('AttestBtwocFenxiao')->where($btcWhere)->field($field)->find();
        if($btwocFenxiaoInfo){
            
            $btwocFenxiaoInfo['run_picture_front'] = $btwocFenxiaoInfo['run_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$btwocFenxiaoInfo['run_picture_front']:'';
            
            $btwocFenxiaoInfo['legal_picture_front'] = $btwocFenxiaoInfo['legal_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$btwocFenxiaoInfo['legal_picture_front']:'';
            
            $btwocFenxiaoInfo['legal_picture_back'] = $btwocFenxiaoInfo['legal_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$btwocFenxiaoInfo['legal_picture_back']:'';
            //dump($btwocFenxiaoInfo);exit;
        }        
        //分销平台
        $fenxWhere = [
            'table_type'=>2,//分销平台
            'm_id'=>$mid,
        ];
        $fenxiaoInfo = D('AttestBtwocFenxiao')->where($fenxWhere)->field($field)->find();
        if($fenxiaoInfo){
            
            $fenxiaoInfo['run_picture_front'] = $fenxiaoInfo['run_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$fenxiaoInfo['run_picture_front']:'';
            
            $fenxiaoInfo['legal_picture_front'] = $fenxiaoInfo['legal_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$fenxiaoInfo['legal_picture_front']:'';
            
            $fenxiaoInfo['legal_picture_back'] = $fenxiaoInfo['legal_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$fenxiaoInfo['legal_picture_back']:'';
            //dump($fenxiaoInfo);exit;
        }
        //商超百货
        $scbaihuoInfo = D('AttestScbaihuo')->where($where)->field($field)->find();
        if($scbaihuoInfo){
            
            $scbaihuoInfo['shop_picture_head'] = $scbaihuoInfo['shop_picture_head']?'http://'.$_SERVER['HTTP_HOST'].$scbaihuoInfo['shop_picture_head']:'';
            
            $scbaihuoInfo['shop_picture_scene'] = $scbaihuoInfo['shop_picture_scene']?'http://'.$_SERVER['HTTP_HOST'].$scbaihuoInfo['shop_picture_scene']:'';
            
            $scbaihuoInfo['run_picture_front'] = $scbaihuoInfo['run_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$scbaihuoInfo['run_picture_front']:'';
            
            $scbaihuoInfo['legal_picture_front'] = $scbaihuoInfo['legal_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$scbaihuoInfo['legal_picture_front']:'';
            
            $scbaihuoInfo['legal_picture_back'] = $scbaihuoInfo['legal_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$scbaihuoInfo['legal_picture_back']:'';
            //dump($scbaihuoInfo);exit;
        }
        //贸易公司
        $tradeCompanyInfo = D('AttestTradeCompany')->where($where)->field($field)->find();
        if($tradeCompanyInfo){
            
            $tradeCompanyInfo['run_picture_front'] = $tradeCompanyInfo['run_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$tradeCompanyInfo['run_picture_front']:'';
            
            $tradeCompanyInfo['legal_picture_front'] = $tradeCompanyInfo['legal_picture_front']?'http://'.$_SERVER['HTTP_HOST'].$tradeCompanyInfo['legal_picture_front']:'';
            
            $tradeCompanyInfo['legal_picture_back'] = $tradeCompanyInfo['legal_picture_back']?'http://'.$_SERVER['HTTP_HOST'].$tradeCompanyInfo['legal_picture_back']:'';       
            //dump($tradeCompanyInfo);exit;
        }

        $attestList = array(//因为是8张表，所以组成一个数组

            $electBusInfo,
            $offLineInfo,
            $personUnityInfo,
            $unityTableInfo,
            $btwocFenxiaoInfo,
            $fenxiaoInfo,
            $scbaihuoInfo,            
            $tradeCompanyInfo

        );
        //dump($attestList);exit;
        //开始处理结果
        $attestList_all = $attestList;//原数组
        $attestList_less = array_filter($attestList);//删除空值后的数组
        //dump($attestList_less);exit;
        $pos = array_keys($attestList_less);//获取当前数组的键，在原数组中的位置
        //dump($pos);exit;
          // 0 => int 6
          // 1 => int 7
        
        $newarray = array();//规定一个新数组
        foreach ($pos as $key => $value) {//$value 认证表的类型
           $type = $value;
           $items['detail'] = $attestList_all[$value];
           $items['type'] = $type+1;
           $newarray[$key] = $items;
        }

        //dump($newarray);exit;


        //数组按status归类
        $item = array();
        foreach($newarray as $k=>$v){
            if(!isset($item[$v['detail']['status']])){
                $item[$v['detail']['status']][]=$v;
            }else{
                $item[$v['detail']['status']][]=$v;
            }
        }
        

        //按照上面的思路再来一遍
        $pos1 = array_keys($item);//array (size=2)

        //dump($pos1);exit;

          // 0 => int 4
          // 1 => int 2
          // 2 => int 3
        $newarray1 = array();
            foreach ($pos1 as $key1 => $value1) {//$value1 认证的状态
               
               $items1['list'] = $item[$value1];
               $items1['status'] = $value1;
               $newarray1[$key1] = $items1;
            }

        //dump($newarray1);exit;

        output_datas($newarray1,array('result' =>"0",'error_code' =>0,'desc'=>'查询认证列表成功！'));
        

	}

 


    //图片上传接口 
    //方式post
    //参数列表 
    //token
    //type 认证类型 1电商平台卖家 2线下个体店铺  3个人微商 4. 微商平台  5. 自营B2C平台  6分销平台  7商超百货消 8贸易公司 9.待定
    //pic 照片类型 1 身份证/法人身份证正面 2.身份证/法人身份证反面  3.营业执照正面  4.店铺门口 5.店铺门景 6.店铺首页图 7.卖家中心图
    //file
    //run_body 经营主体 1个人 2企业
    //table_type 平台类型（1 自营B2C平台 2分销平台），仅认证type=5 和 type=6 时需要传
    //url 120.25.249.28/Api/Attest/saveAttestPhoto

    public function saveAttestPhoto(){

        $ary_post = $this->_post();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
  
        // 图像上传路径
        // $path="/Public/Uploads/v78/card/".date('Ymd',time())."/";
        $path="Public/Uploads/v78/card/".date('Ymd',time());
        if(!is_dir($path))
        {
            mkdir($path,0777,true);
        }
        //插入数据库时照片的保存路径
        $url = "/".$path."/";
        $type = $ary_post['type'];
        switch ($type) {
            //1电商平台卖家 2线下个体店铺  3个人微商 4. 微商平台  5. 自营B2C平台  6分销平台  7商超百货消 8贸易公司 9.待定
            case '1':
                
                    //电商平台卖家 run_body = 1 || 2
                    $mElectBusiness = D('AttestElectbusiness');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];


                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //身份证正面照片
                    if ($pic == '1') {

                        $ident_picture_front = $_FILES['file'];
                        if($ident_picture_front['name']!=="")
                        {
                            $ident_picture_front['name']=md5($ident_picture_front['name'].time()).substr($ident_picture_front['name'], strpos($ident_picture_front['name'],"."));
                            move_uploaded_file($ident_picture_front['tmp_name'], $path."/".$ident_picture_front['name']);
                            $insertData['ident_picture_front']=$url.$ident_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$ident_picture_front['name'];
                    } 
 
                    //身份证反面照片  
                    if ($pic == '2') {

                        $ident_picture_back = $_FILES['file'];
                        if($ident_picture_back['name']!=="")
                        {
                            $ident_picture_back['name']=md5($ident_picture_back['name'].time()).substr($ident_picture_back['name'], strpos($ident_picture_back['name'],"."));
                            move_uploaded_file($ident_picture_back['tmp_name'], $path."/".$ident_picture_back['name']);
                            $insertData['ident_picture_back']=$url.$ident_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$ident_picture_back['name'];
                    } 

                    if($runBody==1){

                        //店铺首页图 taob_home_page
                        if ($pic == '6') {

                            $taob_home_page = $_FILES['file'];
                            if($taob_home_page['name']!=="")
                            {
                                $taob_home_page['name']=md5($taob_home_page['name'].time()).substr($taob_home_page['name'], strpos($taob_home_page['name'],"."));
                                move_uploaded_file($taob_home_page['tmp_name'], $path."/".$taob_home_page['name']);
                                $insertData['taob_home_page']=$url.$taob_home_page['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$taob_home_page['name'];
                        } 
                        //卖家中心图 sale_center_pict
                        if ($pic == '7') {

                            $sale_center_pict = $_FILES['file'];
                            if($sale_center_pict['name']!=="")
                            {
                                $sale_center_pict['name']=md5($sale_center_pict['name'].time()).substr($sale_center_pict['name'], strpos($sale_center_pict['name'],"."));
                                move_uploaded_file($sale_center_pict['tmp_name'], $path."/".$sale_center_pict['name']);
                                $insertData['sale_center_pict']=$url.$sale_center_pict['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$sale_center_pict['name'];
                        }

                    }

                    if($runBody==2){

                        //营业执照正面照片 
                        if ($pic == '3') {

                            $run_picture_front = $_FILES['file'];
                            if($run_picture_front['name']!=="")
                            {
                                $run_picture_front['name']=md5($run_picture_front['name'].time()).substr($run_picture_front['name'], strpos($run_picture_front['name'],"."));
                                move_uploaded_file($run_picture_front['tmp_name'], $path."/".$run_picture_front['name']);
                                $insertData['run_picture_front']=$url.$run_picture_front['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$run_picture_front['name'];
                        } 


                    }
                

                    $find = $mElectBusiness->where(array('m_id'=>$m_id))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $mElectBusiness->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $mElectBusiness->doInsert($insertData);
                    }


                break;
            case '2':
                    //线下个体店铺 run_body = 1

                    $mOfflineUnity = D('AttestOfflineUnity');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];


                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //身份证正面照片
                    if ($pic == '1') {

                        $ident_picture_front = $_FILES['file'];
                        if($ident_picture_front['name']!=="")
                        {
                            $ident_picture_front['name']=md5($ident_picture_front['name'].time()).substr($ident_picture_front['name'], strpos($ident_picture_front['name'],"."));
                            move_uploaded_file($ident_picture_front['tmp_name'], $path."/".$ident_picture_front['name']);
                            $insertData['ident_picture_front']=$url.$ident_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$ident_picture_front['name'];
                    } 
 
                    //身份证反面照片  
                    if ($pic == '2') {

                        $ident_picture_back = $_FILES['file'];
                        if($ident_picture_back['name']!=="")
                        {
                            $ident_picture_back['name']=md5($ident_picture_back['name'].time()).substr($ident_picture_back['name'], strpos($ident_picture_back['name'],"."));
                            move_uploaded_file($ident_picture_back['tmp_name'], $path."/".$ident_picture_back['name']);
                            $insertData['ident_picture_back']=$url.$ident_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$ident_picture_back['name'];
                    } 


                    // if($runBody==2){

                        //营业执照正面照片 
                        if ($pic == '3') {

                            $run_picture_front = $_FILES['file'];
                            if($run_picture_front['name']!=="")
                            {
                                $run_picture_front['name']=md5($run_picture_front['name'].time()).substr($run_picture_front['name'], strpos($run_picture_front['name'],"."));
                                move_uploaded_file($run_picture_front['tmp_name'], $path."/".$run_picture_front['name']);
                                $insertData['run_picture_front']=$url.$run_picture_front['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$run_picture_front['name'];
                        } 


                    // }

                    //店铺门口照片  
                    if ($pic == '4') {

                        $shop_picture_head = $_FILES['file'];
                        if($shop_picture_head['name']!=="")
                        {
                            $shop_picture_head['name']=md5($shop_picture_head['name'].time()).substr($shop_picture_head['name'], strpos($shop_picture_head['name'],"."));
                            move_uploaded_file($shop_picture_head['tmp_name'], $path."/".$shop_picture_head['name']);
                            $insertData['shop_picture_head']=$url.$shop_picture_head['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$shop_picture_head['name'];
                    } 


                    //店铺实景照片  
                    if ($pic == '5') {

                        $shop_picture_scene = $_FILES['file'];
                        if($shop_picture_scene['name']!=="")
                        {
                            $shop_picture_scene['name']=md5($shop_picture_scene['name'].time()).substr($shop_picture_scene['name'], strpos($shop_picture_scene['name'],"."));
                            move_uploaded_file($shop_picture_scene['tmp_name'], $path."/".$shop_picture_scene['name']);
                            $insertData['shop_picture_scene']=$url.$shop_picture_scene['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$shop_picture_scene['name'];
                    } 


                    $find = $mOfflineUnity->where(array('m_id'=>$m_id))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $mOfflineUnity->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $mOfflineUnity->doInsert($insertData);
                    }

                
                break;         
            case '3':
                    //个人微商
                    $mPersonUnity = D('AttestPersonUnity');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];


                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //身份证正面照片
                    if ($pic == '1') {

                        $ident_picture_front = $_FILES['file'];
                        if($ident_picture_front['name']!=="")
                        {
                            $ident_picture_front['name']=md5($ident_picture_front['name'].time()).substr($ident_picture_front['name'], strpos($ident_picture_front['name'],"."));
                            move_uploaded_file($ident_picture_front['tmp_name'], $path."/".$ident_picture_front['name']);
                            $insertData['ident_picture_front']=$url.$ident_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$ident_picture_front['name'];
                    } 
 
                    //身份证反面照片  
                    if ($pic == '2') {

                        $ident_picture_back = $_FILES['file'];
                        if($ident_picture_back['name']!=="")
                        {
                            $ident_picture_back['name']=md5($ident_picture_back['name'].time()).substr($ident_picture_back['name'], strpos($ident_picture_back['name'],"."));
                            move_uploaded_file($ident_picture_back['tmp_name'], $path."/".$ident_picture_back['name']);
                            $insertData['ident_picture_back']=$url.$ident_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$ident_picture_back['name'];
                    } 

                    $find = $mPersonUnity->where(array('m_id'=>$m_id))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $mPersonUnity->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $mPersonUnity->doInsert($insertData);
                    }                
                    

                break;
            case '4':
                    //微商平台 run_body=2

                    $unityTable = D('AttestUnityTable');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];


                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //法人身份证正面照片
                    if ($pic == '1') {

                        $legal_picture_front = $_FILES['file'];
                        if($legal_picture_front['name']!=="")
                        {
                            $legal_picture_front['name']=md5($legal_picture_front['name'].time()).substr($legal_picture_front['name'], strpos($legal_picture_front['name'],"."));
                            move_uploaded_file($legal_picture_front['tmp_name'], $path."/".$legal_picture_front['name']);
                            $insertData['legal_picture_front']=$url.$legal_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_front['name'];
                    } 
 
                    //法人身份证反面照片  
                    if ($pic == '2') {

                        $legal_picture_back = $_FILES['file'];
                        if($legal_picture_back['name']!=="")
                        {
                            $legal_picture_back['name']=md5($legal_picture_back['name'].time()).substr($legal_picture_back['name'], strpos($legal_picture_back['name'],"."));
                            move_uploaded_file($legal_picture_back['tmp_name'], $path."/".$legal_picture_back['name']);
                            $insertData['legal_picture_back']=$url.$legal_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_back['name'];
                    } 



                    if($runBody==2){

                        //营业执照正面照片 
                        if ($pic == '3') {

                            $run_picture_front = $_FILES['file'];
                            if($run_picture_front['name']!=="")
                            {
                                $run_picture_front['name']=md5($run_picture_front['name'].time()).substr($run_picture_front['name'], strpos($run_picture_front['name'],"."));
                                move_uploaded_file($run_picture_front['tmp_name'], $path."/".$run_picture_front['name']);
                                $insertData['run_picture_front']=$url.$run_picture_front['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$run_picture_front['name'];
                        } 


                    }
                
                    $find = $unityTable->where(array('m_id'=>$m_id))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $unityTable->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $unityTable->data($insertData)->add();
                    } 


                break;
            case '5':
                    //自营B2C平台 run_body=2 & table_type平台类型（1，自营B2C平台 2，分销平台）

                    $btwocFenxiao = D('AttestBtwocFenxiao');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];
                    $table_type = $ary_post['table_type'];

                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'table_type'=>$ary_post['table_type'],//1，自营B2C平台 2，分销平台
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //法人身份证正面照片
                    if ($pic == '1') {

                        $legal_picture_front = $_FILES['file'];
                        if($legal_picture_front['name']!=="")
                        {
                            $legal_picture_front['name']=md5($legal_picture_front['name'].time()).substr($legal_picture_front['name'], strpos($legal_picture_front['name'],"."));
                            move_uploaded_file($legal_picture_front['tmp_name'], $path."/".$legal_picture_front['name']);
                            $insertData['legal_picture_front']=$url.$legal_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_front['name'];
                    } 
 
                    //法人身份证反面照片  
                    if ($pic == '2') {

                        $legal_picture_back = $_FILES['file'];
                        if($legal_picture_back['name']!=="")
                        {
                            $legal_picture_back['name']=md5($legal_picture_back['name'].time()).substr($legal_picture_back['name'], strpos($legal_picture_back['name'],"."));
                            move_uploaded_file($legal_picture_back['tmp_name'], $path."/".$legal_picture_back['name']);
                            $insertData['legal_picture_back']=$url.$legal_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_back['name'];
                    }



                    if($runBody==2){

                        //营业执照正面照片 
                        if ($pic == '3') {

                            $run_picture_front = $_FILES['file'];
                            if($run_picture_front['name']!=="")
                            {
                                $run_picture_front['name']=md5($run_picture_front['name'].time()).substr($run_picture_front['name'], strpos($run_picture_front['name'],"."));
                                move_uploaded_file($run_picture_front['tmp_name'], $path."/".$run_picture_front['name']);
                                $insertData['run_picture_front']=$url.$run_picture_front['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$run_picture_front['name'];
                        } 


                    }
                
                    $find = $btwocFenxiao->where(array('m_id'=>$m_id,'table_type'=>$table_type))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $btwocFenxiao->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $btwocFenxiao->data($insertData)->add();
                    } 


                break;

            case '6':
                    //分销平台 run_body=2 & table_type平台类型（1，自营B2C平台 2，分销平台）

                    $fenxiao = D('AttestBtwocFenxiao');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];
                    $table_type = $ary_post['table_type'];

                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'table_type'=>$ary_post['table_type'],//1，自营B2C平台 2，分销平台
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //法人身份证正面照片
                    if ($pic == '1') {

                        $legal_picture_front = $_FILES['file'];
                        if($legal_picture_front['name']!=="")
                        {
                            $legal_picture_front['name']=md5($legal_picture_front['name'].time()).substr($legal_picture_front['name'], strpos($legal_picture_front['name'],"."));
                            move_uploaded_file($legal_picture_front['tmp_name'], $path."/".$legal_picture_front['name']);
                            $insertData['legal_picture_front']=$url.$legal_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_front['name'];
                    } 
 
                    //法人身份证反面照片  
                    if ($pic == '2') {

                        $legal_picture_back = $_FILES['file'];
                        if($legal_picture_back['name']!=="")
                        {
                            $legal_picture_back['name']=md5($legal_picture_back['name'].time()).substr($legal_picture_back['name'], strpos($legal_picture_back['name'],"."));
                            move_uploaded_file($legal_picture_back['tmp_name'], $path."/".$legal_picture_back['name']);
                            $insertData['legal_picture_back']=$url.$legal_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_back['name'];
                    }



                    if($runBody==2){

                        //营业执照正面照片 
                        if ($pic == '3') {

                            $run_picture_front = $_FILES['file'];
                            if($run_picture_front['name']!=="")
                            {
                                $run_picture_front['name']=md5($run_picture_front['name'].time()).substr($run_picture_front['name'], strpos($run_picture_front['name'],"."));
                                move_uploaded_file($run_picture_front['tmp_name'], $path."/".$run_picture_front['name']);
                                $insertData['run_picture_front']=$url.$run_picture_front['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$run_picture_front['name'];
                        } 


                    }
                
                    $find = $fenxiao->where(array('m_id'=>$m_id,'table_type'=>$table_type))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $fenxiao->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $fenxiao->data($insertData)->add();
                    }


                break;

            case '7':
                    //商超百货 run_body = 2

                    $scbaihuo = D('AttestScbaihuo');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];


                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //法人身份证正面照片
                    if ($pic == '1') {

                        $legal_picture_front = $_FILES['file'];
                        if($legal_picture_front['name']!=="")
                        {
                            $legal_picture_front['name']=md5($legal_picture_front['name'].time()).substr($legal_picture_front['name'], strpos($legal_picture_front['name'],"."));
                            move_uploaded_file($legal_picture_front['tmp_name'], $path."/".$legal_picture_front['name']);
                            $insertData['legal_picture_front']=$url.$legal_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_front['name'];
                    } 
 
                    //法人身份证反面照片  
                    if ($pic == '2') {

                        $legal_picture_back = $_FILES['file'];
                        if($legal_picture_back['name']!=="")
                        {
                            $legal_picture_back['name']=md5($legal_picture_back['name'].time()).substr($legal_picture_back['name'], strpos($legal_picture_back['name'],"."));
                            move_uploaded_file($legal_picture_back['tmp_name'], $path."/".$legal_picture_back['name']);
                            $insertData['legal_picture_back']=$url.$legal_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_back['name'];
                    }



                    if($runBody==2){

                        //营业执照正面照片 
                        if ($pic == '3') {

                            $run_picture_front = $_FILES['file'];
                            if($run_picture_front['name']!=="")
                            {
                                $run_picture_front['name']=md5($run_picture_front['name'].time()).substr($run_picture_front['name'], strpos($run_picture_front['name'],"."));
                                move_uploaded_file($run_picture_front['tmp_name'], $path."/".$run_picture_front['name']);
                                $insertData['run_picture_front']=$url.$run_picture_front['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$run_picture_front['name'];
                        } 


                    }

                    //店铺门口照片  
                    if ($pic == '4') {

                        $shop_picture_head = $_FILES['file'];
                        if($shop_picture_head['name']!=="")
                        {
                            $shop_picture_head['name']=md5($shop_picture_head['name'].time()).substr($shop_picture_head['name'], strpos($shop_picture_head['name'],"."));
                            move_uploaded_file($shop_picture_head['tmp_name'], $path."/".$shop_picture_head['name']);
                            $insertData['shop_picture_head']=$url.$shop_picture_head['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$shop_picture_head['name'];
                    } 


                    //店铺实景照片  
                    if ($pic == '5') {

                        $shop_picture_scene = $_FILES['file'];
                        if($shop_picture_scene['name']!=="")
                        {
                            $shop_picture_scene['name']=md5($shop_picture_scene['name'].time()).substr($shop_picture_scene['name'], strpos($shop_picture_scene['name'],"."));
                            move_uploaded_file($shop_picture_scene['tmp_name'], $path."/".$shop_picture_scene['name']);
                            $insertData['shop_picture_scene']=$url.$shop_picture_scene['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$shop_picture_scene['name'];
                    } 

                    $find = $scbaihuo->where(array('m_id'=>$m_id))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $scbaihuo->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $scbaihuo->data($insertData)->add();
                    }                


                break;

            case '8':
                    //贸易公司 run_body = 2

                    $tradeCompany = D('AttestTradeCompany');
                    $runBody = intval($ary_post['run_body']);
                    $date = date('Y-m-d H:i:s');
                    $pic = $ary_post['pic'];


                    $insertData = [
                        'm_id'=>$m_id,
                        'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                        'create_time'=>$date,
                        'update_time'=>$date,            
                    ];

                    //法人身份证正面照片
                    if ($pic == '1') {

                        $legal_picture_front = $_FILES['file'];
                        if($legal_picture_front['name']!=="")
                        {
                            $legal_picture_front['name']=md5($legal_picture_front['name'].time()).substr($legal_picture_front['name'], strpos($legal_picture_front['name'],"."));
                            move_uploaded_file($legal_picture_front['tmp_name'], $path."/".$legal_picture_front['name']);
                            $insertData['legal_picture_front']=$url.$legal_picture_front['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_front['name'];
                    } 
 
                    //法人身份证反面照片  
                    if ($pic == '2') {

                        $legal_picture_back = $_FILES['file'];
                        if($legal_picture_back['name']!=="")
                        {
                            $legal_picture_back['name']=md5($legal_picture_back['name'].time()).substr($legal_picture_back['name'], strpos($legal_picture_back['name'],"."));
                            move_uploaded_file($legal_picture_back['tmp_name'], $path."/".$legal_picture_back['name']);
                            $insertData['legal_picture_back']=$url.$legal_picture_back['name'];
                        }
                        $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$legal_picture_back['name'];
                    }



                    if($runBody==2){

                        //营业执照正面照片 
                        if ($pic == '3') {

                            $run_picture_front = $_FILES['file'];
                            if($run_picture_front['name']!=="")
                            {
                                $run_picture_front['name']=md5($run_picture_front['name'].time()).substr($run_picture_front['name'], strpos($run_picture_front['name'],"."));
                                move_uploaded_file($run_picture_front['tmp_name'], $path."/".$run_picture_front['name']);
                                $insertData['run_picture_front']=$url.$run_picture_front['name'];
                            }
                            $pic_url = 'http://'.$_SERVER['HTTP_HOST'].$url.$run_picture_front['name'];
                        } 


                    }
                
                    $find = $tradeCompany->where(array('m_id'=>$m_id))->find();  
                    //dump($find);exit;
                    if($find){
                        
                        //编辑操作
                        unset($insertData['create_time']);
                        $insertResult = $tradeCompany->where(array('id'=>$find['id']))->save($insertData);
                        //echo M()->getlastsql();exit;
                    }else{
                        //新增操作
                        $insertResult = $tradeCompany->data($insertData)->add();
                    }  


                break;

            default:
                # code...
                break;
        }

        
            output_datas($pic_url,array('result' =>"0",'error_code' =>0,'desc'=>'图片上传成功！'));
        
    }




    /**
     * app不保存照片，返回时删除一条记录id
     * 参数  
     * token 
     * type 认证类型 1电商平台卖家 2线下个体店铺  3个人微商 4. 微商平台  5. 自营B2C平台  6分销平台  7商超百货消 8贸易公司 9.待定
     * url : 120.25.249.28/Api/Attest/delTempGraph
    */
    public function delTempGraph(){

        $ary_post = $this->_post();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $type = $ary_post['type'];
        $where = [
            'm_id'=>$m_id,
        ];

        switch ($type) {
            case '1':
                    //电商平台卖家
                    $delGragh = D('AttestElectbusiness')->where($where)->delete();

                break;            
            case '2':
                    //线下个体店铺
                    $delGragh = D('AttestOfflineUnity')->where($where)->delete();

                break;  
            case '3':
                    //个人微商
                    $delGragh = D('AttestPersonUnity')->where($where)->delete();

                break;  

            case '4':
                    //微商平台
                    $delGragh = D('AttestUnityTable')->where($where)->delete();

                break;  

            case '5':
                    //自营B2C平台
                    $btcWhere = [
                        'table_type'=>1,//自营B2C平台
                        'm_id'=>$m_id,
                    ];

                    $delGragh = D('AttestBtwocFenxiao')->where($btcWhere)->delete();

                break;
            case '6':
                    //自营B2C平台
                    $btcWhere = [
                        'table_type'=>2,//分销平台
                        'm_id'=>$m_id,
                    ];

                    $delGragh = D('AttestBtwocFenxiao')->where($btcWhere)->delete();

                break;       

            case '7':
                    //商超百货
                    $delGragh = D('AttestScbaihuo')->where($where)->delete();
                    //echo M()->getlastsql();exit;
                break;  
            case '8':
                    //贸易公司
                    $delGragh = D('AttestTradeCompany')->where($where)->delete();

                break;  

            default:
                # code...
                break;
        }


        output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'图片删除成功！'));

    }




    /**
     * 发送认证邮箱--个人中心的认证
     * @author zhangdong
     * @date 2016.09.18
     */
    public function sendAuditEmail($userName, $mobilePhone, $message)
    {
        $reEmailAddr = 'info@xyb2b.com';            
        //验证手机号码
        $mobile_preg = '/^1[3|4|5|8|7][0-9]\d{8}$/i';
        if (!preg_match($mobile_preg, $mobilePhone)) {
            output_datas(null,array('result' =>"1",'error_code' =>30000,'desc'=>'手机号码格式不正确'));
        }
        $emailContent = '用户名称：'.$userName.',<br>用户手机号码：'.$mobilePhone.',<br>邮箱内容：'.$message;
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
            return false;
        }        
        return true;        
    }




    //上传文本接口 
    //方式 post
    //参数列表 
    //token
    //type 认证类型 1电商平台卖家 2线下个体店铺  3个人微商 4. 微商平台  5. 自营B2C平台  6分销平台  7商超百货消 8贸易公司 9.待定
    //^——^一共八张表，数不清的字段，crying……
    //url 120.25.249.28/Api/Attest/saveAttestText

    public function saveAttestText(){

        $ary_post = $this->_post();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->where($condition)->find();

        $type = $ary_post['type'];
        $runBody = intval($ary_post['run_body']);
        $date = date('Y-m-d H:i:s');

        switch ($type) {
            case '1':
                //电商平台卖家

                //检查身份证是否唯一
                //$this->checkIdNumIsOnly($ary_post['ident_num'],$m_id);
                //检查企业名是否被占用
                //$this->checkNameIsOnly($ary_post['com_name'],$m_id);

                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>$ary_post['run_body'],//1，个人 2，企业
                    'sale_table_id'=>$ary_post['sale_table_id'],//销售平台id（关联到第三方店铺分类表fx_sale_table）
                    'shop_name'=>$ary_post['shop_name'],
                    'shop_url'=>$ary_post['shop_url'],
                    'month_sale_count'=>$ary_post['month_sale_count'],
                    'com_name'=>$ary_post['com_name'],
                    'shop_user_name'=>$ary_post['shop_user_name'],
                    'run_goods_cate'=>$ary_post['run_goods_cate'],
                    'ident_num'=>$ary_post['ident_num'],
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）
                    'create_time'=>$date,
                    'update_time'=>$date,            
                ];
                if($runBody==2){
                    unset($insertData['ident_num']);//删除企业类型不填的字段
                }
                $mElectBusiness = D('AttestElectbusiness');
 
                $find = $mElectBusiness->where(array('m_id'=>$m_id))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $mElectBusiness->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $mElectBusiness->doInsert($insertData);
                }

                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写电商平台卖家认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }
                
                break;
            case '2':
                
                //线下个体店铺

                $mCityRegion = D('CityRegion');
                $field = 'cr_name';
                $proWhere = [
                    'cr_id'=>$ary_post['province_id'],
                ];
                $cityWhere = [
                    'cr_id'=>$ary_post['city_id'],
                ];
                $areaWhere = [
                    'cr_id'=>$ary_post['distract_id'],
                ];
                $proName = $mCityRegion->addressInfo($proWhere,$field); 
                //echo M()->getlastsql();exit;
                $cityName = $mCityRegion->addressInfo($cityWhere,$field); 
                $areaName = $mCityRegion->addressInfo($areaWhere,$field);
                $shopAddress = $proName['cr_name'] . $cityName['cr_name'] . $areaName['cr_name'];
                //检查企业名是否被占用
                //$this->checkNameIsOnly($ary_post['company_name'],$m_id);
                //echo M()->getlastsql();exit;
                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>1,//1，个人 2，企业
                    'company_name'=>$ary_post['company_name'],
                    'shop_name'=>$ary_post['shop_name'],
                    'shop_addr_full'=>$ary_post['shop_addr_full'],
                    'shop_address'=>$shopAddress,
                    'run_goods_cate'=>$ary_post['run_goods_cate'],            
                    'month_sale_count'=>$ary_post['month_sale_count'],            
                    'province_id'=>$ary_post['province_id'],
                    'city_id'=>$ary_post['city_id'],
                    'distract_id'=>$ary_post['distract_id'],
                    'create_time'=>$date,
                    'update_time'=>$date,
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）            
                ];
                $mAttestOfflineUnity = D('AttestOfflineUnity');
 
                $find = $mAttestOfflineUnity->where(array('m_id'=>$m_id))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $mAttestOfflineUnity->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $mAttestOfflineUnity->doInsert($insertData);
                }

                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写线下个体店铺认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }


                break;  

            case '3':
                //个人微商
                //检查身份证是否唯一
                //$this->checkPersonIdNumIsOnly($ary_post['ident_run_num'],$m_id);
                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>1,//1，个人 2，企业
                    'run_type'=>$ary_post['run_type'],//经营方式   微信、有赞、朋友圈、微博等
                    'month_sale_count'=>$ary_post['month_sale_count'],            
                    'user_name'=>$ary_post['user_name'],
                    'ident_run_num'=>$ary_post['ident_run_num'],
                    'run_goods_cate'=>$ary_post['run_goods_cate'],
                    'create_time'=>$date,
                    'update_time'=>$date,
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）         
                ];
                $mAttestPersonUnity = D('AttestPersonUnity');
                $find = $mAttestPersonUnity->where(array('m_id'=>$m_id))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $mAttestPersonUnity->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $mAttestPersonUnity->doInsert($insertData);
                }

                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写个人微商认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }


                break;

            case '4':
                //微商平台
                //检查企业名是否被占用
                //$this->checkNameIsOnly($ary_post['com_name'],$m_id);

                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>2,//1，个人 2，企业
                    'run_type'=>$ary_post['run_type'],//经营方式   微信、有赞、朋友圈、微博等
                    'month_sale_count'=>$ary_post['month_sale_count'],            
                    'unity_name'=>$ary_post['unity_name'],//微商名称
                    'unity_count'=>$ary_post['unity_count'],//微商用户数
                    'com_name'=>$ary_post['com_name'],
                    'run_goods_cate'=>$ary_post['run_goods_cate'],
                    'create_time'=>$date,
                    'update_time'=>$date,
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）         
                ];
                $unityTableData = D('AttestUnityTable');
                //dump($unityTableData);exit;
                $find = $unityTableData->where(array('m_id'=>$m_id))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $unityTableData->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $unityTableData->data($insertData)->add();
                }

                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写微商平台认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }


                break;
            case '5':
                //自营B2C平台
                //检查企业名是否被占用
                //$this->checkNameIsOnly($ary_post['com_name'],$m_id);

                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>2,//1，个人 2，企业
                    'table_type'=>1,//平台类型（1，自营B2C平台 2，分销平台）
                    'table_url'=>$ary_post['table_url'],
                    'month_sale_count'=>$ary_post['month_sale_count'],            
                    'table_name'=>$ary_post['table_name'],
                    'com_name'=>$ary_post['com_name'],
                    'run_goods_cate'=>$ary_post['run_goods_cate'],
                    'create_time'=>$date,
                    'update_time'=>$date,
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）         
                ];
                $btwocFenxiao = D('AttestBtwocFenxiao');
                //dump($unityTableData);exit;
                $find = $btwocFenxiao->where(array('m_id'=>$m_id,'table_type'=>1))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $btwocFenxiao->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $btwocFenxiao->data($insertData)->add();
                }
                //echo M()->getlastsql();exit;
                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写自营B2C平台认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }


                break;
            case '6':
                
                //分销平台
                //检查企业名是否被占用
                //$this->checkNameIsOnly($ary_post['com_name'],$m_id);

                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>2,//1，个人 2，企业
                    'table_type'=>2,//平台类型（1，自营B2C平台 2，分销平台）
                    'table_url'=>$ary_post['table_url'],
                    'month_sale_count'=>$ary_post['month_sale_count'],            
                    'table_name'=>$ary_post['table_name'],
                    'com_name'=>$ary_post['com_name'],
                    'run_goods_cate'=>$ary_post['run_goods_cate'],
                    'create_time'=>$date,
                    'update_time'=>$date,
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）         
                ];
                $Fenxiao = D('AttestBtwocFenxiao');
                //dump($unityTableData);exit;
                $find = $Fenxiao->where(array('m_id'=>$m_id,'table_type'=>2))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $Fenxiao->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $Fenxiao->data($insertData)->add();
                }
                //echo M()->getlastsql();exit;
                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写分销平台认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }



                break;
            case '7':
                
                //商超百货

                $mCityRegion = D('CityRegion');
                $field = 'cr_name';
                $proWhere = [
                    'cr_id'=>$ary_post['province_id'],
                ];
                $cityWhere = [
                    'cr_id'=>$ary_post['city_id'],
                ];
                $areaWhere = [
                    'cr_id'=>$ary_post['distract_id'],
                ];
                $proName = $mCityRegion->addressInfo($proWhere,$field); 
                //echo M()->getlastsql();exit;
                $cityName = $mCityRegion->addressInfo($cityWhere,$field); 
                $areaName = $mCityRegion->addressInfo($areaWhere,$field);
                $shopAddress = $proName['cr_name'] . $cityName['cr_name'] . $areaName['cr_name'];
                //检查企业名是否被占用
                //$this->checkNameIsOnly($ary_post['com_name'],$m_id);
                //echo M()->getlastsql();exit;
                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>2,//1，个人 2，企业
                    'com_name'=>$ary_post['com_name'],
                    'son_shop_count'=>$ary_post['son_shop_count'],//分店数量
                    'shop_name'=>$ary_post['shop_name'],
                    'shop_addr_full'=>$ary_post['shop_addr_full'],
                    'shop_address'=>$shopAddress,
                    'run_goods_cate'=>$ary_post['run_goods_cate'],            
                    'month_sale_count'=>$ary_post['month_sale_count'],            
                    'province_id'=>$ary_post['province_id'],
                    'city_id'=>$ary_post['city_id'],
                    'distract_id'=>$ary_post['distract_id'],
                    'create_time'=>$date,
                    'update_time'=>$date,
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）            
                ];
                $scbaihuo = D('AttestScbaihuo');
 
                $find = $scbaihuo->where(array('m_id'=>$m_id))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $scbaihuo->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $scbaihuo->data($insertData)->add();
                }

                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写商超百货认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }


                break;

            case '8':
                //贸易公司

                //检查企业名是否被占用
                //$this->checkNameIsOnly($ary_post['com_name'],$m_id);
                //echo M()->getlastsql();exit;
                $insertData = [
                    'm_id'=>$m_id,
                    'run_body'=>2,//1，个人 2，企业
                    'com_name'=>$ary_post['com_name'],
                    'run_goods_cate'=>$ary_post['run_goods_cate'],            
                    'month_sale_count'=>$ary_post['month_sale_count'],            
                    'create_time'=>$date,
                    'update_time'=>$date,
                    'status'=>3,//认证状态（1，未认证 2，已认证 3,审核中 4,未通过）            
                ];
                $tradeCompany = D('AttestTradeCompany');
 
                $find = $tradeCompany->where(array('m_id'=>$m_id))->find();  
                //dump($find);exit;
                if($find){
                    
                    //编辑操作
                    unset($insertData['create_time']);
                    $insertResult = $tradeCompany->where(array('id'=>$find['id']))->save($insertData);
                    //echo M()->getlastsql();exit;
                }else{
                    //新增操作
                    $insertResult = $tradeCompany->data($insertData)->add();
                }

                if(!$insertResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80002,'desc'=>'提交认证失败！'));
                }
                //向客服发送邮件
                $userName = $member_info['m_name'];
                $mobilePhone = $member_info['m_mobile'];
                $message = '用户填写贸易公司认证信息';
                $sendEmailResult = $this->sendAuditEmail($userName, $mobilePhone, $message);
                if(!$sendEmailResult){
                    output_datas(null,array('result' =>"1",'error_code' =>80005,'desc'=>'提交认证失败！'));
                }


                break;


            default:
                # code...
                break;
        }


            output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'提交成功，客服人员将在工作时间2个小时内审核您的信息，请耐心等待！'));


    }




    /*
     * desc:电商平台卖家--检查身份证号码是否唯一
     * author:zhangdong
     * date:2016-09-18
     * **/
    public function checkIdNumIsOnly($idNum,$mid)
    {
        $idNum = $this->_request('ident_num');
        $mElectBusiness = D('AttestElectbusiness');
        $where = [
            'm_id' => ['NEQ',$mid],
            'ident_num' => $idNum,
        ];
        $field = 'ident_num';
        $result = $mElectBusiness->getElectBusData($where,$field);
        if($result){

            output_datas(null,array('result' =>"1",'error_code' =>80003,'desc'=>'该身份证号码已被认证！'));

        }
        
    }
    /*
     * desc:个人微商--检查身份证号码是否唯一
     * author:zhangdong
     * date:2016-09-18
     * **/
    public function checkPersonIdNumIsOnly($idNum,$mid)
    {
        $idNum = $this->_request('ident_run_num');
        $mAttestPersonUnity = D('AttestPersonUnity');
        $where = [
            'm_id' => ['NEQ',$mid],
            'ident_run_num' => $idNum,
        ];
        $field = 'ident_run_num';
        $result = $mAttestPersonUnity->getElectBusData($where,$field);
        if($result){

            output_datas(null,array('result' =>"1",'error_code' =>80003,'desc'=>'该身份证号码已被认证！'));

        }

    }
    /*
     * desc:检查企业名称是否唯一
     * author:zhangdong
     * date:2016-09-18
     * **/
    public function checkNameIsOnly($userComName,$mid)
    {

        //电商平台
        $electBusWhere = [
            'm_id' => ['NEQ',$mid],
            'user_com_name' => $userComName,
        ];
        $field = 'user_com_name';        
        $result = D('AttestElectbusiness')->getElectBusData($electBusWhere,$field);
        if($result){

            output_datas(null,array('result' =>"1",'error_code' =>80004,'desc'=>'该名称已被认证！'));
        }        
        //线下个体店铺
        $offLineWhere = [
            'm_id' => ['NEQ',$mid],
            'company_name' => $userComName,
        ];
        $field = 'company_name';
        $result = D('AttestOfflineUnity')->getElectBusData($offLineWhere,$field);
        if($result){
            output_datas(null,array('result' =>"1",'error_code' =>80004,'desc'=>'该名称已被认证！'));
        }
        //B2C分销
        $publicWhere = [
            'm_id' => ['NEQ',$mid],
            'com_name' => $userComName,
        ];
        $field = 'com_name';
        $result = D('AttestBtwocFenxiao')->getElectBusData($publicWhere,$field);
        if($result){
            output_datas(null,array('result' =>"1",'error_code' =>80004,'desc'=>'该名称已被认证！'));
        }
        //商超百货        
        $result = D('AttestScbaihuo')->getElectBusData($publicWhere,$field);
        if($result){
            output_datas(null,array('result' =>"1",'error_code' =>80004,'desc'=>'该名称已被认证！'));
        }
        //贸易公司        
        $result = D('AttestTradeCompany')->getElectBusData($publicWhere,$field);
        if($result){
            output_datas(null,array('result' =>"1",'error_code' =>80004,'desc'=>'该名称已被认证！'));
        }
        //微商平台        
        $result = D('AttestUnityTable')->getElectBusData($publicWhere,$field);
        if($result){
            output_datas(null,array('result' =>"1",'error_code' =>80004,'desc'=>'该名称已被认证！'));
        }
        

    }



    //查询该用户上传的身份证号码或企业名称 是否被占用
    //请求方式 post
    //url 120.25.249.28/Api/Attest/checkAttestInput
    //参数列表
    //token
    // idNum  
    // userComName   
    public function checkAttestInput(){

        $ary_post = $this->_post();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $mid = $token['member_id'];

        $idNum = $ary_post['idNum'];
        $userComName = $ary_post['userComName'];
        //检查身份证
        if($idNum){
            
            //电商平台卖家
            $mElectBusiness = D('AttestElectbusiness');
            $where = [
                'm_id' => ['NEQ',$mid],
                'ident_num' => $idNum,
            ];
            $field = 'ident_num';
            $result = $mElectBusiness->getElectBusData($where,$field);

            if($result){

                output_datas(true,array('result' =>"0",'error_code' =>80003,'desc'=>'该身份证号码已被认证！'));

            }        
 
            //个人微商
            $mAttestPersonUnity = D('AttestPersonUnity');
            $where = [
                'm_id' => ['NEQ',$mid],
                'ident_run_num' => $idNum,
            ];
            $field = 'ident_run_num';
            $result = $mAttestPersonUnity->getElectBusData($where,$field);

            if($result){

                output_datas(true,array('result' =>"0",'error_code' =>80003,'desc'=>'该身份证号码已被认证！'));

            } 

            
        }

        //检查企业名
        if($userComName){
            //有几张表的查询条件相同        
            $publicWhere = [
                'm_id' => ['NEQ',$mid],
                'com_name' => $userComName,
            ];
            $field1 = 'com_name';

            //电商平台卖家
            $electBusWhere = [
                'm_id' => ['NEQ',$mid],
                'com_name' => $userComName,
            ];
            $field = 'com_name';        
            $result = D('AttestElectbusiness')->getElectBusData($electBusWhere,$field);
            if($result){
                output_datas(true,array('result' =>"0",'error_code' =>80004,'desc'=>'该名称已被认证！'));
            }
                         
            //线下个体店铺
            $offLineWhere = [
                'm_id' => ['NEQ',$mid],
                'company_name' => $userComName,
            ];
            $field = 'company_name';
            $result = D('AttestOfflineUnity')->getElectBusData($offLineWhere,$field);
            if($result){
                output_datas(true,array('result' =>"0",'error_code' =>80004,'desc'=>'该名称已被认证！'));
            }  

            //微商平台        
            $result = D('AttestUnityTable')->getElectBusData($publicWhere,$field1);
            if($result){
                output_datas(true,array('result' =>"0",'error_code' =>80004,'desc'=>'该名称已被认证！'));
            }
              
            //自营B2C平台
            $result = D('AttestBtwocFenxiao')->getElectBusData($publicWhere,$field1);                    
            if($result){
                output_datas(true,array('result' =>"0",'error_code' =>80004,'desc'=>'该名称已被认证！'));
            }
              

            //分销平台
            $result = D('AttestBtwocFenxiao')->getElectBusData($publicWhere,$field1); 

            if($result){
                output_datas(true,array('result' =>"0",'error_code' =>80004,'desc'=>'该名称已被认证！'));
            }

            //商超百货        
            $result = D('AttestScbaihuo')->getElectBusData($publicWhere,$field1);
            if($result){
                output_datas(true,array('result' =>"0",'error_code' =>80004,'desc'=>'该名称已被认证！'));
            }


            //贸易公司        
            $result = D('AttestTradeCompany')->getElectBusData($publicWhere,$field1);
                    
            if($result){
                output_datas(true,array('result' =>"0",'error_code' =>80004,'desc'=>'该名称已被认证！'));
            }


        } 

        output_datas(false,array('result' =>"0",'error_code' =>0,'desc'=>''));

    }




    //查询该用户是否发放过优惠券
    //请求方式 get
    //url 120.25.249.28/Api/Attest/hasAttest?token=94d6658000bbc30693b9d31989615462
    //参数token
    public function hasAttest(){

        $ary_post = $this->_get();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];

         $check = 1;//未发放优惠券
         $UserCouponValidation = D("CouponActivitiesParticipate")->where(array("m_id"=>$m_id))->find();
         if(!empty($UserCouponValidation))
         {
              $check = 2;//已发放优惠券
         }
         output_datas($check,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功！'));

    }



    //查询该用户是否认证
    //请求方式 post
    //url 120.25.249.28/Api/Attest/return_attest_status
    //参数列表
    //token
    //type （可选）传type则返回当前的认证类型 用户是否已认证；不传则返回用户的认证状态（无论是哪种）        
    public function return_attest_status(){

        $ary_post = $this->_post();
        if (empty($ary_post)) {
            output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $type = $ary_post['type'];
        if($type){
            // $check = 1;//未认证
            $where = [
                'm_id'=>$m_id,
            ];

            switch ($type) {
                case '1':
                        //电商平台卖家
                        $find = D('AttestElectbusiness')->where($where)->find();

                    break;            
                case '2':
                        //线下个体店铺
                        $find = D('AttestOfflineUnity')->where($where)->find();

                    break;  
                case '3':
                        //个人微商
                        $find = D('AttestPersonUnity')->where($where)->find();

                    break;  

                case '4':
                        //微商平台
                        $find = D('AttestUnityTable')->where($where)->find();

                    break;  

                case '5':
                        //自营B2C平台
                        $btcWhere = [
                            'table_type'=>1,//自营B2C平台
                            'm_id'=>$m_id,
                        ];

                        $find = D('AttestBtwocFenxiao')->where($btcWhere)->find();

                    break;
                case '6':
                        //自营B2C平台
                        $btcWhere = [
                            'table_type'=>2,//分销平台
                            'm_id'=>$m_id,
                        ];

                        $find = D('AttestBtwocFenxiao')->where($btcWhere)->find();

                    break;       

                case '7':
                        //商超百货
                        $find = D('AttestScbaihuo')->where($where)->find();
                        //echo M()->getlastsql();exit;
                    break;  
                case '8':
                        //贸易公司
                        $find = D('AttestTradeCompany')->where($where)->find();

                    break;  

                default:
                    # code...
                    break;
            }
            $check = $find['status'];
            if(empty($check)){
                $check = 1;//未认证
            }
            output_datas($check,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功！'));
        }else{
            //没传type的情况

            $check = 1;//未认证
            $attest_status = M('Members')->where(array("m_id"=>$m_id))->getfield('attest_status');
            if($attest_status == 2){
                $check = 2;//已认证
            }
            output_datas($check,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功！'));
        }

    }



    public function test(){

        $url = 'http://www.xingyun.com:8080/Api/Attest/checkAttestInput';
        //$post_data['type'] = '3';
        //$post_data['pic'] = '1';
        // $post_data['run_body'] = '1';
        // $post_data['sale_table_id'] = '1';//销售平台id（关联到第三方店铺分类表fx_sale_table）
        // $post_data['ident_num'] = '429004198502111111';
        $post_data['token'] = '94d6658000bbc30693b9d31989615462';
        $post_data['shop_name'] = '9';
        // $post_data['shop_url'] = '1';
        $post_data['shop_addr_full'] = '1';
         $post_data['company_name'] = '影响';
        // $post_data['shop_user_name'] = '1';
        // $post_data['run_goods_cate'] = '1';
        $post_data['province_id'] = '440000';
        $post_data['city_id'] = '440300';
        $post_data['distract_id'] = '440305';
        // $post_data['run_type'] = '1';
        $post_data['month_sale_count'] = '1';
        // $post_data['user_name'] = '1';
        // $post_data['ident_run_num'] = '429004198502111110';
        $post_data['run_goods_cate'] = '鱼虾类';
        //$post_data['com_name'] = '123456';
        // $post_data['unity_name'] = 'eef'; 
        // $post_data['unity_count'] = '100';   
        // $post_data['table_type'] = '2';
        // $post_data['table_url'] = 'http://www.baidu.com';
        // $post_data['table_name'] = '有赞';            
        //$post_data['son_shop_count'] = '6';//分店数量
        $post_data['idNum'] = "429004198502111110";
        $post_data['userComName'] = '123456';
                                                 
        $o = "";
        foreach ( $post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url, $post_data);       
        print_r($res);

    } 


    /**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
    public function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }

}