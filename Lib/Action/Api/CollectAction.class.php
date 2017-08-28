<?php

/* 
 * desc:演示地址 我的收藏接口 
 * author：wangpan
 * date：2016.6.16
 */
class CollectAction extends CommonAction {

    public function __construct(){
            parent::__construct();
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


    public function myCollect()
    {
        // http://www.xingyun.com:8080/Api/Collect/myCollect?token=dd11d73ecd604e79ca13a74b15cd9177&discount=1&hasGoods=0&category_id=1&pagesize=10&pageindex=1
       
        //请求方式： GET 
        // 请求参数： 
        // Action (固定) :favorite
        // Token:  凭证
        // discount: 0 （0，促销商品；1，全部商品）
        // hasGoods: 0 （0，有货商品；1，全部商品）
        // category_id: 1 （商品分类编号）
        //pagesize 每页显示多少条
        //pageindex 页码
        $ary_post = $this->_get();

        // if (empty($ary_post)) {
        //     output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        // }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        $ml_id = $this->get_user_level($m_id);
        //dump($ml_id);exit;
        $condition = array();
        $condition['m_id'] = $m_id;
        $member_info = M("Members")->where($condition)->find();
        //echo M("Members")->getlastsql();exit;
        //dump($member_info);exit;
        if($member_info){
            if(isset($ary_post["category_id"]) & $ary_post["category_id"]!=""){
                $category_id = $ary_post["category_id"];  //分类id
                $ids = $this->getCateIds($category_id);
                //dump($ids);exit;
                $category_name = $this->getName($category_id);
                $where['gc.gc_id'] = array('in',$ids);
            }
            if(isset($ary_post["discount"]) && $ary_post["discount"]!=""){
                $discount = $ary_post["discount"];
                if ($discount=="0") {//折扣
                    $where['g.reduction_price'] = '1';//降价促销
                }
            }
            if(isset($ary_post["hasGoods"]) && $ary_post["hasGoods"]!=""){    
                $hasGoods = $ary_post["hasGoods"]; 
                if ($hasGoods=="0") { //有货
                    $where['gp.pdt_stock'] = array('neq','0');
                    $where['g.g_on_sale'] = array('neq','2'); //2下架             
                }
            }
            if(isset($ary_post["pageindex"]) && $ary_post["pageindex"]!=""){
                $pageindex = $ary_post['pageindex'];
            }
            if(isset($ary_post["pagesize"]) && $ary_post["pagesize"]!=""){
                $pagesize = $ary_post['pagesize']; 
            }    

            $offset = ($pageindex-1) * $pagesize;//获取limit的第一个参数的值 offset ，假如第一页则为(1-1)*10=0,第二页为(2-1)*10=10。             (传入的页数-1) * 每页的数据 得到limit第一个参数的值
             //假如传入的页数参数 大于总页数，则显示错误信息$pagenum=ceil($total/$num);      //获得总页数 pagenum
            //$pagenum = ceil($count/$pagesize);
            //dump($pagenum);exit;
            // if($page_index>$pagenum || $page_index == 0){

            //         output_datas($result,array('error_code' =>305402,'reason'=>'传入页码不合理或超过总页数'));

            // }

            $where['cg.m_id'] = $token['member_id'];
            $where['pmlp.ml_id'] = $ml_id;    
            $where['g.g_on_sale'] = '1';//在架

            $mCollectGoods = D("CollectGoods");                
            $countWhere = [
                "m_id"=>$m_id,
            ];
            $mGoods = D("Goods");
            //获取已关注的商品id
            $collectGoodsInfo = $mCollectGoods->where($countWhere)->select();
            //dump($collectGoodsInfo);exit;
            $pdtSn = [];
            foreach($collectGoodsInfo as $value){
                $isRule = $mGoods->isRuleGoods($value['g_id']);
                $pdtWhere = [
                    "g_id"=>$value['g_id'],
                ];
                if($isRule){                
                    $ruleGoods = D("GoodsProductsTable")->where($pdtWhere)->field("min(pdt_min_num),pdt_sn")->find();
                    $pdtSn[] = $ruleGoods["pdt_sn"];
                }else{
                    $goodsPdtSn = D("GoodsProductsTable")->where($pdtWhere)->field("pdt_sn")->find();
                    $pdtSn[] = $goodsPdtSn["pdt_sn"];
                }
            }
            $strPdtSn = implode(",", $pdtSn);
            $where['gp.pdt_sn'] = ["IN",$strPdtSn];
            $ary_goods = $mGoods
                    ->alias('g')
                    ->field('gi.g_name,gi.g_price,g.reduction_price,gi.g_picture,gi.g_unit,gi.g_id,g.g_trade,gp.pdt_stock,gp.g_sn,pmlp.pmlp_price')
                    ->join('fx_collect_goods cg on cg.g_id = g.g_id')
                    ->join('fx_goods_info gi on gi.g_id = g.g_id')
                    ->join('fx_goods_products gp on gp.g_id = g.g_id') 
                    ->join('fx_product_member_level_price pmlp ON pmlp.pdt_id = gp.pdt_id')
                    ->join('fx_related_goods_category rgc ON rgc.g_id = g.g_id')
                    ->join('fx_goods_category gc ON gc.gc_id = rgc.gc_id')                    
                    ->where($where)
                    //->order('cg.add_time')
                    ->limit($offset . ',' . $pagesize)
                    ->select();             
            //dump($ary_goods);exit;     
            //echo M()->getlastsql();exit; 
            // if(!$ary_goods){
            //    // output_msg(null, array('error_code' => "405201", 'reason' => '您还未收藏任何商品')); 
            //     output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'您还未收藏任何商品'));

            // }
            foreach ($ary_goods as &$value) {

                $mGoodsProducts = D("GoodsProductsTable");
               
                $condition = [];
                $condition = [
                    "gp.g_sn"=>$value['g_sn'],
                    "pmlp.ml_id"=>$ml_id,
                ];
                $field = "max(pmlp_price) as maxPrice,min(pmlp_price) as minPrice";
                $goodsRuleInfo = $mGoodsProducts->alias("gp")->join("INNER JOIN fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")->where($condition)->field($field)->find();
                $mGoods = D("Goods");
                if($mGoods->isRuleGoods($value['g_sn'])){
                        $value['pmlp_price'] = sprintf('%0.2f',$goodsRuleInfo['minPrice']).'~'.sprintf('%0.2f',$goodsRuleInfo['maxPrice']);

                }else{
                    if($value['pmlp_price'] == '0.000'){
                        $value['pmlp_price'] = sprintf('%0.2f',$value['g_price']);
                    }else{
                        $value['pmlp_price'] = sprintf('%0.2f',$value['pmlp_price']);
                    }

                }  

                $thumbname = $this->thumbname($value['g_picture'],200,200);

                $value['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;
                //发货方式
                switch ($value['g_trade']) {
                    case '1' :
                        $value['g_trade'] = '保税';
                        break;
                    case '2' :
                        $value['g_trade'] = '直邮';
                        break;
                    // case '0' :
                    //     $value['g_trade'] = '普通';
                    //     break; 
                   default:
                   $value['g_trade'] = '普通';                              
                } 

            }
            $ary_goods = $this->more_array_unique($ary_goods);
            //dump($ary_goods);exit; 
            $ary_category = M('Goods')
                        ->field('rgc.gc_id,gc.gc_name')
                        ->alias('g')
                        ->join('fx_collect_goods cg on cg.g_id = g.g_id')
                        ->join('fx_goods_info gi on gi.g_id = g.g_id')
                        ->join('fx_goods_products gp on gp.g_id = g.g_id')
                        ->join('fx_product_member_level_price pmlp ON pmlp.pdt_id = gp.pdt_id')
                        ->join('fx_related_goods_category rgc ON rgc.g_id = g.g_id')
                        ->join('fx_goods_category gc ON gc.gc_id = rgc.gc_id')
                        ->where($where)
                        ->order()
                        ->select(); 
            //echo M()->getlastsql();exit;            
            //$ary_category = array_unique($ary_category); 
            //dump($ary_category);exit;           
            foreach ($ary_category as &$value) {
                $value['gc_id'] = $this->getNavPid($value['gc_id']);
                $value['gc_name'] = $this->getName($value['gc_id']);
            } 
            //$ary_category = array_unique($ary_category);  
            $ary_category = $this->more_array_unique($ary_category);                         
            //dump($ary_category);exit;  


        }
        if(empty($ary_goods))
        {
            $ary_goods =  array();
        }

        //output_datas(array('goodsList'=>$ary_goods),array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!'));
        output_datas(array('category'=>$ary_category,'goodsList'=>$ary_goods),array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!'));


    }

    public function more_array_unique($arr=array()){
        foreach($arr[0] as $k => $v){
            $arr_inner_key[]= $k;   //先把二维数组中的内层数组的键值记录在在一维数组中
        }
        foreach ($arr as $k => $v){
            $v =join(",",$v);    //降维 用implode()也行
            $temp[$k] =$v;      //保留原来的键值 $temp[]即为不保留原来键值
        }
        // printf("After split the array:<br>");
        // print_r($temp);    //输出拆分后的数组
        // echo"<br/>";
        $temp =array_unique($temp);    //去重：去掉重复的字符串
        foreach ($temp as $k => $v){
            $a = explode(",",$v);   //拆分后的重组 如：Array( [0] => james [1] => 30 )
            $arr_after[$k]= array_combine($arr_inner_key,$a);  //将原来的键与值重新合并
        }
        sort($arr_after);//排序如需要：ksort对数组进行排序(保留原键值key) ,sort为不保留key值
        return$arr_after;
    }


    //POST请求时使用
    //request_url:http://www.xingyun.com:8080/Api/Collect/test
    public function test(){

        $url = 'http://www.xingyun.com:8080/Api/Collect/save_collect';
        // $post_data['user_name'] = '13302907442';
        $post_data['g_id'] =   '[{"g_id":1928},{"g_id":1892}]';
        $post_data['type'] = '1';
        $post_data['token'] = '237c3e69bad23b0e0a56866fdb12faea';
        // $post_data['password'] = '11111111';
        // $post_data['category_id'] = '171';
        // $post_data['page_index'] = '1';
        // $post_data['page_size'] = '5';

        // $post_data['g_id'] = '607';
        $o = "";
        foreach ( $post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url, $post_data);       
        print_r($res);

    }


    // 请求方式：post
    // 请求参数：
    // Action ：save_collect（固定）
    // token= 凭证
    //g_id商品id
    // type ="0"       //0取消已收藏的商品；1：加入收藏
    public function save_collect(){

        $ary_post = $this->_post();

        // if (empty($ary_post)) {
        //     output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        // }
        $model_mb_user_token = D('MbUserToken');
        $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //dump($token);exit;
        if(!$token){
            output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        }
        $m_id = $token['member_id'];
        // $condition = array();
        // $condition['m_id'] = $m_id;
        // $member_info = M("Members")->where($condition)->find();
        $gId = json_decode($ary_post["g_id"],true);
        //dump($gId);exit;
        foreach($gId as $val){
            $ids[] = $val['g_id'];
        }
        $ids_str = implode(',', $ids);
        //dump($ids_str);exit;
        $mCollectGoods = M("CollectGoods");
        $where = array();
        $where['m_id'] = $m_id;
        $where['g_id'] = array('in',$ids_str);
        if($ary_post['type'] == "0"){//取消


            $updateStatus = $mCollectGoods->where($where)->delete();
            //echo $mCollectGoods->getLastSql();
            if (!$updateStatus) {
                output_datas(null,array('result' =>"1",'error_code' =>40003,'desc'=>'取消收藏失败！'));
            }
        
        }elseif($ary_post['type'] == "1"){//加入

                $ary_goods = M('Goods')->where(array('g_id'=>array('in',$ids_str)))->select();
                //dump($ary_goods);exit;               
                if(!empty($ary_goods) && is_array($ary_goods)){
                    $arr_collect = M('collect_goods',C('DB_PREFIX'),'DB_CUSTOM')->where($where)->select();
                    //dump($arr_collect);exit;
                    if(!empty($arr_collect) && is_array($arr_collect)){
                  
                        output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'收藏成功'));
                    }else{



                            foreach ($gId as $k => $v) {   //  循环保存每一条值
                                $map = array();
                                $map['g_id'] = $v['g_id'];
                                $map['m_id'] = $m_id;
                                $map['add_time'] = date('Y-m-d H:i:s');
                                $arr_res = M('collect_goods',C('DB_PREFIX'),'DB_CUSTOM')->add($map);
                            }


 
                       // echo M('collect_goods',C('DB_PREFIX'),'DB_CUSTOM')->getlastsql();exit;
                        if(!$arr_res){
                           
                            output_datas(null,array('result' =>"1",'error_code' =>40005,'desc'=>'加入收藏失败！'));
                        }
                     }
                }else{

                    output_datas(null,array('result' =>"1",'error_code' =>40006,'desc'=>'该商品不存在或者已经下架'));
                }


        }
        
          
        output_datas(null,array('result' =>"0",'error_code' =>0,'desc'=>'成功'));

    }



    //获取指定分类的父ID号
    public function getNavPid($id){
        $nav = M('GoodsCategory')->find($id);
        if($nav['gc_parent_id'] != 0){ return $this->getNavPid($nav['gc_parent_id']); }
        return $nav['gc_id'];
    }

    //获取指定分类的分类名
    public function getName($id){
        $nav = M('GoodsCategory')->find($id);
        return $nav['gc_name'];
    }

    //获取指定分类的所有子分类
    public function getCateIds($pid){
        $need_list = M('GoodsCategory')->where('gc_parent_id ='. $pid)->select();//获取到的一级分类 
       //dump($need_list);exit;
        $need_id_str = ''; //获取需要的子类id
        foreach($need_list as $val){
            $need_id[] = $val['gc_id'];
        } 
        $need_id_str = join(',', $need_id);

        $where = "gc_parent_id in ($need_id_str)";
        $products = M('GoodsCategory')->field('gc_id')->where($where)->select(); 
        foreach($products as $val){
            $need_ids[] = $val['gc_id'];
        } 
        $need_id_strs = join(',', $need_ids);                
        return $need_id_strs;
    }
        
    /**
     * 根据用戶名得到用戶id
     */
    public function get_user_id($user_name) {

        $map = array();
        $map['m_name'] = $user_name;
        $m_id = M('Members')->where($map)->getfield('m_id');
        return $m_id; 
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

	      
}//end of class
