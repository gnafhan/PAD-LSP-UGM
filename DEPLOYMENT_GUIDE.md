# Deployment Guide - LSP UGM

Panduan lengkap untuk deployment aplikasi LSP UGM ke VPS dengan environment staging dan production yang share database dan Redis.

## Arsitektur

```
┌─────────────────────────────────────────────────────────┐
│                         VPS                              │
│                                                          │
│  ┌──────────────┐              ┌──────────────┐        │
│  │   STAGING    │              │  PRODUCTION  │        │
│  │              │              │              │        │
│  │ Port: 8001   │              │ Port: 8002   │        │
│  │ App + Queue  │              │ App + Queue  │        │
│  └──────┬───────┘              └──────┬───────┘        │
│         │                             │                 │
│         │        ┌────────────────────┤                 │
│         │        │                    │                 │
│         └────────┼────────────────────┘                 │
│                  │                                       │
│         ┌────────▼────────┐    ┌──────────────┐        │
│         │  MySQL (Shared) │    │ Redis (Shared)│        │
│         │                 │    │               │        │
│         │ Port: 3306      │    │ Port: 6379    │        │
│         │                 │    │               │        │
│         │ DB: staging     │    │ DB: 1,2 (stg) │        │
│         │ DB: production  │    │ DB: 3,4 (prod)│        │
│         └─────────────────┘    └───────────────┘        │
└─────────────────────────────────────────────────────────┘
```

## File Structure

```
.
├── docker-compose.yml              # Development
├── docker-compose.staging.yml      # Staging
├── docker-compose.prod.yml         # Production
├── .env                            # Development
├── .env.staging                    # Staging
├── .env.production                 # Production
└── docker/
    └── nginx/
        ├── default.conf            # Development
        ├── staging.conf            # Staging
        └── production.conf         # Production
```

## Setup di VPS

### 1. Persiapan VPS

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose
sudo apt install docker-compose -y

# Add user to docker group
sudo usermod -aG docker $USER
newgrp docker

# Install Git
sudo apt install git -y
```

### 2. Clone Repository

```bash
cd /var/www
git clone <repository-url> lsp-ugm
cd lsp-ugm
```

### 3. Setup Environment Files

```bash
# Copy dan edit .env untuk staging
cp .env.staging.example .env.staging
nano .env.staging

# Copy dan edit .env untuk production
cp .env.production.example .env.production
nano .env.production
```

**Penting:** Pastikan konfigurasi berikut:

**Staging (.env.staging):**
- `DB_DATABASE=laravel_staging`
- `REDIS_DB=1` (untuk queue)
- `REDIS_CACHE_DB=2` (untuk cache)

**Production (.env.production):**
- `DB_DATABASE=laravel_production`
- `REDIS_DB=3` (untuk queue)
- `REDIS_CACHE_DB=4` (untuk cache)

### 4. Generate App Keys

```bash
# Generate key untuk staging
docker-compose -f docker-compose.staging.yml run --rm app-staging php artisan key:generate --env=staging

# Generate key untuk production
docker-compose -f docker-compose.prod.yml run --rm app-prod php artisan key:generate --env=production
```

### 5. Start Services

#### Start Database dan Redis (Shared)

```bash
# Start DB dan Redis dulu
docker-compose -f docker-compose.staging.yml up -d db redis
```

#### Setup Database

```bash
# Create database untuk staging
docker exec laravel_db_shared mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS laravel_staging;"

# Create database untuk production
docker exec laravel_db_shared mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS laravel_production;"
```

#### Start Staging

```bash
# Start staging services
docker-compose -f docker-compose.staging.yml up -d

# Run migrations untuk staging
docker-compose -f docker-compose.staging.yml exec app-staging php artisan migrate --force

# Seed data (optional)
docker-compose -f docker-compose.staging.yml exec app-staging php artisan db:seed --force
```

#### Start Production

```bash
# Start production services
docker-compose -f docker-compose.prod.yml up -d

# Run migrations untuk production
docker-compose -f docker-compose.prod.yml exec app-prod php artisan migrate --force

