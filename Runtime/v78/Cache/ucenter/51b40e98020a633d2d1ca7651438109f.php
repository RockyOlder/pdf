<?php if (!defined('THINK_PATH')) exit();?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head lang="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8" />
        <title>悦书PDF阅读器授权购买 - 悦书PDF阅读器</title>
<!--        <base href='http://manage.com/' />-->
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/clientstyle.css"/>
        <script src="/Public/Tpl/v78/<?php echo ($view); ?>/js/jquery.js" type="text/javascript" charset="utf-8"></script>
        <script src="/Public/Tpl/v78/<?php echo ($view); ?>/js/scanmain.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <div class="popup weixin">
            <div class="popup-con">
                <div class="weixin-main">
                    <h4 class="zf-title">确认支付</h4>
                    <div class="zf-details">
                        <p><span class="dd-name">订单号：</span><span id="order_no"><?php echo ($arr_order["o_id"]); ?></span></p>
                        <p><span class="dd-name">订单名称：</span><span id="subject">悦书PDF阅读器授权购买</span></p>
                        <p><span class="dd-name">支付金额：</span><span id="total_fee" class="pay"><?php echo ($arr_order["o_all_price"]); ?></span>元</p>
                    </div>
                </div>
                <div class="weixin-main-bottom">
                    <a href="<?php echo U('Ucenter/Financial/doALIPAY',array('code'=>'ALIPAY','o_id'=>$arr_order[o_id],'details'=>$arr_order[details],'m_id'=>$arr_order[m_id]));?>" target="_blank" class="btn links-on getback icon-zfb">去支付宝支付</a>
                    <a href="<?php echo U('Home/Products/canselpay_details',array('token'=>$token,'o_id'=>$arr_order[o_id]));?>" target="_self" class="btn links-off cancel">取消</a>
                </div>
            </div>
        </div>
        <!--支付提示弹出层-->
        <div class="payment-tips">
            <div class="payment-tips-box">
                <div class="top">支付提示<i class="icon icon-close"></i></div>
                <div class="con">
                    <i class="icon icon-tsp"></i>
                    <div class="txt">
                        <p>支付完成前，请不要刷新页面或关闭此支付窗口。</p>
                        <p>支付完成后，请根据您的支付情况点击下面的按钮。</p>
                    </div>
                </div>
                <div class="bottom">
                    <i class="btn btn-end" id="payok" target="_self">支付完成</i>
                    <a class="btn btn-problem" href="http://bbs.cqttech.com/forum.php?mod=viewthread&tid=88" target="_blank">支付出现问题</a>
                </div>
                  <input type="hidden" value="<?php echo ($arr_order["m_id"]); ?>" name="m_id" id="m_id" />
                <input type="hidden" id="client" value="<?php echo ($client); ?>" />
                <input type="hidden" id="token" value="<?php echo ($token); ?>" />
                <input type="hidden" id="s_type" value="<?php echo ($s_type); ?>" />
                <input type="hidden" id="details" value="<?php echo ($arr_order["details"]); ?>" />
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                setInterval(function () {
                    if ($("#order_no").html()) {
                        $.ajax({
                            url: "/Ucenter/Orders/getOrderPyOid/?order_no=" + $("#order_no").html() + '&t=' + Math.round(Math.random() * 1000000),
                            type: "GET",
                            success: function (data) {
                                var lvContent=""; 
                                if (typeof data!="string"){  
                                    lvContent=data.innerText;  
                                }  
                                else{  
                                    lvContent=data;  
                                }  
                                data  = eval('('+lvContent+')');
                                if (data.status == 1) {
                                    ajaxCount({"s_status":4,"s_value":$("#details").val(),"token":$("#token").val(),"s_payment":"ALIPAY","s_type":$("#s_type").val()},'AjaxActiviOrderPay');
                                    window.location.href = "/Home/Products/success?order_no="+ $("#order_no").html()+'&token='+$("#token").val()+'&client='+$("#client").val();
                                }
                            }
                        });
                    }
                }, 3000);
            });
        </script>
    </body>
</html>