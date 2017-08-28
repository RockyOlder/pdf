<?php if (!defined('THINK_PATH')) exit();?>
<?php if(is_array($cart_data)): $i = 0; $__LIST__ = $cart_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i; if($data[0]['pdt_rule_name']=='自由推荐'){ ?>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$da): $mod = ($i % 2 );++$i;?><dl>
            <dd>
                <a href='<?php echo U("/Home/Products/detail/","gid=$da[g_id]");?>' class="proPic"><img src="<?php echo (C("DOMAIN_HOST")); echo ($da['g_picture']); ?>" width="60" height="60"></a>
                <a href='<?php echo U("/Home/Products/detail/","gid=$da[g_id]");?>' class="proN"><?php echo ($da["g_name"]); ?>&nbsp;&nbsp;</a><br>
                <a href='<?php echo U("/Home/Products/detail/","gid=$da[g_id]");?>' class="proSpec"><?php echo ($da["pdt_spec"]); ?></a>

                <span>¥ <?php echo (sprintf('%.2f',$da["f_price"])); ?></span><code>×</code><span><?php echo ($da["pdt_nums"]); ?></span>
                <a href="javascript:void(0);" onclick="deleteFromMyCart('<?php echo ($da["pdtId"]); ?>',<?php echo ($da["type"]); ?>);"  class="cancel"></a>
            </dd>
        </dl><?php endforeach; endif; else: echo "" ;endif; ?>
    <?php }elseif($data[0]['type'] == '6'){ ?>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$da): $mod = ($i % 2 );++$i;?><dl>
            <dd>
                <a href='<?php echo U("/Home/Products/detail/","gid=$da[g_id]");?>' class="proPic"><img src="<?php echo (C("DOMAIN_HOST")); echo ($da['g_picture']); ?>" width="60" height="60"></a>
                <a href='<?php echo U("/Home/Products/detail/","gid=$da[g_id]");?>' class="proN"><?php echo ($da["g_name"]); ?>&nbsp;&nbsp;</a><br>
                <a href='<?php echo U("/Home/Products/detail/","gid=$da[g_id]");?>' class="proSpec"><?php echo ($da["pdt_spec"]); ?></a>

                <span>¥ <?php echo (sprintf('%.2f',$da["f_price"])); ?></span><code>×</code><span><?php echo ($da["pdt_nums"]); ?></span>
                <a href="javascript:void(0);" onclick="deleteFromMyCart('<?php echo ($da["pdtId"]); ?>',<?php echo ($da["type"]); ?>);"  class="cancel"></a>
            </dd>
        </dl><?php endforeach; endif; else: echo "" ;endif; ?>
    <?php }else{ ?>
    <dl>
        <dd>
            <a href='<?php echo U("Home/Products/detail/","gid=$data[g_id]");?>' class="proPic"><img src="<?php echo (C("DOMAIN_HOST")); echo ($data['g_picture']); ?>" width="60" height="60"></a>
            <a href='<?php echo U("Home/Products/detail/","gid=$data[g_id]");?>' class="proN"><?php echo ($data["g_name"]); ?>&nbsp;&nbsp;</a><br>
            <a href='<?php echo U("Home/Products/detail/","gid=$data[g_id]");?>' class="proSpec"><?php echo ($data["pdt_spec"]); ?></a>

            <span>¥ <?php echo (sprintf('%.2f',$data["f_price"])); ?></span><code>×</code><span><?php echo ($data["pdt_nums"]); ?></span>
            <a href="javascript:void(0);" onclick="deleteFromMyCart(<?php echo ($data["pdt_id"]); ?>,<?php echo (($data["type"])?($data["type"]):'0'); ?>);"  class="cancel"></a>
        </dd>
    </dl>
    <?php } endforeach; endif; else: echo "" ;endif; ?>
<P>
    <?php if(!empty($cart_data)): ?><span>共 <label><?php echo (($price_data["all_nums"])?($price_data["all_nums"]):'0'); ?></label> 件商品  总计：<label>¥</label> <code><?php echo (($price_data["all_price"])?($price_data["all_price"]):"0.00"); ?></code></span><?php endif; ?>
    <?php if(empty($cart_data)): ?><span>您的购物车还没有任何宝贝。</span><?php endif; ?>
    <a href="<?php echo U('Ucenter/Cart/pageList');?>">查看我的购物车</a>
</P>