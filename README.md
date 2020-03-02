Controllers
===
Example controller for model "UserModel":
```php
<?php
namespace app\controllers;

use app\models\User;

class Home {
    function index(){
        $user = new User([]);
        return ['',[]];
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

Hashing
===
This framework uses **bcrypt** hashing with default options. To use custom options you must specify them in an associative array
 when using Utility with ::hash :

```
Utility::hash($password, $options = []);
//Default options:
//private $cost = 10;
//private $memory = 1024;
//private $time = 2;
//private $threads = 2;

Example with options:
Utility::hash('randomPassword',[
    'cost'=>12,
    'memory'=>2048,
    'time'=>4,
    'threads'=>4
]);
```