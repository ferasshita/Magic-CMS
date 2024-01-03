<?php
function LoadLang(){
    $session = \Config\Services::session();

    // Check if 'language' key exists in the session
    $language = $session->get('language');

    switch ($language) {
        case 'English':
            include_once APPPATH. "language/english.php";
            break;
        case 'العربية':
            include_once APPPATH. "language/arabic.php";
            break;
        default:
            $session->set('language', 'العربية');
            include_once APPPATH. "language/arabic.php";
            break;
    }
}
