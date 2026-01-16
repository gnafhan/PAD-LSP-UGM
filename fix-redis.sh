#!/bin/bash

echo "========================================="
echo "Fixing Redis Extension"
echo "========================================="
echo ""

echo "🛑 Stopping containers..."
docker-compose down

echo ""
echo "🔨 Rebuilding containers with Redis extension..."
docker-compose build --no-cache app queue

echo ""
echo "🚀 Starting containers..."
docker-compose up -d

echo ""
echo "⏳ Waiting for services to start..."
sleep 10

echo ""
echo "🧪 Testing Redis connection..."
if docker-compose exec redis redis-cli ping | grep -q "PONG"; then
    echo "✓ Redis server is running"
else
    echo "❌ Redis connection failed"
    exit 1
fi

echo ""
echo "🔍 Checking Redis PHP extension..."
if docker-compose exec app php -m | grep -q "redis"; then
    echo "✓ Redis PHP extension is installed"
else
    echo "❌ Redis PHP extension not found"
    exit 1
fi

echo ""
echo "🔍 Checking queue worker..."
if docker-compose ps queue | grep -q "Up"; then
    echo "✓ Queue worker is running"
else
    echo "❌ Queue worker is not running"
    docker-compose logs queue
    exit 1
fi

echo ""
echo "========================================="
echo "✅ Redis Fix Complete!"
echo "========================================="
echo ""
echo "You can now:"
echo "1. Visit: http://localhost:8000/admin/events/{event_id}/participants"
echo "2. Try adding participants again"
echo ""
echo "Monitor queue: docker-compose logs queue -f"
echo ""
