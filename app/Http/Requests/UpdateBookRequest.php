<?php

namespace App\Http\Requests;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

/**
 * @property string $title
 * @property string $isbn
 * @property Carbon|null $publication_date
 * @property list<Author> $authors
 */
class UpdateBookRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'isbn'        => 'string|unique:books,isbn',
            'publication_date'=> 'date',
            'authors'     => 'required|array|min:1',
            'authors.*'   => 'exists:authors,id',
        ];
    }
}
