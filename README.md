templates\mail\resetpassword.html.twig
change
href="choiblog/profil/..."

templates\mail\resetpassword.html.twig
change
href="choiblog/profil/..."

set virtual Host
place the repo inside the www.

https://myaccount.google.com/u/0/lesssecureapps

Some basic Git commands are:
```
git status
git add
git commit
```
[Contribution guidelines for this project](docs/CONTRIBUTING.md)


- George Washington
- John Adams
- Thomas Jefferson

- [x] Finish my changes
- [ ] Push my commits to GitHub
- [ ] Open a pull request
- [ ] \(Optional) Open a followup issue



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

STEP 2 : Set a VirtualHost with phpMyAdmin

1. Run WAMP/MAMP/XAMPP depending on your OS.
2. On the taskbar, left click on the icon and set a virtual host (Vos VirtualHosts > Gestions des Virtuals Hosts)
name of the virtualHost : choiblog
path of the virtualHost : c:/wamp64/www/oop_project_php_mysql/public

NB : choiblog must be the name of the virtualHost.

STEP 3 : Set the Database


```
until finished
```

End with an example of getting some data out of the system or using it for a little demo

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).

## Authors

* **Billie Thompson** - *Initial work* - [PurpleBooth](https://github.com/PurpleBooth)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone whose code was used
* Inspiration
* etc
