#!/bin/bash

echo "========================================="
echo "Switching to Database Queue"
echo "========================================="
echo ""
echo "This is an alternative to Redis queue that doesn't require Redis extension."
echo ""

# Update .env
echo "📝 Updating .env to use database queue..."
if grep -q "^QUEUE_CONNECTION=" .env; then
    sed -i.bak 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=database/' .env
    echo "✓ Updated QUEUE_CONNECTION=database"
else
    echo "QUEUE_CONNECTION=database" >> .env
    echo "✓ Added QUEUE_CONNECTION=database"
fi

echo ""
echo "📦 Creating queue tables..."
docker-compose exec app php artisan queue:table
docker-compose exec app php artisan queue:failed-table
docker-compose exec app php artisan migrate

echo ""
echo "🔄 Restarting containers..."
docker-compose restart app queue

echo ""
echo "⏳ Waiting for services..."
sleep 5

echo ""
echo "🔍 Checking queue worker..."
if docker-compose ps queue | grep -q "Up"; then
    echo "✓ Queue worker is running"
else
    echo "❌ Queue worker is not running"
    docker-compose logs queue
fi

echo ""
echo "========================================="
echo "✅ Database Queue Setup Complete!"
echo "========================================="
echo ""
echo "Queue is now using database instead of Redis."
echo "This works without Redis PHP extension."
echo ""
echo "Test it at: http://localhost:8000/admin/events/{event_id}/participants"
echo ""
echo "Note: Database queue is slightly slower than Redis but works fine for most cases."
echo ""
