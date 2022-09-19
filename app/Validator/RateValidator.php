<?php
/**
 * Created by PhpStorm.
 * User: williamgomes
 * Date: 26/02/2017
 * Time: 15:39
 */

namespace App\Validator;


use App\Validator\ValidatorInterface;

class RateValidator implements ValidatorInterface
{

    /**
     * @param $inputValue
     * @return mixed
     */
    public function checkIfValid($inputValue)
    {
        if (is_numeric($inputValue))
        {
            $inputValue = (int) $inputValue;

            if ($inputValue >= 0 AND $inputValue <= 5)
            {
                return true;
            }
        }
        return false;
    }
}