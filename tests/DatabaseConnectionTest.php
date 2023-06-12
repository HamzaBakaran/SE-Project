<?php


use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../rest/Config.class.php';
require_once '../rest/Dao/BaseDao.class.php';

class DatabaseConnectionTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $schema = Config::DB_SCHEME();
        $baseDao = new BaseDao($schema);
        $connection = $baseDao->getConnection();

        $this->assertInstanceOf(PDO::class, $connection);
    }
}
