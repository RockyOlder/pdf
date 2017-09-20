<?php if (!defined('THINK_PATH')) exit();?>
<td colspan="3">
    <div>
<table width="100%" class="tbNew">
    <tbody>
        <tr class="load">
            <td class="first" style="padding-left:3px;"><span class="red">*</span> 赠送优惠券条件</td>
            <td style='text-align:left;width:630px;'>
                <input type="text" id="cfg_cart_start" name="cfg_cart_start" class="small" validate="{ required:true,number:true,min:1}" value="<?php echo ($config['cfg_cart_start']); ?>" /> - 
                <input type="text" id="cfg_cart_end" name="cfg_cart_end" class="small" value="<?php echo ($config['cfg_cart_end']); ?>" validate="{ required:true,number:true,min:1}" />
            </td>
            <td class="last">
                 购物车金额在此范围内享受优惠，优惠条件为必填项。
                <br>例如：500-2000代表500以上2000以下。
            </td>
        </tr>
        <tr class="load">
            <td class="first">是否不限使用条件</td>
            <td>
                <input type="checkbox" name="cfg_condition" id="cfg_condition" value="all" <?php if($config['cfg_condition'] == all): ?>checked="checked"<?php endif; ?>>
                <span id="cfg_condition_money" <?php if($config['cfg_condition'] == all): ?>style="display:none;"<?php endif; ?> >订单满 
                    <input type="text" class="small" name="cfg_condition_money" value="<?php echo ($config['cfg_condition_money']); ?>" validate="{ number:true}"> 元才可以使用
                </span>
            </td>
            <td class="last">勾选上表示不限定使用条件</td>
        </tr>
        <tr class="load">
            <td class="first" style="padding-left:3px;"><span class="red">*</span>  优惠券面额</td>
            <td style='text-align:left;width:630px;'>
                <input type="text" name="cfg_coupon_money" class="small" validate="{ required:true,min:0,number:true}" value="<?php echo ($config['cfg_coupon_money']); ?>"  />
            </td>
            <td class="last">输入赠送的优惠券的面额</td>
        </tr>
        <tr class="load">
            <td class="first" style="padding-left:3px;"><span class="red">*</span>  优惠券有效天数</td>
            <td style='text-align:left;width:630px;'>
                <input type="text" name="cfg_coupon_date" class="small" validate="{ required:true,min:1,max:365,number:true,digits:true}" value="<?php echo ($config['cfg_coupon_date']); ?>"  />
            </td>
            <td class="last">优惠券的有效期起始时间从下单支付成功时开始计算，此处填写有效期天数，例如10代表有效期为10天</td>
        </tr>
        <tr class="load">
            <td class="first" style="padding-left:3px;">优惠券前缀</td>
            <td style='text-align:left;width:630px;'>
                <input type="text" name="cfg_coupon_prefix" class="small" validate="{ path:true}" value="<?php echo ($config['cfg_coupon_prefix']); ?>"  />
            </td>
            <td class="last">系统自动生成优惠券时的前缀，方便查找统计，可以不填</td>
        </tr>
        <tr class="load">
            <td class="first" style="padding-left:3px;">优惠券后缀</td>
            <td style='text-align:left;width:630px;'>
                <input type="text" name="cfg_coupon_suffix" class="small" validate="{ path:true}" value="<?php echo ($config['cfg_coupon_suffix']); ?>"  />
            </td>
            <td class="last">系统自动生成优惠券时的后缀，方便查找统计，可以不填</td>
        </tr>
        <tr class="load">
            <td class="first" style="padding-left:3px;"><span class="red">*</span>  优惠券SN长度</td>
            <td style='text-align:left;width:630px;'>
                <input type="text" name="cfg_coupon_long" class="small" validate="{ required:true,min:6,number:true,digits:true}" value="<?php echo ($config['cfg_coupon_long']); ?>"  />
            </td>
            <td class="last">系统自动生成优惠券的SN长度，至少6位</td>
        </tr>
        <tr id="group">
            <td class="first"><span class="red">*</span>优惠券使用范围</td>
            <td>
               <table class="tblist">
                    <tbody>
                        <?php if(is_array($gGroup)): $i = 0; $__LIST__ = $gGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 10 );++$i; if(($mod) == "0"): ?><tr><?php endif; ?>
                            <td><input type="checkbox" name="gp_group[]" <?php if(in_array($group['gg_id'],$config['ggp_name'])){ ?>checked="checked"<?php } ?> id="<?php echo ($group["gg_id"]); ?>" validate="{required:true}" value="<?php echo ($group["gg_id"]); ?>"/><span><?php echo ($group["gg_name"]); ?></php></span>  </td>
                        <?php if(($mod) == "4"): ?></tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>  
            </td>
            <td class="last"></td>
        </tr>
    </tbody>
</table>
</div>
</td>
<script type="text/javascript">
$("#cfg_condition").click(function(){
    if($(this).attr('checked')=='checked'){
        $("#cfg_condition_money").fadeOut('fast');
    }else{
        $("#cfg_condition_money").fadeIn('fast');
    }
});
</script>