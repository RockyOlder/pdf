<?php if (!defined('THINK_PATH')) exit();?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head lang="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8" />
        <title>悦书PDF阅读器授权购买 - 悦书PDF阅读器</title>
        <!--        <base href='http://manage.com/' />-->
        <link rel="stylesheet" type="text/css" href="__CSS__clientstyle.css"/>
        <script src="__JS__jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="__JS__main.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <div class="popup weixin">
            <div class="popup-con">
                <h3>应付：<span class="pay"><?php echo ($Weixinprepay["o_all_price"]); ?></span>元</h3>
                <input type="hidden" id="order_no" value="<?php echo ($Weixinprepay["o_id"]); ?>" />
                <input type="hidden" id="client" value="<?php echo ($client); ?>" />
                <input type="hidden" id="token" value="<?php echo ($token); ?>" />
                <div class="weixin-main">
                    <ul>
                        <li class="code">
                            <div class="weixin-main-code">
                                <img alt="微信扫码支付" src="__APP__/Home/User/qrcode?data=<?php echo ($Weixinprepay["code_url"]); ?>" style="width:180px;height:180px;"/>
                            </div>
                            <div class="weixin-main-txt">微信扫码支付</div>
                        </li>
                        <li>
                            <img src="__IMAGES__pic-weixin.jpg" alt="">
                        </li>
                    </ul>
                </div>
                <div class="weixin-main-bottom">
                    <a href="<?php echo U('Home/Products/ClientapiConversionFeeDetail',array('token'=>$token));?>" target="_self" class="btn links-on getback">返回</a>
                    <a href="<?php echo U('Home/Products/canselpay_details',array('token'=>$token,'o_id'=>$Weixinprepay[o_id]));?>" target="_self" class="btn links-off cancel">取消</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                setInterval(function () {
                    if ($("#order_no").val()) {
                        $.ajax({
                            url: "/Ucenter/Orders/getOrderPyOid/?order_no=" + $("#order_no").val() + '&t=' + Math.round(Math.random() * 1000000),
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                if (data.status == 1) {
                                    window.location.href = "/Home/Products/success?order_no="+ $("#order_no").val()+'&token='+$("#token").val()+'&client='+$("#client").val();
                                }
                            }
                        });
                    }
                }, 3000);
            });
        </script>
    </body>
</html>