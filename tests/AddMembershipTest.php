<?php

use PHPUnit\Framework\TestCase;

require_once '../rest/Dao/MembershipDao.class.php';

class AddMembershipTest extends TestCase
{
    private $dao;

    protected function setUp(): void
    {
        $this->dao = new MembershipDao();
    }

    public function testAddMembership()
    {
        $membership = [
            'description' => 'Access to basic features',
            'price' => 9.99
        ];

        $addedMembership = $this->dao->add($membership);

        // Retrieve the membership by ID
        $retrievedMembership = $this->dao->getById($addedMembership['id']);

        $this->assertEquals($membership['name'], $retrievedMembership['name']);
        $this->assertEquals($membership['price'], $retrievedMembership['price']);
        
    }
}
