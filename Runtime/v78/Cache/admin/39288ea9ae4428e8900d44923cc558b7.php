<?php if (!defined('THINK_PATH')) exit();?>
<form action='<?php echo U("Admin/Orders/pageList");?>' method="get" name="order_form">
<div class="sSearch"><!--sSearch  start-->
    
    <ul>
        <li>
            <strong>订单状态</strong>
            <select class="mediumBox" style="width:110px" size="10" name="o_status" multiple="multiple">
                <option  value="1">全部</option>
                <option  value="1">正常订单</option>
                <option  value="3">暂停</option>
                <option  value="2">作废</option>
                <option  value="4">完成</option>
				<option  value="5">已确认收货</option>
            </select>
        </li>
        <li>
            <strong>支付状态</strong>
            <select class="mediumBox" style="width:110px" size="10" name="o_pay_status" multiple="multiple">
                <option  value="-1">全部</option>
                <option  value="1">已支付</option>
                <option  value="0">未支付</option>
            </select>
        </li>
        <li>
            <strong>发货状态</strong>
            <select class="mediumBox" style="width:110px" size="10" name="oi_ship_status" multiple="multiple">
                <option value="-1">全部</option>
                <option value="2">已发货</option>
                <option value="0">未发货</option>
            </select>
        </li>
        <li>
            <strong>支付方式</strong>
            <select class="mediumBox" style="width:110px" size="10" name="o_payment[]" multiple="multiple">
                <option value="-1">全部</option>
                <?php if(is_array($data["payment"])): $i = 0; $__LIST__ = $data["payment"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pay): $mod = ($i % 2 );++$i;?><option name="pc_id" value="<?php echo ($pay["pc_id"]); ?>"><?php echo ($pay["pc_custom_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </li>
        <li>
            <strong>配送方式</strong>
            <select class="mediumBox" style="width:110px" size="10" name="lt_id" multiple="multiple">
                <option value="-1">全部</option>
                <?php if(is_array($data["corp"])): $i = 0; $__LIST__ = $data["corp"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cp["lc_id"]); ?>"><?php echo ($cp["lc_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </li>
    </ul>
    <P class="required">以上选项，可以按住CTRL来进行多选</P>
    <table class="alertTable">
        <tr>
            <td width="130" align="right">订单号：</td>
            <td width="200"><input type="text" class="medium" name="o_id" value=""></td>
            <td width="110" align="right">会员名：</td>
            <td><input type="text" class="medium" name="m_name" value="" validate="{ isCheck:true,messages:{isCheck:'您输入的参数非法，请重新输入'}}"></td>
        </tr>
        <tr>
            <td align="right">收货人：</td>
            <td><input type="text" class="medium" name="o_receiver_name" value=""></td>
			<td align="right">第三方订单号：</td>
            <td><input type="text" class="medium" name="o_source_id" value=""></td>
            <!--<td align="right">收货人手机：</td>
            <td><input type="text" class="medium" name="o_receiver_mobile" value=""></td>-->
        </tr>
        <tr>
            <td align="right">收货人地址：</td>
            <td colspan="3">
                
<style type="text/css">
.loading-box{background-color:#FFF8ED;width:auto;min-width:100px;font-size:16px;padding:3px;border:1px solid #FF9900;display:none;}
</style>

<select id="province" name="province" class="medium city_region_select" child_id="city" val="<?php echo ($region['province']); ?>">
   <option value="0" selected="selected">请选择省份</option>
</select>
<select id="city" name="city" child_id="region1" class="medium city_region_select" val="<?php echo ($region['city']); ?>" >
   <option value="0" selected="selected">请选择城市</option>
</select>
<select id="region1" name="region1" child_id="" class="medium city_region_select" val="<?php echo ($region['region']); ?>" >
   <option value="0" selected="selected">请选择地区</option>
</select>
<span class="loading-box">请稍等，载入中......</span>
<script type="text/javascript">
$(document).ready(function(){
	//文档载入完成以后自动加载一级省市区
    loadChildCityRegion(1,'province',$('#province'));
	$(".city_region_select").change(function(){
		$(".city_region_select").attr({'val':''});
		var parent_id = $(this).val();
		var selectDomId = $(this).attr("child_id");
		loadChildCityRegion(parent_id,selectDomId,this);
	});
});
function openLoadingBox(){
	$(".loading-box").show();
}
function closeLoadingBox(){
	$(".loading-box").hide();
}
function loadChildCityRegion(parent_id,selectDomId,clickObj){
	//如果当前选中的行政区ID小于等于0，则表示选择的是“请选择”，将后面的行政区select清楚
	$(clickObj).nextAll("select").hide().empty();
	
	//如果选中了“请选择”，则不理会。
	if(parent_id <= 0 || "region" == $(clickObj).attr("id")){
		return false;
	}
	
	//定义异步加载行政区的url
	var load_options_url = "<?php echo U('Admin/Members/cityRegionOptions');?>";
	//ajax异步加载下一级行政区域数据
	$.ajax({
		url:load_options_url,
		data:{parent_id:parent_id},
		beforeSend:openLoadingBox(),
		type:'POST',
		success:function(jsonObj){
			if(true === jsonObj.status && null !== jsonObj.data){
				$(clickObj).next("select").show();
				//select options 元素数据拼接
				var html_options = '<option value="0" selected="selected">请选择</option>';
				var next_child_parent = 0;
				for(var index in jsonObj.data){
					html_options += '<option value="' + index + '" ';
					if(index == $(clickObj).attr('val')){
						html_options += 'selected="selected" ';
						next_child_parent = index;
					}
					html_options += '>' + jsonObj.data[index] + '</option>';
				}

				//将拼接的结果追加到DOM中
				$("#" + selectDomId).html(html_options);
				
				//递归加载数据，用于初始化的时候
				if(next_child_parent > 0){
					var selectChildDomId = $("#" + selectDomId).attr("child_id");
					loadChildCityRegion(next_child_parent,selectChildDomId,$("#" + selectChildDomId));
				}
				
				//对空seletet元素进行隐藏操作
				if($("#province").val() <= 0){
					$("#province").nextAll("select").hide().empty();
				}else if($("#city").val() <= 0){
					$("#city").nextAll("select").hide().empty();
				}
                
			}else{
				if("region" == $(clickObj).attr("id")){
					$(clickObj).empty().hide();
				}else{
					$(clickObj).next("select").empty().hide();
				}
				
			}
			closeLoadingBox();
		},
		dataType:'json'
	});
}
</script>
            </td>
        </tr>
        <tr>
            <td align="right">物流费用：</td>
            <td colspan="3">
                <input type="text" class="small" name="o_cost_freight_1" value="">
                -
                <input type="text" class="small" name="o_cost_freight_2" value="">
            </td>
        </tr>
        <tr>
            <td align="right">订单金额：</td>
            <td colspan="3">
                <input type="text" class="small" name="o_all_price_1" value="">
                -
                <input type="text" class="small" name="o_all_price_2" value="">
            </td>
        </tr>
        <tr>
            <td align="right">是否使用优惠券：</td>
            <td colspan="3">
                <input type="checkbox" class="inputRadio" name="o_coupon_1" value="1"> <label>是</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" class="inputRadio" name="o_coupon_2" value="0"> <label>否</label>
            </td>
        </tr>
        <tr>
            <td align="right">是否开发票：</td>
            <td colspan="3">
                <input type="checkbox" class="inputRadio yesR" name="is_invoice_1" id="is_invoice_1" value="1"> <label>是</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" class="inputRadio noR" name="is_invoice_2" id="is_invoice_2" value="0"> <label>否</label>
            </td>
        </tr>
        <tr class="trhidden" style="display: none;" id="invoice_type">
            <td align="right">发票类型：</td>
            <td colspan="3">
                <input type="radio" class="inputCheckb" name="invoice_type" value="1"> <label>普通发票</label>&nbsp;&nbsp;
                <input type="radio" class="inputCheckb" name="invoice_type" value="2"> <label>增值税发票</label>
            </td>
        </tr>
        <tr>
            <td align="right">下单时间：</td>
            <td colspan="3">
                <input type="text" class="medium timer" name="o_create_time_1" value="">
                -
                <input type="text" class="medium timer" name="o_create_time_2" value="">
            </td>
        </tr>
        <tr>
            <td align="right">客服：</td>
            <td colspan="3">
                <input type="text" class="medium" name="admin_name" value="">
            </td>
        </tr>
        <tr>
            <td align="right">cps来源：</td>
            <td colspan="3">
            <select name="channelid" >
                <option value="0">全部</option>
                <?php if(is_array($data["cps_info"])): $i = 0; $__LIST__ = $data["cps_info"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cps): $mod = ($i % 2 );++$i; if(($cps) == "1"): ?><option value="<?php echo ($key); ?>"><?php echo ($key); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </select>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center"><input type="submit" name="search" class="btnA" value="搜索">&nbsp;<input type="submit" class="btnA" value="关闭"></td>
        </tr>
    </table>
 
</div><!--sSearch  end-->
</form>
<script>
    $(document).ready(function(){
        $("#is_invoice_1").click(function(){
            $("#is_invoice_2").attr("checked",false);
            $("#invoice_type").show();
        });
        $("#is_invoice_2").click(function(){
            $("#is_invoice_1").attr("checked",false);
            $("#invoice_type").hide();
        });
    });

    $(document).ready(function(){
        $(".dater").datepicker({
            showMonthAfterYear: true,
            changeMonth: true,
            changeYear: true,
            buttonImageOnly: true
        });
        $(".timer").datetimepicker({
            showMonthAfterYear: true,
            changeMonth: true,
            changeYear: true,
            buttonImageOnly: true
        });
    });

    $(document).ready(function(){
        $(":button").click(function(){
            $("#orders_dialog").dialog("close");
        });
    });
</script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-sliderAccess.js"></script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-timepicker-addon.js"></script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-timepicker-zh-CN.js"></script>