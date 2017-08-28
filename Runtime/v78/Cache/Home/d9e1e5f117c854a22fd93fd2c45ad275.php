<?php if (!defined('THINK_PATH')) exit();?>
<!--shopcartCon 开始-->
  <span class="shoppingcart">购物车（<label><?php echo (($price_data["all_nums"])?($price_data["all_nums"]):'0'); ?></label>）</span>
  <!--shopcartHide 开始-->
  <div class="shopcartHide">
      <ul>
        <?php if(is_array($cart_data)): $i = 0; $__LIST__ = $cart_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i; if($data[0]['pdt_rule_name']=='自由推荐'){ ?>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$da): $mod = ($i % 2 );++$i;?><li>
              <dl>
                  <dt><a href="/Home/Products/detail/gid/<?php echo ($da["g_id"]); ?>"><img src="<?php echo (C("DOMAIN_HOST")); echo ($da['g_picture']); ?>" width="50" height="50" /></a></dt>
                  <dd>
                      <a href="/Home/Products/detail/gid/<?php echo ($da["g_id"]); ?>" class="proN"><?php echo ($da["g_name"]); ?>|<?php echo ($da["g_sn"]); ?> <?php echo ($da["pdt_spec"]); ?></a>
                      <span><i>&yen;</i><label class="price"><?php echo (sprintf('%.2f',$da["f_price"])); ?></label>x<label class="proNum"><?php echo ($da["pdt_nums"]); ?></label></span>
                      <a href="javascript:void(0);"  onclick="deleteFromMyCart('<?php echo ($da["pdtId"]); ?>',<?php echo ($da["type"]); ?>);" class="del">删除</a>
                  </dd>
              </dl>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php }elseif($data[0]['type'] == '6'){ ?>
         <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$da): $mod = ($i % 2 );++$i;?><li>
              <dl>
                  <dt><a href="/Home/Products/detail/gid/<?php echo ($da["g_id"]); ?>"><img src="<?php echo (C("DOMAIN_HOST")); echo ($da['g_picture']); ?>" width="50" height="50" /></a></dt>
                  <dd>
                      <a href="/Home/Products/detail/gid/<?php echo ($da["g_id"]); ?>" class="proN"><?php echo ($da["g_name"]); ?>|<?php echo ($da["g_sn"]); ?> <?php echo ($da["pdt_spec"]); ?></a>
                      <span><i>&yen;</i><label class="price"><?php echo (sprintf('%.2f',$da["f_price"])); ?></label>x<label class="proNum"><?php echo ($da["pdt_nums"]); ?></label></span>
                      <a href="javascript:void(0);"  onclick="deleteFromMyCart('<?php echo ($da["pdtId"]); ?>',<?php echo ($da["type"]); ?>);" class="del">删除</a>
                  </dd>
              </dl>
          	</li><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php }else{ ?>
        <li>
              <dl>
                  <dt><a href="/Home/Products/detail/gid/<?php echo ($data["g_id"]); ?>"><img src="<?php echo (C("DOMAIN_HOST")); echo ($data['g_picture']); ?>" width="50" height="50" /></a></dt>
                  <dd>
                      <a href="/Home/Products/detail/gid/<?php echo ($data["g_id"]); ?>" class="proN"><?php echo ($data["g_name"]); ?>|<?php echo ($data["g_sn"]); ?> <?php echo ($data["pdt_spec"]); ?></a>
                      <span><i>&yen;</i><label class="price"><?php echo (sprintf('%.2f',$data["f_price"])); ?></label>x<label class="proNum"><?php echo ($data["pdt_nums"]); ?></label></span>
                      <a href="javascript:void(0);" onclick="deleteFromMyCart(<?php echo ($data["pdt_id"]); ?>,<?php echo (($data["type"])?($data["type"]):'0'); ?>);"  class="del">删除</a>
                  </dd>
              </dl>
        </li>
        <?php } endforeach; endif; else: echo "" ;endif; ?>
      </ul>
      <p>
          <!-- <a href="#" class="prev"></a><a href="#" class="next"></a> -->
         	 总计：<i class="price">&yen;</i> <strong class="red"><?php echo (($price_data["all_price"])?($price_data["all_price"]):"0.00"); ?></strong>
          <a href="<?php echo U('Ucenter/Cart/pageList');?>" class="showCart">查看购物车</a>
      </p>
</div><!--shopcartHide 结束-->