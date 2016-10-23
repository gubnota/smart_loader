# Gubnota autoloader class

Gubnota/smart_loader (aka `g::` or `\Gubnota\Gubnota`) is a class-
helper to load and reuse class instances. It makes re-using 
class instances easier throughout all application (no need to 
re-initialize new instance, each instance stored in global object). 
Autoload class helper increases drastically perfomance and 
convenience by reusing instances when calling class methods in pseudo-static way:
```php
g::Class('method','arg',...) //or
g::instance()->Class->method('arg',...)
```

You can by-pass variables to the other calee (method) in jQuery-way. By
default, `g::` stores only one class instace and re-use it when calling 
the same class from other place. Autoloader can be used two ways: 
composer pakagist default psr-4 autoloader, and `g::` own autoloader. 
Fully compatible with >= PHP 5.4, PHP 7.0.

## Installing by composer

Add `gubnota/smart_loader` string to your composer.json require section and run `composer
update`:
```json
    "require": {
        "php" : ">=5.4",
        "gubnota/smart_loader": "dev-master"
    },
```
Alternatively you can [download package](https://github.com/gubnota/smart_loader/archive/master.zip) to include according to your autoloading pattern subsystem.

```php
include('vendor/gubnota/smart_loader/init.php');

```

## Included files

* test.php - Example of usage
* g.php - class name shortcode (call g:: rather than Gubnota\\Gubnota)
* Gubnota/Gubnota.php - main class helper that do all the stuff
* John/Doe.php - class for calling (with only one public method)
* init.php - include this to autoload

## Autoloading classes
If you are not gonna use Composer psr-4 standard
autoloading class solution, please  don't forget to setup your own:
```php
// Use g:: default autoload implementation
include(__DIR__.'/vendor/gubnota/smart_loader/init.php');
```

You might want to use more advanced usage by adding extra directories 
to search:
```php
include(__DIR__.'/vendor/gubnota/smart_loader/Gubnota/Smart_loader.php');
$l = \Gubnota\Smart_loader::instance();
$l->place('new_place_to_autoload',__DIR__);
spl_autoload_register([$l, 'load']);
```

When you call smart_autoloader from anywhere of your other places:
## Remapping long names
smart_loader also able to remap long class names to the short ones:
```php
g::instance()->facade('john','John\Doe')->get_instance('john');
```
See also at **Facades** section.

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
g::{'John\\Doe'}('write_message_to',
    ['Laura Smith','John Smith','John Marcus','Mark Brown'][rand(0,3)],
    ['How long does it take to reach your house?','How about we meet next Tuesday?','Hello there.','Are you still there?'][rand(0,3)]);
```
or:
```php
g::instance()->{'John\\Doe'}->write_message_to(
    ['Laura Smith','John Smith','John Marcus','Mark Brown'][rand(0,3)],
    ['How long does it take to reach your house?','How about we meet next Tuesday?','Hello there.','Are you still there?'][rand(0,3)]);
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

### Facades

For using name with full namespaces rather than write in every file, better to regsiter it with facades mechanism:
```php
g::instance()
->empty_facade() // empty all facades default name values
->facade('John','John\Doe') // add default one value included with package
->facade('Smith','John\Doe') // facades can share same class among different names
->delete_facade('Smith') // deletes facade name called 'Smith'
;
```
After you register facade, just call it anywhere like:
```php
g::instance()
->facade('sw_sendmail','\Swift_SendmailTransport')
->facade('sw_smtp','\Swift_SmtpTransport')
->facade('sw_message','\Swift_Message')
->facade('sw_malier','\Swift_Mailer')
g::sw_message;
```

## Installing with composer

To be able to use within your composer-powered project, you need to install them via composer.
Simply add the libraries to your project's `composer.json` then run `php composer.phar install`:

```json
{
    "require": {
        "php" : ">=5.4",
        "gubnota/smart_loader": "dev-master"
    }
}
```

## Config and runtime config

Currently the Gubnota\smart_loader or `g` symlink still lack a lot of config options they should probably accept.

## Troubleshooting

If autoloader not works be sure to inlude in `composer.json` parent project file `autoload` and `config` directives like:

```php
{
    "name": "gubnota/your_personal_project",
    "authors": [
        {
            "name": "Vladislav Muravyev",
            "email": "me@gubnota.ru"
        }
    ],
    "require": {
        "php" : ">=5.4",
    	"gubnota/smart_loader": "dev-master"
    },
    "min-stability":"dev-master",
    "config": {
        "vendor-dir": "./vendor/"
    },
    "autoload": {
        "psr-4": {"": ["app/"]}
    }
}

```

You can also autoload files explicily, like:
```json
    "autoload": {
        "files": ["Gubnota/Gubnota.php","g.php","John/Doe.php"]
    }
```

* [More information about autoloading configure in composer https://getcomposer.org/doc/04-schema.md#autoload](https://getcomposer.org/doc/04-schema.md#autoload)