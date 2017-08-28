<?php if (!defined('THINK_PATH')) exit();?>   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head lang="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8" />
        <title>悦书PDF阅读器授权购买 - 悦书PDF阅读器</title>
        <!--        <base href='http://manage.com/' />-->
        <script src="__JS__jquery.min.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body >
        <script type="text/javascript">
            var cpp_object;
            function SaveCppObject(obj) {
                cpp_object = obj;
            }
            var i = 0;
            var timer = setInterval(function () {
                if (cpp_object != null) {
                    var ret = cpp_object.WXLoginMsg('<?php echo ($ary_member["m_name"]); ?>', '<?php echo ($ary_member["open_id"]); ?>', '<?php echo ($ary_member["token"]); ?>');
                    clearInterval(timer);
                }
                if (i++ > 10)
                    clearInterval(timer);
            }, 500);

        </script>
    </body>
</html>