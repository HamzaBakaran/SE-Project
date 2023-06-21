<?php

require_once __DIR__ . '/BaseDao.class.php';

class UserDao extends BaseDao
{
    /**
     * Constructor of the DAO class.
     */
    public function __construct()
    {
        parent::__construct("users");
    }

    public function getUserByEmail($email)
    {
        return $this->queryUnique(
            "SELECT * FROM users 
             WHERE email = :email", ['email' => $email]);
    }

    public function getUserCount()
    {
        return $this->querySingle(
            "SELECT COUNT(users.`id`) AS count
             FROM users"
        );
    }
}
