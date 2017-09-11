<?php if (!defined('THINK_PATH')) exit();?>
<form action="#" method="post" id="order_explort">
<table class="tbForm" width="100%">
    <tbody>
        <tr>
            <td>
                <input name="orders_type" type="radio" value="0" checked="checked">从第<input type="text" value="1" name="start" id="orders_start">页
                至&nbsp;第<input type="text" value="1" name="end" id="orders_end">页结束
            </td>       
        </tr>
        <tr>
            <td colspan="3">
                <input name="orders_type" type="radio" value="3" checked="checked">
                <input type="text" class="timer" name="o_create_time_start" value="">
                -
                <input type="text" class="timer" name="o_create_time_end" value="">(<font color='red'>下单时间</font>)
            </td>
        </tr>
        <tr>
            <td><input name="orders_type" type="radio" value="1" o_ids="<?php echo ($filter["o_ids"]); ?>" class='order_ids'>导出当前选中的订单</td>
        </tr>
         <tr>
            <td><input name="orders_type" type="radio" value="2">导出全部订单(<font color='red'>导出最近1000条数据</font>)</td>
        </tr>
		<tr>
			<td><input name="orders_type" type="radio" value="4"/>导出当前搜索结果订单(<font color='red'>导出最近1000条数据</font>)</td>
		</tr>
    </tbody>
</table>
</form>
<script>
    $(document).ready(function(){
        $(".timer").datetimepicker({
            showMonthAfterYear: true,
            changeMonth: true,
            changeYear: true,
            buttonImageOnly: true
        });
    });
</script>