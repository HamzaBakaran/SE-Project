<?php

require_once __DIR__ . '/BaseService.class.php';
require_once __DIR__ . '/../Dao/UserMembershipDao.class.php';

class UserMembershipService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new UserMembershipDao());
    }

    public function getUsersMembershipById($userId)
    {
        return $this->dao->getUsersMembershipById($userId);
    }

    public function getUsersMembership()
    {
        return $this->dao->getUsersMembership();
    }

    public function getUsersActive()
    {
        return $this->dao->getUsersActive();
    }

    public function getEarned()
    {
        return $this->dao->getEarned();
    }

    public function getLastActiveMembership($id)
    {
        return $this->dao->getLastActiveMembership($id);
    }

    public function getLastMemberships($id)
    {
        return $this->dao->getLastMemberships($id);
    }
}
