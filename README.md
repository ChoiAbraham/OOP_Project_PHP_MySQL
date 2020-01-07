# OOP_Project_PHP_MySQL

This project is to create a secured Blog in Object-Oriented Programming with PHP/MySQL/Composer/Twig/Ajax. It includes the developper blog home page, an user/admin login interface, posts/commments pages, profil pages.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- Git (https://git-scm.com/downloads). It will provide GitBash.

- MySQL/PhpMyAdmin. Depending on your OS:
    - On Windows : Wamp (http://www.wampserver.com/)
    - On Mac OS X : MAMP (https://www.mamp.info/en/downloads/)
    - On Linux : XAMPP (https://www.apachefriends.org/fr/index.html)

For more Information : (https://openclassrooms.com/fr/courses/918836-concevez-votre-site-web-avec-php-et-mysql/4237816-preparez-votre-environnement-de-travail
)

- Composer (https://getcomposer.org/).


### Installing

STEP 1 : Clone the project into the folder www of wamp64.

1. Go to https://github.com/ChoiAbraham/OOP_Project_PHP_MySQL. On the green button, Click "clone or download". Copy the link.
2. Open Git Bash.
3. Move to the directory www.
```
cd path_to_your_local_repo/OOP_Project_PHP_MySQL
```

4. Clone the project : type the git command git clone and insert the link:
```
git clone link
```
STEP 2 : Install the dependencies on Composer

1. Open the terminal Git Bash
2. Move to the project directory OOP_Project_PHP_MySQL
3. run composer update, it will install the dependencies (twig, PHPMailer).

STEP 3 : Set the Database

1. Import the projet5.sql in phpMyAdmin
2. set the connexion to the database in src/Application/database.php. (those could be change according to your database settings).
```
    'host' => '127.0.0.1',
    'db' => 'projet5',
    'username' => 'root',
    'password' => 'YOUR PASSWORD'
```

STEP 4 : set PHPMailer

1. Create a google account/gmail. This project not being yet deployed, the smtp of gmail will be used.
2. set your PHPMailer parameters in src/Application/mail.php :

```
    'username' => 'your gmail address',
    'password' => 'the password you chose for your gmail account'
```
3. Go on https://myaccount.google.com/u/0/lesssecureapps. Allow authorize.

STEP 5 : Set a VirtualHost with phpMyAdmin

1. Run WAMP/MAMP/XAMPP depending on your OS.
2. On the taskbar, left click on the icon and set a virtual host (VirtualHosts > Manage Virtual Hosts)

```
name of the virtualHost : choiblog
path of the virtualHost : c:/wamp64/www/oop_project_php_mysql/public
```

NB : choiblog must be the name of the virtualHost.

## Built With

* [Bootstrap](https://getbootstrap.com/)
* [Twig](https://twig.symfony.com/) - Dependency Management
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
