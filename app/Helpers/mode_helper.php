<?php
function LoadMode(){
    $mode="";
    if($_SESSION['mode'] == "night"){
        $mode = "dark-skin";
    }elseif($_SESSION['mode'] == "light"){
        $mode = "light-skin";
    }else{
    $dhsh = date("H");
    if($dhsh>=4&&$dhsh<=18){
        $mode = "light-skin";
    }else{
        $mode = "dark-skin";
    }
    }

    return $mode ;
}
    ?>
