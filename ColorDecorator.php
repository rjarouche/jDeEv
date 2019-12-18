<?php
$colors = new Colors();


function text($text){
    global $colors;
    echo $colors->getColoredString($text,'white').PHP_EOL;
}

function textSubMenu($text,$param){
    global $colors;
    echo $colors->getColoredString($text." ",'black','light_gray');
    echo $colors->getColoredString($param,'purple','light_gray').PHP_EOL;
}

function textSucess($text){
    global $colors;
    echo $colors->getColoredString($text,'green').PHP_EOL;
}

function textFail($text){
    global $colors;
    echo $colors->getColoredString($text,'white',"red").PHP_EOL;
}

function textWarning($text){
    global $colors;
    echo $colors->getColoredString($text,'yellow').PHP_EOL;
}






