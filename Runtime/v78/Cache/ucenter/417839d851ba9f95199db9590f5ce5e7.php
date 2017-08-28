<?php if (!defined('THINK_PATH')) exit();?>       
<?php if($getSysconfigActivity == 1): ?><input type="hidden" id="getSysconfigActivity" value="2" />
    <?php else: ?>
        <div id="weixin_ifram">
                        <h3>微信扫一扫完成支付</h3>
                        <img alt="微信扫码支付" src="__APP__/Home/User/qrcode?data=<?php echo ($Weixinprepay["code_url"]); ?>" style="width:180px;height:180px;"/>
                        <div class="weixin_pay">应付金额：<span>&yen;<span id="priceSpanWeixin"><?php echo ($Weixinprepay["o_all_price"]); ?></span></span></div>
                          <input type="hidden" value="<?php echo ($Weixinprepay["o_id"]); ?>" name="order_no" id="order_no" />
        </div><?php endif; ?>