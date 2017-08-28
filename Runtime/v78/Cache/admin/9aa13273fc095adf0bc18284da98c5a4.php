<?php if (!defined('THINK_PATH')) exit();?>
<table class="table_map" style="width: 900px;">
    <tbody>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
            <th align="center" style="width: 70px;"><a href="<?php echo ($val['url']); ?>"  data-id="<?php echo ($val["id"]); ?>"><?php echo ($val["name"]); ?></a></th>
            <td>
                <table class="table_map_sub">
                    <tbody>
                    <?php if(isset($val['sub'])): if(is_array($val['sub'])): $i = 0; $__LIST__ = $val['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sval): $mod = ($i % 2 );++$i;?><tr>
                                <th style="width: 100px;"><?php echo ($sval['name']); ?></th>
                                <td>
                            <?php if(isset($sval['sub'])): if(is_array($sval['sub'])): $i = 0; $__LIST__ = $sval['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ssval): $mod = ($i % 2 );++$i;?><a href="<?php echo ($ssval['url']); ?>"  data-id="<?php echo ($ssval["id"]); ?>"><?php echo ($ssval['name']); ?></a><?php endforeach; endif; else: echo "" ;endif; endif; ?>

                            </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </tbody>
                </table>
            </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</tbody>
</table>