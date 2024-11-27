run: up composer-install create-fixtures information

# Start the Docker Compose stack
up:
	docker-compose up -d

# Stop the Docker Compose stack
down:
	docker-compose down

# Run composer install in the PHP container
composer-install:
	docker-compose exec php composer install

create-fixtures:
	docker-compose exec php /var/www/html/bin/console doctrine:fixtures:load

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