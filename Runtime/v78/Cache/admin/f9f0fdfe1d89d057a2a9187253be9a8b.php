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
    <form id="promotion_add" name="promotion_add" method="post" action="<?php echo U('Admin/Promotions/doProAdd');?>">
        <table class="tbForm" width="100%">
            <thead>
                <tr class="title">
                    <th colspan="99">新建促销活动</th>
                </tr>
            </thead>
            <tbody class="tab">
                <tr>
                    <th colspan="99">促销基本信息</th>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 规则名称</td>
                    <td>
                        <input type="text" name="pmn_name" value="" class="large" validate="{ required:true,maxlength:30}" />
                    </td>
                    <td class="last">建议不超过30个字</td>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 优先级</td>
                    <td>
                        <select name="pmn_order" class="medium" id="pmn_order" validate="{ selected:true}" >
                            <option value="">请选择</option>
                            <?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$od): $mod = ($i % 2 );++$i;?><option value="<?php echo ($od["num"]); ?>" <?php if(($od["pmn_id"]) != "0"): ?>disabled="disabled"<?php endif; ?> >
                                    <?php echo ($od["num"]); if(($od["pmn_id"]) != "0"): ?>-- 已被<?php echo ($od["pmn_activity_name"]); ?> - <?php echo ($od["pmn_name"]); ?>使用<?php endif; ?>
                                </option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <input type="checkbox" id="showDisableOrder" checked="checked" /> 
                        <label for="showDisableOrder">显示已占用</label>
                    </td>
                    <td class="last">数值越大越被优先使用。为避免发生冲突，每个优先级仅能被一个活动规则占用</td>
                </tr>
                <tr>
                    <td class="first">是否启用</td>
                    <td>
                        <input type="radio" name="pmn_enable" value="1" checked="checked" /> 启用
                        <input type="radio" name="pmn_enable" value="0" /> 停用 </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 促销开始时间</td>
                    <td>
                        <input type="text" class="medium timer" name="pmn_start_time" id="pmn_start_time" validate="{required:true}"/>
                    </td>
                    <td class="last"></td>
                </tr>
                <tr>
                    <td class="first"><span class="red">*</span> 促销结束时间</td>
                    <td>
                        <input type="text" class="medium timer" name="pmn_end_time" id="pmn_end_time" validate="{required:true}"/>
                    </td>
                    <td class="last"></td>
                </tr>
                
<tr>
    <td class="first"><span class="red">*</span> 促销对象</td>
    <td>
        <input type="radio" class="ra_all" name="ra_all" value="1" <?php if(($mAll) == "1"): ?>checked="checked"<?php endif; ?> /> 全部会员
        <input type="radio" class="ra_all" name="ra_all" value="0" <?php if(($mAll) == "0"): ?>checked="checked"<?php endif; ?> /> 部分会员
    </td>
