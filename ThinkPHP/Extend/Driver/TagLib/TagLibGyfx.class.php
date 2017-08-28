<?php

defined('THINK_PATH') or exit();

/**
 * 管易分销前台模版自定义标签库
 * @package Extend
 * @subpackage  Driver.Taglib
 * @stage 7.0
 * @author  zuo <zuojianghua@guanyisoft.com>
 * @date 2013-03-19
 * @copyright Copyright (C) 2012, Shanghai GuanYiSoft Co., Ltd.
 */
class TagLibGyfx extends TagLib {

    protected $ary_data = array();

    // 标签定义
    protected $tags = array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        //'editor'    => array('attr'=>'id,name,style,width,height,type','close'=>1),
        //'select'    => array('attr'=>'name,options,values,output,multiple,id,size,first,change,selected,dblclick','close'=>0),
        //'grid'      => array('attr'=>'id,pk,style,action,actionlist,show,datasource','close'=>0),
        //'list'      => array('attr'=>'id,pk,style,action,actionlist,show,datasource,checkbox','close'=>0),
        //'imagebtn'  => array('attr'=>'id,name,value,type,style,click','close'=>0),
        //'checkbox'  => array('attr'=>'name,checkboxes,checked,separator','close'=>0),
        //'radio'     => array('attr'=>'name,radios,checked,separator','close'=>0)
        'link'  => array('attr' => 'name,order,sort,type,titlelen,row', 'close' => 1),
        'member'    => array('attr' => 'name,mid', 'close' => 1),
        'comment'  => array('attr' => 'name,gid,order,sort,is_ajax,titlelen,row,infolen,verify', 'close' => 1),
		'commentcount'  => array('attr' => 'name,gid,verify', 'close' => 1),
        'navigation'       =>array('attr' => 'name,row,position', 'close' => 1),
        'breadcrumbs'   => array('attr'=>'name,gid,titlelen,gname','close'=>1),
        'cart'      =>array('attr'=>'name,row,titlelen','close'=>1),
        'goodslist' => array('attr' => 'name,gname,gid,cid,bid,hot,new,order,num,start,pagesize,paged,startprice,endprice,type,tid,erpguid,path,grecommend,ggid,no_spec,no_paged.lid,did', 'close' => 1), //商品列表
        'goodsinfo' => array('attr' => 'name,gid,erpguid,showunsale,showcoolgoods,showcollectnum,showoromotion,nopromotion,nosku', 'close' => 1), //商品详情
        'goodscate' => array('attr' => 'name,cid,mod,gctype', 'close' => 1), //商品分类
        'goodsbrand' => array('attr' => 'name,bid,num,cid,mod', 'close' => 1),//商品品牌
        'goodstype' => array('attr' => 'name,gtid', 'close' => 1),//商品类型
        'skutype' => array('attr' => 'name,stid', 'close' => 1),//商品属性值
        'article' => array('attr' => 'name,cid,num,hot,atitile,titlelen,aid,p,pagesize,no_paged', 'close' => 1),    //文章资讯	
        'articleinfo' => array('attr' => 'name,aid', 'close' => 1),    //文章资讯	
        'articlecate' => array('attr' => 'name,caid,recommend,num,is_show', 'close' => 1),    //文章分类
        'notice' => array('attr' => 'name,pnid,num,titlelen', 'close' => 1),    //网站公告
        'catebreadcrumb'   => array('attr'=>'name,cid','close'=>1),	   //类目导航面包屑
        'sales'   => array('attr'=>'name,stime,etime,limit,titlelen,cid','close'=>1),	   //商品销量排行
        'browsehistory'   => array('attr'=>'name,stime,etime,limit,titlelen','close'=>1),	   //商品浏览历史排行
        'common'   => array('attr'=>'name','close'=>1),	   //获取公用信息
        'askedquestions'   => array('attr'=>'name,gid,p,pagesize,num','close'=>1),	   //顾客购买咨询
        'buyrecord'   => array('attr'=>'name,gid,p,pagesize,stime,etime,num,titlelen','close'=>1),	   //购买记录
        'onlineservice' => array('attr'=>'ocid','close'=>1),
        'collectgoods' => array('attr'=>'name','close'=>1),   //收藏商品排行
        'icp'=> array('attr'=>'icp','close'=>1),     //获取备案号
		'selectsql'=>array('attr'=>'name,page_name,limit,page,sql,cache,time','close'=>1),//name获取数据名称,page_name分页的名称,page分页开启,limit每页显示多少条，sql:查询内容
        'relegoodscate'=>array('attr' => 'name,cid,gname,bid,startprice,endprice', 'close' => 1), //根据当前的搜索条件，查询分类
		'relegoods'=>array('attr'=>'name,gid','close'=>1),//查询关联商品
		'unsalespecs'=>array('attr'=>'name,gid','close'=>1)//查询关联商品
	);
    /**
     * 处理tag标签 
     * @2013-07-01
     * @author wangguibin@guanyisoft.com
     * @param $tag
     * @param $tVar
     */
    public function handleTag($tag,$tVar){
         foreach ($tag as $_key => &$_val) {
            $str = $_val;
            if(!empty($_val) && $_val[0]=='$' ){
                //eval("\$str = \"$_val\";");
				//$tag[$_key] = $str;
				$str = substr($_val,1);
                if(false == strstr($str, '.')){
                	if(false == strstr($str, '[')){
                		//$tag[$_key] = $tVar[substr($str,1)];
                        //$str截取过一次，无须再次substr by Joe modify 2013-07-11
                       $tag[$_key] = $tVar[$str];
                	}else{
                		$str = substr($str,0,strlen($str)-1);
                		$_fix = explode('[',$str);
						$fix1 =  str_replace('"','',$_fix[1]);
						$fix1 =  str_replace("'",'',$_fix[1]);
						if(!empty($tVar[$_fix[0]][$fix1])){
							$tag[$_key] = $tVar[$_fix[0]][$fix1];
						}else{
							$tag[$_key] = '';
						}
                	}
                }else{
                    $_fix = explode('.', substr($_val,1));
					if(isset($tVar[$_fix[0]][$_fix[1]])){
						$tag[$_key] = $tVar[$_fix[0]][$_fix[1]];
					}
                }
            }
         }
		  //参数处理	
		$tag_input = $tag;
	    $tag = array();
		foreach($tag_input as $key=>$tag_info){
			if(!empty($tag_info)){
				$tag[$key] = $this->dowith_sql(addslashes($tag_info));
			}
		}
        return $tag;   	
    }
	
	//sql注入
	public function dowith_sql($str)
    {
		$str = str_replace(" and ","",$str);
		$str = str_replace("execute","",$str);
		$str = str_replace("update","",$str);
		$str = str_replace("count","",$str);
		$str = str_replace("chr","",$str);
		$str = str_replace("mid","",$str);
		$str = str_replace("master","",$str);
		$str = str_replace("truncate","",$str);
		$str = str_replace("char","",$str);
		$str = str_replace("declare","",$str);
		$str = str_replace("select","",$str);
		$str = str_replace("create","",$str);
		$str = str_replace("delete","",$str);
		$str = str_replace("insert","",$str);
		$str = str_replace("'","",$str);
		//$str = str_replace(""","",$str);
		$str = str_replace(" ","",$str);
		$str = str_replace("or","",$str);
		$str = str_replace("=","",$str);
		$str = str_replace("%20","",$str);
			//echo $str;
		return $str;
	}
	
    /**
     * 自定义用户登录信息标签
     * 支持的自定义标签有：
     *      标签    标签值                                  标签描述
     *      name                                           标签名
     *      mid     (默认显示0)                             用户登录者ID
     *      field   (默认显示所有，多个以,分割)              需要显示的信息
     *      (显示：
     *          level           会员等级
     *          balance         会员余额
     *          username        会员用户名
     *          group           会员组
     *          sex             会员性别
     *          address         会员地址
     *          birthday        会员生日
     *          zipcode         邮编
     *          email           邮箱
     *          telphone        电话
     *          mobile          手机
     *          wangwang        旺旺号
     *          qq              QQ号
     *          weburl          网店地址
     *          recommended     推荐人
     *          deposit         保证金
     *          time            注册时间
     *          alipay          支付宝账号
     *          cost            消费金额
     * <gyfx:member name='member' mid='10'></gyfx:member>
     * @param type $attr
     * @param type $content
     */
    public function _member($attr, $content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'goodslist');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        $name = $tag['name'];
        $mid = $tag['mid'];
        $member = M('view_members')->field("
            fx_view_members.m_mobile,
            fx_view_members.m_alipay_name,
            fx_view_members.m_security_deposit,
            fx_view_members.m_website_url,
            fx_view_members.m_email,
            fx_view_members.m_wangwang,
            fx_view_members.m_qq,
            fx_view_members.m_recommended,
            fx_view_members.ml_name,
            fx_view_members.m_balance,
            fx_view_members.m_name,
            fx_view_members.m_sex,
            fx_view_members.m_address_detail,
            fx_view_members.m_zipcode,
            fx_view_members.m_telphone
            ")
              ->where(array('m_id'=>$mid))
              ->find();
        if(!empty($member) && is_array($member)){
            $group = M('view_members_group')->field("mg_name")->where(array('m_id'=>$mid))->find();
            $member['group'] = $group['mg_name'];
        }
        $str_info = var_export($member, true);
        $parseStr = $parseStr . "<?php $$name = " . $str_info . "; ?>";
        $parseStr = $parseStr . $content;
        return $parseStr;

    }

    /**
     * 自定义
     * <gyfx:cart name='cart' gid='1' titlelen='8'></gyfx:cart>
     * 支持的自定义标签有：
     *      标签    标签值                                  标签描述
     *      name                                           标签名
     *      row    (默认显示10)                             购物车中商品分页(默认10)
     *      titlelen 商品长度
     * @param type $attr
     * @param type $content
     */
    public function _cart($attr, $content){
    	//暂时隐藏购物车标签
        $member = session("Members");
        $price = new PriceModel($member['m_id']);
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'cart');
        $name = $tag['name'];
        $row = !empty($tag['row']) ? $tag['row'] : '10';
        if(!empty($member['m_id'])){
        	$Cart = D('Cart');
        	$cart_data = $Cart->ReadMycart($cart_data);
        }else{
        	$cart_data = session("Cart");
        }
        //dump($cart_data);die();
        $list = array();
        if(!empty($cart_data) && is_array($cart_data)){
            $i = 0;
            $pdt_money = 0;
            $pdt_weight = 0;
            //print_r($Cart);exit;
            foreach($cart_data as $keycart=>$valcart){
                $where = array();
                $where['pdt_id'] = $keycart;
                $where['pdt_status'] = '1';
                $list['products'][$i] = D("GoodsProducts")->field("info.g_picture,info.g_name,info.g_id,info.g_price,pdt_id,pdt_sn,pdt_sale_price,pdt_weight,pdt_stock,erp_sku_sn")
                ->join('fx_goods_info as info ON fx_view_products.g_id = info.g_id')
                ->where($where)->find();
                //dump( D("GoodsProducts")->getLastSql());
                $list['products'][$i]["f_price"] = $price->getItemPrice($keycart);
                //dump($keycart);die();
                $list['products'][$i]['pdt_spec'] = D("GoodsSpec")->getProductsSpec($keycart);
                $list['products'][$i]['num'] = $valcart['num'];
                $pdt_money += sprintf("%0.2f", $valcart['num'] * $list['products'][$i]["f_price"]);
                $pdt_weight += sprintf("%0.2f",$list['products'][$i]["pdt_weight"]);
                $i++;
            }
        }
        //dump($list);die();
        if(empty($pdt_money)){
        	$pdt_money = 0;
        }
        if(empty($pdt_weight)){
        	$pdt_weight = 0;
        }
        $info = $list['products'];
        if(!empty($tag['titlelen']) && isset($tag['titlelen'])){
        	foreach($info as &$cart_list){
        		$cart_list['g_name'] = mb_substr($cart_list['g_name'], 0 ,$tag['titlelen'],"utf-8");
        	}
        }
        $pdt_num = !empty($list['products'])?count($list['products']):0;
        $str_list = var_export($info, true);
        $parseStr = $parseStr . "<?php $$name = " . $str_list . "; ?>";
        $parseStr = $parseStr . "<?php \$pdt['pdt_weight'] = " . $pdt_weight . "; ?>";
        $parseStr = $parseStr . "<?php \$pdt['pdt_money'] = " . $pdt_money . "; ?>";
        $parseStr = $parseStr . "<?php \$pdt['pdt_num'] = " . $pdt_num . "; ?>";
        $parseStr = $parseStr . '<volist name="cart" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }


    /**
     * 自定义商品面包屑导航
     * <gyfx:breadcrumb name='breadcrumb' gid='1' titlelen='8'></gyfx:breadcrumb>
     * 支持的自定义标签有：
     *      标签    标签值                                  标签描述
     *      name                                           标签名
     *      gid                                            商品ID
     *      gname                                           商品名称定义
     *      titlelen    (默认显示25)                        商品名称
     * @param type $attr
     * @param type $content
     * @author Terry<wanghui@guanyisoft.com>
     * @date 2013-3-28
     */
    public function _breadcrumbs($attr, $content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'breadcrumbs');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        $name = $tag['name'];

        $gname = !empty($tag['gname']) ? $tag['gname'] : 'gname';
        $gid = $tag['gid'];
        $condition = array();
        $condition[C('DB_PREFIX').'goods_info.g_id'] = $gid;
		/**
        $ary_goods=M('goods_info',C('DB_PREFIX'),'DB_CUSTOM')
             ->field(array(C('DB_PREFIX').'goods_category.*,'.C('DB_PREFIX')."goods_info.g_name"))
             ->join(C('DB_PREFIX').'related_goods_category ON '.C('DB_PREFIX').'related_goods_category.g_id = '.C('DB_PREFIX').'goods_info.g_id')
             ->join(C('DB_PREFIX').'goods_category ON '.C('DB_PREFIX').'goods_category.gc_id = '.C('DB_PREFIX').'related_goods_category.gc_id')
             ->where($condition)->find();
		**/
		$obj_query = M('goods_info',C('DB_PREFIX'),'DB_CUSTOM')
             ->field(array(C('DB_PREFIX').'goods_category.*,'.C('DB_PREFIX')."goods_info.g_name"))
             ->join(C('DB_PREFIX').'related_goods_category ON '.C('DB_PREFIX').'related_goods_category.g_id = '.C('DB_PREFIX').'goods_info.g_id')
             ->join(C('DB_PREFIX').'goods_category ON '.C('DB_PREFIX').'goods_category.gc_id = '.C('DB_PREFIX').'related_goods_category.gc_id')
             ->where($condition);
		$ary_goods = D('Gyfx')->queryCache($obj_query,'find');
