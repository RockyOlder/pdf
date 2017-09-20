<?php

/**
 * 后台会员分布图
 * @package Action
 * @subpackage Admin
 * @stage 7.2
 * @author listen 
 * @date 2013-06-04
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class MembersDistributedAction extends AdminAction{
    //put your code here
    /**会员平台分布饼图
     * @author listen   
     * @date 2013-06-06
    */
    public function platformPie(){
        $this->getSubNav(9,0,50);
        $obj_pie = new PieChart();
        
        $ary_platfrom = D('RelatedMembersSourcePlatform')
                        ->join('fx_source_platform on fx_source_platform.sp_id = fx_related_members_source_platform.sp_id')
                        ->where()
                        ->select();
        $labLst =array();
        if(!empty($ary_platfrom)){
            foreach($ary_platfrom as $k=>$v){
                array_push($labLst,$v['sp_name']);
            }
        }
        $ary_temp_datLst = array_count_values($labLst);
        $json_data = array();
        if(!empty($ary_temp_datLst)){
            $int_sum = array_sum($ary_temp_datLst);
            foreach($ary_temp_datLst as $k1=>$v1){
                //$int_sum += $v1; 
                $ary_labLst[] = $k1; 
                array_push($json_data, array('name'=>$k1,'value'=>round(10000*($v1/$int_sum))/10));
            }
        }
        $json_name = json_encode($ary_labLst);
        $json_data = json_encode($json_data);
        $this->assign('json_name',$json_name);
        $this->assign('json_data',$json_data);
        $this->display();
       
    }   
    
    /**
     * 第三方授权登录平台分步
     * @author Joe <qianyijun@guanyisoft.com>
     */
    public function memberThdPic(){
        $this->getSubNav(6,0,65);
        $obj_pie = new PieChart();
        $member = D('Members')->field('open_source')->where(array('open_source'=>array('neq',' ')))->select();
        $labLst =array();
        foreach ($member as $key=>$val){
            if($val['open_source'] == 'QQ'){
                array_push($labLst,'腾讯授权登录');
            }elseif($val['open_source'] == 'Sina'){
                array_push($labLst,'新浪微博授权登录');
            }elseif($val['open_source'] == 'RenRen'){
            array_push($labLst,'人人网授权登录');
            }
        }
        $ary_temp_datLst = array_count_values($labLst);
        if(!empty($ary_temp_datLst)){
            $int_sum = array_sum($ary_temp_datLst);
            foreach($ary_temp_datLst as $k1=>$v1){
                $ary_labLst[] = $k1; 
                $datLst[] = round(10000*($v1/$int_sum))/100;
            }
        }
        $ary_color  =  $obj_pie->roundColor(count($ary_labLst));
        $image_file = $obj_pie->draw_img($datLst,$ary_labLst,$ary_color);
        $ary_color  =  $obj_pie->roundColor(count($ary_labLst));
        $image_file = $obj_pie->draw_img($datLst,$ary_labLst,$ary_color);
        $this->assign('image_file',$image_file);
        $this->display();
    }
    
    public function MemberDataFile(){
        $this->getSubNav(9,1,10);
        $ary_data = $this->_get();
        $ary_where_in = array();
        $ary_where = array();
        $ary_order = 'f_top desc';
        $json_data = array();
        if(!empty($ary_data['m_id'])){
            $ary_user_data =   D("DataAnalysisUser")->field('COUNT(*) AS total,f_id')->where(array('m_id'=>$ary_data['m_id']))->group('f_id')->limit(0,15)->select();
            foreach ($ary_user_data as $value){
                array_push($ary_where_in, $value['f_id']);
                array_push($json_data,$value['total']);
            }
            $ary_where['f_id'] = array('in',$ary_where_in);
            $ary_order= '';
        }
        $ary_platfrom = D("DataAnalysisFile")->where($ary_where)->order($ary_order)->limit(0,15)->select();
        $labLst =array();
        if(!empty($ary_platfrom)){
            foreach($ary_platfrom as $k=>$v){
                array_push($labLst,$v['f_name']);
                if(!empty($ary_order)){
                    array_push($json_data,$v['f_top']);
                }
            }
        }
        $json_name = json_encode($labLst);
        $json_data = json_encode($json_data);
        $this->assign('json_name',$json_name);
        $this->assign('json_data',$json_data);
        $this->assign('ary_data',$ary_data);
        $this->display();
    }

    public function MemberDataAnalysis(){
        $this->getSubNav(9,1,20);
        
        $labelBottom = array('normal'=>array('color'=>'#ccc','label'=>array('show'=>true,'position'=>'center'),'labelLine'=>array('show'=>false)),'emphasis'=>array('color'=>'rgba(0,0,0,0)'));
        $labelTop    = array('normal'=>array('label'=>array('show'=>true,'position'=>'center','formatter'=>'{b}','textStyle'=>array('baseline'=>'bottom')),'labelLine'=>array('show'=>false)));
        $ary_data = $this->_get();
        $ary_Order_select_count_where = array();
        $userConversion_where = array();
        $ary_user_count_where = array();
        if(!empty($ary_data['m_id'])){
            
                $ary_Order_select_count_where['m_id']     =  $ary_data['m_id'];
                $ary_Order_select_count_pay_where['m_id'] =  $ary_data['m_id'];
                $userConversion_where['m_id']             =  $ary_data['m_id'];
                $ary_user_count_where['m_id']             =  $ary_data['m_id'];

                $ary_order_weixin_count_where['m_id']     =  $ary_data['m_id'];
                $ary_order_weixin_count['m_id']           =  $ary_data['m_id'];
                $ary_order_weixin_count_pay_where['m_id'] =  $ary_data['m_id'];
                $ary_order_o_pay_status_where['m_id']     =  $ary_data['m_id'];
                $ary_order_source_where['m_id']           =  $ary_data['m_id'];
                $ary_user_pdf_where['m_id']               =  $ary_data['m_id'];
                $ary_user_cstate_where['m_id']            =  $ary_data['m_id'];
                $ary_user_c_type_state_where['m_id']      =  $ary_data['m_id'];
                $ary_user_where['m_id']                   =  $ary_data['m_id'];
        }
        if (!empty($ary_data['o_create_time_1']) && !empty($ary_data['o_create_time_2'])) {
            
                if ($ary_data['o_create_time_1'] > $ary_data['o_create_time_2']) {
                    $ary_where_time['m_create_time'] = array("BETWEEN", array($ary_data['o_create_time_2'], $ary_data['o_create_time_1']));
                    $pdfList['crate_time'] = array("BETWEEN", array(strtotime($ary_data['o_create_time_2']), strtotime($ary_data['o_create_time_1'])));
                } else if ($ary_data['o_create_time_1'] < $ary_data['o_create_time_2']) {
                    $ary_where_time['m_create_time']= array("BETWEEN", array($ary_data['o_create_time_1'], $ary_data['o_create_time_2']));
                    $pdfList['crate_time'] = array("BETWEEN", array(strtotime($ary_data['o_create_time_1']), strtotime($ary_data['o_create_time_2'])));
                } else {
                    $ary_where_time['m_create_time'] = $ary_data['o_create_time_1'];
                    $pdfList['crate_time'] = strtotime($ary_data['o_create_time_1']);
                }
                $ary_Order_select_count_where['o_create_time']      =  $ary_where_time['m_create_time'];
                $ary_Order_select_count_pay_where['o_create_time']  =  $ary_where_time['m_create_time'];
                $userConversion_where['crate_time']                 =  $pdfList['crate_time'];
                $ary_user_count_where['m_create_time']              =  $ary_where_time['m_create_time'];

                $ary_order_weixin_count_where['o_create_time']      =  $ary_where_time['m_create_time'];
                $ary_order_weixin_count['o_create_time']            =  $ary_where_time['m_create_time'];
                $ary_order_weixin_count_pay_where['o_create_time']  =  $ary_where_time['m_create_time'];
                $ary_order_o_pay_status_where['o_create_time']      =  $ary_where_time['m_create_time'];
                $ary_order_source_where['o_create_time']            =  $ary_where_time['m_create_time'];
                $ary_user_pdf_where['crate_time']                   =  $pdfList['crate_time'];
                $ary_user_cstate_where['crate_time']                =  $pdfList['crate_time'];
                $ary_user_c_type_state_where['crate_time']          =  $pdfList['crate_time'];
                $ary_user_where['m_create_time']                    =  $ary_where_time['m_create_time'];
        }
        $ary_Order_select_count = D('orders')->where($ary_Order_select_count_where)->count();
         //订单行为
        $ary_order_weixin_count_where['o_payment'] = 13;
        $ary_order_weixin_count = D('orders')->where($ary_order_weixin_count_where)->count();
        $ary_weixin_avg = round(sprintf('%0.2f',($ary_order_weixin_count / $ary_Order_select_count) * 100));
        $ary_order_avg  = round(sprintf('%0.2f',(($ary_Order_select_count - $ary_order_weixin_count) / $ary_Order_select_count) *100));
        $ary_o_payment_type = array(array('name'=>'other','value'=>$ary_order_avg,'itemStyle'=>$labelBottom),array('name'=>'订单微信选择','value'=>$ary_weixin_avg,'itemStyle'=>$labelTop));
        $this->assign('ary_o_payment_type', json_encode($ary_o_payment_type));
        
        //订单支付类型
        $ary_Order_select_count_pay_where['o_pay_status'] = 1;
        $ary_Order_select_count_pay = D('orders')->where($ary_Order_select_count_pay_where)->count();
        
        $ary_order_weixin_count_pay_where['o_pay_status'] = 1;
        $ary_order_weixin_count_pay_where['o_payment'] = 13;
        $ary_order_weixin_count_pay = D('orders')->where($ary_order_weixin_count_pay_where)->count();
        $ary_weixin_pay_avg = round(sprintf('%0.2f',($ary_order_weixin_count_pay / $ary_Order_select_count_pay) * 100));
        $ary_order_Alibaba_pay_avg  = round(sprintf('%0.2f',(($ary_Order_select_count_pay - $ary_order_weixin_count_pay) / $ary_Order_select_count_pay) *100));
        $ary_o_payment_pay = array(array('name'=>'other','value'=>$ary_order_Alibaba_pay_avg,'itemStyle'=>$labelBottom),array('name'=>'订单微信支付','value'=>$ary_weixin_pay_avg,'itemStyle'=>$labelTop));
        $this->assign('ary_o_payment_pay', json_encode($ary_o_payment_pay));
        //订单支付行为
        $ary_order_o_pay_status_where['o_pay_status'] = 1;
        $ary_order_o_pay_status = D('orders')->where($ary_order_o_pay_status_where)->count();
        $ary_order_pay_success_avg  = round(sprintf('%0.2f',($ary_order_o_pay_status / $ary_Order_select_count) * 100));
        $ary_order_pay_fial_avg  = round(sprintf('%0.2f',(($ary_Order_select_count - $ary_order_o_pay_status) / $ary_Order_select_count) *100));
        $ary_order_o_payment_pay = array(array('name'=>'other','value'=>$ary_order_pay_fial_avg,'itemStyle'=>$labelBottom),array('name'=>'订单已支付','value'=>$ary_order_pay_success_avg,'itemStyle'=>$labelTop));
        $this->assign('ary_order_o_payment_pay', json_encode($ary_order_o_payment_pay));
        //订单来源
        $ary_order_source_where['o_source'] = 'pc';
        $ary_order_source= D('orders')->where($ary_order_source_where)->count();
        $ary_order_source_pc = round(sprintf('%0.2f',($ary_order_source / $ary_Order_select_count) * 100));
        $ary_order_source_client  = round(sprintf('%0.2f',(($ary_Order_select_count - $ary_order_source) / $ary_Order_select_count) *100));
        $ary_order_source_json = array(array('name'=>'other','value'=>$ary_order_source_client,'itemStyle'=>$labelBottom),array('name'=>'订单来源PC','value'=>$ary_order_source_pc,'itemStyle'=>$labelTop));
        $this->assign('ary_order_source_json', json_encode($ary_order_source_json));
        //转换行为
        
        $userConversion = D("PdfList")->where($userConversion_where)->count();
        //转换类型行为分析
        $ary_user_pdf_where['ftype'] = 'pdf';
        $ary_user_pdf= D('PdfList')->where($ary_user_pdf_where)->count();
        $ary_user_pdf_type = round(sprintf('%0.2f',($ary_user_pdf / $userConversion) * 100));
        $ary_user_excure_type  = round(sprintf('%0.2f',(($userConversion - $ary_user_pdf) / $userConversion) *100));
        $ary_user_pdf_type_json = array(array('name'=>'other','value'=>$ary_user_excure_type,'itemStyle'=>$labelBottom),array('name'=>'上传PDF文件','value'=>$ary_user_pdf_type,'itemStyle'=>$labelTop));
        $this->assign('ary_user_pdf_type_json', json_encode($ary_user_pdf_type_json));
        //转换成功
        $ary_user_cstate_where['cstate'] = 1;
        $ary_user_cstate= D('PdfList')->where($ary_user_cstate_where)->count();
        $ary_user_cstate_success = round(sprintf('%0.2f',($ary_user_cstate / $userConversion) * 100));
        $ary_user_cstate_fail  = round(sprintf('%0.2f',(($userConversion - $ary_user_cstate) / $userConversion) *100));
        $ary_user_cstate_success_json = array(array('name'=>'other','value'=>$ary_user_cstate_fail,'itemStyle'=>$labelBottom),array('name'=>'转换成功文件','value'=>$ary_user_cstate_success,'itemStyle'=>$labelTop));
        $this->assign('ary_user_cstate_success_json', json_encode($ary_user_cstate_success_json));
        
        //转换文件重复行为
        $ary_user_c_type_state_where['c_type_state'] = 2;
        $ary_user_c_type_state= D('PdfList')->where($ary_user_c_type_state_where)->count();
        $ary_user_c_type_state_success = round(sprintf('%0.2f',($ary_user_c_type_state / $userConversion) * 100));
        $ary_user_c_type_state_fail  = round(sprintf('%0.2f',(($userConversion - $ary_user_c_type_state) / $userConversion) *100));
        $ary_user_c_type_state_json = array(array('name'=>'other','value'=>$ary_user_c_type_state_fail,'itemStyle'=>$labelBottom),array('name'=>'上传重复文件','value'=>$ary_user_c_type_state_success,'itemStyle'=>$labelTop));
        $this->assign('ary_user_c_type_state_json', json_encode($ary_user_c_type_state_json));
        
        //用户付费行为
        
        $ary_user_count = D('Members')->where($ary_user_count_where)->count();
        $ary_user_where['conversion_type'] = 0;
        $ary_user= D('Members')->where($ary_user_where)->count();
        $ary_user_charge = round(sprintf('%0.2f',($ary_user / $ary_user_count) * 100));
        $ary_user_pay =  round(sprintf('%0.2f',(($ary_user_count - $ary_user) / $userConversion) *100));
        $ary_user_json = array(array('name'=>'other','value'=>$ary_user_pay,'itemStyle'=>$labelBottom),array('name'=>'免费用户','value'=>$ary_user_charge,'itemStyle'=>$labelTop));
        $this->assign('ary_user_json', json_encode($ary_user_json));
        $this->assign('ary_data',$ary_data);
        $this->display();
    }
    public function SourceActivity(){
        $this->getSubNav(9,1,30);
        $ary_data = $this->_get();
        if (!empty($ary_data['o_create_time_1']) && !empty($ary_data['o_create_time_2'])) {
            
                if ($ary_data['o_create_time_1'] > $ary_data['o_create_time_2']) {
                    $ary_where_time['m_create_time'] = array("BETWEEN", array($ary_data['o_create_time_2'], $ary_data['o_create_time_1']));
                } else if ($ary_data['o_create_time_1'] < $ary_data['o_create_time_2']) {
                    $ary_where_time['m_create_time']= array("BETWEEN", array($ary_data['o_create_time_1'], $ary_data['o_create_time_2']));
                } else {
                    $ary_where_time['m_create_time'] = $ary_data['o_create_time_1'];
                }
                $ary_Order_select_count_where['s_create_time']      =  $ary_where_time['m_create_time'];

        }
        $ary_Order_select_count_where['m_id'] = array('not in',array(25551,6017,6014,193,7339,3));
        $ary_source_data =   D("Source")->where($ary_Order_select_count_where)->field('COUNT(*) AS total,source')->order('total desc')->group('source')->select();
        $source = array();
        foreach ($ary_source_data as $key=>$value){
            if(!empty($value['source'])){
                    switch ($value['source']){
                        case 'WX':
                            $value['source'] = '微信';
                            break;
                        case 'c2494a81':
                            $value['source'] = '百度';
                            break;
//                        case '4b6b7a35':
//                            $value['source'] = '公众号推广';
//                            break;
                        default :
                            $value['source'] = '客户端';
                    }
                      array_push($source, array('value'=>$value['total'],'name'=>$value['source']));
                       // array_push($source, array('value'=>$value['total'],'name'=>$value['source'],'selected'=>true));
            }
        }
        $ary_source_count =   D("Source")->where($ary_Order_select_count_where)->select();

        $SnapUpClick = 0;
        $FiveUserbrandClick = 0;
        $ApibrandClick = 0;
        $UserbrandConversionsClick = 0;
        $UserbrandClick = 0;
        $brandClick = 0;
        $ApiUserbrandClick = 0;
        foreach ( $ary_source_count as $v){
            if($v['s_type'] == 0 && $v['s_status'] == 1){ //横幅点击
                $brandClick = $brandClick+1;
            }
            if($v['s_type'] == 1 && $v['s_status'] == 1){  //免费用登录弹窗点击
                $UserbrandClick = $UserbrandClick+1;
            }
            if($v['s_type'] == 2 && $v['s_status'] == 1){  //免费用转换弹窗点击
                $UserbrandConversionsClick = $UserbrandConversionsClick+1;  
            }
            if($v['s_type'] == 3 && $v['s_status'] == 1){  //Api右上角
                $ApibrandClick = $ApibrandClick+1;
            }
            if($v['s_type'] == 4 && $v['s_status'] == 1){ //客户端Brand
                $ApiUserbrandClick = $ApiUserbrandClick+1;
            }
            if($v['s_type'] == 5 && $v['s_status'] == 1){ //客户端Brand five click
                $FiveUserbrandClick = $FiveUserbrandClick+1;
            }
            if($v['s_type'] == 6 && $v['s_status'] == 1){ //客户端立即抢购 click
                $SnapUpClick = $SnapUpClick+1;
            }
        }
        $inlet = array();
        array_push($inlet, 
                array('value'=>$brandClick,'name'=>'横幅点击'),
                array('value'=>$UserbrandClick,'name'=>'登录弹窗点击'),
                array('value'=>$UserbrandConversionsClick,'name'=>'转换弹窗点击'),
                array('value'=>$ApibrandClick,'name'=>'ApiRight'),
                array('value'=>$ApiUserbrandClick,'name'=>'ApiBrandClick'),
                array('value'=>$FiveUserbrandClick,'name'=>'APIFiveClick'),
                array('value'=>$SnapUpClick,'name'=>'ApiSnapUpClick')
        );
        $this->assign('source', json_encode($source));
        $this->assign('inlet', json_encode($inlet));
        $this->assign('ary_data',$ary_data);
        $this->display();
    }
    public function ceshi(){
        $this->display();
    }
    public function WeekArray($ary_data,$i=1,$int=0,$day=0,$week_time=array()){
        $weekarray=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
        $key = date("w",strtotime($ary_data['o_create_time_1']));
        $week_time[$weekarray[$key]] = strtotime($ary_data['o_create_time_1']);
        if( count($week_time) == 7){
            return $week_time;
        }
        if($int == 1 && count($week_time) <7 ){
              $week_time[$weekarray[$i]] = strtotime($ary_data['o_create_time_1']." +".$day." day" );
            return $this->WeekArray($ary_data,++$i,1,++$day,$week_time);
        }else {
            if(($key+$i) >6){
               return $this->WeekArray($ary_data,$i=0,1,++$day,$week_time);
            } else {
                  $week_time[$weekarray[$key+$i]] =strtotime($ary_data['o_create_time_1']." +".($day+1)." day" );
                 return $this->WeekArray($ary_data,$i+1,0,++$day,$week_time);
            }
        }
    }


    public function SourceActivityPayCount(){
        $this->getSubNav(9,1,40);
        $ary_data = $this->_get();
        $ary_where = array();
        $week = array();
        if (!empty($ary_data['o_create_time_1'])) {
                $week_time = $this->WeekArray($ary_data);
                $ary_where['s_create_time']      =  array("BETWEEN", array($ary_data['o_create_time_1'], date('Y-m-d',strtotime($ary_data['o_create_time_1']." +7 day"))));
                $date = $ary_data['o_create_time_1'];
        } else {
            $date = date("Y-m-d",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")));
            $ary_where['s_create_time'] = array("BETWEEN", array($date, date('Y-m-d',strtotime($date." +7 day"))));
            $week_time = array(
                        'Monday'=> strtotime($date),
                        'Tuesday'=> strtotime($date." +1 day" ),
                        'Wednesday'=> strtotime($date." +2 day"),
                        'Thursday'=> strtotime($date." +3 day"),
                        'Friday'=> strtotime($date ." +4 day"),
                        'Saturday'=> strtotime($date ." +5 day"),
                        'Sunday'=> strtotime($date." +6 day"),
            );
        }
        if (!empty($ary_data['s_type']) &&  $ary_data['s_type'] != 'all') {
            $ary_where['s_type'] = $ary_data['s_type'];
        }
        if (!empty($ary_data['sp_code'])) {
            $ary_where['source'] = $ary_data['sp_code'];
        }
        $week = array_keys($week_time);
        $this->assign('week', json_encode($week));
        
        $ary_platfrom = D('SourcePlatform')->where(array('sp_default'=>0,'sp_stauts'=>1))->select();
        $this->assign('platfrom',$ary_platfrom);
        $ary_where['m_id'] = array('not in',array(25551,6017,6014,193,7339,3));
        $ary_where['s_status'] = array('in',array(2,3,4,5));
        $ary_members_office  =D('Source')->where($ary_where)->select();
        $ActivityPay = array();
        $ActivityPay_1 = array();
        $ActivityPay_2 = array();
        $ActivityApi = array();
        $ActivityApi_1 = array();
        $ActivityApi_2 = array();
        if(!empty($ary_members_office)){
                    foreach($ary_members_office as $v){
                            foreach ($week_time as $key=>$time){
                                    if(strtotime(date('Y-m-d',strtotime($v['s_create_time']))) == $time){  
                                                if (!empty($ary_data['s_type']) &&  $ary_data['s_type'] != 'all') {
                                                    if(($v['s_type'] == $ary_data['s_type'] && $v['s_status'] == 1 ))
                                                    {
                                                         $ActivityPay[$key] = $ActivityPay[$key] +1;
                                                    }
                                                    if($v['s_type'] == $ary_data['s_type'] && $v['s_status'] == 3 )
                                                    {
                                                         $ActivityPay_1[$key] = $ActivityPay_1[$key] +1;
                                                    }
                                                    if($v['s_type'] == $ary_data['s_type'] && $v['s_status'] == 4 )
                                                    {
                                                         $ActivityPay_2[$key] = $ActivityPay_1[$key] +1;
                                                    }
                                                    if($v['s_type'] == $ary_data['s_type'] && $v['s_status'] == 2 )
                                                    {
                                                         $ActivityApi[$key] = $ActivityPay_1[$key] +1;
                                                    }
                                                    if($v['s_type'] == $ary_data['s_type'] && $v['s_status'] == 5 )
                                                    {
                                                         $ActivityApi_1[$key] = $ActivityPay_1[$key] +1;
                                                    }
                                                    if($v['s_type'] == $ary_data['s_type'] && $v['s_status'] == 99 )
                                                    {
                                                         $ActivityApi_2[$key] = $ActivityPay_1[$key] +1;
                                                    }
                                                } else {
                                                    if(($v['s_type'] == 1 && $v['s_status'] == 4 )|| ($v['s_type'] == 1 && $v['s_status'] == 5 ) )
                                                    {
                                                         $ActivityPay[$key] = $ActivityPay[$key] +1;
                                                    }
                                                    if(($v['s_type'] == 2 && $v['s_status'] == 4 )|| ($v['s_type'] == 2 && $v['s_status'] == 5 ) )
                                                    {
                                                         $ActivityPay_1[$key] = $ActivityPay_1[$key] +1;
                                                    }
                                                    if(($v['s_type'] == 3 && $v['s_status'] == 4 )|| ($v['s_type'] == 3 && $v['s_status'] == 5 ) )
                                                    {
                                                         $ActivityPay_2[$key] = $ActivityPay_2[$key] +1;
                                                    }
                                                    if(($v['s_type'] == 4 && $v['s_status'] == 4 )|| ($v['s_type'] == 4 && $v['s_status'] == 5 ) )
                                                    {
                                                         $ActivityApi[$key] = $ActivityApi[$key] +1;
                                                    }
                                                    if(($v['s_type'] == 5 && $v['s_status'] == 4 )|| ($v['s_type'] == 5 && $v['s_status'] == 5 ) )
                                                    {
                                                         $ActivityApi_1[$key] = $ActivityApi_1[$key] +1;
                                                    }
                                                    if(($v['s_type'] == 6 && $v['s_status'] == 4 )|| ($v['s_type'] == 6 && $v['s_status'] == 5 ) )
                                                    {
                                                         $ActivityApi_2[$key] = $ActivityApi_2[$key] +1;
                                                    }
                                                }

                                    }
                            }
                    }
              //  print_r($ActivityPay_2);exit;
            if (!empty($ary_data['s_type']) &&  $ary_data['s_type'] != 'all') {
                $ActivityPay['name']   = '横幅点击';
                $ActivityPay_1['name'] = '支付宝点击未支付';
                $ActivityPay_2['name'] = '支付宝点击已支付';
                $ActivityApi['name']   = '微信点击未支付';
                $ActivityApi_1['name'] = '微信点击已支付';
                $ActivityApi_2['name'] = '点击取消';
                $title = json_encode(array('横幅点击','支付宝点击未支付','支付宝点击已支付','微信点击未支付','微信点击已支付','点击取消'));
            } else {
                $ActivityPay['name']   = '免费用户登录';
                $ActivityPay_1['name'] = '免费用户转换';
                $ActivityPay_2['name'] = '客户端右上角';
                $ActivityApi['name']   = '客户端界面横幅';
                $ActivityApi_1['name'] = '只转5页图片点击';
                $ActivityApi_2['name'] = '立即抢购点击';
                $title = json_encode(array('免费用户登录','免费用户转换','客户端右上角','客户端界面横幅','只转5页图片点击','立即抢购点击'));
            }
            $this->assign('title', $title);
            $json_pay_1 = json_encode(array(
                                            'name'=>$ActivityPay['name'],
                                            'type'=>'line',
                                            'stack'=>'总量',
                                            'itemStyle'=>array('normal'=>array('areaStyle'=>array('type'=>'default'))),
                                            'data'=>array(
                                                isset($ActivityPay[$week[0]])?$ActivityPay[$week[0]]:0,
                                                isset($ActivityPay[$week[1]])?$ActivityPay[$week[1]]:0,
                                                isset($ActivityPay[$week[2]])?$ActivityPay[$week[2]]:0,
                                                isset($ActivityPay[$week[3]])?$ActivityPay[$week[3]]:0,
                                                isset($ActivityPay[$week[4]])?$ActivityPay[$week[4]]:0,
                                                isset($ActivityPay[$week[5]])?$ActivityPay[$week[5]]:0,
                                                isset($ActivityPay[$week[6]])?$ActivityPay[$week[6]]:0
                                             )
                                    )
                            );
            $json_pay_2 = json_encode(array(
                                            'name'=>$ActivityPay_1['name'],
                                            'type'=>'line',
                                            'stack'=>'总量',
                                            'itemStyle'=>array('normal'=>array('areaStyle'=>array('type'=>'default'))),
                                            'data'=>array(
                                                isset($ActivityPay_1[$week[0]])?$ActivityPay_1[$week[0]]:0,
                                                isset($ActivityPay_1[$week[1]])?$ActivityPay_1[$week[1]]:0,
                                                isset($ActivityPay_1[$week[2]])?$ActivityPay_1[$week[2]]:0,
                                                isset($ActivityPay_1[$week[3]])?$ActivityPay_1[$week[3]]:0,
                                                isset($ActivityPay_1[$week[4]])?$ActivityPay_1[$week[4]]:0,
                                                isset($ActivityPay_1[$week[5]])?$ActivityPay_1[$week[5]]:0,
                                                isset($ActivityPay_1[$week[6]])?$ActivityPay_1[$week[6]]:0
                                            )
                                    )
                            );
            $json_pay_3 = json_encode(array(
                                            'name'=>$ActivityPay_2['name'],
                                            'type'=>'line',
                                            'stack'=>'总量',
                                            'itemStyle'=>array('normal'=>array('areaStyle'=>array('type'=>'default'))),
                                            'data'=>array(
                                                isset($ActivityPay_2[$week[0]])?$ActivityPay_2[$week[0]]:0,
                                                isset($ActivityPay_2[$week[1]])?$ActivityPay_2[$week[1]]:0,
                                                isset($ActivityPay_2[$week[2]])?$ActivityPay_2[$week[2]]:0,
                                                isset($ActivityPay_2[$week[3]])?$ActivityPay_2[$week[3]]:0,
                                                isset($ActivityPay_2[$week[4]])?$ActivityPay_2[$week[4]]:0,
                                                isset($ActivityPay_2[$week[5]])?$ActivityPay_2[$week[5]]:0,
                                                isset($ActivityPay_2[$week[6]])?$ActivityPay_2[$week[6]]:0
                                            )
                                    )
                            );
            $json_pay_4 = json_encode(array(
                                            'name'=>$ActivityApi['name'],
                                            'type'=>'line',
                                            'stack'=>'总量',
                                            'itemStyle'=>array('normal'=>array('areaStyle'=>array('type'=>'default'))),
                                            'data'=>array(
                                                isset($ActivityApi[$week[0]])?$ActivityApi[$week[0]]:0,
                                                isset($ActivityApi[$week[1]])?$ActivityApi[$week[1]]:0,
                                                isset($ActivityApi[$week[2]])?$ActivityApi[$week[2]]:0,
                                                isset($ActivityApi[$week[3]])?$ActivityApi[$week[3]]:0,
                                                isset($ActivityApi[$week[4]])?$ActivityApi[$week[4]]:0,
                                                isset($ActivityApi[$week[5]])?$ActivityApi[$week[5]]:0,
                                                isset($ActivityApi[$week[6]])?$ActivityApi[$week[6]]:0
                                            )
                                    )
                            );

            $json_pay_5 = json_encode(array(
                                            'name'=>$ActivityApi_1['name'],
                                            'type'=>'line',
                                            'stack'=>'总量',
                                            'itemStyle'=>array('normal'=>array('areaStyle'=>array('type'=>'default'))),
                                            'data'=>array(
                                                isset($ActivityApi_1[$week[0]])?$ActivityApi_1[$week[0]]:0,
                                                isset($ActivityApi_1[$week[1]])?$ActivityApi_1[$week[1]]:0,
                                                isset($ActivityApi_1[$week[2]])?$ActivityApi_1[$week[2]]:0,
                                                isset($ActivityApi_1[$week[3]])?$ActivityApi_1[$week[3]]:0,
                                                isset($ActivityApi_1[$week[4]])?$ActivityApi_1[$week[4]]:0,
                                                isset($ActivityApi_1[$week[5]])?$ActivityApi_1[$week[5]]:0,
                                                isset($ActivityApi_1[$week[6]])?$ActivityApi_1[$week[6]]:0
                                            )   
                                    )
                            );
            $json_pay_6 = json_encode(array(
                                            'name'=>$ActivityApi_2['name'],
                                            'type'=>'line',
                                            'stack'=>'总量',
                                            'itemStyle'=>array('normal'=>array('areaStyle'=>array('type'=>'default'))),
                                            'data'=>array(
                                                isset($ActivityApi_2[$week[0]])?$ActivityApi_2[$week[0]]:0,
                                                isset($ActivityApi_2[$week[1]])?$ActivityApi_2[$week[1]]:0,
                                                isset($ActivityApi_2[$week[2]])?$ActivityApi_2[$week[2]]:0,
                                                isset($ActivityApi_2[$week[3]])?$ActivityApi_2[$week[3]]:0,
                                                isset($ActivityApi_2[$week[4]])?$ActivityApi_2[$week[4]]:0,
                                                isset($ActivityApi_2[$week[5]])?$ActivityApi_2[$week[5]]:0,
                                                isset($ActivityApi_2[$week[6]])?$ActivityApi_2[$week[6]]:0
                                            )
                                    )
                            );
        }
        if (empty($ary_data['s_type'])) {
            $ary_data['s_type'] = 'all';
        }
        $this->assign('json_pay_1',$json_pay_1);
        $this->assign('json_pay_2',$json_pay_2);
        $this->assign('json_pay_3',$json_pay_3);
        $this->assign('json_pay_4',$json_pay_4);
        $this->assign('json_pay_5',$json_pay_5);
        $this->assign('json_pay_6',$json_pay_6);
        $this->assign('ary_data',$ary_data);
        $this->display();
    }




    /*
     * 会员地区分布饼图
     * @author  listen
     * @2013-06-06
     */
    public function membersAreaPie(){
        
         $this->getSubNav(9,0,60);
         $ary_members  =  D('Members')->field('cr_id')->where(array('m_status'=>1,'m_verify'=>2))->group('cr_id')->select();//COUNT(cr_id) AS count_cr_id,
         $json_data = array();
         $json_data_boy = array();
         $json_data_girl = array();
         //通过会员中最后一级id 找到上级的id数组
         if(!empty($ary_members)){
             foreach($ary_members as $k=>$v){
                 //$ary_address[] = D('CityRegion')->getFullAddressId($v['cr_id']);
                 $ary_addr_name = D('CityRegion')->getAddressName($v['cr_id']);
                 if(!empty($ary_addr_name)){
                        $boy = D('Members')->where(array('m_status'=>1,'m_verify'=>2,'m_sex'=>1,'cr_id'=>$v['cr_id']))->count();
                        $girl = D('Members')->where(array('m_status'=>1,'m_verify'=>2,'m_sex'=>0,'cr_id'=>$v['cr_id']))->count();
                        //array_push($json_data, array('name'=> str_replace('省', '', $ary_addr_name),'value'=>$v['count_cr_id']));
                        array_push($json_data_boy, array('name'=> str_replace('省', '', $ary_addr_name),'value'=>$boy));
                        array_push($json_data_girl, array('name'=> str_replace('省', '', $ary_addr_name),'value'=>$girl));
                 }
             }
         }
         //通过id数组找到地址名字，以省为单位
//         if(!empty($ary_address)){
//             foreach($ary_address as $k1=>$v1){
//                 $ary_temp_addr[] = $v1[1];
//                 $ary_addr_name[] = D('CityRegion')->getAddressName($v1[1]);
//                 
//             }
//         }
//         $ary_temp_datLst = array_count_values($ary_addr_name);
//         if(!empty($ary_temp_datLst)){
//            $int_sum = array_sum($ary_temp_datLst);
//             foreach($ary_temp_datLst as $k2=>$v2){
//              //  $ary_labLst[] = $k2; //会员分布在哪些省去数组
//                //$ary_datLst[] = round(10000*($v2/$int_sum))/100;//计算每个省里面占用会员的比例
//                array_push($json_data, array('name'=> str_replace('省', '', $k2),'value'=>round(10000*($v2/$int_sum))/100));
//             }
//         }
         //$ary_labLst = array_unique($ary_addr_name);
         //echo "<pre>";print_r($ary_datLst);exit;
         //获取颜色数组，根据省份的个数取几种
//         $ary_color  =  $obj_pie->roundColor(count($ary_labLst));
//         $image_file = $obj_pie->draw_img($ary_datLst,$ary_labLst,$ary_color);
         $json_data_object = json_encode($json_data);
         $this->assign('json_data',$json_data_object);
         $this->assign('json_data_boy',json_encode($json_data_boy));
         $this->assign('json_data_girl',json_encode($json_data_girl));
         $this->display();
         
    }
}

?>
