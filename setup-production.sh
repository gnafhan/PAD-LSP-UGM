#!/bin/bash

echo "========================================="
echo "Setup Production Environment"
echo "========================================="
echo ""
read -p "⚠️  Are you sure you want to setup PRODUCTION? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "❌ Setup cancelled"
    exit 1
fi

# 0. Fix permissions and git ownership
echo "🔧 Fixing permissions..."
git config --global --add safe.directory $(pwd)
mkdir -p vendor storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R 1000:1000 vendor storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 1. Start shared services first (if not already running)
echo "📦 Starting shared services (DB & Redis)..."
docker compose -f docker-compose.prod.yml up -d db redis

# Wait for services
echo "⏳ Waiting for services to start..."
sleep 10

# 2. Build app image
echo "🔨 Building app image..."
docker compose -f docker-compose.prod.yml build app-prod

# 3. Install composer dependencies
echo "📥 Installing composer dependencies..."
docker compose -f docker-compose.prod.yml run --rm app-prod composer install --no-dev --optimize-autoloader

# 4. Copy environment file if not exists
if [ ! -f .env.production ]; then
    echo "📝 Creating .env.production from example..."
    cp .env.production.example .env.production
    echo "⚠️  Please edit .env.production with your configuration!"
    read -p "Press enter to continue after editing .env.production..."
fi

# 5. Generate app key
echo "🔑 Generating application key..."
docker compose -f docker-compose.prod.yml run --rm app-prod php artisan key:generate --env=production

# 6. Create database
echo "🗄️  Creating production database..."
docker exec laravel_db_shared mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS laravel_production;" 2>/dev/null || echo "Database might already exist"

# 7. Run migrations
echo "📊 Running migrations..."
docker compose -f docker-compose.prod.yml run --rm app-prod php artisan migrate --env=production --force

# 8. Start all services
echo "🚀 Starting all production services..."
docker compose -f docker-compose.prod.yml up -d

# 9. Optimize
echo "⚡ Optimizing application..."
docker compose -f docker-compose.prod.yml exec -T app-prod php artisan optimize

echo ""
echo "========================================="
echo "✅ Production Setup Complete!"
echo "========================================="
echo ""
echo "Access production at: http://localhost:8002"
echo ""
echo "Useful commands:"
echo "  View logs: docker compose -f docker-compose.prod.yml logs -f"
echo "  View queue: docker compose -f docker-compose.prod.yml logs queue-prod -f"
echo "  Restart: docker compose -f docker-compose.prod.yml restart"
echo ""
