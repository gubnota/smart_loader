# Gubnota autoloader class

Autoload class helper to call class methods by 
using Laravel 4 alike mechanism via pseudo-static 
calling and by-pass variables to other method 
which simplifies storing same class instace 
without using global keyword quite outdated 
solution. With composer pakagist psr-0 autoloader 
use better, otherwise please declare autoloading 
in psr-0 (or 4) PHP default order by looking via 
folder alike class namespaces.

## Installing

Simply add `gubnota/smart_loader` to your composer.json and run `composer update`. Or add download packege to according your autoloading pattern subsystem place to load when calling it.

## Included files

* index.php - Example of usage
* g.php - class name shortcode, for easier calling
* Gubnota/Gubnota.php - main class helper that do all the stuff
* John/Doe.php - class for calling (with only one public method)

## Autoload issue
If you are not gonna use Composer psr-0 standard default autoloading class solution, please 
not forget ti use PHP default one by calling:

```php
// Use default autoload implementation
// set_include_path(__DIR__);
spl_autoload_register();
```
## Usage
Creating instance of the class for calling only one method: 
```php
$john_doe = new John\Doe(); 
$john_doe->write_message_to('Samuel Smitters');
```

That usually become a headache: you have to create every 
time in every new file utilizing class that class method. 
Old method includes utilize static method or creating the global variable.
New apporach included in Laravel 4, for instance, using catching name method 
to create instance of, save every called instance of the class to 
special array to re-call it again without recreating. In most cases 
you only need this appoach.

Below several equal ways to initialize and call same class method with help of Gubnota/Gubnota loder:

```php
\Gubnota\Gubnota::John('write_message_to', 'Laura Smith', 'Are you still there?');
```
or:

```php
\Gubnota\Gubnota::instance()->John->write_message_to('Dude', 'Got message?');
```
or:

```php
\Gubnota\Gubnota::instance()->John->write_message_to('Dude II', 'Got message?');
```
or:

```php
\Gubnota\Gubnota::instance()->rand;
```
or:

```php
$instance = \Gubnota\Gubnota::instance();
$instance->John->write_message_to('Dude III', 'Got message?');
```

Because individual instances is not creating every tame, it all shares 
same public porperty with random number in it. Any special case required re-creating 
another instance can be also done easily utilizing the `new` keyword:

```php
print "g::instance()->rand = ".g::instance()->rand."\n";
print "\Gubnota\Gubnota::instance()->rand = ".$instance->rand." equals\n";
print "Creation of new independent pocket of classes:\n";
$instance2 = new \Gubnota\Gubnota();
print "\$instance2->rand = $instance2->rand not equals\n";
print "\Gubnota\Gubnota::instance()->rand = ".$instance->rand." still equals\n";
```

## Installing with composer

To be able to use within your composer-powered project, you need to install them via composer.
Simply add the libraries to your project's `composer.json` then run `php composer.phar install`:

```json
{
    "require": {
        "gubnota/smart_loader" : "*",
    }
}
```

## Config and runtime config

Currently the Gubnota\smart_loader or `g` symlink still lack a lot of config options they should probably accept.