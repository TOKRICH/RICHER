<?php
include_once  '../../../Include/web_inc.php';
include_once  '../../../Templete/'.$webTemplate.'/Include/Function.php';
$str=infoview($ID,$db_conn,$Language);
$strs=pnlmcc($Language,$str['info_lanmu'],$db_conn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $str['info_title'];?></title>
    <meta content="<?php echo $str['info_keywords'];?>" name="keywords">
    <meta content="<?php echo $str['info_des'];?>" name="description">
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
                <h1 class="bread_nav_bt left"><?php echo $Label['tag_news'];?></h1>
                <div class="bread_nav right">
                    <a href="<?php echo $web_url; ?>"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/home.png" alt=""><?php echo $Label['tag_home']; ?></a><span class="fa fa-angle-double-right fgf"></span><a href="<?php echo $web_url . UrltoHtml('news/', 'list/', "pr")?>"><?php echo $Label['tag_news']?></a><span class="fa fa-angle-double-right fgf"></span><a href="<?php echo $web_url.UrltoHtml($strs['ID'],$strs['category_url'],"ne")?>"><span class="dqy"><?php echo $strs['category_name'];?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="mk news_detail_mk">
        <div class="center float_after">
            <div class="left mk_left">
                <div class="mk_category">
                    <div class="category_bt"><?php echo ucwords($Label['tag_news'])?></div>
                    <ul>
                        <?php echo wbnews($Language, $web_url, $db_conn)?>
                    </ul>
                </div>
                <div class="mk_product_list">
                    <div class="category_bt"><?php echo strtoupper($Label['tag_hot'])?></div>
                    <ul>
                        <?php echo indexpro("hot",$Language,$web_url,$webiflist,$db_conn,$web_url_meate,$Label['tag_inquiry'],$webinlist,$Label['tag_more'],'pc',$webTemplate,'')?>
                    </ul>
                </div>
            </div>
            <div class="right mk_right">
                <div class="news_detail_pic"><img src="<?php echo $web_url_meate.str_replace('../','',$str['info_image'])?>" alt=""></div>
                <div class="news_detail_bt"><?php echo $str['info_title'];?></div>
                <div class="news_detail_nr">
                    <?php echo $str['info_content'];?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php'?>
</div>
<script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/bothjs.js"></script>
<script>
    document.getElementById("nav_news_active").className="nav_active";
</script>
</body>
</html>