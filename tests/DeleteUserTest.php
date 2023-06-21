<?php
use PHPUnit\Framework\TestCase;

require_once '../rest/Dao/BaseDao.class.php';

class DeleteUserTest extends TestCase
{
    private $dao;

    protected function setUp(): void
    {
        $this->dao = new BaseDao('users');
    }

    public function testDeleteUser()
    {
        // Add a user to the database for testing
        $user = [
            'name' => 'John Doe',
            'description' => 'Test user',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'role' => 'user',
            'created' => date('Y-m-d'),
        ];
        $addedUser = $this->dao->add($user);

        // Delete the user
        $userId = $addedUser['id'];
        $this->dao->delete($userId);

        // Verify that the user no longer exists in the database
        $deletedUser = $this->dao->getById($userId);
        $this->assertFalse($deletedUser, 'User should be deleted');
    }
}