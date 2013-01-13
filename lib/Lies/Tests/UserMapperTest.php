<?php

namespace Lies\Tests;

use Lies\Entity\UserEntity;
use Lies\Entity\UserMapper;

class UserMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returnsUserCollection()
    {
        // Create our collection of Lies
        $userInfo = array(
            array(
                'id' => time(),
                'email' => 'junker@thinkof.net',
                'password' => uniqid(),
                'role' => 'admin',
            ),
            array(
                'id' => time(),
                'email' => 'junky@thinkof.net',
                'password' => uniqid(),
                'role' => 'user',
            ),
            array(
                'id' => time(),
                'email' => 'junk@thinkof.net',
                'password' => uniqid(),
                'role' => 'user',
            ),
        );

        // Create collection of Lie objects based on array info
        $expectedUsers = array();
        $expectedUsers[0] = new UserEntity();
        $expectedUsers[1] = new UserEntity();
        $expectedUsers[2] = new UserEntity();

        foreach ($userInfo as $idx => $details) {
            $expectedUsers[$idx]->setId($details['id']);
            $expectedUsers[$idx]->setEmail($details['email']);
            $expectedUsers[$idx]->setPassword($details['password']);
            $expectedUsers[$idx]->setRole($details['role']);
        }

        // Mock our query object
        $sth = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'fetchAll'))
            ->getMock();
        $sth->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue($userInfo));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();
        $db->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($sth));

        // create LieMapper, passing it our mocked DB
        $userMapper = new UserMapper($db);

        // ask it to get all the Lies
        $users = $userMapper->getAll();

        // assert that collections are the same
        $this->assertEquals(
            $expectedUsers,
            $users,
            "UserMapper::getAll() did not return expected collection"
        );
    }


    /**
     * @test
     */
    public function fetchOneUser()
    {
        // Create our raw Lie info
        $userInfo = array(
            'id' => time(),
            'email' => 'junk@thinkof.net',
            'password' => uniqid(),
            'role' => 'admin',
        );

        // Create collection of Lie objects based on array info
        $expectedUser = new UserEntity();
        foreach ($userInfo as $key => $value) {
            call_user_func(array($expectedUser, 'set' . ucfirst($key)), $value);
        }

        // Mock our PDO statement
        $selectStmt = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'fetch'))
            ->getMock();
        $selectStmt->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($userInfo));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();
        $db->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($selectStmt));

        // create LieMapper, passing it our mocked DB
        $userMapper = new UserMapper($db);

        // ask it to get all the Lies
        $user = $userMapper->get($userInfo['id']);

        // assert that collections are the same
        $this->assertEquals(
            $expectedUser,
            $user,
            "UserMapper::get() did not return expected collection"
        );
    }

    /**
     * @test
     */
    public function createNewUser()
    {
        $userInfo = array(
            'id' => time(),
            'email' => 'junk@thinkof.net',
            'password' => uniqid(),
            'role' => 'admin',
        );

        $expectedUser = new UserEntity();
        foreach ($userInfo as $key => $value) {
            call_user_func(array($expectedUser, 'set' . ucfirst($key)), $value);
        }

        //STMT: INSERT
        $userInsertStmt = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute'))
            ->getMock();
        $userInsertStmt->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(true));

        //STMT: SELECT
        $userSelectStmt = $this->getMockBuilder('stdClass')
            ->setMethods(array('execute', 'fetch'))
            ->getMock();
        $userSelectStmt->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($userInfo));

        $db = $this->getMockBuilder('stdClass')
            ->setMethods(array('prepare'))
            ->getMock();

        //Execute: INSERT
        $db->expects($this->at(0))
            ->method('prepare')
            ->will($this->returnValue($userInsertStmt));

        //Execute: SELECT
        $db->expects($this->at(1))
            ->method('prepare')
            ->will($this->returnValue($userSelectStmt));


        // create LieMapper, passing it our mocked DB
        $lieMapper = new UserMapper($db);
        $response = $lieMapper->create($expectedUser);

        $this->assertTrue($response);

        // Verify that we get back the LieEntity we just created
        $responseUser = $lieMapper->get($expectedUser->getId());

        $this->assertEquals(
            $expectedUser,
            $responseUser,
            "Did not get back our expected UserEntity"
        );
    }

    /**
     * @test
     */
    public function deleteKnownCreatedEntity()
    {

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

        $userMapper = new UserMapper($db);
        $response = $userMapper->delete(uniqid());

        $this->assertTrue($response);
    }
}