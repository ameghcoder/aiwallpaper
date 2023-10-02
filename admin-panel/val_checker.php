<?php

require_once './SDC.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
    if(!empty($_POST['u_email'])){
        $EMAIL = $_POST['u_email'];
        $EMAIL = crcheck($EMAIL);
        cemail($EMAIL);
    } 
    if(!empty($_POST['u_fname']) || !empty($_POST['u_lname'])){
        $FNAME = $_POST['u_fname'];
        $LNAME = $_POST['u_lname'];

        $FNAME = crcheck($FNAME);
        $LNAME = crcheck($LNAME);

        cname($FNAME, $LNAME);
    }
    if(!empty($_POST['veri_code'])){
        $code = $_POST['veri_code'];
        $code_email = $_POST['veri_email'];
        crcheck($code);
        crcheck($code_email);
        code_veri($code, $code_email);
    } 
    if(!empty($_POST['u_username'])){
        $us_name = $_POST['u_username'];
        crcheck($us_name);
        c_user($us_name);
    }
}

function cname($fname, $lname = ''){
    if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
        msgSender("Only letters and white space allowed", 'w');
    } else if(!preg_match("/^[a-zA-Z-' ]*$/", $lname)){
        msgSender("Only letters and white space allowed", 'w');
    } else{
        msgSender('Verify', 's');
    }
}

function cemail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && (str_contains($email, '@gmail.com') || str_contains($email, '@yahoo.com') || str_contains($email, '@outlook.com') || str_contains($email, '@hotmail.com') || str_contains($email, '@'))) {
        $nameErr = "Invalid email format";
        msgSender($nameErr, 'w');
    } else{
        email_Sender($email);
    }
}

function crcheck($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function msgSender($MSG, $FLAG){
    $msgArr = array(
        "msg" => $MSG, 
        "flag" => $FLAG
    );
    if($FLAG == 's'){
        echo json_encode($msgArr);
        exit;
    } else if($FLAG == 'w'){
        echo json_encode($msgArr);
    }
}

function email_Sender($to){

    $ocode = rand(100000,999999);

    $otime = time();

    $sj = "Email verification OTP";

    $header = "MIME-Version: 1.0\r\nContent-Type: text/html;charset=UTF-8\r\n";
    $header .= "From: learnbeyondthink@gmail.com";

    $msg =  '<main style="display: flex; align-content : center; justify-content:center; width : 100%; height : auto; border-radius : 10px;background: #F6F6F2; margin: 0px; padding: 10px 0px;">' .
                '<section style="width : 100%; max-width : 400px; box-shadow : 0px 0px 5px 0px black; height: auto; min-height: 400px; margin: 0px; padding: 15px; border-radius: 10px;">' .
                    '<h1>BLOGDAY.ONLINE</h1>' .
                    '<h2>Verify Your Email</h2>' .
                    '<p>Here is your Email verification code.</p>' .
                    '<div style="background: silver; padding: 10px; text-align: center; border-radius: 10px; font-size : 25px; font-weight : bold; color : #151210;">' .
                    $ocode .
                    '</div>' .
                    '<p>Please make sure you never share this code to anyone.</p>' .
                    '<ol>' .
                        '<strong>Note:</strong>' .
                        '<li>This code will expire in 15 minutes.</li>' .
                        '<li>If you not generate this code. Please Ignore this Email.</li>' .
                    '</ol>' .
                    '<p>~Thanks for using~ <a href="//blogday.online">Blogday.online</a></p>' .
                '</section>' .
            '</main>';

    $selectQuery = "INSERT INTO email_verify (UEMAIL, UCODE, UTIME) values('$to', '$ocode', '$otime')";

    if(mysqli_query($GLOBALS['connn'], $selectQuery)){
        if(mail($to, $sj, $msg, $header)){
            msgSender('Message Sent Successfully, Check Inbox', 's');
        } else{
            msgSender('Something went wrong, Try again', 'w');  
        }
    } else {
        msgSender('Something went wrong, Try again', 'w');
    }

}

function code_veri($code, $code_email){

    $sq = "SELECT * FROM email_verify where UEMAIL='$code_email'";
    $my_sq = mysqli_query($GLOBALS['connn'], $sq);

    if(mysqli_fetch_row($my_sq) > 0){
        $r_d = mysqli_fetch_assoc($my_sq);
        $t_rd = $r_d['UTIME'];
        $c_rd = $r_d['UCODE'];
        
        $c_t = time();
        $d_t = $c_t - $t_rd;
        if($d_t > 900){
            msgSender('Code is expired, Resend it', 'w');
        } else if($d_t < 900){
            if($c_rd == $code){
                msgSender('Email is verified', 's');
            } else {
                msgSender('Code is invalid', 'w');
            }
        }
    } else{
        msgSender('Something went wrong', 'w');
    }
}

function c_user($un){
    $sq02 = "SELECT * FROM bdo_x_y_z_user where bd_username='$un'";
    $my_sq03 = mysqli_query($GLOBALS['connn'], $sq02);
    if(mysqli_fetch_row($my_sq03) > 0){
        msgSender('Username is exists, Try another', 'w');
    } else{
        msgSender('Created', 's');
    }
}
?>