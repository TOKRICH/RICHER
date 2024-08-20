<?php
session_start();
include_once  '../../../Include/web_inc.php';
if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
    if(isset($_POST['news_letter'])){
        $mails=test_input(verify_str($_POST['news_letter']));
        $mailip=test_input(verify_str(getRealIp()));

        if(preg_match('/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[-_a-z0-9][-_a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,})$/i',$mails)){

            //写入数据库

            $db_conn->query("INSERT INTO sc_email(e_ml,e_ip) VALUES ('$mails','$mailip')");
            echo json_encode(['type'=>true,'html'=>'<span class="bd_ty">'.$Label['tag_messgetj'].'</span>']);

        }else{

            echo json_encode(['type'=>false,'html'=>'<span class="bd_tw">'.$Label['tag_messgets'].'</span>']);

        }
    }else if(isset($_POST['tent'])){
        $msg_email=test_input(verify_str($_POST['mail']));
        $msg_content=test_input(verify_str($_POST['tent']));
        $yzm=$_POST['yzm'];
        $msg_tel=test_input(verify_str($_POST['tel']));
        $names=test_input(verify_str($_POST['name']));
        $msg_pid=test_input(verify_str($_POST['PID']));
        $msg_languageID=test_input(verify_str($_POST['languageID']));
        $msg_time=date("Y-m-d h:i:s",time()+8*60*60);
        $msg_ip=test_input(verify_str(getRealIp()));
        if($yzm == $_SESSION['authcode']){

            if(preg_match('/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[-_a-z0-9][-_a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,})$/i',$msg_email) && $names!==""){

                //写入数据库
                $db_conn->query("INSERT INTO sc_msg(msg_pid,msg_email,msg_content,msg_ip,msg_name,msg_tel,msg_time,languageID)"
                    . "VALUES ('$msg_pid','$msg_email','$msg_content','$msg_ip','$names','$msg_tel','$msg_time','$msg_languageID')");

                //邮件发送

                $mailtitle="注意:来自".$_SERVER['SERVER_NAME']."网站的询盘";
                $mailcontent="邮箱:".$msg_email."<br>"
                    . "姓名:".$names."<br>"
                    . "电话:".$msg_tel."<br>"
                    . "留言:".$msg_content."<br>"
                    . "IP地址:".$msg_ip."<br>"
                    . "详细信息登陆网站后台查看！";
                if ($web_mailopen==1){


                    echo  SendEmail($smtpserver,$smtpuser,$smtppass,$smtpemailto,$smtpserverport,$smtpemailtj,$mailtitle,$mailcontent);

                }


                echo json_encode(['type'=>true,'html'=>'<span class="bd_ty">'.$Label['tag_messgetj'].'</span>']);

            }else{


                echo json_encode(['type'=>false,'html'=>'<span class="bd_tw">'.$Label['tag_messgets'].'</span>']);

            }

        }else{

            echo json_encode(['type'=>false,'html'=>'<span class="bd_tw">'.$Label['tag_messgets'].'</span>']);
        }
    }
}