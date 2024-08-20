<?php
ini_set('display_errors', 'on');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_GET["ID"])) {
    $ID = test_input(verify_str($_GET["ID"]));
} else {
    $ID = "";
}
if (isset($_GET["page"])) {
    $page = test_input(verify_str($_GET["page"]));
} else {
    $page = "";
}

if (isset($_POST["search"])) {
    $search = test_input(verify_str($_POST["search"]));
    $search = str_replace("_", "\_", $search);
    $search = str_replace("%", "\%", $search);
} else {
    $search = "";
}
if (isset($_POST["category"])) {

    $category = $_POST["category"];
} else {
    $category = "";
}


//网站 导航

function web_nav($Language, $web_url, $db_conn, $web_url_meate, $webTemplate, $weblogo,$type)
{
    $nav = "";
    $query = $db_conn->query("select * from sc_menu where languageID=$Language  order by  menu_paixu asc,ID asc");
    while ($row = mysqli_fetch_array($query)) {
        if (strlen($row['menu_link']) < 2) {

            $linkurl = str_replace("/", "", $row['menu_link']);

        } else {

            $linkurl = $row['menu_link'];

        }
        if(htmlopen == 1){
            if($linkurl!==''){
                if(strpos(UrltoHtmlNav($row['menu_link']),'download')!==false || strpos(UrltoHtmlNav($row['menu_link']),'contact')){
                    $class = explode('.',explode('/', UrltoHtmlNav($row['menu_link']))[1])[0];
                }else{
                    $class = explode('/', UrltoHtmlNav($row['menu_link']))[0];
                }
            }

        }else{
            $class = explode('.', UrltoHtmlNav($row['menu_link']))[0];
        }

        if($row['menu_link']==='/'){
            $class='home';
        }
        if($type==='home'){
            if ($row['menu_xiala'] === '1') {
                $jiantou='<span class="right fa fa-angle-down"></span>';
                if (strpos($row['menu_link'], 'product') !== false) {
                    $xiala = get_str2(1, $Language, $db_conn, $web_url, '<ul class="children_nav">', 'pr',$web_url_meate,$webTemplate);
                } else if (strpos($row['menu_link'], 'about') !== false) {
                    $xiala = '<ul class="children_nav">' . about_xiala('About', $Language, $web_url, $db_conn) . '</ul>';
                } else if (strpos($row['menu_link'], 'news') !== false) {
                    $xiala = '<ul class="children_nav">' . wbnews($Language, $web_url, $db_conn) . '</ul>';
                }
            } else {
                $jiantou='';
                $xiala = '';
            }
            $nav .='<li id="nav_'.$class.'_active"><a href="' . $web_url .UrltoHtmlNav($linkurl) . '">' . $row['menu_name']. '</a>' .$jiantou. $xiala . '</li>';
        }else{
            $nav .='<li><a href="' . $web_url .UrltoHtmlNav($linkurl) . '">' . $row['menu_name'].'</a></li>';
        }

    }

    return datato($nav);
}


/*导航下拉*/
function xia_la($id, $Language, $db_conn, $web_url, $web_url_meate)
{
    $str = "";
    $strs = "";
    $Str = "";
    $result = $db_conn->query("select * from sc_categories where category_pid= $id and languageID=$Language and category_open=1 order by category_paixu,ID asc");

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) { //循环记录集
                $str .= ' <li><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '" title="' . $row['category_name'] . '">' . $row['category_name'] . '</a></li>';
                $strs .= '<li class="prot_item"><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '"><img src="' . $web_url_meate . str_replace('../', '', $row['category_img']) . '" alt=""></a></li>';
            }
            /*while ($row = mysqli_fetch_array($result)) { //循环记录集
                echo $row['banner_image'];
            }*/
            $Str = '<div class="float_after nav_product"><ul class="nav_product_left left">' . $str . '</ul><ul class="nav_product_right left">' . $strs . '</ul></div>';
        }

    }
    return $Str;
}
//广告
function web_gg($str, $Language, $db_conn, $web_url_meate, $flg)
{ //banner

    $banners = "";
    $query = $db_conn->query("select * from sc_banner where languageID=$Language and banner_fenlei='$flg' order by  banner_paixu asc,ID asc");
    Panduan(mysqli_num_rows($query));

    while ($row = mysqli_fetch_array($query)) {

        if ($str == "nr") {
            $banners .='<li class="pro_qh_item"><a href="'.$row['banner_url'].'"><img src="' . $web_url_meate . str_replace('../', '', $row['banner_image']) . '" alt=""></a></li>';

        } else {

            $banners .= '';
        }
    }



    return $banners;
}
//banner

function web_banner($str, $Language, $db_conn, $web_url_meate, $flg)
{ //banner

    $banners = "";
    $query = $db_conn->query("select * from sc_banner where languageID=$Language and banner_fenlei='$flg' order by  banner_paixu asc,ID asc");
    Panduan(mysqli_num_rows($query));

    while ($row = mysqli_fetch_array($query)) {

        if ($str == "nr") {
            $banners .= '<div class="swiper-slide"><a href="'.$row['banner_url'].'">
                    <img src="' . $web_url_meate . str_replace('../', '', $row['banner_image']) . '" alt=""></a>
                </div>';

        } else {

            $banners .= '';
        }
    }
    if($banners!==''){
        $banners='
            <div class="swiper-wrapper">
                
                '.$banners.'
                </div>
            <div class="banner_an_hz">
                <div class="swiper-button-prev" id="banner_prev"></div>
                <div class="swiper-button-next" id="banner_next"></div>
            </div>
        ';
    }


    return $banners;
}

//友情链接

function web_link($Language, $db_conn, $web_url_meate)
{

    $link = "";
    $query = $db_conn->query("select * from sc_link where languageID=$Language  order by  link_paixu asc,ID asc");
    if (mysqli_num_rows($query) > 0) {

        while ($row = mysqli_fetch_array($query)) {
            $link .='
                <div class="swiper-slide">
                    <a href="'.$row['link_url'].'"><img src="' . $web_url_meate . str_replace('../', '', $row['link_image']) . '" alt="'.$row['link_name'].'"></a>
                </div>
            ';

        }
        $link='<div class="swiper-container" id="hz_sj_lb">
                <div class="swiper-wrapper">'.$link.'</div>
            </div>
            <div class="swiper-button-prev" id="hz_sj_prev"></div>
            <div class="swiper-button-next" id="hz_sj_next"></div>';
        return $link;

    }


}


//语言汇总
function web_language($web_url, $db_conn,$web_urls,$web_url_meate)
{

    $lge = "";
    $query = $db_conn->query("select * from sc_language where language_open=1  order by language_paixu asc,ID asc");
    if (mysqli_num_rows($query) > 1) {
        while ($row = mysqli_fetch_array($query)) {

            if ($row['language_mulu'] == 1) {//判断根目录网站
                $lge .='<li class="left"><a href="' . $web_url . '"><img src="'.$web_url_meate.str_replace('../','',$row['language_Image']).'" alt=""><span>' . $row['language_ename'] . '</span></a></li>';
            } else {
                $lge .='<li class="left"><a href="' . $web_url . $row['language_url'] . '/"><img src="'.$web_url_meate.str_replace('../','',$row['language_Image']).'" alt=""><span>' . $row['language_ename'] . '</span></a></li>';
            }
        }
        $lge='<ul class="yzk float_after">'.$lge.'</ul>';
        return datato($lge);
    }
}

