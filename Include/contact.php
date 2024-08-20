<?php
include_once  '../../../Include/web_inc.php';
include_once  '../../../Templete/'.$webTemplate.'/Include/Function.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $Label['tag_contact'];?></title>
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
                <h1 class="bread_nav_bt left"><?php echo $Label['tag_contact'];?></h1>
                <div class="bread_nav right">
                    <a href="<?php echo $web_url; ?>"><img src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Images/home.png" alt=""><?php echo $Label['tag_home']; ?></a><span class="fa fa-angle-double-right fgf"></span><span class="dqy"><?php echo $Label['tag_contact'];?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="mk contact_mk">
        <div class="center float_after">
            <form class="right contact_bdk">
                <div>
                    <div class="contact_bd_bt"><?php echo ucwords($Label['tag_name'])?></div>
                    <input type="text" class="name_srk">
                </div>
                <div>
                    <div class="contact_bd_bt"><?php echo ucwords($Label['tag_email'])?></div>
                    <input type="text" class="email_srk">
                </div>
                <div>
                    <div class="contact_bd_bt"><?php echo ucwords($Label['tag_tel'])?></div>
                    <input type="text" class="tel_srk">
                </div>
                <div>
                    <div class="contact_bd_bt"><?php echo ucwords($Label['tag_content'])?></div>
                    <textarea name="msg" id="msg"></textarea>
                </div>
                <div>
                    <div class="contact_bd_bt"><?php echo ucwords($Label['tag_code'])?></div>
                    <input type="text" class="pin_srk"><img id="captcha_img" border='1' src='<?php echo $web_url_meate;?>Include/web_code.php?r=<?php echo rand(); ?>' onclick="document.getElementById('captcha_img').src='<?php echo $web_url_meate;?>Include/web_code.php?r='+Math.random()"  align="absmiddle" />
                </div>
                <input type="hidden" value="0" id="PID" name="PID"><input type="hidden" value="<?php echo $Language;?>" name="languageID" id="languageID">
                <div>
                    <button><?php echo strtoupper($Label['tag_send'])?></button>
                </div>
                <div class="sc_tsy"></div>
            </form>
            <div class="lxwm">
            <?php echo $tag_contacts;?>
           </div>
        </div>
    </div>
    <?php require_once 'footer.php'?>
</div>
<script src="<?php echo $web_url_meate;?>Templete/<?php echo $webTemplate;?>/Js/bothjs.js"></script>
<script>
    document.getElementById("nav_contact_active").className="nav_active";
</script>
</body>
</html>