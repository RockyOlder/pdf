<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>悦书会员促销优惠-悦书PDF在线转换</title>
<meta name="keywords" content="会员,会员充值,PDF充值,悦书PDF,悦书PDF在线转换">
<meta name="description" content="悦书PDF在线转换提供会员购买优惠活动,多买多送,最高可送6个月会员">
<link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/style.css?v=44b17eedf9"/>
<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/xcConfirm.css?v=e3d3e41d22"/>
<script type="text/javascript"src="/Public/Tpl/v78/<?php echo ($view); ?>/js/jquery-1.4.2.min.js?v=10092eee56" ></script>
<script type="text/javascript" src="/Public/Tpl/v78/<?php echo ($view); ?>/js/require.js?v=eb0ef9ae5e" data-main="/Public/Tpl/v78/<?php echo ($view); ?>/js/common" defer async="true" ></script>
</head>
<body>
    <div class="act_page">
        <div class="header">
            <div class="wrap clearfix">
                <a href="<?php echo U('Home/Index/CoreBusiness');?>" class="brand"><img src="__IMAGES__brand.png"  alt="pdf在线转换器" /></a>                
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
                                                    <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red'  >亲，您的VIP套餐马上要到期了，现在购买套餐尊享<span class="zkou">9</span>折优惠哦~</a></p><?php endif; ?>
                                                <?php if($time_count > 7 and $time_count > 0 and $out_time == 0): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
                                                <?php if($out_time <= 30 and $out_time > 0): ?><i class="icon icon-gift"></i>
                                                    <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red' >亲，您的VIP套餐已经到期了，现在购买套餐尊享<span class="zkou">9.5</span>折优惠哦~</a></p><?php endif; ?>
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

                    <!-- <div class="recharge_box">&nbsp;&nbsp;│&nbsp;&nbsp;<a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="recharge">充值</a></div> -->
                    <input type="hidden" value="<?php echo ($_SESSION['Members']['m_id']); ?>" name ="gy_member_open" id="gy_member_open"/>
                    <input type="hidden" value="<?php echo ($redirect); ?>" name ="redirect" id="redirect"/>
                    <input type="hidden" id="Authorizationtype" value="<?php echo ($ary_member["conversion_type"]); ?>" />
                    <input type="hidden" id="Free_authorization" value="<?php echo ($ary_member["Free_authorization"]); ?>" />
                    <input type="hidden" id="ACTIVITY_OPEN" value="<?php echo ($ACTIVITY_OPEN); ?>" />
                    <input type="hidden" id="start_time" value="<?php echo ($start_time); ?>" />
                    <input type="hidden" id="halfMonther" value="<?php echo ($halfMonther); ?>" />
                    <input type="hidden" id="month" value="<?php echo ($month); ?>" />
                    <input type="hidden" id="day" value="<?php echo ($day); ?>" />
                    <input type="hidden" id="ACTIVITPPROJECT_TIME" value="<?php echo ($ACTIVITPPROJECT_TIME); ?>" />
                </div>
                <a href="<?php echo U('Home/Index/CoreBusiness');?>" class="start_change">开始转换</a>
            </div>
       </div>
        <div class="actbanner">
            <img src="__IMAGES__images/actbanner.jpg" alt="悦书年中促销" />
            <div class="actDate"></div>
        </div>
        <div class="act_page_con">
            <div>
                <div class="item">
                <ul class="act_type_box">
                    <li class="onemouth">
                        <img src="__IMAGES__images/s01.jpg" setsrc="__IMAGES__images/ss01.jpg" alt="悦书年中促销-1个月送5次转换" />
                        <div class="txt">
                            <div class="price">&yen;<span>10</span></div>
                            <p class="fisrt_price">原价:19元</p>
                            <div class="btn" data-pay="10" data-details='2' >限时购买</div>
                        </div>
                    </li>
                    <li class="oneyears">
                        <img src="__IMAGES__images/s02.jpg" setsrc="__IMAGES__images/ss02.jpg" alt="悦书年中促销-1年加送3个月" />
                        <div class="txt">
                            <div class="price">&yen;<span>69</span></div>
                            <p class="fisrt_price">原价:99元</p>
                            <div class="btn" data-pay="69" data-details='5'>限时购买</div>
                        </div>                        
                    </li>
                    <li class="twoyears">
                        <img src="__IMAGES__images/s03.jpg" setsrc="__IMAGES__images/ss03.jpg" alt="悦书年中促销-2年加送6个月" />
                        <div class="txt">
                            <div class="price">&yen;<span>99</span></div>
                            <p class="fisrt_price">原价:159元</p>
                            <div class="btn" data-pay="99" data-details='6'>限时购买</div>
                        </div>                        
                    </li>
                </ul>
            </div>

            <div class="item">
                <h3 class="Member_box_t">会员权益</h3>
                <ul class="Member_box">
                    <li>
                        <img src="__IMAGES__images/2_20.jpg" alt="会员权益-高级会员享人工服务" />
                        <h4>高级会员享人工服务</h4>
                        <p>人工转换解决特殊文档</p>
                    </li>
                    <li>
                        <img src="__IMAGES__images/2_22.jpg" alt="会员权益-不限次数转换" />
                        <h4>不限次数转换</h4>
                        <p>高级会员任意转换PDF</p>
                    </li>
                    <li>
                        <img src="__IMAGES__images/2_28.jpg" alt="会员权益-大文档不受限" />
                        <h4>大文档不受限</h4>
                        <p>不受页数限制</p>
                    </li>
                    <li>
                        <img src="__IMAGES__images/2_25.jpg" alt="会员权益-更多特权持续推出中" />
                        <h4>更多特权持续推出中</h4>
                    </li>
                </ul>
            </div>

            <div class="item">
                <h3 class="Member_box_t">活动规则</h3>
                <div class="actinfo">
                    <p>1、活动起止时间为<span class="actDate"></span><span class="date_time"></span>，活动结束后将取消促销优惠</p>
                    <p>2、如对活动存有疑问可咨询客服。QQ：3004137938 &nbsp; &nbsp;电话：0755-86952275</p>
                    <p>3、本活动最终解释权归深圳市常青藤软件科技有限公司所有</p>
                </div>
            </div>
                <input type="hidden" id="o_id" value="" />
        </div>
            
        </div>
    </div>


