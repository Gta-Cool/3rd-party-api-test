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

The project implements the http_cache proxy from Symfony, I've used it because it works fine for testing purposes and during the development cycle.
In production, a proper reverse proxy must be used like varnish, nginx or squid, in order to improve the performance and the application scalability.
Of course a new TrustedProxy must be configured inside the application.

All caches (guzzle-cache-middleware and http_cache) are using filesystem cache providers, it is an easy solution to implement during development.
In production, proper cache solutions or stores must be used like Redis or Memcached in order to improve scalability and performance, a distributed one could be a plus.
Because project uses PSR6 (caching interface), this is quite easy to change it on the configuration, and to use another adapter instead of FileSystemAdapter one.

For further information, just go to the [api/src/](api/src/) directory to find the source code.

All the source code relating to the Application itself is on the [api/src/App/](api/src/App/) directory, and all the place holder client source code is on the [api/src/PlaceHolder/](api/src/PlaceHolder/) directory.
Of course, all the dependency injection is configured on the Application and you can retrieve it on [api/src/App/app.php](api/src/App/app.php) file, or on the [registers](api/src/App/Register/) or silex providers.

## How it Works

![First client call without any cache](https://www.websequencediagrams.com/cgi-bin/cdraw?lz=dGl0bGUgRmF2b3JpdGUgcG9zdHMgU2VxdWVuY2UKCkNsaWVudC0-UmV2ZXJzZSBQcm94eTogQXNrcyBmb3IgZgAsDQpub3RlIG92ZXIgACIPRG9lc24ndCBoYXZlIGEgcmVzcG9uc2UgaW4gY2FjaGUKAFQNLT4zcmQgUGFydHkgQXBpAFYaABoNLT5QbGFjZSBIb2xkZXIAgRoLaW5mb3JtYXRpb24gbmVlZGVkCgAeDABdETIwMDogSQAqC3JldHVybmVkAIFVCwCBEg8AIgxhcmUAgU8GZCBpbnNpZGUgaHR0cCBjAIJGBQAZKmFnZ3JlZ2F0ZWQAgVcQAIJ-DwCBKgUAgzMPYXJlAIEiFACDOg0KICAgIFJlAIMDBmNvbnRhaW5zAIMJBiBoZWFkZXJzAB4FYW5kIGl0IGkAFQdkADMFQ2FjaGUtQ29udHJvbDoARgVwdWJsaWMsIG1heC1hZ2U9NjAwLCBtdXN0LXJldmFsaWRhdGUKZW5kIG5vdACDYBEAhGMGOiBSAIQRCXMAgm0K&s=modern-blue)

Fig.1: A first client call at beginning without any cache.


![A client call when the reverse proxy cached response is still fresh](https://www.websequencediagrams.com/cgi-bin/cdraw?lz=dGl0bGUgRmF2b3JpdGUgcG9zdHMgU2VxdWVuY2UKCkNsaWVudC0-K1JldmVyc2UgUHJveHk6IEFza3MgZm9yIGYALQ0Kbm90ZSBvdmVyIAAiD1Jlc3BvbnNlIGlzIHN0aWxsIGZyZXNoACYLM3JkIFBhcnR5IEFwaTogUmVxdWVzdCBkb2Vzbid0IHJlYWNoABcOAGMLUGxhY2UgSG9sZGVyOiBObyByADgHdG8ADw0AMgUAgT8NLT4tAIFfBjogQ2FjaGVkAIETBiByAIEmC3JldHVybmVkCg&s=modern-blue)

Fig.2: A client call when the reverse proxy cached response is still fresh.


![A client call when the reverse proxy cached response isn't fresh anymore](https://www.websequencediagrams.com/cgi-bin/cdraw?lz=dGl0bGUgRmF2b3JpdGUgcG9zdHMgU2VxdWVuY2UKCkNsaWVudC0-UmV2ZXJzZSBQcm94eTogQXNrcyBmb3IgZgAsDQpub3RlIG92ZXIgACIPUmVzcG9uc2UgaXNuJ3QgZnJlc2ggYW55bW9yZQoAUA0tPjNyZCBQYXJ0eSBBcGkAUhoAGg0tPlBsYWNlIEhvbGRlcgCBFgtpbmZvcm1hdGlvbiBuZWVkZWQKAB4MAF0RMzA0OiBOb3QgbW9kaWZpZWQAgUkLAIEKD0kAUAthcmUgZ2V0IGZyb20gaHR0cCBjAII1BSBjYWNoZQAaKmFnZ3JlZ2F0ZWQAgVAQAIJzDzIwMDoAgycQYXJlIHJldHVybgCBKg0Agy8NCiAgICBSZQCDBwZjb250YWlucwCBIAYgaGVhZGVycwAeBWFuZCB0aGUgbmV3IHZlcnNpb24gaQAiB2QAQAVDYWNoZS1Db250cm9sOgBTBXB1YmxpYywgbWF4LWFnZT02MDAsIG11c3QtcmV2YWxpZGF0ZQplbmQgbm90AINmEQCEZQYAhB4NAIFECg&s=modern-blue)

Fig.3: A client call when the reverse proxy cached response isn't fresh anymore.


## How to Install

First install composer ([instructions here](https://getcomposer.org/doc/00-intro.md)) if it's not already done.

And then, go on the [api/](api/) directory to run:
```bash
composer install
```
