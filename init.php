<?php
/**
 * simplier autoloader, just include this file to load gubnota/smart_loader
*/
spl_autoload_register(
function ($class)
{
$segments = array_filter(explode("\\", $class));
$path = dirname(dirname(dirname(__DIR__))) . "/app/" . implode('/', $segments) . '.php';
if (!file_exists($path))
{
$path = dirname(dirname(dirname(__DIR__))) . "/src/" . implode('/', $segments) . '.php';
}
if (!file_exists($path))
{
$path = dirname(dirname(dirname(__DIR__))) . "/vendor/gubnota/smart_loader/" . implode('/', $segments) . '.php';
}
if (file_exists($path)){include $path;}
else {
	throw new Exception("Class $class doesn't exist.");
    }
}
);
// g::John('write_message_to','Jane','Hi');