<div class="popup popup_actpay">
    <div class="content">
        <div class="icon close"></div>
        <div>
            <h3>购买套餐</h3>
            <img class="imgtype" src="__IMAGES__images/s01.jpg" alt="" />
            <div class="pay_method">
                <div class="zfb_pay"><a href="javascript:void(0);" target="_blank">支付宝支付</a></div>
                <div class="weixin_pay">微信支付</div>
            </div>
        </div>
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
               <!--  <div class="promet">您的授权剩余次数<span id="total_number">2</span>次，剩余时间还剩<span id="total_time">12</span>天</div>         -->   
                <div class="bottom">
                    <a href="javascript:;" class="btn btn_contain">关闭</a>
                <!--     <a href="javascript:;" class="btn btn_return">返回</a> -->
                </div>                
            </div>
        </div>
    </div>

    <div class="actlogin_promet">
        <div>
            请先登录再进行充值购买
        </div>        
    </div>

    <!-- 活动过期进入页面提示 -->

    <div class="act_promet">
        <div>
            <i class="icon icon-dhao"></i>
            <p>抱歉，您来晚了，促销活动已经截止，不能享有促销优惠，欢迎关注下次促销活动。</p>
            <a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="getback">知道了</a>
        </div>        
    </div>

<script type="text/javascript"src="/Public/Tpl/v78/<?php echo ($view); ?>/js/jquery-1.4.2.min.js?v=10092eee56" ></script>
    <script type="text/javascript">
            var start_time = document.getElementById("ACTIVITPPROJECT_TIME").value;
            var halfMonther = document.getElementById("halfMonther").value;
            var reg = new RegExp("-", "g");
            var timeStr = halfMonther.replace(reg, "/");
            var nowtimeStr = start_time.replace(reg, "/");
            var timeStr = new Date(timeStr);
            var nowtimeStr = new Date(nowtimeStr);
            $('.actDate').html((nowtimeStr.getMonth()+1)+'月'+nowtimeStr.getDate()+'日-'+(timeStr.getMonth()+1)+'月'+timeStr.getDate()+"日");
            $('.date_time').html(timeStr.getHours()+":"+timeStr.getMinutes());
    </script>
</body>
</html>