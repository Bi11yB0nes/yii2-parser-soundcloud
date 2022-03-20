# yii2 soundCloud.com spider

## Installing

### 1. PHP
* Require php >7.4
### 2. MySQL
* Require MySQL 5.7
### 3. Prepare project for work
* Install [composer](https://getcomposer.org/download/)
* Go to project path
* Run:
```bash
php init
composer install
```
set login and password for connection to database in the config file:
```bash
common/config/main.php
```

* Create the database in one of two ways:
#### with migrations

* Create database for server with SQL request:
```sql
CREATE DATABASE soundcloud_parser;
```
and run:
```bash
php yii migrate
```

#### or using SQL request fom Db.sql

### 4. How run test 
* Run:
```bash
    php yii example/test
```
