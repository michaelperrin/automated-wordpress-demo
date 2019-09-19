WORDPRESS_TOOLBOX=@docker-compose run --rm toolbox

install: wordpress_configure

wordpress_configure:
	@echo "➡️ Configure Wordpress..."
	$(WORDPRESS_TOOLBOX) configure
	$(WORDPRESS_TOOLBOX) configure_url
	@echo "✅ Wordpress is configured."
