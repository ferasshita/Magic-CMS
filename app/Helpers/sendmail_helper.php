<?php
function SendEmail($subject,$to,$body){
     // Get a reference to the controller object
     $mail = \Config\Services::email();

     // You may need to load the model if it hasn't been pre-loaded
     $mail->Host = $_ENV['EMAIL_HOST'];
     $mail->Username = $_ENV['EMAIL_USERNAME'];
     $mail->Password = $_ENV['EMAIL_PASSWORD'];
     $mail->From = $_ENV['EMAIL'];
     $mail->FromName = $_ENV['EMAIL_NAME'];
     if(($_ENV['EMAIL_NAME'] || $_ENV['EMAIL_HOST'] || $_ENV['EMAIL_USERNAME'] || $_ENV['EMAIL_PASSWORD'] || $_ENV['EMAIL']) == NULL){
       die ("Complete all the credentials for EMAIL in .env");
     }

     $mail->Subject = $subject;
     $mail->Body = $body;
     $mail->Header ='Content-type:text/html;charset=UTF-8';
     $mail->setHeader("List-Unsubscribe",'<'.$_ENV['ADMIN_EMAIL'].'>, <'.base_url().'/account?email='.$to.'>');
     $mail->WordWrap = 50;
     $str1= "gmail.com";
     $str2=strtolower($_ENV['EMAIL']);
     If(strstr($str2,$str1))
     {
     $mail->SMTPSecure = 'tls';
     $mail->Port = 587;
     if(!$mail->Send()) {
    return false;
     }else{
        return true;
     }
     }else{
         $mail->Port = 25;
         if(!$mail->Send()) {
        return false;
         }else{
        return true;
     }
     }
}
?>