//        echo "<pre>";echo M('goods_info',C('DB_PREFIX'),'DB_CUSTOM')->getLastSql();exit;
        $$gname = $ary_goods['g_name'];
        $list = $this->getCategory($ary_goods['gc_id']);
        if(!empty($tag['titlelen']) && isset($tag['titlelen'])){
            $$gname = mb_substr($ary_goods['g_name'], 0 ,$tag['titlelen'],"utf-8");
        }
        $cate_info = array();
        foreach($list as $key=>&$val){
        	$cate_info[$key]['cid'] = $key;
        	$cate_info[$key]['cname'] = $val;
        	$cate_info[$key]['gcurl'] = U('Home/Products/index/', array('cid' => $key));
        }
        unset($list);
        //dump($cate_info);die();
        $str_list = var_export($cate_info, true);
        $parseStr = $parseStr . "<?php \$breadcrumbs = " . $str_list . "; ?>";
        $parseStr = $parseStr . '<volist name="breadcrumbs" id="' . $name . '" >' . $content . '</volist>';
        isset($$gname) && $parseStr = $parseStr  . $$gname ;
        return $parseStr;
    }

    /**
     * 自定义类目面包屑导航
     * <gyfx:catebreadcrumb name='catebreadcrumb' gid='1' titlelen='8'></gyfx:catebreadcrumb>
     * 支持的自定义标签有：
     *      标签    标签值                                  标签描述
     *      name                                           标签名
     *      cid                                            商品ID
     * @param type $attr
     * @param type $content
     * @author wangguibin<wangguibin@guanyisoft.com>
     * @date 2013-04-12
     */
    public function _catebreadcrumb($attr, $content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'catebreadcrumb');
		$tag = $this->handleTag($tag, $tVar);
