Controllers
===
Example controller for model "UserModel":
```php
<?php

use app\models\UserModel;

class User{
    public $model;
    public function __construct()
    {
        $this->model = new UserModel([]);
    }
    function index(){
        $this->model->hi();
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