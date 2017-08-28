<?php if (!defined('THINK_PATH')) exit();?>
<div class="sendDis">
    <table>
        <tbody><tr>
            <th width="120" align="right" valign="top"><b>*</b> 咨询内容：</th>
            <td><textarea id="question_content" name="question_content"></textarea></td>
        </tr>
        <tr>
            <th></th>
            <td height="70"><input type="submit" id="addAdvice" value="发表咨询" class="sendD"></td>
        </tr>
        </tbody></table>
</div>
<div class="cs-main-wrap">
    <div class="cs-main-item">
        <ul class="cs-place-item clearfix">
            <li class="now" data-type="4" data-num="57">
                <p id="tabAbp3">购买咨询(0)</p>
            </li>
        </ul>
    </div>
    <div class="cs-main-target">
        <div class="cs-target-item clearfix">
            <?php if(is_array($data)): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($vo['pc_is_reply'] == 1): ?><div class="item clearfix">
                <div class="left">
                    <div class="question clearfix">
                        <div class="user"><i class="icon icon-ask"></i><p class="nickname"><?php echo (($vo["new_mname"])?($vo["new_mname"]):"匿名用户"); ?></p></div>
                        <div class="content"><p><?php echo ($vo["pc_question_content"]); ?></p></div>
                    </div>
                    <div class="answer clearfix">
                        <div class="user"><i class="icon icon-answer"></i><p class="nickname">客服回复：</p></div>
                        <div class="content"><?php echo ($vo["pc_answer"]); ?></div>
                    </div>
                </div>
                <!-- <div class="right r">
                    <div class="time">
                        <span><?php echo ($vo["pc_create_time"]); ?></span>
                    </div>
					<div class="action">
						<a href="###" class="like"><span>满意</span><em>(0)</em></a><a href="###" class="dislike"><span>不满意</span><em>(0)</em></a>
					</div>
                </div> -->
            </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
<div class="fenye" style="text-align:right"><!--fenye  start-->
<?php if($page['nowPage'] == 1){ ?>
<a class="next01" href="javascript:void(0);">首页</a>
<a class="prev" href="javascript:void(0);">上一页</a>
<?php } ?>
<?php if($page['nowPage'] != 1){ ?>
<a class="next on" href="javascript:void(0);" onclick="getGoodsAdvice('<?php echo ($filter["gid"]); ?>',1)">首页</a>
<a class="prev01" href="javascript:void(0);" onclick="getGoodsAdvice('<?php echo ($filter["gid"]); ?>',<?php echo $page['nowPage']-1; ?>)">上一页</a>
<?php } ?>
<?php $int_i = 1; $totalPage = 0; if($page['nowPage']<5 && $page['totalPage']>5){ $totalPage = 5; }else if($page['nowPage']<5 && $page['totalPage']<=5){ $totalPage = $page['totalPage']; } if($page['nowPage'] >=3){ $minPage = $page['totalPage'] - $page['nowPage']; if($minPage <4){ $totalPage = $page['totalPage']; $int_i = $page['totalPage']-4; }else{ $totalPage = $page['nowPage']+2; $int_i = $page['nowPage']-2; } if($int_i <= 0){ $int_i = 1; } } for($i=$int_i;$i<=$totalPage;$i++){ if($i == $page['nowPage']){ ?>
        <a class="on"><?php echo ($i); ?></a>
        <?php }else{ ?>
            <a onclick="getGoodsAdvice('<?php echo ($filter["gid"]); ?>','<?php echo ($i); ?>')"><?php echo ($i); ?></a>
        <?php } } ?>

<?php if($page['nowPage'] == $page['totalPage']){ ?>
<a class="next01" href="javascript:void(0);">下一页</a>
<a class="next01" href="javascript:void(0);">尾页</a>
<?php } ?>
<?php if($page['nowPage'] < $page['totalPage']){ ?>
<a class="next" href="javascript:void(0);" onclick="getGoodsAdvice('<?php echo ($filter["gid"]); ?>',<?php echo $page['nowPage']+1; ?>)">下一页</a>
<a class="next" href="javascript:void(0);" onclick="getGoodsAdvice('<?php echo ($filter["gid"]); ?>','<?php echo ($page["totalPage"]); ?>')">尾页</a>
<?php } ?>
</div>
<script>
    window.onload = function(){
        var count = "<?php echo ($count); ?>";
        if(count == ''){
            $("#tabAbp3").html("购买咨询（0）");
        }else{
            $("#tabAbp3").html("购买咨询（"+count+"）");
        }

    };
    $("#addAdvice").click(function(){
        var question_content = $("#question_content").val();
        if(question_content == ''){
            $.ThinkBox.error('咨询内容不能为空');return false;
        }
        var gid = '<?php echo ($filter["gid"]); ?>';
        var mid = '<?php echo ($_SESSION['Members']['m_id']); ?>';
        var m_name = '<?php echo ($_SESSION['Members']['m_name']); ?>';
        var url = '/Home/Products/doGoodsAdvice';
        $.post(url,{'gid':gid,'mid':mid,'question_content':question_content,'type':1,'question_title':'提问'},function(msgObj){
            if(msgObj.status == '1'){
                $.ThinkBox.success(msgObj.info);
                var _mvq = window._mvq || [];window._mvq = _mvq;
                _mvq.push(['$setAccount', 'm-24416-0']);

                _mvq.push(['$setGeneral', 'consult', '', /*用户名*/ m_name, /*用户id*/ mid]);
                _mvq.push(['$logConversion']);

                getGoodsAdvice(gid,1);
                return false;;
            }else{
                $.ThinkBox.error(msgObj.info);
                return;
            }
        },'json')
    });
</script>