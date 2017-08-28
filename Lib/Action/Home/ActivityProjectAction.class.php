<?php

//Activity project
class ActivityProjectAction extends HomeAction {
    
    public function _initialize() {
        parent::_initialize();
        
    }
    
    public function EuropeanCup(){
        
        $time = date("Y-m-d H:s:i",strtotime("2017-8-17 23:59:59"));
        $this->assign("time_end", $time);
        $this->display();
    }
    
    public function getSeoInfo($page_title = '', $page_keywords = '', $page_desc = '') {
        $this->assign('page_title', $page_title);
        $this->assign('page_keywords', $page_keywords);
        $this->assign('page_desc', $page_desc);
    }   
    public function JapSkin(){
        

        $this->display();
    }
	
     public function EuropeanDirect(){
        

        $this->display();
    }
     public function CouponActivityADD(){

         //$ary_caid = $this->_get("caid");
         $check = 1;
         $UserCouponValidation = D("CouponActivitiesParticipate")->where(array("m_id"=>$_SESSION['Members']['m_id']))->find();
         if(!empty($UserCouponValidation))
         {
              $check = 2;
         }
         $this->assign('check',$check);
         $this->assign('caid',$ary_caid);

        $this->display();
    }
    
     public function CouponActivitySuccess(){
        

        $this->display();
    }
    
       
     public function Olympic(){
        

        $this->display();
    }
     public function School(){
        

        $this->display();
    }
    
    public function participateCoupon(){
        $this->display();
    }
     
    /*
     * desc:农心大货贸易专题
     * author:zhangdong
     * date:2016.09.08
     * **/
    public function bigGoodsTrade()
    {        
        $this->display();
    }
    /*
     * desc:奢侈品专题
     * author:zhangdong
     * date:2016.09.26
     * **/
    public function superfluity()
    {   
        
        //奢侈品信息
        $gcId = [411,412,408,407,404,405,409];
        $mlId = $_SESSION['Members']['ml_id'];
        $authorityGoods = $_SESSION['Members']['authority_goods'];
        if(!$mlId){
            return $this->error('请先登录','/Home/User/login');
        }
        if($authorityGoods==1){
            return throw_exception("404");
        }
        $where = [
            'rgc.gc_id'=>['IN',$gcId],
            'g.g_on_sale'=>1,
            'g.authority_goods'=>2,//奢侈品标识
        ];
        $sortBy = 'gc_id ASC';
        $field = "gi.g_id,gi.g_picture,gi.g_name,gi.g_market_price,rgc.gc_id,pmlp.pmlp_price";
        $result = D('Goods')->alias('g')->field($field)
                ->join("INNER JOIN fx_goods_info as gi on g.g_id = gi.g_id")
                ->join("INNER JOIN fx_related_goods_category as rgc on rgc.g_id = g.g_id")
                ->join("INNER JOIN fx_goods_products as gp on gp.g_id = g.g_id")
                ->join("INNER JOIN fx_product_member_level_price as pmlp ON pmlp.pdt_id=gp.pdt_id AND pmlp.ml_id = $mlId")
                ->where($where)->order($sortBy)->select();
//print_r(D('Goods')->getlastsql());
        foreach($result as $value){
            if($value['gc_id']==405){
                $superGoods['manShoulderBag'][] = $value;//男款双肩包
            }else if($value['gc_id']==412){
                $superGoods['manMoneyBag'][] = $value;//男款钱包
            }else if($value['gc_id']==404){
                $superGoods['manSlantingBag'][] = $value;//男款斜挎包
            }else if($value['gc_id']==409){
                $superGoods['manBelt'][] = $value;//男款腰带
            }else if($value['gc_id']==408){
                $superGoods['womenBag'][] = $value;//女款挎包
            }else if($value['gc_id']==411){
                $superGoods['womenMoneyBag'][] = $value;//女款钱包
            }else if($value['gc_id']==407){
                $superGoods['womenHandBag'][] = $value;//女款手提包
            }
        }
        
        $manBag = array_chunk($superGoods['manSlantingBag'], 5);//男款挎包
        $womenBage = array_chunk($superGoods['womenBag'], 5);//女款挎包
        $this->assign('superGoods',$superGoods);
        $this->assign('manBag',$manBag);
        $this->assign('womenBage',$womenBage);
        $this->display();
    }
    
    public function BeautyStocktake()
    {        
        $this->display();
    }
    
    public function PromotionActivity(){
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
        $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $data = D('SysConfig')->getCfgByModule('ACTIVITPPROJECT_TIME');
        if((time() > $beginThismonth) && (time () <  strtotime(date('Y-m-d',$beginThismonth) . '+ 15day'))){
           $halfMonther =  strtotime(date('Y-m-d',$beginThismonth) . '+ 14day');
           if(empty($data['ACTIVITPPROJECT_TIME'])){
               D("SysConfig")->setConfig('ACTIVITPPROJECT_TIME','ACTIVITPPROJECT_TIME',mktime(23,59,59,date('m',$halfMonther),date('d',$halfMonther),date('Y',$halfMonther)));
           } else {
               if(time() > $data['ACTIVITPPROJECT_TIME']){
                   D("SysConfig")->setConfig('ACTIVITPPROJECT_TIME','ACTIVITPPROJECT_TIME',mktime(23,59,59,date('m',$halfMonther),date('d',$halfMonther),date('Y',$halfMonther)));
               }
           }
        } else {
             if(empty($data['ACTIVITPPROJECT_TIME'])){
                    D("SysConfig")->setConfig('ACTIVITPPROJECT_TIME','ACTIVITPPROJECT_TIME',$endThismonth);
             } else {
                 if(time() >$data['ACTIVITPPROJECT_TIME']){
                    D("SysConfig")->setConfig('ACTIVITPPROJECT_TIME','ACTIVITPPROJECT_TIME',$endThismonth);
                 }
             }
        }
        echo date('Y-m-d H:i:s',$data['ACTIVITPPROJECT_TIME']);exit;

        
    }
    
}
