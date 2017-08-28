<?php if (!defined('THINK_PATH')) exit();?>
<link href="__CSS__homepage-shade.css" rel="stylesheet">
<div id="coupon_toggle" style="display:  none;">
<div class="shade"></div>
<div class="container">
    <div class="content">
        <div class="close-btn"></div>
        <div class="receive-btn">
            <a target=_blank href="<?php echo U(URL_PREFIX . '/Home/ActivityProject/CouponActivityADD');?>/caid/<?php echo ($datalist["ca_id"]); ?>"></a>
             <a target=_blank href="<?php echo U('Home/ActivityProject/CouponActivityADD');?>">
            <a href="receive-coupon.html"></a>
        </div>
    </div>
</div>
</div>
<?php if($coupon_activity == 2): ?><div class="rsidebox_coupon">
      <img src="__PUBLIC__/Lib/images/lihao.gif" width="80" height="65" id="show_coupon" >
  </div><?php endif; ?>
<input type="hidden" name="login_coupon_session" value="<?php echo ($_SESSION['Members']['login_number']); ?>" id="login_coupon_session" />
 <input type="hidden" name="login_coupon_cookie" value="<?php echo (cookie('coupn_set')); ?>" id="login_coupon_cookie" />
<script type="text/javascript">
    $(document).ready(function() {
        
        var login_coupon_session = $("#login_coupon_session").val();
        var login_coupon_cookie = $("#login_coupon_cookie").val();
        if(login_coupon_session == '' &&  login_coupon_cookie < 2 )
        {
            $("#coupon_toggle").show(50)	
        }else if(login_coupon_session < 2 && login_coupon_session !='')
        {
            $("#coupon_toggle").show(50)
        }
        $('.close-btn').on('click', function () {
        //    $('.shade').hide();
        //     $('.container').hide();
            $("#coupon_toggle").hide();
        });
        $(".shade").css({ "width": $(document).width(), "height": $(document).height() });
        $('#show_coupon').bind('click', function() {
             $("#coupon_toggle").show(50)	
        });
   });
    
</script>