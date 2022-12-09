<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


header('Content-type: text/plain; charset=utf-8');
$num = "6521,10"; //Note that when I $num = 6521.10, and did explode, 10 was converted to 1. Don't know why!!!
$exp = explode(',', $num);
$f = new NumberFormatter("de_DE", NumberFormatter::SPELLOUT);
echo $exp[0] . ' ' ;
echo $exp[1] . ' ' ;

echo ucfirst($f->format($exp[0])) . ' Euro und ' . ucfirst($f->format($exp[1])) . ' cent';
//echo $f->format(6521.10);