/*关于我们下拉*/
function about_xiala($str, $Language, $web_url, $db_conn)
{
    $lanmuid = checkinfos($str, $Language, $db_conn);

    $aboulm = "";
    $query = $db_conn->query("select * from sc_info where languageID=$Language and info_lanmu=$lanmuid");
    if ($query) {
        while ($row = mysqli_fetch_array($query)) {
            $aboulm .= '<li><a href="' . $web_url . UrltoHtml($row['ID'], $row['info_url'], "ab") . '" title="' . $row['info_title'] . '">' . $row['info_title'] . '</a></li>';
        }
    }
    return datato($aboulm);

}

/*关于我们分类显示*/
function Abouttype($str, $ID, $Language, $web_url, $db_conn, $web_url_meate, $webTemplate,$category)
{
    $lanmuid = checkinfos($str, $Language, $db_conn);

    $aboulm = "";
    $query = $db_conn->query("select * from sc_info where languageID=$Language and info_lanmu=$lanmuid");
    if ($query) {
        while ($row = mysqli_fetch_array($query)) {
            if(is_numeric($ID)){
                if($ID===$row['ID']){
                    $aboulm.='<li class="about_item_active">';
                }else{
                    $aboulm.='<li>';
                }
            }else{
                if($ID===$row['info_url']){
                    $aboulm.='<li class="about_item_active">';
                }else{
                    $aboulm.='<li>';
                }
            }
            $aboulm .='<a href="' . $web_url . UrltoHtml($row['ID'], $row['info_url'], "ab") . '" title="' . $row['info_title'] . '">' . $row['info_title'] . '</a></li>';
        }
    }
    return datato($aboulm);

}


/*其他页面banner显示*/
function Banner($str, $Language, $web_url_meate, $db_conn, $webTemplate)
{
    $query = $db_conn->query("select * from sc_menu where menu_link LIKE '%$str%'  and  languageID=$Language");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        if ($row['menu_banner'] !== '' && $row['menu_banner'] !== null) {
            $image = '<img src="' . $web_url_meate . str_replace('../', '', $row['menu_banner']) . '" alt="">';
        } else {
            $image = '<img src="' . $web_url_meate . 'Templete/' . $webTemplate . '/Images/banner.jpg" alt="">';
        }
    } else {
        $image = '';
    }
    return $image;
}

/*上一个新闻  下一个新闻*/
function PrevNews($db_conn, $Language, $id, $web_url, $tag_prev, $tag_next,$web_url_meate,$webTemplate)
{
    $where = "";
    $Query = $db_conn->query("select * from sc_categories where languageID=$Language and category_pid=2 and category_open=1 and category_url<>'About'");
    while ($Row = mysqli_fetch_array($Query)) {
        $where .= 'info_lanmu= ' . $Row['ID'] . ' or ';
    }
    $where = substr($where, 0, -4);
    if (is_numeric($id)) {// 判读获取的ID 是否自定义

        $query = $db_conn->query("select * from sc_info where languageId=$Language and ID<$id and ($where) order by ID desc");
        $querys = $db_conn->query("select * from sc_info where languageId=$Language and ID>$id and ($where) order by ID asc");
    } else {
        $id = $db_conn->query("select * from sc_info where  info_url='" . $id . "' ");
        $id = mysqli_fetch_array($id)['ID'];
        $query = $db_conn->query("select * from sc_info where languageId=$Language and ID<$id and ($where) order by ID desc");
        $querys = $db_conn->query("select * from sc_info where languageId=$Language and ID>$id and ($where) order by ID asc");
    }
    $prev = mysqli_fetch_array($query);

    $next = mysqli_fetch_array($querys);

    if (mysqli_num_rows($query) > 0) {
        $PrevHtml = '<div class="left"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/news-detail-arrow.png">' . $tag_prev . ' : <a href="' . $web_url . UrltoHtml($prev['ID'], $prev['info_url'], "nv") . '" title="'.$prev['info_title'].'">'.$prev['info_title'].'</a></div>';
    } else {
        $PrevHtml = '';
    }
    if (mysqli_num_rows($querys) > 0) {
        $NextHtml ='<div class="right"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/news-detail-arrow.png">' . $tag_next . ' : <a href="' . $web_url . UrltoHtml($next['ID'], $next['info_url'], "nv") . '" title="'.$next['info_title'].'">'.$next['info_title'].'</a></div>';
    } else {
        $NextHtml = '';
    }
    $Html = $PrevHtml . $NextHtml;
    return datato($Html);
}
/*相关新闻*/
function Ncate($ID,$db_conn,$Language,$web_url){

    $wbnews = "";


    $query = $db_conn->query("select * from sc_info where languageID=$Language and info_lanmu=$ID ORDER BY ID");

    if(mysqli_num_rows($query)>0){
        while ($row = mysqli_fetch_array($query)) {


            $wbnews .= "<li><a href='" . $web_url . UrltoHtml($row['ID'], $row['info_url'], "nv") . "' title='" . $row['info_title'] . "'>" . $row['info_title'] . "</a></li>";


        }
    }
    return datato($wbnews);
}

// 网站新闻分类

function get_str($id, $lgid, $web_url, $db_conn)
{ //无限分类

    //global $str;
    $str = "";
    $result = $db_conn->query("select * from sc_categories where category_pid= $id and languageID=$lgid and category_open=1 order by category_paixu,ID asc");

    if ($result) {

        while ($row = mysqli_fetch_array($result)) { //循环记录集

            $str .= "<li><a href='" . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . "'>" . $row['category_name'] . "</a>" . get_str2($row['ID'], $web_url, $db_conn);
            $str .= '</li>';
        }
        if ($str == "") {

            $str = "<li>Empty!</li>";

        } else {

            $str = $str;

        }

        return datato($str);
    }
}


function get_str2($ids, $language, $db_conn, $web_url, $ul, $type,$web_url_meate,$webTemplate)
{ //无限
    $str2 = "";
    $results = $db_conn->query("select * from sc_categories where category_pid=$ids and category_open=1 and languageID=$language order by category_paixu,ID asc");//查询pid的子类的分类
    if ($results) {//如果有子类

        while ($row = mysqli_fetch_array($results)) { //循环记录集
            if ($type === 'pr') {
                $id=$row['ID'];
                $null=$db_conn->query("select * from sc_categories where category_pid=$id and category_open=1 and languageID=$language order by category_paixu,ID asc");
                if(mysqli_num_rows($null)>0){
                    $str2 .='
                        <li>
                            <a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '" title="'.$row['category_name'].'">' . $row['category_name'] . '</a><span class="fa fa-angle-down right"></span>' . get_str2($row['ID'], $language, $db_conn, $web_url, '<ul class="sz_nav">', 'pr',$web_url_meate,$webTemplate) . '
                        </li>
                ';
                }else{
                    $str2 .='
                        <li>
                            <a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '" title="'.$row['category_name'].'">' . $row['category_name'] . '</a>
                        </li>
                ';
                }

                //$str2 .= '<li><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '"><span>' . $row['category_name'] . '</span></a>' . get_str2($row['ID'], $language, $db_conn, $web_url, '<ul>', 'pr',$web_url_meate,$webTemplate) . '</li>';
            }else{
                $id=$row['ID'];
                $null=$db_conn->query("select * from sc_categories where category_pid=$id and category_open=1 and languageID=$language order by category_paixu,ID asc");
                if(mysqli_num_rows($null)>0){
                    $str2.='<li><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '" title="' . $row['category_name'] . '">' . $row['category_name'] . '</a><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/pro-arrow.png" alt="" class="right">'.get_str2($row['ID'], $language, $db_conn, $web_url, '<ul class="children_category_list">', 'ps',$web_url_meate,$webTemplate).'</li>';
                }else{
                    $str2.='<li><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '" title="' . $row['category_name'] . '">' . $row['category_name'] . '</a></li>';
                }
            }


        }
        if ($str2 == "") {

            $str2 = " ";

        } else {

            $str2 = $ul . $str2 . "</ul>";

        }

        return datato($str2);
    }
}

