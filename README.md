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
