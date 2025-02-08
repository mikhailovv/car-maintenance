run: up composer-install create-fixtures create-test-fixtures information

# Start the Docker Compose stack
up:
	docker-compose up -d

# Stop the Docker Compose stack
down:
	docker-compose down

restart:
	 docker compose down && docker compose build && docker compose up -d

# Run composer install in the PHP container
composer-install:
	docker-compose exec php composer install

create-fixtures:
	docker-compose exec php /var/www/html/bin/console doctrine:migration:migrate
	docker-compose exec php /var/www/html/bin/console doctrine:fixtures:load

create-test-fixtures:
	docker-compose exec php /var/www/html/bin/console doctrine:database:drop --force --env=test
	docker-compose exec php /var/www/html/bin/console doctrine:database:create --env=test
	docker-compose exec php /var/www/html/bin/console doctrine:schema:create --env=test
	docker-compose exec php /var/www/html/bin/console doctrine:fixtures:load --env=test

information:
	@echo "#############################################################################"
	@echo "###                                                                       ###"
	@echo "###   Your application available at: http://localhost:8000/api/health     ###"
	@echo "###                                                                       ###"
	@echo "###   Adminer for database available at: http://localhost:8050            ###"
	@echo "###   Engine: PostgreSQL                                                  ###"
	@echo "###   Server: database                                                    ###"
	@echo "###   Username: vm_user                                                   ###"
	@echo "###   Password: vm_password                                               ###"
	@echo "###   Database: vm_dev                                                    ###"
	@echo "###                                                                       ###"
	@echo "#############################################################################"

prune:
	docker system prune