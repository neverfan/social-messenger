# Social Messenger
Для практики курса Highload Architect

# Запуск демо

Для запуска выполните команду в корне проекта:

```bash
make start
```

# Полезные команды

#### Генерация диалогов и сообщений пользователей

```bash
make seed
```

#### Добавление воркеров

```bash
make scale-5
```

# Описание запросов Postman

Для выполнения запросов в качестве демо для авторизации нужно использовать Bearer token (время действия не ограничено):

```json
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJleHBpcmVzX2luIjoxNzMwNDEzMzkzfQ.M23jNp63D29UkKGH6YBRSdSFMxmnR45OveERXWULxuM
```

#### Коллекция запросов:

 * [postman_collection.json](postman_collection.json)

