<?php
include_once  '../../../Include/web_inc.php';
include_once  '../../../Templete/'.$webTemplate.'/Include/Function.php';
if ($ID!=""){
    $str=pnlmcc($Language,$ID,$db_conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($ID==""){echo $protitle;}else{ echo $str['category_name'];}?></title>
    <meta content="<?php if($ID==""){echo $tag_prokey;}else{ echo $str['category_key'];}?>" name="keywords">
    <meta content="<?php if($ID==""){echo $tag_prodes;}else{ echo $str['category_des'];}?>" name="description">
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
                <h1 class="bread_nav_bt left"><?php echo $Label['tag_product'];?></h1>
                <div class="bread_nav right">
                    <a href="<?php echo $web_url; ?>"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/home.png" alt=""><?php echo $Label['tag_home']; ?></a><span class="fa fa-angle-double-right fgf"></span>
                    <?php if($ID!==''){?><a href="<?php echo $web_url . UrltoHtml('product/', '', "pr")?>"><?php echo $Label['tag_product']?></a><?php }else{?><span><?php echo $Label['tag_product']?></span><?php }?><?php if($ID!==''){echo lamcc($Language,$ID,$web_url,$db_conn,'product');}?>
                </div>
            </div>
        </div>
    </div>
    <div class="mk products_mk">
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
            <div class="right mk_right">
                <?php echo productslistp($Language,$Label['tag_inquiry'],$web_url,$Label['tag_more'],$ID,$webplist,$db_conn,$web_url_meate,$Label['tag_prev'],$Label['tag_next'],$webTemplate);?>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php'?>
</div>
<script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/bothjs.js"></script>
<script>
    document.getElementById("nav_product_active").className="nav_active";
</script>
</body>
</html>