<?php

declare(strict_types=1);

namespace App\Models;

use App\Repositories\TaskRepository;
use snap\database\Model;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: 'tasks')]
#[ORM\HasLifecycleCallbacks]
class Task extends Model
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', enumType: TaskStatus::class)]
    private TaskStatus $status;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
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
