#!/bin/bash

echo "Fixing Laravel Docker permissions..."

# Stop containers
docker-compose down

# Fix local permissions first
sudo chown -R $USER:$USER .
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Start containers
docker-compose up -d

# Wait a bit
sleep 10

# Fix container permissions
docker-compose exec -u root app chown -R www-data:www-data /var/www/storage
docker-compose exec -u root app chown -R www-data:www-data /var/www/bootstrap/cache
docker-compose exec -u root app chmod -R 775 /var/www/storage
docker-compose exec -u root app chmod -R 775 /var/www/bootstrap/cache

echo "Permissions fixed!"