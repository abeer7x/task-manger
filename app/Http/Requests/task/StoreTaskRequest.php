<?php

namespace App\Http\Requests\task;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidStatus;
class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=> 'required|string|max:20',
            'description'=>'string|nullable',
            'status_name'=>['required', 'string', new ValidStatus(),],
            'priority' => 'sometimes|in:high,medium,low',
          
        ];
    }
    public function messages():array {
        return [
            'title.required'=>'title is required',
            'priority.in' => 'The priority value is invalid. Allowed values are: high, medium, low.',];
        }
}
