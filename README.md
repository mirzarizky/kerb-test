## Installation

1. Install dependencies
   
    ```sh
    composer install
    ```

2. Copy `.env` variables from `.env.example`
   
   ```sh
   cp .env.example .env
   ```

3. Setup your preferred database in `.env` variable such as:
    - `DB_CONNECTION`
    - `DB_DATABASE`
    - `DB_HOST`
    - `DB_USERNAME`
    - `DB_PASSWORD`

4. Generate application key
   
   ```sh
   php artisan key:generate
   ```

5. Running database migration
   ```sh
   php artisan migrate
   ```

## Dummy

I created dummy database seeder to testing. The seeds contains:

1. 1 Owner who has 3 Bays
2. 2 Users with email `user@email.com` & `user2@email.com`
   
```sh
php artisan db:seed --class=DummySeeder
```

## Testing

```sh
php artisan test
```
## Postman docs
Here is the [link](https://documenter.getpostman.com/view/3440175/UV5ZBbyj) to the api documentation.

**Notes**: make sure to check the environment variable in postman app. Some env variables are:
- `api_url` ex: http://kerb.test/api
- `access_token`
- `booking_id`
