<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $indextitle;?></title>
    <meta content="<?php echo $tag_indexkey;?>" name="keywords">
    <meta content="<?php echo $tag_indexdes;?>" name="description">
    <link rel="shortcut icon" href="<?php echo $webico;?>" />
    <link rel="stylesheet" href="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Css/bothstyle.css">
    <link rel="stylesheet" href="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Css/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/jquery-3.2.1.js"></script>
    <script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/swiper-4.3.3.min.js"></script>
    <?php echo $webmeate; ?>
</head>
<body>
<?php echo $webgoogle; ?>
<div>
    <?php require_once 'top.php'?>
    <div class="banner">
        <div class="swiper-container" id="banner_lb">
            <?php echo  web_banner("nr",$Language,$db_conn,$web_url_meate,"index");?>
        </div>
    </div>
    <div class="home_mk featured_mk">
        <div class="center">
            <div class="home_mk_bt">
                <div>
                    <div class="home_mk_xbt">Its Our Great Product</div>
                    <div class="home_mk_zbt"><?php echo ucwords($Label['tag_tuijian'])?></div>
                </div>
            </div>
            <?php if(isMobile()===true){?>
                <div class="sjd_featured float_after">
                    <?php echo indexpro("tj",$Language,$web_url,$webiflist,$db_conn,$web_url_meate,$Label['tag_inquiry'],$webinlist,$Label['tag_more'],'sj',$webTemplate,$Label['tag_tuijian']);?>
                </div>
            <?php }else{?>
                <?php echo indexpro("tj",$Language,$web_url,$webiflist,$db_conn,$web_url_meate,$Label['tag_inquiry'],$webinlist,$Label['tag_more'],'pc',$webTemplate,$Label['tag_tuijian']);?>
            <?php }?>
            <div style="width:100%;float:left; text-align: center; margin-top: 20px; margin-bottom:10px; cursor:pointer;" onclick="window.location.href='product/';"><span style="display: inline-block; padding: 8px 10px; border:1px solid #000;">View More</span></div>


        </div>
    </div>
    <div class="home_about">
        <div class="center">
            <div class="float_after">
                <div class="left home_about_pic">
                    <?php if(@getimagesize($web_url_meate.'Images/prdoucts/about.png')!==false){?>
                        <img src="<?php echo $web_url_meate?>Images/prdoucts/about.png" alt="">
                    <?php }else{?>
                    <img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/home-about-img.png" alt="">
                <?php }?>
                </div>
                <div class="right home_about_wzk">
                    <div class="home_mk_bt">
                        <div>
                            <div class="home_mk_xbt">Stockholm Light</div>
                            <div class="home_mk_zbt"><?php echo ucwords($Label['tag_about'])?></div>
                        </div>
                    </div>
                    <?php echo $tag_homeabout;?>
                </div>
            </div>
        </div>
    </div>
    <div class="home_mk new_products_mk">
        <div class="center">
            <div class="home_mk_bt">
                <div>
                    <div class="home_mk_xbt">Its Our Great Product</div>
                    <div class="home_mk_zbt"><?php echo ucwords($Label['tag_hot'])?></div>
                </div>
            </div>
            <?php if(isMobile()===true){?>
                <div class="sjd_featured float_after">
                    <?php echo indexpro("zx",$Language,$web_url,$webiflist,$db_conn,$web_url_meate,$Label['tag_inquiry'],$webinlist,$Label['tag_more'],'sj',$webTemplate,$Label['tag_tuijian']);?>
                </div>
            <?php }else{?>
                <?php echo indexpro("zx",$Language,$web_url,$webiflist,$db_conn,$web_url_meate,$Label['tag_inquiry'],$webinlist,$Label['tag_more'],'pc',$webTemplate,$Label['tag_tuijian']);?>
            <?php }?>

            <div style="width:100%;float:left; text-align: center; margin-top: 20px; margin-bottom:10px; cursor:pointer;" onclick="window.location.href='product/';"><span style="display: inline-block; padding: 8px 10px; border:1px solid #000;">View More</span></div>
        </div>
    </div>
    <div class="home_mk news_letter_mk">
        <div class="center">
            <div class="news_letter_pic"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/newletter-email.png" alt=""></div>
            <div class="news_letter_bt"><?php echo ucwords($Label['tag_newsletter'])?></div>
            <div class="news_letter_ms"><?php echo $Label['tag_newsletterdes']?></div>
            <form action="#">
                <input type="text" placeholder="<?php echo ucwords($Label['tag_entermail'])?>"><button><?php echo ucwords($Label['tag_send'])?></button><div class="sc_tsy"></div>
            </form>
        </div>
    </div>
    <div class="home_mk last_news_mk">
        <div class="center">
            <div class="home_mk_bt">
                <div>
                    <div class="home_mk_xbt">Recent Post</div>
                    <div class="home_mk_zbt"><?php echo ucwords($Label['tag_lastnews'])?></div>
                </div>
            </div>
            <?php if(isMobile()===true){?>
                <div class="sjd_featured float_after">
                    <?php echo indexwbnews($Language,$web_url,$db_conn,$web_url_meate,$webTemplate,$Label['tag_more'],'sj',$Label['tag_lastnews']);?>
                </div>
            <?php }else{?>
                <?php echo indexwbnews($Language,$web_url,$db_conn,$web_url_meate,$webTemplate,$Label['tag_more'],'pc',$Label['tag_lastnews']);?>
            <?php }?>


        </div>
    </div>
    <div class="hz_sj home_mk">
        <div class="center">
            <?php echo web_link($Language, $db_conn, $web_url_meate)?>
        </div>
    </div>
    <?php require_once 'footer.php'?>
