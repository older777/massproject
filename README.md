## МассПроект, тестовое задание (Артур М.)

Инструкция по установке и запуску. Скачать GIT-репозиторий. Создать новый *.env* файл (из *.env.example*).

Выполнить следующие команды:

    composer install
    php artisan vendor:publish (ресурсы всех вендров: All providers and tags)
    php artisan sail:publish
    php artisan migrate
    php artisan db:seed AddAdminSeeder # добавить пользователя admin (*test@example.com*, *123*)
    ./sail build --no-cache
    ./sail up
    *(в новом окне терминала)* ./sail npm install
    ./sail npm run buid (или ./sail npm run dev)

Устновить актуальное значение MAIL_FROM_ADDRESS.

Перейти на страницу [http://0.0.0.0/](http://0.0.0.0/). Создать заявку, заполнив форму.

Перейти на страницу авторизации [http://0.0.0.0/login](http://0.0.0.0/login). Данные для авторизации, логин и пароль: *test@example.com*, *123*. На странице список заявок  [Dashboard](http://0.0.0.0/dashboard) и обработать, поменять сортировку списка. Проверить почту, возможно сообщение дойдёт.

По вопросам прошу писать на [Телеграм](https://t.me/artip7)