//        print_r($tVar['itemInfo']);//die();
        $name = $tag['name'];
        if(empty($tag['cid'])){
        	$tag['cid'] = null;
        }else{
	        $GoodCategory = D("GoodsCategory");
	        $ary_where = array();
	        $ary_where['gc_id'] = isset($tVar['itemInfo']['cid'])?$tVar['itemInfo']['cid']:null;
	        $ary_where['gc_status'] = '1';
	        $ary_res = array();
	        $i = 0;
	        $ary_cate = D('Gyfx')->selectOneCache('goods_category','gc_id,gc_name,gc_parent_id', $ary_where, $ary_order=null);	
			
                //print_r($ary_cate);exit;
	        if($ary_cate['gc_parent_id'] > 0){
	        	$i++;
	        	$parent_info = $this->getParentCategory($ary_cate['gc_parent_id'],$i);
	        }
                if(!empty($parent_info) && is_array($parent_info)){
                    $ary_res = array_reverse(array_merge(array($ary_cate),$parent_info));
                }else{
                    $ary_res = array_reverse(array_merge(array($ary_cate)));
                }
	        //dump($parent_info);
	        
//                echo "<pre>";print_r($ary_cate);exit;
//                echo $GoodCategory->getLastSql();exit;
        }
        $info = array();
        foreach($ary_res as $key=>&$ary){
        	$info[$key]['gcid'] = $ary['gc_id'];
        	$info[$key]['gcname'] = $ary['gc_name'];
        	$info[$key]['gcpid'] = $ary['gc_parent_id'];
        	$info[$key]['gcurl'] = U('Home/Products/index/', array('cid' => $ary['gc_id']));
        }
        unset($ary_res);//echo "<pre>";print_r($info);die();
        $str_list = var_export($info, true);
        
        $parseStr = $parseStr . "<?php \$catebreadcrumbs= " . $str_list . "; ?>";
        $parseStr = $parseStr . '<volist name="catebreadcrumbs" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }

    /**
     * 商品销量排行
     * <gyfx:sales name='sale' stime='2012-04-01' etime="2013-04-16" limit="5" titlelen='15'></gyfx:sales>
     * 支持的自定义标签有：
	 * 开始时间	stime
	 * 结束时间	etime
	 * 查询条数	limit
	 * 商品长度	titlelen
     * @param type $attr
     * @param type $content
     * @author wangguibin<wangguibin@guanyisoft.com>
     * @date 2013-04-12
     */
    public function _sales($attr, $content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'sales');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        $name = $tag['name'];
        $list = D('GoodsInfo')->HotCount(isset($tag['stime'])?$tag['stime']:null,isset($tag['etime'])?$tag['etime']:null,isset($tag['limit'])?$tag['limit']:null,null,null,isset($tag['cid'])?$tag['cid']:null);
        $sale_info = array();
        foreach($list as $key=>$sale){
        	$sale_info[$key]['gid'] = $sale['g_id'];
	        if(!empty($tag['titlelen']) && isset($tag['titlelen'])){
	           $sale_info[$key]['lgname'] = mb_substr($sale['oi_g_name'], 0 ,$tag['titlelen'],"utf-8");
	        }else{
	        	$sale_info[$key]['lgname'] = $sale['oi_g_name'];
	        }
	        $sale_info[$key]['gname'] = $sale['oi_g_name'];
        	$sale_info[$key]['gpicture'] = $sale['g_picture'];
			//$sale_info[$key]['gpicture'] = D('QnPic')->picToQn($sale_info[$key]['gpicture']);
        	$sale_info[$key]['gprice'] = $sale['g_price'];
        	$sale_info[$key]['gsales'] = $sale['num'];
        	$sale_info[$key]['gurl'] = U('Home/Products/detail', array('gid' => $sale['g_id']));
        }
        //dump($list);
        unset($list);
        $str_list = var_export($sale_info, true);
        //dump($str_list);die();
        $parseStr = $parseStr . "<?php \$sales= " . $str_list . "; ?>";
        $parseStr = $parseStr . '<volist name="sales" id="' . $name . '" key="k">' . $content . '</volist>';
        return $parseStr;
    }

    /**
     * 商品浏览历史
     * <gyfx:browsehistory name='browsehistory' stime='2012-04-01' etime="2013-04-16" limit="5" titlelen='15'></gyfx:browsehistory>
     * 支持的自定义标签有：
	 * 开始时间	stime
	 * 结束时间	etime
	 * 查询条数	limit
	 * 商品长度	titlelen
     * @param type $attr
     * @param type $content
     * @author wangguibin<wangguibin@guanyisoft.com>
     * @date 2013-04-23
     */
    public function _browsehistory($attr, $content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'browsehistory');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        $name = $tag['name'];
        $list = D('GoodsInfo')->BrowsehistoryCount($tag['stime'],$tag['etime'],$tag['limit']);
        $sale_info = array();
        foreach($list as $key=>$sale){
        	$sale_info[$key]['gid'] = $sale['g_id'];
	        if(!empty($tag['titlelen']) && isset($tag['titlelen'])){
	           $sale_info[$key]['lgname'] = mb_substr($sale['g_name'], 0 ,$tag['titlelen'],"utf-8");
	        }else{
	        	$sale_info[$key]['lgname'] = $sale['g_name'];
	        }
	        $sale_info[$key]['gname'] = $sale['g_name'];
        	$sale_info[$key]['gpicture'] = '/'.trim($sale['g_picture'],'/');
			if($_SESSION['OSS']['GY_QN_ON'] == '1'){
			$sale_info[$key]['gpicture'] = D('QnPic')->picToQn($sale_info[$key]['gpicture']);
			}
        	$sale_info[$key]['gprice'] = $sale['g_price'];
        	$sale_info[$key]['num'] = $sale['num'];
        	$sale_info[$key]['gurl'] = U('Home/Products/detail', array('gid' => $sale['g_id']));
        }
       	//dump($sale_info);die();
        //dump($list);DIE();
        unset($list);
        $str_list = var_export($sale_info, true);
        //dump($str_list);die();
        $parseStr = $parseStr . "<?php \$browsehistory= " . $str_list . "; ?>";
        $parseStr = $parseStr . '<volist name="browsehistory" id="' . $name . '" key="k">' . $content . '</volist>';
        return $parseStr;
    }

    /**
     * 分类面包屑导航
     * @author Terry<wanghui@guanyisoft.com>
     * @date 2013-3-28
     */
    public function getParentCategory($gcid,$i,$ary_res){
        $GoodCategory = D("GoodsCategory");
        $ary_where = array();
        $ary_where['gc_id'] = $gcid;
        $ary_where['gc_status'] = '1';
		$ary_cate = D('Gyfx')->selectOneCache('goods_category','gc_id,gc_name,gc_parent_id', $ary_where, $ary_order=null);
        if(!empty($ary_cate)){
        	$ary_res[] = $ary_cate;
        	$i++;
             if(!empty($ary_cate['gc_parent_id'])){
             	$ary_cate1 = $GoodCategory->field('gc_id,gc_name,gc_parent_id')->where(array('gc_id'=>$ary_cate['gc_parent_id'],'gc_status'=>'1'))->find();
             	$ary_res[] = $ary_cate1;
       		 }
        }
        //dump($ary_res);//die();
        return $ary_res;
    }

    /**
     * 获取父分类
     * @author Terry<wanghui@guanyisoft.com>
     * @date 2013-3-28
     */
    public function getCategory($gcid,$ary_category=''){
        //$GoodCategory = D("GoodsCategory");
        $ary_where = array();
		if(isset($gcid) && !empty($gcid)){
			$ary_where['gc_id'] = $gcid;
		}
        $ary_where['gc_status'] = '1';
        $ary_cate = D('Gyfx')->selectOneCache('goods_category',null, $ary_where);
		//$GoodCategory->where($ary_where)->find();
        $ary_res = array();
        if(is_array($ary_cate) && $ary_cate['gc_parent_id'] > 0){
                $ary_res = $this->getCategory($ary_cate['gc_parent_id'],$ary_category);
        }
        $ary_res[$ary_cate['gc_id']] = $ary_cate['gc_name'];
        return $ary_res;
    }


    /**
     * 自定义主导航标签
     * <gyfx:navigation name='navigation' row='8' position="middle"></gyfx:navigation>
     * @param type $attr
     * @param type $content
     */
    public function _navigation($attr, $content){
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'navigation');
        //dump($tag);die();
        $name = $tag['name'];
        $row = !empty($tag['row']) ? $tag['row'] : '8';
        $position = !empty($tag['position']) ? $tag['position'] : 'top';
		//实例化缓存
		if(C('DATA_CACHE_TYPE') == 'MEMCACHED' && C('MEMCACHED_OCS') == true){
			$memcaches = new Cacheds();
		}else{
			$memcaches = new Caches();
		}
		//生成一个用来保存 namespace 的 key  
		if($memcaches->getStat()){
			$ns_key = $memcaches->C()->get(CI_SN."_namespace_key");  
			//如果 key 不存在，则创建，默认使用当前的时间戳作为标识
			if($ns_key===false) $memcaches->C()->set(CI_SN."_namespace_key",time());  
		}
        //根据tag获取缓存key
        $cache_key = json_encode($tag).CI_SN;
		$cache_key = $ns_key.$cache_key;
        if($memcaches->getStat() && ini_get('memcache.allow_failover')&& $ary_return = $memcaches->C()->get($cache_key)){
            $list = json_decode($ary_return,true);
           
        }else{
            $list = D("Nav")->where(array('n_status'=>'1','n_position'=>$position))
            ->field('n_id as nid,n_name as nname,n_url as nurl,n_target as ntarget, n_order as norder ')
            ->order(array('n_order' => 'asc'))->limit($row)->select();
            //处理数据
            if(!empty($list) && is_array($list)){
                foreach($list as &$slist){
                    if(strstr($slist['nurl'],"?")){
                        $slist['nurl'] = $slist['nurl'].'&name='.$slist['nname'];
                    }else{
                        $slist['nurl'] = $slist['nurl'];
                    }
                }
            }
            if($memcaches->getStat() && ini_get('memcache.allow_failover')){
                $memcaches->C()->set($cache_key,json_encode($list));
            }
        }
        $count = count($list);
        $str_list = var_export($list, true);
        $parseStr = $parseStr . "<?php $$name = " . $str_list . "; ?>";
        $parseStr = $parseStr . "<?php \$nav_count = " . $count . "; ?>";
        $parseStr = $parseStr . '<volist name="nav" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }

    /**
     * 自定义商品评论列表
     * 支持的自定义标签有：
     *      标签    标签值                                  标签描述
     *      gid                                             商品ID
     *      name                                            标签名
     *      order   time                                    排序
     *      sort    desc,asc(默认显示desc)                  desc：降序  asc：升序
     *      is_ajax 0：否，1：是                             是否为异步分页
     *      titlelen                                        标题显示文字的长度(为整数值)
     *      infolen                                         评论长度(为整数值)
     *      row     (默认显示10)                             显示评论个数(为整数值)
     *      verify  all：显示全部（默认显示已审核）            是否显示全部评论
     * <gyfx:comment name='comment' num='10'></gyfx:comment>
     * @param type $attr
     * @param type $content
     */
    public function _comment($attr,$content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'comment');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        //后台评论设置
 		$comment = D('SysConfig')->getCfgByModule('goods_comment_set',1);
    	$comment['comment_show_condition'] = explode(',',$comment['comment_show_condition']);
    	//dump($comment);die();
        $name = $tag['name'];
        $order = !empty($tag['order']) ? $tag['order'] : 'time';
        $sort = !empty($tag['sort']) ? $tag['sort'] : 'desc';
        $is_ajax = !empty($tag['is_ajax']) ? $tag['is_ajax'] : '1';
        if(!empty($comment['show_nums'])){
        	$row = $comment['show_nums'];
        }else{
        	$row = !empty($tag['row']) ? $tag['row'] : '10';
        }
        $where = array();
        $orders = array();
        if($order == 'time'){
            $orders['fx_goods_comments.gcom_create_time']   = $sort;
        }
        if(!empty($tag['gid'])){
            $where['fx_goods_comments.g_id'] = $tag['gid'];
        }
        //$where['fx_goods_comments.gcom_parentid'] = '0';
        if(empty($tag['verify']) && $tag['verify'] != 'all' && $comment['comment_show_condition'][0] == '0'){
            $where['fx_goods_comments.gcom_verify'] = '1';
        }
        $where['fx_goods_comments.gcom_status']    = '1';
       // $count = D('GoodsComments')->where($where)->count();
		$count = D('Gyfx')->getCountCache('goods_comments',$where,600);
        $obj_page = new Pager($count, $row);
        $obj_query = D('GoodsComments')->field(" fx_members.m_name,fx_goods_comments.*")
                                  ->join("fx_members ON fx_members.`m_id`=fx_goods_comments.`m_id` ")
                                  ->where($where)->order($orders)->limit($obj_page->firstRow, $obj_page->listRows);
								  //->select();
        //echo "<pre>";print_r($list);exit;
		$list = D('Gyfx')->queryCache($obj_query,'',600);
        if(!empty($list) && is_array($list)){
            foreach($list as $key=>$val){
                if(!empty($tag['titlelen']) && isset($tag['titlelen'])){
                    $list[$key]['gcom_title'] = mb_substr($val['gcom_title'], 0 ,$tag['titlelen'],"utf-8");
                }
                if(!empty($tag['infolen']) && isset($tag['infolen'])){
                    $list[$key]['gcom_content'] = mb_substr($val['gcom_content'], 0 ,$tag['infolen'],"utf-8");
                }
                //dump($val['gcom_parentid']);
                if(!empty($val['gcom_parentid'])){
                	//dump($val['gcom_parentid']);die();
	                $parent_data = $this->_getComment($val['gcom_parentid']);
	                $list[$key]['gcom'] = $parent_data;
	                unset($parent_data);
                }
            }
        }
        //echo "<pre>";print_r($list);exit;
        $page = $obj_page->show();
        $pagearr = $obj_page->showArr();
        //dump($pagearr);die();
        $str_list = var_export($list, true);
        $str_pageinfo = var_export($page, true);
        $str_pagearr = var_export($pagearr, true);
        //dump($pagearr);die();
        $parseStr = $parseStr . "<?php $$name = " . $str_list . "; ?>";
        $parseStr = $parseStr . $content;
        $parseStr = $parseStr . "<?php \$pageinfo['$name'] = " . $str_pageinfo . "; ?>";
        $parseStr = $parseStr . "<?php \$pagearr['$name'] = " . $str_pagearr . "; ?>";
        return $parseStr;
    }


    public function _getComment($gcid){
        $where = array();
        $orders = array();
        $orders['fx_goods_comments.gcom_create_time']   = "desc";
        $where['fx_goods_comments.gcom_id'] = $gcid;
        $where['fx_goods_comments.gcom_verify'] = '2';
        $where['fx_goods_comments.gcom_status']    = '1';
        //$list = D('GoodsComments')->field(" fx_goods_comments.*")
                                //  ->where($where)->order($orders)->find();
		$list = D('Gyfx')->selectOneCache('goods_comments','fx_goods_comments.*', $where, $ary_order=null,600);								  
								  
                                  //dump(D('GoodsComments')->getLastSql());die();
//        if(!empty($list) && is_array($list)){
//            $ary_data[] = $list;
//            if(!empty($list['gcom_parentid']) && (int)$list['gcom_parentid']>0){
//                if(is_array($this->_getComment($list['gcom_parentid']))){
//                    array_push($ary_data, $this->_getComment($list['gcom_parentid']));
//                }
//            }
//        }
        return $list;
    }
	
	/**
     * 自定义商品评论星星数
     * 支持的自定义标签有：
     *      标签    标签值                                  标签描述
     *      gid                                             商品ID
     *      name                                            标签名
     *      verify  all：显示全部（默认显示已审核）         是否显示全部评论
	 * <gyfx:commentcount name='返回数据变量名' gid='商品ID' verify='0' ></gyfx:commentcount>
     * @param type $attr
     * @param type $content
     */
    public function _commentcount($attr,$content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'commentcount');
		$tag = $this->handleTag($tag, $tVar);
        //后台评论设置
 		$comment = D('SysConfig')->getCfgByModule('goods_comment_set',1);
    	$comment['comment_show_condition'] = explode(',',$comment['comment_show_condition']);
        $name = $tag['name'];
        $where = array();
        if(!empty($tag['gid'])){
            $where['fx_goods_comments.g_id'] = $tag['gid'];
        }
        if(empty($tag['verify']) && $tag['verify'] != 'all' && $comment['comment_show_condition'][0] == '0'){
            $where['fx_goods_comments.gcom_verify'] = '1';
        }
        $where['fx_goods_comments.gcom_status']    = '1';
        $where['fx_goods_comments.gcom_parentid']    = '0';
		$list = D('GoodsComments')->field(" fx_goods_comments.gcom_star_score")->where($where)->select();
		$int_score=0;
		$int_num=0;
		$ary_res=array();
		if(!empty($list) && is_array($list)){
            foreach($list as $key=>$val){
				$int_score+=$val['gcom_star_score'];
				$int_num++;
            }
        }
		$avg_score=$int_score/$int_num;
		$int_star=ceil($avg_score); 
		$ary_res['star']=$int_star."%";
		$ary_res['num']=$int_num;
		$str_list = var_export($ary_res, true);
        $parseStr = $parseStr . "<?php $$name = " . $str_list . "; ?>";
		$parseStr = $parseStr . $content;
        return $parseStr;
    }

    /**
     * 自定义友情链接标签
     * 支持的自定义标签有：
     *      标签    标签值                                  标签描述
     *      name                                           标签名
     *      order   order,time(默认显示order)               排序
     *      sort    desc,asc(默认显示desc)                  desc：降序  asc：升序
     *      type    images,textall(默认显示0)         		1:显示图片images:图片链接 0:显示文字textall:文字链接
     *      titlelen                                        站点文字的长度(为整数值)
     *      row     (默认显示10)                            链接数量(为整数值)
     * <gyfx:link name='link'></gyfx:link>
     * @param type $attr
     * @param type $content
     * @return string
     */
    public function _link($attr, $content){
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'link');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        $name = $tag['name'];
        $order = !empty($tag['order']) ? $tag['order'] : 'order';
        $sort = !empty($tag['sort']) ? $tag['sort'] : 'desc';
        $type = !empty($tag['type']) ? $tag['type'] : '';
        $row = !empty($tag['row']) ? $tag['row'] : '10';
        $where = array();
        $orders = array();
        if($order == 'time'){
            $orders['ul_create_time']   = $sort;
        }else{
            $orders['ul_order']   = $sort;
        }
		$where['ul_status'] = '1';
        if($type == '0'){
            $where['ul_is_image_link'] =  '0';
        }
		if($type == '1'){
            $where['ul_is_image_link'] =  '1';
        }
		//实例化缓存
		if(C('DATA_CACHE_TYPE') == 'MEMCACHED' && C('MEMCACHED_OCS') == true){
			$memcaches = new Cacheds();
		}else{
			$memcaches = new Caches();
		}
		//生成一个用来保存 namespace 的 key  
		if($memcaches->getStat()){
			$ns_key = $memcaches->C()->get(CI_SN."_namespace_key");  
			//如果 key 不存在，则创建，默认使用当前的时间戳作为标识
			if($ns_key===false) $memcaches->C()->set(CI_SN."_namespace_key",time());  
		}		
        //根据tag获取缓存key
        $cache_key = json_encode($tag).CI_SN;
		$cache_key = $ns_key.$cache_key;
		$cache_key = md5($cache_key);
        if($memcaches->getStat() && ini_get('memcache.allow_failover')&& $ary_return = $memcaches->C()->get($cache_key)){
            $list = json_decode($ary_return,true);
        }else{
			$list = D('UsefulLinks')->order($orders)->where($where)->limit($row)->select();
			$count = D('UsefulLinks')->order($orders)->where($where)->limit($row)->count();
			
			if(!empty($list) && is_array($list)){
				foreach($list as $key=>$val){
					if(!empty($tag['titlelen']) && isset($tag['titlelen'])){
						$list[$key]['ul_name'] = mb_substr($val['ul_name'], 0 ,$tag['titlelen'],"utf-8");
					}
					$list[$key]['nums'] = $count;
					if($_SESSION['OSS']['GY_QN_ON'] == '1'){
					$list[$key]['ul_image_path'] = D('QnPic')->picToQn($list[$key]['ul_image_path']);
					}
				}
			}
            if($memcaches->getStat() && ini_get('memcache.allow_failover')){
                $memcaches->C()->set($cache_key,json_encode($list));
            }
        }
        $str_list = var_export($list, true);
        $parseStr = $parseStr . "<?php \$link = " . $str_list . "; ?>";
        $parseStr = $parseStr . '<volist name="link" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }

    /**
     * 自定义商品列表标签
     * <gyfx:goodslist name='返回数据变量名' gname='商品名称' gid='商品ID' cid='分类ID' bid='品牌ID' hot='是否热销' new='是否新品' order='排序默认时间逆序' num='数量' start='偏移量' pagesize=’每页显示条数','type'='商品类型','ggid'='商品分组id'></gyfx:goodslist>
     * 示例:<gyfx:goodslist name='返回数据变量名' gid='24' hot='0' ></gyfx:goodslist>
     * @param type $attr
     * 备注：hot(是否热销产品1是0不是)、new(是否新品上架1是0不是)、order(_new:时间逆序,new:时间正序,price:价格从低到高，_price:价格从高到低,_hot:销量从低到高，hot:销量从高到低,)
     * @param type $content
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-03-26
     */
    public function _goodslist($attr, $content) {
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'goodslist');
		$tVar = $this->tpl->tVar;
		$tag = $this->handleTag($tag, $tVar);
        $list = D('ViewGoods')->goodList($tag);
        $path = !empty($tag['path'])?$tag["path"]:'';
		if(is_array($list['list'])){
			foreach($list['list'] as $key=>$val){
				$list['list'][$key]['market_price'] = isset($tag['market_price'])?$tag['market_price']:0;
				$list['list'][$key]['column'] = isset($tag['column'])?$tag['column']:'';
				$list['list'][$key]['sale_price'] = isset($tag['sale_price'])?$tag['sale_price']:0;
				$list['list'][$key]['discount_price'] = isset($tag['discount_price'])?$tag['discount_price']:0;
				$list['list'][$key]['a'] = isset($tag['a'])?$tag['a']:'';
				$list['list'][$key]['show_name'] = isset($tag['show_name'])?$tag['show_name']:'';
				$list['list'][$key]['show_pic'] = isset($tag['show_pic'])?$tag['show_pic']:'';
				$list['list'][$key]['g_nums'] = isset($tag['g_nums'])?$tag['g_nums']:0;
				$list['list'][$key]['g_instead'] = isset($tag['g_instead'])?$tag['g_instead']:'';
				$list['list'][$key]['hc_nums'] = isset($tag['hc_nums'])?$tag['hc_nums']:'';
				$list['list'][$key]['hcid'] = isset($tag['hcid'])?$tag['hcid']:'';
			}		
		}
        $name = isset($tag['name'])?$tag['name']:'';
        $goods = $list['list'];
        $page = $list['pageinfo'];
        $str_goods = var_export($goods, true);
        $str_pageinfo = var_export($page, true);
        $str_pagearr = var_export($list['pagearr'], true);
        $type = $list['type'];
        $str_type = var_export($type, true);
        
        $spec = $list['spec'];
        $str_spec = var_export($spec, true);
        
        $parseStr = $parseStr . "<?php \$goodslist = " . $str_goods . "; ?>";
        $parseStr = $parseStr . '<volist name="goodslist" id="' . $name . '" >' . $content . '</volist>';
        $parseStr = $parseStr . "<?php \$type['$name'] = " . $str_type . "; ?>";
        $parseStr = $parseStr . "<?php \$spec['$name'] = " . $str_spec . "; ?>";
        if(!empty($tag['pagesize'])){
           $parseStr = $parseStr . "<?php \$pageinfo['$name'] = " . $str_pageinfo . "; ?>";
            $parseStr = $parseStr . "<?php \$pagearr['$name'] = " . $str_pagearr . "; ?>";
        }
        
