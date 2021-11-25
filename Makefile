start:
	php artisan serve --host 127.0.0.1

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate --force
	npm install
	npm run prod

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	composer exec --verbose phpunit tests

test-coverage:
	vendor/bin/phpunit --coverage-clover coverage.xml

deploy:
	git push heroku

lint:
	composer phpcs

lint-fix:
	composer phpcbf
