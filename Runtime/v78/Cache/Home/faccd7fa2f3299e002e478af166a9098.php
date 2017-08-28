<?php if (!defined('THINK_PATH')) exit();?>
<div class="content content_two">
    <div class="icon close"></div>
    <div class="popup_content" id="wx_login" >
         
        <img src="__IMAGES__ewm_wx.jpg" />
       
    </div>
    <h3>使用微信扫描上方二维码登录</h3>
</div>
<?php if(($wxloginstatus) == "1"): ?><script>

	var obj = new WxLogin({
	  id:"wx_login", 
	  appid: "<?php echo ($wxid); ?>", 
	  scope: "snsapi_login", 
	  redirect_uri: "<?php echo ($wx_redirect_uri); ?>",
	  state: "<?php echo ($wxrand); ?>",
	  style: "white", //可选值：black,white
	  href: ""
	});
</script><?php endif; ?>