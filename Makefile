all: install test

install:
	docker run -it --rm -v ${PWD}:/app -w /app composer update --prefer-dist --verbose --no-interaction --optimize-autoloader

phpstan:
	docker run -it --rm -v ${PWD}:/app -w /app php:8.1-cli-alpine php -d error_reporting=-1 -d memory_limit=-1 bin/phpstan --ansi analyse

phpunit:
	docker run -it --rm -v ${PWD}:/app -w /app php:8.1-cli-alpine php bin/phpunit --colors=always -c phpunit.xml

test: phpstan phpunit
