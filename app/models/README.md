Example Model:

```php
<?php

namespace app\models;
use core\Model\Model;

class UserModel extends Model
{
    function hi()
    {
        echo 'Hi';
    }
}
```
Models must inherit the base Model. Including is not needed