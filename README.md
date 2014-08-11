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

To install modman Module Manager: https://github.com/colinmollenhour/modman

After having installed modman on your system, you can clone this module on your
Magento base directory by typing the following command:

```
$ modman init
$ modman clone git@github.com:aleron75/magelog.git
```

**Composer**

Add the dependency to your ```composer.json```:

```
{
  ...
  "require-dev": {
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
}
```

Then run the following command:

```
$ composer update aleron75/magelog
```

**Common tasks**

After installation:

* if you have cache enabled, disable or refresh it;
* if you have compilation enabled, disable it or recompile the code base.

Usage example
-------------
<pre>
$logger = Mage::getModel(
    'aleron75_magelog/logger',
    array(
        /* log file */ 'test.log',
        /* log level */ Zend_Log::INFO,
        /* force log */ true)
);
$logger->log("Hello World");
$logger->log("Hello Error", Zend_Log::ERR);

$logger
    ->setFilterDataKeys('password')
    ->log(array(
        'username' => 'aleron75',
        'password' => 'admin123'
    ));
</pre>