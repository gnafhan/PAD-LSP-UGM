# PAD-LSP - Laravel Assessment Platform

A comprehensive Laravel-based assessment platform for competency certification and evaluation, built with Laravel 10, Jetstream, and Livewire.

## Features

- **User Management**: Multi-role authentication with Jetstream
- **Assessment System**: Comprehensive competency assessment tools
- **API Integration**: RESTful API with Swagger documentation
- **Real-time Updates**: Livewire components for dynamic interactions
- **Social Authentication**: Google OAuth integration
- **Document Management**: Assessment forms and certification tracking

## Tech Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Livewire 3, Tailwind CSS
- **Database**: MySQL 8.0
- **Cache**: Redis
- **Authentication**: Laravel Jetstream + Fortify
- **API Documentation**: L5-Swagger
- **Containerization**: Docker & Docker Compose

## Quick Start with Docker

### Prerequisites
- Docker and Docker Compose installed
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd pad-lsp
   ```

2. **Quick setup** (recommended)
   ```bash
   ./docker-manual-setup.sh
   ```

3. **Manual setup** (alternative)
   ```bash
   # Copy environment file
   cp .env.docker .env
   
   # Start containers
   docker-compose up -d --build
   
   # Install dependencies
   docker-compose exec -u root app composer install
   
   # Setup Laravel
   docker-compose exec app php artisan key:generate --force
   docker-compose exec app php artisan migrate --force --seed
   docker-compose exec app php artisan config:cache
   ```

### Access the Application

- **Web Application**: http://localhost:8000
- **API Documentation**: http://localhost:8000/api/documentation
- **Database**: localhost:3306 (user: laravel, password: password)
- **Redis**: localhost:6379

## Development

### Available Scripts

```bash
# Fix permissions if needed
./docker-fix-permissions.sh

# View logs
docker-compose logs -f

# Access application container
docker-compose exec app bash

# Run artisan commands
docker-compose exec app php artisan <command>

# Run tests
docker-compose exec app php artisan test
```

### Services

- **app**: PHP 8.2-FPM application container
- **webserver**: Nginx web server
- **db**: MySQL 8.0 database
- **redis**: Redis cache server
- **node**: Node.js for asset compilation

## API

The application provides a comprehensive REST API documented with Swagger. Access the interactive documentation at `/api/documentation` after starting the application.

### Authentication

API endpoints are protected with API key authentication. Include the API key in your requests:

```bash
curl -H "X-API-Key: your-api-key" http://localhost:8000/api/v1/endpoint
```

## Database

The application includes comprehensive seeders for:
- User accounts and roles
- Assessment templates
- Competency frameworks
- Sample data for testing

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## License

This project is licensed under the MIT License.
