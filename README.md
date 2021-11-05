# Fashionette README
Welcome to Fashionette.


## Components
[Xampp (PHP 8.0.10)](https://www.apachefriends.org/download.html)

---
## Utilities
[Global Composer](https://getcomposer.org/doc/00-intro.md)

---
## Running

Download project from git and then use commandline 
```composer
$ composer install
```
* create **.env** file and copy from **.env.example**
```key
$ php artisan key:generate
```
```run
$ php artisan serve –port=8081
```
In last step you can use any port number 


Run API from this [URL](http://127.0.0.1:8081/?q=girls) in local machine.
**http://127.0.0.1:8081/?q=girls**


***
## Future Development Scope
* Store a data in cache-database like Redis.
* Instead of deleting cache-data after 7 days update it during low user traffic time e.g. night time using scheduler.
* Manage API Rate Limits in Queued Jobs.
