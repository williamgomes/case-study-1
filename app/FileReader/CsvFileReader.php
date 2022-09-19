<?php


namespace App\FileReader;

use Keboola\Csv\CsvFile;
use App\FileReader\AbstractFileReader;


/**
 * Class CsvFileReader
 * @package App\FileReader
 */
class CsvFileReader extends AbstractFileReader
{


    public function getFileContent($filePath = "", $config = array())
    {
        $errorChk = 0;
        $csvFileContent = array();
        
        if(!$this->isValidFile($filePath))
        {
            $errorChk++;
            throw new \Exception("Parameter 1 supplied for ". __FUNCTION__ ." is not a valid file. Value: " . $filePath);
        }


        if(!$this->isFileReadable($filePath))
        {
            $errorChk++;
            throw new \Exception("Parameter 1 supplied for ". __FUNCTION__ ." is not a readable file. Value: " . $filePath);
        }


        if($errorChk == 0)
        {
            $csvFileContent = new CsvFile($filePath);
            $csvFileContent = $this->csvDataFormatter($csvFileContent, $config);
        }

        return $csvFileContent;
    }

    /**
     * @param array $csvData
     * @param array $config
     * @return array
     */
    public function csvDataFormatter($csvData = array(), $config = array())
    {
        $result = array();
        //getting csv file headers from config
        $arrFieldName = $config['settings']['fields_csv_array'];
        $countFieldName = count($arrFieldName);
        $startPoint = $config['settings']['start_point_index'];

        //reorganising whole array by putting field name as index
        foreach($csvData AS $key => $value)
        {
            if($key >= $startPoint)
            {
                for($i = 0; $i < $countFieldName; $i++)
                {
                    $result[$key][$arrFieldName[$i]] = $value[$i];
                }
            }
        }
        return $result;
    }
}