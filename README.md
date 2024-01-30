## МассПроект, тестовое задание (Артур М.)

Инструкция по установке и запуску. Скачать GIT-репозитарий. Создать новый *.env* файл (из *.env.example*)  Выполнить следующие команды:

- composer install
- php artisan vendor:publish
- php artisan sail:publish
- php artisan migrate
- php artisan db:seed AddAdminSeeder # добавить пользователя admin (*test@example.com*, *123*)
- ./sail build --no-cache
- ./sail up
- (в новом окне терминала) ./sail npm run buid (или ./sail npm run dev)


Перейти на страницу [http://0.0.0.0/](http://0.0.0.0/). Создать заявку, заполнив форму. Перейти на страницу авторизации [http://0.0.0.0/login](http://0.0.0.0/login). 
Данные для авторизации, логин и пароль: *test@example.com*, *123*. На странице список заявок, обработать активные заявки.
