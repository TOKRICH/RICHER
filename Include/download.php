<?php
include_once  '../../../Include/web_inc.php';
include_once  '../../../Templete/'.$webTemplate.'/Include/Function.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $Label['tag_download'];?></title>
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
                <h1 class="bread_nav_bt left"><?php echo ucwords($Label['tag_download']);?></h1>
                <div class="bread_nav right">
                    <a href="<?php echo $web_url; ?>"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/home.png" alt=""><?php echo $Label['tag_home']; ?></a><span class="fa fa-angle-double-right fgf"></span><span class="dqy"><?php echo ucwords($Label['tag_download']);?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="mk download_mk">
        <div class="center">
            <ul class="float_after">
                <?php echo downloadfile($Language,$web_url,$Label['tag_download'],$db_conn,$web_url_meate,$webTemplate,$webplist, $Label['tag_prev'], $Label['tag_next'])?>
            </ul>
        </div>
    </div>
    <?php require_once 'footer.php'?>
</div>
<script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/bothjs.js"></script>
<script>
    document.getElementById("nav_download_active").className="nav_active";
</script>
</body>
</html>