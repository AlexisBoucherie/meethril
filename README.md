# MEETHRIL - Symfony 6.2 Role-Playing Game Platform
This is a web application built using Symfony 6.2 framework that allows role-players to organize game sessions. A dungeon master can create and manage a session, and players can join the session.

### Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
PHP 7.4 or higher
Composer
MySQL or MariaDB

### Installing
Clone the repository to your local machine
bash
git clone https://github.com/[your_username]/symfony-rpg-platform.git

### Navigate to the project directory
bash
cd symfony-rpg-platform

### Install the dependencies
Copy code
composer install

### Create a .env file in the root directory
bash
cp .env.example .env

### Fill in the necessary environment variables in the .env file
bash
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

### Create the database schema
python
php bin/console doctrine:schema:create

### Start the built-in web server
python
php bin/console server:start

The application should now be accessible at http://localhost:8000.

### Contributing
Feel free to submit pull requests to contribute to the project.

### License
This project is licensed under the MIT License - see the LICENSE file for details.