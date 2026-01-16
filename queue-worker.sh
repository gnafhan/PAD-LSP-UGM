#!/bin/sh

echo "========================================="
echo "Laravel Queue Worker Starting..."
echo "========================================="
echo "Time: $(date)"
echo "Queue: emails,default"
echo "========================================="
echo ""

# Run queue worker
php artisan queue:work --queue=emails,default --sleep=3 --tries=3 --max-time=3600 --verbose
