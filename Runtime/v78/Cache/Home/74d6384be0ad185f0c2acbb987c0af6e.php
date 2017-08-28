<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<script src="__JS__jquery.min.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
    *{padding:0;margin:0;list-style-type:none;}
    body{font:14px/1.4 '5FAE8F6F96C59ED1',Tahoma,Arial,'5B8B4F53',sans-serif;overflow:hidden;}
    .login_box{text-align:center;color:#666;}
    .login_box h3{font-size:20px;font-weight:600;padding:20px 0;margin-bottom:30px;border-bottom:1px dashed #ddd;}
    .weixin_code{text-align:center;}
    .login_box h4{color:#09bb07;font-size:18px;font-weight:600;}
    .login_box img{width:150px;height:150px;margin:10px 0;}
</style>
</head>
<body>
<div class="weixin_login">
    <div class="login">
        <div class="weixin_code" id="wx_login"><img src="__IMAGES__2_03.jpg" alt="微信二维码登录" /></div>      
    </div>
</div>
    <script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
    <script>

	var obj = new WxLogin({
	  id:"wx_login", 
	  appid: "<?php echo ($wxid); ?>", 
	  scope: "snsapi_login", 
	  redirect_uri: "<?php echo ($wx_redirect_uri); ?>",
	  state: "<?php echo ($wxrand); ?>",
	  style: "black", //可选值：black,white
	  href: ""
	});
</script>
</body>
</html>