/*首页一级分类显示*/
function Pcate($Pid, $Language, $db_conn, $web_url, $web_url_meate, $inquiry)
{
    $str2 = '';
    $str3 = '';
    $results = $db_conn->query("select * from sc_categories where category_pid=$Pid and category_open=1 and category_tj=1 and languageID=$Language order by category_paixu,ID asc");

    if ($results) {//如果有子类
        $i = 1;

        while ($row = mysqli_fetch_array($results)) { //循环记录集

            if ($i === 1) {
                $str2 .= '<li class="pro_all_zl_active"><a href="javascript:" title="' . $row['category_name'] . '">' . $row['category_name'] . '</a></li>';
            } else {
                $str2 .= '<li><a href="javascript:" title="' . $row['category_name'] . '">' . $row['category_name'] . '</a></li>';

            }
            $lmID = prolmid($Language, $row['ID'], $db_conn);
            $sql = $db_conn->query("select * from sc_products where languageID=$Language and products_zt=1 and  $lmID limit 3");
            if ($sql) {
                $str1 = '';
                while ($rows = mysqli_fetch_array($sql)) {
                    $Imgs = explode(",", $rows['products_Images']);
                    $str1 .= '
                        <div class="left product_all_item">
                            <div class="product_all_pic"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['products_url'], "pv") . '"><img src="' .$web_url_meate. str_replace("../", "", $Imgs[0]) . '" alt="' . $rows['products_name'] . '"></a></div>
                            <div class="product_all_xx">
                                <div class="product_all_name"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['products_url'], "pv") . '" title="' . $rows['products_name'] . '">' . $rows['products_name'] . '</a></div>
                            </div>
                        </div>
                    ';
                }

                if ($i === 1) {
                    $str3 .= '<div class="tab_qh_box tab_qh_box_active">' . $str1 . '</div>';
                } else {
                    $str3 .= '<div class="tab_qh_box">' . $str1 . '</div>';
                }
            }

            $i++;
        }

        $str2 = '<ul class="left product_all_zl">' . $str2 . '</ul><div class="right">' . $str3.'</div>';

        return datato($str2);
    }
}

// 首页产品推荐 与 //首页新产品

function indexpro($str, $Language, $web_url, $weblist, $db_conn, $web_url_meate, $tag_inquiry, $webinlist,$read_more,$type,$webTemplate,$tuijian)
{

    $indexpros = "";

    if ($str == "tj") {

        $sql = "select * from  sc_products where languageID=$Language and products_zt=1 and products_index=1 order by  products_paixu asc, ID asc limit $weblist ";

    } else if($str == "sj"){
        $sql = "select * from  sc_products where languageID=$Language and products_zt=1 and products_index=1 order by  products_paixu asc, ID asc limit $weblist ";

    }else if($str == 'hot'){
        $sql = "select * from  sc_products where languageID=$Language and products_zt=1  order by   ID desc limit 6";
    }else{

        $sql = "select * from  sc_products where languageID=$Language and products_zt=1  order by   ID desc limit $webinlist";
    }

    $query = $db_conn->query($sql);
    Panduan(mysqli_num_rows($query));
    $i=1;

    while ($row = mysqli_fetch_array($query)) {

        $Imgs = explode(",", trim($row['products_Images'],','));
        if ($str == "tj") {
            if($i===1){
                $indexpros.='<div class="swiper-slide">
                        <ul class="float_after">';
            }else if($i%12===1){
                $indexpros.=' </ul>
                    </div>
                    <div class="swiper-slide">
                        <ul class="float_after">';
            }
            $indexpros.='
                <li class="left product_item">
                                <div class="product_item_pic">
                                    <a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '">
                                        <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tj">
                                        <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tc">
                                    </a>
                                    <div class="product_item_eye"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/btn.png" alt=""></a></div>
                                </div>
                                <div class="product_item_name"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '" title="' . $row['products_name'] . '">' . $row['products_name'] . '</a></div>
                            </li>
            ';
        } else if($str == 'zx'){
            $indexpros.='
                <div class="swiper-slide product_item">
                             <div class="product_item_pic">
                                    <a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '">
                                        <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tj">
                                        <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tc">
                                    </a>
                                    <div class="product_item_eye"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/btn.png" alt=""></a></div>
                                </div>
                                <div class="product_item_name"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '" title="' . $row['products_name'] . '">' . $row['products_name'] . '</a></div>
                        </div>
            ';
        }else{
            $indexpros.='
                <li class="float_after">
                            <div class="left mk_product_list_pic"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '"><img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '"></a></div>
                            <div class="right mk_product_list_wzk">
                                <div class="mk_product_list_bt"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '" title="' . $row['products_name'] . '">' . $row['products_name'] . '</a></div>
                                <div class="mk_product_list_shop"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '">'.strtoupper($read_more).' ></a></div>
                            </div>
                        </li>   
            ';
        }
        $i++;
    }
    if($str==='tj'&& mysqli_num_rows($query)>0){
        if($type==='pc'){
            $indexpros='<div class="swiper-container" id="featured_lb">
                <div class="swiper-wrapper">'.$indexpros.'</ul>
                    </div>
                </div>
            </div>
            <div class="home_mk_an">
                <div class="swiper-button-prev" id="featured_prev"></div>
                <div class="swiper-button-next" id="featured_next"></div>
            </div>';
        }else{
            $indexpros=$indexpros.'</ul>
                    </div>
                ';
        }
    }else if($str==='zx' && $type==='pc'&& mysqli_num_rows($query)>0){
        $indexpros='
            <div class="swiper-container" id="new_products_mk_lb">
                    <div class="swiper-wrapper">
                        '.$indexpros.'
                   </div>
                </div>
                <div class="home_mk_an">
                    <div class="swiper-button-prev" id="new_products_mk_prev"></div>
                    <div class="swiper-button-next" id="new_products_mk_next"></div>
                </div>
        ';
    }
    return datato($indexpros);
}


//网站尾部信息[关于我们]

function wbabout($str, $Language, $web_url, $db_conn,$web_url_meate,$webTemplate)
{

    $lanmuid = checkinfos($str, $Language, $db_conn);
    $aboulm = "";
    $query = $db_conn->query("select * from sc_info where languageID=$Language and info_lanmu=$lanmuid");
    if ($query) {
        while ($row = mysqli_fetch_array($query)) {
            $aboulm .= '<li><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/dot.png"><a href="' . $web_url . UrltoHtml($row['ID'], $row['info_url'], "ab") . '" title="' . $row['info_title'] . '">' . $row['info_title'] . '</a></li>';
        }
    }
    return datato($aboulm);
}

//产品栏目

function wbpro($Language, $db_conn,$type,$web_url_meate,$webTemplate,$web_url)
{

    $wbpro = "";
    $query = $db_conn->query("select * from sc_categories where languageID=$Language and category_pid=1 and category_open=1 order by category_paixu,ID asc  ");


    while ($row = mysqli_fetch_array($query)) {
        if($type==='product'){
            $wbpro.='<li>';
        }else if($type==='top'){
            $wbpro.="<li class='".$row['ID']."'>";
        }else if($type==='left'){
            $wbpro.='<li>';
        }
        if($type==='top'){
            $wbpro .= "<a href='javascript:' title='".$row['category_name']."'>" . $row['category_name'] . "</a></li>";
        }else if($type==='left'){
            if($row['category_img']!==null && $row['category_img']!==''){
                $img='<img src="'.$web_url_meate.str_replace('../','',$row['category_img']).'" alt="" title="' . $row['category_name'] . '">';
            }else{
                $img='<img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/Categories-icon.png" alt="' . $row['category_name'] . '">';
            }
            $wbpro .='<a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '"><span>'.$img.'</span>' . $row['category_name'] . '</a></li>';
        }else{

            $wbpro .= "<img src='".$web_url_meate.'Templete/'.$webTemplate."/Images/dot.png'><a href='" . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . "' title='".$row['category_name']."'>" . $row['category_name'] . "</a></li>";
        }
    }
    if($type==='left' && mysqli_num_rows($query)>8){
        $wbpro='<ul>'.$wbpro.'<li class="more_nav_li"><a href="javascript:"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/jia.png" alt=""></a></li>
                    <li class="less_nav_li"><a href="javascript:"><span><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/less.png" alt=""></a></li></ul>';
    }else if($type==='left' && mysqli_num_rows($query)>0){
        $wbpro='<ul>'.$wbpro.'</ul>';
    }

    return datato($wbpro);
}



