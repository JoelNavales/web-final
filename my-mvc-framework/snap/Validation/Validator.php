<?php

declare(strict_types=1);

namespace snap\Validation;

use DateTimeImmutable;

class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;
            foreach (explode('|', $ruleSet) as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }

        return $this->passes();
    }

    private function applyRule(string $field, mixed $value, string $rule): void
    {
        [$name, $param] = array_pad(explode(':', $rule, 2), 2, null);

        match ($name) {
            'required' => $this->validateRequired($field, $value),
            'max'      => $this->validateMax($field, $value, (int) $param),
            'in'       => $this->validateIn($field, $value, explode(',', (string) $param)),
            'date'     => $this->validateDate($field, $value),
            default    => null,
        };
    }

    private function validateRequired(string $field, mixed $value): void
    {
        if ($value === null || $value === '') {
            $this->errors[$field][] = "The {$field} field is required.";
        }
    }

    private function validateMax(string $field, mixed $value, int $max): void
    {
        if ($value !== null && $value !== '' && strlen((string) $value) > $max) {
            $this->errors[$field][] = "The {$field} may not exceed {$max} characters.";
        }
    }

    private function validateIn(string $field, mixed $value, array $options): void
    {
        if ($value !== null && $value !== '' && ! in_array($value, $options, true)) {
            $this->errors[$field][] = "The {$field} must be one of: " . implode(', ', $options) . '.';
        }
    }

    private function validateDate(string $field, mixed $value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $d = DateTimeImmutable::createFromFormat('Y-m-d', (string) $value);
        if ($d === false || $d->format('Y-m-d') !== $value) {
            $this->errors[$field][] = "The {$field} must be a valid date (YYYY-MM-DD).";
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }
}
