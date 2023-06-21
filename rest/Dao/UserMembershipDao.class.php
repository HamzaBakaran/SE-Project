<?php

require_once __DIR__ . '/BaseDao.class.php';

class UserMembershipDao extends BaseDao
{
    /**
     * Constructor of the DAO class.
     */
    public function __construct()
    {
        parent::__construct("users_membership");
    }

    public function getUsersMembershipById($users_id)
    {
        $query = "SELECT users_membership.`id`, users.`name`, membership.`description`, users_membership.`start_date`, users_membership.`end_date`
            FROM users_membership
            JOIN users ON users.`id` = users_membership.`user_id`
            JOIN membership ON membership.`id` = users_membership.`membership_id`
            WHERE users_membership.`id` = :users_id";
        return $this->query($query, ['users_id' => $users_id]);
    }

    public function getUsersMembership()
    {
        $query = "SELECT users_membership.`id`, users.`name`, membership.`description`, users_membership.`start_date`, users_membership.`end_date`
            FROM users_membership
            JOIN users ON users.`id` = users_membership.`user_id`
            JOIN membership ON membership.`id` = users_membership.`membership_id`";
        return $this->querySingle($query);
    }

    public function getUsersActive()
    {
        $query = "SELECT COUNT(id) as id
            FROM users_membership
            WHERE end_date > CURRENT_DATE";
        return $this->querySingle($query);
    }

    public function getEarned()
    {
        $query = "SELECT SUM(membership.`price`) AS suma
            FROM membership
            JOIN users_membership ON users_membership.`membership_id` = membership.`id`
            WHERE users_membership.start_date >= NOW() - INTERVAL 30 DAY";
        return $this->querySingle($query);
    }

    public function getLastActiveMembership($id)
    {
        return $this->queryUnique(
            "SELECT DATE_FORMAT(end_date, '%d/%m/%Y') AS end_date, user_id, membership.`description`
            FROM users_membership
            JOIN membership ON membership.`id` = users_membership.`membership_id`
            WHERE user_id = :id
            ORDER BY end_date ASC
            LIMIT 1",
            ['id' => $id]
        );
    }

    public function getLastMemberships($id)
    {
        return $this->queryUnique(
            "SELECT users_membership.`id`, membership.`description`, users_membership.`start_date`, users_membership.`end_date`
            FROM users_membership
            JOIN membership ON membership.`id` = users_membership.`membership_id`
            WHERE users_membership.`user_id` = :id
            ORDER BY end_date DESC",
            ['id' => $id]
        );
    }
}
