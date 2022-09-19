<?php

namespace App\FileWriter;

use App\FileWriter\FileWriterInterface;

class XmlFileWriter implements FileWriterInterface
{
    /**
     * @var \DOMDocument
     */
    protected $_domTree, $_xmlRoot;

    /**
     * XmlFileWriter constructor.
     */
    public function __construct()
    {
        $this->_domTree = new \DOMDocument('1.0', 'UTF-8');
        /* create the root element of the xml tree */
        $this->_xmlRoot = $this->_domTree->createElement("hotels");
        /* append it to the document created */
        $this->_xmlRoot = $this->_domTree->appendChild($this->_xmlRoot);
    }

    /**
     * @param array $hotelData
     */
    public function appendData($hotelData = array())
    {
        $hotel = $this->_domTree->createElement("hotel");
        $hotel = $this->_xmlRoot->appendChild($hotel);
        foreach ($hotelData AS $attribute => $value)
        {
            $hotel->appendChild($this->_domTree->createElement($attribute, $value));
        }
    }

    /**
     * @param string $filePath
     * @throws \Exception
     */
    public function saveDataToFile($filePath = "")
    {
        try
        {
            $this->_domTree->save($filePath);
        }
        catch(\Exception $ex)
        {
            throw new \Exception("XML file save failed. Error: " . $ex->getMessage());
        }
    }
}