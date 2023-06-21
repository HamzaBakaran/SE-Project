<?php

use PHPUnit\Framework\TestCase;

require_once '../rest/Dao/EmployeDao.class.php';

class AddEmployeTest extends TestCase
{
    private $dao;

    protected function setUp(): void
    {
        $this->dao = new EmployeDao();
    }

    public function testAddEmploye()
    {
        // Arrange
        $employeData = [
            'name' => 'test2',
            'surname' => 'test2',
            'email' => 'test2@gmail.com',
            'status' => 'active',
            'position' => 'coach'
        ];

        // Act
        $addedEmploye = $this->dao->add($employeData);
        $addedEmployeId = (int) $addedEmploye['id'];

        // Assert
        $this->assertIsInt($addedEmployeId);
        $this->assertGreaterThan(0, $addedEmployeId);

        

        // Clean up 
        $this->dao->delete($addedEmployeId);
    }
}