//分享

function wbfollowus($webshare)
{

    $wbfollow = $webshare;
    return datato($wbfollow);
}


function downloadfile($Language, $web_url, $tag_download, $db_conn, $web_url_meate, $webTemplate, $webplist, $tag_prev, $tag_next)
{ //1)资料下载

    $aboulm = "";
    /*$sql = $db_conn->query("select * from sc_download where languageID=$Language order by down_paixu asc ,ID asc");
    $all_num = mysqli_num_rows($sql); //总条数
    $page_num = $webplist; //每页条数
    $page_all_num = ceil($all_num / $page_num); //总页数
    $page = empty($_GET['page']) ? 1 : $_GET['page']; //当前页数
    $page = (int)$page; //安全强制转换
    $limit_st = ($page - 1) * $page_num; //起始数*/
    $query = $db_conn->query("select * from sc_download where languageID=$Language order by down_paixu asc ,ID asc ");
    while ($row = mysqli_fetch_array($query)) {


        $kzm = explode(".", $row['down_file']);

        if (end($kzm) == "xls" || end($kzm) == "xlsx") {


            $img = "<img src='" . $web_url_meate . "Templete/" . $webTemplate . "/Images/Download_excel.png'  alt='excel'>";

        } elseif (end($kzm) == "zip" || end($kzm) == "rar") {

            $img = "<img src='" . $web_url_meate . "Templete/" . $webTemplate . "/Images/Download_zip.png'  alt='rar,zip'>";

        } elseif (end($kzm) == "pdf") {

            $img = "<img src='" . $web_url_meate . "Templete/" . $webTemplate . "/Images/Download_pdf.png'  alt='pdf'>";

        } else {

            $img = "<img src='" . $web_url_meate . "Templete/" . $webTemplate . "/Images/Download_word.png' alt='other'>";

        }
        $aboulm .='
            <li class="left">
                    <div class="download_pic">'.$img.'</div>
                    <div class="download_name" title="' . $row['down_name'] . '">' . $row['down_name'] . '</div>
                    <div class="download_more"><a href="' . $web_url_meate . str_replace("../", "", $row['down_file']) . '">'.strtoupper($tag_download).'</a></div>
                </li>
        ';

        /*if ($all_num > 1) {

            $fy = '<div class="pro_fyq float_after"><ul>' . show_page($all_num, $page, $page_num, $tag_prev, $tag_next) . '</ul></div>';

        } else {

            $fy = "";
        }*/

    }

    return datato($aboulm);
}
/*首页关于我们推荐*/
function Abouttj($name,$Language,$db_conn){
    $where='';
    $query=$db_conn->query("select * from sc_categories where category_pid=2 and category_url='$name' and languageID=$Language and category_open=1");
    if(mysqli_num_rows($query)>0){
        while($row=mysqli_fetch_array($query)){
            $where.= 'info_lanmu='.$row['ID']. ' or ';
        }
        $where=substr($where,0,-4);
        $querys=$db_conn->query("select * from sc_info where $where and info_tj=1 and languageID=$Language order by ID asc limit 1");
        if(mysqli_num_rows($querys)>0){
            $rows=mysqli_fetch_array($querys);
            $about=wbfollowus($rows['info_content']);
        }else{
            $about='';
        }

    }else{
        $about='';

    }
    return $about;

}

//新闻导航栏目

function wbnews($Language, $web_url, $db_conn)
{

    $wbnews = "";
    $query = $db_conn->query("select * from sc_categories where languageID=$Language and category_pid=2 and category_open=1 and category_url<>'About'");

    while ($row = mysqli_fetch_array($query)) {
        $wbnews.='<li><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "ne") . '" title="' . $row['category_name'] . '">' . $row['category_name'] . '</a></li>';
    }

    return datato($wbnews);
}

/*新闻分类*/
function wbnewss($Language, $web_url, $db_conn, $web_url_meate,$webTemplate)
{

    $wbnews = "";
    $query = $db_conn->query("select * from sc_categories where languageID=$Language and category_pid=2 and category_open=1 and category_url<>'About'");
    while ($row = mysqli_fetch_array($query)) {
        $wbnews.='<li><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/dot.png"><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "ne") . '" title="' . $row['category_name'] . '">' . $row['category_name'] . '</a></li>';
    }

    return datato($wbnews);
}

/*时间转换*/
function times($time, $type)
{
    $time = explode('-', explode(' ', $time)[0]);
    /*$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'Octorber', 'November', 'December'];*/
    $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    if ($type === 'last') {
        $date =ltrim($time[2],'0') . $month[ltrim($time[1],'0')-1];
    } else if ($type === 'news') {
        $date = $time[0] . '-' . $time[1] . '-' . $time[2];
    } else {
        $date = $month[trim($time[1] - 1, '0')] . ' ' . $time[2] . ' ' . $time[0];
    }
    return datato($date);

}


//新闻显示
function indexwbnews($Language, $web_url, $db_conn, $web_url_meate, $webTemplate, $tag_more,$type,$lastnews)
{
    $indexnews = "";
    $where = '';
    $query = $db_conn->query("select * from sc_categories where languageID=$Language and category_pid=2 and category_open=1 and category_url<>'About'");
    if(mysqli_num_rows($query)>0){
        while ($row = mysqli_fetch_array($query)) {
            $where .= 'info_lanmu=' . $row['ID'] . ' or ';


        }

        $where = substr($where, 0, -4);
        $querys = $db_conn->query("select * from sc_info where languageID=$Language and $where  order by ID desc limit 6");

        while ($rows = mysqli_fetch_array($querys)) {
            $indexnews.='
                <div class="swiper-slide last_news_item">
                            <div class="float_after">
                                <div class="left last_news_pic"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['info_url'], "nv") . '"><img src="'.$web_url_meate.str_replace('../','',$rows['info_image']).'" alt="' . $rows['info_title'] . '"></a></div>
                                <div class="right last_news_wzk">
                                    <div class="last_news_time"><span>'.times($rows['info_time'],'last').'</span></div>
                                    <div class="last_news_bt"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['info_url'], "nv") . '" title="' . $rows['info_title'] . '">' . $rows['info_title'] . '</a></div>
                                    <div class="last_news_ms"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['info_url'], "nv") . '">' . $rows['info_des'] . '</a></div>
                                    <div class="last_news_more"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['info_url'], "nv") . '">'.strtoupper($tag_more).' ></a></div>
                                </div>
                            </div>
                        </div>
            ';
        }
        if($type==='pc' && mysqli_num_rows($querys)>0){
            $indexnews='
            <div class="swiper-container" id="last_news_lb">
                    <div class="swiper-wrapper">
        '.$indexnews.'</div>
                </div>
                <div class="home_mk_an">
                    <div class="swiper-button-prev" id="last_news_prev"></div>
                    <div class="swiper-button-next" id="last_news_next"></div>
                </div>';
        }
    }

    return datato($indexnews);
}


