<?php

/* 
 * @athour wangpan 2016.06.25
 * 商品基本类
 * and open the template in the editor.
 */
class GoodsAction extends CommonAction {
    
    // URL:
    // http://www.xingyun.com:8080/Api/Goods/goods_show?token=237c3e69bad23b0e0a56866fdb12faea&goodsid=104
    // 请求方式：get
    // 请求参数：
    // Action ：goods_show   （固定）   
    // goodsid : 商品ID
    // token : token  (可选)
    // 返回data
    public function goods_show(){//TODO:$specifications数组 取商品信息表?待定……


        $ary_post = $this->_get();

            
        if(empty($ary_post['goodsid'])){

            output_datas(null,array('result' =>"1",'error_code' =>40008,'desc'=>'商品id为空'));
        }else{
            //获取到商品类型用到的所有属性
            $obj = M('goods as `g` ', C('DB_PREFIX'), 'DB_CUSTOM');
            //join查询
            $join_where = array();
            $ary_where = array();
            $join_where[] = '`fx_goods_info` `gi` on(`g`.`g_id` = `gi`.`g_id`)';
            $join_where[] = '`fx_goods_type` `gt` on(`g`.`gt_id` = `gt`.`gt_id`)';
            $join_where[] = '`fx_nationality` `na` on(`g`.`country_origin` = `na`.`n_id`)';
            $join_where[] = '`fx_related_goods_category` `rgc` on(`g`.`g_id` = `rgc`.`g_id`)';
            $join_where[] = '`fx_goods_category` `gc` on(`rgc`.`gc_id` = `gc`.`gc_id`)';
            $join_where[] = '`fx_goods_brand` `gb` on(`gb`.`gb_id` = `g`.`gb_id`)';
            $ary_where['g.g_id'] = $ary_post['goodsid'];
            $ary_where['g.g_on_sale'] = '1';//在架
            $ary_where['g.g_status'] = '1';//0为废弃，1为有效，2为进入回收站'
            $ary_where['g.authority_goods'] = '1';//不是奢侈品
            //有token才能看到会员价格
            $model_mb_user_token = D('MbUserToken');
            $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
            if($token == false || $ary_post['token'] == ""){
                $ary_where['pmlp.ml_id'] = '3';
            }else{
                $ml_id = $this->get_user_level($token['member_id']);//会员等级id
                //dump($ml_id);exit;
                $ary_where['pmlp.ml_id'] = $ml_id;                        
            } 

            //查询字段
            $ary_fields = "gp.pdt_id,gp.pdt_min_num,g.g_id,g.g_trade,g.number_least,g.g_on_sale,g.sales_goods,g.carriage_temp_id,gb.gb_name,gi.g_name,gi.g_cname,gi.extension_spec,gi.g_picture,gi.g_weight,gi.g_unit,gi.g_salenum,gi.g_price,na.n_name,na.n_pic,gp.g_sn,gp.pdt_stock,pmlp.pmlp_price,rgc.gc_id,gc.gc_name,gi.g_desc,g.shelf_time,g.shelf_time_end,wh.c_name";

            $result = $obj->field($ary_fields)
            ->join($join_where)
            ->join("fx_goods_products as gp ON gp.g_id = g.g_id")
            ->join("fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")
            //->join('fx_collect_goods cg on cg.g_id = g.g_id')
            ->join('fx_warehouses wh on wh.c_id = g.g_point_origin')
            ->where($ary_where)
            ->order()
            ->find(); 
            //echo M()->getlastsql();exit;           
            if(empty($result)){

               output_datas(null,array('result' =>"1",'error_code' =>40006,'desc'=>'商品不存在或者已下架'));
            }
            switch ($result['g_trade']) {
                case '1' :
                    $g_trade = '保税';
                    break;
                case '2' :
                    $g_trade = '直邮';
                    break;
                case '0' :
                    $g_trade = '普通';
                    break;                              
            }                       
            //echo $obj->getlastsql();exit;
            //dump($result);exit;
            // if(empty($result['isbookmark'])){//是否已收藏
            //     $result['isbookmark'] = 'false';
            // }else{
            //     $result['isbookmark'] = 'true';
            // }

            //关注商品后空心/红心的状态
            $arr_collect = M('collect_goods',C('DB_PREFIX'),'DB_CUSTOM')->where(array("m_id"=>$token['member_id'],"g_id"=>$ary_post['goodsid']))->find();
            //dump($arr_collect);exit;
            if($arr_collect){
                $result['isbookmark'] = 'true';
            }else{
                $result['isbookmark'] = 'false';
            }
            //dump($result);exit;

         //    if($token){

         //        $result['pmlp_price'] = sprintf("%.2f", $result['pmlp_price']); // 运行结果：$43.20
	        // }else{    
	        //     $result['pmlp_price'] = '登录后可见';        
	        // } 
            //现在是"0000-00-00 00:00:00",转换时间格式如2013.02.13
            if($result['shelf_time']==="0000-00-00 00:00:00"){
                  $result['shelf_time'] = "";
            }else{
                  $result['shelf_time'] = date('Y.m.d' ,strtotime($result['shelf_time']));
            }
            if($result['shelf_time_end']==="0000-00-00 00:00:00"){
                  $result['shelf_time_end'] = "";
            }else{
                  $result['shelf_time_end'] = date('Y.m.d' ,strtotime($result['shelf_time_end']));
            }            

            //$result['shelf_time_end'] = date('Y.m.d' ,strtotime($result['shelf_time_end']));
            //dump($result['shelf_time_end']);exit;
            
	        $result['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$result['g_picture']; 
            $result['n_pic'] = 'http://'.$_SERVER['HTTP_HOST'].$result['n_pic']; 
            //  会员价格数组
            $condition = array();
            $condition['g.g_id'] = $ary_post['goodsid'];
            $group_price = M('Goods')
                        ->alias('g')
                        ->field('ml.ml_name,pmlp.pmlp_price,g.g_id')
                        ->join('fx_goods_products gp on gp.g_id = g.g_id')
                        ->join('fx_product_member_level_price pmlp on pmlp.pdt_id = gp.pdt_id')
                        ->join('fx_members_level ml on ml.ml_id = pmlp.ml_id')
                        ->where($condition)
                        ->select();
            //dump($group_price);exit;            
            $result['group_price'] = $group_price;             

            //图片数组gi.g_desc
            
            $str = $this->_strip_tags(array("p", "br"),$result['g_desc']); //去掉 p 标签和 br 标签 
            //dump($str);exit;
            $reg="/\"\/[^\"]*\"/";
            preg_match_all ($reg,$str,$matches);

            //dump($matches[0]);exit;
            foreach($matches[0] as $k=>&$v){

                $v = ltrim($v,'"');
                $v = 'http://'.$_SERVER['HTTP_HOST'].$v;
                $v = rtrim($v,'"');
                
            }
            //dump($matches[0]);exit;
            $result['contents'] = $matches[0];
            unset($result['g_desc']);
            //$specifications数组
              // "原产地": "德国", n_name
              // "品牌": "爱他美 Aptamil", gb_name
              // "单位": "罐", g_unit
              // "保存方法": "干燥常温",
              // "适用人群": "婴幼儿",
              // "段位": "Pre段",    extension_spec
              // "发货地": "保税区" g_trade
            if(empty($result['c_name'])){//发货仓
                $result['c_name'] = "其他仓";
            }

        
            $tmp_relatedgoods = D('Gyfx')->selectOneCache('goods','g_related_goods_ids', array('g_id'=>$ary_post['goodsid']));
            //dump($tmp_relatedgoods);exit;
            $relatedgoods = $tmp_relatedgoods['g_related_goods_ids'];

            $relatedgoods = trim($relatedgoods,",");

            $where = array();

            $where['gi.g_id'] = array('in',$relatedgoods);
            $ary_relate_goods = M('GoodsInfo')
                                ->alias('gi')
                                ->field('gi.g_id,gi.g_picture,gi.extension_spec,gp.pdt_stock')
                                ->join('fx_goods_products gp on gp.g_id = gi.g_id')
                                ->group('gi.g_id')
                                ->where($where)
                                ->select();
            if(empty($ary_relate_goods)){
                $ary_relate_goods = array();
            }         
            // $ary_relate_goods = D("Gyfx")->selectAllCache('goods_info','g_id,g_picture,extension_spec',$where,'extension_ordey asc',null, null);
            //dump($ary_relate_goods);exit;
            foreach($ary_relate_goods as $key=>$value){
                $thumbname = $this->thumbname($value['g_picture'],200,200);
                $ary_relate_goods[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;//图片加域名
            }
            //起发数和每个起发数对应的当前会员价
            $starting_number = M('Goods')
                        ->alias('g')
                        ->field('gp.pdt_id,gp.pdt_min_num,gp.pdt_max_num,gp.pdt_stock,pmlp.pmlp_price,gi.g_price')
                        ->join('fx_goods_info gi on gi.g_id = g.g_id')
                        ->join('fx_goods_products gp on gp.g_id = g.g_id')
                        ->join('fx_product_member_level_price pmlp on pmlp.pdt_id = gp.pdt_id')
                        ->join('fx_members_level ml on ml.ml_id = pmlp.ml_id')
                        ->where($ary_where)
                        ->select();            
            //dump($starting_number);exit;            
            foreach($starting_number as $key=>$value){
                if(!$token){
                    $starting_number[$key]['pmlp_price'] = '登录后可见';    
                }else{
                    if($value['pmlp_price'] == '0.000'){
                        $starting_number[$key]['pmlp_price'] = sprintf('%0.2f',$value['g_price']);//价格保留两位小数
                    }else{
                        $starting_number[$key]['pmlp_price'] = sprintf('%0.2f',$value['pmlp_price']);//价格保留两位小数
                    }
                    
                }

            }            
            //1全国包邮 2. 全国不包邮 3 部分包邮

            if($result['carriage_temp_id']){//如果goods表的carriage_temp_id有值
                //先查母模板  
                $carriage =  M('carriage_template',C('DB_PREFIX'),'DB_CUSTOM')->where(array("id"=>$result['carriage_temp_id']))->find();
                //dump($carriage['default_first_price']);exit;
                if($carriage['default_first_price']==0 && $carriage['default_second_price']==0 ){//母模板运费为0
                      $carriage_temp =  M('carriage_template_son',C('DB_PREFIX'),'DB_CUSTOM')->where(array("father_id"=>$result['carriage_temp_id']))->select();                    
                      if($carriage_temp){//有子模板
                             $carriage_temp_id = 3;//部分包邮
                             $ship_to  =  '';
                             foreach ($carriage_temp as $temp) 
                             {
                                $ship_to .= trim($temp['ship_to'])." ";
                             }
                             $data['ship_to'] = $ship_to;

                             $cr_name  =  str_replace( ' ', ',',trim($data['ship_to']));
                             //部分不包邮地区
                             $data_not_name =  D('CityRegion')->field('cr_id,cr_name')->where(array("cr_name"=>array("in",$cr_name),'cr_parent_id'=>1,'cr_status'=>1))->order('convert(cr_name using gb2312) asc')->select();
                             // foreach ($data_not_name as $dnn => $dnnv) {
                             //     $part_no_free_district['cr_id'][] = $dnnv['cr_id'];
                             //     $part_no_free_district['cr_name'][] = $dnnv['cr_name'];

                             // }
                             //dump($part_no_free_district);exit;                     
                             //部分包邮地区
                             $data_name =  D('CityRegion')->field('cr_id,cr_name')->where(array("cr_name"=>array("not in",$cr_name),'cr_parent_id'=>1,'cr_status'=>1))->order('convert(cr_name using gb2312) asc')->select();
                             // foreach ($data_name as $dn => $dnv) {
                             //     $part_free_district['cr_id'][] = $dnv['cr_id'];
                             //     $part_free_district['cr_name'][] = $dnv['cr_name'];
                             // }
                             //dump($part_free_district);exit;  


                      }else{
                            $carriage_temp_id = 1;//全国包邮
                      }

                }else{//母模板运费不为0
                     $carriage_temp_id = 2;//全国不包邮   
                }
             }else{//goods表的carriage_temp_id没有值
                    $carriage_temp_id = 1;//全国包邮
             }   
            //dump($carriage_temp_id);exit;
            $carriage_status = array();
            $carriage_status['id'] = $carriage_temp_id;
            $carriage_status['part_no_free_district'] = $data_not_name;
            $carriage_status['part_free_district'] = $data_name;
            $carriage_status = array_filter($carriage_status);
            //dump($carriage_status);exit;
            $result['carriage_status'] = $carriage_status;
            //获取商品SKU详细资料
            // $array_products = M("GoodsProducts")
            // ->alias('gp')
            // ->field('gs.gs_name,rgs.gsd_aliases')
            // ->where(array("gp.g_id"=>$ary_post['goodsid']))
            // ->join('fx_related_goods_spec rgs on rgs.pdt_id = gp.pdt_id')
            // ->join('fx_goods_spec gs on gs.gs_id = rgs.gs_id')
            // ->order("gp.pdt_id asc")
            // ->select();
            //dump($array_products);exit;
            // foreach($array_products as $val){
            //     if(empty($val['gs_name'])){
            //         $val['gs_name'] = "";
            //     }
            //     if(empty($val['gsd_aliases'])){
            //         $val['gsd_aliases'] = "";
            //     }


            // }
            // 因为规格表里好多字段弃用了，所以暂时取商品基本信息表里的字段(固定)
            $specifications = array();
            $specifications[0]['品牌名称'] = $result['gb_name'];
            $specifications[1]['原产地'] = $result['n_name'];
            $specifications[2]['单位'] = $result['g_unit'];
            $specifications[3]['发货地'] = $result['c_name'];
            $specifications[4]['属性'] = $result['extension_spec'];
            //dump($specifications);exit; 
            $result['rules'] = $ary_relate_goods;
            $result['specifications'] = $specifications;
            $result['starting_number'] = $starting_number;
            // if($token){

            //     $result['pmlp_price'] = sprintf("%.2f", $result['pmlp_price']); // 运行结果：$43.20
            // }else{    
            //     $result['pmlp_price'] = '登录后可见';
            //     $result['isbookmark'] = 'false';//收藏不可见
            //     output_datas($result,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));        
            // } 
            if(!$token){

                $result['pmlp_price'] = '登录后可见';
                $result['isbookmark'] = 'false';//收藏不可见
                output_datas($result,array('result' =>"0",'error_code' =>'1','desc'=>'查询成功'));
            

            }else{

                if($result['pmlp_price'] == '0.000'){
                    $result['pmlp_price'] = sprintf('%0.2f',$result['g_price']);
                }else{
                    $result['pmlp_price'] = sprintf('%0.2f',$result['pmlp_price']);
                }
     
            }


	        //output_datas($result,array('error_code' =>0,'reason'=>'成功'));
	        output_datas($result,array('result' =>"0",'error_code' =>'0','desc'=>'查询成功!'));


        }

        
    }


    //     url :  http://www.xingyun.com:8080/Api/Goods/hot_key?token=237c3e69bad23b0e0a56866fdb12faea
    // 请求方式： get
    // 请求参数： 
    // Action : hot_key (固定)
    // Token:  凭证  （可选）
    // 返回data 
    public function hot_key(){

        $ary_post = $this->_get();

        // if (empty($ary_post)) {
        //     output_datas(null,array('result' =>"1",'error_code' =>10002,'desc'=>'请求失败，请检查参数是否有误'));
        // }
        // if((isset($ary_post['token']))&&$ary_post['token']!=""){
        //     $model_mb_user_token = D('MbUserToken');
        //     $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
        //     if(!$token){
        //         output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
        //     }
        // }
        // $m_id = $token['member_id'];
        // $condition = array();
        // $condition['m_id'] = $m_id;
        // $member_info = M("Members")->where($condition)->find();
        $keyword = M('keyword',C('DB_PREFIX'),'DB_CUSTOM');
        $where = array();
        $klist = $keyword->field('k.k_title,gc.gc_name,gc.gc_id')
                        ->alias('k')
                        ->join('fx_goods_category gc on gc.gc_id = k.gc_id')    
                        ->where($where)
                        ->order('k.k_update_time desc')
                        ->limit(3)
                        ->select();
        output_datas($klist,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!'));

    }



    // url： http://www.xingyun.com:8080/Api/Goods/search_key?kw=奶
    // Action : search_key
    // kw: 要搜索的词 
    // 返回data 
    public function search_key(){//搜索词提示，返回搜索词和对应的分类id
        $ary_post = $this->_get();


            $ary_where = array();
      
            $ary_where['gc_name'] = array('like','%'.$ary_post['kw'].'%');

            $result = M('GoodsCategory')
            ->field('gc_name')
            ->where($ary_where)
            ->order()
            ->select();
            foreach($result as $val){
                $name[] = $val['gc_name'];
            }
             //dump($name);exit;
            //echo M('GoodsCategory')->getlastsql();exit;
            //dump($result);exit;
            $ary_where1 = array();
      
            $ary_where1['gb_name'] = array('like','%'.$ary_post['kw'].'%');

            $result1 = M('GoodsBrand')
            ->field('gb_name')
            ->where($ary_where1)
            ->order()
            ->select();
            foreach($result1 as $val1){
                $name[] = $val1['gb_name'];
            }            
            //dump($name1);exit;
            $ary_where2 = array();
      
            $ary_where2['n_name'] = array('like','%'.$ary_post['kw'].'%');

            $result2 = M('Nationality')
            ->field('n_name')
            ->where($ary_where2)
            ->order()
            ->select();
            //dump($result2);exit;
            foreach($result2 as $val2){
                $name[] = $val2['n_name'];
            }            

            $newArr=array_map(function ($v){return array('keyword'=>$v);},$name);
            //dump($newArr);exit;
            if(empty($newArr)){
                $newArr = array();
            }
        



        output_datas($newArr,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功'));






    }




    // url :  http://www.xingyun.com:8080/Api/Goods/get_category_child_list?parent_id=0
    // Action ：get_category_child_list   （固定）                             
    // parent_id：0         //父级ID
    // count ：6                // 要取的直接子数据的行数

    // 返回data 
    public function get_category_child_list(){

        $ary_post = $this->_get();


        $obj = M('goods_category', C('DB_PREFIX'), 'DB_CUSTOM');
        //$ary_where['gc_id'] = array('neq','297');//奢侈品分类id  测试服297  正式服400
        $ary_where['gc_id'] = array('not in','297,8');//服饰鞋包分类id  测试服8  正式服8
        if($ary_post['parent_id'] == 0){//0下面是一级分类，5大类
            //$ary_where = "";
            $ary_where['gc_parent_id'] = 0;

        }else{

            // $ids = $this->getCateIds($ary_post['parent_id']);

            // $ary_where['gc_id'] = array('in',$ids);
            $ary_where['gc_parent_id'] = $ary_post['parent_id'];


        }

        //查询字段
        $ary_fields = "gc_id,gc_name";
        if($ary_post['childCount']){
            $childCount = $ary_post['childCount'];
        }else{
            $childCount = "";
        }
        $ary_category = $obj->field($ary_fields)    
        ->where($ary_where)
        ->order('gc_id ASC')
        ->select();
        //dump($ary_category);exit; 
        foreach($ary_category as &$value){

            $child_ids = M('GoodsCategory')->field('gc_id,gc_name')->where('gc_parent_id ='. $value['gc_id'])->limit($childCount)->select(); 
            //如果数组为空，不返回null而是[],防止app端崩溃
            if(empty($child_ids)){
    
                $child_ids = array();
            }
            //把$child_ids数组存到$ary_category里面
            $value['childList'] = $child_ids;
         }

        //dump($ary_category);exit;   
        output_datas($ary_category,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!'));


    }


    // 请求方式：get
    // url：http://www.xingyun.com:8080/Api/Goods/get_goods_list?category_id=0&pagesize=50&pageindex=1&origin_of_goods=NLD&order=_price&token=237c3e69bad23b0e0a56866fdb12faea
    // Action ：get_goods_list   （固定）
    // category_id= 类别ID
    // pagesize= 每页返回商品数量
    // pageindex= 取第几页
    // order=排序类型 （asc,desc）
    // order_filed =要排序的字段  (sort_price 按价格排序, sort_gain 按利润排序,vol 按销量排序)
    // 筛选参数:品牌brand，原产地origin_of_goods，分类
    // 返回data 
    // 格式:  totalcount:商品总数 ，goodslist：商品列表
    // goodsid:商品ID,img_url:图片URL,
    // stock_quantity:库存
    // title : title
    // vol:销售数
    // origin_img_url:国旗图标地址
    // good_country:英国品牌
    // price :价格
    // delivery_place : 发货地
    // good_type:商品类型（完税、保税，海外）
    public function get_goods_list(){

        $ary_post = $this->_get();



        // if((!isset($ary_post['category_id'])) || $ary_post['category_id'] ==""){
            
        //     output_datas(null,array('error_code' =>305301,'reason'=>'分类id为空'));
        // }else{
            //获取到商品类型用到的所有属性
            $obj = M('goods as `g` ', C('DB_PREFIX'), 'DB_CUSTOM');
            //join查询
            $join_where = array();
            $ary_where = array();
            $join_where[] = '`fx_goods_info` `gi` on(`g`.`g_id` = `gi`.`g_id`)';
            $join_where[] = '`fx_goods_type` `gt` on(`g`.`gt_id` = `gt`.`gt_id`)';
            $join_where[] = '`fx_nationality` `na` on(`g`.`country_origin` = `na`.`n_id`)';
            $join_where[] = '`fx_related_goods_category` `rgc` on(`g`.`g_id` = `rgc`.`g_id`)';
            $join_where[] = '`fx_goods_category` `gc` on(`rgc`.`gc_id` = `gc`.`gc_id`)';
            $join_where[] = '`fx_goods_brand` `gb` on(`gb`.`gb_id` = `g`.`gb_id`)';
            
            //如果请求分类id为0，获取全部
            if($ary_post['category_id'] == 0){
                $ary_where = "";
            }else{

            $ids = $this->getCateIds($ary_post['category_id']);
            //dump($ids);exit;
            //$category_name = $this->getName($category_id);
            $ary_where['gc.gc_id'] = array('in',$ids);

            }
            //根据参数筛选
            if($ary_post["brand"]){
               //$ary_where['gb.gb_name'] = array('like', "%" . trim($ary_post["brand"]) . "%");//
               $ary_where['gb.gb_id'] = $ary_post["brand"];//brand=2
            }
            if($ary_post["origin_of_goods"]){
               $ary_where['na.code'] = $ary_post["origin_of_goods"]; 
            }
            if($ary_post["keyword"]){
               $ary_where['_string'] = " g.g_sn like '%".$ary_post["keyword"]."%' or gi.g_name like '%".$ary_post["keyword"]."%' "; 
            } 
            //有token才能看到会员价格
            // if(!empty($ary_post['token'])){

                // if(!$token){
                //     output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
                // }
               
            $model_mb_user_token = D('MbUserToken');
            $token = $model_mb_user_token->getMbUserTokenInfoByToken($ary_post['token']);
            $ml_id = $this->get_user_level($token['member_id']);//会员等级id
                //dump($ml_id);exit;
            // if($token == false || $ary_post['token'] == ""){
            //     $ary_where['pmlp.ml_id'] = '1';
            // }else{
            //     $ml_id = $this->get_user_level($token['member_id']);//会员等级id
            //     //dump($ml_id);exit;
            //     $ary_where['pmlp.ml_id'] = $ml_id;                        
            // }

            // if(!$token){
            //     output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
            // }   

            if($token == false || $ary_post['token'] == ""){
                if($ary_post["order"]){  
                    switch ($ary_post["order"]) {

                        case 'price':
                            // if($ml_id == '4'){
                            //     $order_by = 'gi.g_price asc,g.g_order desc';
                            // }else{
                                $order_by = 'gi.g_price asc,g.g_order desc';
                            // }  
                            break;
                        case '_price':
                            // if($ml_id == '4'){
                            //     $order_by = 'gi.g_price desc,g.g_order desc';
                            // }else{
                                $order_by = 'gi.g_price desc,g.g_order desc';
                            // }                              
                            break;
                        case 'gnum':
                            $order_by = 'gi.g_salenum asc,g.g_order desc';
                            break;
                        case '_gnum':
                            $order_by = 'gi.g_salenum desc,g.g_order desc';
                            break;
                        default:
                            $order_by = array('g.g_order'=>'desc','gi.`g_update_time`'=>'desc');                
                                   
                    }            
                }

            }else{
                if($ary_post["order"]){  
                    switch ($ary_post["order"]) {

                        case 'price':
                            // if($ml_id == '4'){
                            //     $order_by = 'gi.g_price asc,g.g_order desc';
                            // }else{
                                $order_by = 'pmlp.pmlp_price asc,g.g_order desc';
                            // }  
                            break;
                        case '_price':
                            // if($ml_id == '4'){
                            //     $order_by = 'gi.g_price desc,g.g_order desc';
                            // }else{
                                $order_by = 'pmlp.pmlp_price desc,g.g_order desc';
                            // }                              
                            break;
                        case 'gnum':
                            $order_by = 'gi.g_salenum asc,g.g_order desc';
                            break;
                        case '_gnum':
                            $order_by = 'gi.g_salenum desc,g.g_order desc';
                            break;
                        default:
                            $order_by = array('g.g_order'=>'desc','gi.`g_update_time`'=>'desc');                
                                   
                    }            
                }

                $ary_where['pmlp.ml_id'] = $ml_id;  

            } 

            if($ary_post["haveStock"]){  
                if ($ary_post["haveStock"] == '1') {
                      $ary_where['gp.pdt_stock'] = array('GT',0);//有货
                }            
            }

            $ary_where['g.g_on_sale'] = '1';//在架
            $ary_where['g.g_status'] = '1';//0为废弃，1为有效，2为进入回收站' 
            $ary_where['g.authority_goods'] = '1';//不是奢侈品
            //查询字段
            $ary_fields = "g.g_id,g.g_trade,g.number_least,g.g_on_sale,g.sales_goods,gb.gb_name,g.g_update_time,gi.g_name,gi.g_cname,gi.extension_spec,gi.g_price,gi.g_market_price,gi.g_picture,gi.g_weight,gi.g_unit,gi.g_salenum,pmlp.pmlp_price,na.n_name,na.n_pic,gp.g_sn,gp.pdt_stock,gp.pdt_id,gp.pdt_min_num,rgc.gc_id,gc.gc_name";
      

            //必传参数
            if($ary_post['pageindex']){
                $pageindex = $ary_post['pageindex'];
            }
            if($ary_post['pagesize']){
                $pagesize = $ary_post['pagesize']; 
            }    

            $offset = ($pageindex-1) * $pagesize;

            $result = $obj->field($ary_fields)
            ->join($join_where)
            ->join("fx_goods_products as gp ON gp.g_id = g.g_id")
            ->join("fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")                
            ->where($ary_where)
            ->order($order_by)
            ->group('g.g_id')//由于多个起发数价格对应多个pdt_id,而联表的字段却是商品g_id，所以商品有几个起发数价格就会对应重复几次，在此处过滤
            ->limit($offset . ',' . $pagesize)
            ->select();
        //    echo $obj->getlastsql();exit;
            //dump($result);exit;
            foreach($result as $kk=>$vv){
                //列表过滤掉现货商品，但搜索栏要能够搜到（因为搜索和商品列表是同一个接口，所以加个判断）
                if(!$ary_post["keyword"]){//如果是列表页
                    if($vv['g_name'] == $vv['g_sn']){
                        unset($result[$kk]);
                    }
                }    
            }
            $result = array_values($result);
            $count = count($result);
            //dump($result);exit;
            if(empty($result)){
    
                $result = array();
                $count = 0;
            }


            $filter = $obj->field('gb.gb_name,gb.gb_id,na.n_name,na.code')
            ->join($join_where)
            ->join("fx_goods_products as gp ON gp.g_id = g.g_id")
            ->join("fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")                 
            ->where($ary_where)
            ->order($order_by)
            //->group('gb.gb_name')
            //->limit($offset . ',' . $pagesize)
            ->select();
            if(empty($filter)){
                $filter = [];
            }            
            // dump(array_chunk($filter,2));
            foreach ($filter as $k => $v) {
                   $filter1[$k]['k'] = $v['gb_name']; 
                   $filter1[$k]['v'] = $v['gb_id'];
                   $filter2[$k]['k'] = $v['n_name']; 
                   $filter2[$k]['v'] = $v['code'];                    
               }   
             //数组去重后组装
             $filter2 = $this->array_unique_2d($filter2);
             //去除null
             foreach($filter2 as $new=>$new_filter){
                if($new_filter['k'] === NULL || $new_filter['v'] === NULL ){
                    unset($filter2[$new]);   
                }
             }
             $filter2 = array_values($filter2);//数组键重构
            //数组去重后组装
             $filter1 = $this->array_unique_2d($filter1);
             //去除null
             foreach($filter1 as $new1=>$new_filter1){
                if($new_filter1['k'] === NULL || $new_filter1['v'] === NULL ){
                    unset($filter1[$new1]);   
                }
             }
             $filter1 = array_values($filter1);//数组键重构
             //这个地方不能取规格表，所以写死，详情看web端
             $filters[0]['name'] =  'origin_of_goods';
             $filters[0]['title'] =  '原产地';
             $filters[0]['item_option'] =  $filter2;

             $filters[1]['name'] =  'brand';
             $filters[1]['title'] =  '品牌';
             $filters[1]['item_option'] =  $filter1;

             //dump($filter2);exit;
            //$filter = array();

            if(!$token){
                foreach ($result as $key=>$value) {

                    $thumbname = $this->thumbname($value['g_picture'],200,200);
                    //dump($thumbname);exit;
                    $result[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;  
                    $result[$key]['n_pic'] = 'http://'.$_SERVER['HTTP_HOST'].$value['n_pic'];

                    $result[$key]['pmlp_price'] = '登录后可见';
                    // if($value['pdt_stock'] <= '0'){
                    //     $result[$key]['haveStock'] = "0";//无货
                    // }else{
                    //     $result[$key]['haveStock'] = "1";//有货
                    // }
                    //output_datas(null,array('result' =>"2",'error_code' =>10003,'desc'=>'token配对失败'));
                }
                $newarr['result'] = '0';
                $newarr['error_code'] = '1';
                $newarr['desc'] = '取产品列表成功';
                $newarr['data']['totalcount'] = $count;
                $newarr['data']['filter'] = $filters;
                $newarr['data']['goodslist'] = $result;
                $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);
                echo $json;die;                            

            }



            foreach ($result as $key=>$value) {

                $mGoodsProducts = D("GoodsProductsTable");
               
                $where = [];
                $where = [
                    "gp.g_sn"=>$value['g_sn'],
                    "pmlp.ml_id"=>$ml_id,
                ];
                $field = "max(pmlp_price) as maxPrice,min(pmlp_price) as minPrice";
                $goodsRuleInfo = $mGoodsProducts->alias("gp")->join("INNER JOIN fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")->where($where)->field($field)->find();
                $mGoods = D("Goods");
                if($mGoods->isRuleGoods($value['g_sn'])){
                        $result[$key]['pmlp_price'] = sprintf('%0.2f',$goodsRuleInfo['minPrice']).'~'.sprintf('%0.2f',$goodsRuleInfo['maxPrice']);

                }else{
                    if($value['pmlp_price'] == '0.000'){
                        $result[$key]['pmlp_price'] = sprintf('%0.2f',$value['g_price']);
                    }else{
                        $result[$key]['pmlp_price'] = sprintf('%0.2f',$value['pmlp_price']);
                    }

                }    
                
                $thumbname = $this->thumbname($value['g_picture'],200,200);
                //dump($thumbname);exit;
                $result[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;          
          
                //$result[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$value['g_picture'];
                $result[$key]['n_pic'] = 'http://'.$_SERVER['HTTP_HOST'].$value['n_pic'];
                // if($value['pdt_stock'] <= '0'){
                //     $result[$key]['haveStock'] = "0";//无货
                // }else{
                //     $result[$key]['haveStock'] = "1";//有货
                // }
        
            }

            $newarr['result'] = '0';
            $newarr['error_code'] = '0';
            $newarr['desc'] = '取产品列表成功';
            $newarr['data']['totalcount'] = $count;
            $newarr['data']['filter'] = $filters;
            $newarr['data']['goodslist'] = $result;

            $json = json_encode($newarr,JSON_UNESCAPED_UNICODE);
            echo $json;

        // }

        //output_datas($result,array('result' =>"0",'error_code' =>0,'desc'=>'取产品列表成功'));

    }



    public function get_new(){

       $ary_post = $this->_get();        
       $ary_where = array();
       $ary_where['g.g_on_sale'] = '1';//在架
       $ary_where['g.g_status'] = '1';//0为废弃，1为有效，2为进入回收站'
       $ary_goods = M('GoodsNew')
           ->alias('gn')
           ->join('fx_goods_info gi on gi.g_id = gn.g_id')
           ->join('fx_goods g on g.g_id = gn.g_id')
           ->where($ary_where)
           ->field('gn.g_id,gn.g_name,gn.gt_name,gn.g_desc,gi.g_picture')
           ->select();
       //dump($ary_goods);exit;
       //echo M()->getLastSql();exit;
        foreach ($ary_goods as $key=>$value) {
            $thumbname = $this->thumbname($value['g_picture'],200,200);
            //dump($thumbname);exit;
            $ary_goods[$key]['g_picture'] = 'http://'.$_SERVER['HTTP_HOST'].$thumbname;

        }
        //数组按gt_name归类
        $item = array();
        foreach($ary_goods as $k=>$v){
            if(!isset($item[$v['gt_name']])){
                $item[$v['gt_name']][]=$v;
            }else{
                $item[$v['gt_name']][]=$v;
            }
        }
        //dump($item);exit;
        if(empty($item)){
            $item = array();
        }


        output_datas($item,array('result' =>"0",'error_code' =>0,'desc'=>'查询成功!'));

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


    //二维数组去掉重复值
    public function array_unique_2d($array2D){
        $temp = $res = array();
        foreach ($array2D as $v){
            $v = json_encode($v);  //降维,将一维数组转换字符串      

                $temp[] = $v;
            }
            $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $item){

            $res[] = json_decode($item,true);   //再将拆开的数组重新组装
        }
        return $res;
    }


    //获取指定分类的所有子分类
    public function getCateIds($pid){
        
        $cate_list = M('GoodsCategory')->where('gc_id ='. $pid)->find();
        if($cate_list['gc_is_parent'] == '0'){//说明没有子类
            return $pid;
        } 

        //dump($cate_list);exit;

        $need_list = M('GoodsCategory')->where('gc_parent_id ='. $pid)->select();//获取到的一级分类 
       //dump($need_list);
       //echo M()->getlastsql();
        $need_id_str = ''; //获取需要的子类id
        foreach($need_list as $val){
            $need_id[] = $val['gc_id'];
        } 
        $need_id_str = join(',', $need_id);

        $where = "gc_parent_id in ($need_id_str)";
        $products = M('GoodsCategory')->field('gc_id')->where($where)->select(); 
        //dump($products);exit;
        //echo M('GoodsCategory')->getlastsql();exit;
        if(!$products){
            return $need_id_str;
        }else{
            foreach($products as $val){
                $need_ids[] = $val['gc_id'];
            } 
            $need_id_strs = join(',', $need_ids);                
            return $need_id_strs;
        }
    }




    /**   
    * 去掉指定的html标签 
    * @param array $string   
    * @param bool $str  
    * @return string 
    */  
    public function _strip_tags($tagsArr,$str) {   
        foreach ($tagsArr as $tag) {  
            $p[]="/(<(?:\/".$tag."|".$tag.")[^>]*>)/i";  
        }  
        $return_str = preg_replace($p,"",$str);  
        return $return_str;  
    }  
  
    /**   
    * 替换空数组或null 
    * @param array $string   
    * @param bool $str  
    * @return string 
    */
    public function array_null($arr){

    }




}



