#!/bin/bash

echo "Setting up Laravel Docker environment..."

# Stop any running containers
docker-compose down

# Copy environment file
cp .env.docker .env

# Build and start containers
docker-compose up -d --build

# Wait for database to be ready
echo "Waiting for database to be ready..."
sleep 30

# Generate application key if needed
docker-compose exec app php artisan key:generate --force

# Run migrations
docker-compose exec app php artisan migrate --force

# Clear and cache config
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan config:cache

# Set storage link
docker-compose exec app php artisan storage:link

echo "Setup complete! Your Laravel application is running at http://localhost:8000"