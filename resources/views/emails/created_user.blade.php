<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Norde - Novo Usuário</title>
</head>
<body>
    Olá {{ $user->salute }} {{$user->name}} {{$user->surname}},<br>
    <br>
    Seu usuário foi criado com as seguintes informações de login:<br>
    Usuário: {{ $user->email }}<br>
    Senha temporária: {{ $user->config('temporary_password') }}<br>
    <br>
    Faça o login para alterar sua senha.<br>
    <br>
    Obrigado,<br>
    Equipe Norde
</body>
</html>