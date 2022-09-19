<?php


namespace App\Validator;

use App\Validator\ValidatorInterface;

class NameValidator implements ValidatorInterface
{

    /**
     * @param $inputValue
     * @return bool
     * @throws \Exception
     */
    public function checkIfValid($inputValue)
    {
        if (preg_match('/[^\x20-\x7f]/', $inputValue))
        {
            return false;
        }
        return true;
    }
}