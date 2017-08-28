<?php

class CartAction extends MobileAction {

    public function CartAdd() {

        $ary_parms = $this->_param();
        $ary_insert = array();
        $int_good_type = 0;
        $ary_parms['pdt_id'] = $ary_parms['goods_id'];
        $ary_parms['num'] = $ary_parms['quantity'];
        $nerber = $ary_parms['allnums'];
        $pdt_id = $ary_parms['pdt_id'];
        $num = $ary_parms['num'];
        $arr_integral = M('goods_products', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('pdt_id' => $ary_parms['pdt_id']))->find();
        if (empty($arr_integral)) {
            output_datas(null, array('result' => "1", 'desc' => '商品不存在'));
        }
        //       $int_good_type = $this->_param('good_type', '', 0);
        $ary_insert[$pdt_id] = $num;
        foreach ($ary_insert as $str_pdt => $int_num) {
            $int_num = (int) $int_num;
            //大于0的新插入/更新. 小于等于0的不作处理
            if ($int_num > 0) {
                $ary_cart[$str_pdt] = $int_num;
            }
        }

        //$type=item&num=1&pdt_id=111
        //过滤一遍数据，以防有小于0的或者不是数字的
        $ary_db_carts = array();
        if (!empty($this->member_info['m_id'])) {

            $ary_db_carts = D('Cart')->ApiReadMycart($this->member_info['m_id']);
        }
        foreach ($ary_cart as $key => $int_num) {
            if ($int_num <= 0 || !is_int($int_num)) {
                unset($ary_cart[$key]);
            }
            $goods_info = D('GoodsProducts')->GetProductList(array('fx_goods_products.pdt_id' => $key), array('fx_goods.g_is_combination_goods', 'fx_goods.g_gifts', 'fx_goods.g_id'));
            if ($goods_info[0]['g_is_combination_goods']) {//组合商品
                $int_good_type = 3;
            }
            if ($goods_info[0]['g_gifts'] == 1) {
                output_datas(null, array('result' => "1", 'desc' => '赠品不能购买'));
                return false;
            }
            if (!empty($this->member_info['m_id'])) {//database
                $sku_count = M('goods_products', C('DB_PREFIX'), 'DB_CUSTOM')->where(array("g_id" => $arr_integral["g_id"]))->count();
                if ($sku_count > 1) {
                    if (empty($ary_db_carts)) {
                        $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num, 'g_trade' => $ary_parms['g_trade'], 'type' => $int_good_type, 'g_id' => $goods_info[0]['g_id']);
                    } else {
                        foreach ($ary_db_carts as $k => $value) {
                            if ($value['g_id'] == $arr_integral["g_id"]) {
                                $sku_num = $int_num;
                                $ary_where['pdt_min_num'] = array('ELT', $sku_num);
                                $ary_where['pdt_max_num'] = array('EGT', $sku_num);
                                $ary_where['g_id'] = $arr_integral['g_id'];
                                $detail = M('goods_products', C('DB_PREFIX'), 'DB_CUSTOM')->where($ary_where)->find();
                                //echo M('goods_products',C('DB_PREFIX'),'DB_CUSTOM')->getLastSql();exit;
                                if (!empty($detail)) {
                                    foreach ($ary_db_carts as $keys => $Cart) {
                                        if ($arr_integral["g_id"] == $Cart['g_id']) {
                                            unset($ary_db_carts[$keys]);
                                            D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);
                                        }
                                    }
                                    $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num, 'g_trade' => $ary_parms['g_trade'], 'type' => $int_good_type, 'g_id' => $goods_info[0]['g_id']);
                                } else {
                                    $ary_where['pdt_min_num'] = array('ELT', $sku_num);
                                    $ary_where['pdt_max_num'] = 0;
                                    $ary_where['g_id'] = $arr_integral['g_id'];
                                    $detail = M('goods_products', C('DB_PREFIX'), 'DB_CUSTOM')->where($ary_where)->find();
                                    foreach ($ary_db_carts as $keys => $Cart) {
                                        if ($arr_integral["g_id"] == $Cart['g_id']) {
                                            unset($ary_db_carts[$keys]);
                                            D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);
                                        }
                                    }
                                    $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num, 'g_trade' => $ary_parms['g_trade'], 'type' => $int_good_type, 'g_id' => $goods_info[0]['g_id']);
                                }
                            } else {
                                if (!array_key_exists($key, $ary_db_carts)) {
                                    if ($this->_post('way_type') == '1') {
                                        foreach ($ary_db_carts as $keys => $Cart) {
                                            if ($arr_integral["g_id"] == $Cart['g_id']) {
                                                unset($ary_db_carts[$keys]);
                                                D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);
                                            }
                                        }
                                    }
                                    $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num, 'g_trade' => $ary_parms['g_trade'], 'type' => $int_good_type, 'g_id' => $goods_info[0]['g_id']);
                                }
                            }
                        }
                    }
                }

                if (array_key_exists($key, $ary_db_carts) && isset($ary_db_carts[$key]['type']) && ($int_good_type == $ary_db_carts[$key]['type'])) {

                    if ('item' == $type && $this->_post('way_type') == '1') {
                        $ary_db_carts[$key]['num'] = $int_num;
                    } else {
                        if ($sku_count == 1) {
                            $ary_db_carts[$key]['num'] = $int_num;
                        }
                    }
                } else {
                    if ($sku_count == 1) {
                        $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num, 'g_trade' => $ary_parms['g_trade'], 'type' => $int_good_type, 'g_id' => $goods_info[0]['g_id']);
                    }
                }
            }
        }
        if (!empty($this->member_info['m_id'])) {
            //保存到databese
            if ($int_good_type == 1) {
                //判断会员的当前有效积分是否满足购买积分条件
                $ary_point_datas = array();
                foreach ($ary_db_carts as $pkey => $pvalue) {
                    if ($pvalue['type'] == $int_good_type) {
                        $ary_point_datas[$pvalue['pdt_id']] = $pvalue;
                    }
                }
                if (false == ($flag = D('Cart')->enablePoint($this->member_info['m_id'], $ary_point_datas, $info))) {
                    $this->error($info);
                }
            }
            //print_r($ary_db_carts);exit;
            $Cart = D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);

            if ($Cart == true) {
                output_datas(null, array('result' => "0", 'desc' => '进货单添加成功！'));
            } else {
                output_datas(null, array('result' => "1", 'desc' => '进货单添加失败'));
            }
        }
    }

    public function doDel() {
        $ary_member = $this->member_info;

        //获取货品id
        $mix_pdt_id = explode(',', $this->_param("pid"));
        //print_r($mix_pdt_id);exit;
        foreach ($mix_pdt_id as $v) {
            $mix_pdt_type[] = 0;
        }
        //   $mix_pdt_type = $this->_get("type"); //商品类型
        /* if (empty($mix_pdt_id)) {			
          $this->success(L('SELECT_GOOD'));
          } */
        if (!empty($ary_member['m_id'])) {
            $ary_db_carts = D('Cart')->ApiReadMycart($this->member_info['m_id']);
            if (!empty($ary_db_carts) && is_array($ary_db_carts)) {
                foreach ($ary_db_carts as &$cart_val) {
                    if ($cart_val['type'] == '0') {
                        $ary_gid = M("goods_products", C('DB_PREFIX'), 'DB_CUSTOM')->field('g_id')->where(array('pdt_id' => $cart_val['pdt_id']))->find();
                        //by wanghaoyu 商品加入购物车后,验证该商品是否在后台直接删除或者数据非法
                        if (NULL === $ary_gid) {
                            $mix_pdt_id = $cart_val['pdt_id'];
                        }
                    }
                }
            }
            if (is_array($mix_pdt_id)) {
                foreach ($mix_pdt_id as $key => $val) {
                    //$val = (int)$val;
                    if ($mix_pdt_type[$key] == 2) {
                        if (isset($ary_db_carts['gifts'][$val]) && $ary_db_carts['gifts'][$val]['type'] == $mix_pdt_type[$key]) {
                            if (count($ary_db_carts['gifts']) < 2) {
                                unset($ary_db_carts['gifts']);
                            } else {
                                unset($ary_db_carts['gifts'][$val]);
                            }
                        }
                    } else {
                        if (isset($ary_db_carts[$val]) && $ary_db_carts[$val]['type'] == $mix_pdt_type[$key]) {
                            unset($ary_db_carts[$val]);
                        }
                    }
                }
            } else {
                //$pdt_id = (int) $mix_pdt_id;
                $pdt_id = $mix_pdt_id;
                if ($mix_pdt_type == 2) {
                    if (isset($ary_db_carts['gifts'][$pdt_id]) && $ary_db_carts['gifts'][$pdt_id]['type'] == $mix_pdt_type) {
                        if (count($ary_db_carts['gifts']) < 2) {
                            unset($ary_db_carts['gifts']);
                        } else {
                            unset($ary_db_carts['gifts'][$pdt_id]);
                        }
                    }
                } else {
                    if (isset($ary_db_carts[$pdt_id]) && $ary_db_carts[$pdt_id]['type'] == $mix_pdt_type) {
                        unset($ary_db_carts[$pdt_id]);
                    }
                }
            }
            $Cart = D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);
        } else {
            $mix_pdt_id = $this->_get("pid");
            $ary_cart = (session("?Cart")) ? session("Cart") : array();
            if (is_array($mix_pdt_id)) {
                foreach ($mix_pdt_id as $val) {
                    $val = $val;
                    if (isset($ary_cart[$val]) && $ary_cart[$val]['type'] == $mix_pdt_type) {
                        unset($ary_cart[$val]);
                    }
                }
            } else {
                $mix_pdt_id = $mix_pdt_id;
                if (isset($ary_cart[$mix_pdt_id]) && $ary_cart[$mix_pdt_id]['type'] == $mix_pdt_type) {
                    unset($ary_cart[$mix_pdt_id]);
                }
            }
            //     session("Cart", $ary_cart);
        }
        output_datas(null, array('result' => "0", 'desc' => '进货单删除成功！'));
    }

    public function CartList() {

        $Cart = D('Cart');

        if (!empty($this->member_info['m_id'])) {
            //获取购物车信息
            $tmp_cart_data = $Cart->ApiReadMycart($this->member_info['m_id']);
            //处理购物车信息
            $cart_data = $Cart->handleCart($tmp_cart_data);

            //获取促销后优惠信息
            $pro_datas = D('Promotion')->calShopCartPro($this->member_info['m_id'], $cart_data, 1);

            $subtotal = $pro_datas['subtotal']; //促销金额
            //剔除商品价格信息
            unset($pro_datas['subtotal']);
            //获取商品详细信息
            if (is_array($cart_data) && !empty($cart_data)) {
                $ary_cart_data = $Cart->getProductInfo($cart_data, $this->member_info['m_id'], 1);
            }
            //   echo json_encode($ary_cart_data);exit;
            //处理获取的商品信息
            $ary_cart = $Cart->handleCartProductsAuthorize($ary_cart_data, $this->member_info['m_id']);
            //处理通过促销获取的优惠信息

            $tmp_pro_datas = $Cart->handleProdatas($pro_datas, $ary_cart);

//            dump($tmp_pro_datas);die;
            //处理pro_datas信息
            $pro_datas = $tmp_pro_datas['pro_datas'];
            //获取促销信息
        }
        $list = array();
        $warehouses = M('warehouses', C('DB_PREFIX'), 'DB_CUSTOM');
        foreach ($pro_datas as $k => $value) {
            foreach ($value['products'] as $key => $v) {
                //dump($value['products']);exit;

                $mGoods = D("Goods");
                if($mGoods->isRuleGoods($v['g_sn'])){//多起发数   
                    $mGoodsProducts = D("GoodsProductsTable");
                    $where = [];
                    $where = [
                        "gp.g_sn"=>$v['g_sn'],
                        //"pmlp.ml_id"=>$ml_id,
                    ];
                    $field = "pdt_min_num,pdt_max_num";
                    $goodsRuleInfo = $mGoodsProducts->alias("gp")->join("INNER JOIN fx_product_member_level_price as pmlp ON pmlp.pdt_id = gp.pdt_id")->where($where)->field($field)->select();
                    //dump($goodsRuleInfo);exit;
                    $count_num = count($goodsRuleInfo);
                    $v['min'] = $goodsRuleInfo[0]['pdt_min_num'];
                    $v['max'] = $goodsRuleInfo[$count_num-1]['pdt_max_num'];
                }else{
                    $v['min'] = $v['pdt_min_num'];
                    $v['max'] = $v['pdt_max_num'];                    
                }    
                // if ($v['g_trade'] == 0 && isset($v['g_trade'])) {
                    if (!empty($value['pmn_id'])) {
                        $list[$v['g_trade']]['pmn_id'] = $value['pmn_id'];
                        $list[$v['g_trade']]['pmn_name'] = $value['pmn_name'];
                        $list[$v['g_trade']]['pmn_activity_name'] = $value['pmn_activity_name'];
                        $list[$v['g_trade']]['pmn_enable'] = $value['pmn_enable'];
                        $list[$v['g_trade']]['pmn_category'] = $value['pmn_category'];
                        $list[$v['g_trade']]['pmn_class'] = $value['pmn_class'];
                        $list[$v['g_trade']]['pmn_category'] = $value['pmn_category'];
                    }
                    $list[$v['g_trade']]['groupType'] = $v['g_trade'];
                    //$name = $warehouses->where(array("c_id" => $v['g_point_origin']))->find();
                    //$list[$v['g_trade']]['name'] = $name['c_name'];
                    //1保税2直邮0普通
                    if($v['g_trade'] == '1'){
                        $list[$v['g_trade']]['name'] = "保税商品";
                    }elseif($v['g_trade'] == '0'){
                        $list[$v['g_trade']]['name'] = "完税商品";
                    }elseif($v['g_trade'] == '2'){
                        $list[$v['g_trade']]['name'] = "直邮商品";
                    }
                    $list[$v['g_trade']]['totalAmount'] += $v['pdt_price'] * $v['pdt_nums'];
                    $list[$v['g_trade']]['totalTaxes'] += ($v['g_tax_rate'] * $v['pdt_price']) * $v['pdt_nums'];
                    $v['packaging'] = '';
                    //取图片全路径加域名
                    $thumbname = $this->thumbname($v['g_picture'],200,200);
                    $v['g_picture'] = 'http://' . $_SERVER['HTTP_HOST'] . $thumbname;

                    $list[$v['g_trade']]['goodsList'][] = $v;
                    unset($pro_datas[$k]['products'][$key]);
//                 } else if ($v['g_trade'] == 1) {
//                     $v['packaging'] = '';
//                     //取图片全路径加域名
//                     $thumbname = $this->thumbname($v['g_picture'],200,200);
//                     $v['g_picture'] = 'http://' . $_SERVER['HTTP_HOST'] . $thumbname;
//                     $list[$v['g_point_origin']]['groupType'] = 1;
//                     $list[$v['g_point_origin']]['totalAmount'] += $v['pdt_price'] * $v['pdt_nums'];
//                     $list[$v['g_point_origin']]['totalTaxes'] += ($v['g_tax_rate'] * $v['pdt_price']) * $v['pdt_nums'];
//                     if (!empty($value['pmn_id'])) {
//                         $list[$v['g_point_origin']]['pmn_id'] = $value['pmn_id'];
//                         $list[$v['g_point_origin']]['pmn_name'] = $value['pmn_name'];
//                         $list[$v['g_point_origin']]['pmn_activity_name'] = $value['pmn_activity_name'];
//                         $list[$v['g_point_origin']]['pmn_enable'] = $value['pmn_enable'];
//                         $list[$v['g_point_origin']]['pmn_category'] = $value['pmn_category'];
//                         $list[$v['g_point_origin']]['pmn_class'] = $value['pmn_class'];
//                         $list[$v['g_point_origin']]['pmn_category'] = $value['pmn_category'];
//                     }
//                     if (empty($list[$v['g_point_origin']]['name'])) {
//                         $name = $warehouses->where(array("c_id" => $v['g_point_origin']))->find();
//                         $list[$v['g_point_origin']]['name'] = $name['c_name'];
//                         //     $list[$v['g_point_origin']]['id']    = $v['g_point_origin'];
//                     }
//                     if (empty($arr)) {
//                         $list[$v['g_point_origin']]['goodsList'][] = $v;
//                         $arr[] = $v['g_point_origin'];
//                     } else {
//                         if (in_array($v['g_point_origin'], $arr)) {
//                             $list[$v['g_point_origin']]['goodsList'][] = $v;
//                         } else {
//                             $list[$v['g_point_origin']]['goodsList'][] = $v;
//                             $arr[] = $v['g_point_origin'];
//                         }
//                     }
//                 } else {
//                     $v['packaging'] = '';
//                     //取图片全路径加域名
//                     $thumbname = $this->thumbname($v['g_picture'],200,200);
//                     $v['g_picture'] = 'http://' . $_SERVER['HTTP_HOST'] . $thumbname;
//                     $list[$v['g_point_origin']]['groupType'] = 2;
//                     $list[$v['g_point_origin']]['totalAmount'] += $v['pdt_price'] * $v['pdt_nums'];
//                     $list[$v['g_point_origin']]['totalTaxes'] += ($v['g_tax_rate'] * $v['pdt_price']) * $v['pdt_nums'];
//                     if (!empty($value['pmn_id'])) {
//                         $list[$v['g_point_origin']]['pmn_id'] = $value['pmn_id'];
//                         $list[$v['g_point_origin']]['pmn_name'] = $value['pmn_name'];
//                         $list[$v['g_point_origin']]['pmn_activity_name'] = $value['pmn_activity_name'];
//                         $list[$v['g_point_origin']]['pmn_enable'] = $value['pmn_enable'];
//                         $list[$v['g_point_origin']]['pmn_category'] = $value['pmn_category'];
//                         $list[$v['g_point_origin']]['pmn_class'] = $value['pmn_class'];
//                         $list[$v['g_point_origin']]['pmn_category'] = $value['pmn_category'];
//                     }
//                         $name = $warehouses->where(array("c_id" => $v['g_point_origin']))->find();
//                         $list[$v['g_point_origin']]['name'] = $name['c_name'];
// //                    if (empty($list[$v['g_point_origin']]['name'])) {
// //              
// //                        //    $list[$v['g_point_origin']]['id']    = $v['g_point_origin'];
// //                    }
//                     if (empty($arr)) {
//                         $list[$v['g_point_origin']]['goodsList'][] = $v;
//                         $arr[] = $v['g_point_origin'];
//                     } else {
//                         if (in_array($v['g_point_origin'], $arr)) {
//                             $list[$v['g_point_origin']]['goodsList'][] = $v;
//                         } else {
//                             $list[$v['g_point_origin']]['goodsList'][] = $v;
//                             $arr[] = $v['g_point_origin'];
//                         }
//                     }
//                 }
            }

            //$pro_datas['shoppingList'] = $list;
        }
        foreach ($list as $key => $c) {
            $list[$key]['totalAmount'] = sprintf("%.2f", $c['totalAmount']);
            $list[$key]['totalTaxes'] = sprintf("%.2f", $c['totalTaxes']);
        }
        $proCart = array();
        $proCart['shoppingList'] = (object) $list;
        //  echo json_encode(array($proCart));exit;
        output_datas($proCart, array('result' => "0", 'desc' => '查询成功！'));
    }

    public function doAddAll() {

        $good_type = 0;
        $ary_insert = $this->_post('cart');
        // print_r($this->member_info);exit;
        foreach ($ary_insert as $str_pdt => $int_num) {
            $int_num = (int) $int_num;
            //大于0的新插入/更新. 小于等于0的不作处理
            if ($int_num > 0) {
                $ary_cart[$str_pdt] = $int_num;
            }
        }
        //$int_type=item&num=1&pdt_id=111
        //过滤一遍数据，以防有小于0的或者不是数字的
        $ary_db_carts = array();
        $ary_db_carts = D('Cart')->ApiReadMycart($this->member_info['m_id']);
        foreach ($ary_cart as $key => $int_num) {
            if ($int_num <= 0 || !is_int($int_num)) {
                unset($ary_cart[$key]);
            }
            $where = array('fx_goods_products.pdt_id' => $key);
            $field = array('fx_goods.g_is_combination_goods', 'fx_goods.g_gifts', 'fx_goods.g_id');
            $goods_info = D('GoodsProducts')->GetProductList($where, $field);
            if ($goods_info[0]['g_is_combination_goods']) {//组合商品
                $good_type = 3;
            }
            if ($goods_info[0]['g_gifts'] == 1) {
                output_datas(null, array('result' => "1", 'desc' => '赠品不能购买'));
                return false;
            }

            if (array_key_exists($key, $ary_db_carts) && isset($ary_db_carts[$key]['type']) && ($good_type == $ary_db_carts[$key]['type'])) {
                $ary_db_carts[$key]['num']+=$int_num;
            } else {
                $ary_db_carts[$key] = array('pdt_id' => $key, 'num' => $int_num, 'type' => $good_type, 'g_id' => $goods_info[0]['g_id']);
            }
        }
        // print_r($ary_db_carts);exit;
        $Cart = D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);

        output_datas(null, array('result' => "0", 'desc' => '进货单添加成功！'));
    }

    /**
     * 根据商品的pdt_id和购买数量，修改购物车
     * @author jiye
     * @date 2012-12-11
     * @modify zuo <zuojianghua@guanyisoft.com>
     * @date 2012-12-28
     */
    public function doEdit() {
        $int_pdt_nums = $this->_post("pdt_nums");
        $int_pdt_id = $this->_post("pdt_id");
        $int_good_type = 0;
        $Cart = D('Cart');
        $ary_member = $this->member_info;
        $ary_member_find = M('Members', C('DB_PREFIX'), 'DB_CUSTOM')->field('m_balance')->where(array('m_id' => $ary_member['m_id']))->find();
            if (!empty($ary_member['m_id'])) {
            $ary_db_carts = D('Cart')->ApiReadMycart($this->member_info['m_id']);
            foreach ($ary_db_carts as $key => &$value) {
                if ($key == $int_pdt_id) {
                    $count_sku_list =  M('goods_products', C('DB_PREFIX'), 'DB_CUSTOM')->where(array('g_id' => $value['g_id']))->count();
                    if($count_sku_list >1)
                    {
                        $ary_where['pdt_min_num'] = array('ELT',$int_pdt_nums);
                        $ary_where['pdt_max_num'] = array('EGT',$int_pdt_nums);
                        $ary_where['g_id'] = $value['g_id'];
                        $detail =  M('goods_products',C('DB_PREFIX'),'DB_CUSTOM')->where($ary_where)->find();
               
                        if($detail['pdt_id'] !=$int_pdt_id)
                        {
                            if(!empty($detail))
                            {
                                 unset($ary_db_carts[$int_pdt_id]);
                                 $ary_db_carts[$detail['pdt_id']] = array('pdt_id' => $detail['pdt_id'], 'num' => $int_pdt_nums,'g_trade'=>$detail['g_trade'], 'type' => 0, 'g_id' => $detail['g_id']);
                                  D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);
                                 $int_pdt_id = $detail['pdt_id'];
                            }else{
                                $ary_where['pdt_min_num'] = array('ELT',$int_pdt_nums);
                                $ary_where['pdt_max_num'] = 0;
                                $ary_where['g_id'] = $value['g_id'];
                                $detail =  M('goods_products',C('DB_PREFIX'),'DB_CUSTOM')->where($ary_where)->find();
                                if(!empty($detail))
                                 {
                                    unset($ary_db_carts[$int_pdt_id]);
                                    $ary_db_carts[$detail['pdt_id']] = array('pdt_id' => $detail['pdt_id'], 'num' => $int_pdt_nums,'g_trade'=>$detail['g_trade'], 'type' => 0, 'g_id' => $detail['g_id']);
                                     D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);
                                    $int_pdt_id = $detail['pdt_id'];
                                 }
                            }
                            
                        }
                    }else{
                          $value['num'] = $int_pdt_nums;
                    }
                  
                }
            }
			//处理购物车信息
			$ary_db_carts = $Cart->handleCart($ary_db_carts);
			//获取促销后优惠信息
            $pro_datas = D('Promotion')->calShopCartPro($ary_member['m_id'], $ary_db_carts,1);
          
            $subtotal = $pro_datas['subtotal']; //促销金额
            //剔除商品价格信息
            unset($pro_datas['subtotal']);
			//获取商品详细信息
            if (isset($ary_db_carts[$int_pdt_id]) && $ary_db_carts[$int_pdt_id]['type'] == $int_good_type) {
                $ary_db_carts[$int_pdt_id]['num'] = (int) $int_pdt_nums;
                if ($int_good_type == 1) {
                    //判断会员的当前有效积分是否满足购买积分条件
                    if (false == ($flag = D('Cart')->enablePoint($ary_member['m_id'], $ary_db_carts, $info))) {
                        $this->ajaxReturn(array('status'=>false,"message"=>"会员不满足购买积分条件"));exit;
                    }
                }
				if(!empty($cart_gifts_data)){
					foreach($cart_gifts_data as $ary_gift){
						 $ary_db_carts['gifts'][$ary_gift['pdt_id']] = array('pdt_id' => $ary_gift['pdt_id'], 'num' => 1, 'type' => 2);
					}
				}

            D('Cart')->Api_WriteMycart($ary_db_carts, $this->member_info['m_id']);
            } else {
                $this->ajaxReturn(array('status'=>false,"message"=>"没有此货品"));exit;
            }
            if (is_array($ary_db_carts) && !empty($ary_db_carts)) {
                $ary_cart_data = $Cart->getProductInfo($ary_db_carts,$ary_member['m_id'],1);
            }
			//处理获取的商品信息
			$ary_cart = $Cart->handleCartProductsAuthorize($ary_cart_data,$ary_member['m_id']);
			//处理通过促销获取的优惠信息
			$tmp_pro_datas = $Cart->handleProdatas($pro_datas,$ary_cart);
			//处理pro_datas信息
			$pro_datas = $tmp_pro_datas['pro_datas'];
			//获取促销信息
			$pro_data = $tmp_pro_datas['pro_data'];
			//获取赠品信息
			$cart_gifts_data = $tmp_pro_datas['cart_gifts_data'];
			//获取订单总金额
			$ary_price_data = $Cart->getPriceData($tmp_pro_datas,$subtotal);
			unset($tmp_pro_datas);

		}
        if(!empty($ary_member['m_id']) && isset($ary_member['m_id'])){
                                  //  print_r();exit;
            $pmn_names = $pro_datas[$pro_data[$int_pdt_id]['pmn_id']]['products'][$int_pdt_id]['rule_info']['name'];
            $tax_rate = $pro_datas[$pro_data[$int_pdt_id]['pmn_id']]['products'][$int_pdt_id]['g_tax_rate'];
			if($tax_rate <=0){
				$tax_rate = $pro_datas[0]['products'][$int_pdt_id]['g_tax_rate'];
			}
			//税率
			$tax_price = sprintf("%0.2f",($pro_data[$int_pdt_id]['pdt_price'] * $pro_data[$int_pdt_id]['num'])*$tax_rate);
                        $logistic_price = D("Goods")->GoodsNumberPriceOperation($ary_db_carts[$int_pdt_id],$this->_post("cr_id"));
            //dump($pro_data);die;
			//参数说明 tax_price税额计算，promotion_result_name:促销名称；promotion_names：促销名称 cart_gifts_data:赠品 promotion_price:商品总金额
                $result = array('stauts' => true,
                'tax_price' =>$tax_price,
                'int_pdt_id'=>$int_pdt_id,
                'logistic_price'=>$logistic_price,
                'price'=>sprintf("%0.2f",$pro_data[$int_pdt_id]['pdt_price']),
                'promotion_result_name' => $pro_data[$int_pdt_id]['pmn_name'],
                'promotion_names'=>$pmn_names,
                'cart_gifts_data' => $cart_gifts_data,
                'm_balance'=>$ary_member_find['m_balance'],
                'promotion_price'=>  sprintf("%0.2f",$pro_data[$int_pdt_id]['pdt_price'] * $ary_db_carts[$int_pdt_id]['num'])
            );
        }else{
            $result = array('stauts' => true,'tax_rate' =>$tax_rate,'promotion_item_price' =>$promotion_item_price,'promotion_result_name' => $promotion_result['name'], 'cart_gifts_data' => $cart_gifts_data,'m_balance'=>$ary_member_find['m_balance']);
        }
        output_datas($result, array('result' => "0", 'desc' => '进货单添加成功！'));
    }
    
    public function ceshi() {


        //  echo $aa;exit;
        $a['cart'] = array(1 => 3, 2 => 0, 7 => 0, 18 => 1, 25 => 1);
        $a['key'] = "f15814bc224dd50442affbd86e78e593";
        $CC = makeRequestJson("http://txy.com/Api/Cart/doAddAll", $a, "POST");
        print_r($CC);
        exit;
        //   send_post(, $a);
    }

    //取缩略图路径（200*200）
    public function thumbname($pic,$w,$h){

        $info = pathinfo($pic);
        //dump($info);exit;
        $thumbname = $info['dirname'] . '/_thumb/' . $info['filename'] . '_' . $w . '_' . $h . '.' . $info['extension'];
        //dump($thumbname);exit;
        if(file_exists('.'.$thumbname)){
            return $info['dirname'] . '/_thumb/' . $info['filename'] . '_' . $w . '_' . $h . '.' . $info['extension'];
        }else{
            return $info['dirname'] .'/' .$info['filename'] . '.' .$info['extension'];
        }
    }


}
