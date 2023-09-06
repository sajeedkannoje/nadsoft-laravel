# ![Nadsoft  Test](https://lh3.googleusercontent.com/a-/AD_cMMRtvEV3-EQ4thNqC5mM57fi-AEyUsy-OOQhCWehkwj2G4Q=s64-p-k-rw-no)

# Getting started
    Developed by Sajeed Kannoje
## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


Clone the repository

    git clone git@github.com:sajeedkannoje/nadsoft-laravel.git

Switch to the repo folder

    cd nadsoft-laravel

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes Members.**

Open the DummyDataSeeder and set the property values as per your requirement

    use Database\Seeders\MemberSeeder.php

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh