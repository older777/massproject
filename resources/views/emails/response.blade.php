<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
<body class="m-auto p-4">
  <h1>Здравствуйте! Вы получили ответ на ваше сообщение</h1>
  <div class="m-6 w-1/2 p-4 bg-gray-300 text-gray-700">{{ $msg }}</div>
  <div class="mt-6">Ответ оператора: {{ $comment }}</div>
</body>
</html>