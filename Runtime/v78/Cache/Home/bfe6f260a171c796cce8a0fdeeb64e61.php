<?php if (!defined('THINK_PATH')) exit();?>
<?php if($this_coll["gname"] != ''): ?><h2><span>套餐搭配</span><a href="javascript:void(0);"  onclick="checkTeb(this,'next')" nowPage="1" class="xnext pageCollGood"></a><a href="javascript:void(0);" onclick="checkTeb(this,'prev')" nowPage="1" class="spre pageCollGood"></a></h2>

<div class="freeCombination"><!--自由组合   开始-->
    <div class="freeComCon"><!--freeComCon  start-->
        <ul>
            <li id="onHoverCollGoods<?php echo ($this_coll["gid"]); ?>" class="onHoverCollGoods">
                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["gid"]); ?>" class="proPic"><img src="<?php echo ($this_coll['gpic']); ?>" width="112" height="112"></a>
                <a href="/Home/Products/detail/gid/<?php echo ($this_coll["gid"]); ?>" class="proN"><?php echo ($this_coll["gname"]); ?></a>
                <p><strong id="collPrice_<?php echo ($this_coll["gid"]); ?>">&yen;<?php echo (sprintf('%.2f',$this_coll["gcoll_price"])); ?></strong></p>
                <input type="hidden" gid="<?php echo ($this_coll["gid"]); ?>" name="arrayPdt" id="coll_products_<?php echo ($this_coll["gid"]); ?>" <?php if($this_coll["skuNames"] != ''): ?>value=""<?php else: ?>value="<?php echo ($this_coll["pdt_id"]); ?>" save="<?php echo (sprintf('%.2f',$this_coll["save_price"])); ?>" price="<?php echo (sprintf('%.2f',$this_coll["gcoll_price"])); ?>"<?php endif; ?> />
                <a href="javascript:void(0);" <?php if($this_coll["skuNames"] != ''): ?>style="display:none"<?php endif; ?> id="saveColl_<?php echo ($this_coll["gid"]); ?>" class="gra onHoverSavePrice">搭配省<?php echo (sprintf('%.2f',$this_coll["save_price"])); ?>元</a>
                <?php if($this_coll["skuNames"] != ''): ?><a href="javascript:void(0);" id="selectColl_<?php echo ($this_coll["gid"]); ?>" class="blu onHoverSelectGoods" onclick="selectGoodProducts('<?php echo ($this_coll["gid"]); ?>','<?php echo ($this_coll["authorize"]); ?>');">选择商品信息</a>
                <p style="display:none" class="onHoverPdtName" id="collPdt_<?php echo ($this_coll["gid"]); ?>">规格规格规格规格</p><?php endif; ?>
            </li>
        </ul>
        <span class="jia"></span>
        <ul style="width:568px">
            <?php if(is_array($coll_goods)): $i = 0; $__LIST__ = $coll_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i; switch($key): case "0": case "1": case "2": ?><li id="onHoverCollGoods<?php echo ($goods["gid"]); ?>" class="onHoverCollGoods foreachCollGoods" fuck="1">
                <a href="/Home/Products/detail/gid/<?php echo ($goods["gid"]); ?>" class="proPic"><img src="<?php echo ($goods['gpic']); ?>" width="110" height="110"></a>
                <a href="/Home/Products/detail/gid/<?php echo ($goods["gid"]); ?>" class="proN"><?php echo ($goods["gname"]); ?></a>
                
                <p><input type="checkbox" value=""  <?php if($goods["skuNames"] != ''): ?>onclick="collGoodsClick(this,'<?php echo ($goods["gid"]); ?>','<?php echo ($goods["authorize"]); ?>');"<?php else: ?>onclick="collProductClick(this,'<?php echo ($goods["gid"]); ?>','<?php echo ($goods["pdt_id"]); ?>','<?php echo ($goods["authorize"]); ?>','<?php echo ($goods["gcoll_price"]); ?>','<?php echo ($goods["save_price"]); ?>');"<?php endif; ?> id="coll_goods_<?php echo ($goods["gid"]); ?>" /> <strong id="collPrice_<?php echo ($goods["gid"]); ?>">&yen;<?php echo (sprintf('%.2f',$goods["gcoll_price"])); ?></strong></p>
                <input type="hidden" gid="<?php echo ($goods["gid"]); ?>" name="arrayPdt" id="coll_products_<?php echo ($goods["gid"]); ?>" value="" <?php if($goods["skuNames"] == ''): ?>save="<?php echo (sprintf('%.2f',$goods["save_price"])); ?>" price="<?php echo (sprintf('%.2f',$goods["gcoll_price"])); ?>"<?php endif; ?> />
                <a href="javascript:void(0);" id="saveColl_<?php echo ($goods["gid"]); ?>" class="gra onHoverSavePrice">搭配省<?php echo (sprintf('%.2f',$goods["save_price"])); ?>元</a>
                <?php if($goods["skuNames"] != ''): ?><a href="javascript:void(0);"  id="selectColl_<?php echo ($goods["gid"]); ?>"  class="blu onHoverSelectGoods" onclick="selectGoodProducts('<?php echo ($goods["gid"]); ?>','<?php echo ($goods["authorize"]); ?>');">选择商品信息</a>
                <p style="display:none" class="onHoverPdtName" id="collPdt_<?php echo ($goods["gid"]); ?>">规格规格规格规格</p><?php endif; ?>
            </li><?php break;?>
            <?php case "3": case "4": case "5": ?><li id="onHoverCollGoods<?php echo ($goods["gid"]); ?>" class="onHoverCollGoods foreachCollGoods" fuck="2" style="display:none">
                <a href="/Home/Products/detail/gid/<?php echo ($goods["gid"]); ?>" class="proPic"><img src="<?php echo ($goods['gpic']); ?>" width="110" height="110"></a>
                <a href="/Home/Products/detail/gid/<?php echo ($goods["gid"]); ?>" class="proN"><?php echo ($goods["gname"]); ?></a>
                
                <p><input type="checkbox" value=""  <?php if($goods["skuNames"] != ''): ?>onclick="collGoodsClick(this,'<?php echo ($goods["gid"]); ?>','<?php echo ($goods["authorize"]); ?>');"<?php else: ?>onclick="collProductClick(this,'<?php echo ($goods["gid"]); ?>','<?php echo ($goods["pdt_id"]); ?>','<?php echo ($goods["authorize"]); ?>','<?php echo ($goods["gcoll_price"]); ?>','<?php echo ($goods["save_price"]); ?>');"<?php endif; ?> id="coll_goods_<?php echo ($goods["gid"]); ?>" /> <strong id="collPrice_<?php echo ($goods["gid"]); ?>">&yen;<?php echo (sprintf('%.2f',$goods["gcoll_price"])); ?></strong></p>
                <input type="hidden" gid="<?php echo ($goods["gid"]); ?>" name="arrayPdt" id="coll_products_<?php echo ($goods["gid"]); ?>" value="" <?php if($goods["skuNames"] == ''): ?>save="<?php echo (sprintf('%.2f',$goods["save_price"])); ?>" price="<?php echo (sprintf('%.2f',$goods["gcoll_price"])); ?>"<?php endif; ?> />
                <a href="javascript:void(0);" id="saveColl_<?php echo ($goods["gid"]); ?>" class="gra onHoverSavePrice">搭配省<?php echo (sprintf('%.2f',$goods["save_price"])); ?>元</a>
                <?php if($goods["skuNames"] != ''): ?><a href="javascript:void(0);"  id="selectColl_<?php echo ($goods["gid"]); ?>"  class="blu onHoverSelectGoods" onclick="selectGoodProducts('<?php echo ($goods["gid"]); ?>','<?php echo ($goods["authorize"]); ?>');">选择商品信息</a>
                <p style="display:none" class="onHoverPdtName" id="collPdt_<?php echo ($goods["gid"]); ?>">规格规格规格规格</p><?php endif; ?>
            </li><?php break;?>
            <?php case "6": case "7": case "8": ?><li id="onHoverCollGoods<?php echo ($goods["gid"]); ?>" class="onHoverCollGoods foreachCollGoods" fuck="3" style="display:none">
                <a href="/Home/Products/detail/gid/<?php echo ($goods["gid"]); ?>" class="proPic"><img src="<?php echo ($goods['gpic']); ?>" width="110" height="110"></a>
                <a href="/Home/Products/detail/gid/<?php echo ($goods["gid"]); ?>" class="proN"><?php echo ($goods["gname"]); ?></a>
                
                <p><input type="checkbox" value=""  <?php if($goods["skuNames"] != ''): ?>onclick="collGoodsClick(this,'<?php echo ($goods["gid"]); ?>','<?php echo ($goods["authorize"]); ?>');"<?php else: ?>onclick="collProductClick(this,'<?php echo ($goods["gid"]); ?>','<?php echo ($goods["pdt_id"]); ?>','<?php echo ($goods["authorize"]); ?>','<?php echo ($goods["gcoll_price"]); ?>','<?php echo ($goods["save_price"]); ?>');"<?php endif; ?> id="coll_goods_<?php echo ($goods["gid"]); ?>" /> <strong id="collPrice_<?php echo ($goods["gid"]); ?>">&yen;<?php echo (sprintf('%.2f',$goods["gcoll_price"])); ?></strong></p>
                <input type="hidden" gid="<?php echo ($goods["gid"]); ?>" name="arrayPdt" id="coll_products_<?php echo ($goods["gid"]); ?>" value="" <?php if($goods["skuNames"] == ''): ?>save="<?php echo (sprintf('%.2f',$goods["save_price"])); ?>" price="<?php echo (sprintf('%.2f',$goods["gcoll_price"])); ?>"<?php endif; ?> />
                <a href="javascript:void(0);" id="saveColl_<?php echo ($goods["gid"]); ?>" class="gra onHoverSavePrice">搭配省<?php echo (sprintf('%.2f',$goods["save_price"])); ?>元</a>
                <?php if($goods["skuNames"] != ''): ?><a href="javascript:void(0);"  id="selectColl_<?php echo ($goods["gid"]); ?>"  class="blu onHoverSelectGoods" onclick="selectGoodProducts('<?php echo ($goods["gid"]); ?>','<?php echo ($goods["authorize"]); ?>');">选择商品信息</a>
                <p style="display:none" class="onHoverPdtName" id="collPdt_<?php echo ($goods["gid"]); ?>">规格规格规格规格</p><?php endif; ?>
            </li><?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="btnd">
            <label>购买人气组合</label>
            <P>组&nbsp;合&nbsp;价:<strong id="all_coll_price"><?php if($this_coll["skuNames"] != ''): ?>￥0.00<?php else: ?>￥<?php echo (sprintf('%.2f',$this_coll["gcoll_price"])); endif; ?></strong><input type="hidden" id="cartNums" value="1" onblur="checkNums(this);"></P>
            <label id="all_save_price"><?php if($this_coll["skuNames"] != ''): ?>立即节省0.00元<?php else: ?>立即节省<?php echo (sprintf('%.2f',$this_coll["save_price"])); ?>元<?php endif; ?></label>
			<a href="javascript:void(0);" onclick="addCart();" class="addCart"></a>
		</div>	
    </div><!--freeComCon  end-->
