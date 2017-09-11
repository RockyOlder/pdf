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
                <div class="rightInners">
    <table width="100%" class="tbList">
            <thead>
                <tr class="title">
                <th colspan="<?php echo 14+count($fields); ?>">
                    <form id="searchForm" method="get" action="<?php echo U('Admin/MembersDistributed/SourceActivityPayCount');?>" style='width:55%;'>
                    <span   style="margin-left:40px;float:left;text-align:right;font-size:12px;">
                         主题切换：<select id="theme-select" class="medium" ></select>
                            时间筛选:<input type="text" class="medium timer" name="o_create_time_1" value="<?php echo ($ary_data["o_create_time_1"]); ?>"> 
                            点击类型：<select id="" class="medium" name="s_type">
                             <option value="all" <?php if($ary_data['s_type'] == 'all'){ ?>selected="selected"<?php } ?>>所有</option>
                             <option value="1" <?php if($ary_data['s_type'] == 1){ ?>selected="selected"<?php } ?>>免费用户登录</option>
                             <option value="2" <?php if($ary_data['s_type'] == 2){ ?>selected="selected"<?php } ?>>免费用户转换</option>
                             <option value="3" <?php if($ary_data['s_type'] == 3){ ?>selected="selected"<?php } ?>>客户端右上角</option>
                             <option value="4" <?php if($ary_data['s_type'] == 4){ ?>selected="selected"<?php } ?>>客户端界面横幅</option>
                             <option value="5" <?php if($ary_data['s_type'] == 5){ ?>selected="selected"<?php } ?>>只转5页图片点击</option>
                             <option value="6" <?php if($ary_data['s_type'] == 6){ ?>selected="selected"<?php } ?>>立即抢购点击</option>
                        </select>
                          <!--用户id：<input type="text" name="m_id" class="large" value="<?php echo ($ary_data["m_id"]); ?>" style="width: 145px;">-->
                          <input type="submit" name="search" value="搜 索" class="btnHeader inpButton">
                    </span>
                    </form>
                  </th>
                </tr>
            </thead>
    </table>
</div>
<script src="__PUBLIC__/Admin/www/js/echarts.js"></script>
<div id="main" style="height:500px;border:1px solid #ccc;padding:10px;"></div>

  <script type="text/javascript">
 /**
  * @@author Rocky
  * @type type
  */
var myChart;
var theme = 'macarons';
var labelFromatter = {
    normal : {
        label : {
            formatter : function (params){
                return 100 - params.value + '%'
            },
            textStyle: {
                baseline : 'top'
            }
        }
    },
}

var radius = [40, 55];
    // Step:3 conifg ECharts's path, link to echarts.js from current page.
    // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径
    require.config({
        paths: {
            echarts: '/Public/Admin/www/js',
            echart: '/Public/Admin/theme'
        }
    });
   
    // Step:4 require echarts and use it in the callback.
    // Step:4 动态加载echarts然后在回调函数中开始使用，注意保持按需加载结构定义图表路径
    require(
        [
            'echarts',
            'echarts/chart/line',
            'echarts/chart/pie',
            'echarts/chart/bar',          
            'echart/macarons'
        ],
        function (ec) {
            //--- 折柱 ---
             myChart = ec.init(document.getElementById('main'),theme);
            // myChart.showLoading({
            //     text: '正在努力的读取数据中...',    //loading话术
            // });
            // myChart.hideLoading();
            myChart.setOption({
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:<?php echo ($title); ?>
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : <?php echo ($week); ?>
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        <?php echo ($json_pay_1); ?>,
        <?php echo ($json_pay_2); ?>,
        <?php echo ($json_pay_3); ?>,
        <?php echo ($json_pay_4); ?>,
        <?php echo ($json_pay_5); ?>,
        <?php echo ($json_pay_6); ?>
    ]
});
        }
    );
    $(document).ready(function(){
        var themeSelector = $('#theme-select');
        var enVersion = location.hash.indexOf('-en') != -1;
        var hash = location.hash.replace('-en','');
        hash = hash.replace('#','') || (needMap() ? 'default' : 'macarons');
        hash += enVersion ? '-en' : '';
        if (themeSelector) {
            themeSelector.html(
                '<option selected="true" name="macarons">macarons</option>'
                + '<option name="infographic">infographic</option>'
                + '<option name="shine">shine</option>'
                + '<option name="dark">dark</option>'
                + '<option name="blue">blue</option>'
                + '<option name="green">green</option>'
                + '<option name="red">red</option>'
                + '<option name="gray">gray</option>'
                + '<option name="helianthus">helianthus</option>'
                + '<option name="roma">roma</option>'
                + '<option name="mint">mint</option>'
                + '<option name="macarons2">macarons2</option>'
                + '<option name="sakura">sakura</option>'
                + '<option name="default">default</option>'
            );
            $(themeSelector).on('change', function(){
                selectChange($(this).val());
            });
            function selectChange(value){
                var theme = value;
                myChart.showLoading();
                $(themeSelector).val(theme);
                if (theme != 'default') {
                    window.location.hash = value + (enVersion ? '-en' : '');
                    require(['/Public/Admin/theme/' + theme], function(tarTheme){
                        console.log(tarTheme);
                        curTheme = tarTheme;
                        setTimeout(refreshTheme, 500);
                    })
                }
                else {
                    window.location.hash = enVersion ? '-en' : '';
                    curTheme = {};
                    setTimeout(refreshTheme, 500);
                }
            }
            function refreshTheme(){
                myChart.hideLoading();
                myChart.setTheme(curTheme);
            }
            if ($(themeSelector).val(hash.replace('-en', '')).val() != hash.replace('-en', '')) {
                $(themeSelector).val('macarons');
                hash = 'macarons' + enVersion ? '-en' : '';
                window.location.hash = hash;
            }
        }

    })
    function needMap() {
        var href = location.href;
        return href.indexOf('map') != -1
               || href.indexOf('mix3') != -1
               || href.indexOf('mix5') != -1
               || href.indexOf('dataRange') != -1;

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