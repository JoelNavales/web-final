<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Repositories\TaskRepositoryInterface;
use core\Http\Request;
use core\Http\Response;
use core\Validation\Validator;
use core\View\Engine;
use DateTimeImmutable;

class TaskController
{
    public function __construct(
        private TaskRepositoryInterface $repository,
        private Engine                  $engine,
    ) {}

    public function index(Request $request): Response
    {
        return Response::view($this->engine->render('tasks/index', [
            'title' => 'All Tasks',
            'tasks' => $this->repository->all(),
        ]));
    }

    public function create(Request $request): Response
    {
        $errors = $_SESSION['errors'] ?? [];
        $old    = $_SESSION['old']    ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        return Response::view($this->engine->render('tasks/create', [
            'title'    => 'New Task',
            'errors'   => $errors,
            'old'      => $old,
            'statuses' => TaskStatus::cases(),
        ]));
    }

    public function store(Request $request): Response
    {
        $data      = $request->body;
        $validator = new Validator();

        $validator->validate($data, [
            'title'       => 'required|max:255',
            'description' => 'max:5000',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'date',
        ]);

        if (! $validator->passes()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old']    = $data;
            return Response::redirect('/tasks/create');
        }

        $task = new Task($data['title'], TaskStatus::from($data['status']));
        $task->setDescription(! empty($data['description']) ? $data['description'] : null);

        if (! empty($data['due_date'])) {
            $parsed = DateTimeImmutable::createFromFormat('Y-m-d', $data['due_date']);
            $task->setDueDate($parsed !== false ? $parsed : null);
        }

        $this->repository->save($task);

        return Response::redirect('/tasks');
    }

    public function show(Request $request): Response
    {
        $task = $this->repository->find((int) $request->params['id']);

        if ($task === null) {
            return Response::view('<h1>404 — Task Not Found</h1>', 404);
        }

        return Response::view($this->engine->render('tasks/show', [
            'title' => $task->getTitle(),
            'task'  => $task,
        ]));
    }

    public function edit(Request $request): Response
    {
        $task = $this->repository->find((int) $request->params['id']);

        if ($task === null) {
            return Response::view('<h1>404 — Task Not Found</h1>', 404);
        }

        $errors = $_SESSION['errors'] ?? [];
        $old    = $_SESSION['old']    ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        return Response::view($this->engine->render('tasks/edit', [
            'title'    => 'Edit Task',
            'task'     => $task,
            'errors'   => $errors,
            'old'      => $old,
            'statuses' => TaskStatus::cases(),
        ]));
    }

    public function update(Request $request): Response
    {
        $task = $this->repository->find((int) $request->params['id']);

        if ($task === null) {
            return Response::view('<h1>404 — Task Not Found</h1>', 404);
        }

        $data      = $request->body;
        $validator = new Validator();

        $validator->validate($data, [
            'title'       => 'required|max:255',
            'description' => 'max:5000',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'date',
        ]);

        if (! $validator->passes()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old']    = $data;
            return Response::redirect("/tasks/{$task->getId()}/edit");
        }

        $task->setTitle($data['title']);
        $task->setDescription(! empty($data['description']) ? $data['description'] : null);
        $task->setStatus(TaskStatus::from($data['status']));

        $dueDate = null;
        if (! empty($data['due_date'])) {
            $parsed  = DateTimeImmutable::createFromFormat('Y-m-d', $data['due_date']);
            $dueDate = $parsed !== false ? $parsed : null;
        }
        $task->setDueDate($dueDate);

        $this->repository->save($task);

        return Response::redirect("/tasks/{$task->getId()}");
    }

    public function destroy(Request $request): Response
    {
        $task = $this->repository->find((int) $request->params['id']);

        if ($task !== null) {
            $this->repository->delete($task);
        }

        return Response::redirect('/tasks');
    }
}
