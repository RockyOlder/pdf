<?php if (!defined('THINK_PATH')) exit();?>
<?php if(empty($page_detail["gid"])): ?>商品已下架或不存在<?php die(); endif; ?>						
<?php if(is_array($page_detail["ary_goods_spec_list"])): $k = 0; $__LIST__ = $page_detail["ary_goods_spec_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_spec): $mod = ($k % 2 );++$k;?><li class="spec_list" style="list-style:none">
		<dl>
			<dt><?php echo ($goods_spec["gs_name"]); ?>：</dt>
			<dd id="sku<?php echo ($goods_spec["gs_id"]); ?>_<?php echo ($k); ?>">
				<?php if(is_array($goods_spec["gs_details"])): $gskk = 0; $__LIST__ = $goods_spec["gs_details"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gs_detail): $mod = ($gskk % 2 );++$gskk; $gsd_type = 'text'; $va = strpos($gs_detail['gsd_value'],'|'); if($va){ $gsdinfos = explode('|', $gs_detail['gsd_value']); $gsd_value = $gsdinfos[0]; $gsd_info = $gsdinfos[1]; $gsd_type = 'img'; }else{ $gsd_value = $gs_detail['gsd_value']; } ?>
					<a href="javascript:void (0);" onclick="specSelect(this,'on');" name="<?php echo ($gsd_value); ?>" data-value="<?php echo ($gs_detail["gsd_id"]); ?>"
                        <?php if($gsd_type == 'img'): ?>style="height:30px;"<?php endif; ?>
                        >
                        <?php if($gsd_type == 'img'): ?><img src="<?php echo (C("DOMAIN_HOST")); echo ($gsd_info); ?>" width="30" height="30" title="<?php echo ($gsd_name); ?>"/>
                            <?php else: ?>
                            <?php echo ($gsd_value); endif; ?>
					</a><?php endforeach; endif; else: echo "" ;endif; ?>
			</dd>
		</dl>
	</li><?php endforeach; endif; else: echo "" ;endif; ?>
	<ul>
		<li class="num">
			<dl>
				<dt>数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;量</dt>
				
				<dd>
					<span class="span01"><input type="text" id="item_num" name="num" value="1" onblur="if (value == '') {value = '1'}" max="<?php echo (($max_buy_number)?($max_buy_number):0); ?>" value="1" onfocus="if (value == '1') {value = ''}"></span>
					<span class="span02"><a href="javascript:void(0);" class="a01" onclick="countNum(1)"></a>
					<a href="javascript:void(0);" class="a02" onclick="countNum( - 1)"></a></span>件&nbsp;&nbsp;&nbsp;
					库存:
					<?php if($stock_data['OPEN_STOCK'] == 1 and $stock_data['level'] != '' ): if($page_detail['gstock'] <= 0): ?><label><strong style='color:red' id="showNum">缺货</strong></label>
						<?php elseif($page_detail['gstock'] > 0 && $page_detail['gstock'] <= $stock_data['STOCK_NUM']): ?>
						<label><strong style='color:red' id="showNum">供货紧张</strong></label>
						<?php elseif($page_detail['gstock'] > $stock_data['STOCK_NUM']): ?>
						<label><strong style='color:green' id="showNum">充足</strong></label><?php endif; ?>
					<?php else: ?>
						<label id="showNum"><?php echo ($page_detail["gstock"]); ?></label><?php endif; ?>
					<input type="hidden" value="0" id="is_global_stock" />
					<input type="hidden" name="type" value="item" id="item_type" />
					<input type="hidden" name="open_stock" value="<?php echo ($stock_data["OPEN_STOCK"]); ?>" id="open_stock" />
					<input type="hidden" name="stock_num" value="<?php echo ($stock_data["STOCK_NUM"]); ?>" id="stock_num" />
					<input type="hidden" name="stock_level" value="<?php echo ($stock_data['level']); ?>" id="stock_level" />
					<input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_id"]); ?>" name="pdt_id" id="pdt_id" />
					<input type="hidden" value="<?php echo ($page_detail["ary_goods_default_pdt"]["pdt_stock"]); ?>" name="pdt_stock" id="pdt_stock" />
					<input type="hidden" value="<?php echo (($max_buy_number)?($max_buy_number):0); ?>" name="max_buy_number" id="max_buy_number" />
				</dd><div style="clear:both"></div>
				
				<div class="other-lk">
					<div id="ckepop" style="float:left;margin-top:20px;margin-left:10px">
						<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
						<span class="jiathis_txt" style="font-family:\5b8b\4f53;">分享：</span>
					</div>
					<div style="float:left;margin-top:18px;margin-left:20px;">
					<i style="display:block;float:left;" class="icon icon-size-9-24 icon-get"></i>
					<a href="javascript:addToInterests('<?php echo ($page_detail[gid]); ?>');" style="display:block;float:left;margin-top:2px">收藏商品</a>
					</div>
				</div>
				<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
			</dl>
		</li>
	</ul>

<script type="text/javascript" src="__JS__goodsDetailSku.js"></script>
<script type="text/javascript">
    var fuzzy_stock_open = parseInt('<?php echo ($stock_data["OPEN_STOCK"]); ?>');
    var fuzzy_stock_level = parseInt('<?php echo ($stock_data["level"]); ?>');

    var warning_stock_num = parseInt("<?php echo ($stock_data['STOCK_NUM']); ?>");
    var json_goods_pdts = JSON.parse('<?php echo (json_encode($page_detail["json_goods_pdts"])); ?>');

    var max_buy_number = parseInt('<?php echo (($max_buy_number)?($max_buy_number):0); ?>');
    //console.log(json_goods_pdts);
    //页面初始化操作
    getPdtBySpecSelect('on');

</script>