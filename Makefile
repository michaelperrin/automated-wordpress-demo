WORDPRESS_TOOLBOX=@docker-compose run --rm toolbox

start:
	docker-compose up -d

stop:
	docker-compose stop

install: wordpress_configure

wordpress_configure:
	@echo "➡️ Configure Wordpress..."
	$(WORDPRESS_TOOLBOX) configure
	$(WORDPRESS_TOOLBOX) configure_url
	@echo "✅ Wordpress is configured."
