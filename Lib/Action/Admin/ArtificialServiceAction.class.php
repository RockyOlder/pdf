<?php

/**
 * 后台订单控制器
 *
 * @package Action
 * @subpackage Admin
 * @stage 7.0
 * @author Terry <wanghui@guanyisoft.com>
 * @date 2013-01-18
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class ArtificialServiceAction extends AdminAction {

    /**
     * 控制器初始化操作
     * @author Terry <wanghui@guanyisoft.com>
     * @date 2013-01-18
     */
    public function _initialize() {
        parent::_initialize();
        $this->log = new ILog('db');
        $this->setTitle(' - ' . L('MENU3_0'));
    }

    /*
     * 跳转列表页
     */

    public function index() {

        $this->redirect(U('Admin/ArtificialService/pageList'));
    }
    /*
     * 列表页
     */
    public function pageList() {
        $this->getSubNav(4, 7, 10);
        $ary_request = $this->_request();
        $currentPage = (int) $ary_request['p'];
        if (0 != $currentPage) {
            session('page', $currentPage);
        }
        $ary_request['tabs'] = empty($ary_request['tabs']) ? "website" : $ary_request['tabs'];
        $data = array();
        $ary_where = array();
        if (!empty($ary_request['search']) && $ary_request['search'] == 'easy') {
            switch ($ary_request['field']) {
                case 'g_sn':
                    if (!empty($ary_request['val'])) {
                        $ary_where['g_sn'] = trim($ary_request['val']);
                        break;
                    }
                case 'g_name':
                    $ary_request['val'] = urldecode(trim($ary_request['val']));

                    $ary_where['gi.g_name'] = array('like', "%" . trim($ary_request['val']) . "%");
                    break;
            }
            if (!empty($ary_request['gpid']) && isset($ary_request['gpid'])) {
                $array_goods_id = M('related_goods_group', C('DB_PREFIX'), 'DB_CUSTOM')->distinct(true)->field('g_id')->where(array('gg_id' => $ary_request['gpid']))->select();
                $ary_gid = array();
                foreach ($array_goods_id as $gid) {
                    $ary_gid[] = $gid['g_id'];
                }

                $ary_where['gi.g_id'] = array('in', isset($ary_gid) ? $ary_gid : '');
            }
        } else {
            if (isset($ary_request['category']) && !empty($ary_request['category'])) {
                $ary_where["fx_goods.g_id"] = 0;
                //如果指定了商品分类进行检索，则先获取该商品分类下关联的商品ID
                $array_related_g_ids = D("RelatedGoodsCategory")->distinct(true)->where(array("gc_id" => array('in', $ary_request['category'])))->getField("g_id", true);
                //echo D("RelatedGoodsCategory")->getLastSql();exit;
                if (!empty($array_related_g_ids)) {
                    $ary_where["fx_goods.g_id"] = array("IN", $array_related_g_ids);
                }
            }
            //品牌搜索
            if (!empty($ary_request['brand']) && isset($ary_request['brand'])) {
                $ary_where['gb_id'] = array('in', $ary_request['brand']);
            }
            if (!empty($ary_request['status']) && isset($ary_request['status'])) {
                $ary_where['g_on_sale'] = $ary_request['status'];
            }
            if (!empty($ary_request['start_time']) && isset($ary_request['start_time'])) {
                if (!empty($ary_request['end_time']) && $ary_request['end_time'] > $ary_request['start_time']) {
                    $ary_request['end_time'] = trim($ary_request['end_time']) . " 23:59:59";
                } else {
                    $ary_request['end_time'] = date("Y-m-d H:i:s");
                }
                $ary_where['g_update_time'] = array("between", array($ary_request['start_time'] . " 00:00:00", $ary_request['end_time']));
            }
            if (!empty($ary_request['stockSymbol']) && !empty($ary_request['stock'])) {
                $ary_where['g_stock'] = array($ary_request['stockSymbol'], $ary_request['stock']);
            }
            if (!empty($ary_request['new']) && !empty($ary_request['new'])) {
                $ary_where['g_new'] = $ary_request['new'];
            }
            if (!empty($ary_request['hot']) && !empty($ary_request['hot'])) {
                $ary_where['g_hot'] = $ary_request['hot'];
            }
        }
        // 判断是否开启分配库存
        $inventoryConfig = D('SysConfig')->getConfigs('GY_STOCK', 'INVENTORY_STOCK');
        $ary_request['inventory_stock'] = 0;
        if (isset($inventoryConfig['INVENTORY_STOCK']['sc_value'])) {
            $ary_request['inventory_stock'] = $inventoryConfig['INVENTORY_STOCK']['sc_value'];
        }

        $ary_where['g_status'] = '1';
        $int_page_size = 10;
        //商品列表页页签处理
        $string_name = trim($ary_request['tabs']);
        $admin_left_menu = 30;
        switch ($string_name) {
            case "shelves":
                $ary_where['g_on_sale'] = '2';
                $admin_left_menu = 40;
                break;
            case "website":
                $ary_where['g_on_sale'] = '1';
                $admin_left_menu = 30;
                break;
            case "recycle":
                $ary_where['g_status'] = 2;
                $admin_left_menu = 45;
                break;
            case "new":
                $ary_where['g_on_sale'] = '1';
                $ary_where['g_new'] = '1';
                break;
            case "hot":
                $ary_where['g_on_sale'] = '1';
                $ary_where['g_hot'] = '1';
                break;
            default:
                $ary_where['g_on_sale'] = '1';
        }
        $ary_where['fx_goods.g_is_combination_goods'] = 0;
        if (!empty($ary_request['ggid']) && (int) $ary_request['ggid'] > 0) {
            $ary_where['gg.gg_id'] = $ary_request['ggid'];
        }
        //按修改时间排序（大到小 desc） 商品排序（越大越靠前 desc）
        $order_by = array('g_order' => 'desc', 'g_update_time' => 'desc');
        $data = $this->pageGoods($ary_where, $order_by, $int_page_size);
        $related_goods_category = D("RelatedGoodsCategory");
        $goods_products_table = D('GoodsProductsTable');
        //获取商品分类
        $array_category = D("GoodsCategory")->getChildLevelCategoryById(0);
        foreach ($array_category as $cat) {
            $all_cat[$cat['gc_id']] = $cat['gc_name'];
        }
        // 计算库存
        if (!empty($data['list']) && is_array($data['list'])) {
            foreach ($data['list'] as &$goods) {
                $goods['total_stock'] = $goods_products_table->where(array('g_id' => $goods['g_id']))->sum('pdt_total_stock');

                //获取此商品关联的分类信息
                $goods['array_catid'] = $related_goods_category->where(array("g_id" => $goods['g_id']))->getField("gc_id", true);
                $arr_cat = array();
                foreach ($goods['array_catid'] as $cat_id) {
                    $arr_cat[] = $all_cat[$cat_id];
                }
                $goods['cat_name'] = implode(",", $arr_cat);
            }
        }

        $this->assign("array_category", $array_category);
        $this->assign("filter", $ary_request);
        $this->assign("page", $data['page']);
        $this->assign("data", $data['list']);
        //获取所有的商品分组，提供给页面批量操作使用
        $this->assign("goodsgroups", D("GoodsGroup")->where(array("gg_status" => 1))->order(array("gg_order" => "asc"))->select());
        $this->display();
    }
    
    public function ArtificialOrderAdd(){
        $this->getSubNav(4, 7, 20);
        $this->display();
    }
    
    private function ComputationsArtificialPrice($ary_Artificial){
            switch ($ary_Artificial['service_type']){
                case 1:
                    if ($ary_Artificial['conversions_pages'] > 100){
                                if($ary_Artificial['documents_difficulty'] == 1 && $ary_Artificial['documents_type'] ==1){
                                    $ary_Artificial['price'] = 0.03;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",$ary_Artificial['conversions_pages']  * 0.03);
                                }
                                if($ary_Artificial['documents_difficulty'] == 2 && $ary_Artificial['documents_type'] ==1){
                                    $ary_Artificial['price'] = 0.05;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",$ary_Artificial['conversions_pages']  * 0.05);
                                }
                                if($ary_Artificial['documents_difficulty'] == 1 && $ary_Artificial['documents_type'] ==2){
                                    $ary_Artificial['price'] = 0.1;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",$ary_Artificial['conversions_pages']  * 0.1);
                                }
                                if($ary_Artificial['documents_difficulty'] == 2 && $ary_Artificial['documents_type'] == 2){
                                    $ary_Artificial['price'] = 0.2;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",$ary_Artificial['conversions_pages']  * 0.2);
                                }
                    } else {
                                if($ary_Artificial['documents_difficulty'] == 1 && $ary_Artificial['documents_type'] ==1){
                                    $ary_Artificial['price'] = 3;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",3);
                                }
                                if($ary_Artificial['documents_difficulty'] == 2 && $ary_Artificial['documents_type'] ==1){
                                    $ary_Artificial['price'] = 5;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",5);
                                }
                                if($ary_Artificial['documents_difficulty'] == 1 && $ary_Artificial['documents_type'] ==2){
                                    $ary_Artificial['price'] = 10;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",2);
                                }
                                if($ary_Artificial['documents_difficulty'] == 2 && $ary_Artificial['documents_type'] == 2){
                                    $ary_Artificial['price'] = 20;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",20);
                                }
                    }
                    break;
                case 2:
                        $ary_Artificial['price'] = 1;
                        $ary_Artificial['total_price'] = sprintf("%0.2f",1);
                    break;
                case 3:
                    if ($ary_Artificial['conversions_pages'] > 20){
                                if($ary_Artificial['documents_type'] == 1 ){
                                    $ary_Artificial['price'] = 0.05;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",$ary_Artificial['conversions_pages']  * 0.5);
                                }
                                if($ary_Artificial['documents_type'] == 2 ){
                                    $ary_Artificial['price'] = 0.1;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",$ary_Artificial['conversions_pages']  * 0.1);
                                }
                    } else {
                                if($ary_Artificial['documents_type'] == 1 ){
                                    $ary_Artificial['price'] = 1;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",1);
                                }
                                if($ary_Artificial['documents_type'] == 2 ){
                                    $ary_Artificial['price'] = 2;
                                    $ary_Artificial['total_price'] = sprintf("%0.2f",2);
                                }
                    }
                    break;
            }
            return $ary_Artificial;
    }

    public function doArtificialadd(){
        $ary_post = $this->_post();
        
        $ary_Artificial = array();
        
        $ary_Artificial['f_name']               =   (isset($ary_post["f_name"]) && "" != trim($ary_post["f_name"]))?trim($ary_post["f_name"]):'';
        $ary_Artificial["document_pages"]       =   (isset($ary_post["document_pages"]) && is_numeric($ary_post["document_pages"]))?$ary_post["document_pages"]:0;
        $ary_Artificial["permissions_ps"]       =   (isset($ary_post["permissions_ps"]) && is_numeric($ary_post["permissions_ps"]))?$ary_post["permissions_ps"]:0;
        $ary_Artificial["documents_badness"]    =   (isset($ary_post["documents_badness"]) && is_numeric($ary_post["documents_badness"]))?$ary_post["documents_badness"]:0;
        $ary_Artificial["service_type"]         =   (isset($ary_post["service_type"]) && is_numeric($ary_post["service_type"]))?$ary_post["service_type"]:0;
        $ary_Artificial["documents_difficulty"] =   (isset($ary_post["documents_difficulty"]) && is_numeric($ary_post["documents_difficulty"]))?$ary_post["documents_difficulty"]:0;
        $ary_Artificial["documents_type"]       =   (isset($ary_post["documents_type"]) && is_numeric($ary_post["documents_type"]))?$ary_post["documents_type"]:0;
        $ary_Artificial["conversions_pages"]    =   (isset($ary_post["conversions_pages"]) && is_numeric($ary_post["conversions_pages"]))?$ary_post["conversions_pages"]:0;
        $orders = M('', C('DB_PREFIX'), 'DB_CUSTOM');
        $orders->startTrans();
        $ary_Artificial_data = $this->ComputationsArtificialPrice($ary_Artificial);
        $ordersModel = D('Orders');
        $int_artificial_id = D("ArtificialService")->add($ary_Artificial_data);
        if(false === $int_artificial_id){
                $orders->rollback();
                $this->error('人工订单数据表插入失败');
                exit;
        }
        $ary_orders =  array();
        $now_time = date('Y-m-d H:i:s',time());
        $ary_orders['o_create_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        $ary_orders['o_update_time'] = $now_time;
        $ary_orders ['o_id'] = '400'.date('YmdHis') . rand(1000, 9999);
        $ary_orders['o_goods_all_price'] = $ary_Artificial_data['price'];
        $ary_orders['o_all_price'] = $ary_Artificial_data['total_price'];
        $ary_orders['o_pre_sale'] = 1;
        $bool_orders = $ordersModel->data($ary_orders)->add();
        if(empty($bool_orders)){
              $orders->rollback();
              $this->error('订单创建失败'); 
        }
        //订单商品详情 
        $arr_orders_items = array();
        $arr_orders_items['o_id'] = $ary_orders ['o_id'];
        $arr_orders_items['pdt_id'] = $int_artificial_id;
        //    $arr_orders_items['gt_id'] = $bool_orders;
        $arr_orders_items['oi_g_name'] = $ary_Artificial_data['f_name'];
        $arr_orders_items['oi_cost_price'] = $ary_Artificial_data['price'];
        $arr_orders_items['pdt_sale_price'] = $ary_Artificial_data['price'];
        $arr_orders_items['oi_price'] = $ary_Artificial_data['price'];
        $arr_orders_items['oi_nums'] = 1;
        $arr_orders_items['oi_type'] = 8;
        $arr_orders_items['oi_refund_status'] = 1;
        $arr_orders_items['oi_create_time'] = $now_time;
        $arr_orders_items['oi_update_time'] = $now_time;
        $bool_orders_items = D('OrdersItems')->data($arr_orders_items)->add();
        if($bool_orders_items == true ) {
            $orders->commit();
            $this->success('订单创建成功',U('Admin/ArtificialService/pageList'));
        } else {
              $orders->rollback();
              $this->error('订单详情创建失败'); 
        }
    }





    /**
     * 后台官网商品列表页
     * @author Terry<wanghui@guanyisoft.com>
     * @date 2013-3-19
     */
    public function pageGoods($array_condition = array(), $order_by, $int_page_size = 20) {
        $GoodsBaseModel = D("GoodsBase");
        $count = $GoodsBaseModel
                ->where($array_condition)
                ->join("fx_goods_info as gi on(fx_goods.g_id=gi.g_id) ")
                ->join("fx_related_goods_group as rgg on(fx_goods.g_id=rgg.g_id)")
                ->join("fx_goods_group as gg on(gg.gg_id = rgg.gg_id)")
                ->count('distinct(fx_goods.`g_id`)');
        //echo "<pre>";print_r($GoodsBaseModel->getLastSql());exit;
        $obj_page = new Page($count, $int_page_size);
        $data['page'] = $obj_page->show();
        $data['list'] = $GoodsBaseModel
                ->where($array_condition)
                ->field("
				distinct(fx_goods.`g_id`) AS `g_id`,
				fx_goods.`gb_id` AS `gb_id`,fx_goods.`gt_id` AS `gt_id`,fx_goods.`g_on_sale` AS `g_on_sale`,
				fx_goods.`g_status` AS `g_status`,fx_goods.`g_sn` AS `g_sn`,
				fx_goods.`g_off_sale_time` AS `g_off_sale_time`,fx_goods.`g_on_sale_time` AS `g_on_sale_time`,
				fx_goods.`g_new` AS `g_new`,fx_goods.`g_hot` AS `g_hot`,fx_goods.`g_retread_date` AS `g_retread_date`,
				fx_goods.`g_pre_sale_status` AS `g_pre_sale_status`,fx_goods.`g_gifts` AS `g_gifts`,
				`gi`.`ma_price` AS `ma_price`,
				`gi`.`mi_price` AS `mi_price`,`gi`.`g_name` AS `g_name`,`gi`.`g_price` AS `g_price`,
				`gi`.`g_unit` AS `g_unit`,`gi`.`g_desc` AS `g_desc`,`gi`.`g_picture` AS `g_picture`,
				`gi`.`g_no_stock` AS `g_no_stock`,`gi`.`g_create_time` AS `g_create_time`,
				`gi`.`g_update_time` AS `g_update_time`,`gi`.`g_red_num` AS `g_red_num`,
				`gi`.`g_source` AS `g_source`,`gi`.`g_stock` AS `g_stock`,
				`gi`.`g_salenum` AS `g_salenum`,`gi`.`point` AS `point`,
				`gi`.`is_exchange` AS `is_exchange`,group_concat(gg.gg_name) as group_name               
                ")
                ->join("fx_goods_info as gi on(fx_goods.g_id=gi.g_id) ")
                ->join("fx_related_goods_group as rgg on(fx_goods.g_id=rgg.g_id)")
                ->join("fx_goods_group as gg on(gg.gg_id = rgg.gg_id)")
                ->order($order_by)
                ->group('fx_goods.g_id')
                ->limit($obj_page->firstRow . ',' . $obj_page->listRows)
                ->select();
                //echo "<pre>";print_r($GoodsBaseModel->getLastSql());exit;
        return $data;
    }
    
    
    
}
