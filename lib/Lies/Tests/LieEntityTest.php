<?php

namespace Lies\Tests;

use Lies\Entity\LieEntity;
use Lies\Service\DescriptionValidation;

class LieEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canRetrieveAsArray()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->once())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $expected = array(
            'id' => time(),
            'date' => time(),
            'description' => 'First test lie',
            'user_id' => time(),
            'valid' => 1
        );

        $lie = new LieEntity($validator);
        $lie->setId($expected['id']);
        $lie->setDate($expected['date']);
        $lie->setDescription($expected['description']);
        $lie->setUserId($expected['user_id']);
        $lie->setValid($expected['valid']);


        $this->assertEquals($expected, $lie->toArray(), 'toArray() failed');
    }

    /**
     * @test
     */
    public function idCanBeSetAndRetrieved()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $id = time();
        $entity = new LieEntity($validator);
        $entity->setId($id);

        //$this->assertAttributeContains($id, 'id', $entity, 'Attribute id is not set');

        $this->assertEquals($id, $entity->getId(), 'IDs do not match');
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function idCanNotBeNull()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $entity = new LieEntity($validator);
        $entity->setId(null);
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function idCanNotBeEmpty()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $entity = new LieEntity($validator);
        $entity->setId('');
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function idMustBeSetAnInteger()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $id = '1e123d';
        $entity = new LieEntity($validator);
        $entity->setId($id);
    }

    /**
     * @test
     */
    public function dateCanBeSetAndRetrieved()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $date = time();
        $entity = new LieEntity($validator);
        $entity->setDate($date);

        //$this->assertAttributeContains($date, 'date', $entity, 'Attribute date is not set');

        $this->assertEquals($date, $entity->getDate(), 'Dates do not match');
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function dateCanNotBeNull()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $entity = new LieEntity($validator);
        $entity->setDate(null);
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function dateCanNotBeEmpty()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $entity = new LieEntity($validator);
        $entity->setDate('');
    }

    /**
     * @test
     */
    public function descriptionCanBeSetAndRetrieved()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->once())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $description = 'Description';
        $entity = new LieEntity($validator);
        $entity->setDescription($description);

        //$this->assertAttributeContains($date, 'date', $entity, 'Attribute date is not set');

        $this->assertEquals($description, $entity->getDescription(), 'Descriptions do not match');
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function descriptionCanNotBeNull()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $entity = new LieEntity($validator);
        $entity->setDescription(null);
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function descriptionMustBeAtLeast3CharsLong()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->once())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $description = '123';
        $entity = new LieEntity($validator);
        $entity->setDescription($description);
        $this->assertEquals($description, $entity->getDescription(), 'Descriptions do not match');

        $entity = new LieEntity($validator);
        $entity->setDescription('12');
    }

    /**
     * @test
     */
    public function userIdCanBeSetAndRetrieved()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $userId = time();
        $entity = new LieEntity($validator);
        $entity->setUserId($userId);

        //$this->assertAttributeContains($date, 'date', $entity, 'Attribute date is not set');

        $this->assertEquals($userId, $entity->getUserId(), 'UserIds do not match');
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function userIdMustBeSetAnInteger()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $userId = '1e123d';
        $entity = new LieEntity($validator);
        $entity->setUserId($userId);
    }


}