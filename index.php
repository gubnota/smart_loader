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
 * Below several equal ways to initialize and call same class method with help of Gubnota/Gubnota loder
**/
\Gubnota\Gubnota::John('write_message_to', 'Laura Smith', 'Are you still there?');
\Gubnota\Gubnota::instance()->John->write_message_to('Dude', 'Got message?');
\Gubnota\Gubnota::instance()->John->write_message_to('Dude II', 'Got message?');
\Gubnota\Gubnota::instance()->rand;
$instance = \Gubnota\Gubnota::instance();
print "g::instance()->rand = ".g::instance()->rand."\n";
print "\Gubnota\Gubnota::instance()->rand = ".$instance->rand." equals\n";
print "Creation of new independent pocket of classes:\n";
$instance2 = new \Gubnota\Gubnota();
print "\$instance2->rand = $instance2->rand not equals\n";
print "\Gubnota\Gubnota::instance()->rand = ".$instance->rand." still equals\n";

?>