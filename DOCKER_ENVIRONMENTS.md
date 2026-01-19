# Docker Environments - Quick Reference

## 🚀 Quick Start

### Development (Local)
```bash
docker-compose up -d
# Access: http://localhost:8000
```

### Staging
```bash
docker-compose -f docker-compose.staging.yml up -d
# Access: http://localhost:8001
```

### Production
```bash
docker-compose -f docker-compose.prod.yml up -d
# Access: http://localhost:8002
```

## 📋 Environment Files

| Environment | File | Database | Redis DB |
|------------|------|----------|----------|
| Development | `.env` | `laravel` | 0 |
| Staging | `.env.staging` | `laravel_staging` | 1, 2 |
| Production | `.env.production` | `laravel_production` | 3, 4 |

## 🔧 Helper Scripts

### Deploy Staging
```bash
./deploy-staging.sh
```

### Deploy Production
```bash
./deploy-production.sh
```

### Backup Databases
```bash
./backup.sh
```

## 📊 Container Names

| Service | Development | Staging | Production |
|---------|------------|---------|------------|
| App | `laravel_app` | `laravel_app_staging` | `laravel_app_prod` |
| Queue | `laravel_queue` | `laravel_queue_staging` | `laravel_queue_prod` |
| Webserver | `laravel_webserver` | `laravel_webserver_staging` | `laravel_webserver_prod` |
| Database | `laravel_db` | `laravel_db_shared` | `laravel_db_shared` |
| Redis | `laravel_redis` | `laravel_redis_shared` | `laravel_redis_shared` |

## 🌐 Port Mapping

| Service | Development | Staging | Production |
|---------|------------|---------|------------|
| Web | 8000 | 8001 | 8002 |
| MySQL | 3306 | 3306 | 3306 |
| Redis | 6379 | 6379 | 6379 |

## 📝 Common Commands

### View Logs
```bash
# Development
docker-compose logs -f

# Staging
docker-compose -f docker-compose.staging.yml logs -f

# Production
docker-compose -f docker-compose.prod.yml logs -f
```

### Run Artisan Commands
```bash
# Development
docker-compose exec app php artisan [command]

# Staging
docker-compose -f docker-compose.staging.yml exec app-staging php artisan [command]

# Production
docker-compose -f docker-compose.prod.yml exec app-prod php artisan [command]
```

### Clear Cache
```bash
# Development
docker-compose exec app php artisan optimize:clear

# Staging
docker-compose -f docker-compose.staging.yml exec app-staging php artisan optimize:clear

# Production
docker-compose -f docker-compose.prod.yml exec app-prod php artisan optimize:clear
```

### Restart Services
```bash
# Development
docker-compose restart

# Staging
docker-compose -f docker-compose.staging.yml restart

# Production
docker-compose -f docker-compose.prod.yml restart
```

## 🗄️ Database Management

### Access MySQL
```bash
# Development
docker exec -it laravel_db mysql -uroot -proot

# Staging/Production (shared)
docker exec -it laravel_db_shared mysql -uroot -proot
```

### Backup Database
```bash
# Staging
docker exec laravel_db_shared mysqldump -uroot -proot laravel_staging > backup_staging.sql

# Production
docker exec laravel_db_shared mysqldump -uroot -proot laravel_production > backup_production.sql
```

### Restore Database
```bash
# Staging
docker exec -i laravel_db_shared mysql -uroot -proot laravel_staging < backup_staging.sql

# Production
docker exec -i laravel_db_shared mysql -uroot -proot laravel_production < backup_production.sql
```

## 🔴 Redis Management

### Access Redis CLI
```bash
docker exec -it laravel_redis_shared redis-cli
```

### Clear Cache by Environment
```bash
# Staging cache (DB 2)
docker exec laravel_redis_shared redis-cli -n 2 FLUSHDB

# Production cache (DB 4)
docker exec laravel_redis_shared redis-cli -n 4 FLUSHDB
```

## 🔍 Monitoring

### Check Container Status
```bash
docker ps
```

### Check Resource Usage
```bash
docker stats
```

### Check Queue Status
```bash
# Staging
docker-compose -f docker-compose.staging.yml logs queue-staging -f

# Production
docker-compose -f docker-compose.prod.yml logs queue-prod -f
```

## 🛠️ Troubleshooting

### Container won't start
```bash
# Check logs
docker-compose -f docker-compose.staging.yml logs

# Rebuild
docker-compose -f docker-compose.staging.yml build --no-cache
docker-compose -f docker-compose.staging.yml up -d
```

### Database connection error
```bash
# Check if DB is running
docker ps | grep db

# Restart DB
docker restart laravel_db_shared
```

### Queue not processing
```bash
# Check queue worker
docker-compose -f docker-compose.staging.yml logs queue-staging

# Restart queue worker
docker-compose -f docker-compose.staging.yml restart queue-staging
```

## 📚 Full Documentation

For complete deployment guide, see [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)
