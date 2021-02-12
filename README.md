
<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# For Sale
User-driven marketplace application for posting and viewing ads in several categories. Users can make deals for selling and buying anything belonging to them.

## Installation

### Step 1

> To run this project, you must have a PHP 7 or higher installed.

Clone this repository and install all Composer dependencies.

```bash
git clone https://github.com/Al-Cross/For-Sale.git
cd for-sale && composer install
mv .env.example .env
php artisan key:generate
```

### Step 2
Create a new database and reference its name and username/password within the project's .env file. In the example below I named the database "for-sale".

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=for-sale
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3
For Sale utilizes Stripe for processing payments. Create a developer account at their website:

https://www.stripe.com

Then reference the provided test API keys in your `.env` file.

```bash
STRIPE_KEY=YOUR_KEY_HERE
STRIPE_SECRET=YOUR_KEY_HERE
```

### Step 4
Optionally, you can set up a Mailtrap account to utilize the application's email features:

https://mailtrap.io/signin

...and enter your credentials in the `.env` file:

```bash
MAIL_USERNAME=YOUR_KEY_HERE
MAIL_PASSWORD=YOUR_KEY_HERE
MAIL_FROM_ADDRESS=admin@forsale.com
```

### Step 5

Run `php artisan install:forsale` to seed the database.

### Ready For Launch
Now you can start the application and take a look at its features. The database is seeded with cities from Germany. To fully test the distance filter in the search bar, enter Frankfurt as city, since there are ads in close range around Frankfurt. The other cities don't have ads from neighbouring locations.

## License

For Sale is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
