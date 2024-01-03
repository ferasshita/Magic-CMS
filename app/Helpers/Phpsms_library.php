<?php
class Phpsms_library
{
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load()
    {
        require_once(APPPATH."third_party/twilio-php-main/src/Twilio/autoload.php");
        $objMail = new Phpsms_library;
        return $objMail;
    }
}
?>
