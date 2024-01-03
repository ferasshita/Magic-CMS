<?php
require APPPATH. 'ThirdParty/twilio-php-main/src/Twilio/autoload.php';
use Twilio\Rest\Client;
function SendSms($to,$body){
     // Get a reference to the controller object

     // You may need to load the model if it hasn't been pre-loaded

     $account_sid = $_ENV['ACCOUNT_ID'];
     $auth_token = $_ENV['AUTH_TOKEN'];
     $twilio_phone_number = $_ENV['TWILIO_PHONE_NUMBER'];

     if(($account_sid || $auth_token || $twilio_phone_number) == NULL){
       die ("Complete all the credentials for TWILIO SMS in .env");
     }

     $client = new Client($account_sid, $auth_token);

     $client->messages->create(
         $to,
         array(
             "from" => $twilio_phone_number,
             "body" => $body,
         )
     );

}
?>
