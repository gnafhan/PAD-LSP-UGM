# Environment Comparison

Perbandingan lengkap antara Development, Staging, dan Production environment.

## 📊 Overview Table

| Feature | Development | Staging | Production |
|---------|------------|---------|------------|
| **Purpose** | Local development | Pre-production testing | Live application |
| **Docker Compose** | `docker-compose.yml` | `docker-compose.staging.yml` | `docker-compose.prod.yml` |
| **Environment File** | `.env` | `.env.staging` | `.env.production` |
| **APP_ENV** | `local` | `staging` | `production` |
| **APP_DEBUG** | `true` | `true` | `false` |
| **Port** | 8000 | 8001 | 8002 |
| **Database** | `laravel` (separate) | `laravel_staging` (shared) | `laravel_production` (shared) |
| **Redis DB** | 0 | 1, 2 | 3, 4 |
| **SSL** | No | Optional | Required |
| **Queue Worker** | Yes | Yes | Yes |
| **Node/Vite** | Yes | No | No |

## 🗄️ Database Configuration

### Development
```env
DB_HOST=laravel_db
DB_DATABASE=laravel
```
- Separate MySQL container
- Full control over data
- Can be reset anytime

### Staging
```env
DB_HOST=laravel_db_shared
DB_DATABASE=laravel_staging
```
- Shared MySQL container with production
- Separate database
- Persistent data

### Production
```env
DB_HOST=laravel_db_shared
DB_DATABASE=laravel_production
```
- Shared MySQL container with staging
- Separate database
- Critical data - backup regularly

## 🔴 Redis Configuration

### Development
```env
REDIS_HOST=laravel_redis
REDIS_DB=0
REDIS_CACHE_DB=0
```
- Separate Redis container
- Single database for all

### Staging
```env
REDIS_HOST=laravel_redis_shared
REDIS_DB=1          # Queue
REDIS_CACHE_DB=2    # Cache
```
- Shared Redis container
- Isolated databases

### Production
```env
REDIS_HOST=laravel_redis_shared
REDIS_DB=3          # Queue
REDIS_CACHE_DB=4    # Cache
```
- Shared Redis container
- Isolated databases

## 🐳 Container Names

### Development
- `laravel_app`
- `laravel_queue`
- `laravel_webserver`
- `laravel_db`
- `laravel_redis`
- `laravel_node`

### Staging
- `laravel_app_staging`
- `laravel_queue_staging`
- `laravel_webserver_staging`
- `laravel_db_shared` (shared)
- `laravel_redis_shared` (shared)

### Production
- `laravel_app_prod`
- `laravel_queue_prod`
- `laravel_webserver_prod`
- `laravel_db_shared` (shared)
- `laravel_redis_shared` (shared)

## 🌐 Access URLs

### Development (Local)
```
http://localhost:8000
```

### Staging
```
# Direct access
http://localhost:8001
http://your-vps-ip:8001

# With Nginx reverse proxy
http://staging.lsp-ugm.ac.id
https://staging.lsp-ugm.ac.id (with SSL)
```

### Production
```
# Direct access
http://localhost:8002
http://your-vps-ip:8002

# With Nginx reverse proxy
http://lsp-ugm.ac.id
https://lsp-ugm.ac.id (with SSL)
```

## 📝 Common Commands

### Start Services

**Development:**
```bash
docker-compose up -d
```

**Staging:**
```bash
docker-compose -f docker-compose.staging.yml up -d
```

**Production:**
```bash
docker-compose -f docker-compose.prod.yml up -d
```

### Run Artisan Commands

**Development:**
```bash
docker-compose exec app php artisan [command]
```

**Staging:**
```bash
docker-compose -f docker-compose.staging.yml exec app-staging php artisan [command]
```

**Production:**
```bash
docker-compose -f docker-compose.prod.yml exec app-prod php artisan [command]
```

### View Logs

**Development:**
```bash
docker-compose logs -f
docker-compose logs queue -f
```

**Staging:**
```bash
docker-compose -f docker-compose.staging.yml logs -f
docker-compose -f docker-compose.staging.yml logs queue-staging -f
```

**Production:**
```bash
docker-compose -f docker-compose.prod.yml logs -f
docker-compose -f docker-compose.prod.yml logs queue-prod -f
```

## 🔧 Configuration Differences

### Nginx Configuration

**Development (default.conf):**
```nginx
fastcgi_pass app:9000;
```

**Staging (staging.conf):**
```nginx
fastcgi_pass app-staging:9000;
```

**Production (production.conf):**
```nginx
fastcgi_pass app-prod:9000;
```

### Queue Worker Command

All environments use the same command:
```bash
php artisan queue:work --queue=emails,default --sleep=3 --tries=3 --max-time=3600 --verbose
```

But with different Redis databases based on environment.

## 🔒 Security Differences

### Development
- Debug mode enabled
- Detailed error messages
- No SSL required
- Relaxed security

### Staging
- Debug mode enabled (for testing)
- Detailed error messages
- SSL optional
- Similar to production

### Production
- Debug mode disabled
- Generic error messages
- SSL required
- Strict security
- Regular backups

## 📦 Resource Usage

### Development (Local)
```
Containers: 6
- app
- queue
- webserver
- db
- redis
- node

Estimated RAM: ~2GB
```

### Staging + Production (VPS)
```
Containers: 8
- app-staging
- queue-staging
- webserver-staging
- app-prod
- queue-prod
- webserver-prod
- db (shared)
- redis (shared)

Estimated RAM: ~4GB
```

## 🚀 Deployment Process

### Development
```bash
# No deployment needed
# Just pull and restart
git pull
docker-compose restart
```

### Staging
```bash
# Automated
./deploy-staging.sh

# Or manual
git pull origin staging
docker-compose -f docker-compose.staging.yml build
docker-compose -f docker-compose.staging.yml down
docker-compose -f docker-compose.staging.yml up -d
docker-compose -f docker-compose.staging.yml exec app-staging php artisan migrate --force
docker-compose -f docker-compose.staging.yml exec app-staging php artisan optimize
```

### Production
```bash
# Automated (with confirmation)
./deploy-production.sh

# Or manual
git pull origin main
docker-compose -f docker-compose.prod.yml exec app-prod php artisan down
docker-compose -f docker-compose.prod.yml build
docker-compose -f docker-compose.prod.yml down
docker-compose -f docker-compose.prod.yml up -d
docker-compose -f docker-compose.prod.yml exec app-prod php artisan migrate --force
docker-compose -f docker-compose.prod.yml exec app-prod php artisan optimize
docker-compose -f docker-compose.prod.yml exec app-prod php artisan up
```

## 🎯 Use Cases

### Development
- Feature development
- Bug fixes
- Local testing
- Database experiments
- Quick iterations

### Staging
- Pre-production testing
- QA testing
- Client demos
- Integration testing
- Performance testing

### Production
- Live application
- Real users
- Critical data
- High availability
- Regular backups

## 📊 Monitoring

### Development
- Docker logs
- Laravel log viewer
- Browser console

### Staging
- Docker logs
- Application logs
- Queue monitoring
- Error tracking

### Production
- Docker logs
- Application logs
- Queue monitoring
- Error tracking
- Performance monitoring
- Uptime monitoring
- Resource monitoring

## 🔄 Data Flow

```
Development (Local)
    ↓
    git push to staging branch
    ↓
Staging (VPS)
    ↓
    Testing & QA
    ↓
    git merge to main branch
    ↓
Production (VPS)
```

## 📚 Best Practices

### Development
- Commit frequently
- Test locally before pushing
- Use feature branches
- Keep dependencies updated

### Staging
- Test all features thoroughly
- Verify migrations
- Check queue processing
- Test email sending
- Verify integrations

### Production
- Always test in staging first
- Use maintenance mode during deployment
- Backup before deployment
- Monitor after deployment
- Have rollback plan ready

## 🆘 Emergency Procedures

### Development
```bash
# Reset everything
docker-compose down -v
docker-compose up -d
docker-compose exec app php artisan migrate:fresh --seed
```

### Staging
```bash
# Rollback
git checkout previous-commit
./deploy-staging.sh

# Restore database
docker exec -i laravel_db_shared mysql -uroot -proot laravel_staging < backup_staging.sql
```

### Production
```bash
# Enable maintenance mode
docker-compose -f docker-compose.prod.yml exec app-prod php artisan down

# Rollback
git checkout previous-commit
./deploy-production.sh

# Restore database
docker exec -i laravel_db_shared mysql -uroot -proot laravel_production < backup_production.sql

# Disable maintenance mode
docker-compose -f docker-compose.prod.yml exec app-prod php artisan up
```

---

**Summary:**
- **Development**: Fast iteration, full control, local only
- **Staging**: Pre-production testing, shared resources, VPS
- **Production**: Live application, shared resources, VPS, SSL required
