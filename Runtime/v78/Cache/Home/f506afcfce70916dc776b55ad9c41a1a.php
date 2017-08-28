<?php if (!defined('THINK_PATH')) exit();?>
<html lang="zh-cn">
<head>
	<style>
	 .error{color:red}
	</style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo ($page_title); ?></title>
	<script src="__JS__base.js"></script>
    <link href="__CSS__global.css" type="text/css" rel="stylesheet">
	<script src="__PUBLIC__/Lib/jquery/js/jquery.form.js"></script>
    <script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.validate.1.9.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.metadata.js"></script>
    <script src="__PUBLIC__/Lib/validate/messages_cn.js"></script>
    <script src="__PUBLIC__/Lib/thinkbox/js/jquery.ThinkBox.min.js"></script>
	<link href="__PUBLIC__/Lib/thinkbox/css/style.css" rel="stylesheet">
    <script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script>
</head>
<body class="login-body">
<!-- header -->
<!-- 获取公共信息 -->
<?php $commonInfo = array ( 'GY_IS_FOREIGN' => '1', 'GY_MUST_LOGIN' => NULL, 'GY_SHOP_CODE' => '', 'GY_SHOP_HOST' => 'http://ucenter.wiserar.com/', 'GY_SHOP_ICP' => '', 'GY_SHOP_LOGO' => '', 'GY_SHOP_ONLINE_END' => '18:00', 'GY_SHOP_ONLINE_START' => '9:00', 'GY_SHOP_OPEN' => '1', 'GY_SHOP_QC_LOGO' => '/Public/Uploads/v78/images/20170504141845.png', 'GY_SHOP_SERVER_PHONE' => '', 'GY_SHOP_TITLE' => '分销测试店铺', 'GY_SHOP_TYPE' => '2', ); $cfg = array ( ); $ary_top_ads = array ( ); ?>
<div class="header regist-header">
    <div class="hd-top w1192">
        <div class="ef-title">
            <h1 class="logo">
                <a href="<?php echo U('Home/Index/index');?>" class="no-trans"><img src="<?php echo (C("DOMAIN_HOST")); echo (($commonInfo['GY_SHOP_LOGO'])?($commonInfo['GY_SHOP_LOGO']):'__IMAGES__logo.png'); ?>" width="177" height="50"/></a>
                <!--<span class="CHANNEL_LOGO">
                    <img src="images/go.png" width="116" height="29" alt=""/>
                </span>-->
            </h1>
        </div>
        <div class="regist-bar fr"> 你好，欢迎光临 <em></em>！ 请 <a href="/">登录</a></div>
    </div>
