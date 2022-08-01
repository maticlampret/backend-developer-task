# Setup

Provide a file with instructions on how to set up and use the API:
* dependencies
* variables to be set
* run configs
* file system permissions
* ...

### Optional
You can provide Docker and Docker Compose files instead.

### Setup
I used PHP and Laravel for building the API.
Before installing composer you have to have installed PHP. I was using version 7.3.31 but never version should work aswell PHP can be downloaded [here](https://www.php.net/downloads.php "Download PHP"). After installing PHP the next install is [composer](https://getcomposer.org/doc/00-intro.md "Download PHP"). After installing both PHP and composer and cloning the repository, you can go into NotesAPI and run: <br><strong>composer install </strong>

### Variables to be set
After composer installs all dependencies, you can copy the the .env.sample in root directory and rename it to .env. The only thing that needs to be changed here is the connection data for the database. Bellow is an example of the configuration I was using in testing:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=celtra_notes
DB_USERNAME=root
DB_PASSWORD=matic
```
After setting up the database information we can begin to create database structure and import test data. The information for this is located in the database instructions.

### Notes
* Api uses middleware to auth user and request data validation to ensure the sent data is correct for the endpoint that user is calling.
* All of the logic is located in [FoldersController](/NotesAPI/app/Http/Controllers/FoldersController.php) and [NotesController](/NotesAPI/app/Http/Controllers/NotesController.php).
* When user is not authenticated I return the basic laravel unauthorized message, if this was a real project I would write custom messages with just json.
* I  tried to write as many comments in code to explain my thinking 
* I tried writing descriptive messages when error handling so frontend can give the user the correct information about what is wrong.

### Running the app
You can start the app by going to root folder and running:  <strong> php artisan serve </strong>

### API documentation
I tried documenting the API through using postman documenter. The published API documentation can be found [here](https://documenter.getpostman.com/view/22477830/UzdzSQAx "API documentatition"). In the documentation I list some of the possible response for routes but not all, ofcourse there are others that the frontend receives in case there is a problem with the send data or user is not authenticated. This is my first time documentating an API in this way since we usually use Swagger at work, so there are probably some mistake in terms of using the postman tool I just wanted to document a litle bit of the API so whoever uses it doesnt have to go in "completly blind". If you have any question please contact me at matic.lampret@gmail.com.

  
