<?php
/**
 * Created by PhpStorm.
 * User: williamgomes
 * Date: 26/02/2017
 * Time: 14:10
 */

namespace App\FileReader;

/**
 * Class AbstractFileReader
 * @package App\FileReader
 */
abstract class AbstractFileReader
{
    /**
     * @param $filePath
     * @return mixed
     */
    abstract public function getFileContent($filePath);

    /**
     * @param $filePath
     * @return bool
     */
    public function isValidFile($filePath)
    {
        return is_file($filePath);
    }

    /**
     * @param $filePath
     * @return bool
     */
    public function isFileReadable($filePath)
    {
        return is_readable($filePath);
    }
}