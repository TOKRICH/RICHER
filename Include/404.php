<?php
include_once  '../../../Include/web_inc.php';
include_once  '../../../Templete/'.$webTemplate.'/Include/Function.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>404</title>
    <link rel="stylesheet" href="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Css/bothstyle.css">
    <link rel="stylesheet" href="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Css/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<!--header-->

<!--yem_ds-->
<div class="yem_ds">
    <div class="center">
        <p><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/404.jpg" alt=""></p>
        <p class="float_after">

            <a href="#"  onClick="javascript :history.back(-1);"" class="left"><span class="fa fa-angle-double-left"></span><?php echo $Label['tag_prev']?></a>
            <a  href="<?php echo $web_url; ?>" class="right"><?php echo $Label['tag_home']?><span class="fa fa-angle-double-right"></span></a>
        </p>
    </div>
</div>
<!--footer-->

</body>
</html>