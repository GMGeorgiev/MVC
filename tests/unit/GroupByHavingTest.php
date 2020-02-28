<?php

use core\Registry;

class GroupByHavingTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testGroupByHaving()
    {
        $sql = Registry::get('QueryBuilder')
            ->select('users', ['COUNT(email)'])
            ->groupBy(['password'])
            ->having("password = 'asdasd'")
            ->getQuery();
        $result = Registry::get('Database')->query($sql);
        $this->assertEquals('2', reset($result)['emails']);
    }
    public function testGroupByHavingNegative()
    {
        $sql = Registry::get('QueryBuilder')
            ->select('users', ['COUNT(email)'])
            ->groupBy(['password'])
            ->having("password = 'negative'")
            ->getQuery();
        $result = Registry::get('Database')->query($sql);
        $this->assertEmpty($result);
    }

    public function testOrderBy()
    {
        $sql = Registry::get('QueryBuilder')
            ->select('users', ['email'])
            ->orderBy(['email LIMIT 1'])
            ->getQuery();
        $result = Registry::get('Database')->query($sql);
        $this->assertEquals('asd@asd.asd', reset($result)['email']);
    }

    public function testOrderByNegative()
    {
        $sql = Registry::get('QueryBuilder')
            ->select('users', ['email'])
            ->orderBy(['email DESC LIMIT 1'])
            ->getQuery();
        $result = Registry::get('Database')->query($sql);
        $this->assertNotEquals('asd@asd.asd', reset($result)['email']);
    }
}
