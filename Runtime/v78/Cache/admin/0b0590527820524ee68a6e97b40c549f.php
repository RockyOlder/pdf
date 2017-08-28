<?php if (!defined('THINK_PATH')) exit();?>
<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
        <td><input type="radio" class="checkSon" name="mid" value="<?php echo ($list["m_id"]); ?>" m_conversion_types="<?php echo ($list["conversion_types"]); ?>" m_bce="<?php echo ($list["m_balance"]); ?>" m_conversion_type="<?php echo ($list["conversion_type"]); ?>" m_time="<?php echo ($list["end_time"]); ?>"  m_number="<?php echo ($list["number_remaining"]); ?>" m_name="<?php echo ($list["m_name"]); ?>"/></td>
        <td style="text-align: left;">
            <a href="javascript:void(0);" title="<?php echo ($list["m_name"]); ?>"><?php echo ($list["m_names"]); ?></a>
        </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
<!--<tr>
    <td colspan="2">
        <input type="button" class="btn" name="besure" value="确定" style="background: #cecece;border: 1px solid #cecece;padding: 3px 10px;cursor: pointer;"/>
        <input type="button" class="btn" name="cancel" value="取消" style="background: #cecece;border: 1px solid #cecece;padding: 3px 10px;cursor: pointer;"/>
    </td>
</tr>-->
<script>
$(document).ready(function(){
    $("input[name='besure']").click(function(){
        var m_id = $("#memberList input:radio[name='mid']:checked").val();
        if(m_id == null ){
            alert("请选中一个");return false;
        }
        var m_name = $("#memberList input:radio[name='mid']:checked").attr("m_name");
        var m_bce = $("#memberList input:radio[name='mid']:checked").attr("m_bce");

        $("#members").html("[ "+m_name+" ]");
        $("#m_id").val(m_id);
        // $("#bi_balance_money").attr("validate",'{ required:true,min:0,remote:"/Admin/BalanceInfo/checkBalanceMoney?id='+m_id+'",messages:{min:"金额不能为负数"}}');
        $(".bi_moneys").attr("validate",'{ required:true,min:0,messages:{min:"金额不能为负数"}}');
//       $("#balance").html(m_bce);

        $("#memberBalan").show();
        $("#member_dialog").dialog('destroy');
        $('#tip_dialog').append($('#member_dialog'));
    });

    $("input[name='cancel']").click(function(){
        $("#member_dialog").dialog('destroy');
        $('#tip_dialog').append($('#member_dialog'));
    });
});
</script>