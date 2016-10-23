<?php
/**
 * This file is part of Gubnota/smart_loader.php.
 * (A Gubnota smart_loader implementation in PHP)
 * (c) 2014-2016 Vladislav Muravyev
 *
 * For the full copyright and license information, please look at the LICENSE file in project link
 *
 * Gubnota/smart_loader is a class-helper to pseudo-statically load classes and 
 * simplifies re-using instances throughout all application code. 
 *
 * @copyright	2016 Vladislav Muravyev
 * {@link https://github.com/gubnota/smart_loader}
 * @author		Vladislav Muravyev {@link http://gubnota.ru}
 * Usage:
	include(__DIR__.'/Gubnota/Smart_loader.php');
	$l = \Gubnota\Smart_loader::instance();
	// to add new place to look at:
	$l->place('new_place_to_autoload',__DIR__);
	spl_autoload_register([$l, 'load']);
	// test it:
	g::John('write_message_to','Jane','Hi');
*/

namespace Gubnota;
class Smart_loader
{

	// Locations to autoload (like psr-4, but without imploding namespaces)
	protected $places = array(
	);

	/**
	 * Here we put initialized instance of this class and 
	 * utilize it on every static call for everywere
	 * Сюда прячем экземпляр инициализованного класса и его 
	 * же используем при статических вызовах
	 *
	 * @var app
	 */
	protected static $app;

	// random number using for recognize whether created instance the same
	// Случайное число чтобы идентифицировать экземпляр класса
	protected $rand;

	/**
	 * Constructor let empty in case or parent::__construct() calls
	 * Конструктор оставим пустым, но определим его на случай обращения parent::__construct() в классах API
	 */
	public function __construct($num=0)
	{
		if (!$this->rand){
		if ($num === 0) $num = rand();
		$this->rand = $num;
	}
		return $this->rand;
		// error_reporting(E_ALL & !E_STRICT);
	}

	public static function instance(){
		if (!static::$app) static::$app = new self();
		return self::$app;
	}

	/**
	 * method to delete location to autoload
	 * Метод для удаления места для автозагрузки
	 */
	public function delete_place($name)
	{
		if (!empty($name))
			unset($this->places[$name]);
        return $this;
	}

	/**
	 * method to delete all classes places names
	 * Метод для удаления всех фасадов
	 */
	public function empty_place()
	{
		$this->places=[];
        return $this;
	}

	/**
	 * method to get/insert/update classes places
	 * Метод для получения, создания, замены фасада
	 */
	public function place($name=null, $value = null)
	{
		if (!empty($name) && empty($value))
    	 return (array_key_exists($name, $this->places) ? $this->places[$name] : $value);
		if (!empty($name) && !empty($value))
			$this->places[$name]=$value;
         return $this;
	}

	/**
	 * Method to load class
	 * Метод для автозагрузки класса
	 */
	public function load($class)
	{
	$segments = array_filter(explode("\\", $class));
	if (empty($this->places)){
	$this->place('parent',dirname(__DIR__));
	$this->place('app',dirname(dirname(dirname(dirname(__DIR__)))) . "/app/");
	$this->place('src',dirname(dirname(dirname(dirname(__DIR__)))) . "/src/");
	$this->place('vendor',dirname(dirname(dirname(dirname(__DIR__)))) . "/vendor/");
	$this->place('gubnota',dirname(dirname(dirname(dirname(__DIR__)))) . "/vendor/gubnota/smart_loader/");
	}
	print_r($this->places);
	foreach ($this->places as $key => $value) {
	if (substr($value, strlen($value)-1)!=='/') $value.='/';
	$path = $value . implode('/', $segments) . '.php';
	if (file_exists($path)) include($path); return;
	}
	// die($path);
	throw new Exception("Class $class doesn't exist.");
	}

}
