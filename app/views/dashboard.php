<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Dashboard</title>
</head>
<body>
<section class="section-register">
    <div class="container">
        <a href="/logout" class="btn btn-dark">Выйти</a>
        <h2 class="text-center">Dashboard</h2>

        <div class="text-center">
            <?php foreach ($processDefinitions as $processDefinition):?>
                <div>
                    Process deployment ID: <?=$processDefinition->getDeploymentId();?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</section>

</body>
</html>