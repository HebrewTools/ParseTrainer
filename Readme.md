# ParseTrainer

A simple app to practice Hebrew verbs.

## Demo

[parse.hebrewtools.org][demo]

## Installation

    $ git clone https://github.com/HebrewTools/ParseTrainer
    $ cd ParseTrainer
    $ composer install
    $ npm ci
    $ npm run dev

## Configuration

First, create a MySQL database and a user that can connect to it. In this example, we'll use `hebrew_db`, `hebrew_user` and `hebrew_pass`.

Create a `.env` file in the root directory with at least the following options:

    APP_ENV=production
    APP_DEBUG=false
    APP_KEY= # a 32-char random string
    APP_URL=https://demo.camilstaps.nl/HebrewParseTrainer/ # e.g., use your own URL here

    APP_LOCALE=en
    APP_FALLBACK_LOCALE=en

    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=hebrew_db
    DB_USERNAME=hebrew_user
    DB_PASSWORD=hebrew_pass

    CACHE_DRIVER=memchached
    SESSION_DRIVER=memcached
    QUEUE_DRIVER=database

Return to the root directory and run:

    $ php artisan migrate --seed

You can now test the application with artisan's built-in web server:

    $ php artisan serve

Alternatively, read on for the nginx instructions.

### Nginx

You need to enable PHP and redirect everything to `server.php`. Configuration on the root of a site is straightforward:

    server {
        listen [::]:80;
        server_name myhostname;
        root /.../ParseTrainer;
        index index.php index.html index.htm;
        charset utf-8;

        location / {
            autoindex off;
            try_files $uri $uri/ /server.php$is_args$query_string;
        }

        location ~ \.php$ {
            # whatever you do to make PHP work
        }

        location ~ /\. {
            deny all;
        }
    }

In a subdirectory, we need to enforce trailing slashes and do some special things. This configures nginx to handle the trainer from `/ParseTrainer/`:

    server {
        listen [::]:80;
        server_name myhostname;
        root /...;
        index index.php index.html index.htm;
        charset utf-8;

        rewrite ^([^.]*[^/])$ $1/ permanent;

        location ~ ^/ParseTrainer/(.*)\.php$ {
            try_files $uri $uri/ /ParseTrainer/server.php$is_args$query_string;

            # whatever you do to make PHP work
        }

        rewrite /ParseTrainer/?$ /ParseTrainer/public/index.php;
        location /ParseTrainer {
            try_files $uri $uri/ /ParseTrainer/server.php$is_args$query_string;
        }

        location / {
            autoindex off;
        }

        location ~ /\. {
            deny all;
        }
    }

## License

Copyright 2015&ndash;present Camil Staps.
Licensed under GPL v3.0, see the LICENSE file.

This project uses the [EzraSIL][ezrasil] font which is licensed under the Open Font License.

[demo]: https://parse.hebrewtools.org/
[ezrasil]: http://scripts.sil.org/cms/scripts/page.php?item_id=EzraSIL_Home
