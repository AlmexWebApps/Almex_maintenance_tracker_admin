.PHONY: help dev prod stop clean logs shell artisan composer npm test

help: ## Mostrar ayuda
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

dev: ## Iniciar entorno de desarrollo
	@bash scripts/dev.sh

prod: ## Desplegar en producción
	@bash scripts/prod.sh

stop: ## Detener contenedores
	docker-compose down

clean: ## Limpiar contenedores y volúmenes
	docker-compose down -v
	docker system prune -f

logs: ## Ver logs
	docker-compose logs -f

shell: ## Acceder al contenedor app
	docker-compose exec app sh

artisan: ## Ejecutar comando artisan (uso: make artisan cmd="migrate")
	docker-compose exec app php artisan $(cmd)

composer: ## Ejecutar comando composer (uso: make composer cmd="require package")
	docker-compose exec app composer $(cmd)

npm: ## Ejecutar comando npm (uso: make npm cmd="install")
	docker-compose exec npm npm $(cmd)

test: ## Ejecutar tests
	docker-compose exec app php artisan test

migrate: ## Ejecutar migraciones
	docker-compose exec app php artisan migrate

fresh: ## Reset y migrar base de datos
	docker-compose exec app php artisan migrate:fresh --seed

optimize: ## Optimizar Laravel
	docker-compose exec app php artisan optimize

cache-clear: ## Limpiar cache
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear
