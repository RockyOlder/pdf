<?php if (!defined('THINK_PATH')) exit();?>    
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style type="text/css">
html,body,div,ul,li,p,span,a,input,strong,textarea,h1,h2,h3,h4,h5,h6,dl,dt,dd,ol,pre,form,fieldset,blockquote{margin:0;padding:0;}
img{border:0 none;}
em,i{font-style:normal;}
ul,li,ol{list-style-type:none;}
input{outline:none;}
input::-ms-clear,input::-ms-reveal{display:none;}
input[type="submit"],input[type="button"]{star:expression(this.onFocus=this.blur());}
a,a:link,a:visited{text-decoration:none;outline:none;star:expression(this.onFocus=this.blur());}
a:hover{text-decoration:none;}
body{font:14px/1.4 '5FAE8F6F96C59ED1',Tahoma,Arial,'5B8B4F53',sans-serif;}
.weixin_login{text-align:center;}
.login{display:inline-block;*display:inline;*zoom:1;padding:20px;background-color:#fff;}
.login .weixin_code,.login .gh,.login .txt{display:inline-block;*display:inline;*zoom:1;vertical-align:middle;}
.login h3{color:#67b85b;font-weight:600;font-size:16px;}
.login p{color:#666;line-height:1.6;margin-top:10px;}
.login .gh{font-family:"宋体";font-size:30px;color:#ddd;padding:0 30px;}
.weixin_code img{width:140px;height:140px;display:block;}
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