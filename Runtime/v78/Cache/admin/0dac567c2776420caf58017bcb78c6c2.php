<?php if (!defined('THINK_PATH')) exit();?>
<tbody >
<?php if(is_array($rGoods)): $i = 0; $__LIST__ = $rGoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr class="selected_goods_tr_<?php echo ($goods["g_id"]); ?>">
        <td style="text-align:center;"><?php echo ($goods["g_name"]); ?></td>
        <td style="text-align:center;"><span class="blue"><?php echo ($goods["g_sn"]); ?></span></td>
        <td style="text-align:center;"><?php echo ($goods["g_price"]); ?></td>
    <?php if($filter["type"] != 'add'): if(($goods_page) == "PYIKOUJIA"): ?><td style="text-align:center;">
                <input type="text" onblur="shortcut(<?php echo ($goods["g_id"]); ?>)" id="shortcut_goods_<?php echo ($goods["g_id"]); ?>" validate="{ number:true}" name="cfg_discounts[<?php echo ($goods["g_id"]); ?>]" value="<?php echo ($goods["g_price_config"]["cfg_products"]); ?>" class="tiny cfg_discounts">
            </td><?php endif; endif; ?>
        
        <td style="text-align:center;">
            <a onclick="delGoods($(this),<?php echo ($goods["g_id"]); ?>);" href="javascript:void(0);">删除</a>
            <a href="javascript:void(0);" onclick="expansion(<?php echo ($goods["g_id"]); ?>);">展开</a>
            <input type="hidden" name="ra_gid[]" value="<?php echo ($goods["g_id"]); ?>">
        </td> 
    </tr>
    <tr class="selected_goods_tr_<?php echo ($goods["g_id"]); ?>" id="selected_goods_products_tr_<?php echo ($goods["g_id"]); ?>" style="display:none; padding-left:30px;">
        <td></td>
        <td colSpan="6">
            <table class="" style="width:100%">
                <thead>
                    <tr class="tbody_products_<?php echo ($goods["g_id"]); ?>">
                        <th style="text-align:center;">商家编码</th>
                        <th style="text-align:center;">规格</th>
                        <th style="text-align:center;">销售价</th>
                        <?php if($filter["type"] != 'add'): if(($goods_page) == "PYIKOUJIA"): ?><th>一口价</th><?php endif; endif; ?>
                        <th style="text-align:center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($goods['products'])): $i = 0; $__LIST__ = $goods['products'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?><tr class="tbody_products_<?php echo ($goods["g_id"]); ?>" style="display:">
                            <td><?php echo ($pro["pdt_sn"]); ?></td>
                            <td><?php echo ($pro["specName"]); ?></td>
                            <td><?php echo ($pro["pdt_sale_price"]); ?></td> 
                        <?php if($filter["type"] != 'add'): if(($goods_page) == "PYIKOUJIA"): ?><td>
                                <input type="text" name="cfg_products[<?php echo ($goods["g_id"]); ?>][<?php echo ($pro["pdt_id"]); ?>]" value="<?php echo ($pro["g_price_config"]["cfg_products"]); ?>" class="tiny cfg_discounts shortcut_pro_<?php echo ($goods["g_id"]); ?>"/> 
                            </td><?php endif; endif; ?>
                            

                            <?php if(($goods_page) != "PYIKOUJIA"): ?><input type="hidden" name="cfg_products[<?php echo ($goods["g_id"]); ?>][<?php echo ($pro["pdt_id"]); ?>]" value="<?php echo ($goods["g_price_config"]["cfg_products"]); ?>" class="tiny cfg_discounts shortcut_pro_<?php echo ($goods["g_id"]); ?>"/><?php endif; ?>
                            <td>
                                <a onclick="delGoods($(this));" href="javascript:void(0);">删除</a>
                                <a href="javascript:void(0);" onclick="expansion(<?php echo ($goods["g_id"]); ?>)">收起</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</tbody>
<script type="text/javascript">
     /*批量删除*/
    function batchDelGoods(){
        $("input[name='ra_gid[]']").each(function(){
            if($(this).prop("checked")== true){
               
                $(this).parent('td').parent('tr').remove();
                $("#selected_goods_products_tr_"+$(this).attr('g_id')).remove();
            }
        })
    }
    /*
     * 展开操作
     */
    function expansion(gid){
        var display_val = $("#selected_goods_products_tr_"+gid).css('display');
        if(display_val == 'none'){
            //$(".tbody_products_"+gid).css({'display':''});
            $("#selected_goods_products_tr_"+gid).show();
        }else {
            $("#selected_goods_products_tr_"+gid).hide();
            //$(".tbody_products_"+gid).css({'display':'none'});
        }
    }
     /*删除商品*/
    function delGoods(obj,gid){
        obj.parent('td').parent('tr').remove();
        $(".tbody_products_"+gid).remove();
        //console.log("selected_goods_products_tr_"+gid);
        $("#selected_goods_products_tr_"+gid).remove();
    }
    function checkAll(){
        if($('.checkAll_tr').attr('checked')=='checked'){
            $('.checkSon_tr').attr('checked','checked');
        }else{
            $('.checkSon_tr').removeAttr('checked');
        }
    }
</script>