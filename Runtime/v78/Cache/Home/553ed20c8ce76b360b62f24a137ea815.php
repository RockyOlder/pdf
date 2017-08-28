<?php if (!defined('THINK_PATH')) exit();?>
您好，
<?php if(empty($_SESSION['Members']['m_name'])): ?><a href="<?php echo U('Home/User/login');?>">[<strong>请登录</strong>]</a><a href="<?php echo U('Home/User/pageRegister');?>">[免费注册]</a><?php endif; ?>
<?php if(!empty($_SESSION['Members']['m_name'])): echo ($_SESSION['Members']['m_name']); ?>&nbsp;&nbsp;&nbsp;
   <a href="<?php echo U('Home/User/doLogout');?>">[<?php echo (L("TOP_LOGOUT")); ?>]</a><?php endif; ?>
<input type="hidden" name="no_login" value="<?php echo ($_SESSION['Members']['m_name']); ?>" id="no_login" />