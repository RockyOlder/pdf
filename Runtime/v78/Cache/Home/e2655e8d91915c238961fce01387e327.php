<?php if (!defined('THINK_PATH')) exit();?>   
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($page_title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="keywords" content="<?php echo ($page_keywords); ?>">
        <meta name="description" content="<?php echo ($page_description); ?>">
        <link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
        <script type="text/javascript" src="/Public/Tpl/v78/<?php echo ($view); ?>/js/jquery-1.8.3.js" ></script>
        <script type="text/javascript" src="/Public/Tpl/v78/<?php echo ($view); ?>/js/xcConfirm.js" ></script>
        <script type="text/javascript" src="/Public/Tpl/v78/<?php echo ($view); ?>/js/Clientapimain.js" ></script>
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/webuploader.css">
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/apistyle.css">
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/loaders.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/xcConfirm.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/jquery.fileupload.css"/>
    </head>
    <body id="goTop"  >
        <div class="main">
            <div class="wrap">

                <div class="main_main">                
                    <div class="package_box">
                        <h3>悦书客户端用户仅可免费转换5页，若超过5页请购买授权</h3> 
                        <div class="actTxt"><span class="actDate"></span>，买一个月送5次转换，买 一年送3个月，买两年送6个月！</div>                                          
                        <div class="package">
                            <div class="content">
                                <div class="section section_one">
                                    <div class="left">次数套餐:</div>
                                    <div class="right">
                                        <div class="item num_input" data-now="<?php echo ($page_detail["ary_goods_number_pdt"]["pdt_sale_price"]); ?>" data-details='1'  data-pdt_sn='<?php echo ($page_detail["ary_goods_number_pdt"]["pdt_sn"]); ?>' data-pdt_id='<?php echo ($page_detail["ary_goods_number_pdt"]["pdt_id"]); ?>' id="times">
                                            <div class="species"><?php echo ($page_detail["ary_goods_number_pdt"]["specName"]); ?></div>
                                            <div class="species_price">&yen;<span>2</span></div>
                                            <i class="icon icon_current"></i>
                                        </div>
                                        <div class="item num_input" name="num_input" >
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
                                        <?php if(is_array($page_detail["json_goods_pdts"])): $k = 0; $__LIST__ = $page_detail["json_goods_pdts"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_spec): $mod = ($k % 2 );++$k; if($goods_spec['pdt_g_remark'] != ''): if($goods_spec['pdt_min_num'] == 1 ): ?><div class="item current" name="tc_default" data-now="<?php echo ($goods_spec["pdt_sale_price"]); ?>" data-details='2'  data-pdt_sn='<?php echo ($goods_spec["pdt_sn"]); ?>' data-pdt_id='<?php echo ($goods_spec["pdt_id"]); ?>' data-first="<?php echo ($goods_spec["pdt_set_sale_price"]); ?>">
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
                                            <div class="pay" id="pay"><span class="pay_money">10元</span><span class="first_price">原价20元</span><span class="save_money">省10元</span></div>                                                                         
                                        </div>
                                    </div>
                                    <div class="discount">
                                        <div class="left">优惠折扣:</div>
                                        <div class="right"><strong></strong>老用户专享！</div>
                                    </div>
                                    <div class="last_pay">
                                        <div class="left">应付金额:</div>
                                        <div class="right">
                                            <div class="pay"><span class="pay_money">10</span>元</div> 
                                            <div class="pay_method">
                                                <div class="zfb_pay"><button type="button" onclick="OrderPayClient('ALIPAY')" >支付宝支付</button></div>
                                                <div class="weixin_pay"><button type="button" onclick="OrderPayClient('WEIXIN')" >微信支付</button></div>
                                            </div>                                   
                                        </div>
                                    </div>                                    
                                </div>                               
                            </div>
                        </div>
                    </div>               
                </div>
                <form id="submitSkipFrom" name="submitSkipFrom" method="post" action="/Ucenter/Financial/ClientapiALIPAYPayOnline">
                    <input type="hidden" name="type" value="item" id="item_type" />
                    <input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_id"]); ?>" name="pdt_id" id="pdt_id" />
                    <input type="hidden" value="2" name="details" id="details" />
                    <input type="hidden" value="5" name="pdt_stock" id="pdt_stock" />
                    <input type="hidden" value="clien" name="clien" id="clien" />
                    <input type="hidden" value="ALIPAY" name="pc_abbreviation" id="pc_abbreviation" />
                    <input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_sn"]); ?>" name="pdt_sn" id="pdt_sn" />
                    <input type="hidden" value="" name="o_id" id="o_id" />
                    <input type="hidden" value="<?php echo ($ary_member["end_time_count"]); ?>" name="end_time" id="end_time" />
                    <input type="hidden" value="<?php echo ($ary_member["end_time_count_out"]); ?>" name="end_time_count_out" id="end_time_count_out" />
                    <input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_sale_price"]); ?>" name="pdt_sale_price" id="pdt_sale_price" />
                    <input type="hidden" value="<?php echo ($token); ?>" name="token" id="token" />
                    <input type="hidden" value="<?php echo ($PaymentSerialCount); ?>" name="PaymentSerialCount" id="PaymentSerialCount" />
                    <input type="hidden" value="<?php echo ($union); ?>" name="union" id="union" />
                    <input type="hidden" value="<?php echo ($ary_get); ?>" name="client" id="client" />
                    <input type="hidden" id="ACTIVITY_OPEN" value="<?php echo ($ACTIVITY_OPEN); ?>" />
                    <input type="hidden" id="ACTIVITPPROJECT_TIME" value="<?php echo ($ACTIVITPPROJECT_TIME); ?>" />
                    <input type="hidden" id="halfMonther" value="<?php echo ($halfMonther); ?>" />
                    <input type="hidden" id="get_data" value="<?php echo ($get_data); ?>" />
                </form>
            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" class="customer_service"><img src="__IMAGES__callme.png" alt="" /></a>
            <?php if($ary_get == 'free'): ?><div class="txt-limit" id="closeBtn">只转5页</div><?php endif; ?>
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
                        <div>应付金额：<div class="pay" >&yen;<span class="pay_money" id="pay_order_price"></span><span class="first_price">原价&yen;<i id="zfb_sale_price"></i></span><span class="save_money">省<i id="preferential_price"></i>元</span></div></div>
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
<!-- 按照次数支付三次后提示包月更优惠 -->
        <div class="popup popup_exceed">
            <div class="content">
                <div class="icon close"></div>
                <p>亲，您本月已有三次付费转换记录<br>
                    悦书为您推荐<strong>包月套餐</strong><br>
                    性价比更高，更适合你哦~</p>
                <div class="bottom">
                    <div class="btn btn_contain_pay" id="ContinueNumber">继续次数</div>
                    <div class="btn btn_contain_pay" id="TryMonthly">试试包月</div>
                </div>
            </div>
        </div>
                <script type="text/javascript">
            var cpp_object;
            function SaveCppObject(obj) {
                cpp_object = obj;
            }
            var i = 0;
            var timer = setInterval(function () {
                if (cpp_object != null) {
                   // var ret = cpp_object.PayFinish();
                    clearInterval(timer);
                }
                if (i++ > 10)
                    clearInterval(timer);
            }, 500);

            $("#closeBtn").click(function () {
                if (cpp_object != null)
                    cpp_object.CloseMessageBox('ONLY5');
            });

            $('.close').click(function(){
                $(this).parents('.popup').hide().find('.content').hide();
            })


            // $('.pay_method>div>div').click(function(event){
            //     alert('000000');
            // });
        </script>
    </body>
</html>