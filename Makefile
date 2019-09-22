WORDPRESS_TOOLBOX=@docker-compose run --rm toolbox

start:
	docker-compose up -d

stop:
	docker-compose stop

install: start wordpress_configure wordpress_install_plugins

wordpress_configure:
	@echo "➡️ Configuring WordPress..."
	$(WORDPRESS_TOOLBOX) configure
	$(WORDPRESS_TOOLBOX) configure_url
	@echo "✅ WordPress is configured."

wordpress_install_plugins:
	@echo "➡️ Installing and activating plugins..."
	$(WORDPRESS_TOOLBOX) install_plugins
	@echo "✅ WordPress plugins are installed."
