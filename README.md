# Laravel Test


## Introduction

It is your first day at a new job and you have to finish implemenng a web API for a calculator service.
The project contains unit and funconal tests and your goal is to make sure they all pass by wring
missing code.

### Setup
composer install

### Tests
./vendor/bin/phpunit

### Requirements
The API must provide endpoints for 5 mathematical operations:
- GET /api/calculator/add?a={a}&b={b} - addition
- GET /api/calculator/sub?a={a}&b={b} - subtraction
- GET /api/calculator/div?a={a}&b={b} - division
- GET /api/calculator/mul?a={a}&b={b} - multiplication
- GET /api/calculator/mod?a={a}&b={b} - modulo

Access to each endpoint requires authencaon via an API token.

Access to the mod acon requires a premium account.
Both ( a & b ) query parameters are required and must be integers.
In addion, mod & div acons must ensure that the b parameter does not allow a 0 value.
A successful API response should have a 200 HTTP code, be returned in a JSON format, and look as follows:

{"result": 4}

In case of validaon errors, the API should respond with a default error list from the Laravel
framework (and a 422 HTTP code).
The API should be protected with a rate liming mechanism.

### To do
Add missing api_token & is_premium columns via a database migraon.
Configure routes for App\Http\Controllers\CalculatorController .
Implement methods in the App\Calculator class.
Use above listed methods in the controller and implement JSON formaed responses.
Implement validaon rules in the App\Http\Requests\CalculatorRequest class.
Implement logic in the App\Http\Middleware\PremiumAccess classes and secure the mod acon.
Configure the \Illuminate\Routing\Middleware\ThrottleRequests middleware and set the rate
limit to 60 reqs/minute.

Hints
The project is configured to use the SQLite database.
Please do not modify any tests.

You do not have to create any new classes.
Look for comments with // TODO @laravel-test in the code and fix them.


