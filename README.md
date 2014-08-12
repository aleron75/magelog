magelog
=======

Introduction
------------

A Magento Module that wraps and enhances native logging functionalities 

Installation
------------

You can install this extension in several ways:

**Download**

Download the full package, copy the content of the ```src``` directory
in your magento base directory; pay attention not to overwrite
the ```app``` folder, only merge its contents into existing directory;

**Modman**

Install modman Module Manager: https://github.com/colinmollenhour/modman

After having installed modman on your system, you can clone this module on your
Magento base directory by typing the following command:

```
$ modman init
$ modman clone git@github.com:aleron75/magelog.git
```

**Composer**

Install composer: http://getcomposer.org/download/

Install Magento Composer: https://github.com/magento-hackathon/magento-composer-installer

Add the dependency to your ```composer.json```:

```
{
  ...
  "require": {
    ...
    "aleron75/magelog": "dev-master",
    ...
  },
  "repositories": [
    ...
    {
      "type": "vcs",
      "url":  "git@github.com:aleron75/magelog.git"
    },
    ...
  ],
  ...
  "extra": {
    "magento-root-dir": "<magento_installation_dir>/"
  }
  ...
}
```

Then run the following command from the directory where your ```composer.json```
file is contained:

```
$ php composer.phar install
```

or

```
$ composer install
```

**Common tasks**

After installation:

* if you have cache enabled, disable or refresh it;
* if you have compilation enabled, disable it or recompile the code base.

Usage example
-------------

Passing a string:

<pre>
$logger = Mage::getModel(
    'aleron75_magelog/logger',
    array(
        /* log file */ 'test.log',
        /* log level */ Zend_Log::INFO,
        /* force log */ true)
);
$logger->log("Hello World");
</pre>

will produce the following output:

<pre>
2014-08-11T15:59:25+00:00 INFO (6): Array
(
    [__pid] => 14460
    [__file] => /home/alessandro/NetBeansProjects/magedev/magento/logtest.php
    [__line] => 67
    [__function] => log
    [__class] => Aleron75_Magelog_Model_Logger
    [0] => Hello World
)
</pre>

Passing an error level different by the default one:

<pre>
$logger->log("Hello Error", Zend_Log::ERR);
</pre>

will produce the following output:

<pre>
2014-08-11T15:59:25+00:00 ERR (3): Array
(
    [__pid] => 14460
    [__file] => /home/alessandro/NetBeansProjects/magedev/magento/logtest.php
    [__line] => 68
    [__function] => log
    [__class] => Aleron75_Magelog_Model_Logger
    [0] => Hello Error
)
</pre>

Passing an array with some data to filter:

<pre>
$logger
    ->setFilterDataKeys('password')
    ->log(array(
        'username' => 'aleron75',
        'password' => 'admin123'
    ));
</pre>

will produce the following output:

<pre>
2014-08-11T15:59:25+00:00 INFO (6): Array
(
    [__pid] => 14460
    [__file] => /home/alessandro/NetBeansProjects/magedev/magento/logtest.php
    [__line] => 75
    [__function] => log
    [__class] => Aleron75_Magelog_Model_Logger
    [username] => aleron75
    [password] => ****
)
</pre>

**Note:** printing of the backtrace metadata identified by the keys starting
with "__" can be disabled by calling the <code>setLogAdditionalData(false)</code>
method on the logger object after its instantiation.