//产品总列表页面

// 查询所有分类的ID【共用】

function prolmid($Language, $ID, $db_conn)
{

    $str = "";
    $strs = "";
    $query = $db_conn->query("select * from sc_categories where category_path like '%," . $ID . ",%' and languageID=$Language and category_open=1");
    Panduan(mysqli_num_rows($query));

    while ($row = mysqli_fetch_array($query)) {

        $str .= "products_category like '%," . $row['ID'] . ",%' or ";

    }
    $strs = "(" . $str . "products_category like '%," . $ID . ",%')";
    return $strs;
}

/*首页推荐下的产品*/
function pcatelist($Language, $tag_inquiry, $web_url, $tag_more, $db_conn, $web_url_meate, $webTemplate,$tag_category,$tag_tuijian,$type,$str)
{

    //显示每个栏目下的3个产品



    $indexprost='';
    $query_p = $db_conn->query("select * from sc_categories where category_pid=1 and languageID=$Language and category_open=1 order by  category_paixu asc,ID asc ");
    Panduan(mysqli_num_rows($query_p));
    while ($row = mysqli_fetch_array($query_p)) {
        $indexprost.='
            <div class="swiper-slide category_item">
                            <div class="category_pic"><img src="' . $web_url_meate . str_replace('../', '', $row['category_img']) . '" alt="'.$row['category_name'].'"></div>
                            <div class="category_wzxx">
                                <div class="category_name"><a href="'.$web_url . UrltoHtml($row['ID'], $row['category_url'], "pl").'">'.$row['category_name'].'</a></div>
                                <div class="category_an"><a href="'.$web_url . UrltoHtml($row['ID'], $row['category_url'], "pl").'">'.$tag_more.'</a></div>
                            </div>
                        </div>
        ';

    }
    if($str==='pc'){
        $indexprost='
         <div class="home_mk_bt">
                    '.$tag_category.'
                    <div class="swiper-button-prev" id="category_prev"></div>
                    <div class="swiper-button-next" id="category_next"></div>
                </div>
                <div class="swiper-container" id="category_pro">
                    <div class="swiper-wrapper">'.$indexprost.'</div>
                </div>
        ';
    }
    return datato($indexprost);
}
function isMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {

        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {

        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
    if (isset($_SERVER['HTTP_USER_AGENT'])) {

        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}
// 产品列表

function productslist($Language, $tag_inquiry, $web_url, $tag_more, $db_conn, $web_url_meate, $tag_prev, $tag_next, $webTemplate)
{

    //显示每个栏目下的3个产品

    $indexpros = "";
    $indexprost = "";
    $query_p = $db_conn->query("select * from sc_categories where category_pid=1 and languageID=$Language and category_open=1  order by  category_paixu asc,ID asc ");
    Panduan(mysqli_num_rows($query_p));
    while ($row = mysqli_fetch_array($query_p)) {
        $lmID = prolmid($Language, $row['ID'], $db_conn);


        // 以下是产品信息

        $query = $db_conn->query("select * from  sc_products where languageID=$Language and products_zt=1 and  $lmID order by  products_paixu asc, ID asc limit 4 ");
        Panduan(mysqli_num_rows($query));
        $m = 1;
        while ($rows = mysqli_fetch_array($query)) {

            $Imgs = explode(",", $rows['products_Images']);
            $Imgs = $web_url_meate . $Imgs[0];
            if ($m % 2 === 0) {
                $indexpros .= '
                <div class="right">
                        <div class="product_list_kind"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['products_url'], "pv") . '">' . $rows['products_name'] . '</a></div>
                        <div class="product_list_img"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['products_url'], "pv") . '"><img src="' . str_replace("../", "", $Imgs) . '" alt="' . $rows['products_name'] . '"></a></div>
                    </div>
                    ';

            } else {
                $indexpros .= '<div class="left">
                        <div class="product_list_img"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['products_url'], "pv") . '"><img src="' . str_replace("../", "", $Imgs) . '" alt="' . $rows['products_name'] . '"></a></div>
                        <div class="product_list_kind"><a href="' . $web_url . UrltoHtml($rows['ID'], $rows['products_url'], "pv") . '">' . $rows['products_name'] . '</a></div>
                    </div>';
            }

            $m++;

        }


        $indexprost .= '
           

            <div class="float_after product_list">
                    <div class="product_kind_q">
                        <div title="' . $row['category_name'] . '">' . $row['category_name'] . '</div>
                        <div><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '">' . $tag_more . '</a></div>
                    </div>
                    '.$indexpros.'
                </div>';
        $indexpros = "";

    }
    return datato($indexprost);
}
//产品页
function productscate($Language, $tag_inquiry, $web_url, $tag_more,$db_conn, $web_url_meate){

    $product_c="";
    $query_p = $db_conn->query("select * from sc_categories where languageID=$Language and category_open=1 and category_pid=1 ORDER BY category_paixu ASC,ID ASC");
    goto404(mysqli_num_rows($query_p));
    $i=0;
    while($row=mysqli_fetch_array($query_p)){
        if($i>3){
            $i=$i-4;
        }
        $cate=['first','second','third','fourth'];
        $product_c.='
            <li class="float_after product_kind_item product_kind_'.$cate[$i].'">
                            <div class="left">
                                <div class="product_kind_bt" title="'.$row['category_name'].'"><a href="'. $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '">'.$row['category_name'].'</a></div>
                                <div class="product_kind_ms"><a href="'. $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '">'.$row['category_des'].'</a></div>
                                <div class="product_kind_inquiry"><a href="'. $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '">'.$tag_more.'</a></div>
                            </div>
                            <div class="right">
                                <a href="'. $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '"><img src="'.$web_url_meate.str_replace('../','',$row['category_img']).'" alt="'.$row['category_name'].'"></a>
                            </div>
                        </li>
        ';
        $i++;
    }
    echo datato($product_c);
}

// 产品列表，获取相应的ID 列出产品

function productslistp($Language, $tag_inquiry, $web_url, $tag_more, $ID, $webplist, $db_conn, $web_url_meate, $tag_prev, $tag_next,$webTemplate)
{

    $indexpros = "";
    $indexprost = "";
    $indextitle = "";
    if ($ID !== '') {
        if (is_numeric($ID)) {

            $query_p = $db_conn->query("select * from sc_categories where ID=$ID and languageID=$Language and category_open=1");

        } else {

            $query_p = $db_conn->query("select * from sc_categories where category_url='" . $ID . "' and languageID=$Language and category_open=1");

        }
    } else {
        $query_p = $db_conn->query("select * from sc_categories where languageID=$Language and category_open=1");
    }

    goto404(mysqli_num_rows($query_p));
    $row = mysqli_fetch_array($query_p);
    $iD = $row['ID'];
    $query_s = $db_conn->query("select * from sc_categories where category_pid=$iD and languageID=$Language and category_open=1  order by  category_paixu asc,ID asc ");


    $lmID = prolmid($Language, $row['ID'], $db_conn);

    //$protitle='<div class="sc_mid_c_right_title">'.$row['category_name'].'</div>';
    if($ID!==''){
        $sql = $db_conn->query("select * from sc_products where languageID=$Language and products_zt=1 and  $lmID");
    }else{
        $sql = $db_conn->query("select * from sc_products where languageID=$Language and products_zt=1");
    }
    $all_num = mysqli_num_rows($sql); //总条数
    $page_num = $webplist; //每页条数
    $page_all_num = ceil($all_num / $page_num); //总页数
    $page = empty($_GET['page']) ? 1 : $_GET['page']; //当前页数
    $page = (int)$page; //安全强制转换
    $limit_st = ($page - 1) * $page_num; //起始数

    if($ID!==''){
        $query = $db_conn->query("select * from sc_products where languageID=$Language and products_zt=1 and  $lmID order by products_paixu asc, ID asc limit $limit_st,$page_num ");
    }else{
        $query = $db_conn->query("select * from sc_products where languageID=$Language and products_zt=1 order by products_paixu asc, ID asc limit $limit_st,$page_num ");
    }
    Panduan(mysqli_num_rows($query));

    while ($row = mysqli_fetch_array($query)) {

        $Imgs = explode(",", $row['products_Images']);
        $indexpros .='
            <li class="left product_item">
                        <div class="product_item_pic">
                            <a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '">
                                <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tj">
                                <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tc">
                            </a>
                            <div class="product_item_eye"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/btn.png" alt=""></a></div>
                        </div>
                        <div class="product_item_name"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '" title="' . $row['products_name'] . '">' . $row['products_name'] . '</a></div>
                    </li>
        ';
    }
    $indexprost = '<ul class="products_mk_list float_after">' . $indexpros . '</ul>';
    if ($page_all_num > 1) {

        $fy = '<div class="pro_fyq float_after">
                    <ul>' . show_page($all_num, $page, $page_num, $tag_prev, $tag_next) . '</ul></div>';

    } else {

        $fy = "";
    }

    echo datato($indexprost) . $fy;
}


