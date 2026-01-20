#!/bin/bash

echo "========================================="
echo "Setup Staging Environment"
echo "========================================="

# 0. Fix permissions and git ownership
echo "� Fixing permissions..."
git config --global --add safe.directory $(pwd)
mkdir -p vendor storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R 1000:1000 vendor storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 1. Start shared services first
echo "📦 Starting shared services (DB & Redis)..."
docker compose -f docker-compose.staging.yml up -d db redis

# Wait for services
echo "⏳ Waiting for services to start..."
sleep 10

# 2. Build app image
echo "🔨 Building app image..."
docker compose -f docker-compose.staging.yml build app-staging

# 3. Install composer dependencies
echo "📥 Installing composer dependencies..."
docker compose -f docker-compose.staging.yml run --rm app-staging composer install --no-dev --optimize-autoloader

# 4. Copy environment file if not exists
if [ ! -f .env.staging ]; then
    echo "📝 Creating .env.staging from example..."
    cp .env.staging.example .env.staging
    echo "⚠️  Please edit .env.staging with your configuration!"
    read -p "Press enter to continue after editing .env.staging..."
fi

# 5. Generate app key
echo "🔑 Generating application key..."
docker compose -f docker-compose.staging.yml run --rm app-staging php artisan key:generate --env=staging

# 6. Create database
echo "🗄️  Creating staging database..."
docker exec laravel_db_shared mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS laravel_staging;" 2>/dev/null || echo "Database might already exist"

# 7. Run migrations
echo "📊 Running migrations..."
docker compose -f docker-compose.staging.yml run --rm app-staging php artisan migrate --env=staging --force

# 8. Start all services
echo "🚀 Starting all staging services..."
docker compose -f docker-compose.staging.yml up -d

# 9. Optimize
echo "⚡ Optimizing application..."
docker compose -f docker-compose.staging.yml exec -T app-staging php artisan optimize

echo ""
echo "========================================="
echo "✅ Staging Setup Complete!"
echo "========================================="
echo ""
echo "Access staging at: http://localhost:8001"
echo ""
echo "Useful commands:"
echo "  View logs: docker compose -f docker-compose.staging.yml logs -f"
echo "  View queue: docker compose -f docker-compose.staging.yml logs queue-staging -f"
echo "  Restart: docker compose -f docker-compose.staging.yml restart"
echo ""
