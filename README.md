# 3rd-party-api-test

##Technical Test

Implementing and working with internal and external APIs is the core of our projects. The aim of this exercise is to test your problem solving skills and to see the approach that you take when developing greenfield projects.

We will base the exercise on the following 3rd party API:  [https://jsonplaceholder.typicode.com](https://jsonplaceholder.typicode.com).
Bear in mind that we don’t have control over its behaviour.

In this case we want you to build a microservice that reads data from the 3rd party API, manipulates it and returns it to our users.

The requirements are:
- The only endpoint of our microservice will be /favourite_posts
- By default, all requests sent to /favourite_post will display the information of the posts
from the 3rd party API identified by the following IDs: 35, 48, 91, 150.
- The format of the data that our microservice will return needs to be in the following JSON
format:
```json
[
    {
        "post_id": ,
        "title": "",
        "body": "",
        "user": {
            "id": ,
            "name": "",
            "email": ""
        }
    }
]
```

Notes:
- Although we don’t ask you to implement unit tests for this exercise, consider it when
implementing your code.
- Good performance and error handling are key.
- You can use any PHP framework that you want. Please give a brief explanation of the
approach that you’ve taken.
- We’ll give more value to an unfinished application that is well structured than a finished
one with spaghetti code.

## What's Inside

This application uses Silex, a light framework based on symfony components.
I've used it because this micro-service is really light (only get data from a 3rd party API) and in this kind of situation, I like to use light frameworks instead of more complete frameworks like Symfony.

I've also used some community libraries like:
* *guzzlehttp/guzzle* For getting data from place holder API
* *kevinrob/guzzle-cache-middleware* For caching these data and using cache mechanism provided by the API
* *symfony/serializer* For deserializing place holder data or serializing our micro-service data
* *symfony/validator* For validating query parameters

The project implements the http_cache proxy from Symfony, I've used it because it works fine for testing purposes and also because I didn't want to set up a varnish, nginx or squid image.
But in production, I should use one of them, of course, and to configure a new TrustedProxy.

All caches (guzzle-cache-middleware and http_cache) are using filesystem cache provider, here as well because it was an easy solution to implement, but it exists a lot of providers like for Redis or Memcached.
It might be easy to change this on configuration.

For further information, just go to the [api/src/](api/src/) directory to find the source code.

All the source code relating to the Application itself is on the [api/src/App/](api/src/App/) directory, and all the place holder client source code is on the [api/src/PlaceHolder/](api/src/PlaceHolder/) directory.
Of course, all the dependency injection is configured on the Application and you can retrieve it on [api/src/App/app.php](api/src/App/app.php) file, or on the [registers](api/src/App/Register/) or silex providers.

## Install

First install composer ([instructions here](https://getcomposer.org/doc/00-intro.md)) if it's not already done.

And then, go on the [api/](api/) directory to run:
```bash
composer install
```
