# 1. Verificar que Docker esté corriendo
docker --version
docker-compose --version

# 2. Limpiar cualquier build anterior
docker-compose down -v
docker system prune -a --volumes

# 3. Construir las imágenes
docker-compose build --no-cache

# 4. Levantar los servicios
docker-compose up -d

# 5. Ver los logs en tiempo real
docker-compose logs -f

# 6. Verificar que los contenedores estén corriendo
docker-compose ps

# 7. Verificar la salud de la base de datos
docker-compose exec db mysql -u root -p${DB_ROOT_PASSWORD} -e "SHOW DATABASES;"

# 8. Verificar que Laravel esté funcionando
curl http://localhost:8000

# 9. Ejecutar comandos dentro del contenedor
docker-compose exec app php artisan --version
docker-compose exec app php artisan migrate:status
docker-compose exec app php artisan queue:work --once

# 10. Verificar los logs de Laravel
docker-compose exec app tail -f storage/logs/laravel.log
