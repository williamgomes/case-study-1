<?php

namespace App\FileWriter;

/**
 * Interface FileWriterInterface
 * @package App\FileWriter
 */
interface FileWriterInterface
{
    /**
     * @param array $hotelData
     * @return mixed
     */
    public function appendData($hotelData = array());

    /**
     * @param string $filePath
     * @return mixed
     */
    public function saveDataToFile($filePath = "");
}