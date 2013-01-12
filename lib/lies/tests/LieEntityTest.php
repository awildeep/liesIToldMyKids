<?php

namespace Lies\Tests;

use Lies\Entity\LieEntity;

class LieEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canRetrieveAsArray()
    {
        $expected = array(
            'id' => time(),
            'date' => time(),
            'description' => 'First test lie',
            'user_id' => time(),
            'valid' => 1
        );

        $lie = new LieEntity();
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
        $id = time();
        $entity = new LieEntity();
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
        $entity = new LieEntity();
        $entity->setId(null);
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function idCanNotBeEmpty()
    {
        $entity = new LieEntity();
        $entity->setId('');
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function idMustBeSetAnInteger()
    {
        $id = '1e123d';
        $entity = new LieEntity();
        $entity->setId($id);
    }

    /**
     * @test
     */
    public function dateCanBeSetAndRetrieved()
    {
        $date = time();
        $entity = new LieEntity();
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
        $entity = new LieEntity();
        $entity->setDate(null);
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function dateCanNotBeEmpty()
    {
        $entity = new LieEntity();
        $entity->setDate('');
    }

    /**
     * @test
     */
    public function descriptionCanBeSetAndRetrieved()
    {
        $description = 'Description';
        $entity = new LieEntity();
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
        $entity = new LieEntity();
        $entity->setDescription(null);
    }

    /**
     * @test
     * @expectedException Lies\Exception\LieException
     */
    public function descriptionMustBeAtLeast3CharsLong()
    {
        $description = '123';
        $entity = new LieEntity();
        $entity->setDescription($description);
        $this->assertEquals($description, $entity->getDescription(), 'Descriptions do not match');

        $entity = new LieEntity();
        $entity->setDescription('12');
    }

    /**
     * @test
     */
    public function userIdCanBeSetAndRetrieved()
    {
        $userId = time();
        $entity = new LieEntity();
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
        $userId = '1e123d';
        $entity = new LieEntity();
        $entity->setUserId($userId);
    }


}