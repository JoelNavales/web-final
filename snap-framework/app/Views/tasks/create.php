<h1>Create Task</h1>

<?php if (! empty($errors)): ?>
<ul>
    <?php foreach ($errors as $fieldErrors): ?>
        <?php foreach ($fieldErrors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<form method="post" action="/tasks">
    <p>
        <label for="title">Title <strong>*</strong></label><br>
        <input type="text" id="title" name="title"
               value="<?= htmlspecialchars($old['title'] ?? '') ?>" required>
    </p>

    <p>
        <label for="description">Description</label><br>
        <textarea id="description" name="description" rows="4" cols="50"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </p>

    <p>
        <label for="status">Status <strong>*</strong></label><br>
        <select id="status" name="status">
            <?php foreach ($statuses as $s): ?>
                <option value="<?= htmlspecialchars($s->value) ?>"
                    <?= ($old['status'] ?? '') === $s->value ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s->label()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="due_date">Due Date</label><br>
        <input type="date" id="due_date" name="due_date"
               value="<?= htmlspecialchars($old['due_date'] ?? '') ?>">
    </p>

    <p>
        <button type="submit">Create Task</button>
        <a href="/tasks">Cancel</a>
    </p>
</form>
