WP_CLI=@docker-compose run --rm wp_cli sh -c

wordpress_configure:
	@echo "➡️ Configure Wordpress..."
	$(WP_CLI) 'wp-cli config create \
		--dbhost=$$MYSQL_HOST \
		--dbname=$$MYSQL_DATABASE \
		--dbuser=$$MYSQL_USER \
		--dbpass=$$MYSQL_USER_PASSWORD \
		--locale=$$WORDPRESS_LOCALE \
		--skip-check'
	@echo "✅ Wordpress is configured."
