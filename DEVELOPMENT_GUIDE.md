# 🚀 Laravel LSP UGM - Development Guide

## 📋 Quick Start Commands

### **🟢 Start Development (Mulai Kerja)**

```bash
# 1. Start Docker containers
cd /Users/ghanizulhusnibahri/dev/PAD-LSP-UGM/docker
docker-compose up -d

# 2. Start Vite development server (di terminal baru)
cd /Users/ghanizulhusnibahri/dev/PAD-LSP-UGM
npm run dev
```

### **🔴 Stop Development (Selesai Kerja)**

```bash
# 1. Stop Vite development server (Ctrl+C di terminal npm run dev)

# 2. Stop Docker containers
cd /Users/ghanizulhusnibahri/dev/PAD-LSP-UGM/docker
docker-compose down
```

---

## 🌐 Services & URLs

| Service             | URL                   | Description           |
| ------------------- | --------------------- | --------------------- |
| **Laravel App**     | http://localhost:8000 | Main application      |
| **Vite Dev Server** | http://localhost:5174 | Hot reload for CSS/JS |
| **phpMyAdmin**      | http://localhost:8080 | Database management   |
| **MySQL Database**  | localhost:3306        | Database server       |

---

## 🔧 Useful Commands

### **Start Services Selective**

```bash
# Start hanya Laravel essentials (tanpa phpMyAdmin)
docker-compose up -d app mysql nginx

# Start dengan phpMyAdmin
docker-compose up -d app mysql nginx phpmyadmin

# Tambah phpMyAdmin ke yang sudah running
docker-compose up -d phpmyadmin
```

### **Check Status**

```bash
# Lihat status Docker containers
cd /Users/ghanizulhusnibahri/dev/PAD-LSP-UGM/docker
docker-compose ps

# Lihat logs jika ada masalah
docker-compose logs

# Lihat logs service tertentu
docker-compose logs app
docker-compose logs nginx
docker-compose logs mysql
```

### **Restart Services**

```bash
# Restart semua containers
docker-compose restart

# Restart service tertentu
docker-compose restart mysql
docker-compose restart nginx
docker-compose restart app
```

### **Stop/Start (tanpa remove containers)**

```bash
# Stop semua (tanpa hapus data)
docker-compose stop

# Start yang sudah di-stop
docker-compose start
```

### **Rebuild Container (jika ada perubahan Dockerfile)**

```bash
docker-compose up -d --build
```

---

## 📅 Workflow Development Harian

### **🌅 Pagi (Mulai Kerja)**

1. Buka terminal
2. `cd /Users/ghanizulhusnibahri/dev/PAD-LSP-UGM/docker`
3. `docker-compose up -d`
4. Buka terminal baru
5. `cd /Users/ghanizulhusnibahri/dev/PAD-LSP-UGM`
6. `npm run dev`
7. Buka browser ke http://localhost:8000

### **🌆 Sore (Selesai Kerja)**

1. Stop npm run dev dengan `Ctrl+C`
2. `docker-compose down`
3. Tutup terminal

---

## 🔍 Troubleshooting

### **Aplikasi tidak bisa diakses (404 Error)**

```bash
# Check nginx logs
docker-compose logs nginx

# Restart nginx
docker-compose restart nginx
```

### **Database connection error**

```bash
# Check MySQL logs
docker-compose logs mysql

# Restart MySQL
docker-compose restart mysql

# Check .env file
cat /Users/ghanizulhusnibahri/dev/PAD-LSP-UGM/.env
```

### **Assets tidak ter-compile**

```bash
# Stop npm run dev (Ctrl+C)
# Start lagi
npm run dev

# Atau build untuk production
npm run build
```

### **Composer dependencies error**

```bash
# Install dependencies di container
docker exec laravel-app composer install
```

---

## 📁 Important Files

### **Environment Configuration**

-   `.env` - Database & app configuration
-   `docker/docker-compose.yml` - Docker services
-   `docker/nginx/default.conf` - Nginx routing

### **Frontend Assets**

-   `package.json` - NPM dependencies
-   `vite.config.js` - Vite configuration
-   `tailwind.config.js` - Tailwind CSS
-   `resources/` - Views, CSS, JS source files

### **Backend Code**

-   `app/` - Laravel application code
-   `routes/` - Application routes
-   `database/` - Migrations & seeders

---

## ⚡ Performance Tips

1. **Gunakan `docker-compose up -d`** untuk background mode
2. **Jangan lupa stop containers** saat tidak development
3. **npm run dev** untuk hot reload saat development
4. **npm run build** untuk production assets
5. **Docker volumes** menyimpan data database permanen

---

## 🆘 Emergency Commands

### **Reset Everything (Nuclear Option)**

```bash
# Stop dan hapus semua containers + volumes
docker-compose down -v

# Rebuild dari scratch
docker-compose up -d --build

# Install dependencies lagi
docker exec laravel-app composer install
npm install
```

### **Check Docker Resources**

```bash
# Lihat semua containers
docker ps -a

# Lihat disk usage
docker system df

# Clean unused resources
docker system prune
```

---

## 📝 Development Notes

-   **Database data** tetap persist setelah `docker-compose down`
-   **Node modules** di-share antara host dan container
-   **Hot reload** bekerja untuk CSS/JS changes
-   **PHP changes** langsung ter-reflect tanpa restart
-   **Environment variables** di `.env` file

---

**Happy Coding! 🚀**

_Last updated: July 6, 2025_