//分页函数

function show_page($count, $page, $page_size, $tag_prev, $tag_next)
{

    $page_count = ceil($count / $page_size);  //计算得出总页
    $init = 1;
    $page_len = 2;
    $max_p = $page_count;
    $pages = $page_count;
    $page = (empty($page) || $page < 0) ? 1 : $page;
    $url = $_SERVER['REQUEST_URI'];

    if (htmlopen == 0) {

        $parsedurl = parse_url($url);

        $url_query = isset($parsedurl['query']) ? $parsedurl['query'] : '';
        if ($url_query != '') {
            $url_query = preg_replace("/(^|&)page=$page/", '', $url_query);
            $url = str_replace($parsedurl['query'], $url_query, $url);
            if ($url_query != '') {

                $url .= '&';
            }
        } else {

            $url .= '?';
        }

        $page_len = ($page_len % 2) ? $page_len : $page_len + 1;
        $pageoffset = ($page_len - 1) / 2;

        $navs = '';

        if ($pages != 0) {
            if ($page != 1) {

                /* if($page==2){
                     $navs.='<li class="pro_fyq_prev"><a href="'.str_replace("?", "", $url).'"> Previous </a></li>';
                 }else{
                     echo 1;*/
                $navs .= '<li class="pro_fyq_prev"><a href="' . $url . 'page=' . ($page - 1) . '"><span class="fa fa-angle-left"></span></a></li>';
                /*}*/

            } else {

                $navs .= '<li class="pro_fyq_prev"><a href="javascript:"><span class="fa fa-angle-left"></span></a></li>';
            }
            if ($pages > $page_len) {

                if ($page <= $pageoffset) {
                    $init = 1;
                    $max_p = $page_len;

                } else {

                    if ($page + $pageoffset >= $pages + 1) {

                        $init = $pages - $page_len + 1;

                    } else {

                        $init = $page - $pageoffset;
                        $max_p = $page + $pageoffset;
                    }
                }
            }
            for ($i = $init; $i <= $max_p; $i++) {
                if ($i == $page) {
                    $navs .= '<li class="pro_active pro_fyq_ym"><a href="javascript:">' . $i . '</a></li>';
                } else {
                    /* if ($i==1){
                         $navs.=' <li class="pro_fyq_ym"><a href="'.$url.'page='.$i.'">'.$i.'</a></li>';
                     }else{*/
                    $navs .= ' <li class="pro_fyq_ym"><a href="' . $url . 'page=' . $i . '">' . $i . '</a></li>';
                    /*}*/


                }
            }
            if ($page != $pages) {
                $navs .= '<li class="pro_fyq_next"><a href="' . $url . 'page=' . ($page + 1) . '"><span class="fa fa-angle-right"></span></a></li>';

            } else {
                $navs .= '<li class="pro_fyq_next"><a href="javascript:"><span class="fa fa-angle-right"></span></a></li>';

            }
            return " $navs";
        }


    } else {
        $url = substr($url, 0, strlen($url) - 1);
        $url = explode("_", $url);
        $url = $url[0];
        $page_len = ($page_len % 2) ? $page_len : $page_len + 1;  //页码个数
        $pageoffset = ($page_len - 1) / 2;  //页码个数左右偏移
        $navs = '';
        if ($pages != 0) {
            if ($page != 1) {

                if ($page == 2) {
                    $navs .= '<li class="pro_fyq_prev"><a href="' . $url . '/"><span class="fa fa-angle-left"></span></a></li>';
                } else {
                    $navs .= '<li class="pro_fyq_prev"><a href="' . $url . '_' . ($page - 1) . '/"><span class="fa fa-angle-left"></span></a></li>';
                }

            } else {
                $navs .= '<li class="pro_fyq_prev"><a href="javascript:"><span class="fa fa-angle-left"></span></a></li>';
            }
            if ($pages > $page_len) {
                if ($page <= $pageoffset) {
                    $init = 1;
                    $max_p = $page_len;

                } else {
                    if ($page + $pageoffset >= $pages + 1) {
                        $init = $pages - $page_len + 1;
                    } else {
                        $init = $page - $pageoffset;
                        $max_p = $page + $pageoffset;
                    }
                }
            }
            for ($i = $init; $i <= $max_p; $i++) {

                if ($i == $page) {
                    $navs .= '<li class="pro_active pro_fyq_ym"><a href="javascript:">' . $i . '</a></li>';
                    //$navs.="<span class='current'>".$i.'</span>';
                } else {

                    if ($i == 1) {
                        //$navs.=" <a href=\"".str_replace("&", "", $url)."/\">".$i."</a>";
                        $navs .= '<li class="pro_fyq_ym"><a href="' . str_replace("&", "", $url) . '/">' . $i . '</a></li>';
                    } else {
                        //$navs.=" <a href=\"".$url."_".$i."/\">".$i."</a>";
                        $navs .= '<li class="pro_fyq_ym"><a href="' . $url . '_' . $i . '/">' . $i . '</a></li>';
                    }

                }

            }
            if ($page != $pages) {
                $navs .= '<li class="pro_fyq_next"><a href="' . $url . '_' . ($page + 1) . '/"><span class="fa fa-angle-right"></span></a></li>';
                /*$navs.=" <a href=\"".$url."_".($page+1)."/\"> > </a> ";*/

            } else {

                $navs .= '<li class="pro_fyq_next"><a href="javascript:"><span class="fa fa-angle-right"></span></a></li>';

            }
            return " $navs";
        }

    }

}

// 栏目层次

function lamcc($Language, $ID, $web_url, $db_conn,$type)
{

    $strs = "";
    $ID = rtrim($ID, ",");
    $ID = ltrim($ID, ",");
    if (strpos($ID, "rand") !== false) {//判断是否自定义随机产品
        $ID = explode("rand", $ID);
        $ID = explode(",", $ID[1]);
        $ID = end($ID);
        $sql = "select * from sc_categories where ID =$ID and languageID=$Language and category_open=1";
    } else {

        if (is_numeric($ID)) {

            $sql = "select * from sc_categories where ID =$ID and languageID=$Language and category_open=1";
        } else {

            $sql = "select * from sc_categories where category_url ='" . $ID . "' and languageID=$Language and category_open=1";
        }

    }
    $query = $db_conn->query($sql);
    goto404(mysqli_num_rows($query));
    while ($row = mysqli_fetch_array($query)) {

        $str = substr(str_replace("0,1,", "", $row['category_path']), 0, -1);//去最后一个,号
    }
    $arr = explode(",", $str);//分割
    foreach ($arr as $u) {
        $query = $db_conn->query("select * from sc_categories where ID =$u and category_open=1");
        Panduan(mysqli_num_rows($query));
        while ($row = mysqli_fetch_array($query)) {

            if($ID===$row['ID']||$ID===$row['category_url']){
                $strs.='<span class="fa fa-angle-double-right fgf"></span><span class="dqy">'.$row['category_name'].'</span>';
            }else{
                $strs .= '<span class="fa fa-angle-double-right fgf"></span><a href="' . $web_url . UrltoHtml($row['ID'], $row['category_url'], "pl") . '">' . $row['category_name'] . '</a>';
            }


        }

    }
    //$strs = substr($strs, 0, -29);//去除最后两位
    return $strs;
}


