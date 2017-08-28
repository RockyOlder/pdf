<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($page_title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="keywords" content="<?php echo ($page_keywords); ?>">
        <meta name="description" content="<?php echo ($page_description); ?>">
        <link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="__CSS__webuploader.css">
	<link rel="stylesheet" type="text/css" href="__CSS__style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="__CSS__loaders.css"/>
	<link rel="stylesheet" type="text/css" href="__CSS__xcConfirm.css"/>
        <link rel="stylesheet" type="text/css" href="__CSS__jquery.fileupload.css"/>

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
                     <div class="info">
                         <i class="arrow_up"></i>
                         <div class="content">
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
                                                <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red'  >亲，您的套餐马上要到期了，现在购买套餐尊享<span class="zkou">9</span>折优惠哦~</a></p><?php endif; ?>
                                            <?php if($time_count > 7 and $time_count > 0 and $out_time == 0): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
                                            <?php if($out_time <= 30 and $out_time > 0): ?><i class="icon icon-gift"></i>
                                                <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red' >亲，您的套餐已经到期了，现在购买套餐尊享<span class="zkou">9.5</span>折优惠哦~</a></p><?php endif; ?>
                                            <?php if($out_time > 30 and $time_count != 0 ): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
                                        </div>

                         </div>
                         <div class="work_time">
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
            </div>
        </div>
    </div>
	    <table width="1920" height="9300" border="0">
  <tr>
    <td width="1920" height="1069"><table id="__01" width="1920" height="1069" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td rowspan="7">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_01.jpg" width="362" height="1068" alt=""></td>
		<td colspan="4">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_02.jpg" width="1209" height="251" alt=""></td>
		<td rowspan="7">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_03.jpg" width="349" height="1068" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_04.jpg" width="313" height="153" alt=""></td>
		<td colspan="3">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_05.jpg" width="896" height="153" alt=""></td>
	</tr>
	<tr>
		<td>
		<a href="javascript:void(0);" id="qqonline_float_1" onclick="qqclick('1')">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_06.jpg" width="313" height="45" alt="">
		</a>			
		</td>
		<td colspan="3">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_07.jpg" width="896" height="45" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_08.jpg" width="1209" height="198" alt=""></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="3">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_09.jpg" width="820" height="421" alt=""></td>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_10.jpg" width="328" height="151" alt=""></td>
		<td rowspan="3">
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_11.jpg" width="61" height="421" alt=""></td>
	</tr>
	<tr>
		<td>
			<a href="javascript:void(0);" id="qqonline_float_2" onclick="qqclick('2')">
				<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_12.jpg" width="328" height="36" alt="">
			</a>
		</td>
	</tr>
	<tr>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_01_13.jpg" width="328" height="234" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/fgf.gif" width="362" height="1" alt=""></td>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/fgf.gif" width="313" height="1" alt=""></td>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/fgf.gif" width="507" height="1" alt=""></td>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/fgf.gif" width="328" height="1" alt=""></td>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/fgf.gif" width="61" height="1" alt=""></td>
		<td>
			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/fgf.gif" width="349" height="1" alt=""></td>
	</tr>
</table>
<!-- End Save for Web Slices --></td>
  </tr>
  <tr>
    <td width="1920" 7682><table width="1920" style="margin-top:-15px;" height="7682" border="0">
  <tr>
    <td width="289" height="7682">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_01.jpg" width="289" height="7682" alt=""></td>
    <td width="1342" height="7682"><table width="1342" border="0">
      <tr>
        <td width="1342" height="510">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_02.jpg" width="1342" height="510" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="626">
        	<a href="javascript:void(0);" id="qqonline_float_3" onclick="qqclick('3')">
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_04.jpg" width="1342" height="626" alt="">
        	</a>
        </td>
      </tr>
      <tr>
        <td width="1342" height="108">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_05.jpg" width="1342" height="108" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="514">
        	<a href="javascript:void(0);" id="qqonline_float_4" onclick="qqclick('4')">
				<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_06.jpg" width="1342" height="514" alt="">
			</a>
		</td>
      </tr>
      <tr>
        <td width="1342" height="230">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_07.jpg" width="1342" height="230" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="418">
        	<a href="javascript:void(0);" id="qqonline_float_5" onclick="qqclick('5')">
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_08.jpg" width="1342" height="418" alt="">
    		</a>

    	</td>
      </tr>
      <tr>
        <td width="1342" height="66">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_09.jpg" width="1342" height="66" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="636">
        	<a href="javascript:void(0);" id="qqonline_float_6" onclick="qqclick('6')">			
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_10.jpg" width="1342" height="636" alt="">
        	</a>
        </td>
      </tr>
      <tr>
        <td width="1342" height="172">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_11.jpg" width="1342" height="172" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="510">
        	<a href="javascript:void(0);" id="qqonline_float_7" onclick="qqclick('7')">
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_12.jpg" width="1342" height="510" alt="">
        	</a>

        </td>
      </tr>
      <tr>
        <td width="1342" height="122">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_13.jpg" width="1342" height="122" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="596">
        	<a href="javascript:void(0);" id="qqonline_float_8" onclick="qqclick('8')">
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_14.jpg" width="1342" height="596" alt="">
        	</a>
        </td>
      </tr>
      <tr>
        <td width="1342" height="96">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_15.jpg" width="1342" height="96" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="608">
        	<a href="javascript:void(0);" id="qqonline_float_9" onclick="qqclick('9')">
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_16.jpg" width="1342" height="608" alt="">
        	</a>

        </td>
      </tr>
      <tr>
        <td width="1342" height="90">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_17.jpg" width="1342" height="90" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="586">
        	<a href="javascript:void(0);" id="qqonline_float_10" onclick="qqclick('10')">
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_18.jpg" width="1342" height="586" alt="">
        	</a>
        </td>
      </tr>
      <tr>
        <td width="1342" height="96">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_19.jpg" width="1342" height="96" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="608">
        	<a href="javascript:void(0);" id="qqonline_float_11" onclick="qqclick('11')">
       			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_20.jpg" width="1342" height="608" alt="">
       		</a>
        </td>
      </tr>
      <tr>
        <td width="1342" height="62">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_21.jpg" width="1342" height="62" alt=""></td>
      </tr>
      <tr>
        <td width="1342" height="612">
        	<a href="javascript:void(0);" id="qqonline_float_12" onclick="qqclick('12')">		
        		<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_22.jpg" width="1342" height="612" alt="">
        	</a>
        </td>
      </tr>
        <td width="1342" height="416">	
        <a href="/Home/Products/GoodsStrade" target="_blank">        	
        	<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_23.jpg" width="1342" height="416" alt="">
        </a>

        </td>
      </tr>
    </table></td>
    <td width="289" height="7682">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_02_03.jpg" width="289" height="7682" alt=""></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td width="1920" height="550"><table width="1920" height="550" border="0">
  <tr>
    <td width="289" height="550">			<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_03_01.jpg" width="289" height="550" alt=""></td>
    <td width="332" height="550"><a href="http://www.xyb2b.com/Home/Products/detail/gid/530" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_03_02.jpg" width="332" height="550" alt=""></a></td>
    <td width="339" height="550"><a href="http://www.xyb2b.com/Home/Products/detail/gid/531" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_03_03.jpg" width="339" height="550" alt=""></a></td>
    <td width="318" height="550"><a href="http://www.xyb2b.com/Home/Products/detail/gid/2289" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_03_04.jpg" width="318" height="550" alt=""></a></td>
		<td></td>
    <td width="353" height="550"><a href="http://www.xyb2b.com/Home/Products/detail/gid/2288" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_03_05.jpg" width="353" height="550" alt=""></a></td>
    <td width="289" height="550"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/big_goods_trade/2_03_06.jpg" width="289" height="550" alt=""></td>
  </tr>
</table>
</td>
  </tr>
</table>
<script type="text/javascript">
	function qqclick(id){    
	     BizQQWPA.addCustom({ //增加自定义外观的WPA
	        aty: '0', //接入类型，0-自动分流，1-指定工号，2-指定分组
	        a: '1002',  //指定接入者，当aty=0时无效
	        nameAccount: '4008635878',//营销QQ号
	  		selector: 'qqonline_float_'+id//指定成为WPA的元素ID
	    });
	    BizQQWPA.visitor({  //为页面添加访客功能（主动，自动邀请，TA统计）
	        nameAccount: '4008635878'
	    });
	    //http://wpa.b.qq.com/cgi/wpa.php?ln=2&uin=4008635878
	}
</script>
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