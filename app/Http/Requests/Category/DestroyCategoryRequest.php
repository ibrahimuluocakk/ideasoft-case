<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [];
    }
}
