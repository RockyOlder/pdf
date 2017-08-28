<?php if (!defined('THINK_PATH')) exit();?>
<div id="isAjaxGift" class="none">用此ID标识本页面是通过ajax载入进来的</div>
<div class="rightInner load" id="goodsSelecterInner">
    <table width="100%" class="tbForm">
        <thead>
            <tr class="title">
                <th colspan="99">查找商品</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>商品编号</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["gsn"]); ?>" name="gs_gsn" id="gs_gsn" />
                </td>
                <td>商品名称</td>
                <td>
                    <input type="text" class="medium" value="<?php echo ($chose["gname"]); ?>" name="gs_gname" id="gs_gname" />
                </td>
            </tr>
            <tr>
                <td>商品分类</td>
                <td>
                    <select class="medium" name="gs_gcid" id="gs_gcid">
                        <option value="0"> - 全部分类 - </option>
                        <?php if(is_array($search["cates"])): $i = 0; $__LIST__ = $search["cates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["gc_id"]); ?>" <?php if(($chose["gcid"]) == $cate[gc_id]): ?>selected="selected"<?php endif; ?> ><?php $__FOR_START_281__=0;$__FOR_END_281__=$cate[gc_level];for($i=$__FOR_START_281__;$i < $__FOR_END_281__;$i+=1){ ?>&nbsp;&nbsp;<?php } echo ($cate["gc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
                <input type="checkbox" name="g_gifts" id="g_gifts" value="1" checked="checked" disabled="disabled"  >赠品
                <td colspan="99" align="right">
                    <input type="button" value="查 找" class="btnA" id="goodsSelecterSerchGift" >
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
                <th>分类</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" class="checkSon" name="gs_gift_gid[]" value="<?php echo ($goods["g_id"]); ?>" /></td>
                <td><img src='<?php echo (($goods["g_picture"])?($goods["g_picture"]):"/Public/Ucenter/images/grey.gif"); ?>' class="img32" /></td>
                <td><?php echo ($goods["g_name"]); ?><br><span class="blue"><?php echo ($goods["g_sn"]); ?></span></td>
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
<script type="text/javascript">
    $("#g_gifts").click(function(){
        if($(this).val()=='1'){
            $("#g_gifts").val('0');
        }else{
            $("#g_gifts").val('1');
        }
    })
    //查找商品 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $('#goodsSelecterSerchGift').click(function(){
        var g_gifts =  $("#g_gifts").val();
        var data = {
            'gs_gname':$('#gs_gname').val(),
            'gs_gsn':$('#gs_gsn').val(),
            'gs_gcid':$('#gs_gcid').val(),
            'g_gifts':g_gifts
        };
		
        var url = "<?php echo U('Admin/Products/getGoodsSelecterGift');?>";
        $.get(url,data,function(info){
            $('#isAjaxGift').parent().html(info);
			$("#goodsSelectGift").attr('g_gifts',g_gifts);
        },'text');
    });
</script>