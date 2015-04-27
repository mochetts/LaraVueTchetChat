## LaravelRatchet Chat

"Laravel is a web application framework with expressive, elegant syntax... Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching."

"Ratchet is a loosely coupled PHP library providing developers with tools to create real time, bi-directional applications between clients and servers over WebSockets. This is not your Grandfather's Internet."

## Official Documentation

Documentation for Laravel 5 can be found on the [Laravel website](http://laravel.com/docs).

Documentation for ratchet can be found on the [Ratchet website](http://socketo.me/docs/).

## Description

The idea is to integrate Ratchet web sockets with a Laravel 5 simple application and implement a chat that uses web sockets.

This repo also showcases how to do the whole cicle for social authentication with laravel 5 (which is kind of a neat feature). I only used facebook login as example, but it's quite easy to add new authentication methods.

## Setup guide
	
1) Clone repo
2) Standing on repo folder, run "composer install" from a terminal (note that composer is needed got to [Composer Website](https://getcomposer.org/) to get more info on how to install it)
3) Standing on repo folder, run "composer update" from a terminal
4) If you want to test facebook login with your own app, go to config/services.php and change the facebook credentials and use your own.
5) On a terminal run command "php artisan chat:serve" to start the chat server (on port 8080)
6) You'r done!

## Contributing

Thank you for considering contributing to this repository! Any contribution is welcomed always having the "spread the knowledge" in mind. 

Eveloution comes after sharing knowledge.

### License

The code under this repository is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
