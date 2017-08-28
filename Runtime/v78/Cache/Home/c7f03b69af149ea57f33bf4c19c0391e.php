<?php if (!defined('THINK_PATH')) exit();?>
<?php if(count($ary_relate_goods) != 0): ?><div class="freeCombination"><!--关联商品   开始-->
    <div class="tabAbp_coll"><!--tabAbp_coll  start-->
        <p><span class="onHover">相关商品</span><a href="javascript:void(0);"  onclick="checkTebRelate(this,'next')" nowPage="1" class="xnext pageRelateGood">下一页</a><a href="javascript:void(0);" onclick="checkTebRelate(this,'prev')" nowPage="1" class="spre pageRelateGood">上一页</a></p>
    </div><!--tabAbp_coll  end-->
    
    <div class="freeComCon"><!--freeComCon  start-->
        <ul class="xggoods">
       		<?php if(is_array($ary_relate_goods)): $i = 0; $__LIST__ = $ary_relate_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$this_coll): $mod = ($i % 2 );++$i; switch($key): case "0": case "1": case "2": case "3": case "4": ?><li class="onHoverCollGoods foreachRelateGoods" fuck="1">
	                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["g_id"]); ?>" class="proPic"><img src="<?php echo ($this_coll['g_picture']); ?>" width="110" height="110"></a>
	                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["g_id"]); ?>" class="proN"><?php echo ($this_coll["g_name"]); ?></a>
	                <p><strong id="collPrice_<?php echo ($this_coll["g_id"]); ?>">&yen;<?php echo (sprintf('%.2f',$this_coll["g_price"])); ?></strong></p>
            </li><?php break;?>
            <?php case "5": case "6": case "7": case "8": case "9": ?><li  class="onHoverCollGoods foreachRelateGoods" fuck="2" style="display:none">
	                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["g_id"]); ?>" class="proPic"><img src="<?php echo ($this_coll['g_picture']); ?>" width="110" height="110"></a>
	                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["g_id"]); ?>" class="proN"><?php echo ($this_coll["g_name"]); ?></a>
	                <p><strong id="collPrice_<?php echo ($this_coll["g_id"]); ?>">&yen;<?php echo (sprintf('%.2f',$this_coll["g_price"])); ?></strong></p>
            </li><?php break;?>
            <?php case "10": case "11": case "12": case "13": case "14": ?><li  class="onHoverCollGoods foreachRelateGoods" fuck="3" style="display:none">
	                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["g_id"]); ?>" class="proPic"><img src="<?php echo ($this_coll['g_picture']); ?>" width="110" height="110"></a>
	                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["g_id"]); ?>" class="proN"><?php echo ($this_coll["g_name"]); ?></a>
	                <p><strong id="collPrice_<?php echo ($this_coll["g_id"]); ?>">&yen;<?php echo (sprintf('%.2f',$this_coll["g_price"])); ?></strong></p>
            </li><?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div><!--freeComCon  end-->
</div><!--关联商品   结束--><?php endif; ?>
<script>
var count_teb = "<?php echo count($ary_relate_goods); ?>";
var min_orders = parseInt(Math.ceil(count_teb/4));
function checkTebRelate(obj,tab){
    $(".foreachRelateGoods").hide();
    var nowPage = parseInt($(obj).attr('nowPage'));

    if(tab == 'next' && nowPage != min_orders){
        nowPage = parseInt(nowPage+1);
    }else if(tab == 'next' && nowPage == min_orders){
        nowPage=1;
    }
    if(tab == 'prev' && nowPage == min_orders && nowPage!=1){
        nowPage = parseInt(nowPage-1);
    }else if(tab == 'prev' && nowPage<min_orders && nowPage!=1){
         nowPage = parseInt(nowPage-1);
    }else if(tab == 'prev' && nowPage==1){
        nowPage = min_orders;
    }
    $(".foreachRelateGoods[fuck='"+nowPage+"']").slideDown();
    $(".pageRelateGood").each(function(){
        $(this).attr('nowPage',nowPage);
    
    });
    
}

</script>
</if>