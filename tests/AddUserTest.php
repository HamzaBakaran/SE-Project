<?php
use PHPUnit\Framework\TestCase;

require_once '../rest/Dao/BaseDao.class.php';

class AddUserTest extends TestCase
{
    private $dao;

    protected function setUp(): void
    {
        $this->dao = new BaseDao('users');
    }

    public function testAddUser()
    {
        $user = [
            'name' => 'John Doe',
            'description' => 'A test user',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'user',
            'created' => date('Y-m-d')
        ];

        $addedUser = $this->dao->add($user);

        // Retrieve the user by ID
        $retrievedUser = $this->dao->get_by_id($addedUser['id']);

        $this->assertEquals($user['name'], $retrievedUser['name']);
        $this->assertEquals($user['description'], $retrievedUser['description']);
        $this->assertEquals($user['email'], $retrievedUser['email']);
        $this->assertEquals($user['password'], $retrievedUser['password']);
        $this->assertEquals($user['role'], $retrievedUser['role']);
        $this->assertEquals($user['created'], $retrievedUser['created']);
        // Add more assertions as needed
    }

}
