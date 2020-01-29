<?php

namespace core\DB;

interface DatabaseInterface
{
    public function getConnection();
    public function query($sql, $params = []);
}
