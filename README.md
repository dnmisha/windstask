 
## Instructions to install

1. Clone repository
```bash
git clone https://github.com/dnmisha/windstask.git
``` 
2. Create empty database
execute sql file in folder /dump

3. Setup db connection in common-local.yaml
```yaml
db:
    password : 'password'
    username : 'username'
    dbname : 'dbname'
```
3. Start your localhost