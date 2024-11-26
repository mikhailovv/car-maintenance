.PHONY: up down composer-install create-fixtures

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
	docker-compose exec /var/www/html/bin/console doctrine:fixtures:load