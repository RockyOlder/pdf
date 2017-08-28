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
        <div class="popup pay-success">
            <div class="popup-con">
                <div class="pay-top">
                    <i class="icon icon-success"></i><p>您已成功支付<span class="pay"><?php echo ($arr_order["o_all_price"]); ?></span>元	</p>
                </div>
<!--                <div class="txt-onlytime"></div>-->
                <div class="pay-on">
                    <a href="<?php echo U('Home/Products/ClientapiConversionFeeDetail');?>" class="btn links-on buy-continue">继续购买</a>
                    <a href="javascript:void(0);" class="btn links-off close">关闭</a>
                </div>
<!--                 <p class="color_ff6633 txt">将软件推荐给自己的小伙伴，获取免费的转换次数</p>
                <div class="share-box">
                        <div class="share"><a href=""><i class="icon icon-share"></i><span>立即分享</span></a></div>
                </div> -->
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
                    var ret = cpp_object.NoticeAuth();
                    clearInterval(timer);
                }
                if (i++ > 10)
                    clearInterval(timer);
            }, 500);

            $(".close").click(function () {
                if (cpp_object != null)
                    cpp_object.CloseMessageBox();
            });
        </script>
    </body>
</html>