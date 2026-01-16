#!/bin/bash

echo "========================================="
echo "Processing Pending Email Jobs"
echo "========================================="
echo ""

echo "Checking jobs in queue..."
JOBS=$(docker-compose exec redis redis-cli LLEN "laravel_database_queues:emails" | tr -d '\r')
echo "Jobs in queue: $JOBS"

if [ "$JOBS" -gt 0 ]; then
    echo ""
    echo "Processing all jobs..."
    docker-compose exec app php artisan queue:work --queue=emails --stop-when-empty
    
    echo ""
    echo "Done! Checking results..."
    docker-compose exec redis redis-cli LLEN "laravel_database_queues:emails"
    
    echo ""
    docker-compose exec app php artisan tinker --execute="
    echo 'Pending: ' . DB::table('event_participants')->where('invitation_status', 'pending')->count() . PHP_EOL;
    echo 'Sent: ' . DB::table('event_participants')->where('invitation_status', 'sent')->count() . PHP_EOL;
    "
else
    echo "No jobs to process!"
fi

echo ""
echo "========================================="
echo "Complete!"
echo "========================================="
