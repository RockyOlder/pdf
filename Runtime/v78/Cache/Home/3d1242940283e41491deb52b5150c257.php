<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>取消支付</title>
<link rel="stylesheet" type="text/css" href="/Public/Tpl/v78/<?php echo ($view); ?>/css/clientstyle.css"/>
<script src="/Public/Tpl/v78/<?php echo ($view); ?>/js/jquery.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
 <!-- 各种状态的弹窗 -->
    <div class="popup popup_other">
        <div class="content" name="content_whycansel">
            <form id='submitSkipFrom' name="submitSkipFrom" method="post" action="/Home/Products/send_order_feedback">
                 <h4>亲，为何要取消支付呢？</h4>
                 <ul class="choose_reason">
                     <li data="0"><i></i>选错啦</li>
                     <li data="1"><i></i>价格小贵，我再想想</li>
                     <li data="2"><i></i>转换质量有待提高</li>
                 </ul>
                 <textarea class="other_resson" maxlength="100" name='content' placeholder="其他内容"></textarea>
                <div class="bottom">
                    <div class="btn btn_contain_pay" onclick="history.back()">返回支付</div>
                    <div class="btn btn_submit">提交</div>
                </div> 
                <input type="hidden" id="o_id" value="<?php echo ($o_id); ?>" name='o_id' />
                <input type="hidden" id="token" value="<?php echo ($token); ?>" name='token' />
                <input type="hidden" id="state" value="0" name='state' />
             </form>
        </div>
    </div>

<script type="text/javascript">
    $('.choose_reason li').click(function(){
        $("#state").val($(this).attr('data'));
        $('.btn_submit').attr('name','submit');
        $(this).addClass('on').siblings().removeClass('on');
        $('.btn_submit').addClass('on');
    })
    $('.other_resson').keyup(function(event) {
         var val = $('.other_resson').val();
         var Lilen = $('.choose_reason li.on').length;
         var len = val.toString().length;
         if(len>2 || Lilen>0){
            $('.btn_submit').attr('name','submit');
            $('.btn_submit').addClass('on');
         }else{
            $('.btn_submit').removeAttr('name');
         };
    });
    //生成支付宝订单
   $(document).on('click','.btn_submit[name="submit"]',function(){
         $("#submitSkipFrom").submit();
    })
</script>
</body>
</html>