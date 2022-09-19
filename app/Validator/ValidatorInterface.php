<?php

namespace App\Validator;


interface ValidatorInterface
{
    /**
     * @param $inputValue
     * @return mixed
     */
    public function checkIfValid($inputValue);
}