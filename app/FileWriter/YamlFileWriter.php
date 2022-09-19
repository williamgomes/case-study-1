<?php
/**
 * Created by PhpStorm.
 * User: williamgomes
 * Date: 26/02/2017
 * Time: 22:19
 */

namespace App\FileWriter;

use App\FileWriter\FileWriterInterface;
use Symfony\Component\Yaml\Yaml;


class YamlFileWriter implements FileWriterInterface
{
    /**
     * @var Yaml
     */
    protected $_yamlWriter, $_arrData;

    /**
     * YamlFileWriter constructor.
     */
    public function __construct()
    {
        $this->_yamlWriter = new Yaml();
        $this->_arrData = array();
    }

    /**
     * @param array $hotelData
     */
    public function appendData($hotelData = array())
    {
        $singleHotel = array();
        foreach ($hotelData AS $attribute => $value)
        {
            $singleHotel[$attribute] = $value;
        }

        $this->_arrData[] = array(
            'hotel' => $singleHotel
        );
    }

    /**
     * @param string $filePath
     * @throws \Exception
     */
    public function saveDataToFile($filePath = "")
    {
        try
        {
            $hotelsData = array(
                'hotels' => $this->_arrData
            );

            $wholeYamlData = $this->_yamlWriter->dump($hotelsData);

            file_put_contents($filePath, $wholeYamlData);
        }
        catch(\Exception $ex)
        {
            throw new \Exception("XML file save failed. Error: " . $ex->getMessage());
        }
    }
}