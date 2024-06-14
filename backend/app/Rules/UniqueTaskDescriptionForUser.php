<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Task;

class UniqueTaskDescriptionForUser implements ValidationRule
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskExists = Task::where('user_id', $this->userId)
                          ->where('description', $value)
                          ->exists();

        if ($taskExists) {
            $fail('The task description must be unique for each user.');
        }
    }
}
