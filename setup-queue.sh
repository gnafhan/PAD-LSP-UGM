#!/bin/bash

# Setup script for email queue enhancement
# This script configures the environment for queue-based email sending

echo "========================================="
echo "Email Queue Enhancement Setup"
echo "========================================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ Error: .env file not found"
    echo "Please copy .env.example to .env first"
    exit 1
fi

echo "✓ .env file found"
echo ""

# Update .env with queue configuration
echo "📝 Updating .env configuration..."

# Check if QUEUE_CONNECTION exists
if grep -q "^QUEUE_CONNECTION=" .env; then
    sed -i.bak 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=redis/' .env
    echo "✓ Updated QUEUE_CONNECTION=redis"
else
    echo "QUEUE_CONNECTION=redis" >> .env
    echo "✓ Added QUEUE_CONNECTION=redis"
fi

# Check if REDIS_HOST exists
if ! grep -q "^REDIS_HOST=" .env; then
    echo "REDIS_HOST=redis" >> .env
    echo "✓ Added REDIS_HOST=redis"
fi

# Check if REDIS_PORT exists
if ! grep -q "^REDIS_PORT=" .env; then
    echo "REDIS_PORT=6379" >> .env
    echo "✓ Added REDIS_PORT=6379"
fi

echo ""
echo "📦 Installing/updating dependencies..."
docker-compose exec app composer install --no-interaction

echo ""
echo "🔄 Restarting Docker containers..."
docker-compose down
docker-compose up -d

echo ""
echo "⏳ Waiting for services to start..."
sleep 5

echo ""
echo "🧪 Testing Redis connection..."
if docker-compose exec redis redis-cli ping | grep -q "PONG"; then
    echo "✓ Redis is running"
else
    echo "❌ Redis connection failed"
    exit 1
fi

echo ""
echo "🔍 Checking queue worker..."
if docker-compose ps queue | grep -q "Up"; then
    echo "✓ Queue worker is running"
else
    echo "❌ Queue worker is not running"
    echo "Try: docker-compose logs queue"
    exit 1
fi

echo ""
echo "========================================="
echo "✅ Setup Complete!"
echo "========================================="
echo ""
echo "Next steps:"
echo "1. Visit: http://localhost:8000/admin/events/{event_id}/participants"
echo "2. Add participants and watch the queue in action"
echo ""
echo "Useful commands:"
echo "  - Monitor queue: docker-compose exec app php artisan queue:monitor"
echo "  - View queue logs: docker-compose logs queue -f"
echo "  - Check failed jobs: docker-compose exec app php artisan queue:failed"
echo "  - Retry failed jobs: docker-compose exec app php artisan queue:retry all"
echo ""
