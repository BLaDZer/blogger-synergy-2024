## Blogger - сайт для ведения блогов

## Требования
* Система управления версиями: **GIT** (либо можно **скачать архив**)
* Интерпретатор PHP: `7.2` и выше (тестировалось на `7.2`)
* Менеджер зависимостей PHP: **Composer**
* СУБД: MariaDB `10.1` или MySQL `5.7` и выше (тестировалось на MariaDB `10.1`)
* Интерпретатор JS: **NodeJS** `v20` + **NPM** (**только** если нужна **пересборка** js/css файлов)

## Развертывание
0. если предполагается скачивание репозитория с помощью GIT, то в терминале использовать следующую команду:
```bash
git clone https://github.com/BLaDZer/blogger-synergy-2024.git
cd blogger-synergy-2024/
```
1. в корне проекта скопировать `.env.example` как `.env`. Или можно вызвать следующую команду:
```bash
cp .env.example .env
```
2. в .env настроить доступы к СУБД
3. установить PHP пакеты, для этого необходимо в терминале запустить
```bash
composer install
```
4. далее рекомендуется инициализировать кеш и контейнер фреймворка, для этого необходимо в терминале запустить
```bash
php artisan cache:clear
```
5. запустить миграции, чтобы создались необходимые таблицы в СУБД
```bash
php artisan migrate
```
6. чтобы наши HTTP запросы обрабатывались сервером необходимо в терминале запустить 
```bash
php artisan serve
```
7. открыть в браузере http://127.0.0.1:8000
8. после этого, для наглядного тестирования, рекомендуется зарегистрировать несколько пользователей http://127.0.0.1:8000/register 
