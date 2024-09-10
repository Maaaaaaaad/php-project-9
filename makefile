PORT ?= 8000
start:
	PHP_CLI_SERVER_WORKERS=5 php -S 0.0.0.0:$(PORT) -t public
	export DATABASE_URL=postgresql://mad:l5HOcwzap3wrbBZ5NJCZouZRgOiPf6g5@dpg-crg1fi3qf0us73desm50-a:5432/hexlet_bfjd
	psql -a -d $DATABASE_URL -f database.sql

install:
	composer install

update:
	composer update

valid:
	composer validate

dump:
	composer dump-autoload

lint:
	composer exec --verbose phpcs -- --standard=PSR12 --colors public

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 --colors public

test:
	composer exec --verbose phpunit tests