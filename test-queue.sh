#!/bin/bash

echo "========================================="
echo "Testing Queue System"
echo "========================================="
echo ""

echo "1. Checking queue worker status..."
docker-compose ps queue

echo ""
echo "2. Checking jobs in queue..."
docker-compose exec app php artisan tinker --execute="echo 'Jobs: ' . DB::table('jobs')->count(); echo PHP_EOL;"

echo ""
echo "3. Checking pending participants..."
docker-compose exec app php artisan tinker --execute="echo 'Pending: ' . DB::table('event_participants')->where('invitation_status', 'pending')->count(); echo PHP_EOL;"

echo ""
echo "4. Checking sent participants..."
docker-compose exec app php artisan tinker --execute="echo 'Sent: ' . DB::table('event_participants')->where('invitation_status', 'sent')->count(); echo PHP_EOL;"

echo ""
echo "5. Recent queue worker logs (last 20 lines)..."
docker-compose logs queue --tail=20

echo ""
echo "6. Testing queue worker manually..."
echo "Running: php artisan queue:work --once"
docker-compose exec app php artisan queue:work --once

echo ""
echo "========================================="
echo "Test Complete"
echo "========================================="
