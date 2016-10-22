<?php
/**
 * Uses default Autoloader helper 
 * to autoload classes in psr-0 order
 * Namespace/Class.php, etc.
 *
 * @copyright 	2014 Vladislav Muravyev
 * @link 		http://gubnota.ru
 * @author 		Vladislav Muravyev
 *
 */

// Use default autoload implementation
// set_include_path(__DIR__);
spl_autoload_register();

$john_doe = new John\Doe(); 
$john_doe->write_message_to('Samuel Smitters');

/**
 * Below several equal ways to register real classnames
 * under facade, emty facade names, chaining several facades init
 * initialize and call same class method with help of Gubnota/Gubnota loder
**/
\Gubnota\Gubnota::instance()
->empty_facade() // empty all facades default name values
->facade('John','John\Doe')
->facade('Smith','John\Doe') // facades can share same class among different names
->delete_facade('Smith') // deletes facade name called 'Smith'
;
// From there we'll be using g:: symlink instead of \Gubnota\Gubnota::

g::John('write_message_to', 'Laura Smith', 'Are you still there?');
// Same like:
// $john = new John();
// $john->write_message_to('Laura Smith', 'Are you still there?');

g::instance()->John->write_message_to('Dude', 'Got message?');
g::instance()->John->write_message_to('Dude', 'Got message?');
g::instance()->John->write_message_to('Dude II', 'Got message?');
g::instance()->rand;
$instance = g::instance();
print "g::instance()->rand = ".g::instance()->rand."\n";
print "g::instance()->rand = ".$instance->rand." equals\n";
print "Creation of new independent pocket of classes:\n";
$instance2 = new g();
print "\$instance2->rand = $instance2->rand not equals\n";
print "g::instance()->rand = ".$instance->rand." still equals\n";
print "g::instance()->facade('John') = ". g::instance()->facade('John'). "\n";
print "g::instance()->classes = ". str_replace( ["Array\n","(",")\n"], ['','[',']'], (print_r(g::instance()->classes, 1) ) ). "\n";
?>