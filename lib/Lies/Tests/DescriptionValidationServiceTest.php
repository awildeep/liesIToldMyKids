<?php

namespace Lies\Tests;

use Lies\Service\DescriptionValidation;
use Lies\Exception\DescriptionValidationException;

class DescriptionValidationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function validatesDescription()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->once())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));


        $validator = new DescriptionValidation($apiMock);
        $return = $validator->validate('My description');
        $this->assertTrue($return, 'Expected true value (' . $return . ')');
    }

    /**
     * @test
     * @expectedException Lies\Exception\DescriptionValidationException
     */
    public function invalidatesDescription()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->once())
            ->method('postProfanityFilter')
            ->will($this->throwException(new DescriptionValidationException('Failed to pass profanity filter')));


        $validator = new DescriptionValidation($apiMock);
        $return = $validator->validate('My description contains a naughty word.');
        $this->assertTrue($return, 'Expected true value (' . $return . ')');
    }


}