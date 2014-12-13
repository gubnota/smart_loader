<?php

/**
 * Autoload class helper to call class methods by 
 * using Laravel 4 alike mechanism via pseudo-static 
 * calling and by-pass variables to other method 
 * which simplifies storing same class instace 
 * without using global keyword quite outdated 
 * solution. With composer pakagist psr-0 autoloader 
 * use better, otherwise please declare autoloading 
 * in psr-0 (or 4) PHP default order by looking via 
 * folder alike class namespaces, etc.
 *
 * @copyright 	2014 Vladislav Muravyev
 * @link 		http://gubnota.ru
 * @author 		Vladislav Muravyev
 *
 */
// Instead of Composer autoload, you can also use default autoload implementation
// set_include_path(__DIR__);
// spl_autoload_register();

namespace Gubnota;
class Gubnota
{
	public static $globals=[];// для хранения прединициализуемых параметров
	// API classes symlinks with their namespaces preceding (aka facades in Laravel 4)
	public $classes = array(
		'John' => 'John\Doe',
	);
	
	// Created objects goes stored here
	private static $objects = array();
	
	/**
	 * Here we put initialized instance of this class and 
	 * utilize it on every static call for everywere
	 * Сюда прячем инстанс инициализованного класса и его 
	 * же используем при статических вызовах
	 *
	 * @var app
	 */
	protected static $app;

	// random number using for recognize whether created instance the same
	// Случайное число чтобы идентифицировать инстанс оф класс
	public $rand;

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
	 * Magic method to create API object
	 * Магический метод, создает нужный объект API
	 */
	public function __get($name)
	{
		if ($name == 'instance')
			return self::$app;
		// If it already exists - return it
		// Если такой объект уже существует, возвращаем его
		if(isset(self::$objects[$name]))
		{
			return(self::$objects[$name]);
		}
		
		// If there is no any class like this - throw an error
		// Если запрошенного API не существует - ошибка
		if (array_key_exists($name, $this->classes)) {
			// define class name
			// Определяем имя нужного класса
			$class = $this->classes[$name];
		}

		else if(class_exists($name)){
			$class = $name;
		}

		else
		{
			return null;
		}
		
		// Save it for calling next time
		// Сохраняем для будущих обращений к нему
		self::$objects[$name] = new $class();

		// returns the created object
		// Возвращаем созданный объект
		return self::$objects[$name];
	}

	/**
	 * Handle dynamic, static calls to the object.
	 *
	 * @param  string  $method
	 * @param  array   $args
	 * @return mixed
	 */
	public static function __callStatic($class, $args)
	{
		if (count($args)<1){
			throw new \RuntimeException("Need to provide method name for $class that exists!");
		}

		$method = array_shift($args);
		if (!static::$app) static::$app = new self();
		$instance = static::$app;

		if (array_key_exists($class, $instance->classes)) {
			// define class name
			// Определяем имя нужного класса
			$class = $instance->classes[$class];
		}

		// If there is no any class like this - throw an error
		// Если запрошенного API не существует - ошибка
		else if(class_exists($class)){
			$class = $class;
		}

		// If requesting class is not exists - throw error
		// Если запрошенного Класса не существует - ошибка
		else {
			throw new \RuntimeException("Class $class does not exists!");
		}


		if (!array_key_exists($class, $instance::$objects))
		// Save it for calling next time
		// Сохраняем для будущих обращений к нему
			$instance::$objects[$class] = new $class();

		// returns the created object calling it's method with supplied args
		// Возвращаем созданный объект вызвав соотв. метод с аргументами
		$obj = $instance::$objects[$class];

		switch (count($args))
		{
			case 0:
				return $obj->$method();

			case 1:
				return $obj->$method($args[0]);

			case 2:
				return $obj->$method($args[0], $args[1]);

			case 3:
				return $obj->$method($args[0], $args[1], $args[2]);

			case 4:
				return $obj->$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array($instance, $method), $args);
		}
	}
	/**
	 * Handle dynamic calls to the object.
	 *
	 * @param  string  $method
	 * @param  array   $args
	 * @return mixed
	 */
	public function __call($class, $args)
	{
		if (count($args)<1){
			throw new \RuntimeException("Need to provide method name for $class that exists!");
		}

		// If requesing class is not exists - throw error
		// Если запрошенного Класса не существует - ошибка
		if(!class_exists($class)){
			throw new \RuntimeException("Class $class does not exists!");
		}

		$method = array_shift($args);
		if (!static::$app) static::$app = new self();
		$instance = static::$app;

		if (!array_key_exists($class, $instance::$objects))
		// Save object for later call
		// Сохраняем для будущих обращений к нему
			$instance::$objects[$class] = new $class();

		// returns the created object calling it's method with supplied args
		// Возвращаем созданный объект вызвав соотв. метод с аргументами
		$obj = $instance::$objects[$class];

		switch (count($args))
		{
			case 0:
				return $obj->$method();

			case 1:
				return $obj->$method($args[0]);

			case 2:
				return $obj->$method($args[0], $args[1]);

			case 3:
				return $obj->$method($args[0], $args[1], $args[2]);

			case 4:
				return $obj->$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array($instance, $method), $args);
		}
	}
}
