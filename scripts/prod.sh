#!/bin/bash

# Colores
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}🚀 Desplegando en producción...${NC}"

# Verificar archivo de producción
if [ ! -f .env.production ]; then
    echo -e "${RED}❌ .env.production no encontrado${NC}"
    exit 1
fi

# Construir imagen de producción
docker-compose -f docker-compose.prod.yml build --no-cache

# Levantar servicios
docker-compose -f docker-compose.prod.yml up -d

# Ejecutar migraciones
echo -e "${GREEN}🗄️  Ejecutando migraciones...${NC}"
docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force

echo -e "${GREEN}✅ Producción desplegada!${NC}"
