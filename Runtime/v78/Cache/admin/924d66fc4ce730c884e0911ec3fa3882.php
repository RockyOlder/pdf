<?php if (!defined('THINK_PATH')) exit();?>
<tr style='border:1px solid gray;text-align:center;' class='searchGoods'>
    <td style='border:1px solid gray;'><?php echo ($data["g_name"]); ?></td>
    <td style='border:1px solid gray;' class='pdt_sn_search'><?php echo ($data["pdt_sn"]); ?>
        <input type='hidden' name='pro_g_id' value='<?php echo ($data["g_id"]); ?>'>
        <input type='hidden' name='pro_pdt_sn' value='<?php echo ($data["pdt_sn"]); ?>'>
        <input type='hidden' name='pro_pdt_id' value='<?php echo ($data["pdt_id"]); ?>'>
        <input type='hidden' name='pro_have_sku' value='<?php if($data['products'] == ''): ?>1<?php endif; ?>'>
    <input type='hidden' name='com_id' value="<?php echo ($data["g_id"]); ?>">	        	
</td>
<td style='border:1px solid gray;'>
    <?php echo ($data["g_stock"]); ?>
</td>
<td style='border:1px solid gray;'><?php echo ($data["g_price"]); ?></td>
<!--    <td style='border:1px solid gray;'>
        <input type='text' class='small not_null input_number' value="<?php echo ($data["g_price"]); ?>"  />
    </td>-->
<td style='border:1px solid gray;'><a href='javascript:void(0);' onclick='deleteProduct(this);'>删除</a>
<noempty name="data.products">
    <a href='javascript:void(0);' onclick='hideProduct("<?php echo ($data["g_id"]); ?>");' class="hp<?php echo ($data["g_id"]); ?>">隐藏</a>
    <a href='javascript:void(0);' onclick='showProduct("<?php echo ($data["g_id"]); ?>");' class="sp<?php echo ($data["g_id"]); ?>" style="display:none;">展开</a>
</notempty>
</td>
</tr>
<noempty name="data.products">
    <?php if($data['products'] != ''): ?><tr style="border:1px solid gray;text-align:center;background:#DDDDDD;" class="hideTr<?php echo ($data["g_id"]); ?>">
            <td style="border:1px solid gray;" width="150px;">规格</td>
            <td style="border:1px solid gray;" width="300px;">商品规格</td>
            <td style="border:1px solid gray;" width="150px;">库存数</td>
            <td style="border:1px solid gray;" width="150px;">销售价</td>
            <td style="border:1px solid gray;" ></td>
        </tr><?php endif; ?>
    <?php if(is_array($data["products"])): $i = 0; $__LIST__ = $data["products"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data_info): $mod = ($i % 2 );++$i;?><tr style='border:1px solid gray;text-align:center;background:#DDDDDD;' class='searchGoods hideTr<?php echo ($data["g_id"]); ?>'>
            <td style='border:1px solid gray;'><?php echo ($data_info["specName"]); ?></td>
            <td style='border:1px solid gray;'><?php echo ($data_info["pdt_sn"]); ?>
                <input type='hidden' name='pro_g_id' value='<?php echo ($data_info["g_id"]); ?>'>
                <input type='hidden' name='pro_pdt_sn' value='<?php echo ($data_info["pdt_sn"]); ?>'>
                <input type='hidden' name='pro_pdt_id' value='<?php echo ($data_info["pdt_id"]); ?>'>
            </td>
            </td>
            <td style='border:1px solid gray;'>
                <?php echo ($data_info["pdt_stock"]); ?>
            </td>
            <td style='border:1px solid gray;'><?php echo ($data_info["pdt_sale_price"]); ?></td>
            <td style='border:1px solid gray;' >
                    <a onclick="delGoods($(this));" href="javascript:void(0);">删除</a>
                  <a href="javascript:void(0);" onclick="expansion(<?php echo ($data_info["g_id"]); ?>)">收起</a>
            </td>

        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</noempty>
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