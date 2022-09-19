<?php

namespace App\Validator;

use Psr\Log\LoggerInterface;

class HotelDataValidator
{

    protected $_dynamicClass, $_loggerInterface;

    /**
     * HotelDataValidator constructor.
     * @param array $config
     * @param LoggerInterface $logger
     */
    public function __construct($config = array(), LoggerInterface $logger)
    {
        foreach($config['settings']['fields_csv_array'] AS $fieldName)
        {

            if (isset($config['settings']['validator'][$fieldName]['class'])) {
                $config['settings']['validator'][$fieldName]['class'];
                $className = $config['settings']['validator'][$fieldName]['class'];
                $interfaces = class_implements($className);
                if (isset($interfaces['App\Validator\ValidatorInterface'])) {
                    $this->_dynamicClass[$fieldName] = new $className();
                }
            }
        }

        $this->_loggerInterface = $logger;
    }

    /**
     * @param array $hotelData
     * @return bool
     */
    public function validateHotelData($hotelData = array())
    {
        $validCheck = 0;

        foreach ($hotelData AS $attribute => $value) {
            if (isset($this->_dynamicClass[$attribute])) {
                if(!$this->_dynamicClass[$attribute]->checkIfValid($value))
                {
                    $this->logWarning(
                        sprintf(
                            '%s is not a/an valid %s, skipping the hotel information',
                            $value, $attribute
                        )
                    );
                    $validCheck++;
                }
            }
        }

        if($validCheck == 0)
        {
            return true;
        }
        return false;
    }

    /**
     * @param $message
     * @return $this
     */
    public function logWarning($message)
    {
        $this->getLogger()->addWarning($message);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->_loggerInterface;
    }
}