<?php
//include 'database.php';
if(empty($_POST)){
    exit();
}
function verify_token($token){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('secret' => '6LdIL3gpAAAAACmfxwqLhTVkXmc4DP--HSGzGsso','response' => $token),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $res = json_decode($response);
    return $res->success;
}
if(!verify_token($_POST['token'])){
    exit();
}
$name = $_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$url=$_POST['url'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.shopperscargo.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'shopper2';                 // SMTP username
    $mail->Password = 'S104-QDFx4k;zu';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('info@shopperscargo.com', 'Shoppers Cargo');
    $mail->addAddress($email);
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Request Recieved';
    $mail->Body    = 'your request has been recieved and is been processed. We shall get back to you during our business hours';
    $mail->AltBody =  'your request has been recieved and is been processed. We shall get back to you during our business hours';

    if($mail->send()){
    
    $_SESSION['set'] = $email;
header('location:index.php');

    }
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}


$mail2 = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail2->SMTPDebug = 1;                                 // Enable verbose debug output
    $mail2->isSMTP();                                      // Set mailer to use SMTP
    $mail2->Host = 'mail.shopperscargo.com';  // Specify main and backup SMTP servers
    $mail2->SMTPAuth = true;                               // Enable SMTP authentication
    $mail2->Username = 'shopper2';                 // SMTP username
    $mail2->Password = 'S104-QDFx4k;zu';                           // SMTP password
    $mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail2->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail2->setFrom('info@shopperscargo.com', 'Shoppers Cargo');
    $mail2->addAddress('dummye72@gmail.com');     // Add a recipient
                   // Name is optional
    
   

    //Content
    $mail2->isHTML(true);                                  // Set email format to HTML
    $mail2->Subject = 'Ticket no'.$ticket;
    $mail2->Body    = 'name:'.$name.'<br>'.
    'phone:'.$phone.'<br>'.
    'url:'.$url.'<br>'.
    'email:'.$email.'<br>';





    
    $mail2->AltBody =  'name:'.$name.''.
    'phone:'.$phone.''.
    'url:'.$url.''.
    'email:'.$email.'';

    $mail2->send();

    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail2->ErrorInfo;
}

?>




