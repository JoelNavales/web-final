<h1><?= htmlspecialchars($task->getTitle()) ?></h1>

<dl>
    <dt>Status</dt>
    <dd><?= htmlspecialchars($task->getStatus()->label()) ?></dd>

    <dt>Description</dt>
    <dd><?= nl2br(htmlspecialchars($task->getDescription() ?? '—')) ?></dd>

    <dt>Due Date</dt>
    <dd><?= $task->getDueDate()?->format('Y-m-d') ?? '—' ?></dd>

    <dt>Created</dt>
    <dd><?= $task->getCreatedAt()?->format('Y-m-d H:i:s') ?? '—' ?></dd>

    <dt>Updated</dt>
    <dd><?= $task->getUpdatedAt()?->format('Y-m-d H:i:s') ?? '—' ?></dd>
</dl>

<p>
    <a href="/tasks/<?= $task->getId() ?>/edit">Edit</a>
    &nbsp;
    <form method="post" action="/tasks/<?= $task->getId() ?>/delete">
        <button type="submit">Delete</button>
    </form>
</p>

<p><a href="/tasks">Back to list</a></p>
