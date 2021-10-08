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
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

deploy:
	git push heroku

lint:
	composer exec --verbose phpcs -- --standard=PSR12 routes tests app

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 routes
