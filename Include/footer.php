<div class="footer">
    <div class="footer_top">
        <div class="center">
            <div class="footer_fllow_us">
                <?php echo wbfollowus($webshare);?>
            </div>
            <ul class="footer_top_list float_after">
                <li class="left">
                    <div class="footer_list_bt"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-icon.png" alt=""><?php echo strtoupper($Label['tag_contact']);?> <span class="right fa fa-plus"></span></div>
                    <ul>
                        <?php if($webtel!==''){?>
                            <li><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-phone.png" alt=""><?php echo $webtel?></li>
                        <?php }?>
                        <?php if($webwathsapp!==''){?>
                            <li><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-whatsapp.png" alt=""><?php echo $webwathsapp?></li>
                        <?php }?>
                        <?php if($webemail!==''){?>
                            <li><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-email.png" alt=""><a href="mailto:<?php echo $webemail?>"><?php echo $webemail?></a></li>
                        <?php }?>
                        <?php if($webskype!==''){?>
                            <li><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-skype.png" alt=""><a href="skype:<?php echo $webskype?>?chat"><?php echo $webskype?></a></li>
                        <?php }?>
                    </ul>
                </li>
                <li class="left">
                    <div class="footer_list_bt"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-icon.png" alt=""><?php echo strtoupper($Label['tag_productcategory']);?> <span class="right fa fa-plus"></span></div>
                    <ul>
                        <?php echo wbpro($Language,$db_conn,'product',$web_url_meate,$webTemplate,$web_url);?>
                    </ul>
                </li>
                <li class="left">
                    <div class="footer_list_bt"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-icon.png" alt=""><?php echo strtoupper($Label['tag_about']);?> <span class="right fa fa-plus"></span></div>
                    <ul>
                        <?php echo wbabout("About",$Language,$web_url,$db_conn,$web_url_meate,$webTemplate);?>
                    </ul>
                </li>
                <li class="left">
                    <div class="footer_list_bt"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/footer-icon.png" alt=""><?php echo strtoupper($Label['tag_news']);?> <span class="right fa fa-plus"></span></div>
                    <ul>
                        <?php echo wbnewss($Language,$web_url,$db_conn,$web_url_meate,$webTemplate);?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer_bottom"><?php echo $webcopy.$CopyRight;?></div>
</div>
