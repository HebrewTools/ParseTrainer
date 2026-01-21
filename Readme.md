# ParseTrainer

A simple app to practice Hebrew verbs.

## Live version

[parse.hebrewtools.org][live]

## Installation instructions for local use

Prerequisites:

- [npm][] (there are different ways to
  [install npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm))
- One of:
  - [Docker][] (recommended)
  - A local PHP and MySQL installation (for production use you also need an
    HTTP server such as Nginx)

### Retrieving code and dependencies

Clone the repository:

    $ git clone https://github.com/HebrewTools/ParseTrainer.git
    $ cd ParseTrainer

Retrieve dependencies:

    $ npm ci

### Building static files

If you are running in a private development environment, build static files
with:

    $ npm run dev

If you are running in a public production environment, build static files with:

    $ npm run prod

This (re)builds CSS and JavaScript files, and copies fonts and audio files from
`./resources`.

When developing, the following command can be used to automatically rebuild
static resources (JS, CSS, etc.) when source files change:

    $ npm run watch

### Configuration

Copy the `.env.example` file in the root directory to `.env`. If you are
running a public instance you should set `APP_ENV` to `production` and
`APP_DEBUG` to `false`.

### Running in Docker (recommended)

Retrieve dependencies:

    $ docker compose run --rm app composer install

Generate a random application key for security purposes:

    $ docker compose run --rm app php artisan key:generate

Initialize the database:

    $ docker compose run --rm app php artisan migrate --seed

Once everything has been set up, only one command is needed to start the
server:

    $ docker compose up -d

To stop the server:

    $ docker compose down

### Running with a local PHP and MySQL installation

Alternatively, you can use a local PHP and MySQL installation.

Create a MySQL database and a user that can connect to it, and fill in the
connection details in `.env`.

Generate a random application key for security purposes:

    $ php artisan key:generate

Initialize the database:

    $ php artisan migrate --seed

You can now test the application with artisan's built-in web server:

    $ php artisan serve

In a production environment you should serve the application using a dedicated
HTTP server such as Nginx. Essentially, you need to enable PHP and redirect
everything to `server.php`. In Nginx this looks like:

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

If serving from a different path, we need to enforce trailing slashes and do
some special things. This configures Nginx to serve the application from
`/ParseTrainer/`:

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

This project uses the [EzraSIL][ezrasil] font which is licensed under the Open
Font License.

[Docker]: https://www.docker.com/
[ezrasil]: http://scripts.sil.org/cms/scripts/page.php?item_id=EzraSIL_Home
[live]: https://parse.hebrewtools.org/
[npm]: https://npmjs.com
