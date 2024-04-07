# Book Store APP

## Setup

Database is already configured on .env for you with sqlite.
Simply run
``composer install && php artisan serve`` so that you can test.

## Resources
We have 3 resource here. You can use ``php artisan route:list`` to see all available endpoints.

* api/store
* api/book
* api/library

## Authentication

We are using Sanctum API tokens to handle authentication.
You can use routes ``/api/login`` to generate a token or ``/api/logout`` to invalidate the current token.

Before using any endpoints of the API, you must use /api/login so that you can generate a valid token to user on subsequent requests. For convenience, the ``/login`` also creates a new user for you, so that you don't need to run a seeder.

## Testing

Yes! We have feature tests that cover all of our endpoints
feel free to run ``php artisan test`` to check them out.