//详细页面参数调用

function proview($ID, $ziduan, $web_url, $db_conn, $web_url_meate,$webTemplate,$Language)
{

    $str2 = "";
    if (is_numeric($ID)) {// 判读获取的ID 是否自定义

        $query = $db_conn->query("select * from sc_products where ID =$ID ");

    } else {

        $query = $db_conn->query("select * from sc_products where  products_url='" . $ID . "' and languageID='".$Language."' ");
    }

    goto404(mysqli_num_rows($query));
    $row = mysqli_fetch_array($query);

    if ($ziduan == "products_Images") {

        $strs = explode(",", $row[$ziduan]);
        $str1 = '<img class="bigImg" src="' . $web_url_meate . str_replace("../", "", $strs[0]) . '" alt="big"/>';
        $str3 = '<img class="smallImg" src="' . $web_url_meate . str_replace("../", "", $strs[0]) . '" alt="small">';
        foreach ($strs as $st) {

            if ($st !== "") {
                $str2 .= '<div class="slide left"><img src="' . $web_url_meate . str_replace("../Images/prdoucts", "Images/prdoucts/small", $st) . '" alt=""></div>';
            }

        }
        $str ='
            <div class="pro_det_Img left">
                        <div id="container">
                            <div class="pro_det_bigImg leftView">
                                <div class="mask"></div>
                                '.$str3.'
                            </div>
                            <div class="rightView">
                                '.$str1.'
                            </div>
                        </div>
                        <div class="sp_pic">
                            <div class="button-prev left"><a href="javascript:"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/pro-arrow-left.png" alt=""></a></div>
                            <div class="tp_ti left">
                                <div class="wrapContainer">
                                    <div class="wrapper">
                                        '.$str2.'
                                    </div>
                                </div>
                            </div>
                            <div class="button-next left"><a href="javascript:"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/pro-arrow-right.png" alt=""></a></div>
                        </div>
                    </div>            
        ';
    }elseif($ziduan =="products_Images_sj"){
        $strs = explode(",", $row["products_Images"]);
        foreach ($strs as $st) {
            if ($st !== "") {
                $str2 .= '<div class="slide left"><img src="' . $web_url_meate . str_replace("../Images/prdoucts", "Images/prdoucts/small", $st) . '" alt=""></div>';
            }

        }
        $str = '
            <div class="sjd_sp_pic left">
                <div class="tp_ti">
                    <div class="wrapContainer">
                        <div class="wrapper">
                            '.$str2.'
                        </div>
                    </div>
                </div>
            </div>
        ';

    } elseif ($ziduan == "products_category") {

        $products_xiangguan = trim($row['products_xiangguan']);//判断是否自定义随机产品

        if (strlen($products_xiangguan) > 0) {

            $str = $products_xiangguan . "rand" . $row[$ziduan];
        } else {

            $str = ltrim($row[$ziduan], ",");
            $str = rtrim($str, ",");
            $str = explode(",", $str);
            $str = end($str);
        }

    } else if($ziduan=='category'){
        $str = ltrim($row['products_category'], ",");
        $str = rtrim($str, ",");
        $str = explode(",", $str);
        $str = end($str);
    }else {


        $str = array('products_metatit' => datato($row['products_metatit']), 'products_name' => datato($row['products_name']), 'products_key' => datato($row['products_key']), 'products_des' => datato($row['products_des']), 'products_guige' => datato($row['products_guige']), 'products_model' => datato($row['products_model']), 'products_content' => datato($row['products_content']), 'ID' => datato($row['ID']), 'products_aurl' => datato($row['products_aurl']));

    }

    return $str;

}

// 随机产品

function sjpro($Language, $tag_inquiry, $ID, $web_url, $db_conn, $web_url_meate, $tag_more,$type,$webTemplate)
{

    $indexpros = "";
    if (strpos($ID, "rand") !== false) {//判读随机产品是否后台选择的
        $ID = explode("rand", $ID);
        $queryx = $db_conn->query("select * from  sc_products where languageID=$Language and products_zt=1 and ID in ($ID[0])");

    } else {
        $queryx = $db_conn->query("select * from  sc_products where languageID=$Language and products_zt=1 and products_category like '%" . $ID . "%' order by RAND() ");

    }

    Panduan(mysqli_num_rows($queryx));
    while ($row = mysqli_fetch_array($queryx)) {

        $Imgs = explode(",", $row['products_Images']);
        $indexpros.='
            <div class="swiper-slide product_item">
                            <div class="product_item_pic">
                                <a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '">
                                    <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tj">
                                    <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tc">
                                </a>
                                <div class="product_item_eye"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/btn.png" alt=""></a></div>
                            </div>
                            <div class="product_item_name"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '" title="' . $row['products_name'] . '">' . $row['products_name'] . '</a></div>
                        </div>
        ';

    }
    return datato($indexpros);
}

// 新闻信息调用


function infoview($ID, $db_conn,$Language)
{

    if (is_numeric($ID)) {// 判读获取的ID 是否自定义

        $query = $db_conn->query("select * from sc_info where ID=$ID");

    } else {
        $query = $db_conn->query("select * from sc_info where  info_url='" . $ID . "' and languageID= '" . $Language . "'");
    }

    goto404(mysqli_num_rows($query));
    $row = mysqli_fetch_assoc($query);
    $Nav = array('info_title' => datato($row['info_title']), 'info_keywords' => datato($row['info_keywords']), 'info_des' => datato($row['info_des']), 'info_content' => datato($row['info_content']), 'info_lanmu' => $row['info_lanmu'], 'info_time' => $row['info_time'],'info_image'=>$row['info_image']);

    return $Nav;

}


// 新闻信息列表


