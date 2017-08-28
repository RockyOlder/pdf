<?php if (!defined('THINK_PATH')) exit();?>
<td colspan="3">
    <div style="width:887px;margin-left:75px">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbForm">
            <tr id="orders_condition" >
                <td width="90px" style="padding-left:3px;"><span class="red">*</span> 订单优惠条件</td>
                <td  style=''>
                    <input type="text" class="medium" name="cfg_cart_start" id="cfg_cart_start" value="<?php echo ($config['cfg_cart_start']); ?>" validate="{ required:true,number:true,min:1}"/> - 
                    <input type="text" name="cfg_cart_end" id="cfg_cart_end" class="medium" value="<?php echo ($config['cfg_cart_end']); ?>" validate="{ required:true,number:true,min:1}"/>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbForm">
            <tbody>
                <tr>
                    <td width="80px"><span class="red">*</span>  选择赠品</td>
                    <td align="left">
                        <input type="hidden" value="1" name="cfg_goods_area_gift" checked="checked" />
                       <input type="hidden" value="<?php echo ($g_gifts); ?>" id="g_gifts" checked="checked" />
                        <input type="button" class="goodsSelecterGift btnA"  id="add_goods" value="添加商品">
                        <div id="goodsSelectGift" g_gifts="" style="display: none;" title="请选择商品">
                            
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
                        <?php if(is_array($search["cates"])): $i = 0; $__LIST__ = $search["cates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["gc_id"]); ?>" <?php if(($chose["gcid"]) == $cate[gc_id]): ?>selected="selected"<?php endif; ?> ><?php $__FOR_START_4754__=0;$__FOR_END_4754__=$cate[gc_level];for($i=$__FOR_START_4754__;$i < $__FOR_END_4754__;$i+=1){ ?>&nbsp;&nbsp;<?php } echo ($cate["gc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
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
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                         <table id="raGoodsGiftId" class="tbList" width="100%" style="border-top:1px solid #d7d7d7;">
                             <tr style="border:1px solid #D7D7D7">
                                <td style="text-align:center; background-color:#ECECEC; font-size:14px">商品名称</td>
                                <td style="text-align:center; background-color:#ECECEC; font-size:14px">商品编号</td>
                                <td style="text-align:center; background-color:#ECECEC; font-size:14px">销售价（元）</td>
                                <td style="text-align:center; background-color:#ECECEC; font-size:14px">操作</td>
                            </tr>
                            
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
            <input type="hidden" name="ra_gift_gid[]" value="<?php echo ($goods["g_id"]); ?>">
        </td> 
    </tr>
    <tr class="selected_goods_gift_tr_<?php echo ($goods["g_id"]); ?>" id="selected_goods_products_tr_<?php echo ($goods["g_id"]); ?>" style="display:none; padding-left:30px;">
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
                                <input type="text" name="cfg_products[<?php echo ($goods["g_id"]); ?>][<?php echo ($pro["pdt_id"]); ?>]" value="<?php echo ($goods["g_price_config"]["cfg_products"]); ?>" class="tiny cfg_discounts shortcut_pro_<?php echo ($goods["g_id"]); ?>"/> 
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
        $("input[name='ra_gift_gid[]']").each(function(){
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
                         </table>
                    </td>
                </tr>
        </tbody>
        </table>
</div>
<script type="text/javascript">
    $('#goodsSelectGift').dialog({
        resizable:false,
        autoOpen: false,
        modal: true,
        width: 'auto',
        height:500,
        open:function(){
            $('.ui-widget-content').css('overflow-x','hidden');
        },
        buttons: {
            '确认': function() {
                var dio = $( this );
                //将弹框内已经选择好的数据发送的母页面的元素
                //此处不用js拼接html元素，直接把数据发送给控制器，利用控制器生成页面返回替换
                var data = {};
                $("input[name='gs_gift_gid[]']").each(function(){
                    var g_id = $(this).val();
                        if($(".selected_goods_gift_tr_"+g_id).length > 0) {
                            $(this).attr('checked',false);
                        }
                    });
                data = $("input[name='gs_gift_gid[]']").serialize();
                data+=',PZENPIN';
                var url = "<?php echo U('Admin/Promotions/getGoodsGiftTr');?>";
                $.post(url,data,function(info){
                    var html= $('#raGoodsGiftId').html() + info;
                    $('#raGoodsGiftId').html(html);
                },'text');
                dio.dialog( "close");
            },
            '关闭': function() {
                $( this ).dialog( "close" );
            }
        }
    });

    $('.goodsSelecterGift').click(function(){
		$("#gifts").show();
		$("#g_gifts").val("1");
		if($("#goodsSelectGift").attr('g_gifts') != '1'){
			$("#goodsSelectGifterList").html("");
		}
        var types=$("input[name='cfg_goods_area_gift']").val();
        if(types==1){
            $('#goodsSelectGift').dialog('open');
        }else{
            $("input[name='ra_gift_gid[]']").each(function(){
                $(this).parent('td').parent('tr').remove();
            })
        }
    });

    $('.condition').click(function(){
        if($(this).val() == '1'){
            $('#orders_condition').fadeIn('fast');
            $('#cart_condition').hide();
        }else if($(this).val() == '2'){
            $('#cart_condition').fadeIn('fast');
            $('#orders_condition').hide();
        }
    })
</script>