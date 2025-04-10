
# Laravel Test Setup Guide

## 1. Environment Configuration
Create or update your `.env.testing` file with these values:
```bash
APP_NAME=Laravel
APP_ENV=testing
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db_test
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

## 2. Generate Application Key
```bash
docker-compose exec app php artisan key:generate --env=testing
```

## 3. Run Tests
```bash
docker-compose exec app php artisan test --env=testing
```

## 4. Frontend Asset Setup
```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```
```

