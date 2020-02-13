<?php

namespace core\Authentication;

use app\models\User;

interface AuthenticationInterface
{
    public function authenticate(User $user);
    public function isAuthenticated();
}
