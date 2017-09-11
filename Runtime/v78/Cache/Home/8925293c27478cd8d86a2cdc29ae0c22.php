<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($page_title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="keywords" content="<?php echo ($page_keywords); ?>">
        <meta name="description" content="<?php echo ($page_description); ?>">
        <link rel="shortcut icon" href="__TPL__/images/favicon.ico"  type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/webuploader.css">
	<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/style.css">
	<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/loaders.css"/>
	<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/xcConfirm.css"/>
        <link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/jquery.fileupload.css"/>

    </head>
	<body id="goTop"  ><!--      -->

	        <div class="header">
        <div class="wrap clearfix">
            <a href="<?php echo U('Home/Index/CoreBusiness');?>" class="brand"><img src="__IMAGES__brand.png"  alt="pdf在线转换器" /></a>
            <ul class="nav">
                <li <?php if($header_tag_highlighted == 3 ): ?>class="current"<?php endif; ?>><a href="/">首页</a></li>
                <li <?php if($header_tag_highlighted == 4 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/CoreBusiness');?>">开始转换</a></li>
                <li <?php if($header_tag_highlighted == 1 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/artificialvip');?>">人工VIP</a></li>
                <li <?php if($header_tag_highlighted == 2 ): ?>class="current"<?php endif; ?>><a href="<?php echo U('Home/Index/informationRecords');?>">信息记录</a></li>
                <li>联系我们
                    <div class="info">
                        <i class="arrow_up"></i>
                        <p><i class="icon icon_qq"></i>官方QQ群<a href="http://shang.qq.com/wpa/qunwpa?idkey=5b012a15f072526bb9334848d8f60dbcaf7c8e2f7023f3378e1655ddd364dd00" target="_blank">(点击加入)</a></p>
                        <p><i class="icon icon_qq"></i>QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" target="_blank">3004137938</a></p>
                        <p><i class="icon icon_phone"></i>0755-86952275</p>
                        <div class="work_time">周一至周五 09:00-18:00</div>                        
                    </div>
                </li>
            </ul>
            <div class="login">
            <?php if(empty($_SESSION['Members']['m_name'])): ?><a href="javascript:return false;" id="login_weixin" class="login_weixin">登录</a><!-- <?php echo U('Home/Index/weixin_login');?> --><?php endif; ?>
                <?php if(!empty($_SESSION['Members']['m_name'])): ?><div class="user">
                     <div class="name">你好，<?php echo ($_SESSION['Members']['m_name']); ?></div>
                     <div class="info" id="appendHtml">
                         
<i class="arrow_up"></i>
<div class="content" id="hederGet">
    <h3><div class="login_name" title="<?php echo ($_SESSION['Members']['m_name']); ?>"><?php echo ($_SESSION['Members']['m_name']); ?></div></h3><a href="<?php echo U('Home/User/doLogout');?>" class="exit">退出<!-- <div><i class="icon icon_exit"></i></div>  --></a>
    <p class="promet2"> 
    <?php $out_time = 0; if(time() > strtotime($ary_member['end_time'])){ $time_count =0; $out_time = count_days(strtotime($ary_member['end_time']),strtotime(date('Y-m-d'))); $out_day_small = time() - strtotime($ary_member['end_time']); if($out_day_small < 86400){ $out_time = 1; } }else { $time_count = count_days(strtotime(date('Y-m-d H:i:s')),strtotime($ary_member['end_time'])); if($time_count == 0){ $time_count_show = 1; }else { $time_count_show = $time_count; } } ?>
    <?php if(($ary_member["conversion_type"] == 0 and $out_time == 0) or ($out_time > 30 and $ary_member["conversion_type"] == 0) ): ?>您当前还未充值<?php endif; ?>
</p>
<?php if($ary_member["conversion_type"] == 1 and $ary_member["number_remaining"] != 0): ?><p>次数套餐：<span class="times"><?php echo ($ary_member["number_remaining"]); ?> </span>次&nbsp;&nbsp;&nbsp;
    <?php elseif($ary_member["conversion_type"] == 2): ?>
    <?php if($ary_member["number_remaining"] != 0 ): ?><p>VIP套餐：<span class="times"><?php echo $time_count_show; ?> </span>天(优先)&nbsp;&nbsp;&nbsp;次数套餐：<span class="times"><?php echo ($ary_member["number_remaining"]); ?> </span>次</p>
        <?php else: ?>
        <p>VIP套餐：<span class="times"><?php echo $time_count_show; ?> </span>天</p><?php endif; endif; ?>

<div class="warning_promet">
    <?php if((($ary_member["conversion_type"] == 0 and $out_time == 0) or ($out_time > 30)) or (($ary_member["conversion_type"] == 1 and $out_time == 0) or ($out_time > 30))): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
    <?php if($time_count == 0 and $out_time == 0 ): ?><i class="icon icon-gift"></i>
        <p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
    <?php if($time_count <= 7 and $time_count > 0 and $out_time == 0): ?><i class="icon icon-gift"></i>
        <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red'  >亲，您的VIP套餐马上要到期了，现在购买套餐尊享<span class="zkou">9</span>折优惠哦~</a></p><?php endif; ?>
    <?php if($time_count > 7 and $time_count > 0 and $out_time == 0): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
    <?php if($out_time <= 30 and $out_time > 0): ?><i class="icon icon-gift"></i>
        <p class="promet"><a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" style='color:red' >亲，您的VIP套餐已经到期了，现在购买套餐尊享<span class="zkou">9.5</span>折优惠哦~</a></p><?php endif; ?>
    <?php if($out_time > 30 and $time_count != 0 ): ?><p class="promet">包月转换次数不受限，包年最低只要0.1元/天</p><?php endif; ?>
</div>
</div>
<div class="work_time" data-id="info" id="header_tag_data">
    <a href="<?php echo U('Home/Index/informationRecords',array('record'=>Prepaidrecords));?>" class="record">充值记录</a>
    <a href="<?php echo U('Home/Index/informationRecords',array('record'=>Conversionrecord));?>" class="record">转换记录</a>
    <a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="now_cz">立即充值</a>
</div>                   
                     </div>
                 </div><?php endif; ?>
                <div class="recharge_box">&nbsp;&nbsp;│&nbsp;&nbsp;<a href="<?php echo U('Home/Products/ConversionFeeDetail');?>" class="recharge">充值</a></div>
                <input type="hidden" value="<?php echo ($_SESSION['Members']['m_id']); ?>" name ="gy_member_open" id="gy_member_open"/>
                <input type="hidden" value="<?php echo ($redirect); ?>" name ="redirect" id="redirect"/>
                <input type="hidden" id="Authorizationtype" value="<?php echo ($ary_member["conversion_type"]); ?>" />
                <input type="hidden" id="Free_authorization" value="<?php echo ($ary_member["Free_authorization"]); ?>" />
                <input type="hidden" id="ACTIVITY_OPEN" value="<?php echo ($ACTIVITY_OPEN); ?>" />
                <input type="hidden" id="LoadDataType" value="<?php echo ($_SESSION['Members']['LoadDataType']); ?>" />
            </div>
        </div>
    </div>
	        <div class="main">
        <div class="wrap">
            <div class="add_banner" style="display:none;"><a href="/Home/Products/ConversionFeeDetail"><img src="__IMAGES__banner-1.2_03.jpg" alt=""></a><i class="icon icon-close"></i></div>
            <?php if($ACTIVITY_OPEN != 1): ?><div class="activity_banner">
                    <img src="__IMAGES__images/1_03.jpg" alt="" />
                    <div class="content">
                       <a href="<?php echo U('Home/Index/YearMiddlePage',array('s_type'=>0));?>" class="Behavior_Statistics_Banner">
                        <div class="left">
                            <img src="__IMAGES__images/txt.png" alt="" />                       
                        </div>
                        <div class="count_down right">
                            <h3>距离<span class="end_date"></span>活动截止还剩</h3>
                            <p><span class="day"></span><span class="time"></span></p>
                            <span class="details">活动详情</span>
                        </div>
                        </a>
                        <div class="linkbox">
                            <a href="<?php echo U('Home/Index/YearMiddlePage#01',array('s_type'=>0));?>" class="first">买一个月送5次转换</a>
                            <a href="<?php echo U('Home/Index/YearMiddlePage#02',array('s_type'=>0));?>">买一年送3个月</a>
                            <a href="<?php echo U('Home/Index/YearMiddlePage#03',array('s_type'=>0));?>">买二年送6个月</a>
                        </div>
                    </div>
                </div><?php endif; ?>
            
<div class="main_header">
                <ul>
                    <li <?php if($pdf_type == 0 ): ?>class="active"<?php endif; ?>>
                       <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>0));?>">
                            <i class="icon icon_s1"></i>
                            <p>PDF转Word</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 1 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>1));?>">
                            <i class="icon icon_s2"></i>
                            <p>PDF转Excel</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 2 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>2));?>">
                            <i class="icon icon_s3"></i>
                            <p>PDF转PPT</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 3 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>3));?>">
                            <i class="icon icon_s4"></i>
                            <p>Word转PDF</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 4 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>4));?>">
                            <i class="icon icon_s5"></i>
                            <p>Excel转PDF</p>
                        </a>
                    </li>
                    <li <?php if($pdf_type == 5 ): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo U('Home/Index/CoreBusiness',array('pdf_type'=>5));?>">
                            <i class="icon icon_s6"></i>
                            <p>PPT转PDF</p>
                        </a>
                    </li>
                   
                </ul>
</div>
            <div class="main_main">
                <div class="choose_file_box">
                    <div class="choose_file">
                        <div class="div_usehover">                        
                            <a href="javascript:;" class="btn_file">
                                <input id="fileupload"  type="file" name="files[]" multiple="">选择文件
                                <div class="bubble_promet">
                                    <i class="arrow_up2"></i>
                                    <p>主人，登录才可享受限量<br>PDF文档<span class="strong">免费转换~</span></p>                           
                                    <div class="login_weixin">微信登录</div>
                                </div>                           
                            </a>
                        </div>
                        <br>
                        <label class="label checked"><i class="icon"></i>请确保上传的文档没有违法内容并且不涉及到版权</label>
                    </div>
                    <div class="sendfor_email clearfix">
                        <span class="promet">您还可将文档拖拽至页面空白处上传<i class="icon icon-promet"></i></span>
                        <label class="label <?php if($ary_member["m_email"] != '' ): ?>checked<?php endif; ?>"><i class="icon"></i>您可以将转换后的文档发送至邮箱</label>
                        <div class="email_div">
                            <input type="text" class="email" id="email" name="email" value='<?php echo ($ary_member["m_email"]); ?>'  placeholder="请务必填写正确的邮件地址" autocomplete="off" />
                            <i class="icon2"></i>
                        </div>
                    </div>
                    <div id="myp"></div>
                </div>
                <div class="upload_file">
                    <table class="table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                            <th width="80">选择</th>
                            <th>文件名</th>
                            <th width="80">总页数</th>
                            <th width="110">文件类型</th>
                            <th></th>
                            <th width="140">转换格式</th>
                            <th width="140">状态</th>
                            <th>操作</th>
                            <th width="80">删除</th>
                            </tr>
                        </thead>
                        <tbody>
                                                   
                        </tbody>
                    </table>
                <input type="hidden" id="fileVal" value="" />
		<input type="hidden" id="delFile" value="" />
                <input type="hidden" id="pdf_authorization" value="0" />
                    <div class="file_operation">
                        <div class="all_choose">全选</div>
                        <div class="in_turn">反选</div>
                        <div class="batch_conversion" onclick="conversion.batchConversion()" ><img src="__IMAGES__icon_1.png" alt=""  />批量转换</div>
                        <div class="batch_delete" onclick="conversion.batch_delete()"><i class="icon"></i>批量删除</div>
                    </div>
                </div>                
            </div>
            <div class="main_footer">
                <?php if($pdf_type == 0 ): ?><h3>在线PDF转Word功能说明</h3>
                            <p>1、每天赠送一次转换50页以内PDF文档的特权，文档超过20M推荐您使用人工 VIP服务或无大小限制的客户端转换。</p>
                            <p>2、转换出来的Word文档能最大限度的保留原文档的内容和布局。</p>
                            <p>3、若PDF文档是通过扫描后生成的图片型PDF文档，转换后的图片还是不能编辑。</p>
                            <p>4、加密的PDF文档需要先去除密码后，再进行转换，悦书PDF阅读器可以快速去除文档密码。</p>
                            <p>5、转换后的Word文档格式为docx，请使用Office或WPS进行阅读和编辑。</p>
                   <?php elseif($pdf_type == 1): ?>
                            <h3>在线PDF转Excel功能说明</h3>
                            <p>1、每天赠送一次转换50页以内PDF文档的特权，文档超过20M推荐您使用人工 VIP服务或无大小限制的客户端转换。</p>
                            <p>2、转换出来的Excel文档能最大限度的保留原Excel文档格式的内容和布局。</p>
                            <p>3、若PDF文档是通过扫描后生成的图片型PDF文档，转换后的图片还是不能编辑。</p>
                            <p>4、加密的PDF文档需要先去除密码后，再进行转换，悦书PDF阅读器可以快速去除文档密码。</p>
                            <p>5、转换后的Excel文档格式为xlsx，请使用Office或WPS进行阅读和编辑。</p>
                   <?php elseif($pdf_type == 2): ?>
                            <h3>在线PDF转PPT功能说明</h3>
                            <p>1、每天赠送一次转换50页以内PDF文档的特权，文档超过20M推荐您使用人工 VIP服务或无大小限制的客户端转换。</p>
                            <p>2、转换出来的PPT文档能最大限度的保留原PPT文档格式的内容和布局。</p>
                            <p>3、若PDF文档是通过扫描后生成的图片型PDF文档，转换后的图片还是不能编辑。</p>
                            <p>4、加密的PDF文档需要先去除密码后，再进行转换，悦书PDF阅读器可以快速去除文档密码。</p>
                            <p>5、转换后的PPT文档格式为pptx，请使用Office或WPS进行阅读和编辑。</p>
                   <?php elseif($pdf_type == 3): ?>
                            <h3>在线Word转PDF功能说明</h3>
                            <p>1、可免费无限量使用Word转PDF功能，超过20M推荐您使用人工 VIP服务或无大小限制的客户端转换。</p>                            
                            <p>2、支持2种格式的Word文档转换，可以完美的将doc，docx格式转换成PDF文档。</p> 
                            <p>3、通过Word转换生成的PDF文档，还可以进行高亮，批注，注释等操作。</p> 
                            <p>4、若要生成加密的PDF文档，转换成功后使用悦书PDF阅读器可以快速的为PDF文档增加打开密码和权限密码。</p> 
                            <p>5、转换后的文档格式为PDF，请使用悦书PDF阅读器进行阅读和注释。</p> 

                   <?php elseif($pdf_type == 4): ?>
                            <h3>在线Excel转PDF功能说明</h3>
                            <p>1、可免费无限量使用Excel转PDF功能，超过20M推荐您使用人工 VIP服务或无大小限制的客户端转换。</p>
                            <p>2、支持2种格式的Excel文档转换，可以完美的将xls，xlsx格式转换成PDF文档。</p>
                            <p>3、通过Excel转换生成的PDF文档，还可以进行高亮，批注，注释等操作。</p>
                            <p>4、若要生成加密的PDF文档，转换成功后使用悦书PDF阅读器可以快速的为PDF文档增加打开密码和权限密码。</p>
                            <p>5、转换后的文档格式为PDF，请使用悦书PDF阅读器进行阅读和注释。</p>


                   <?php elseif($pdf_type == 5): ?>
                            <h3>在线PPT转PDF功能说明</h3>
                            <p>1、可免费无限量使用PPT转PDF功能，超过20M推荐您使用人工 VIP服务或无大小限制的客户端转换。</p>
                            <p>2、支持2种格式的PPT文档转换，可以完美的将ppt，pptx格式转换成PDF文档。</p>
                            <p>3、通过PPT转换生成的PDF文档，还可以进行高亮，批注，注释等操作。</p>
                            <p>4、若要生成加密的PDF文档，转换成功后使用悦书PDF阅读器可以快速的为PDF文档增加打开密码和权限密码。</p>
                            <p>5、转换后的文档格式为PDF，请使用悦书PDF阅读器进行阅读和注释。</p><?php endif; ?>

            </div>
        </div>
    </div>
 <div class="popup popup_weixin" >

</div>
    <!-- 各种状态的弹窗 -->
    <div class="popup popup_other">
        <div class="content" name="content_whycansel">
            <div class="icon close"></div>
            <form action="">
                 <h4>亲，为何要取消支付呢？</h4>
                 <ul class="choose_reason">
                     <li>选错啦</li>
                     <li>价格小贵，我再想想</li>
                     <li>转换质量有待提高</li>
                 </ul>
                 <textarea class="other_resson" maxlength="200"></textarea>
                <div class="bottom">
                    <a href="javascript:;" class="btn btn_contain_pay">返回支付</a>
                    <a href="javascript:;" class="btn btn_submit">提交</a>
                </div> 
             </form>
        </div>
        <div class="content" name="content_start">
            <div class="icon close"></div>
                <h4>文档开始转换~</h4>
                 <div class="txt">
                     <p>普通用户每天仅可免费转换一份PDF文档</p>
                     <p>升级VIP享更多超值特权</p>
                     <p>多样套餐随心选，包月套餐现仅需<span class="strong">10元</span></p>
                 </div>
                <div class="bottom">
                    <a href="#" class="btn btn_recharge">立即充值</a>
                </div> 
        </div>
        <div class="content" name="content_success">
            <div class="icon close"></div>
                <h4>文档转换成功！</h4>
                 <div class="txt">
                     <p>普通用户每天仅可免费转换一份PDF文档</p>
                     <p>升级VIP享更多超值特权</p>
                     <p>多样套餐随心选，包月套餐现仅需<span class="strong">10元</span></p>
                 </div>
                <div class="bottom">
                    <a href="#" class="btn btn_recharge">立即充值</a>
                </div> 
        </div> 
        <div class="content" name="content_split">
            <div class="icon close"></div>
                 <div class="txt">
                     <p>非常抱歉，您购买的单次/多次套餐仅支持500页内的PDF文档转换。</p>
                     <p>升级月度或更长时限套餐即可享超大文档任性转，<i style="color:red">速来抢购！</i></p>
                     <!-- <p>多样套餐随心选，包月套餐现仅需<span class="strong">10元</span></p> -->
                 </div>
                <div class="bottom">
                    <a href="####" class="btn btn_recharge">立即升级</a>
                </div> 
        </div>
        <div class="content" name="content_overflow">
            <div class="icon close"></div>
                 <div class="txt">
                     <p>非常抱歉，你上传的文档大于50页，已超过免费转换范围。</p>
                     <p></p>
                     <p>充值体验悦书超值会员行业最低价，包月套餐现仅需<span class="strong">10元</span></p>
                 </div>
                <div class="bottom">
                    <a href="####" class="btn btn_only_change">只转50页</a>
                    <a href="#" class="btn btn_recharge">立即充值</a>
                </div> 
        </div>        
        <div class="content" name="teachesDay">
            <div class="icon close" itemid="1" ></div>
            <a href="<?php echo U('Home/Index/YearMiddlePage',array('s_type'=>1));?>" itemtype="1" itemid="1" class="ClickTheBanner" >
                <img src="__IMAGES__images/x01.jpg"  alt="教师节抢购" />
            </a>
        </div>
        <div class="content" name="freeContent">
            <div class="icon close" itemid="2"></div>
            <a href="<?php echo U('Home/Index/YearMiddlePage',array('s_type'=>2));?>" itemtype="1" itemid="2" class="ClickTheBanner">
                <img src="__IMAGES__images/x02.jpg"  alt="教师节抢购" />
            </a>
        </div>             
    </div>
