### Task manager. Example on HEROKU:
http://novapc74task-manager.herokuapp.com/
***


### Installation:
Run the following commands on the command line:
```
git clone git@github.com:novapc74/php-project-lvl4.git
make setup
php artisan db:seed --class=UserSeeder
make start
```

### POSTGRES:
```
sudo apt-get install php-pgsql
psql {{ db_name }}
ALTER USER {{ user_name }} with encrypted password 'password';
sudo systemctl restart postgresql.service
```
```
.env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE={{ db_name }}
DB_USERNAME={{ user_name }}
DB_PASSWORD=password
```
***
#### SQLITE:
```
sudo apt-cache search sqlite
sudo apt install sqlite3
```
***
### Hexlet tests and linter status:
[![Actions Status](https://github.com/novapc74/php-project-lvl4/workflows/hexlet-check/badge.svg)](https://github.com/novapc74/php-project-lvl4/actions)
***
### Analizer CI and linter status:
[![taskManager-CI](https://github.com/novapc74/php-project-lvl4/actions/workflows/analizer-ci.yml/badge.svg)](https://github.com/novapc74/php-project-lvl4/actions/workflows/analizer-ci.yml)
