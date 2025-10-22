## 🔐 Аутентификация

### Регистрация пользователя
```http request
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "Password123",
  "password_confirmation": "Password123"
}
```

### Вход в систему
```http request
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "Password123"
}
```

### Выход из системы
```http request
POST /api/logout
Authorization: Bearer {token}
```

## 👥 Управление пользователями

### Получить всех пользователей
```http request
GET /api/users
Authorization: Bearer {token}
Accept-Language: en|ru
```

### Получить пользователей с фильтром
```http request
GET /api/users?name=John
Authorization: Bearer {token}
```

### Создать пользователя
```http request
POST /api/users
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Jane Smith",
  "email": "jane@example.com",
  "password": "SecurePass123"
}
```

### Получить пользователя по ID
```http request
GET /api/users/{id}
Authorization: Bearer {token}
```

### Обновить пользователя
```http request
PUT /api/users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Updated",
  "email": "john.updated@example.com"
}
```

### Удалить пользователя
```http request
DELETE /api/users/{id}
Authorization: Bearer {token}
```
