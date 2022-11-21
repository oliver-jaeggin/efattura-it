# e*Fattura* IT
"e*Fattura* IT" is a litte application for freelancers to create and manage bills. The system allows to generate a PDF for the client and an XML file to submit to the italian government (Agenzia delle entrate).

## Requirements
- Webhosting/locak enviroment to use PHP
- PHP-Version 8.0 or higher
- The application uses a SQLite database which is included

## Installation
1. Clone repository
2. Copy the included SQLite database `/database/database_example.sqlite` to `/database/database.sqlite`
3. Point the your domain into the directory `public`
4. Call the domain in the browser and create a login
5. Fill out your personale information that will be displayed on the invoice and will be used for the XML file

## Database cofiguration
To use another database as SQLite, please follow the [instructions of Laraval](https://laravel.com/docs/9.x/installation#databases-and-migrations) and change the the credentials inside your `.env` file. For this you have to have access to the command line to migrate the database with `php artisan migrate`.

## Questions and bugs
If this application is helpful for you let me know😊. If you find any bug or something that don't work well, create an issue or contact me.