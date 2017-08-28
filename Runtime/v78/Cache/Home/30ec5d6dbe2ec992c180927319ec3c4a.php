<?php if (!defined('THINK_PATH')) exit();?>
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