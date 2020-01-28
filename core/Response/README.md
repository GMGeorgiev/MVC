Response is registered in the Registry. To use:

```php
Registry::get('Response')->setHeaderErrorCode(404, "Error Page not found");
Registry::get('Response')-->setContent(json or template in format "[templatename,parameters]");
Registry::get('Response')->getContent();
```