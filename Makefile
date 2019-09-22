WORDPRESS_TOOLBOX=@docker-compose run --rm toolbox

start:
	docker-compose up -d

stop:
	docker-compose stop

install: start wordpress_configure wordpress_install_plugins

wordpress_configure:
	@echo "➡️ Configuring WordPress..."
	$(WORDPRESS_TOOLBOX) run_configure
	$(WORDPRESS_TOOLBOX) run_configure_url
	@echo "✅ WordPress is configured."

wordpress_install_plugins:
	@echo "➡️ Installing and activating plugins..."
	$(WORDPRESS_TOOLBOX) run_install_plugins
	@echo "✅ WordPress plugins are installed."

run_configure:
	wp-cli config create \
		--dbhost=${MYSQL_HOST} \
		--dbname=${MYSQL_DATABASE} \
		--dbuser=${MYSQL_USER} \
		--dbpass=${MYSQL_USER_PASSWORD} \
		--locale=${WORDPRESS_LOCALE} \
		--skip-check \
		--force

	wp-cli core install \
		--url=${WORDPRESS_DOMAIN_NAME} \
		--title="$(WORDPRESS_WEBSITE_TITLE)" \
		--admin_user=${WORDPRESS_ADMIN_USER} \
		--admin_password=${WORDPRESS_ADMIN_PASSWORD} \
		--admin_email=${WORDPRESS_ADMIN_EMAIL}

run_configure_url:
	wp-cli option update siteurl "${WORDPRESS_WEBSITE_URL}"
	wp-cli rewrite structure $(WORDPRESS_WEBSITE_POST_URL_STRUCTURE)
	wp-cli rewrite flush

run_install_plugins:
	wp-cli plugin install contact-form-7 --activate
	wp-cli plugin install mailchimp-for-wp --activate
	wp-cli plugin install advanced-custom-fields --activate