function newslist($Language, $web_url, $ID, $tag_news, $webnlist, $db_conn, $web_url_meate, $tag_more, $webTemplate, $tag_prev, $tag_next)
{
    $indexpros = "";
    $indexprost = "";

    if ($ID !== "") {// 新闻信息总列表

        if (is_numeric($ID)) {
            $query_p = $db_conn->query("select * from sc_categories where ID=$ID and category_open=1");
        } else {
            $query_p = $db_conn->query("select * from sc_categories where category_url='" . $ID . "' and category_open=1");
        }

        goto404(mysqli_num_rows($query_p));

        while ($row = mysqli_fetch_array($query_p)) {

            $protitle = '<div class="sc_mid_c_right_title">' . $row['category_name'] . '</div>';
            $IDl = $row['ID'];

        }
        $sql = $db_conn->query("select * from sc_info where languageID=$Language and info_lanmu=$IDl");

    } else {

        $lanmuid = checkinfos("About", $Language, $db_conn);

        $sql = $db_conn->query("select * from sc_info where languageID=$Language and info_lanmu<>$lanmuid");
    }
    if ($sql !== false) {

        $all_num = mysqli_num_rows($sql); //总条数
        $page_num = $webnlist; //每页条数
        $page_all_num = ceil($all_num / $page_num); //总页数
        $page = empty($_GET['page']) ? 1 : $_GET['page']; //当前页数
        $page = (int)$page; //安全强制转换
        $limit_st = ($page - 1) * $page_num; //起始数
        // 新闻信息总列表
        if($ID!==''){
            $sql = "select  * from  sc_info where languageID=$Language and info_lanmu=$IDl order by ID desc limit $limit_st,$page_num ";
        }else{
            $sql = "select  * from  sc_info where languageID=$Language and info_lanmu<>$lanmuid order by ID desc limit $limit_st,$page_num ";
        }
        $query = $db_conn->query($sql);
        Panduan(mysqli_num_rows($query));

        while ($row = mysqli_fetch_array($query)) {
            if (strpos($row['info_image'], "Images/default/") == true) {

                $nimg = $row['info_image'];

            } else {

                $nimg = "Images/default/logo.png";

            }
            $indexpros.='
                    <li class="news_item">
                        <div class="news_pic"><a href="' . $web_url . UrltoHtml($row['ID'], $row['info_url'], "nv") . '"><img src="'.$web_url_meate.str_replace('../','',$row['info_image']).'" alt="' . $row['info_title'] . '"></a></div>
                        <div class="news_bt"><a href="' . $web_url . UrltoHtml($row['ID'], $row['info_url'], "nv") . '" title="' . $row['info_title'] . '">' . $row['info_title'] . '</a></div>
                        <div class="news_ms"><a href="' . $web_url . UrltoHtml($row['ID'], $row['info_url'], "nv") . '">' . $row['info_des'] . '</a></div>
                        <div class="news_more"><a href="' . $web_url . UrltoHtml($row['ID'], $row['info_url'], "nv") . '">'.strtoupper($tag_more).' ></a></div>
                    </li>
                ';
        }
        $indexprost .= '<ul>'.$indexpros.'</ul>';
        if($page_all_num>1){
            $indexprost.='<div class="pro_fyq float_after">
                    <ul>'.show_page($all_num, $page, $page_num, $tag_prev, $tag_next).'</ul></div>';
        }
    }


    echo datato($indexprost);
}

//产品信息分类名称及关键词描述调用

function pnlmcc($Language, $ID, $db_conn)
{

    if (is_numeric($ID)) { // 判读获取的ID 是否自定义

        $query = $db_conn->query("select * from sc_categories where ID=$ID");

    } else {

        $query = $db_conn->query("select * from sc_categories where category_url ='" . $ID . "' and languageID='".$Language."'");
    }



    Panduan(mysqli_num_rows($query));
    $row = mysqli_fetch_array($query);

    $str = array('ID' => datato($row['ID']), 'category_url' => datato($row['category_url']), 'category_name' => datato($row['category_name']), 'category_key' => datato($row['category_key']), 'category_des' => datato($row['category_des']), 'category_path' => $row['category_path']);

    return $str;

}


//  列出搜索产品列表

function searchprolist($Language, $tag_inquiry, $web_url, $skeywords, $webplist, $db_conn, $web_url_meate, $tag_searchms, $tag_more,$webTemplate,$category)
{

    $indexpros = "";
    $indexprost = "";
    $keywordstr = "";
    $keywordsc = explode(" ", $skeywords);//分割
    foreach ($keywordsc as $keyw) {

        $keywordstr = "products_name like '%" . $keyw . "%' and ";
    }

    $keywordstr = substr($keywordstr, 0, -4);
    if($category!==''){
        $keywordstr.=" and products_category like '%,".$category.",%'";
    }
    $sql = $db_conn->query("select * from sc_products where languageID=$Language and $keywordstr");
    $all_num = mysqli_num_rows($sql); //总条数
    $page_num = $webplist; //每页条数
    $page_all_num = ceil($all_num / $page_num); //总页数
    $page = empty($_GET['page']) ? 1 : $_GET['page']; //当前页数
    $page = (int)$page; //安全强制转换
    $limit_st = ($page - 1) * $page_num; //起始数

    $query = $db_conn->query("select  * from  sc_products where languageID=$Language and products_zt=1 and  $keywordstr order by  products_paixu asc, ID asc ");
    if (mysqli_num_rows($query) > 0) {

        while ($row = mysqli_fetch_array($query)) {

            $Imgs = explode(",", $row['products_Images']);
            $indexpros .='
            <li class="left product_item">
                        <div class="product_item_pic">
                            <a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '">
                                <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tj">
                                <img src="' . $web_url_meate.str_replace("../", "", $Imgs[0]) . '" alt="' . $row['products_name'] . '" class="fg_tc">
                            </a>
                            <div class="product_item_eye"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '"><img src="'.$web_url_meate.'Templete/'.$webTemplate.'/Images/btn.png" alt=""></a></div>
                        </div>
                        <div class="product_item_name"><a href="' . $web_url . UrltoHtml($row['ID'], $row['products_url'], "pv") . '" title="' . $row['products_name'] . '">' . $row['products_name'] . '</a></div>
                    </li>
        ';
        }
        $indexprost = '<ul class="products_mk_list float_after">' . $indexpros . '</ul>';


        //$fy='<div class="pro_fyq float_after"><ul>'.show_page($all_num,$page,$page_num).'</ul></div>';

        $fy = "";

        return datato($indexprost) . $fy;

    } else {


        return "<div class='sech'>" . datato($tag_searchms) . "</div>";

    }
}


function checkinfos($str, $Language, $db_conn)
{ //查询数据信息
    $result = $db_conn->query("select * from sc_categories where category_url='$str' and languageID=$Language and category_open=1");
    //$row = mysqli_fetch_array($result,MYSQL_ASSOC);
    $row = mysqli_fetch_array($result);
    if (!mysqli_num_rows($result)) {

        echo "";

    } else {
        $strs = $row['ID'];
        return datato($strs);
    }

}


//URL 转换  $urlo= ID $urlt=自定url $type=产品类型

function UrltoHtml($urlo, $urlt, $type)
{

    switch ($type) {

        case 'pv':

            if (htmlopen == 1) {

                $url = trim($urlt) == "" ? $urlo . ".html" : $urlt . ".html";

            } else {

                $url = "view.php?ID=" . $urlo;

            }

            break;

        case 'pl':

            if (htmlopen == 1) {

                $url = trim($urlt) == "" ? $urlo . "/" : $urlt . "/";

            } else {

                $url = "product.php?ID=" . $urlo;

            }

            break;

        case 'ab';

            if (htmlopen == 1) {

                $url = trim($urlt) == "" ? "about/" . $urlo . ".html" : "about/" . $urlt . ".html";

            } else {

                $url = "about.php?ID=" . $urlo;

            }

            break;

        case 'nv';

            if (htmlopen == 1) {

                $url = trim($urlt) == "" ? "news/" . $urlo . ".html" : "news/" . $urlt . ".html";

            } else {

                $url = "info.php?ID=" . $urlo;

            }

            break;

        case 'ne';

            if (htmlopen == 1) {
                $url = trim($urlt) == "" ? "news" . $urlo . "/" : "news/" . $urlt . "/";

            } else {

                $url = "news.php?ID=" . $urlo;

            }

            break;
        case 'pr';
            if(htmlopen == 1){
                $url = $urlo.$urlt;
            }else{
                $url = trim($urlo,'/').'.php';
            }
            break;
        case 'con';
            if(htmlopen == 1){
                $url = $urlt;
            }else{
                $url = trim($urlo,'/').'.php';
            }
            break;

    }

    return $url;


}


function Panduan($str)
{  //判断数据,输出空符

    if ($str < 1) {

        echo '';

    }
}
