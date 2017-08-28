<?php if (!defined('THINK_PATH')) exit();?>
<div class="cjjl">
	<p>本商品累计售出<strong><?php echo (($buynums)?($buynums):0); ?></strong>件</p>
	<table>
		<tr>
			<th>买家</th><th>宝贝名称</th><?php if(($buy_price) == "1"): ?><th>购买价</th><?php endif; ?><th>购买数量</th><th width="200">成交时间</th>
		</tr>
		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
				<td><span><?php echo ($list["m_name"]); ?></span></td>
				<td><div class="pName"><a><?php echo ($list["oi_g_name"]); ?></a></div></td>
                <?php if(($buy_price) == "1"): ?><td><span><?php echo (sprintf('%.2f',$list["oi_price"])); ?></span></td><?php endif; ?>
				<td><span><?php echo ($list["oi_nums"]); ?></span></td>
				<td><span><?php echo ($list["oi_create_time"]); ?></span></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<div class="fenyex">
<?php if($page['nowPage'] == 1): ?><a><<上一页</a>
<?php else: ?>
<a onclick="getBuyRecordPage('<?php echo ($list[g_id]); ?>','<?php echo ($page[nowPage]-1); ?>')"><<上一页</a><?php endif; ?>
<?php for($a=1;$a<=$page['totalPage'];$a++){ ?>
<?php if($a == $page['nowPage']): ?><a href="javascript:void(0);" class="on"><?php echo ($a); ?></a>
<?php else: ?>
<a onclick="getBuyRecordPage('<?php echo ($list[g_id]); ?>','<?php echo ($a); ?>')"><?php echo ($a); ?></a><?php endif; ?>
<?php } ?>
<?php if($page['nowPage'] == $page['totalPage']): ?><a>下一页>></a>
<?php else: ?>
<a onclick="getBuyRecordPage('<?php echo ($list[g_id]); ?>','<?php echo ($page[nowPage]+1); ?>')">下一页>></a><?php endif; ?>
</div>
</div>
<script>
function getBuyRecordPage(gid,num){
    $.ajax({
        url:'/Home/Products/getBuyRecordPage',
        dataType:'HTML',
        type:'GET',
        data:{
            gid:gid,
            p:num
        },
        success:function(msgObj){
            $("#con_tabs_3").html(msgObj);
            return false;
        }
    }); 
}
</script>
<script>
    $(function(){
        if("<?php echo ($buynums); ?>"){
            $('#show_sale_num').html("(" + "<?php echo (($buynums)?($buynums):0); ?>"+")");
        }
    });
</script>