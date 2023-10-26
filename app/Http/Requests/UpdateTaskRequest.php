<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phase_id' => ['required', 'integer', 'exists:phases,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'priority_id' => ['required', 'exists:priorities,id', 'integer'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'description'=> ['nullable', 'min:5', 'max:500'],
            'attachment_image' => ['nullable']
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'title',
            'phase_id' => 'phase',
            'user_id' => 'assignee',
            'priority_id' => 'priority',
            'attachment_image' => 'attachment'
        ];
    }
}
