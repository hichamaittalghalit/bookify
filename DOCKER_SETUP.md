# Docker Setup for Bookify

This project uses Docker Compose with Nginx and PHP-FPM.

## Prerequisites

- Docker and Docker Compose installed
- Access to edit `/etc/hosts` file (macOS/Linux)

## Setup Instructions

### 1. Add Domain to Hosts File

Add the following line to your `/etc/hosts` file to map `bookify.test` to localhost:

**On macOS/Linux:**
```bash
sudo nano /etc/hosts
```

Add this line:
```
127.0.0.1    bookify.test
```

**On Windows:**
Edit `C:\Windows\System32\drivers\etc\hosts` as Administrator and add:
```
127.0.0.1    bookify.test
```

### 2. Update Environment Variables

Make sure your `.env` file has:
```env
APP_URL=http://bookify.test
DB_HOST=mysql
DB_PORT=3306
```

### 3. Start Docker Containers

```bash
docker-compose up -d
```

### 4. Access the Application

Open your browser and navigate to:
```
http://bookify.test
```

## Services

- **Nginx**: Web server on port 80
- **App**: PHP-FPM application server
- **MySQL**: Database server on port 33060
- **Queue**: Laravel queue worker
- **Scheduler**: Laravel task scheduler

## Useful Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f nginx
docker-compose logs -f app

# Rebuild containers
docker-compose up -d --build

# Access app container shell
docker-compose exec app sh

# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

## Troubleshooting

If you can't access `bookify.test`:
1. Check that the hosts file entry is correct
2. Try `ping bookify.test` - should return 127.0.0.1
3. Check nginx logs: `docker-compose logs nginx`
4. Ensure containers are running: `docker-compose ps`

