<?php if (!defined('THINK_PATH')) exit();?>
<?php if($veriry_order["status"] == 0): ?><table class="tbForm" width="100%;">
	<tbody>
        <tr>
			<td align="left">订单号<?php echo ($ary_data["o_id"]); ?>：<?php echo ($veriry_order["msg"]); ?></td>
			<input type="hidden" value="0" id="status_<?php echo ($ary_data["o_id"]); ?>" />
		</tr>
	</tbody>
</table>
<?php else: ?>
<table class="tbForm" width="100%;">
	<tbody>
        <tr>
			<td align="left">订单号：</td>
			<td align="left">
				<?php echo ($ary_data["o_id"]); ?><input type="hidden" value="1" id="status_<?php echo ($ary_data["o_id"]); ?>" />
            </td>
		</tr>
		<tr>
			<td align="left">备注：</td>
			<td align="left">
                <textarea name="ap_remark" id="ap_remark" cols="30" rows="4"></textarea>
            </td>
		</tr>
	</tbody>
</table><?php endif; ?>