<?php
namespace App\Tests\Unit;


use PhpParser\Node\Name;
use Symfony\Component\Yaml\Yaml;
use App\Validator\NameValidator;

/**
 * Class NameValidatorTest
 * @package App\Tests\Unit
 */
class NameValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var
     */
    private $_nameValidator;

    public function setUp()
    {
        parent::setUp();
        $this->_nameValidator = new NameValidator();
    }


    public function tearDown()
    {
        parent::tearDown();
        $this->_nameValidator = null;
    }

    public function testNameWithAsciiCharacter()
    {
        $nameWithAscii = "Apartment Dörr";
        $result = $this->_nameValidator->checkIfValid($nameWithAscii);
        $this->assertEquals(false, $result);
    }


    public function testNameWithoutAsciiCharacter()
    {
        $nameWithAscii = "The Zimmer";
        $result = $this->_nameValidator->checkIfValid($nameWithAscii);
        $this->assertEquals(true, $result);
    }

}