<?php

declare(strict_types=1);

namespace App\Models;

use core\database\Model;
use DateTimeImmutable;

class Task extends Model
{
    private string $title;
    private ?string $description = null;
    private TaskStatus $status;
    private ?DateTimeImmutable $due_date = null;

    public function __construct(string $title, TaskStatus $status = TaskStatus::Pending)
    {
        $this->title  = $title;
        $this->status = $status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getDueDate(): ?DateTimeImmutable
    {
        return $this->due_date;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setStatus(TaskStatus $status): void
    {
        $this->status = $status;
    }

    public function setDueDate(?DateTimeImmutable $dueDate): void
    {
        $this->due_date = $dueDate;
    }
}
