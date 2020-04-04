check:	phpunit

run:
	docker-compose run --rm vending_machine bash

copy_vendor:
	sudo docker cp vending_machine:/usr/src/app/vendor ./

phpunit:
	./vendor/bin/phpunit

phpcs:
	./vendor/bin/phpcs --standard=PSR1 ./src
	./vendor/bin/phpcs --standard=PSR2 ./src

phpstan:
	./vendor/bin/phpstan analyse src --level max

php-cs-fixer:
	./vendor/bin/php-cs-fixer fix
