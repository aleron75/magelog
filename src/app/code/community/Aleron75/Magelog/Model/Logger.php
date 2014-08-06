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
        $data['__pid'] = getmypid();

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

}