//        print_r($parseStr);exit;
        return $parseStr;
    }

    /**
     * 自定义商品详情标签
     * <gyfx:goodsinfo name='返回数据变量名' gid='商品ID' ></gyfx:goodslist>
     * 示例:<gyfx:goodslist name='list' gid='24' hot='0' ></gyfx:goodsinfo>
     * @param type $attr
     * @param type $content
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-03-27
     */
    public function _goodsinfo($attr, $content) {
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'goodsinfo');
        $tag = $this->handleTag($tag, $tVar);
        $info = D('ViewGoods')->goodDetail($tag,true);
		//print_r($info);exit;
        $name = $tag['name'];
        $good = $info['list'];
        $page = $info['pageinfo'];
        $str_good = var_export($good, true);
        $str_pageinfo = var_export($page, true);
        $parseStr = $parseStr . "<?php $$name = " . $str_good . "; ?>";
        $parseStr = $parseStr . $content;
        $parseStr = $parseStr . "<?php \$pageinfo['$name'] = " . $str_pageinfo . "; ?>";
        return $parseStr;
    }

    /**
     * 自定义商品类目标签
     * <gyfx:goodscate name='返回数据变量名' cid='类ID' ></gyfx:goodscate>
     * 示例:<gyfx:goodscate name='list' cid='24'  ></gyfx:goodscate>
     * @access public
     * @param string $attr 标签属性
     * @return array
     * 分类ID	cid
	 * 分类名称	cname
	 * 分类层级	clevel
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-03-29
     */
    public function _goodscate($attr,$content) {
    	$parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'goodscate');
        //print_r($tag);//die();
        if(empty($tag['cid'])){
        	$tag['cid'] = null;
        }
		$tVar = $this->tpl->tVar;
		$tag = $this->handleTag($tag, $tVar);
		$int_cid = null;
		$int_gctype = 0;
		if(isset($tag['cid'])){
			$int_cid = $tag['cid'];
		}
		if(isset($tag['gctype'])){
			$int_gctype = $tag['gctype'];
		}
        $cate_info = D('ViewGoods')->getInfo($int_cid,null,$int_gctype,true);
        $name = $tag['name'];
        $str_cate = var_export($cate_info, true);
        if(!isset($tag['mod']) || !$tag['mod']) $tag['mod'] = 2;
        $parseStr = $parseStr . "<?php \$cateslist = " . $str_cate . "; ?>";
        $parseStr = $parseStr . '<volist name="cateslist" id="' . $name . '" key="k" mod="'.$tag['mod'] .'">' . $content . '</volist>';
        // echo "<pre>";print_r($parseStr);die();
        return $parseStr;
    }

    /**
     * goodsbrand标签解析
     * 格式： <html:goodsbrand type="" bid="" value="" />
     * @access public
     * @param string $attr 标签属性 bid
     * @return array
     * 品牌ID	bid
	 * 品牌名称	bname
	 * 品牌图片	bpic
	 * 品牌URL	burl
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-03-26
     */
    public function _goodsbrand($attr,$content) {
    	$parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'goodsbrand');              //名称
		$tag = $this->handleTag($tag, $tVar);
		//print_r($tag);
        $obj_viewGoods = D('ViewGoods');
		$tag['gbids']=array('status'=>0,'data'=>array());
		if(isset($tag['cid']) && !empty($tag['cid']) && is_numeric($tag['cid'])) {
			//echo "11";
		    $ary_gb_ids = $obj_viewGoods->getBrandsByCatId($tag['cid'],true);
			//echo $obj_viewGoods->getLastsql();
			//print_r($ary_gb_ids);
			if(null !== $ary_gb_ids) $tag['gbids'] = array('status'=>1,'data'=>$ary_gb_ids);
			else $tag['gbids'] = array('status'=>1,'data'=>array());
		}
		
        //得到所有品牌
        $info = $obj_viewGoods->getBrands($tag);
        $name = $tag['name']; //名称
		$brand_info = array();
        foreach($info as $key=>$brand){
        	$brand_info[$key]['bid'] = $brand['gb_id'];
        	$brand_info[$key]['bname'] = $brand['gb_name'];
        	$brand_info[$key]['bpic'] = $brand['gb_logo'];
        	$brand_info[$key]['burl'] = U('Home/Products/index',array('bid'=>$brand['gb_id']));
            $brand_info[$key]['first_letter'] = $this->getfirstchar($brand['gb_name']); //根据品牌名称获取对应的首字的首字母
        }
        unset($info);
        //dump($brand_info);die();
        //if(!$tag['mod']) $tag['mod'] = 2;
		$tag['mod'] = 2;
        $str_brand = var_export($brand_info, true);
        $parseStr = $parseStr . "<?php \$brandlist = " . $str_brand . "; ?>";
        $parseStr = $parseStr . '<volist name="brandlist" id="' . $name . '" mod="'.$tag['mod'].'" >' . $content . '</volist>';
        return $parseStr;
    }
    
    /**
     * onlineservice标签解析
     * 格式： <html:onlineservice ocid="" />
     * @access public 
     * @param string $attr 标签属性 ocid
     * @return array 客服分组 信息
     * @author Joe <qianyijun@guanyisoft.com>
     * @date 2013-10-28
     */
    public function _onlineservice($attr,$content){
        $parseStr = '';
        $tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'onlineservice');
        $tag = $this->handleTag($tag,$tVar);
        $name = $tag['name']; //名称
        $onlie_service = D('OnlineService');
        //获取客服信息
        $on_service_info = $onlie_service->getOnlineService($tag);
        
        $on_service_info = var_export($on_service_info, true);
        $parseStr = $parseStr . "<?php \$onlineservice = " . $on_service_info . "; ?>";
        $parseStr = $parseStr . '<volist name="onlineservice" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
        
    }

    /**
     * notice标签解析
     * 格式： <html:notice type="" pnid="" num="" />
     * @access public
     * @param string $attr 标签属性 pnid
     * @return array
     * 公告ID	pnid
	 * 公告名称	bname
	 * 公告内容	bpic
	 * 发布时间	pntime
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-04-10
     */
    public function _notice($attr,$content) {
    	$parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'notice');              //名称
		$tag = $this->handleTag($tag, $tVar);
        //echo "<pre>";print_r($tag);die();
        //得到公告
        $noticeObj = D('PublicNotice');
        $where = array('pn_status'=>'1','pn_is_all'=>'1');
        if(!empty($tag['pnid'])){
        	$where['pn_id'] = $tag['pnid'];
        }
        if(!empty($tag['num'])){
        	$num = $tag['num'];
        }else{
        	$num = 100;
        }
		//实例化缓存
		if(C('DATA_CACHE_TYPE') == 'MEMCACHED' && C('MEMCACHED_OCS') == true){
			$memcaches = new Cacheds();
		}else{
			$memcaches = new Caches();
		}
		//生成一个用来保存 namespace 的 key  
		if($memcaches->getStat()){
			$ns_key = $memcaches->C()->get(CI_SN."_namespace_key");  
			//如果 key 不存在，则创建，默认使用当前的时间戳作为标识
			if($ns_key===false) $memcaches->C()->set(CI_SN."_namespace_key",time());  
		}
        //根据tag获取缓存key
        $cache_key = json_encode($tag).CI_SN;
		$cache_key = $ns_key.$cache_key;
		$notice_info = array();
        if($memcaches->getStat() && ini_get('memcache.allow_failover')&& $ary_return = $memcaches->C()->get($cache_key)){
            $notice_info = json_decode($ary_return,true);
        }else{
			$list = $noticeObj->field('pn_id,pn_title,pn_content,pn_create_time')
									->where($where)
									->order('pn_is_top desc,pn_create_time desc')
									->limit($num)
									->select();
			foreach($list as $key=>$notice){
				$notice_info[$key]['pnid'] = $notice['pn_id'];
				$notice_info[$key]['pntitle'] = $notice['pn_title'];
			   if(!empty($tag['titlelen']) && isset($tag['titlelen'])){
					if(strlen($notice['pn_title'])>$tag['titlelen']*2){
						$notice_info[$key]['pntitle'] = mb_substr($notice['pn_title'], 0 ,$tag['titlelen'],"utf-8").'...';
					}
				}
				$notice_info[$key]['pncontent'] = $notice['pn_content'];
				$notice_info[$key]['pncontent'] = D('ViewGoods')->ReplaceItemDescPicDomain($notice_info[$key]['pncontent']);
				$notice_info[$key]['pntime'] = $notice['pn_create_time'];
				$notice_info[$key]['pnurl'] = U('Ucenter/Notice/pageRead', array('pnid' => $notice['pn_id']));
			}
			unset($list);							
            if($memcaches->getStat() && ini_get('memcache.allow_failover')){
                $memcaches->C()->set($cache_key,json_encode($notice_info));
            }
        }
		$name = $tag['name']; //名称
        //dump($noticeObj->getLastSql());
        $str_notice = var_export($notice_info, true);
        $parseStr = $parseStr . "<?php \$noticelist = " . $str_notice . "; ?>";
        $parseStr = $parseStr . '<volist name="noticelist" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }

    /**
     * article标签解析
     * 格式： <html:article type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
	 * 文章分类	cid
	 * 数量	num
	 * 热门标记	hot
	 * 文章标题  atitle
	 * 文章ID   aid
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-03-26
     */
    public function _article($attr,$content) {
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'article');
		$tVar = $this->tpl->tVar;
		$tag = $this->handleTag($tag, $tVar);
        $list = D('Article')->pageList($tag);
        //echo "<pre>";print_r($list);exit;
        $name = $tag['name'];
        $articles = $list['list'];
        $page = $list['pageinfo'];
        $pagearr = $list['pagearr'];
        $str_articles = var_export($articles, true);
        $str_pageinfo = var_export($page, true);
        $str_pagearr = var_export($pagearr, true);
        $parseStr = $parseStr . "<?php \$$name = " . $str_articles . "; ?>";
        //$parseStr = $parseStr . '<volist name="articleslist" id="' . $name . '" >' . $content . '</volist>';
        $parseStr = $parseStr . "<?php \$pageinfo['$name'] = " . $str_pageinfo . "; ?>";
        $parseStr = $parseStr . "<?php \$pagearr['$name'] = " . $str_pagearr . "; ?>";
        $parseStr = $parseStr . $content;
        //dump($parseStr);die();
        return $parseStr;
    }

	/**
     * articleinfo标签解析
     * 格式： <html:articleinfo type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
	 * 文章ID   aid
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-04-02
     */
    public function _articleinfo($attr,$content) {
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'articleinfo');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        $name = $tag['name'];
        $list = D('Article')->getArticleInfo($tag);
        $articles = $list;
        //dump($articles);die();
        $str_articles = var_export($articles, true);
        $parseStr = $parseStr . "<?php $$name = " . $str_articles . "; ?>";
        $parseStr = $parseStr . $content;
        return $parseStr;
    }
    
    
    /**
     * articlecate标签解析
     * 格式： <html:articlecate type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
	 * 文章分类ID   acid
	 * 显示推荐 recommend
	 * 显示类目数量 num
	 * 是否显示文章 is_show
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-04-02
     */
    public function _articlecate($attr,$content) {
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'articleinfo');
		$tag = $this->handleTag($tag, $tVar);
        
        $name = $tag['name'];
        $list = D('Article')->getCateInfo($tag);
        $articleCate = $list;
        $str_articles = var_export($articleCate, true);
        //echo "<pre>";print_r($str_articles);die();
        $parseStr = $parseStr . "<?php $$name = " . $str_articles . "; ?>";
        $parseStr = $parseStr . $content;
        return $parseStr;
        
    }


  	/**
     * common标签解析
     * 格式： <html:common />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-05-06
     */
    public function _common($attr,$content) {
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'common');
        $name = $tag['name'];
		$info = D('SysConfig')->getCfgByModule('GY_SHOP',1);
		if($_SESSION['OSS']['GY_QN_ON'] == '1'){
			$info['GY_SHOP_LOGO'] = D('QnPic')->picToQn($info['GY_SHOP_LOGO']);
			$info['GY_SHOP_QC_LOGO'] = D('QnPic')->picToQn($info['GY_SHOP_QC_LOGO']);
		}
        $comment = D('SysConfig')->getCfgByModule('goods_comment_set',1);
		if(!empty($comment)){
			$comment['comment_show_condition'] = explode(',',$comment['comment_show_condition']);
		}
        $str_articles = var_export($info, true);
        $str_comments = var_export($comment, true);
		$ary_top_ads = var_export($this->getTopAds(), true);
        //dump($comment);die();
        $parseStr = $parseStr . "<?php $$name = " . $str_articles . "; ?>";
        $parseStr = $parseStr . "<?php \$cfg = " . $str_comments . "; ?>";
		$parseStr = $parseStr . "<?php \$ary_top_ads = " . $ary_top_ads . "; ?>";
        $parseStr = $parseStr . $content;
        return $parseStr;
    }
    /**
     * 获得顶部广告图
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @version 7.6 
     * @date 2014-06-10
     */
    public function getTopAds() {
		$ary_ads = D('SysConfig')->getConfigs('GY_SHOP_TOP_AD','','','',1);
		if($_SESSION['OSS']['GY_QN_ON'] == '1'){
		$ary_ads['APP_ICO_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['APP_ICO_PIC']['sc_value']['sc_value']);
		$ary_ads['APP_LOGIN_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['APP_LOGIN_PIC']['sc_value']);		
		$ary_ads['APP_LOGO_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['APP_LOGO_PIC']['sc_value']);	
		$ary_ads['APP_REGISTER_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['APP_REGISTER_PIC']['sc_value']);	
		$ary_ads['APP_LOGO_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['APP_LOGO_PIC']['sc_value']);	
		$ary_ads['BIG_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['BIG_PIC']['sc_value']);
		$ary_ads['BOTTOM_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['BOTTOM_PIC']['sc_value']);
		$ary_ads['LOGIN_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['LOGIN_PIC']['sc_value']);
		$ary_ads['REGISTER_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['REGISTER_PIC']['sc_value']);
		$ary_ads['SMALL_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['SMALL_PIC']['sc_value']);
		$ary_ads['RIGHT_PIC']['sc_value'] = D('QnPic')->picToQn($ary_ads['RIGHT_PIC']['sc_value']);
		}
		if(empty($ary_ads)){
			if($ary_ads['STATE']['sc_value'] == '1'){
				if(!empty($_SESSION[CI_SN.'showAd'])){
					$_SESSION[CI_SN.'showAd'] = 1;
				}else{
					$ary_ads['STATE']['sc_value'] = 2;
				}		
			}			
		}
		
		$ary_ads_data = array();
		//大小两图
		if(isset($ary_ads['STATE']['sc_value']) && $ary_ads['STATE']['sc_value'] == '1'){
			$ary_ads_data['big_pic'] = $ary_ads['BIG_PIC']['sc_value'];
			$ary_ads_data['big_pic_url'] = $ary_ads['BIG_PIC_URL']['sc_value'];
			$ary_ads_data['small_pic'] = $ary_ads['SMALL_PIC']['sc_value'];
			$ary_ads_data['small_pic_url'] = $ary_ads['SMALL_PIC_URL']['sc_value'];
		}
		//只显示小图
		if(isset($ary_ads['STATE']['sc_value']) && $ary_ads['STATE']['sc_value'] == '2'){
			$ary_ads_data['small_pic'] = $ary_ads['SMALL_PIC']['sc_value'];
			$ary_ads_data['small_pic_url'] = $ary_ads['SMALL_PIC_URL']['sc_value'];		
		}	
		if(isset($ary_ads['RIGHT_PIC']['sc_value']) && !empty($ary_ads['RIGHT_PIC']['sc_value'])){
			$ary_ads_data['right_pic'] = $ary_ads['RIGHT_PIC']['sc_value'];
			if(isset($ary_ads['RIGHT_PIC_URL']['sc_value'])){
                $ary_ads_data['right_pic_url'] = $ary_ads['RIGHT_PIC_URL']['sc_value'];
            }
		}
		if(isset($ary_ads['BOTTOM_PIC']['sc_value']) && !empty($ary_ads['BOTTOM_PIC']['sc_value'])){
			$ary_ads_data['bottom_pic'] = $ary_ads['BOTTOM_PIC']['sc_value'];
			if(isset($ary_ads['BOTTOM_PIC_URL']['sc_value'])){
                $ary_ads_data['bottom_pic_url'] = $ary_ads['BOTTOM_PIC_URL']['sc_value'];
            }
		}		
		
		return $ary_ads_data;
    }
  	/**
     * goodstype标签解析
     * 格式： <html:goodstype type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
	 * 文章ID   gtid
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-04-02
     */
    public function _goodstype($attr,$content) {
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'goodstype');
		$tag = $this->handleTag($tag, $tVar);
        //print_r($tag);//die();
        $name = $tag['name'];
//        $goodstype = D('ViewGoods')->getTypes($tag['gtid']);
        $goodstype = D('ViewGoods')->getTypes($tag['gtid'],$tag['gtype']);
        $types = array();
        foreach($goodstype as $key=>$val){
        	$types[$key]['gtid'] = $val['gt_id'];
        	$types[$key]['gtname'] = $val['gt_name'];
        	$types[$key]['gtsname'] = $val['gt_simple_name'];
        	$types[$key]['gttime'] = $val['gt_create_time'];
        }
        unset($goodstype);
        $str_goodstype = var_export($types, true);
        //dump($goodstype);die();
        $parseStr = $parseStr . "<?php \$types = " . $str_goodstype . "; ?>";
        $parseStr = $parseStr . '<volist name="types" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }
    
    

  	/**
     * skutype标签解析
     * 格式： <html:skutype type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
	 * 商品属性值 ID   stid
     * @return array
     * @author hcaijin <huangcaijin@guanyisoft.com>
     * @date 2012-07-24
     */
    public function _skutype($attr,$content) {
        $parseStr = '';
		$tVar = $this->tpl->tVar;
        $tag = $this->parseXmlAttr($attr, 'skutype');
		$tag = $this->handleTag($tag, $tVar);
        //商品类型药品，剂型
        $int_gs_id = 899;

        $name = $tag['name'];
        $skutype = D("GoodsSpecDetail")->where(array("gs_id"=>$int_gs_id,"gsd_status"=>1))->order(array("gsd_order"=>"asc"))->select();
        //dump($skutype);exit();
        $types = array();
        foreach($skutype as $key=>$val){
        	$types[$key]['stid'] = $val['gsd_id'];
        	$types[$key]['stname'] = $val['gsd_value'];
        	$types[$key]['sturl'] = U('Home/Products/index',array('stid'=>$val['gsd_id']));
        }
        unset($skutype);
        $str_skutype = var_export($types, true);
        //dump($str_skutype);die();
        $parseStr = $parseStr . "<?php \$types = " . $str_skutype . "; ?>";
        $parseStr = $parseStr . '<volist name="types" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }
    

    /**
     * askedquestions标签解析
     * 格式： <html:askedquestions type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
	 * 商品ID	gid
	 * 数量	num
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2012-07-25
     */
    public function _askedquestions($attr,$content) {
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'askedquestions');
		$tVar = $this->tpl->tVar;
		$tag = $this->handleTag($tag, $tVar);
    	$ary_where[C('DB_PREFIX') . 'purchase_consultation.g_id'] = $tag['gid'];
       	if($tag['num']){
	  		$page_no = 1;
			$page_size = $tag['num'];  		
    	}else{
	 		$page_no = empty($tag['p'])?1:$tag['p'];
			$page_size = empty($tag['pagesize'])?10:$tag['pagesize'];   		
    	}
        $ary_data = M('PurchaseConsultation', C('DB_PREFIX'), 'DB_CUSTOM')->field(" " . C('DB_PREFIX') . "goods_info.g_name," . C('DB_PREFIX') . "purchase_consultation.*," . C('DB_PREFIX') . "members.m_name")
                        ->join(' ' . C('DB_PREFIX') . "goods_info ON " . C('DB_PREFIX') . "purchase_consultation.g_id=" . C('DB_PREFIX') . "goods_info.g_id")
                        ->join(' ' . C('DB_PREFIX') . "members ON " . C('DB_PREFIX') . "purchase_consultation.m_id=" . C('DB_PREFIX') . "members.m_id")
                        ->where($ary_where)->order(C('DB_PREFIX') . "purchase_consultation.`pc_create_time` DESC")
                        ->page($page_no,$page_size)
                        ->select();
                        
        $count = M('PurchaseConsultation', C('DB_PREFIX'), 'DB_CUSTOM')->field(" " . C('DB_PREFIX') . "goods.g_name," . C('DB_PREFIX') . "purchase_consultation.*," . C('DB_PREFIX') . "members.m_name")
                ->join(' ' . C('DB_PREFIX') . "goods ON " . C('DB_PREFIX') . "purchase_consultation.g_id=" . C('DB_PREFIX') . "goods.g_id")
                ->join(' ' . C('DB_PREFIX') . "members ON " . C('DB_PREFIX') . "purchase_consultation.m_id=" . C('DB_PREFIX') . "members.m_id")
                ->where($ary_where)->order(C('DB_PREFIX') . "purchase_consultation.`pc_create_time` DESC")
                ->count();
		$obj_page = new Pager($count, $page_size);
        $page = $obj_page->show();
        $pagearr = $obj_page->showArr();             
        if (!empty($ary_data) && is_array($ary_data)) {
            foreach ($ary_data as $ky => $vl) {
                if ($vl['pc_type'] == '1') {
                    $ary_data[$ky]['new_mname'] = $vl['m_name'];
                } else {
                    $ary_data[$ky]['new_mname'] = str_replace(substr($vl['m_name'], 3, 2), "****", $vl['m_name']);
                }
                $ary_data[$ky]['pc_answer'] = htmlspecialchars_decode($vl['pc_answer']);
            }
        }
        $name = $tag['name'];
        $lists = $ary_data;
        $str_lists = var_export($lists, true);
        $str_pageinfo = var_export($page, true);
        $str_pagearr = var_export($pagearr, true);
        $parseStr = $parseStr . "<?php \$$name = " . $str_lists . "; ?>";
        //$parseStr = $parseStr . '<volist name="aslist" id="' . $name . '" >' . $content . '</volist>';
        $parseStr = $parseStr . "<?php \$pageinfo['$name'] = " . $str_pageinfo . "; ?>";
        $parseStr = $parseStr . "<?php \$pagearr['$name'] = " . $str_pagearr . "; ?>";
        $parseStr = $parseStr . $content;
        //dump($parseStr);die();
        return $parseStr;
    }


    public function _buyrecord($attr,$content) {
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'buyrecord');
		$tVar = $this->tpl->tVar;
		$tag = $this->handleTag($tag, $tVar);
		$list = D('GoodsInfo')->getBuyRecords($tag);
        //echo "<pre>";print_r($tag);exit;
        $name = $tag['name'];
        $lists = $list['data'];
        $str_lists = var_export($lists, true);
        $str_pageinfo = var_export($list['page'], true);
        $str_pagearr = var_export($list['pagearr'], true);
        $parseStr = $parseStr . "<?php \$buylists = " . $str_lists . "; ?>";
        $parseStr = $parseStr . '<volist name="buylists" id="' . $name . '" >' . $content . '</volist>';
        $parseStr = $parseStr . "<?php \$pagearr['$name'] = " . $str_pagearr . "; ?>";
        $parseStr = $parseStr . $content;
        //dump($parseStr);die();
        return $parseStr;
    }
    
    /**
     * editor标签解析 插入可视化编辑器
     * 格式： <html:editor id="editor" name="remark" type="FCKeditor" style="" >{$vo.remark}</html:editor>
     * @access public
     * @param string $attr 标签属性
     * @return string|void
     */
    public function _editor($attr, $content) {
        $tag = $this->parseXmlAttr($attr, 'editor');
        $id = !empty($tag['id']) ? $tag['id'] : '_editor';
        $name = $tag['name'];
        $style = !empty($tag['style']) ? $tag['style'] : '';
        $width = !empty($tag['width']) ? $tag['width'] : '100%';
        $height = !empty($tag['height']) ? $tag['height'] : '320px';
        //   $content    =   $tag['content'];
        $type = $tag['type'];
        switch (strtoupper($type)) {
            case 'FCKEDITOR':
                $parseStr = '<!-- 编辑器调用开始 --><script type="text/javascript" src="__ROOT__/Public/Js/FCKeditor/fckeditor.js"></script><textarea id="' . $id . '" name="' . $name . '">' . $content . '</textarea><script type="text/javascript"> var oFCKeditor = new FCKeditor( "' . $id . '","' . $width . '","' . $height . '" ) ; oFCKeditor.BasePath = "__ROOT__/Public/Js/FCKeditor/" ; oFCKeditor.ReplaceTextarea() ;function resetEditor(){setContents("' . $id . '",document.getElementById("' . $id . '").value)}; function saveEditor(){document.getElementById("' . $id . '").value = getContents("' . $id . '");} function InsertHTML(html){ var oEditor = FCKeditorAPI.GetInstance("' . $id . '") ;if (oEditor.EditMode == FCK_EDITMODE_WYSIWYG ){oEditor.InsertHtml(html) ;}else	alert( "FCK必须处于WYSIWYG模式!" ) ;}</script> <!-- 编辑器调用结束 -->';
                break;
            case 'FCKMINI':
                $parseStr = '<!-- 编辑器调用开始 --><script type="text/javascript" src="__ROOT__/Public/Js/FCKMini/fckeditor.js"></script><textarea id="' . $id . '" name="' . $name . '">' . $content . '</textarea><script type="text/javascript"> var oFCKeditor = new FCKeditor( "' . $id . '","' . $width . '","' . $height . '" ) ; oFCKeditor.BasePath = "__ROOT__/Public/Js/FCKMini/" ; oFCKeditor.ReplaceTextarea() ;function resetEditor(){setContents("' . $id . '",document.getElementById("' . $id . '").value)}; function saveEditor(){document.getElementById("' . $id . '").value = getContents("' . $id . '");} function InsertHTML(html){ var oEditor = FCKeditorAPI.GetInstance("' . $id . '") ;if (oEditor.EditMode == FCK_EDITMODE_WYSIWYG ){oEditor.InsertHtml(html) ;}else	alert( "FCK必须处于WYSIWYG模式!" ) ;}</script> <!-- 编辑器调用结束 -->';
                break;
            case 'EWEBEDITOR':
                $parseStr = "<!-- 编辑器调用开始 --><script type='text/javascript' src='__ROOT__/Public/Js/eWebEditor/js/edit.js'></script><input type='hidden'  id='{$id}' name='{$name}'  value='{$conent}'><iframe src='__ROOT__/Public/Js/eWebEditor/ewebeditor.htm?id={$name}' frameborder=0 scrolling=no width='{$width}' height='{$height}'></iframe><script type='text/javascript'>function saveEditor(){document.getElementById('{$id}').value = getHTML();} </script><!-- 编辑器调用结束 -->";
                break;
            case 'NETEASE':
                $parseStr = '<!-- 编辑器调用开始 --><textarea id="' . $id . '" name="' . $name . '" style="display:none">' . $content . '</textarea><iframe ID="Editor" name="Editor" src="__ROOT__/Public/Js/HtmlEditor/index.html?ID=' . $name . '" frameBorder="0" marginHeight="0" marginWidth="0" scrolling="No" style="height:' . $height . ';width:' . $width . '"></iframe><!-- 编辑器调用结束 -->';
                break;
            case 'UBB':
                $parseStr = '<script type="text/javascript" src="__ROOT__/Public/Js/UbbEditor.js"></script><div style="padding:1px;width:' . $width . ';border:1px solid silver;float:left;"><script LANGUAGE="JavaScript"> showTool(); </script></div><div><TEXTAREA id="UBBEditor" name="' . $name . '"  style="clear:both;float:none;width:' . $width . ';height:' . $height . '" >' . $content . '</TEXTAREA></div><div style="padding:1px;width:' . $width . ';border:1px solid silver;float:left;"><script LANGUAGE="JavaScript">showEmot();  </script></div>';
                break;
            case 'KINDEDITOR':
                $parseStr = '<script type="text/javascript" src="__ROOT__/Public/Js/KindEditor/kindeditor.js"></script><script type="text/javascript"> KE.show({ id : \'' . $id . '\'  ,urlType : "absolute"});</script><textarea id="' . $id . '" style="' . $style . '" name="' . $name . '" >' . $content . '</textarea>';
                break;
            default :
                $parseStr = '<textarea id="' . $id . '" style="' . $style . '" name="' . $name . '" >' . $content . '</textarea>';
        }

        return $parseStr;
    }

    /**
     * imageBtn标签解析
     * 格式： <html:imageBtn type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * @return string|void
     */
    public function _imageBtn($attr) {
        $tag = $this->parseXmlAttr($attr, 'imageBtn');
        $name = $tag['name'];                //名称
        $value = $tag['value'];                //文字
        $id = isset($tag['id']) ? $tag['id'] : '';                //ID
        $style = isset($tag['style']) ? $tag['style'] : '';                //样式名
        $click = isset($tag['click']) ? $tag['click'] : '';                //点击
        $type = empty($tag['type']) ? 'button' : $tag['type'];                //按钮类型

        if (!empty($name)) {
            $parseStr = '<div class="' . $style . '" ><input type="' . $type . '" id="' . $id . '" name="' . $name . '" value="' . $value . '" onclick="' . $click . '" class="' . $name . ' imgButton"></div>';
        } else {
            $parseStr = '<div class="' . $style . '" ><input type="' . $type . '" id="' . $id . '"  name="' . $name . '" value="' . $value . '" onclick="' . $click . '" class="button"></div>';
        }

        return $parseStr;
    }

    /**
     * imageLink标签解析
     * 格式： <html:imageLink type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * @return string|void
     */
    public function _imgLink($attr) {
        $tag = $this->parseXmlAttr($attr, 'imgLink');
        $name = $tag['name'];                //名称
        $alt = $tag['alt'];                //文字
        $id = $tag['id'];                //ID
        $style = $tag['style'];                //样式名
        $click = $tag['click'];                //点击
        $type = $tag['type'];                //点击
        if (empty($type)) {
            $type = 'button';
        }
        $parseStr = '<span class="' . $style . '" ><input title="' . $alt . '" type="' . $type . '" id="' . $id . '"  name="' . $name . '" onmouseover="this.style.filter=\'alpha(opacity=100)\'" onmouseout="this.style.filter=\'alpha(opacity=80)\'" onclick="' . $click . '" align="absmiddle" class="' . $name . ' imgLink"></span>';

        return $parseStr;
    }

    /**
     * select标签解析
     * 格式： <html:select options="name" selected="value" />
     * @access public
     * @param string $attr 标签属性
     * @return string|void
     */
    public function _select($attr) {
        $tag = $this->parseXmlAttr($attr, 'select');
        $name = $tag['name'];
        $options = $tag['options'];
        $values = $tag['values'];
        $output = $tag['output'];
        $multiple = $tag['multiple'];
        $id = $tag['id'];
        $size = $tag['size'];
        $first = $tag['first'];
        $selected = $tag['selected'];
        $style = $tag['style'];
        $ondblclick = $tag['dblclick'];
        $onchange = $tag['change'];

        if (!empty($multiple)) {
            $parseStr = '<select id="' . $id . '" name="' . $name . '" ondblclick="' . $ondblclick . '" onchange="' . $onchange . '" multiple="multiple" class="' . $style . '" size="' . $size . '" >';
        } else {
            $parseStr = '<select id="' . $id . '" name="' . $name . '" onchange="' . $onchange . '" ondblclick="' . $ondblclick . '" class="' . $style . '" >';
        }
        if (!empty($first)) {
            $parseStr .= '<option value="" >' . $first . '</option>';
        }
        if (!empty($options)) {
            $parseStr .= '<?php  foreach($' . $options . ' as $key=>$val) { ?>';
            if (!empty($selected)) {
                $parseStr .= '<?php if(!empty($' . $selected . ') && ($' . $selected . ' == $key || in_array($key,$' . $selected . '))) { ?>';
                $parseStr .= '<option selected="selected" value="<?php echo $key ?>"><?php echo $val ?></option>';
                $parseStr .= '<?php }else { ?><option value="<?php echo $key ?>"><?php echo $val ?></option>';
                $parseStr .= '<?php } ?>';
            } else {
                $parseStr .= '<option value="<?php echo $key ?>"><?php echo $val ?></option>';
            }
            $parseStr .= '<?php } ?>';
        } else if (!empty($values)) {
            $parseStr .= '<?php  for($i=0;$i<count($' . $values . ');$i++) { ?>';
            if (!empty($selected)) {
                $parseStr .= '<?php if(isset($' . $selected . ') && ((is_string($' . $selected . ') && $' . $selected . ' == $' . $values . '[$i]) || (is_array($' . $selected . ') && in_array($' . $values . '[$i],$' . $selected . ')))) { ?>';
                $parseStr .= '<option selected="selected" value="<?php echo $' . $values . '[$i] ?>"><?php echo $' . $output . '[$i] ?></option>';
                $parseStr .= '<?php }else { ?><option value="<?php echo $' . $values . '[$i] ?>"><?php echo $' . $output . '[$i] ?></option>';
                $parseStr .= '<?php } ?>';
            } else {
                $parseStr .= '<option value="<?php echo $' . $values . '[$i] ?>"><?php echo $' . $output . '[$i] ?></option>';
            }
            $parseStr .= '<?php } ?>';
        }
        $parseStr .= '</select>';
        return $parseStr;
    }

    /**
     * checkbox标签解析
     * 格式： <html:checkbox checkboxes="" checked="" />
     * @access public
     * @param string $attr 标签属性
     * @return string|void
     */
    public function _checkbox($attr) {
        $tag = $this->parseXmlAttr($attr, 'checkbox');
        $name = $tag['name'];
        $checkboxes = $tag['checkboxes'];
        $checked = $tag['checked'];
        $separator = $tag['separator'];
        $checkboxes = $this->tpl->get($checkboxes);
        $checked = $this->tpl->get($checked) ? $this->tpl->get($checked) : $checked;
        $parseStr = '';
        foreach ($checkboxes as $key => $val) {
            if ($checked == $key || in_array($key, $checked)) {
                $parseStr .= '<input type="checkbox" checked="checked" name="' . $name . '[]" value="' . $key . '">' . $val . $separator;
            } else {
                $parseStr .= '<input type="checkbox" name="' . $name . '[]" value="' . $key . '">' . $val . $separator;
            }
        }
        return $parseStr;
    }

    /**
     * radio标签解析
     * 格式： <html:radio radios="name" checked="value" />
     * @access public
     * @param string $attr 标签属性
     * @return string|void
     */
    public function _radio($attr) {
        $tag = $this->parseXmlAttr($attr, 'radio');
        $name = $tag['name'];
        $radios = $tag['radios'];
        $checked = $tag['checked'];
        $separator = $tag['separator'];
        $radios = $this->tpl->get($radios);
        $checked = $this->tpl->get($checked) ? $this->tpl->get($checked) : $checked;
        $parseStr = '';
        foreach ($radios as $key => $val) {
            if ($checked == $key) {
                $parseStr .= '<input type="radio" checked="checked" name="' . $name . '[]" value="' . $key . '">' . $val . $separator;
            } else {
                $parseStr .= '<input type="radio" name="' . $name . '[]" value="' . $key . '">' . $val . $separator;
            }
        }
        return $parseStr;
    }

    /**
     * list标签解析
     * 格式： <html:grid datasource="" show="vo" />
     * @access public
     * @param string $attr 标签属性
     * @return string
     */
    public function _grid($attr) {
        $tag = $this->parseXmlAttr($attr, 'grid');
        $id = $tag['id'];                       //表格ID
        $datasource = $tag['datasource'];               //列表显示的数据源VoList名称
        $pk = empty($tag['pk']) ? 'id' : $tag['pk']; //主键名，默认为id
        $style = $tag['style'];                    //样式名
        $name = !empty($tag['name']) ? $tag['name'] : 'vo';                 //Vo对象名
        $action = !empty($tag['action']) ? $tag['action'] : false;                   //是否显示功能操作
        $key = !empty($tag['key']) ? true : false;
        if (isset($tag['actionlist'])) {
            $actionlist = explode(',', trim($tag['actionlist']));    //指定功能列表
        }

        if (substr($tag['show'], 0, 1) == '$') {
            $show = $this->tpl->get(substr($tag['show'], 1));
        } else {
            $show = $tag['show'];
        }
        $show = explode(',', $show);                //列表显示字段列表
        //计算表格的列数
        $colNum = count($show);
        if (!empty($action))
            $colNum++;
        if (!empty($key))
            $colNum++;

        //显示开始
        $parseStr = "<!-- Think 系统列表组件开始 -->\n";
        $parseStr .= '<table id="' . $id . '" class="' . $style . '" cellpadding=0 cellspacing=0 >';
        $parseStr .= '<tr><td height="5" colspan="' . $colNum . '" class="topTd" ></td></tr>';
        $parseStr .= '<tr class="row" >';
        //列表需要显示的字段
        $fields = array();
        foreach ($show as $val) {
            $fields[] = explode(':', $val);
        }

        if (!empty($key)) {
            $parseStr .= '<th width="12">No</th>';
        }
        foreach ($fields as $field) {//显示指定的字段
            $property = explode('|', $field[0]);
            $showname = explode('|', $field[1]);
            if (isset($showname[1])) {
                $parseStr .= '<th width="' . $showname[1] . '">';
            } else {
                $parseStr .= '<th>';
            }
            $parseStr .= $showname[0] . '</th>';
        }
        if (!empty($action)) {//如果指定显示操作功能列
            $parseStr .= '<th >操作</th>';
        }
        $parseStr .= '</tr>';
        $parseStr .= '<volist name="' . $datasource . '" id="' . $name . '" ><tr class="row" >'; //支持鼠标移动单元行颜色变化 具体方法在js中定义

        if (!empty($key)) {
            $parseStr .= '<td>{$i}</td>';
        }
        foreach ($fields as $field) {
            //显示定义的列表字段
            $parseStr .= '<td>';
            if (!empty($field[2])) {
                // 支持列表字段链接功能 具体方法由JS函数实现
                $href = explode('|', $field[2]);
                if (count($href) > 1) {
                    //指定链接传的字段值
                    // 支持多个字段传递
                    $array = explode('^', $href[1]);
                    if (count($array) > 1) {
                        foreach ($array as $a) {
                            $temp[] = '\'{$' . $name . '.' . $a . '|addslashes}\'';
                        }
                        $parseStr .= '<a href="javascript:' . $href[0] . '(' . implode(',', $temp) . ')">';
                    } else {
                        $parseStr .= '<a href="javascript:' . $href[0] . '(\'{$' . $name . '.' . $href[1] . '|addslashes}\')">';
                    }
                } else {
                    //如果没有指定默认传编号值
                    $parseStr .= '<a href="javascript:' . $field[2] . '(\'{$' . $name . '.' . $pk . '|addslashes}\')">';
                }
            }
            if (strpos($field[0], '^')) {
                $property = explode('^', $field[0]);
                foreach ($property as $p) {
                    $unit = explode('|', $p);
                    if (count($unit) > 1) {
                        $parseStr .= '{$' . $name . '.' . $unit[0] . '|' . $unit[1] . '} ';
                    } else {
                        $parseStr .= '{$' . $name . '.' . $p . '} ';
                    }
                }
            } else {
                $property = explode('|', $field[0]);
                if (count($property) > 1) {
                    $parseStr .= '{$' . $name . '.' . $property[0] . '|' . $property[1] . '}';
                } else {
                    $parseStr .= '{$' . $name . '.' . $field[0] . '}';
                }
            }
            if (!empty($field[2])) {
                $parseStr .= '</a>';
            }
            $parseStr .= '</td>';
        }
        if (!empty($action)) {//显示功能操作
            if (!empty($actionlist[0])) {//显示指定的功能项
                $parseStr .= '<td>';
                foreach ($actionlist as $val) {
                    if (strpos($val, ':')) {
                        $a = explode(':', $val);
                        if (count($a) > 2) {
                            $parseStr .= '<a href="javascript:' . $a[0] . '(\'{$' . $name . '.' . $a[2] . '}\')">' . $a[1] . '</a>&nbsp;';
                        } else {
                            $parseStr .= '<a href="javascript:' . $a[0] . '(\'{$' . $name . '.' . $pk . '}\')">' . $a[1] . '</a>&nbsp;';
                        }
                    } else {
                        $array = explode('|', $val);
                        if (count($array) > 2) {
                            $parseStr .= ' <a href="javascript:' . $array[1] . '(\'{$' . $name . '.' . $array[0] . '}\')">' . $array[2] . '</a>&nbsp;';
                        } else {
                            $parseStr .= ' {$' . $name . '.' . $val . '}&nbsp;';
                        }
                    }
                }
                $parseStr .= '</td>';
            }
        }
        $parseStr .= '</tr></volist><tr><td height="5" colspan="' . $colNum . '" class="bottomTd"></td></tr></table>';
        $parseStr .= "\n<!-- Think 系统列表组件结束 -->\n";
        return $parseStr;
    }

    /**
     * list标签解析
     * 格式： <html:list datasource="" show="" />
     * @access public
     * @param string $attr 标签属性
     * @return string
     */
    public function _list($attr) {
        $tag = $this->parseXmlAttr($attr, 'list');
        $id = $tag['id'];                       //表格ID
        $datasource = $tag['datasource'];               //列表显示的数据源VoList名称
        $pk = empty($tag['pk']) ? 'id' : $tag['pk']; //主键名，默认为id
        $style = $tag['style'];                    //样式名
        $name = !empty($tag['name']) ? $tag['name'] : 'vo';                 //Vo对象名
        $action = $tag['action'] == 'true' ? true : false;                   //是否显示功能操作
        $key = !empty($tag['key']) ? true : false;
        $sort = $tag['sort'] == 'false' ? false : true;
        $checkbox = $tag['checkbox'];                 //是否显示Checkbox
        if (isset($tag['actionlist'])) {
            $actionlist = explode(',', trim($tag['actionlist']));    //指定功能列表
        }

        if (substr($tag['show'], 0, 1) == '$') {
            $show = $this->tpl->get(substr($tag['show'], 1));
        } else {
            $show = $tag['show'];
        }
        $show = explode(',', $show);                //列表显示字段列表
        //计算表格的列数
        $colNum = count($show);
        if (!empty($checkbox))
            $colNum++;
        if (!empty($action))
            $colNum++;
        if (!empty($key))
            $colNum++;

        //显示开始
        $parseStr = "<!-- Think 系统列表组件开始 -->\n";
        $parseStr .= '<table id="' . $id . '" class="' . $style . '" cellpadding=0 cellspacing=0 >';
        $parseStr .= '<tr><td height="5" colspan="' . $colNum . '" class="topTd" ></td></tr>';
        $parseStr .= '<tr class="row" >';
        //列表需要显示的字段
        $fields = array();
        foreach ($show as $val) {
            $fields[] = explode(':', $val);
        }
        if (!empty($checkbox) && 'true' == strtolower($checkbox)) {//如果指定需要显示checkbox列
            $parseStr .='<th width="8"><input type="checkbox" id="check" onclick="CheckAll(\'' . $id . '\')"></th>';
        }
        if (!empty($key)) {
            $parseStr .= '<th width="12">No</th>';
        }
        foreach ($fields as $field) {//显示指定的字段
            $property = explode('|', $field[0]);
            $showname = explode('|', $field[1]);
            if (isset($showname[1])) {
                $parseStr .= '<th width="' . $showname[1] . '">';
            } else {
                $parseStr .= '<th>';
            }
            $showname[2] = isset($showname[2]) ? $showname[2] : $showname[0];
            if ($sort) {
                $parseStr .= '<a href="javascript:sortBy(\'' . $property[0] . '\',\'{$sort}\',\'' . ACTION_NAME . '\')" title="按照' . $showname[2] . '{$sortType} ">' . $showname[0] . '<eq name="order" value="' . $property[0] . '" ><img src="../Public/images/{$sortImg}.gif" width="12" height="17" border="0" align="absmiddle"></eq></a></th>';
            } else {
                $parseStr .= $showname[0] . '</th>';
            }
        }
        if (!empty($action)) {//如果指定显示操作功能列
            $parseStr .= '<th >操作</th>';
        }

        $parseStr .= '</tr>';
        $parseStr .= '<volist name="' . $datasource . '" id="' . $name . '" ><tr class="row" '; //支持鼠标移动单元行颜色变化 具体方法在js中定义
        if (!empty($checkbox)) {
            $parseStr .= 'onmouseover="over(event)" onmouseout="out(event)" onclick="change(event)" ';
        }
        $parseStr .= '>';
        if (!empty($checkbox)) {//如果需要显示checkbox 则在每行开头显示checkbox
            $parseStr .= '<td><input type="checkbox" name="key"	value="{$' . $name . '.' . $pk . '}"></td>';
        }
        if (!empty($key)) {
            $parseStr .= '<td>{$i}</td>';
        }
        foreach ($fields as $field) {
            //显示定义的列表字段
            $parseStr .= '<td>';
            if (!empty($field[2])) {
                // 支持列表字段链接功能 具体方法由JS函数实现
                $href = explode('|', $field[2]);
                if (count($href) > 1) {
                    //指定链接传的字段值
                    // 支持多个字段传递
                    $array = explode('^', $href[1]);
                    if (count($array) > 1) {
                        foreach ($array as $a) {
                            $temp[] = '\'{$' . $name . '.' . $a . '|addslashes}\'';
                        }
                        $parseStr .= '<a href="javascript:' . $href[0] . '(' . implode(',', $temp) . ')">';
                    } else {
                        $parseStr .= '<a href="javascript:' . $href[0] . '(\'{$' . $name . '.' . $href[1] . '|addslashes}\')">';
                    }
                } else {
                    //如果没有指定默认传编号值
                    $parseStr .= '<a href="javascript:' . $field[2] . '(\'{$' . $name . '.' . $pk . '|addslashes}\')">';
                }
            }
            if (strpos($field[0], '^')) {
                $property = explode('^', $field[0]);
                foreach ($property as $p) {
                    $unit = explode('|', $p);
                    if (count($unit) > 1) {
                        $parseStr .= '{$' . $name . '.' . $unit[0] . '|' . $unit[1] . '} ';
                    } else {
                        $parseStr .= '{$' . $name . '.' . $p . '} ';
                    }
                }
            } else {
                $property = explode('|', $field[0]);
                if (count($property) > 1) {
                    $parseStr .= '{$' . $name . '.' . $property[0] . '|' . $property[1] . '}';
                } else {
                    $parseStr .= '{$' . $name . '.' . $field[0] . '}';
                }
            }
            if (!empty($field[2])) {
                $parseStr .= '</a>';
            }
            $parseStr .= '</td>';
        }
        if (!empty($action)) {//显示功能操作
            if (!empty($actionlist[0])) {//显示指定的功能项
                $parseStr .= '<td>';
                foreach ($actionlist as $val) {
                    if (strpos($val, ':')) {
                        $a = explode(':', $val);
                        if (count($a) > 2) {
                            $parseStr .= '<a href="javascript:' . $a[0] . '(\'{$' . $name . '.' . $a[2] . '}\')">' . $a[1] . '</a>&nbsp;';
                        } else {
                            $parseStr .= '<a href="javascript:' . $a[0] . '(\'{$' . $name . '.' . $pk . '}\')">' . $a[1] . '</a>&nbsp;';
                        }
                    } else {
                        $array = explode('|', $val);
                        if (count($array) > 2) {
                            $parseStr .= ' <a href="javascript:' . $array[1] . '(\'{$' . $name . '.' . $array[0] . '}\')">' . $array[2] . '</a>&nbsp;';
                        } else {
                            $parseStr .= ' {$' . $name . '.' . $val . '}&nbsp;';
                        }
                    }
                }
                $parseStr .= '</td>';
            }
        }
        $parseStr .= '</tr></volist><tr><td height="5" colspan="' . $colNum . '" class="bottomTd"></td></tr></table>';
        $parseStr .= "\n<!-- Think 系统列表组件结束 -->\n";
        return $parseStr;
    }

    /**
     * collectgoods标签解析
     * 格式: <html:collectgoods name="返回数据变量名" num="数量">
     * 返回数据变量名  name
     * 数量   num
     * @return array
     * @author WangHaoYu <why419163@163.com>
     * @version 
     * @date 2013-11-10
     */
    public function _collectgoods($attr,$content) {
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'collectgoods');
        $tVar = $this->tpl->tVar;
        $tag = $this->handleTag($tag, $tVar);
        if($tag['num']){
            $page_no = 1;
            $page_size = $tag['num'];
        }
        $obj_query = M('collect_goods',C('DB_PREFIX'),'DB_CUSTOM')
                        ->field(' ' .C('DB_PREFIX') . "goods_info.g_id," . C('DB_PREFIX') . "goods_info.g_picture," . C('DB_PREFIX') . "goods_info.g_name,g_price,count('*') as nums")
                        ->join(' ' . C('DB_PREFIX') . "goods_info ON " . C('DB_PREFIX') . "collect_goods.g_id=" . C('DB_PREFIX') . "goods_info.g_id")
                        ->group('fx_collect_goods.g_id')
                        ->order("nums desc")
						->where(array('fx_goods_info.g_id'=>array('neq','')))
                        ->page($page_no,$page_size);
                        //->select();
						
		$ary_data = D('Gyfx')->queryCache($obj_query,'',600);
		//七牛图片显示
		foreach($ary_data as $key=>$value){
			if($_SESSION['OSS']['GY_QN_ON'] == '1'){
			$ary_data[$key]['g_picture']=D('QnPic')->picToQn($value['g_picture']);
			}
		}
						//echo M('collect_goods',C('DB_PREFIX'),'DB_CUSTOM')->getLastSql();exit;
						
        $name = $tag['name'];
        $collect = var_export($ary_data, true);
        $nums = var_export($count, true);
        $parseStr = $parseStr . "<?php \$goodslist = " . $collect . "; ?>";
        $parseStr = $parseStr . '<volist name="goodslist" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }
    
    /**
    * icp标签解析获取备案号
    * 格式:<gyfx:icp name='返回数据变量名'></gyfx:icp>
    * @author WangHaoYu <wanghaoyu@guanyisoft.com>
    * @date 2014-1-10 
    * @version 7.4.5
    */
    public function _icp($attr,$content) {
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'icp');
        $tVar = $this->tpl->tVar;
        $tag = $this->handleTag($tag, $tVar);
        $ary_result = D('SysConfig')->getConfigs('GY_SHOP', 'GY_SHOP_ICP','','',1);
        $str_icp = $ary_result['GY_SHOP_ICP']['sc_value'];
        $parseStr ="&copy;" . $str_icp;   
        return $parseStr;
    }
	
    /**
     * select标签解析
     * 格式： <gyfx:selectsql type="" value="" />
     * @access public
     * @param string $attr 标签属性
     * 返回数据变量名	name
	 * //name获取数据名称,page_name分页的名称,page分页开启,limit:每页显示多少条，sql:查询内容
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2014-12-15
     */    
	public function _selectsql($attr,$content){
		$parseStr = "";
		$tag = $this->parseXmlAttr($attr, 'select');
        $tVar = $this->tpl->tVar;
        //$tag = $this->handleTag($tag, $tVar);
		$name = empty($tag['name'])?'data':$tag['name'];
		$page_name = empty($tag['page_name'])?'pageinfo':$tag['page_name'];
		$limit = $tag['limit'];
		$sql = '';
		$tmp_sql_info = $this->handleSql(trim($tag['sql']));
		if(empty($tmp_sql_info['status'])){
			return $tmp_sql_info['sql'];
		}else{
			$sql = $tmp_sql_info['sql'];
		}
		$module = M("",C("DB_PREFIX"),"DB_CUSTOM");
		$res_data = array();
		$pages = "";
        if($sql){
			$limit=$limit?$limit:10;//如果有page，没有输入limit则默认为10
            if($tag['page']){
				//import("@.ORG.Page");
				if($tag['cache'] == '1'){
					$count = count(D('Gyfx')->querySqlCache($sql,$tag['time']));
				}else{
					$count = count($module->query($sql));
				}				
				$obj_page = new Pager($count, $limit);
				$sql .=" limit ".$obj_page->firstRow.",".$obj_page->listRows.""; 
				if($tag['cache'] == '1'){
					$res_data = D('Gyfx')->querySqlCache($sql,$tag['time']);
				}else{
					$res_data = $module->query($sql);
				}
				$page = $obj_page->show();
				//$pagearr = $obj_page->showArr();   
            }else{
                $sql.=$limit?(' limit '.$limit):'';
				if($tag['cache'] == '1'){
					$res_data = D('Gyfx')->querySqlCache($sql,$tag['time']);
				}else{
					$res_data = $module->query($sql);
				}				
            }
         }    
		$str_lists = var_export($res_data, true);
        $str_pageinfo = var_export($page, true);
        $parseStr = $parseStr . "<?php \$$name = " . $str_lists . "; ?>";
        $parseStr = $parseStr . "<?php \$$page_name = " . $str_pageinfo . "; ?>";
        $parseStr = $parseStr . $content;
         return $parseStr;
    }
	//处理SQL语句只允许查询 ByWangguibin
	protected function handleSql($sql){
		//限制部分查询语句和部分表
		$array_not_allow = array(
			'drop'=>'不允许删除表或视图',//不允许删除表
			'admin'=>'表fx_admin不允许操作',//表fx_admin
			'role'=>'表fx_role，fx_role_access，fx_role_node不允许操作',//表fx_role，fx_role_access，fx_role_node
			'script_info'=>'表fx_script_info不允许操作',//表fx_script_info
			'sys_config'=>'表fx_sys_config不允许操作',//表fx_sys_config
			'_template'=>'表fx_template不允许操作',//表fx_template
			'create table'=>'不允许创建操作',//不允许创建操作
			'CREATE TABLE'=>'不允许创建操作',//不允许创建操作
			'view'=>'视图不允许操作',//视图不允许操作
			'alter'=>'不允许更改表结构',
			'delete'=>'不允许删除表数据',
			'update'=>'不允许更新数据',
			'replace'=>'不允许replace',
			'truncate'=>'不允许清空表',
			'TRUNCATE'=>'不允许清空表'
		);
		foreach($array_not_allow as $key=>$val){
			$is_exist = is_int(strpos($sql,$key));
			if($is_exist){
				return array('status'=>false,'sql'=>$val);
			}else{
				if(is_int(strpos($sql,'select')) || is_int(strpos($sql,'SELECT'))){
					return array('status'=>true,'sql'=>htmlspecialchars($sql));
				}else{
					return array('status'=>false,'sql'=>'必须是查询语句');
				}
			}
		}
	}

    /**
     * 自定义分类标签
     * <gyfx:goodslist name='返回数据变量名' gname='商品名称' gid='商品ID' cid='分类ID' bid='品牌ID' hot='是否热销' new='是否新品' order='排序默认时间逆序' num='数量' start='偏移量' pagesize=’每页显示条数','type'='商品类型','ggid'='商品分组id'></gyfx:goodslist>
     * 示例:<gyfx:goodslist name='返回数据变量名' gid='24' hot='0' ></gyfx:goodslist>
     * @param type $attr
     * 备注：根据商品列表页所筛选的条件查询分类
     * @param type $content
     * @return array
     * @author huhaiwei <huhaiwei@guanyisoft.com>
     * @date 2015-04-16
     */
    public function _relegoodscate($attr,$content){
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'relegoodscate');
        $tVar = $this->tpl->tVar;
        $tag = $this->handleTag($tag, $tVar);
        $good_cate = D('ViewGoods')->getGoodCate($tag);
        $name = $tag['name'];
        $str_cate = var_export($good_cate, true);
        if(!isset($tag['mod']) || !$tag['mod']) $tag['mod'] = 2;
        $parseStr = $parseStr . "<?php \$cateslist = " . $str_cate . "; ?>";
        $parseStr = $parseStr . '<volist name="cateslist" id="' . $name . '" key="k" mod="'.$tag['mod'] .'">' . $content . '</volist>';
        return $parseStr;
    }

    /*
     * 获取中文名首字母对应的拼音
     * @return A-Z
     * @author huhaiwei <huhaiwei@guanyisoft.com>
     * @date 2015-04-16
    */
    function getfirstchar($s0){
        $firstchar_ord=ord(strtoupper($s0{0}));
        if (($firstchar_ord>=65 and $firstchar_ord<=91)or($firstchar_ord>=48 and $firstchar_ord<=57)) return $s0{0};
        $s=iconv("UTF-8","gb2312", $s0);
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319 and $asc<=-20284)return "A";
        if($asc>=-20283 and $asc<=-19776)return "B";
        if($asc>=-19775 and $asc<=-19219)return "C";
        if($asc>=-19218 and $asc<=-18711)return "D";
        if($asc>=-18710 and $asc<=-18527)return "E";
        if($asc>=-18526 and $asc<=-18240)return "F";
        if($asc>=-18239 and $asc<=-17923)return "G";
        if($asc>=-17922 and $asc<=-17418)return "H";
        if($asc>=-17417 and $asc<=-16475)return "J";
        if($asc>=-16474 and $asc<=-16213)return "K";
        if($asc>=-16212 and $asc<=-15641)return "L";
        if($asc>=-15640 and $asc<=-15166)return "M";
        if($asc>=-15165 and $asc<=-14923)return "N";
        if($asc>=-14922 and $asc<=-14915)return "O";
        if($asc>=-14914 and $asc<=-14631)return "P";
        if($asc>=-14630 and $asc<=-14150)return "Q";
        if($asc>=-14149 and $asc<=-14091)return "R";
        if($asc>=-14090 and $asc<=-13319)return "S";
        if($asc>=-13318 and $asc<=-12839)return "T";
        if($asc>=-12838 and $asc<=-12557)return "W";
        if($asc>=-12556 and $asc<=-11848)return "X";
        if($asc>=-11847 and $asc<=-11056)return "Y";
        if($asc>=-11055 and $asc<=-10247)return "Z";
        return null;
    }
	
    /**
     * 获取关联商品
     * <gyfx:relegoods name='返回数据变量名' gid='商品ID'  ></gyfx:relegoods>
     * @param type $attr
     * 备注：根据商品ID查询相关的商品
     * @param type $content
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2015-05-04
     */
    public function _relegoods($attr,$content){
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'relegoods');
        $tVar = $this->tpl->tVar;
        $tag = $this->handleTag($tag, $tVar);		
        $ary_relate_goods = D('ViewGoods')->getRelegoods($tag);
        $name = $tag['name'];
        $str_relate_goods = var_export($ary_relate_goods, true);
        $parseStr = $parseStr . "<?php \$relategoodslist = " . $str_relate_goods . "; ?>";
        $parseStr = $parseStr . '<volist name="relategoodslist" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }

	/**
     * 获取商品非销售属性
     * <gyfx:unsalespecs name='返回数据变量名' gid='商品ID'  ></gyfx:unsalespecs>
     * @param type $attr
     * 备注：根据商品ID查询相关的商品
     * @param type $content
     * @return array
     * @author wangguibin <wangguibin@guanyisoft.com>
     * @date 2015-05-05
     */
    public function _unsalespecs($attr,$content){
        $parseStr = '';
        $tag = $this->parseXmlAttr($attr, 'unsalespecs');
        $tVar = $this->tpl->tVar;
        $tag = $this->handleTag($tag, $tVar);		
        $ary_unsale_specs = D('ViewGoods')->getUnsalespecs($tag,true);
        $name = $tag['name'];
        $str_unsale_specs = var_export($ary_unsale_specs, true);
        $parseStr = $parseStr . "<?php \$unsalespecslist = " . $str_unsale_specs . "; ?>";
        $parseStr = $parseStr . '<volist name="unsalespecslist" id="' . $name . '" >' . $content . '</volist>';
        return $parseStr;
    }
}
