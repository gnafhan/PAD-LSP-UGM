#!/bin/bash

echo "========================================="
echo "Deploying to PRODUCTION"
echo "========================================="
echo ""
read -p "⚠️  Are you sure you want to deploy to PRODUCTION? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "❌ Deployment cancelled"
    exit 1
fi

# Pull latest code
echo "📥 Pulling latest code from main branch..."
git pull origin main

# Build containers
echo "🔨 Building containers..."
docker-compose -f docker-compose.prod.yml build

# Put app in maintenance mode
echo "🔧 Enabling maintenance mode..."
docker-compose -f docker-compose.prod.yml exec -T app-prod php artisan down || true

# Stop services
echo "🛑 Stopping services..."
docker-compose -f docker-compose.prod.yml down

# Start services
echo "🚀 Starting services..."
docker-compose -f docker-compose.prod.yml up -d

# Wait for services to be ready
echo "⏳ Waiting for services to start..."
sleep 10

# Run migrations
echo "📊 Running migrations..."
docker-compose -f docker-compose.prod.yml exec -T app-prod php artisan migrate --force

# Clear and optimize cache
echo "🧹 Clearing cache..."
docker-compose -f docker-compose.prod.yml exec -T app-prod php artisan optimize:clear
docker-compose -f docker-compose.prod.yml exec -T app-prod php artisan optimize

# Disable maintenance mode
echo "✅ Disabling maintenance mode..."
docker-compose -f docker-compose.prod.yml exec -T app-prod php artisan up

# Check status
echo ""
echo "========================================="
echo "✅ Deployment Complete!"
echo "========================================="
echo ""
echo "Container Status:"
docker-compose -f docker-compose.prod.yml ps
echo ""
echo "Access production at: http://localhost:8002"
echo ""
echo "View logs: docker-compose -f docker-compose.prod.yml logs -f"
