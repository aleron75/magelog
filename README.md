magelog
=======

A Magento Module that wraps and enhances native logging functionalities 

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