CREATE DATABASE IF NOT EXISTS user_management_module;

CREATE USER IF NOT EXISTS 'laravel'@'%' IDENTIFIED BY 'Password1234!';
GRANT ALL PRIVILEGES ON user_management_module.* TO 'laravel'@'%';
GRANT ALL PRIVILEGES ON `user_management_module`.* TO 'laravel'@'%';
FLUSH PRIVILEGES;