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
                     <div class="info">
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
                         <div class="work_time" data-id="info">
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
	    <script type="text/javascript" src="/Public/Tpl/v78/<?php echo ($view); ?>/js/require.js" data-main="/Public/Tpl/v78/<?php echo ($view); ?>/js/common" defer async="true" ></script>
<div class="main">
        <div class="wrap">
            <div class="add_banner" style="display:none;"><a href="/Home/Products/ConversionFeeDetail"><img src="__IMAGES__banner-1.2_03.jpg" alt=""></a><i class="icon icon-close"></i></div>
            <?php if($ACTIVITY_OPEN != 1): ?><div class="activity_banner">
                    <img src="__IMAGES__images/1_03.jpg" alt="" />
                    <div class="content">
                       <a href="<?php echo U('Home/Index/YearMiddlePage');?>">
                        <div class="left">
                            <img src="__IMAGES__images/txt.png" alt="" />                       
                        </div>
                        <div class="count_down right">
                            <h3>距离<span class="end_date"></span>活动截止还剩</h3>
                            <p><span class="day"></span><span class="time"></span></p>
                            <span class="details">活动详情</span>
                        </div>
                        </a>
                        <div class="linkbox">
                            <a href="<?php echo U('Home/Index/YearMiddlePage#01');?>" class="first">买一个月送5次转换</a>
                            <a href="<?php echo U('Home/Index/YearMiddlePage#02');?>">买一年送3个月</a>
                            <a href="<?php echo U('Home/Index/YearMiddlePage#03');?>">买二年送6个月</a>
                        </div>
                    </div>
                </div><?php endif; ?>

            
<div class="main_header">
                <ul>
                    <li <?php if($pdf_type == 0 ): ?>class="active"<?php endif; ?>>
                       <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>0));?>">
                            <i class="icon icon_s1"></i>
                            <p>PDF转Word</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 1 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>1));?>">
                            <i class="icon icon_s2"></i>
                            <p>PDF转Excel</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 2 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>2));?>">
                            <i class="icon icon_s3"></i>
                            <p>PDF转PPT</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 3 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>3));?>">
                            <i class="icon icon_s4"></i>
                            <p>Word转PDF</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 4 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>4));?>">
                            <i class="icon icon_s5"></i>
                            <p>Excel转PDF</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 5 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>5));?>">
                            <i class="icon icon_s6"></i>
                            <p>PPT转PDF</p>
                        </a>
                    </li>
                   
                </ul>
</div>
            <!--<iframe src="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" frameborder="0" scrolling="no" id="external-frame" style=" position: absolute;float: left;z-index: 888; background: windowframe;" onload="setIframeHeight(this)"  width="600" height="300"></iframe>-->
            <div class="main_main main_vip">                
                 <div class="rg_vip_main">
                     <h3>人工VIP服务将享有以下特权</h3>
                     <div class="list_box clearfix">
                         <div class="item item_one">
                             <i class="icon icon_v01"></i>
                             <h4>OCR识别，PDF文档识别率更高</h4>
                             <p>特有的PDF识别算法，支持普通PDF文件<br>
                                扫描PDF文件、加密PDF文件进行扫描识别，识别率高达95%</p>
                         </div>
                         <div class="item item_two">
                             <i class="icon icon_v02"></i>
                             <h4>转换速度更快，效率更高</h4>
                             <p>特有的PDF转换内核，转换速度更加迅速<br>提高您的工作效率，让繁琐的PDF文档转换变得更加容易</p>
                         </div>
                         <div class="item item_three">
                             <i class="icon icon_v03"></i>
                             <h4>文档隐私和加密</h4>
                             <p>您提交的所有文档，转换完成后都会在24小时内删除<br>确保您的文档隐私和安全，我们还提供文档加密防止数据泄露</p>
                         </div>
                         <div class="item item_four">
                             <i class="icon icon_v04"></i>
                             <h4>价格更亲民，效果不满意，全额退款</h4>
                             <p>人工VIP服务收费低价实惠，转换效果好，是您<br>办公、生活、娱乐的好助手，转换效果不满意，我们将全额退还您的费用</p>
                         </div>
                     </div>
                     <div class="rg_vip_footer">
                         <h3>通过以下方式获得人工VIP服务</h3>
                         <ul>
                             <li>
                                 <a  id="qq_open" href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" target="_blank" >
                                     <i class="icon icon_v05"></i>
                                     <p>腾讯企业QQ号</p>
                                      <div class="method">3004137938</div>
                                  </a>
                             </li>
                             <li><a href="mailto:service@cqttech.com" >
                                     <i class="icon icon_v06"></i>
                                     <p>1个工作日内邮件服务</p>
                                      <div class="method">service@cqttech.com</div>
                                  </a>
                             </li>
                             <li class="last">
                                 <i class="icon icon_v07"></i>
                                 <p>客户服务电话</p>
                                  <div class="method">0755-86952275</div>
                             </li>
                         </ul>
                         <div class="fw_time">服务时间：周一至周日 / 9:00-21:00</div>
                     </div>
                 </div>             
            </div>
            
        </div>
    </div>

<script language="javascript"> 
function setIframeHeight(iframe) {
if (iframe) {
var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
if (iframeWin.document.body) {
iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
}
}
};

//window.onload = function () {
//setIframeHeight(document.getElementById('external-frame'));
//};
</script>
<input type="hidden" id="year" value="<?php echo ($year); ?>" />
<input type="hidden" id="month" value="<?php echo ($month); ?>" />
<input type="hidden" id="day" value="<?php echo ($day); ?>" />
<input type="hidden" id="start_time" value="<?php echo ($start_time); ?>" />
<input type="hidden" id="halfMonther" value="<?php echo ($halfMonther); ?>" />
 <div class="popup popup_weixin" >

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