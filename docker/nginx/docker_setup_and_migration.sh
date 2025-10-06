# 1. Copiar variables de entorno
cp .env.example .env

# 2. Generar APP_KEY
php artisan key:generate

# 3. Construir y levantar contenedores
docker-compose up -d --build

# 4. Instalar dependencias (si no están en el build)
docker-compose exec app composer install

# 5. Ejecutar migraciones
docker-compose exec app php artisan migrate
