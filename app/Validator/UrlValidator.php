<?php

namespace App\Validator;

use App\Validator\ValidatorInterface;

/**
 * Class UrlValidator
 * @package App\Validator
 */
class UrlValidator implements ValidatorInterface
{

    /**
     * @param $inputValue
     * @return mixed
     */
    public function checkIfValid($inputValue)
    {
        //pattern for validating an url
        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor

        if (filter_var($inputValue, FILTER_VALIDATE_URL)) {
            if (preg_match("/^$regex$/i", $inputValue)) {
                return true;
            }
        }

        return false;
    }
}