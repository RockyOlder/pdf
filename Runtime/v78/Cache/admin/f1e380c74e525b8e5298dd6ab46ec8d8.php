<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
    <title><?php echo ($common_title); echo ($page_title); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="<?php echo ($common_keywords); ?>">
    <meta name="description" content="<?php echo ($common_desc); ?>">
    <link href="__PUBLIC__/Lib/jquery/css/base/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="__PUBLIC__/Lib/thinkbox/css/style.css">
    <script src="__PUBLIC__/Lib/jquery/js/jquery-1.8.3.js"></script>
    <script src="__PUBLIC__/Lib/jquery/js/jquery-ui-1.9.2.custom.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.validate.1.9.js"></script>
    <script src="__PUBLIC__/Lib/validate/jquery.metadata.js"></script>
    <script src="__PUBLIC__/Lib/validate/messages_cn.js"></script>
    <script src="__PUBLIC__/Admin/js/common.js"></script>
    <script src="__PUBLIC__/Common/js/global.js"></script>
    <link href="__PUBLIC__/Admin/css/global.css" rel="stylesheet">
    <!--[if IE 6]>
        <script type="text/javascript" src="__PUBLIC__/Admin/js/iepng.js"></script>
        <script type="text/javascript">
        EvPNG.fix("#pngImg,.sliderNavBox dl dd");
        </script>
    <![endif]-->
	<script>
        function U(url) {
            return ("__WEBROOT__"+url).replace('//','/'); 
        }
    </script>
</head>
	<?php if(!empty($_SESSION['OSS']['GY_OSS_PIC_URL']) || (!empty($_SESSION['OSS']['GY_OTHER_IP']) && !empty($_SESSION['OSS']['GY_OTHER_ON']) )){ ?>
    <input type="hidden" value="1" id="oss_id" />
   	<?php }else{ ?>
   	<input type="hidden" value="0" id="oss_id" />
   	<?php } ?>
	<?php if($_SESSION['OSS']['GY_QN_ON'] == '1'){ ?>
    <input type="hidden" value="1" id="qn_id" />
   	<?php }else{ ?>
   	<input type="hidden" value="0" id="qn_id" />
   	<?php } ?>
    <body class="mainBox">
        <div id="J_ajax_loading" class="ajax_loading">提交请求中，请稍候...</div>
        <div class="header">
            <!--顶部LOGO和导航-->
<div class="headerBox">
    <h1><a href="#"><img  id="pngImg" <?php if($admin_logo == '/Public/Admin/images/logo.png'): ?>src="__PUBLIC__/Admin/images/logo.png"<?php else: ?>src="<?php echo ($admin_logo); ?>"<?php endif; ?> width="195" height="70"/></a></h1>
    <ul>
        <?php if(is_array($tops)): $i = 0; $__LIST__ = $tops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top): $mod = ($i % 2 );++$i;?><li <?php if(($i) == $nav1): ?>class='on'<?php endif; ?> nav="<?php echo ($i); ?>"><a href="<?php echo ($top["url"]); ?>"><?php echo ($top["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
        </div><!-- header end -->
        <div id="tip_dialog">
            
        </div>
        <div class="contentBox">
            <div class="sidebar">
                <div class="sildebarBox">
                    <div class="sidebarMasg">
                        <h2><?php echo (L("TOP_HELLO")); ?><span><?php echo (session('admin_name')); ?></span></h2>
                        <ul>
                            <h3>待办事务</h3>
                            <li>
							<a href="<?php echo U('Admin/Orders/pageWaitDeliverOrdersList');?>" style="color:#fff;">待发货订单(<?php echo ($wtrade_num); ?>笔)</a>&nbsp;
							<a href="<?php echo U('Admin/Seo/deleteRedis');?>" style="float:right;color:#fff;">清空缓存</a>
							</li>
                        </ul>
                        <a href="###">&nbsp;</a>
                        <a href="<?php echo U('Home/Index/index');?>" target="_blank" class="sc" title="<?php echo (L("TOP_HOME")); ?>"><?php echo (L("TOP_HOME")); ?></a>
                        <a href="<?php echo U('Admin/User/doLogout');?>" class="out" title="<?php echo (L("TOP_LOGOUT")); ?>"><?php echo (L("TOP_LOGOUT")); ?></a>
                        <a href="<?php echo U('Admin/Index/index');?>" class="more" title="<?php echo (L("MORE")); ?>"><?php echo (L("MORE")); ?></a>
                        <a href="<?php echo U('Admin/System/pageEditAdminPasswd');?>" class="editpasswd" title="<?php echo (L("EDITPW")); ?>"><?php echo (L("EDITPW")); ?></a>
                        <a href="javascript:void(0);" data-uri='<?php echo U("Admin/Index/getMap");?>' class="map" id="GyMap" title="后台地图"></a>
                    
                    </div>   
            		
                    <!-- 侧导航开始 -->
                    <!--左侧导航-->
                    <div class="sliderNavBox" id="sliderNavBox">
                        
<div id="sliderNavBoxInner" style="display: block; overflow:visible;">
    <?php if(is_array($menus[$nav1])): $k = 0; $__LIST__ = $menus[$nav1];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu1): $mod = ($k % 2 );++$k; $mk = $key; ?>
        <h2><img class="title" <?php if(($nav2) == $key): ?>src="__PUBLIC__/Admin/images/silderNavIcoF.png"<?php else: ?>src="__PUBLIC__/Admin/images/silderNavIcoJ.png"<?php endif; ?> /><?php echo ($menu1[0]['name']); ?></h2>
        <dl <?php if(($nav2) != $key): ?>style="display: none;"<?php endif; ?> >
            <?php if(is_array($menu1)): $i = 0; $__LIST__ = $menu1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu2): $mod = ($i % 2 );++$i; if(($i) != "1"): ?><dd <?php if(($key == $nav3) and ($mk == $nav2)): ?>class="on"<?php endif; ?> ><a href="<?php echo ($menu2['url']); ?>"><?php echo ($menu2['name']); ?></a></dd><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </dl><?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="clear"></div>
