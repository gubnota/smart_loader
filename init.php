<?php
/**
 * simplier autoloader, just include this file to load gubnota/smart_loader
*/
$loaded=false;
if (class_exists('\Gubnota\Smart_loader')) {$loaded=true;}
if (!$loaded) include __DIR__.'/Gubnota/Smart_loader.php';
$l = \Gubnota\Smart_loader::instance();
$l->place('smart_loader',__DIR__);
if (!$loaded) spl_autoload_register([$l, 'load']);
//g::John('write_message_to','Jane','Hi');
//to enumerate all registered directories: print_r($l->place();
