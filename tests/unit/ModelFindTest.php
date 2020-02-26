<?php

use app\models\User;

use function PHPUnit\Framework\assertEquals;

class ModelFindTest extends \Codeception\Test\Unit
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
    public function testBaseModelFind()
    {
        $user = User::find(1);
        assertEquals('test@test.test', $user->email);
    }
}
