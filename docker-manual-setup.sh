#!/bin/bash

echo "Setting up Laravel Docker environment manually..."

# Stop any running containers
docker-compose down


# Create necessary directories with proper permissions
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Build and start containers
docker-compose up -d --build

# Wait for containers to be ready
echo "Waiting for containers to be ready..."
sleep 20

# Install composer dependencies
echo "Installing composer dependencies..."
docker-compose exec -u root app composer install --no-interaction

# Generate application key
echo "Generating application key..."
docker-compose exec app php artisan key:generate --force

# Wait for database
echo "Waiting for database..."
sleep 10

# Run migrations
echo "Running migrations..."
docker-compose exec app php artisan migrate --force

# Clear and cache config
echo "Clearing and caching config..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan config:cache

# Create storage link
echo "Creating storage link..."
docker-compose exec app php artisan storage:link

# Fix permissions one more time
docker-compose exec -u root app chown -R www-data:www-data /var/www/storage
docker-compose exec -u root app chown -R www-data:www-data /var/www/bootstrap/cache

echo "Setup complete! Your Laravel application is running at http://localhost:8000"
echo "You can check the logs with: docker-compose logs -f"