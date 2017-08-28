<?php

class AddressAction extends MobileAction {
    
        private $cityRegion;
        
        private $orders;
    /**
     * 地址控制器初始化
     */
    public function _initialize() {
        $this->orders = D('Orders');
        $this->cityRegion = D('CityRegion');
        $this->logistic = D('Logistic');
        $this->cart = D('Cart');
    }
    /**
     * 新增收货地址
     */
    public function addAddress(){
        
        $bool_return = false;
        $ary_post_data = $this->_post();
    //    print_r($ary_post_data);exit;
        $m_id = $this->member_info['m_id'];
        if (isset($ary_post_data ['del']) || $ary_post_data ['del'] == 'del') {
            // 删除
            $int_ra_id = $ary_post_data ['ra_id'];
            $bool_return = $this->cityRegion->doDelDeliver($int_ra_id);
        } else {
            // 添加
            if ($ary_post_data ['cr_id'] == 0) {
                if(empty($ary_post_data['region'])){
                   $ary_post_data['region']=$ary_post_data['city'];
                }
                $ary_post_data ['cr_id'] = $ary_post_data ['region'];
            }
                $ary_post_data ['ra_id_card']  = $ary_post_data['idno'];
                $ary_post_data ['ra_name']  = $ary_post_data['accept_name'];
                $ary_post_data ['ra_detail']  = $ary_post_data['address'];
                $ary_post_data ['ra_mobile_phone']  = $ary_post_data['mobile'];
                    if(!empty($ary_post_data['gb_logo_1']) && !empty($ary_post_data['gb_logo_2']))
                    {
                        $ary_post_data['CardFaceImg'] = D('ViewGoods')->ReplaceItemPicReal($ary_post_data['gb_logo_1']); 
                        $ary_post_data['CardOppositeImg'] = D('ViewGoods')->ReplaceItemPicReal($ary_post_data['gb_logo_2']);
                    }
                        //默认设为默认地址
			//$ary_post_data ['ra_is_default'] = '1';
			$bool_return = $this->cityRegion->addReceiveAddr($ary_post_data, $m_id);
                        $int_ra_id = $bool_return ['data'] ['ra_id'];
                        if($bool_return){
                            $newarr = array();
                            $newarr['result'] = '0';
                            $newarr['error_code'] = '0';
                            $newarr['desc'] = '地址新增成功！';
                            $newarr['data']['id'] = $int_ra_id;  //地址id  
                            $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);                            
                            echo $json;die;   

                              // output_datas(null,array('result' =>"0",'desc'=>'地址新增成功！'));
                        }else{
                              output_datas(null,array('result' =>"1",'desc'=>'地址添加失败'));
                        } 
        }
        
    }
    /*
     * 删除收货地址
     */
    public function delAddress(){
    
            $ary_post_data = $this->_post();
            $int_ra_id = $ary_post_data ['id'];
            $bool_return = $this->cityRegion->doDelDeliver($int_ra_id);
          if ($bool_return) {
               output_datas(null,array('result' =>"0",'desc'=>'地址删除成功！'));
            } else {
               output_datas(null,array('result' =>"1",'desc'=>'地址删除失败'));
            }
    }
    
    public function checkReciveAddr(){
        
            $ary_post_data = $this->_post();
            $int_ra_id = $ary_post_data ['id'];
            $bool_return = $this->cityRegion->checkReciveAddr($int_ra_id,$this->member_info['m_id']);
          if ($bool_return) {
               output_datas(null,array('result' =>"0",'desc'=>'地址设置默认成功！'));
            } else {
               output_datas(null,array('result' =>"1",'desc'=>'地址设置默认失败'));
            }
    }

    /**
     * 修改收货地址
     */
    public function ajaxUpdateAddr() {
        $ary_update_data = array();
        $ary_addr = $this->_post();
        $ary_update_data['ra_id'] = $ary_addr['id'];
        $ary_update_data['cr_id'] = $ary_addr['region'];
        $ary_update_data['ra_name'] = $ary_addr['accept_name'];
        $ary_update_data['ra_detail'] = $ary_addr['address'];
        $ary_update_data['ra_id_card'] = $ary_addr['idno'];
        $ary_update_data['ra_mobile_phone'] = $ary_addr['mobile'];
        $ary_update_data['ra_update_time'] = date('Y-m-d H:i:s');
        if(!empty($ary_addr['gb_logo_1']) && !empty($ary_addr['gb_logo_2']))
        {
            $ary_update_data['CardFaceImg'] = D('ViewGoods')->ReplaceItemPicReal($ary_addr['gb_logo_1']); 
            $ary_update_data['CardOppositeImg'] = D('ViewGoods')->ReplaceItemPicReal($ary_addr['gb_logo_2']);
        }
        $ary_return = $this->cityRegion->updateAddr($ary_update_data);
        $ary_data = $this->cityRegion->getReceivingAddress($this->member_info['m_id'],$ary_addr['id']);
        if($ary_data)
        {
            output_datas(null,array('result' =>"0",'desc'=>'地址修改成功！'));
        }
    }
    /*
     * 收货地址列表
     */
    public function ApiReceivingAddressPage(){
        
        $pids = $this->_request('p');	
        $ary_addr = $this->cityRegion->ApiReceivingAddressPage($this->member_info['m_id'],$pids);
        $ary_deliver = $ary_addr['addr'];
        foreach($ary_deliver as $key=>$val){
            $id_arr = $this->get_address_id($val['id']);
            $ary_deliver[$key]['province_id'] = $id_arr[1];
            $ary_deliver[$key]['city_id'] = $id_arr[2];
            $ary_deliver[$key]['state_id'] = $id_arr[3];   

        }
        //dump($ary_deliver);exit;
        if(empty($ary_deliver))
        {
            $ary_deliver = array();
        }
        output_datas($ary_deliver,array('result' =>"0",'desc'=>'查询成功！'));
        
    }
 

    //根据ra_id获取省、市、区id的数组
    public function get_address_id($ra_id){

        $ReceiveAddress = M('ReceiveAddress')
        ->alias('ra')
        ->field('cr.cr_path,ra.cr_id')
        ->join('fx_city_region cr on cr.cr_id = ra.cr_id')
        ->where(array('ra.ra_id'=>$ra_id))
        ->find();
        //dump($ReceiveAddress);exit;
        $id_arr = explode('|', $ReceiveAddress['cr_path']);
        $id_arr[] = $ReceiveAddress['cr_id'];
        //dump($id_arr);exit;

        return $id_arr;

    }
    
}
