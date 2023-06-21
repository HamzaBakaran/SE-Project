<?php

require_once __DIR__ . '/BaseService.class.php';
require_once __DIR__ . '/../Dao/MembershipDao.class.php';

class MembershipService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new MembershipDao());
    }

    public function getMembershipByUserId($userId)
    {
        return $this->dao->getMembershipByUserId($userId);
    }

    public function delete($id)
    {
        return $this->dao->delete($id);
    }
}
