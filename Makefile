run:
	docker-compose run --rm vending_machine bash

phpunit:
	./vendor/bin/phpunit
