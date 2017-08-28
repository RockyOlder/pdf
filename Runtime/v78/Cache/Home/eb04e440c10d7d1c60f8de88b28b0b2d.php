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
	    ﻿<style type="text/css">
.japheader{ background: url(__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_02.jpg) no-repeat center top; height:750px; min-width:1213px;}
.japtitle{background: url(__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_04.jpg) no-repeat center top; height:137px; min-width:1213px; margin-top:65px;}
.japcon{width:1213px; margin:0 auto;}
.japbg{ background:#fdf0f7;min-width:1213px;}
.japtitle02{background: url(__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_13.jpg) no-repeat center top; height:137px; min-width:1213px;}
.japtitle03{background: url(__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_19.jpg) no-repeat center top; height:137px; min-width:1213px;}
.overdue { }
.overdue .con {width: 531px;position: fixed;top: 50%;left: 50%; z-index: 999;margin: -233px 0 0 -265px; text-align: center;z-index: 999;height: 466px;}
.overdue .bg { background:#000;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=30)";
 filter: progid:DXImageTransform.Microsoft.Alpha(opacity=30);
opacity: 0.3;width: 100%; height: 100%; position: fixed; z-index: 997;left: 0; top: 0; }
</style>
<div class="overdue" id="newz">
<div class="con">
<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/overdue.png" />
</div>
<div class="bg"></div>
</div>
<div class="japbg">
<div class="japheader"></div>
<div class="japtitle"></div>
<div class="japcon">
<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_09.jpg" width="1212" height="919" usemap="#Map">
<map name="Map">
  <area shape="rect" coords="62,363,242,748" href="http://www.xyb2b.com/Home/Products/detail/gid/2280" target="_blank">
  <area shape="rect" coords="355,241,567,646" href="http://www.xyb2b.com/Home/Products/detail/gid/2285" target="_blank">
  <area shape="rect" coords="654,38,869,412" href="http://www.xyb2b.com/Home/Products/detail/gid/2284" target="_blank">
  <area shape="rect" coords="955,4,1224,369" href="http://www.xyb2b.com/Home/Products/detail/gid/2283" target="_blank">
  <area shape="rect" coords="668,494,890,869" href="http://www.xyb2b.com/Home/Products/detail/gid/2278" target="_blank">
  <area shape="rect" coords="984,461,1208,845" href="http://www.xyb2b.com/Home/Products/detail/gid/2276" target="_blank">
</map>
<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_11.jpg" width="1212" height="782" usemap="#Map2">
<map name="Map2">
  <area shape="rect" coords="94,146,276,573" href="http://www.xyb2b.com/Home/Products/detail/gid/2289" target="_blank">
  <area shape="rect" coords="367,148,589,570" href="http://www.xyb2b.com/Home/Products/detail/gid/2288" target="_blank">
  <area shape="rect" coords="631,183,922,574" href="http://www.xyb2b.com/Home/Products/detail/gid/2272" target="_blank">
  <area shape="rect" coords="937,31,1224,382" href="http://www.xyb2b.com/Home/Products/detail/gid/2287" target="_blank">
  <area shape="rect" coords="971,427,1218,782" href="http://www.xyb2b.com/Home/Products/detail/gid/2275" target="_blank">
</map>
<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_12.jpg" width="1212" height="1201" usemap="#Map3">
<map name="Map3">
  <area shape="rect" coords="83,-1,326,333" href="http://www.xyb2b.com/Home/Products/detail/gid/2271" target="_blank">
  <area shape="rect" coords="431,109,749,459" href="http://www.xyb2b.com/Home/Products/detail/gid/2270" target="_blank">
  <area shape="rect" coords="843,198,1168,552" href="http://www.xyb2b.com/Home/Products/detail/gid/2269" target="_blank">
  <area shape="rect" coords="113,664,429,1073" href="http://www.xyb2b.com/Home/Products/detail/gid/530" target="_blank">
  <area shape="rect" coords="584,683,811,1102" href="http://www.xyb2b.com/Home/Products/detail/gid/531" target="_blank">
</map>
</div>
<div class="japtitle02"></div>
<div class="japcon">
  <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_15.jpg" width="1213" height="1551" usemap="#Map4">
  <map name="Map4">
    <area shape="rect" coords="4,338,260,714" href="http://www.xyb2b.com/Home/Products/detail/gid/1738" target="_blank">
    <area shape="rect" coords="290,257,543,624" href="http://www.xyb2b.com/Home/Products/detail/gid/620" target="_blank">
    <area shape="rect" coords="590,31,888,401" href="http://www.xyb2b.com/Home/Products/detail/gid/621" target="_blank">
    <area shape="rect" coords="596,483,888,850" href="http://www.xyb2b.com/Home/Products/detail/gid/618" target="_blank">
    <area shape="rect" coords="944,30,1210,399" href="http://www.xyb2b.com/Home/Products/detail/gid/619" target="_blank">
    <area shape="rect" coords="937,473,1224,846" href="http://www.xyb2b.com/Home/Products/detail/gid/622" target="_blank">
    <area shape="rect" coords="26,1018,293,1385" href="http://www.xyb2b.com/Home/Products/detail/gid/604" target="_blank">
    <area shape="rect" coords="352,1068,597,1425" href="http://www.xyb2b.com/Home/Products/detail/gid/605" target="_blank">
    <area shape="rect" coords="648,1007,893,1357" href="http://www.xyb2b.com/Home/Products/detail/gid/1597" target="_blank">
    <area shape="rect" coords="937,916,1223,1289" href="http://www.xyb2b.com/Home/Products/detail/gid/607" target="_blank">
  </map>
  <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_17.jpg" width="1213" height="1403" usemap="#Map5">
  <map name="Map5">
    <area shape="rect" coords="63,90,422,445" href="http://www.xyb2b.com/Home/Products/detail/gid/95" target="_blank">
    <area shape="rect" coords="466,87,797,447" href="http://www.xyb2b.com/Home/Products/detail/gid/1866" target="_blank">
    <area shape="rect" coords="843,92,1185,448" href="http://www.xyb2b.com/Home/Products/detail/gid/96" target="_blank">
    <area shape="rect" coords="60,518,418,878" href="http://www.xyb2b.com/Home/Products/detail/gid/97" target="_blank">
    <area shape="rect" coords="460,519,805,871" href="http://www.xyb2b.com/Home/Products/detail/gid/98" target="_blank">
    <area shape="rect" coords="839,527,1196,873" href="http://www.xyb2b.com/Home/Products/detail/gid/611" target="_blank">
    <area shape="rect" coords="66,958,247,1350" href="http://www.xyb2b.com/Home/Products/detail/gid/1864" target="_blank">
    <area shape="rect" coords="380,961,558,1343" href="http://www.xyb2b.com/Home/Products/detail/gid/612" target="_blank">
    <area shape="rect" coords="686,959,875,1340" href="http://www.xyb2b.com/Home/Products/detail/gid/613" target="_blank">
    <area shape="rect" coords="990,954,1184,1337" href="http://www.xyb2b.com/Home/Products/detail/gid/93" target="_blank">
  </map>
  <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_18.jpg" width="1213" height="1757" usemap="#Map6">
  <map name="Map6">
    <area shape="rect" coords="64,262,364,669" href="http://www.xyb2b.com/Home/Products/detail/gid/881" target="_blank">
    <area shape="rect" coords="500,264,749,664" href="http://www.xyb2b.com/Home/Products/detail/gid/878" target="_blank">
    <area shape="rect" coords="898,267,1152,665" href="http://www.xyb2b.com/Home/Products/detail/gid/1963" target="_blank">
    <area shape="rect" coords="50,752,241,1142" href="http://www.xyb2b.com/Home/Products/detail/gid/853" target="_blank">
    <area shape="rect" coords="362,754,537,1146" href="http://www.xyb2b.com/Home/Products/detail/gid/1965" target="_blank">
    <area shape="rect" coords="625,750,902,1137" href="http://www.xyb2b.com/Home/Products/detail/gid/860" target="_blank">
    <area shape="rect" coords="957,744,1209,1139" href="http://www.xyb2b.com/Home/Products/detail/gid/861" target="_blank">
    <area shape="rect" coords="122,1225,349,1612" href="http://www.xyb2b.com/Home/Products/detail/gid/854" target="_blank">
    <area shape="rect" coords="500,1216,750,1611" href="http://www.xyb2b.com/Home/Products/detail/gid/1583" target="_blank">
    <area shape="rect" coords="880,1209,1148,1613" href="http://www.xyb2b.com/Home/Products/detail/gid/886" target="_blank">
  </map>
</div>
  <div class="japtitle03"></div>
  <div class="japcon" style="padding:60px 0;">
  <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_23.jpg" width="1213" height="912" usemap="#Map7">
  <map name="Map7">
    <area shape="rect" coords="39,103,267,421" href="http://www.xyb2b.com/Home/Products/detail/gid/2095" target="_blank">
    <area shape="rect" coords="366,136,567,419" href="http://www.xyb2b.com/Home/Products/detail/gid/1072" target="_blank">
    <area shape="rect" coords="696,101,880,434" href="http://www.xyb2b.com/Home/Products/detail/gid/1843" target="_blank">
    <area shape="rect" coords="996,110,1210,434" href="http://www.xyb2b.com/Home/Products/detail/gid/540" target="_blank">
    <area shape="rect" coords="28,502,284,819" href="http://www.xyb2b.com/Home/Products/detail/gid/2097" target="_blank">
    <area shape="rect" coords="324,497,627,827" href="http://www.xyb2b.com/Home/Products/detail/gid/2096" target="_blank">
    <area shape="rect" coords="681,507,881,820" href="http://www.xyb2b.com/Home/Products/detail/gid/2083" target="_blank">
    <area shape="rect" coords="973,519,1206,822" href="http://www.xyb2b.com/Home/Products/detail/gid/2080" target="_blank">
  </map> 
  <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_24.jpg" width="1213" height="1061" usemap="#Map8">
  <map name="Map8">
    <area shape="rect" coords="59,104,260,477" href="http://www.xyb2b.com/Home/Products/detail/gid/1444" target="_blank">
    <area shape="rect" coords="337,120,616,472" href="http://www.xyb2b.com/Home/Products/detail/gid/1447" target="_blank">
    <area shape="rect" coords="660,122,898,462" href="http://www.xyb2b.com/Home/Products/detail/gid/1056" target="_blank">
    <area shape="rect" coords="967,113,1207,463" href="http://www.xyb2b.com/Home/Products/detail/gid/1052" target="_blank">
    <area shape="rect" coords="47,652,283,1031" href="http://www.xyb2b.com/Home/Products/detail/gid/1068" target="_blank">
    <area shape="rect" coords="311,658,552,1019" href="http://www.xyb2b.com/Home/Products/detail/gid/2082" target="_blank">
    <area shape="rect" coords="594,670,870,1020" href="http://www.xyb2b.com/Home/Products/detail/gid/2090" target="_blank">
    <area shape="rect" coords="935,670,1210,1021" href="http://www.xyb2b.com/Home/Products/detail/gid/2084" target="_blank">
  </map>
  <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_25.jpg" width="1213" height="1023" usemap="#Map9">
  <map name="Map9">
    <area shape="rect" coords="33,187,292,541" href="http://www.xyb2b.com/Home/Products/detail/gid/973" target="_blank">
    <area shape="rect" coords="376,178,586,549" href="http://www.xyb2b.com/Home/Products/detail/gid/1167" target="_blank">
    <area shape="rect" coords="649,160,920,533" href="http://www.xyb2b.com/Home/Products/detail/gid/523" target="_blank">
    <area shape="rect" coords="957,161,1206,534" href="http://www.xyb2b.com/Home/Products/detail/gid/527" target="_blank">
    <area shape="rect" coords="21,607,311,937" href="http://www.xyb2b.com/Home/Products/detail/gid/1844" target="_blank">
    <area shape="rect" coords="364,618,570,940" href="http://www.xyb2b.com/Home/Products/detail/gid/532" target="_blank">
    <area shape="rect" coords="659,608,891,943" href="http://www.xyb2b.com/Home/Products/detail/gid/2088" target="_blank">
    <area shape="rect" coords="957,606,1200,937" href="http://www.xyb2b.com/Home/Products/detail/gid/1063" target="_blank">
  </map>
  <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/jap-korea/jap_26.jpg" width="1213" height="1310" usemap="#Map10">
  <map name="Map10">
    <area shape="rect" coords="95,156,332,485" href="http://www.xyb2b.com/Home/Products/detail/gid/1313"  target="_blank">
    <area shape="rect" coords="496,128,723,491" href="http://www.xyb2b.com/Home/Products/detail/gid/1314" target="_blank">
    <area shape="rect" coords="917,121,1128,484" href="http://www.xyb2b.com/Home/Products/detail/gid/1030" target="_blank">
    <area shape="rect" coords="128,550,295,899" href="http://www.xyb2b.com/Home/Products/detail/gid/1057" target="_blank">
    <area shape="rect" coords="503,547,741,898" href="http://www.xyb2b.com/Home/Products/detail/gid/1058"  target="_blank">
    <area shape="rect" coords="925,550,1113,900" href="http://www.xyb2b.com/Home/Products/detail/gid/1047" target="_blank">
    <area shape="rect" coords="114,946,298,1312" href="http://www.xyb2b.com/Home/Products/detail/gid/970" target="_blank">
    <area shape="rect" coords="497,954,725,1307" href="http://www.xyb2b.com/Home/Products/detail/gid/972" target="_blank">
    <area shape="rect" coords="898,940,1152,1292" href="http://www.xyb2b.com/Home/Products/detail/gid/1374" target="_blank">
  </map>
  </div>
</div>

<div class="qualitybox02" style=" min-width:1213px;">
    <ul class="warp clearfix">
        <li>100%正品保证</li>
        <li class="icon02">贴心极速物流</li>
        <li class="icon03">订单闪电发货</li>
        <li class="icon04">品牌防伪码</li>
    </ul>
</div>

<!--底部 -->
<div class="footer clearfix">
    <div class="warp clearfix">
        <div class="left">
            <?php $artcat = array ( ); if(is_array($artcat)): $keys = 0; $__LIST__ = $artcat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$arts): $mod = ($keys % 2 );++$keys;?><div class="ctl">
                        <ul class="top">
                            <li><?php echo ($arts["cat_name"]); ?></li>
                        </ul>
                        <ul>
                            <li>
                                <?php if(is_array($arts["list"])): $k = 0; $__LIST__ = $arts["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$artinfo): $mod = ($k % 2 );++$k; if($artinfo['a_link']): ?><a href="<?php echo ($artinfo['a_link']); ?>"><?php echo ($artinfo["a_title"]); ?></a><?php else: ?>
                                    <a href="<?php echo U('/Home/Index/article_show?aid='.$artinfo['a_id']);?>"><?php echo ($artinfo["a_title"]); ?></a><br><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </li>
                        </ul>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

        <div class="right">
<p><img src="__PUBLIC__/Tpl/v78/chocolate/images/down_appnew.png"> </p>
        </div>

    </div>
    <!-- <div class="iconbox"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/cx1.png" width="100" height="30"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/cx2.png"
            width="100" height="30"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/cx3.jpg" width="100" height="30"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/cx4.png"
            width="100" height="30"></div> -->
    <div class="copyright">
        版权所有 深圳市天行云供应链有限公司 粤ICP备15060915号-1 行云全球汇<br> Copyright © 2015 - 2020. xyb2b.com. All Rights Reserved.
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