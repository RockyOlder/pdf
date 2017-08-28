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
.overdue { }
.overdue .con {width: 531px;position: fixed;top: 50%;left: 50%; z-index: 999;margin: -233px 0 0 -265px; text-align: center;z-index: 999;height: 466px;}
.overdue .bg { background:#000;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=30)";
 filter: progid:DXImageTransform.Microsoft.Alpha(opacity=30);
opacity: 0.3;width: 100%; height: 100%; position: fixed; z-index: 997;left: 0; top: 0; }
.EDMheader{ background: url(__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDMheader.jpg) no-repeat center top; height:842px; min-width:1200px;}
.EDMbg{ background:url(__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDMbg.jpg); padding-bottom:80px; min-width:1200px;}
.EDMbox{}
.EDMbox .title{ text-align:center; padding:65px 0 25px 0;}
.EDMbox ul{ margin-top:10px;}
.EDMbox ul li{ width:293px; height:403px; float:left; background:url(__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_conbg.png) no-repeat; font-family:微软雅黑;margin-left:9px;}
.EDMbox .pic{ height:262px; line-height:262px; text-align:center; }
.EDMbox ul li:first-child{ margin-left:0;}
.EDMbox .text{ height:140px;}
.EDMbox .text h2{ color:#004a9e; text-align:center; padding:10px 15px 0 15px; font-size:18px; line-height:22px; font-weight:normal; height:60px;}
.EDMbox .text h2 a{ color:#004a9e; }
.EDMbox .text .textdown{ padding-top:15px;}
.EDMbox .text .textdown .price{ width:100px; float:left; position:relative;}
.EDMbox .text .textdown .price span{ position:absolute; top:5px; left:18px; color:#004a9e;font-size:14px; }
.EDMbox .text .textdown .price i{position:absolute; color:#fff100; font-size:14px; top:23px; left:18px;}
.EDMbox .text .textdown .price strong{position:absolute;color:#fff100; font-size:40px; font-weight:normal; top:-5px; left:65px;}

.EDMbox .text .textdown .but{ float:right; width:150px; text-align:right; padding-right:15px;}
</style>
<div class="overdue" id="newz">
<div class="con">
<img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/overdue.png" />
</div>
<div class="bg"></div>
</div>
<div class="EDMheader"></div>
<div class="EDMbg">
<div class="EDMbox warp">
<div class="title"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_title01.png" ></div>

<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/348" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_milk01.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/348" target="_blank">荷兰Herobaby美素<br>
婴幼儿奶粉 1段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>91</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/348" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/347" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_milk02.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/347" target="_blank">荷兰Herobaby美素<br>
婴幼儿奶粉 2段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>91</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/347" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/346" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_milk03.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/346" target="_blank">荷兰Herobaby美素<br>

婴幼儿奶粉 3段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>91</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/346" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/345" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_milk04.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/345" target="_blank">荷兰Herobaby美素<br>

婴幼儿奶粉 4段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>84</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/345" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/344" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_milk05.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/344" target="_blank">荷兰Herobaby美素<br>
婴幼儿奶粉 5段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>84</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/344" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/343" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_06.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/343" target="_blank">荷兰Nutrilon牛栏<br>
  婴幼儿奶粉 1段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>151</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/343" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/342" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_08.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/342" target="_blank">荷兰Nutrilon牛栏<br />
婴幼儿奶粉 2段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>151</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/342" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/341" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_03.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/341">荷兰Nutrilon牛栏<br />
婴幼儿奶粉 3段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>131</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/341" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/340" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_14.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/340" target="_blank">荷兰Nutrilon牛栏<br />
婴幼儿奶粉 4段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>118</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/340" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/339" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_16.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/339" target="_blank">荷兰Nutrilon牛栏<br>
  婴幼儿奶粉 5段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>118</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/339" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/332" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_18.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/332" target="_blank">荷兰Nutrilon牛栏<br>
  婴幼儿奶粉 6段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>73</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/332" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>

<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/337" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_25.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/337" target="_blank">德国Aptamil爱他美<br>
  婴幼儿奶粉 1段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>146</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/337" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/336" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_27.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/336" target="_blank">德国Aptamil爱他美<br>
  婴幼儿奶粉 2段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>146</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/336" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/335" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_31.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/335">德国Aptamil爱他美<br>
    婴幼儿奶粉 1+段（麦德龙版）
    <br>
  </a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>

  <strong>101</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/335" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>
<li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1874" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_36.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1874">德国Aptamil爱他美<br>
    婴幼儿奶粉 2+段（麦德龙版）<br>
  </a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>101</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1874" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>

<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/329" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_38.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/329" target="_blank">雀巢Nestle Alfare<br>
  婴儿低敏配方奶粉 400g</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>125</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/329" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
<li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/902" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_40.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/902">德国Hipp喜宝<br>
    益生菌奶粉 1+段  600g<br>
  </a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>114</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/902" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>
<li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/904" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_46.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/904" target="_blank">德国Hipp喜宝<br>
    有机奶粉 pre段</a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>98</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/904" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>

<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1865" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_48.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1865" target="_blank">德国Hipp喜宝<br>
  有机奶粉 1段</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>98</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/905" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/905" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_50.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/905">德国Hipp喜宝<br>
    有机奶粉 2段<br>
  </a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>115</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/338" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>
</ul>
<ul class="clearfix">

<li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/921" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_56.jpg"></a>
    </div>
  <div class="text">
    <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/921">德国Hipp喜宝<br>
      有机奶粉 12+
      <br>
      </a></h2>
    <div class="textdown clearfix">
      <div class="price">
        <span>狂欢价</span>
        <i>RMB￥</i>
        <strong>119</strong>
        </div>
      <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/921" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
      </div>
    </div>
</li>
</ul>
</div>
<!--母婴用品 -->
<div class="EDMbox warp">
<div class="title"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_title02.png" ></div>

<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/285" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_baby001.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/285" target="_blank">挪威Lifeline Care<br>

婴幼儿新生儿宝宝鱼油DHA</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>88</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/285" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/283" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_baby002.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/283" target="_blank">挪威Lifeline care<br>
  女性哺乳期综合营养补充剂</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>246</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/283" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/258" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_66.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/258" target="_blank">Bambix<br>
  大米米粉/米糊4+（原味）</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>35</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/258" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/257" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_68.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/257" target="_blank">Bambix宝宝成长<br>
  营养标准米粉 6+（原味）</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>38</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/257"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/256" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_73.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/256" target="_blank">Bambix<br>
  晚安营养奶糊 6+（苹果口味）</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>37</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/256" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/255" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_75.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/255" target="_blank">Bambix<br>
  宝宝成长米粉 8+（原味）</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>38</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/255" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
</div>
<!--防晒美白 -->
<div class="EDMbox warp">
<div class="title"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_title03.png" ></div>
<ul class="clearfix">
  <li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/388" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_baby02.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/388" target="_blank">Bio-Oil<br>
    百洛油 200ml</a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>117</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/388" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/379" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_baby03.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/379" target="_blank">法国bioderma贝德玛<br>
  水润喷雾 300ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>64</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/379" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/377" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_baby04.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/377" target="_blank">法国bioderma贝德玛<br>
  水润保湿爽肤水 250ml</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>124</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/377" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/421" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_84.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/421" target="_blank">施巴Sebamed<br>
  护肤霜</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>90</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/421" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
  <li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/349" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_89.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/349" target="_blank">法国eau precieuse<br>
    珍贵水</a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>77</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/349" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1179" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_91.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1179" target="_blank">Balea/芭乐雅<br>
  玻尿酸保湿浓缩精华安瓶 7*1ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>60</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1179" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1163" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_93.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1163" target="_blank">CAUDALIE欧缇丽<br>
  大葡萄柔润爽肤水 200ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>121</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1163" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1161" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_95.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1161" target="_blank">CAUDALIE欧缇丽<br>
  葡萄水活性喷雾 200ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>110</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1161" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1550" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_100.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1550" target="_blank">法国bioderma贝德玛<br>
  净妍毛孔修护乳 30ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>140</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1550" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
  <li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/376" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_102.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/376" target="_blank">法国bioderma贝德玛<br>
    舒妍DS舒缓霜/精华 40ml</a></h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>131</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/376" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1578" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_104.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1578" target="_blank">AVENE雅漾<br>
  修护舒缓保湿霜 50ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>120</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1578" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/368" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_106.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/368" target="_blank">JACOB HOOY天然洋甘菊<br>
  温和保湿紧肤日霜 150ml</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>67</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/368" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>

</ul>
<ul class="clearfix">
  <li>
  <div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/366" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_110.jpg"></a>
  </div>
  <div class="text">
  <h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/366" target="_blank">Jacob Hooy<br>
    七香草滋润面霜 250ml</a><br>
  </h2>
  <div class="textdown clearfix">
  <div class="price">
  <span>狂欢价</span>
  <i>RMB￥</i>
  <strong>69</strong>
  </div>
  <div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/366" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
  </div>
  </div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/406" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_112.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/406" target="_blank">Kneipp<br>
  杏仁花泡澡精油
  </a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>85</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/406" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
</div>

<!--防晒美白 -->
<div class="EDMbox warp">
<div class="title"> <img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_title04.png" ></div>

<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1582" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_skin01.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1582" target="_blank">Avene雅漾<br>
  防晒小金刚SPF50 30ml</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>86</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1582" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/951" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/pic_skin04.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/951" target="_blank">Nuxe欧树<br>
  全效晶莹护理精华油50ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>116</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/951" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/385" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_121.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/385" target="_blank">Montagne Jeunesse<br>
死海泥面膜 20g</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>15</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/385" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1591" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_123.jpg"></a>
</div>
<div class="text">
<h2 style="padding:0 5px;"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1591" target="_blank">Montagne Jeunesse<br>
草莓蛋白奶油深层清洁面膜 15ml </a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>15</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1591" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
</ul>
<ul class="clearfix">
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/384" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_127.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/384" target="_blank">Montagne Jeunesse<br>
  MJ黄瓜美白清洁面膜 10ml</a></h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>15</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/384" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/380" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_129.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/380" target="_blank">法国bioderma贝德玛<br>
  美白淡斑晚间精华 30ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>275</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/380" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/369" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_131.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/369" target="_blank">Jacob Hooy<br>
  玫瑰水 500ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>62</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/369" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>
<li>
<div class="pic"> <a href="http://www.xyb2b.com/Home/Products/detail/gid/1213" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_133.jpg"></a>
</div>
<div class="text">
<h2><a href="http://www.xyb2b.com/Home/Products/detail/gid/1213" target="_blank">Nuxe欧树<br>
  玫瑰花凝柔肤水 200ml</a><br>
</h2>
<div class="textdown clearfix">
<div class="price">
<span>狂欢价</span>
<i>RMB￥</i>
<strong>106</strong>
</div>
<div class="but"><a href="http://www.xyb2b.com/Home/Products/detail/gid/1213" target="_blank"><img src="__PUBLIC__/Tpl/v78/chocolate/images/ztimg/Europe/EDM_but.png"></a></div>
</div>
</div>
</li>

</ul>
</div>

</div>

<div class="qualitybox02" style=" min-width:1200px;">
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