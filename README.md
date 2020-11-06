<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About User service granting system

Purpose of SGS is to manage user for REST Apis to manage session by using passport:

Steps to install

- clone project from git or download
- composer install
- copy .env-example file into .env
- create database user-sgs and write DB username and password in env
- go to project directory and run php artisan migrate
- run php artisan passport:install

Create Virtual host 

<VirtualHost *:80>
    ServerName user-sgs
    ServerAlias user-sgs
    DocumentRoot "/var/www/html/htdocs/user-sgs/public"
    Options Indexes FollowSymLinks
    <Directory "/var/www/html/htdocs/user-sgs/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<pre>
create user 
url : http://user-sgs/api/register
method : POST
request : {
              "name": "jagmohan",
              "username": "jagmohan",
              "email": "jagmohan@gmail.com",
              "password": "Skil@123",
              "password_confirmation": "Skil@123"
          }

Get Token : 
url : http://user-sgs/api/oauth/token
method : POST
request : {
              "username": "jagmohan",
              "password": "Skil@123"
          }
          
Login user 
url : http://user-sgs/api/login_data
method: GET
request Authorization : bearer <token got in previous api>


Binary Search api:
url : http://user-sgs/api/binary-search
method : GET
request: {
             "array": [
                 1,
                 5,
                 7,
                 8,
                 9
             ],
             "search": 8
         }
         

