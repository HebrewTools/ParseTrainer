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

Copy the `.env.example` file in the root directory and call it `.env` and customise it.

Install `npm` packages:

    $ npm install

Run the development server:

    $ npm run watch

### Docker Compose

To initialise the database:

    $ docker compose run --rm app bash -c 'composer install && php artisan migrate --seed'

To generate an application key:

    $ docker compose run --rm app php artisan key:generate

Then to run the server:

    $ docker compose up -d

### Local

First, create a MySQL database and a user that can connect to it.

Then run:

    $ php artisan key:generate
    $ php artisan migrate --seed

You can now test the application with artisan's built-in web server:

    $ php artisan serve

Alternatively, you can configure PHP through Nginx.

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

If serving from a different path, we need to enforce trailing slashes and do some special things.
This configures Nginx to handle the trainer from `/ParseTrainer/`:

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
