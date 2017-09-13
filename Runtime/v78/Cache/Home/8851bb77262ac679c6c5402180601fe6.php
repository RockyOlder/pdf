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
                <input type="hidden" id="LoadDataType" value="<?php echo ($_SESSION['Members']['LoadDataType']); ?>" />
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
                       <a href="<?php echo U('Home/Index/YearMiddlePage',array('s_type'=>0));?>" class="Behavior_Statistics_Banner" >
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
                            <a href="<?php echo U('Home/Index/YearMiddlePage#01',array('s_type'=>0));?>" class="first">买一个月送5次转换</a>
                            <a href="<?php echo U('Home/Index/YearMiddlePage#02',array('s_type'=>0));?>">买一年送3个月</a>
                            <a href="<?php echo U('Home/Index/YearMiddlePage#03',array('s_type'=>0));?>">买二年送6个月</a>
                        </div>
                    </div>
                </div><?php endif; ?>
            <input type="hidden" id="year" value="<?php echo ($year); ?>" />
            <input type="hidden" id="month" value="<?php echo ($month); ?>" />
            <input type="hidden" id="day" value="<?php echo ($day); ?>" />
            <input type="hidden" id="start_time" value="<?php echo ($start_time); ?>" />
            <input type="hidden" id="halfMonther" value="<?php echo ($halfMonther); ?>" />
            
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
            <div class="main_main">                
                <div class="record_box">
                     <div class="list_title">
                         <ul>
                             <li data-id="xf_record" <?php if($record == 'Prepaidrecords' ): ?>class="active"<?php endif; ?>><a href="<?php echo U('Home/Index/informationRecords',array('record'=>Prepaidrecords));?>">充值记录</a></li>
                         <li data-id="zh_record" <?php if($record == 'Conversionrecord' ): ?>class="active"<?php endif; ?>><a href="<?php echo U('Home/Index/informationRecords',array('record'=>Conversionrecord));?>" >转换记录</a></li>
                         </ul>
                     </div>
                     <div class="list_box">
                         <div class="list_con" id="xf_record"  <?php if($record == 'Prepaidrecords' ): ?>style="display:block;"<?php endif; ?>>
                             <table cellpadding="0" cellspacing="0" class="table_xf_record">
                                 <thead>
                                        <th class="first">时间</th>
                                        <th class="two">充值金额</th>
                                        <th class="three">状态</th>
                                 </thead>
                                 <tbody>
                                 <?php if(is_array($ary_article_list)): $k = 0; $__LIST__ = $ary_article_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$PaymentSeriallist): $mod = ($k % 2 );++$k;?><tr>
                                         <td class="first"><?php echo ($PaymentSeriallist["ps_create_time"]); ?> </td>
                                         <?php if($PaymentSeriallist['ps_buy_type'] == 1 ): ?><td><?php echo ($PaymentSeriallist["ps_money"]); ?>元（<?php echo ($PaymentSeriallist["ps_buy_nunmber"]); ?>次）</td>
                                                <?php else: ?>   
                                                <td><?php echo ($PaymentSeriallist["ps_money"]); ?>元（<?php echo ($PaymentSeriallist["ps_buy_nunmber"]); ?>个月）</td><?php endif; ?>   
                                             <?php if($PaymentSeriallist['ps_status'] == 0): ?><td><span class="not_pay">已过期</span></td>
                                               <?php elseif($PaymentSeriallist['ps_status'] == 1): ?>
                                                <td><span class="success">支付成功</span></td>
                                               <?php elseif($PaymentSeriallist['ps_status'] == 4): ?>
                                                 <td><span class="failure">已失效</span></td><?php endif; ?>
                                     </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </tbody>
                             </table>
                             <div class="pagination">
                                 <?php echo ($page); ?>
