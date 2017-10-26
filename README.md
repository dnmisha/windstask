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


