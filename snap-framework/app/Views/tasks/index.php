<h1>Tasks</h1>
<p><a href="/tasks/create">+ New Task</a></p>

<?php if (empty($tasks)): ?>
<p>No tasks yet. <a href="/tasks/create">Create one</a>.</p>
<?php else: ?>
<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= $task->getId() ?></td>
            <td><a href="/tasks/<?= $task->getId() ?>"><?= htmlspecialchars($task->getTitle()) ?></a></td>
            <td><?= htmlspecialchars($task->getStatus()->label()) ?></td>
            <td><?= $task->getDueDate()?->format('Y-m-d') ?? '—' ?></td>
            <td>
                <a href="/tasks/<?= $task->getId() ?>/edit">Edit</a>
                <form method="post" action="/tasks/<?= $task->getId() ?>/delete">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
