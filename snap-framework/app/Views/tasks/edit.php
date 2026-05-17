<h1>Edit Task</h1>

<?php if (! empty($errors)): ?>
<ul>
    <?php foreach ($errors as $fieldErrors): ?>
        <?php foreach ($fieldErrors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<form method="post" action="/tasks/<?= $task->getId() ?>/update">
    <p>
        <label for="title">Title <strong>*</strong></label><br>
        <input type="text" id="title" name="title"
               value="<?= htmlspecialchars($old['title'] ?? $task->getTitle()) ?>" required>
    </p>

    <p>
        <label for="description">Description</label><br>
        <textarea id="description" name="description" rows="4" cols="50"><?= htmlspecialchars($old['description'] ?? $task->getDescription() ?? '') ?></textarea>
    </p>

    <p>
        <label for="status">Status <strong>*</strong></label><br>
        <select id="status" name="status">
            <?php foreach ($statuses as $s): ?>
                <option value="<?= htmlspecialchars($s->value) ?>"
                    <?= ($old['status'] ?? $task->getStatus()->value) === $s->value ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s->label()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="due_date">Due Date</label><br>
        <input type="date" id="due_date" name="due_date"
               value="<?= htmlspecialchars($old['due_date'] ?? $task->getDueDate()?->format('Y-m-d') ?? '') ?>">
    </p>

    <p>
        <button type="submit">Update Task</button>
        <a href="/tasks/<?= $task->getId() ?>">Cancel</a>
    </p>
</form>
