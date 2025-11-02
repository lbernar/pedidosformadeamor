#!/bin/bash

echo "🐳 Docker Setup - Laravel E-commerce"
echo "======================================"
echo ""

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

cd /home/lucas-ntt/pedidosformadeamor-laravel

echo -e "${YELLOW}⚠️  This process may take 5-10 minutes the first time.${NC}"
echo ""

echo -e "${BLUE}[1/7] Stopping old containers...${NC}"
docker compose down 2>/dev/null

echo -e "${BLUE}[2/7] Building Docker image...${NC}"
docker compose build

echo -e "${BLUE}[3/7] Starting containers...${NC}"
docker compose up -d

echo -e "${BLUE}[4/7] Waiting for MySQL...${NC}"
sleep 20

echo -e "${BLUE}[5/7] Running migrations...${NC}"
docker compose exec -T app php artisan migrate --force

echo -e "${BLUE}[6/7] Seeding database...${NC}"
docker compose exec -T app php artisan db:seed --force
docker compose exec -T app php artisan db:seed --class=AdminSeeder --force

echo -e "${BLUE}[7/7] Configuring storage...${NC}"
docker compose exec -T app php artisan storage:link
docker compose exec -T app php artisan optimize:clear

echo ""
echo -e "${GREEN}═══════════════════════════════════════${NC}"
echo -e "${GREEN}✅ SETUP COMPLETE!${NC}"
echo -e "${GREEN}═══════════════════════════════════════${NC}"
echo ""
echo "🌐 URLs:"
echo "   Frontend: http://localhost:8000"
echo "   Admin:    http://localhost:8000/admin"
echo ""
echo "🔑 Login Credentials:"
echo ""
echo "   Customer:"
echo "     📧 customer@test.com"
echo "     🔑 password"
echo ""
echo "   Admin:"
echo "     📧 admin@admin.com"
echo "     🔑 password"
echo ""
echo "📦 Useful commands:"
echo "   docker compose logs -f        # View logs"
echo "   docker compose down           # Stop"
echo "   docker compose restart        # Restart"
echo "   docker compose exec app bash  # Enter container"
echo ""
echo "🎉 Access: http://localhost:8000"
