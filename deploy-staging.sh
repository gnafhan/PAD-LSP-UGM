#!/bin/bash

echo "========================================="
echo "Deploying to STAGING"
echo "========================================="

# Pull latest code
echo "📥 Pulling latest code from staging branch..."
git pull origin staging

# Build containers
echo "🔨 Building containers..."
docker-compose -f docker-compose.staging.yml build

# Stop services
echo "🛑 Stopping services..."
docker-compose -f docker-compose.staging.yml down

# Start services
echo "🚀 Starting services..."
docker-compose -f docker-compose.staging.yml up -d

# Wait for services to be ready
echo "⏳ Waiting for services to start..."
sleep 10

# Run migrations
echo "📊 Running migrations..."
docker-compose -f docker-compose.staging.yml exec -T app-staging php artisan migrate --force

# Clear and optimize cache
echo "🧹 Clearing cache..."
docker-compose -f docker-compose.staging.yml exec -T app-staging php artisan optimize:clear
docker-compose -f docker-compose.staging.yml exec -T app-staging php artisan optimize

# Check status
echo ""
echo "========================================="
echo "✅ Deployment Complete!"
echo "========================================="
echo ""
echo "Container Status:"
docker-compose -f docker-compose.staging.yml ps
echo ""
echo "Access staging at: http://localhost:8001"
echo ""
echo "View logs: docker-compose -f docker-compose.staging.yml logs -f"
