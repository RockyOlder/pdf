<?php if (!defined('THINK_PATH')) exit();?>
<div id="isAjax" style="display:none">用此ID标识本页面是通过ajax载入进来的</div>
<div class="rightInner load" id="goodsSelecterInner">
    <table width="100%" class="tbForm">
        <thead>
            <tr class="title">
                <th colspan="99">查找商品</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>商品货号</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["pdt_sn"]); ?>" name="pdt_sn" id="pdt_sn" />
                </td>
                <td>商品名称</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["g_name"]); ?>" name="gs_name" id="gs_name" />
                </td>
                <td>商品分类</td>
                <td>
                    <select class="medium" name="gs_gcid" id="gs_gcid">
                        <option value="0"> - 全部分类 - </option>
                        <?php if(is_array($search["cates"])): $i = 0; $__LIST__ = $search["cates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["gc_id"]); ?>" <?php if(($chose["gcid"]) == $cate[gc_id]): ?>selected="selected"<?php endif; ?> ><?php $__FOR_START_3893__=0;$__FOR_END_3893__=$cate[gc_level];for($i=$__FOR_START_3893__;$i < $__FOR_END_3893__;$i+=1){ ?>&nbsp;&nbsp;<?php } echo ($cate["gc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
                <td colspan="99" align="right">
                    <input type="button" value="查 找" class="btnA" onclick="goodsSelecterSerch();" >
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="rightInner load" id="goodsSelecterList">
    <table width="100%" class="tbList">
        <thead>
            <tr>
                <th><input type="checkbox" class="ckeckAll" /></th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>商品货号</th>
                <th>规格名称</th>
                <th>分类</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" class="checkSon" name="gs_pdt_sn" value="<?php echo ($goods["pdt_sn"]); ?>" /></td>
                <td><img src='<?php echo (($goods["g_picture"])?($goods["g_picture"]):"Ucenter/images/pdtDefault.jpg"); ?>' class="img32" /></td>
                <td><?php echo ($goods["g_name"]); ?><br><span class="blue"><?php echo ($goods["g_sn"]); ?></span></td>
                <td><?php echo ($goods["pdt_sn"]); ?></td>
                <td><?php echo ($goods["pdt_spec"]); ?></td>
                <td><?php echo ($goods["gc_name"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(empty($list)): ?><tr><td colspan="99" class="left">没有查找到结果! 没有相关的数据或者请先进行查找~ </td></tr><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="99"><span class="right page"><?php echo ($page); ?></span></td>
            </tr>
        </tfoot>
    </table>
    <div class="clear"></div>
</div>
<script src="__PUBLIC__/Admin/js/loading.js"></script>
<script>
$("#g_gifts").click(function(){
    if($(this).val()=='1'){
        $("#g_gifts").val('0');
    }else{
        $("#g_gifts").val('1');
    }
})

//查找商品 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function goodsSelecterSerch(){
    var g_gifts =  $("#g_gifts").val();
    var data = {
        'pdt_sn':$("input[name='pdt_sn']").val(),
        'g_name':$("input[name='gs_name']").val(),
        'gs_gcid':$('#gs_gcid').val(),
        'g_gifts':g_gifts
    };
    var url = "<?php echo U('Admin/Goods/getProductsInfo');?>";
    $.get(url,data,function(info){
        $('#isAjax').parent().html(info);
    },'text');
}
</script>