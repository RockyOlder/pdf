<?php if (!defined('THINK_PATH')) exit();?><table>
<tbody>
<?php if(!empty($array_spec_info)): if(is_array($array_spec_info)): $i = 0; $__LIST__ = $array_spec_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		<td style="width:100px;text-align:right;padding-right:3px;"><?php echo ($vo["gs_name"]); ?>：</td>
		<td>
		<?php if($vo["gs_input_type"] == 1): ?><input type="text" class="large" name="goods_unsales_spec[<?php echo ($vo["gs_id"]); ?>]" value="<?php echo ($vo["gsd_aliases"]); ?>" />
		<?php elseif($vo["gs_input_type"] == 2): ?>
		<select class="medium" name="goods_unsales_spec[<?php echo ($vo["gs_id"]); ?>]" style="width:auto;">
			<option value="0" >请选择<?php echo ($vo["gs_name"]); ?>的属性值</option>
			<?php if(is_array($vo[spec_detail])): $i = 0; $__LIST__ = $vo[spec_detail];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sp): $mod = ($i % 2 );++$i; if($vo['gsd_id'] == $sp['gsd_id']): ?><option value="<?php echo ($sp["gsd_id"]); ?>" selected="selected" ><?php echo ($sp["gsd_value"]); ?></option>
				<?php else: ?>
					<option value="<?php echo ($sp["gsd_id"]); ?>" ><?php echo ($sp["gsd_value"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</select>
		<?php elseif($vo["gs_input_type"] == 3): ?>
		<textarea name="goods_unsales_spec[<?php echo ($vo["gs_id"]); ?>]" class="mediumBox"><?php echo ($vo["gsd_aliases"]); ?></textarea><?php endif; ?>
		</td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
<?php else: ?>
	<tr>
		<td colspan="2" style="text-align:left;padding-left:30px;color:#ff0000;">
			该商品类型下暂无扩展属性需要录入。如需录入，请先转到
			<a href="<?php echo U('Admin/GoodsType/pageList');?>" title="点击转到类型列表。" onclick="if(!confirm('确定要去录入属性吗？\n您之前录入的数据比如商品名称可能丢失！')){return false;}">类型列表</a>
			，添加相应的属性。
		</td>
	</tr><?php endif; ?>
	<!-- 启用规格 按钮 开始 -->
	<tr>
		<td colspan="2" style="text-align:left;padding-left:30px;">
            <?php if($enable != 0): else: ?>
			<button type="button" id="enable_goods_skus" enable="<?php echo ($enable); ?>" class="btnA">
                启用规格
			</button><?php endif; ?>
		</td>
	</tr>
	<!-- 启用规格 按钮 结束 -->
</tbody>
</table>
<script type="text/javascript">
$(document).ready(function(){
	//启用规格按钮被点击以后，异步加载商品销售属性的表单
	$("#enable_goods_skus").click(function(){
		var enable = parseInt($(this).attr("enable"));
		if(1 == enable && confirm("确定要取消规格吗？")){
			$(this).attr({"enable":0}).html("开启规格");
			$("#select_goods_sales_spec_box,#goods_sku_list_form").hide();
			$(".disabled_goods_sale_spec_info").show();
			return false;
		}
		$(this).attr({"enable":1}).html("取消规格");
		$("#select_goods_sales_spec_box,#goods_sku_list_form").show();
		$(".disabled_goods_sale_spec_info").hide();
	});
});
</script>