</div><!--自由组合   结束-->
<form id="submitCollFrom" name="submitCollFrom" method="post" action="/Ucenter/Orders/pageAdd">
<input type="hidden" name="pid[]" id="submitSkipPid" value="free1" />
<input type="hidden" name="type[]" id="submitSkiptype" value="4"/>
</form>
<input type="hidden" id="fc_id" value="<?php echo ($fc_id); ?>" />
<script>
var count_teb = "<?php echo count($coll_goods); ?>";
var min_orders = parseInt(Math.ceil(count_teb/4));
function checkTeb(obj,tab){
    $(".foreachCollGoods").hide();
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
    $(".foreachCollGoods[fuck='"+nowPage+"']").slideDown();
    $(".pageCollGood").each(function(){
        $(this).attr('nowPage',nowPage);
    
    });
        
    
    
}

$(document).ready(function(){
    $('.onHoverCollGoods').mouseover(function(){
        if($(this).attr('ohgg') == 1){
            $(this).find('.onHoverSelectGoods').show();
            $(this).find('.onHoverPdtName').hide();
        }
        
    });
    $('.onHoverCollGoods').mouseout(function(){
        if($(this).attr('ohgg') == 1){
            $(this).find('.onHoverSelectGoods').hide();
            $(this).find('.onHoverPdtName').show();
        }
    });
});
//点击复选框选择多规格商品
function collGoodsClick(obj,gid,authorize){
    if($(obj).attr('checked') == 'checked'){
        $(obj).attr('checked',false);
        selectGoodProducts(gid,authorize);
    }else{
        var nums = $('#cartNums').val();
        $("#coll_products_"+gid).val('');
        $("#coll_products_"+gid).attr('price','');
        $("#coll_products_"+gid).attr('save','');
        $(obj).parent().parent().removeAttr('ohgg');
        setRemmendPrice();
        $("#coll_products_"+gid).val('');
       
    }
}
//点击复选框选择无规格商品
function collProductClick(obj,gid,pdt_id,authorize,gcoll_price,save){
    var nums = parseInt($('#cartNums').val());
    if(parseInt(pdt_id) <= 0){
        $.ThinkBox.error("商品不存在或者已经被下架");
        return false;
    }
    if(authorize != '1'){
        $.ThinkBox.error("您不能购买该商品");
        return false;
    }
    if($(obj).attr('checked') == 'checked'){
        $("#onHoverCollGoods"+gid).attr('ohgg',1);
        $("#coll_products_"+gid).val(pdt_id);
    }else{
        $("#onHoverCollGoods"+gid).removeAttr('ohgg');
        $("#coll_products_"+gid).val('');
    }
    setRemmendPrice();
}
//选择商品属性
function selectGoodProducts(gid,authorize){
    if(parseInt(gid) <= 0){
        $.ThinkBox.error("商品不存在或者已经被下架");
        return false;
    }
    if(authorize != '1'){
        $.ThinkBox.error("您不能购买该商品");
        return false;
    }
    $.ajax({
        url:'/Home/Products/getAddGoodsCart',
        cache:false,
        dataType:'HTML',
        data:{gid:gid},
        type:"POST",
        success:function(msgObj){
            var box = $.ThinkBox(msgObj, {'title' : '请选择您要的商品信息','width':'448px','drag' : true,'unload':true});
        }
    });

}
//重新计算套餐价和搭配优惠金额，返回单组套餐价与优惠金额 格式：套餐价,优惠金额
function setRemmendPrice(){
    var all_price = 0.00;
    var save_price = 0.00;
    $("input[name='arrayPdt']").each(function(){
        if($(this).val() != ''){
            all_price = (parseFloat($(this).attr('price'))+parseFloat(all_price)).toFixed(2);
            save_price = (parseFloat($(this).attr('save'))+parseFloat(save_price)).toFixed(2);;
        }
    });
    $("#all_coll_price").html("￥"+(all_price*$("#cartNums").val()).toFixed(2));
    
    $("#all_save_price").html("搭配买共省"+(save_price*$("#cartNums").val()).toFixed(2)+"元");
    return all_price+','+save_price;
}
//加入购物车
function addCart(skip){
    var data = new Object();
    var pdt_id = '';
    var nums = '';
    var gid = '';
    data['fc_id'] = $("#fc_id").val();
    var i = 0;
    var j =0;
    $("input[name='arrayPdt']").each(function(){
        if($(this).val() != ''){
            pdt_id += this.value+',';
            nums += $("#cartNums").val()+',';
            gid += $(this).attr('gid')+',';
            if(parseInt($(this).attr('gid')) == parseInt($("#gid").val())){
                j=1;
            }
            i++;
        }
    });
    if(j!=1){
    
        $.ThinkBox.error("请选择第一件商品信息");return false;
    }
    if(j == 1 && i==1){
        $.ThinkBox.error("请选择自由推荐商品");return false;
    }
    if(skip == '1'){
        data['skip'] = 1;
    }
    data['pdt_id'] = pdt_id.substring(0,pdt_id.length-1);
    data['num'] = nums.substring(0,nums.length-1);
    data['g_id'] = gid.substring(0,gid.length-1);
    $.post('/Home/Cart/doAddFreeCollocation',data,function(dataMsg){
        if(dataMsg.status){
            if(skip == '1' && '<?php echo ($_SESSION['Members']['m_name']); ?>'!='' && dataMsg.url!=''){
                $.ThinkBox.success(dataMsg.info);
                $("#submitCollFrom").submit();
            }else{
                ajaxLoadShoppingCart(1);
                $.ThinkBox.success(dataMsg.info);
            } 
        }else{
            $.ThinkBox.error(dataMsg.info);
        }
         
    },'json');
    
}
//选择购买数量
function checkNums(obj){
    var ereg_rule= /[^0-9]+/;
    var nums = obj.value;
    var all_coll_price = $("#all_coll_price").html();
    var all_coll_price = $("#all_coll_price").html();
    if(nums == ''){return false;}
    if(nums < 1){
        $.ThinkBox.error('购买数量不能小于1');
        $(obj).val('1');
        nums = 1;
    }
    var str_tmp_price = setRemmendPrice();
    var price = str_tmp_price.split(',');
    $("#all_coll_price").html("￥"+(parseFloat(price[0])*nums).toFixed(2));
    
    $("#all_save_price").html("搭配买共省"+(parseFloat(price[1])*nums).toFixed(2)+"元");
}

</script><?php endif; ?>