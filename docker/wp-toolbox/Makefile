configure:
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

configure_url:
	wp-cli option update siteurl "${WORDPRESS_WEBSITE_URL}"
	wp-cli rewrite structure $(WORDPRESS_WEBSITE_POST_URL_STRUCTURE)
	wp-cli rewrite flush

install_plugins:
	wp-cli plugin install contact-form-7 --activate
	wp-cli plugin install mailchimp-for-wp --activate
	wp-cli plugin install advanced-custom-fields --activate
