# Run these commands after cloning the repository
composer install

npm install

php artisan key:generate


# How to create a database
 first run xammp server. then open a web browser and type 
 #### localhost/phpmyadmin
 then click on new(from left sidebar) and give a name(medicare) and click on create.
 
### now open the .env file

add this line

API_KEY=jVO6EI4kLdaZ6EIXnfJnV54XJaZ6VOT




edit these 3 lines to connect the database with the project:

DB_DATABASE=medicare

DB_USERNAME=root

DB_PASSWORD=
 


# Run migration

goto project directory and run the command as given below

php artisan migrate:fresh
 
