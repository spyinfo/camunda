<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
<section class="section-register">
    <div class="container">
        <h2 class="text-center">Вход в личный кабинет</h2>

        <div class="row">
            <div class="col-4 offset-4">
                <form action="/login/check" method="POST" class="form form-register text-center">
                    <label class="d-block">
                        <input type="text" class="form-control" id="username" placeholder="Логин" name="username" required>
                    </label>
                    <label class="d-block">
                        <input type="password" class="form-control" id="password" placeholder="Пароль" name="password" required>
                    </label>
                    <div>
                        <?= flash();?>
                    </div>
                    <button class="btn btn-dark" id="submit" type="submit">
                        Войти
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>