<?php

require_once __DIR__ . '/BaseDao.class.php';

class EmployeDao extends BaseDao
{
    /**
     * Constructor of the DAO class.
     */
    public function __construct()
    {
        parent::__construct("employes");
    }

    public function getEmployeById($id)
    {
        return $this->query(
            "SELECT * FROM 
             employes  
             WHERE id = :id", ['id' => $id]);
    }

    public function getEmployeCount()
    {
        return $this->querySingle(
            "SELECT COUNT(id) AS employes
             FROM employes
             WHERE employes.`status`='active'"
        );
    }

    public function delete($id)
    {
        parent::delete($id);
    }
}
