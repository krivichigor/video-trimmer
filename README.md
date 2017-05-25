# Video Trimmer API

This is the test api for trimming Video.

## Important

Trimming video process is simulating by sleep function according to the terms of the task

### Documentation for the API

You can it find [here](http://docs.apivideotrimmer.apiary.io)

### Installing

* clone repository, run

```
composer install
```

* copy .env.example to .env file
* install MongoDB on your machine
* if you want to start queus on the background - install BeanstalkD, setup supervisor config, start supervisor, change QUEUE_DRIVER in the .env file

## Running the tests

run next command
```
phpunit
```
Tests are covering all API methods and App Models