</div>
                    </div>
                    
                    <!-- 侧导航结束 -->
                </div>
            </div><!-- 左侧结束 -->
            <!-- 中间内容开始 -->
            <div class="breadcrumb">
                <!--面包屑导航-->
<a href="<?php echo ($bread0["url"]); ?>"><?php echo ($bread0["name"]); ?></a>
 &nbsp;>&nbsp;
 <?php if(($bread1["name"]) != ""): ?><a href="<?php echo ($bread1["url"]); ?>"><?php echo ($bread1["name"]); ?></a><?php endif; ?>
 <?php if(($bread2["name"]) != ""): ?>&nbsp;>&nbsp;<a href="<?php echo ($bread2["url"]); ?>"><?php echo ($bread2["name"]); ?></a><?php endif; ?>
 <?php if(($bread3["name"]) != ""): ?>&nbsp;>&nbsp;<?php echo ($bread3["name"]); endif; ?>
            </div>
            <div class="content">
                <?php if($is_user_access == '1'){ ?>
                <div class="rightInner">
   
        <table width="100%" class="tbList">
            <thead>
                <tr class="title">
                <th colspan="<?php echo 14+count($fields); ?>">
<!--                    <p class="conOneP" style="float: left;">
                        <a href="javascript:void(0);" class="btnG ico_explort">导出Excel</a>
                    </p>                  -->
<!--					<span style="float:left;">
                        <select id="batch" onchange="doBatch()" class="medium" name="">
                            <option value="0">批量操作</option>
                            <option  value="1">批量分组</option>
                            <option  value="2">批量设置等级</option>
                            <option  value="3">批量审核</option>
                            <option  value="4">批量冻结</option>
                            <option  value="5">批量设置类型</option>
                        </select>
                    </span>-->
                    <span   style="margin-left:40px;float:left;text-align:right;font-size:12px;">
                        <form id="searchForm" method="get" action="<?php echo U('Admin/Members/pageList');?>">
                         会员ID：<input type="text" name="m_id" class="large" value="<?php echo ($filter["m_id"]); ?>" style="width: 145px;">
                         来源ID：<input type="text" name="open_source" class="large" value="<?php echo ($filter["open_source"]); ?>" style="width: 145px;">
                            <select id="" class="medium" name="m_name_type">
                                <option value="1" <?php if($filter['m_name_type'] == '1'){ ?>selected="selected"<?php } ?>>会员名称</option>
                                <option value="2" <?php if($filter['m_name_type'] == '2'){ ?>selected="selected"<?php } ?>>真实姓名</option>
                                <option value="3" <?php if($filter['m_name_type'] == '3'){ ?>selected="selected"<?php } ?>>手机号</option>								
                            </select>
                            <input type="text" name="m_name" class="large" value="<?php echo ($filter["m_name"]); ?>" style="width: 145px;">
                                <input type="submit" value="搜 索" class="btnHeader inpButton">
								<button type="button" id="admin-member-advance-search-button">高级搜索</button>	
                        </form>   
                    </span>
                  </th>
                </tr>
                 <form method="get" action="<?php echo U('Admin/Members/doDel');?>" id="members_del">
                <tr>
                    <th><input type="checkbox" class="checkAll" /></th>
                    <th>操&nbsp;&nbsp;作</th>
                    <th>会员Id</th>
                    <th>会员账号</th>
                    <th>会员ID</th>
                    <th>来源ID</th>
                    <th>首次登陆时间</th>
                    <th>首次充值时间</th>
                    <th>首次消费时间</th>
                    <th>周均转换文档数</th>
                    <th>已支付订单数</th>
                    <th>待支付订单数</th>
                    <th>退款订单数</th>
                    <th>累计充值金额</th>
                    <th>剩余可消费次数</th>
                    <?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?><th><?php echo ($field["field_name"]); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($ary_members)): $i = 0; $__LIST__ = $ary_members;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$members): $mod = ($i % 2 );++$i;?><tr id="list_<?php echo ($members["m_id"]); ?>">
                    <td><input type="checkbox" class="checkSon" name="m_id[]" value="<?php echo ($members["m_id"]); ?>" /></td>
                    <td>
                         <a href='<?php echo U("Admin/Members/PrepaidRecords?mid=$members[m_id]");?>'>充值记录</a>
<!--                        <a href='<?php echo U("Admin/Members/pageEdit?mid=$members[m_id]");?>'>编辑</a><br/>
                        <a href='<?php echo U("Admin/Members/doDel?m_id=$members[m_id]");?>' class="confirm">删除</a> <br/>
                        <a  href="<?php echo U("Admin/Members/addOrder");?>?m_id=<?php echo ($members[m_id]); ?>"   target="_blank"  class="confirm">替客户下单</a> -->
                       <!--  <a class="addOrder" m_id="<?php echo ($members[m_id]); ?>" url='<?php echo U("Admin/Members/addOrder");?>'  class="confirm">替客户下单</a>-->  
                    </td>
                    <td><?php echo ($members["m_id"]); ?></td>
                    <td><?php echo ($members["m_name"]); ?></td>
                    <td><?php echo ($members["source"]); ?></td>
                    <td>
                        <?php if($members[m_sex] == 0): ?>女
                        <?php elseif($members[m_sex] == 1): ?>男
                        <?php else: ?>保密<?php endif; ?>
                    </td>
                    <td><span><?php echo ($members["m_create_time"]); ?></span></td>
                    <td class="left"><span><?php echo ($members["ps_create_time"]); ?></span></td>
                    <td><span><?php echo ($members["member_authorization_time"]); ?></span></td>
                    <td>
                       <span> <?php echo ($members["member_count_conversion"]); ?></span>
                    </td>
                    <td ><?php echo ($members["member_order_pay"]); ?></td>
                    <td><?php echo ($members["member_order_Waiting_pay"]); ?></td>
                    <td><?php echo ($members["member_order_exit_pay"]); ?></td>
                    <td><?php echo ($members["m_all_cost"]); ?></td>
                    <td data-id="<?php echo ($members["m_id"]); ?>" id="deposit_<?php echo ($members["m_id"]); ?>"><?php echo ($members["number_remaining"]); ?></td>
					
