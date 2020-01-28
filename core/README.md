In loadComponents.php all new services registered in the Registry must be appended in use:

```php
use core\Config\Config,
    core\Registry,
    core\App,
    core\DB\Database,
    core\Request\Request,
    core\DB\QueryBuilder,
    core\Response\Response,
    core\Router\Router,
    core\View\View,
    core\Authentication\Authentication,
    core\Utility\Utility;
```