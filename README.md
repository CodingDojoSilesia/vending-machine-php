#Coding Dojo Silesia #3

## Vending machine kata - PHP
Instructions: https://code.joejag.com/coding-dojo/vending-machine/  
Tests: `./vendor/bin/phpunit`

## Setup
Run commands:
* `docker-compose up`

## Run
Open interactive bash `docker-compose run --rm vending_machine bash`

## Development
Copy dependencies form volume: `sudo docker cp vending_machine:/usr/src/app/vendor ./`
