$(document).ready(function () {
    //分类js
    var category_cs=$(".nav_category ul li").length;
    function category_list(){
        for (var cate_cs = 0; cate_cs < 8; cate_cs++) {
            $(".nav_category ul li").eq(cate_cs).addClass("nav_category_active")
        }
    }
    $(".more_nav_li").mousedown(function () {
        $(".nav_category ul li").removeClass("nav_category_active");
        for (var cate_cs1 = 0; cate_cs1 < category_cs; cate_cs1++) {
            $(".nav_category ul li").eq(cate_cs1).addClass("nav_category_active")
        }
        $(this).hide();
        $(".less_nav_li").show()
    });
    $(".less_nav_li").mousedown(function () {
        $(this).hide();
        $(".more_nav_li").show();
        $(".nav_category ul li").removeClass("nav_category_active");
        for (var cate_cs1 = 0; cate_cs1 < 5; cate_cs1++) {
            $(".nav_category ul li").eq(cate_cs1).addClass("nav_category_active")
        }
    });
//
    var lujing=$('#sc_ajax_lujin').val();

    /*body_mb~height*/
    $(".body_mb").css("height",$("body").height());

    function show_search_category() {
        $(".search_category ul").stop().slideDown();
        $(".body_mb").show();
    }
    function hide_search_category() {
        $(".search_category ul").stop().slideUp();
        $(".body_mb").hide()
    }
    $(".search_category div").mousedown(function () {
        if($(this).siblings("ul").css("display")=="none"){
            show_search_category()
        }else{
            hide_search_category();
        }
    });
    //搜索点击获取分类ID
    $(".search_category ul li").click(function(){
       var id=$(this).prop("className");
       $(this).parent().next().val(id);
    });
    //搜索控制是否未填关键词
    $('.search_k button').click(function(){
       if($('.search_category_val').val()===''&& $('.search_name_val').val()===''){
           $('.search_name_val').css("border-color","#f00")
           return false;
       }else{
           $('.search_name_val').css("border-color","#f5f5f5")
       }
    });
    $(".body_mb").mousedown(function () {
        hide_search_category()
    });
    $(".search_category ul li").mousedown(function () {
        hide_search_category();
        $(".search_category div").html($(this).children("a").html())
    });
    function show_nav_category() {
        $(".nav_category ul").stop().slideDown();
    }
    function hide_nav_category() {
        $(".nav_category ul").stop().slideUp();
    }
    $(".nav_category div").mousedown(function () {
        category_list();
        if($(this).siblings("ul").css("display")=="none"){
            $(".nav_icon").addClass("nav_icon_active");
            show_nav_category()
        }else{
            $(".nav_icon").removeClass("nav_icon_active");
            hide_nav_category()
        }
    });
    $(".nav li").mouseenter(function () {
        $(this).children("ul").stop().slideDown()
    }).mouseleave(function () {
        $(this).children("ul").stop().slideUp()
    });
    $(".news_letter_mk form button").click(function () {
        if((!emailYz.test($(".news_letter_mk form input").val()))){
            $(".news_letter_mk form input").css("border-color","red");
            return false
        }else{
            $(".news_letter_mk form input").css("border-color","#ddd");
            $.ajax({
                type: 'post',
                url: lujing+'ajax.php',
                dataType: 'json',
                data: {'news_letter':$(".news_letter_mk form input").val()},
                success:function(data){
                    if(data.type===true){
                        $(".news_letter_mk form")[0].reset();
                        $('.news_letter_mk .sc_tsy').html(data.html);
                        setTimeout(function () {
                            /*$('.bd_ts').css("display","none");*/
                            $('.news_letter_mk .sc_tsy').html("");
                        }, 3000);
                    }else{
                        /*$('.bd_tt').css("display","block");*/
                        $('.news_letter_mk .sc_tsy').html(data.html);
                    }
                }
            });
        }
        return false;
    });
    var emailYz=/^([a-zA-Z0-9_\.-]+)@([\dA-Za-z\.-]+)\.([A-Za-z\.]{2,6})$/;
    $(".contact_bdk button").click(function () {
        if($(".name_srk").val()==""){
            $(".name_srk").css("border-color","#f00");
            return false
        }else{
            $(".name_srk").css("border-color","#f3f3f3");
        }
        if((!emailYz.test($(".email_srk").val()))){
            $(".email_srk").css("border-color","red");
            return false
        }else{
            $(".email_srk").css("border-color","#f3f3f3");
        }
        if($(".tel_srk").val()==""){
            $(".tel_srk").css("border-color","#f00");
            return false
        }else{
            $(".tel_srk").css("border-color","#f3f3f3");
        }
        if($("#msg").val()==""){
            $("#msg").css("border-color","#f00");
            return false
        }else{
            $("#msg").css("border-color","#f3f3f3");
        }
        if($(".pin_srk").val()==""){
            $(".pin_srk").css("border-color","#f00");
            return false
        }else{
            $(".pin_srk").css("border-color","#f3f3f3");
        }
        $.ajax({
            type: 'post',
            url: lujing+'ajax.php',
            dataType: 'json',
            data: {'name':$(".name_srk").val(),'mail':$(".email_srk").val(),'tel':$(".tel_srk").val(),'tent':$("#msg").val(),'yzm':$(".pin_srk").val(),'PID':$('#PID').val(),'languageID':$('#languageID').val()},
            success:function(data){

                if(data.type===true){
                    $(".contact_bdk")[0].reset();
                    $('.contact_bdk .sc_tsy').html(data.html);
                    setTimeout(function () {
                        $('.contact_bdk .sc_tsy').html("");
                    }, 3000);
                }else{
                    /*$('.bd_tw').css("display","block");*/
                    $('.contact_bdk .sc_tsy').html(data.html);
                }
                $('#captcha_img').trigger('click');
            }
        });
        return false;
    });
    /*products*/
    $(".mk_category ul li img").mousedown(function () {
        if($(this).siblings("ul").css("display")=="none"){
            $(this).siblings("ul").stop().slideDown(function () {
                $(this).css("height","auto")
            });
            $(this).css("transform","rotate(90deg)");
            $(this).parent().siblings().children("ul").stop().slideUp();
            $(this).parent().siblings().children("img").css("transform","rotate(0deg)");
        }else{
            $(this).siblings("ul").stop().slideUp(function () {
                $(this).css("height","auto")
            });
            $(this).css("transform","rotate(0deg)");
        }
    });
    /*   fyq   */
    $(".pro_fyq ul").find(".pro_fyq_ym").mousedown(function () {
        $(this).addClass("pro_active");
        $(this).siblings(".pro_fyq_ym").removeClass("pro_active")
    });
    $(".pro_fyq_prev").mousedown(function () {
        var ac_CS=$(".pro_active").index(".pro_fyq_ym");
        if(ac_CS==0){
            return false;
        }else{
            $(".pro_fyq").find(".pro_fyq_ym").eq(ac_CS-1).addClass("pro_active");
            $(".pro_fyq").find(".pro_fyq_ym").eq(ac_CS-1).siblings(".pro_fyq_ym").removeClass("pro_active")
        }
    });
    $(".pro_fyq_next").mousedown(function () {
        var ac_CS=$(".pro_active").index(".pro_fyq_ym");
        if(ac_CS==$(".pro_fyq_ym").length-1){
            return false;
        }else{
            $(".pro_fyq").find(".pro_fyq_ym").eq(ac_CS+1).addClass("pro_active");
            $(".pro_fyq").find(".pro_fyq_ym").eq(ac_CS+1).siblings(".pro_fyq_ym").removeClass("pro_active")
        }
    });
    /*放大镜*/
    $(".slide").mousedown(function () {
        var djcs=$(this).find("img").attr("src");
        var img_lj_cs=djcs.lastIndexOf("/small");
        var bigImg_lj=$(this).find("img").attr("src").slice(0,img_lj_cs)+$(this).find("img").attr("src").slice(img_lj_cs+6);
        $(".smallImg").attr("src",bigImg_lj);
        $(".bigImg").attr("src",bigImg_lj);
    });
    $(".wrapper").css("width",($(".slide").length+30)*120);
    var i=0;
    var j=parseInt($(".slide").css("width"))+parseInt($(".slide").css("margin-right"));
    $(".button-next").mousedown(function () {
        i++;
        if (i==Math.ceil($(".slide").length)){
            i=0;
            $(".wrapper").animate({"left":-i*j});
        }else{
            $(".wrapper").animate({"left":-i*j});
        }
    });
    $(".button-prev").mousedown(function () {
        if (i==0){
            i=Math.ceil($(".slide").length);
            i--;
            $(".wrapper").animate({"left":-i*j});
        }else{
            i--;
            $(".wrapper").animate({"left":-i*j});
        }
    });
    var wind_wid=$(window).width();
    if(wind_wid<1200){

    }else{
        $('.leftView').on('mouseover',function(){
            $('.mask').css('display','block');
            $('.rightView').css('display','block');
            calculateMaskWH();
        });
        $('.leftView').on('mouseout',function(){
            $('.mask').css('display','none');
            $('.rightView').css('display','none');
        });
        $('.leftView').on('mousemove',function(event){
            var left=event.pageX-$(this).offset().left-$('.mask').width()/2;
            var top=event.pageY-$(this).offset().top-$('.mask').height()/2;
            if(left<0){
                left=0
            }else if(left>$(this).width()-$('.mask').width()){
                left=$(this).width()-$('.mask').width();
            }
            if(top<0){
                top=0;
            }else if(top>$(this).height()-$('.mask').height()){
                top=$(this).height()-$('.mask').height();
            }
            $('.mask').css({
                left:left+'px',
                top:top+'px'
            });
            var rate=$('.bigImg').width()/$('.leftView').width();
            $('.bigImg').css({
                left:-rate*left+'px',
                top:-rate*top+'px'
            });
        });
        function calculateMaskWH(){
            var width=$('.leftView').width()/$('.bigImg').width()*$('.rightView').width();
            var height=$('.leftView').height()/$('.bigImg').height()*$('.rightView').height();
            $('.mask').css({
                "width":width,
                "height":height
            });
        }
    }
    $(".tab_qh_small div").mousedown(function () {
        var tab_qh_cs=$(this).index();
        $(this).addClass("tab_small_active").siblings().removeClass("tab_small_active");
        $(".tab_qh_big>div").eq(tab_qh_cs).addClass("tab_big_active").siblings().removeClass("tab_big_active");
    });
    $(".tab_qh_big form button").click(function () {
        if($(".inquiry_name_srk").val()==""){
            $(".inquiry_name_srk").css({
                "border-color":"red"
            });
            return false
        }else{
            $(".inquiry_name_srk").css({
                "border-color":"#ebebeb"
            })
        }
        if($(".inquiry_tel_srk").val()==""){
            $(".inquiry_tel_srk").css({
                "border-color":"red"
            });
            return false
        }else{
            $(".inquiry_tel_srk").css({
                "border-color":"#ebebeb"
            })
        }
        if((!emailYz.test($(".inquiry_mail_srk").val()))){
            $(".inquiry_mail_srk").css({
                "border-color":"red"
            });
            return false
        }else{
            $(".inquiry_mail_srk").css({
                "border-color":"#ebebeb"
            })
        }
        if($("#message").val()==""){
            $("#message").css({
                "border-color":"red"
            });
            return false
        }else{
            $("#message").css({
                "border-color":"#ebebeb"
            })
        }
        if($(".inquiry_code_srk").val()==""){
            $(".inquiry_code_srk").css({
                "border-color":"red"
            });
            return false
        }else{
            $(".inquiry_code_srk").css({
                "border-color":"#ebebeb"
            })
        }

        $.ajax({
            type: 'post',
            url: lujing+'ajax.php',
            dataType: 'json',
            data: {'name':$(".inquiry_name_srk").val(),'mail':$(".inquiry_mail_srk").val(),'tel':$(".inquiry_tel_srk").val(),'tent':$("#message").val(),'yzm':$(".inquiry_code_srk").val(),'PID':$('#PID').val(),'languageID':$('#languageID').val()},
            success:function(data){

                if(data.type===true){
                    $('.tab_qh_big form')[0].reset();
                    $('.tab_qh_big .sc_tsy').html(data.html);
                    setTimeout(function () {
                        $('.tab_qh_big .sc_tsy').html("");
                    }, 3000);
                }else{
                    $('.tab_qh_big .sc_tsy').html(data.html);
                }

            }
        });
        return false;
    });
    $(".inquiry_an").mousedown(function(){
        var gundjl=$(".description").offset().top-parseInt($(".head").css("height"));
        $('body,html').animate({scrollTop:gundjl},1000);
        $(".tab_qh_small div").eq(1).addClass("tab_small_active").siblings().removeClass("tab_small_active");
        $(".tab_qh_big>div").eq(1).addClass("tab_big_active").siblings().removeClass("tab_big_active")
    });
    $(".sjd_nav_tb").mousedown(function () {
        if($(".nav").css("display")=="none"){
            $(".nav").stop().slideDown(function () {
                $(".nav").css("height","auto")
            });
            $(this).addClass("fa-close").removeClass("fa-bars")
        }else{
            $(".nav").stop().slideUp(function () {
                $(".nav").css("height","auto")
            });
            $(this).addClass("fa-bars").removeClass("fa-close")
        }
    });
    $(".footer_list_bt span").mousedown(function () {
        if($(this).parent().siblings("ul").css("display")=="none"){
            $(this).parent().siblings("ul").stop().slideDown();
            $(this).addClass("fa-minus").removeClass("fa-plus");
            $(this).parent().parent().siblings().children("ul").stop().slideUp();
            $(this).parent().parent().siblings().children(".footer_list_bt").children("span").addClass("fa-plus").removeClass("fa-minus");
        }else{
            $(this).parent().siblings("ul").stop().slideUp();
            $(this).addClass("fa-plus").removeClass("fa-minus")
        }
    });
});