## LaravelRatchet Chat

"Laravel is a web application framework with expressive, elegant syntax... Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching."

"Ratchet is a loosely coupled PHP library providing developers with tools to create real time, bi-directional applications between clients and servers over WebSockets. This is not your Grandfather's Internet."

## Official Documentation

Documentation for Laravel 5 can be found on the [Laravel website](http://laravel.com/docs).

Documentation for ratchet can be found on the [Ratchet website](http://socketo.me/docs/).

## Description

The idea is to integrate Ratchet web sockets with a Laravel 5 simple application and implement a chat that uses web sockets.

This repo also showcases how to do the whole cicle for social authentication with laravel 5 (which is kind of a neat feature). I only used facebook login as example, but it's quite easy to add new authentication methods.

## Requirements

1) [Composer](https://getcomposer.org/)

2) Database server (I use mysql)

## Setup guide
	
1) Clone repo

2) Standing on repo folder, run "composer install" from a terminal.

3) Standing on repo folder, run "composer update" from a terminal

4) If you want to test facebook login with your own app, go to config/services.php and change the facebook credentials and use your own.

5) Add a virtual host with ServerName "chat.dev" (or use whatever server name you like). This steps has more steps within, so please search on google how to add a virtual host.

6) On a terminal console navigate to project root run command "chmod -R 777 storage" 

7) Rename .env.example file (located at root structure) to be .env only and update your database credentials. (Note that a database server is needed to run this app)

8) On a terminal console navigate to project root run command "php artisan migrate:install"

9) On a terminal console navigate to project root run command "php artisan migrate"

10) On a terminal console navigate to project root run command "php artisan chat:serve" to start the chat server (localhost on port 8080)

11) Whohaa! You'r done! Open browser and enter url http://chat.dev, login and start chatting!

## Contributing

Thank you for considering contributing to this repository! Any contribution is welcomed always having the "spread the knowledge" in mind. 

Eveloution comes after sharing knowledge.

### License

The code under this repository is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
