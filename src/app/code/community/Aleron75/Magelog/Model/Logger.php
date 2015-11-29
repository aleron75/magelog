<?php

class Aleron75_Magelog_Model_Logger extends Mage_Core_Model_Log_Adapter
{
    /**
     * Store log level
     *
     * @var mixed|int
     */
    protected $_logLevel = null;

    /**
     * Store flag to force logging
     *
     * @var string
     */
    protected $_forceLog = false;

    /**
     * The logger object used to log
     *
     * @var Mage_Core_Model_Logger
     */
    protected $_logger = null;

    /**
     * Whether or not to prepend additional backtrace data
     *
     * @var bool
     */
    protected $_logAdditionalData = true;

    /**
     * Constructor can be called either with a single parameter representing the
     * log file name or with an array, representing respectively:
     *
     * log file name
     * log level
     * force log flag
     *
     * @param string|array $params
     */
    public function __construct($params)
    {
        if (is_array($params)) {
            list($fileName, $logLevel, $forceLog) = $params;
            $this->_logLevel = $logLevel;
            $this->_forceLog = $forceLog;
        } else {
            $fileName = $params;
        }
        $this->_logger = Mage::getModel('core/logger');
        parent::__construct($fileName);
    }

    /**
     * Logs $data array; if log level and/or force log flag are not passed,
     * internal initialized values are used.
     *
     * @param mixed $data
     * @param int $logLevel
     * @param boolean $forceLog
     * @return $this|Mage_Core_Model_Log_Adapter
     */
    public function log($data = null, $logLevel = null, $forceLog = null)
    {
        if (is_null($logLevel)) {
            $logLevel = $this->_logLevel;
        }

        if (is_null($forceLog)) {
            $forceLog = $this->_forceLog;
        }

        if ($data === null) {
            $data = $this->_data;
        } else {
            if (!is_array($data)) {
                $data = array($data);
            }
        }
        $data = $this->_filterDebugData($data);

        if ($this->_logAdditionalData)
        {

            $backtrace = debug_backtrace();
            $loggerClassName = Mage::getConfig()->getModelClassName('aleron75_magelog/logger');
            $className = '';
            while (strcmp($className, $loggerClassName))
            {
                $backtraceData = array_pop($backtrace);
                $className = $backtraceData['class'];
            }
            $additionalData = array(
                '__pid' => getmypid(),
                '__file' => $backtraceData['file'],
                '__line' => $backtraceData['line'],
                '__function' => $backtraceData['function'],
                '__class' => $backtraceData['class'],
            );

            $data = $additionalData + $data;
        }

        $this->_logger->log(
            $data,
            $logLevel,
            $this->_logFileName,
            $forceLog
        );

        return $this;
    }

    public function logException($e)
    {
        $this->_logger->logException($e);
    }

    /**
     * Use to log informativedebug messages.
     * 
     * Debugging messages bring extended information about application processing. 
     * Such messages usually report calls of important functions along with results they return 
     * and values of specific variables or parameters.
     */ 
    public function debug($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::DEBUG, $forceLog);
    }

    /**
     * Use to log informative messages.
     * 
     * Informative messages are usually used for reporting significant application progress and stages.
     * Informative messages should not be reported too frequently because they can quickly become noise.
     */ 
    public function info($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::INFO, $forceLog);
    }

    /**
     * Use to log normal but significant condition.
     */ 
    public function notice($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::NOTICE, $forceLog);
    }

    /**
     * Use to log that application encountered warning conditions.
     * 
     * Such messages are reported when something unusual happened that is not critical to process,
     * but it would be useful to review this situation to decide if it should be resolved.
     */ 
    public function warn($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::WARN, $forceLog);
    }

    /**
     * Use to log that application encountered error conditions.
     * 
     * A problem occurred while processing the current operation. 
     * Such a message usually requires the user to interact with the application or research the problem 
     * in order to find the reason and resolve it.
     */ 
    public function err($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::ERR, $forceLog);
    }

    /**
     * Use to log that application is in critical conditions.
     * 
     * A critical problem occurred while processing the current operation. 
     * The application is in a critical state and cannot proceed with the execution of the current operation. 
     * In this case, the application usually reports such message and terminates.
     * Such a message usually requires the user to interact with the application or research the problem 
     * in order to find the reason and resolve it.
     */ 
    public function crit($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::CRIT, $forceLog);
    }

    /**
     * Use to log that an action must be taken immediately.
     * 
     * A very critical problem occurred while processing the current operation. 
     * Such a message usually requires the user to interact urgently with the application or research the problem 
     * in order to find the reason and resolve it.
     */ 
    public function alert($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::ALERT, $forceLog);
    }

    /**
     * Use to log that system is unusable.
     * 
     * The application is in an unusable state and cannot proceed with the execution of the current operation. 
     * In this case, the application usually reports such message and terminates.
     * Such a message usually requires the user to interact immediately with the application or research the problem 
     * in order to find the reason and resolve it.
     */ 
    public function emerg($data, $forceLog = null)
    {
        return $this->log($data, Zend_Log::EMERG, $forceLog);
    }

    /**
     * @param int|mixed $logLevel
     */
    public function setLogLevel($logLevel)
    {
        $this->_logLevel = $logLevel;
    }

    /**
     * @param string $forceLog
     */
    public function setForceLog($forceLog)
    {
        $this->_forceLog = $forceLog;
    }

    /**
     * @param string $logFileName
     */
    public function setLogFileName($logFileName)
    {
        $this->_logFileName = $logFileName;
    }

    /**
     * @param bool $logAdditionalData
     */
    public function setLogAdditionalData($logAdditionalData)
    {
        $this->_logAdditionalData = $logAdditionalData;
    }

}