<!--                                 <a href="#">首页</a>
                                 <a href="javascript:;" class="prev">上一页</a>
                                 <a href="javascript:;" class="next">下一页</a>
                                 <a href="#">尾页</a>-->
                             </div>
                             <?php if(empty($ary_article_list)): ?><div class="noinfo">
                                         <img src="__IMAGES__pic-nozh.png" alt="" />
                                         <p>您暂时还没有充值记录哦</p>
                                    </div><?php endif; ?>
                         </div>
                         <div class="list_con" id="zh_record" <?php if($record == 'Conversionrecord' ): ?>style="display:block;"<?php endif; ?>>
                             <div class="promet">请您在24小时之内进行下载，超过24小时下载链接将失效！</div>
                              <table cellpadding="0" cellspacing="0" class="table_zh_record">
                                 <thead>
                                        <th class="first">时间</th>
                                        <th class="two">文件名</th>
                                        <th class="three">状态</th>
                                        <th class="four">转换方式</th>
                                        <th class="five">下载链接</th>
                                 </thead>
                                 <tbody>
                                     <?php if(is_array($PdfListSelect)): $k = 0; $__LIST__ = $PdfListSelect;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$PdfListSelectlist): $mod = ($k % 2 );++$k;?><tr>
                                         <td class="first"><?php echo ($PdfListSelectlist[crate_time]); ?></td>
                                         <td class="file_name"><p><?php echo ($PdfListSelectlist[fname]); ?></p></td>
                                        <?php if( $PdfListSelectlist['cstate'] == 1 ): ?><td><span class="success">转换成功</span></td>
                                               <?php elseif($PdfListSelectlist['cstate'] == 2): ?>
                                                 <td><span class="failure">转换失败</span></td>
                                               <?php elseif($PdfListSelectlist['fstate'] != 1 and $PdfListSelectlist['cstate'] != 1 and $PdfListSelectlist['fdown'] != 1): ?>
                                                <td><span class="failure">上传失败</span></td><?php endif; ?>
                                              <?php if($PdfListSelectlist['conversion_type'] == 1 ): ?><td>次数</td>
                                                  <?php elseif($PdfListSelectlist['conversion_type'] == 2 ): ?>
                                                     <td>月份</td>
                                                   <?php else: ?>  
                                                     <td>免费</td><?php endif; ?>
                                         <td>
                                               <?php if( $PdfListSelectlist['cstate'] == 1 ): if( $PdfListSelectlist['lastDown'] == 1 ): ?><a href="javascript:void(0)" class="not_pay" >已过期</a>
                                                       <?php else: ?>
                                                       <a href="javascript:void(0)" class="success"  onclick="getFileDownload('<?php echo ($PdfListSelectlist["m_id"]); ?>','<?php echo ($PdfListSelectlist["id"]); ?>')">点击下载</a><?php endif; ?>
                                                    
                                                     
                                               <?php elseif($PdfListSelectlist['cstate'] == 2 ): ?>
                                                  <a href="<?php echo U('Home/Index/artificialvip');?>" class="success">人工vip
                                                     </a>
                                               <?php elseif($PdfListSelectlist['fstate'] != 1 and $PdfListSelectlist['cstate'] != 1 and $PdfListSelectlist['fdown'] != 1): ?>
                                                   <a href="http://file1.cqttech.com/soft/Yueshu/YueShuPDF_setup.exe" class="success">客户端转换
                                                     </a><?php endif; ?>
                                    
                                         </td>
                                     </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </tbody>
                             </table>
                             <div class="pagination">
                                   <?php echo ($pdf_page); ?>
                             </div>
                             <?php if(empty($PdfListSelect)): ?><div class="noinfo">
                                         <img src="__IMAGES__pic-noswith.png" alt="" />
                                         <p>您暂时还没有转换记录哦</p>
                                    </div><?php endif; ?>

                         </div>
                     </div>
                </div>                
            </div>
        </div>
</div>
<!-- 各种状态的弹窗 -->
<div class="popup popup_other">
    <div class="content" name="teachesDay">
        <div class="icon close" itemid="1" ></div>
        <a href="<?php echo U('Home/Index/YearMiddlePage',array('s_type'=>1));?>" itemtype="1" itemid="1" class="ClickTheBanner" >
            <img src="__IMAGES__images/x01.jpg"  alt="教师节抢购" />
        </a>
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