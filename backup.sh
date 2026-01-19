#!/bin/bash

BACKUP_DIR="./backups"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory
mkdir -p $BACKUP_DIR

echo "========================================="
echo "Database Backup"
echo "========================================="
echo "Date: $DATE"
echo ""

# Backup staging database
echo "📦 Backing up staging database..."
docker exec laravel_db_shared mysqldump -uroot -proot laravel_staging > $BACKUP_DIR/staging_$DATE.sql
if [ $? -eq 0 ]; then
    gzip $BACKUP_DIR/staging_$DATE.sql
    echo "✅ Staging backup: $BACKUP_DIR/staging_$DATE.sql.gz"
else
    echo "❌ Staging backup failed"
fi

# Backup production database
echo "📦 Backing up production database..."
docker exec laravel_db_shared mysqldump -uroot -proot laravel_production > $BACKUP_DIR/production_$DATE.sql
if [ $? -eq 0 ]; then
    gzip $BACKUP_DIR/production_$DATE.sql
    echo "✅ Production backup: $BACKUP_DIR/production_$DATE.sql.gz"
else
    echo "❌ Production backup failed"
fi

# List recent backups
echo ""
echo "Recent backups:"
ls -lh $BACKUP_DIR/*.sql.gz | tail -5

# Delete backups older than 30 days
echo ""
echo "🧹 Cleaning old backups (>30 days)..."
find $BACKUP_DIR -name "*.sql.gz" -mtime +30 -delete

echo ""
echo "========================================="
echo "✅ Backup Complete!"
echo "========================================="