<!--                    <?php if(is_array($members["fields"])): $i = 0; $__LIST__ = $members["fields"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?><td>
						<?php $is_exist = 0; if(stristr($field['content'],'.png') || stristr($field['content'],'.jpg') || stristr($field['content'],'.gif')){ $is_exist = 1; } ?>
						<?php if($is_exist == 1): ?><img src="<?php echo ($field["content"]); ?>" width="50px" height="50px"/>
						<?php else: ?>
						<?php echo ($field["content"]); endif; ?>
						</td><?php endforeach; endif; else: echo "" ;endif; ?>-->
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(empty($ary_members)): ?><tr><td colspan="99" class="left">暂时没有数据!</td></tr><?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="99"><input type="button" data-uri='<?php echo U("Admin/Members/doBatDelMembers");?>' data-field="m_id" value="删除选中" class="btnA confirm" id="delAll" /><span class="right page"><?php echo ($page); ?></span></td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div class="clear"></div>
    
    <div id="member_dialog" style="display:none;"></div>
    <input type="hidden" value="<?php echo ($filters); ?>" name="filter"/>
    <!--    分组弹框-->
    <div id="batch_group" title="请选择分组" style="display: none;">
          <table class="alertTable"  >
            <tr>
                <td align="right" width="75" valign="top">分组名称：</td>
                <td>
                    <select id="batch_group_val">
                        <option>请选择</option>
                        <?php if(is_array($group)): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mg): $mod = ($i % 2 );++$i;?><option value="<?php echo ($mg["mg_id"]); ?>"><?php echo ($mg["mg_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select> 
                </td>
            </tr>
        </table>
    </div>
    <!-- 弹框 -->
    <!--等级设置弹框-->
    <div id="batch_level" title="请选择等级" style="display: none;">
        <table class="alertTable"  >
            <tr>
                <td align="right" width="75" valign="top">等级名称：</td>
                <td>
                    <select id="batch_level_val">
                        <option>请选择</option>
                        <?php if(is_array($level)): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ml["ml_id"]); ?>"><?php echo ($ml["ml_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select> 
                </td>
            </tr>
        </table>
    </div>
    <!-- 会员类型设置弹框 -->
    <div id="batch_set_type" title="请选择会员类型" style="display: none;">
        <table class="alertTable"  >
            <tr>
                <td align="right" width="75" valign="top">会员类型：</td>
                <td>
                    <select id="batch_type_val" class="medium">
                        <option  value="0" >分销商类型</option>
                        <option  value="1" >普通类型</option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <!-- 弹框 -->
</div>
<style type="text/css">
.member-search span{height:18px;}
.member-search label{cursor:pointer;vertical-align:middle;}
.member-search input[type='checkbox']{cursor:pointer;vertical-align:middle;}
.first-td{width:90px;text-align:right;}
.member-advance-search td{line-height: 100%;padding:3px;}
</style>
<div id="member-advance-search-dialog" style="width:700px;display:none;" class="member-search">
<form action="<?php echo U('Admin/Members/pageList');?>" method="GET" id="admin-member-advance-search-form">
	<table class="member-advance-search" style="width:100%">
		<tr>
			<td class="first-td">会员帐号：</td>
			<td>
				<input type="text" name="advance_search[m_name]" value="<?php echo (($filter["m_name"])?($filter["m_name"]):''); ?>" class="large" />
			</td>
		</tr>
		<tr>
			<td class="first-td">真实姓名：</td>
			<td>
				<input type="text" name="advance_search[m_real_name]" value="<?php echo (($filter["m_real_name"])?($filter["m_real_name"]):''); ?>" class="large" />
			</td>
		</tr>
		<tr>
			<td class="first-td">状态：</td>
			<td>
				<table>
					<tr>
						<td>
							<input type="checkbox" name="advance_search[m_verify][]" value="0" id="advance_search_m_verify_0" />
							<label for="advance_search_m_verify_0">未审核</label>
						</td>
						<td>
							<input type="checkbox" name="advance_search[m_verify][]" value="1" id="advance_search_m_verify_1" />
							<label for="advance_search_m_verify_1">审核中</label>
						</td>
						<td>
							<input type="checkbox" name="advance_search[m_verify][]" value="2" id="advance_search_m_verify_2" />
							<label for="advance_search_m_verify_2">审核通过</label>
						</td>
						<td>
							<input type="checkbox" name="advance_search[m_verify][]" value="3" id="advance_search_m_verify_3" />
							<label for="advance_search_m_verify_3">审核不通过</label>
						</td>
						<td>
							<input type="checkbox" name="advance_search[m_status]" value="1" id="advance_search_m_status" />
							<label for="advance_search_m_status">已冻结</label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- 会员高级搜索 会员等级搜索开始 -->
		<?php $array_member_levels = D('MembersLevel')->where(array("ml_status"=>1))->order(array('ml_order'=>'desc'))->select(); if(is_array($array_member_levels) && !empty($array_member_levels)){ ?>
		<tr>
			<td class="first-td">会员等级：</td>
			<td>
				<table>
				<?php foreach($array_member_levels as $key=>$val){ if($key != 1 && ($key == 0 || $key%4 == 1)){echo '<tr>';} ?>
				<td>
					<input type="checkbox" name="advance_search[ml_id][]" value="<?php echo $val['ml_id']; ?>" id="advance_search_ml_id_<?php echo $val['ml_id']; ?>" />
					<label for="advance_search_ml_id_<?php echo $val['ml_id']; ?>"><?php echo $val['ml_name']; ?></label>
				</td>
				<?php if($key > 0 && $key%4 == 0){echo '</tr>';} } ?>
				</table>
			</td>
		</tr>
		<?php } ?>
		<!-- 会员高级搜索 会员等级搜索结束 -->
		
		<!-- 会员高级搜索 会员所属平台搜索开始 -->
		<?php $source_platform = D('SourcePlatform')->where(array("sp_stauts"=>1))->order(array('sp_id'=>'asc'))->select(); if(is_array($source_platform) && !empty($source_platform)){ ?>
		<tr>
			<td class="first-td">来源平台：</td>
			<td>
				<table>
				<?php foreach($source_platform as $key=>$val){ if($key != 1 && ($key == 0 || $key%4 == 1)){echo '<tr>';} ?>
				<td>
					<input type="checkbox" name="advance_search[sp_id][]" value="<?php echo $val['sp_id']; ?>" id="advance_search_sp_id_<?php echo $val['sp_id']; ?>" />
					<label for="advance_search_sp_id_<?php echo $val['sp_id']; ?>"><?php echo $val['sp_name']; ?></label>
				</td>
				<?php if($key > 0 && $key%4 == 0){echo '</tr>';} } ?>
				</table>
			</td>
		</tr>
		<?php } ?>
		<!-- 会员高级搜索 会员所属平台搜索结束 -->
		
		<!-- 会员高级搜索 会员组搜索开始 -->
		<?php $array_member_groups = D('MembersGroup')->where(array("mg_status"=>1))->order(array('mg_id'=>'asc'))->select(); if(is_array($array_member_groups) && !empty($array_member_groups)){ ?>
		<tr>
			<td class="first-td">所属组：</td>
			<td>
				<table>
				<?php foreach($array_member_groups as $key=>$val){ if($key != 1 && ($key == 0 || $key%4 == 1)){echo '<tr>';} ?>
				<td>
					<input type="checkbox" name="advance_search[mg_id][]" value="<?php echo $val['mg_id']; ?>" id="advance_search_mg_id_<?php echo $val['mg_id']; ?>" />
					<label for="advance_search_mg_id_<?php echo $val['mg_id']; ?>"><?php echo $val['mg_name']; ?></label>
				</td>
				<?php if($key > 0 && $key%4 == 0){echo '</tr>';} } ?>
				</table>
			</td>
		</tr>
		<?php } ?>
		<!-- 会员高级搜索 会员组搜索结束 -->
		<tr>
			<td class="first-td">结余款：</td>
			<td>
				<input type="text" name="advance_search[m_balance_min]" value="" class="input40" />
				-
				<input type="text" name="advance_search[m_balance_max]" value="" class="input40" />
			</td>
		</tr>
		<tr>
			<td class="first-td">积分：</td>
			<td>
				<input type="text" name="advance_search[total_point_min]" value="" class="input40" />
				-
				<input type="text" name="advance_search[total_point_max]" value="" class="input40" />
			</td>
		</tr>
		<tr>
			<td class="first-td">性别：</td>
			<td>
				<table>
					<tr>
						<td>
							<input type="checkbox" name="advance_search[m_sex][]" value="0" id="advance_search_m_sex_0" />
							<label for="advance_search_m_sex_0">女</label>
						</td>
						<td>
							<input type="checkbox" name="advance_search[m_sex][]" value="1" id="advance_search_m_sex_1" />
							<label for="advance_search_m_sex_1">男</label>
						</td>
						<td>
							<input type="checkbox" name="advance_search[m_sex][]" value="2" id="advance_search_m_sex_2" />
							<label for="advance_search_m_sex_2">保密</label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="first-td">注册时间：</td>
			<td>
				<input type="text" name="advance_search[m_create_time_start]" value="" class="medium timer" />
				-
				<input type="text" name="advance_search[m_create_time_end]" value="" class="medium timer" />
			</td>
		</tr>
		<!--
		<tr>
			<td class="first-td">最后登录时间：</td>
			<td>
				<input type="text" name="advance_search[total_point_min]" value="" class="input40" />
				-
				<input type="text" name="advance_search[total_point_max]" value="" class="input40" />
			</td>
		</tr>
		-->
		<input type="hidden" id="filter" name="filter" value="" />
	</table>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#admin-member-advance-search-button").click(function(){
		$("#member-advance-search-dialog").dialog({
			title:'会员资料高级搜索',
			width:'720',
			height:'auto',
			modal: true,
			buttons:{
				'搜索':function(){
					var data = $("#admin-member-advance-search-form").serializeArray();
					data = JSON.stringify(data);
					$('#filter').val(data);
					$("#admin-member-advance-search-form").submit();
				},
				'重置':function(){
					$("#admin-member-advance-search-form").find("input[type='text']").val("");
					$("#admin-member-advance-search-form").find("input[type='checkbox']").attr({"checked":false});
				},
				'取消':function(){
					$(this).dialog("close");
				}
			}
		});
	});
});
</script>
<script type="text/javascript">
    var old_deposit = '';
    function doBatch(){
        var batecVal = $("#batch").val();
        var m_ids = new Array();
        $(".tbList input:checked[class='checkSon']").each(function(){
            m_ids.push(this.value);
        });
        m_id = m_ids;
        m_ids = m_ids.join(",");
        if(m_ids == ''){
            alert("请选择需要操作的会员！");
            return false;
        }
        //批量分组
        if(batecVal == 1){
             $("#batch_group").dialog({
                height:200,
                width:300,
                resizable:false,
                modal:true,
                title:'批量会员分组',
                close:function(){
                    $("#batch_group").dialog('destroy');
                },
                buttons: {
                    '添加': function() {
                        var data = { 'mg_id':$("#batch_group_val").val(),'m_id':m_ids};
                        var url = "<?php echo U('Admin/Membergroup/doBacthGroup');?>";
                        $.post(url,data,function(info){
                            if(info=="false"){
                                showAlert(false,'出错了','归组失败');
                            }else{
                                showAlert(true,'成功');
                            }
                        });
                        $( this ).dialog( "close" );
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        //批量设置等级
        if(batecVal == 2){
            $("#batch_level").dialog({
                height:200,
                width:300,
                resizable:false,
                modal:true,
                title:'批量设置等级',
                close:function(){
                    $("#batch_level").dialog('destroy');
                },
                buttons: {
                    '添加': function() {
                        var data = { 'ml_id':$("#batch_level_val").val(),'m_id':m_ids};
                        var url = "<?php echo U('Admin/Memberlevel/doBacthLevel');?>";
                        $.post(url,data,function(info){
                            if(info=="false"){
                                showAlert(false,'设置失败');
                            }else{
                                showAlert(true,'成功');
                            }
                        });
                        $( this ).dialog( "close" );
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        //批量审核
        if(batecVal == 3){
            if(!confirm('你确定要批量审核吗？')){
                return false;
            }
            var url = "<?php echo U('Admin/Members/doBacthMembers');?>";
            $.post(url,{'m_id':m_ids,'type':'verify'},function(data){
                if(data==true){
                    showAlert(true,'成功');
                }else {
                    showAlert(false,'失败');
                }
            });
        }
        //批量审核
        if(batecVal == 4){
            if(!confirm('你确定要批量冻结吗？')){
                return false;
            }
            var url = "<?php echo U('Admin/Members/doBacthMembers');?>";
            $.post(url,{'m_id':m_ids,'type':'freeze'},function(data){
                if(data==true){
                    showAlert(true,'成功');
                }else {
                    showAlert(false,'失败');
                }
            });
        }

        //批量设置会员类型
        if(batecVal == 5){
            $("#batch_set_type").dialog({
                height:200,
                width:300,
                resizable:false,
                modal:true,
                title:'批量设置会员类型',
                close:function(){
                    $("#batch_set_type").dialog('destroy');
                },
                buttons: {
                    '添加': function() {
                        var data = { 'm_type':$("#batch_type_val").val(),'m_id':m_ids};
                        var url = "<?php echo U('Admin/Members/doBacthSetype');?>";
                        $.post(url,data,function(resMsg){
                            showAlert(resMsg.status,resMsg.info);
                        });
                        $( this ).dialog( "close" );
                    },
                    '取消': function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
   
    }

    $(document).ready(function(){
        $('td[id^=deposit]').bind({'dblclick':function(){
            old_deposit = $(this).text();
            $(this).html('<input type="text" name="deposit" value="" id="operate_'+$(this).attr('data-id')+'" style="width:50px;" >');
            $(this).find('input').focus();
        }});
        $('input[id^=operate]').live('blur',function(){
            var operate_dom = $(this);
            var m_id = $(this).parent().attr('data-id');
            var deposit = $(this).val();
            if(typeof deposit == 'undefined' || deposit == ''){
                alert('请填写金额');
                $(this).focus();
                return false;
            }
            $.ajax({
                url:"<?php echo U('Admin/Members/exchangeDeposit');?>",
                cache:false,
                dataType:"json",
                data: {mid:m_id,deposit:deposit},
                type:"POST",
                beforeSend:function(){
                    $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
                },
                error:function(){
                    $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
                    operate_dom.parent().html(parseFloat(old_deposit));
                },
                success:function(msgObj){
                    $("#J_ajax_loading").hide();
                    if(msgObj.status == '2'){
                        $("#J_ajax_loading").addClass('ajax_success').html(msgObj.info).show().fadeOut(5000);
                        var total = parseFloat(old_deposit)+parseFloat(msgObj.data);
                        operate_dom.parent().html(total);
                    }else{
                        $("#J_ajax_loading").removeClass("ajax_success").addClass('ajax_error').html(msgObj.info).show().fadeOut(5000);
                        operate_dom.parent().html(parseFloat(old_deposit));
                    }
                }
            });
        });

        $(".synMembers").live('click',function(){
            var url = $(this).attr("data-uri");
            var field = $(this).attr('data-field');
            var val   = $(this).attr('data-id');
            var name = $(this).attr("data-name");
            $.ajax({
                url:url,
                cache:false,
                dataType:"json",
                data: {id:val, field:field,'name':name},
                type:"POST",
                beforeSend:function(){
                    $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
                },
                error:function(){
                    $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
                },
                success:function(msgObj){
                    $("#J_ajax_loading").hide();
                    if(msgObj.status == '1'){
                        $("#J_ajax_loading").addClass('ajax_success').html(msgObj.info).show().fadeOut(5000);
                        var strHtml = '';
                        strHtml += '<span style="color:green;">已同步</span>';
                        $("#syn_"+val).html(strHtml);
                    }else{
                        $("#J_ajax_loading").removeClass("ajax_success").addClass('ajax_error').html(msgObj.info).show().fadeOut(5000);
                    }
                }
            });
        });
        
        $("#delAll").live("click",function(){
            var m_ids = new Array();;
            $(".tbList input:checked[class='checkSon']").each(function(){
                m_ids.push(this.value);
            });
            m_id = m_ids;
            m_ids = m_ids.join(",");
            if(m_ids == ''){
                $("#J_ajax_loading").addClass('ajax_error').html("请选择需要删除的会员！").show().fadeOut(5000);
                return false;
            }
            var url = $(this).attr("data-uri");
            var field = $(this).attr('data-field');
            $.ajax({
                url:url,
                cache:false,
                dateType:'json',
                type:'POST',
                data:{field:field,m_ids:m_ids},
                beforeSend:function(){
                    $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
                },
                error:function(){
                    $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误！").show().fadeOut(5000);
                },
                success:function(msgObj){
                    $("#J_ajax_loading").hide();
                    if(msgObj.status == '1'){
                        $.each(m_id,function(index,value){
                            $("#list_"+value).remove();
                        });
                        $("#J_ajax_loading").addClass('ajax_success').html(msgObj.info).show().fadeOut(5000);
                    }else{
                        $("#J_ajax_loading").addClass('ajax_error').html(msgObj.info).show().fadeOut(5000);
                    }
                }
            });
        });
        
        //替会员下单 wangguibin
        $(".addOrder").live("click",function(){
			var m_id = $(this).attr('m_id');
			var url = $(this).attr('url');
            $.ajax({
                url:url,
                cache:false,
                dataType:"json",
                data: {m_id:m_id},
                type:"POST",
                error:function(){
                   showAlert(false,'失败，未知错误');
                   return;
                },
                success:function(msgObj){
                    window.open("/Products")
                }
            });
        });  
        
        //导出Excel yangkewei
        $('.ico_explort').click(function(){
            //弹出对话框，确认导出成员对象
            $.ajax({
                url      : '<?php echo U('Admin/Members/getMembersDialog');?>',
                cache    : false,
                dataType : 'HTML',
                data     : {},
                type     : 'POST',
                success  : function(msgObj){
                    $('#member_dialog').html(msgObj);
                    $('#member_dialog').dialog({
                        height : '305',
                        width  : '300',
                        resizable:false,
                        title:'会员导出',
                        buttons:{
                            '确认' : function(){
                                $('#member_dialog').dialog('destroy');      //先关闭对话框
                                m_ids = setMids();                          //通过单选获取m_ids的值
                                explor(m_ids);                              //将成员值以Excel格式导出
                            },
                            '取消' : function(){
                                $('#member_dialog').dialog('destroy');
                            }
                        },
                        close:function(){
                            $('#member_dialog').dialog('destroy');
                        }
                    });
                }
            });  
        });
    });
    //将成员值以Excel格式导出
    function explor(m_ids){
		var select_type = $('.tbForm input[type="radio"]:checked').val();
        if(m_ids==''){
            alert('请勾选您要导出的数据！');
            return false;
        }else{
            $.ajax({
                url      : '<?php echo U("Admin/Members/explortMembersInfo");?>',
                cache    : false,
                dataType : 'json',
                data     : {m_ids:m_ids,type:select_type},
                type     : 'POST',
                success  : function(msgObj){
                    if(msgObj.status == '1'){
                        var url = '<?php echo U('Admin/Members/getExportFileDownList');?>'+'?type=excel&file='+msgObj.data;
                        window.location.href = url;
                        return false;
                    }else{
                        alert(msgObj.info);
                        return false;
                    }
                }
            });
        }
    }
    //通过对话框选中对象获取相应的类型
    function setMids(){
        //获取Radio的值
        var select_type = $('.tbForm input[type="radio"]:checked').val();
		var start = parseInt($("#members_start").val());
		var end = parseInt($("#members_end").val());
        //初始化m_ids的值为选中成员
        var m_ids = new Array();;
        $(".tbList input:checked[class='checkSon']").each(function(){
            m_ids.push(this.value);
        });
        m_ids = m_ids.join(',');
        switch(parseInt(select_type)){
			case 0:
				if(start <= 0){
					alert("输入有误请重新输入");return false;
				}
				if(end <= 0){
					alert("输入有误请重新输入");return false;
				}
				return start+'-'+end;break;
            case 1 : return m_ids;break;
            case 2 : return 'ALL';break;
            case 3 : return $('input[name="filter"]').val();break;
            default: return m_ids;
        }
    }	
</script>

                <?php } ?>

                <?php if($is_user_access != 1): ?>您无权限访问此页。<?php endif; ?>
            </div>
            <!--<div class="fav-nav" style="background: url('__PUBLIC__/Admin/images/fav-nav-bg.png') repeat-x scroll left top transparent;height: 28px;line-height: 28px;">-->
			<div class="fav-nav" style="height: 28px;line-height: 28px;">               
			   <div style="text-align: center; width: 100%;" id="index_footer_text">版权所有 上海管易云</div>
                <div id="panellist"></div>
                <div id="paneladd"></div>
                <input type="hidden" id="menuid" value="">
                <input type="hidden" id="bigid" value="" />
                <div id="help" class="fav-help"></div>
            </div>
        </div>
        <!--后台页脚-->
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-sliderAccess.js"></script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-timepicker-addon.js"></script>
<script src="__PUBLIC__/Lib/jquery/js/jquery-ui-timepicker-zh-CN.js"></script>

        <!--弹出框-->
<div id="alert" style="display: none;" title="系统提示">
    <table width="100%">
        <tr>
            <td style="padding:5px; vertical-align: top;"><div id="alert_face" class=""></div></td>
            <td style="padding:5px; vertical-align: top;">
                <div id="alert_title">提示标题</div>
                <div id="alert_msg">提示内容</div>
            </td>
        </tr>
    </table>
</div>
<!--End of 弹出框-->
        <div style="width: 0px; height: 0px; overflow: hidden; visibility: hidden; clear: both;">
    <audio id="reader" src="" autoplay="autoplay" onended="javascript:void(0);" onemptied="javascript:void(0);" onerror="javascript:void(0);" />
</div>
		<script type="text/javascript">
			//load();
			function load(){
				$.ajax({
				    url:'<?php echo U("Script/Batch/ajaxAsynchronous");?>',//请求的url地址 
					type:"post", //请求的方式 
					dataType:"json", //数据的格式
					data:{}, //请求的数据 
					success:function(data){ //请求成功时，处理返回来的数据 
						
					} 
				})
			}
			/**
            var footer_text = '';
            var footer_text_index = 0;
            function footerTextWaveEffect(){
                var str = footer_text;
                var array_text = str.split('');
                for(var i =0;i<array_text.length;i++){
                    if(i == footer_text_index){
                        array_text[i] = '<span style="color:#ff0000;font-size:18px;">' + array_text[i] + '</span>';
                    }
                }
                $("#index_footer_text").html(array_text.join(''));
                footer_text_index ++ ;
                if(array_text[footer_text_index] == ' '){
                    footer_text_index ++;
                }
                if(footer_text_index >= array_text.length){
                    footer_text_index = 0;
                }
            }
            //默认页面加载
            $(document).ready(function(){
                footer_text = $("#index_footer_text").html();
                setInterval("footerTextWaveEffect()",350);
            });
			**/
		</script>
<!--         <script type="text/javascript" src="alires://MsgHistory/unknownurl.pnghttp://g.tbcdn.cn/sj/securesdk/0.0.3/securesdk_v2.js" id="J_secure_sdk_v2" data-appkey="12541234"></script> -->
    </body>
</html>