# User Management API

Модуль для системы управления пользователями с полной CRUD-функциональностью и аутентификацией.

## 🚀 Основные технологии и подходы

### Архитектура и паттерны
- **DDD (Domain-Driven Design)** - четкое разделение на Domain, Application, Infrastructure слои
- **CQRS** - разделение команд (запись) и запросов (чтение)
- **SOLID** - соблюдение принципов объектно-ориентированного проектирования
- **RESTful API** - стандартизированные эндпоинты и HTTP-методы

### Backend

- **PHP 8.3**
- **Laravel 11/12**
- **MySQL 8.0**
- **Laravel Sanctum** - аутентификация через API tokens
- **Docker, Docker Compose**

### Безопасность
- **Хеширование паролей** - bcrypt для безопасного хранения
- **Валидация данных** - комплексные правила валидации для всех входных данных
- **Rate Limiting** - ограничение запросов для защиты от брутфорса
- **JWT-like токены** - безопасная аутентификация через Sanctum

### Качество кода
- Соблюдение **PSR стандартов**
- **Type Hinting**

## 🛠 Установка и запуск

### Предварительные требования
Так как проект запускается в Docker, то необходимы:
- Docker
- Docker Compose

## Быстрый старт

```shell
# Клонировать репозиторий
git clone <repository-url>
cd <project-directory>

# Запустить в Docker
docker-compose up -d --build

# Процесс настройки приложения (миграции, сиды, запуск сервера и т.д.) можно просмотреть в логах контейнере `app`.
# Приложение будет доступно по http://localhost:8000
# API будет доступно по http://localhost:8000/api
```

## Postman
- Коллекция Postman `postman.json` расположена в директории _public_

## Доступ к БД
- Хост: **localhost**
- Порт: **3306**
- База данных: **user_management_module**
- Пользователь: **laravel**
- Пароль: **Password1234!**

_Настройки задаются в .env.example_

## Полезные команды

```
# Просмотр логов
docker-compose logs -f

# Остановка контейнеров
docker-compose down

# Пересборка
docker-compose up -d --build

# Запуск тестов (пока не добавил)
docker-compose exec app php artisan test

# Composer команды
docker-compose exec app composer install

# Artisan команды
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

## [📚 API Endpoints](Endpoints.md)

## 🧪 Тестирование

### Запуск тестов
```shell
# Все тесты
php artisan test

# Только unit тесты
php artisan test --testsuite=Unit

# Только feature тесты  
php artisan test --testsuite=Feature
```

## ⚙️ Конфигурация

### Основные настройки (.env)
```dotenv
# База данных
DB_HOST=db
DB_DATABASE=user_management_module
DB_USERNAME=laravel
DB_PASSWORD=Password1234!

# API настройки
API_RATE_LIMITING_ENABLED=true
API_DEFAULT_PER_PAGE=15
```
