
#!/bin/bash

# Colores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 Iniciando entorno de desarrollo...${NC}"

# Verificar .env
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠️  .env no encontrado, copiando desde .env.example${NC}"
    cp .env.example .env
fi

# Construir y levantar contenedores
docker-compose up -d --build

# Esperar a que MySQL esté listo
echo -e "${GREEN}⏳ Esperando a que MySQL esté listo...${NC}"
docker-compose exec -T mysql sh -c 'while ! mysqladmin ping -h localhost --silent; do sleep 1; done'

# Instalar dependencias
echo -e "${GREEN}📦 Instalando dependencias de Composer...${NC}"
docker-compose exec app composer install

# Generar APP_KEY si no existe
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${GREEN}🔑 Generando APP_KEY...${NC}"
    docker-compose exec app php artisan key:generate
fi

# Ejecutar migraciones
echo -e "${GREEN}🗄️  Ejecutando migraciones...${NC}"
docker-compose exec app php artisan migrate --force

# Dar permisos
echo -e "${GREEN}🔐 Configurando permisos...${NC}"
docker-compose exec app chmod -R 775 storage bootstrap/cache

echo -e "${GREEN}✅ Entorno de desarrollo listo!${NC}"
echo -e "${GREEN}📍 Aplicación: http://localhost:8083${NC}"
echo -e "${GREEN}📍 Vite: http://localhost:5173${NC}"
