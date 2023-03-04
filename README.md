Тестовое задание.

Необходимо разработать скандинавский аукцион.

Что нужно сделать:
1) Выбрать и реализовать БД.
2) Выбрать и применить дополнительные технологии (бд, кэши, очереди и тд).
3) Выбрать реализовать/частично реализовать основной функционал, насколько это возможно.

Обязательные требования:
1) Необходимо описать как установить проект на локалке. Лучше использовать Docker.
2) Нужно посчитать количество времени затраченное на решение задачи
3) Основное хранилище - MySQL
4) Основный язык - PHP (с использованием ООП). 

Что вам не нужно делать:
1) Не делать дизайн, просто выполнить саму задачу.
2) Сложные механизмы общения фронта и бэка не использовать, делать через http запрос.
3) Не прорабатывать слишком глубоко - это же все-таки тестовое задание! :) Лучше об этом просто рассказать в ходе технического интервью.
4) Админку/личный кабинет игрока не делать, все данные добавлять напрямую через БД
5) Авторизация не нужна, не нужны также и личные кабинеты и т.д.

### Установка проекта локально на Windows с использованием Docker

1. создаем проект composer create-project --prefer-dist yiisoft/yii2-app-basic basic
2. устанавливаем docker в корне проекта docker-compose run --rm php composer install
3. в файл docker-compose.yml вставляем следующую конфигурацию 
```
version: '3'
services:
  adminer:
    image: adminer
    restart: always
    ports:
      - 8081:8080
  php:
    image: yiisoftware/yii2-php:8.1-apache
    volumes:
      - ~/.composer-docker/cache:/root/.composer/cache:delegated
      - ./:/app:delegated
    ports:
      - '8000:80'
    links:
      - mariadb
  mariadb:
    image: mariadb:10.1
    volumes:
      - mariadb:/var/lib/mysql
    environment:
      TZ: "Europe/Moscow"
      MYSQL_ALLOW_EMPTY_PASSWORD: "no"
      MYSQL_ROOT_PASSWORD: "rootpw"
      MYSQL_USER: 'testuser'
      MYSQL_PASSWORD: 'testpassword'
      MYSQL_DATABASE: 'testdb'
volumes:
  mariadb:
```
4. запускаем контейнеры ```docker-compose up -d```
5. устанавливаем миграции ```docker-compose exec php php yii migrate```
6. запускаем проект http://127.0.0.1:8000/
7. смотрим базу данных http://127.0.0.1:8081/?server=mariadb&username=testuser&db=testdb