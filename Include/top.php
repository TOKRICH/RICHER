<div class="body_mb"></div>
<div class="top">
    <div class="center">
        <?php echo  web_language($web_url_meate,$db_conn,$web_urls,$web_url_meate);?>
        <div class="head">
            <div class="logo"><a href="<?php echo $web_url?>"><img src="<?php echo $weblogo?>" alt=""></a></div>
            <?php if(isMobile()!==true){?>
            <div class="search">
                <form action="<?php echo $web_url; ?>search.php" class="float_after" method="post">
                    <div class="search_category left">
                        <div><?php echo $Label['tag_productcategory']?></div>
                        <ul>
                            <?php echo wbpro($Language,$db_conn,'top',$web_url_meate,$webTemplate,$web_url);?>
                        </ul>
                        <input type="hidden" value="" name="category" class="search_category_val">
                    </div>
                    <div class="search_k left">
                        <input type="text" placeholder="<?php echo $Label['tag_searchtit']?>" name="search" class="search_name_val"><button><?php echo ucwords($Label['tag_search'])?></button>
                    </div>
                </form>
            </div>
            <?php }?>
            <?php if($webtel!==''){?>
            <div class="head_lxfs"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/phone.png" alt=""><?php echo $webtel?></div>
            <?php }?>
        </div>
    </div>
</div>
<div class="nav_hz">
    <div class="center float_after">
        <div class="left nav_category">
            <div><span class="nav_icon"></span><span class="nav_wzbs"><?php echo ucwords($Label['tag_productcategory'])?></span></div>

                <?php echo wbpro($Language,$db_conn,'left',$web_url_meate,$webTemplate,$web_url);?>

        </div>
        <?php if(isMobile()===true){?>
        <div class="left sjd_search">
            <div class="search">
                <form action="<?php echo $web_url; ?>search.php" class="float_after"  method="post">
                    <div class="search_category left">
                        <div><?php echo $Label['tag_productcategory']?></div>
                        <ul>
                            <?php echo wbpro($Language,$db_conn,'top',$web_url_meate,$webTemplate,$web_url);?>
                        </ul>
                        <input type="hidden" value="" name="category" class="search_category_val">
                    </div>
                    <div class="search_k left">
                        <input type="text" placeholder="<?php echo $Label['tag_searchtit']?>" name="search" class="search_name_val"><button><?php echo ucwords($Label['tag_search'])?></button>
                    </div>
                </form>
            </div>
        </div>
        <?php }?>
        <div class="left nav_bf">
            <span class="sjd_nav_tb fa fa-bars"></span>
            <ul class="nav">
                <?php echo web_nav($Language,$web_url,$db_conn,$web_url_meate,$webTemplate,$weblogo,'home');?>
            </ul>
        </div>
        <?php if($webemail!==''){?>
            <div class="nav_lxfs left"><a href="mailto:<?php echo $webemail?>"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/email.png" alt=""><?php echo $webemail?></a></div>
        <?php }?>

    </div>
</div>
<input type="hidden" value="<?php echo $web_url_meate?>" id="sc_ajax_lujin">

