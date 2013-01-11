<?php

namespace Lies\tests;

use Lies\Entity\UserEntity;

require_once (dirname(__FILE__) . '/bootstrap.php');

class UserEntityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function canRetrieveAsArray ()
    {
        $userInfo = array(
            'id' => time(),
            'email' => 'junk@thinkof.net',
            'password' => uniqid(),
            'role' => 'admin'
        );

        $user = new UserEntity();
        foreach ($userInfo as $key => $value) {
            call_user_func(array($user, 'set'.ucfirst($key)), $value);
        }


        $this->assertEquals($userInfo, $user->toArray(), 'toArray() failed');
    }

    /**
     * @test
     */
    public function idCanBeSetAndRetrieved()
    {
        $id = time();
        $entity = new UserEntity();
        $entity->setId($id);

        $this->assertEquals($id, $entity->getId(), 'IDs do not match');
    }

    /**
     * @test
     * @expectedException Lies\Exception\UserException
     */
    public function idCanNotBeNull()
    {
        $entity = new UserEntity();
        $entity->setId(null);
    }

    /**
     * @test
     * @expectedException Lies\Exception\UserException
     */
    public function idCanNotBeEmpty()
    {
        $entity = new UserEntity();
        $entity->setId('');
    }

    /**
     * @test
     * @expectedException Lies\Exception\UserException
     */
    public function idMustBeSetAnInteger()
    {
        $id = '1e123d';
        $entity = new UserEntity();
        $entity->setId($id);
    }

    /**
     * @test
     */
    public function emailCanBeSetAndRetrieved()
    {
        $email = 'test@gmail.com';
        $entity = new UserEntity();
        $entity->setEmail($email);

        $this->assertAttributeContains($email, 'email', $entity, 'Attribute email is not set');

        $this->assertEquals($email, $entity->getEmail(), 'Emails do not match');
    }

    /**
     * @test
     * @expectedException Lies\Exception\UserException
     */
    public function emailMustBeValid()
    {
        $email = 'test@.com';
        $entity = new UserEntity();
        $entity->setEmail($email);
    }

    /**
     * @test
     */
    public function passwordCanBeSetAndRetrieved()
    {
        $password = uniqid();
        $entity = new UserEntity();
        $entity->setPassword($password);

        $this->assertAttributeContains($password, 'password', $entity, 'Attribute password is not set');

        $this->assertEquals($password, $entity->getPassword(), 'Passwords do not match');
    }

    /**
     * @test
     */
    public function roleCanBeSetAndRetrieved()
    {
        $role = 'admin';
        $entity = new UserEntity();
        $entity->setRole($role);

        $this->assertAttributeContains($role, 'role', $entity, 'Attribute role is not set');

        $this->assertEquals($role, $entity->getRole(), 'Roles do not match');
    }

    /**
     * @test
     * @expectedException Lies\Exception\UserException
     */
    public function roleMustNotBeNull()
    {
        $role = null;
        $entity = new UserEntity();
        $entity->setRole($role);
    }

    /**
     * @test
     * @expectedException Lies\Exception\UserException
     */
    public function roleMustBeAValue()
    {
        $role = '';
        $entity = new UserEntity();
        $entity->setRole($role);
    }


}