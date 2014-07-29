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

    public function log($data = null)
    {
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
            $this->_logLevel,
            $this->_logFileName,
            $this->_forceLog
        );

        return $this;
    }

    public function logException($e)
    {
        $this->_logger->logException($e);
    }


}