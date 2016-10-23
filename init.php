<?php
/**
 * simplier autoloader, just include this file to load gubnota/smart_loader
*/
include(__DIR__.'/Gubnota/Smart_loader.php');
$l = \Gubnota\Smart_loader::instance();
//$l->place('new_place_to_autoload',__DIR__);
spl_autoload_register([$l, 'load']);
//g::John('write_message_to','Jane','Hi');