</div>
<script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/bothjs.js"></script>
<script>
    document.getElementById("nav_home_active").className="nav_active";
    $(document).ready(function () {
        var swiper1 = new Swiper('#banner_lb', {
            autoplay: true,
            speed:3000,
            navigation: {
                nextEl: '#banner_next',
                prevEl: '#banner_prev'
            },
            loop : true
        });
        var featured_cs="";
        if($("#featured_lb .swiper-slide").length<=1){
            featured_cs=false;
        }else{
            featured_cs=true;
        }
        var swiper3 = new Swiper('#featured_lb', {
            autoplay: false,
            speed:1000,
            navigation: {
                nextEl: '#featured_next',
                prevEl: '#featured_prev'
            },
            loop : featured_cs
        });
        var loop_cs="";
        if($("#new_products_mk_lb .swiper-slide").length<=3){
            loop_cs=false;
        }else{
            loop_cs=true;
        }
        var swiper4 = new Swiper('#new_products_mk_lb', {
            slidesPerView : 4,
            spaceBetween : 27,
            navigation: {
                nextEl: '#new_products_mk_next',
                prevEl: '#new_products_mk_prev'
            },
            speed:1000,
            loop : loop_cs
        });
        var last_news_cs="";
        if($("#last_news_lb .swiper-slide").length<=1){
            last_news_cs=false;
        }else{
            last_news_cs=true;
        }
        var swiper5 = new Swiper('#last_news_lb', {
            slidesPerView : 2,
            spaceBetween : 50,
            navigation: {
                nextEl: '#last_news_next',
                prevEl: '#last_news_prev'
            },
            speed:1000,
            loop : last_news_cs
        });
        var hz_sj_cs="";
        if($("#category_lb .swiper-slide").length<=6){
            hz_sj_cs=false;
        }else{
            hz_sj_cs=true;
        }
        var swiper6 = new Swiper('#hz_sj_lb', {
            slidesPerView : 7,
            spaceBetween : 70,
            autoplay: false,
            speed:1000,
            navigation: {
                nextEl: '#hz_sj_next',
                prevEl: '#hz_sj_prev'
            },
            loop : hz_sj_cs
        });
    });
</script>
</body>
</html>