</tr>
<tr class="raMember <?php if(($mAll) == "1"): ?>none<?php endif; ?>">
    <td class="first ">会员组</td>
    <td>
        <?php if(is_array($mGroups)): $i = 0; $__LIST__ = $mGroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mg): $mod = ($i % 2 );++$i;?><input type="checkbox" class="checkedMeInfo" name="ra_mg[]" value="<?php echo ($mg["mg_id"]); ?>" <?php if(($mg["checked"]) == "1"): ?>checked="checked"<?php endif; ?>  /> <?php echo ($mg["mg_name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
    </td>
</tr>
<tr class="raMember  <?php if(($mAll) == "1"): ?>none<?php endif; ?>">
    <td class="first ">会员等级</td>
    <td>
        <?php if(is_array($mLevels)): $i = 0; $__LIST__ = $mLevels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><input type="checkbox" class="checkedMeInfo" name="ra_ml[]" value="<?php echo ($ml["ml_id"]); ?>" <?php if(($ml["checked"]) == "1"): ?>checked="checked"<?php endif; ?> /> <?php echo ($ml["ml_name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
    </td>
</tr>
<tr class="raMember <?php if(($mAll) == "1"): ?>none<?php endif; ?>">
    <td class="first" style="vertical-align:top">指定会员</td>
    <td>
        <div class="searching">
            <input  type="text" name="memberName"  onblur="memberSearch()"  id="memberName"  class="medium" />
            <a href="javascript:void(0);" onclick="addMember();" class="btnB">添加</a>
            <a href="javascript:void(0);" id="add_batch_members" class="btnB">批量添加会员</a>
            <!--    弹框-->
            <div id="batch_members" title="请输入会员" style="display: none;">
                  <table class="alertTable"  >
                    <tr>
                        <td align="right" width="75" valign="top">会员名称：</td>
                        <td>
                            <textarea id="batch_names_textarea" class="mediumBox"></textarea>
                            <p class="gray6">添加多个会员时，可通过逗号，空格和换行形式输入；</p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- 弹框 -->
            <ul id="m_name_li" style="display:none">

            </ul>
        </div>

        <table class="addBorder tbList" style="margin:8px 0px;">
            <thead>
                <tr>
                    <th><input type="checkbox" class="checkAll" /></th>
                    <th>会员名称</th>
                    <th>会员等级</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="raMemberId">
                 
<?php if(is_array($mIds)): $i = 0; $__LIST__ = $mIds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$member): $mod = ($i % 2 );++$i; if($member["m_name"] != ''): ?><tr id="tr_members_<?php echo ($member["m_id"]); ?>">	
            <td><input class="checkSon"  name="check_members"  type="checkbox" /></td>
            <input type="hidden"  name="ra_mid[]" id="<?php echo ($member["m_id"]); ?>"  value="<?php echo ($member["m_id"]); ?>">
            <td class="m_names"><?php echo ($member["m_name"]); ?></td>
            <td ><?php echo ($member["ml_name"]); ?></td>
            <td><a href="javascript:void(0);" onclick="delMember($(this));" class="blue">删除</a></td>
        </tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>


            </tbody>
        </table>
        <input type="button" class="btnA" onclick="batchDelMember()" value="批量删除" />
    </td>
</tr>
<script type="text/javascript">
  
    /*全部会员还是部分会员*/
    $(".ra_all").click(function(){
        if($(this).val()=='0'){
            $('.raMember').fadeIn('fast');
        }else{
            $('.raMember').hide();
        }
    });

    //会员搜索
    function memberSearch(){    
        var url ="<?php echo U('Admin/Members/ajaxMemberLike');?>";
        var memberName = $('#memberName').val();
        $.post(url,{'member_name':memberName},function(data){
            if(data.result){ 
                var ary_data = data['data'];
                var str = '';
                for(var i = 0; i < ary_data.length;i++){
                    str = str + "<li ondblclick='dbclickMemberName(this)' class='m_name'>"+ary_data[i]['m_name']+"</li>";
                }
                $('#m_name_li').html(str);
            }
        },'json');
    }
    //选择会员
    function dbclickMemberName(obj){
        $('#memberName').val($(obj).html());
        $('#m_name_li').hide();
    }
    /*添加会员*/
    function addMember(){
       if($("#memberName").val() == ''){
           showAlert(false,'出错了','请输入会员名称');
           return false;
       }
        var url = "<?php echo U('Admin/Promotions/getMemberTr');?>";
        var member_id = new Array();
        var name = $("#memberName").val();
        $("input[name='ra_mid[]']").each(function () {
               member_id.push(this.value);
        });
        
        var data = { name:name,member_id:member_id};
        $.post(url,data,function(info){
            if(info=="false"){
                showAlert(false,'出错了','请输入用户名已存在或用户名不正确');
            }else{ 
               $("#raMemberId").append(info);
               //$("#raMemberId").html(html);  
            }
        },'text');
    }
    /*删除会员*/
    function delMember(obj){
        obj.parent('td').parent('tr').remove();
    }
     /*批量删除*/
    function batchDelMember(){
        $("input[name='check_members']").each(function(){
            if($(this).prop("checked")== true){
               
                $(this).parent('td').parent('tr').remove();
            }
        })
    }
    /*
     * 批量添加会员
     */
        $('#batch_members').dialog({
        resizable:false,
        autoOpen: false,
        modal: true,
        width: 600,
        hight:500,
        buttons: {
                '添加': function() {
                    var dio = $( this );
                    var data = { name:$("#batch_names_textarea").val()};
                    var url = "<?php echo U('Admin/Promotions/getMemberTr');?>";
                    $.post(url,data,function(info){
                        if(info=="false"){
                            showAlert(false,'出错了','请输入用户名或用户名不正确');
                        }else{
                            $('#raMemberId').html(info);
                        }
                    },'text');
                            dio.dialog( "close" );
                        },
                '取消': function() {
                    $( this ).dialog( "close" );
                }
            }
        });
      $('#add_batch_members').click(function(){
        $('#batch_members').dialog('open');
        
    });
</script>
                <tr>
                    <td class="first"><span class="red">*</span> 促销规则</td>
                    <td>
                        <select id="pmn_rule" name="pmn_class" class="medium" validate="{ selected:true}" style="width:450px;" onchange="change_rule(this.value);">
                            <option value="0">请选择</option>
                            <?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($tp["code"]); ?>">促销活动规则 - <?php echo ($tp["memo"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                    <td class="last"></td>
                </tr>
				<tr id="category">
					<td class="first"><span class="red">*</span> 商品分类</td>
					<td id="clist" name="clist">
							  <span id="" class="rule-param rule-param-edit">
							<span id="" class="element">
							<input id="cat_selValue" class="medium input-text" readonly="readonly" type="text" name="cat_selValue" value="<?php echo ($info['cids']); ?>">
							<a class="rule-chooser-trigger" ref="'.$this->index.'" href="javascript:void(0)">
							<img title="Open Chooser" class="v-middle" alt="" src="__PUBLIC__/Admin/images/rule_chooser_trigger.gif"></a>
							请点击按钮选择分类
							</span>
							</span>
							<div id="shopMulti_cat" class="shop-cat-list rule-chooser" style="display:none;padding-left: 15px;">
								<ul id="cat_selItems"><?php echo ($catHtml); ?></ul>
							</div>
					</td>
					<td class="last">商品分类、商品品牌、商品分组、指定商品至少选择一个</td> 
				</tr>
				<tr id="brand">
					<td class="first"><span class="red">*</span> 商品品牌</td>
					<td id="blist" name="blist">
							  <span id="" class="rule-param rule-param-edit">
							<span id="" class="element">
							<input id="brand_selValue" readonly="readonly" class="medium input-text" type="text" name="brand_selValue" value="<?php echo ($info['bids']); ?>">
							<a class="rule-chooser-trigger1" ref="'.$this->index.'" href="javascript:void(0)">
							<img title="Open Chooser" class="v-middle" alt="" src="__PUBLIC__/Admin/images/rule_chooser_trigger.gif"></a>
							请点击按钮选择品牌
							</span>
							</span>
							<div id="shopMulti_brand" class="shop-cat-list rule-chooser" style="display:none;padding-left: 15px;">
								<ul id="brand_selItems"><?php echo ($brandHtml); ?></ul>
							</div>
					</td>
					<td class="last"></td>
				</tr>                
                <tr id="group">
                    <td class="first"><span class="red">*</span> 商品分组</td>
                    <td>
                        <table class="tblist">
                            <tbody>
                                <?php if(is_array($gGroup)): $i = 0; $__LIST__ = $gGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 10 );++$i; if(($mod) == "0"): ?><tr><?php endif; ?>
                                    <?php if(!in_array($group['gg_id'],$allgroup)){ ?><td><input type="checkbox" name="gg_name[]" id="gg_name" value="<?php echo ($group["gg_id"]); ?>"> <span><?php echo ($group["gg_name"]); ?></span></td><?php } ?>
                                <?php if(($mod) == "4"): ?></tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table> 
                    </td>
                    <td class="last"></td>
                </tr>
                <tr id='html_box'>
                </tr>
                <tr id='rule_box'>
                </tr>
                
                <tr>
                    <td class="first">促销规则描述</td>
                    <td><textarea name="pmn_memo" class="mediumBox" validate="{ maxlength:200}"></textarea></td>
                    <td class="last">200字以内</td>
                </tr>
                <tr class="last">
                    <td colspan="99">
                        <input type="button" value="提 交" class="btnA" onclick="javascrpt:save();"/>&nbsp;
                        <input type="button" value="取 消" class="btnA back" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div class="clear"></div>
</div>
<link href="__PUBLIC__/Admin/css/condition.css" rel="stylesheet">
<script type="text/javascript">
/**
 * 提交表单
 * @author zhangjiasuo <zhangjiasuo@guanyisoft.com>
 * @date 2013-05-29
 */
function save(){
    var types=$("#rule_box input:radio[name='cfg_goods_area']:checked").val();  //选择商品
    var pmn_type = $(".tbForm select[name='pmn_class']").val();
    var res = $('#promotion_add').valid();
    var start_price =$('#cfg_cart_start').val();
    var end_price =$('#cfg_cart_end').val();
    var ra_part = $("input[name='ra_all']:checked").val();
    var memberName = $("input[name='memberName']").val();
    //定义一个判断标示
    var i = 0;
    if(ra_part == 0){
        $('input[class="checkedMeInfo"]:checked').each(function(){
             i = 1;
        });
         if(memberName != ""){
            i = 1;
        }
       if(i != 1){
            showAlert(false,'部分会员选项不能为空');
            return false;
       }

    }

    if(parseFloat(end_price) < parseFloat(start_price)){
        showAlert(false,'出错了','优惠条件起始价格大于结束价格！');
        return false;
    }

    if(pmn_type == 'PYIKOUJIA'){
        if(types==1){
            var num = $("input[name='ra_gid[]']").length;
            if(num==0){
                showAlert(false,'出错了','请您选择商品！');
                return false;
            }
        }
    }

    if(res){
        document.promotion_add.submit();
    }
} 

//修改促销规则
function change_rule(selectVal){
    if(selectVal != 'PYIKOUJIA' && selectVal != '0'){
        $.ajax({
            url:"<?php echo U('Admin/Promotions/getPromotionsGoods');?>",
            cache:false,
            dataType:'HTML',
            data:{type:'add'},
            type:"post",
            success:function(msgObj){
                $('#html_box').html(msgObj);
            }
        });
    }
    //判断是否为真正的onchange事件
    if(selectVal != $('#rule_box').data('index')){
        $('#rule_box').data('index',selectVal);
    }else{
        return;
    }
    var html = '';
    switch(selectVal){
        case "MZHEKOU":
            html = "<td class='first' colspan='3'>"
                 + "<div>"
                 + "<table><tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 优惠条件</td><td style='text-align:left;width:630px;'><input type='text' id='cfg_cart_start' name='cfg_cart_start' class='small' validate='{ required:true,number:true,min:1}' value='<?php echo ($config->cfg_cart_start); ?>' />-<input type='text' id='cfg_cart_end' name='cfg_cart_end' class='small' value='<?php echo ($config->cfg_cart_end); ?>' validate='{ required:true,number:true,min:1}' /></td>"
                 + "<td class='last'>购物车金额在此范围内享受优惠，优惠条件为必填项。<br>例如：500-2000代表500以上2000以下。</td></tr>"
                 + "<tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 给与多少折扣</td><td style='text-align:left;width:630px;'><input type='text' name='cfg_discount' class='small' validate='{ required:true,range:[0,1],number:true}' value='<?php echo ($config->cfg_discount); ?>'  />"
                 + "<td class='last'>示例：如果打8折，请输入0.8</td>"
                 + "</tr></table>";
                
        break;
        case "MJIAN":
            html = "<td class='first' colspan='3'>"
                 + "<div>"
                 + "<table><tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 优惠条件</td><td style='text-align:left;width:630px;'><input type='text' id='cfg_cart_start' name='cfg_cart_start' class='small' validate='{ required:true,number:true,min:1}' value='<?php echo ($config->cfg_cart_start); ?>' />-<input type='text' id='cfg_cart_end' name='cfg_cart_end' class='small' value='<?php echo ($config->cfg_cart_end); ?>' validate='{ required:true,number:true,min:1}' /></td>"
                 + "<td class='last'>购物车金额在此范围内享受优惠，优惠条件为必填项。<br>例如：500-2000代表500以上2000以下。</td></tr>"
                 + "<tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 整单立减多少元</td><td style='text-align:left;width:630px;'><input type='text' name='cfg_discount' class='small' validate='{ required:true,min:0,number:true}' value='<?php echo ($config->cfg_discount); ?>'  />"
                 + "<td class='last'>输入优惠的金额</td>"
                 + "</tr></table>";
        break;
        case "MZENPIN":
             $.ajax({
                url:"<?php echo U('Admin/Promotions/getProPremiums');?>",
                cache:false,
                dataType:'HTML',
                data:{},
                type:"post",
                success:function(msgObj){
                    $('#rule_box').html(msgObj);
                }
             });
        break;
        case "MBAOYOU":
            html = "<td class='first' colspan='3'>"
                 + "<div>"
                 + "<table><tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 优惠条件</td><td style='text-align:left;width:630px;'><input type='text' id='cfg_cart_start' name='cfg_cart_start' class='small' validate='{ required:true,number:true,min:1}' value='<?php echo ($config->cfg_cart_start); ?>' />-<input type='text' id='cfg_cart_end' name='cfg_cart_end' class='small' value='<?php echo ($config->cfg_cart_end); ?>' validate='{ required:true,number:true,min:1}' /></td>"
                 + "<td class='last'>购物车金额在此范围内享受优惠，优惠条件为必填项。<br>例如：500-2000代表500以上2000以下。</td></tr>"
                 +"</table>";
            break;
        case "MQUAN":
             $.ajax({
                url:"<?php echo U('Admin/Promotions/getPreferential');?>",
                cache:false,
                dataType:'HTML',
                data:{},
                type:"post",
                success:function(msgObj){
                    $('#rule_box').html(msgObj);
                }
             });
        break;
        case "PYIKOUJIA":
            $.ajax({
                url:"<?php echo U('Admin/Promotions/getPromotionsGoods');?>",
                cache:false,
                dataType:'HTML',
                data:{},
                type:"post",
                success:function(msgObj){
                    $('#rule_box').html(msgObj);
                }
            });
        break;
        case "MJLB":
            html = "<td class='first' colspan='3'>"
                 + "<div>"
                 + "<table><tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 优惠条件</td><td style='text-align:left;width:630px;'><input type='text' id='cfg_cart_start' name='cfg_cart_start' class='small' validate='{ required:true,number:true,min:1}' value='<?php echo ($config->cfg_cart_start); ?>' />-<input type='text' id='cfg_cart_end' name='cfg_cart_end' class='small' value='<?php echo ($config->cfg_cart_end); ?>' validate='{ required:true,number:true,min:1}' /></td>"
                 + "<td class='last'>购物车金额在此范围内享受优惠，优惠条件为必填项。<br>例如：500-2000代表500以上2000以下。</td></tr>"
                 + "<tr class='load'>"
                 + "<td class='first'><span class='red'>*</span> 可获取得金币</td><td style='text-align:left;width:630px;'><input type='text' name='cfg_discount' class='small' validate='{ required:true,min:0,number:true}' value='<?php echo ($config->cfg_discount); ?>'  />"
                 + "<td class='last'>输入赠送的金币数量</td>"
                 + "</tr></table>";
        break;
    }
    if(selectVal == 'PYIKOUJIA'){
        $("#group").hide();
		$("#category").hide();
		$("#brand").hide();
    }else{
        $("#group").show();
		$("#category").show();
		$("#brand").show();
    }
    
    $('#rule_box').html(html);
    //alert(selectVal);return false;
}
$(document).ready(function(){
    /*显示和隐藏已经被占用的优先级*/
    $('#showDisableOrder').click(function(){
        if($(this).attr('checked')=='checked'){
            $("#pmn_order option:disabled").show();
        }else{
            $("#pmn_order option:disabled").hide();
        }
    });
    //刷新页面后 自动调用被选的 促销规则
    change_rule($("#pmn_rule option:selected").val());
	
	//类目选择
	$(".rule-chooser-trigger").click(function(){
		if($("#shopMulti_cat").css('display') == 'block'){
			$("#shopMulti_cat").css("display","none");
		}else{
			$("#shopMulti_cat").css("display","block");
		}
	});
	 
	 $(".cat-checkbox").click(function(){
		var selValue = '';
		var now_id = $(this).attr("ref");
		if($(this).attr('checked') == 'checked'){
			$(".cat-checkbox").each(function(){
				if($(this).attr("pid") == now_id){
					$(this).attr("checked","checked");
				}
			});
		}else{
			$(".cat-checkbox").each(function(){
				if($(this).attr("pid") == now_id){
					$(this).attr("checked",false);
				}
			});
		}
		$(".cat-checkbox:checked").each(function(){
			selValue += $(this).attr("ref") + ',';
		});
		if(selValue.length>0){
			selValue = selValue.substr(0,selValue.length-1);
		}
		$("#cat_selValue").val(selValue);
	});

	//品牌选择
	$(".rule-chooser-trigger1").click(function(){
		if($("#shopMulti_brand").css('display') == 'block'){
			$("#shopMulti_brand").css("display","none");
		}else{
			$("#shopMulti_brand").css("display","block");
		}
	});  
	
	 $(".brand-checkbox").click(function(){
		var selValue = '';
		$(".brand-checkbox:checked").each(function(){
			selValue += $(this).attr("ref") + ',';
		});
		if(selValue.length>0){
			selValue = selValue.substr(0,selValue.length-1);
		}
		 
		$("#brand_selValue").val(selValue);
	}); 
	
});
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