<?php
namespace App\Tests\Unit;


use PhpParser\Node\Name;
use Symfony\Component\Yaml\Yaml;
use App\Validator\UrlValidator;

/**
 * Class BonusDateProcessorTest
 * @package Willy\Tests\Unit
 */
class UrlValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var
     */
    private $_urlValidator;

    public function setUp()
    {
        parent::setUp();
        $this->_urlValidator = new UrlValidator();
    }


    public function tearDown()
    {
        parent::tearDown();
        $this->_urlValidator = null;
    }

    public function testUrlWithoutProperProtocol()
    {
        $testUrl = "ht://www.google.com/test/url";
        $result = $this->_urlValidator->checkIfValid($testUrl);
        $this->assertEquals(false, $result);
    }

    public function testUrlWithDoubleProtocol()
    {
        $testUrl = "http://www.google.com/http://msn.com/";
        $result = $this->_urlValidator->checkIfValid($testUrl);
        $this->assertEquals(false, $result);
    }

    public function testUrlWithSpecialCharacter()
    {
        $testUrl = "http://✪df.ws/123";
        $result = $this->_urlValidator->checkIfValid($testUrl);
        $this->assertEquals(false, $result);
    }
    
    public function testUrlWithSubdomain()
    {
        $testUrl = "http://www.williamgomes.com/";
        $result = $this->_urlValidator->checkIfValid($testUrl);
        $this->assertEquals(true, $result);
    }
}