<input type="hidden" id="year" value="<?php echo ($year); ?>" />
<input type="hidden" id="month" value="<?php echo ($month); ?>" />
<input type="hidden" id="day" value="<?php echo ($day); ?>" />
<input type="hidden" id="start_time" value="<?php echo ($start_time); ?>" />
<input type="hidden" id="halfMonther" value="<?php echo ($halfMonther); ?>" />
<!--        <script src="__JS__jquery.js" type="text/javascript"></script>

	<script src="__JS__fixBox.js" type="text/javascript"></script>-->
        	<script>
	//首页fix导航
  
	</script>
<!--<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>-->
<script type="text/javascript" src="/Public/Tpl/v78/<?php echo ($view); ?>/js/require.js" data-main="/Public/Tpl/v78/<?php echo ($view); ?>/js/main"  defer async="true" ></script>


        <?php if(TPL!='sky'){ ?>
	    <noempty name="ary_online">
<style>
/*在线咨询   开始*/
.cusService { display:inline-block; position:fixed; left:0px; top:200px;}
.cusServiceCon { float:left; width:180px; border:1px solid #d7d7d7; background:white; display:none}
.cusServiceCon table { width:100%}
.cusServiceCon table thead td { border-bottom:1px solid #d7d7d7; color:#333; font-size:14px; text-shadow:1px 1px 3px #999;}
.cusServiceCon table td { padding:5px 0px; line-height:23px; padding-left:10px;}
.cusServiceCon table td.addBorder { border-top:1px dashed #d7d7d7;}
.cusServiceCon table td a { display:inline-block; white-space:nowrap}
.cusServiceCon table td span { position:relative; margin-left: 4px;}
.cusServiceCon table td a:hover { text-decoration:none; color:red;}
.cusServiceCon table tfoot td { border-top:1px sold #d7d7d7;}
a.cusSerClick { float:left; background:url(__PUBLIC__/Ucenter/images/customerService.jpg) no-repeat 0px -124px; width:42px; height:124px;}
a.cusSerClickAgain { background-position:0px 0px;}
/*在线咨询   结束*/
</style>
<?php if(isset($ary_online)): ?><div class="cusService" style="z-index:100"><!--cusService  客服 start-->
	<div class="cusServiceCon" id="cusCon">
    	<table>
        	<thead>
            	<tr>
                	<td><strong>在线咨询</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($ary_online)): $i = 0; $__LIST__ = $ary_online;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$online): $mod = ($i % 2 );++$i;?><tr><td align="center"><strong><?php echo ($online["oc_name"]); ?></strong></td></tr>
                <?php if(is_array($online["server"])): $i = 0; $__LIST__ = $online["server"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$server): $mod = ($i % 2 );++$i;?><tr>
                	<td>
                    	<?php echo ($server["o_code"]); ?><span><?php echo ($server["o_name"]); ?></span>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <tfoot>
            	<tr>
                	<td style="border-top:1px solid #d7d7d7;">在线时间：<?php echo (($online_start_time)?($online_start_time):'9:00'); ?>-<?php echo (($online_end_time)?($online_end_time):'18:00'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <a href="javascript:void(0)" class="cusSerClick" id="azx" style="display:block"></a>
</div><!--cusService  end-->
<script type="text/javascript">
/*$(function(){
	$("a.cusSerClick").hover(function(){
		$(".cusServiceCon").show();
		$(this).css("babkgroundPosition":"0px 0px")
	},function(){
		$(".cusServiceCon").hide();
		$(this).css("babkgroundPosition":"0px -124px")
	})
});*/

//window.onload=function(){
	var azx=document.getElementById('azx');
	var cus=document.getElementById('cusCon');
	
	azx.onclick=function(){
		if(cus.style.display=='block'){
			cus.style.display='none'
			this.style.backgroundPosition='0px -124px';
		}else {
			cus.style.display='block';
			this.style.backgroundPosition='0px 0px'
		}
	}
	
//}
</script><?php endif; ?>
</noempty>

        <?php } ?>
	        <div class="footer">
        <p>&nbsp;&nbsp;E-mail：<a href="mailto:service@cqttech.com" >service@cqttech.com</a>&nbsp;&nbsp;网址：<a href="http://www.cqttech.com" target="_blank">http://www.cqttech.com</a></p>
        <p>Copyright (C) 2017 IVY Tec. All Rights Reserved.  <a href="http://www.miibeian.gov.cn/" target="_blank">粤ICP备16105002号-2</a></p>
        <p>商务QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004139668&site=qq&menu=yes" target="_blank">3004139668</a> | 产品QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004198912&site=qq&menu=yes" target="_blank">3004198912</a> | 客服QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=3004137938&site=qq&menu=yes" target="_blank">3004137938</a></p>
    </div>

		<?php if($_SESSION['OSS']['GY_OSS_ON'] == '1'){ ?>
			<input type="hidden" value="1" id="oss_id" />
		<?php }else{ ?>
			<input type="hidden" value="0" id="oss_id" />
		<?php } ?>
		<?php if($ary_request[index]== true){ ?>
		<input type="hidden" id="is_index" value="1" />
		<?php }else{ ?>	
		<input type="hidden" id="is_index" value="0" />
		<?php } ?>
	    <!-- 是否有统计代码,有则显示  Start-->
		<?php if(isset($shop_code)): ?><noempty name="shop_code">
	    	<div class="statistics"><?php echo ($shop_code); ?></div>
	    </noempty><?php endif; ?>
	    <!-- 是否有统计代码，有则显示 End-->
	</body>
</html>