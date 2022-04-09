**Subscription Manager**

To run this code, 

1. First clone the project from Github, 
2.then go ahead to install the dependencies by running 

`composer install --ignore-platform-reqs
`
4. Set up your local configuration file by running `cp .env.example .env`
   This would create a .env file at the root of the project with all the sample configurations from the .env.example file
   
3. Next, you need to configure your development environment. Start by adding your database credentials in the .env file.
   the default values you would find there include
       `DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=amat
       DB_USERNAME=root
       DB_PASSWORD=
   `
You should replace these with your own custom values.

4. Setup your queue driver using the database queue driver. You would need to ensure the queue worker is running when running the app by running `php artisan queue:work`
5. A sample postman documentation for the endpoints can be found here https://documenter.getpostman.com/view/15497163/UVyxRZmG
