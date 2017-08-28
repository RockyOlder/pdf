<?php if (!defined('THINK_PATH')) exit();?>
<option value="-1" selected="selected">请选择</option>
<?php if(is_array($cityRegion)): $i = 0; $__LIST__ = $cityRegion;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cr): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cr["cr_id"]); ?>"><?php echo ($cr["cr_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>