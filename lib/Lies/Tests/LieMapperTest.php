<?php

namespace Lies\Tests;

use Lies\Entity\LieEntity;
use Lies\Entity\LieMapper;
use Lies\Service\DescriptionValidation;

class LieMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returnsLieCollection()
    {

        /**
         * Create a mocked DB object
         * Create a result set that represents multiple rows
         * Create data value objects
         * Mock any functionality that is required to grab those rows
         * inject mocked DB object into real LieMapper
         * execute getAll()
         * compare results to expected results
         */

        // Create our collection of Lies
        $lieInfo = array(
            array(
                'id' => time(),
                'date' => time(),
                'description' => 'First test lie',
                'user_id' => time(),
                'valid' => 1
            ),
            array(
                'id' => time(),
                'date' => time(),
                'description' => 'Second test lie',
                'user_id' => time(),
                'valid' => 1
            ),
            array(
                'id' => time(),
                'date' => time(),
                'description' => 'Third test lie',
                'user_id' => time(),
                'valid' => 0
            ),
        );

        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->any())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));


        $validator = new DescriptionValidation($apiMock);

        // Create collection of Lie objects based on array info
        $expectedLies = array();
        $expectedLies[0] = new LieEntity($validator);
        $expectedLies[1] = new LieEntity($validator);
        $expectedLies[2] = new LieEntity($validator);

        foreach ($lieInfo as $idx => $details) {
            $expectedLies[$idx]->setId($details['id']);
            $expectedLies[$idx]->setDate($details['date']);
            $expectedLies[$idx]->setDescription($details['description']);
            $expectedLies[$idx]->setUserId($details['user_id']);
            $expectedLies[$idx]->setValid($details['valid']);
        }

        // Mock our query object
        $sth = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'fetchAll'))
            ->getMock();
        $sth->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue($lieInfo));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();
        $db->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($sth));

        // create LieMapper, passing it our mocked DB
        $lieMapper = new LieMapper($db, $validator);

        // ask it to get all the Lies
        $lies = $lieMapper->getAll();

        // assert that collections are the same
        $this->assertEquals(
            $expectedLies,
            $lies,
            "LieMapper::getAll() did not return expected collection"
        );
    }

    /**
     * @test
     */
    public function getOneRecord()
    {

        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->any())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        // Create our raw Lie info 
        $lieInfo = array(
            'id' => time(),
            'date' => time(),
            'description' => 'First test lie',
            'user_id' => time(),
            'valid' => 1
        );

        // Create collection of Lie objects based on array info
        $expectedLie = new LieEntity($validator);

        $expectedLie->setId($lieInfo['id']);
        $expectedLie->setDate($lieInfo['date']);
        $expectedLie->setDescription($lieInfo['description']);
        $expectedLie->setUserId($lieInfo['user_id']);
        $expectedLie->setValid($lieInfo['valid']);

        // Mock our PDO statement
        $sth = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'fetch'))
            ->getMock();
        $sth->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($lieInfo));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();
        $db->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($sth));

        // create LieMapper, passing it our mocked DB
        $lieMapper = new LieMapper($db, $validator);

        // ask it to get all the Lies
        $lie = $lieMapper->get($lieInfo['id']);

        // assert that collections are the same
        $this->assertEquals(
            $expectedLie,
            $lie,
            "LieMapper::getAll() did not return expected collection"
        );
    }

    /**
     * @test
     */
    public function getValidLies()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->any())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        $lieInfo = array(
            array(
                'id' => time(),
                'date' => time(),
                'description' => 'First test lie',
                'user_id' => time(),
                'valid' => 1
            ),
            array(
                'id' => time(),
                'date' => time(),
                'description' => 'Second test lie',
                'user_id' => time(),
                'valid' => 1
            ),
        );

        // Create collection of Lie objects based on array info
        $expectedLies = array();
        $expectedLies[0] = new LieEntity($validator);
        $expectedLies[1] = new LieEntity($validator);

        foreach ($lieInfo as $idx => $details) {
            $expectedLies[$idx]->setId($details['id']);
            $expectedLies[$idx]->setDate($details['date']);
            $expectedLies[$idx]->setDescription($details['description']);
            $expectedLies[$idx]->setUserId($details['user_id']);
            $expectedLies[$idx]->setValid($details['valid']);
        }

        // Mock our query object
        $sth = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'fetchAll'))
            ->getMock();
        $sth->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue($lieInfo));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();
        $db->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($sth));

        // create LieMapper, passing it our mocked DB
        $lieMapper = new LieMapper($db, $validator);

        // ask it to get all the Lies
        $lies = $lieMapper->getAllValid();

        // assert that collections are the same
        $this->assertEquals(
            $expectedLies,
            $lies,
            "LieMapper::getAll() did not return expected collection"
        );
    }

    /**
     * @test
     */
    public function createNewLie()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->any())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        /**
         * Create a new LieEntity in a known state
         * Create a new LieMapper
         * Pass in a mocked DB object
         * Pass the LieEntity to a create() method
         * Verify via get() that our LieEntity matches
         */
        $lieInfo = array(
            'id' => time(),
            'date' => time(),
            'description' => 'First test lie',
            'user_id' => time(),
            'valid' => 1
        );

        // Create collection of Lie objects based on array info
        $expectedLie = new LieEntity($validator);

        $expectedLie->setId($lieInfo['id']);
        $expectedLie->setDate($lieInfo['date']);
        $expectedLie->setDescription($lieInfo['description']);
        $expectedLie->setUserId($lieInfo['user_id']);
        $expectedLie->setValid($lieInfo['valid']);

        // Mock our PDO statement
        $sth = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'fetch'))
            ->getMock();
        $sth->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($lieInfo));

        $sth2 = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute'))
            ->getMock();
        $sth2->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(true));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();
        $db->expects($this->at(0))
            ->method('prepare')
            ->will($this->returnValue($sth2));

        $db->expects($this->at(1))
            ->method('prepare')
            ->will($this->returnValue($sth));

        // create LieMapper, passing it our mocked DB
        $lieMapper = new LieMapper($db, $validator);
        $response = $lieMapper->create($expectedLie);

        $this->assertTrue($response);

        // Verify that we get back the LieEntity we just created
        $responseLie = $lieMapper->get($expectedLie->getId());

        $this->assertEquals(
            $expectedLie,
            $responseLie,
            "Did not get back our expected LieEntity"
        );
    }

    /**
     * @test
     */
    public function deleteKnownCreatedEntity()
    {
        $apiMock = $this->getMockBuilder('stdClass')
            ->setMethods(array('postProfanityFilter'))
            ->getMock();
        $apiMock->expects($this->never())
            ->method('postProfanityFilter')
            ->will($this->returnValue(true));

        $validator = new DescriptionValidation($apiMock);

        /**
         * Given a known Entity ID
         * Tell me if it was actually deleted
         */

        $sth = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'rowCount'))
            ->getMock();
        $sth->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(true));
        $sth->expects($this->once())
            ->method('rowCount')
            ->will($this->returnValue(1));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();
        $db->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($sth));

        $lieMapper = new LieMapper($db, $validator);
        $response = $lieMapper->delete(uniqid());

        $this->assertTrue($response);
    }
}
