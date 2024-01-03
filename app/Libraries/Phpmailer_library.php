<?php
class Phpmailer_library
{
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load()
    {
        require_once(APPPATH."third_party/phpmailer/class.phpmailer.php");
        $objMail = new PHPMailer;
        return $objMail;
    }
}
?>
