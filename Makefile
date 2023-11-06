flushdb:
	@echo "Flushing and seeding the DB"
	php artisan migrate:fresh --seed

serve:
	@echo "Serving app..."
	php artisan serve
