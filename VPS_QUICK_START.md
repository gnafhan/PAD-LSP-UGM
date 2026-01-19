# VPS Quick Start Guide

Panduan cepat untuk setup aplikasi LSP UGM di VPS dengan staging dan production environment.

## 📋 Prerequisites

- VPS dengan minimal 4GB RAM
- Ubuntu 20.04 atau 22.04
- Domain sudah pointing ke VPS IP
- SSH access ke VPS

## 🚀 Step-by-Step Setup

### 1. Login ke VPS

```bash
ssh root@your-vps-ip
```

### 2. Install Docker

```bash
# Update system
apt update && apt upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# Install Docker Compose
apt install docker-compose -y

# Verify installation
docker --version
docker-compose --version
```

### 3. Create User (Optional but Recommended)

```bash
# Create user
adduser lspugm

# Add to docker group
usermod -aG docker lspugm

# Add to sudo group
usermod -aG sudo lspugm

# Switch to user
su - lspugm
```

### 4. Clone Repository

```bash
# Create directory
mkdir -p /var/www
cd /var/www

# Clone repository
git clone <your-repository-url> lsp-ugm
cd lsp-ugm
```

### 5. Setup Environment Files

```bash
# Copy staging environment
cp .env.staging.example .env.staging

# Copy production environment
cp .env.production.example .env.production

# Edit staging environment
nano .env.staging
```

**Important settings in .env.staging:**
```env
APP_NAME="LSP UGM - Staging"
APP_ENV=staging
APP_DEBUG=true
APP_URL=http://staging.lsp-ugm.ac.id

DB_HOST=laravel_db_shared
DB_DATABASE=laravel_staging

REDIS_HOST=laravel_redis_shared
REDIS_DB=1
REDIS_CACHE_DB=2

# Configure your mail settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

```bash
# Edit production environment
nano .env.production
```

**Important settings in .env.production:**
```env
APP_NAME="LSP UGM"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://lsp-ugm.ac.id

DB_HOST=laravel_db_shared
DB_DATABASE=laravel_production

REDIS_HOST=laravel_redis_shared
REDIS_DB=3
REDIS_CACHE_DB=4

# Configure your mail settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

### 6. Generate App Keys

```bash
# Generate key for staging
docker-compose -f docker-compose.staging.yml run --rm app-staging php artisan key:generate

# Generate key for production
docker-compose -f docker-compose.prod.yml run --rm app-prod php artisan key:generate
```

### 7. Start Shared Services (DB & Redis)

```bash
# Start DB and Redis
docker-compose -f docker-compose.staging.yml up -d db redis

# Wait for services to start
sleep 10

# Verify services are running
docker ps
```

### 8. Create Databases

```bash
# Create staging database
docker exec laravel_db_shared mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS laravel_staging;"

# Create production database
docker exec laravel_db_shared mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS laravel_production;"

# Verify databases
docker exec laravel_db_shared mysql -uroot -proot -e "SHOW DATABASES;"
```

### 9. Deploy Staging

```bash
# Make deploy script executable
chmod +x deploy-staging.sh

# Deploy staging
./deploy-staging.sh
```

Atau manual:

```bash
# Start staging services
docker-compose -f docker-compose.staging.yml up -d

# Run migrations
docker-compose -f docker-compose.staging.yml exec app-staging php artisan migrate --force

# Seed data (optional)
docker-compose -f docker-compose.staging.yml exec app-staging php artisan db:seed --force

# Optimize
docker-compose -f docker-compose.staging.yml exec app-staging php artisan optimize
```

### 10. Deploy Production

```bash
# Make deploy script executable
chmod +x deploy-production.sh

# Deploy production
./deploy-production.sh
```

Atau manual:

```bash
# Start production services
docker-compose -f docker-compose.prod.yml up -d

# Run migrations
docker-compose -f docker-compose.prod.yml exec app-prod php artisan migrate --force

# Seed data (optional)
docker-compose -f docker-compose.prod.yml exec app-prod php artisan db:seed --force

# Optimize
docker-compose -f docker-compose.prod.yml exec app-prod php artisan optimize
```

### 11. Verify Deployment

```bash
# Check all containers
docker ps

# Check staging
curl http://localhost:8001

# Check production
curl http://localhost:8002

# Check queue workers
docker-compose -f docker-compose.staging.yml logs queue-staging
docker-compose -f docker-compose.prod.yml logs queue-prod
```

### 12. Setup Nginx Reverse Proxy (Optional)

```bash
# Install Nginx
sudo apt install nginx -y

# Create staging config
sudo nano /etc/nginx/sites-available/lsp-staging
```

Paste this:
```nginx
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
```

```bash
# Create production config
sudo nano /etc/nginx/sites-available/lsp-production
```

Paste this:
```nginx
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

```bash
# Enable sites
sudo ln -s /etc/nginx/sites-available/lsp-staging /etc/nginx/sites-enabled/
sudo ln -s /etc/nginx/sites-available/lsp-production /etc/nginx/sites-enabled/

# Test config
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

### 13. Setup SSL with Let's Encrypt

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Generate SSL for staging
sudo certbot --nginx -d staging.lsp-ugm.ac.id

# Generate SSL for production
sudo certbot --nginx -d lsp-ugm.ac.id -d www.lsp-ugm.ac.id

# Test auto-renewal
sudo certbot renew --dry-run
```

### 14. Setup Firewall

```bash
# Install UFW
sudo apt install ufw -y

# Allow SSH
sudo ufw allow 22/tcp

# Allow HTTP
sudo ufw allow 80/tcp

# Allow HTTPS
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable

# Check status
sudo ufw status
```

### 15. Setup Automated Backups

```bash
# Make backup script executable
chmod +x backup.sh

# Test backup
./backup.sh

# Setup cron job
crontab -e
```

Add this line:
```
0 2 * * * cd /var/www/lsp-ugm && ./backup.sh >> /var/log/lsp-backup.log 2>&1
```

## ✅ Verification Checklist

- [ ] Docker and Docker Compose installed
- [ ] Repository cloned
- [ ] Environment files configured
- [ ] App keys generated
- [ ] Databases created
- [ ] Staging deployed and accessible
- [ ] Production deployed and accessible
- [ ] Queue workers running
- [ ] Nginx reverse proxy configured (optional)
- [ ] SSL certificates installed (optional)
- [ ] Firewall configured
- [ ] Automated backups configured

## 🔍 Testing

### Test Staging
```bash
# Check status
docker-compose -f docker-compose.staging.yml ps

# Check logs
docker-compose -f docker-compose.staging.yml logs -f

# Test queue
docker-compose -f docker-compose.staging.yml logs queue-staging -f

# Access staging
curl http://staging.lsp-ugm.ac.id
# or
curl http://your-vps-ip:8001
```

### Test Production
```bash
# Check status
docker-compose -f docker-compose.prod.yml ps

# Check logs
docker-compose -f docker-compose.prod.yml logs -f

# Test queue
docker-compose -f docker-compose.prod.yml logs queue-prod -f

# Access production
curl https://lsp-ugm.ac.id
# or
curl http://your-vps-ip:8002
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

# Check DB logs
docker logs laravel_db_shared

# Restart DB
docker restart laravel_db_shared
```

### Permission issues
```bash
# Fix permissions
sudo chown -R 1000:1000 /var/www/lsp-ugm/storage
sudo chown -R 1000:1000 /var/www/lsp-ugm/bootstrap/cache
```

### Queue not processing
```bash
# Check queue worker
docker-compose -f docker-compose.staging.yml logs queue-staging

# Restart queue worker
docker-compose -f docker-compose.staging.yml restart queue-staging
```

## 📚 Next Steps

1. **Monitor logs** regularly
2. **Test all features** in staging before production
3. **Setup monitoring** (optional: Prometheus, Grafana)
4. **Document custom configurations**
5. **Train team** on deployment process

## 📞 Support

For detailed documentation:
- [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) - Complete guide
- [DOCKER_ENVIRONMENTS.md](DOCKER_ENVIRONMENTS.md) - Quick reference
- [DOCKER_SETUP_SUMMARY.md](DOCKER_SETUP_SUMMARY.md) - Setup summary

---

**Quick Access:**
- Staging: http://staging.lsp-ugm.ac.id (or http://your-vps-ip:8001)
- Production: https://lsp-ugm.ac.id (or http://your-vps-ip:8002)
