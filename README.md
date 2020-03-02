Controllers
===
Example controller for model "UserModel":
```php
<?php
namespace app\controllers;

use core\Controller\BaseController;

class Home extends BaseController
{

    function index()
    {
        return ['welcome.tpl', [
            'framework' => 'ca<span id="v">V</span>eman',
            'title' => 'caVeman'
        ]];
    }
}
```
To test controller in url: *www.yourdomain.com\controller\method"* In this case:
*www.yourdomain.com\user\index*
When adding a new controller it has to be registered in *config\routesConfig* 
When returning templates:
```php
return ['templatename.tpl',[your parameters, blank if none]]
```

Example Model:

```php
<?php
namespace app\models;

use core\Model\Model;

class User extends Model {

}
```
Models must inherit the base Model. Including is not needed

find() and getAll() methods:
---
```
$user = User::find(7);//returns a new User model with id 7
$userCollection = User::getAll();//returns all users as objects
```

Config Files
===
In registryConfig, a new service must be registered with namespace and interface its implementing like:

```php
'core\\Config\\Config' => 'core\Config\ConfigInterface',
```

Config Service
===
Config is registered in the Registry. To use:
Example:
```php
Registry::get('Config')->getProperty('database', 'DB_NAME');
```
Response service
===
Response is registered in the Registry. To use:

```php
Registry::get('Response')->setHeaderErrorCode(404, "Error Page not found");
Registry::get('Response')-->setContent(json or template in format "[templatename,parameters]");
Registry::get('Response')->getContent();
```
Router
===
Router breaks down url in :
domain/controller/action/parameters

Controller and action are mandatory in each url. Parameters are optional

View
===
Each template engine must implement ViewInterface and be configured in config/templateEngine.php

Load Components
===
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
Query Builder Examples:
===

Select:
---
```
Registry::get('QueryBuilder')
            ->select('users', ['email'])
            ->orderBy(['email LIMIT 1'])
            ->getQuery();
// SELECT email FROM `users` ORDER BY email LIMIT 1;
```

Update:
---
```
$sql = Registry::get('QueryBuilder')
			->update('users')
            ->set(['name'=>'Georgi'])
            ->where(
                $this->Registry::get('QueryBuilder')->whereAnd("id = 1")
            )
            ->getQuery();
// UPDATE `users` SET name=? where id = 1;
Registry::get('Database')->query($sql,['Georgi'])//here you bind your parameters
```

Insert:
---
```
$sql = Registry::get('QueryBuilder')
			->insert('users')
            ->values(['name'=>'Georgi'])
            ->getQuery();
// INSERT INTO `users` ('name') VALUES ('?');
Registry::get('Database')->query($sql,['Georgi'])//here you bind your parameters
```

Delete:
---
```
$sql = Registry::get('QueryBuilder')
			->delete('users')
            ->->where(
                $this->Registry::get('QueryBuilder')->whereAnd("id = 1")
            )
            ->getQuery();
// DELETE FROM `users` WHERE id = 1;
```

