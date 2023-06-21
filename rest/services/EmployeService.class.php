<?php

require_once __DIR__ . '/BaseService.class.php';
require_once __DIR__ . '/../Dao/EmployeDao.class.php';

class EmployeService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new EmployeDao());
    }

    public function getEmployeById($id)
    {
        return $this->dao->getEmployeById($id);
    }

    public function getEmployeCount()
    {
        return $this->dao->getEmployeCount();
    }

    public function delete($id)
    {
        return $this->dao->delete($id);
    }
}
