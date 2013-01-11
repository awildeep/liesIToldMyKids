<?php

namespace Lies\tests;

use Lies\Service\DescriptionValidation;

require_once (dirname(__FILE__) . '/bootstrap.php');

class DescriptionValidationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function validatesDescription ()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->once())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));


        $validator = new DescriptionValidation($apiMock);
        $return = $validator->validate('My description');
        $this->assertTrue ($return, 'Expected true value ('.$return.')');
    }
}