# Seed data (optional)
docker-compose -f docker-compose.prod.yml exec app-prod php artisan db:seed --force
```

## Port Mapping

- **Staging**: http://your-vps-ip:8001
- **Production**: http://your-vps-ip:8002
- **MySQL**: localhost:3306 (internal)
- **Redis**: localhost:6379 (internal)

## Nginx Reverse Proxy (Recommended)

Untuk production, sebaiknya gunakan Nginx sebagai reverse proxy dengan SSL:

```nginx
# /etc/nginx/sites-available/lsp-staging
server {
    listen 80;
    server_name staging.lsp-ugm.ac.id;
    
    location / {
        proxy_pass http://localhost:8001;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

# /etc/nginx/sites-available/lsp-production
server {
    listen 80;
    server_name lsp-ugm.ac.id www.lsp-ugm.ac.id;
    
    location / {
        proxy_pass http://localhost:8002;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Enable sites:
```bash
sudo ln -s /etc/nginx/sites-available/lsp-staging /etc/nginx/sites-enabled/
sudo ln -s /etc/nginx/sites-available/lsp-production /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## SSL dengan Let's Encrypt

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Generate SSL untuk staging
sudo certbot --nginx -d staging.lsp-ugm.ac.id

# Generate SSL untuk production
sudo certbot --nginx -d lsp-ugm.ac.id -d www.lsp-ugm.ac.id
```

## Management Commands

### Staging

```bash
# View logs
docker-compose -f docker-compose.staging.yml logs -f

# View queue logs
docker-compose -f docker-compose.staging.yml logs queue-staging -f

# Restart services
docker-compose -f docker-compose.staging.yml restart

# Stop services
docker-compose -f docker-compose.staging.yml down

# Run artisan commands
docker-compose -f docker-compose.staging.yml exec app-staging php artisan [command]

# Clear cache
docker-compose -f docker-compose.staging.yml exec app-staging php artisan cache:clear
docker-compose -f docker-compose.staging.yml exec app-staging php artisan config:clear
docker-compose -f docker-compose.staging.yml exec app-staging php artisan view:clear
```

### Production

```bash
# View logs
docker-compose -f docker-compose.prod.yml logs -f

# View queue logs
docker-compose -f docker-compose.prod.yml logs queue-prod -f

# Restart services
docker-compose -f docker-compose.prod.yml restart

# Stop services
docker-compose -f docker-compose.prod.yml down

# Run artisan commands
docker-compose -f docker-compose.prod.yml exec app-prod php artisan [command]

# Clear cache
docker-compose -f docker-compose.prod.yml exec app-prod php artisan cache:clear
docker-compose -f docker-compose.prod.yml exec app-prod php artisan config:clear
docker-compose -f docker-compose.prod.yml exec app-prod php artisan view:clear
```

### Database Management

```bash
# Backup staging database
docker exec laravel_db_shared mysqldump -uroot -proot laravel_staging > backup_staging_$(date +%Y%m%d).sql

# Backup production database
docker exec laravel_db_shared mysqldump -uroot -proot laravel_production > backup_production_$(date +%Y%m%d).sql

# Restore database
docker exec -i laravel_db_shared mysql -uroot -proot laravel_staging < backup_staging_20260117.sql
```

### Redis Management

```bash
# Connect to Redis CLI
docker exec -it laravel_redis_shared redis-cli

# View all keys
docker exec laravel_redis_shared redis-cli KEYS '*'

# Clear staging cache (DB 2)
docker exec laravel_redis_shared redis-cli -n 2 FLUSHDB

# Clear production cache (DB 4)
docker exec laravel_redis_shared redis-cli -n 4 FLUSHDB

# Monitor Redis
docker exec laravel_redis_shared redis-cli MONITOR
```

## Deployment Workflow

### Deploy ke Staging

```bash
cd /var/www/lsp-ugm

# Pull latest code
git pull origin staging

# Rebuild containers (if needed)
docker-compose -f docker-compose.staging.yml build

# Restart services
docker-compose -f docker-compose.staging.yml down
docker-compose -f docker-compose.staging.yml up -d

# Run migrations
docker-compose -f docker-compose.staging.yml exec app-staging php artisan migrate --force

# Clear cache
docker-compose -f docker-compose.staging.yml exec app-staging php artisan optimize:clear
docker-compose -f docker-compose.staging.yml exec app-staging php artisan optimize
```

### Deploy ke Production

```bash
cd /var/www/lsp-ugm

# Pull latest code
git pull origin main

# Rebuild containers (if needed)
docker-compose -f docker-compose.prod.yml build

# Put app in maintenance mode
docker-compose -f docker-compose.prod.yml exec app-prod php artisan down

# Restart services
docker-compose -f docker-compose.prod.yml down
docker-compose -f docker-compose.prod.yml up -d

# Run migrations
docker-compose -f docker-compose.prod.yml exec app-prod php artisan migrate --force

# Clear cache
docker-compose -f docker-compose.prod.yml exec app-prod php artisan optimize:clear
docker-compose -f docker-compose.prod.yml exec app-prod php artisan optimize

# Bring app back up
docker-compose -f docker-compose.prod.yml exec app-prod php artisan up
```

## Monitoring

### Check Container Status

```bash
# All containers
docker ps

# Staging only
docker ps | grep staging

# Production only
docker ps | grep prod
```

### Check Queue Status

```bash
# Staging queue
docker-compose -f docker-compose.staging.yml exec app-staging php artisan queue:work --once

# Production queue
docker-compose -f docker-compose.prod.yml exec app-prod php artisan queue:work --once

# Failed jobs
docker-compose -f docker-compose.staging.yml exec app-staging php artisan queue:failed
docker-compose -f docker-compose.prod.yml exec app-prod php artisan queue:failed
```

### Resource Usage

```bash
# Container stats
docker stats

# Disk usage
docker system df

# Clean up unused resources
docker system prune -a
```

## Troubleshooting

### Container tidak start

```bash
# Check logs
docker-compose -f docker-compose.staging.yml logs

# Check specific service
docker-compose -f docker-compose.staging.yml logs app-staging
```

### Database connection error

```bash
# Check if DB container is running
docker ps | grep db

# Test connection
docker exec laravel_db_shared mysql -uroot -proot -e "SHOW DATABASES;"
```

### Redis connection error

```bash
# Check if Redis container is running
docker ps | grep redis

# Test connection
docker exec laravel_redis_shared redis-cli PING
```

### Queue not processing

```bash
# Check queue worker logs
docker-compose -f docker-compose.staging.yml logs queue-staging

# Restart queue worker
docker-compose -f docker-compose.staging.yml restart queue-staging
```

## Security Checklist

- [ ] Change default MySQL root password
- [ ] Use strong passwords in .env files
- [ ] Enable firewall (ufw)
- [ ] Setup SSL certificates
- [ ] Disable debug mode in production
- [ ] Setup regular backups
- [ ] Monitor logs regularly
- [ ] Keep Docker images updated
- [ ] Restrict database access
- [ ] Use Redis password (optional)

## Backup Strategy

### Automated Daily Backup

Create cron job:

```bash
# Edit crontab
crontab -e

# Add daily backup at 2 AM
0 2 * * * /var/www/lsp-ugm/backup.sh
```

Create backup script:

```bash
#!/bin/bash
# backup.sh

BACKUP_DIR="/var/backups/lsp-ugm"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup staging database
docker exec laravel_db_shared mysqldump -uroot -proot laravel_staging > $BACKUP_DIR/staging_$DATE.sql

# Backup production database
docker exec laravel_db_shared mysqldump -uroot -proot laravel_production > $BACKUP_DIR/production_$DATE.sql

# Compress backups
gzip $BACKUP_DIR/staging_$DATE.sql
gzip $BACKUP_DIR/production_$DATE.sql

# Delete backups older than 30 days
find $BACKUP_DIR -name "*.sql.gz" -mtime +30 -delete

echo "Backup completed: $DATE"
```

Make executable:
```bash
chmod +x /var/www/lsp-ugm/backup.sh
```

## Support

Untuk pertanyaan atau masalah, hubungi tim development.
