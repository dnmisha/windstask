# mvc-skeleton

Simple MVC sceleton

## Instructions to install

Clone repository
```bash
git clone https://github.com/dnmisha/mvc-skeleton.git 
``` 
## Route example routes.yaml

```yaml
routes:
      '/':
            controller: main:index
      '/demo':
            controller: main:demo
      '/login':
            controller: user:login
      '/path1/path2/:int:':
                        controller: name_controller:name_action
                        params:
                                id: 3 #index of your dynamic param
```

## Processing request 
component MvcKernel::$app->request

### check if request is post

```php
MvcKernel::$app->request->isPost()
```

### redirect user to url

```php
 MvcKernel::$app->request->redirect('/path');
```
### to get post/get variable
if args sre empty return all post data
```php
MvcKernel::$app->request->post()
```
if method receive variableName or/and defaultValue will return some variable with/or default value if it does't exist

The same solution for GET
```php
MvcKernel::$app->request->get()
```