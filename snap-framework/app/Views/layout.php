<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Task Manager') ?></title>
</head>
<body>
<header>
    <!-- <nav>
        <a href="/">Home</a> |
        <a href="/tasks">Tasks</a> |
        <a href="/tasks/create">New Task</a>
    </nav> -->
    <hr>
</header>
<main>
    <?= $content ?>
</main>
</body>
</html>
