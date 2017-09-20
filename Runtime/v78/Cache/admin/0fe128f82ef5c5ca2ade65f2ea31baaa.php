<?php if (!defined('THINK_PATH')) exit();?>
<td colspan="3" >
    <div style="margin-left:75px; width:887px" class='ajax_show_area'><!--rightInner  start-->
        <table width="100%" class="tbNew">
            <tbody>
                <tr>
                    <td class="first" style="width:74px"><span class="red">*</span> 选择商品：</td>
                    <td>
                        <input class="goodsSelecter" type="hidden" value="1" id="cfg_goods_part" name="cfg_goods_area" checked="checked">
                        <input type="button" <?php if(($config->cfg_goods_area) == "-1"): ?>style="display:none;"<?php endif; ?> class="btnA" id="add_goods" value="添加商品" onClick="javascript:add_pmn_goods();">
                        <div id="goodsSelect" style="display: none;" title="请选择商品">
                            
<div id="isAjax" class="none">用此ID标识本页面是通过ajax载入进来的</div>
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
                    <input type="text" class="medium" value="<?php echo ($chose["gsn"]); ?>" name="gs_gsn" id="gs_gsn1" />
					&nbsp;商品名称&nbsp;<input type="text" class="medium" value="<?php echo ($chose["gname"]); ?>" name="gs_gname" id="gs_gname1" />
                </td>
                <td></td>
                <td>

                </td>
            </tr>
            <tr>
                <td>商品分类</td>
                <td>
                    <select class="medium" name="gs_gcid" id="gs_gcid1">
                        <option value="0"> - 全部分类 - </option>
                        <?php if(is_array($search["cates"])): $i = 0; $__LIST__ = $search["cates"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["gc_id"]); ?>" <?php if(($chose["gcid"]) == $cate[gc_id]): ?>selected="selected"<?php endif; ?> style="color:<?php echo ($color[$cate[gc_level]]); ?>">
                                <?php $__FOR_START_31244__=0;$__FOR_END_31244__=$cate[gc_level];for($i=$__FOR_START_31244__;$i < $__FOR_END_31244__;$i+=1){ ?>&nbsp;&nbsp;<?php } ?>
                                <?php echo ($cate["gc_name"]); ?>
                            </option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
					&nbsp;&nbsp;商品品牌&nbsp;
                    <select class="medium" name="gs_gbid" id="gs_gbid">
                        <option value="0"> - 全部品牌 - </option>
                        <?php if(is_array($search["brands"])): $i = 0; $__LIST__ = $search["brands"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?><option value="<?php echo ($brand["gb_id"]); ?>" <?php if(($chose["gbid"]) == $brand[gb_id]): ?>selected="selected"<?php endif; ?> >
                                <?php echo ($brand["gb_name"]); ?>
                            </option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>					
                </td>
                <td id="gifts" style="display:none">
                    <input type="checkbox" name="g_gifts" id="g_gifts1" value="1" checked="checked" disabled="disabled"  >赠品
                </td>
                <td colspan="99" align="right">
                    <input type="button" value="查 找" class="btnA" id="goodsSelecterSerch" >
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
                <td><input type="checkbox" class="checkSon" name="gs_gid[]" value="<?php echo ($goods["g_id"]); ?>" /></td>
				<td><img src='<?php echo (C("DOMAIN_HOST")); echo (($goods["g_picture"])?($goods["g_picture"]):"/Public/Ucenter/images/grey.gif"); ?>' class="img32" /></td>
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
    $('#goodsSelecterSerch').click(function(){
        var g_gifts =  0;
        var data = {
            'gs_gname':$('#gs_gname1').val(),
            'gs_gsn':$('#gs_gsn1').val(),
            'gs_gcid':$('#gs_gcid1').val(),
            'g_gifts':g_gifts,
			'gs_gbid':$('#gs_gbid').val()
        };
		
        var url = "<?php echo U('Admin/Products/getGoodsSelecter');?>";
        $.get(url,data,function(info){
            $('#isAjax').parent().html(info);
			$("#goodsSelect").attr('g_gifts',g_gifts);
        },'text');
    });
</script>
                        </div>
                    </td>
                </tr>
                <tr id="add_goods_tr" <?php if(($config->cfg_goods_area) == "-1"): ?>style="display:none"<?php endif; ?>>
                    <td colspan="2">
                        <table id="raGoodsId" class="tbList" width="100%">
                            <thead>
                                <tr>
                                    <!--<th style="text-align:center;">
                                        <input type="checkbox" onclick="checkAll()" class="checkAll_tr">
                                    </th>-->
                                    <th style="text-align:center;">商品名称</th>
                                    <th style="text-align:center;">商品编号</th>
                                    <th style="text-align:center;">销售价（元）</th>
                                    <?php if($filter["type"] != 'add'): ?><th style="text-align:center;">一口价（元）</th><?php endif; ?>
                                    
                                    <th style="text-align:center;">操作</th>
                                </tr>
                            </thead>
                            
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
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <?php echo ($page); ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
                <?php if($filter["type"] != 'add'): ?><tr>
                    <table style="width:100%">
                        <tr>
                            <td width="75px">设置一口价：</td>
                            <td id="discounts_all" style="display:block">
                                <input type="text" class="small" id="cfg_discounts_all" name="cfg_discounts_all" value="<?php echo ($config['cfg_discount_all']); ?>" validate="{ number:true}" >
                                <a href="javascript:void(0);" id="cfg_discounts_setAll" >快速批量设置</a>&nbsp;&nbsp;
                            <!--</td>
                            <td id="discounts_system_all">-->
                                <input type="text" class="small" style="display:none" id="cfg_discounts_system_all" name="cfg_discounts_system_all" validate="{ required:true,number:true,min:0.01}" value="<?php echo ($config['cfg_discounts_system_all']); ?>"/>
                            <span>折上折：<input class="checkSon_tr" type="checkbox" name="cfg_use_again_discount" id="cfg_use_again_discount" value="1" <?php if($config['cfg_use_again_discount'] == 1): ?>checked<?php endif; ?> >(是否再次参与订单促销)</span>
                            </td>
                        </tr>
                        <tr>
                    <table >
                </tr><?php endif; ?>
            </tbody>
        </table>
    </div></td>

<script type="text/javascript">
    $(document).ready(function(){
        var types=$("input:radio[name='cfg_goods_area']:checked").val();
        if(types == -1){
            //如果是全部商品则隐藏商品
            $("#add_goods_tr").hide();
            $('#add_goods').hide();
            $("#raGoodsId tbody").remove();
            $("#discounts_system_all").css("display","block");  
        }
         
    });

    $('#goodsSelect').dialog({
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
                $("input[name='gs_gid[]']").each(function(){
                    var g_id = $(this).val();
                    if($(".selected_goods_tr_" +g_id).length > 0){
                        $(this).attr("checked",false);
                    }
                });
                var data = $("input[name='gs_gid[]']").serialize();
                    data+=',PYIKOUJIA';
                    var type = "<?php echo ($filter["type"]); ?>";
                    if(type == 'add'){
                        var url = "<?php echo U('Admin/Promotions/getGoodsTr','type=add');?>";
                    }else{
                        var url = "<?php echo U('Admin/Promotions/getGoodsTr');?>";
                    }
                
                $.post(url,data,function(info){
                    var html= $('#raGoodsId thead').after($(info));
                    var num=$("input[name='ra_gid[]']").length;
                    if(num==0){
                        $("#cfg_discounts_setAll").css('display','none');
                    }else{
                        $("#cfg_discounts_setAll").css('display','');
                    }
                },'text');
                dio.dialog( "close" );
            },
            '关闭': function() {
                var num=$("input[name='ra_gid[]']").length;
                if(num==0){
                    $("#cfg_discounts_setAll").css('display','none');
                }else{
                    $("#cfg_discounts_setAll").css('display','');
                }
                $( this ).dialog( "close" );
            }
        }
    });

    $('.goodsSelecter').click(function(){
        var types=$("input:radio[name='cfg_goods_area']:checked").val();
        //1:部分商品，-1：全部商品
        if(types==1){
            $("#add_goods_tr").hide();
            $('#add_goods').hide();
            $("#raGoodsId tbody").remove();
            $("#discounts_system_all").css("display","block");  
            $("#discounts_all").css("display","none"); 
            $("#add_goods_tr").addClass('tbList');
            $('#add_goods').css("display","");
            $("#add_goods_tr").css("display","");
            //$('#goodsSelect').dialog('open');
            $("#discounts_all").css("display","block");  
            $("#discounts_system_all").css("display","none");  
        }else{
            //如果是全部商品则隐藏商品
            $("#add_goods_tr").hide();
            $('#add_goods').hide();
        }
    });
    /*
     * 设置价格
     */
    function shortcut(gid){
        $(".shortcut_pro_"+gid).val($("#shortcut_goods_"+gid).val());
    }
    /*批量设置商品折扣*/
    $(function(){
        $('#cfg_discounts_setAll').click(function(){
            //$("#cfg_discounts_system_all").show();
            $('.cfg_discounts').val($('#cfg_discounts_all').val());
        });
        
    });
    //显示商品选择框
    function add_pmn_goods() {
		$("#gifts").hide();
		$("#g_gifts").val("0");
		if($("#goodsSelect").attr('g_gifts') != '0'){
			$("#goodsSelecterList").html("");
		}
		
		//$("#goodsSelecterList").html("");
        $('#goodsSelect').dialog('open');
    }
</script>