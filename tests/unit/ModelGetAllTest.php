<?php

use app\models\User;

class ModelGetAllTest extends \Codeception\Test\Unit
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
    public function testBaseModelGetAll()
    {
        $user = new User([]);
        $users = $user->getAll();
        $this->assertInstanceOf(User::class, reset($users));
    }
}
