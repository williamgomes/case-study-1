<?php
namespace App\Tests\Unit;


use PhpParser\Node\Name;
use Symfony\Component\Yaml\Yaml;
use App\Validator\RateValidator;

/**
 * Class NameValidatorTest
 * @package App\Tests\Unit
 */
class RateValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var
     */
    private $_rateValidator;

    public function setUp()
    {
        parent::setUp();
        $this->_rateValidator = new RateValidator();
    }


    public function tearDown()
    {
        parent::tearDown();
        $this->_rateValidator = null;
    }

    public function testWithNumberGreaterThanRange()
    {
        $testRate = 10;
        $result = $this->_rateValidator->checkIfValid($testRate);
        $this->assertEquals(false, $result);
    }


    public function testWithNumberLowerThanRange()
    {
        $testRate = -10;
        $result = $this->_rateValidator->checkIfValid($testRate);
        $this->assertEquals(false, $result);
    }


    public function testWithAnyString()
    {
        $testRate = "test";
        $result = $this->_rateValidator->checkIfValid($testRate);
        $this->assertEquals(false, $result);
    }

    public function testWithinRange()
    {
        $testRate = 4;
        $result = $this->_rateValidator->checkIfValid($testRate);
        $this->assertEquals(true, $result);
    }
}