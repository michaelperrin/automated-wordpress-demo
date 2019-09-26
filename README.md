WordPress, the automated way – DEMO
===================================

## Usage

### Prerequesites

The project requires the following tools to be built and run:

* Docker
* Docker Compose

### Define environment variables

Create a .env file at the root of the project with the following configuration:

    MYSQL_ROOT_PASSWORD=my_root_password
    MYSQL_HOST=database
    MYSQL_DATABASE=wordpress
    MYSQL_USER=wordpress
    MYSQL_USER_PASSWORD=wordpress_pwd
    WORDPRESS_DOMAIN_NAME=localhost:8000
    WORDPRESS_WEBSITE_URL=http://localhost:8000
    WORDPRESS_ADMIN_USERNAME=admin
    WORDPRESS_ADMIN_PASSWORD=vancouver2019
    WORDPRESS_ADMIN_EMAIL=test@example.com
    WEBSERVER_PORT=8000

* `MYSQL_ROOT_PASSWORD`: Password for the *root* user in MySQL (no app should connect with it) — recommendation: complex password
* `MYSQL_HOST`: Host of the MySQL database. If using the Docker MySQL instance, set `database` (it is the Docker container name for the database, see *docker-compose.yml* file). If it is hosted on an external server, set the IP or host.
* `MYSQL_DATABASE`: Name of the MySQL database used for WordPress — recommendation: *wordpress*
* `MYSQL_USER`: MySQL username that WordPress will use to connect to the database — recommendation: *wordpress*
* `MYSQL_USER_PASSWORD`: Password for WordPress MySQL user — recommendation: complex password
* `WORDPRESS_DOMAIN_NAME`: Domain name of the Wordpress public address (the one seen from a browser).
* `WORDPRESS_WEBSITE_URL`: Domain name of the Wordpress public address with `http://` or `https://` at the beginning.
* `WORDPRESS_ADMIN_EMAIL`: Email address of the admin user for WordPress admin interface.
* `WORDPRESS_ADMIN_USERNAME`: Username of the admin user for WordPress admin interface (example: *admin*)
* `WORDPRESS_ADMIN_PASSWORD`: Password of the admin user (choose wisely!).
* `WEBSERVER_PORT`: **Port that will be exposed for Nginx** (Example if *8000* is chosen, the website will be locally available at http://localhost:8000).

### Run project

Run installation first:

    make install

Start containers:

    make start

Visit http://localhost:8000

### Run phpMyAdmin

I have added phpMyAdmin for demonstration purpose of Docker Compose.

Access it on http://localhost:8082

### What does it do?

Running the `make install` command will:

* Create Docker containers for WordPress, MySQL and Nginx.
* Initiate the WordPress database.
* Configure WordPress:
    * Database parameters.
    * Default WordPress user.
    * Set language.
    * Set default URL structure.
* Activate the custom `my-simple-theme` theme.
* Install plugins (Contact Form 7 and WP MailChimp as examples).
* Create an "About us" page (which has a specific template in the custom theme).

☑️ The project should be then be up and running.

## Docker configuration

The following containers are created and configured in `docker-compose.yml`:

* *webserver*: A Nginx Docker image.
* *wordpress*: A WordPress Docker image with PHP 7.3.
* *database*: A MySQL Docker image.
* *toolbox*: A toolbox containing WP-CLI and running a Makefile.

The `restart: always` instruction allows containers to get restarted if they stop for any reason
or when the server is restarted.