</div>
<div class="w1192 clearfix">
    <?php if($ad_arr['log_pic'] != ''): ?><div class="login-img"><a href="<?php echo ($ad_arr['log_url']); ?>"><img src="<?php echo (C("DOMAIN_HOST")); echo ($ad_arr['log_pic']); ?>" alt="" width="500" height="380"/></a></div><?php endif; ?>
    <div class="login-container">
        <div class="login-hd clearfix">
            <div class="fl login-text"><i></i>用户登录</div>
            <a class="fr" href="<?php echo U('Home/User/pageRegister');?>">注册新帐号</a>
        </div>
        <div class="login-bd">
            <!-- 空心三角箭头 -->
            <span class="login-arrow">
                <b class="login-arr-outer"></b>
                <b class="login-arr-inner"></b>
            </span>
            <form action="<?php echo U('Home/User/doLogin');?>" method="post" class="login-form" id="register_form">
                <label class="form-group compact-group clearfix">
                    <div class="form-lab"><i class="icon-user"></i></div>
                    <div class="form-field">
                        <input tabindex="1" type="text" name="m_name" id="m_name" placeholder="请输入用户名"/>
                    </div>
                </label>
                <label class="form-group compact-group clearfix">
                    <div class="form-lab"><i class="icon-pwd"></i></div>
                    <div class="form-field">
                        <input tabindex="2" type="password" name="m_password" id="m_password" placeholder="请输入密码"/>
                    </div>
                </label>
				<?php if($vef["sc_value"] == 1): ?><label class="form-group compact-group clearfix" style="padding:10px 25px 10px 10px">
                    <div class="form-lab"><i class="icon-yzm"></i></div>
                    <div class="form-field">
                        <input type="text" tabindex="3" class="yzm" name="verify" id="verify" value="" validate="{ required:true}" style="width:70px;height:35px;float:left;padding: 6px 5px 6px 5px;border: 1px solid #ccc;"/>
						<a href="javascript:void(0)" onclick="changeverify()" style="margin-left:10px;padding-right:30px">
							<img id="loginverify" src="__APP__/Home/User/verify/" width="75" height="35" onClick="this.src='__APP__/Home/User/verify/'+Math.random()">换一张
						</a>
                    </div>
					<i style="width:auto;">
						<label class="error" for="verify" generated="true"></label>
					</i>
                </label><?php endif; ?>
                <div class="login-link clearfix">
                    <!--<label class="checkbox"><input type="checkbox" name="autoLogin" checked/>自动登陆</label>-->
                    <a class="fr" href="<?php echo U('Home/User/pageFoget');?>">忘记密码？</a>
                </div>
                <input type="submit" tabindex="4" class="regist-btn" value="登录"/>
                <input name="savelogin" type="hidden" value="0"/>
                <input name="requsetUrl" id="requsetUrl" type="hidden" value="<?php echo ($requset_url); ?>"/>
                <?php if(($sina == '1') or ($qq == '1') or ($renren == '1')): ?><div class="third-platform">
                        <p>第三方账号登陆</p>
                        <?php if($sina == '1'): ?><a href="<?php echo U('Home/User/thdLoginUr/');?>?type=Sina" class="sina" title="新浪微博">新浪微博</a><?php endif; ?>
                        <?php if($qq == '1'): ?><a href="<?php echo U('Home/User/thdLoginUr/');?>?type=QQ" class="qq" title="QQ">QQ</a><?php endif; ?>
                        <?php if($renren == '1'): ?><a href="<?php echo U('Home/User/thdLoginUr/');?>?type=RenRen" class="renren" title="人人网">人人网</a><?php endif; ?>
						<?php if($wx == '1'): ?><div id="wx_login" class="t_center">
							<img src="__IMAGES__ewm_wx.jpg" />
							<span class="f12 gray3" style="margin-top:10px;">使用微信扫描上方二维码登陆</span>
						</div><?php endif; ?>
                    </div><?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
<?php if(($wxloginstatus) == "1"): ?><script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script>
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
<script>
	function redirectUri(obj){
		if(obj == 'fogetpass'){
			window.parent.location.href="<?php echo U('Home/User/pageFoget');?>";
		}else if(obj == 'registpage'){
			$.popup.close();
			$.popup.popwin('/Home/User/ajaxRegPage', { settings: { width: 410, height:710, title: '注册',head:true} });
		}
	}
</script>
<script>
	function changeverify(){      
		$('#loginverify').attr('src','<?php echo U("Home/User/verify");?>'+'?r='+Math.random());     	
	}
	$(document).ready(function(){
		$("#register_form").validate({
			errorPlacement: function(error, element) {
				var error_td = element.parent("label").siblings("i");
				error_td.append(error);
			},
			submitHandler:function(form){
				var rand = '<?php echo (session('rand')); ?>'.toString();
				var m_password = $("#m_password").val().toString();
				var new_password = encode64(m_password+rand);
				$("#m_password").val(new_password);
				var formdata = $("#register_form").serialize();
				var url = $("#requsetUrl").val();
				var isreset = url.indexOf("doReset");
				var mobilereset = url.indexOf("synResetByMobile");
				$.ajax({
					url:"<?php echo U('Home/User/doLogin');?>",
					data:formdata,
					dataType:"json",
					type:"post",
					success:function(msgObj){
						if(msgObj.status == 1){
							if(msgObj.url){
								url = msgObj.url;
							}
							if( isreset !== -1 || mobilereset !== -1){
								$.ThinkBox.success('登录成功,等待跳转……');
								window.location.href = "/Home/Index/index";
							}else{
								$.ThinkBox.success('登录成功,等待跳转……');
								window.location.href = url;
							}
						}else{
						   $.ThinkBox.error(msgObj.info);
						   return false;
						}
					}
				});
			},
			rules : {
				verify : {
					rangelength:[4,4],
					required:true,
					digits:true,
					remote:'/Home/User/checkVerify'
				}
			},
			messages : {
				verify : {
					rangelength:'验证码长度为4',
					required:'请输入验证码',
					digits:'对不起，请输入正确的验证码'
				}
			}
		});
	});
	$("input[tabindex=1]").blur(function(){
		$("#m_name").val(this.value);
	});
</script>
</html>