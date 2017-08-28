<?php

/* 
 * desc:商品相关接口
 * author：wangpan 
 * date：2016-06-21
 * 演示地址:www.xingyun.com:8080/Api/Products/test
 * request_type:POST或GET
 */
class ProductsAction extends CommonAction {
    
    public function __construct(){
        parent::__construct();
    }

    //请求方式： GET  http://www.xingyun.com:8080/Api/Products/newProducts?token=237c3e69bad23b0e0a56866fdb12faea
    // 请求参数： 
    // Action (固定) :newProducts
    // Type:(1,往期上架；2，新品上架；3，即将上架)
    // Token:  凭证

    // 返回data
    public function newProducts(){


        $ary_post = $this->_get();

        // if (empty($ary_post['token'])) {
        //     output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        // }


        // $m_id = $token['member_id'];
        // $condition = array();
        // $condition['m_id'] = $m_id;
        // $member_info = M("Members")->field('ml_id')->where($condition)->find();   

        if(empty($ary_post['type']))
        {
            $ary_post['type'] = 2;
        }
        if ($ary_post['type'] == 1) {//假设今天是5.23，往期上架是,5.13-5.22；
           $timeRole = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -20day"));
           $time     = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -11day"));
        } elseif ($ary_post['type'] == 2) {//假设今天是5.23，新品上架是,5.23-5.29；
            // if( strtotime(date("Y-m-d H:i:s") . " +5day") > time()){
            //      $time  =  date("Y-m-d H:i:s");
              
            // }else{
                 $time =  date("Y-m-d H:i:s");
            // }
              $timeRole  = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -10day"));
      
        } else {
           // $timeRole = date("Y-m-d H:i:s", strtotime(date() . " +10day"));
           // $time     = date("Y-m-d H:i:s", strtotime(date() . " -10day"));

           // $art_where['g_on_sale'] = 2;//下架
           
        }
            // $data['future_time'] = date("Y-m-d", strtotime(date() . " +10day"));
            // $data['last_time'] =  date("Y-m-d", strtotime(date("Y-m-d H:i:s") . " -10day"));
            // $data['time'] = date("Y-m-d");

            //有token才能看到会员价格
            // if(!empty($ary_post['token'])){

                // if(!$token){
                //     output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
                // }
        //有token才能看到会员价格
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if($token == false || $ary_post['token'] == ""){
            $art_where['f.ml_id'] = '1';
        }else{
            $ml_id = $this->get_user_level($token['member_id']);//会员等级id
            //dump($ml_id);exit;
            $art_where['f.ml_id'] = $ml_id;                        
        } 


        $art_where ['a.x_create_time'] = array(
                array(
                    'ELT',
                    $time
                ),
                array(
                    'EGT',
                    $timeRole
                )
            );
   
        $art_where['a.g_new'] = 1;
        $art_where['a.g_on_sale'] = 1;//在架
        //dump($art_where);exit;
        // $ml_id = $member_info['ml_id'];
        //dump($ml_id);exit;
        // if ($ml_id < 4) {
        //     $pmlpWhere = "fx_product_member_level_price f ON f.pdt_id = e.pdt_id And f.ml_id=$ml_id";
        // }else{
        //     $pmlpWhere = "";
        // }

        //查询商品具体信息
       
        //$art_where['c.gc_parent_id'] = array('neq','0');
        $ary_goods_info = M('Goods')
                    ->alias('a')
                    ->field('c.g_id,c.g_price,c.g_picture,c.g_name,e.pdt_stock,d.n_name,f.pmlp_price')
                    ->join('fx_related_goods_category b on b.g_id = a.g_id')
                    ->join('fx_goods_info c on c.g_id = a.g_id')
                    ->join('fx_nationality d on d.n_id = a.n_id')
                    ->join("fx_goods_products e ON e.g_id = a.g_id")
                    ->join("fx_product_member_level_price f ON f.pdt_id = e.pdt_id")   
                    //->join($pmlpWhere) 
                    ->where($art_where)
                    ->group('a.g_id')
                    ->select();

        //echo M()->getLastSql();exit; 
        if(!$token){
            foreach ($ary_goods_info as $key=>$value) {
                $ary_goods_info[$key]['pmlp_price'] = '登录后可见';
                $ary_goods_info[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];

            }

            output_datas($ary_goods_info,array('result' =>"0",'error_code' =>'1','desc'=>'查询成功'));
        

        }


        foreach ($ary_goods_info as &$value) {

            if($value['pmlp_price'] == '0.000'){
                $value['pmlp_price'] = sprintf('%0.2f',$value['g_price']);
            }else{
                $value['pmlp_price'] = sprintf('%0.2f',$value['pmlp_price']);
            }

            $value['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];



        }                    
        //dump($ary_goods_info);
       //echo M("Goods")->getLastSql();exit;
        // if($ary_goods_info)  
        // {  
          //return $this->ajaxReturn($ary_goods_info,'查询成功!',1);
          output_datas($ary_goods_info,array('result' =>"0",'error_code' =>'0','desc'=>'查询成功!'));  
        // }else{  
          //return $this->ajaxReturn($ary_goods_info,"查询失败,数据不存在！",0);  
          //output_datas(null,array('result' =>"1",'error_code' =>10003,'desc'=>'查询失败,数据不存在！'));
        // } 

    }


    // 请求方式： GET   http://www.xingyun.com:8080/Api/Products/recommend?token=237c3e69bad23b0e0a56866fdb12faea
    // 请求参数： 
    // Action (固定) :recommend
    // Token:  凭证

    // 返回data
    public function recommend(){

        $ary_post = $this->_get();

        //有token才能看到会员价格
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if($token == false || $ary_post['token'] == ""){
            $art_where['f.ml_id'] = '1';
        }else{
            $ml_id = $this->get_user_level($token['member_id']);//会员等级id
            //dump($ml_id);exit;
            $art_where['f.ml_id'] = $ml_id;                        
        } 
        $art_where['b.g_on_sale'] = '1';//在架
        $int_sales_nums = M('GoodsInfo')
                    ->alias('a')
                    ->join('fx_goods b on b.g_id = a.g_id')
                    ->join('fx_goods_brand c on c.gb_id = b.gb_id')
                    ->join('fx_nationality d on d.n_id = b.n_id')
                    ->join("fx_goods_products e ON e.g_id = a.g_id") 
                    ->join("fx_product_member_level_price f ON f.pdt_id = e.pdt_id")         
                    ->field('a.g_salenum,a.g_id,a.g_name,a.g_price,a.g_picture,c.gb_detail,f.pmlp_price')
                    ->where($art_where)
                    ->group('a.g_id')
                    ->order('a.g_salenum DESC')
                    ->limit(10)
                    ->select();
        //echo M()->getLastSql();exit;            
        if(!$token){
            foreach ($int_sales_nums as $key=>$value) {
                $int_sales_nums[$key]['pmlp_price'] = '登录后可见';
                $int_sales_nums[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];

            }

            output_datas($int_sales_nums,array('result' =>"0",'error_code' =>'1','desc'=>'查询成功'));
        

        }

        foreach ($int_sales_nums as &$value) {
            
            if($value['pmlp_price'] == '0.000'){
                $value['pmlp_price'] = sprintf('%0.2f',$value['g_price']);
            }else{
                $value['pmlp_price'] = sprintf('%0.2f',$value['pmlp_price']);
            }

            $value['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];
  


        } 
        //dump($int_sales_nums);exit;
        output_datas($int_sales_nums,array('result' =>"0",'error_code' =>'0','desc'=>'查询成功!'));


    }


    // 请求方式：get http://www.xingyun.com:8080/Api/Products/get_attribute_option
    // 请求参数：
    // Action ：get_attribute_option   （固定）     
    // attribute_name: brand   （固定）
    // 返回data
    public function get_attribute_option(){

        $ary_post = $this->_get();
        //全部品牌
        $brandlist = M('GoodsBrand')       
                    ->field('gb_first_letter')
                    ->order('gb_first_letter ASC')
                    ->group('gb_first_letter')
                    ->limit()
                    ->select();

        
        //$new_brand = array();
        foreach($brandlist as $k => &$v){
           
            $ary_brand = M('GoodsBrand')
                        ->where(array(
                                    'gb_first_letter' => $v ['gb_first_letter']
                                ))
                        ->field('gb_id,gb_name,gb_logo')
                        ->select();
                        foreach ( $ary_brand as &$val) {
                                $val['gb_logo'] = 'http://'.$_SERVER['HTTP_HOST'].$val['gb_logo'];
                        }            
            $v['k'] = $v ['gb_first_letter'];
            $v['value'] = $ary_brand;           
            unset($v['gb_first_letter']);         
            // $new_brand[$k]['k'] = $v['gb_first_letter'];
            // $new_brand[$k]['value'] = $v;
        }
        //$new_brand = array_values($new_brand);
        
        //dump($brandlist);exit;
        //热门品牌
        $condition=array();
        $condition['gb_hot'] = '1';
        $hbrandlist = M('GoodsBrand')       
                    ->field('gb_id,gb_name,gb_logo')
                    ->order('rand()')
                    ->where($condition)
                    ->limit(8)
                    ->select();
        //dump($hbrandlist);exit;
        foreach ($hbrandlist as &$value) {
            $value['gb_logo'] = 'http://'.$_SERVER['HTTP_HOST'].$value['gb_logo'];

        } 



        output_datas(array('brand'=>$brandlist,'hotbrand'=>$hbrandlist),array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!'));
    }


    public function get_picture(){

       $ary_post = $this->_post();        
       $gids = json_decode($ary_post['g_id'],true);
       //dump($gids);exit;        
       //$gids_str = implode(',', $gids);
       //dump($gids_str);exit;
       //$condition = array();
       //$condition['g_id'] = array('in',$gids_str);
       //$where = "FIND_IN_SET(g_id, '$gids_str')";
       //$order_by = "find_in_set('g_id','$gids_str')";
       //$sql = "select * from fx_goods_info where FIND_IN_SET(g_id, '$gids_str')";

       for($i=0;$i<count($gids);$i++){
            $picture = M('GoodsInfo')->field('g_id,g_picture')->where(array('g_id'=>$gids[$i]))->find();
            $pictures[] = $picture;
       }

       //$pictures = M('GoodsInfo')->field('g_id,g_picture')->where($condition)->order($order_by)->select();
       //dump($pictures);exit;
       //dump($sql);exit;
       //echo M()->getLastSql();exit;
        foreach ($pictures as $key=>$value) {
            //$pictures[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];
            $pictures[$key]['g_picture'] = 'http://www.xyb2b.com'.$value['g_picture'];

        }
        output_datas($pictures,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!'));

    }




    // 请求方式： GET
    // 请求参数： 
    // Action (固定) : weiShopList
    // Type: 0 （0，上架商品列表；1，下架商品列表）
    // Token:  凭证

    // 返回data
    public function weiShopList(){

    }


    /**
     * 根据用戶id得到用戶会员等级
     */
    public function get_user_level($member_id) {

        $map = array();
        $map['m_id'] = $member_id;
        $ml_id = M('Members')->where($map)->getfield('ml_id');
        return $ml_id; 
    }

    public function test(){

        
        $url = 'http://www.xingyun.com:8080/Api/Products/get_picture';
        $post_data['g_id']='[618,846,1920,868,1630,588,1704,1892]';
        $post_data['mobile'] = '18825500151';
        $post_data['mobilecode'] = '4789';
        $post_data['password'] = '123456';
        $post_data['type'] = '101';
        $post_data['username'] = '18825500151';
        $post_data['birthday'] = '2016-05-20';
        $post_data['sex'] = '1';
        $post_data['email'] = '111@qq.com';
        $post_data['file'] = 'www.baidu.com';
        $post_data['token'] = '237c3e69bad23b0e0a56866fdb12faea';
        $post_data['order_amount'] = '0.01';
        $post_data['payment_id'] = '1';
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
