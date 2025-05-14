<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Status;

use Illuminate\Support\Facades\Auth;

class ValidStatus implements Rule
{
    

    protected array $allowed;

    public function __construct()
    {

        $this->allowed = Status::pluck('name')->toArray();
    }

    public function passes($attribute, $value): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return in_array($value, $this->allowed);
        }

        return true;
    }
    public function message(): string
    {
        return 'The current value is invalid. Allowed values ​​are:' . implode(', ', $this->allowed);
    }
}