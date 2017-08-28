<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($page_title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="keywords" content="<?php echo ($page_keywords); ?>">
        <meta name="description" content="<?php echo ($page_description); ?>">
        <link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/webuploader.css">
	<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/style.css">
	<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/loaders.css"/>
	<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/xcConfirm.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/jquery.fileupload.css"/>

    </head>
	<body id="goTop"  ><!--      -->

	        <div class="header">
        <div class="wrap clearfix">
            <a href="<?php echo U('Home/Index/CoreBusiness');?>" class="brand"><img src="__IMAGES__brand.png"  alt="pdf在线转换器" /></a>
            <ul class="nav">
                <li <?php if($header_tag_highlighted == 3 ): ?>class="current"<?php endif; ?>><a href="/">首页</a></li>
                <li <?php if($header_tag_highlighted == 4 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/CoreBusiness');?>">开始转换</a></li>
                <li <?php if($header_tag_highlighted == 1 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/artificialvip');?>">人工VIP</a></li>
                <li <?php if($header_tag_highlighted == 2 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/informationRecords');?>">信息记录</a></li>
                <li>联系我们
                    <div class="info">
                        <i class="arrow_up"></i>
                        <p><i class="icon icon_qq"></i>官方QQ群<a href="http://shang.qq.com/wpa/qunwpa?idkey=5b012a15f072526bb9334848d8f60dbcaf7c8e2f7023f3378e1655ddd364dd00" target="_blank">(点击加入)</a></p>
                        <p><i class="icon icon_qq"></i>QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" target="_blank">3004137938</a></p>
                        <p><i class="icon icon_phone"></i>0755-86952275</p>
                        <div class="work_time">周一至周五 09:00-18:00</div>                        
                    </div>
                </li>
            </ul>
            <div class="login">
            <?php if(empty($_SESSION['Members']['m_name'])): ?><a href="javascript:return false;" id="login_weixin" class="login_weixin">登录</a><!-- <?php echo U('Home/Index/weixin_login');?> --><?php endif; ?>
                <?php if(!empty($_SESSION['Members']['m_name'])): ?><div class="user">
                     <div class="name">你好，<?php echo ($_SESSION['Members']['m_name']); ?></div>
                     <div class="info" id="appendHtml">
                         
<i class="arrow_up"></i>
<div class="content" id="hederGet">
    <h3><div class="login_name" title="<?php echo ($_SESSION['Members']['m_name']); ?>"><?php echo ($_SESSION['Members']['m_name']); ?></div></h3><a href="<?php echo U('Home/User/doLogout');?>" class="exit">退出<!-- <div><i class="icon icon_exit"></i></div>  --></a>
    <p class="promet2"> 
    <?php $out_time = 0; if(time() > strtotime($ary_member['end_time'])){ $time_count =0; $out_time = count_days(strtotime($ary_member['end_time']),strtotime(date('Y-m-d'))); $out_day_small = time() - strtotime($ary_member['end_time']); if($out_day_small < 86400){ $out_time = 1; } }else { $time_count = count_days(strtotime(date('Y-m-d H:i:s')),strtotime($ary_member['end_time'])); if($time_count == 0){ $time_count_show = 1; }else { $time_count_show = $time_count; } } ?>
    <?php if(($ary_member["conversion_type"] == 0 and $out_time == 0) or ($out_time > 30 and $ary_member["conversion_type"] == 0) ): ?>您当前还未充值<?php endif; ?>
</p>
<?php if($ary_member["conversion_type"] == 1 and $ary_member["number_remaining"] != 0): ?><p>次数套餐：<span class="times"><?php echo ($ary_member["number_remaining"]); ?> </span>次&nbsp;&nbsp;&nbsp;
    <?php elseif($ary_member["conversion_type"] == 2): ?>
    <?php if($ary_member["number_remaining"] != 0 ): ?><p>VIP套餐：<span class="times"><?php echo $time_count_show; ?> </span>天(优先)&nbsp;&nbsp;&nbsp;次数套餐：<span class="times"><?php echo ($ary_member["number_remaining"]); ?> </span>次</p>
        <?php else: ?>
        <p>VIP套餐：<span class="times"><?php echo $time_count_show; ?> </span>天</p><?php endif; endif; ?>

<div class="warning_promet">
    <?php if((($ary_member["conversion_type"] == 0 and $out_time == 0) or ($out_time > 30)) or (($ary_member["conversion_type"] == 1 and $out_time == 0) or ($out_time > 30))): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
    <?php if($time_count == 0 and $out_time == 0 ): ?><i class="icon icon-gift"></i>
        <p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
    <?php if($time_count <= 7 and $time_count > 0 and $out_time == 0): ?><i class="icon icon-gift"></i>
        <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red'  >亲，您的VIP套餐马上要到期了，现在购买套餐尊享<span class="zkou">9</span>折优惠哦~</a></p><?php endif; ?>
    <?php if($time_count > 7 and $time_count > 0 and $out_time == 0): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
    <?php if($out_time <= 30 and $out_time > 0): ?><i class="icon icon-gift"></i>
        <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red' >亲，您的VIP套餐已经到期了，现在购买套餐尊享<span class="zkou">9.5</span>折优惠哦~</a></p><?php endif; ?>
    <?php if($out_time > 30 and $time_count != 0 ): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
</div>
</div>
<div class="work_time" data-id="info" id="header_tag_data">
    <a href="<?php echo U('Home/Index/informationRecords',array('record'=>Prepaidrecords));?>" class="record">充值记录</a>
    <a href="<?php echo U('Home/Index/informationRecords',array('record'=>Conversionrecord));?>" class="record">转换记录</a>
    <a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="now_cz">立即充值</a>
</div>                   
                     </div>
                 </div><?php endif; ?>

                <div class="recharge_box">&nbsp;&nbsp;│&nbsp;&nbsp;<a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="recharge">充值</a></div>
                <input type="hidden" value="<?php echo ($_SESSION['Members']['m_id']); ?>" name ="gy_member_open" id="gy_member_open"/>
                <input type="hidden" value="<?php echo ($redirect); ?>" name ="redirect" id="redirect"/>
                <input type="hidden" id="Authorizationtype" value="<?php echo ($ary_member["conversion_type"]); ?>" />
                <input type="hidden" id="Free_authorization" value="<?php echo ($ary_member["Free_authorization"]); ?>" />
                <input type="hidden" id="ACTIVITY_OPEN" value="<?php echo ($ACTIVITY_OPEN); ?>" />
            </div>
        </div>
    </div>
	    <script type="text/javascript" src="/Public/Tpl/v78/<?php echo ($view); ?>/js/require.js" data-main="/Public/Tpl/v78/<?php echo ($view); ?>/js/ConversionFeeDetail"  defer async="true" ></script>    
<div class="main">
        <div class="wrap">
            <?php if($ACTIVITY_OPEN != 1): ?><div class="activity_con">
                    <div class="content">
                        <a href="<?php echo U('Home/Index/YearMiddlePage');?>" class="linkbox"></a>                                                                                 
                        <div class="Deadline count_down">距离<span class="end_date"></span>活动截止还剩<span class="day"></span><span class="time"></span></div>
                    </div>
                </div><?php endif; ?>
            <div class="main_main">                
                <div class="package_box">
                   <!--  <h3>悦书PDF在线转换工具每天可以免费转换一次50页</h3> -->
                    <div class="promet">温馨提示： 我们无法提供充值金额的提现和返还服务,请您谅解！</div>
                    <div class="package">
                        <div class="promet">充值用户享有20M以内文档转换特权，超过20M请使用 <a href="<?php echo U('Home/Index/artificialvip');?>">人工VIP</a> 或 <a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe">客户端转换</a></div>
                        <div class="content">
                            <div class="section section_one">
                                <div class="left">次数套餐:</div>
                                <div class="right">
                                    <div class="item num_input" data-now="<?php echo ($page_detail["ary_goods_number_pdt"]["pdt_sale_price"]); ?>" data-details='1'  data-pdt_sn='<?php echo ($page_detail["ary_goods_number_pdt"]["pdt_sn"]); ?>' data-pdt_id='<?php echo ($page_detail["ary_goods_number_pdt"]["pdt_id"]); ?>' id="times">
                                        <div class="species"><?php echo ($page_detail["ary_goods_number_pdt"]["specName"]); ?></div>
                                        <div class="species_price">&yen;<span>2</span></div>
                                        <i class="icon icon_current"></i>
                                    </div>
                                    <div class="item num_input" name="num_input">
                                        <input type="text" class="amount" name='number' id='pdt_id_number' value="5"/>
                                        <div class="upor_down">
                                            <div class="add_numberof"></div>                                            
                                            <div class="reduce_numberof"></div>                                            
                                        </div>
                                        <span class="unit">次</span>
                                    </div>
                                    <div class="give_promet">(可享受 <span>6</span> 次转换服务)</div>
                                </div>
                            </div>
                            <div class="section section_two">
                                <div class="left">VIP套餐:</div>
                                <div class="right">
                                    <?php if(is_array($page_detail["json_goods_pdts"])): $k = 0; $__LIST__ = $page_detail["json_goods_pdts"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_spec): $mod = ($k % 2 );++$k; if($goods_spec['pdt_g_remark'] != ''): if($goods_spec['pdt_min_num'] == 1 ): ?><div class="item current" data-now="<?php echo ($goods_spec["pdt_sale_price"]); ?>" data-details='2'  data-pdt_sn='<?php echo ($goods_spec["pdt_sn"]); ?>' data-pdt_id='<?php echo ($goods_spec["pdt_id"]); ?>' data-first="<?php echo ($goods_spec["pdt_set_sale_price"]); ?>" name="tc_default">
                                                                              <em></em>
                                                                              <div class="species"><?php echo ($goods_spec["specName"]); ?></div>
                                                                              <div class="species_price">&yen;<span><?php echo ($goods_spec["pdt_sale_price"]); ?></span></div>
                                                                              <i class="icon icon_current"></i>
                                                                          </div>
                                                                 <?php else: ?>   
                                                                          <div class="item" data-now="<?php echo ($goods_spec["pdt_sale_price"]); ?>" data-pdt_id='<?php echo ($goods_spec["pdt_id"]); ?>' data-details='2'  data-pdt_sn='<?php echo ($goods_spec["pdt_sn"]); ?>' data-first="<?php echo ($goods_spec["pdt_set_sale_price"]); ?>">
                                                                              <div class="species"><?php echo ($goods_spec["specName"]); ?></div>
                                                                              <div class="species_price">&yen;<span><?php echo ($goods_spec["pdt_sale_price"]); ?></span></div>
                                                                              <i class="icon icon_current"></i>
                                                                          </div><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>                                    
                                </div>
                            </div>
                            <div class="section section_three">
                                <div class="original">
                                    <div class="left">套餐金额:</div>
                                    <div class="right">
                                        <div class="pay" id="pay"><span class="pay_money"></span><span class="first_price"></span><span class="save_money"></span></div>                                                                         
                                    </div>
                                </div>
                                <div class="discount">
                                    <div class="left">优惠折扣:</div>
                                    <div class="right"><strong></strong>老用户专享！</div>
                                </div>
                                <div class="last_pay">
                                    <div class="left">应付金额:</div>
                                    <div class="right">
                                        <div class="pay"><span class="pay_money"></span>元</div> 
                                        <div class="pay_method">
                                            <div class="zfb_pay"><a href="javascript:void(0);">支付宝支付</a></div>
                                            <div class="weixin_pay">微信支付</div>
                                        </div>                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
            <div class="add_banner"><a href="<?php echo U('Home/Products/Price_service_details');?>"><img src="__IMAGES__banner-2_03.jpg" alt="每日送,套餐特权,转换无忧" /></a></div>
            <form id="submitSkipFrom" name="submitSkipFrom" method="post" action="/Ucenter/Financial/doALIPAY">
                <input type="hidden" name="type" value="item" id="item_type" />
                <input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_id"]); ?>" name="pdt_id" id="pdt_id" />
                <input type="hidden" value="2" name="details" id="details" />
                <input type="hidden" value="5" name="pdt_stock" id="pdt_stock" />
                <input type="hidden" value="ALIPAY" name="pc_abbreviation" id="pc_abbreviation" />
                <input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_sn"]); ?>" name="pdt_sn" id="pdt_sn" />
                <input type="hidden" value="" name="o_id" id="o_id" />
                <input type="hidden" value="<?php echo ($ary_member["end_time_count"]); ?>" name="end_time" id="end_time" />
                <input type="hidden" value="<?php echo ($ary_member["end_time_count_out"]); ?>" name="end_time_count_out" id="end_time_count_out" />
                <input type="hidden" value="<?php echo ($PaymentSerialCount); ?>" name="PaymentSerialCount" id="PaymentSerialCount" />
                <input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_sale_price"]); ?>" name="pdt_sale_price" id="pdt_sale_price" />
                <input type="hidden" id="year" value="<?php echo ($year); ?>" />
                <input type="hidden" id="month" value="<?php echo ($month); ?>" />
                <input type="hidden" id="day" value="<?php echo ($day); ?>" />
                <input type="hidden" id="start_time" value="<?php echo ($start_time); ?>" />
                <input type="hidden" id="halfMonther" value="<?php echo ($halfMonther); ?>" />
            </form>

        </div>
    </div>
    <!-- 微信弹窗 -->
    <div class="popup popup_weixin">
        <div class="content">
            <div class="icon close"></div>
            <div class="popup_content">

            </div>
        </div>        
    </div>
    <!-- 支付宝弹窗 -->
    <div class="popup popup_zfb">
         <div class="content" id="be_paid">
            <div class="icon close"></div>
            <div class="zfb_info">
                <div class="top">
                    <div class="order_number">订单号：<i id="o_id_orders"></i></div>
                    <div class="order_name">订单名称：悦书PDF阅读器授权购买</div>
                    <div>应付金额：<div class="pay" id="realPay">&yen;<span class="pay_money" id="pay_order_price"></span></div></div>
                </div>
                <div class="bottom">
                    <a href="javascript:void(0);" target="_blank" class="btn pay_zfb">去支付宝支付</a>
                </div>                
            </div>
        </div> 
         <div class="content" id="pay_Waiting">
            <div class="icon close"></div>
            <div class="zfb_info">
                <i class="icon icon-dhao"></i>
                <p>支付完成前，请不要刷新页面或关闭此支付窗口。</p> 
                <p>支付完成后，请根据您的支付情况点击下面的按钮。</p>              
                <div class="bottom">
                    <a href="javascript:;" class="btn btn_end">支付完成</a>
                    <a href="http://bbs.cqttech.com/forum.php?mod=viewthread&tid=88" class="btn btn_danger" target="_blank">支付出问题</a>
                </div>                
            </div>
        </div> 

        <div class="content" id="play_success">
            <div class="icon close"></div>
            <div class="zfb_info">
                <i class="icon icon-end"></i>
                <div class="txt">您已成功支付<span class="pay">&yen;<span class="pay_money" id="pay_sccess_price"></span></span></div>  
                <div class="promet">您的授权剩余次数<span id="total_number">2</span>次，剩余时间还剩<span id="total_time">12</span>天</div>           
                <div class="bottom">
                    <a href="javascript:;" class="btn btn_contain">继续购买</a>
                    <a href="javascript:;" class="btn btn_return">返回</a>
                </div>                
            </div>
        </div>
    </div>
    <div class="popup popup_other" id='open_box' >
        <div class="content" name="content_payment">
            <div class="icon close"></div>
                 <div class="txt">
                     <p>亲，您本月已有三次付费转换记录</p>
                     <p>悦书为您推荐<span class="strong">包月套餐</span></p>
                     <p> 性价比更高，更适合你哦~</p>
                 </div>
                <div class="bottom">
                    <a href="####" class="btn btn_only_change">购买单次</a>
                    <a href="####" class="btn btn_recharge">试试包月</a>
                </div> 
        </div>          
    </div>










        <?php if(TPL!='sky'){ ?>
	    <noempty name="ary_online">
<style>
/*在线咨询   开始*/
.cusService { display:inline-block; position:fixed; left:0px; top:200px;}
.cusServiceCon { float:left; width:180px; border:1px solid #d7d7d7; background:white; display:none}
.cusServiceCon table { width:100%}
.cusServiceCon table thead td { border-bottom:1px solid #d7d7d7; color:#333; font-size:14px; text-shadow:1px 1px 3px #999;}
.cusServiceCon table td { padding:5px 0px; line-height:23px; padding-left:10px;}
.cusServiceCon table td.addBorder { border-top:1px dashed #d7d7d7;}
.cusServiceCon table td a { display:inline-block; white-space:nowrap}
.cusServiceCon table td span { position:relative; margin-left: 4px;}
.cusServiceCon table td a:hover { text-decoration:none; color:red;}
.cusServiceCon table tfoot td { border-top:1px sold #d7d7d7;}
a.cusSerClick { float:left; background:url(__PUBLIC__/Ucenter/images/customerService.jpg) no-repeat 0px -124px; width:42px; height:124px;}
a.cusSerClickAgain { background-position:0px 0px;}
/*在线咨询   结束*/
</style>
<?php if(isset($ary_online)): ?><div class="cusService" style="z-index:100"><!--cusService  客服 start-->
	<div class="cusServiceCon" id="cusCon">
    	<table>
        	<thead>
            	<tr>
                	<td><strong>在线咨询</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($ary_online)): $i = 0; $__LIST__ = $ary_online;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$online): $mod = ($i % 2 );++$i;?><tr><td align="center"><strong><?php echo ($online["oc_name"]); ?></strong></td></tr>
                <?php if(is_array($online["server"])): $i = 0; $__LIST__ = $online["server"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$server): $mod = ($i % 2 );++$i;?><tr>
                	<td>
                    	<?php echo ($server["o_code"]); ?><span><?php echo ($server["o_name"]); ?></span>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <tfoot>
            	<tr>
                	<td style="border-top:1px solid #d7d7d7;">在线时间：<?php echo (($online_start_time)?($online_start_time):'9:00'); ?>-<?php echo (($online_end_time)?($online_end_time):'18:00'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <a href="javascript:void(0)" class="cusSerClick" id="azx" style="display:block"></a>
</div><!--cusService  end-->
<script type="text/javascript">
/*$(function(){
	$("a.cusSerClick").hover(function(){
		$(".cusServiceCon").show();
		$(this).css("babkgroundPosition":"0px 0px")
	},function(){
		$(".cusServiceCon").hide();
		$(this).css("babkgroundPosition":"0px -124px")
	})
});*/

//window.onload=function(){
	var azx=document.getElementById('azx');
	var cus=document.getElementById('cusCon');
	
	azx.onclick=function(){
		if(cus.style.display=='block'){
			cus.style.display='none'
			this.style.backgroundPosition='0px -124px';
		}else {
			cus.style.display='block';
			this.style.backgroundPosition='0px 0px'
		}
	}
	
//}
</script><?php endif; ?>
</noempty>

        <?php } ?>
	        <div class="footer">
        <p>&nbsp;&nbsp;E-mail：<a href="mailto:service@cqttech.com" >service@cqttech.com</a>&nbsp;&nbsp;网址：<a href="http://www.cqttech.com" target="_blank">http://www.cqttech.com</a></p>
        <p>Copyright (C) 2017 IVY Tec. All Rights Reserved.  <a href="http://www.miibeian.gov.cn/" target="_blank">粤ICP备16105002号-2</a></p>
        <p>商务QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004139668&site=qq&menu=yes" target="_blank">3004139668</a> | 产品QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004198912&site=qq&menu=yes" target="_blank">3004198912</a> | 客服QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" target="_blank">3004137938</a></p>
    </div>

		<?php if($_SESSION['OSS']['GY_OSS_ON'] == '1'){ ?>
			<input type="hidden" value="1" id="oss_id" />
		<?php }else{ ?>
			<input type="hidden" value="0" id="oss_id" />
		<?php } ?>
		<?php if($ary_request[index]== true){ ?>
		<input type="hidden" id="is_index" value="1" />
		<?php }else{ ?>	
		<input type="hidden" id="is_index" value="0" />
		<?php } ?>
	    <!-- 是否有统计代码,有则显示  Start-->
		<?php if(isset($shop_code)): ?><noempty name="shop_code">
	    	<div class="statistics"><?php echo ($shop_code); ?></div>
	    </noempty><?php endif; ?>
	    <!-- 是否有统计代码，有则显示 End-->
	</body>
</html>