<?php
session_start();
include_once  '../../../Include/web_inc.php';
include_once  '../../../Templete/'.$webTemplate.'/Include/Function.php';
$prv=proview($ID,"All",$web_url,$db_conn,$web_url_meate,$webTemplate,$Language); //All 是用来区分图片 与目录
$prcate=proview($ID,"products_category",$web_url,$db_conn,$web_url_meate,$webTemplate,$Language);
$Pid=proview($ID,"category",$web_url,$db_conn,$web_url_meate,$webTemplate,$Language);
$primg=proview($ID,"products_Images",$web_url,$db_conn,$web_url_meate,$webTemplate,$Language);
$products_aurls=$prv['products_aurl'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if(empty($prv['products_metatit'])){echo $prv['products_name'];}else{echo $prv['products_metatit'];}?></title>
    <meta content="<?php echo $prv['products_key'];?>" name="keywords">
    <meta content="<?php echo $prv['products_des'];?>" name="description">
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
    <div class="bread_nav_hz">
        <div class="center">
            <div class="float_after">
                <div class="bread_nav_bt left"><?php echo $Label['tag_product'];?></div>
                <div class="bread_nav right">
                    <a href="<?php echo $web_url; ?>"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/home.png" alt=""><?php echo $Label['tag_home']; ?></a><span class="fa fa-angle-double-right fgf"></span><a href="<?php echo $web_url . UrltoHtml('product/', '', "pr")?>"><?php echo $Label['tag_product']?></a><?php echo lamcc($Language,$Pid,$web_url,$db_conn,'view') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mk product_detail_mk">
        <div class="center float_after">
            <div class="left mk_left">
                <div class="mk_category">
                    <div class="category_bt"><?php echo ucwords($Label['tag_productcategory'])?></div>
                    <?php echo get_str2(1, $Language, $db_conn, $web_url, '<ul>', 'ps',$web_url_meate,$webTemplate);?>
                </div>
                <div class="mk_product_list">
                    <div class="category_bt"><?php echo strtoupper($Label['tag_hot'])?></div>
                    <ul>
                        <?php echo indexpro("hot",$Language,$web_url,$webiflist,$db_conn,$web_url_meate,$Label['tag_inquiry'],$webinlist,$Label['tag_more'],'pc',$webTemplate,'')?>
                    </ul>
                </div>
            </div>
            <?php $_SESSION['authcode']=1 ;
            ?>
            <div class="right mk_right">
                <div class="product_detail float_after">
                    <?php echo $primg?>
                    <div class="right pro_det_nr">
                        <h1><?php echo $prv['products_name']?></h1>
                        <div class="products_xh"><?php echo $Label['tag_Item']?>: <?php echo $prv['products_model']?></div>
                        <div class="products_sx">
                            <?php echo $prv['products_guige'];?>
                        </div>
                        <div class="product_detail_an">
                            <a href="javascript:" class="inquiry_an"><?php echo ucwords($Label['tag_inquiry']);?></a>
                            <?php if(!empty($products_aurls)){echo '<a href="'.$products_aurls.'" class="buy_now_an">'.$Label['tag_buynow'].'</a>';}?>
                        </div>
<!--                         <div class="share_hz">
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58c4eabb859efec7"></script>
                            <div class="addthis_inline_share_toolbox" ></div>
                        </div> -->
                    </div>
                </div>
                <div class="description">
                    <div class="tab_qh_small">
                        <div class="tab_small_active"><a href="javascript:"><?php echo ucwords($Label['tag_proxxms'])?></a></div>
                        <div><a href="javascript:"><?php echo ucwords($Label['tag_inquiry'])?></a></div>
                    </div>
                    <div class="tab_qh_big">
                        <div class="tab_big_active tab_big_wznr">
                            <?php echo $prv['products_content'];?>
                        </div>
                        <div>
                            <form action="#">
                                <div>
                                    <input type="text" placeholder="<?php echo ucwords($Label['tag_name'])?>" class="inquiry_name_srk">
                                </div>
                                <div>
                                    <input type="text" placeholder="<?php echo ucwords($Label['tag_tel'])?>" class="inquiry_tel_srk">
                                </div>
                                <div>
                                    <input type="text" placeholder="<?php echo ucwords($Label['tag_email'])?>" class="inquiry_mail_srk">
                                </div>
                                <div>
                                    <textarea name="msg" id="message" placeholder="<?php echo ucwords($Label['tag_content'])?>"></textarea>
                                </div>
                                <input type="hidden" value="1" class="inquiry_code_srk">
                                <input type="hidden" value="<?php echo $prv['ID'];?>" id="PID" name="PID"><input type="hidden" value="<?php echo $Language;?>" name="languageID" id="languageID">
                                <div>
                                    <button><?php echo ucwords($Label['tag_send'])?></button>
                                </div>
                                <div class="sc_tsy"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home_mk related ">
        <div class="center">
            <div class="home_mk_bt">
                <div>
                    <div class="home_mk_xbt">Its Our Great Product</div>
                    <div class="home_mk_zbt"><?php echo ucwords($Label['tag_proxgcp'])?></div>
                </div>
            </div>
            <?php if(isMobile()===true){?>
                <div class="sjd_featured float_after">
                    <?php echo sjpro($Language, $Label['tag_inquiry'],$prcate,$web_url,$db_conn,$web_url_meate,$Label['tag_more'],'pc',$webTemplate);?>
                </div>
            <?php }else{?>
                <div class="swiper-container" id="new_products_mk_lb">
                    <div class="swiper-wrapper">
                        <?php echo sjpro($Language, $Label['tag_inquiry'],$prcate,$web_url,$db_conn,$web_url_meate,$Label['tag_more'],'pc',$webTemplate);?>
                    </div>
                </div>
                <div class="home_mk_an">
                    <div class="swiper-button-prev" id="new_products_mk_prev"></div>
                    <div class="swiper-button-next" id="new_products_mk_next"></div>
                </div>
            <?php }?>
        </div>
    </div>
    <?php require_once 'footer.php'?>
</div>
<script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/bothjs.js"></script>
<script>
    document.getElementById("nav_product_active").className="nav_active";
    $(document).ready(function () {
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
    });
</script>
</body>
</html>